<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewConfirm extends JView {

  // we are in 'editurl' view
  protected $_context = 'confirm';

  public function display( $tpl = null) {

    // if redirecting to another page, we need to simply send some javascript
    // to : a / close the popup, b / redirect the parent page to where we
    // want to go
    if (!empty( $this->redirectTo)) {
      $js = 'window.addEvent( \'domready\', function () {
      setTimeout( \'shRedirectTo()\', 2000);
    });
    function shRedirectTo() {
      parent.window.location="' . $this->redirectTo .'";
      window.parent.SqueezeBox.close();
    }
    
    ';
      $document = & JFactory::getDocument();
      $document->addScriptDeclaration( $js);

      // insert needed css files
      $this->_addCss();

    } else {

      // get action
      $this->task = empty( $this->task) ? 'delete' : $this->task;
      
      // build the toolbar
      $toolBar = $this->_makeToolbar();
      $this->assignRef( 'toolbar', $toolBar);

      // add confirmation phrase to toolbar
      $this->assign( 'toolbarTitle', '<div class="headerconfirm" >' . JText::_('COM_SH404SEF_CONFIRM_TITLE') . '</div>');

      // insert needed css files
      $this->_addCss();

      // link to  custom javascript
      JHtml::script( 'edit.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');
    }
     
    // now display normally
    parent::display($tpl);

  }

  /**
   * Create toolbar for current view
   *
   * @param midxed $params
   */
  private function _makeToolbar( $params = null) {

    // if redirect is set, no toolbar
    if (!empty( $this->redirectTo)) {
      return;
    }
    
    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add save button as an ajax call
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['id'] = 'modalconfirmconfirm';
    $params['closewindow'] = 1;
    $bar->appendButton( 'Shajaxbutton', $this->task, JText::_('Delete'), 'index.php?option=com_sh404sef&c=editurl&shajax=1&tmpl=component&task=' . $this->task, $params);

    // other button are standards
    JToolBarHelper::spacer();
    JToolBarHelper::divider();
    JToolBarHelper::spacer();
    // we cannot use Joomla's cancel button from a popup, as they use href="#" which causes the page to load in parallel with
    // closing of the popup. Need use href="javascript: void(0);"
    $bar->appendButton( 'Shpopupstandardbutton', 'cancel', JText::_('Cancel'), $task='cancel', $list = false);

    return $bar;
  }

  private function _addCss() {

    // add link to css
    JHtml::styleSheet( 'icon.css', 'administrator/templates/bluestork/css/');
    JHtml::styleSheet( 'rounded.css', 'administrator/templates/bluestork/css/');
    JHtml::styleSheet( 'system.css', 'administrator/templates/system/css/');
    $customCss = '
    <!--[if IE 7]>
<link href="templates/bluestork/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="templates/bluestork/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->';
    // insert using addCustomtag, so that J! does not add any markup
    $document = & JFactory::getDocument();
    $document->addCustomTag( $customCss);

    // add our own css
    JHtml::styleSheet( 'confirm.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');
  }

}
