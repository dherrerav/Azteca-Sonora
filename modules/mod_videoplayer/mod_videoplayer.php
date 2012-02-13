<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
$categories = modVideoPlayerHelper::getVideos($params);
$count = count($categories);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_videoplayer', $params->get('layout', 'default'));