<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editalias.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelEditalias extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.editalias';
  protected $_defaultTable = 'aliases';

  protected $_alias = null;

  /**
   * Create or update a record to
   * DB from POST data
   *
   * Overriden from base model
   * to also save metas and aliases
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null) {

    // use parent save method to save the url itself, from default values
    $this->_data = is_null( $dataArray) ? JRequest::get('post') : $dataArray;

    // save the non-sef/sef pair data
    $savedId = $this->_save();

    // return savedId of the url, will have
    // been set to 0 if something wrong happened
    // while saving either url, meta data or aliase
    return $savedId;
  }

  /**
   * Get a list of aliases from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of aliases id to fetch
   * @return array of objects as read from db
   */
  public function getByIds( $ids = array()) {

    $aliases = array();

    if (empty($ids)) {
      return $aliases;
    }

    // select element where id is in list supplied
    try {
      $aliases = Sh404sefHelperDb::selectObjectList( $this->_getTableName(), array('*'), $this->_db->nameQuote( 'id') . ' in (?)', Sh404sefHelperDb::arrayToQuotedList($ids));
    } catch (Sh404sefExceptionDefault $e) {

    }
    // return result
    return $aliases;
  }

  /**
   * Delete a list of aliases from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of aliases id to delete
   * @return boolean true if success
   */
  public function deleteByIds( $ids = array()) {

    if (empty($ids)) {
      return false;
    }

    try {
      Sh404sefHelperDb::deleteIn( $this->_getTableName(),  'id', $ids, Sh404sefHelperDb::INTEGER);
    } catch (Sh404sefExceptionDefault $e) {
      $this->setError( 'Internal database error # ' . $e->getMessage());
      return false;
    }

    return true;
  }

  /**
   * Save an alias to the database
   *
   * @param integer $type force url type, used when saving a custom url
   */
  private function _save( $type = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS) {

    // check for bad data
    if (empty( $this->_data['newurl'])) {
      return 0;
    }

    // get required tools
    jimport( 'joomla.database.table');
    $row = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // let table save record
    $row->save( $this->_data['newurl']);

    // collect errors
    $error = $row->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // return what should be a non-zero id
    return $row->id;

  }

  /**
   * Returns the default full table name on
   * which this model operates
   */
  protected function _getTableName() {

    return '#__sh404sef_aliases';

  }

}