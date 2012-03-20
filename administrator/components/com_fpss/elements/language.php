<?php
/**
 * @version		$Id: language.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(version_compare( JVERSION, '1.6.0', 'ge' )) {

	jimport('joomla.form.formfield');
	class JFormFieldLanguage extends JFormField {

		var	$type = 'language';

		function getInput(){
			return JElementLanguage::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}

		function getLabel(){
			return '';
		}
	}
}

jimport('joomla.html.parameter.element');

class JElementLanguage extends JElement {

	var	$_name = 'language';

	function fetchElement($name, $value, &$node, $control_name){
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$extension = $node->getAttribute('extension');
		}
		else {
			$extension = $node->attributes('extension');
		}
		$language = &JFactory::getLanguage();
		$language->load($extension, JPATH_SITE);
		$language->load($extension, JPATH_ADMINISTRATOR);
	}

	function fetchTooltip($label, $description, &$node, $control_name, $name){
		return;
	}
}
