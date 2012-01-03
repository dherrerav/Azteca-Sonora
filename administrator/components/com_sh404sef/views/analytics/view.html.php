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

class Sh404sefViewAnalytics extends JView {

  public function display( $tpl = null) {

    // prepare the view, based on request
    // do we force reading updates from server ?
    $options = Sh404sefHelperAnalytics::getRequestOptions();

    $method = '_makeView' . ucfirst( $options['report']);
    if (is_callable( array( $this, $method))) {
      $this->$method( $tpl);
    }

    // push display options into template
    $this->assign('options', $options);

    // add our javascript
    JHTML::script( 'cp.js', Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/');

    // add Joomla calendar behavior, needed to input start and end dates
    if ($options['showFilters'] == 'yes') {
      JHTML::_('behavior.calendar');
    }
    
    // add our own css
    JHtml::styleSheet( 'cp.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

    // add tooltips handler
    JHTML::_('behavior.tooltip');
    
    // add title
    $app = &JFactory::getApplication();
    $title = Sh404sefHelperGeneral::makeToolbarTitle( JText::_('COM_SH404SEF_ANALYTICS_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
    $app->set('JComponentTitle', $title);

    // add a div to display our ajax-call-in-progress indicator
    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $html = '<div id="sh-progress-cpprogress"></div>';
    $bar->appendButton( 'custom', $html, 'sh-progress-button-cpprogress');

    // add quick control panel loader
    $js = 'window.addEvent(\'domready\', function(){  shSetupAnalytics({report:" '. $options['report']. '"});});';
    $document = & JFactory::getDocument();
    $document->addScriptDeclaration( $js);

    // flag to know if we should display placeholder for ajax fillin
    $this->assign( 'isAjaxTemplate', true);

    parent::display($tpl = null);
  }

}