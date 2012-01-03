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

Class Sh404sefControllerMetas extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.metas';
  protected $_defaultModel = 'urls';
  protected $_defaultView = 'metas';
  protected $_defaultController = 'metas';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'metas';
  protected $_returnTask = '';
  protected $_returnView = 'metas';
  protected $_returnLayout = 'default';


  /**
   * Save a list of meta data as edited by
   * user in backend
   */
  public function save() {

    // first check if anything was modified
    $originalMd5 = JRequest::getString( 'contentcs');
    $dataSet = array();
    $ids = JRequest::getVar( 'metaid', array(0), 'post', 'array' );
    $titles = JRequest::getVar( 'metatitle', array(), 'post', 'array' );
    $descs = JRequest::getVar( 'metadesc', array(), 'post', 'array' );
    $newurls = JRequest::getVar( 'newurls', array(), 'post', 'array' );

    // calculate md5 of incoming data and compare to stored value
    foreach( $ids as $id => $value) {
      $t = array();
      $t['id'] = $value;
      $t['metatitle'] = $titles[$id];
      $t['metadesc'] = $descs[$id];
      $t['newurl'] = $newurls[$id];
      $dataSet[] = $t;
    }
    $newMd5 = Sh404sefHelperGeneral::getDataMD5( $dataSet, array( 'metatitle', 'metadesc'), $asObject= false);
    $dataModified = $originalMd5 != $newMd5;

    // if nothing changed, display message and return to meta data list
    if ($dataModified) {

      // we did change something, ask model to save it
      $model = & $this->getModel( 'metas', 'Sh404sefModel');
      $model->saveSet( $dataSet);

      // check errors and display if not ajax call
      $error = $model->getError();
      if (!empty($error)) {
        $this->setError( $error);
      }
      
    } else {
      // did not change data, display that
      $this->setError( JText::_('COM_SH404SEF_DATA_NOT_MODIFIED'));
    }
    
    // check if ajax call, we'll return differently
    $isAjax = JRequest::getInt( 'shajax') == 1;

    // finally return
    if ($isAjax) {
      // ajax : send xml response
      $this->display();
    } else {
      // not ajax, enqueue message and go back to list
      $this->enqueuemessages( array( $error), 'error');
      $this->setRedirect( $this->_getDefaultRedirect());
    }
  }

  /**
   * Handles confirmation for "Purge urls" action
   *
   */
  public function confirmpurge() {

    // use actual method shared with "purge selected" feature
    $this->_doConfirmPurge( 'all');

  }

  /**
   * Handles confirmation for "Purge selected urls" action
   *
   */
  public function confirmpurgeselected() {

    // use actual method shared with "purge" feature
    $this->_doConfirmPurge( 'selected');

  }

  /**
   * Hook for the "confirmed" task, until our
   * confirm view is a bit more flexible
   */
  public function delete() {
    $this->confirmedDeleteMetas();
  }

  /**
   * Handles actions confirmed through the confirmation box
   */
  public function confirmedDeleteMetas() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // collect type of purge to make
    $type = JRequest::getCmd( 'delete_type');

    switch($type) {
      case 'all':
        break;
      case 'selected':
        break;
      default:
        $this->setError('Invalid data');
        $this->display();
        break;
    }

    // now perform meta data deletion
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( 'metas', 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( 'com_sh404sef.metas.metas.default');

      // call the delete method on our list
      $model->purgeMetas( $type);

      // check errors and enqueue them for display if any
      $error = $model->getError();
      if (!empty($error)) {
        $this->setError( $error);
      }

    }
    // return result to caller
    $this->display();
  }

  public function import() {

  }

  public function export() {

  }

  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  private function _doConfirmPurge( $type = 'allmeta') {

    // Set the view name and create the view object
    $viewName = 'confirm';
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath));

    // and who's gonna handle the request
    $view->assign( 'actionController', $this->_defaultController);

    // Get/Create the model
    if ($model = & $this->getModel( 'metas', 'Sh404sefModel')) {
      // store context of the main url view in the model
      $model->setContext( 'com_sh404sef.metas.metas.default');

      // Push the model into the view (as default)
      $view->setModel($model, true);

    }

    // tell it what to display
    // we only purge automatic sef urls, count that
    $numberOfMetaRecords = $model->getMetaRecordsCount( $type);

    // if nothing to do, say so and return to main page
    if (empty( $numberOfMetaRecords)) {
      $view->assign( 'redirectTo', $this->_getDefaultRedirect());
      $view->assign( 'message', JText::_('COM_SH404SEF_NORECORDS'));
    } else {

      // calculate the message and some hidden data to be passed
      // through the confirmation box
      switch ($type) {
        case 'selected':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PURGE_METAS_SELECTED', $numberOfMetaRecords);
          break;
        case 'all':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PURGE_METAS', $numberOfMetaRecords);
        default:
          break;
      }

      $hiddenText = '<input type="hidden" name="delete_type" value="' . $type . '" />';

      // push that into the view
      $view->assign( 'mainText', $mainText);
      $view->assign( 'hiddenText', $hiddenText);
    }
    // Set the layout
    $view->setLayout($viewLayout);

    // Display the view
    $view->display();

  }


}