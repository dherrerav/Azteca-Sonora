<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: analytics.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperAnalytics {

  // store whether doing a forced update. Reason to store it
  // is to keep _doCheck() method w/o any parameters
  // as this would otherwise prevent caching from operating
  // normally
  private static $_options = false;

  /**
   * Obtain analytics information, as stored in cache
   * by checkAnalytics
   *
   */
  public function getData( $options) {

    // main option: are we forcing update, or only using the cached data ?
    $options['forced'] = empty( $options['forced']) ? 0 : $options['forced'];

    $sefConfig = Sh404sefFactory::getConfig();
    $dataTypeString = str_replace( 'ga:', '', $sefConfig->analyticsDashboardDataType);

    // store options
    self::$_options = $options;

    // create cache Id and get cache object
    $cacheId = md5( $dataTypeString . $options['accountId'] . $options['showFilters'] . $options['groupBy'] . $options['startDate'] . $options['endDate'] . $options['cpWidth'] . $options['report'] . $options['subrequest']);

    $cache = & JFactory::getCache( 'sh404sef_analytics');
    $cache->setLifetime( 3600); // cache result for 1 hours
    $cache->setCaching(1); // force caching on

    // empty cache if we are going to look for updates or if reports are disabled (so that next time
    // they enabled, we start wih fresh data
    if(self::$_options['forced'] || !$sefConfig->analyticsReportsEnabled) {
      // clean our cache
      $cache->remove( $cacheId);
    }

    $response = $cache->get( array( 'Sh404sefHelperAnalytics', '_doCheck'), $args = array(), $cacheId);

    // return response, either dummy or from cache
    return $response;

  }

  public function _doCheck() {

    jimport( 'joomla.error.profiler' );
    // creating the profiler object will start the counter
    $profiler =& JProfiler::getInstance( 'sh404sef_analytics_profiler' );

    // if not set to auto check and not forced to do so
    // when user click on "check updates" button
    // we don't actually try to get updates info
    $sefConfig = & Sh404sefFactory::getConfig();

    // check if allowed to auto check, w/o user clicking on button
    if (!$sefConfig->autoCheckNewAnalytics && !self::$_options['forced']) {
      // prepare a default response object
      $response = new stdClass();
      $response->status = true;
      $response->statusMessage = JText::_('COM_SH404SEF_CLICK_TO_CHECK_ANALYTICS');
      $response->note = '';
      return $response;
    }

    // calculate adapted class name
    $className = 'Sh404sefAdapterAnalytics' . strtolower( $sefConfig->analyticsType);
    $handler = new $className();

    // ask specialized class to fetch analytics data
    $response = $handler->fetchAnalytics( $sefConfig, self::$_options);

    // done; send response back
    return $response;
  }

  public function getHttpClient() {

    static $_instance = null;

    if (is_null( $_instance)) {
      // get an http client
      require_once sh404SEF_ADMIN_ABS_PATH . 'lib/Zend/Http/Client.php';
      $_instance = new Sh_Zend_Http_Client;

      // set params
      $_instance->setConfig( array (
    'maxredirects' => 0,
    'timeout' => 10));
      
    }

    return $_instance;
  }

  public function verifyAuthResponse( $response) {

    // check if valid response http code
    $status = $response->getStatus();
    if ($status != 200) {
      throw new Sh404sefExceptionDefault( JText::_('COM_SH404SEF_ERROR_AUTH_ANALYTICS'));
    }
  }

  public static function getRequestOptions( $context = '') {

    $options = array();

    // if showing filter, we're on the main analytics manager view
    $options['showFilters'] = JRequest::getCmd( 'showFilters', 'yes');

    // use that in the context where display options are stored, to differentiate
    // dashboard from analytics manager
    $context = empty( $context) ? 'sh404sef_analytics_' : $context;
    $context .= '_' . ( $options['showFilters'] == 'yes' ? 'manager' : 'dashboard');

    $options['forced'] = JRequest::getInt( 'forced', 0);
    $options['startDate'] = JRequest::getString( 'startDate', '');
    $options['endDate'] = JRequest::getString( 'endDate', '');
    $options['groupBy'] = JRequest::getString( 'groupBy', '');
    $options['cpWidth'] = JRequest::getInt( 'cpWidth');
    $options['report'] = JRequest::getCmd( 'report', 'dashboard');
    $options['subrequest'] = JRequest::getCmd( 'subrequest', '');

    // default max number of results
    $options['max-results'] = '100';

    // max out width for dashboard
    if ($options['report'] == 'dashboard' && $options['cpWidth'] > 800) {
      $options['cpWidth'] = 800;
    }

    // start and end dates
    $app = &JFactory::getApplication();

    // which web site to look at ?
    $options['accountId'] = $app->getUserstateFromRequest( $context . 'accountId', 'accountId', '', 'string');

    // if on dashboard, we use dates calculated from backend settings
    // else we use user set values (using calendar input boxes displayed
    // the Filters area
    if ($options['showFilters'] == 'yes') {
      // user selected dates, read user input
      $options['startDate'] = $app->getUserstateFromRequest( $context . 'startDate', 'startDate', '', 'string');
      $options['endDate'] = $app->getUserstateFromRequest( $context . 'endDate', 'endDate', '', 'string');
      $options['groupBy'] = $app->getUserstateFromRequest( $context . 'groupBy', 'groupBy', '', 'string');
      if(empty( $options['groupBy'])) {
        // default to grouping by day
        $options['groupBy'] = self::_getDefaultGroupBy();
      }
      $options['max-top-referrers'] = 15;
      $options['max-top-urls'] = 15;
    } else {
      $options['max-top-referrers'] = 5;
      $options['max-top-urls'] = 5;
    }

    if (empty( $options['startDate']) || empty( $options['endDate']) || $options['showFilters'] != 'yes') {
      // dashboard: calculate dates based on backend settings
      // end date is always yesterday
      $date = new DateTime( 'yesterday');
      $options['endDate'] = $date->format('Y-m-d');

      // use config to find what date range we should display : week, month or year
      $sefConfig = Sh404sefFactory::getConfig();
      $date->modify( '-1 ' . $sefConfig->analyticsDashboardDateRange);
      $options['startDate'] = $date->format('Y-m-d');

      // calculate groupBy options
      $options['groupBy'] = self::_getDefaultGroupBy();

    }

    return $options;

  }

  /**
   * Search for current site in account list, in order
   * to find its Google id. If not found, defaults to
   * first site in list
   * 
   * @param array of object $accounts
   */
  public static function getDefaultAccountId( $accounts) {

    $id = 0;
    if (!empty( $accounts)) {
      // search for current site
      $current = Sh404sefHelperAnalytics::getWebsiteName();
      foreach( $accounts as $account) {
        if ($account->title == $current or ($account->title == str_replace( 'www.', '', $current))) {
          $id = $account->id;
          break;
        }
      }
      // default to first account if no match found
      $id = empty( $id) ? $accounts[0]->id : $id;
    }

    return $id;
  }
  /**
   * Get this web site name, w/o scheme, port, etc
   *
   */
  public static function getWebsiteName() {

    static $site;

    // Get the scheme
    if(!isset($site))
    {
      $uri = & JURI::getInstance( JURI::base());
      $site = $uri->toString( array('host'));
    }

    return $site;
  }

  protected static function _getDefaultGroupBy() {

    $sefConfig = Sh404sefFactory::getConfig();
    switch ($sefConfig->analyticsDashboardDateRange) {
      default:
      case 'week':
        $groupBy = 'ga:year,ga:month,ga:week,ga:day';
        break;
      case 'month':
        $groupBy = 'ga:year,ga:month,ga:week';
        break;
      case 'year':
        $groupBy = 'ga:year,ga:month';
        break;
    }

    return $groupBy;
  }

  /**
   * Format an array of date strings for display as abscise
   * of a graphic
   *
   * @param array of object $entries
   * @param array $options
   */
  public function formatAbciseDates( $entries, $options) {

    // array to receive X labels
    $formattedDates = array();

    // various cases of dimensions requested
    switch( $options['groupBy']) {
      case 'ga:year,ga:month,ga:week,ga:day':
        // date string represents a day. we use : mm/dd
        foreach( $entries as $entry) {
          $formattedDates[] = self::_getShortMonthString( $entry->dimension['month']) . ' ' . $entry->dimension['day'];
        }
        break;
        // date string represents a week number
      case 'ga:year,ga:month,ga:week':
        foreach( $entries as $entry) {
          $formattedDates[] = self::_getWeekPeriodString( $entry->dimension);
        }
        break;
      case 'ga:year,ga:month':
        // date string is a month number
        foreach( $entries as $entry) {
          $formattedDates[] = self::_getShortMonthString( $entry->dimension['month']) . ' ' . substr( $entry->dimension['year'], 2, 2);
        }
        break;
    }

    return $formattedDates;
  }

  protected function _getShortMonthString( $month) {

    switch ($month) {
      case 1:
        $m = JText::_('JANUARY_SHORT');
        break;
      case 2:
        $m = JText::_('FEBRUARY_SHORT');
        break;
      case 3:
        $m = JText::_('MARCH_SHORT');
        break;
      case 4:
        $m = JText::_('APRIL_SHORT');
        break;
      case 5:
        $m = JText::_('MAY_SHORT');
        break;
      case 6:
        $m = JText::_('JUNE_SHORT');
        break;
      case 7:
        $m = JText::_('JULY_SHORT');
        break;
      case 8:
        $m = JText::_('AUGUST_SHORT');
        break;
      case 9:
        $m = JText::_('SEPTEMBER_SHORT');
        break;
      case 10:
        $m = JText::_('OCTOBER_SHORT');
        break;
      case 11:
        $m = JText::_('NOVEMBER_SHORT');
        break;
      case 12:
        $m = JText::_('DECEMBER_SHORT');
        break;

    }

    return $m;

  }

  protected function _getWeekPeriodString ( $dimension) {

    // start jan 1st of that year
    $date = new DateTime ( $dimension['year'] . '-01-01');

    // what day of week is that ?
    $janFirst = $date->format( 'w');

    // if not a Sunday, we have at partial first week of year
    if ($janFirst != 0) {
      // jan first is not a Sunday, first add days for this first partial week
      $days = 6 - $janFirst;

      // then add days corresponding to the remaining number of weeks
      if ($dimension['week'] > 1) {
        $days += 7 * ($dimension['week']-1);
      }

    } else {
      // jan first is a sunday, we add 7 x number of weeks to jan first
      // to find date of LAST day of week #XX
      $days = 7 * $dimension['week'] -1;
    }

    // add as many days as required to find LAST day of week
    $date->modify( '+' . $days . ' days');

    // then format result as needed
    $string = self::_getShortMonthString( $date->format( 'm')) . ' ' . $date->format( 'd');

    return $string;
  }

  /**
   * Calculates a displayable label for Google raw medium type
   */
  public static function getReferralLabel( $rawReferralType) {

    switch ($rawReferralType) {

      case '(none)':
        $label = JText::_('COM_SH404SEF_ANALYTICS_REF_LABEL_DIRECT');
        break;
      case 'organic':
        $label = JText::_('COM_SH404SEF_ANALYTICS_REF_LABEL_ORGANIC');
        break;
      case 'referral':
        $label = JText::_('COM_SH404SEF_ANALYTICS_REF_LABEL_REFERRAL');
        break;
      default:
        $label = $rawReferralType;
        break;
    }

    return $label;
  }

  public static function getDataTypeTitle() {

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();
    $dataType = $sefConfig->analyticsDashboardDataType;
    $dataTypeString = str_replace( 'ga:', '', $dataType);

    $label = JText::_( 'COM_SH404SEF_ANALYTICS_DATA_' . strtoupper( $dataTypeString));

    return $label;
  }

  /**
   * Method to create a select list of possible analytics reports
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  public static function buildAnalyticsReportSelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // available reports, should not be hardcoded though !
    $data = array(
    array( 'id' => 'dashboard', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_DASHBOARD'))
    ,array( 'id' => 'visits', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_VISITS'))
    ,array( 'id' => 'sources', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_SOURCES'))
    ,array( 'id' => 'keywords', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_KEYWORDS'))
    ,array( 'id' => 'urls', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_URLS'))
    ,array( 'id' => 'equipment', 'title' => JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_VISITORS_EQUIPMENT'))
    );

    // use helper to build html
    $list = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of possible ways to group data on analytics reports
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  public static function buildAnalyticsGroupBySelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // available reports, should not be hardcoded though !
    $data = array(
    array( 'id' => 'ga:year,ga:month,ga:week,ga:day', 'title' => JText::_( 'Day'))
    ,array( 'id' => 'ga:year,ga:month,ga:week', 'title' => JText::_( 'Week'))
    ,array( 'id' => 'ga:year,ga:month', 'title' => JText::_( 'Month'))
    );

    // use helper to build html
    $list = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  public static function createTempFile( $basePath, $report) {

    // we use a temporary png file to display graphic

    // make sure we also have on in the base cache directory
    // compute filename, using current time, up to 1/100 of a sec
    $timestamp = floor(microtime(true) *100);
    $timestamp = str_replace( '.', '', $timestamp);
    $imageFileName =  str_replace( DS, '/', $basePath) . $timestamp . '.' . strtolower($report) .'.png';

    return $imageFileName;

  }

  /**
   * Remove all png files older than a set time in provided directory
   *
   * @param $basePath
   * @param $age en secondes
   */
  public function cleanReportsImageFiles( $basePath, $age = 300) {

    // collect all png files in that directory
    $fileList = JFolder::files( $basePath, '.png');

    // if any file, check them against age
    if (!empty( $fileList)) {
      // heure courante
      $timestamp = floor(microtime(true) *100)  ;
      $timestamp = str_replace( '.', '', $timestamp);

      // ajuster l'age en centième de secondes
      $age = $age * 100;

      // calculate oldest file we can accept
      $oldestAllowed = $timestamp - $age;

      // iterate over files and delete the old ones
      foreach( $fileList as $file) {

        // file name format : timestamp.type.png, ie: "123456789.visits.datatype.png"
        $bits = explode('.', $file);
        $ts = $bits[0];
        if ($ts < $oldestAllowed) {
          // remove that file
          jimport( 'joomla.filesystem.file');
          $deleted = JFile::delete( $basePath . $file );
        }
      }
    }
  }

  /**
   * Encode a time value, in seconds
   * to predefined numerical codes
   * using 6 bits (64 values)
   * @param float $time
   */
  public static function classifyTime( $time) {

    // default
    $time = floatval( $time);

    // break it down to classes
    if ($time < 4.95) {  // max value for that case is going to be 49
      // convert to 1/10th of second
      $time = round($time * 10); // ie 1.9 sec becomes 19
    } else if ($time < 6.0) {
      $time = 50;
    } else if ($time < 7) {
      $time = 51;
    } else if ($time < 8) {
      $time = 52;
    } else if ($time < 9) {
      $time = 53;
    } else if ($time < 10){
      $time = 54;
    } else if ($time < 11){
      $time = 55;
    } else if ($time < 12){
      $time = 56;
    } else if ($time < 13){
      $time = 57;
    } else if ($time < 14){
      $time = 58;
    } else if ($time < 15){
      $time = 59;
    } else if ($time < 20){
      $time = 60;
    } else if ($time < 25){
      $time = 61;
    } else if ($time < 30){
      $time = 62;
    } else {
      $time = 63;
    }

    return $time;
  }

  /**
   * Revert classification of page creation time
   * to get back approximate time from value range
   * encoded in analytics data
   *
   * @param integer $time code as per classification function
   */

  public static function declassifyTime( $time) {

    // break it down to classes
    if ($time < 50) {  // actual time in 1/10th of sec
      // convert back to secondd
      $time = $time / 10; // ie 1.9 sec becomes 19
    } else if ($time == 50) {  //
      $time = 5.5;
    } else if ($time == 51) {  //
      $time = 6.5;
    } else if ($time == 52) {  //
      $time = 7.5;
    } else if ($time == 53) {  //
      $time = 8.5;
    } else if ($time == 54) {  //
      $time = 9.5;
    } else if ($time == 55) {  //
      $time = 10.5;
    } else if ($time == 56) {  //
      $time = 11.5;
    } else if ($time == 57) {  //
      $time = 12.5;
    } else if ($time == 58) {  //
      $time = 13.5;
    } else if ($time == 59) {  //
      $time = 14.5;
    } else if ($time == 60) {  //
      $time = 17.5;
    } else if ($time == 61) {  //
      $time = 22.5;
    } else if ($time == 62) {  //
      $time = 27.5;
    } else {
      $time = 40.0; // default value if time exceeds 30 seconds
    }

    return $time;

  }


  /**
   * Classify memory consumption into predefined
   * value ranges, to encode it into only 16 values
   *
   * @param float $ram ram used up by page creation
   */
  public static function classifyMemory( $ram) {

    // default
    $ram = floatval( $ram);

    // break it down to classes
    if ($ram < 6) {
      $ram = 0;
    } else if ($ram < 8) {
      $ram = 1;
    } else if ($ram < 10) {
      $ram = 2;
    } else if ($ram < 12) {
      $ram = 3;
    } else if ($ram < 14) {
      $ram = 4;
    } else if ($ram < 16) {
      $ram = 5;
    } else if ($ram < 18) {
      $ram = 6;
    } else if ($ram < 20) {
      $ram = 7;
    } else if ($ram < 22) {
      $ram = 8;
    } else if ($ram < 24) {
      $ram = 9;
    } else if ($ram < 28) {
      $ram = 10;
    } else if ($ram < 32) {
      $ram = 11;
    } else if ($ram < 48) {
      $ram = 12;
    } else if ($ram < 64) {
      $ram = 13;
    } else if ($ram < 128) {
      $ram = 14;
    } else {
      $ram = 15;
    }

    return $ram;
  }

  /**
   * Revert classification of ram consumption
   * to get back approximate memory from value range
   * encoded in analytics data
   *
   * @param integer $ram code as per classification function
   */
  public static function declassifyMemory( $ram) {

    $ramValues = array(3, 7, 9, 11, 13, 15, 17, 19, 21, 23, 26, 30, 40, 56, 96, 128);

    if (isset( $ramValues[$ram])) {
      $ram = $ramValues[$ram];
    } else {
      $ram = 0;
    }

    return $ram;
  }

}