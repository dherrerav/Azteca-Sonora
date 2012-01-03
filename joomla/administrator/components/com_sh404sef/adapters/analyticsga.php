<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: analyticsga.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.application');

/**
 * Implement Google analytics handling
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterAnalyticsga extends Sh404sefClassBaseanalytics {

  protected $_snippet = "
  <script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{tracking_code}']);
  {customVar1}
  {customVar2}
  {customVar3}
  {customVar4}
  {customVar5}
  _gaq.push(['_trackPageview']);
  
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

  protected $_endPoint = 'https://www.google.com/analytics/feeds/';
  protected $_authPoint = 'https://www.google.com/accounts/ClientLogin';

  // specific data
  protected $_SID = '';
  protected $_LSID = '';


  /**
   * Set client object to perform request
   * for connection to analytics service
   *
   */
  protected function _prepareConnectRequest() {

    $hClient = & Sh404sefHelperAnalytics::getHttpClient();

    // set params
    $hClient->setUri( $this->_authPoint);
    $hClient->setConfig( array (
    'maxredirects' => 0
    , 'timeout' => 10));

    // request details
    $hClient->setMethod( Sh_Zend_Http_Client::POST);
    $hClient->setEncType( 'application/x-www-form-urlencoded');

    // request data
    $postData = array(
      'accountType' => 'GOOGLE'
      , 'Email' => $this->_config->analyticsUser
      , 'Passwd' => $this->_config->analyticsPassword
      , 'service' => 'analytics'
      , 'source' => JApplication::getCfg( 'sitename') . '-sh404sef-' . $this->_config->version
      );

      $hClient->setParameterPost( $postData);
  }

  /**
   *
   * Handle response from connect request
   *
   */
  protected function _handleConnectResponse( $response) {

    // check if authentified
    Sh404sefHelperAnalytics::verifyAuthResponse( $response);

    // we are authorized, collect Auth token from body
    $this->_extractAuthToken( $response->getBody());

    return true;
  }

  protected function _fetchAccountsList() {

    $hClient = & Sh404sefHelperAnalytics::getHttpClient();
    $hClient->resetParameters($clearAll = true);

    // set target API url
    $hClient->setUri( $this->_endPoint . 'accounts/default');

    // make sure we use GET
    $hClient->setMethod( Sh_Zend_Http_Client::GET);

    // set headers required by Google Analytics
    $headers = array(
      'GData-Version' => 2
    , 'Authorization' => 'GoogleLogin auth="' . $this->_Auth . '"'
    );

    $hClient->setHeaders( $headers);

    //perform request
    // establish connection with available methods
    $adapters = array( 'Sh_Zend_Http_Client_Adapter_Curl', 'Sh_Zend_Http_Client_Adapter_Socket');
    $rawResponse = null;

    // perform connect request
    foreach( $adapters as $adapter) {
      try {
        $hClient->setAdapter( $adapter);
        $response = $hClient->request();
        break;
      } catch (Exception $e) {  // need that to be Exception, so as to catch Sh_Zend_Exceptions.. as well
        // we failed, let's try another method
      }
    }

    // return if error
    if (empty( $response)) {
      $msg = 'unknown code';
      throw new Sh404sefExceptionDefault( JText::sprintf('COM_SH404SEF_ERROR_CHECKING_ANALYTICS', $msg));
    }
    if (empty( $response) || !is_object( $response) || $response->isError()) {
      $msg = method_exists( $response, 'getStatus') ? $response->getStatus() : 'unknown code';
      throw new Sh404sefExceptionDefault( JText::sprintf('COM_SH404SEF_ERROR_CHECKING_ANALYTICS', $msg));
    }

    // analyze response
    // check if authentified
    Sh404sefHelperAnalytics::verifyAuthResponse( $response);
    $xml = simplexml_load_string( $response->getBody());

    if (!empty( $xml->entry)) {
      foreach( $xml->entry as $entry) {
        $account = new StdClass();
        $accId = explode(':',(string)$entry->id);
        $account->id  = array_pop($accId);
        $account->title = (string)$entry->title;
        $this->_accounts[] = clone( $account);
      }
    }
  }


  /**
   * prepare html filters to allow user to select the way she likes
   * to view reports
   */
  protected function _prepareFilters() {

    // array to hold various filters
    $filters = array();

    // find if we must display all filters. On dashboard, only a reduced set
    $allFilters = $this->_options['showFilters'] == 'yes';

    // select account to retrieve data for (or rather, profile
    $customSubmit = ' onchange="shSetupAnalytics({' . ($allFilters ? '' : 'showFilters:\'no\'') . '});"';

    $select = Sh404sefHelperHtml::buildSelectList( $this->_accounts, $this->_options['accountId'], 'accountId', $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit );
    $filters[] = JText::_( 'COM_SH404SEF_ANALYTICS_ACCOUNT') . ':&nbsp;' . $select;

    // dashboard only has account selection, no room for anything else
    // only shows main selection drop downs on analytics view
    if ($allFilters) {
       
      // select start date
      $select = JHTML::_( 'calendar', $this->_options['startDate'], 'startDate', 'startDate', '%Y-%m-%d', 'class="textinput"');
      $filters[] = '&nbsp;' . JText::_( 'COM_SH404SEF_ANALYTICS_START_DATE') . ':&nbsp;' . $select;

      // select end date
      $select = JHTML::_( 'calendar', $this->_options['endDate'], 'endDate', 'endDate', '%Y-%m-%d', 'class="textinput"');
      $filters[] = '&nbsp;' . JText::_( 'COM_SH404SEF_ANALYTICS_END_DATE') . ':&nbsp;' . $select;

      // select groupBy (day, week, month)
      $select = Sh404sefHelperAnalytics::buildAnalyticsGroupBySelectList( $this->_options['groupBy'], 'groupBy', $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit);
      $filters[] = '&nbsp;' . JText::_( 'COM_SH404SEF_ANALYTICS_GROUP_BY') . ':&nbsp;' . $select;

      // add a click to update link
      $filters[] = '&nbsp;<a href="javascript: void(0);" onclick="javascript: shSetupAnalytics({forced:1' . ($allFilters ? '' : ',showFilters:\'no\'') . '});" > ['
      . JText::_('COM_SH404SEF_CHECK_ANALYTICS').']</a>';
    } else {

      // on dashboard, there is no date select, so we must display the date range
      $filters[] = '&nbsp;' . JText::_( 'COM_SH404SEF_ANALYTICS_DATE_RANGE') . '&nbsp;<div class="largertext">' . $this->_options['startDate'] . '&nbsp;&nbsp;>>&nbsp;&nbsp;' . $this->_options['endDate'] . '</div>';
    }
    return $filters;
  }


  protected function _extractAuthToken( $body) {

    $SID = explode( 'LSID=', $body);
    $this->_SID = trim( $SID[0]);
    $this->_SID = ltrim( $this->_SID, 'SID=');

    $LSID = explode( 'Auth=', $SID[1]);
    $this->_LSID = trim( $LSID[0]);

    $this->_Auth = trim( $LSID[1]);

  }
}