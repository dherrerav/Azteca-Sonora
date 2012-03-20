<?php
/**
 * @version		$Id: router.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function FPSSBuildRoute( & $query) {
	$segments = array();
	if (isset($query['task'])) {
		$task = $query['task'];
		$segments[] = $task;
		unset($query['task']);
	}
	if (isset($query['id'])) {
		$id = $query['id'];
		$segments[] = $id;
		unset($query['id']);
	}
	if (isset($query['url'])) {
		$url = $query['url'];
		$segments[] = $url;
		unset($query['url']);
	}
	return $segments;
}

function FPSSParseRoute($segments) {
	$vars = array();
	$vars['task'] = $segments[0];
	$vars['id'] = $segments[1];
	if(isset($segments[2])) {
		$vars['url'] = $segments[2];
	}
	return $vars;
}