<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.raw.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewDefault extends JView {

  public function display( $tpl = null) {


    $layout = JRequest::getCmd( 'layout', 'default');

    switch ($layout) {

      case 'secstats':
        $this->_doSecStats($tpl);
        break;
      case 'updates':
        $this->_doUpdates($tpl);
        break;
      default:
        $this->_doDefault($tpl);
        break;

    }
  }

  private function _doDefault($tpl) {

    // declare docoument mime type
    $document = &JFactory::getDocument();
    $document->setMimeEncoding( 'text/xml');

    // call helper to prepare response xml file content
    $response = Sh404sefHelperGeneral::prepareAjaxResponse( $this);

    // echo it
    echo $response;

  }

  private function _doSecStats($tpl) {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // push security stats into view
    $this->_prepareSecStatsData();

    // push any message
    $error= $this->getError();
    if(empty($error)) {
      $noMsg= JRequest::getInt('noMsg', 0);
      if (empty( $noMsg)) {
        $this->assign( 'message', JText::_( 'COM_SH404SEF_ELEMENT_SAVED'));
      }
    }

    //$this->assign( 'errors', array( 'this is an error'));
    parent::display($tpl);

  }

  private function _prepareSecStatsData() {

    $sefConfig = & Sh404sefFactory::getConfig();

    // calculate security stats
    $default = empty($sefConfig->shSecLastUpdated) ? '- -' : '0';
    $shSecStats['curMonth'] = empty($sefConfig->shSecCurMonth) ? $default : $sefConfig->shSecCurMonth;
    if (empty($sefConfig->shSecLastUpdated)) {
      $shSecStats['lastUpdated'] = $default;
    } else {
      $shSecStats['lastUpdated'] = date('Y-m-d H:i:s', $sefConfig->shSecLastUpdated);
    }
    $monthStart = mktime(0,0,0,
    empty($sefConfig->shSecLastUpdated) ? 0: intval(date('m', $sefConfig->shSecLastUpdated)),
    1,
    empty($sefConfig->shSecLastUpdated) ? 0 : intval(date('Y', $sefConfig->shSecLastUpdated)) );
    $hours = $sefConfig->shSecLastUpdated == $monthStart ? 0.0001 : ($sefConfig->shSecLastUpdated - $monthStart)/3600;
    $shSecStats['totalAttacks'] = empty($sefConfig->shSecTotalAttacks) ? $default : $sefConfig->shSecTotalAttacks;
    $shSecStats['totalAttacksHrs'] = $shSecStats['totalAttacks']/$hours;
    $shSecStats['totalConfigVars'] = empty($sefConfig->shSecTotalConfigVars) ? $default : $sefConfig->shSecTotalConfigVars;
    $shSecStats['totalConfigVarsHrs'] = $shSecStats['totalConfigVars']/$hours;
    $shSecStats['totalBase64'] = empty($sefConfig->shSecTotalBase64) ? $default : $sefConfig->shSecTotalBase64;
    $shSecStats['totalBase64Hrs'] = $shSecStats['totalBase64']/$hours;
    $shSecStats['totalScripts'] = empty($sefConfig->shSecTotalScripts) ? $default : $sefConfig->shSecTotalScripts;
    $shSecStats['totalScriptsHrs'] = $shSecStats['totalScripts']/$hours;
    $shSecStats['totalStandardVars'] = empty($sefConfig->shSecTotalStandardVars) ? $default : $sefConfig->shSecTotalStandardVars;
    $shSecStats['totalStandardVarsHrs'] = $shSecStats['totalStandardVars']/$hours;
    $shSecStats['totalImgTxtCmd'] = empty($sefConfig->shSecTotalImgTxtCmd) ? $default : $sefConfig->shSecTotalImgTxtCmd;
    $shSecStats['totalImgTxtCmdHrs'] = $shSecStats['totalImgTxtCmd']/$hours;
    $shSecStats['totalIPDenied'] = empty($sefConfig->shSecTotalIPDenied) ? $default : $sefConfig->shSecTotalIPDenied;
    $shSecStats['totalIPDeniedHrs'] = $shSecStats['totalIPDenied']/$hours;
    $shSecStats['totalUserAgentDenied'] = empty($sefConfig->shSecTotalUserAgentDenied) ? $default : $sefConfig->shSecTotalUserAgentDenied;
    $shSecStats['totalUserAgentDeniedHrs'] = $shSecStats['totalUserAgentDenied']/$hours;
    $shSecStats['totalFlooding'] = empty($sefConfig->shSecTotalFlooding) ? $default : $sefConfig->shSecTotalFlooding;
    $shSecStats['totalFloodingHrs'] = $shSecStats['totalFlooding']/$hours;
    $shSecStats['totalPHP'] = empty($sefConfig->shSecTotalPHP) ? $default : $sefConfig->shSecTotalPHP;
    $shSecStats['totalPHPHrs'] = $shSecStats['totalPHP']/$hours;
    $shSecStats['totalPHPUserClicked'] = empty($sefConfig->shSecTotalPHPUserClicked) ? $default : $sefConfig->shSecTotalPHPUserClicked;
    $shSecStats['totalPHPUserClickedHrs'] = $shSecStats['totalPHPUserClicked']/$hours;
    if (!empty($sefConfig->shSecTotalAttacks)) {
      $shSecStats['totalConfigVarsPct'] = round($sefConfig->shSecTotalConfigVars/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalBase64Pct'] = round($sefConfig->shSecTotalBase64/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalScriptsPct'] = round($sefConfig->shSecTotalScripts/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalStandardVarsPct'] = round($sefConfig->shSecTotalStandardVars/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalImgTxtCmdPct'] = round($sefConfig->shSecTotalImgTxtCmd/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalIPDeniedPct'] = round($sefConfig->shSecTotalIPDenied/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalUserAgentDeniedPct'] = round($sefConfig->shSecTotalUserAgentDenied/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalFloodingPct'] = round($sefConfig->shSecTotalFlooding/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalPHPPct'] = round($sefConfig->shSecTotalPHP/$sefConfig->shSecTotalAttacks*100,1);
      $shSecStats['totalPHPUserClickedPct'] = round($sefConfig->shSecTotalPHPUserClicked/$sefConfig->shSecTotalAttacks*100,1);
    } else {
      $shSecStats['totalConfigVarsPct'] = 0;
      $shSecStats['totalBase64Pct'] = 0;
      $shSecStats['totalScriptsPct'] = 0;
      $shSecStats['totalStandardVarsPct'] = 0;
      $shSecStats['totalImgTxtCmdPct'] = 0;
      $shSecStats['totalIPDeniedPct'] = 0;
      $shSecStats['totalUserAgentDeniedPct'] = 0;
      $shSecStats['totalFloodingPct'] = 0;
      $shSecStats['totalPHPPct'] = 0;
      $shSecStats['totalPHPUserClickedPct'] = 0;
    }

    $this->assign( 'shSecStats', $shSecStats);

  }

  private function _doUpdates($tpl) {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // do we force reading updates from server ?
    $forced = JRequest::getInt( 'forced', 0);
    $versionsInfo = Sh404sefHelperUpdates::getUpdatesInfos( !empty($forced));

    // push security stats into view
    $this->assign( 'updates', $versionsInfo);

    // push any message
    $error= $this->getError();
    if(empty($error)) {
      $noMsg= JRequest::getInt('noMsg', 0);
      if (empty( $noMsg)) {
        $this->assign( 'message', JText::_( 'COM_SH404SEF_ELEMENT_SAVED'));
      }
    }

    parent::display($tpl);

  }

}
