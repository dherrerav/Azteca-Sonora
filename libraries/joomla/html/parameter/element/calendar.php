<?php
/**
 * @version		$Id: calendar.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Renders a calendar element
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */
class JElementCalendar extends JElement
{
	/**
	* Element name
	* @access	protected
	* @var		string
	*/
	protected $_name = 'Calendar';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		JHtml::_('behavior.calendar'); //load the calendar behavior

		$format	= ($node->attributes('format') ? $node->attributes('format') : '%Y-%m-%d');
		$class	= $node->attributes('class') ? $node->attributes('class') : 'inputbox';
		$id		= $control_name.$name;
		$name	= $control_name.'['.$name.']';

		return JHtml::_('calendar',$value, $name, $id, $format, array('class' => $class));
	}
}
