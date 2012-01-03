<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: config.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

Class Sh404sefControllerConfig extends Sh404sefClassBaseEditcontroller {

  protected $_context = 'com_sh404sef.config';
  protected $_defaultModel = 'config';
  protected $_defaultView = 'config';
  protected $_defaultController = 'config';
  protected $_defaultTask = '';
  protected $_defaultLayout = 'default';

  protected $_returnController = '';
  protected $_returnTask = '';
  protected $_returnView = '';
  protected $_returnLayout = '';

  protected $_editController = 'config';
  protected $_editTask = '';
  protected $_editLayout = 'default';

  /**
   * performs saving of configuration,
   * using the ad-hoc model
   */
  protected function _doSave( $dataArray) {

    // get model
    $model = $this->getModel( $this->_defaultView);

    // get current layout
    $layout = JRequest::getCmd( 'layout', 'default');

    // and store it into model
    $model->set( '_layout', $layout);

    // perform save operation
    $model->save( $dataArray);

    // store error message
    $error = $model->getError();
    if (!empty( $error)) {
      $this->setError( $error);
    }

    // return result
    return empty( $error);

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

}