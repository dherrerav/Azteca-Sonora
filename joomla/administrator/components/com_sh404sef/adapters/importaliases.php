<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: importaliases.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * Implement wizard based exportation of pageids data
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterImportaliases extends Sh404sefClassImportgeneric {

  /**
   * Parameters for current adapter, to be used by parent controller
   *
   */
  public function setup() {

    // let parent do their job
    $properties = parent::setup();

    // set context record
    $this->_context = 'aliases';

    // setup a few custom properties
    $properties['_returnController'] = 'aliases';
    $properties['_returnTask'] = '';
    $properties['_returnView'] = 'aliases';
    $properties['_returnLayout'] = 'default';

    // and return the whole thing
    return $properties;

  }

  /**
   * Creates a record in the database, based
   * on data read from import file
   *
   * @param array $header an array of fields, as built from the header line
   * @param string $line raw record obtained from import file
   */
  protected function _createRecord( $header, $line) {

    // extract the record
    $line = $this->_lineToArray( $line);

    // get table object to store record
    $model = & JModel::getInstance( 'aliases', 'Sh404sefModel');

    // bind table to current record
    $record = array();
    $record['newurl'] = $line[3];
    if ($record['newurl'] == '__ Homepage __') {
      $record['newurl'] = sh404SEF_HOMEPAGE_CODE;
    }
    $record['alias'] = $line[1];
    $record['type'] = $line[4];

    // find if there is already same alias record for this non-sef url. If so
    // we want the imported record to overwrite the existing one.
    $existingRecords = $model->getByAttr( array( 'newurl' => $record['newurl'], 'alias' => $record['alias']));
    if( !empty( $existingRecords)) {
      $existingRecord = $existingRecords[0];  // getByAttr always returns an array

      // use the existing id, this will be enought to override existing record when saving
      $record['id'] = $existingRecord->id;

      // ensure consistency : delete the remaining records, though there is no reason
      // there can be more than one record with same alias AND same SEF
      array_shift( $existingRecords);
      if (!empty( $existingRecords)) {
        $db = &JFactory::getDBO();
        $ids = array();
        foreach( $existingRecords as $existingRecord) {
          $ids[] = $db->Quote( $existingRecord->id);
        }

        $query = 'delete from ' . $db->nameQuote( '#__sh404sef_aliases')
        . ' where ' . $db->nameQuote( 'id') . ' in (' . implode( ',', $ids) . ')';
        $db->setQuery( $query);
        $db->query();
      }
    }

    // save record : returns the record id, so failure is when 0 is returned
    try {
      $model->save( $record);
    } catch (Sh404sefExceptionDefault $e) {
      // rethrow a more appropriate error message
      throw new Sh404sefExceptionDefault( JText::sprintf( 'COM_SH404SEF_IMPORT_ERROR_INSERTING_INTO_DB', $line[0]));
    }
  }
}