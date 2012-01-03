<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldAbout extends JFormField {
	protected $type = 'About';

	protected function getInput() {
		return '<div id="gk_about_us">' . JText::_('MOD_HIGHLIGHT_GK4_ABOUT_US_CONTENT') . '</div>';
	}
}
