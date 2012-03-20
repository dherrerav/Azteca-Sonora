<?php
/**
 * @version		$Id: extension.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSHelperExtension {

	function isInstalled($extension = NULL){
		if(is_null($extension)){
			return false;
		}
		$extension = JString::strtolower($extension);
		if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_'.$extension.DS.$extension.'.php')){
			return true;
		}
		else {
			return false;
		}
	}
}