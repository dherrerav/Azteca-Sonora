<?php
/**
 * @version		$Id: radio.php 20972 2011-03-16 13:57:36Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a radio element
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */

class JElementRadio extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	protected $_name = 'Radio';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$options = array ();
		foreach ($node->children() as $option)
		{
			$val	= $option->attributes('value');
			$text	= $option->data();
			$options[] = JHtml::_('select.option', $val, $text);
		}

		return JHtml::_('select.radiolist', $options, ''.$control_name.'['.$name.']', '', 'value', 'text', $value, $control_name.$name, true);
	}
}
