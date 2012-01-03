<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package com_udjacomments
**/
// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.event.plugin');
jimport( 'joomla.application.application' );
jimport( 'joomla.application.categories' );


class plgContentUdjaComments extends JPlugin
{
	
	function plgContentUdjaComments(&$subject, $config )
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
	
	function onContentAfterDisplay($item, &$article)
	{
		//get component params
		$componentParams = JComponentHelper::getParams('com_udjacomments');
		
		//output comments if article view.
		if (JRequest::getString('view') == 'article')
		{
			$document = &JFactory::getDocument();
			$renderer = $document->loadRenderer('module');

			//get module as an object
			$database = JFactory::getDBO();
			$database->setQuery('SELECT * FROM #__modules WHERE `module`="mod_udjacomments" LIMIT 1');
			$modules = $database->loadObjectList();

			//just to get rid of that stupid php warning
			$modules[0]->user = '';
			
			//render module content
			$content = $renderer->render($modules[0], array('style'=>'none'));
		}
		//else (if enabled) display comment count.
		else
		{
			//get URL for article
			$url	= ContentHelperRoute::getArticleRoute($article->id.':'.$article->alias, $article->catid);
			
			//get Comment count
			$count	= $this->getNumComments(str_ireplace(JURI::base(),'',$url));
			
			//get correct term for comment count.
			$commentCountString = ($count != 1) ? $count . ' ' . JText::_('PLG_UDJACOMMENTS_COMMENTS') : '1 ' . JTEXT::_('PLG_UDJACOMMENTS_COMMENT');
			
			//create output
			$content = '<p class="articleMeta"><a href="'.$url.'#frmUdjaComments" class="commentCount" title="'.$commentCountString.'">'.$commentCountString.'</a></p>';
		}
		
		return $content;
		//return a string value. Returned value from this event will be displayed in a placeholder. 
		// Most templates display this placeholder after the article separator.
	}
	
	private function getNumComments($url)
	{
		$sql = 'SELECT
					count(`id`) AS commentCount
				FROM
					`#__udjacomments`
				WHERE
					`comment_url` = "'.$url.'"';			
		
		$dbo = JFactory::getDBO();
		
		$dbo->setQuery($sql);
		
		if ($dbo->Query())
		{
			if ($result = $dbo->loadObject())
			{
				
				
				return $result->commentCount;
			}
		}
		
		if ($err = $dbo->getErrorMsg()) { die($err); }
		
		return 0;
	}
	
}