<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
$articles = modContentCarouselHelper::getArticles($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$width = $params->get('width');
$height = $params->get('height');
require JModuleHelper::getLayoutPath('mod_content_carousel', $params->get('layout', 'default'));