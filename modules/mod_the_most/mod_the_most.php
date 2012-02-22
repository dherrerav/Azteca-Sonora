<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// No direct access.
defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__) . '/helper.php';

$articles = modTheMostHelper::getArticles($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_the_most', $params->get('layout', 'default'));