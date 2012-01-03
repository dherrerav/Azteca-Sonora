<?php

/**
 * sh404SEF support for com_weblinks component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_weblinks.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_weblinks', $shLangIso, 'COM_SH404SEF_CREATE_NEW_LINK');
// ------------------  load language file - adjust as needed ----------------------------------------

// collect probable url vars
$view = isset($view) ? $view : null;
$task = isset($task) ? $task : null;
$Itemid = isset($Itemid) ? $Itemid : null;
$id = isset($id) ? $id : null;
$catid = isset($catid) ? $catid : null;

// optional prefix
$shWeblinksName = shGetComponentPrefix( $option);
if (!empty($shWeblinksName) && $shWeblinksName != '/') {
  $title[] = $shWeblinksName;
}

// joomla content models
$slugsModel = Sh404sefModelSlugs::getInstance();
$menuItemTitle = getMenuTitle( null, $view, (isset($Itemid) ? $Itemid : null), '',  $shLangName);
$uncategorizedPath = $sefConfig->slugForUncategorizedWeblinks == shSEFConfig::COM_SH404SEF_UNCATEGORIZED_EMPTY ? '' : $menuItemTitle;
$slugsArray = array();

if($task == 'weblink.go') {
  // jumping to link target
  if (!empty($id)) {
    try {
      $weblinkDetails = Sh404sefHelperDb::selectObject( '#__weblinks', array('id', 'title', 'catid'), array( 'id' => $id));
      $slugsArray[] = $weblinkDetails->title;
    } catch (Sh404sefExceptionDefault $e) {
      $weblinksDetails = null;
    }
    if(!empty( $weblinkDetails->catid)) {
      try {
        $title = $slugsModel->getCategorySlugArray( 'com_weblinks', $weblinkDetails->catid, $sefConfig->includeWeblinksCat, $sefConfig->useWeblinksCatAlias, $insertId = false, $uncategorizedPath, $shLangName);
      } catch (Sh404sefExceptionDefault $e) {}
      $title[] = '/';
    }
  } else {
    $dosef = false;
  }
  if(!empty($slugsArray)) {
    $title = array_merge( $title, $slugsArray);
  }
  shRemoveFromGETVarsList('id');
  shRemoveFromGETVarsList('catid');
  shRemoveFromGETVarsList('task');
  shMustCreatePageId( 'set', true);

} else {

  // displaying weblinks
  switch ($view) {
    case 'category':
      // fetch cat name
      if(!empty( $id)) {
        try {
          $slugsArray = $slugsModel->getCategorySlugArray( 'com_weblinks', $id, $sefConfig->includeWeblinksCatCategories, $sefConfig->useContactCatAlias, $insertId = false, $menuItemTitle, $shLangName);
        } catch (Sh404sefExceptionDefault $e) {}
        $slugsArray[] = '/';
      } else {
        if (!empty($menuItemTitle)) {
          $slugsArray[] = $menuItemTitle;
        } else {
          $dosef = false;
        }
      }
      if(!empty($slugsArray)) {
        $title = array_merge( $title, $slugsArray);
      }
      shRemoveFromGETVarsList('id');
      shRemoveFromGETVarsList('catid');
      shMustCreatePageId( 'set', true);
      break;
    case 'categories':
      // fetch cat name
      if(!empty( $id)) {
        try {
          $slugsArray = $slugsModel->getCategorySlugArray( 'com_weblinks', $id, $sefConfig->includeWeblinksCatCategories, $sefConfig->useContactCatAlias, $insertId = false, $menuItemTitle, $shLangName);
        } catch (Sh404sefExceptionDefault $e) {}
        $slugsArray[] = '/';
      } else {
        if (!empty($menuItemTitle)) {
          $slugsArray[] = $menuItemTitle;
        } else {
          $dosef = false;
        }
      }
      if(!empty($slugsArray)) {
        $title = array_merge( $title, $slugsArray);
      }
      shRemoveFromGETVarsList('id');
      shRemoveFromGETVarsList('catid');
      shMustCreatePageId( 'set', true);
      break;
    case 'form':
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_CREATE_NEW_LINK'];
      break;
    default:
      $dosef = false;
      break;
  }
}

shRemoveFromGETVarsList('option');
if (!empty($Itemid))
shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
if (!empty($catid))
shRemoveFromGETVarsList('catid');
if (!empty($view))
shRemoveFromGETVarsList('view');
if (!empty($id))
shRemoveFromGETVarsList('id');
if (!empty($layout))
shRemoveFromGETVarsList('layout');

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
