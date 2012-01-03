<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: pageids.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerPageids extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.pageids';
  protected $_defaultModel = 'urls';
  protected $_defaultView = 'pageids';
  protected $_defaultController = 'pageids';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'pageids';
  protected $_returnTask = '';
  protected $_returnView = 'pageids';
  protected $_returnLayout = 'default';

  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  public function confirmdelete() {

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // Set the view name and create the view object
    $viewName = 'confirm';
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath));

    // push url id(s) into the view
    $view->assign( 'cid', $cid);

    // tell it what to display
    $view->assign( 'mainText', JText::sprintf( 'COM_SH404SEF_CONFIRM_PAGEID_DELETION', count($cid)));

    // and who's gonna handle the request
    $view->assign( 'actionController', $this->_defaultController);
    
    // and then what to do
    $view->assign( 'task', 'confirmeddeletepageids');

    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // Push the model into the view (as default)
      $view->setModel($model, true);

    }

    // Set the layout
    $view->setLayout($viewLayout);

    // Display the view
    $view->display();

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

  public function confirmeddeletepageids() {
    
    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // check invalid data
    if (!is_array( $cid ) || count( $cid ) < 1 || $cid[0] == 0) {
      $this->setRedirect( $this->_getDefaultRedirect(), JText::_( 'COM_SH404SEF_SELECT_ONE_PAGEID'));
    }

    // now perform pageid deletion
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( 'pageids', 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // call the delete method on our list
      $model->deleteByIds( $cid);

      // check errors and enqueue them for display if any
      $errors = $model->getErrors();
      if (!empty($errors)) {
        $this->enqueuemessages( $errors, 'error');

        // clear success message, as we have just queued some error messages
        $status = '';
      }

    }

    // send back response through default view
    $this->display();
    
  }
  
  /**
   * Handles actions confirmed through the confirmation box
   */
  public function confirmedpurgepageids() {

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
        return;
        break;
    }

    // now perform meta data deletion
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( 'pageids', 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( 'com_sh404sef.pageids.pageids.default');

      // call the delete method on our list
      $model->purgePageids( $type);

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
    if ($model = & $this->getModel( 'pageids', 'Sh404sefModel')) {
      // store context of the main url view in the model
      $model->setContext( 'com_sh404sef.pageids.pageids.default');

      // Push the model into the view (as default)
      $view->setModel($model, true);

    }

    // tell it what to display
    // we only purge automatic sef urls, count that
    $numberOfPageids = $model->getPageIdsCount( $type);

    // if nothing to do, say so and return to main page
    if (empty( $numberOfPageids)) {
      $view->assign( 'redirectTo', $this->_getDefaultRedirect());
      $view->assign( 'message', JText::_('COM_SH404SEF_NORECORDS'));
    } else {

      // calculate the message and some hidden data to be passed
      // through the confirmation box
      switch ($type) {
        case 'selected':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PAGEID_DELETION', $numberOfPageids);
          break;
        case 'all':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PAGEID_DELETION', $numberOfPageids);
        default:
          break;
      }

      // and then what to do
      $view->assign( 'task', 'confirmedpurgepageids');
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