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

class Sh404sefViewAliases extends JView {

  // we are in 'urls' view
  protected $_context = 'aliases';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();
    $context = $model->setContext( $this->_context . '.' . $this->getLayout());

    // read data from model
    $list = &$model->getList( (object) array('layout' => $this->getLayout()));

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'pagination', $model->getPagination());
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));
    $this->assign( 'helpMessage', JText::_('COM_SH404SEF_ALIASES_HELP_NEW_ALIAS'));

    // add behaviors and styles as needed
    $modalSelector = 'a.modalediturl';
    $js= '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) {parent.window.location=\''. $this->defaultRedirectUrl .'\';window.parent.shReloadModal=true}}';
    $params = array( 'overlayOpacity' => 0, 'classWindow' => 'sh404sef-popup', 'classOverlay' => 'sh404sef-popup', 'onClose' => $js);
    Sh404sefHelperHtml::modal( $modalSelector, $params);

    // build the toolbar
    $toolBar = $this->_makeToolbar();

    // insert needed css files
    $this->_addCss();

    // link to  custom javascript
    JHtml::script( 'list.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

    // now display normally
    parent::display($tpl);

  }

  /**
   * Create toolbar for default layout view
   *
   * @param midxed $params
   */
  private function _makeToolbar( $params = null) {

    $mainframe =& JFactory::getApplication();

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText::_( 'COM_SH404SEF_ALIASES_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // add "New url" button
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');

    // add edit button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>700, 'y' => 500);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editalias&task=edit&tmpl=component&view=editurl&startOffset=2';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'edit', $url, JText::_( 'Edit'), $msg='', $task='edit', $list = true, $hidemenu=true, $params);

    // add delete button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editalias&task=confirmdelete&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 400);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=aliases';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'import', $url, JText::_( 'COM_SH404SEF_IMPORT_BUTTON'), $msg='', $task='import', $list = false, $hidemenu=true, $params);

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=aliases';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'COM_SH404SEF_EXPORT_BUTTON'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();
    
    // edit home page button
    $params['class'] = 'modalediturl';
    $params['size'] =array('x' =>700, 'y' => 500);
    $js= '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) parent.window.location=\''. $this->defaultRedirectUrl .'\';window.parent.shReloadModal=true}';
    $params['onClose'] = $js;
    $bar->appendButton( 'Shpopupbutton', 'home', JText::_( 'COM_SH404SEF_HOME_PAGE_ICON'), "index.php?option=com_sh404sef&c=editalias&task=edit&view=editurl&home=1&tmpl=component&startOffset=1", $params);

    // separator
    JToolBarHelper::divider();

  }

  private function _addCss() {

    // add link to css
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
    JHtml::styleSheet( 'list.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');
  }

  private function _makeOptionsSelect( $options) {

    $selects = new StdClass();

    // component list
    $current = $options->filter_component;
    $name = 'filter_component';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_COMPONENTS');
    $selects->components = Sh404sefHelperHtml::buildComponentsSelectList( $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // language list
    $current = $options->filter_language;
    $name = 'filter_language';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_LANGUAGES');
    $selects->languages = Sh404sefHelperHtml::buildLanguagesSelectList( $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // return set of select lists
    return $selects;
  }

}