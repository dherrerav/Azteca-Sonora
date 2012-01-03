<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.application.component.view');

class Sh404sefViewConfig extends JView {

  // we are in 'config' view
  protected $_context = 'config';

  public function display( $tpl = null) {

    // get current layout
    $params['layout'] = JRequest::getCmd( 'layout', 'default');

    // push the appropriate data into the view
    $methodName = '_pushConfigData' . ucfirst( $params['layout']);
    if (is_callable( array($this, $methodName))) {
      $this->$methodName();
    }

    // build the toolbar
    $toolBar = $this->_makeToolbar( $params);
    $this->assignRef( 'toolbar', $toolBar);

    // add title and icon to toolbar
    $this->assign( 'toolbarTitle', Sh404sefHelperGeneral::makeToolbarTitle( JText::_('COM_SH404SEF_CONFIGURATION'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title'));

    // insert needed css files
    $this->_addCss();

    // link to  custom javascript
    JHtml::script( 'config.js', Sh404sefHelperGeneral::getComponentUrl() .  '/assets/js/');

    // also add some custom javascript tp collect editor content
    if ($params['layout'] == 'errordocs') {
      $this->_addJs();
    }

    // add tooltips
    JHTML::_('behavior.tooltip');

    // now display normally
    parent::display($tpl);

  }

  /**
   * Push current general configuration items
   * values into the view for edition
   */
  private function _pushConfigDataDefault() {

    // get configuration object
    $shPageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';
    $lists['enabled'] =  JHTML::_('select.booleanlist', 'Enabled', $std_opt, $sefConfig->Enabled );
    $lists['lowercase'] =  JHTML::_('select.booleanlist','LowerCase', $std_opt, $sefConfig->LowerCase );
    // shumisha 2007-04-01 new params for cache :
    $lists['shUseURLCache'] =  JHTML::_('select.booleanlist','shUseURLCache', $std_opt, $sefConfig->shUseURLCache );
    // shumisha 2007-04-03 new params for translation and Itemid :
    $lists['shTranslateURL'] =  JHTML::_('select.booleanlist','shTranslateURL', $std_opt, $sefConfig->shTranslateURL );
    $lists['shInsertLanguageCode'] =  JHTML::_('select.booleanlist','shInsertLanguageCode', $std_opt,
    $sefConfig->shInsertLanguageCode );
    $lists['shInsertGlobalItemidIfNone'] =  JHTML::_('select.booleanlist','shInsertGlobalItemidIfNone',
    $std_opt, $sefConfig->shInsertGlobalItemidIfNone );
    $lists['shInsertTitleIfNoItemid'] =  JHTML::_('select.booleanlist','shInsertTitleIfNoItemid',
    $std_opt, $sefConfig->shInsertTitleIfNoItemid );
    $lists['shAlwaysInsertMenuTitle'] =  JHTML::_('select.booleanlist','shAlwaysInsertMenuTitle',
    $std_opt, $sefConfig->shAlwaysInsertMenuTitle );
    $lists['shAlwaysInsertItemid'] =  JHTML::_('select.booleanlist','shAlwaysInsertItemid',
    $std_opt, $sefConfig->shAlwaysInsertItemid );

    // V 1.2.4.q new param for URL encoding
    $lists['shEncodeUrl'] =  JHTML::_('select.booleanlist','shEncodeUrl',
    $std_opt, $sefConfig->shEncodeUrl );

    $lists['guessItemidOnHomepage'] =  JHTML::_('select.booleanlist','guessItemidOnHomepage',
    $std_opt, $sefConfig->guessItemidOnHomepage );

    $lists['shForceNonSefIfHttps'] =  JHTML::_('select.booleanlist','shForceNonSefIfHttps',  // V 1.2.4.q
    $std_opt, $sefConfig->shForceNonSefIfHttps );

    $shRewriteMode[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_RW_MODE_NORMAL') );
    $shRewriteMode[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_RW_MODE_INDEXPHP') );

    $lists['shRewriteMode'] = JHTML::_('select.genericlist', $shRewriteMode, 'shRewriteMode',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shRewriteMode); 

    $lists['shRemoveGeneratorTag'] =  JHTML::_('select.booleanlist','shRemoveGeneratorTag',  // V 1.2.4.r
    $std_opt, $sefConfig->shRemoveGeneratorTag );
    $lists['shPutH1Tags'] =  JHTML::_('select.booleanlist','shPutH1Tags',  // V 1.2.4.r
    $std_opt, $sefConfig->shPutH1Tags );
    $lists['shMetaManagementActivated'] =  JHTML::_('select.booleanlist','shMetaManagementActivated',  // V 1.2.4.r
    $std_opt, $sefConfig->shMetaManagementActivated );
    $lists['shInsertContentTableName'] =  JHTML::_('select.booleanlist','shInsertContentTableName',  // V 1.2.4.r
    $std_opt, $sefConfig->shInsertContentTableName );
    
    $shAutoRedirectWww[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_WWW_DONT_ENFORCE') );
    $shAutoRedirectWww[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_WWW_ENFORCE_WWW') );
    $shAutoRedirectWww[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_WWW_ENFORCE_NO_WWW') );

    $lists['shAutoRedirectWww'] = JHTML::_('select.genericlist', $shAutoRedirectWww, 'shAutoRedirectWww',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shAutoRedirectWww); 

    $lists['usealias'] =  JHTML::_('select.booleanlist','UseAlias', $std_opt, $sefConfig->UseAlias );

    // shumisha 2007-04-11 new params for non-sef to sef 301 redirect :
    $lists['shRedirectNonSefToSef'] =  JHTML::_('select.booleanlist','shRedirectNonSefToSef',
    $std_opt, $sefConfig->shRedirectNonSefToSef );
    // shumisha 2007-05-04 new params for joomla sef to sef 301 redirect :
    $lists['shRedirectJoomlaSefToSef'] =  JHTML::_('select.booleanlist','shRedirectJoomlaSefToSef',
    $std_opt, $sefConfig->shRedirectJoomlaSefToSef );

    // V 1.2.4.k 404 errors loggin is now optional
    $lists['shLog404Errors'] =  JHTML::_('select.booleanlist','shLog404Errors',
    $std_opt, $sefConfig->shLog404Errors );
     
    $lists['shInsertContentBlogName'] =  JHTML::_('select.booleanlist','shInsertContentBlogName',  // V 1.2.4.t
    $std_opt, $sefConfig->shInsertContentBlogName );

    // V 1.2.4.t 19/08/2007 16:26:46
    $lists['shKeepStandardURLOnUpgrade'] =  JHTML::_('select.booleanlist','shKeepStandardURLOnUpgrade',
    $std_opt, $sefConfig->shKeepStandardURLOnUpgrade );
    $lists['shKeepCustomURLOnUpgrade'] =  JHTML::_('select.booleanlist','shKeepCustomURLOnUpgrade',
    $std_opt, $sefConfig->shKeepCustomURLOnUpgrade );
    $lists['shKeepMetaDataOnUpgrade'] =  JHTML::_('select.booleanlist','shKeepMetaDataOnUpgrade',
    $std_opt, $sefConfig->shKeepMetaDataOnUpgrade );

    // V 1.2.4.t 24/08/2007 12:56:16
    $lists['shMultipagesTitle'] =  JHTML::_('select.booleanlist','shMultipagesTitle',
    $std_opt, $sefConfig->shMultipagesTitle );

    // V x
    $lists['shKeepConfigOnUpgrade'] =  JHTML::_('select.booleanlist','shKeepConfigOnUpgrade',
    $std_opt, $sefConfig->shKeepConfigOnUpgrade );

    // V x : per language insert iso code and translate URl params and page text

    $activeLanguages = shGetActiveLanguages();
    $lists['activeLanguages'][] = $shPageInfo->shMosConfig_locale;  // put default in first place

    $shLangOption[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_DEFAULT') );
    $shLangOption[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_YES') );
    $shLangOption[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_NO') );

    foreach ($activeLanguages as $language) {
      $currentLang = $language->code;
      if ($currentLang != $shPageInfo->shMosConfig_locale) $lists['activeLanguages'][] = $currentLang;
      $lists['languages_'.$currentLang.'_translateURL'] =
      JHTML::_('select.genericlist', $shLangOption, 'languages_'.$currentLang.'_translateURL',
                   "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangTranslateList[$currentLang]);
      $lists['languages_'.$currentLang.'_insertCode'] =
      JHTML::_('select.genericlist', $shLangOption, 'languages_'.$currentLang.'_insertCode',
                   "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangInsertCodeList[$currentLang]);  
    }

    $lists['debugToLogFile'] =  JHTML::_('select.booleanlist','debugToLogFile',
    $std_opt, $sefConfig->debugToLogFile );

    //build mode list and create the list
    $mode = array();
    $mode[] = JHTML::_('select.option', 0, JText::_('COM_SH404SEF_USE_DEFAULT'));
    $mode[] = JHTML::_('select.option', 1, JText::_('COM_SH404SEF_NOCACHE'));
    $mode[] = JHTML::_('select.option', 2, JText::_('COM_SH404SEF_SKIP'));
    $mode[] = JHTML::_('select.option', 3, JText::_('COM_SH404SEF_USE_JOOMLA_ROUTER'));
    $modeTranslate[] = JHTML::_('select.option', 0, JText::_('COM_SH404SEF_TRANSLATE_URL')); // V 1.2.4.m
    $modeTranslate[] = JHTML::_('select.option', 1, JText::_('COM_SH404SEF_DO_NOT_TRANSLATE_URL'));
    $modeInsertIso[] = JHTML::_('select.option', 0, JText::_('COM_SH404SEF_INSERT_LANGUAGE_CODE'));
    $modeInsertIso[] = JHTML::_('select.option', 1, JText::_('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE'));
    $modeshDoNotOverrideOwnSef[] = JHTML::_('select.option', Sh404sefClassBaseextplugin::TYPE_SH404SEF_ROUTER, JText::_('COM_SH404SEF_USE_SH404SEF_PLUGIN'));
    $modeshDoNotOverrideOwnSef[] = JHTML::_('select.option', Sh404sefClassBaseextplugin::TYPE_JOOMLA_ROUTER, JText::_('COM_SH404SEF_USE_JOOMLA_PLUGIN'));
    $modeshDoNotOverrideOwnSef[] = JHTML::_('select.option', Sh404sefClassBaseextplugin::TYPE_JOOMSEF_ROUTER, JText::_('COM_SH404SEF_USE_JOOMSEF_PLUGIN'));
    $modeshDoNotOverrideOwnSef[] = JHTML::_('select.option', Sh404sefClassBaseextplugin::TYPE_ACESEF_ROUTER, JText::_('COM_SH404SEF_USE_ACESEF_PLUGIN'));
    $compEnablePageId[] = JHTML::_('select.option', 1, JText::_('COM_SH404SEF_ENABLE_PAGEID'));
    $compEnablePageId[] = JHTML::_('select.option', 0, JText::_('COM_SH404SEF_DISABLE_PAGEID'));
    $installedComponents = Sh404sefHelperGeneral::getComponentsList();
    while (list($comName, $comp) = each($installedComponents)){
      $name = str_replace( 'com_', '', $comName);
      $selectedmode = in_array($name,$sefConfig->nocache)*1 + in_array($name,$sefConfig->skip)*2 + in_array($name,$sefConfig->useJoomlaRouter)*3;
      $lists['adv_config'][$name]['manageURL'] = JHTML::_('select.genericlist', $mode, 'com_'.$name.'___manageURL', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);
      $selectedmode = in_array($name,$sefConfig->notTranslateURLList);
      $lists['adv_config'][$name]['translateURL'] = JHTML::_('select.genericlist', $modeTranslate, 'com_'.$name.'___translateURL', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);

      $selectedmode = in_array($name,$sefConfig->notInsertIsoCodeList);
      $lists['adv_config'][$name]['insertIsoCode'] = JHTML::_('select.genericlist', $modeInsertIso, 'com_'.$name.'___insertIsoCode', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);

      if( in_array( $name, $sefConfig->useJoomsefRouter)) {
        $selectedmode = Sh404sefClassBaseextplugin::TYPE_JOOMSEF_ROUTER;
      } else if (in_array( $name, $sefConfig->useAcesefRouter)) {
        $selectedmode = Sh404sefClassBaseextplugin::TYPE_ACESEF_ROUTER;
      } else {
        $selectedmode = in_array($name,$sefConfig->shDoNotOverrideOwnSef);
      }
      $lists['adv_config'][$name]['shDoNotOverrideOwnSef'] = JHTML::_('select.genericlist', $modeshDoNotOverrideOwnSef, 'com_'.$name.'___shDoNotOverrideOwnSef', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);

      $selectedmode = in_array($name,$sefConfig->compEnablePageId) ? 1 : 0;
      $lists['adv_config'][$name]['compEnablePageId'] = JHTML::_('select.genericlist', $compEnablePageId, 'com_'.$name.'___compEnablePageId', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);

      $defaultString = empty($sefConfig->defaultComponentStringList[@$name]) ? '':$sefConfig->defaultComponentStringList[$name];
      $compName = 'com_'.$name.'___defaultComponentString';
      $lists['adv_config'][$name]['defaultComponentString'] =
          '<td width="150"><input type="text" name="'.$compName.'" value="'.$defaultString.'" size="30" maxlength="30"></td>';
    }

    // V 1.0.3
    $lists['defaultParamList'] = $sefConfig->defaultParamList;

    //  V 1.012
    $lists['useCatAlias'] =  JHTML::_('select.booleanlist','useCatAlias',
    $std_opt, $sefConfig->useCatAlias );
    $lists['useMenuAlias'] =  JHTML::_('select.booleanlist','useMenuAlias',
    $std_opt, $sefConfig->useMenuAlias );

    // V 1.5.3
    $lists['alwaysAppendItemsPerPage'] =  JHTML::_('select.booleanlist','alwaysAppendItemsPerPage',
    $std_opt, $sefConfig->alwaysAppendItemsPerPage );
    $lists['redirectToCorrectCaseUrl'] =  JHTML::_('select.booleanlist','redirectToCorrectCaseUrl',
    $std_opt, $sefConfig->redirectToCorrectCaseUrl );

    // V 1.5.5
    $lists['ContentTitleShowCat'] =  JHTML::_('select.booleanlist','ContentTitleShowCat',
    $std_opt, $sefConfig->ContentTitleShowCat );
    $lists['ContentTitleUseAlias'] =  JHTML::_('select.booleanlist','ContentTitleUseAlias',
    $std_opt, $sefConfig->ContentTitleUseAlias );
    $lists['ContentTitleUseCatAlias'] =  JHTML::_('select.booleanlist','ContentTitleUseCatAlias',
    $std_opt, $sefConfig->ContentTitleUseCatAlias );

    $lists['autoCheckNewVersion'] =  JHTML::_('select.booleanlist','autoCheckNewVersion',
    $std_opt, $sefConfig->autoCheckNewVersion );

    $lists['enablePageId'] =  JHTML::_('select.booleanlist', 'enablePageId', $std_opt, $sefConfig->enablePageId );

    // V 2.1.4
    $lists['slowServer'] =  JHTML::_('select.booleanlist', 'slowServer', $std_opt, $sefConfig->slowServer );

    // V 2.1.11
    $lists['insertShortlinkTag'] =  JHTML::_('select.booleanlist', 'insertShortlinkTag', $std_opt, $sefConfig->insertShortlinkTag );
    $lists['insertRevCanTag'] =  JHTML::_('select.booleanlist', 'insertRevCanTag', $std_opt, $sefConfig->insertRevCanTag );
    $lists['insertAltShorterTag'] =  JHTML::_('select.booleanlist', 'insertAltShorterTag', $std_opt, $sefConfig->insertAltShorterTag );
    $lists['stopCreatingShurls'] =  JHTML::_('select.booleanlist', 'stopCreatingShurls', $std_opt, $sefConfig->stopCreatingShurls );

    // push into view
    $this->assign( 'lists', $lists);
  }

  /**
   * Push current general configuration items
   * values into the view for edition
   */
  private function _pushConfigDataAnalytics() {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';

    // analytics
    $lists['analyticsEnabled'] =  JHTML::_('select.booleanlist', 'analyticsEnabled', $std_opt, $sefConfig->analyticsEnabled );
    $lists['analyticsReportsEnabled'] =  JHTML::_('select.booleanlist', 'analyticsReportsEnabled', $std_opt, $sefConfig->analyticsReportsEnabled );
    $lists['analyticsExcludeIP'] = implode("\n",$sefConfig->analyticsExcludeIP);
    $lists['analyticsMaxUserLevel'] = Sh404sefHelperHtml::buildUserLevelsList( $sefConfig->analyticsMaxUserLevel, 'analyticsMaxUserLevel', $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '');
    $lists['autoCheckNewAnalytics'] =  JHTML::_('select.booleanlist', 'autoCheckNewAnalytics', $std_opt, $sefConfig->autoCheckNewAnalytics );
    $lists['analyticsDashboardDateRange'] = Sh404sefHelperHtml::buildDashboardDateRangeList( $sefConfig->analyticsDashboardDateRange, 'analyticsDashboardDateRange', $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '');
    $lists['analyticsEnableTimeCollection'] =  JHTML::_('select.booleanlist', 'analyticsEnableTimeCollection', $std_opt, $sefConfig->analyticsEnableTimeCollection );
    $lists['analyticsEnableUserCollection'] =  JHTML::_('select.booleanlist', 'analyticsEnableUserCollection', $std_opt, $sefConfig->analyticsEnableUserCollection );
    $lists['analyticsDashboardDataType'] = Sh404sefHelperHtml::buildDashboardDataTypeList( $sefConfig->analyticsDashboardDataType, 'analyticsDashboardDataType', $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '');

    // push into view
    $this->assign( 'lists', $lists);
  }


  /**
   * Push current extensions configuration items
   * values into the view for edition
   */
  private function _pushConfigDataExt() {

    // get configuration object
    $shPageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';

    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_NONE, JText::_('COM_SH404SEF_CAT_NONE') );
    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_FIRST, JText::_('COM_SH404SEF_CAT_FIRST') );
    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_LAST, JText::_('COM_SH404SEF_CAT_LAST') );
    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_2_FIRST, JText::_('COM_SH404SEF_CAT_2_FIRST') );
    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_2_LAST, JText::_('COM_SH404SEF_CAT_2_LAST') );
    $includeContentCat[] = JHTML::_('select.option', shSEFConfig::CAT_ALL_NESTED_CAT, JText::_('COM_SH404SEF_CAT_ALL_NESTED_CAT') );
    $lists['includeContentCat'] = JHTML::_('select.genericlist', $includeContentCat, 'includeContentCat',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeContentCat);

    $includeContentCatCategories[] = JHTML::_('select.option', shSEFConfig::CAT_FIRST, JText::_('COM_SH404SEF_CAT_FIRST') );
    $includeContentCatCategories[] = JHTML::_('select.option', shSEFConfig::CAT_LAST, JText::_('COM_SH404SEF_CAT_LAST') );
    $includeContentCatCategories[] = JHTML::_('select.option', shSEFConfig::CAT_2_FIRST, JText::_('COM_SH404SEF_CAT_2_FIRST') );
    $includeContentCatCategories[] = JHTML::_('select.option', shSEFConfig::CAT_2_LAST, JText::_('COM_SH404SEF_CAT_2_LAST') );
    $includeContentCatCategories[] = JHTML::_('select.option', shSEFConfig::CAT_ALL_NESTED_CAT, JText::_('COM_SH404SEF_CAT_ALL_NESTED_CAT') );
    $lists['includeContentCatCategories'] = JHTML::_('select.genericlist', $includeContentCatCategories, 'includeContentCatCategories',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeContentCatCategories);

    // shumisha 2007-04-03 new params for Virtuemart plugin :
    $lists['shVmInsertShopName'] =  JHTML::_('select.booleanlist','shVmInsertShopName',
    $std_opt, $sefConfig->shVmInsertShopName );
    $lists['shInsertProductId'] =  JHTML::_('select.booleanlist','shInsertProductId',
    $std_opt, $sefConfig->shInsertProductId );
    $lists['shVmUseProductSKU'] =  JHTML::_('select.booleanlist','shVmUseProductSKU',
    $std_opt, $sefConfig->shVmUseProductSKU );
    $lists['shVmInsertManufacturerName'] =  JHTML::_('select.booleanlist','shVmInsertManufacturerName',
    $std_opt, $sefConfig->shVmInsertManufacturerName );
    $lists['shInsertManufacturerId'] =  JHTML::_('select.booleanlist','shInsertManufacturerId',
    $std_opt, $sefConfig->shInsertManufacturerId );
    $shVMInsertCat[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES') );
    $shVMInsertCat[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_VM_SHOW_LAST_CATEGORY') );
    $shVMInsertCat[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES') );
    $lists['shVMInsertCategories'] = JHTML::_('select.genericlist', $shVMInsertCat, 'shVMInsertCategories',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shVMInsertCategories); 
    $lists['shInsertCategoryId'] =  JHTML::_('select.booleanlist','shInsertCategoryId',
    $std_opt, $sefConfig->shInsertCategoryId );
    $lists['shVmInsertFlypage'] =  JHTML::_('select.booleanlist','shVmInsertFlypage',  // V 1.2.4.q
    $std_opt, $sefConfig->shVmInsertFlypage );
    // shumisha 2007-04-03 end of new params for Virtuemart plugin

    $lists['shInsertContentTableName'] =  JHTML::_('select.booleanlist','shInsertContentTableName',  // V 1.2.4.r
    $std_opt, $sefConfig->shInsertContentTableName );
    $lists['shVmInsertProductName'] =  JHTML::_('select.booleanlist','shVmInsertProductName',  // V 1.2.4.s
    $std_opt, $sefConfig->shVmInsertProductName );

    $lists['usealias'] =  JHTML::_('select.booleanlist','UseAlias', $std_opt, $sefConfig->UseAlias );

    // shumisha 2007-04-25 new params to activate iJoomla magazine in content :
    $lists['shActivateIJoomlaMagInContent'] =  JHTML::_('select.booleanlist','shActivateIJoomlaMagInContent',
    $std_opt, $sefConfig->shActivateIJoomlaMagInContent );
    $lists['shInsertIJoomlaMagIssueId'] =  JHTML::_('select.booleanlist','shInsertIJoomlaMagIssueId',
    $std_opt, $sefConfig->shInsertIJoomlaMagIssueId );
    $lists['shInsertIJoomlaMagName'] =  JHTML::_('select.booleanlist','shInsertIJoomlaMagName',
    $std_opt, $sefConfig->shInsertIJoomlaMagName );
    $lists['shInsertIJoomlaMagMagazineId'] =  JHTML::_('select.booleanlist','shInsertIJoomlaMagMagazineId',
    $std_opt, $sefConfig->shInsertIJoomlaMagMagazineId );
    $lists['shInsertIJoomlaMagArticleId'] =  JHTML::_('select.booleanlist','shInsertIJoomlaMagArticleId',
    $std_opt, $sefConfig->shInsertIJoomlaMagArticleId );
    // shumisha 2007-04-27 new params for Community Builder :
    $lists['shInsertCBName'] =  JHTML::_('select.booleanlist','shInsertCBName',
    $std_opt, $sefConfig->shInsertCBName );
    $lists['shCBInsertUserName'] =  JHTML::_('select.booleanlist','shCBInsertUserName',
    $std_opt, $sefConfig->shCBInsertUserName );
    $lists['shCBInsertUserId'] =  JHTML::_('select.booleanlist','shCBInsertUserId',
    $std_opt, $sefConfig->shCBInsertUserId );
    $lists['shCBUseUserPseudo'] =  JHTML::_('select.booleanlist','shCBUseUserPseudo',
    $std_opt, $sefConfig->shCBUseUserPseudo );

    $lists['shVmAdditionalText'] =  JHTML::_('select.booleanlist','shVmAdditionalText',
    $std_opt, $sefConfig->shVmAdditionalText );
    $lists['shVmInsertFlypage'] =  JHTML::_('select.booleanlist','shVmInsertFlypage',
    $std_opt, $sefConfig->shVmInsertFlypage );

    // V 1.2.4.m added fireboard params
    $lists['shInsertFireboardName'] =  JHTML::_('select.booleanlist','shInsertFireboardName',
    $std_opt, $sefConfig->shInsertFireboardName );

    $lists['shFbInsertCategoryName'] =  JHTML::_('select.booleanlist','shFbInsertCategoryName',
    $std_opt, $sefConfig->shFbInsertCategoryName );
    $lists['shFbInsertCategoryId'] =  JHTML::_('select.booleanlist','shFbInsertCategoryId',
    $std_opt, $sefConfig->shFbInsertCategoryId );
    $lists['shFbInsertMessageSubject'] =  JHTML::_('select.booleanlist','shFbInsertMessageSubject',
    $std_opt, $sefConfig->shFbInsertMessageSubject );
    $lists['shFbInsertMessageId'] =  JHTML::_('select.booleanlist','shFbInsertMessageId',
    $std_opt, $sefConfig-> shFbInsertMessageId);

    // V 1.2.4.r MyBlog params
    $lists['shInsertMyBlogName'] =  JHTML::_('select.booleanlist','shInsertMyBlogName',
    $std_opt, $sefConfig->shInsertMyBlogName );
    $lists['shMyBlogInsertPostId'] =  JHTML::_('select.booleanlist','shMyBlogInsertPostId',
    $std_opt, $sefConfig->shMyBlogInsertPostId );
    $lists['shMyBlogInsertTagId'] =  JHTML::_('select.booleanlist','shMyBlogInsertTagId',
    $std_opt, $sefConfig->shMyBlogInsertTagId );
    $lists['shMyBlogInsertBloggerId'] =  JHTML::_('select.booleanlist','shMyBlogInsertBloggerId',
    $std_opt, $sefConfig->shMyBlogInsertBloggerId );

    /* Docman parameters  V 1.2.4.r*/
    $lists['shInsertDocmanName'] =  JHTML::_('select.booleanlist','shInsertDocmanName',
    $std_opt, $sefConfig->shInsertDocmanName );
    $lists['shDocmanInsertDocId'] =  JHTML::_('select.booleanlist','shDocmanInsertDocId',
    $std_opt, $sefConfig->shDocmanInsertDocId );
    $lists['shDocmanInsertDocName'] =  JHTML::_('select.booleanlist','shDocmanInsertDocName',
    $std_opt, $sefConfig->shDocmanInsertDocName );
    $lists['shDMInsertCategoryId'] =  JHTML::_('select.booleanlist','shDMInsertCategoryId',  // V 1.2.4.t
    $std_opt, $sefConfig->shDMInsertCategoryId );
    $shDMInsertCat[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES') );
    $shDMInsertCat[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_VM_SHOW_LAST_CATEGORY') );
    $shDMInsertCat[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES') );
    $lists['shDMInsertCategories'] = JHTML::_('select.genericlist', $shDMInsertCat, 'shDMInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shDMInsertCategories);

    $lists['shInsertContentBlogName'] =  JHTML::_('select.booleanlist','shInsertContentBlogName',  // V 1.2.4.t
    $std_opt, $sefConfig->shInsertContentBlogName );

    $lists['shInsertMTreeName'] =  JHTML::_('select.booleanlist','shInsertMTreeName',  // V 1.2.4.t
    $std_opt, $sefConfig->shInsertMTreeName );
    $lists['shMTreeInsertListingName'] =  JHTML::_('select.booleanlist','shMTreeInsertListingName',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreeInsertListingName );
    $lists['shMTreeInsertListingId'] =  JHTML::_('select.booleanlist','shMTreeInsertListingId',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreeInsertListingId );
    $lists['shMTreePrependListingId'] =  JHTML::_('select.booleanlist','shMTreePrependListingId',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreePrependListingId );
    $shMTreeInsertCat[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES') );
    $shMTreeInsertCat[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_VM_SHOW_LAST_CATEGORY') );
    $shMTreeInsertCat[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES') );
    $lists['shMTreeInsertCategories'] = JHTML::_('select.genericlist', $shMTreeInsertCat, 'shMTreeInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shMTreeInsertCategories);
    $lists['shMTreeInsertCategoryId'] =  JHTML::_('select.booleanlist','shMTreeInsertCategoryId',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreeInsertCategoryId );
    $lists['shMTreeInsertUserName'] =  JHTML::_('select.booleanlist','shMTreeInsertUserName',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreeInsertUserName );
    $lists['shMTreeInsertUserId'] =  JHTML::_('select.booleanlist','shMTreeInsertUserId',  // V 1.2.4.t
    $std_opt, $sefConfig->shMTreeInsertUserId );

    $lists['shInsertNewsPName'] =  JHTML::_('select.booleanlist','shInsertNewsPName',  // V 1.2.4.t
    $std_opt, $sefConfig->shInsertNewsPName );
    $lists['shNewsPInsertCatId'] =  JHTML::_('select.booleanlist','shNewsPInsertCatId',  // V 1.2.4.t
    $std_opt, $sefConfig->shNewsPInsertCatId );
    $lists['shNewsPInsertSecId'] =  JHTML::_('select.booleanlist','shNewsPInsertSecId',  // V 1.2.4.t
    $std_opt, $sefConfig->shNewsPInsertSecId );

    /* Remository parameters  V 1.2.4.t  */
    $lists['shInsertRemoName'] =  JHTML::_('select.booleanlist','shInsertRemoName',
    $std_opt, $sefConfig->shInsertRemoName );
    $lists['shRemoInsertDocId'] =  JHTML::_('select.booleanlist','shRemoInsertDocId',
    $std_opt, $sefConfig->shRemoInsertDocId );
    $lists['shRemoInsertDocName'] =  JHTML::_('select.booleanlist','shRemoInsertDocName',
    $std_opt, $sefConfig->shRemoInsertDocName );
    $lists['shRemoInsertCategoryId'] =  JHTML::_('select.booleanlist','shRemoInsertCategoryId',  // V 1.2.4.t
    $std_opt, $sefConfig->shRemoInsertCategoryId );
    $shRemoInsertCat[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES') );
    $shRemoInsertCat[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_VM_SHOW_LAST_CATEGORY') );
    $shRemoInsertCat[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES') );
    $lists['shRemoInsertCategories'] = JHTML::_('select.genericlist', $shRemoInsertCat, 'shRemoInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shRemoInsertCategories);

    // V 1.2.4.t 16/08/2007 15:43:31
    $lists['shCBShortUserURL'] =  JHTML::_('select.booleanlist','shCBShortUserURL',
    $std_opt, $sefConfig->shCBShortUserURL );

    // V 1.2.4.t 24/08/2007 12:56:16
    $lists['shMultipagesTitle'] =  JHTML::_('select.booleanlist','shMultipagesTitle',
    $std_opt, $sefConfig->shMultipagesTitle );

    // V x : per language insert iso code and translate URl params and page text

    $activeLanguages = shGetActiveLanguages();
    $lists['activeLanguages'][] = $shPageInfo->shMosConfig_locale;  // put default in first place

    $shLangOption[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_DEFAULT') );
    $shLangOption[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_YES') );
    $shLangOption[] = JHTML::_('select.option', '2', JText::_('COM_SH404SEF_NO') );

    foreach ($activeLanguages as $language) {
      $currentLang = $language->code;
      if ($currentLang != $shPageInfo->shMosConfig_locale) $lists['activeLanguages'][] = $currentLang;
      $lists['languages_'.$currentLang.'_translateURL'] =
      JHTML::_('select.genericlist', $shLangOption, 'languages_'.$currentLang.'_translateURL',
                   "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangTranslateList[$currentLang]);
      $lists['languages_'.$currentLang.'_insertCode'] =
      JHTML::_('select.genericlist', $shLangOption, 'languages_'.$currentLang.'_insertCode',
                   "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangInsertCodeList[$currentLang]);  
    }

    // V 1.3.1 RC
    $lists['shVmUsingItemsPerPage'] =  JHTML::_('select.booleanlist','shVmUsingItemsPerPage',
    $std_opt, $sefConfig->shVmUsingItemsPerPage );

    //  V 1.012
    $lists['useCatAlias'] =  JHTML::_('select.booleanlist','useCatAlias',
    $std_opt, $sefConfig->useCatAlias );
    $lists['useMenuAlias'] =  JHTML::_('select.booleanlist','useMenuAlias',
    $std_opt, $sefConfig->useMenuAlias );

    $lists['jclInsertEventId'] =  JHTML::_('select.booleanlist','jclInsertEventId',
    $std_opt, $sefConfig->jclInsertEventId );
    $lists['jclInsertCategoryId'] =  JHTML::_('select.booleanlist','jclInsertCategoryId',
    $std_opt, $sefConfig->jclInsertCategoryId );
    $lists['jclInsertCalendarId'] =  JHTML::_('select.booleanlist','jclInsertCalendarId',
    $std_opt, $sefConfig->jclInsertCalendarId );
    $lists['jclInsertCalendarName'] =  JHTML::_('select.booleanlist','jclInsertCalendarName',
    $std_opt, $sefConfig->jclInsertCalendarName );
    $lists['jclInsertDate'] =  JHTML::_('select.booleanlist','jclInsertDate',
    $std_opt, $sefConfig->jclInsertDate );
    $lists['jclInsertDateInEventView'] =  JHTML::_('select.booleanlist','jclInsertDateInEventView',
    $std_opt, $sefConfig->jclInsertDateInEventView );

    // V 1.5.7
    // shumisha 2007-04-11 new params for Numerical Id insert :
    $lists['ContentTitleInsertArticleId'] =  JHTML::_('select.booleanlist','ContentTitleInsertArticleId',
    $std_opt, $sefConfig->ContentTitleInsertArticleId );
    // build the html select list for category
    $category = array();
    $catListOptions = JHtml::_('category.options', 'com_content');
    if (is_array( $catListOptions)) {
      $category = array_merge( $category, $catListOptions);
    }
    $category = JHTML::_('select.genericlist', $category, 'shInsertContentArticleIdCatList[]',
      'class="inputbox" size="10" multiple="multiple"' ,
        'value', 'text', $sefConfig->shInsertContentArticleIdCatList);
    $lists['shInsertContentArticleIdCatList'] = $category;


    // V 1.5.8

    $lists['shJSInsertJSName'] =  JHTML::_('select.booleanlist','shJSInsertJSName',
    $std_opt, $sefConfig->shJSInsertJSName );
    $lists['shJSShortURLToUserProfile'] =  JHTML::_('select.booleanlist','shJSShortURLToUserProfile',
    $std_opt, $sefConfig->shJSShortURLToUserProfile );
    $lists['shJSInsertUsername'] =  JHTML::_('select.booleanlist','shJSInsertUsername',
    $std_opt, $sefConfig->shJSInsertUsername );
    $lists['shJSInsertUserFullName'] =  JHTML::_('select.booleanlist','shJSInsertUserFullName',
    $std_opt, $sefConfig->shJSInsertUserFullName );
    $lists['shJSInsertUserId'] =  JHTML::_('select.booleanlist','shJSInsertUserId',
    $std_opt, $sefConfig->shJSInsertUserId );
    $lists['shJSInsertGroupCategory'] =  JHTML::_('select.booleanlist','shJSInsertGroupCategory',
    $std_opt, $sefConfig->shJSInsertGroupCategory );
    $lists['shJSInsertGroupCategoryId'] =  JHTML::_('select.booleanlist','shJSInsertGroupCategoryId',
    $std_opt, $sefConfig->shJSInsertGroupCategoryId );
    $lists['shJSInsertGroupId'] =  JHTML::_('select.booleanlist','shJSInsertGroupId',
    $std_opt, $sefConfig->shJSInsertGroupId );
    $lists['shJSInsertGroupBulletinId'] =  JHTML::_('select.booleanlist','shJSInsertGroupBulletinId',
    $std_opt, $sefConfig->shJSInsertGroupBulletinId );
    $lists['shJSInsertDiscussionId'] =  JHTML::_('select.booleanlist','shJSInsertDiscussionId',
    $std_opt, $sefConfig->shJSInsertDiscussionId );
    $lists['shJSInsertMessageId'] =  JHTML::_('select.booleanlist','shJSInsertMessageId',
    $std_opt, $sefConfig->shJSInsertMessageId );
    $lists['shJSInsertPhotoAlbum'] =  JHTML::_('select.booleanlist','shJSInsertPhotoAlbum',
    $std_opt, $sefConfig->shJSInsertPhotoAlbum );
    $lists['shJSInsertPhotoAlbumId'] =  JHTML::_('select.booleanlist','shJSInsertPhotoAlbumId',
    $std_opt, $sefConfig->shJSInsertPhotoAlbumId );
    $lists['shJSInsertPhotoId'] =  JHTML::_('select.booleanlist','shJSInsertPhotoId',
    $std_opt, $sefConfig->shJSInsertPhotoId );
    $lists['shJSInsertVideoCat'] =  JHTML::_('select.booleanlist','shJSInsertVideoCat',
    $std_opt, $sefConfig->shJSInsertVideoCat );
    $lists['shJSInsertVideoCatId'] =  JHTML::_('select.booleanlist','shJSInsertVideoCatId',
    $std_opt, $sefConfig->shJSInsertVideoCatId );
    $lists['shJSInsertVideoId'] =  JHTML::_('select.booleanlist','shJSInsertVideoId',
    $std_opt, $sefConfig->shJSInsertVideoId );

    $lists['shFbInsertUserName'] =  JHTML::_('select.booleanlist','shFbInsertUserName',
    $std_opt, $sefConfig->shFbInsertUserName );
    $lists['shFbInsertUserId'] =  JHTML::_('select.booleanlist','shFbInsertUserId',
    $std_opt, $sefConfig->shFbInsertUserId );
    $lists['shFbShortUrlToProfile'] =  JHTML::_('select.booleanlist','shFbShortUrlToProfile',
    $std_opt, $sefConfig->shFbShortUrlToProfile );

    // shumisha 2007-04-11 new params for Numerical Id insert :
    $lists['shInsertNumericalId'] =  JHTML::_('select.booleanlist','shInsertNumericalId',
    $std_opt, $sefConfig->shInsertNumericalId );
    // build the html select list for category!
    $categories[] = JHTML::_('select.option', '', JText::_('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT') );
    $catListOptions = JHtml::_('category.options', 'com_content');
    if (is_array( $catListOptions)) {
      $categories = array_merge( $categories, $catListOptions);
    }

    $categories = JHTML::_('select.genericlist', $categories, 'shInsertNumericalIdCatList[]',
      'class="inputbox" size="10" multiple="multiple"' ,
        'value', 'text', $sefConfig->shInsertNumericalIdCatList);
    $lists['shInsertNumericalIdCatList'] = $categories;

    // V 3.0
    $lists['useContactCatAlias'] =  JHTML::_('select.booleanlist','useContactCatAlias',
    $std_opt, $sefConfig->useContactCatAlias );
    
    $lists['includeContactCat'] = JHTML::_('select.genericlist', $includeContentCat, 'includeContactCat',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeContactCat);

    $lists['includeContactCatCategories'] = JHTML::_('select.genericlist', $includeContentCatCategories, 'includeContactCatCategories',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeContactCatCategories);
    
    $lists['useWeblinksCatAlias'] =  JHTML::_('select.booleanlist','useWeblinksCatAlias',
    $std_opt, $sefConfig->useWeblinksCatAlias );
    
    $lists['includeWeblinksCat'] = JHTML::_('select.genericlist', $includeContentCat, 'includeWeblinksCat',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeWeblinksCat);

    $lists['includeWeblinksCatCategories'] = JHTML::_('select.genericlist', $includeContentCatCategories, 'includeWeblinksCatCategories',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->includeWeblinksCatCategories);
    
    // V 3.1.2
    $categories = array();
    $categories[] = JHTML::_('select.option', '0', JText::_('COM_SH404SEF_UNCAT_ITEM_SLUG_NO_CAT') );
    $categories[] = JHTML::_('select.option', '1', JText::_('COM_SH404SEF_UNCAT_ITEM_SLUG_USE_MENU_ITEM') );
    $lists['slugForUncategorizedContent'] =  JHTML::_('select.genericlist', $categories, 'slugForUncategorizedContent',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->slugForUncategorizedContent);
    $lists['slugForUncategorizedContact'] =  JHTML::_('select.genericlist', $categories, 'slugForUncategorizedContact',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->slugForUncategorizedContact);
    $lists['slugForUncategorizedWeblinks'] =  JHTML::_('select.genericlist', $categories, 'slugForUncategorizedWeblinks',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->slugForUncategorizedWeblinks);
    
    //push params in to view
    $this->assign( 'lists', $lists);
  }


  /**
   * Push current SEO and metas configuration items
   * values into the view for edition
   */
  private function _pushConfigDataSeo() {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';

    $lists['shRemoveGeneratorTag'] =  JHTML::_('select.booleanlist','shRemoveGeneratorTag',  // V 1.2.4.r
    $std_opt, $sefConfig->shRemoveGeneratorTag );
    $lists['shPutH1Tags'] =  JHTML::_('select.booleanlist','shPutH1Tags',  // V 1.2.4.r
    $std_opt, $sefConfig->shPutH1Tags );
    $lists['shMetaManagementActivated'] =  JHTML::_('select.booleanlist','shMetaManagementActivated',  // V 1.2.4.r
    $std_opt, $sefConfig->shMetaManagementActivated );

    // V 1.3 RC shCustomTags params
    /*
    $lists['shInsertReadMorePageTitle'] =  JHTML::_('select.booleanlist','shInsertReadMorePageTitle',
    $std_opt, $sefConfig->shInsertReadMorePageTitle );
    */
    $lists['shMultipleH1ToH2'] =  JHTML::_('select.booleanlist','shMultipleH1ToH2',
    $std_opt, $sefConfig->shMultipleH1ToH2 );

    // V 1.3.1
    $lists['shInsertOutboundLinksImage'] =  JHTML::_('select.booleanlist','shInsertOutboundLinksImage',
    $std_opt, $sefConfig->shInsertOutboundLinksImage );
    $shInsertImgLnk[] = JHTML::_('select.option', 'external-black.png', JText::_('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK') );
    $shInsertImgLnk[] = JHTML::_('select.option', 'external-white.png', JText::_('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE') );

    $lists['shImageForOutboundLinks'] = JHTML::_('select.genericlist', $shInsertImgLnk, 'shImageForOutboundLinks',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shImageForOutboundLinks);

    $lists['ContentTitleShowCat'] =  JHTML::_('select.booleanlist','ContentTitleShowCat',
    $std_opt, $sefConfig->ContentTitleShowCat );
    $lists['ContentTitleUseAlias'] =  JHTML::_('select.booleanlist','ContentTitleUseAlias',
    $std_opt, $sefConfig->ContentTitleUseAlias );
    $lists['ContentTitleUseCatAlias'] =  JHTML::_('select.booleanlist','ContentTitleUseCatAlias',
    $std_opt, $sefConfig->ContentTitleUseCatAlias );

    $contentTitleIncludeCat[] = JHTML::_('select.option', shSEFConfig::CAT_FIRST, JText::_('COM_SH404SEF_CAT_FIRST') );
    $contentTitleIncludeCat[] = JHTML::_('select.option', shSEFConfig::CAT_LAST, JText::_('COM_SH404SEF_CAT_LAST') );
    $contentTitleIncludeCat[] = JHTML::_('select.option', shSEFConfig::CAT_2_FIRST, JText::_('COM_SH404SEF_CAT_2_FIRST') );
    $contentTitleIncludeCat[] = JHTML::_('select.option', shSEFConfig::CAT_2_LAST, JText::_('COM_SH404SEF_CAT_2_LAST') );
    $contentTitleIncludeCat[] = JHTML::_('select.option', shSEFConfig::CAT_ALL_NESTED_CAT, JText::_('COM_SH404SEF_CAT_ALL_NESTED_CAT') );
    $lists['contentTitleIncludeCat'] = JHTML::_('select.genericlist', $contentTitleIncludeCat, 'contentTitleIncludeCat',
      "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->contentTitleIncludeCat);

    // mobile configuration is actually coming from the system plugin
    $plugin = &JPluginHelper::getPlugin( 'system', 'shmobile');
    $params = new JParameter( $plugin->params);
    $enabled = $params->get('mobile_switch_enabled');
    $lists['mobile_switch_enabled'] = JHTML::_('select.booleanlist','mobile_switch_enabled',
    $std_opt, $enabled );
    $lists['mobile_template'] = $params->get('mobile_template');

    //push params in to view
    $this->assign( 'lists', $lists);

  }

  /**
   * Push current Security configuration items
   * values into the view for edition
   */
  private function _pushConfigDataSec() {

    // get configuration object
    $shPageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';

    // security parameters  V x
    $lists['shSecEnableSecurity'] =  JHTML::_('select.booleanlist','shSecEnableSecurity',
    $std_opt, $sefConfig->shSecEnableSecurity );
    $lists['shSecLogAttacks'] =  JHTML::_('select.booleanlist','shSecLogAttacks',
    $std_opt, $sefConfig->shSecLogAttacks );
    $lists['shSecOnlyNumVars'] = implode("\n",$sefConfig->shSecOnlyNumVars);
    $lists['shSecAlphaNumVars'] = implode("\n",$sefConfig->shSecAlphaNumVars);
    $lists['shSecNoProtocolVars'] = implode("\n",$sefConfig->shSecNoProtocolVars);
    $lists['ipWhiteList'] = implode("\n",$sefConfig->ipWhiteList);
    $lists['ipBlackList'] = implode("\n",$sefConfig->ipBlackList);
    $lists['uAgentWhiteList'] = implode("\n",$sefConfig->uAgentWhiteList);
    $lists['uAgentBlackList'] = implode("\n",$sefConfig->uAgentBlackList);

    $lists['shSecCheckHoneyPot'] =  JHTML::_('select.booleanlist','shSecCheckHoneyPot',
    $std_opt, $sefConfig->shSecCheckHoneyPot );
    $lists['shSecActivateAntiFlood'] =  JHTML::_('select.booleanlist','shSecActivateAntiFlood',
    $std_opt, $sefConfig->shSecActivateAntiFlood );
    $lists['shSecAntiFloodOnlyOnPOST'] =  JHTML::_('select.booleanlist','shSecAntiFloodOnlyOnPOST',
    $std_opt, $sefConfig->shSecAntiFloodOnlyOnPOST );

    $lists['shSecCheckPOSTData'] =  JHTML::_('select.booleanlist','shSecCheckPOSTData',
    $std_opt, $sefConfig->shSecCheckPOSTData );

    //push params in to view
    $this->assign( 'lists', $lists);

  }

  /**
   * Push current error documents content
   * values into the view for edition
   */
  private function _pushConfigDataErrorDocs() {

    // get configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // push it into to the view
    $this->assignRef( 'sefConfig', $sefConfig);

    // special check for Joomfish 2.0 : must be sure href are not cached in language selection module
    // otherwise new SEF urls will not be created
    shDisableJFModuleCaching();

    $database =& JFactory::getDBO();
    $std_opt = 'class="inputbox" size="2"';

    // get a list of the static content items for 404 page
    $query = "SELECT id, title"
    . "\n FROM #__content"
    . "\n WHERE sectionid = 0 AND title != '__404__'"
    . "\n AND catid = 0"
    . "\n ORDER BY ordering"
    ;
    $database->setQuery( $query );
    $items = $database->loadObjectList();
    $options = array(  JHTML::_('select.option', 0, "(".JText::_('COM_SH404SEF_DEF_404_PAGE').")")  );
    //$options[] = JHTML::_('select.option', 9999999, "(Front Page)" ); // 1.2.4.t
    // assemble menu items to the array
    foreach ( $items as $item ) {
      $options[] = JHTML::_('select.option', $item->id, $item->title );
    }
    $lists['page404'] = JHTML::_('select.genericlist', $options, 'page404', 'class="inputbox" size="1"', 'value', 'text', $sefConfig->page404 );

    $sql='SELECT id,introtext FROM #__content WHERE `title`="__404__"';
    $row = null;
    $database->setQuery($sql);
    $row = $database->loadObject(  );
    if (!empty($row) && !empty($row->introtext))  // V 1.2.4.t
    $txt404 = $row->introtext;
    else
    $txt404 = JText::_('COM_SH404SEF_DEF_404_MSG');

    //push params in to view
    $this->assign( 'lists', $lists);
    $this->assign( 'txt404', $txt404);

  }


  /**
   * Create toolbar for current view
   *
   * @param midxed $params
   */
  private function _makeToolbar( $params = null) {

    // Get the JComponent instance of JToolBar
    $bar = & JToolBar::getInstance('toolbar');

    // add save button as an ajax call
    $bar->addButtonPath( JPATH_COMPONENT . DS . 'classes');
    $params['class'] = 'modalediturl';
    $params['id'] = 'modalediturlsave';
    $params['closewindow'] = 1;
    $bar->appendButton( 'Shajaxbutton', 'save', 'Save', '', $params);

    // add apply button as an ajax call
    $params['id'] = 'modalediturlapply';
    $params['closewindow'] = 0;
    $bar->appendButton( 'Shajaxbutton', 'apply', 'Apply', '', $params);

    // other button are standards
    JToolBarHelper::cancel( 'cancel');

    return $bar;

  }

  private function _addCss() {

    // add link to css
    JHtml::styleSheet( 'icon.css', 'administrator/templates/bluestork/css/');
    JHtml::styleSheet( 'rounded.css', 'administrator/templates/bluestork/css/');
    JHtml::styleSheet( 'system.css', 'administrator/templates/system/css/');
    $customCss = '
    <!--[if IE 7]>
<link href="templates/bluestork/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="templates/bluestork/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->';
    // insert using addCustomtag, so that J! does not add any markup
    $document = & JFactory::getDocument();
    $document->addCustomTag( $customCss);

    // add our own css
    JHtml::styleSheet( 'config.css', Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/');

  }

  /*
   *
   * Build and insert into document some javascript to
   * collect Joomla text editor conten. This cannot
   * be hardcoded into config.js, as the code to
   * collect editor content depends on the editor selected
   * by user, and is provided by the editor object itself
   * However, the shCollectEditorData() function will be
   * called from config.js when save or apply is pressed
   */
  private function _addJs() {

    // get editor instance
    $editor =& JFactory::getEditor();

    // build javascript
    $js = '
      <!--
      function shCollectEditorData() {
        var text = '
        . $editor->getContent( 'introtext' )
        . $editor->save( 'introtext' )
        . '$("introtext").value=text;'
        . '
      };
    //-->  
    ';

        // insert into document
        $document = & JFactory::getDocument();
        $document->addScriptDeclaration( $js);

  }

}