<?php
/**
 * shCustomTags support for VirtueMart component.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_virtuemart.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 *
 * This module must set $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag, $shCustomRobotsTag according to specific component output
 *
 * if you set a variable to '', this will ERASE the corresponding meta tag
 * if you set a variable to null, this will leave the corresponding meta tag UNCHANGED
 *
 * Some parts from:
 * 404SEFx support for VirtueMart component.
 * Mark Fabrizio, Joomlicious
 * fabrizim@owlwatch.com
 * http://www.joomlicious.com
 *
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $VM_LANG;

// init languages system : we could use Virtuemart languages files, but I want to use the same system as sh404SEF, to have the exact same translations
global  $sh_LANG;
$mainframe = JFactory::getApplication();
$shPageInfo = & Sh404sefFactory::getPageInfo();  // get page details gathered by system plugin
$sefConfig = & Sh404sefFactory::getConfig();

// get DB
$database =& JFactory::getDBO();

// V 1.2.4.q must comply with translation restrictions
$shLangName = empty($lang) ? $shPageInfo->shMosConfig_locale : shGetNameFromIsoCode( $lang);
$shLangIso = isset($lang) ? $lang : shGetIsoCodeFromName( $shPageInfo->shMosConfig_locale);
$shLangIso = shLoadPluginLanguage( 'com_virtuemart', $shLangIso, '_PHPSHOP_LIST_ALL_PRODUCTS');
//-------------------------------------------------------------

$page = JRequest::getString('page', null);
$func = JRequest::getString('func', null);
$task = JRequest::getCmd( 'task', null);
$category_id = JRequest::getInt( 'category_id', null);
$product_id = JRequest::getInt( 'product_id', null);
$flypage = JRequest::getString('flypage', '');

global $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag, $shCustomLangTag, $shCustomRobotsTag, $shCanonicalTag;

$q = 'SELECT vendor_id, vendor_name, vendor_store_name, vendor_store_desc FROM #__vm_vendor';
$database->setQuery( $q );
$row = $database->loadObjectList();

if (!empty($row) && !empty($row[0]->vendor_name) ){
  $shShopName = $row[0]->vendor_name;
  $shStoreName = Sh404sefFactory::getPageInfo()->getDefaultLiveSite();
  $shStoreDesc = $row[0]->vendor_store_desc;
} else {
  $shShopName = $mainframe->getCfg('sitename');
  $shStoreName = Sh404sefFactory::getPageInfo()->getDefaultLiveSite();
  $shStoreDesc = $mainframe->getCfg('MetaDesc');
}

function vm_sef_get_category_title( &$db, &$catDesc, $category_id, $option, $shLangName ){

  $sefConfig = & Sh404sefFactory::getConfig();

  if (empty($category_id)) return '';
  $q  = "SELECT c.category_name, c.category_id, c.category_description, x.category_parent_id FROM #__vm_category AS c" ;
  $q .= "\n LEFT JOIN #__vm_category_xref AS x ON c.category_id = x.category_child_id;";
  $db->setQuery( $q );
  if (!shTranslateUrl($option, $shLangName))  // V 1.2.4.m
  $tree = $db->loadObjectList( 'category_id', false);
  else
  $tree = $db->loadObjectList( 'category_id' );
  $catDesc = $tree[ $category_id ]->category_description;
  $title='';
  $securityCounter = 0;
  do {               // all categories and subcategories
    $securityCounter++;
    $title .= ($sefConfig->shInsertCategoryId ?
    $tree[ $category_id ]->category_id.$sefConfig->replacement : '')
    .$tree[ $category_id ]->category_name. ' | ';
    $category_id = $tree [ $category_id ]->category_parent_id;
  } while( $category_id != 0 && $securityCounter < 10);
  if ($securityCounter >= 10) {
    JError::raiseError( 500, 'Unable to create SEF url for Virtuemart: could not find category with id : ' . $category_id);
  }
  return JString::rtrim( $title, ' | ');
}

switch ($page)
{
  case 'shop.browse':
    $catDesc = '';
    $catList = vm_sef_get_category_title( $database, $catDesc, $category_id, $option, $shLangName );
    $shCustomTitleTag = $catList ? $catList.' | ':'';
    // pagination
    $limit = JRequest::getInt( 'limit');
    $limitstart = JRequest::getInt( 'limitstart');
    $pageNumber = empty( $limit) ? $limitstart : (floor( $limitstart/$limit) + 1);
    if (!empty( $pageNumber)) {
      $sefConfig = & Sh404sefFactory::getConfig();
      if ( $sefConfig->alwaysAppendItemsPerPage || $sefConfig->shVmUsingItemsPerPage) {
        $shMultPageLength= $sefConfig->pagerep .(empty($limit) ? '' : $limit);
      } else $shMultPageLength= '';
      // shumisha : modified to add # of items per page to URL, for table-category or section-category

      if (!empty($sefConfig->pageTexts[$shPageInfo->shMosConfig_locale])
      && (false !== strpos($sefConfig->pageTexts[$shPageInfo->shMosConfig_locale], '%s'))){
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->shMosConfig_locale]);
        $pageString = str_replace('%s', $pageNumber, $pattern).$shMultPageLength;
      } else {
        $pageString = ' ' .$pageNumber.$shMultPageLength;
      }
    } else {
      $pageString = '';
    }
    $shCustomTitleTag .= empty($pageString) ? '' : $pageString .' | ';
    // shop name
    $shCustomTitleTag .= $shShopName;
    $shCustomDescriptionTag = $catDesc;
    $shCustomKeywordsTag = ($catList ? str_replace('|', ',', $catList).',':'')
    .$shShopName. ','.$shStoreName;
    $shCustomRobotsTag = 'index, follow';
    break;
  case 'shop.product_details':
    $q = "SELECT product_id, product_name, product_s_desc FROM #__vm_product";
    $q .= "\n WHERE product_id = '%d'";
    $database->setQuery( sprintf( $q, $product_id ) );
    $row = null;
    $row = $database->loadObject();
    $catDesc = '';
    $catList = vm_sef_get_category_title( $database, $catDesc, $category_id, $option, $shLangName );
    if ($row) {
      $shCustomTitleTag = $row->product_name.' | '.($catList ? $catList.' | ':'').$shShopName;
      $shCustomDescriptionTag = $row->product_s_desc;
      $shCustomKeywordsTag = $row->product_name.', '.($catList ? str_replace('|', ',', $catList).',':'')
      .$shShopName. ','.$shStoreName;
      $shCustomRobotsTag = 'index, follow';
    }
    
    // calculate canonical
    $q = "SELECT category_id FROM #__vm_product_category_xref";
    $q .= "\n WHERE product_id = '%d' limit 1";
    $database->setQuery( sprintf( $q, $product_id ) );
    $mainCatId = $database->loadResult();
    if(!empty( $mainCatId) && !empty( $category_id) && $mainCatId != $category_id) {
      $shCanonicalTag = JRoute::_('index.php?option=com_virtuemart&page=shop.product_details&product_id=' . (int) $product_id
      . '&category_id=' . $mainCatId . (empty($flypage) ? '' : '&flypage=' . $flypage));
    } 
    break;
  case 'shop.pdf_output':
    $showpage = JRequest::getString( 'showpage');
    if($showpage == 'shop.product_details') {
      $shCanonicalTag = JRoute::_('index.php?option=com_virtuemart&page=shop.product_details&product_id=' . (int) $product_id
      . '&category_id=' . $mainCatId . (empty($flypage) ? '' : '&flypage=' . $flypage));
    }
    break;
    // shumisha 2007-03-16 let's try to do something for more pages
  case 'checkout.index':
    $shCustomTitleTag = $VM_LANG->_('PHPSHOP_CHECKOUT_TITLE').' | '.$shShopName;
    $shCustomDescriptionTag = $shCustomTitleTag;
    $shCustomKeywordsTag = $VM_LANG->_('PHPSHOP_CHECKOUT_TITLE').', '.$shShopName;
    $shCustomRobotsTag = 'noindex, follow';
    break;
  case 'shop.index':
  case '':  // this is main menu link, let's fetch store name, etc
    $shCustomTitleTag = $shShopName;
    $shCustomDescriptionTag = $shStoreDesc;
    $shCustomKeywordsTag = '';
    $q  = 'SELECT category_name, category_id FROM #__vm_category';
    $database->setQuery( $q );
    $catRows = $database->loadObjectList();
    if (!empty($catRows)) {
      forEach ($catRows as $cat)
      $shCustomKeywordsTag .= $cat->category_name.',';
    }
    $shCustomKeywordsTag = $shCustomKeywordsTag.$shShopName. ','.$shStoreName;
    $shCustomRobotsTag = 'index, follow';
    break;
  default:
    break;
}

