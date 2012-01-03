<?php
/**
 * String Stream Controller
 *
 * Used to control the string stream
 *
 * PHP4/5
 *
 * Created on Sep 18, 2008
 *
 * @package stringstream
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 * @version SVN: $Id: stringcontroller.php 20196 2011-01-09 02:40:25Z ian $
 */


// No direct access
defined('JPATH_BASE') or die();


class JStringController {

	function _getArray() {
		static $strings = Array();
		return $strings;
	}

	function createRef($reference, &$string) {
		$ref = &JStringController::_getArray();
		$ref[$reference] =& $string;
	}


	function getRef($reference) {
		$ref = &JStringController::_getArray();
		if(isset($ref[$reference])) {
			return $ref[$reference];
		} else {
			return false;
		}
	}
}