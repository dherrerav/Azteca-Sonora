<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
$articles = modLatestNewsVideosHelper::getArticles($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_latest_news_videos', $params->get('layout', 'default'));