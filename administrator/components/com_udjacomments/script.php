<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package com_udjacomments
**/ 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of HelloWorld component
 */
class com_udjacommentsInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");

		$installer = new JInstaller();
		
		// Install plugins
		foreach($manifest->plugins->plugin as $plugin) {
			$attributes = $plugin->attributes();
			$plg = $source . DS . $attributes['folder'].DS.$attributes['plugin'];
			$installer->install($plg);
		}

		// Install modules
		foreach($manifest->modules->module as $module) {
			$attributes = $module->attributes();
			$mod = $source . DS . $attributes['folder'].DS.$attributes['module'];
			$installer->install($mod);
		}
		
		// $parent is the class calling this method
		$parent->setRedirectURL('index.php?option=com_udjacomments');
	}
	
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_UDJACOMMENTS_UNINSTALL_TEXT') . '</p>';
	}
	
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");

		$installer = new JInstaller();
		
		// Install plugins
		foreach($manifest->plugins->plugin as $plugin) {
			$attributes = $plugin->attributes();
			$plg = $source . DS . $attributes['folder'].DS.$attributes['plugin'];
			$installer->install($plg);
		}

		// Install modules
		foreach($manifest->modules->module as $module) {
			$attributes = $module->attributes();
			$mod = $source . DS . $attributes['folder'].DS.$attributes['module'];
			$installer->install($mod);
		}
		
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_UDJACOMMENTS_UPDATE_TEXT') . '</p>';
	}
	
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_UDJACOMMENTS_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}
	
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_UDJACOMMENTS_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}