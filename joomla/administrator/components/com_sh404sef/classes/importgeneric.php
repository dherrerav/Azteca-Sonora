<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: importgeneric.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * Implement wizard based exportation of generic data
 *
 * @author shumisha
 *
 */
class Sh404sefClassImportgeneric extends JObject {

  /**
   * An array holding each step details
   * A step is defined as a task, a view and a layout
   * By default, task can be 'display', but still need
   * to be defined in array
   * @var array
   */
  public $_stepsMap = array(

  -2 => array( 'task' => 'doTerminate', 'view' => 'wizard', 'layout' => 'default')
  ,-1 => array( 'task' => 'doCancel', 'view' => 'wizard', 'layout' => 'default')
  , 0 => array( 'task' => 'doStart', 'view' => 'wizard', 'layout' => 'default')
  , 1 => array( 'task' => 'doUpload', 'view' => 'wizard', 'layout' => 'default')
  , 2 => array( 'task' => 'doValidate', 'view' => 'wizard', 'layout' => 'default')
  , 3 => array( 'task' => 'doImport', 'view' => 'wizard', 'layout' => 'default')

  );

  public $_stepsCount = 0;
  public $_steps = array( 'next' => 0, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);
  public $_button = '';
  public $_buttonsList = array ('next', 'previous', 'terminate', 'cancel');
  // visible buttons are displayed as toolbar pressbutton
  // buttons not on that list are passed as 'hidden' post data
  public $_visibleButtonsList = array ('next', 'previous', 'terminate', 'cancel');

  protected $_context = '';
  protected $_total = 0;
  protected $_parentController = null;
  protected $_filename = '';
  protected $_result = array();

  const MAX_PAGEIDS_PER_STEP = 20;

  /**
   * Constructor, keep reference to controller
   * which called the adapter
   * @param unknown_type $parentController
   */
  public function __construct( $parentController) {

    $this->_parentController = $parentController;

  }

  /**
   * Parameters for current adapter, to be used by parent controller
   *
   */
  public function setup() {

    $this->_stepsCount = count( $this->_stepsMap);

    // prepare data for controller
    $properties = array();

    $properties['_defaultController'] = 'wizard';
    $properties['_defaultTask'] = '';
    $properties['_defaultModel'] = '';
    $properties['_defaultView'] = 'wizard';
    $properties['_defaultLayout'] = 'default';

    $properties['_returnController'] = 'default';
    $properties['_returnTask'] = '';
    $properties['_returnView'] = 'default';
    $properties['_returnLayout'] = 'default';
    $properties['_pageTitle'] = JText::_('COM_SH404SEF_IMPORTING_TITLE');

    return $properties;

  }

