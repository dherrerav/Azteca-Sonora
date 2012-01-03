<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: cache.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperCache {

  protected static function & _getInstance( $type = 'file') {

    static $_instance = null;

    if(empty( $_instance)) {

      // get global config
      $config = & Sh404sefFactory::getConfig();

      // instantiate object
      $className = 'Sh404sefClass' . $type . 'cache';
      $_instance = new $className( $config);
    }

    return $_instance;
  }

  public static function getSefUrlFromCache( $nonSefUrl, & $sefUrl) {

    try {
      $cache = &self::_getInstance();
      return $cache->getSefUrlFromCache( $nonSefUrl, $sefUrl);
    } catch (Exception $e) {
      // TODO: should decouple this result from sh404SEF constants
      return sh404SEF_UrlTYPE_NONE;
    }
  }

  public static function getNonSefUrlFromCache( $sefUrl, & $nonSefUrl) {

    try {
      $cache = &self::_getInstance();
      return $cache->getNonSefUrlFromCache( $sefUrl, $nonSefUrl);
    } catch (Exception $e) {
      // TODO: should decouple this result from sh404SEF constants
      return sh404SEF_UrlTYPE_NONE;
    }

  }

  public static function addSefUrlToCache( $nonSefUrl, $sefUrl, $UrlType) {

    try {
      $cache = &self::_getInstance();
      return $cache->addSefUrlToCache( $nonSefUrl, $sefUrl, $UrlType);
    } catch (Exception $e) {
      return null;
    }

  }

  public static function removeUrlFromCache( $nonSefUrlList) {

    try {
      $cache = &self::_getInstance();
      return $cache->removeUrlFromCache( $nonSefUrlList);
    } catch (Exception $e) {
      return null;
    }

  }

  public static function purge() {

    try {
      $cache = &self::_getInstance();
      return $cache->purge();
    } catch (Exception $e) {
      return null;
    }

  }

  public static function getCacheStats() {

    try {
      // get cache instance, assuming it was already created
      $cache = & self::_getInstance();

      return $cache->getCacheStats();

    } catch (Exception $e) {
      return '';
    }
  }

}