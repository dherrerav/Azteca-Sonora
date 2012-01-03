<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: analyticsgareportdashboard.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * Implement Google analytics handling
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterAnalyticsgareportdashboard {


  // general SEF config, includes analytics details
  protected $_config = null;

  // option set, describes reports to be built
  protected $_options = null;

  // a http client, already setup
  protected $_client = null;

  // Authorization token, as provided by analytics supplier, when
  // we already tried to connect to the service
  // we would not be here if this failed
  protected $_Auth = null;

  // base url for queries
  protected $_endPoint = '';

  // raw response obtained from supplier
  protected $_rawData = null;

  // formated responsed object, ready to be used
  // to display report. This is not HTML or similar,
  // but simply PHP object/array data, ready
  // to be displayed, vs xml obtained from supplier
  protected $_formatedResponse = null;

  // path to charting library root dir
  private $_baseChartPath = '';

  /**
   * Constructor, simple init
   */
  public function __construct() {

    $this->_baseChartPath = sh404SEF_ADMIN_ABS_PATH . 'lib/pChart';

  }

  /**
   *
   * @param object $config
   * @param array $options
   * @param object $client
   */
  public function fetchData( $config, $options, $Auth, $endPoint) {

    // store parameters
    $this->_config = $config;
    $this->_options = $options;
    $this->_Auth = $Auth;
    $this->_endPoint = $endPoint;

    // get a http client
    $this->_client = & Sh404sefHelperAnalytics::getHttpClient();

    // response object
    $this->_formatedResponse = new stdClass();

    // read data from Google
    $this->_getData();

    // processing of global data always happens
    $this->_addFiguresVisits();

    // call methods to create each of the report sub parts
    switch ($this->_options['subrequest']) {

      case 'visits':
        // create a graph of visits
        $this->_formatedResponse->images['visits'] = $this->_createVisitsGraph();
        break;

      case 'sources':
        // create a graph of traffic sources
        $this->_formatedResponse->images['sources'] = $this->_createSourcesGraph();
        break;

      case 'perf':
        $this->_addCustomVars();
        break;

      case 'top5referrers':
        $this->_addFiguresReferrers();
        break;

      case 'top5urls':
        $this->_addFiguresUrls();

        break;

    }

    // send back to caller
    return $this->_formatedResponse;

  }

  /**
   * Make queries to Google API as needed
   * to collect data required to build report
   *
   * The final report page is built using several ajax calls. The main dashboard template
   * is first displayed, with only place holders for the various parts
   * The some javascript fired with the main dashboard display
   * performs several requests, or "subrequests", each asking for a specific set
   * of data or graphic
   * Reason for this is to speed things up, as the whole request-google-respond-prepare graph
   * can last 2 or 3 seconds. As there may be 6 or 7 requests, this adds up to more than 15 seconds
   * Using several ajax calls allow doing all the requests in parallel, and the total time is
   * not much longer than the time for the longest individual subrequest
   * On the contrary, some delay between subrequests has been introduced
   * as Google has/may refuse serving them if they exceed allowances, published as
   * 4 concurrent requests max
   * 10 req. per sec max
   *
   */
  protected function _getData() {

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();

    // set headers required by Google Analytics
    $headers = array(
      'GData-Version' => 2
    , 'Authorization' => 'GoogleLogin auth="' . $this->_Auth . '"'
    );

    $this->_client->setHeaders( $headers);

    // 0 . Global data, needed in all queries to calculate %

    // build uri as needed to retrieve required data
    $query = array( 'dimensions' => ''
    , 'metrics' => 'ga:pageviews,ga:visits,ga:visitors,ga:bounces,ga:entrances,ga:timeOnSite,ga:newVisits'
    , 'start-date' => $this->_options['startDate']
    , 'end-date' => $this->_options['endDate']
    );

    // use method to build the correct url
    $uri = $this->_buildQueryUri( $query);

    // set target API url
    $this->_client->setUri( $uri);

    // perform query
    $this->_query( 'global');

    // specific queries for each subrequest
    switch ( $this->_options['subrequest']) {

      case 'visits':

        // 1 . query pageviews and visits
        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => $this->_options['groupBy']
        , 'metrics' => $sefConfig->analyticsDashboardDataType
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );

        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'visits');

        break;

      case 'sources':

        // 2 . traffic sources

        // Google does not allow combining dimension=ga:medium with metric = unique visitors
        $metric = $sefConfig->analyticsDashboardDataType == 'ga:visitors' ?
        'ga:visits' : $sefConfig->analyticsDashboardDataType;

        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => 'ga:medium'
        , 'metrics' => $metric
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );

        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'sources');

        break;

      case 'perf':

        // 4 . Custom var : logged in users
        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => 'ga:customVarValue' . sh404SEF_ANALYTICS_USER_CUSTOM_VAR
        , 'metrics' => 'ga:pageviews'
        , 'sort' => '-ga:pageviews'
        , 'max-results' => '100'
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );


        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'logged-in-users');

        // 5 . Custom var : page creation time
        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => 'ga:customVarValue' . sh404SEF_ANALYTICS_TIME_CUSTOM_VAR
        , 'metrics' => 'ga:pageviews'
        , 'sort' => '-ga:pageviews'
        , 'max-results' => '512'
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );


        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'page-creation-time');

        break;

      case 'top5urls':

        // 6 . Top 5 urls
        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => 'ga:pagePath'
        , 'metrics' => 'ga:pageviews,ga:timeOnPage'
        , 'sort' => '-ga:pageviews'
        , 'max-results' => $this->_options['max-top-urls']
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );

        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'top5urls');

        break;

      case 'top5referrers':

        // 7 . Top 5 referrer

        // Google does not allow combining dimension=ga:medium with metric = unique visitors
        $metric = $sefConfig->analyticsDashboardDataType == 'ga:visitors' ?
        'ga:visits' : $sefConfig->analyticsDashboardDataType;

        // build uri as needed to retrieve required data
        $query = array( 'dimensions' => 'ga:source,ga:referralPath'
        , 'metrics' => $metric . ',ga:timeOnSite,ga:bounces,ga:newVisits'
        , 'sort' => '-' . $metric
        , 'max-results' => $this->_options['max-top-referrers']
        , 'start-date' => $this->_options['startDate']
        , 'end-date' => $this->_options['endDate']
        );


        // use method to build the correct url
        $uri = $this->_buildQueryUri( $query);

        // set target API url
        $this->_client->setUri( $uri);

        // perform query
        $this->_query( 'top5referrers');

        break;

    }

  }

  protected function _addFiguresVisits() {

    if (!empty($this->_rawData['global'][0])) {
      $this->_formatedResponse->global = $this->_rawData['global'][0];
      $this->_formatedResponse->global->bounceRate = empty($this->_formatedResponse->global->entrances) ? 0 : $this->_formatedResponse->global->bounces / $this->_formatedResponse->global->entrances;
      $this->_formatedResponse->global->avgTimeOnSite = empty($this->_formatedResponse->global->visits) ? 0 : $this->_formatedResponse->global->timeOnSite / $this->_formatedResponse->global->visits;
      $this->_formatedResponse->global->newVisitsPerCent = empty($this->_formatedResponse->global->visits) ? 0 : $this->_formatedResponse->global->newVisits / $this->_formatedResponse->global->visits;
      $this->_formatedResponse->global->pagesPerVisit = empty($this->_formatedResponse->global->visits) ? 0 : $this->_formatedResponse->global->pageviews / $this->_formatedResponse->global->visits;
    } else {
      $this->_formatedResponse->global->visits = 0;
      $this->_formatedResponse->global->visitors = 0;
      $this->_formatedResponse->global->pageviews = 0;
      $this->_formatedResponse->global->bounceRate = 0;
      $this->_formatedResponse->global->avgTimeOnSite = 0;
      $this->_formatedResponse->global->newVisitsPerCent = 0;
      $this->_formatedResponse->global->pagesPerVisit = 0;
    }
  }

  protected function _addFiguresUrls() {

    $this->_formatedResponse->top5urls = array();
    foreach( $this->_rawData['top5urls'] as $entry) {
      $entry->avgTimeOnPage = empty($entry->pageviews) ? 0 : $entry->timeOnPage / $entry->pageviews;
      $entry->pageviewsPerCent = empty($this->_formatedResponse->global->pageviews) ? 0 : $entry->pageviews / $this->_formatedResponse->global->pageviews;
      $this->_formatedResponse->top5urls[] = $entry;
    }

  }

  protected function _addFiguresReferrers() {

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();
    // Google does not allow combining dimension=ga:medium with metric = unique visitors
    $metric = $sefConfig->analyticsDashboardDataType == 'ga:visitors' ?
        'ga:visits' : $sefConfig->analyticsDashboardDataType;

    $dataTypeString = str_replace( 'ga:', '', $metric);

    $this->_formatedResponse->top5referrers = array();
    foreach( $this->_rawData['top5referrers'] as $entry) {
      $entry->views = $entry->$dataTypeString;
      $entry->avgTimeOnSite = empty($entry->$dataTypeString) ? 0 : $entry->timeOnSite / $entry->$dataTypeString;
      $entry->bounceRate = empty($entry->$dataTypeString) ? 0 : $entry->bounces / $entry->$dataTypeString;
      $entry->viewsPerCent = empty($this->_formatedResponse->global->$dataTypeString) ? 0 : $entry->$dataTypeString / $this->_formatedResponse->global->$dataTypeString;
      $this->_formatedResponse->top5referrers[] = $entry;
    }


  }

  protected function _addCustomVars() {

    $this->_formatedResponse->perf = new stdClass();

    // prepare time and memory calculation
    $field = 'customVarValue' . sh404SEF_ANALYTICS_TIME_CUSTOM_VAR;
    $totalPages = 0;
    $totalTime = 0;
    $totalMemory = 0;

    // now iterate over time and memory records
    foreach( $this->_rawData['page-creation-time'] as $entry) {
      $record = intval( $entry->dimension[$field]);  // make it an int, this will remove dev data that had decimals

      // sanitize
      $record = $record < 3 ? 0 : $record;

      // we only calculate averaged on pages we have time and ram data for
      if (!empty( $record)) {
        // separate time and memory
        $time = $record >> 4;  // bits 5 and up
        $memory = $record & 15; // bits 1 to 4

        // aggregate
        $totalPages += $entry->pageviews;
        $totalTime += Sh404sefHelperAnalytics::declassifyTime( $time) * $entry->pageviews;
        $totalMemory += Sh404sefHelperAnalytics::declassifyMemory( $memory) * $entry->pageviews;

      }
    }

    // calculate averages time and ram now
    $this->_formatedResponse->perf->avgPageCreationTime = empty($totalPages) ? 0 : $totalTime / $totalPages;
    $this->_formatedResponse->perf->avgMemoryUsed = empty($totalPages) ? 0 : $totalMemory / $totalPages;

    // logged in users handling
    $field = 'customVarValue' . sh404SEF_ANALYTICS_USER_CUSTOM_VAR;
    $groups = Sh404sefHelperGeneral::getUserGroups();
    $loggedInPages = 0;
    foreach( $this->_rawData['logged-in-users'] as $entry) {
      $userType = urldecode( $entry->dimension[$field]);
      // if user was logged in, any group, including "Public Frontend"
      if (in_array( $userType, $groups)) {
        // include # of pages
        $loggedInPages += $entry->pageviews;
      }
    }

    $this->_formatedResponse->perf->loggedInUserRate = empty($this->_formatedResponse->global->pageviews) ? 0 : $loggedInPages / $this->_formatedResponse->global->pageviews;

  }


  protected function _createVisitsGraph() {

    // load pChart graphic library
    $this->_loadLibs();

    // définition des données à afficher
    $dataSet = new pData();

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();
    $dataTypeString = str_replace( 'ga:', '', $sefConfig->analyticsDashboardDataType);

    // get data from response
    $data = array();
    $maxY = 0;
    foreach( $this->_rawData['visits'] as $entry) {
      $data[] = $entry->$dataTypeString;
      if($entry->$dataTypeString > $maxY) {
        $maxY = $entry->$dataTypeString;
      }
    }

    // format dates
    $dates = Sh404sefHelperAnalytics::formatAbciseDates( $this->_rawData['visits'], $this->_options);

    $dataSet->AddPoint($data, $dataTypeString);
    $dataSet->AddPoint($dates,"dates");
    $dataSet->addSerie($dataTypeString);
    $dataSet->SetAbsciseLabelSerie("dates");
    $label = JText::_( 'COM_SH404SEF_ANALYTICS_DATA_' . strtoupper( $dataTypeString));
    $dataSet->SetSerieName( $label, $dataTypeString);

    // Initialise the graph
    $w = $this->_options['cpWidth'];
    $w = empty( $w) ? 400 : intval($w - 40);
    $h = 225;
    $centreX = intval(0.50 * $w);
    $centreY = intval(0.5 * $h);
    $chart = new pChart( $w, $h);
    $fontSize = 8;
    // calculate left margin based on max value to display
    $leftMargin = 20 + $fontSize + 20 + $fontSize * strlen( $maxY);
    $bottomMargin = 5 + $fontSize * 6;

    switch ($this->_options['groupBy']) {
      case 'ga:year,ga:month,ga:week,ga:day':
        $YAxisName = JText::_( 'Day');
        break;
        // date string represents a week number
      case 'ga:year,ga:month,ga:week':
        $YAxisName = JText::_( 'Week');
        break;
      case 'ga:year,ga:month':
        $YAxisName = JText::_( 'Month');
        break;
    }

    $dataSet->SetYAxisName( $label . JText::_('COM_SH404SEF_ANALYTICS_REPORT_PER_LABEL') . $YAxisName);
    $chart->setFontProperties( $this->_baseChartPath . DS .'Fonts/arial.ttf',$fontSize);
    $chart->setGraphArea( $leftMargin,30,$w-20,$h-$bottomMargin);
    $chart->drawFilledRoundedRectangle(7,7,$w-7,$h-7,5,240,240,240);
    $chart->drawRoundedRectangle(5,5,$w-5,$h-5,5,230,230,230);
    $chart->drawGraphArea(255,255,255,TRUE);
    $d = $dataSet->GetData();
    if (!empty( $d)) {
      $chart->drawScale($d,$dataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,60,0, false);
      $chart->drawGrid(4,TRUE,230,230,230,50);

      // Draw the 0 line
      $chart->setFontProperties( $this->_baseChartPath . DS .'Fonts/arial.ttf',$fontSize);

      $chart->drawTreshold(0,143,55,72,TRUE,TRUE);

      // Draw the line graph
      $chart->drawLineGraph($d,$dataSet->GetDataDescription());
      $chart->drawPlotGraph($d, $dataSet->GetDataDescription(),3,2,255,255,255);
    }

    // create a temporary file for
    $user = &JFactory::getUser();

    // make sure the root tmp dir exists
    $rootDir = 'tmp' . DS . 'sh404sef_analytics';
    Sh404sefHelperFiles::createDirAndIndex( JPATH_ROOT . DS . $rootDir);

    // file name is per user
    $basePath = $rootDir . DS . md5( 'useless_' . $user->id . '_hashing') . DS;

    // create path and make sure there's an index.html file in it
    Sh404sefHelperFiles::createDirAndIndex( JPATH_ROOT . DS . $basePath);

    $imageFileName = Sh404sefHelperAnalytics::createTempFile( $basePath, $this->_options['report'] . '.' . $this->_options['accountId'] . '.visits.' . $dataTypeString);
    $chart->Render( JPATH_ROOT. DS . $imageFileName);

    // need cleaning up, so let's remove all report files for that user older than an hour or so
    Sh404sefHelperAnalytics::cleanReportsImageFiles( JPATH_ROOT . DS . $basePath, $age = 4000);

    return JURI::root() . $imageFileName;
  }

  protected function _createSourcesGraph() {

    // load pChart graphic library
    $this->_loadLibs();

    // définition des données à afficher
    $dataSet = new pData();

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();

    // Google does not allow combining dimension=ga:medium with metric = unique visitors
    $dataType = $sefConfig->analyticsDashboardDataType == 'ga:visitors' ?
        'ga:visits' : $sefConfig->analyticsDashboardDataType;
    $dataTypeString = str_replace( 'ga:', '', $dataType);

    // sort data for proper display
    usort( $this->_rawData['sources'], array($this, '_sortSourcesDataCompareFunction'));

    // we walk the array, pulling out alternatively
    // the first and last items
    // making the new array having the largest item
    // followed by the smallest, then second largest
    // then second smallest, ...
    // which makes drawing labels much easier
    $tmpArray = array();
    $even = false;
    $max = count($this->_rawData['sources']);
    for( $i = 0; $i < $max; $i++) {
      if ($even) {
        // pull last item in sorted array
        $tmpArray[] = array_pop( $this->_rawData['sources']);
      } else {
        // pull array first item
        $tmpArray[] = array_shift( $this->_rawData['sources']);
      }
      // flag inversion
      $even = !$even;
    };

    // get data from response
    $data = array();
    $types = array();
    foreach( $tmpArray as $entry) {
      $value = $entry->$dataTypeString;
      // do not add empty values, as pChart would choke on that and display a warning
      if( !empty($value)) {
        $data[] = $value;
        $types[] = Sh404sefHelperAnalytics::getReferralLabel( $entry->dimension['medium']);
      }
    }

    $dataSet->AddPoint( $data,"visits");
    $dataSet->AddPoint( $types,"types");
    $dataSet->addSerie('visits');
    $dataSet->SetAbsciseLabelSerie("types");
    $label = JText::_( 'COM_SH404SEF_ANALYTICS_REPORT_SOURCES') . JText::_('COM_SH404SEF_ANALYTICS_REPORT_BY_LABEL') . Sh404sefHelperAnalytics::getDataTypeTitle();
    $dataSet->SetSerieName( $label,"visits");

    // Initialise the graph
    $w = intval( 0.45 * $this->_options['cpWidth']);
    $w = empty( $w) ? 160 : $w;
    $radius = intval( $w * 0.22);
    $margin = 5;
    $h = intval($w * 0.8);
    $centreX = intval(0.50 * $w);
    $centreY = intval(0.50 * $h);
    $chart = new pChart( $w, $h);
    $fontSize = 8;

    // prepare graph
    $chart->setFontProperties( $this->_baseChartPath . DS .'Fonts/arial.ttf', $fontSize);
    $chart->loadColorPalette( $this->_baseChartPath . DS . 'palettes' . DS . 'tones-2-green-soft.php');
    $chart->setGraphArea( $margin, $margin, $w-$margin, $h-$margin);

    // This will draw a shadow under the pie chart
    $chart->drawFilledCircle( $centreX + 4, $centreY + 4, $radius,200,200,200);
     
    // Draw the pie chart
    $d = $dataSet->GetData();
    if (!empty( $d)) {
      $chart->drawBasicPieGraph( $d, $dataSet->GetDataDescription(), $centreX, $centreY, $radius, PIE_PERCENTAGE_LABEL_VALUE, 255, 255, 218);
    }

    // create a temporary file for
    $user = &JFactory::getUser();

    // make sure the root tmp dir exists
    $rootDir = 'tmp' . DS . 'sh404sef_analytics';
    Sh404sefHelperFiles::createDirAndIndex( JPATH_ROOT . DS . $rootDir);

    // file name is variable to avoid browser cache
    $basePath = $rootDir . DS . md5( 'useless_' . $user->id . '_hashing') . DS;

    // create path and make sure there's an index.html file in it
    Sh404sefHelperFiles::createDirAndIndex( JPATH_ROOT . DS . $basePath);

    $imageFileName = Sh404sefHelperAnalytics::createTempFile( $basePath, $this->_options['report'] . '.' . $this->_options['accountId']. '.sources.' . $dataTypeString);
    $chart->Render( JPATH_ROOT. DS . $imageFileName);

    // need cleaning up, so let's remove all report files for that user older than an hour or so
    Sh404sefHelperAnalytics::cleanReportsImageFiles( JPATH_ROOT . DS . $basePath, $age = 4000);

    return JURI::root() . $imageFileName;

  }

  /**
   * Builds an URI suitable to query Google Analytics API
   * @param array $query a set of query constraints (ie: dimensions, metrics, etc)
   */
  protected function _buildQueryUri( $query) {

    // default values
    $defaultQuery = array(
      'ids' => 'ga:' . $this->_options['accountId']
    , 'dimensions' => array()
    , 'metrics' => array()
    , 'sort' => null
    , 'filters' => null
    , 'segment' => null
    , 'start-date' => $this->_options['startDate']
    , 'end-date' => $this->_options['endDate']
    , 'start-index' => null
    , 'max-results' => $this->_options['max-results']
    );

    // combine with request
    $query = array_merge( $defaultQuery, $query);

    // combine them into a uri
    $uri = '';
    foreach( $query as $key => $value) {
      if (!is_null( $value)) {
        $uri .= '&' . $key . '=' . $value;
      }
    }

    // prepare dimensions
    $uri = $this->_endPoint . 'data?' . ltrim( $uri, '&');

    return $uri;
  }

  protected function _query( $type) {

    //perform request
    $response = $this->_client->request();

    // check if authentified
    Sh404sefHelperAnalytics::verifyAuthResponse( $response);

    // analyze response
    $parser = new DOMDocument();
    //echo '<br />-------------------------------------<br />';
    //print_r( $response->getBody());
    //echo '<br />-------------------------------------<br />';
    $parser->loadXML( $response->getBody());
    $this->_rawData[$type] = $parser->getElementsByTagName('entry');
    $this->_decodeXml( $type);

  }

  protected function _decodeXml($type) {

    $data = array();

    foreach( $this->_rawData[$type] as $entry) {
      $r = new StdClass();

      $dimensions = $entry->getElementsByTagName('dimension');
      foreach($dimensions as $dimension) {
        $name = $dimension->getAttribute('name');
        $name = str_replace( 'ga:', '', $name);
        $r->dimension[$name] = $dimension->getAttribute('value');
      }
      $metrics = $entry->getElementsByTagName('metric');
      foreach( $metrics as $metric) {
        $name = $metric->getAttribute('name');
        $name = str_replace( 'ga:', '', $name);
        $r->$name = $metric->getAttribute('value');
      }
      $data[] = clone($r);
       
    }

    $this->_rawData[$type] = $data;

  }

  private function _loadLibs() {

    // include pChart pChart
    require_once( $this->_baseChartPath . DS . 'pChart' . DS . 'pData.class.php');
    require_once( $this->_baseChartPath . DS . 'pChart' . DS . 'pChart.class.php');
  }

  /**
   * NUmerical sort function
   *
   * @param $first
   * @param $second
   * @return unknown_type
   */
  protected function _sortSourcesDataCompareFunction( $first, $second) {

    // need config, to know which data user wants to display : visits, unique visitors, pageviews
    $sefConfig = Sh404sefFactory::getConfig();
    // Google does not allow combining dimension=ga:medium with metric = unique visitors
    $metric = $sefConfig->analyticsDashboardDataType == 'ga:visitors' ?
        'ga:visits' : $sefConfig->analyticsDashboardDataType;

    $dataTypeString = str_replace( 'ga:', '', $metric);

    if ($first->$dataTypeString == $second->$dataTypeString) {
      return 0;
    }

    return $first->$dataTypeString > $second->$dataTypeString ? +1 : -1;
  }

}