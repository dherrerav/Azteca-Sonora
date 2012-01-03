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

class Sh404sefViewAnalytics extends JView {

  public function display( $tpl = null) {

    // prepare the view, based on request
    // do we force reading updates from server ?
    $options = Sh404sefHelperAnalytics::getRequestOptions();
    
    // push display options into template
    $this->assign('options', $options);
    
    // call report specific methods to get data
    $method = '_makeView' . ucfirst( $options['report']);
    if (is_callable( array( $this, $method))) {
      $this->$method( $tpl);
    }
    
    // flag to know if we should display placeholder for ajax fillin
    $this->assign( 'isAjaxTemplate', false);
    
    parent::display( $tpl);
  }

  /**
   * Prepare and display the control panel
   * dashboard, which is a simplified view
   * of main analytics results
   * 
   * @param string $tpl layout name
   */
  private function _makeViewDashboard( $tpl) {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // get analytics data using helper, possibly from cache
    $analyticsData = Sh404sefHelperAnalytics::getData( $this->options);

    // push analytics stats into view
    $this->assign( 'analytics', $analyticsData);

  }
  
}
