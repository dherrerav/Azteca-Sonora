<?php
/**
 * @version		$Id: form.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Utility class for form elements
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @version		1.5
 */
abstract class JHtmlForm
{
	/**
	 * Displays a hidden token field to reduce the risk of CSRF exploits
	 *
	 * Use in conjuction with JRequest::checkToken
	 *
	 * @static
	 * @return	void
	 * @since	1.5
	 */
	public static function token()
	{
		return '<input type="hidden" name="'.JUtility::getToken().'" value="1" />';
	}
}