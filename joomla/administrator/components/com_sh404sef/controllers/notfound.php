<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: notfound.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerNotfound extends Sh404sefClassBasecontroller {

  protected $_context = 'com_sh404sef.notfound';
  protected $_defaultModel = 'notfound';
  protected $_defaultView = 'notfound';
  protected $_defaultController = 'notfound';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = 'urls';
  protected $_returnTask = '';
  protected $_returnView = 'urls';
  protected $_returnLayout = 'view404';


  public function selectnfredirect() {

    // collect input data : which url needs to be redirected ?
    $notFoundUrlId = JRequest::getInt( 'notfound_url_id');
    
    // which URL to redirect to?
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');
    JArrayHelper::toInteger( $cid);
    if(count($cid) > 1) {
      // more than one target url selected, display error
      $this->setError( JText::_('COM_SH404SEF_SELECT_ONLY_ONE_URL_TO_REDIRECT'));
      $this->display();
      return;
    }
    // only one url, use it
    $targetUrlId = $cid[0];
    if(empty($targetUrlId)) {
      // bad url, probably not an integer was passed
      $this->setError( JText::_('COM_SH404SEF_INVALID_REDIRECT_TARGET_ID'));
      $this->display();
      return;
    }
     
    // get model and ask it to do the job
    $model = & $this->getModel( $this->_defaultModel);
    $model->redirectNotFoundUrl( $notFoundUrlId, $targetUrlId);
     
    // check errors
    $error = $model->getError();
    if(!empty( $error)) {
      $this->setError( $error);
    }

    // standard display
    $this->display();
  }

}