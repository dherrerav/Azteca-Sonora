<?php
/**
 * @version		$Id: modulelayouts.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

require_once dirname(__FILE__).'/list.php';

/**
 * Parameter to display a list of the layouts for a module from the module or default template overrides.
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 */
class JElementModuleLayouts extends JElementList
{
	/**
	 * @var		string
	 */
	protected $_name = 'ModuleLayouts';

	/**
	 * Get the options for the list.
	 */
	protected function _getOptions(&$node)
	{
		$clientId = ($v = $node->attributes('client_id')) ? $v : 0;

		$options	= array();
		$path1		= null;
		$path2		= null;

		// Load template entries for each menuid
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->select('template');
		$query->from('#__template_styles');
		$query->where('client_id = '.(int) $clientId);
		$query->where('home = 1');
		$db->setQuery($query);
		$template	= $db->loadResult();

		if ($module = $node->attributes('module')) {
			$base	= ($clientId == 1) ? JPATH_ADMINISTRATOR : JPATH_SITE;
			$module	= preg_replace('#\W#', '', $module);
			$path1	= $base.DS.'modules'.DS.$module.DS.'tmpl';
			$path2	= $base.DS.'templates'.DS.$template.DS.'html'.DS.$module;
			$options[]	= JHtml::_('select.option', '', '');
		}

		if ($path1 && $path2) {
			jimport('joomla.filesystem.file');
			$path1 = JPath::clean($path1);
			$path2 = JPath::clean($path2);

			$files	= JFolder::files($path1, '^[^_]*\.php$');
			foreach ($files as $file) {
				$options[]	= JHtml::_('select.option', JFile::stripExt($file));
			}

			if (is_dir($path2) && $files = JFolder::files($path2, '^[^_]*\.php$')) {
				$options[]	= JHtml::_('select.optgroup', JText::_('JOPTION_FROM_DEFAULT'));
				foreach ($files as $file) {
					$options[]	= JHtml::_('select.option', JFile::stripExt($file));
				}
				$options[]	= JHtml::_('select.optgroup', JText::_('JOPTION_FROM_DEFAULT'));
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::_getOptions($node), $options);

		return $options;
	}
}