<?php
/**
 * @version		1.5.0
 * @package		AceSEF Library
 * @subpackage	Extension
 * @copyright	2009-2010 JoomAce LLC, www.joomace.net
 * @copyright   Yannick Gaultier - 2011
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No Permission
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.filesystem.file');
require_once(JPATH_ACESEF_ADMIN.DS.'tables'.DS.'acesefextensions.php');

// Extension class
class AcesefExtension {

  protected $params = null;
  protected $meta_title = null;
  protected $meta_desc = null;

  function __construct() {
    // Get config object
    $this->AcesefConfig = AcesefFactory::getConfig();

    // Skip menu
    self::skipMenu(false);
  }

  function setParams($params) {
    $this->params = $params;
  }

  function skipMenu($status, $get = false) {
    static $skip_menu = false;

    if ($get) {
      return $skip_menu;
    }

    $skip_menu = $status;
  }

  function beforeBuild(&$uri) {
  }

  function catParam($vars) {
  }

  function build(&$vars, &$segments, &$do_sef, &$metadata, &$item_limitstart) {
  }

  function afterBuild(&$uri) {
  }

  // Define title or alias
  function urlPart($param) {
    if (($param == 'title') || ($param == 'global' && $this->AcesefConfig->title_alias == 'title')) {
      return 'title';
    }
    return 'alias';
  }

  function categoryParam($area, $action = 2, $id = 0, $is_cat = 0, $real_url = "") {
    self::categoryParams($id, $is_cat, $real_url);
  }

  function categoryParams($id = 0, $is_cat = 0, $real_url = "") {
    $vars = array();
    $areas = array('sm_auto_cats', 'tags_cats', 'ilinks_cats', 'bookmarks_cats');

    foreach ($areas as $a) {
      if (!isset($vars[$a.'_status'])) {
        $vars[$a.'_status'] = 0;
      }
      if (!isset($vars[$a.'_flag'])) {
        $vars['_flag'] = 0;
      }
      if (!isset($vars['_is_cat'])) {
        $vars['_is_cat'] = $is_cat;
      }
      if (!isset($vars['_real_url'])) {
        $vars['_real_url'] = $real_url;
      }
    }

    foreach ($areas as $a) {
      $categories = $this->params->get($a, '-11');
      if ($categories == 'all') {
        $vars[$a.'_status'] = 1;
      }
      elseif (is_array($categories) && in_array($id, $categories)) {
        $vars[$a.'_status'] = 1;
      }
      elseif ($categories == $id) {
        $vars[$a.'_status'] = 1;
      }
    }
    $vars['_flag'] = 1;

    AcesefUtility::set('category.param', $vars);
  }

  function getMetaData($vars, $item_limitstart = false) {

    return array();
  }

  function getMenuParams($id) {
    static $params = array();

    if (!isset($params[$id])) {
      $params[$id] = AcesefUtility::getMenu()->getParams($id);
    }

    return $params[$id];
  }

  function fixVar($var) {
    if (!is_null($var)) {
      $pos = strpos($var, ':');
      if ($pos !== false) {
        $var = substr($var, 0, $pos);
      }
    }
    return $var;
  }
}
