<?php
if (class_exists('T3Template')) {
	$tmpl = T3Template::getInstance();
	$tmpl->setTemplate($this);
	$tmpl->render();
	return;
} else {
	//Need to install or enable JAT3 Plugin
	echo JText::_('MISSING_JAT3_FRAMEWORK_PLUGIN');
}