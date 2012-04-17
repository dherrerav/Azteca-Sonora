<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$cacheId = md5(serialize(array($params->get('facebook_page'), $params->get('twitter_username'), $module->module)));
$cacheParams = new stdClass();
$cacheParams->cachemode = 'id';
$cacheParams->class = 'modSocialStatsHelper';
$cacheParams->method = 'getStats';
$cacheParams->methodparams = $params;
$cacheParams->modeparams = $cacheId;
$stats = JModuleHelper::moduleCache($module, $params, $cacheParams);
if (!empty($stats)) {
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	require JModuleHelper::getLayoutPath('mod_social_stats', $params->get('layout', 'default'));
}