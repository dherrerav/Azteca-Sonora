<?php
/**
 * @version		1.6.0.54 helpers/version.php
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		1.6.0
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

class j2xmlVersion
{
	/** @public static string Product */
	public static $PRODUCT	= 'J2XMLImporter';
	/** @public static int Main Release Level */
	public static $RELEASE	= '1.6';
	/** @public static int Sub Release Level */
	public static $DEV_LEVEL	= '0';
	/** @public static string Development Status */
	public static $DEV_STATUS	= '';
	/** @public static int build Number */
	public static $BUILD		= '54';
	/** @public static string Codename */
	public static $CODENAME	= 'Treglia';
	/** @public static string Copyright Text */
	public static $COPYRIGHT	= 'Copyright &copy; 2010-2011 Helios Ciancio <a href="http://www.eshiol.it" title="eshiol.it"><img src="components/com_j2xmlimporter/assets/images/eshiol.png" alt="eshiol.it" /></a>. All rights reserved.';
	/** @public static string License */
	public static $LICENSE	= '<a href="http://www.gnu.org/licenses/gpl-3.0.html">GNU GPL v3</a>';	
	/** @public static string URL */
	public static $URL		= '<a href="http://www.eshiol.it/j2xmlimporter.html">J2XMLImporter</a> is Free Software released under the GNU General Public License.';

	/**
	 * Method to get the long version information.
	 *
	 * @return	string	Long format version.
	 */
	public static function getLongVersion()
	{
		return self::$RELEASE .'.'. self::$DEV_LEVEL .' '
			. (self::$DEV_STATUS ? ' '.self::$DEV_STATUS : '')
			. ' build ' . self::$BUILD
			.' [ '.self::$CODENAME .' ] '
			;
	}

	/**
	 * Method to get the full version information.
	 *
	 * @return	string	version.
	 */
	public static function getFullVersion()
	{
		return self::$RELEASE 
			.'.'.self::$DEV_LEVEL
			. (self::$DEV_STATUS ? '-'.self::$DEV_STATUS : '')
			.'.'.self::$BUILD;
	}

	/**
	 * Method to get the short version information.
	 *
	 * @return	string	Short version format.
	 */
	public static function getShortVersion() {
		return self::$RELEASE .'.'. self::$DEV_LEVEL;
	}
}
