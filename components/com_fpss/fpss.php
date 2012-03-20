<?php
/**
 * @version		$Id: fpss.php 497 2011-07-07 11:43:10Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.application.component.model');
jimport('joomla.application.component.view');
jimport('joomla.application.module.helper');
jimport('joomla.filesystem.file');
$language = &JFactory::getLanguage();
$language->load('com_fpss', JPATH_ADMINISTRATOR);
require_once(JPATH_COMPONENT.DS.'controller.php');
$controller = new FPSSController();
$controller->execute(JRequest::getWord('task'));
$controller->redirect();