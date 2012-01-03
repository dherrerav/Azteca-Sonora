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

class Sh404sefViewUrls extends JView {

  // we are in 'urls' view
  protected $_context = 'urls';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();

    $context = $model->setContext( $this->_context . '.' . $this->getLayout());

    // display type: simple for very large sites/slow slq servers
    $sefConfig = & Sh404sefFactory::getConfig();
    
    // if set for a slowServer, display simplified version of the url manager
    $this->assign( 'slowServer', $sefConfig->slowServer);
    
    // read data from model
    $list = &$model->getList( (object) array('layout' => $this->getLayout(), 'simpleUrlList' => $this->slowServer, 'slowServer' => $sefConfig->slowServer));

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'pagination', $model->getPagination( (object) array('layout' => $this->getLayout(), 'simpleUrlList' => $this->slowServer, 'slowServer' => $sefConfig->slowServer)));
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));

    // add behaviors and styles as needed
    $modalSelector = 'a.modalediturl';
    $js= '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) {parent.window.location=\''. $this->defaultRedirectUrl .'\';window.parent.shReloadModal=true}}';
    $params = array( 'overlayOpacity' => 0, 'classWindow' => 'sh404sef-popup', 'classOverlay' => 'sh404sef-popup', 'onClose' => $js);
    Sh404sefHelperHtml::modal( $modalSelector, $params);

    // build the toolbar
    $toolbarMethod = '_makeToolbar' . ucfirst( $this->getLayout());
    if (is_callable( array( $this, $toolbarMethod))) {
      $this->$toolbarMethod( $params);
    }

    // add our own css
    JHtml::styleSheet( 'urls.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

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
  private function _makeToolbarDefault( $params = null) {

    $mainframe =& JFactory::getApplication();

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText::_( 'COM_SH404SEF_SEF_URL_LIST'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // add "New url" button
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['size'] =array('x' =>700, 'y' => 500);
    $js= '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) parent.window.location=\''. $this->defaultRedirectUrl .'\';window.parent.shReloadModal=true}';
    $params['onClose'] = $js;
    $bar->appendButton( 'Shpopupbutton', 'new', JText::_('New'), "index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component", $params);

    // add edit button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>700, 'y' => 500);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'edit', $url, JText::_( 'Edit'), $msg='', $task='edit', $list = true, $hidemenu=true, $params);

    // add delete with duplicates button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdeletedeldup&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'deletedeldup', $url, JText::_( 'COM_SH404SEF_DELETE_URLS_WITH_DUP'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);
    
    // add delete button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 400);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=urls';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'import', $url, JText::_( 'COM_SH404SEF_IMPORT_BUTTON'), $msg='', $task='import', $list = false, $hidemenu=true, $params);

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=urls';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'COM_SH404SEF_EXPORT_BUTTON'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add purge and purge selected  buttons
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'purge', $url, JText::_( 'COM_SH404SEF_PURGE'), $msg=JText::_('VALIDDELETEITEMS', true), $task='purge', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // edit home page button
    $params['class'] = 'modalediturl';
    $params['size'] =array('x' =>700, 'y' => 500);
    $js= '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) parent.window.location=\''. $this->defaultRedirectUrl .'\';window.parent.shReloadModal=true}';
    $params['onClose'] = $js;
    $bar->appendButton( 'Shpopupbutton', 'home', JText::_( 'COM_SH404SEF_HOME_PAGE_ICON'), "index.php?option=com_sh404sef&c=editurl&task=edit&home=1&tmpl=component", $params);

    // separator
    JToolBarHelper::divider();

  }


  /**
   * Create toolbar for 404 pages template
   *
   * @param midxed $params
   */
  private function _makeToolbarView404( $params = null) {

    $mainframe =& JFactory::getApplication();

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // and connect to our buttons
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText::_( 'COM_SH404SEF_404_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // add edit button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>700, 'y' => 500);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'edit', $url, JText::_( 'Edit'), $msg='', $task='edit', $list = true, $hidemenu=true, $params);

    // add delete button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete404&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='delete', $list = true, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=view404';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'Export'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();
    
    // add purge and purge selected  buttons
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge404&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'purge', $url, JText::_( 'COM_SH404SEF_PURGE'), $msg=JText::_('VALIDDELETEITEMS', true), $task='purge', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

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

    // select duplicates
    $current = $options->filter_duplicate;
    $name = 'filter_duplicate';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_DUPLICATES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DUPLICATES, 'title' => JText::_('COM_SH404SEF_ONLY_DUPLICATES'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DUPLICATES, 'title' =>JText::_('COM_SH404SEF_ONLY_NO_DUPLICATES'))
    );
    $selects->filter_duplicate = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select aliases
    $current = $options->filter_alias;
    $name = 'filter_alias';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_ALIASES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_ALIASES, 'title' => JText::_('COM_SH404SEF_ONLY_ALIASES'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_ALIASES, 'title' =>JText::_('COM_SH404SEF_ONLY_NO_ALIASES'))
    );
    $selects->filter_alias = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select custom
    $current = $options->filter_url_type;
    $name = 'filter_url_type';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_URL_TYPES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText::_('COM_SH404SEF_ONLY_CUSTOM'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText::_('COM_SH404SEF_ONLY_AUTO'))
    );
    $selects->filter_url_type = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // return set of select lists
    return $selects;
  }

}