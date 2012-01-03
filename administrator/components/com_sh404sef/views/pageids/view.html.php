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

class Sh404sefViewPageids extends JView {

  // we are in 'urls' view
  protected $_context = 'pageids';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');
    $context = $model->setContext( $this->_context . '.' . $this->getLayout());

    // display type: simple for very large sites/slow slq servers
    $sefConfig = & Sh404sefFactory::getConfig();
    
    // store it
    $model = &$this->setModel( $model, true);

    // read data from model
    $list = &$model->getList( (object) array('layout' => $this->getLayout(), 'getPageId' => true, 'simpleUrlList' => true, 'slowServer' => $sefConfig->slowServer));

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'pagination', $model->getPagination( (object) array('layout' => $this->getLayout(), 'getPageId' => true, 'simpleUrlList' => true, 'slowServer' => $sefConfig->slowServer)));
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));
    $this->assign( 'helpMessage', JText::_('COM_SH404SEF_PAGEID_HELP'));

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
    JHtml::styleSheet( 'list.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

    // link to  custom javascript
    JHtml::script( 'list.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');
    JHtml::script( 'metas.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

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

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add title
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText::_( 'COM_SH404SEF_PAGEIDS_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $mainframe->set('JComponentTitle', $title);

    // get toolbar object
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');

    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 400);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=pageids';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'import', $url, JText::_( 'COM_SH404SEF_IMPORT_BUTTON'), $msg='', $task='import', $list = false, $hidemenu=true, $params);
    
    // add import button
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=pageids';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'export', $url, JText::_( 'COM_SH404SEF_EXPORT_BUTTON'), $msg='', $task='export', $list = false, $hidemenu=true, $params);

    // separator
    JToolBarHelper::divider();

    // add delete button as an ajax call
    $params['class'] = 'modaltoolbar';
    $params['size'] =array('x' =>500, 'y' => 300);
    unset( $params['onClose']);
    $url = 'index.php?option=com_sh404sef&c=pageids&task=confirmdelete&tmpl=component';
    $bar->appendButton( 'Shpopuptoolbarbutton', 'delete', $url, JText::_( 'Delete'), $msg=JText::_('VALIDDELETEITEMS', true), $task='purgeselected', $list = true, $hidemenu=true, $params);
    
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

    // select custom
    $current = $options->filter_url_type;
    $name = 'filter_url_type';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_URL_TYPES');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText::_('COM_SH404SEF_ONLY_CUSTOM'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText::_('COM_SH404SEF_ONLY_AUTO'))
    );
    $selects->filter_url_type = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);
    
    // select title
    $current = $options->filter_title;
    $name = 'filter_title';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_TITLE');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_TITLE, 'title' => JText::_('COM_SH404SEF_ONLY_TITLE'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_TITLE, 'title' =>JText::_('COM_SH404SEF_NO_TITLE'))
    );
    $selects->filter_title = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // select description
    $current = $options->filter_desc;
    $name = 'filter_desc';
    $selectAllTitle = JText::_('COM_SH404SEF_ALL_DESC');
    $data = array(
    array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DESC, 'title' => JText::_('COM_SH404SEF_ONLY_DESC'))
    ,array( 'id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DESC, 'title' =>JText::_('COM_SH404SEF_NO_DESC'))
    );
    $selects->filter_desc = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

    // return set of select lists
    return $selects;
  }

}