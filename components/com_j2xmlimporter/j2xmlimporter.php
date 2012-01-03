<?php

/**
 * @author Antonio Duran
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package xmlrpctest
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');

$controller	= JController::getInstance('J2XMLImporter');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();