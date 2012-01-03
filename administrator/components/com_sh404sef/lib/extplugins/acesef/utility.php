<?php
/**
 * @version    1.5.0
 * @package    AceSEF Library
 * @subpackage Utility
 * @copyright  2009-2010 JoomAce LLC, www.joomace.net
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No Permission
defined('_JEXEC') or die('Restricted Access');

// Imports
jimport('joomla.filesystem.file');

// Utility class
class AcesefUtility {

  static $props = array();

  function __construct() {
    // Get config object
    $this->AcesefConfig = AcesefFactory::getConfig();
  }

  function import($path) {
    require_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_acesef' . DS . str_replace('.', '/', $path).'.php');
  }

  function render($path) {
    ob_start();
    require_once($path);
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
  }

  function get($name, $default = null) {
    if (!is_array(self::$props) || !isset(self::$props[$name])) {
      return $default;
    }

    return self::$props[$name];
  }

  function set($name, $value) {
    if (!is_array(self::$props)) {
      self::$props = array();
    }

    $previous = self::get($name);
    self::$props[$name] = $value;

    return $previous;
  }

  function getConfigState($params, $cfg_name, $prm = "") {
    if (!is_object($params)) {
      return false;
    }

    $prm_name = $cfg_name;
    if ($prm != "") {
      $prm_name = $prm;
    }

    $param = $params->get($prm_name, 'global');
    if (($param == 'no') || ($param == 'global' && $this->AcesefConfig->$cfg_name == '0')) {
      return false;
    }

    return true;
  }

  function &getMenu() {
    jimport('joomla.application.menu');
    $options = array();

    $menu =& JMenu::getInstance('site', $options);

    if (JError::isError($menu)) {
      $null = null;
      return $null;
    }

    return $menu;
  }

  function getComponents() {
    static $components;

    if(!isset($components)) {
      $filter = "'com_sef', 'com_sh404sef', 'com_joomfish', 'com_config', 'com_media', 'com_installer', 'com_templates', 'com_plugins', 'com_modules', 'com_cpanel', 'com_cache', 'com_messages', 'com_menus', 'com_massmail', 'com_languages', 'com_users'";
      $rows = AceDatabase::loadObjectList("SELECT `name`, `option` FROM `#__components` WHERE `parent` = '0' AND `option` != '' AND `option` NOT IN ({$filter}) ORDER BY `name`");

      foreach($rows as $row) {
        $components[] = JHTML::_('select.option', $row->option, $row->name);
      }
    }

    return $components;
  }

  function getExtensionFromRequest() {
    static $extension;

    if (!isset($extension)) {
      $cid = JRequest::getVar('cid', array(0), 'method', 'array');
      $extension = AceDatabase::loadResult("SELECT extension FROM #__acesef_extensions WHERE id = ".$cid[0]);
    }

    return $extension;
  }

  function getOptionFromRealURL($url) {
    $url = str_replace('&amp;', '&', $url);
    $url = str_replace('index.php?', '', $url);
    parse_str($url, $vars);

    if (isset($vars['option'])) {
      return $vars['option'];
    } else {
      return '';
    }
  }

  // Get the list of languages
  function getLanguages() {
    static $languages;

    if(!isset($languages)) {
      $db =& JFactory::getDBO();
      $tables = $db->getTableList();
      $prefix = $db->getPrefix();
      $langs  = $prefix."languages";
      if (in_array($langs, $tables)){
        // Get installed languages and add them to list
        $langs = AceDatabase::loadObjectList("SELECT `id`, `shortcode`, `name` FROM `#__languages` WHERE `active` = '1' ORDER BY `ordering`");

        if( @count(@$langs) ) {
          foreach($langs as $lang) {
            $l = new stdClass();
            $l->code = $lang->shortcode;
            $l->name = $lang->name;

            // Load languages
            $languages[] = JHTML::_('select.option', $l->code, $l->name);
          }
        }
      }
    }

    return $languages;
  }


  function replaceLoop($search, $replace, $text) {
    $count = 0;

    if (!is_string($text)) {
      return $text;
    }

    while ((strpos($text, $search) !== false) && ($count < 10)) {
      $text = str_replace($search, $replace, $text);
      $count++;
    }

    return $text;
  }


  function getSefStatus() {
    static $status;

    if (!isset($status)) {
      $JoomlaConfig =& JFactory::getConfig();

      $status = array();
      $status['version_checker'] = (bool)$this->AcesefConfig->version_checker;
      $status['php'] = (bool)version_compare(PHP_VERSION, '5.2.0', '>');
      $status['s_mod_rewrite'] = '';
      if (function_exists('apache_get_modules')) {
        $modules = apache_get_modules();
        $status['s_mod_rewrite'] = (bool)in_array('mod_rewrite', $modules);
      }
      $status['sef'] = (bool)$JoomlaConfig->getValue('sef');
      $status['mod_rewrite'] = (bool)$JoomlaConfig->getValue('sef_rewrite');
      $status['htaccess'] = false;
      if (file_exists(JPATH_ROOT.DS.'.htaccess')) {
        $filesize = filesize(JPATH_ROOT.DS.'.htaccess');
        $status['htaccess'] = (bool)($filesize > 2060);
      }
      $status['live_site'] = $JoomlaConfig->getValue('live_site');
      if (AcesefUtility::JoomFishInstalled()) {
        $status['jfrouter'] = JPluginHelper::isEnabled('system', 'jfrouter');
      }
      $status['acesef'] = (bool)$this->AcesefConfig->mode;
      $status['plugin'] = JPluginHelper::isEnabled('system', 'acesef');
      $status['generate_sef'] = (bool)$this->AcesefConfig->generate_sef;
    }

    return $status;
  }

  function JoomFishInstalled() {
    static $installed;

    if (!isset($installed)) {
      $installed = JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php');
    }

    return $installed;
  }


  function getParam($text, $param) {
    $params = new JParameter($text);
    return $params->get($param);
  }

  function storeParams($table, $id, $db_field, $new_params) {
    $row = AcesefFactory::getTable($table);
    if (!$row->load($id)) {
      return false;
    }

    $params = new JParameter($row->$db_field);

    foreach ($new_params as $name => $value) {
      $params->set($name, $value);
    }

    $row->$db_field = $params->toString();

    if (!$row->check()) {
      return false;
    }

    if (!$row->store()) {
      return false;
    }
  }

  // Clear texts from unwanted chars
  function cleanText($text) {
    $text = strip_tags($text);
    $text = preg_replace(array('/&amp;quot;/', '/&amp;nbsp;/', '/&amp;lt;/', '/&amp;gt;/', '/&amp;copy;/', '/&amp;amp;/', '/&amp;euro;/', '/&amp;hellip;/'), ' ', $text);
    $text = preg_replace(array('/&quot;/', '/&nbsp;/', '/&lt;/', '/&gt;/', '/&copy;/', '/&amp;/', '/&euro;/', '/&hellip;/'), ' ', $text);
    $text = preg_replace("'<script[^>]*>.*?</script>'si", ' ', $text);
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
    $text = preg_replace('/<!--.+?-->/', ' ', $text);
    $text = preg_replace('/{.+?}/', ' ', $text);
    $text = preg_replace('(\{.*?\})', ' ', $text);
    $text = preg_replace('/\s\s+/', ' ', $text);
    $text = preg_replace('/\n\n+/s', ' ', $text);
    $text = preg_replace('/<[^<|^>]*>/u', ' ', $text);
    $text = preg_replace('/{[^}]*}[\s\S]*{[^}]*}/u', ' ', $text);
    $text = preg_replace('/{[^}]*}/u', ' ', $text);
    $text = trim($text);
    $text = str_replace(array('\r\n', '\r', '\n', '\t', '\n\n', '<', '>', ':', '#', '`', '”', '“', '¿', '\0', '\x0B', '"', '&quot;', '&quot'), ' ', $text);
    $text = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', ' ', $text);
    while(strpos($text, '  ')) {
      $text = str_replace('  ', ' ', $text);
    }

    // Space
    $text = preg_replace('/\s/u', ' ', $text);

    // Special chars
    $text = self::replaceSpecialChars($text);

    $text = rtrim($text, "'");
    $text = rtrim($text, "\\");

    return $text;
  }

  // Replace some special chars
  function replaceSpecialChars($text, $reverse = false) {
    if (is_string($text)) {
      if (!$reverse) {
        $text = str_replace("\'", "'", $text);
        $text = addslashes($text);
      } else {
        $text = stripslashes($text);
      }
    }

    return $text;
  }

  // Get text from XML
  function getXmlText($file, $variable) {
    // Try to find variable
    $value = null;
    if (JFile::exists($file)) {
      $xml =& JFactory::getXMLParser('Simple');
      if ($xml->loadFile($file)) {
        $root =& $xml->document;
        $element =& $root->getElementByPath($variable);
        $value = $element ? $element->data() : '';
      }
    }
    return $value;
  }

  // Get Menu title
  function getMenuTitle($Itemid, $start_level = 0, $length_level = 0) {
    if (empty($Itemid)) {
      return array();
    }

    static $menus = array();

    $id = $Itemid;
    if (!isset($menus[$id])) {
      $joomfish = $this->AcesefConfig->joomfish_trans_url ? ', id' : '';

      // Title or Alias
      $part = 'name';
      if ($this->AcesefConfig->menu_url_part == 'alias') {
        $part = 'alias';
      }

      $menus[$id] = array();

      while ($Itemid > 0) {
        $row = AceDatabase::loadObject("SELECT $part AS name, parent$joomfish FROM #__menu WHERE id = '$Itemid' AND published > 0");

        if (is_null($row)) {
          break;
        }

        array_unshift($menus[$id], $row->name);

        $Itemid = $row->parent;
        if ($this->AcesefConfig->parent_menus == '0') {
          break; //  Only last one
        }
      }
    }

    if ($this->AcesefConfig->parent_menus == '1' && ($start_level != 0 || $length_level != 0) && !empty($menus[$id])) {
      if ($length_level != 0) {
        return array_slice($menus[$id], $start_level, $length_level);
      }
      else {
        return array_slice($menus[$id], $start_level);
      }
    }

    return $menus[$id];
  }

}
