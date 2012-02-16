<?php
/*
# ------------------------------------------------------------------------
# JA Comment On JA Comment Plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

// define directory separator short constant
if (!defined( 'DS' )) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'jacomment.php')){
	return;	
}

jimport('joomla.event.plugin');
/**
 * Editor JAComment Off button plugin
 */
class plgButtonJACommentOn extends JPlugin
{
	function plgButtonJACommentOn(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onDisplay($name)
	{		
		$getContent = $this->_subject->getContent($name);		
		$jaJS = "
			function insertJACommentOn(editor) {
				var content = $getContent							
				if (content.match(/{jacomment on}/)) {
					return false;
				} else {
					jInsertEditorText('{jacomment on}', editor);					
				}				
			}
			";

		$doc =& JFactory::getDocument();
		$doc->addScriptDeclaration($jaJS);
		
		$button = new JObject();
		$button->set('modal', false);
		$button->set('onclick', 'insertJACommentOn(\''.$name.'\');return false;');
		$button->set('text', 'JAComment ON');
		$button->set('name', 'blank');
		$button->set('link', '#');

		return $button;
	}
}

?>