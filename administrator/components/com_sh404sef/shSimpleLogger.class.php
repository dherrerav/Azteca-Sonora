<?php
/**
 * SEO extension for Joomla! 1.6
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shSimpleLogger.class.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class shSimpleLogger {

  var $traceFileName = '';
  var $isActive = 0;
  var $logFile = null;

  function shSimpleLogger( $siteName, $basePath, $fileName, $isActive) {
    $sefConfig = Sh404sefFactory::getConfig();
    if (empty($isActive)) {
      $this->isActive = 0;
      return;
    } else $this->isActive = 1;
    $traceFileName = $basePath.$sefConfig->debugStartedAt.'.'.$fileName.'_'
    .str_replace('/','_',str_replace('http://', '', $siteName))
    .'.log';
    // Create file
    $fileIsThere = file_exists($traceFileName);
    $sep = "\t";
    if (!$fileIsThere) { // create file
      $fileHeader = 'sh404SEF trace file - created : '.$this->logTime()
      .' for '.$siteName."\n\n".str_repeat('-',25).' PHP Configuration '.str_repeat('-',25)."\n\n";
      $config = $this->parsePHPConfig();
      $line = str_repeat('-',69)."\n\n";
      // look for ob handlers, as we cannot use print_r from one (thanks Moovur !)
      $handlers = ob_list_handlers();
      $line .= "\nHandlers found : " . count( $handlers);
      if (!empty( $handlers)) {
        foreach( $handlers as $key => $handler) {
          $line .= "\nHandler " . ($key + 1) . ' : ' . $handler;
        }
      }
      $line .= "\n".str_repeat('-',69)."\n\n";
    } else $fileHeader = '';
    $file = fopen($traceFileName, 'ab');
    if ($file) {
      if (!empty($fileHeader)) {
        fWrite( $file, $fileHeader);
        fWrite( $file, print_r($config, true));
        fwrite( $file, $line);
      }
      $this->logFile = $file;
    } else {
      $this->isActive = 0;
      return;
    }
  }

  function logTime() {
    return date('Y-m-d')."\t".date('H:i:s');
  }

  function log($text, $data='') {
    if (empty($this->isActive) || empty($text)) return;
    // sometimes some system plugins can use the router. If we use
    // print_r in this situatation, this generates an error
    // Cannot use output buffering in output buffering display handlers
    // so we must check first that no handler is being used
    $logData = '';
    if (!empty( $data)) {
      $handlers = ob_list_handlers();
      if (empty( $handlers)) {
        $logData = ":\t".print_r($data, true);
      } else {
        // we can't use print_r
        if (is_object($data)) {
          $logData .= $this->logObject( $data);
        } else if (is_array($data)) {
          $logData .= ":\n";
          $logData .= $this->logArray( $data);
        } else {
          $logData .= ":\t".$data;
        }
      }
    }
    fWrite($this->logFile, $this->logTime()."\t".$text.$logData."\n");
  }

  function logObject( $object, $prefix = '  ') {

    $vars = get_object_vars( $object);
    if (empty( $vars)) {
      return '';
    }
    $ret = "\n{\n";
    $ret .= $this->logArray( $vars, $prefix);
    $ret .= "\n}\n";
    return $ret;
  }

  function logArray( $array, $prefix = '  ') {

    if (empty( $array)) {
      return '';
    }

    $ret = '{';
    foreach( $array as $key => $val) {
      if (is_array($val)) {
        $ret .= $this->logArray( $val, $prefix);
      }
      if (is_object($val)) {
        $ret .=  $this->logObject( $val, $prefix);
      }
      if (!is_array($val) && !is_object( $val)) {
        $ret .= "\n" . $prefix . $key . ' => ' . $val;
      }
    }
    $ret .= "\n}\n";
    return $ret;
  }

  function parsePHPConfig() {
    // by Andrew dot Boag at catalyst dot net dot nz
    // found on php.net doc

    ob_start();
    phpinfo(-1);
    $s = ob_get_contents();
    ob_end_clean();
    $a = $mtc = array();
    if (preg_match_all('/<tr><td class="e">(.*?)<\/td><td class="v">(.*?)<\/td>(:?<td class="v">(.*?)<\/td>)?<\/tr>/',$s,$mtc,PREG_SET_ORDER)){
      foreach($mtc as $v){
        if($v[2] == '<i>no value</i>') continue;
        $a[$v[1]] = $v[2];
      }
    }
    return $a;
  }
}
