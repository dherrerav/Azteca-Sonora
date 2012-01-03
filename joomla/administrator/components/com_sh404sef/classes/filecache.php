<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: filecache.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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

//define('SH_SHOW_CACHE_STATS', 0);

/**
 * URL caching
 *
 * @author shumisha
 *
 */
class Sh404sefClassFilecache extends Sh404sefClassBasecache {

  protected $_newUrlsCache = array();
  protected $_newUrlsCacheCount = 0;
  protected $_cacheFilename = '';
  protected $_cacheFilefullpath = '';
  protected $_lockFilefullpath = '';
  protected $_cacheFileLocked = false;
  protected $_urlCacheRam = 0;
  protected $_lockTtl = 35; // usual exec time is 30sec

  protected $_fileHeader = '<?php // shCache : URL cache file for sh404SEF
// version %s    
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');
$shURLCacheCreationDate = %s;
';

  public function __construct( $config) {

    parent::__construct( $config);

    // init cache filename, must be unique per live site, in case of multisite
    $liveSite = str_replace( 'administrator/', '', JURI::base());
    $this->_cacheFilename =  'shCacheContent.' . md5( $liveSite);
    $this->_cacheFilefullpath = sh404SEF_FRONT_ABS_PATH . 'cache' . '/' . $this->_cacheFilename . '.php';
    $this->_lockFilefullpath = sh404SEF_FRONT_ABS_PATH . 'cache' . '/' . $this->_cacheFilename . '.shlock';

    // every now and then we clear the cache to let it refill with more recent data
    $this->_itsTimeToCheckTTL = mt_rand(1, SH404SEF_URL_CACHE_WRITES_TO_CHECK_TTL) == 1;

    // register method that will store urls created during
    // current page request into cache file
    if (!empty($this->_config->shUseURLCache)) {
      register_shutdown_function( array( $this, 'writeURLCacheToDisk'));
    }

  }

  public function getSefUrlFromCache( $nonSefUrl, & $sefUrl) {

    if (!$this->_config->shUseURLCache) {
      $sefUrl = null;
      $this->_urlCacheMisses += 1;
      return sh404SEF_URLTYPE_NONE;
    }

    // make sure cache is loaded, in case this method is called first
    $this->_loadURLCache();

    // no urls in cache, no need to go further
    if (empty($this->_urlCacheCount) && empty($this->_newUrlsCacheCount)) {
      $sefUrl = null;
      $this->_urlCacheMisses += 1;
      return sh404SEF_URLTYPE_NONE;
    }
    $key = md5( $nonSefUrl);
    if(!empty( $this->_urlCache[$key])) {
      $tmp = explode('#', $this->_urlCache[$key]);  // cache format : non-sef#sef#type
      $sefUrl = $tmp[1];
      _log('Retrieved SEF from disk cache : '.$sefUrl.' => '.html_entity_decode( $tmp[0], ENT_QUOTES).'('.$tmp[2].')');
      $this->_urlCacheHits += 1;
      return $tmp[2];
    }

    if(!empty( $this->_newUrlsCache[$key])) {
      $tmp = explode('#', $this->_newUrlsCache[$key]);  // cache format : non-sef#sef#type
      $sefUrl = $tmp[1];
      _log('Retrieved SEF from disk cache : '.$sefUrl.' => '.html_entity_decode( $tmp[0], ENT_QUOTES).'('.$tmp[2].')');
      $this->_urlCacheHits += 1;
      return $tmp[2];
    }

    $this->_urlCacheMisses += 1;
    $this->_urlCacheMissesList[] = $nonSefUrl;
    return sh404SEF_URLTYPE_NONE;

  }

