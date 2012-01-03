<?php
/**
 * SEF module for Joomla! 1.6+
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: installation.script.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
defined( '_JEXEC' ) or die;

/**
 * Installation/Uninstallation script
 *
 */

class Com_Sh404sefInstallerScript {

  private $_siteId = '';
  private $_preserveConfigFolder = '';

  public function install($parent) {
  }

  public function uninstall($parent) {

    $this->_doUninstall( $parent);

  }

  public function update($parent) {
  }

  public function preflight($type, $parent) {
  }

  public function postflight($type, $parent) {

    $this->_doInstallUpdate( $parent);

  }

  // Implementation of install/uninstall scripts

  private function _doInstallUpdate( $parent) {

    $this->_definePaths();
    $this->_includeLibs();


    // V 1.2.4.q Copy existing config file from /media to current component. Used to recover configuration when upgrading
    // V 1.2.4.s check if old file exists before deleting stub config file
    $oldConfigFile = $this->_preserveConfigFolder .'sh404_upgrade_conf_'.$this->_siteId .'.php';
    if (JFile::exists($oldConfigFile)) {
      // update old config files from VALID_MOS check to _JEXEC
      $config = JFile::read($oldConfigFile);
      if ($config && strpos( $config, 'VALID_MOS') !== false) {
        $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
        JFile::write( $oldConfigFile, $config);  // write it back
      }
      // now get back old config
      if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php')) {
        JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'config' . DS . 'config.sef.php');
      }
      JFile::copy( $oldConfigFile, JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'.DS.'config'.DS.'config.sef.php' );
    }

    // restore black/white lists
    $folder = $this->_preserveConfigFolder . 'sh404_upgrade_conf_security';
    if (JFolder::exists( $folder)) {
      $fileList = JFolder::files( $folder);
      if (!empty( $fileList)) {
        foreach( $fileList as $file) {
          if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file)) {
            JFile::delete(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
          }
          JFile::copy( $this->_preserveConfigFolder.'sh404_upgrade_conf_security'.DS.$file,
          JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security'.DS.$file);
        }
      }
    }
    // if upgrading rather than installing from scratch, or after an uninstall
    // we must not copy back saved configuration files and log files
    // as this would overwrite up to date current ones
    // note that above we restored main config file and
    // security data files becomes blank files come
    // with the extension, so they'll be deleted in any case
    // and we have to restore them
    $shouldRestore = $this->_shShouldRestore();

