<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editurl.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerEditurl extends Sh404sefClassBaseeditcontroller {

  protected $_context = 'com_sh404sef.editurl';
  protected $_editController = 'editurl';
  protected $_editView = 'editurl';
  protected $_editLayout = 'default';
  protected $_defaultModel = 'editurl';
  protected $_defaultView = 'editurl';

  protected $_returnController = 'urls';
  protected $_returnTask = '';
  protected $_returnView = 'urls';
  protected $_returnLayout = 'default';

  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  public function confirmdelete( $deleteDuplicates = false) {

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
    $view->assign( 'mainText', JText::sprintf( 'COM_SH404SEF_CONFIRM_URL_DELETION', count($cid)));

    // and who's gonna handle the request
    $view->assign( 'actionController', $this->_editController);

    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // Push the model into the view (as default)
      $view->setModel($model, true);

      // check if delete duplicates requested
      $view->task = $deleteDuplicates ? 'confirmeddeldup' : 'delete';

    }

    // Set the layout
    $view->setLayout($viewLayout);

    // Display the view
    $view->display();

  }

  /**
   * GO to confirmation of url and duplicates deletion
   */
  public function confirmdeletedeldup() {

    $this->confirmdelete( $deleteDuplicates = true);
  }

  /**
   * 404 urls deletion is same as regular urls
   */
  public function confirmdelete404() {

    $this->confirmdelete();
  }

  public function confirmed( $deleteDuplicates = false) {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // check invalid data
    if (!is_array( $cid ) || count( $cid ) < 1 || $cid[0] == 0) {
      $this->setRedirect( $this->_getDefaultRedirect(), JText::_( 'COM_SH404SEF_SELECT_ONE_URL'));
    }

    // now perform url deletion
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // call the delete method on our list
      if($deleteDuplicates) {
        $model->deleteByIdsWithDuplicates($cid);
      } else {
        $model->deleteByIds( $cid);
      }

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

  public function confirmeddeldup() {

    $this->confirmed( $deleteDuplicates = true);

  }

  /**
   * Hook for the "confirmed" task, until our
   * confirm view is a bit more flexible
   */
  public function delete() {
    $this->confirmed();
  }

}