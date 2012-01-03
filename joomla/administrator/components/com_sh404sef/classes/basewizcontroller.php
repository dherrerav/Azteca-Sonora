<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: basewizcontroller.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefClassBasewizcontroller extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.wiz';

  protected $_defaultController = '';
  protected $_defaultTask = '';
  protected $_defaultModel = '';
  protected $_defaultView = 'wizard';
  protected $_defaultLayout = 'default';

  protected $_returnController = '';
  protected $_returnTask = '';
  protected $_returnView = 'default';
  protected $_returnLayout = 'default';

  protected $_opType = '';
  protected $_opSubject = '';

  protected $_mainText = '';
  protected $_hiddenText = '';
  protected $_stepTitle = '';
  protected $_setFormEncType = '';

  /**
   * Constructor.
   *
   * @access  protected
   * @param array An optional associative array of configuration settings.
   * Recognized key values include 'name', 'default_task', 'model_path', and
   * 'view_path' (this list is not meant to be comprehensive).
   * @since 1.5
   */
  public function __construct( $config = array() ) {

    // call parent, doing main construct job
    parent::__construct( $config);

    // attach appropriate adapter
    $this->_opType = strtolower( JRequest::getCmd( 'optype'));  //ex : 'import'
    $this->_opSubject = strtolower( JRequest::getCmd( 'opsubject'));  // ex:  pageids

    // update context
    $this->_context .= '.' . $this->_opType . '.' . $this->_opSubject;
     
    // create adapter object
    $adapterName = 'Sh404sefAdapter' . ucfirst( $this->_opType) . $this->_opSubject;

    if (!class_exists( $adapterName)) {
      $this->_fail( 'COM_SH404SEF_INVALID_WIZARD_ADAPTER');
    } else {
      $this->_adapter = new $adapterName( $this);
    }

    // collect properties from adapter
    $properties = $this->_adapter->setup();

    // and store them
    foreach($properties as $key => $value) {
      $this->$key = $value;
    }

  }

  /**
   * Display the view
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
        $app = & JFactory::getApplication();
        $app->enqueuemessage( $msg);
      }
    }

    // get/create the view
    $document =& JFactory::getDocument();
    $viewType = $document->getType();
    $view = & $this->getView( $this->_adapter->_stepsMap[$this->_adapter->_step]['view'], $viewType, '', array( 'base_path'=>$this->basePath));

    // Set the layout
    $view->setLayout( $this->_adapter->_stepsMap[$this->_adapter->_step]['layout']);

    // push button list into the view
    $view->assign('buttonsList', $this->_adapter->_buttonsList);
    $view->assign('visibleButtonsList', $this->_adapter->_visibleButtonsList);

    // push list of steps in to the view
    foreach( $this->_adapter->_buttonsList as $button) {
      $view->assign( $button, $this->_adapter->_steps[$button]);
    }

    // push controller name into view
    $view->assign( 'actionController', $this->_defaultController);

    // push operation type and subject into the view
    $view->assign( 'opType', $this->_opType);
    $view->assign( 'opSubject', $this->_opSubject);

    // push title, main and hidden text
    $view->assign( 'pageTitle', $this->_pageTitle);
    $view->assign( 'mainText', $this->_mainText);
    $view->assign( 'hiddenText', $this->_hiddenText);
    $view->assign( 'setFormEncType', $this->_setFormEncType);

    // check if we are done, and need to set a redirect
    if (!empty( $this->_redirectTo)) {
      $view->assign( 'redirectTo', $this->_redirectTo);
    }

    // check if we are continuein to another step, and need to set a redirect
    if (!empty( $this->_continue)) {
      $view->assign( 'continue', $this->_continue);
    }
    if (!empty( $this->_nextStart)) {
      $view->assign( 'nextstart', $this->_nextStart);
    }

    // push controller errors in the view
    $error = $this->getError();
    if (!empty( $error)) {
      $view->setError( $error);
    }

    // Display the view
    $view->display();

  }

  /**
   * Entry point for first screen of wizard
   * without token check
   */
  public function start() {

    $this->_adapter->_button = 'next';
    $this->_dispatch();
  }


  public function next() {

    // Check for request forgeries
    //JRequest::checkToken() or jexit( 'Invalid Token' );

    // if not form submit, just display current step
    $this->_adapter->_button = 'next';
    $this->_dispatch();
  }

  public function previous() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    $this->_adapter->_button = 'previous';
    $this->_dispatch();
  }

  public function terminate() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    $this->_adapter->_button = 'terminate';
    $this->_dispatch();
  }

  /**
   * Close the wizard window and display an error message
   * in the parent window
   */
  public function cancel() {

    // Check for request forgeries
    JRequest::checkToken() or jexit( 'Invalid Token' );

    $this->_adapter->_button = 'cancel';
    $this->_dispatch();

  }

  /**
   * Main entry point
   */
  protected function _dispatch() {

    // collect and store request params
    // what is the step id to run depending on what button was pressed
    // ie : next = 3, previous = 1, terminate = 6
    foreach( $this->_adapter->_buttonsList as $button) {
      $this->_adapter->_steps[$button] = JRequest::getInt( $button, $this->_adapter->_steps[$button]);
    }

    // check request params
    if(!in_array( $this->_adapter->_button, $this->_adapter->_buttonsList)) {
      $this->_fail( 'COM_SH404SEF_INVALID_WIZARD_STEP');
    }

    // _dispatch request to appropriate method

    // _step contains numerical id of _stepsMap record to use
    $this->_adapter->_step = $this->_adapter->_steps[$this->_adapter->_button];

    // call the 'task' method listed in the _stepsMap array item
    if (empty( $this->_adapter->_stepsMap[$this->_adapter->_step])) {
      $this->_fail( 'COM_SH404SEF_INVALID_WIZARD_STEP');
    } else {
      $methodName = $this->_adapter->_stepsMap[$this->_adapter->_step]['task'];
      if (is_callable (array( $this->_adapter, $methodName))) {
        $result = $this->_adapter->$methodName();
        $this->_useAdapterResult( $result);
        $this->display();
      } else {
        $this->_fail( 'COM_SH404SEF_INVALID_WIZARD_STEP');
      }
    }
  }

  /**
   * invalid internal parameters, errors in parameters
   */
  protected function _fail( $msg) {

    $app = & JFactory::getApplication();
    $app->enqueuemessage( $msg, 'error');
    $this->display();

  }

  protected function _useAdapterResult( $result) {

    // use results : the adapter may have change the suject
    // of this operation, after analyzing incoming data in an import
    // for instance
    if( !empty( $result['opSubject'])) {
      $this->_opSubject = $result['opSubject'];
    }

    // redirections results
    $redirectOptions = empty( $result['redirectOptions']) ? array() : $result['redirectOptions'];

    if (!empty( $result['redirectTo'])) {
      $this->_redirectTo = $this->_getDefaultRedirect( $redirectOptions);
    }

    // display results
    if( !empty( $result['mainText'])) {
      $this->_mainText = $result['mainText'];
    }

    if( !empty( $result['hiddenText'])) {
      $this->_hiddenText = $result['hiddenText'];
    }

    if (!empty( $result['setFormEncType'])) {
      $this->_setFormEncType = $result['setFormEncType'];
    }

    if( !empty( $result['continue'])) {
      // calculate redirect url to next step
      $vars = array( 'option' => 'com_sh404sef', 'c' => $this->_defaultController, 'tmpl' => 'component', 'optype' => $this->_opType, 'opsubject' => $this->_opSubject);
      $vars = array_merge( $vars, $result['continue']);
      $this->_continue = Sh404sefHelperGeneral::buildUrl( $vars);
    }

    if( !empty( $result['nextStart'])) {
      $this->_nextStart = $result['nextStart'];
    }

  }

}