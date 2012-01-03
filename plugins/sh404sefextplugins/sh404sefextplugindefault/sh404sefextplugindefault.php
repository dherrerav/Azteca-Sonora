<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404sefextplugindefault.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Default extension handler plugin: will look for sh404sef
 * plugin first in extension dir, then in sh404sef own dir
 * then will try to use router.php
 * then, only if set to, wil try to use Joomsef or Acesef plugin
 * then will fall back to simple url encoding
 *
 * @author Yannick Gaultier
 */
class  Sh404sefExtpluginDefault extends Sh404sefClassBaseextplugin {

  protected $_extName = 'default';

  public function __construct( $option, $config) {

    // call parent to store config and option
    parent::__construct($option, $config);

  }

  protected function _findSefPluginPath( $nonSefVars = array()) {

    $this->_sefPluginPath = '';

    // check for Joomsef plugin
    if( in_array( $this->_optionNoCom, $this->_config->useJoomsefRouter)) {
      // check if file exists, store path if it does
      $path = sh404SEF_ABS_PATH . 'plugins/sh404sefextjoomsef/'.$this->_option.'.php';
      if ( shFileExists($path)) {
        $this->_sefPluginPath = $path;
        $this->_pluginType = Sh404sefClassBaseextplugin::TYPE_JOOMSEF_ROUTER;
      }
    }

    // check for Acesef plugin
    if( empty( $this->_sefPluginPath) && in_array( $this->_optionNoCom, $this->_config->useAcesefRouter)) {
      // check if file exists, store path if it does
      $path = sh404SEF_ABS_PATH .'plugins/sh404sefextacesef/'.$this->_option.'.php';
      if ( shFileExists($path)) {
        $this->_sefPluginPath = $path;
        $this->_pluginType = Sh404sefClassBaseextplugin::TYPE_ACESEF_ROUTER;
      }
    }

    // read
    $useExtensionPlugin = in_array( $this->_optionNoCom, $this->_config->shDoNotOverrideOwnSef);

    // look first in component owndir for a joomla sef router.php file
    $path = sh404SEF_ABS_PATH.'components/'.$this->_option.'/router.php';
    $pathSh404sefExtPlugin = sh404SEF_ABS_PATH.'components/'.$this->_option.'/sef_ext/'.$this->_option.'.php';
    $pathSh404sefBuiltinPlugin = sh404SEF_ABS_PATH.'components/com_sh404sef/sef_ext/'.$this->_option.'.php';
    if (empty( $this->_sefPluginPath) &&  shFileExists( $path)
    && ($useExtensionPlugin                   // and param said use extension plugin
    || (!$useExtensionPlugin              // or param said do not use extension plugin BUT
    && !shFileExists( $pathSh404sefExtPlugin)  // we don't have any other plugin to use
    && !shFileExists($pathSh404sefBuiltinPlugin)))) {
      // use router.php
      $this->_sefPluginPath = $path;
      $this->_pluginType = Sh404sefClassBaseextplugin::TYPE_JOOMLA_ROUTER;
    }

    // not found yet, look into extension dir for an sh404sef native plugin
    if (empty( $this->_sefPluginPath) &&  shFileExists( $pathSh404sefExtPlugin)) {
      $this->_sefPluginPath = $pathSh404sefExtPlugin;
      $this->_pluginType = Sh404sefClassBaseextplugin::TYPE_SH404SEF_ROUTER;

    }

    // not found yet, look into sh404sef dir for an sh404sef native plugin
    if (empty( $this->_sefPluginPath) &&  shFileExists( $pathSh404sefBuiltinPlugin)) {
      $this->_sefPluginPath = $pathSh404sefBuiltinPlugin;
      $this->_pluginType = Sh404sefClassBaseextplugin::TYPE_SH404SEF_ROUTER;

    }

  }

  protected function _findMetaPluginPath( $nonSefVars = array()) {

    $this->_metaPluginPath = '';

    // read setting: use extension plugin or our own?
    // we use same setting as for SEF urls
    $useExtensionPlugin = in_array( $this->_optionNoCom, $this->_config->shDoNotOverrideOwnSef);

    // look first in component owndir for a meta ext file
    $path = sh404SEF_ABS_PATH.'components/'. $this->_option . '/meta_ext/'. $this->_option . '.php';
    if (shFileExists( $path) && $useExtensionPlugin) {
      // use router.php
      $this->_metaPluginPath = $path;
    }

    // then look for our own meta ext file, if any
    if (empty( $this->_metaPluginPath)) {
      $path = sh404SEF_ABS_PATH.'components/com_sh404sef/meta_ext/'. $this->_option . '.php';
      if(shFileExists( $path)) {
        // use router.php
        $this->_metaPluginPath = $path;
      }

    }
  }
}