<?php
/**
 * @version		$Id:sql.php 6961 2007-03-15 16:06:53Z tcp $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a SQL element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JFormFieldFJSQL extends JFormFieldList
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	public $type = 'FJSQL';

	protected function getOptions()
	{
		$options = array();
		$key = $this->element('key_field') ? (string) $this->element('key_field') : 'value';
		$value	= $this->element['value_field'] ? (string) $this->element['value_field'] : (string) $this->element['name'];
		$query	= (string) $this->element['query'];

		// Get the database object.
		$db = JFactory::getDBO();
		
		// Set the query and get the result list.
		$db->setQuery($query);
		$items = $db->loadObjectlist();
		
			// Check for an error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
			return $options;
		}

		if ($node->attributes('multiple')) {
			$size = $node->attributes('size') ? $node->attributes('size') : '5';
			$multiple = ' multiple="multiple" size="'.$size.'"';
			$multipleArray = "[]";
		} else {
			$multiple = '';
			$multipleArray = '';
		}
		$attributes = 'class="inputbox" ' . $multiple;


		return JHTML::_('select.genericlist',  $items, ''.$control_name.'['.$name.']'.$multipleArray, $attributes, $key, $val, $value, $control_name.$name);
	}
}
