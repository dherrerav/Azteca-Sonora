<?php
/**
* @version    $Id: general.php 36 2011-01-20 12:59:29Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author   Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined('_JEXEC') or die('ERROR_403');

$plugin = WFTablesPlugin::getInstance();

echo $this->loadTemplate($plugin->getContext());

?>
