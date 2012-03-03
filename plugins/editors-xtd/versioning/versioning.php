<?php
/**
 * @version		$Id: Versioning.php 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Editor Versioning buton
 *
 * @author Michael Fatica mike@fatica.net
 * @package Editors-xtd
 * @since 1.5
 * @version $Revision$
 */
class plgButtonVersioning extends JPlugin
{
	
	var $params;
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param 	object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgButtonVersioning(& $subject, $config)
	{
		parent::__construct($subject, $config);	
        $this->loadLanguage( );
	}

	/**
	 * Versioning button
	 * @return array A two element array of ( imageName, textToInsert )
	 */
	function onDisplay($name)
	{
		$mainframe = JFactory::getApplication();

		//load the language .ini file
		$lang =& JFactory::getLanguage();
		$lang->load( 'com_versions', JPATH_ADMINISTRATOR);

		$liveSite = substr_replace(JURI::root(), '', -1, 1);

		$doc 		=& JFactory::getDocument();
	
		$present = JText::_('ALREADY EXISTS', true) ;
		
		$editor = JFactory::getEditor();
				
		$js = $editor->setContent($name,'content');
				
		$js = str_replace("'content'","content",$js);
		
		$js = 'function insertVersioning(editor,content) { ' . $js . '}';
	
		$doc->addScriptDeclaration($js);
		
		$id = JRequest::getVar('cid',0);
		
		if(is_array($id)){
			$id = $id[0];	
		}
				
		//front-end
		if($id <= 0){
			$id = JRequest::getVar('id',0);			
		}
		
		if($id <= 0){
			$id = JRequest::getVar('a_id',0);
		}
		
		$id = (int)$id;
		$language_id = 0;
		
		if(JRequest::getVar('option') == "com_joomfish"){
			$ids = JRequest::getVar('cid',0);
			$ids = explode("|",$ids[0]);
			$id = (int)$ids[1];
			$language_id = (int)$ids[2];
		}
				
		$stub =	"index.php";
		
        $link = $stub . '?option=com_versions&language_id='.$language_id.'&tmpl=component&ename='.$name.'&id=' . $id;
      			
		//default height & width of window
        $popup_height = 370;
        $popup_width = 450;
        
		if(@$this->params){
			
			$front_end = @$this->params->get('front_end');
			
			if(@$this->params->get('popup_width') > 0){
				$popup_width = (int)@$this->params->get('popup_width');
			}
			
			if(@$this->params->get('popup_height') > 0){
				$popup_height = (int)@$this->params->get('popup_height');
			}			
			
			
		}
		
		//show the number of staged articles
		$db =& JFactory::getDBO();
		$sql = "SELECT count(id) FROM #__version WHERE content_id = $id  AND (autosaved != '1' or autosaved is null)";
		$db->setQuery( $sql );
		$count = (int)$db->loadResult();
				
		if($count > 0){
			$linktext =  JText::_('VERSIONS') . " ($count)";
		}else{
			$linktext =  JText::_('VERSIONS');
		}		
		
		//This is for backwards compatibilty
		if($front_end == "No" && $mainframe->isSite()){	
			
			$link = "";
        
	        JHTML::_('behavior.modal');
	        $button = new JObject();
	        $button->set('modal', false);
	        $button->set('link', $link);
	        $button->set('text', $linktext);
	        $button->set('name', 'pagebreak');
	        $button->set('options', "");
	        			
		}else{
		        
	        JHTML::_('behavior.modal');
	        $button = new JObject();
	        $button->set('modal', true);
	        $button->set('link', $link);
	        $button->set('text', $linktext);
	        $button->set('name', 'pagebreak');
	        $button->set('options', "{handler: 'iframe',size: {x: $popup_width, y: $popup_height}}");	
			
		}

        return $button;
        
       
	}
}