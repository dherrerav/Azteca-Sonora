<?php
/**
 * SEO extension for Joomla! 1.6
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shSEFConfig.class.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class shSEFConfig {

  const CAT_ALL_NESTED_CAT = 0;
  const CAT_FIRST = 1;
  const CAT_LAST = 2;
  const CAT_2_FIRST = 3;
  const CAT_2_LAST = 4;
  const CAT_NONE = 5;

  const DONT_ENFORCE_WWW = 0;
  const ENFORCE_WWW = 1;
  const ENFORCE_NO_WWW = 2;

  const COM_SH404SEF_UNCATEGORIZED_EMPTY = 0;
  const COM_SH404SEF_UNCATEGORIZED_USE_MENU_ITEM = 1;

  /* string,  version number */
  var $version = '3.1.5.1098';
  /* boolean, is 404 SEF enabled  */
  var $Enabled = false;
  /* char,  Character to use for url replacement */
  var $replacement = '-';
  /* char,  Character to use for page spacer */
  var $pagerep = '-';
  /* strip these characters */
  var $stripthese = ',|~|!|@|%|^|(|)|<|>|:|;|{|}|[|]|&|`|„|‹|’|‘|“|”|•|›|«|´|»|°';
  /* characters replacement table v 1.2.4.f April 4, 2007*/
  var $shReplacements = 'Š|S, Œ|O, Ž|Z, š|s, œ|oe, ž|z, Ÿ|Y, ¥|Y, µ|u, À|A, Á|A, Â|A, Ã|A, Ä|A, Å|A, Æ|A, Ç|C, È|E, É|E, Ê|E, Ë|E, Ì|I, Í|I, Î|I, Ï|I, Ð|D, Ñ|N, Ò|O, Ó|O, Ô|O, Õ|O, Ö|O, Ø|O, Ù|U, Ú|U, Û|U, Ü|U, Ý|Y, ß|s, à|a, á|a, â|a, ã|a, ä|a, å|a, æ|a, ç|c, è|e, é|e, ê|e, ë|e, ì|i, í|i, î|i, ï|i, ð|o, ñ|n, ò|o, ó|o, ô|o, õ|o, ö|o, ø|o, ù|u, ú|u, û|u, ü|u, ý|y, ÿ|y, ß|ss, ă|a, ş|s, ţ|t, ț|t, Ț|T, Ș|S, ș|s, Ş|S';
  /* string,  suffix for "files" */
  var $suffix = '.html';
  /* string,  file to display when there is none */
  var $addFile = '';
  /* trims friendly characters from where they shouldn't be */
  var $friendlytrim = '-|.';
  /* boolean, convert url to lowercase */
  var $LowerCase = false;
  /* boolean, include the section name in url */
  var $ShowSection = false;
  /* boolean, exclude the category name in url */
  var $ShowCat = true;
  /* boolean, use the title_alias instead of the title */
  var $UseAlias = true;
  /* int, id of #__content item to use for static page */
  var $page404 = 0;
  /* Array, contains predefined components. DEPRECATED - 2.2.4*/
  var $predefined = array(
  );
  /* Array, contains components 404 SEF will ignore. */
  var $skip = array();
  /* Array, contains components 404 SEF will not add to the DB.
   * default style URLs will be generated for these components instead
   */
  var $nocache = array('events');
  // shumisha : additional parameters
  /* Array, contains components 404 SEF will override their own sef_ext file if it has its own plugin. */
  var $shDoNotOverrideOwnSef = array();
  /* boolean,  true (default) to log 404 errors to DB, false otherwise  */
  var $shLog404Errors = true;
  /* boolean,  true (default) to use in mem cache, false to disable  */
  var $shUseURLCache = true;
  /* integer, max number of URL couple (sef + non-sef url) allowed in cache */
  var $shMaxURLInCache = 10000;
  /* boolean,  true (default) to translate texts in URL */
  var $shTranslateURL = true;
  /* boolean,  true (default) will always insert language iso code in URL (for other than default language) */
  var $shInsertLanguageCode = true;
  /* Array, contains components sh404SEF will NOT translate URLs */
  var $notTranslateURLList = array();  // V 1.2.4.m
  /* Array, contains components sh404SEF will NOT insert iso code in URL */
  var $notInsertIsoCodeList = array();
  // cache management
  /* boolean, true if insert Itemid of menu item is none exists */
  var $shInsertGlobalItemidIfNone = false;
  /* boolean, if true insert title of menu item if no Itemid exists for the URL*/
  var $shInsertTitleIfNoItemid = false;
  /* boolean, true if always insert title of menu item. URL Itemid is used, if any, or menu item title*/
  var $shAlwaysInsertMenuTitle= false;
  /* boolean, true if always append Itemid of non-sef URL (or of current menu item if none) to SEF URL */
  var $shAlwaysInsertItemid= false; // v 1.2.4.f
  /* string, default menu name, to be used if $shAlwaysInsertMenuTitle is true, to override menu title */
  var $shDefaultMenuItemName = '';
  /* boolean, if true, Getvars not used in URl will be reappend to it  */
  var $shAppendRemainingGETVars = true;

  // virtuemart management
  /* boolean, true if always insert title of shop menu item */
  var $shVmInsertShopName= false;
  /* boolean, if true, product ID will be prepended to product name */
  var $shInsertProductId = false;
  /* boolean, if true, product sku will be used instead of name */
  var $shVmUseProductSKU = false;
  /* boolean, if true, product Manufacturer name will be included in URL */
  var $shVmInsertManufacturerName = false;
  /* boolean, if true, product if will be prepended to manufacturer name */
  var $shInsertManufacturerId = false;
  /* integer, if 0, no categories will be inserted in URL for a product
   if 1, only 'last' category will be inserted in URL
   if 2, all nested categories will be inserted in URL */
  var $shVMInsertCategories = 1;

  /* boolean, if true, an additional text will be appended to sef URl when browsing categories
   * ie : .../product_cat/view-all-products.html VS .../product_cat/     */
  var $shVmAdditionalText = true;
  /* boolean, if true, a flypage name will be inserted in URL     */
  var $shVmInsertFlypage = true;

  /* boolean, if true, category id will be prepended to category name */
  var $shInsertCategoryId = false;
  /* boolean, if true, numerical id will be prepended to URL, for inclusion in Googlenews  */
  var $shInsertNumericalId = false;
  /* text, list of categories of content to which numerical id should be applied  */
  var $shInsertNumericalIdCatList = '';
  /* boolean, if true, non-sef URL like index.php?option=com_content&task=view&id=12&Itemid=2 will be 301-redirected to their sef equivalent */
  var $shRedirectNonSefToSef = true;
  /* boolean, if true, Joomla sef URL like /content/view/12/61 will be 301-redirected to their sef equivalent */
  var $shRedirectJoomlaSefToSef = false;
  /* string, should be set to SSL secure URL of site if any used. No trailing / */
  var $shConfig_live_secure_site = '';
  /* boolean, if true, ed non-sef parameter will be interpreted as a iJoomla param in com_content plugin  */
  var $shActivateIJoomlaMagInContent = true;
  /* boolean, if true, issue id of iJoomla magazine will be prepended to category name */
  var $shInsertIJoomlaMagIssueId = false;
  /* boolean, if true, magazine name will be prepended to all URL */
  var $shInsertIJoomlaMagName = false;
  /* boolean, if true, magazine id will be inserted before magazine title */
  var $shInsertIJoomlaMagMagazineId = false;
  /* boolean, if true, article id will be inserted before article title */
  var $shInsertIJoomlaMagArticleId = false;


  /* boolean, if true, name of menu item leading to Community builder will be prepended to all URL */
  var $shInsertCBName = false;
  /* boolean, if true, user name will be inserte to all URL wher appropriate. Warning : this will
   *  increase DB space used? Normally user id is still passed as a GET param (ie ...?user=245)
   *  to save space and increase speed  */
  var $shCBInsertUserName = false;
  /* boolean, if true, id of user will be prepended to its name when previous option is activated
   *  in case two users have the same name */
  var $shCBInsertUserId = true;
  /* boolean, if true user pseudo will be used instead of name */
  var $shCBUseUserPseudo = true;

  /* integer, default value for Itemid when using lettermand newsletter component */
  var $shLMDefaultItemid = 0;

  /* boolean, if true, default name for board will be prepended to URL */
  var $shInsertFireboardName = false;
  /* boolean, if true name of forum category will be inserted in URL */
  var $shFbInsertCategoryName = true;
  /* boolean, if true, Category id will be prepended to category name, in case 2 categories have same name */
  var $shFbInsertCategoryId = false;
  /* boolean, if true, message subject will be inserted in URL */
  var $shFbInsertMessageSubject = true;
  /* boolean, if true message id will be prepended to subject, in case 2 messages have same subject */
  var $shFbInsertMessageId = true;

  /* MyBlog parameters  V 1.2.4.r*/
  var $shInsertMyBlogName = false;
  var $shMyBlogInsertPostId = true;
  var $shMyBlogInsertTagId = false;
  var $shMyBlogInsertBloggerId = true;

  /* Docman parameters  V 1.2.4.r*/
  var $shInsertDocmanName = false;
  var $shDocmanInsertDocId = true;
  var $shDocmanInsertDocName = true;
  /* integer, if 0, no categories will be inserted in URL for a product
   if 1, only 'last' category will be inserted in URL
   if 2, all nested categories will be inserted in URL */
  var $shDMInsertCategories = 1;
  /* boolean, if true, category id will be prepended to category name */
  var $shDMInsertCategoryId = false;

  /* boolean, if true, url will be urlencoded, needed for some non-latin languages */
  var $shEncodeUrl = false;

  /* boolean, if true, Itemid from url on homepage with com_content will be removed, so that com_content plugin
   *  can try guess amore appropriate one  */
  var $guessItemidOnHomepage = false; // V 1.2.4.q
  // V 1.2.4.q : added param to force non-sef if https, as we are not through with some shared ssl servers!
  var $shForceNonSefIfHttps = false;

  // V 1.2.4.s try SEF without mod_rewrite
  // V 3.0+ mode 2, /index.php?/ removed, not compatible with using Joomla router
  var $shRewriteMode = 1;  // 0 = mod_rewrite, 1 = AcceptpathInfo index.php 2 = AcceptPathInfo index.php?
  var $shRewriteStrings = array('/','/index.php/','/index.php?/');

  // V1.2.4.s  record duplicate URL param
  var $shRecordDuplicates = true;
  var $shRemoveGeneratorTag = true;
  var $shPutH1Tags = false;
  var $shMetaManagementActivated = true;
  var $shInsertContentTableName = true;
  var $shContentTableName = 'Table';

  // V 1.2.4.s auto redirect from www to non-www and vice-versa
  var $shAutoRedirectWww = self::DONT_ENFORCE_WWW;
  var $shVmInsertProductName = true;

  // V 1.2.4.t
  /* string, exact URL for homepage, to replace the automatic one. Workaround for splash pagesNo trailing / */
  var $shForcedHomePage = '';
  var $shInsertContentBlogName = false;
  var $shContentBlogName = '';

  // Mosets Tree params
  var $shInsertMTreeName = false;
  var $shMTreeInsertListingName = true;
  var $shMTreeInsertListingId = true;
  var $shMTreePrependListingId = true;
  /* integer, if 0, no categories will be inserted in URL for a product
   if 1, only 'last' category will be inserted in URL
   if 2, all nested categories will be inserted in URL */
  var $shMTreeInsertCategories = 1;
  /* boolean, if true, category id will be prepended to category name */
  var $shMTreeInsertCategoryId = false;
  var $shMTreeInsertUserName = true;
  var $shMTreeInsertUserId = true;
   
  // iJoomla NewsPortal params
  var $shInsertNewsPName = false;
  var $shNewsPInsertCatId = false;
  var $shNewsPInsertSecId = false;
   
  /* Remository parameters  V 1.2.4.t*/
  var $shInsertRemoName = false;
  var $shRemoInsertDocId = true;
  var $shRemoInsertDocName = true;
  /* integer, if 0, no categories will be inserted in URL for a product
   if 1, only 'last' category will be inserted in URL
   if 2, all nested categories will be inserted in URL */
  var $shRemoInsertCategories = 1;
  /* boolean, if true, category id will be prepended to category name */
  var $shRemoInsertCategoryId = false;
   
  // boolean, if true, task = userProfile is accessed through mysite.com/username in CB
  var $shCBShortUserURL = false; //V 1.2.4.t

  // a set of boolean vars, to decide what to do with existing data when upgrading sh404SEF
  var $shKeepStandardURLOnUpgrade = true; //V 1.2.4.t
  var $shKeepCustomURLOnUpgrade = true; //V 1.2.4.t
  var $shKeepMetaDataOnUpgrade = true; //V 1.2.4.t
  var $shKeepModulesSettingsOnUpgrade = true; //V 1.2.4.t

  // boolean, to decide whether to replace page numbering by headings in multipage articles
  var $shMultipagesTitle = true; //V 1.2.4.t
   
  // compatiblity variables, for sef_ext files usage from OpenSef/SEf Advance
  var $encode_page_suffix = '';
  var $encode_space_char = '';
  var $encode_lowercase = '';
  var $encode_strip_chars = '';
  var $spec_chars_d;
  var $spec_chars;
  var $content_page_format;  // V 1.2.4.r
  var $content_page_name;  // V 1.2.4.r

  // V x
  var $shKeepConfigOnUpgrade = true;

  // security parameters  V x
  var $shSecEnableSecurity = true;
  var $shSecLogAttacks = true;
  var $shSecOnlyNumVars = array('itemid','limit', 'limitstart');
  var $shSecAlphaNumVars = array();
  var $shSecNoProtocolVars = array('task','option','no_html','mosmsg', 'lang');
  var $ipWhiteList = '';
  var $ipBlackList = '';
  var $uAgentWhiteList = '';
  var $uAgentBlackList = '';
  var $shSecCheckHoneyPot = false;
  var $shSecHoneyPotKey = '';
  var $shSecEntranceText ="<p>Sorry. You are visiting this site from a suspicious IP address, which triggered our protection system.</p>
    <p>If you <strong>ARE NOT</strong> a malware robot of any kind, please accept our apologies for the inconvenience. You can access the page by clicking here : ";
  var $shSecSmellyPotText = "The following link is here to further trap malicious internet robots, so please don't click on it : ";
  var $monthsToKeepLogs = 1;  // = 1 will keep current months log + the month before
  var $shSecActivateAntiFlood = true;
  var $shSecAntiFloodOnlyOnPOST = false;  // if true, antiflood is activated only if there is some POST data, as in a form
  var $shSecAntiFloodPeriod = 10;   // period over which requests from same IP are counted
  var $shSecAntiFloodCount = 10;    // max number of request from same IP in period above

  //var $insertSectionInBlogTableLinks = false; // default should be true, but set to false for compat reason

  /* Array, contains whether we should translate URLs per language */
  var $shLangTranslateList = array();  // V 1.2.4.m
  /* Array, contains whether we should insert iso code URLs per language */
  var $shLangInsertCodeList = array();
  /* Array, contains list of default initial URL fragement per component */
  var $defaultComponentStringList = array();  // V 1.2.4.m
  /* Array, contains pagination string, per language */
  var $pageTexts = array();

  var $shAdminInterfaceType = SH404SEF_STANDARD_ADMIN;

  // V 1.3 RC shCustomTags params
  var $shInsertNoFollowPDFPrint = true;
  var $shInsertReadMorePageTitle = false;
  var $shMultipleH1ToH2 = false;

  // V 1.3.1 RC
  var $shVmUsingItemsPerPage = true;  // set to true if using drop-down list to select number of items per page
  var $shSecCheckPOSTData = true;    // if set to yes, POST data will not be checked for mosconfig, script, base64,
  // standard vars and cmd file in img names
  var $shSecCurMonth = 0;
  var $shSecLastUpdated = 0;
  var $shSecTotalAttacks = 0;
  var $shSecTotalConfigVars = 0;
  var $shSecTotalBase64 =0;
  var $shSecTotalScripts = 0;
  var $shSecTotalStandardVars = 0;
  var $shSecTotalImgTxtCmd = 0;
  var $shSecTotalIPDenied = 0;
  var $shSecTotalUserAgentDenied = 0;
  var $shSecTotalFlooding = 0;
  var $shSecTotalPHP = 0;
  var $shSecTotalPHPUserClicked = 0;
  // com_smf params
  var $shInsertSMFName = true;
  var $shSMFItemsPerPage = 20;
  var $shInsertSMFBoardId = true;
  var $shInsertSMFTopicId = true;
  var $shinsertSMFUserName = false;
  var $shInsertSMFUserId = true;

  // other
  var $appendToPageTitle = '';
  var $prependToPageTitle = '';
  var $debugToLogFile = false;
  var $debugStartedAt = 0;
  var $debugDuration = 3600;  // time in seconds to log debug data to file. if 0, unlimited, default = 1 hour

  // V 1.3.1
  var $shInsertOutboundLinksImage = false;
  var $shImageForOutboundLinks = 'external-black.png';  // default = black image

  // V 1.0.3
  var $defaultParamList = '';  // holds content of /administrator/components/custom.sef.php for editing

  // V 1.0.12
  var $useCatAlias = false;
  var $useSecAlias = false;
  var $useMenuAlias = false;

  // V 1.5.3
  var $alwaysAppendItemsPerPage = false;
  var $redirectToCorrectCaseUrl = true;

  // V 1.5.5
  var $jclInsertEventId = false;
  var $jclInsertCategoryId = false;
  var $jclInsertCalendarId = false;
  var $jclInsertCalendarName = false;
  var $jclInsertDate = false;
  var $jclInsertDateInEventView = true;

  var $ContentTitleShowSection = false;
  var $ContentTitleShowCat = true;
  var $ContentTitleUseAlias = false;
  var $ContentTitleUseCatAlias = false;
  var $ContentTitleUseSecAlias = false;
  var $pageTitleSeparator = ' | ';

  // V 1.5.7
  var $ContentTitleInsertArticleId = false;
  /* text, list of categories of content to which numerical id should be applied  */
  var $shInsertContentArticleIdCatList = '';
   
  // V 1.5.8

  var $shJSInsertJSName = true;
  var $shJSShortURLToUserProfile = true;
  var $shJSInsertUsername = true;
  var $shJSInsertUserFullName = false;
  var $shJSInsertUserId = false;
  var $shJSInsertGroupCategory = true;
  var $shJSInsertGroupCategoryId = false;
  var $shJSInsertGroupId = false;
  var $shJSInsertGroupBulletinId = false;
  var $shJSInsertDiscussionId = true;
  var $shJSInsertMessageId = true;
  var $shJSInsertPhotoAlbum = true;
  var $shJSInsertPhotoAlbumId = false;
  var $shJSInsertPhotoId = true;
  var $shJSInsertVideoCat = true;
  var $shJSInsertVideoCatId = false;
  var $shJSInsertVideoId = true;

  var $shFbInsertUserName = true;
  var $shFbInsertUserId = true;
  var $shFbShortUrlToProfile = true;

  var $shPageNotFoundItemid = 0;

  // V 2.0.0
  var $autoCheckNewVersion = true;
  var $error404SubTemplate = 'index';

  /**
   * Holds whether we should create a page id
   * for current url routing task
   *
   * @var boolean
   */
  var $enablePageId = true;
  var $compEnablePageId = array( 'contact', 'content', 'newsfeeds', 'poll', 'user', 'weblinks');

  // V 2.0.1
  var $analyticsEnabled = false;
  var $analyticsReportsEnabled = true;
  var $analyticsType = 'ga'; // google
  var $analyticsId = '';
  var $analyticsExcludeIP = array();
  var $analyticsMaxUserLevel = '';
  var $analyticsUser = '';
  var $analyticsPassword = '';
  var $analyticsAccount = '';
  var $analyticsProfile = '';
  var $autoCheckNewAnalytics = true;
  var $analyticsDashboardDateRange = 'week';
  var $analyticsEnableTimeCollection = true;
  var $analyticsEnableUserCollection = true;
  var $analyticsDashboardDataType = 'pageviews'; // visits | unique | pageviews

  // v 2.1.4
  var $slowServer = false;

  // V 2.1.7
  //var $insertContactCat = false;

  // V 2.1.10
  var $useJoomsefRouter = array();
  var $useAcesefRouter = array();

  // V 2.2.11
  var $insertShortlinkTag = true;
  var $insertRevCanTag = false;
  var $insertAltShorterTag = false;
  var $canReadRemoteConfig = false;
  var $stopCreatingShurls = false;
  var $shurlBlackList = '';
  var $shurlNonSefBlackList = '';
   
  // V 3.0.0
  var $includeContentCat = self::CAT_LAST;
  var $includeContentCatCategories = self::CAT_2_LAST;
  var $contentCategoriesSuffix = 'all';
  var $contentTitleIncludeCat = self::CAT_ALL_NESTED_CAT;

  var $useContactCatAlias = false;
  var $contactCategoriesSuffix = 'all';
  var $includeContactCat = self::CAT_NONE;
  var $includeContactCatCategories = self::CAT_LAST;

  var $useWeblinksCatAlias = false;
  var $weblinksCategoriesSuffix = 'all';
  var $includeWeblinksCat = self::CAT_LAST;
  var $includeWeblinksCatCategories = self::CAT_LAST;
  var $liveSites = array();
  var $alternateTemplate = '';
  var $useJoomlaRouter = array();

  // 3.1.2
  var $slugForUncategorizedContent = self::COM_SH404SEF_UNCATEGORIZED_EMPTY;
  var $slugForUncategorizedContact = self::COM_SH404SEF_UNCATEGORIZED_EMPTY;
  var $slugForUncategorizedWeblinks = self::COM_SH404SEF_UNCATEGORIZED_EMPTY;
  
  // End of parameters

  function shSEFConfig() {

    $sef_config_file = sh404SEF_ADMIN_ABS_PATH.'config/config.sef.php';

    $app = JFactory::getApplication();
    if ($app->isAdmin()) {
      $this->shCheckFilesAccess();
    }

    if (shFileExists($sef_config_file)) {
      include($sef_config_file);
    }

    // shumisha : 2007-04-01 version was missing !
    //if (isset($version))    $this->version    = $version;  // V 1.2.4.r : removed as would prevent update system to work : version was not updated
    // shumisha : 2007-04-01 new parameters !
    if (isset($shUseURLCache))    $this->shUseURLCache    = $shUseURLCache;
    // shumisha : 2007-04-01 new parameters !
    if (isset($shMaxURLInCache))    $this->shMaxURLInCache    = $shMaxURLInCache;
    // shumisha : 2007-04-01 new parameters !
    if (isset($shTranslateURL))   $this->shTranslateURL   = $shTranslateURL;
    //V 1.2.4.m
    if (isset($shInsertLanguageCode))   $this->shInsertLanguageCode   = $shInsertLanguageCode;
    if (isset($notTranslateURLList))    $this->notTranslateURLList    = $notTranslateURLList;
    if (isset($notInsertIsoCodeList))   $this->notInsertIsoCodeList   = $notInsertIsoCodeList;

    // shumisha : 2007-04-03 new parameters !
    if (isset($shInsertGlobalItemidIfNone)) $this->shInsertGlobalItemidIfNone = $shInsertGlobalItemidIfNone;
    if (isset($shInsertTitleIfNoItemid))  $this->shInsertTitleIfNoItemid  = $shInsertTitleIfNoItemid;
    if (isset($shAlwaysInsertMenuTitle))  $this->shAlwaysInsertMenuTitle  = $shAlwaysInsertMenuTitle;
    if (isset($shAlwaysInsertItemid)) $this->shAlwaysInsertItemid = $shAlwaysInsertItemid;
    if (isset($shDefaultMenuItemName))  $this->shDefaultMenuItemName = $shDefaultMenuItemName;
    if (isset($shAppendRemainingGETVars)) $this->shAppendRemainingGETVars = $shAppendRemainingGETVars;
    if (isset($shVmInsertShopName)) $this->shVmInsertShopName = $shVmInsertShopName;

    if (isset($shInsertProductId))  $this->shInsertProductId  = $shInsertProductId;
    if (isset($shVmUseProductSKU))  $this->shVmUseProductSKU  = $shVmUseProductSKU;
    if (isset($shVmInsertManufacturerName))
    $this->shVmInsertManufacturerName = $shVmInsertManufacturerName;
    if (isset($shInsertManufacturerId)) $this->shInsertManufacturerId = $shInsertManufacturerId;
    if (isset($shVMInsertCategories)) $this->shVMInsertCategories= $shVMInsertCategories;
    if (isset($shVmAdditionalText)) $this->shVmAdditionalText= $shVmAdditionalText;
    if (isset($shVmInsertFlypage))  $this->shVmInsertFlypage= $shVmInsertFlypage;

    if (isset($shInsertCategoryId)) $this->shInsertCategoryId= $shInsertCategoryId;
    if (isset($shReplacements)) $this->shReplacements= $shReplacements;

    if (isset($shInsertNumericalId))  $this->shInsertNumericalId = $shInsertNumericalId;
    if (isset($shInsertNumericalIdCatList)) $this->shInsertNumericalIdCatList = $shInsertNumericalIdCatList;

    if (isset($shRedirectNonSefToSef))  $this->shRedirectNonSefToSef = $shRedirectNonSefToSef;
    if (isset($shRedirectJoomlaSefToSef)) $this->shRedirectJoomlaSefToSef = $shRedirectJoomlaSefToSef;
    if (isset($shConfig_live_secure_site))
    $this->shConfig_live_secure_site = JString::rtrim( $shConfig_live_secure_site, '/');

    if (isset($shActivateIJoomlaMagInContent))
    $this->shActivateIJoomlaMagInContent = $shActivateIJoomlaMagInContent;
    if (isset($shInsertIJoomlaMagIssueId))
    $this->shInsertIJoomlaMagIssueId = $shInsertIJoomlaMagIssueId;
    if (isset($shInsertIJoomlaMagName))
    $this->shInsertIJoomlaMagName = $shInsertIJoomlaMagName;
    if (isset($shInsertIJoomlaMagMagazineId))
    $this->shInsertIJoomlaMagMagazineId = $shInsertIJoomlaMagMagazineId;
    if (isset($shInsertIJoomlaMagArticleId))
    $this->shInsertIJoomlaMagArticleId = $shInsertIJoomlaMagArticleId;

    if (isset($shInsertCBName))
    $this->shInsertCBName = $shInsertCBName;
    if (isset($shCBInsertUserName))
    $this->shCBInsertUserName = $shCBInsertUserName;
    if (isset($shCBInsertUserId))
    $this->shCBInsertUserId = $shCBInsertUserId;
    if (isset($shCBUseUserPseudo))
    $this->shCBUseUserPseudo = $shCBUseUserPseudo;
     
    if (isset($shInsertMyBlogName))
    $this->shInsertMyBlogName = $shInsertMyBlogName;
    if (isset($shMyBlogInsertPostId))
    $this->shMyBlogInsertPostId = $shMyBlogInsertPostId;
    if (isset($shMyBlogInsertTagId))
    $this->shMyBlogInsertTagId = $shMyBlogInsertTagId;
    if (isset($shMyBlogInsertBloggerId))
    $this->shMyBlogInsertBloggerId = $shMyBlogInsertBloggerId;

    if (isset($shInsertDocmanName))
    $this->shInsertDocmanName = $shInsertDocmanName;
    if (isset($shDocmanInsertDocId))
    $this->shDocmanInsertDocId = $shDocmanInsertDocId;
    if (isset($shDocmanInsertDocName))
    $this->shDocmanInsertDocName = $shDocmanInsertDocName;

    if (isset($shLog404Errors))
    $this->shLog404Errors = $shLog404Errors;

    if (isset($shLMDefaultItemid))
    $this->shLMDefaultItemid = $shLMDefaultItemid;
     
    if (isset($shInsertFireboardName))
    $this->shInsertFireboardName = $shInsertFireboardName;
    if (isset($shFbInsertCategoryName))
    $this->shFbInsertCategoryName = $shFbInsertCategoryName;
    if (isset($shFbInsertCategoryId))
    $this->shFbInsertCategoryId = $shFbInsertCategoryId;
    if (isset($shFbInsertMessageSubject))
    $this->shFbInsertMessageSubject = $shFbInsertMessageSubject;
    if (isset($shFbInsertMessageId))
    $this->shFbInsertMessageId = $shFbInsertMessageId;
     
    if (isset($shDoNotOverrideOwnSef)) // V 1.2.4.m
    $this->shDoNotOverrideOwnSef = $shDoNotOverrideOwnSef;
     
    if (isset($shEncodeUrl)) // V 1.2.4.m
    $this->shEncodeUrl = $shEncodeUrl;

    if (isset($guessItemidOnHomepage)) // V 1.2.4.q
    $this->guessItemidOnHomepage = $guessItemidOnHomepage;

    if (isset($shForceNonSefIfHttps)) // V 1.2.4.q
    $this->shForceNonSefIfHttps= $shForceNonSefIfHttps;
     
    if (isset($shRewriteMode))  // V 1.2.4.s
    $this->shRewriteMode = $shRewriteMode;
    if (isset($shRewriteStrings)) // V 1.2.4.s
    $this->shRewriteStrings = $shRewriteStrings;

    if (isset($shMetaManagementActivated))  // V 1.2.4.s
    $this->shMetaManagementActivated = $shMetaManagementActivated;
    if (isset($shRemoveGeneratorTag)) // V 1.2.4.s
    $this->shRemoveGeneratorTag = $shRemoveGeneratorTag;
    if (isset($shPutH1Tags))  // V 1.2.4.s
    $this->shPutH1Tags = $shPutH1Tags;
    if (isset($shInsertContentTableName)) // V 1.2.4.s
    $this->shInsertContentTableName = $shInsertContentTableName;
    if (isset($shContentTableName)) // V 1.2.4.s
    $this->shContentTableName = $shContentTableName;
    if (isset($shAutoRedirectWww))  // V 1.2.4.s
    $this->shAutoRedirectWww = $shAutoRedirectWww;
    if (isset($shVmInsertProductName))  // V 1.2.4.s
    $this->shVmInsertProductName = $shVmInsertProductName;

    if (isset($shDMInsertCategories)) // V 1.2.4.t
    $this->shDMInsertCategories = $shDMInsertCategories;
    if (isset($shDMInsertCategoryId)) // V 1.2.4.t
    $this->shDMInsertCategoryId = $shDMInsertCategoryId;

    if (isset($shForcedHomePage)) // V 1.2.4.t
    $this->shForcedHomePage = $shForcedHomePage;
    if (isset($shInsertContentBlogName))  // V 1.2.4.t
    $this->shInsertContentBlogName = $shInsertContentBlogName;
    if (isset($shContentBlogName))  // V 1.2.4.t
    $this->shContentBlogName = $shContentBlogName;

    if (isset($shInsertMTreeName))  // V 1.2.4.t
    $this->shInsertMTreeName = $shInsertMTreeName;
    if (isset($shMTreeInsertListingName)) // V 1.2.4.t
    $this->shMTreeInsertListingName = $shMTreeInsertListingName;
    if (isset($shMTreeInsertListingId)) // V 1.2.4.t
    $this->shMTreeInsertListingId = $shMTreeInsertListingId;
    if (isset($shMTreePrependListingId))  // V 1.2.4.t
    $this->shMTreePrependListingId = $shMTreePrependListingId;
    if (isset($shMTreeInsertCategories))  // V 1.2.4.t
    $this->shMTreeInsertCategories = $shMTreeInsertCategories;
    if (isset($shMTreeInsertCategoryId))  // V 1.2.4.t
    $this->shMTreeInsertCategoryId = $shMTreeInsertCategoryId;
    if (isset($shMTreeInsertUserName))  // V 1.2.4.t
    $this->shMTreeInsertUserName = $shMTreeInsertUserName;
    if (isset($shMTreeInsertUserId))  // V 1.2.4.t
    $this->shMTreeInsertUserId = $shMTreeInsertUserId;

    if (isset($shInsertNewsPName))  // V 1.2.4.t
    $this->shInsertNewsPName = $shInsertNewsPName;
    if (isset($shNewsPInsertCatId)) // V 1.2.4.t
    $this->shNewsPInsertCatId = $shNewsPInsertCatId;
    if (isset($shNewsPInsertSecId)) // V 1.2.4.t
    $this->shNewsPInsertSecId = $shNewsPInsertSecId;
     
    if (isset($shInsertRemoName))  // V 1.2.4.t
    $this->shInsertRemoName = $shInsertRemoName;
    if (isset($shRemoInsertDocId))    // V 1.2.4.t
    $this->shRemoInsertDocId = $shRemoInsertDocId;
    if (isset($shRemoInsertDocName))    // V 1.2.4.t
    $this->shRemoInsertDocName = $shRemoInsertDocName;
    if (isset($shRemoInsertCategories)) // V 1.2.4.t
    $this->shRemoInsertCategories = $shRemoInsertCategories;
    if (isset($shRemoInsertCategoryId)) // V 1.2.4.t
    $this->shRemoInsertCategoryId = $shRemoInsertCategoryId;

    if (isset($shCBShortUserURL)) // V 1.2.4.t
    $this->shCBShortUserURL = $shCBShortUserURL;
     
    if (isset($shKeepStandardURLOnUpgrade)) // V 1.2.4.t
    $this->shKeepStandardURLOnUpgrade = $shKeepStandardURLOnUpgrade;
    if (isset($shKeepCustomURLOnUpgrade)) // V 1.2.4.t
    $this->shKeepCustomURLOnUpgrade = $shKeepCustomURLOnUpgrade;
    if (isset($shKeepMetaDataOnUpgrade))  // V 1.2.4.t
    $this->shKeepMetaDataOnUpgrade = $shKeepMetaDataOnUpgrade;
    if (isset($shKeepModulesSettingsOnUpgrade)) // V 1.2.4.t
    $this->shKeepModulesSettingsOnUpgrade = $shKeepModulesSettingsOnUpgrade;

    if (isset($shMultipagesTitle))  // V 1.2.4.t
    $this->shMultipagesTitle = $shMultipagesTitle;

    // shumisha end of new parameters
    if (isset($Enabled))    $this->Enabled    = $Enabled;
    if (isset($replacement))  $this->replacement  = $replacement;
    if (isset($pagerep))    $this->pagerep    = $pagerep;
    if (isset($stripthese))   $this->stripthese   = $stripthese;
    if (isset($friendlytrim))   $this->friendlytrim = $friendlytrim;
    if (isset($suffix))     $this->suffix   = $suffix;
    if (isset($addFile))    $this->addFile    = $addFile;
    if (isset($LowerCase))    $this->LowerCase  = $LowerCase;
    if (isset($HideCat))    $this->HideCat    = $HideCat;
    if (isset($replacement))  $this->UseAlias   = $UseAlias;
    if (isset($UseAlias))   $this->page404    = $page404;
    if (isset($predefined))   $this->predefined = $predefined;
    if (isset($skip))     $this->skip     = $skip;
    if (isset($nocache))    $this->nocache    = $nocache;

    // V x
    if (isset($shKeepConfigOnUpgrade))  // V 1.2.4.x
    $this->shKeepConfigOnUpgrade = $shKeepConfigOnUpgrade;
    if (isset($shSecEnableSecurity))  // V 1.2.4.x
    $this->shSecEnableSecurity = $shSecEnableSecurity;
    if (isset($shSecLogAttacks))  // V 1.2.4.x
    $this->shSecLogAttacks = $shSecLogAttacks;
    if (isset($shSecOnlyNumVars)) // V 1.2.4.x
    $this->shSecOnlyNumVars = $shSecOnlyNumVars;
    if (isset($shSecAlphaNumVars))  // V 1.2.4.x
    $this->shSecAlphaNumVars = $shSecAlphaNumVars;
    if (isset($shSecNoProtocolVars))  // V 1.2.4.x
    $this->shSecNoProtocolVars = $shSecNoProtocolVars;
    $this->ipWhiteList = shReadFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_IP_white_list.dat');
    $this->ipBlackList = shReadFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_IP_black_list.dat');
    $this->uAgentWhiteList = shReadFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_uAgent_white_list.dat');
    $this->uAgentBlackList = shReadFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_uAgent_black_list.dat');
     

    if (isset($shSecCheckHoneyPot)) // V 1.2.4.x
    $this->shSecCheckHoneyPot = $shSecCheckHoneyPot;
    if (isset($shSecDebugHoneyPot)) // V 1.2.4.x
    $this->shSecDebugHoneyPot = $shSecDebugHoneyPot;
    if (isset($shSecHoneyPotKey)) // V 1.2.4.x
    $this->shSecHoneyPotKey = $shSecHoneyPotKey;
    if (isset($shSecEntranceText))  // V 1.2.4.x
    $this->shSecEntranceText = $shSecEntranceText;
    if (isset($shSecSmellyPotText)) // V 1.2.4.x
    $this->shSecSmellyPotText = $shSecSmellyPotText;
    if (isset($monthsToKeepLogs)) // V 1.2.4.x
    $this->monthsToKeepLogs = $monthsToKeepLogs;
    if (isset($shSecActivateAntiFlood)) // V 1.2.4.x
    $this->shSecActivateAntiFlood = $shSecActivateAntiFlood;
    if (isset($shSecAntiFloodOnlyOnPOST)) // V 1.2.4.x
    $this->shSecAntiFloodOnlyOnPOST = $shSecAntiFloodOnlyOnPOST;
    if (isset($shSecAntiFloodPeriod)) // V 1.2.4.x
    $this->shSecAntiFloodPeriod = $shSecAntiFloodPeriod;
    if (isset($shSecAntiFloodCount))  // V 1.2.4.x
    $this->shSecAntiFloodCount = $shSecAntiFloodCount;
    //  if (isset($insertSectionInBlogTableLinks))  // V 1.2.4.x
    //    $this->insertSectionInBlogTableLinks = $insertSectionInBlogTableLinks;

    $this->shLangTranslateList = $this->shInitLanguageList( isset($shLangTranslateList)? $shLangTranslateList : null, 0, 0);
    $this->shLangInsertCodeList = $this->shInitLanguageList( isset($shLangInsertCodeList) ? $shLangInsertCodeList : null, 0, 0);

    if (isset($defaultComponentStringList)) // V 1.2.4.x
    $this->defaultComponentStringList = $defaultComponentStringList;

    $this->pageTexts = $this->shInitLanguageList( isset($pageTexts) ? $pageTexts : null, // V x
    isset($pagetext) ? $pagetext : 'Page-%s', isset($pagetext) ? $pagetext : 'Page-%s'); // use value from prev versions if any
     
    if (isset($shAdminInterfaceType)) // V 1.2.4.x
    $this->shAdminInterfaceType = $shAdminInterfaceType;

    // compatibility with version earlier than V x
    if (isset($shShopName)) // V 1.2.4.x
    $this->defaultComponentStringList['virtuemart'] = $shShopName;
    if (isset($shIJoomlaMagName))// V 1.2.4.x
    $this->defaultComponentStringList['magazine'] = $shIJoomlaMagName;
    if (isset($shCBName))// V 1.2.4.x
    $this->defaultComponentStringList['comprofiler'] = $shCBName;
    if (isset($shFireboardName))// V 1.2.4.x
    $this->defaultComponentStringList['fireboard'] = $shFireboardName;
    if (isset($shMyBlogName))// V 1.2.4.x
    $this->defaultComponentStringList['myblog'] = $shMyBlogName;
    if (isset($shDocmanName))// V 1.2.4.x
    $this->defaultComponentStringList['docman'] = $shDocmanName;
    if (isset($shMTreeName))// V 1.2.4.x
    $this->defaultComponentStringList['mtree'] = $shMTreeName;
    if (isset($shNewsPName))// V 1.2.4.x
    $this->defaultComponentStringList['news_portal'] = $shNewsPName;
    if (isset($shRemoName))// V 1.2.4.x
    $this->defaultComponentStringList['remository'] = $shRemoName;
    // end of compatibility code

    // V 1.3 RC
    if (isset($shInsertNoFollowPDFPrint))
    $this->shInsertNoFollowPDFPrint = $shInsertNoFollowPDFPrint;
    if (isset($shInsertReadMorePageTitle))
    $this->shInsertReadMorePageTitle = $shInsertReadMorePageTitle;
    if (isset($shMultipleH1ToH2))
    $this->shMultipleH1ToH2 = $shMultipleH1ToH2;

    // V 1.3.1 RC
    if (isset($shVmUsingItemsPerPage))
    $this->shVmUsingItemsPerPage = $shVmUsingItemsPerPage;
    if (isset($shSecCheckPOSTData))
    $this->shSecCheckPOSTData = $shSecCheckPOSTData;
    if (isset($shSecCurMonth))
    $this->shSecCurMonth = $shSecCurMonth;
    if (isset($shSecLastUpdated))
    $this->shSecLastUpdated = $shSecLastUpdated;
    if (isset($shSecTotalAttacks))
    $this->shSecTotalAttacks = $shSecTotalAttacks;
    if (isset($shSecTotalConfigVars))
    $this->shSecTotalConfigVars = $shSecTotalConfigVars;
    if (isset($shSecTotalBase64))
    $this->shSecTotalBase64 = $shSecTotalBase64;
    if (isset($shSecTotalScripts))
    $this->shSecTotalScripts = $shSecTotalScripts;
    if (isset($shSecTotalStandardVars))
    $this->shSecTotalStandardVars = $shSecTotalStandardVars;
    if (isset($shSecTotalImgTxtCmd))
    $this->shSecTotalImgTxtCmd = $shSecTotalImgTxtCmd;
    if (isset($shSecTotalIPDenied))
    $this->shSecTotalIPDenied = $shSecTotalIPDenied;
    if (isset($shSecTotalUserAgentDenied))
    $this->shSecTotalUserAgentDenied = $shSecTotalUserAgentDenied;
    if (isset($shSecTotalFlooding))
    $this->shSecTotalFlooding = $shSecTotalFlooding;
    if (isset($shSecTotalPHP))
    $this->shSecTotalPHP = $shSecTotalPHP;
    if (isset($shSecTotalPHPUserClicked))
    $this->shSecTotalPHPUserClicked = $shSecTotalPHPUserClicked;

    if (isset($prependToPageTitle))
    $this->prependToPageTitle = $prependToPageTitle;
    if (isset($appendToPageTitle))
    $this->appendToPageTitle = $appendToPageTitle;

    if (isset($debugToLogFile))
    $this->debugToLogFile = $debugToLogFile;
    if (isset($debugStartedAt))
    $this->debugStartedAt = $debugStartedAt;
    if (isset($debugDuration))
    $this->debugDuration = $debugDuration;

    // V 1.3.1
    if (isset($shInsertOutboundLinksImage))
    $this->shInsertOutboundLinksImage = $shInsertOutboundLinksImage;
    if (isset($shImageForOutboundLinks))
    $this->shImageForOutboundLinks = $shImageForOutboundLinks;

    // V 1.0.12
    if (isset($useCatAlias))
    $this->useCatAlias = $useCatAlias;
    if (isset($useMenuAlias))
    $this->useMenuAlias = $useMenuAlias;

    // V 1.5.3
    if (isset($alwaysAppendItemsPerPage))
    $this->alwaysAppendItemsPerPage = $alwaysAppendItemsPerPage;
    if (isset($redirectToCorrectCaseUrl))
    $this->redirectToCorrectCaseUrl = $redirectToCorrectCaseUrl;


    // V 1.5.5
    if (isset($jclInsertEventId))
    $this->jclInsertEventId = $jclInsertEventId;
    if (isset($jclInsertCategoryId))
    $this->jclInsertCategoryId = $jclInsertCategoryId;
    if (isset($jclInsertCalendarId))
    $this->jclInsertCalendarId = $jclInsertCalendarId;
    if (isset($jclInsertCalendarName))
    $this->jclInsertCalendarName = $jclInsertCalendarName;
    if (isset($jclInsertDate))
    $this->jclInsertDate = $jclInsertDate;
    if (isset($jclInsertDateInEventView))
    $this->jclInsertDateInEventView = $jclInsertDateInEventView;


    if (isset($ContentTitleShowCat))
    $this->ContentTitleShowCat = $ContentTitleShowCat;
    if (isset($ContentTitleUseAlias))
    $this->ContentTitleUseAlias = $ContentTitleUseAlias;
    if (isset($ContentTitleUseCatAlias))
    $this->ContentTitleUseCatAlias = $ContentTitleUseCatAlias;
    if (isset($pageTitleSeparator))
    $this->pageTitleSeparator = $pageTitleSeparator;

    if (isset($ContentTitleInsertArticleId))
    $this->ContentTitleInsertArticleId = $ContentTitleInsertArticleId;
    if (isset($shInsertContentArticleIdCatList))
    $this->shInsertContentArticleIdCatList = $shInsertContentArticleIdCatList;

    // 1.5.8
    if (isset($shJSInsertJSName))
    $this->shJSInsertJSName = $shJSInsertJSName;
    if (isset($shJSShortURLToUserProfile))
    $this->shJSShortURLToUserProfile = $shJSShortURLToUserProfile;
    if (isset($shJSInsertUsername))
    $this->shJSInsertUsername = $shJSInsertUsername;
    if (isset($shJSInsertUserFullName))
    $this->shJSInsertUserFullName = $shJSInsertUserFullName;
    if (isset($shJSInsertUserId))
    $this->shJSInsertUserId = $shJSInsertUserId;
    if (isset($shJSInsertUserFullName))
    $this->shJSInsertUserFullName = $shJSInsertUserFullName;
    if (isset($shJSInsertGroupCategory))
    $this->shJSInsertGroupCategory = $shJSInsertGroupCategory;
    if (isset($shJSInsertGroupCategoryId))
    $this->shJSInsertGroupCategoryId = $shJSInsertGroupCategoryId;
    if (isset($shJSInsertGroupId))
    $this->shJSInsertGroupId = $shJSInsertGroupId;
    if (isset($shJSInsertGroupBulletinId))
    $this->shJSInsertGroupBulletinId = $shJSInsertGroupBulletinId;
    if (isset($shJSInsertDiscussionId))
    $this->shJSInsertDiscussionId = $shJSInsertDiscussionId;
    if (isset($shJSInsertMessageId))
    $this->shJSInsertMessageId = $shJSInsertMessageId;
    if (isset($shJSInsertPhotoAlbum))
    $this->shJSInsertPhotoAlbum = $shJSInsertPhotoAlbum;
    if (isset($shJSInsertPhotoAlbumId))
    $this->shJSInsertPhotoAlbumId = $shJSInsertPhotoAlbumId;
    if (isset($shJSInsertPhotoId))
    $this->shJSInsertPhotoId = $shJSInsertPhotoId;
    if (isset($shJSInsertVideoCat))
    $this->shJSInsertVideoCat = $shJSInsertVideoCat;
    if (isset($shJSInsertVideoCatId))
    $this->shJSInsertVideoCatId = $shJSInsertVideoCatId;
    if (isset($shJSInsertVideoId))
    $this->shJSInsertVideoId = $shJSInsertVideoId;
     
    if (isset($shFbInsertUserName))
    $this->shFbInsertUserName = $shFbInsertUserName;
    if (isset($shFbInsertUserId))
    $this->shFbInsertUserId = $shFbInsertUserId;
    if (isset($shFbShortUrlToProfile))
    $this->shFbShortUrlToProfile = $shFbShortUrlToProfile;

    if (isset($shPageNotFoundItemid))
    $this->shPageNotFoundItemid = $shPageNotFoundItemid;

    if (isset($autoCheckNewVersion))
    $this->autoCheckNewVersion = $autoCheckNewVersion;

    if (isset($error404SubTemplate))
    $this->error404SubTemplate = $error404SubTemplate;

    if (isset($enablePageId))
    $this->enablePageId = $enablePageId;
    if (isset($compEnablePageId))
    $this->compEnablePageId = $compEnablePageId;
    // V 2.1.0
    if (isset($analyticsEnabled))
    $this->analyticsEnabled = $analyticsEnabled;
    if (isset($analyticsReportsEnabled))
    $this->analyticsReportsEnabled = $analyticsReportsEnabled;
    if (isset($analyticsType))
    $this->analyticsType = $analyticsType;
    if (isset($analyticsId))
    $this->analyticsId = $analyticsId;
    if (isset($analyticsUser))
    $this->analyticsUser = $analyticsUser;
    if (isset($analyticsPassword))
    $this->analyticsPassword = $analyticsPassword;
    if (isset($analyticsAccount))
    $this->analyticsAccount = $analyticsAccount;
    if (isset($analyticsExcludeIP))
    $this->analyticsExcludeIP = $analyticsExcludeIP;
    if (isset($analyticsMaxUserLevel))
    $this->analyticsMaxUserLevel = $analyticsMaxUserLevel;
    if (isset($analyticsProfile))
    $this->analyticsProfile = $analyticsProfile;
    if (isset($autoCheckNewAnalytics))
    $this->autoCheckNewAnalytics = $autoCheckNewAnalytics;
    if (isset($analyticsDashboardDateRange))
    $this->analyticsDashboardDateRange = $analyticsDashboardDateRange;
    if (isset($analyticsEnableTimeCollection))
    $this->analyticsEnableTimeCollection = $analyticsEnableTimeCollection;
    if (isset($analyticsEnableUserCollection))
    $this->analyticsEnableUserCollection = $analyticsEnableUserCollection;

    if (isset($analyticsDashboardDataType))
    $this->analyticsDashboardDataType = $analyticsDashboardDataType;

    if (isset($slowServer))
    $this->slowServer = $slowServer;

    // V 2.1.10
    if (isset($useJoomsefRouter))
    $this->useJoomsefRouter = $useJoomsefRouter;
    if (isset($useAcesefRouter))
    $this->useAcesefRouter = $useAcesefRouter;

    // V 2.1.11
    if (isset($insertShortlinkTag))
    $this->insertShortlinkTag = $insertShortlinkTag;
    if (isset($insertRevCanTag))
    $this->insertRevCanTag = $insertRevCanTag;
    if (isset($insertAltShorterTag))
    $this->insertAltShorterTag = $insertAltShorterTag;
    if (isset($canReadRemoteConfig))
    $this->canReadRemoteConfig = $canReadRemoteConfig;
    if (isset($stopCreatingShurls))
    $this->stopCreatingShurls = $stopCreatingShurls;
    if (isset($shurlBlackList))
    $this->shurlBlackList = $shurlBlackList;
    if (isset($shurlNonSefBlackList))
    $this->shurlNonSefBlackList = $shurlNonSefBlackList;

    // V 3.0.0
    if (isset($includeContentCat))
    $this->includeContentCat = $includeContentCat;
    if (isset($includeContentCatCategories))
    $this->includeContentCatCategories = $includeContentCatCategories;
    if (isset($contentCategoriesSuffix))
    $this->contentCategoriesSuffix = $contentCategoriesSuffix;
    if (isset($contentTitleIncludeCat))
    $this->contentTitleIncludeCat = $contentTitleIncludeCat;

    if (isset($useContactCatAlias))
    $this->useContactCatAlias = $useContactCatAlias;
    if (isset($contactCategoriesSuffix))
    $this->contactCategoriesSuffix = $contactCategoriesSuffix;
    if (isset($includeContactCat))
    $this->includeContactCat = $includeContactCat;
    if (isset($includeContactCatCategories))
    $this->includeContactCatCategories = $includeContactCatCategories;

    if (isset($useWeblinksCatAlias))
    $this->useWeblinksCatAlias = $useWeblinksCatAlias;
    if (isset($weblinksCategoriesSuffix))
    $this->weblinksCategoriesSuffix = $weblinksCategoriesSuffix;
    if (isset($includeWeblinksCat))
    $this->includeWeblinksCat = $includeWeblinksCat;
    if (isset($includeWeblinksCatCategories))
    $this->includeWeblinksCatCategories = $includeWeblinksCatCategories;

    $this->liveSites = $this->shInitLanguageList( isset($liveSites) ? $liveSites : array(), '', '');

    if (isset($alternateTemplate))
    $this->alternateTemplate = $alternateTemplate;

    if (isset($useJoomlaRouter))
    $this->useJoomlaRouter = $useJoomlaRouter;
    
    if (isset($slugForUncategorizedContent))
    $this->slugForUncategorizedContent = $slugForUncategorizedContent;
    if (isset($slugForUncategorizedContact))
    $this->slugForUncategorizedContact = $slugForUncategorizedContact;
    if (isset($slugForUncategorizedWeblinks))
    $this->slugForUncategorizedWeblinks = $slugForUncategorizedWeblinks;
    
    // define default values for seldom used params

    if (!defined('sh404SEF_PROTECT_AGAINST_DOCUMENT_TYPE_ERROR')) {
      // SECTION : GLOBAL PARAMETERS for sh404sef ---------------------------------------------------------------------

      $shDefaultParamsHelp['sh404SEF_PROTECT_AGAINST_DOCUMENT_TYPE_ERROR'] =
'// if not 0, urls for pdf documents and rss feeds  will be only partially turned into sef urls. 
//The query string &format=pdf or &format=feed will be still be appended.
// This will protect against malfunctions when using some plugins which makes a call
// to JFactory::getDocument() from a onAfterInitiliaze handler
// At this time, SEF urls are not decoded and thus the document type is set to html instead of pdf or feed
// resulting in the home page being displayed instead of the correct document';
      $shDefaultParams['sh404SEF_PROTECT_AGAINST_DOCUMENT_TYPE_ERROR'] = 0;

      /*
       $shDefaultParamsHelp['sh404SEF_PROTECT_AGAINST_BAD_NON_DEFAULT_LANGUAGE_MENU_HOMELINK'] =
       '// Joomla mod_mainmenu module forces usage of JURI::base() for the homepage link
       // On multilingual sites, this causes homepage link in other than default language to
       // be wrong. If the following parameter is non-zero, such a homepage link
       // will be replaced by the correct link, similar to www.mysite.com/es/ for instance';
       $shDefaultParams['sh404SEF_PROTECT_AGAINST_BAD_NON_DEFAULT_LANGUAGE_MENU_HOMELINK'] = 1;

       */

      $shDefaultParamsHelp['sh404SEF_REDIRECT_IF_INDEX_PHP'] =
'// if not 0, sh404SEF will do a 301 redirect from http://yoursite.com/index.php
// or http://yoursite.com/index.php?lang=xx to http://yoursite.com/
// this may not work on some web servers, which transform yoursite.com into
// yoursite.com/index.php, thus creating and endless loop. If your server does
// that, set this param to 0';
      $shDefaultParams['sh404SEF_REDIRECT_IF_INDEX_PHP'] = 1;

      $shDefaultParamsHelp['sh404SEF_NON_SEF_IF_SUPERADMIN'] =
'// if superadmin logged in, force non-sef, for testing and setting up purpose';
      $shDefaultParams['sh404SEF_NON_SEF_IF_SUPERADMIN'] = 0;

      $shDefaultParamsHelp['sh404SEF_DE_ACTIVATE_LANG_AUTO_REDIRECT'] =
'// set to 1 to prevent 303 auto redirect based on user language
// use with care, will prevent language switch to work for users without javascript';
      $shDefaultParams['sh404SEF_DE_ACTIVATE_LANG_AUTO_REDIRECT'] = 1;

      $shDefaultParamsHelp['sh404SEF_CHECK_COMP_IS_INSTALLED'] =
'// if 1, SEF URLs will only be built for installed components.';
      $shDefaultParams['sh404SEF_CHECK_COMP_IS_INSTALLED'] = 1;

      $shDefaultParamsHelp['sh404SEF_REDIRECT_OUTBOUND_LINKS'] =
'// if 1, all outbound links on page will be reached through a redirect
// to avoid page rank leakage';
      $shDefaultParams['sh404SEF_REDIRECT_OUTBOUND_LINKS'] = 0;

      $shDefaultParamsHelp['sh404SEF_PDF_DIR'] =
'// if not empty, urls to pdf produced by Joomla will be prefixed with this
// path. Can be : \'pdf\' or \'pdf/something\' (ie: don\'t put leading or trailing slashes)
// Allows you to store some pre-built PDF in a directory called /pdf, with the same name
// as a page. Such a pdf will be served directly by the web server instead of being built on
// the fly by Joomla. This will save CPU and RAM. (only works this way if using htaccess';
      $shDefaultParams['sh404SEF_PDF_DIR'] = 'pdf';

      $shDefaultParamsHelp['SH404SEF_URL_CACHE_TTL'] =
'// time to live for url cache in hours : default = 168h = 1 week
// Set to 0 to keep cache forever';
      $shDefaultParams['SH404SEF_URL_CACHE_TTL'] = 168;

      $shDefaultParamsHelp['SH404SEF_URL_CACHE_WRITES_TO_CHECK_TTL'] =
'// number of cache write before checking cache TTL.';
      $shDefaultParams['SH404SEF_URL_CACHE_WRITES_TO_CHECK_TTL'] = 1000;

      $shDefaultParamsHelp['sh404SEF_SEC_MAIL_ATTACKS_TO_ADMIN'] =
'// if set to 1, an email will be send to site admin when an attack is logged
// if the site is live, you could be drowning in email rapidly !!!';
      $shDefaultParams['sh404SEF_SEC_MAIL_ATTACKS_TO_ADMIN'] = 0;

      $shDefaultParams['sh404SEF_SEC_EMAIL_TO_ADMIN_SUBJECT'] = 'Your site %sh404SEF_404_SITE_NAME% was subject to an attack';
      $shDefaultParams['sh404SEF_SEC_EMAIL_TO_ADMIN_BODY'] =
'Hello !'."\n\n".'This is sh404SEF security component, running at your site (%sh404SEF_404_SITE_URL%).'
      ."\n\n".'I have just blocked an attack on your site. Please check details below : '
      ."\n".  '------------------------------------------------------------------------'
      ."\n".  '%sh404SEF_404_ATTACK_DETAILS%'
      ."\n".  '------------------------------------------------------------------------'
      ."\n\n".'Thanks for using sh404SEF!'
      ."\n\n"
      ;

      $shDefaultParamsHelp['SH404SEF_PAGES_TO_CLEAN_LOGS'] =
'// number of pages between checks to remove old log files
// if 1, we check at every page request';
      $shDefaultParams['SH404SEF_PAGES_TO_CLEAN_LOGS'] = 10000;

      $shDefaultParamsHelp['SH_VM_ALLOW_PRODUCTS_IN_MULTIPLE_CATS'] =
'// SECTION : Virtuemart plugin parameters ----------------------------------------------------------------------------

// set to 1 for products to have requested category name included in url
// useful if some products are in more than one category. If param set to 0,
// only one category will be used for all pages. Not recommended now that sh404SEF
// automatically handle rel=canonical on such pages';

      $shDefaultParams['SH_VM_ALLOW_PRODUCTS_IN_MULTIPLE_CATS'] = 1;

      $shDefaultParamsHelp['sh404SEF_SOBI2_PARAMS_ALWAYS_INCLUDE_CATS'] =
'// SECTION : SOBI2 plugin parameters ----------------------------------------------------------------------------

// set to 1 to always include categories in SOBI2 entries
// details pages url';
      $shDefaultParams['sh404SEF_SOBI2_PARAMS_ALWAYS_INCLUDE_CATS'] = 0;

      $shDefaultParamsHelp['sh404SEF_SOBI2_PARAMS_INCLUDE_ENTRY_ID'] =
'// set to 1 so that entry id is prepended to url';
      $shDefaultParams['sh404SEF_SOBI2_PARAMS_INCLUDE_ENTRY_ID'] = 0;

      $shDefaultParamsHelp['sh404SEF_SOBI2_PARAMS_INCLUDE_CAT_ID'] =
'// set to 1 so that category id is prepended to category name';
      $shDefaultParams['sh404SEF_SOBI2_PARAMS_INCLUDE_CAT_ID'] = 0;

      // end of parameters

      $sef_custom_config_file = sh404SEF_ADMIN_ABS_PATH.'custom.sef.php';
      // read user defined values, possibly recovered while upgrading
      if (JFile::exists($sef_custom_config_file)) {
        include($sef_custom_config_file);
      }

      // generate string for parameter modification
      if ($app->isAdmin()) {  // only need to modify custom params in back-end
        $this->defaultParamList = '<?php
// custom.sef.php : custom.configuration file for sh404SEF
// 3.1.5.1098 - anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html

// DO NOT REMOVE THIS LINE :
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');
// DO NOT REMOVE THIS LINE'."\n";

        foreach ($shDefaultParams as $key=>$value) {
          $this->defaultParamList .= "\n";
          if (!empty ($shDefaultParamsHelp[$key]))
          $this->defaultParamList .= $shDefaultParamsHelp[$key]."\n";  // echo help text, if any
          $this->defaultParamList .= '$shDefaultParams[\''.$key.'\'] = '
          . (is_string($value) ? "'$value'" : $value)
          .";\n";
        }
      }

      // read user set values for these params and create constants
      if (!empty($shDefaultParams)) {
        foreach( $shDefaultParams as $key=>$value) {
          define($key, $value);
        }
      }
      unset($shDefaultParams);
      unset($shDefaultParamsHelp);

    }

    // compatiblity variables, for sef_ext files usage from OpenSef/SEf Advance V 1.2.4.p
    $this->encode_page_suffix = '';// if using an opensef sef_ext, we don't let  them manage suffix
    $this->encode_space_char = $this->replacement;
    $this->encode_lowercase = $this->LowerCase;
    $this->encode_strip_chars = $this->stripthese;
    $this->content_page_name = str_replace('%s', '', $this->pageTexts[Sh404sefFactory::getPageInfo()->shMosConfig_locale]); // V 1.2.4.r
    $this->content_page_format = '%s'.$this->replacement.'%d'; // V 1.2.4.r
    $shTemp = $this->shGetReplacements();
    foreach ($shTemp as $dest=>$source) {
      $this->spec_chars_d .= $dest.',';
      $this->spec_chars .= $source.',';
    }
    JString::rtrim($this->spec_chars_d, ',');
    JString::rtrim($this->spec_chars, ',');
     
  }  // end of SefConfig

  // V x
  function shCheckFileAccess($fileName) {

    $ret = is_readable( sh404SEF_ABS_PATH.$fileName) && is_writable( sh404SEF_ABS_PATH.$fileName) ?
    JText::_('COM_SH404SEF_WRITEABLE') : JText::_('COM_SH404SEF_UNWRITEABLE');
    return $ret;
  }

  function shCheckFilesAccess() {

    shIncludeLanguageFile();  // sometimes language file may not be included yet, need it in shCheckFileAccess
    $status = array();
    $status['administrator/components/com_sh404sef/config'] = $this->shCheckFileAccess('administrator/components/com_sh404sef/config');
    $status['administrator/components/com_sh404sef/config/config.sef.php'] = $this->shCheckFileAccess('administrator/components/com_sh404sef/config/config.sef.php');
    $status['administrator/components/com_sh404sef'] = $this->shCheckFileAccess('administrator/components/com_sh404sef');
    $status['administrator/components/com_sh404sef/custom.sef.php'] = $this->shCheckFileAccess('administrator/components/com_sh404sef/index.html');
    $status['administrator/components/com_sh404sef/logs'] = $this->shCheckFileAccess('administrator/components/com_sh404sef/logs/index.html');
    $status['administrator/components/com_sh404sef/security'] = $this->shCheckFileAccess('administrator/components/com_sh404sef/security/index.html');
    $status['components/com_sh404sef/cache'] = $this->shCheckFileAccess('components/com_sh404sef/cache/index.html');
    $this->fileAccessStatus = $status;
  }

  function shInitLanguageList($currentList, $default, $defaultLangDefault) {

    $ret = array();
    $shKind = shIsMultilingual();
    $app = JFactory::getApplication();
    if (!$shKind && !$app->isAdmin()) {
      if (empty($currentList) || !isset($currentList[sh404sefFactory::getPageInfo()->shMosConfig_locale])) {
        $ret[sh404sefFactory::getPageInfo()->shMosConfig_locale] = $defaultLangDefault;
      } else {
        $ret[sh404sefFactory::getPageInfo()->shMosConfig_locale] = $currentList[sh404sefFactory::getPageInfo()->shMosConfig_locale];
      }
    } else {
      $activeLanguages = shGetActiveLanguages();
      if (empty($activeLanguages)) {
        if (empty($currentList) || !isset($currentList[sh404sefFactory::getPageInfo()->shMosConfig_locale])) {
          $ret[sh404sefFactory::getPageInfo()->shMosConfig_locale] = $defaultLangDefault;
        } else {
          $ret[sh404sefFactory::getPageInfo()->shMosConfig_locale] = $currentList[sh404sefFactory::getPageInfo()->shMosConfig_locale];
        }
      } else {
        foreach ($activeLanguages as $language) {
          if (empty($currentList) || !isset($currentList[$language->code])) {
            $ret[$language->code] = $language->code == sh404sefFactory::getPageInfo()->shMosConfig_locale ? $defaultLangDefault : $default;
          } else {
            $ret[$language->code] = $currentList[$language->code];
          }
        }
      }
    }
    return $ret;
  }

  function saveConfig($return_data=0) {

    $sef_config_file = sh404SEF_ADMIN_ABS_PATH.'config/config.sef.php';

    $database =& JFactory::getDBO();
    $quoteGPC = get_magic_quotes_gpc();
    $user = JFactory::getUser();
    $userName = empty($user) ? '-' : $user->username;
    $userId = empty($user) ? '-' : $user->id;
    //build the data file
    $config_data = '<?php' . "\n"
    . '// config.sef.php : configuration file for sh404SEF for Joomla 1.5.x' . "\n"
    . '// ' . $this->version . "\n"
    . '// saved at: ' . date( 'Y-m-d H:i:s') . "\n"
    . '// by: ' . $userName . ' (id: ' . $userId . ' )' . "\n"
    . '// domain: ' . sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite() . "\n\n"
    . 'if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');' . "\n\n"
    ;

    foreach ($this as $key=>$value) {
      if ($key != "0" && $key != 'ipWhiteList' && $key != 'ipBlackList'
      && $key != 'uAgentWhiteList' && $key != 'uAgentBlackList'
      && $key != 'defaultParamList'
      ) {
        $config_data .= "\$$key = ";
        if ($key == 'shLangTranslateList' || $key == 'shLangInsertCodeList' || $key == 'defaultComponentStringList'
        || $key == 'pageTexts' || $key == 'liveSites') {
          $datastring ='';
          foreach($value as $key2=>$data) {
            $datastring .= '"'.$key2.'"=>'.'"'.str_replace('"', '\"', $quoteGPC ? stripslashes($data):$data).'",';
          }
          $datastring = JString::substr($datastring,0,-1);
          $config_data .= "array($datastring)";
        } else
        switch (gettype($value)) {
          case "boolean":
            $config_data .= ($value ? "true" : "false");
            break;
          case "string":
            $datastring = str_replace("'", "\'", $quoteGPC ? stripslashes($value):$value);
            $config_data .= "'". $datastring."'";
            break;
          case "integer":
          case "double":
            $config_data .= strval($value);
            break;
          case "array":
            $datastring ='';
            foreach($value as $key2=>$data) {
              $datastring .= '"'.str_replace('"', '\"', $quoteGPC ? stripslashes($data):$data).'",';
            }
            $datastring = JString::substr($datastring,0,-1);
            $config_data .= "array($datastring)";
            break;
          default:
            $config_data .= "null";
            break;
        }
        $config_data .= ";\n";
      }
    }
    $config_data .= '?'.'>';
    if ($return_data == 1) {
      return $config_data;
    }else{
      // write to disk
      $trans_tbl = get_html_translation_table(HTML_ENTITIES);
      $trans_tbl = array_flip($trans_tbl);
      $config_data =strtr($config_data, $trans_tbl);
      jimport( 'joomla.filesystem.file');
      $ret = JFile::write( $sef_config_file, $config_data);

      // save lists
      shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_IP_white_list.dat', $this->ipWhiteList);
      shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_IP_black_list.dat', $this->ipBlackList);
      shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_uAgent_white_list.dat', $this->uAgentWhiteList);
      shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_uAgent_black_list.dat', $this->uAgentBlackList);
      shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'custom.sef.php',
      $quoteGPC ? stripslashes($this->defaultParamList) : $this->defaultParamList);

      // V 1.2.4.q : save copy of config file to other location for automatic recovering of config when upgrading
      $fileName = sh404SEF_ABS_PATH.'media/sh404sef/sh404_upgrade_conf_'
      .str_replace('/','_',str_replace('http://', '', sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite())).'.php';
      JFile::write( $fileName, $config_data);
      // save lists to backup location
      if (!is_writable(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security')) {
        jimport( 'joomla.filesystem.folder');
        JFolder::create(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security');
      }
      shSaveFile(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security/sh404SEF_IP_white_list.dat',
      $this->ipWhiteList);
      shSaveFile(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security/sh404SEF_IP_black_list.dat',
      $this->ipBlackList);
      shSaveFile(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security/sh404SEF_uAgent_white_list.dat',
      $this->uAgentWhiteList);
      shSaveFile(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_security/sh404SEF_uAgent_black_list.dat',
      $this->uAgentBlackList);
      shSaveFile(sh404SEF_ABS_PATH . 'media/sh404sef/sh404_upgrade_conf_'
      .str_replace('/','_',str_replace('http://', '', sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite())).'.custom.php',
      $quoteGPC ? stripslashes($this->defaultParamList) : $this->defaultParamList);

      // v 3.0+ : as we are now using J! router, we need to update the global configuration object with the rewrite mode setting
      // as otherwise users would have to manually change it
      return $ret;
    }
  }

  /**
   * Return array of URL characters to be replaced.
   * Copied from Artio Joomsef V 1.4.0
   *
   * @return array
   */
   
  function shGetReplacements()

  {
    // V 1.2.4.q : initialize variable
    static $shReplacements = null;
    if (isset($shReplacements)) return $shReplacements;
    $shReplacements = array();
    $items = explode(',', $this->shReplacements);
    foreach ($items as $item) {
      if (!empty($item)) {  // V 1.2.4.q better protection. Returns null array if empty
        @list($src, $dst) = explode('|', JString::trim($item));
        $shReplacements[JString::trim($src)] = JString::trim($dst);
      }
    }

    return $shReplacements;
  }

  /**
   * Return array of URL characters to be replaced.
   * Copied from Artio Joomsef V 1.4.0
   *
   * @return array
   */
   
  function shGetStripCharList()

  {
    static $shStripCharList = null;
    if (is_null($shStripCharList)) {
      $shStripCharList = array();
      $shStripCharList = explode('|', $this->stripthese);
    }
    return $shStripCharList;
  }

  function set($var, $val) {

    if (isset($this->$var)) {
      $this->$var = $val;
      return true;
    }
    return false;
  }

  function version() {

    return $this->version;
  }
}
