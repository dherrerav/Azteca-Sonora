<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$cacheId = md5(serialize(array($params->get('catids'), $module->module)));
$cacheParams = new stdClass();
$cacheParams->cachemode = 'id';
$cacheParams->class = 'modBreakingNewsHelper';
$cacheParams->method = 'getArticles';
$cacheParams->methodparams = $params;
$cacheParams->modeparams = $cacheId;
$articles = JModuleHelper::moduleCache($module, $params, $cacheParams);
if (!empty($articles)) {
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	$articles_per_column = explode(',', trim($params->get('articles_per_column')));
	$item_heading = $params->get('item_heading', 3);
	require JModuleHelper::getLayoutPath('mod_breaking_news', $params->get('layout', 'default'));
}