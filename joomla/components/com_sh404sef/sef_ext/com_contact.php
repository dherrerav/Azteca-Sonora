<?php
/**
 * sh404SEF support for com_contact component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_contact.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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


// do something about that Itemid thing
if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
  //global $Itemid;
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
  }
  if ($sefConfig->shInsertTitleIfNoItemid)
  $title[] = $sefConfig->shDefaultMenuItemName ?
  $sefConfig->shDefaultMenuItemName : getMenuTitle($option, null, $shCurrentItemid );
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
  : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
  : '';
}

// collect probable url vars
$view = isset($view) ? $view : null;
$Itemid = isset($Itemid) ? $Itemid : null;
$id = isset($id) ? $id : null;
$catid = isset($catid) ? $catid : null;

// optional prefix
$shName = shGetComponentPrefix( $option);
if (!empty($shName) && $shName != '/') {
  $title[] = $shName;
}

// joomla content models
$slugsModel = Sh404sefModelSlugs::getInstance();
$menuItemTitle = getMenuTitle( null, $view, (isset($Itemid) ? $Itemid : null), '',  $shLangName);
$uncategorizedPath = $sefConfig->slugForUncategorizedContact == shSEFConfig::COM_SH404SEF_UNCATEGORIZED_EMPTY ? '' : $menuItemTitle;

$slugsArray = array();

switch ($view) {
  case 'featured':
    if (!empty($menuItemTitle)) {
      $title[] = $menuItemTitle;
      $title[] = '/';
    } else {
      $dosef = false;
    }
    shMustCreatePageId( 'set', true);
    break;
  case 'category' :
     
    // fetch cat name
    if(!empty( $id)) {
      try {
        $slugsArray = $slugsModel->getCategorySlugArray( 'com_contact', $id, $sefConfig->includeContactCatCategories, $sefConfig->useContactCatAlias, $insertId = false, $menuItemTitle, $shLangName);
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
    shRemoveFromGETVarsList('catid'); // still in use? probably a bug in sample data
    shMustCreatePageId( 'set', true);
    break;
  case 'categories':
    // get category(ies) path
    if (!empty($id)) {
      try {
        $slugsArray = $slugsModel->getCategorySlugArray( 'com_contact', $id, $sefConfig->includeContactCatCategories, $sefConfig->useContactCatAlias, $insertId = false, $menuItemTitle, $shLangName);
      } catch (Sh404sefExceptionDefault $e) {}
      // insert a suffix to distinguish from normal category listing
      if(!empty( $sefConfig->contactCategoriesSuffix)) {
        $slugsArray[] = $sefConfig->contactCategoriesSuffix;
      }
      // end with a directory sign
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
    shMustCreatePageId( 'set', true);
    break;
  case 'contact' :

    // insert category, as per settings
    if(!empty( $catid)) {
      try {
        $slugsArray = $slugsModel->getCategorySlugArray( 'com_contact', $catid, $sefConfig->includeContactCat, $sefConfig->useContactCatAlias, $insertId = false, $menuItemTitle, $shLangName);
      } catch (Sh404sefExceptionDefault $e) {}
      if(!empty($slugsArray)) {
        $title = array_merge( $title, $slugsArray);
      }
      shRemoveFromGETVarsList('catid');
    }

    // fetch contact name
    if (!empty($id)) {
      shRemoveFromGETVarsList('id');
      $database = JFactory::getDbo();
      $query  = "SELECT name, id FROM #__contact_details" ;
      $query .= " WHERE id=".$database->Quote($id);
      $database->setQuery( $query );
      if (shTranslateUrl($option, $shLangName))
      $result = $database->loadObject();
      else $result = $database->loadObject( false);
      if (!empty($result))  {
        $title[] = $result->name;
        shMustCreatePageId( 'set', true);
      }	else {
        $title[] = $id;
      }
    }
    break;
  default:
    $dosef = false;
    break;
}

shRemoveFromGETVarsList('option');
if (!empty($Itemid))
shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
if (!empty($view))
shRemoveFromGETVarsList('view');

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
