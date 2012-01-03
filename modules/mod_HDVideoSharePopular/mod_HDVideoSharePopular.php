<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        mod_HDVideoSharePopular.php
 * @location    /components/modules/mod_HDVideoSharePopular/mod_HDVideoSharePopular.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Popular
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
require_once( dirname(__FILE__) . DS . 'helper.php' );
$db = & JFactory::getDBO();
$class	= $params->get( 'moduleclass_sfx' );
$query = "select 	language_settings from #__hdflv_site_settings "; //and id=2";
$db->setQuery($query);
$rows = $db->loadObjectList();
require_once("components/com_contushdvideoshare/language/" . $rows[0]->language_settings );
$result = modpopularvideos::getpopularVideos();
$result1 = modpopularvideos::getpopularVideossettings();
require(JModuleHelper::getLayoutPath('mod_HDVideoSharePopular'));
?>
