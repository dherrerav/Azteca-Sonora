<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: notfound.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelNotfound extends Sh404sefClassBaselistmodel {

  protected $_context = 'notfound';
  protected $_defaultTable = 'urls';

  /**
   * Layout value
   *
   * @var string
   */
  private $_layout = 'default';

  /**
   * Object holding the url record
   * for which we are handling duplicates
   *
   * @var object
   */
  private $_url = null;

  /**
   * Method to get lists item data
   *
   * @access public
   * @param object holding options
   * @param boolea $returnZeroElement . If true, and the list returned is empty, a null object will be returned (as an array)
   * @return array
   */
  public function getList( $options = null, $returnZeroElement = false, $forcedLimitstart = null, $forcedLimit = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (is_null($this->_data)) {

      // get set of filters applied to the current view
      $filters = $this->getDisplayOptions();

      if($filters->filter_similar_urls) {
        $this->_getSimilarUrls( $returnZeroElement);
      } else {
        parent::getList( $options, $returnZeroElement, $forcedLimitstart, $forcedLimit);
      }
    }

    return $this->_data;
  }

  /**
   * Method to get the total number of categories
   *
   * @access public
   * @return integer
   */
  public function getTotal( $options = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (is_null($this->_total)) {

      // get set of filters applied to the current view
      $filters = $this->getDisplayOptions();

      if($filters->filter_similar_urls) {
        $this->_countSimilarUrls();
      } else {
        parent::getTotal( $options);
      }
    }

    return $this->_total;
  }

  /**
   * Read a url object from DB
   *
   * @param integer $id
   */
  public function getUrl( $id) {

    if(is_null( $this->_url)) {
      $this->_url = &JTable::getInstance( 'urls', 'Sh404sefTable');
      $result = $this->_url->load( $id);
    }

    return $this->_url;
  }

  /**
   * Make the url with id = $cid the main url
   * in case of duplicates. Also set the previous
   * main url as secondary, swapping their rank
   *
   * @param integer $notFoundUrlId id of not found page, to be redirected
   * @param integer $targetUrlId id of SEF url to redirect to
   */
  public function redirectNotFoundUrl($notFoundUrlId, $targetUrlId) {

    // read targetUrl
    $targetUrl = &JTable::getInstance( 'urls', 'Sh404sefTable');
    $targetUrl->load( $targetUrlId);
    // collect errors
    $error = $targetUrl->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // read alias, as obtained from original 404 record
    $notFoundUrl = &JTable::getInstance( 'urls', 'Sh404sefTable');
    $notFoundUrl->load( $notFoundUrlId);
    // collect errors
    $error = $notFoundUrl->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // prepare an alias record to save to db
    jimport( 'joomla.database.table');
    $alias = & JTable::getInstance( 'aliases', 'Sh404sefTable');
    $newAlias = array( 'newurl' => $targetUrl->newurl, 'alias' => $notFoundUrl->oldurl, 'type' => Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS);

    // let table save record
    $alias->save( $newAlias);

    // collect errors
    $error = $alias->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // now delete the page not found record
    $notFoundUrl->delete();
    // collect errors
    $error = $notFoundUrl->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // return what should be a non-zero id
    return $alias->id;
  }

  /**
   * Hook to protected method to reset model internal cached data
   * used after changing context for instance
   */
  public function resetData() {

    // clean data, total and pagination, as we need them rebuilt
    $this->_data = null;
    $this->_total = null;
    $this->_pagination = null;
  }

  /**
   * Hook to protected method to read latest state
   */
  public function updateContextData() {

    $this->_updateContextData();
  }


  /**
   * Gets alist of current filters and sort options which have
   * been applied when building up the data
   * @override
   * @return object the list ov values as object properties
   */
  public function getDisplayOptions() {

    $options = parent::getDisplayOptions();

    // get additional options vs base class

    // component used in url
    $options->filter_component = $this->_getState( 'filter_component');
    // show all/only with aliases/only w/o aliases
    $options->filter_alias = $this->_getState( 'filter_alias');
    // show all/only custom/only automatic
    $options->filter_url_type = $this->_getState( 'filter_url_type');
    // show all/only one language
    $options->filter_language = $this->_getState( 'filter_language');

    // show all/only similar urls
    $options->filter_similar_urls = $this->_getState( 'filter_similar_urls');

    // return cached instance
    return $options;
  }

  /**
   * Lookup urls similar to the (not found) request
   * stored in $this->_url
   *
   * @param boolean $returnZeroElement if true, an empty object is store in result
   *                if there is not data available. If false, result is left null
   */
  protected function _getSimilarUrls( $returnZeroElement) {

    // check if we have not already done the job
    if(is_null( $this->_data)) {

      if (is_callable( 'shFindSimilarUrls')) {
        // get plugin params
        $plugin =& JPluginHelper::getPlugin('sh404sefcore', 'sh404sefsimilarurls');

        // init params from plugin
        $pluginParams = new JParameter($plugin->params);

        // call our similar url function
        // TODO: move similar url into a model
        $this->_data = shFindSimilarUrls( $this->_url->oldurl, $pluginParams);
        $this->_total = count( $this->_data);

        if ($returnZeroElement && empty( $this->_data)) {
          // create an empty record and return it
          $this->_data = array(JTable::getInstance( $this->_defaultTable, 'Sh404sefTable'));
        }
      }
    }

  }

  /**
   * Count urls similar to the (not found) request
   * stored in $this->_url
   *
   */
  protected function _countSimilarUrls() {

    // check if we have not already done the job
    if(is_null( $this->_total)) {
      $this->_getSimilarUrls($returnZeroElement = false);
    }

    return $this->_total;
  }

  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get the layout option from params
    $layout = $this->_getOption( 'layout', $options);
    switch ($layout) {
      default:
        $select[] = ' select u1.*, pg.pageid as pageid';
        break;
    }

    // add from  clause
    $select[] = 'from ' . $this->_getTableName() . ' as u1';
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    // get page ids
    $join[] = 'left join ' . $this->_db->nameQuote( '#__sh404sef_pageids') . ' as pg';
    $join[] = 'on pg.' . $this->_db->nameQuote('newurl') . ' = u1.' . $this->_db->nameQuote('newurl');

    // aggregate clauses
    $join = ( count( $join ) ? ' ' . implode( ' ', $join ) : '' );

    return $join;

  }

  protected function _buildListWhere( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // array to hold where clause parts
    $where = array();

    // get the layout options from param
    $layout = $this->_getOption( 'layout', $options);

    // only display main url
    $where[] = 'u1.rank = 0';

    // don't include 404s in the proposed redirects
    // only display main url
    $where[] = 'u1.newurl <> ""';

    // add search all urls term if any
    if ( !empty($filters->search_all) ) {  // V 1.2.4.q added search URL feature
      jimport( 'joomla.utilities.string');
      $searchTerm = $this->_cleanForQuery( JString::strtolower($filters->search_all));
      $where[] = "LOWER(u1.oldurl)  LIKE '%" . $searchTerm  . "%'";
    }

    // components check
    if (!empty( $filters->filter_component)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%option=" . $this->_cleanForQuery( $filters->filter_component ) . "%'";
    }

    // language check
    if (!empty( $filters->filter_language)) {
      $where[] = "LOWER(u1.newurl)  LIKE '%lang=" . $this->_cleanForQuery( $filters->filter_language ) . "%'";
    }

    // custom or automatic ?
    if (!empty( $filters->filter_url_type)) {
      switch ($filters->filter_url_type) {
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM:
          $where[] = 'u1.dateadd <> ' . $this->_db->Quote( '0000-00-00');
          break;
        case Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO:
          $where[] = 'u1.dateadd = ' . $this->_db->Quote( '0000-00-00');
          break;
      }
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }


  protected function _getTableName() {

    return '#__sh404sef_urls';

  }

  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $contextData = parent::_getContextDataDef();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $addedContextData = array(

    // redefined default sort order
    array( 'name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'rank', 'type' => 'string')

    // component used in url
    , array( 'name' => 'filter_component', 'html_name' => 'filter_component', 'default' => '', 'type' => 'string')
    // show all/only with aliases/only w/o aliases
    , array( 'name' => 'filter_alias', 'html_name' => 'filter_alias', 'default' => 0, 'type' => 'int')
    // show all/only custom/only automatic
    , array( 'name' => 'filter_url_type', 'html_name' => 'filter_url_type', 'default' => 0, 'type' => 'int')
    // show all/only one language
    , array( 'name' => 'filter_language', 'html_name' => 'filter_language', 'default' => '', 'type' => 'string')

    // show all/only similar urls
    , array( 'name' => 'filter_similar_urls', 'html_name' => 'filter_similar_urls', 'default' => 1, 'type' => 'int')


    );

    return array_merge( $contextData, $addedContextData);
  }

}