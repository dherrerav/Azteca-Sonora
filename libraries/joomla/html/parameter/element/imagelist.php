<?php
/**
 * @version		$Id: imagelist.php 20972 2011-03-16 13:57:36Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a imagelist element
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */

class JElementImageList extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	protected $_name = 'ImageList';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$filter = '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$';
		$node->addAttribute('filter', $filter);

		$parameter = $this->_parent->loadElement('filelist');

		return $parameter->fetchElement($name, $value, $node, $control_name);
	}
}
