<?php
/*
# ------------------------------------------------------------------------
# JA Comment Off JA Comment Plugin for Joomla 1.5
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
class plgButtonJaCommentOff extends JPlugin
{
	function plgButtonJCommentsOff(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onDisplay($name)
	{
		$doc =& JFactory::getDocument();
		$getContent = $this->_subject->getContent($name);
		
		$jaJS = "
			function insertJaCommentOn(editor) {
				var content = $getContent
				if (content.match(/{jacomment on}/)) {
					content.replace('{jacomment on}', '');
				}
				if (content.match(/{jacomment off}/)) {
					return false;
				} else {
					jInsertEditorText('{jacomment off}', editor);
				}
			}
			";
		
		$doc->addScriptDeclaration($jaJS);
		
		$button = new JObject();
		$button->set('modal', false);
		$button->set('onclick', 'insertJaCommentOn(\''.$name.'\');return false;');
		$button->set('text', 'JAComment OFF');
		$button->set('name', 'blank');
		$button->set('link', '#');

		return $button;
	}
}
?>