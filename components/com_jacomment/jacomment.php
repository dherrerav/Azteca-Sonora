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
/*
 * DEVNOTE: This is the 'main' file. 
 * It's the one that will be called when we go to the Jacomment component. 
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Require the submenu for component
jimport( 'joomla.application.component.model' );
jimport('joomla.utilities.date');
jimport('joomla.application.component.controller');

JTable::addIncludePath(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_jacomment' . DS . 'tables');
         
//------------------------------check Component Offline-------------------------
/* Require Helper */
require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'jahelper.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'jacaptcha'.DS.'jacapcha.php');

$GLOBALS['jacconfig'] = array(); 
JACommentHelpers::get_config_system();
global $jacconfig;

if(isset($jacconfig['general']) && $jacconfig['general']->get('is_comment_offline', 0)){
	if(!JACommentHelpers::check_access()) return ;
}			
if(!isset($_SESSION['JAC_LAST_VISITED'])){
    if(isset($_COOKIE['JAC_LAST_VISITED'])) $_SESSION['JAC_LAST_VISITED'] = $_COOKIE['JAC_LAST_VISITED'];
    else $_SESSION['JAC_LAST_VISITED'] = strtotime ( date ( "Y-m-d" ) . " -3 days" );
    setcookie('JAC_LAST_VISITED', time());    	
}

if(!JRequest::getCmd('view')) JRequest::setVar('view', 'comments');
$controller = JRequest::getCmd('view');

require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'controller.php');
$view = $controller;
if($controller) {
	$path = JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

if(!defined('JACOMMENT_GLOBAL_JS')){	
	JHTML::script('components/com_jacomment/asset/js/jquery-1.4.2.js');
    JHTML::script('components/com_jacomment/asset/js/ja.comment.js');
    JHTML::script('components/com_jacomment/asset/js/ja.popup.js');  
    define('JACOMMENT_GLOBAL_JS', true);
}

// Create the controller
$classname	= 'JACommentController'.ucfirst($controller);
$controller = new $classname( );

$controller->_basePath = JPATH_SITE.DS.'components'.DS.'com_jacomment';
$controller->_path['view'][0] = JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'views'.DS;


$task = JRequest::getVar('task', null, 'default', 'cmd');

$controller->execute( $task );


// Redirect if set by the controller
$controller->redirect();
?>