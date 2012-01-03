<?php
/**
 * @version		$Id: baseinstalladapter.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Adapted for SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: baseinstalladapter.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// No direct access
defined('JPATH_BASE') or die;

require_once JPATH_LIBRARIES . DS. 'joomla' . DS . 'installer' . DS . 'adapters' . DS . 'plugin.php';

/**
 * Plugin installer
 *
 * @package		Joomla.Framework
 * @subpackage	Installer
 * @since		1.5
 */
class Sh404sefClassBaseinstalladapter extends JInstallerPlugin
{

  protected $_basePath = '';

  protected $_group = 'sh404sefextplugins';
  protected $_installType = 'plugin';

  /** @var string install function routing */
  var $route = 'install';

  protected $manifest = null;
  protected $manifest_script = null;
  protected $name = null;
  protected $scriptElement = null;
  protected $oldFiles = null;

  public function __construct(&$parent, &$db, $options = Array()) {

    parent::__construct($parent, $db, $options);
    $this->_basePath = JPATH_ROOT . DS . 'plugins';
  }

  /**
   * Custom install method
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  public function install()
  {

    // set our target path
    $this->parent->setPath( 'extension_root', $this->_getPath());

    // Get a database connector object
    $db = $this->parent->getDbo();

    // Get the extension manifest object
    $this->manifest = $this->parent->getManifest();

    $xml = $this->manifest;

    /**
     * ---------------------------------------------------------------------------------------------
     * Manifest Document Setup Section
     * ---------------------------------------------------------------------------------------------
     */

    // Set the extensions name
    $name = (string)$xml->name;
    $name = JFilterInput::getInstance()->clean($name, 'string');
    $this->set('name', $name);

    // Get the component description
    $description = (string)$xml->description;
    if ($description) {
      $this->parent->set('message', JText::_($description));
    }
    else {
      $this->parent->set('message', '');
    }

    /*
     * Backward Compatability
     * @todo Deprecate in future version
     */
    $type = (string)$xml->attributes()->type;
    $pname = $this->_getElement($xml);

    $group = $this->_group;
    if ($type == $this->_installType && !empty( $pname)) {
      $this->parent->setPath('extension_root', JPATH_PLUGINS.DS.$group.DS.$element);
    }
    else
    {
      $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_NO_FILE', JText::_('JLIB_INSTALLER_'.$this->route)));
      return false;
    }


    /*
     * Check if we should enable overwrite settings
     */
    // Check to see if a plugin by the same name is already installed
    $query = 'SELECT `extension_id`' .
				' FROM `#__extensions`' .
				' WHERE folder = '.$db->Quote($group) .
				' AND element = '.$db->Quote($element);
    $db->setQuery($query);
    try {
      $db->Query();
    }
    catch(JException $e)
    {
      // Install failed, roll back changes
      $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_ROLLBACK', JText::_('JLIB_INSTALLER_'.$this->route), $db->stderr(true)));
      return false;
    }
    $id = $db->loadResult();

