<?php

/**
* Main file
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

/** access restriction **/
defined('_JEXEC') or die('Restricted access');
/**	Loading helper class **/
require_once (dirname(__FILE__).DS.'helper.php');
//
if(!class_exists('NSP_GK4_Joomla_Source')) require_once (dirname(__FILE__).DS.'gk_classes'.DS.'gk.source.joomla.php');
if(!class_exists('NSP_GK4_Thumbs')) require_once (dirname(__FILE__).DS.'gk_classes'.DS.'gk.thumbs.php');
if(!class_exists('NSP_GK4_Utils')) require_once (dirname(__FILE__).DS.'gk_classes'.DS.'gk.utils.php');
if(!class_exists('NSP_GK4_Layout_Parts')) require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk4','layout.parts'));
//
$helper = new NSP_GK4_Helper();
$helper->init($module, $params);
$helper->getDatas();
$helper->renderLayout();

?>