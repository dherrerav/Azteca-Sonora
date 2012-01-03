<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: metas.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelMetas extends Sh404sefClassBaselistModel {

  protected $_context = 'sh404sef.metas';
  protected $_defaultTable = 'metas';


  /**
   * Save a list of meta data as entered by user in backend to the database
   *
   * @param string $metaData an array of meta key/meta value from user. Also include nonsef url
   *
   * @return boolean true on success
   */
  public function save( $metaDatas) {


    $this->_db =& JFactory::getDBO();
    $row = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // attach incoming data to table object
    $status = $row->bind( $metaDatas );

    // add language code if missing, except on home page
    if ( $status && $row->newurl != sh404SEF_HOMEPAGE_CODE &&  // don't add on homepage
    !preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $row->newurl)) {  // no lang string, let's add default
      $shTemp = explode( '-', shGetDefaultLang());
      $shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
      $row->newurl .= '&lang='.$shLangTemp;

    }

    // sort url params, except on home page
    if ( $status && $row->newurl != sh404SEF_HOMEPAGE_CODE) {
      $row->newurl = shSortUrl($row->newurl);
    }

    // pre-save checks
    $status = $status && $row->check();

    // save the changes
    $status = $status && $row->store();

    // store error message
    if (!$status) {
      $error = $row->getError();
      $this->setError( $error);
    }

    // return true if no error
    $errors = $this->getError();
    return empty( $errors);

  }

  /**
   * Save an array of metadata records
   * typycally coming from user entry
   * on the meta data list page
   *
   * @param array of objects $dataSet the data, with each object holding a record
   */
  public function SaveSet( $dataSet) {

    if (empty($dataSet)) {
      $this->setError( 'No data to save');
      return;
    }

    foreach( $dataSet as $dataRecord) {
      $status = $this->save( $dataRecord);
      if (!$status) {
        break;
      }
    }

    return $status;
  }

  /**
   * Count meta data records
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function getMetaRecordsCount( $type) {

    switch (strtolower( $type)) {

      // we want to read all automatic urls (include duplicates)
      case 'all':
        $query = 'select count(*) from ' . $this->_db->nameQuote( $this->_getTableName());
        $this->_db->setQuery( $query);
        $numberOfMetaRecords = $this->_db->loadResult();
        break;

        // we want to read urls as per current selection input fields
        // ie : component, language, custom, ...
      case 'selected':
        // get model and update context with current
        $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

        // use current filters for default layout of metas manager
        $context = $model->updateContext( $this->_context . '.' . 'default');

        // read url data from model
        $list = &$model->getList( (object) array('layout' => 'default', 'getMetaData' => true));

        $numberOfMetaRecords = 0;
        // just count urls with some meta data
        if (!empty($list)) {
          foreach ($list as $urlRecord) {
            if (!empty( $urlRecord->metas)) {
              $numberOfMetaRecords++;
            }
          }
        }
        break;

      default:
        $numberOfMetaRecords = 0;
        break;
    }

    return intval( $numberOfMetaRecords);
  }

  /**
   * Purge meta data records from the database
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function purgeMetas( $type) {

    // make sure we use latest user state
    $this->_updateContextData();

    // call the appropriate sub-method to get the db query
    $methodName = '_getPurgeQuery' . ucfirst($type);
    if (is_callable( array( $this, $methodName))) {
      $deleteQuery = $this->$methodName();
    } else {
      $this->setError( 'Invalid method call _purge' . $type);
      return;
    }

    // then run the query
    if (!empty( $deleteQuery)) {
      $this->_db->setQuery( $deleteQuery);
      $this->_db->query();
      // set error
      $error = $this->_db->getErrorNum();
      if (!empty($error)) {
        $this->setError( 'Internal database error # ' . $error . ' ' . $deleteQuery);
      }
      // reset limit and limitstart variables, to avoid
      // issue when displaying again results
      $this->_setState( 'limitstart', 0);
      $this->_setState( 'limit', 0);
    } else {
      $this->setError( JText::_('COM_SH404SEF_NORECORDS'));
    }

  }

  /**
   * Construct select statement, for use
   * by getList() controller method
   * @param unknown_type $options
   */
  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // are we reading metas for one specific url ?
    $newurl = $this->_getOption( 'newurl', $options);
    if (!empty( $newurl)) {
      $where[] = 'newurl = ' . $this->_db->Quote( $newurl);
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    $orderBy  = ' order by ' . $this->_db->nameQuote( 'newurl');
    $orderBy .=  ' ' . $filters->filter_order_Dir;

    return $orderBy;
  }


  /**
   * Delete all automatically generated url records
   * from database and cache
   */
  private function _getPurgeQueryAll() {

    // delete from database
    $query = 'truncate ' . $this->_db->nameQuote( $this->_getTableName());

    return $query;
  }

  private function _getPurgeQuerySelected() {

    // get model and update context with current
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

    // use current filters for default layout of metas manager
    $context = $model->updateContext( $this->_context . '.' . 'default');

    // read url data from model
    $list = &$model->getList( (object) array('layout' => 'default', 'getMetaData' => true));

    $metaRecordsIds = array();
    // store meta data records ids for urls with some metat data
    if (!empty($list)) {
      foreach ($list as $urlRecord) {
        $id = intval($urlRecord->metaid);
        if (!empty( $id)) {
          $metaRecordsIds[] = $this->_db->Quote($id);
        }
      }
    }

    // if no urls with meta data, return empty query
    if (empty( $metaRecordsIds)) {
      return '';
    }

    // start delete query
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName());

    // call method to build where clause in accordance to current settings and user selection
    $where = implode( ', ', $metaRecordsIds);

    // stitch where clause
    $query = $query . ' where id in (' . $where . ')';

    return $query;
  }

  protected function _getTableName() {

    return '#__sh404sef_metas';

  }

}