  // fetch an URL from cache, return null if not found
  public function getNonSefUrlFromCache( $sefUrl, & $nonSefUrl) {

    if (!$this->_config->shUseURLCache) {
      $nonSefUrl = null;
      return sh404SEF_URLTYPE_NONE;
    }

    // make sure cache is loaded, in case this method is called first
    $this->_loadURLCache();

    // no urls in cache, no need to go further
    if (empty($this->_urlCacheCount) && empty($this->_newUrlsCacheCount)) {
      $nonSefUrl = null;
      return sh404SEF_URLTYPE_NONE;
    }

    // search for requested sef url in disk stored cache
    foreach( $this->_urlCache as $key => $value) {
      if (strpos( $value, $sefUrl) !== false) {
        $tmp = explode('#', $value);  // cache format : non-sef#sef#type
        $nonSef = html_entity_decode( $tmp[0], ENT_QUOTES);
        if ($sefUrl == $tmp[1]) {
          $nonSefUrl = $nonSef;
          _log('Retrieved Non SEF from disk cache : '.$nonSefUrl.' => '.$tmp[1].'('.$tmp[2].')');
          return $tmp[2];
        }
      }
    }
    // search also in urls waiting to be stored to disk
    foreach( $this->_newUrlsCache as $key => $value) {
      if (strpos( $value, $sefUrl) !== false) {
        $tmp = explode('#', $value);  // cache format : non-sef#sef#type
        $nonSef = html_entity_decode( $tmp[0], ENT_QUOTES);
        if ($sefUrl == $tmp[1]) {
          $nonSefUrl = $nonSef;
          _log('Retrieved Non SEF from mem cache : '.$nonSefUrl.' => '.$tmp[1].'('.$tmp[2].')');
          return $tmp[2];
        }
      }
    }
    return sh404SEF_URLTYPE_NONE;
  }

  public function addSefUrlToCache( $nonSefUrl, $sefUrl, $UrlType) {

    if (!$this->_config->shUseURLCache) {
      return null;
    }

    // make sure cache is loaded, in case this method is called first
    $this->_loadURLCache();

    // insertion key
    $key = md5( $nonSefUrl);

    // already there?
    if(!empty($this->_urlCache[$key]) || !empty( $this->_newUrlsCache[$key])) {
      return true;
    }

    if (($this->_urlCacheCount + $this->_newUrlsCacheCount) >= $this->_config->shMaxURLInCache) {
      return null;  // v 1.2.4.c added total cache size control
    }
    // Filter out non sef url which include &mosmsg, as I don't want to have a cache entry for every single msg
    // that can be thrown at me, including every 404 error
    if (strpos(strtolower($nonSefUrl), '&mosmsg')) {
      return null;
    }

    // new cache format : non-sef#sef#type
    $this->_newUrlsCache[md5($nonSefUrl)] = htmlentities( $nonSefUrl, ENT_QUOTES).'#'.$sefUrl.'#'.$UrlType;
    _log('Adding to URL cache : '.$sefUrl.' <= '.$nonSefUrl);
    $this->_newUrlsCacheCount++;
    return true;
  }

  public function removeUrlFromCache( $nonSefUrlList) {

    if (!$this->_config->shUseURLCache || empty($nonSefUrlList)) {
      return null;
    }

    // make sure cache is loaded, in case this method is called first
    $this->_loadURLCache();

    $foundInDiskCache = false;
    $foundInMemCache = false;
    foreach ($nonSefUrlList as $nonSefURL) {
      if (!empty($this->_newUrlsCache)) {
        foreach ($this->_newUrlsCache as $key => $cacheItem) { // look up in memory cache
          $tmp = explode('#', $cacheItem);
          $cacheNonSef = html_entity_decode( $tmp[0], ENT_QUOTES);
          if ($cacheNonSef == $nonSefURL) {
            unset($this->_newUrlsCache[$key]);
            $this->_newUrlsCacheCount--;
            $foundInMemCache = true;
          }
        }
      }

      // TODO: rewrite using md5 key
      if (!empty($this->_urlCache)) {
        foreach ($this->_urlCache as $key => $cacheItem) {  // look up disk cache
          $tmp = explode('#', $cacheItem);
          $cacheNonSef = html_entity_decode( $tmp[0], ENT_QUOTES);
          if ($cacheNonSef == $nonSefURL) {
            unset($this->_urlCache[$key]);
            $this->_urlCacheCount--;
            $foundInDiskCache = true;
          }
        }
      }
    }
    if ($foundInMemCache) {
      $this->_newUrlsCache = array_values($this->_newUrlsCache); // simply reindex mem cache
      return;
    }
    if ($foundInDiskCache) { // we need to remove these url from the disk cache file
      // to make it simpler, I simply rewrite the complete file
      $this->_newUrlsCache = (empty($this->_newUrlsCache) ?
      array_values($this->_urlCache)
      :array_merge($this->_urlCache, $this->_newUrlsCache));
      $this->_urlCache = array();  // don't need disk cache anymore, as all URL are in mem cache
      // so we remove both on disk cache and in memory copy of on disk cache
      $this->purge();
      // no need to write new URL list in disk file, as this will be done automatically at shutdown
    }
  }


