<?php
/**
 * @version		$Id: number.php 18743 2010-09-01 02:01:33Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * HTML helper class for rendering numbers.
 *
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @since		1.6
 */
abstract class JHtmlNumber
{
	/**
	 * Converts bytes to more distinguishable formats such as:
	 * kilobytes, megabytes, etc.
	 *
	 * By default, the proper format will automatically be chosen.
	 * However, one of the allowed unit types may also be used instead.
	 *
	 * @param	int		$bytes		The number of bytes.
	 * @param	string	$unit		The type of unit to return.
	 * @param	int		$precision	The number of digits to be used after the decimal place.
	 *
	 * @return	string	The number of bytes in the proper units.
	 * @since	1.6
	 */
	public static function bytes($bytes, $unit = 'auto', $precision = 2)
	{
		$bytes		= (int) $bytes;
		$precision	= (int) $precision;

		if (empty($bytes)) {
			return 0;
		}

		$unitTypes	= array('b','kb','MB','GB','TB','PB');

		// Default automatic method.
		$i = floor(log($bytes, 1024));

		// User supplied method:
		if ($unit !== 'auto' && in_array($unit, $unitTypes)) {
			$i = array_search($unit, $unitTypes, true);
		}

		// TODO Allow conversion of units where $bytes = '32M'.

		return round($bytes / pow(1024, $i), $precision).' '.$unitTypes[$i];
	}
}