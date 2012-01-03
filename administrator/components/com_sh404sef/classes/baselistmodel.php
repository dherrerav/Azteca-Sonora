<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baselistmodel.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class Sh404sefClassBaselistmodel extends Sh404sefClassBasemodel {

  /**
   * Data array
   *
   * @var array
   */
  protected $_data = null;

  /**
   * Data total
   *
   * @var integer
   */
  protected $_total = null;

  /**
   * Pagination object
   *
   * @var object
   */
  protected $_pagination = null;

  /**
   * Holds current context, ie : controller/model/view/layout hierarchy
   *
   * @var string
   */
  protected $_context = null;

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

      // get pagination values, and check them
      $total = $this->getTotal($options);
      $limitstart = is_null( $forcedLimitstart) ? $this->_getState( 'limitstart') : $forcedLimitstart;
      if( !is_null( $forcedLimitstart) && $limitstart >= $total) {
        $limitstart = 0;
        $this->_setState( 'limitstart', 0);
      }
      $limit = is_null( $forcedLimit) ? $this->_getState( 'limit') : $forcedLimit;

      // don't allow display 'all' ie $limit = 0, and do sanity check
      if (empty( $limit) || intval( $limit) > 500) {
        $limit = 20;
        $this->_setState( 'limit', $limit);
      }

      // build the actual query
      $query = $this->_buildListQuery( $options, $forcedLimitstart, $forcedLimit);
      $this->_data = $this->_getList( $query);
      //echo '<br >----------------------<br />data query:<br />' . $query . '<br >----------- '. count( $this->_data).' -----------<br />';
      if ($returnZeroElement && empty( $this->_data)) {
        // create an empty record and return it
        $zeroObject = JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');
        return array( $zeroObject);
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
      $options->onlyCount = true;
      $query = $this->_buildListQuery( $options);
      $this->_total = $this->_getListCount( $query);
      //echo '<br >----------------------<br />count query:<br />' . $query . '<br >--------' . $this->_total . '--------------<br />';
      $options->onlyCount = false;

    }

    return $this->_total;
  }

  /**
   * Method to get a pagination object for the lists
   *
   * @access public
   * @return integer
   */
  public function getPagination( $options = null) {

    // make sure we use latest user state
    $this->_updateContextData();

    // Lets load the content if it doesn't already exist
    if (empty($this->_pagination)) {
      // get pagination values, and check them
      $total = $this->getTotal($options);
      $limitstart = $this->_getState( 'limitstart');
      $limit = $this->_getState( 'limit');

      // create a pagination object
      jimport('joomla.html.pagination');
      $this->_pagination = new JPagination( $total, $limitstart, $limit);
    }

    return $this->_pagination;
  }

  /**
   * Gets alist of current filters and sort options which have
   * been applied when building up the data
   *
   * @return object the list ov values as object properties
   */
  public function getDisplayOptions() {

    $options = new stdClass();

    // search string applied to either sef or non sef
    $options->search_all = $this->_getState( 'search_all');
    // ordering column
    $options->filter_order = $this->_getState( 'filter_order');
    // show all/only custom/only automatic
    $options->filter_order_Dir = $this->_getState( 'filter_order_Dir');

    // return cached instance
    return $options;
  }

  /**
   * Set a display option for the current context
   *
   * @return mixed previous value of the property
   */
  public function setDisplayOptions( $key, $value) {

    // read previous
    $previous = $this->_getState( $key);

    // set new
    $this->_setState( $key, $value);

    // return previous
    return $previous;
  }

  protected function _buildListQuery( $options, $forcedLimitstart = null, $forcedLimit = null) {

    // Collect the various parts of the query
    $select = $this->_buildListSelect( $options);
    $join = $this->_buildListJoin( $options);
    $where = $this->_buildListWhere( $options);
    $limit = $this->_buildListLimit( $options, $forcedLimitstart, $forcedLimit);
    $orderBy = $this->_buildListOrderBy( $options);
    $groupBy = $this->_buildListGroupBy( $options);

    // complete query
    $query = $select . $join . $where . $groupBy;

    // wrap if combined queries
    $query = $this->_buildListCombinedQuery( $query, $options);

    // add sorting
    $query .= $orderBy;

    // limit number of items
    $query .= $limit;

    return $query;
  }


  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get options
    $select[] = ' select *';

    // add from  clause
    $select[] = 'from ' . $this->_getTableName();
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    // aggregate clauses
    $join = ( count( $join ) ? ' ' . implode( ' ', $join ) : '' );

    return $join;

  }

  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListLimit( $options, $forcedLimitstart = null, $forcedLimit = null) {

    // build query fragment
    $limitString = '';

    // get the layout options from param
    $layout = $this->_getOption( 'layout', $options);

    // in some case, we only need a simple list of urls, with no
    // additionnal date, pageids, aliases, etc
    $simpleUrlList = $this->_getOption( 'simpleUrlList', $options, false);

    // various cases of layouts
    switch ($layout) {
      case 'view404':
      default:
        // build query fragment
        $onlyCount = $this->_getOption( 'onlyCount', $options, false);
        if (!$onlyCount) {
          $limitstart = is_null( $forcedLimitstart) ? ( $this->_getState( 'limitstart')) : intval($forcedLimitstart);
          $limit = is_null( $forcedLimit) ? intval( $this->_getState( 'limit')) : intval( $forcedLimit);
          if(empty($limit) && empty( $limitstart)) {
            $limitstring = '';
          } else {
            $limitString = ' limit ' . $limitstart . ',' . $limit;
          }
        }
        break;
    }

    return $limitString;
  }

  protected function _buildListGroupBy( $options) {

    // build query fragment
    $groupBy = '';

    return $groupBy;
  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    if(!empty($filters->filter_order)) {
      $orderBy  = ' order by ' . $this->_db->nameQuote( $filters->filter_order);
      $orderBy .=  ' ' . $filters->filter_order_Dir;
    }

    return $orderBy;
  }

  protected function _buildListCombinedQuery( $query, $options) {

    return $query;
  }

  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $application = JFactory::getApplication();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $contextData = array(

    array( 'name' => 'limit', 'html_name' => 'limit', 'default' => $application->getCfg('list_limit'), 'type' => 'int')
    , array( 'name' => 'limitstart', 'html_name' => 'limitstart', 'default' => 0, 'type' => 'int')
    // search string applied to either sef or non sef
    , array( 'name' => 'search_all', 'html_name' => 'search_all', 'default' => '', 'type' => 'string')
    // ordering column
    , array( 'name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'oldurl', 'type' => 'string')
    // ordering direction
    , array( 'name' => 'filter_order_Dir', 'html_name' => 'filter_order_Dir', 'default' => 'ASC', 'type' => 'string')

    );

    return $contextData;
  }

  /**
   * Reset model internal cached data
   * used after changing context for instance
   */
  protected function _resetData() {

    // clean data, total and pagination, as we need them rebuilt
    $this->_data = null;
    $this->_total = null;
    $this->_pagination = null;
  }

  /**
   * Read application user state stored by
   * Joomla application object for the current context
   * context represents current controller/model/view hierarchy
   * and has been set by each of those elements
   */
  protected function _updateContextData() {

    // if not been there before, or context has changed since last visit
    if (is_null($this->_context) || $this->_context != $this->getState( 'context')) {

      // read context name and store inclass variabel, easier to access later on
      $this->_context = $this->getState( 'context', $this->_context);

      // get an application instance
      $application = & JFactory::getApplication();

      // define context data to be retrieved. Cannot be done at class level,
      // as some default values are dynamic
      $contextData = $this->_getContextDataDef();

      // must reset limistart if limit is changed
      $mustResetLimitstart = false;

      // get the values from session and store them for future reuse
      foreach( $contextData as $contextDataItem) {

        // must reset limistart if limit is changed, so store previous value of limit
        if ($contextDataItem['name'] == 'limit') {
          // search for previous value
          $previousLimit = $application->getUserState( $this->_context . '.limit');
          $previousLimitstart = $application->getUserState( $this->_context . '.limitstart');
        }

        // get value
        $value = $application->getUserStateFromRequest( $this->_context . '.' . $contextDataItem['name'], $contextDataItem['html_name'], $contextDataItem['default'], $contextDataItem['type'] );

        if ($contextDataItem['name'] == 'limit' && isset($previousLimit) && $value != $previousLimit) {
          $mustResetLimitstart = true;
          $newLimit = $value;
        }

        // and store it into this model
        $this->setState( $this->_context . '.' . $contextDataItem['name'], $value);

      }

      // now check if we should reset limitstart
      if ($mustResetLimitstart) {

        $newLimitstart = empty( $newLimit) ? 0 : $newLimit * floor( $previousLimitstart / $newLimit);
        // store it into the session and the model
        $application->setUserState( $this->_context . '.limitstart', $newLimitstart);
        $this->setState( $this->_context . '.limitstart', $newLimitstart);
      }

    }
  }

  protected function _getOption( $name, $options, $default = null) {

    if (empty( $options) || !is_object( $options)) {
      return $default;
    }

    $value = isset( $options->$name) ? $options->$name : $default;

    return $value;

  }

  /**
   * Short cut to get current state of value
   * @param string $key
   */
  protected function _getState( $key) {

    return $this->getState( $this->_context . '.' . $key);

  }

  /**
   * short cut to set the state of a value
   *
   * @param string $key
   * @param mixed $value
   */
  protected function _setState( $key, $value) {

    return $this->setState( $this->_context . '.' . $key, $value);

  }


  protected function _cleanForQuery( $string) {

    return $this->_db->getEscaped( JString::trim( JString::strtolower( $string )));

  }

}