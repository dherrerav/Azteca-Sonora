<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: aliases.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerAliases extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.aliases';
  protected $_defaultModel = 'aliases';
  protected $_defaultView = 'aliases';
  protected $_defaultController = 'aliases';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'aliases';
  protected $_returnTask = '';
  protected $_returnView = 'aliases';
  protected $_returnLayout = '';

  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  public function display($cachable = false) {

    // catch up any result message coming from an
    // ajax save for instance, and push that into
    // the application message queue
    $messageCode = JRequest::getCmd( 'sh404sefMsg');
    if (!empty($messageCode)) {
      $msg = JText::_( $messageCode);
      if ($msg != $messageCode) {
        // if no language string exists, JText will
        // return the input string, so only display if
        // we have something to display
        $app = &JFactory::getApplication();
        $app->enqueuemessage( $msg);
      }
    }

    // find and store edited item id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');

    // Set the view name and create the view object
    $viewName = $this->_defaultView;
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath));

    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( $this->_context);

      // Push the model into the view (as default)
      $view->setModel($model, true);

      // and push also the default redirect
      $view->assign('defaultRedirectUrl', $this->_getDefaultRedirect( array( 'layout' => $viewLayout)));

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
    $this->_doConfirmPurge( 'auto');

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
    $this->confirmed();
  }

  /**
   * Handles actions confirmed through the confirmation box
   */
  public function confirmed() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // collect type of purge to make
    $type = JRequest::getCmd( 'delete_type');

    switch($type) {
      case 'auto':
        break;
      case 'selected':
        break;
      default:
        $this->setError('Invalid data');
        $view->display();
        break;
    }

    // now perform url deletion
    // get the model to do it, actually
    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store initial context in model
      $model->setContext( 'com_sh404sef.aliases.aliases.default');

      // call the delete method on our list
      $model->purge( $type);

      // check errors and enqueue them for display if any
      $error = $model->getError();
      if (!empty($error)) {
        $this->setError( $error);
      }

    }
    // return result to caller
    $this->display();
  }


  /**
   * Redirect to a confirmation page showing in
   * a popup window
   */
  private function _doConfirmPurge( $type = 'auto') {

    // Set the view name and create the view object
    $viewName = 'confirm';
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $viewLayout = JRequest::getCmd( 'layout', $this->_defaultLayout );

    $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath));

    // and who's gonna handle the request
    $view->assign( 'actionController', $this->_defaultController);

    // Get/Create the model
    if ($model = & $this->getModel( $this->_defaultModel, 'Sh404sefModel')) {
      // store context of the main url view in the model
      $model->setContext( 'com_sh404sef.aliases.aliases.default');

      // Push the model into the view (as default)
      $view->setModel($model, true);

    }

    // tell it what to display
    // we purge aliases, count them first
    $numberOfAliases = $model->getAliasesCount( $type);

    // if nothing to do, say so and return to main page
    if (empty( $numberOfAliases)) {
      $view->assign( 'redirectTo', $this->_getDefaultRedirect());
      $view->assign( 'message', JText::_('COM_SH404SEF_NORECORDS'));
    } else {

      // calculate the message and some hidden data to be passed
      // through the confirmation box
      switch ($type) {
        case 'selected':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PURGE_ALIASES_SELECTED', $numberOfAliases);
          break;
        case 'auto':
          $mainText  = JText::sprintf( 'COM_SH404SEF_CONFIRM_PURGE_ALIASES', $numberOfAliases);
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