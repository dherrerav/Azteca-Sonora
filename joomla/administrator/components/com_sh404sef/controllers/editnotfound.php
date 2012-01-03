<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editnotfound.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerEditnotfound extends Sh404sefClassBaseeditcontroller {

  protected $_context = 'com_sh404sef.editnotfound';
  protected $_editController = 'editnotfound';
  protected $_editView = 'editnotfound';
  protected $_editLayout = 'default';
  protected $_defaultModel = 'editnotfound';
  protected $_defaultView = 'editnotfound';

  protected $_returnController = 'urls';
  protected $_returnTask = '';
  protected $_returnView = 'default';
  protected $_returnLayout = 'view404';


  /**
   * Handle creating a redirect from the 404 requests
   * manager. 
   */
  public function newredirect() {

    // hide the main menu
    JRequest::setVar('hidemainmenu', 1);

    // find and store edited item id . should be 0, as this is a new url
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');
    $this->_id = $cid[0];

    // need to get the view to push the url data into it
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

    // Call the base controller to do the rest
    $this->display();

  }

}