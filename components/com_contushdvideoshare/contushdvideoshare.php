<?php

/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/

defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT.DS.'controller.php' );
$cache = &JFactory::getCache('com_contusvideoshare');
$cache->clean();
date_default_timezone_set('UTC');
if(version_compare(JVERSION,'1.7.0','ge')) {
    $version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
    $version='1.6';
} else {
    $version='1.5';
}
if($version == '1.5'){
    JLoader::register('JHtmlString', JPATH_COMPONENT.'/string.php');
}
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_contushdvideoshare'.DS.'tables');
//define('VPATH1', realpath(dirname(__FILE__).'../../../../components/com_contushdvideoshare/videos') );
$controller = new contushdvideoshareController();
$controller->execute( JRequest::getVar('task') );
$controller->redirect();
?>