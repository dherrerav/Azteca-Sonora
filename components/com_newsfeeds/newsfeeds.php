<?php
/**
* version $Id: newsfeeds.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_newsfeeds
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Require the com_content helper library
jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

$controller	= JController::getInstance('Newsfeeds');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();