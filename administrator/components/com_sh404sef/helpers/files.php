<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: files.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperFiles {

  public static $stringDelimiter = '"';
  public static $fieldDelimiter = ',';
  /**
   * Append some data to an existing file
   *
   * Joomla JFile::write() cannot append, as this would not
   * be compatible with FTP layer
   *
   * @param string $file the full path file name
   * @param string $data data to append
   */
  public function appendToFile( $filename, $data) {

    $status = false;

    // nothing to do
    if (empty( $filename)) {
      return $status;
    }

    // open file for writing
    $handle = fopen($filename, 'a');
    if (!$handle) {
      return $status;
    }

    // write data
    $status = fwrite( $handle, $data);

    // close before the end
    $status = $status && fclose( $handle);

    // return result
    return $status;
  }

  public function createFileName( $filename, $type = '') {

    // if pre-existing, use it
    if (!empty( $filename)) {
      return $filename;
    }

    jimport( 'joomla.utilities.utility');

    // check if one was passed in query
    $filename = base64_decode(JRequest::getString( 'filename'));

    if (empty( $filename)) {
      // need to create and store a unique file name
      $name = $type . '.' . JUtility::getToken( $forceNew = true);

      // create the fully pathed file name
      $filename = self::getTempPath() . DS . $name . '.' . time() . '.dat';
    }

    return $filename;

  }

  /**
   * Delete a group of file in a temp directory
   *
   * File name format MUST be :  $baseName.XXXXXXXXX.123456789.dat
   *
   * 12345679 is a Unix timestamp, used to determine if file is old enough to be deleted
   *
   * @param string $baseName the file set base name
   * @param string $basePath optional path
   * @param integer $olderThan delete only files older than so many seconds
   */
  public function purgeTempFiles( $baseName, $basePath = '', $olderThan = 60) {

    if (empty( $baseName)) {
      return;
    }

    // find base path
    $basePath = empty( $basePath) ? self::getTempPath() . DS : $basePath . DS;

    // get a list of files that match baseName
    jimport('joomla.filesystem. folder');
    $filter =  preg_quote( $baseName);
    $fileList = JFolder::files( $basePath, '^' . $filter, $recurse = false, $fullpath = true);

    // delete them
    $now = time();
    if (!empty( $fileList)) {
      foreach ($fileList as $file) {
        $parts = explode( '.', JFile::getName( $file));
        // get the timestamp : first pop out extension, then comes the timestamp
        array_pop($parts);
        $timestamp = array_pop($parts);
        $age = $now - intval($timestamp);
        if ($age > $olderThan) {
          JFile::delete( $file);
        }
      }
    }
  }

  /**
   * Get current Joomla temporary path, unless
   * it does not exists, in which case
   * Joomla_root/tmp is returned, as it will most
   * likely exists, even in the case of
   * site moved from local to remote site
   */
  public function getTempPath() {

    static $_tempPath = null;

    if (is_null ($_tempPath)) {

      // find about Joomla temporary directory
      $app =& JFactory::getApplication();
      $tmpPath = $app->getCfg('tmp_path');

      // check it
      jimport( 'joomla.filesystem.folder');
      $_tempPath = JFolder::exists( $tmpPath) ? $tmpPath : JPATH_ROOT . DS . 'tmp';
    }

    return $_tempPath;
  }

  /**
   * Create a directory, and makes sure there is an index.html file in it
   *
   * @param string $path the full absolute path to the target dir
   */
  public static function createDirAndIndex( $path) {

    jimport( 'joomla.filesystem.path');
    $path = JPath::clean( $path, '/');
    $path = rtrim( $path, '/') . '/';
    
    // make sure dir exists
    jimport( 'joomla.filesystem.folder');
    JFolder::create( $path);

    // make sure we have an index.html file in the user directory
    jimport( 'joomla.filesystem.file');
    if(!JFile::exists($path . 'index.html')) {
      // copy one in there
      JFile::copy( sh404SEF_ADMIN_ABS_PATH . 'index.html', $path . 'index.html');
    }
  }

  /**
   * Format a numerical file size into a
   * human readable format
   *
   * From http://uk2.php.net/manual/de/features.file-upload.php#88591
   *
   * @param integer $filesize the numerical file size
   * @param integer $precision optional precision, default to 0
   */
  public function displayableFileSize( $filesize, $precision = 0) {

    $units = array('B', 'KB', 'MB', 'GB', 'GB');

    $filesize = max($filesize, 0);
    $pow = floor(($filesize ? log($filesize) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $filesize /= pow(1024, $pow);

    return round($filesize, $precision) . ' ' . $units[$pow];

  }

  /**
   * Convert a filesize as reported by ini_get into
   * a numerical value
   *
   * From http://de3.php.net/manual/en/function.ini-get.php
   *
   * @param string $filesize the file size
   */
  public function numericalFileSize( $filesize) {

    $filesize = trim($filesize);
    $unit = strtolower($filesize[strlen($filesize)-1]);
    switch($unit) {
      // The 'G' modifier is available since PHP 5.1.0
      case 'g':
        $filesize *= 1024;
      case 'm':
        $filesize *= 1024;
      case 'k':
        $filesize *= 1024;
    }

    return $filesize;
  }

  /**
   * Get current server maximum upload file size
   * @param boolean $asInteger, if true, return result as integer, else as a human readable string
   */
  public function getMaxUploadSize( $asInteger = false) {

    $postMaxSize = self::numericalFileSize(ini_get( 'post_max_size'));
    $uploadMaxFileSize = self::numericalFileSize( ini_get( 'upload_max_filesize'));
    $maxUploadSize = min( $postMaxSize, $uploadMaxFileSize);

    return $asInteger ? $maxUploadSize : self::displayableFileSize( $maxUploadSize);

  }

  /**
   * Force download by user of an existing file
   *
   * @param string $filename the file (fullpathed) name
   */
  public function triggerDownload( $filename, $displayName) {

    // required library
    jimport( 'joomla.filesystem.file');

    // get filesize
    $filesize = @ filesize( $filename);

    // output
    header ('Expires: 0');
    header ('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()) . ' GMT');
    header ('Pragma: public');
    header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header ('Accept-Ranges: bytes');
    header ('Content-Length: ' . $filesize);
    header ('Content-Type: Application/octet-stream');
    header ('Content-Disposition: attachment; filename="' . $displayName . '"');
    header ('Connection: close');
    ob_end_clean(); //flush any joomla stuff from the ouput buffer

    // read file content by chunks and send it
    $offset = 0;
    do {
      $chunk = JFile::read( $filename, $incpath = false, $amount = 81920, $chunksize = 8192, $offset);
      if ($chunk) {
        print $chunk;
        $offset += strlen( $chunk);
      }
    } while ($chunk);
     
    // die, to have file content sent
    jexit();
  }

  public function csvQuote( $string) {

    return str_replace( self::$stringDelimiter, self::$stringDelimiter.self::$stringDelimiter, $string);

  }

  public function csvUnquote( $string) {

    return str_replace( self::$stringDelimiter.self::$stringDelimiter, self::$stringDelimiter, $string);

  }
}