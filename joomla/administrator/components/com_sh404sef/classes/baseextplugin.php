<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baseextplugin.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.plugin.plugin' );

/**
 * Base extension handler plugin
 *
 * @author Yannick Gaultier
 */
class  Sh404sefClassBaseextplugin extends JPlugin {


  const TYPE_DEFAULT = 0;
  const TYPE_SKIP = 1;
  const TYPE_SIMPLE = 2;

  const TYPE_SH404SEF_ROUTER = 0; // do not change, must be 0 for compat reason
  const TYPE_JOOMLA_ROUTER = 1;  // do not change, must be 1 for compat reason

  const TYPE_JOOMSEF_ROUTER = 30;
  const TYPE_ACESEF_ROUTER = 40;
  const TYPE_NO_ROUTER = 100;
  const TYPE_OPENSEF_ROUTER = 101;

  protected $_componentType = null;
  protected $_pluginType = null;

  protected $_option = '';
  protected $_optionNoCom = '';
  protected $_extName = '';
  protected $_config = null;
  protected $_sefPluginPath = null;
  protected $_metaPluginPath = null;

  protected $_version = '';


  public function __construct( $option, $config) {

    $this->_option = $option;
    $this->_optionNoCom = str_replace('com_', '', $this->_option);
    $this->_config = $config;
    $this->_pluginType = self::TYPE_NO_ROUTER;

  }

  public function getComponentType() {

    if(is_null( $this->_componentType)) {
      switch ($this->_optionNoCom) {
        // leave urls non-sef
        case (in_array($this->_optionNoCom, $this->_config->skip)):
          $this->_componentType = self::TYPE_SKIP;
          break;
          // use simple encoding
        case (in_array($this->_optionNoCom, $this->_config->nocache)):
          $this->_componentType = self::TYPE_SIMPLE;
          break;
          // default handler, full sef
        default:
          $this->_componentType = self::TYPE_DEFAULT;
          break;
      }

      // now validate that type: if required plugin is not available,
      // we'll need to switch back to "simple
      if($this->_componentType == self::TYPE_DEFAULT) {
        $path = $this->getSefPluginPath();
        if(empty( $path)) {
          $this->_componentType = self::TYPE_SIMPLE;
        }
      }
    }
    return $this->_componentType;
  }

  public function getPluginType() {

    return $this->_pluginType;

  }

  public function getName() {

    return $this->_extName;
  }

  public function getVersion() {

    return $this->_version;
  }

  public function getSefPluginPath( $nonSefVars = array()) {

    if(is_null( $this->_sefPluginPath)) {
      $this->_findSefPluginPath( $nonSefVars);
    }

    return $this->_sefPluginPath;
  }

  public function getMetaPluginPath( $nonSefUrl = '') {

    if(is_null( $this->_metaPluginPath)) {
      $this->_findMetaPluginPath( $nonSefUrl);
    }

    return $this->_metaPluginPath;

  }


  protected function _findSefPluginPath( $nonSefVars = array()) {

    $this->_sefPluginPath = '';

  }

  protected function _findMetaPluginPath( $nonSefUrl = '') {

    $this->_metaPluginPath = '';

  }

}