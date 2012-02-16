<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TOOLBAR_JACOMMENT {
	
	function _DEFAULT($text = 'JA Comment') {
		/*
		 * DEVNOTE: This should make sense by itself now... 
		 */
		JToolBarHelper::title ( JText::_( $text ), 'generic.png' );
		JToolBarHelper::help ( 'screen.jacomment' );
	}
	function JACCOMMENT($text = '') {
		JToolBarHelper::title ( JText::_( $text ) );
		$task = JRequest::getWord ( 'task', '' );
		switch ($task) {
			case 'add' :
			case 'save' :
			case 'apply' :
			case 'edit' :
				{
					JToolBarHelper::apply ();
					JToolBarHelper::save ();
					JToolBarHelper::cancel ();
				}
				break;
			default :
				{
					//JToolBarHelper::addNewX ();
					//JToolBarHelper::addNew("add","Add");
					JToolBarHelper::publish("approve","Approve");
					JToolBarHelper::unpublish ("unapprove","Unapprove");
					JToolBarHelper :: custom( 'spam', 'trash.png', 'trash.png', 'Mark Spam', false, false );												
					JToolBarHelper :: custom( 'delete', 'delete.png', 'delete.png', 'Delete', false, false );
					//JToolBarHelper::trash("Spam","Spam");										
					//JToolBarHelper::deleteList ( JText::_( 'WARNING BEFOR DELETED' ) );					
				}
		}
	}
	function JACREPORTS($text = '') {
		JToolBarHelper::title ( JText::_( $text ) );
		$task = JRequest::getWord ( 'task', '' );
		switch ($task) {
			default :
				{
					JToolBarHelper::publish ();
					JToolBarHelper::unpublish ();
					JToolBarHelper::deleteList(JText::_( 'WARNING BEFOR DISMISS' ), 'dismiss_all', 'Dismiss');
				}
		}
	}
	function JACEmails() {
		$task = JRequest::getWord ( 'task', '' );
		JToolBarHelper::title ( JText::_( 'Email Template Manager' ) );
		switch ($task) {
			case 'add' :
			case 'edit' :
				{
					JToolBarHelper::apply ();
					JToolBarHelper::save ();
					JToolBarHelper::cancel ();
				}
				break;
			case 'show_duplicate' :
			case 'show_import' :
			case 'show_export' :
				break;
			default :
				{
					JToolBarHelper::custom ( 'show_duplicate', 'copy', '', JText::_( 'Copy to' ) );
					JToolBarHelper::custom ( 'show_import', 'back', '', JText::_( 'Import' ), false );
					JToolBarHelper::custom ( 'export', 'forward', '', JText::_( 'Export' ) );
					JToolBarHelper::publishList ();
					JToolBarHelper::unpublishList ();
					JToolBarHelper::deleteList ( JText::_( 'Are you sure to delete' ) );
					JToolBarHelper::editListX ();
					JToolBarHelper::addNewX ();
				}
				break;
		}
	}
	function JACConfigs() {
		$group = JRequest::getWord ( 'group', '' );
		JToolBarHelper::title ( JText::_( 'Configuration Manager' ) );
		
		if($group=='layout'){
			//JToolBarHelper::preview(JURI::root().'index.php?tmpl=component&option=com_jacomment&view=comments&layout=themes');
			JToolBarHelper::save ("save",JTEXT::_("Save"));
		}
		elseif($group=='moderator'){
			JToolBarHelper::addNewX('add','Add User');
			JToolBarHelper::deleteListX();
		}else{
			JToolBarHelper::save ("save",JTEXT::_("Save"));
		}			
		
	}
	function JACDesign($title = '') {
		$task = JRequest::getWord ( 'task', '' );
		$controller = JRequest::getVar ( 'view', NULL );
		if (! $title) {
			switch ($controller) {
				case 'jacustomcss' :
					$title = JText::_( "CUSTOM CSS" );
					break;
				case 'jacustomtmpl' :
					$title = JText::_( "CUSTOM TEMPLATE" );
					break;
				case 'managelang':
					$title = JText::_( "CUSTOM LANGUAGE" );
					break;					
			}
		}
		JToolBarHelper::title ($title );
		if ($task == 'edit'){
			JToolBarHelper::save ();
			JToolBarHelper::cancel();
		}
		
	}
	
	function JACImexport(){
		$task = JRequest::getWord ( 'task', '' );
		if($task == "showComment"){
			JToolBarHelper::publish("approve","Approve");
			JToolBarHelper::unpublish ("unapprove","Unapprove");
			JToolBarHelper :: custom( 'spam', 'trash.png', 'trash.png', 'Mark Spam', false, false );												
			JToolBarHelper :: custom( 'delete', 'delete.png', 'delete.png', 'Delete', false, false );	
		}
	}
}
?>