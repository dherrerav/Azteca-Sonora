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

class Sh404sefViewEditnotfound extends JView {

  // we are in 'editurl' view
  protected $_context = 'editnotfound';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();
    $context = $model->updateContext( $this->_context . '.' . $this->getLayout());

    // get url id
    $notFoundUrlId = JRequest::getInt('notfound_url_id');

    // read url data from model
    $url = &$model->getUrl( $notFoundUrlId);

    // and push url into the template for display
    $this->assign( 'url', $url);

    // build the toolbar
    $toolBar = $this->_makeToolbar();
    $this->assignRef( 'toolbar', $toolBar);

    // add title.
    $this->assign( 'toolbarTitle', Sh404sefHelperGeneral::makeToolbarTitle( JText::_( 'COM_SH404SEF_NOT_FOUND_ENTER_REDIRECT'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title'));

    // insert needed css files
    $this->_addCss();

    // link to  custom javascript
    JHtml::script( 'edit.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

    // add domready event
    $document = & JFactory::getDocument();

    // add tooltips
    JHTML::_('behavior.tooltip');

    // now display normally
    parent::display($tpl);

  }

  /**
   * Create toolbar for current view
   *
   * @param midxed $params
   */
  private function _makeToolbar( $params = null) {

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add save button as an ajax call
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['id'] = 'modalediturlsave';
    $params['closewindow'] = 1;
    $bar->appendButton( 'Shajaxbutton', 'save', 'Save', "index.php?option=com_sh404sef&c=editnotfound&task=save&shajax=1&tmpl=component", $params);

    // add apply button as an ajax call
    $params['id'] = 'modalediturlapply';
    $params['closewindow'] = 0;
    $bar->appendButton( 'Shajaxbutton', 'apply', 'Apply', "index.php?option=com_sh404sef&c=editnotfound&task=apply&shajax=1&tmpl=component", $params);

    // other button are standards
    $bar->appendButton( 'Standard', 'back', 'Back', 'back', false, false );
    JToolBarHelper::cancel( 'cancel');

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
    JHtml::styleSheet( 'editurl.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');
  }

}