  public function writeURLCacheToDisk() {

    // If we acquired lock at page load, we can write
    if (count($this->_newUrlsCache) && $this->_cacheFileLocked) {
      $cache = '';
      $now = time();
      if (!file_exists($this->_cacheFilefullpath)) {
        $cache = sprintf( $this->_fileHeader, $this->_config->version, $now);
        $this->_urlCacheCreationDate = $now;
      } else {
        // check cache TTL
        if (empty($this->_urlCacheCreationDate)){  // file exists, but creation date is missing : we are upgrading from a previous version
          $status = stat($this->_cacheFilefullpath);  // lets's read from file status : use last change date as creation date
          if (!empty($status)) {
            $this->_urlCacheCreationDate = $status[9];
          }
        }
        if (SH404SEF_URL_CACHE_TTL && $this->_itsTimeToCheckTTL) { // probability = 1/SH404SEF_WRITES_TO_CLEAN_LOGS
          if (!empty($this->_urlCacheCreationDate)){  // if we have a valid creation date, check  TTL
            if (($now-$this->_urlCacheCreationDate) > SH404SEF_URL_CACHE_TTL*86400) { // cache must be cleared
              $this->_urlCache = array();
              unlink($this->_cacheFilefullpath);
              $this->_urlCacheCreationDate = $now;
              $cache = sprintf( $this->_fileHeader, $this->_config->version, $now);
            }
          }
        }
      }
      $count = count( $this->_urlCache);
      $cache .= $this->_varExport( $this->_newUrlsCache, $count); // only need to write memory cache, ie: those URL added since last read of cache from disk
      $cache .= "\n".'$shURLCacheCreationDate='.$now.';';
      $cacheFile = fopen( $this->_cacheFilefullpath,'ab');
      if ($cacheFile) {
        fwrite( $cacheFile, $cache);
        fclose( $cacheFile);
      }

    }

    // in any case, release lock to file
    $this->_releaseLock();
  }

  public function purge( $allCaches = true) {

    jimport( 'joomla.filesystem.file');
    if($allCaches) {
      // delete all sh404SEF cache files in the dir
      // so as to clear also potential https, or alternate domains caches
      jimport( 'joomla.filesystem.folder');
      $files = JFolder::files( sh404SEF_FRONT_ABS_PATH . 'cache', 'shCacheContent\.', $recurse = false, $fullpath = true);
      if(!empty( $files)) {
        foreach( $files as $file) {
          if (JFile::exists( $file)) {
            JFile::delete( $file);
          }
        }
      }
    } else {
      // only delete cache for current live site url
      if (JFile::exists( $this->_cacheFilefullpath)) {
        JFile::delete( $this->_cacheFilefullpath);
      }
      if (JFile::exists( $this->_lockFilefullpath)) {
        JFile::delete( $this->_lockFilefullpath);
      }
    }
  }

  public function getCacheStats() {

    // collect basic data
    $out = parent::getCacheStats();

    // add urls waiting to be written
    $out .=  'In memory, waiting to be written  : '. $this->_newUrlsCacheCount . '<br />';

    // add ram usage of cached urls read from disk file
    // and stored in ram
    $out .=  'Ram used  : '. $this->_urlCacheRam . '<br />';

    return $out;
  }