    if($shouldRestore) {
      // restore log files
      $folder = $this->_preserveConfigFolder .'sh404_upgrade_conf_logs';
      if (JFolder::exists( $folder)) {
        $fileList = JFolder::files( $folder);
        if (!empty( $fileList)) {
          foreach( $fileList as $file) {
            JFile::copy( $this->_preserveConfigFolder .'sh404_upgrade_conf_logs'.DS.$file,
            JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs'.DS.$file);
          }
        }
      }

      // restore customized default params
      $oldCustomConfigFile = $this->_preserveConfigFolder .'sh404_upgrade_conf_' . $this->_siteId . '.custom.php';
      if (is_readable($oldCustomConfigFile) && filesize($oldCustomConfigFile) > 1000) {
        // update old config files from VALID_MOS check to _JEXEC
        $config = JFile::read($oldCustomConfigFile);
        if ($config && strpos( $config, 'VALID_MOS') !== false) {
          $config = str_replace( 'VALID_MOS', '_JEXEC', $config);
          JFile::write( $oldCustomConfigFile, $config);  // write it back
        }
        if (JFile::exists( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php')) {
          JFile::delete(JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS .'custom.sef.php');
        }
        $result = JFile::copy( $oldCustomConfigFile, JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'custom.sef.php' );
      }

    }

    $sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
    // setup autoloader, so that base classes work
    // get Joomla autloader out
    spl_autoload_unregister("__autoload");
    // add our own
    include JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_sh404sef' . DS . 'helpers' . DS . 'autoloader.php';
    $registered = spl_autoload_register(array('Sh404sefAutoloader', 'doAutoload'));
    // stitch back Joomla's at the end of the list
    if(function_exists("__autoload")) {
      spl_autoload_register("__autoload");
    }

    // Make sure class was loaded.
    if (!class_exists('shSEFConfig')) {
      if (is_readable($sef_config_class)) {
        include( JPATH_ADMINISTRATOR. DS .'components'.DS.'com_sh404sef'. DS . 'shSEFConfig.class.php');
        require_once($sef_config_class);
      }
      else JError::RaiseError( 500, JText::_('COM_SH404SEF_NOREAD')."( $sef_config_class )<br />".JText::_('COM_SH404SEF_CHK_PERMS'));
    }
    $sefConfig = new shSEFConfig();

    // install module
    $installer = $parent->getParent();
    $source = $installer->getPath('source');
    $extensionConfig = array( 'enabled' => 1, 'access' => 3);
    $moduleConfig = array();
    $status = $this->_shInstallModule( 'mod_sh404sef_cpicon', $source, $extensionConfig, $moduleConfig);
    // custom language switcher module disabled for now, not needed
    //$extensionConfig = array();
    //$moduleConfig = array();
    //$status = $this->_shInstallModule( 'mod_sh_languages', $source, $extensionConfig, $moduleConfig);

    // install plugins
    $status = $this->_shInstallPluginGroup( 'system');
    $status = $this->_shInstallPluginGroup( 'sh404sefcore');
    $status = $this->_shInstallPluginGroup( 'sh404sefextplugins');

    // now we insert the 404 error page into the database
    // from version 1.5.5, the default content of 404 page has been largely modified
    // to make use of the similar urls plugin (and potentially others)
    // so we want to make sure people will have the new version of the 404 error page
    $this->_shUpdateErrorPage();

    // apply various DB updates
    $this->_shUpdateDBStructure();


    // message
    // decide on help file language
    $languageCode = Sh404sefHelperLanguage::getFamily();
    $basePath = JPATH_ROOT . DS . 'administrator' .DS .'components'.DS.'com_sh404sef'.DS.'language'.DS.'%s.postinstall.php';
    // fall back to english if language readme does not exist
    jimport('joomla.filesystem.file');
    if(!JFile::exists( sprintf( $basePath, $languageCode))) {
      $languageCode = 'en';
    }

    include sprintf( $basePath, $languageCode);
  }

  /**
   * Insert into the content database an uncategorized article
   * which serves as a basis for the 404 error page
   * Article title is __404__
   * Prior to version 1.5.5, the article displayed for 404 errors
   * was titled 404. The new name ensures users who customized
   * will keep their old design in the db. They can either reselect it
   * from the control panel, or customize as well the new __404__ page
   * @return unknown_type
   */
  private function _shUpdateErrorPage( $pageTitle = '__404__') {

    echo '<font color="red">Not updating error page for now</font><br />';
    return;

    // get a db instance
    $db = JFactory::getDBO();

    // do we already have a __404__ article?
    // first read uncategorised cat id
    try {

      $catid = Sh404sefHelperDb::selectResult( '#__categories', array('id'), 'parent_id > 0 and extension = ? and path = ? and level = ?', array( $extension, 'uncategorised', 1));

      if (empty( $catid)) {
        return;
      }

      // we have cat id, try to read article
      $id = Sh404sefHelperDb::selectResult( '#__content', array('id'), array( 'catid' => $catid, 'title' => $pageTitle));

      // if required page is already there, go away
      if (!empty( $id)) {
        return;
      }

      // find about the default page content
      $lang = JFactory::getLanguage();
      $lang->load('com_sh404sef');

      // now we can insert the new page content into the db
      $status = $this->_insertContent( $pageTitle, JText::_('COM_SH404SEF_DEF_404_MSG'));

      return $status;

    } catch( Sh404sefExceptionDefault $e) {
      $app = &JFactory::getApplication();
      $app->enqueueMessage( 'Error: ' . $e->getMessage());
      return false;
    }
  }

  /**
   * Performs update to db stucture on existing setups
   */
  private function _shUpdateDBStructure() {

  }


  private function _shInstallModule( $module, $source, $extensionConfig, $moduleConfig) {

    $app = &JFactory::getApplication();

    $path = $source . DS . 'admin' . DS . 'modules' . DS .$module;
    $installer = new JInstaller;
    $result = $installer->install( $path);

    if ($result) {

      // if files moved to destination, setup module in Joomla database

      $shouldRestore = $this->_shShouldRestore();

      if ($shouldRestore) {

        // read stored params from disk
        $this->_shGetExtensionSavedParams( $module . '_extension', $extensionConfig);

      }

      // update elements in db, only if we need to restore past configuration
      try {
        if (!empty( $extensionConfig)) {
          // load module details from extension table
          $moduleDetails = Sh404sefHelperDb::selectAssoc( '#__extensions', array('*'), array( 'type' => 'module','element' => $module));

          // merge with saved details and write back to disk
          $details = array_merge( $moduleDetails, $extensionConfig);
          Sh404sefHelperDb::update( '#__extensions', $details, array( 'extension_id' => (int) $moduleDetails['extension_id']));

        }
      } catch (Sh404sefExceptionDefault $e) {
        $app->enqueueMessage( 'Error: ' . $e->getMessage());
      }

      if ($shouldRestore) {

        // read stored params from disk
        $this->_shGetExtensionSavedParams( $module . '_modules', $moduleConfig);

      }

      // update elements in db, if we need to restore past configuration
      try {
        $instanceDetails = Sh404sefHelperDb::selectAssoc( '#__modules', array('*'), array( 'module' => $module));

        // merge with saved details and write back to disk
        $details = array_merge( $instanceDetails, $moduleConfig);
        Sh404sefHelperDb::update( '#__modules', $details, array( 'id' => (int) $instanceDetails['id']));

      } catch (Sh404sefExceptionDefault $e) {
        $app->enqueueMessage( 'Error: ' . $e->getMessage());
      }

      // and finally we make sure there is a menu item associated with the module
      $details = array( 'menuid' => 0);

      if ($shouldRestore) {

        // read stored params from disk
        $this->_shGetExtensionSavedParams( $module . '_modules_menu', $details);

      }
      $details = array_merge( $details, array('moduleid' => (int) $instanceDetails['id']));

      // insert or update elements in db, if we need to restore past configuration
      try {

        sh404sefHelperDb::insertUpdate( '#__modules_menu', $details, array( 'moduleid' => (int) $instanceDetails['id']));

      } catch (Sh404sefExceptionDefault $e) {
        $app->enqueueMessage( 'Error: ' . $e->getMessage());
      }

    } else {
      $app->enqueueMessage( 'Error installing sh404sef module: ' . $module);
    }
    return $result;
  }

  /**
   * Install all sh404sef plugins available in a given
   * group
   *
   * @param string $group name of group
   * @return boolean, true if success
   */
  private function _shInstallPluginGroup( $group) {

    $app = &JFactory::getApplication();

    $sourcePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_sh404sef'.DS.'plugins'.DS.$group;
    if (!JFolder::exists( $sourcePath)) {
      $app->enqueueMessage( 'Trying to install empty plugin group: ' . $group);;
      return true;
    }

    // if each plugin resides in its own subDir, we must iterate over all sub dirs
    $folderList = JFolder::folders( $sourcePath);
    if(empty( $folderList)) {
      $app->enqueueMessage( 'Trying to install empty plugin group, folder is empty: ' . $sourcePath);
      return true;
    }

    // process each plugin
    $errors = false;
    foreach( $folderList as $folder) {
      // install the plugin itself
      $status = $this->_shInstallPlugin( $group, $folder, $sourcePath);
      // set flag if an error happened, but keep installing
      // other plugins
      $errors = $errors && $status;
      // also display status
      if (!$status) {
        $app->enqueueMessage( 'Error installing sh404sef plugin from ' . $folder);
      }
    }

    // return true if no error at all
    return $errors == false;
  }

  /**
   * Insert in the db the previously retrieved parameters for a plugin
   * including publication information. Also move files as required
   *
   * @param string $basePath , the base path to get original files from
   */


  /**
   * Insert in the db the previously retrieved parameters for a plugin
   * including publication information. Also move files as required
   *
   * @param string $pluginFolder
   * @param string $pluginElement
   * @param string $basePath
   */
  private function _shInstallPlugin( $pluginFolder, $pluginElement, $sourcePath) {

    $app = &JFactory::getApplication();

    // use J! installer to fully install the plugin
    $installer = new JInstaller;
    $result = $installer->install( $sourcePath . DS . $pluginElement);


    if ($result) {

      $overrides = array( 'ordering' => 10, 'enabled' => 1);

      $shouldRestore = $this->_shShouldRestore();

      if ($shouldRestore) {

        // read stored params from disk
        $saved = array();
        $this->_shGetExtensionSavedParams( $pluginFolder . '.' . $pluginElement, $saved);
        $overrides = array_merge( $overrides, $saved);

      }

      // overrides data in extension table, possibly overriding some columns from saved data
      if( !empty( $overrides)) {
        try {
          $pluginId = Sh404sefHelperDb::selectResult( '#__extensions', array('extension_id'), array( 'type' => 'plugin','element' => $pluginElement, 'folder' => $pluginFolder));

          if(!empty( $pluginId)) {
            jimport( 'joomla.database.table.extension');
            $extension = & JTable::getInstance( 'Extension');
            $extension->load( $pluginId);
            $extension->bind( $overrides);
            $status = $extension->store();
            if (!$status) {
              $app->enqueueMessage( 'Error: ' . $extension->getError());
            }
          } else {
            $app->enqueueMessage( 'Error updating plugin DB record: '. $pluginFolder . ' / ' . $pluginElement);
          }
        } catch (Sh404sefExceptionDefault $e) {
          $status = false;
          $app->enqueueMessage( 'Error: ' . $e->getMessage());
        }

      }

    } else {
      $app->enqueueMessage( 'Error installing sh404sef plugin: ' . $pluginFolder . ' / ' . $pluginElement);
      $status = false;
    }

    return $status;
  }

  /**
   * Retrieves stored params of a given extension (module or plugin)
   * (as saved upon uninstall)
   *
   * @param string $extName the module name, including mod_ if a module
   * @param array $shConfig an array holding the database columns of the extension
   * @param array $shPub, an array holding the publication information of the module (only for modules)
   * @return boolean, true if any stored parameters were found for this extension
   */
  private function _shGetExtensionSavedParams( $extName, &$shConfig, &$shPub = null, $useId = false) {

    static $fileList = array();

    // prepare default return value
    $status = false;

    // read all file names in /media/sh404_upgrade_conf dir, for easier processing
    $baseFolder = $this->_preserveConfigFolder .'sh404_upgrade_conf';
    if (JFolder::exists( $baseFolder) && (empty( $fileList) || !isset($fileList[$extName]))) {
      $baseName = $extName . ($useId ? '_[0-9]{1,10}':'').'_'.$this->_siteId.'.php';
      $fileList[$extName] = JFolder::files( $baseFolder, $baseName);
    }

    // extract filename from list we've established previously
    $extFile = isset($fileList[$extName]) && $fileList[$extName] !== false ? array_shift( $fileList[$extName]) : '';
    if (empty( $fileList[$extName])) {
      // prevent infinite loop
      $fileList[$extName] = false;
    }

    if (!empty( $extFile) && JFile::exists( $baseFolder . DS . $extFile)) {
      $status = true; // operation was successful
      include( $baseFolder . DS . $extFile);
    }

    return $status;
  }

  /**
   * Decide whether backed up params should be restore (and
   * plugins reinstalled).
   * This should happen only when the extension is NOT already
   * installed. Most of times, as we are using updagre install
   * that should not happen and we jst overwrite
   * but if user uninstalled the extension, we must restore
   * data saved when he uninstalled
   *
   */
  private function _shShouldRestore() {

    // IMPORTANT: the check is done once, and only once
    // as for later calls, the system plugin will have been installed
    // and thus the test will not be valid anymore
    static $restore = null;

    if (is_null( $restore)) {

      // search for base xml file to decide if already installed
      $restore = !JFile::exists( JPATH_ROOT. DS .'plugins'.DS.'system'. DS . 'sh404sef' . DS . 'sh404sef.xml');
    }

    return $restore;
  }

  /**
   * Performs pre-uninstall backup of configuration
   *
   * @param object $parent
   */
  private function _doUninstall( $parent) {

    $this->_definePaths();
    $this->_includeLibs();

    // V 1.2.4.t before uninstalling modules, save their settings, if told to do so
    $sef_config_class = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'sh404sef.class.php';
    // Make sure class was loaded.
    if (!class_exists('shSEFConfig')) {
      if (is_readable($sef_config_class))  {
        require_once($sef_config_class);
      } else {
        JError::RaiseError( 500, JText::_('COM_SH404SEF_NOREAD')."( $sef_config_class )<br />".JText::_('COM_SH404SEF_CHK_PERMS'));
      }
    }
    $sefConfig = new shSEFConfig();
    if (!$sefConfig->shKeepStandardURLOnUpgrade && !$sefConfig->shKeepCustomURLOnUpgrade) {
      $this->_shDeleteTable('sh404sef_urls');
      $this->_shDeleteTable('sh404sef_aliases');
      $this->_shDeleteTable('sh404sef_pageids');
    } elseif (!$sefConfig->shKeepStandardURLOnUpgrade) {
      $this->_shDeleteAllSEFUrl('Standard');
    } elseif (!$sefConfig->shKeepCustomURLOnUpgrade) {
      $this->_shDeleteAllSEFUrl('Custom');
      $this->_shDeleteTable('sh404sef_aliases');
      $this->_shDeleteTable('sh404sef_pageids');
    }

    if (!$sefConfig->shKeepMetaDataOnUpgrade) {
      $this->_shDeleteTable('sh404sef_metas');
    }

    // remove admin quick icon module
    $this->_shSaveDeleteModuleParams( 'mod_sh404sef_cpicon', $client = 1);

    // remove language switcher module
    // custom language switcher module disabled for now, not needed
    //$this->_shSaveDeleteModuleParams( 'mod_sh_languages', $client = 0);

    // remove system plugin
    $this->_shSaveDeletePluginParams( 'sh404sef', 'system', $folders = null);
    $this->_shSaveDeletePluginParams( 'shmobile', 'system', $folders = array( 'shmobile'));

    // remove core plugins
    $this->_shSaveDeletePluginGroup( 'sh404sefcore');
    $this->_shSaveDeletePluginGroup( 'sh404sefextplugins');

    // delete analytics cached data, to force update
    // in case this part of sh404sef has changed
    $cache = & JFactory::getCache( 'sh404sef_analytics');
    $cache->clean();

    // preserve configuration or not ?
    if (!$sefConfig->shKeepConfigOnUpgrade) {

      // main config file
      $fileName = $this->_preserveConfigFolder . 'sh404_upgrade_conf_'.$this->_siteId.'.php';
      if (JFile::exists( $fileName)) {
        JFile::delete( $fileName);
      }

      // user custom config file
      $fileName = $this->_preserveConfigFolder.'sh404_upgrade_conf_'.$this->_siteId.'.custom.php';
      if (JFile::exists( $fileName)) {
        JFile::delete( $fileName);
      }

      // related extensions (plugins) config files folder
      if (JFolder::exists( $this->_preserveConfigFolder.'sh404_upgrade_conf')) {
        JFolder::delete( $this->_preserveConfigFolder.'sh404_upgrade_conf');
      }

      // log files folder
      if (JFolder::exists( $this->_preserveConfigFolder.'sh404_upgrade_conf_logs')) {
        JFolder::delete( $this->_preserveConfigFolder.'sh404_upgrade_conf_logs');
      }

      // security log files folder
      if (JFolder::exists( $this->_preserveConfigFolder.'sh404_upgrade_conf_security')) {
        JFolder::delete( $this->_preserveConfigFolder.'sh404_upgrade_conf_security');
      }

    }
    // must move log files out of the way, otherwise administrator/com_sh404sef/logs will not be deleted
    // and next installation of com_sh404sef will fail
    else { // if we keep config

      if (JFolder::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs')) {
        JFolder::copy( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'logs', $this->_preserveConfigFolder.'sh404_upgrade_conf_logs', $path = '', $force = true);
      }

      if (JFolder::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security')) {
        JFolder::copy( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sh404sef'.DS.'security', $this->_preserveConfigFolder.'sh404_upgrade_conf_security', $path = '', $force = true);
      }

    }

    // display results
    echo '<h3>sh404SEF has been succesfully uninstalled. </h3>';
    echo '<br />';
    if ($sefConfig->shKeepStandardURLOnUpgrade) {
      echo '- automatically generated SEF url have not been deleted (table #__sh404sef_urls)<br />';
    } else {
      echo '- automatically generated SEF url have been deleted<br />';
    }
    echo '<br />';
    if ($sefConfig->shKeepCustomURLOnUpgrade) {
      echo '- custom SEF url, aliases and pageIds have not been deleted (tables #__sh404sef_urls, #__sh404sef_aliases and #__sh404sef_pageids)<br />';
    } else {
      echo '- custom SEF url, aliases and pageIds have been deleted<br />';
    }
    echo '<br />';
    if ($sefConfig->shKeepMetaDataOnUpgrade) {
      echo '- Custom Title and META data have not been deleted (table #__sh404sef_metas)<br />';
    } else {
      echo '- Custom Title and META data have been deleted<br />';
    }
    echo '<br />';

  }

  // V 1.2.4.t improved upgrading
  private function _shDeletetable( $tableName) {
    $db = JFactory::getDbo();
    $query = 'drop table '.$db->nameQuote( '#__' . $tableName);
    try {
      Sh404sefHelperDb::query( $query);
    } catch (Sh404sefExceptionDefault $e) {
      echo $e->getMessage() . '<br />';
    }
  }

  private function _shDeleteAllSEFUrl( $kind) {

    If ($kind == 'Custom') {
      $where = '`dateadd` > \'0000-00-00\' and `newurl` != \'\';';
    } else {
      $where = '`dateadd` = \'0000-00-00\';';
    }
    try {
      Sh404sefHelperDb::delete( '#__sh404sef_urls', $where);
    } catch (Sh404sefExceptionDefault $e) {
      echo $e->getMessage() . '<br />';
    }
  }

  /**
   *
   * utility functions
   *
   */
  /**
   * Writes an extension parameter to a disk file, located
   * in the /media directory
   *
   * @param string $extName the extension name
   * @param array $shConfig associative array of parameters of the extension, to be written to disk
   * @param array $pub, optional, only if module, an array of the menu item id where the module is published
   * @return boolean, true if no error
   */
  private function _shWriteExtensionConfig( $extName, $params) {

    if (empty($params)) {
      return;
    }

    // calculate target file name
    $extPath = $this->_preserveConfigFolder.'sh404_upgrade_conf';

    // if it does not exists, lets create it first
    if(!JFolder::exists( $extPath)) {
      JFolder::create( $extPath);
    }

    // make sure we have an index.html file in that folder
    $target = JPath::clean( $extPath . DS . 'index.html');
    if (!JFile::exists( $target)) {
      // copy one Joomla's index.html file to the backup directory
      $source = JPath::clean( JPATH_ROOT.DS.'plugins'.DS.'index.html');
      $success = JFile::copy( $source, $target);
    }

    // now build full path file name to save config
    $extFile = $extPath . DS . $extName .'_' .$this->_siteId.'.php';

    // remove previous if any
    if (JFile::exists( $extFile)) {
      JFile::delete( $extFile);
    }

    // prepare data for writing
    $data = '<?php // Extension params save file for sh404sef
//    
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');';
    $data .= "\n";

    if (!empty( $params)) {
      foreach( $params as $key => $value) {
        $data .= '$'. $key . ' = ' . var_export($value, true) . ';';
        $data .= "\n";
      }
    }

    // write to disk
    $success = JFile::write( $extFile, $data);

    return $success !== false;
  }

  /**
   * Save parameters, then delete a module
   * Would not work on additional copies made by user
   *
   * @param string $moduleName, the module name, matching 'module' column in modules table
   * @param string $client (ie : site or administrator
   */
  private function _shSaveDeleteModuleParams( $moduleName, $client) {

    // read plugin param from db
    try {
      $result = Sh404sefHelperDb::selectAssoc( '#__extensions', array('*'), array( 'type' => 'module', 'element' => $moduleName, 'client_id' => $client));

      if(empty($result)) {
        // invalid module name?
        return false;
      }
      // remove module db id
      unset($result['extension_id']);

      // write everything on disk
      $this->_shWriteExtensionConfig( $moduleName . '_extension', array('shConfig' => $result));

      // now remove plugin details from db
      Sh404sefHelperDb::delete( '#__extensions', array( 'type' => 'module', 'element' => $moduleName, 'client_id' => $client));

      // do the same for the module instance, in #__module table
      $result = Sh404sefHelperDb::selectAssoc( '#__modules', array('*'), array( 'module' => $moduleName, 'client_id' => $client));

      if(empty($result)) {
        // invalid module name?
        return false;
      }
      // save and remove module db id
      $moduleId = $result['id'];
      unset( $result['id']);

      // write everything on disk
      $this->_shWriteExtensionConfig( $moduleName . '_modules', array('shConfig' => $result));

      // now remove plugin details from db
      Sh404sefHelperDb::delete( '#__modules', array( 'module' => $moduleName, 'client_id' => $client));

      // remove module/menu affectation
      $result = Sh404sefHelperDb::selectAssoc( '#__modules_menu', array('*'), array( 'moduleid' => $moduleId));

      // remove module db id
      unset($result['moduleid']);

      // write everything on disk
      $this->_shWriteExtensionConfig( $moduleName . '_modules_menu', array('shConfig' => $result));

      // now remove plugin details from db
      Sh404sefHelperDb::delete( '#__modules_menu', array( 'moduleid' => $moduleId));

    } catch ( Sh404sefExceptionDefault $e) {
      echo $e->getMessage() . '<br />';
    }

    // delete the module files
    $path = JPATH_ROOT.DS . ($client ? 'administrator' . DS : '') . 'modules'. DS . $moduleName;
    if (JFolder::exists( $path)) {
      JFolder::delete( $path);
    }

  }

  /**
   * Save parameters, then delete a plugin
   *
   * @param string $pluginName, the plugin name, mathcing 'element' column in plugins table
   * @param string $folder, the plugin folder (ie : 'content', 'search', 'system',...
   */
  private function _shSaveDeletePluginParams( $pluginName, $folder, $folders = null) {

    try {
      $result = Sh404sefHelperDb::selectAssoc( '#__extensions', array('*'), array( 'type' => 'plugin', 'element' => $pluginName, 'folder' => $folder));

      if(empty($result)) {
        // invalid plugin name?
        return false;
      }

      // remove plugin db id
      unset($result['id']);

      // write everything on disk
      $this->_shWriteExtensionConfig( $pluginName, array('shConfig' => $result));

      // now remove plugin details from db
      Sh404sefHelperDb::delete( '#__extensions', array( 'type' => 'plugin', 'element' => $pluginName, 'folder' => $folder));

    } catch ( Sh404sefExceptionDefault $e) {

    }

    // delete the plugin files
    $basePath = JPATH_ROOT.DS.'plugins'. DS . $folder . DS . $pluginName;
    if (JFolder::exists($basePath)) {
      JFolder::delete( $basePath);
    }
  }

  /**
   * Save params, then delete plugin, for all plugins
   * in a given group
   *
   * @param $group the group to be deleted
   * @return none
   */
  private function _shSaveDeletePluginGroup( $group) {

    $unsafe = array( 'authentication', 'content', 'editors', 'editors-xtd', 'search', 'system', 'xmlrpc');
    if (in_array( $group, $unsafe)) {
      // safety net : we don't want to delete the whole system or content folder
      return false;
    }

    // read list of plugins from db
    $db = & JFactory::getDBO();

    // read plugin param from db
    try {
      $pluginList = Sh404sefHelperDb::selectAssocList( '#__extensions', array('*'), array( 'type' => 'plugin', 'folder' => $group));

      if (empty( $pluginList)) {
        return true;
      }

      // for each plugin
      foreach( $pluginList as $plugin) {
        // remove plugin db id
        unset($plugin['id']);

        // write everything on disk
        $this->_shWriteExtensionConfig( $plugin['folder'] . '.' . $plugin['element'], array('shConfig' => $plugin));

        // now remove plugin details from db
        Sh404sefHelperDb::delete( '#__extensions', array( 'type' => 'plugin', 'element' => $plugin['element'], 'folder' => $plugin['folder']));

      }

    } catch (Sh404sefExceptionDefault $e) {
      echo $e->getMessage() . '<br />';
    }

    // now delete the files for the whole group
    if (JFolder::exists( JPATH_ROOT.DS.'plugins'. DS . $group)) {
      JFolder::delete( JPATH_ROOT.DS.'plugins'. DS . $group);
    }

  }

  /**
   * Insert an intro text into the content table
   *
   * @param strng $shIntroText
   * @return boolean, true if success
   */
  function _insertContent( $pageTitle, $shIntroText) {

    // result storage
    $status = false;

    jimport('joomla.database.table');
    try {
      $catid = Sh404sefHelperDb::selectResult( '#__categories', array('id'), 'parent_id > 0 and extension = ? and path = ? and level = ?', array( 'com_content', 'uncategorised', 1));
      if(empty($catid)) {
        $this->setError( JText::_('COM_SH404SEF_CANNOT_SAVE_404_NO_UNCAT'));
        return;
      }
      $contentTable = JTable::getInstance( 'content');
      $content = array( 'title' => $pageTitle, 'alias' => $pageTitle, 'title_alias' => $pageTitle, 'introtext' => $shIntroText, 'state' => 1, 'language' => '*'
      , 'catid' => $catid, 'attribs' => '{"menu_image":"-1","show_title":"0","show_section":"0","show_category":"0","show_vote":"0","show_author":"0","show_create_date":"0","show_modify_date":"0","show_pdf_icon":"0","show_print_icon":"0","show_email_icon":"0","pageclass_sfx":""');

      $status = $contentTable->save( $content);
    } catch (Sh404sefExceptionDefault $e) {
    }

    return $status;
  }

  private function _definePaths() {

    $this->_siteId = rtrim(str_replace('/administrator', '', JURI::base()), '/');
    $this->_siteId = str_replace('/','_',str_replace('http://', '', $this->_siteId));
    $this->_preserveConfigFolder = JPATH_ROOT. DS .'media'.DS. 'sh404sef' . DS;
  }

  private function _includeLibs() {

    jimport('joomla.filesystem.file');
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.path');
    jimport('joomla.html.parameter');
    jimport('joomla.filter.filterinput');
    jimport('joomla.utilities.string');

    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components'.DS.'com_sh404sef'.DS.'exceptions'.DS.'default.php';
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components'.DS.'com_sh404sef'.DS.'classes'.DS.'shabstractdecorator.php';
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components'.DS.'com_sh404sef'.DS.'classes'.DS.'shdb.php';
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components'.DS.'com_sh404sef'.DS.'helpers'.DS.'db.php';
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components'.DS.'com_sh404sef'.DS.'helpers'.DS.'language.php';
  }
}
