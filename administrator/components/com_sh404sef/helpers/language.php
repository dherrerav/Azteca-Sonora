<?php
/**
 *
 * @version   $Id: language.php 1814 2011-02-21 19:39:42Z silianacom-svn $
 * @copyright Copyright (C) 2010 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Sh404sefClassShdb is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Helper class to use extended Joomla! default database class: Sh404sefClassShdb
 *
 */

// Security check to ensure this file is being included by a parent file.
defined( '_JEXEC' ) or die;

class Sh404sefHelperLanguage {

  /**
   * Find a language family
   *
   * @param object $language a Joomla! language object
   * @return string a 2 or 3 characters language family code
   */
  public static function getFamily( $language = null) {


    if (!is_object($language)) {

      // get application db instance
      $language = JFactory::getLanguage();

    }

    $code = $language->get( 'lang');
    $bits = explode( '-', $code);
    return empty($bits[0]) ? 'en' : $bits[0];
  }

}