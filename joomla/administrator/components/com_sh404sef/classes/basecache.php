<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: basecache.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if (!defined('sh404SEF_FRONT_ABS_PATH')) {
  define('sh404SEF_FRONT_ABS_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
}
if (!defined('sh404SEF_ABS_PATH')) {
  define('sh404SEF_ABS_PATH', str_replace( '/components/com_sh404sef', '', sh404SEF_FRONT_ABS_PATH) );
}
if (!defined('sh404SEF_ADMIN_ABS_PATH')) {
  define('sh404SEF_ADMIN_ABS_PATH', sh404SEF_ABS_PATH.'administrator/components/com_sh404sef/');
}

/**
 * URL caching
 *
 * @author shumisha
 *
 */
class Sh404sefClassBasecache {

  protected static $_instance = null;

  // general configuration
  protected $_config = null;

  // cache content
  protected $_urlCache = array();
  protected $_urlCacheCount = 0;
  protected $_urlCacheCreationDate = null;

  // cache stats
  protected $_urlCacheMisses = 0;
  protected $_urlCacheHits = 0;
  protected $_urlCacheMissesList = array();

  public function __construct( $config) {

    // store sef config
    $this->_config = $config;

  }

  // fetch an URL from cache, return null if not found
  public function getSefUrlFromCache( $nonSefUrl, & $sefUrl) {

    return sh404SEF_URLTYPE_NONE;

  }

  // fetch an URL from cache, return null if not found
  public function getNonSefUrlFromCache( $sefUrl, & $nonSefUrl) {

    return sh404SEF_URLTYPE_NONE;
  }

  public function addSefUrlToCache( $nonSefUrl, $sefUrl, $UrlType) {

    return null;

  }

  public function removeUrlFromCache( $nonSefUrlList) {

    return null;

  }

  public function purge() {

    return null;

  }


  public function getCacheStats() {

    $cacheTotal = $this->_urlCacheMisses+$this->_urlCacheHits;
    $out = 'Cache hits   : '. $this->_urlCacheHits . "  [".( !empty( $cacheTotal) ? (int)(100*$this->_urlCacheHits/$cacheTotal) . '%' : 'N/A') .']<br />';
    $out .= 'Cache misses : '. $this->_urlCacheMisses . "  [".( !empty( $cacheTotal) ? (int)(100*$this->_urlCacheMisses/$cacheTotal)  . '%' : 'N/A'). ']<br />';
    $out .=  'Cache total  : '. $cacheTotal . '<br />';
    $out .=  'In cache  : '. $this->_urlCacheCount . '<br />';
    $out .=  '<br /><br /><br />Misses list';
    foreach($this->_urlCacheMissesList as $url) {
      $out .=  '<pre>'.$url.'</pre><br />';
    }
    return $out;
  }

  protected function _varExport( $cache, $start) {

    return false;
  }



}
