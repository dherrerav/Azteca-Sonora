<?php
/**
 * @version		$Id: usergroup.php 20972 2011-03-16 13:57:36Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a editors element
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */

class JElementUserGroup extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	protected $_name = 'UserGroup';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$ctrl	= $control_name .'['. $name .']';
		$attribs	= ' ';

		if ($v = $node->attributes('size')) {
			$attribs	.= 'size="'.$v.'"';
		}
		if ($v = $node->attributes('class')) {
			$attribs	.= 'class="'.$v.'"';
		} else {
			$attribs	.= 'class="inputbox"';
		}
		if ($m = $node->attributes('multiple'))
		{
			$attribs	.= 'multiple="multiple"';
			$ctrl		.= '[]';
			//$value		= implode('|',)
		}
		//array_unshift($editors, JHtml::_('select.option',  '', '- '. JText::_('SELECT_EDITOR') .' -'));

		return JHtml::_('access.usergroup', $ctrl, $value, $attribs, false);
	}
}
