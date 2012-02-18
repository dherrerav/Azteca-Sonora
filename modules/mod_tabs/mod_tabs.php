<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
$tabs = modTabsHelper::getTabs($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
if ($tabs) {
	JHTML::_('behavior.framework', true);
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base() . 'modules/mod_tabs/css/mod_tabs.css');
	require JModuleHelper::getLayoutPath('mod_tabs', $params->get('layout', 'default'));
}
