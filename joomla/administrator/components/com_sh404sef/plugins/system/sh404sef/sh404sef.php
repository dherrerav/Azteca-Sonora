<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404sef.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * sh404SEF system plugin
 *
 * @author
 */
class  plgSystemSh404sef extends JPlugin {

  static $_template = '';

  public function onAfterInitialise() {

    // prevent warning on php5.3+
    $this->_fixTimeWarning();

    // get joomla application object
    $app = &JFactory::getApplication();

    // register our autoloader
    $this->_registerAutoloader();

    require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php');

    // get our configuration
    $sefConfig = & Sh404sefFactory::getConfig();

    if (!$app->isAdmin() && $sefConfig->shSecEnableSecurity) {
      require_once(JPATH_ROOT.DS.'components'.DS.'com_sh404sef'.DS.'shSec.php');
      // do security checks
      shDoSecurityChecks();
      shCleanUpSecLogFiles(); // see setting in class file for clean up frequency
    }

    // optionnally collect page creation time
    if (!$app->isAdmin() && $sefConfig->analyticsEnableTimeCollection) {
      jimport( 'joomla.error.profiler' );
      // creating the profiler object will start the counter
      $profiler =& JProfiler::getInstance( 'sh404sef_profiler' );
    }

    // load plugins, as per configuration
    $this->_loadPlugins( $type = 'sh404sefcore');

    // load extension plugins, created by others
    $this->_loadPlugins( $type = 'sh404sefext');

    // hook to be able to install other SEF extension plugins
    Sh404sefHelperExtplugins::loadInstallAdapters();

    // another hook to allow other SEF extensions language file to be loaded
    Sh404sefHelperExtplugins::loadLanguageFiles();

    if (!$sefConfig->Enabled) {  // go away if not enabled
      return;
    }

    if (!defined('SH404SEF_IS_RUNNING')) {
      DEFINE ('SH404SEF_IS_RUNNING', 1);
    }

    if (!$app->isAdmin()) {
      // setup our JPagination replacement, so as to bring
      // back # of items per page in the url, in order
      // to properly calculate pagination
      // will only work if php > 5, so test for that
      if (version_compare( phpversion(), '5.0' ) >= 0) {
        // this register the old file, but do not load it if PHP5
        // will prevent further calls to the same jimport()
        // to actually do anything, because the 'joomla.html.pagination' key
        // is now registered statically in Jloader::import()
        jimport( 'joomla.html.pagination');
        // now we can register our own path
        JLoader::register( 'JPagination', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'pagination.php');

      }

      // attach parse and build rules to Joomla router
      $joomlaRouter = $app->getRouter();
      $pageInfo = & Sh404sefFactory::getPageInfo();
      $pageInfo->router = new Sh404sefClassRouter();
      $joomlaRouter->attachParseRule( array( $pageInfo->router, 'parseRule'));
      $joomlaRouter->attachBuildRule( array( $pageInfo->router, 'buildRule'));
      
      // forece J! router config to SEF if at least one of the installed
      // components has been set to use raw J! router
      if(!empty(Sh404sefFactory::getConfig()->useJoomlaRouter)) {
        $joomlaRouter->setMode( JROUTER_MODE_SEF);
      }

      // pretend SEF is on, mostly for Joomla SEF plugin to work
      // as it checks directly 'sef' value in config, instead of
      // usgin $router->getMode()
      JFactory::$config->set('sef', 1);
      
      // kill Joomla suffix, so that it doesn't add or remove it in the parsing/building process
      JFactory::$config->set('sef_suffix', 0);
      
      // we use opposite setting from J!
      $mode = 1 - $sefConfig->shRewriteMode;
      JFactory::$config->set( 'sef_rewrite', $mode);

      // perform startup operations, such as detecting request caracteristics
      // and checking redirections
      $pageInfo->router->startup( JURI::getInstance());

    }
  }

  /**
   * Various operations :
   *  - load our plugins
   * @return unknown_type
   */
  public function onAfterRoute() {

    $app = &JFactory::getApplication();

    if (defined( 'SH404SEF_IS_RUNNING') && !$app->isAdmin()) {

      // reset Joomla router, as we temporarily changed
      // routing mode to avoid Joomla own request parsing code
      // while we use ours
      $app->getRouter()->setMode( JROUTER_MODE_SEF);

      // set template, to perform alternate template output, if set to
      $this->_setAlternateTemplate();

    }

  }

  public function onAfterDispatch() {

    $app = &JFactory::getApplication();

    if (!$app->isAdmin() && defined( 'SH404SEF_IS_RUNNING')) {

      // reset alternate template
      $this->_resetAlternateTemplate();

      // create shurl on the fly for this page
      // if not already done
      if (JFactory::getDocument()->getType() == 'html') {
        // shortlinks
        Sh404sefHelperShurl::updateShurls();
      }
    }
  }

  /* page rewriting features */
  public function onAfterRender() {

    if (JFactory::getApplication()->isAdmin()) {
      return;
    }

    $sefConfig = Sh404sefFactory::getConfig();

    // return if no seo optim to perform
    if ($sefConfig->shMetaManagementActivated || $sefConfig->analyticsEnabled) {  // go away if not enabled
      $include = JPATH_ROOT.DS.'components'.DS.'com_sh404sef'.DS.'shPageRewrite.php';
      require_once( $include);
    }
     
  }

  /**
   * Load and register the plugins currently activated by webmaster
   *
   * @return none
   */
  protected function _loadPlugins( $type)  {

    // required joomla library
    jimport( 'joomla.plugin.helper.php');

    // import the plugin files
    $status = JPluginHelper::importPlugin( $type);

    return $status;

  }

  /**
   * Register our autoloader function with PHP
   */
  protected function _registerAutoloader() {

    // get Joomla autloader out
    spl_autoload_unregister("__autoload");

    // add our own
    include JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_sh404sef' . DS . 'helpers' . DS . 'autoloader.php';
    $registered = spl_autoload_register(array('Sh404sefAutoloader', 'doAutoload'));

    // stitch back Joomla's at the end of the list
    if(function_exists("__autoload")) {
      spl_autoload_register("__autoload");
    }

  }

  protected function _fixTimeWarning() {
    // prevent timezone not set warnings to appear all over,
    // especially for PHP 5.3.3+
    $serverTimezone = @date_default_timezone_get();
    @date_default_timezone_set( $serverTimezone);
  }

  protected function _setAlternateTemplate() {

    $app = JFactory::getApplication();
    $sefConfig = Sh404sefFactory::getConfig();

    if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED') && !empty($sefConfig->alternateTemplate)) { // global on/off switch
      self::$_template = $app->getTemplate(); // save current template
      $app->setTemplate( $sefConfig->alternateTemplate);
    }
  }

  protected function _resetAlternateTemplate() {

    $app = JFactory::getApplication();
    $sefConfig = Sh404sefFactory::getConfig();

    if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED') && !empty($sefConfig->alternateTemplate)) { // global on/off switch
      if (empty(self::$_template)) {
        return;
      }
      $app->setTemplate(self::$_template);  // restore old template
    }
  }

}

