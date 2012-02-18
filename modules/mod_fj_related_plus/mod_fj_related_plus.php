<?php
/**
* @version		$Id: mod_fj_related_plus.php 295 2012-01-05 00:47:20Z dextercowley $
* @package		mod_fj_related_plus
* @copyright	Copyright (C) 2008 Mark Dexter. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl.html
*/

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modFJRelatedPlusHelper::getList($params); // get return results from the helper
$articleView = modFJRelatedPlusHelper::isArticle(); // is this an article?
$subtitle = '';


if (!count($list)) {  // no articles to list. check whether we want to show some text
	//return;
	if ($articleView != 'true' && ($params->get('notArticleText','')))
	{
		$subtitle = $params->get('notArticleText','');
	}
	else if ($params->get('noRelatedText','') && $articleView == 'true')
	{
		$subtitle = $params->get('noRelatedText','');
	}
	else
	{
		return;
	}
}

// choose layout based on ordering parameter
if ($params->get('ordering') == 'keyword_article' && count($list))
{
	// We need to hard-code the layout when sorting by keyword_article
	$path = JModuleHelper::getLayoutPath('mod_fj_related_plus', 'key_word');
}
else
{
	$path = JModuleHelper::getLayoutPath('mod_fj_related_plus', $params->get('layout', 'default'));
}

if (file_exists($path)) {
	require($path);
}
