<?php
/**
 * @version		$Id: modules.php 20740 2011-02-17 10:28:57Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Modules component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @since		1.6
 */
abstract class ModulesHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName)
	{
		// Not used in this component.
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, 'com_modules'));
		}

		return $result;
	}

	/**
	 * Get a list of filter options for the state of a module.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 */
	public static function getStateOptions()
	{
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option',	'1',	JText::_('JPUBLISHED'));
		$options[]	= JHtml::_('select.option',	'0',	JText::_('JUNPUBLISHED'));
		$options[]	= JHtml::_('select.option',	'-2',	JText::_('JTRASHED'));
		return $options;
	}

	/**
	 * Get a list of filter options for the application clients.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 */
	public static function getClientOptions()
	{
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '0', JText::_('JSITE'));
		$options[]	= JHtml::_('select.option', '1', JText::_('JADMINISTRATOR'));
		return $options;
	}

	static function getPositions($clientId)
	{
		jimport('joomla.filesystem.folder');

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('DISTINCT(position)');
		$query->from('#__modules');
		$query->where('`client_id` = '.(int) $clientId);
		$query->order('position');

		$db->setQuery($query);
		$positions = $db->loadResultArray();
		$positions = (is_array($positions)) ? $positions : array();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
			return;
		}

		// Build the list
		$options = array();
		foreach ($positions as $position) {
			$options[]	= JHtml::_('select.option', $position, $position);
		}
		return $options;
	}

	public static function getTemplates($clientId = 0, $state = '', $template='')
	{
		$db = JFactory::getDbo();
		// Get the database object and a new query object.
		$query	= $db->getQuery(true);

		// Build the query.
		$query->select('element, name, enabled');
		$query->from('#__extensions');
		$query->where('client_id = '.(int) $clientId);
		$query->where('type = '.$db->quote('template'));
		if ($state!='') {
			$query->where('enabled = '.$db->quote($state));
		}
		if ($template!='') {
			$query->where('element = '.$db->quote($template));
		}

		// Set the query and load the templates.
		$db->setQuery($query);
		$templates = $db->loadObjectList('element');
		return $templates;
	}

	/**
	 * Get a list of the unique modules installed in the client application.
	 *
	 * @param	int		The client id.
	 *
	 * @return	array
	 */
	public static function getModules($clientId)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('DISTINCT(m.module) AS value, e.name AS text');
		$query->from('#__modules AS m');
		$query->join('LEFT', '#__extensions AS e ON e.element=m.module');
		$query->where('m.`client_id` = '.(int)$clientId);

		$db->setQuery($query);
		$modules = $db->loadObjectList();
		$lang = JFactory::getLanguage();
		foreach ($modules as $i=>$module) {
			$extension = $module->value;
			$path = $clientId ? JPATH_ADMINISTRATOR : JPATH_SITE;
			$source = $path . "/modules/$extension";
				$lang->load("$extension.sys", $path, null, false, false)
			||	$lang->load("$extension.sys", $source, null, false, false)
			||	$lang->load("$extension.sys", $path, $lang->getDefault(), false, false)
			||	$lang->load("$extension.sys", $source, $lang->getDefault(), false, false);
			$modules[$i]->text = JText::_($module->text);
		}
		JArrayHelper::sortObjects($modules, 'text', 1, true, $lang->getLocale());
		return $modules;
	}

	/**
	 * Get a list of the assignment options for modules to menus.
	 *
	 * @param	int		The client id.
	 *
	 * @return	array
	 */
	public static function getAssignmentOptions($clientId)
	{
		$options = array();
		$options[] = JHtml::_('select.option', '0', 'COM_MODULES_OPTION_MENU_ALL');
		$options[] = JHtml::_('select.option', '-', 'COM_MODULES_OPTION_MENU_NONE');

		if ($clientId == 0) {
			$options[] = JHtml::_('select.option', '1', 'COM_MODULES_OPTION_MENU_INCLUDE');
			$options[] = JHtml::_('select.option', '-1', 'COM_MODULES_OPTION_MENU_EXCLUDE');
		}

		return $options;
	}
}
