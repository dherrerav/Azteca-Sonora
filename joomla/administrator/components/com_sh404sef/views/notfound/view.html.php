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

class Sh404sefViewNotfound extends JView {

  // we are in 'urls' view
  protected $_context = 'notfound';

  public function display( $tpl = null) {

    // get model and update context with current
    $model = &$this->getModel();
    $context = $model->updateContext( $this->_context . '.' . $this->getLayout());

    // get url id
    $notFoundUrlId = JRequest::getInt('notfound_url_id');

    // read url data from model. This is the 404 request we want to
    // redirect to something else
    // must be called before model->getList()
    $url = &$model->getUrl( $notFoundUrlId);

    // and push url into the template for display
    $this->assign( 'url', $url);

    // attach data, according to specific layout requested
    $methodName = '_attachData' . ucfirst( $this->getLayout());
    if (is_callable( array( $this, $methodName))) {
      $this->$methodName();
    }

    // build the toolbar
    $methodName = '_makeToolbar' . ucfirst( $this->getLayout());
    if (is_callable( array( $this, $methodName))) {
      $this->$methodName();
    }

    // add confirmation phrase to toolbar
    $this->assign( 'toolbarTitle', Sh404sefHelperGeneral::makeToolbarTitle( JText::_('COM_SH404SEF_NOT_FOUND_SELECT_REDIRECT'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title'));

    // insert needed css files
    $this->_addCss();

    // link to  custom javascript
    JHtml::script( 'notfound.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

    // now display normally
    parent::display($tpl);

  }

  /**
   * Push data needed for display into the view
   * for the default layout
   */
  private function _attachDataDefault() {

    // get a notFound model
    $model = &$this->getModel();

    // current options
    $options = (object) array('layout' => $this->getLayout());

    // check if we have similar urls, if not switch to displaying all SEF
    // make sure we use latest user state
    $model->updateContextData();
    $filters = $model->getDisplayOptions();
    if($filters->filter_similar_urls) {
      $total = $model->getTotal($options);
      if(empty($total)) {
        // switch to show all SEF
        $model->setDisplayOptions( 'filter_similar_urls', 0);

        // reset data in model, as it has been cached from getting the total
        $model->resetData();

        // and add a message to tell user
        $this->assign('alertMsg', JText::_('COM_SH404SEF_NOT_FOUND_SWITCHING_TO_DISPLAY_ALL_SEF'));
      }
    }


    // read data from model
    $list = &$model->getList( $options);

    // and push it into the view for display
    $this->assign( 'items', $list);
    $this->assign( 'itemCount', count( $this->items));
    $this->assign( 'pagination', $model->getPagination($options));
    $options = $model->getDisplayOptions();
    $this->assign( 'options', $options);
    $this->assign( 'optionsSelect', $this->_makeOptionsSelect( $options));

    // additional text displayed
    $this->mainTitle = JText::_('COM_SH404SEF_NOT_FOUND_SELECT_REDIRECT_FOR');
  }

  /**
   * Create toolbar for current view
   *
   * @param midxed $params
   */
  private function _makeToolbarDefault( $params = null) {

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add save button as an ajax call
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['id'] = 'modalediturlsave';
    $params['closewindow'] = 1;
    $bar->appendButton( 'Shajaxbutton', 'selectnfredirect', JText::_('COM_SH404SEF_NOT_FOUND_SELECT_REDIRECT'), "index.php?option=com_sh404sef&c=notfound&task=selectnfredirect&shajax=1&tmpl=component", $params);

    // other button are standards
    $bar->appendButton( 'Standard', 'back', JText::_('COM_SH404SEF_BACK_TO_NOT_FOUND'), 'backPopup', false, false );

    // push in to the view
    $this->assignRef( 'toolbar', $bar);

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

    // select similar urls or all
    $current = $options->filter_similar_urls;
    $name = 'filter_similar_urls';
    $data = array(
    array( 'id' => 1, 'title' => JText::_('COM_SH404SEF_NOT_FOUND_SHOW_SIMILAR_URLS'))
    ,array( 'id' => 0, 'title' => JText::_('COM_SH404SEF_NOT_FOUND_SHOW_ALL_URLS'))
    );
    $selects->filter_similar_urls = Sh404sefHelperHtml::buildSelectList( $data, $current, $name, $autoSubmit = true, $addSelectAll = false);

    // return set of select lists
    return $selects;
  }

}