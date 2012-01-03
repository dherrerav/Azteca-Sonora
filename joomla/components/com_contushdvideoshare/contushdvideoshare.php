<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        contushdvideoshare.php
 * @location    /components/com_contushdvideosahre/contushdvideoshare.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Common controller
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT . DS . 'controller.php' );
JTable::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_contushdvideoshare' . DS . 'tables');
$controller = new contushdvideoshareController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
?>