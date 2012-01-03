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

class Sh404sefViewEditurl extends JView {

  // we are in 'editurl' view
  protected $_context = 'editurl';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();
    $context = $model->updateContext( $this->_context . '.' . $this->getLayout());

    // get url id
    $cid = JRequest::getVar('cid', array(0), 'default', 'array');
    $cid = intval($cid[0]);

    // get home page flag, and make sure id is 0 if editing home data
    $home = JRequest::getInt( 'home');
    if ($home == 1) {
      $cid = 0;
    }
    $this->assign( 'home', $home);
    
    // optional starting pane in case of tabbed edition
    $startOffset = JRequest::getInt( 'startOffset', 0);
    $this->assign( 'startOffset', $startOffset);

    // read url data from model
    $url = &$model->getById( $cid);

    // if editing home, set home url
    if ($this->home == 1) {
      $url->set( 'newurl', sh404SEF_HOMEPAGE_CODE);
    }

    // controllers may forbid to edit sef or non-sef urls
    $noUrlEditing = empty( $this->noUrlEditing) ? false : $this->noUrlEditing;
    $this->assign( 'noUrlEditing', $noUrlEditing);
    
    // and push url into the template for display
    $this->assign( 'url', $url);

    // we only allow editing of non-sef url for new urls, that is when non sef url field is empty
    // of for 404s, when we have a sef but no non-sef
    $newUrl = $url->get('newurl');
    $this->assign( 'canEditNewUrl', empty( $newUrl));

    // are we creating a new url rcord or editing an existing one
    $oldUrl = $url->get('oldurl');
    $existingUrl = !empty( $newUrl) || !empty( $newUrl);
    
    // now read meta for this url, using meta  model
    if ($existingUrl) {
      $metaModel = &JModel::getInstance( 'metas', 'Sh404sefModel');
      $metas = $metaModel->getList( (object) array('newurl' => $url->get('newurl') ), $returnZeroElement = true );
      $meta = $metas[0];
    } else {
      $meta = JTable::getInstance( 'metas', 'Sh404sefTable');
    }
    $this->assign( 'meta', $meta);

    // now read aliases for this url, using an aliases model
    if ($existingUrl) {
      $aliasModel = &JModel::getInstance( 'aliases', 'Sh404sefModel');
      $aliases = $aliasModel->getDisplayableList( (object) array('newurl' => $url->get('newurl') ) );
    } else {
      $aliases = '';
    }
    $this->assign( 'aliases', $aliases);

    // now read pageid for this url, using pageid model
    $pageidModel = &JModel::getInstance( 'pageids', 'Sh404sefModel');
    $pageids = $pageidModel->getList( (object) array('newurl' => $url->get('newurl') ), $returnZeroElement = true );
    $this->assign( 'pageid', $pageids[0]);

    // build the toolbar
    $toolBar = $this->_makeToolbar();
    $this->assignRef( 'toolbar', $toolBar);

    // add title. If there is an id, we are editing an existing url, or else we create a new one
    // other case : edting home page, there is a specific title
    if ($home == 1) {
      $title = JText::_( 'COM_SH404SEF_HOME_PAGE_EDIT_TITLE');
    } else {
      $title = $url->get('id') ? JText::_( 'COM_SH404SEF_EDIT_URL_TITLE') : JText::_('COM_SH404SEF_ADD_URL_TITLE');
    }
    $this->assign( 'toolbarTitle', Sh404sefHelperGeneral::makeToolbarTitle( $title, $icon = 'sh404sef', $class = 'sh404sef-toolbar-title'));

    // insert needed css files
    $this->_addCss();

    // link to  custom javascript
    JHtml::script( 'edit.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');
    
    // add domready event
    $document = & JFactory::getDocument();
    //$js = 'window.addEvent("domready", function(){ shAttachResizer();});';
    //$document->addScriptDeclaration( $js);

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
    $bar->appendButton( 'Shajaxbutton', 'save', 'Save', "index.php?option=com_sh404sef&c=editurl&task=save&shajax=1&tmpl=component", $params);
    
    // add apply button as an ajax call
    $params['id'] = 'modalediturlapply';
    $params['closewindow'] = 0;
    $bar->appendButton( 'Shajaxbutton', 'apply', 'Apply', "index.php?option=com_sh404sef&c=editurl&task=apply&shajax=1&tmpl=component", $params);

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
