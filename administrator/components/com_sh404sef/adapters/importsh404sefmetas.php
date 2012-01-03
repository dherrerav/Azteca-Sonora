<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: importsh404sefmetas.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * Implement wizard based exportation of pageids data
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterImportsh404sefmetas extends Sh404sefClassImportgeneric {

  /**
   * Parameters for current adapter, to be used by parent controller
   *
   */
  public function setup() {

    // let parent do their job
    $properties = parent::setup();

    // set context record
    $this->_context = 'sh404sefmetas';

    // setup a few custom properties
    $properties['_returnController'] = 'urls';
    $properties['_returnTask'] = '';
    $properties['_returnView'] = 'urls';
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
    $line = $this->_lineToArray( trim( $line));

    // get table object to store record
    $model = & JModel::getInstance( 'metas', 'Sh404sefModel');

    // bind table to current record
    $record = array();
    $record['newurl'] = $line[1];
    $record['metatitle'] = $line[4];
    $record['metadesc'] = $line[2];
    $record['metakey'] = $line[3];
    $record['metalang'] = $line[5];
    $record['metarobots'] = $line[6];
    
    // clean up records
    foreach( $record as $key => $value) {
      if ($value == '&nbsp') {
        $record[$key] = '';
      }
    }

    // find if there is already an url record for this non-sef url. If so
    // we want the imported record to overwrite the existing one.
    // while makinf sure we're doing that with the main url, not one of the duplicates
    $existingRecords = $model->getByAttr( array( 'newurl' => $record['newurl']));
    if( !empty( $existingRecords)) {
      $existingRecord = $existingRecords[0];  // getByAttr always returns an array

      // use the existing id, this will be enought to override existing record when saving
      $record['id'] = $existingRecord->id;

      // ensure consistency : delete the remaining records, though there is no reason
      // there can be more than one record with same SEF AND same SEF
      array_shift( $existingRecords);
      if (!empty( $existingRecords)) {
        $db = &JFactory::getDBO();
        $ids = array();
        foreach( $existingRecords as $existingRecord) {
          $ids[] = $db->Quote( $existingRecord->id);
        }

        $query = 'delete from ' . $db->nameQuote( '#__sh404sef_metas')
        . ' where ' . $db->nameQuote( 'id') . ' in (' . implode( ',', $ids) . ')';
        $db->setQuery( $query);
        $db->query();
      }
    } else {
      $record['id'] = 0;
    }

    // save record : returns the record id, so failure is when 0 is returned
    $status = $model->save( $record);
    if (!$status) {
      // rethrow a more appropriate error message
      throw new Sh404sefExceptionDefault( JText::sprintf( 'COM_SH404SEF_IMPORT_ERROR_INSERTING_INTO_DB', $line[0]));
    }

  }

  /**
   * Return html for any option that could
   * be presented to the user on the last
   * page of the wizard (like clean temp files)
   * for instance. This will be displayed just after
   * the mainText text, as prepared by the main
   * part of this controller
   */
  protected function _getTerminateOptions() {

    $options = JText::_( 'COM_SH404SEF_IMPORT_URLS_WARNING');

    return $options;
  }

}