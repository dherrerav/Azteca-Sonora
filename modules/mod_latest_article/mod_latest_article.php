<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$cacheId = md5(serialize(array($params->get('catids'), $module->module)));
$cacheParams = new stdClass();
$cacheParams->cachemode = 'id';
$cacheParams->class = 'modLatestArticleHelper';
$cacheParams->method = 'getArticles';
$cacheParams->methodparams = $params;
$cacheParams->modeparams = $cacheId;
$articles = JModuleHelper::moduleCache($module, $params, $cacheParams);
if (!empty($articles)) {
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	require JModuleHelper::getLayoutPath('mod_latest_article', $params->get('layout', 'default'));
}