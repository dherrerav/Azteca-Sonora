<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baseeditcontroller.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefClassBaseEditController extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.edit';

  protected $_editController = '';
  protected $_editTask = 'edit';
  protected $_editLayout = '';

  protected $_returnController = '';
  protected $_returnTask = '';
  protected $_returnView = 'default';
  protected $_returnLayout = 'default';


  /**
   * Id of the currently edited item
   * @var integer
   */
  protected $_id = null;

  /**
   * POST data saved in case of need to edit again
   * same data (if error detected)
   * @var mixed
   */
  protected $_editData = null;

  /**
   * Display the view
   */
  public function display($cachable = false) {

    // Set the default view name in case it's missing
    $viewName = JRequest::getWord('view');
    if (empty( $viewName)) {
      JRequest::setVar( 'view', $this->_defaultView);
    }

    $document =& JFactory::getDocument();

    $viewType = $document->getType();
    $viewName = JRequest::getCmd( 'view');
    $this->_editView = $viewName;
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath));

    // Get/Create the model
    if ($model = & $this->getModel($viewName)) {
      // store initial context in model
      $model->setContext( $this->_context);

      // if we have some stored data from a previous attempt at editing
      // that failed because of validation, then push saved data into
      // the model, to redisplay it for user to fix or cancel
      if (!is_null($this->_editData)) {
        $model->setData( $this->_editData);
      }

      // Push the model into the view (as default)
      $view->setModel($model, true);

      // and push also the default redirect
      $view->assign('defaultRedirectUrl', $this->_getDefaultRedirect());

    }

    // Set the layout
    $view->setLayout($viewLayout);

    // push controller errors in the view
    $error = $this->getError();
    if (!empty( $error)) {
      $view->setError( $error);
    }

    // Display the view
    $view->display();

  }

  public function edit() {

    // hide the main menu
    JRequest::setVar('hidemainmenu', 1);

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');
    $this->_id = $cid[0];
    
    // let the base controller do the rest
    $this->display();

  }

  public function save() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // save incoming data
    $this->_editData = JRequest::get('post');

    // find and store edited item id
    $this->_id = JRequest::getInt('id');

    // perform saving of incoming data
    $savedId = $this->_doSave( $this->_editData);

    // error ?
    if (empty( $savedId)) {
      // edit again with same data
      $errorMsg = $this->getError();
      $errorMsg = empty( $errorMsg) ? $this->_getMessage( 'failure') : $errorMsg;
      $this->setError( $errorMsg);
      JRequest::setVar( 'c', $this->_editController);
      JRequest::setVar( 'task', $this->_editTask);
      JRequest::setVar( 'cid', array($this->_id));
      // in case of error, if this is an ajax call,
      // we simply return the error to the caller
      $isAjax = JRequest::getInt( 'shajax') == 1;
      if(!$isAjax) {
        // if not ajax, we edit again the same page
        $this->edit();
        return false;
      }
    }

    // saved, no need to keep them
    $this->_editData = null;

    // display response
    $this->display();
  }

  public function apply() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // just an alias for save
    $this->save();

  }

  public function cancel() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    $this->setRedirect( $this->_getDefaultRedirect(), $this->_getMessage( 'cancel'));
  }

  protected function setId( $id) {

    $this->_id = $id;

  }

  protected function _getMessage( $type) {

    switch ($type) {
      case 'success':
        $msg = JText::_('COM_SH404SEF_ELEMENT_SAVED');
        break;
      case 'failure':
        $msg = JText::_('COM_SH404SEF_ELEMENT_NOT_SAVED');
        break;
      case 'cancel':
        $msg = JText::_('COM_SH404SEF_CANCELLED');
        break;
      default:
        $msg = '';
        break;
    }

    return $msg;

  }

  protected function _doSave( $dataArray, $urlType = sh404SEF_URLTYPE_CUSTOM) {

    // get model
    $model = $this->getModel( $this->_defaultView);

    // perform save operation
    $savedId = $model->save( $dataArray, $urlType);

    // store error message
    if (empty( $savedId)) {
      $this->setError( $model->getError());
    }

    // return result
    return $savedId;

  }
}