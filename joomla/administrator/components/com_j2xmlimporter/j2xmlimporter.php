<?php
/**
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * 
 * @version		1.6.0beta3.37
 * @since		1.6.0
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

// Merge the default translation with the current translation
$jlang =& JFactory::getLanguage();
// Back-end translation
$jlang->load('com_j2xmlimporter', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_j2xmlimporter', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_j2xmlimporter', JPATH_ADMINISTRATOR, null, true);


$task = JRequest::getCmd('task', 'cpanel');
if (strpos($task, '.') != false) 
{
	// We have a defined controller/task pair -- lets split them out
	list($controllerName, $task) = explode('.', $task);
	
	// Define the controller name and path
	$controllerName	= strtolower($controllerName);
} else {
	// Get the controller, just set the task
	$controllerName = JRequest::getCmd('c', 'cpanel');
}

$controllerPath	= JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.$controllerName.'.php';
	
// If the controller file path exists, include it ... else lets die with a 500 error
if (file_exists($controllerPath)) {
	require_once($controllerPath);
} else {
	JError::raiseError(500, 'Invalid Controller '.$controllerName);
}

// Set the name for the controller and instantiate it
$controllerClass = 'J2XMLImporterController'.ucfirst($controllerName);
if (class_exists($controllerClass)) {
	$controller = new $controllerClass();
} else {
	JError::raiseError(500, 'Invalid Controller Class - '.$controllerClass );
}

//$config	= JFactory::getConfig();

// Perform the Request task
$controller->execute($task);

// Redirect if set by the controller
$controller->redirect();