  /**
   * First step, by default a message
   * and a Terminate button
   *
   */
  public function doStart() {

    // which button should be displayed ?
    $this->_visibleButtonsList = array ('next', 'cancel');

    // next steps definition
    $this->_steps = array( 'next' => 1, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

    // return results
    $this->_result['mainText'] = JText::_('COM_SH404SEF_IMPORT_' . strtoupper( $this->_context). '_START');

    return $this->_result;

  }

  /**
   * Second step, let user upload file
   *
   */
  public function doUpload() {

    // which button should be displayed ?
    $this->_visibleButtonsList = array ( 'next', 'cancel');

    // next steps definition
    $this->_steps = array( 'next' => 2, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

    // return results

    // make sure we can upload, ie set the correct encoding type for the form
    $this->_result['setFormEncType'] = 'multipart/form-data';

    // prepare display
    $this->_result['mainText'] = JText::sprintf('COM_SH404SEF_IMPORT_UPLOAD_FILE', Sh404sefHelperFiles::getMaxUploadSize());

    // add a file browse button
    $this->_result['mainText'] .= '<div style="text-align:center;width:100%;" ><input type="file" name="wizardfile" size="70" /></div>';

    return $this->_result;

  }

  /**
   * Second step, read file content, validate and display for user go ahead
   *
   */
  public function doValidate() {

    // get file name
    $fileRecord = JRequest::getVar( 'wizardfile', null, 'files');

    // move uploaded file, to get access to it
    $this->_filename = Sh404sefHelperFiles::createFileName( $this->_filename, 'sh404sef_import_' . $this->_context);

    try {
      if (!move_uploaded_file($fileRecord['tmp_name'], $this->_filename)) {
        // could not write to web space temp dir
        throw new Sh404sefExceptionDefault( JText::_('COM_SH404SEF_WRITE_FAILED'));
      }

      // which button should be displayed ?
      $this->_visibleButtonsList = array ( 'previous', 'next', 'cancel');

      // next steps definition
      $this->_steps = array( 'next' => 3, 'previous' => 1, 'cancel' => -1, 'terminate' => -2);

      // analyse file content, returning itemsCount
      $importType = $this->_analyzeImportFileContent( $this->_filename);

      // we may have to change the opSubject and related data. If user asked for instance to import
      // aliases, from the aliases page, but actually loaded an import file
      // containing urls or pageids
      if ($this->_context != $importType) {
        $this->_result['opSubject'] = $importType;
        // update filename
        $oldFileName = $this->_filename;
        $this->_filename = str_replace( $this->_context, $importType, $this->_filename);
        // and rename the temp file
        JFile::move( $oldFileName, $this->_filename);
        // tell parent controller that we should go to new target afer this import
        $this->_parentController->set( '_returnController', $importType);
        $this->_parentController->set( '_returnView', $importType);
      }

      // save current file for next steps
      $this->_result['mainText'] = JText::sprintf( 'COM_SH404SEF_IMPORT_VALIDATE_IMPORT', $importType, $this->_total);
      $this->_result['hiddenText'] = '<input type="hidden" name="filename" value="' . $this->_filename . '" />';

    } catch  (Sh404sefExceptionDefault $e) {
      $this->_handleException( $e);
    }

    return $this->_result;

  }

  /**
   * Last step, actually perform importation
   *
   */
  public function doImport() {

    // collect file and import type information
    $this->_filename = JRequest::getString( 'filename');

    try {
      // read file content in an array
      $lines = file( $this->_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

      // start analysing
      if (empty( $lines)) {
        throw new Sh404sefExceptionDefault( 'COM_SH404SEF_ERROR_IMPORT');
      }

      // extract header line
      $header = array_shift( $lines);
      if (empty( $header)) {
        throw new Sh404sefExceptionDefault( 'COM_SH404SEF_ERROR_IMPORT');
      }

      // turn header into an array
      $header = $this->_lineToArray( $header);

      // count items
      $this->_total = count( $lines);

      // iterate through file content and create each record
      foreach( $lines as $line) {
        $this->_createRecord( $header, $line);
      }

      // get back memory
      unset( $lines);

      // delete temporary uploaded file
      JFile::delete( $this->_filename);

      // which button should be displayed ?
      $this->_visibleButtonsList = array ( 'terminate');

      // next steps definition
      $this->_steps = array( 'next' => 3, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

      // setup display of wizard last page
      $this->_result['hiddenText'] = '';
      $this->_result['mainText'] = JText::sprintf('COM_SH404SEF_IMPORT_DONE', $this->_total, $this->_context);
      $this->_result['mainText'] .= $this->_getTerminateOptions();
       
    } catch (Sh404sefExceptionDefault $e) {

      $this->_handleException( $e);

    }

    return $this->_result;

  }

  /**
   * Close the wizard window and redirect to default page
   *
   */
  public function doTerminate() {

    // now go back to main page
    $this->_result = array( 'redirectTo' => true);

    return $this->_result;

  }

  /**
   * Close the wizard window and redirect to default page
   *
   */
  public function doCancel() {

    $this->_result['redirectTo'] = true;
    $this->_result['redirectOptions'] = array();

    return $this->_result;

  }

  /**
   * Analyze the content of a potential import file
   * to try recognize its content. Also find the
   * number of records in the file
   * @param string $filename fully pathed file name
   */
  protected function _analyzeImportFileContent( $filename) {

    // read file content in an array
    $lines = file( $filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // start analysing
    if (empty( $lines)) {
      throw new Sh404sefExceptionDefault( JText::_('COM_SH404SEF_IMPORT_UNRECOGNIZED_CONTENT'));
    }

    // extract header line
    jimport( 'joomla.utilities.string');
    $header = JString::trim(array_shift( $lines));
    if (empty( $header)) {
      throw new Sh404sefExceptionDefault( JText::_('COM_SH404SEF_IMPORT_UNRECOGNIZED_CONTENT'));
    }

    // check against known headers
    $headers = Sh404sefHelperGeneral::getExportHeaders();
    foreach( $headers as $key => $value) {
      if( $header == $value) {
        $importType = $key;
        break;
      }
    }

    // have we found something ?
    if (empty( $importType)) {
      throw new Sh404sefExceptionDefault( JText::_('COM_SH404SEF_IMPORT_UNRECOGNIZED_CONTENT'));
    }

    // count items
    $this->_total = count( $lines);

    // clear memory
    unset( $lines);

    // return record
    return $importType;

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

    $options = '';

    return $options;
  }

  /**
   * Handle an exception by returning to step 2, where
   * user can select a file
   *
   * @param Sh404sefExceptionDefault $e
   */
  protected function _handleException( Sh404sefExceptionDefault $e) {

    // unable to get the file, display error and go back to step 2, "doUpload"
    $this->_parentController->setError( $e->getMessage());
     
    // try delete the uploaded file
    if (JFile::exists( $this->_filename)) {
      JFile::delete( $this->_filename);
    }

    // go back to previous step
    $this->doUpload();

  }

  /**
   * Creates a record in the database, based
   * on data read from import file
   *
   * @param array $header an array of fields, as built from the header line
   * @param string $line raw record obtained from import file
   */
  protected function _createRecord( $header, $line) {

    return true;

  }


  protected function _lineToArray( $line, $glue = null) {

    $glue = is_null( $glue) ? Sh404sefHelperFiles::$stringDelimiter . Sh404sefHelperFiles::$fieldDelimiter . Sh404sefHelperFiles::$stringDelimiter : $glue;
    
    // remove opening and closing quotes - can't use trim or ltrim, as this would remove several occurences
    if (substr( $line, 0, 1) == Sh404sefHelperFiles::$stringDelimiter) {
      $line = substr( $line, 1);
    }
    if (substr( $line, -1, 1) == Sh404sefHelperFiles::$stringDelimiter) {
      $line = substr( $line, 0, -1);
    }

    // break up the line
    $records = explode( $glue, $line);
    if (empty( $records)) {
      return $records;
    }

    // now clean up a bit
    foreach( $records as $i => $value) {

      // remove double quotes, and store back in array
      $records[$i] = Sh404sefHelperFiles::csvUnquote( $value);

    }

    return $records;
  }
}