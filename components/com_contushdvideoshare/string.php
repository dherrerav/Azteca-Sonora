<?php
/**
 * @package     Joomla.Platform
 * @subpackage  HTML
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * HTML helper class for rendering manipulated strings.
 *
 * @package     Joomla.Platform
 * @subpackage  HTML
 * @since       11.1
 */
abstract class JHtmlString
{

	public static function truncate($text, $length = 0)
	{
		// Truncate the item text if it is too long.
		if ($length > 0 && JString::strlen($text) > $length)
		{
			// Find the first space within the allowed length.
			$tmp = JString::substr($text, 0, $length);
			$offset = JString::strrpos($tmp, ' ');
			if(JString::strrpos($tmp, '<') > JString::strrpos($tmp, '>'))
			{
				$offset = JString::strrpos($tmp, '<');
			}
			$tmp = JString::substr($tmp, 0, $offset);

			// If we don't have 3 characters of room, go to the second space within the limit.
			if (JString::strlen($tmp) >= $length - 3) {
				$tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));
			}

			// Put all opened tags into an array
			preg_match_all ( "#<([a-z][a-z0-9]?)( .*)?(?!/)>#iU", $tmp, $result );
			$openedtags = $result[1];
			$openedtags = array_diff($openedtags, array("img", "hr", "br"));
			$openedtags = array_values($openedtags);

			// Put all closed tags into an array
			preg_match_all ( "#</([a-z]+)>#iU", $tmp, $result );
			$closedtags = $result[1];
			$len_opened = count ( $openedtags );
			// All tags are closed
			if( count ( $closedtags ) == $len_opened )
			{
				return $tmp.'...';
			}
			$openedtags = array_reverse ( $openedtags );
			// Close tags
			for( $i = 0; $i < $len_opened; $i++ )
			{
				if ( !in_array ( $openedtags[$i], $closedtags ) )
				{
					$tmp .= "</" . $openedtags[$i] . ">";
				} else {
					unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
				}
			}
			$text = $tmp.'...';
		}

		return $text;
	}

}