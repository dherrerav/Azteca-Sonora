<?php
/**
 * @version		$Id: category.php 627 2011-08-11 19:45:36Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(version_compare( JVERSION, '1.6.0', 'ge' )) {

	jimport('joomla.form.formfield');
	class JFormFieldCategory extends JFormField {

		var	$type = 'category';

		function getInput(){
			return JElementCategory::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}
	}
}

jimport('joomla.html.parameter.element');

class JElementCategory extends JElement {

	var	$_name = 'category';

	function fetchElement($name, $value, &$node, $control_name){

		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models');
		$model = &JModel::getInstance('categories', 'FPSSModel');
		$model->setState('published', -1);
		$model->setState('limit', 0);
		$model->setState('limitstart', 0);
		$model->setState('ordering', 'name');
		$model->setState('orderingDir', 'ASC');
		$categories = $model->getData();
		$attributes = '';
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			if($node->getAttribute('multiple')){
				$attributes.=' multiple="multiple" style="width:99%;" size="6"';
			}
			$fieldName = $name;
		}
		else {
			$fieldName = $name.'[]';
			if($node->attributes('multiple')){
				$attributes.=' multiple="multiple" style="width:99%;" size="6"';
				$fieldName = $control_name.'['.$name.'][]';
			}
			
		}
		return JHTML::_('select.genericlist', $categories, $fieldName, $attributes, 'id', 'name', $value);
	}
}
