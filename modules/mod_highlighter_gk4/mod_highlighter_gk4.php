<?php

/**
* Main file
* @package News Highlighter GK4
* @Copyright (C) 2009-2010 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/

/** access restriction **/
defined('_JEXEC') or die('Restricted access');
/**	Loading helper class **/
require_once (dirname(__FILE__).DS.'helper.php');
//
if(!class_exists('NH_GK4_Joomla_Source')) require_once (dirname(__FILE__).DS.'gk_classes'.DS.'gk.source.joomla.php');
if(!class_exists('NH_GK4_Utils')) require_once (dirname(__FILE__).DS.'gk_classes'.DS.'gk.utils.php');
//
$helper = new NH_GK4_Helper($params, $module);
$helper->getDatas();
$helper->renderLayout();

?>