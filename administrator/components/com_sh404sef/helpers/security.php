<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: security.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperSecurity {

  public function updateSecStats() {
    $sefConfig = & Sh404sefFactory::getConfig();
    $shNum = 12*(intval(date('Y')) - 2000)+intval(date('m'));
    $shFileName = sh404SEF_ADMIN_ABS_PATH.'logs/'.date('Y').'-'.date('m').'-'.'sh404SEF_security_log.'.$shNum.'.log';
    $fileIsThere = file_exists($shFileName) && is_readable($shFileName);
    Sh404sefHelperSecurity::_shResetSecStats();
    if($fileIsThere) {
      Sh404sefHelperSecurity::_shReadSecStatsFromFile($shFileName);
    }
    $sefConfig->shSecCurMonth = date('M').'-'.date('Y');
    $sefConfig->shSecLastUpdated = time();
    // get a configuration model object
    $model = & JModel::getInstance( 'config', 'Sh404sefModel');
    if (is_callable( array( $model, 'save'))) {
      $model->save();
    }
  }

  private function _shResetSecStats() {
    $sefConfig = & Sh404sefFactory::getConfig();

    $sefConfig->shSecCurMonth = '';
    $sefConfig->shSecLastUpdated = '';
    $sefConfig->shSecTotalAttacks = 0;
    $sefConfig->shSecTotalConfigVars = 0;
    $sefConfig->shSecTotalBase64 = 0;
    $sefConfig->shSecTotalScripts = 0;
    $sefConfig->shSecTotalStandardVars = 0;
    $sefConfig->shSecTotalImgTxtCmd = 0;
    $sefConfig->shSecTotalIPDenied = 0;
    $sefConfig->shSecTotalUserAgentDenied = 0;
    $sefConfig->shSecTotalFlooding = 0;
    $sefConfig->shSecTotalPHP = 0;
    $sefConfig->shSecTotalPHPUserClicked = 0;
  }

  private function _shReadSecStatsFromFile( $shFileName) {
    $logFile=fopen( $shFileName,'r');
    if ($logFile) {
      while (!feof($logFile)) {
        $line = fgets($logFile, 4096);
        Sh404sefHelperSecurity::_shDecodeSecLogLine( $line);
      }
      fClose( $logFile);
    }
  }

  private function _shDecodeSecLogLine( $line) {
    $sefConfig = & Sh404sefFactory::getConfig();

    if (preg_match( '/[0-9]{2}\-[0-9]{2}\-[0-9]{2}/', $line)) { // this is not header or comment line
      $sefConfig->shSecTotalAttacks++;
      $bits = explode("\t", $line);
      switch (substr($bits[2],0, 15)) {
        case 'Flooding':
          $sefConfig->shSecTotalFlooding++;
          break;
        case 'Caught by Honey':
          $sefConfig->shSecTotalPHP++;
          break;
        case 'Honey Pot but u':
          $sefConfig->shSecTotalPHPUserClicked++;
          break;
        case 'Var not numeric':
        case 'Var not alpha-n':
        case 'Var contains ou':
          $sefConfig->shSecTotalStandardVars++;
          break;
        case 'Image file name':
          $sefConfig->shSecTotalImgTxtCmd++;
          break;
        case '<script> tag in':
          $sefConfig->shSecTotalScripts++;
          break;
        case 'Base 64 encoded':
          $sefConfig->shSecTotalBase64++;
          break;
        case 'mosConfig_var i':
          $sefConfig->shSecTotalConfigVars++;
          break;
        case 'Blacklisted IP':
          $sefConfig->shSecTotalIPDenied++;
          break;
        case 'Blacklisted use':
          $sefConfig->shSecTotalUserAgentDenied++;
          break;
        default:  // if not one of those, then it's a 404, don't count it as an attack
          $sefConfig->shSecTotalAttacks--;
          break;

      }
    }
  }

}