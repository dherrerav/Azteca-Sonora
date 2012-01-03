<?php
/**
 * shCustomTags support for com_content
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_content.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 *
 *  This module must set $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag,$shCustomLangTag, $shCustomRobotsTag according to specific component output
 *
 * if you set a variable to '', this will ERASE the corresponding meta tag
 * if you set a variable to null, this will leave the corresponding meta tag UNCHANGED
 *
 *
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $Itemid;

global $sh_LANG;

$mainframe = JFactory::getApplication();
$shPageInfo = & Sh404sefFactory::getPageInfo();  // get page details gathered by system plugin
$sefConfig = & Sh404sefFactory::getConfig();

$database =& JFactory::getDBO();

$view = JREQUEST::getCmd('view', null);
$catid = JREQUEST::getInt('catid', null);
$id = JREQUEST::getInt('id', null);
$limit = JREQUEST::getInt('limit', null);
$limitstart = JREQUEST::getInt('limitstart', null);
$layout = JREQUEST::getCmd('layout', null);
$showall = JREQUEST::getInt('showall', null);
$format = JREQUEST::getCmd('format', null);
$print = JREQUEST::getInt('print', null);
$tmpl = JREQUEST::getCmd('tmpl', null);
$lang = JREQUEST::getString('lang', null);

$shLangName = empty($lang) ? $shPageInfo->shMosConfig_locale : shGetNameFromIsoCode( $lang);
$shLangIso = isset($lang) ? $lang : shGetIsoCodeFromName( $shPageInfo->shMosConfig_locale);
$shLangIso = shLoadPluginLanguage( 'com_content', $shLangIso, 'COM_SH404SEF_CREATE_NEW');
//-------------------------------------------------------------

global 	$shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag,
$shCustomLangTag, $shCustomRobotsTag, $shCanonicalTag;

// add no follow to print pages
$shCustomRobotsTag = ($tmpl == 'component' && !empty( $print) ) ? 'noindex, nofollow' : $shCustomRobotsTag;

// calculate page title
$title= array();
switch ($view) {
  case 'archivecategory':
  case 'archivesection' :
    $shCustomTitleTag = $sh_LANG[$shLangIso]['COM_SH404SEF_ARCHIVE']
    . ' '.$sefConfig->replacement.' '. $shPageInfo->getDefaultLiveSite();
    break;
  case 'form':
    break;
  case 'featured':
    $shCustomDescriptionTag = $mainframe->getCfg('MetaDesc');
    $shCustomKeywordsTag = $mainframe->getCfg('MetaKeys');
    $shTitle = shGetJoomlaMenuItemPageTitle();
    if (empty($shTitle)) {
      $config =& JFactory::getConfig();
      $title[] = $config->getValue('config.sitename');
    }	else {
      $title[] = $shTitle;
    }

    // handle second, third,... pages on home page
    // TODO same code used in function shAddPaginationInfo, should regroup
    if (!empty( $limitstart)) {
      $shLimit = shGetDefaultDisplayNumFromConfig( $shPageInfo->shCurrentPageNonSef, $includeBlogLinks = false);
      $pagenum = empty( $shLimit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
      if ( $sefConfig->alwaysAppendItemsPerPage) {
        $shMultPageLength= $sefConfig->pagerep . $shLimit;
      } else $shMultPageLength= '';

      if (!empty($sefConfig->pageTexts[$shPageInfo->shMosConfig_locale])
      && (false !== strpos($sefConfig->pageTexts[$shPageInfo->shMosConfig_locale], '%s'))){
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->shMosConfig_locale]);
        $title[] = str_replace('%s', $pagenum, $pattern).$shMultPageLength;
      } else {
        $title[] = ' ' . $pagenum.$shMultPageLength;
      }
    }

    $shCustomTitleTag = JString::ltrim(implode( ' | ', $title), '/ | ');

    break;

  default:
    if ($view=='form' && !empty($layout) && $layout == 'edit') { // submit new article
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_CREATE_NEW'];
      if (!empty($sectionid)) {
        $q = 'SELECT id, title FROM #__sections WHERE id = '.intval($sectionid);
        $database->setQuery($q);
        if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
        $sectionTitle = $database->loadObject( );
        else $sectionTitle = $database->loadObject( false);
        if ($sectionTitle) {
          $title[] = $sectionTitle->title;
        }
      }
    }

    // calculate canonical
    if($view == 'article' && !empty($print)) {

      $nonSef = Sh404sefHelperGeneral::stripTrackingVarsFromNonSef( $shPageInfo->shCurrentPageNonSef);
      $nonSef = str_replace( array( 'format=pdf', 'print=1') , '', $nonSef);
      $shCanonicalTag = JRoute::_( $nonSef);
    }
    // use regular function to get content titles, as per out specific settings
    $customConfig = clone( $sefConfig);

    $customConfig->includeContentCat = $sefConfig->contentTitleIncludeCat;
    $customConfig->UseAlias = $sefConfig->ContentTitleUseAlias;
    $customConfig->useCatAlias = $sefConfig->ContentTitleUseCatAlias;
    $customConfig->LowerCase = false;
    $customConfig->ContentTitleInsertArticleId = false;
    // V 1.2.4.t protect against sef_ext.php not being included
    if (!class_exists('sef_404')) {
      require_once(sh404SEF_ABS_PATH.'components/com_sh404sef/sef_ext.php');
    }
    $layout = isset($layout) ? $layout : null;
    $articleId = shGetArticleIdString( $id, $view, $option, $shLangName);
    $title = sef_404::getContentSlugsArray($view, $id, $layout, $Itemid, $shLangName, $customConfig);
    if (!empty( $articleId)) {
      $lastBit = array_pop( $title);
      $lastBit .= ' [' . $articleId . ']';
      array_push( $title, $lastBit);
    }
    $pageNumber = '';
    // V 1.2.4.t try better handling of multipages article (use of mospagebreak)
    if ($view == 'article' && !empty($limitstart) ) {  // this is multipage article
      $shPageTitle = '';
      $sql = 'SELECT c.id, c.fulltext, c.introtext  FROM #__content AS c WHERE id='.$id;
      $database->setQuery($sql);
      $contentElement = $database->loadObject( );
      if ($database->getErrorNum()) {
        JError::raiseError(500, $database->stderr() );
      }
      $contentText = $contentElement->introtext.$contentElement->fulltext;

      if (!empty($contentElement) && empty($showall) && ( strpos( $contentText, 'class="system-pagebreak' ) !== false )) { // search for mospagebreak tags
        // copied over from pagebreak plugin
        // expression to search for
        //$regex = '/{(mospagebreak)\s*(.*?)}/i';
        $regex = '#<hr([^>]*)class=\"system-pagebreak\"([^>]*)\/>#iU';
        // find all instances of mambot and put in $matches
        $shMatches = array();
        preg_match_all( $regex, $contentText, $shMatches, PREG_SET_ORDER );
        // adds heading or title to <site> Title
        if (empty($limitstart)) {  // if first page use heading of first mospagebreak
        } else {  // for other pages use title of mospagebreak
          if ( $limitstart > 0 && $shMatches[$limitstart-1][1] ) {
            $args = JUtility::parseAttributes( $shMatches[$limitstart-1][0] );
            if ( @$args['title'] ) {
              $shPageTitle = $args['title'];
            } else if (@$args['alt']) {
              $shPageTitle = $args['alt'];
            } else {  // there is a page break, but no title. Use a page number
              $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->shMosConfig_locale]);
              $shPageTitle = str_replace('%s', $limitstart+1, $pattern);
            }
          }
        }
      }

      if (!empty($shPageTitle))  // found a heading, we should use that as a Title
      $title[] = shCleanUpTitle($shPageTitle);
    } else {
      if (!empty( $limit) && !empty( $limitstart)) {
        //TODO handle multipages
        $shLimit = $layout == 'blog' ? shGetDefaultDisplayNumFromConfig( $shPageInfo->shCurrentPageNonSef, $includeBlogLinks = $view == 'section') : $limit;
        $pagenum = empty( $limit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
        if ( $sefConfig->alwaysAppendItemsPerPage) {
          $shMultPageLength= $sefConfig->pagerep . $shLimit;
        } else $shMultPageLength= '';
        $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->shMosConfig_locale]);
        $pageNumber = str_replace('%s', $pagenum, $pattern).$shMultPageLength;
      } else {
        if (!empty($limitstart)) {  // this may be a blog category view, with more than one page
          if ($title[count($title)-1] == '/') { // need to remove trailing slash added by getContentTitle
            unset($title[count($title)-1]);
          }
          if ($view == 'article') {
            $pagenum = intval($limitstart+1);   // multipage article
          }
          if(!empty($pagenum)) {
            $pattern  = str_replace( $sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->shMosConfig_locale]);
            $pageNumber = str_replace('%s', $pagenum, $pattern)/*.$shMultPageLength*/;
          }
        } else {
          if (!empty($showall)) {
            $pageNumber = titleToLocation(JText::_( 'All Pages' ));
          }
        }
      }
    }
    // V 1.2.4.j 2007/04/11 : numerical ID, on some categories only
    if ($sefConfig->shInsertNumericalId && isset($sefConfig->shInsertNumericalIdCatList)
    && !empty($id) && ($view == 'view')) {

      $q = 'SELECT id, catid, created FROM #__content WHERE id = '.$id;
      $database->setQuery($q);
      if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
      $contentElement = $database->loadObject( );
      else $contentElement = $database->loadObject( false);
      if (!empty($contentElement)) { // V 1.2.4.t
        $foundCat = array_search(@$contentElement->catid, $sefConfig->shInsertNumericalIdCatList);
        if (($foundCat !== null && $foundCat !== false)
        || ($sefConfig->shInsertNumericalIdCatList[0] == ''))  { // test both in case PHP < 4.2.0
          $shTemp = explode(' ', $contentElement->created);
          $title[] = str_replace('-','', $shTemp[0]).$contentElement->id;
        }
      }
    }

    // V 1.2.4.k 2007/04/25 : if activated, insert edition id and name from iJoomla magazine
    if (!empty($ed) && $sefConfig->shActivateIJoomlaMagInContent && $id && ($view == 'view')) {
      $q = 'SELECT id, title FROM #__magazine_categories WHERE id = '.$ed;
      $database->setQuery($q);
      if (shTranslateUrl($option, $shLangName)) // V 1.2.4.m
      $issueName = $database->loadObject(false);
      else $issueName = $database->loadObject( );
      if ($issueName) {
        $title[] = ($sefConfig->shInsertIJoomlaMagIssueId ? $ed.$sefConfig->replacement:'')
        .$issueName->title;
      }
    }
    // end of edition id insertion
    $title = array_reverse( $title);
    if (!empty($pageNumber)) {  // better add page number at end rather than beg
      $title[] = $pageNumber;
    }
    $shCustomTitleTag = JString::ltrim(implode( $sefConfig->pageTitleSeparator, $title), '/' . $sefConfig->pageTitleSeparator);
}

