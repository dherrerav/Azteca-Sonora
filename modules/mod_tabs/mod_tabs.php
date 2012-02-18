<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
$modules = modTabsHelper::getModules($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_tabs', $params->get('layout', 'default'));
