<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: exporturls.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

/**
 * Implement wizard based exportation of page title and metas data
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterExporturls extends JObject {

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
  , 1 => array( 'task' => 'doExport', 'view' => 'wizard', 'layout' => 'default')
  , 2 => array( 'task' => 'doDownload', 'view' => 'wizard', 'layout' => 'default')

  );

  public $_stepsCount = 0;
  public $_steps = array( 'next' => 0, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);
  public $_button = '';
  public $_buttonsList = array ('next', 'previous', 'terminate', 'cancel');
  // visible buttons are displayed as toolbar pressbutton
  // buttons not on that list are passed as 'hidden' post data
  public $_visibleButtonsList = array ('next', 'previous', 'terminate', 'cancel');


  protected $_context = 'urls';
  protected $_total = 0;
  protected $_parentController = null;
  protected $_filename = '';

  const MAX_PAGEIDS_PER_STEP = 100;

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

    $properties['_returnController'] = 'urls';
    $properties['_returnTask'] = '';
    $properties['_returnView'] = 'urls';
    $properties['_returnLayout'] = 'default';
    $properties['_pageTitle'] = JText::_('COM_SH404SEF_EXPORTING_TITLE');

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

    // A customiser :
    $this->_steps = array( 'next' => 1, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

    // return results
    $result = array();

    $result['mainText'] = JText::_('COM_SH404SEF_EXPORT_URLS_START');

    return $result;

  }

  /**
   * Second step, export data
   *
   */
  public function doExport() {

    // which button should be displayed ?
    $this->_visibleButtonsList = array ();

    // next steps definition
    $this->_steps = array( 'next' => 1, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

    // return results
    $result = array();

    // exporting a limited set of pageids at a time
    $nextStart = JRequest::getInt( 'nextstart', 0);

    // are we adding to an existing data file ?
    $this->_filename = Sh404sefHelperFiles::createFileName( $this->_filename, 'sh404sef_export_' . $this->_context);

    // calculate number of items to export
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');
    $model->setContext( 'urls.default');
    $options = (object) array('layout' => 'export', 'getMetaData' => true);
    $this->_total = $model->getTotal( $options);

    // do we have anything to export ?
    if (empty( $this->_total)) {
      $result['mainText'] = JText::_('COM_SH404SEF_NOTHING_TO_EXPORT');
      // which button should be displayed ?
      $this->_visibleButtonsList = array ('terminate');
      // next step so to trigger download, as file is ready now
      $this->_steps = array( 'next' => -2, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);

      return $result;
    }

    // get new start item
    if (empty( $nextStart)) {
      // this is first pass, starting from 0
      $start = 0;
      $nextStart = $start + self::MAX_PAGEIDS_PER_STEP;
      if ($nextStart >= $this->_total) {
        // reached the end
        $nextStart = $this->_total;
      }
    } else {
      $start = $nextStart;
      $nextStart = $start + self::MAX_PAGEIDS_PER_STEP;
    }

    // are we done ? if so, move to next step
    $result['hiddenText'] = '';

    if ($start >= $this->_total) {
      $result['mainText'] = JText::sprintf('COM_SH404SEF_EXPORT_DONE', $this->_total);
      $result['mainText'] .= $this->_getTerminateOptions();

      // which button should be displayed ?
      $this->_visibleButtonsList = array ('terminate');
      // next step so to trigger download, as file is ready now
      $this->_steps = array( 'next' => 2, 'previous' => 0, 'cancel' => -1, 'terminate' => -2);
    } else {

      // actually export items
      $this->_export( $start);

      // continuing for another round
      $result['mainText'] = JText::sprintf('COM_SH404SEF_EXPORT_EXPORTING', $start + 1, $this->_total);
      $result['hiddenText'] = '<input type="hidden" name="nextstart" value="'.$nextStart.'" />';
      $result['nextStart'] = $nextStart;
    }

    $result['continue'] = array( 'task' => 'next', 'nextstart' => $nextStart, 'filename' => base64_encode($this->_filename));
    $result['continue'] = array_merge( $result['continue'], $this->_steps);
    $result['hiddenText'] .= '<input type="hidden" name="filename" value="'.$this->_filename.'" />';

    return $result;

  }

  /**
   * Last step, send results as download
   *
   */
  public function doDownload() {


    // fake content
    $data = '';

    // get the current filename with path
    $this->_filename = Sh404sefHelperFiles::createFileName( $this->_filename, 'sh404sef_export_' . $this->_context);

    // get a more readable filename
    $displayName = date('Y-m-d') . '_' .  $this->_context . '_export.txt';

    Sh404sefHelperFiles::triggerDownload( $this->_filename, $displayName);

  }

  /**
   * Close the wizard window and redirect to default page
   *
   */
  public function doTerminate() {

    // are we set to purge temporary files ?
    $purgeTempFiles = JRequest::getInt( 'purge_temp_files', 0);
    if (!empty($purgeTempFiles)) {
      Sh404sefHelperFiles::purgeTempFiles( 'sh404sef_export_' . $this->_context);
    }

    // now go back to main page
    $result = array( 'redirectTo' => true);

    return $result;

  }

  /**
   * Close the wizard window and redirect to default page
   *
   */
  public function doCancel() {

    $result = array();
    $result['redirectTo'] = true;
    $result['redirectOptions'] = array( 'sh404sefMsg' => 'COM_SH404SEF_WIZARD_CANCELLED');

    return $result;

  }

  protected function _export( $start) {

    // do we have a valid filename
    $this->_filename = Sh404sefHelperFiles::createFileName( $this->_filename, 'sh404sef_export_' . $this->_context);

    // put some data in the file
    $end = $start + self::MAX_PAGEIDS_PER_STEP + 1;
    $end = $end > $this->_total ? $this->_total : $end;

    // fetch pageIds record from model
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');
    $model->setContext( 'urls.default');
    $options = (object) array('layout' => 'export', 'getMetaData' => true);
    $records = $model->getList( $options, $returnZeroElement = false, $start, $forcedLimit = self::MAX_PAGEIDS_PER_STEP);

    // do we need a header written to the file, for first record
    $header = $start == 0 ? Sh404sefHelperGeneral::getExportHeaders( $this->_context) . "\n" : '';

    // format them for text file output
    $data = '';
    $counter = $start;
    $glue = Sh404sefHelperFiles::$stringDelimiter . Sh404sefHelperFiles::$fieldDelimiter . Sh404sefHelperFiles::$stringDelimiter;
    if (!empty( $records)) {
      foreach( $records as $record) {
        $counter++;
        $textRecord = $record->oldurl . $glue . $record->newurl
        . $glue . $record->cpt
        . $glue . $record->rank
        . $glue . $record->dateadd
        . $glue . Sh404sefHelperFiles::csvQuote( $record->metatitle)
        . $glue . Sh404sefHelperFiles::csvQuote( $record->metadesc)
        . $glue . Sh404sefHelperFiles::csvQuote( $record->metakey)
        . $glue . Sh404sefHelperFiles::csvQuote( $record->metalang)
        . $glue . Sh404sefHelperFiles::csvQuote( $record->metarobots) . Sh404sefHelperFiles::$stringDelimiter;
        $line = Sh404sefHelperFiles::$stringDelimiter . $counter . $glue . $textRecord;
        $data .= $line . "\n";
      }
    }

    // prepare data for storage
    if (!empty( $header)) {
      // first record written to file, prepend header
      $data = $header . $data;
    }

    // store in file
    $status = Sh404sefHelperFiles::appendToFile( $this->_filename, $data);

    // return any error
    return $status;

  }

  protected function _getTerminateOptions() {

    $options = '<br /><br />';
    $options .= '<input type="checkbox" name="purge_temp_files" value="1" checked="checked" >';
    $options .= JText::_('COM_SH404SEF_PURGE_TEMP_FILES');
    $options .= '<br />';

    return $options;
  }

}