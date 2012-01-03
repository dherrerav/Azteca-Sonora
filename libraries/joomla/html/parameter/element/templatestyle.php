<?php
/**
 * @version		$Id: templatestyle.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined( '_JEXEC' ) or die( 'Access denied' );

/**
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.6
**/
class JElementTemplateStyle extends JElement {

	/**
	* Element name
	*
	* @access	protected
	* @var		string
	**/
	var	$_name = 'TemplateStyle';

	public function fetchElement( $name, $value, &$node, $control_name )
	{
		$db = JFactory::getDBO();

		$query = 'SELECT * FROM #__template_styles '
			. 'WHERE client_id = 0 '
			. 'AND home = 0';
		$db->setQuery( $query );
		$data = $db->loadObjectList();

		$default = JHtml::_( 'select.option', 0, JText::_( 'JOPTION_USE_DEFAULT' ), 'id', 'description' );
		array_unshift( $data, $default );

		$selected = $this->_getSelected();
		$html = JHtml::_( 'select.genericlist', $data, $control_name.'['.$name.']', 'class="inputbox" size="6"', 'id', 'description', $selected );
		return $html;
	}

	private function _getSelected()
	{
		$id = JRequest::getVar( 'cid', 0 );
		$db = JFactory::getDBO();
		$query = 'SELECT `template_style_id` FROM `#__menu` '
			. 'WHERE id = '.$id[0];
		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	}
}
