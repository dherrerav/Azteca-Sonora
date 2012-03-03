<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport('joomla.event.plugin');
jimport('joomla.mail.helper');

/**
 * 
 * @version $Revision$
 *
 */

if(!defined( '_VERSION_ONCE' )){

	//ensure its only loaded once
	define( '_VERSION_ONCE',1 );

class TableVersion extends JTable{
	
	/** @var foreign content id key */
	public $content_id = null;
	
	/** @var staging flag */
	public $stage = null;
	
	/** @var autosaved flag */
	public $autosaved = null;
	
	/** @var int Primary key */
	var $id					= null;
	/** @var string */
	var $title				= null;
	/** @var string */
	var $alias				= null;
	/** @var string */
	var $title_alias			= null;
	/** @var string */
	var $introtext			= null;
	/** @var string */
	var $fulltext			= null;
	/** @var int */
	var $state				= null;
	/** @var int The id of the category section*/
	var $sectionid			= null;
	/** @var int DEPRECATED */
	var $mask				= null;
	/** @var int */
	var $catid				= null;
	/** @var datetime */
	var $created				= null;
	/** @var int User id*/
	var $created_by			= null;
	/** @var string An alias for the author*/
	var $created_by_alias		= null;
	/** @var datetime */
	var $modified			= null;
	/** @var int User id*/
	var $modified_by			= null;
	/** @var boolean */
	var $checked_out			= 0;
	/** @var time */
	var $checked_out_time		= 0;
	/** @var datetime */
	var $frontpage_up		= null;
	/** @var datetime */
	var $frontpage_down		= null;
	/** @var datetime */
	var $publish_up			= null;
	/** @var datetime */
	var $publish_down		= null;
	/** @var string */
	var $images				= null;
	/** @var string */
	var $urls				= null;
	/** @var string */
	var $attribs				= null;
	/** @var int */
	var $version				= null;
	/** @var int */
	var $parentid			= null;
	/** @var int */
	var $ordering			= null;
	/** @var string */
	var $metakey				= null;
	/** @var string */
	var $metadesc			= null;
	/** @var string */
	var $metadata			= null;
	/** @var int */
	var $access				= null;
	/** @var int */
	var $hits				= null;
	
	/** @var int Joomfish */
	var $language_id		= null;
	
	var $featured = null;
	
	var $xreference = null;
	var $asset_id = null;
	
	
	function __construct(&$db)
	{
		parent::__construct( '#__version', 'id', $db );
	}

}

class plgContentVersion extends JPlugin
{
	var $params;
	
	function plgContentVersion(&$subject , $config)
	{
		parent::__construct($subject, $config);
		
        $this->_plugin = JPluginHelper::getPlugin( 'Content', 'Version' );
        //$this->params = new JParameter( $config['params'] );	
        
        $this->loadLanguage( );
       
	}
	/* Joomla 1.6 version of the versioning plugin
	 * *
	 *
	 * @param unknown_type $article
	 * @param unknown_type $isNew
	 * @return unknown
	 */
	public function onContentAfterSave($context, &$article, $isNew)
	{
		
		if(strpos($context,"com_content") === false){
			return;	
		}
		
		$mainframe = JFactory::getApplication();
		$admin_notify ="";
		$version_limit = 0;
		
		$db =& JFactory::getDBO();
			
		if(@$this->params){
			$version_limit = (int)$this->params->get('version_limit');
			$admin_notify = trim($this->params->get('admin_notify'));
		}	
		
		//clean out the autosaves!
		if($isNew === false){
			
			 if($article->id > 0){
			 	
			 	$id = (int)$article->id;
			 	
				//delete autosaves
				$sql = "DELETE FROM #__version WHERE content_id = $id AND autosaved=1";
				$db->setQuery($sql);
				$db->Query($sql);
				
			 }
			 
		}elseif($isNew === true){
		 	
		 	if(isset($_SESSION['content_id'])){
		 		
				$content_id  = (int)$_SESSION['content_id'];
				
				if($content_id > 0){
					
					//delete autosaves of new articles
					$sql = "DELETE FROM #__version WHERE content_id = $content_id AND autosaved=1";
					
					$db->setQuery($sql);
					$db->Query($sql);		 			
				}
		 	}	
		 }

		//check the number of versions, and FIFO
		if($version_limit > 0 && $article->id > 0){
			
			$id = (int)$article->id;
			$sql = "SELECT COUNT(id) AS cnt FROM #__version WHERE content_id = $id  AND (autosaved != '1' or autosaved is null)";
			
			$db->setQuery($sql);
			
			$res = $db->loadObject();
			
			//if we're at the version limit
			if($res->cnt > $version_limit){
			
				//if we're over the version limit, we need to delete
				$difference = (int)$res->cnt - $version_limit;
				
				//FIXME: If the version_limit is the same as the number of STAGED versions we will not be able to restore
				$sql = "DELETE FROM #__version WHERE content_id = $id  AND (autosaved != '1' or autosaved is null) ORDER BY id ASC LIMIT $difference";
				
				$db->setQuery($sql);
				$db->Query($sql);
					
			}
			
		}
		
		//get a copy of the version table
		$doc =& JTable::getInstance('version', 'Table');

		//duplicate the article object
		$vars = $article->getProperties();
				
		//copy it to the version object
		if($vars){
			foreach ($vars as $name => $value) {		
				$doc->$name = $article->$name;
			}
		}else{
			foreach ($doc as $name => $value) {		
				$doc->$name = $article->$name;
			}
			
		}

		//store the article id
		$doc->content_id = (int)$doc->id;

		//they're always new
		$doc->id = null;
		
		//does the latest workflow record indicate that this version should be staged?
		$sql = "SELECT stage FROM #__fc_workflow WHERE content_id = " . $doc->content_id . "  order by id desc limit 1";

		$db->setQuery($sql);
		$stage = (int)$db->loadResult();
		
		//set this version as staged
		if($stage > 0){
			$doc->stage = 1;	
		}
		
		$user = JFactory::getUser();
		$doc->checked_out = $user->id;
		
		$doc->checkin();
		//Check if this version is any different	
		if(!$doc->store()){
			JError::raiseError(500, 'Versioning:' . $doc->getError() );
			return false;
		}
		
		//check if the admin notify parameter is set
		if(strlen($admin_notify) > 0){
			
			if(JMailHelper::isEmailAddress($admin_notify) === true){
				
				//load the language .ini file
				$lang =& JFactory::getLanguage();
				$lang->load( 'com_versions', JPATH_ADMINISTRATOR);

				$mailSender =& JFactory::getMailer();
				$mailSender->addRecipient($admin_notify);
				$mailSender->setSubject(JText::_('EMAIL_SUBJECT') . " " . $doc->title);
				
				$modified_by_user 	=& JFactory::getUser((int)@$article->modified_by);
				$created_by_user 	=& JFactory::getUser((int)@$article->created_by);
				
				
				$body = JText::_('EMAIL_BODY') . "<br />" . JText::_('Created by:') . $created_by_user->name . "<br />";
				
				$body .= JText::_('Modified by:') . $modified_by_user->name . "<br />";
				
				$body .= "<br />" . $doc->introtext . $doc->fulltext;
				
				//send the content
				$mailSender->setBody($body);
				$mailSender->IsHTML(true);
				
				//get the from address for SMTP 
				$mail_from   = JApplication::getCfg('mailfrom');
				$from_name   = JApplication::getCfg('fromname');
				
				if(JMailHelper::isEmailAddress($mail_from) === true){
					$from_address =  array( $mail_from, $from_name );
					$mailSender->setSender( $from_address );
				}
				
				if (!$mailSender->Send())
				{
					JError::raiseWarning(500,JText::_('EMAIL_ERROR'));
				}
			}
		}
		   
		return true;
	}


	/**
	 * Versioning after save content method (Joomla 1.5)
	 *
	 *
	 * @param 	object		A JTableContent object
	 * @param 	bool		If the content is just about to be created
	 * @return	bool		If false, abort the save
	 */
	function onAfterContentSave( &$article, $isNew )
	{
		$mainframe = JFactory::getApplication();
		$admin_notify ="";
		$version_limit = 0;
		
		$db =& JFactory::getDBO();
			
		if(@$this->params){
			$version_limit = (int)$this->params->get('version_limit');
			$admin_notify = trim($this->params->get('admin_notify'));
		}	
		
		//clean out the autosaves!
		if($isNew === false){
			
			 if($article->id > 0){
			 	
			 	$id = (int)$article->id;
			 	
				//delete autosaves
				$sql = "DELETE FROM #__version WHERE content_id = $id AND autosaved=1";
				$db->setQuery($sql);
				$db->Query($sql);
				
			 }
			 
		}elseif($isNew === true){
		 	
		 	if(isset($_SESSION['content_id'])){
		 		
				$content_id  = (int)$_SESSION['content_id'];
				
				if($content_id > 0){
					
					//delete autosaves of new articles
					$sql = "DELETE FROM #__version WHERE content_id = $content_id AND autosaved=1";
					
					$db->setQuery($sql);
					$db->Query($sql);		 			
				}
		 	}	
		 }

		//check the number of versions, and FIFO
		if($version_limit > 0 && $article->id > 0){
			
			$id = (int)$article->id;
			$sql = "SELECT COUNT(id) AS cnt FROM #__version WHERE content_id = $id  AND (autosaved != '1' or autosaved is null)";
			
			$db->setQuery($sql);
			
			$res = $db->loadObject();
			
			//if we're at the version limit
			if($res->cnt > $version_limit){
			
				//if we're over the version limit, we need to delete
				$difference = (int)$res->cnt - $version_limit;
				
				//FIXME: If the version_limit is the same as the number of STAGED versions we will not be able to restore
				$sql = "DELETE FROM #__version WHERE content_id = $id  AND (autosaved != '1' or autosaved is null) ORDER BY id ASC LIMIT $difference";
				
				$db->setQuery($sql);
				$db->Query($sql);
					
			}
			
		}
		
		//get a copy of the version table
		$doc =& JTable::getInstance('version', 'Table');

		//duplicate the article object
		$vars = get_class_vars(get_class($article));
				
		//copy it to the version object
		if($vars){
			foreach ($vars as $name => $value) {		
				$doc->$name = $article->$name;
			}
		}else{
			
			foreach ($doc as $name => $value) {		
				$doc->$name = $article->$name;
			}
			
		}
		
		//store the article id
		$doc->content_id = (int)$doc->id;
		
		$doc->_tbl = "#__version";

		//items coming from Joomfish need this
		if(!$doc->_tbl_key){
			$doc->_tbl_key = "id";
			
			$doc->_db =& JFactory::getDBO();
		}
		
		//they're always new
		$doc->id = null;
		
		//does the latest workflow record indicate that this version should be staged?
		$sql = "SELECT stage FROM #__fc_workflow WHERE content_id = " . $doc->content_id . "  order by id desc limit 1";

		$db->setQuery($sql);
		$stage = (int)$db->loadResult();
		
		//set this version as staged
		if($stage > 0){
			$doc->stage = 1;	
		}
		
		//Check if this version is any different	
		if(!$doc->store()){
			JError::raiseError(500, $doc->getError() );
			return false;
		}
		
		//check if the admin notify parameter is set
		if(strlen($admin_notify) > 0){
			
			if(JMailHelper::isEmailAddress($admin_notify) === true){
				
				//load the language .ini file
				$lang =& JFactory::getLanguage();
				$lang->load( 'com_versions', JPATH_ADMINISTRATOR);

	
				$mailSender =& JFactory::getMailer();
				$mailSender->addRecipient($admin_notify);
				$mailSender->setSubject(JText::_('EMAIL_SUBJECT') . " " . $doc->title);
				
				$modified_by_user 	=& JFactory::getUser((int)@$article->modified_by);
				$created_by_user 	=& JFactory::getUser((int)@$article->created_by);
				
				
				$body = JText::_('EMAIL_BODY') . "<br />" . JText::_('Created by:') . $created_by_user->name . "<br />";
				
				$body .= JText::_('Modified by:') . $modified_by_user->name . "<br />";
				
				$body .= "<br />" . $doc->introtext . $doc->fulltext;
				
				//send the content
				$mailSender->setBody($body);
				$mailSender->IsHTML(true);
				
				//get the from address for SMTP 
				$mail_from   = JApplication::getCfg('mailfrom');
				$from_name   = JApplication::getCfg('fromname');
				
				if(JMailHelper::isEmailAddress($mail_from) === true){
					$from_address =  array( $mail_from, $from_name );
					$mailSender->setSender( $from_address );
				}
				
				if (!$mailSender->Send())
				{
					JError::raiseWarning(500,JText::_('EMAIL_ERROR'));
				}
			}
		}
		   
		return true;
	}
	
}
}