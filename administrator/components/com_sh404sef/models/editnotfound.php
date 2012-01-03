<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editnotfound.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelEditnotfound extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.editnotfound';
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
   * Read a url object from DB
   *
   * @param integer $id
   */
  public function getUrl( $id) {

    $url = &JTable::getInstance( 'urls', 'Sh404sefTable');
    $url->load( $id);

    return $url;
  }

  /**
   * Save an alias to the database
   *
   * @param integer $type force url type, used when saving a custom url
   */
  private function _save( $type = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS) {

    // check for bad data
    $newUrl = empty($this->_data['newurl']) ? '' : trim($this->_data['newurl']);
    $id =  empty($this->_data['id']) ? '' : intval($this->_data['id']);
    if (empty( $newUrl) || empty($id)) {
      return 0;
    }

    // read alias, as obtained from original 404 record
    $url = &JTable::getInstance( 'urls', 'Sh404sefTable');
    $url->load( $id);
    // collect errors
    $error = $url->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // prepare an alias record to save to db
    jimport( 'joomla.database.table');
    $alias = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');
    $newAlias = array( 'newurl' => $newUrl, 'alias' => $url->oldurl, 'type' => $type);

    // let table save record
    $alias->save( $newAlias);

    // collect errors
    $error = $alias->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // now delete the page not found record
    $url->delete();
    // collect errors
    $error = $url->getError();
    if (!empty( $error)) {
      $this->setError( $error);
      return 0;
    }

    // return what should be a non-zero id
    return $alias->id;

  }

  /**
   * Returns the default full table name on
   * which this model operates
   */
  protected function _getTableName() {

    return '#__sh404sef_aliases';

  }

}