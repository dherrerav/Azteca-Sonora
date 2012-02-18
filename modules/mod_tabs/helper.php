<?php
defined('_JEXEC') or die;
abstract class modTabsHelper {
	public static function getTabs(&$params) {
		$ids = explode(',', str_replace(array(' ', '"'), array('', ''), trim($params->get('ids'))));
		$tabs = array();
		foreach ($ids as $id) {
			$tabs[] = self::getModule($id);
		}
		return $tabs;
	}
	public static function getModule($id) {
		$db =& JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__modules');
		$query->where('id = ' . $id);
		$db->setQuery($query);
		if (!($modules = $db->loadObjectList())) {
			JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));
		}
		$custom = substr($modules[0]->module, 0, 4) == 'mod_' ? 0 : 1;
		$modules[0]->user = $custom;
		array_unshift($modules, $modules[0]->title);
		array_unshift($modules, 'mod');
		return $modules;
	}
	public static function generateRamdonId($length) {
		$pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$id = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $pattern{rand(0, strlen($pattern) - 1)};
		}
		return $key;
	}
}