  // load cached URL from disk into an array in memory
  protected function _loadURLCache() {

    static $shDiskCacheLoaded = false;

    if (!$shDiskCacheLoaded) {
      _log('Cache not loaded - trying to load '.$this->_cacheFilefullpath);
      if (file_exists( $this->_cacheFilefullpath)) {
        $startMem = function_exists('memory_get_usage')? memory_get_usage():'unavailable';
        _log('Including cache file (mem = '.$startMem.')');
        $this->_urlCache = array();
        // we try lock the cache file until the end of the request
        // so as to avoid other concurrent requests writing to it
        // while we have some pending data
        $this->_acquireLock();

        // read cache file content
        include($this->_cacheFilefullpath);
        $this->_urlCacheCreationDate = $shURLCacheCreationDate;

        $endMem = function_exists('memory_get_usage')? memory_get_usage():'unavailable';
        $this->_urlCacheRam = $startMem == 'unavailable' ? $startMem: $endMem - $startMem;
        $shDiskCacheLoaded = !empty($this->_urlCache);
        $this->_urlCacheCount = !empty($this->_urlCache) ? count($this->_urlCache) : 0;
        _log('Cache file included : '.($startMem == 'unavailable' ? $startMem: $endMem-$startMem).' bytes used, '.$this->_urlCacheCount.' URLs');
      } else {
        // cache file not there, create it
        $now = time();
        $cache = sprintf( $this->_fileHeader, $this->_config->version, $now);

        // lock cache file before using it
        if ( $this->_acquireLock()) {
          $cacheFile = fopen( $this->_cacheFilefullpath,'ab');
          if ($cacheFile) {
            fwrite( $cacheFile, $cache);
            fclose( $cacheFile);
          }
        }
        $this->_urlCache = array();
        $this->_urlCacheCount = 0;
        $shDiskCacheLoaded = true; // we don't want to try again if it failed first time
        $this->_urlCacheCreationDate = $now;
        _log('Cache file does not exists');
      }
    }
  }

  protected function _acquireLock() {

    $attempts = 0;
    $tryAgain = false;
    $now = time();
    do {
      // directly attempts to create the lock. If it fails, then element is already locked
      $handle = @fopen( $this->_lockFilefullpath, 'x');
      if ($handle) {
        // we could create file for writing, element is not locked.
        // store time, close and return
        $written = fwrite( $handle, $now);
        $closed  = fclose($handle);
        // return true if we could write the time stamp
        $this->_cacheFileLocked = !empty($written) && $closed;
        // we don't try again, even if we failed writing -> something is not working anyway
      } else {
        // we could not create lock file, element is already locked
        // by another process. Check for timeout
        // read lock file, and check TTL
        if ($this->_itsTimeToCheckTTL) {
          $lockTime = file_get_contents( $this->_lockFilefullpath);
          $lockTime = (int) trim( $lockTime);
          if (($now - $lockTime) > $this->_lockTtl) {
            // existing lock has timed out, we can release it
            $this->_cacheFileLocked = $this->_releaseLock();
          }
          // we have released the lock file, we can try again grabbing it
          // as we test also for _cacheFileLocked, this will happen only if the release was successful
          $tryAgain = true;
        }
      }
    } while (!$this->_cacheFileLocked && $tryAgain);

    return $this->_cacheFileLocked;
  }

  protected function _releaseLock() {

    if ($this->_cacheFileLocked) {
      jimport( 'joomla.filesystem.file');
      if (JFile::exists( $this->_lockFilefullpath)) {
        $this->_cacheFileLocked = !JFile::delete( $this->_lockFilefullpath);
      }
    }

    return $this->_cacheFileLocked;

  }

  protected function _varExport( $cache, $start) {

    // export content of array $cache, inserting a numeric key starting at $start
    $size = count( $cache);
    if (empty($size)) {
      return '';
    }
    $ret = '';

    foreach($cache as $key => $value) {  // use for instead of foreach to reduce memory usage
      $tmp = explode('#', $value);  // cache format : non-sef#sef#type
      $nonSef = html_entity_decode( $tmp[0], ENT_QUOTES);
      $ret .= "\n".'$this->_urlCache[\''.md5($nonSef).'\']=\''.$value.'\';';
    }

    return $ret;
  }

}
