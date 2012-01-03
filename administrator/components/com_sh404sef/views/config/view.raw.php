<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.raw.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewConfig extends JView {

  public function display( $tpl = null) {


    $layout = JRequest::getCmd( 'layout', 'default');

    switch ($layout) {

      case 'qcontrol':
        $this->_doQuickControl($tpl);
        break;
      default:
        $this->_doDefault($tpl);
        break;

    }
  }

  /**
   * Ajax response handler for any configuration dialog
   * except quick control panel
   *
   * @param string $tpl
   */
  private function _doDefault($tpl) {

    // use Joomla wml object
    jimport( 'joomla.utilities.simplexml');

    // prepare elements of respn
    $this->assign( 'taskexecuted', $this->getLayout());
    $errors = $this->getError();
    $task = JRequest::getCmd( 'task');
    switch ( $task) {
      case 'apply' :
        // applying : dialog box not going to be closed
        if(($this->taskexecuted == 'default' || $this->taskexecuted == 'ext') && empty( $errors)) {
          // no errors, insert success messages
          $this->assign( 'message', '<li>'.JText::_('COM_SH404SEF_ELEMENT_SAVED') . '.</li><br /><li>' .JText::_('COM_SH404SEF_MAY_NEED_PURGE_DIALOGBOX') . '</li>');
        } else if (empty( $errors)) {
          $this->assign( 'message', JText::_('COM_SH404SEF_ELEMENT_SAVED'));
        }
        break;
      case 'save' :
        // box is going to be close, we want to redirect so that message is displayed
        if(($this->taskexecuted == 'default' || $this->taskexecuted == 'ext') && empty( $errors)) {
          // no errors, tell user they must purge urls
          $messagecode = 'COM_SH404SEF_MAY_NEED_PURGE';
        } else if (empty( $errors)) {
          // no errors, but no need to purge : seo settings, security settings, etc
          $messagecode = 'COM_SH404SEF_ELEMENT_SAVED';
        }
        $this->assign( 'redirectTo', $this->defaultRedirectUrl);
        $this->assign( 'messagecode', $messagecode);
        break;
    }

    // use helper to prepare response
    $response = Sh404sefHelperGeneral::prepareAjaxResponse( $this);

    // declare docoument mime type
    $document = &JFactory::getDocument();
    $document->setMimeEncoding( 'text/xml');

    // output resulting text, no need for a layout file I think
    echo $response;

  }

  private function _doQuickControl($tpl) {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // push any message
    $error= $this->getError();
    if(empty($error)) {
      $noMsg= JRequest::getInt('noMsg', 0);
      if (empty( $noMsg)) {
        $this->assign( 'message', JText::_( 'COM_SH404SEF_ELEMENT_SAVED'));
      }
    }

    parent::display($tpl);

  }


}
