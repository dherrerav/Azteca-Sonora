<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: basemodel.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.model');

abstract class Sh404sefClassBasemodel extends JModel {

  /**
   * Data object
   *
   * @var object
   */
  protected $_data = null;

  /**
   * Holds current context, ie : controller/model/view/layout hierarchy
   *
   * @var string
   */
  protected $_context = null;

  /**
   * Holds default table name
   *
   * @var string
   */
  protected $_defaultTable = '';


  /**
   * Returns an item as an object
   * identified by its db id
   *
   * @param integer $id
   */
  public function getById( $id) {

    // if no cached data, fetch from DB or create
    if (is_null( $this->_data) || $this->_data->id != $id) {

      jimport('joomla.database.table');

      // get a table instance
      $this->_data =& JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

      // load from table
      $this->_data->load( $id);
      
      // set error
      $error = $this->_data->getError();
      if (!empty($error)) {
        $this->setError( $error);
      }

    }

    return $this->_data;
  }

  /**
   * Returns a list of items as objects
   * as selected in the db based on passed
   * options (ie $options = array( 'id' => 12);)
   *
   * Data is not cached!
   *
   * @param array $options an array of key/ value pairs representing select params
   * @param boolean if true, method will only count matching records
   *
   * @return array of objects
   */
  public function getByAttr( $options, $countOnly = false) {

    // prepare a query
    $query = 'select  ' . ($countOnly ? 'count(*)' : '*') . ' from ' . $this->_db->nameQuote( $this->_getTableName());

    // where clause based on options
    $where = array();
    if (!empty( $options)) {
      foreach($options as $key => $value) {
        $where[] = $this->_db->nameQuote( $key) . '= ' . $this->_db->Quote( $value);
      }
    }

    // aggregates all params
    $where = empty( $where) ? '' : ' where ' . implode( ' and ', $where);

    // finalize query
    $query .= $where;

    // query DB
    $this->_db->setQuery( $query);
    $list = $this->_db->loadObjectList();

    return $list;
  }

  public function setData( $data) {

    // get a table instance
    $this->_data =& JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // bind data
    $this->_data->bind( $data);

  }

  /**
   * Create or update a record to
   * DB from POST data or input array of data
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null) {

    // get required tools
    jimport( 'joomla.database.table');
    $this->_data =& JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');
    $post = is_null( $dataArray) ? JRequest::get('post') : $dataArray;

    // use table save method
    $status = $this->_data->save( $post);

    // report error
    if (!$status) {
      $app = & JFactory::getApplication();
      $app->enqueuemessage( $this->_data->getError());
      return 0;
    }

    // if success, fetch last insert id and return that
    $tableDb = &$this->_data->getDBO();
    $keyName = $this->_data->getKeyName();
    $id = empty($post[$keyName]) ? 0 : intval($post[$keyName]);
    $savedId = empty( $id) ? $tableDb->insertid() : $id;

    return $savedId;
  }

  /**
   * set current context string, replacing existing one
   *
   * @param string $newContext
   * @return string updated context
   */
  public function setContext( $newContext = '') {

    if (!empty( $newContext)) {
      $this->setState( 'context', $newContext);

      // reset object data as context has changed
      $this->_resetData();
    }

    return $this->getState( 'context');
  }

  /**
   * Update current context string, appending
   * new context to existing one, separated by '.'
   *
   * @param string  $newContextPart
   * @return string updated context
   */
  public function updateContext( $newContextPart = '') {

    $currentContext = $this->getState('context');

    if (!empty( $newContextPart)) {
      $this->setState( 'context', $currentContext . '.' . $newContextPart);

      // reset object data as context has changed
      $this->_resetData();
    }

    return $this->getState( 'context');

  }

  protected function _getTableName() {

  }

    /**
   * Returns an object list
   * Overriden to check on respective values
   * of limit and limit start
   * If limit is 0, limitstart should be reset to 0 as well
   *
   * @param string The query
   * @param int Offset
   * @param int The number of records
   * @return  array
   * @access  protected
   * @since 1.5
   */
  function &_getList( $query, $limitstart=0, $limit=0 )
  {
    
    // check limit and lim
    $limitstart = $limit === 0 ? 0 : $limitstart;
    
    // do the job
    $result = parent::_getList( $query, $limitstart, $limit);

    return $result;
  }
  
  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $application = JFactory::getApplication();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $contextData = array();

    return $contextData;
  }

  /**
   * Reset model internal cached data
   * used after changing context for instance
   */
  protected function _resetData() {

    // clean data, total and pagination, as we need them rebuilt
    $this->_data = null;
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
      $this->_context = $this->getState( 'context');

      // get an application instance
      $application = & JFactory::getApplication();

      // define context data to be retrieved. Cannot be done at class level,
      // as some default values are dynamic
      $contextData = $this->_getContextDataDef();

      // get the values from session and store them for future reuse
      if (!empty( $contextData)) {
        foreach( $contextData as $contextDataItem) {
          // get value
          $value = $application->getUserStateFromRequest( $this->_context . '.' . $contextDataItem['name'], $contextDataItem['html_name'], $contextDataItem['default'], $contextDataItem['type'] );

          // and store
          $this->setState( $this->_context . '.' . $contextDataItem['name'], $value);
        }
      }
    }
  }

  protected function _getOption( $name, $options, $default = null) {

    $value = isset( $options->$name) ? $options->$name : $default;

  }

  /**
   * Short cut to get current state of value
   * @param string $key
   */
  protected function _getState( $key) {

    return $this->getState( $this->_context . '.' . $key);

  }

  protected function _cleanForQuery( $string) {

    return $this->_db->getEscaped( JString::trim( JString::strtolower( $string )));

  }

}