    // if its on the fs...
    if (file_exists($this->parent->getPath('extension_root')) && (!$this->parent->getOverwrite() || $this->parent->getUpgrade()))
    {
      $updateElement = $xml->update;
      // upgrade manually set
      // update function available
      // update tag detected
      if ($this->parent->getUpgrade() || ($this->parent->manifestClass && method_exists($this->parent->manifestClass,'update')) || is_a($updateElement, 'JXMLElement'))
      {
        // force these one
        $this->parent->setOverwrite(true);
        $this->parent->setUpgrade(true);
        if ($id) { // if there is a matching extension mark this as an update; semantics really
          $this->route = 'update';
        }
      }
      else if (!$this->parent->getOverwrite())
      {
        // overwrite is set
        // we didn't have overwrite set, find an udpate function or find an update tag so lets call it safe
        $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_DIRECTORY', JText::_('JLIB_INSTALLER_'.$this->route), $this->parent->getPath('extension_root')));
        return false;
      }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Installer Trigger Loading
     * ---------------------------------------------------------------------------------------------
     */
    // If there is an manifest class file, lets load it; we'll copy it later (don't have dest yet)
    if ((string)$xml->scriptfile)
    {
      $manifestScript = (string)$xml->scriptfile;
      $manifestScriptFile = $this->parent->getPath('source').DS.$manifestScript;
      if (is_file($manifestScriptFile))
      {
        // load the file
        include_once $manifestScriptFile;
      }
      // Set the class name
      $classname = 'plg'.$group.$element.'InstallerScript';
      if (class_exists($classname))
      {
        // create a new instance
        $this->parent->manifestClass = new $classname($this);
        // and set this so we can copy it later
        $this->set('manifest_script', $manifestScript);
        // Note: if we don't find the class, don't bother to copy the file
      }
    }

    // run preflight if possible (since we know we're not an update)
    ob_start();
    ob_implicit_flush(false);
    if ($this->parent->manifestClass && method_exists($this->parent->manifestClass,'preflight'))
    {
      if($this->parent->manifestClass->preflight($this->route, $this) === false)
      {
        // Install failed, rollback changes
        $this->parent->abort(JText::_('JLIB_INSTALLER_ABORT_PLG_INSTALL_CUSTOM_INSTALL_FAILURE'));
        return false;
      }
    }
    $msg = ob_get_contents(); // create msg object; first use here
    ob_end_clean();

    /**
     * ---------------------------------------------------------------------------------------------
     * Filesystem Processing Section
     * ---------------------------------------------------------------------------------------------
     */

    // If the plugin directory does not exist, lets create it
    $created = false;
    if (!file_exists($this->parent->getPath('extension_root')))
    {
      if (!$created = JFolder::create($this->parent->getPath('extension_root')))
      {
        $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_CREATE_DIRECTORY', JText::_('JLIB_INSTALLER_'.$this->route), $this->parent->getPath('extension_root')));
        return false;
      }
    }

    // if we're updating at this point when there is always going to be an extension_root find the old xml files
    if($this->route == 'update')
    {
      // Hunt for the original XML file
      $old_manifest = null;
      $tmpInstaller = new JInstaller(); // create a new installer because findManifest sets stuff; side effects!
      // look in the extension root
      $tmpInstaller->setPath('source', $this->parent->getPath('extension_root'));
      if ($tmpInstaller->findManifest())
      {
        $old_manifest = $tmpInstaller->getManifest();
        $this->oldFiles = $old_manifest->files;
      }
    }

    /*
     * If we created the plugin directory and will want to remove it if we
     * have to roll back the installation, lets add it to the installation
     * step stack
     */
    if ($created) {
      $this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
    }

    // Copy all necessary files
    if ($this->parent->parseFiles($xml->files, -1, $this->oldFiles) === false)
    {
      // Install failed, roll back changes
      $this->parent->abort();
      return false;
    }

    // Parse optional tags -- media and language files for plugins go in admin app
    $this->parent->parseMedia($xml->media, 1);
    $this->parent->parseLanguages($xml->languages, 1);

    // If there is a manifest script, lets copy it.
    if ($this->get('manifest_script'))
    {
      $path['src'] = $this->parent->getPath('source').DS.$this->get('manifest_script');
      $path['dest'] = $this->parent->getPath('extension_root').DS.$this->get('manifest_script');

      if (!file_exists($path['dest']))
      {
        if (!$this->parent->copyFiles(array ($path)))
        {
          // Install failed, rollback changes
          $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_MANIFEST', JText::_('JLIB_INSTALLER_'.$this->route)));
          return false;
        }
      }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Database Processing Section
     * ---------------------------------------------------------------------------------------------
     */
    $row = JTable::getInstance('extension');
    // Was there a plugin already installed with the same name?
    if ($id)
    {
      if (!$this->parent->getOverwrite())
      {
        // Install failed, roll back changes
        $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_ALLREADY_EXISTS', JText::_('JLIB_INSTALLER_'.$this->route), $this->get('name')));
        return false;
      }
      $row->load($id);
      $row->name = $this->get('name');
      $row->manifest_cache = $this->parent->generateManifestCache();
      $row->store(); // update the manifest cache and name
    }
    else
    {
      // Store in the extensions table (1.6)
      $row->name = $this->get('name');
      $row->type = 'plugin';
      $row->ordering = 0;
      $row->element = $element;
      $row->folder = $group;
      $row->enabled = 1;
      $row->protected = 0;
      $row->access = 1;
      $row->client_id = 0;
      $row->params = $this->parent->getParams();
      $row->custom_data = ''; // custom data
      $row->system_data = ''; // system data
      $row->manifest_cache = $this->parent->generateManifestCache();

      // Editor plugins are published by default
      if ($group == 'editors') {
        $row->enabled = 1;
      }

      if (!$row->store())
      {
        // Install failed, roll back changes
        $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_ROLLBACK', JText::_('JLIB_INSTALLER_'.$this->route), $db->stderr(true)));
        return false;
      }

      // Since we have created a plugin item, we add it to the installation step stack
      // so that if we have to rollback the changes we can undo it.
      $this->parent->pushStep(array ('type' => 'extension', 'id' => $row->extension_id));
      $id = $row->extension_id;
    }

    /*
     * Let's run the queries for the module
     *	If Joomla 1.5 compatible, with discreet sql files - execute appropriate
     *	file for utf-8 support or non-utf-8 support
     */
    // try for Joomla 1.5 type queries
    // second argument is the utf compatible version attribute
    if(strtolower($this->route) == 'install') {
      $utfresult = $this->parent->parseSQLFiles($this->manifest->install->sql);
      if ($utfresult === false)
      {
        // Install failed, rollback changes
        $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_SQL_ERROR', JText::_('JLIB_INSTALLER_'.$this->route), $db->stderr(true)));
        return false;
      }

      // Set the schema version to be the latest update version
      if($this->manifest->update) {
        $this->parent->setSchemaVersion($this->manifest->update->schemas, $row->extension_id);
      }
    } else if(strtolower($this->route) == 'update') {
      if($this->manifest->update)
      {
        $result = $this->parent->parseSchemaUpdates($this->manifest->update->schemas, $row->extension_id);
        if ($result === false)
        {
          // Install failed, rollback changes
          $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_UPDATE_SQL_ERROR', $db->stderr(true)));
          return false;
        }
      }
    }

    // Start Joomla! 1.6
    ob_start();
    ob_implicit_flush(false);
    if ($this->parent->manifestClass && method_exists($this->parent->manifestClass,$this->route))
    {
      if($this->parent->manifestClass->{$this->route}($this) === false)
      {
        // Install failed, rollback changes
        $this->parent->abort(JText::_('JLIB_INSTALLER_ABORT_PLG_INSTALL_CUSTOM_INSTALL_FAILURE'));
        return false;
      }
    }
    $msg .= ob_get_contents(); // append messages
    ob_end_clean();

    /**
     * ---------------------------------------------------------------------------------------------
     * Finalization and Cleanup Section
     * ---------------------------------------------------------------------------------------------
     */

    // Lastly, we will copy the manifest file to its appropriate place.
    if (!$this->parent->copyManifest(-1))
    {
      // Install failed, rollback changes
      $this->parent->abort(JText::sprintf('JLIB_INSTALLER_ABORT_PLG_INSTALL_COPY_SETUP', JText::_('JLIB_INSTALLER_'.$this->route)));
      return false;
    }
    // And now we run the postflight
    ob_start();
    ob_implicit_flush(false);
    if ($this->parent->manifestClass && method_exists($this->parent->manifestClass,'postflight'))
    {
      $this->parent->manifestClass->postflight($this->route, $this);
    }
    $msg .= ob_get_contents(); // append messages
    ob_end_clean();
    if ($msg != '') {
      $this->parent->set('extension_message', $msg);
    }
    return $id;
  }

  /**
   * Get unique element id for the plugin
   *
   */
  protected function _getElement( $xml) {

    static $_element = null;

    if( is_null( $_element)) {
      // get name, should work for Joomsef, not sure for Aces, as
      // I have seen some plugin with wrong filename attribute
      // should use the "extension" field with acesef
      if (count($xml->files->children()))
      {
        foreach ($xml->files->children() as $file)
        {
          $type = $this->_installType;
          if ((string)$file->attributes()->$type)
          {
            $_element = (string)$file->attributes()->$type;
            break;
          }
        }
      }

    }
    return $_element;

  }

  /**
   * Get sub dir of given plugin, usually based on name
   * of extension. Obtaining that name will vary based
   * on the type of plugin
   */
  protected function _getPath() {

    return $this->_basePath . DS . $this->_group;

  }

  protected function _fixManifest() {

  }

}
