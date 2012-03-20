<?php
/**
 * @version		$Id: header.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(version_compare( JVERSION, '1.6.0', 'ge' )) {

	jimport('joomla.form.formfield');
	class JFormFieldHeader extends JFormField {

		var	$type = 'header';

		function getInput(){
			return JElementHeader::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}

		function getLabel(){
			return '';
		}

	}
}

jimport('joomla.html.parameter.element');

class JElementHeader extends JElement {

	var	$_name = 'header';

	function fetchElement($name, $value, &$node, $control_name){
		// Output
		return '
		<div style="font-weight:normal;font-size:12px;color:#fff;padding:4px;margin:0;background:#0B55C4;clear:both;">
			'.JText::_($value).'
		</div>
		';
	}

	function fetchTooltip($label, $description, &$node, $control_name, $name){
		return;
	}
}
