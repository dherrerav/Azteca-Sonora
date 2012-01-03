<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: defines.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if (!defined('sh404SEF_ADMIN_ABS_PATH')) {
  define('sh404SEF_ADMIN_ABS_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
}
if (!defined('sh404SEF_ABS_PATH')) {
  define('sh404SEF_ABS_PATH', str_replace( '/administrator/components/com_sh404sef', '', sh404SEF_ADMIN_ABS_PATH) );
}
if (!defined('sh404SEF_FRONT_ABS_PATH')) {
  define('sh404SEF_FRONT_ABS_PATH', sh404SEF_ABS_PATH.'components/com_sh404sef/');
}

DEFINE ('SH404SEF_IS_INSTALLED', 1);

DEFINE ('sh404SEF_URLTYPE_404', -2);
DEFINE ('sh404SEF_URLTYPE_NONE', -1);
DEFINE ('sh404SEF_URLTYPE_AUTO', 0);
DEFINE ('sh404SEF_URLTYPE_CUSTOM', 1);
DEFINE ('sh404SEF_MAX_SEF_URL_LENGTH', 255);

DEFINE ('sh404SEF_HOMEPAGE_CODE', 'index.php?'.md5('sh404SEF Homepage url code'));

DEFINE ('SH404SEF_STANDARD_ADMIN', 1);  // define possible levels for adminstration complexity
DEFINE ('SH404SEF_ADVANCED_ADMIN', 2);

DEFINE ('sh404SEF_ANALYTICS_TIME_CUSTOM_VAR', 1);
DEFINE ('sh404SEF_ANALYTICS_USER_CUSTOM_VAR', 2);
