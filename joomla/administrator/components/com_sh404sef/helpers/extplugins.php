<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: extplugins.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperExtplugins {

  public static function loadJoomsefCompatLibs() {

    $basePath = self::_getBasePath( 'joomsef');

    include_once $basePath . DS . 'config.php';
    include_once $basePath . DS . 'seftools.php';
    include_once $basePath . DS . 'tables' . DS . 'extension.php';
    include_once $basePath . DS . 'joomsef.php';
    include_once $basePath . DS . 'sef.ext.php';

  }

  public static function loadAcesefCompatLibs() {

    $basePath = self::_getBasePath( 'acesef');

    //  define base path
    if(!defined('JPATH_ACESEF_ADMIN')) {
      define('JPATH_ACESEF_ADMIN', $basePath);
    }

    //
    include_once $basePath . DS . 'utility.php';
    include_once $basePath . DS . 'factory.php';
    include_once $basePath . DS . 'extension.php';
    include_once $basePath . DS . 'database.php';
    include_once $basePath . DS . 'uri.php';

  }

  /**
   * Acesef stores language strings for its plugins
   * inside its own language file. If displaying
   * the parameter form for one of the Acesef plugins
   * we load a (partial) copy of this language file
   * Joomsef does not use language files for its plugins
   */
  public static function loadLanguageFiles() {

    $app = &JFactory::getApplication();
    $option = JRequest::getCmd( 'option');
    $task = JRequest::getCmd( 'task');
    if( $app->isAdmin() && $option == 'com_plugins' && $task == 'edit') {
      // identify the plugin
      $cid = JRequest::getVar( 'cid');
      $id = intval($cid[0]);
      // is it ours ? well, theirs ?
      $filename = '';
      $plgTable = &JTable::getInstance( 'plugin');
      $loaded = $plgTable->load( $id);
      if($loaded) {
        if($plgTable->folder == 'sh404sefextacesef') {
          $filename = 'com_sh404sef.acesef';
        }
        /*if($plgTable->folder == 'sh404sefextjoomsef') {
         $filename = 'com_sh404sef.joomsef';
         }*/
        // load a custom language file
        if(!empty( $filename)) {
          $language = &JFactory::getLanguage();
          $language->load($filename, JPATH_ADMINISTRATOR);
        }
      }
    }
  }

  /**
   * Loads custom install adapters, allowing
   * installation of Acesef and Joomsef custom plugins
   * as regular Joomla plugins
   *
   */
  public static function loadInstallAdapters() {

    $app = &JFactory::getApplication();
    $option = JRequest::getCmd( 'option');

    if($app->isAdmin() && $option == 'com_installer') {
      // Get the installer instance
      jimport( 'joomla.installer.installer' );
      $installer =& JInstaller::getInstance();
      $db = JFactory::getDbo();

      // create a Joomsef adapter
      $joomsefAdapter = new Sh404sefAdapterJoomsefinstaller( $installer, $db);
      $installer->setAdapter( 'sef_ext', $joomsefAdapter);

      // create an Acesef adapter
      $acesefAdapter = new Sh404sefAdapterAcesefinstaller( $installer, $db);
      $installer->setAdapter( 'acesef_ext', $acesefAdapter);
    }
  }

  protected static function _getBasePath( $extension) {

    return JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_sh404sef' . DS . 'lib' . DS . 'extplugins' . DS . $extension;
  }

}