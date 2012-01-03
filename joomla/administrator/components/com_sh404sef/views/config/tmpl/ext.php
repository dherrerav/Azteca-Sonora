<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: ext.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
// we'll use panes so import Joomla library and instantiate one
jimport( 'joomla.html.pane');
$pane =& JPane::getInstance('Tabs');

?>

<div class="sh404sef-popup" id="sh404sef-popup">

<!-- markup common to all config layouts -->

<?php include JPATH_ADMINISTRATOR . DS . 'components' . DS. 'com_sh404sef' . DS . 'views' . DS . 'config' . DS . 'tmpl' . DS . 'common_header.php'; ?>

<!-- start general configuration markup -->

<div id="element-box">
  <div class="t">
    <div class="t">
      <div class="t"></div>
    </div>
  </div>
<div class="m">

<form action="index.php" method="post" name="adminForm" id="adminForm">

  <div id="editcell">

  <!-- start of configuration html -->
  
  <?php 
    echo $pane->startPane('sh404SEFConf');

    echo $pane->startPanel( 'Joomla', 'content' ); ?>
    
<table class="adminlist">

  <!-- shumisha 2007-06-30 new params for regular content  -->
  <?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_USE_ALIAS'),
  JText::_('COM_SH404SEF_TT_USE_ALIAS'),
  $this->lists['usealias'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_USE_CAT_ALIAS'),
  JText::_('COM_SH404SEF_TT_USE_CAT_ALIAS'),
  $this->lists['useCatAlias'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_USE_MENU_ALIAS'),
  JText::_('COM_SH404SEF_TT_USE_MENU_ALIAS'),
  $this->lists['useMenuAlias'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT'),
  $this->lists['includeContentCat'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT_CATEGORIES'),
  $this->lists['includeContentCatCategories'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_CATEGORIES_SUFFIX'),
  JText::_('COM_SH404SEF_TT_CATEGORIES_SUFFIX'),
            'contentCategoriesSuffix',
  $this->sefConfig->contentCategoriesSuffix, 30, 30 );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  JText::_('COM_SH404SEF_TT_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  $this->lists['slugForUncategorizedContent'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME'),
  JText::_('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME'),
  $this->lists['shInsertContentTableName'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_CONTENT_TABLE_NAME'),
  JText::_('COM_SH404SEF_TT_CONTENT_TABLE_NAME'),
            'shContentTableName',
  $this->sefConfig->shContentTableName, 30, 30 );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME'),
  JText::_('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME'),
  $this->lists['shInsertContentBlogName'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_CONTENT_BLOG_NAME'),
  JText::_('COM_SH404SEF_TT_CONTENT_BLOG_NAME'),
            'shContentBlogName',
  $this->sefConfig->shContentBlogName, 30, 30 );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE'),
  JText::_('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE'),
  $this->lists['shMultipagesTitle'] );

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_ARTICLE_ID_TITLE'),
  JText::_('COM_SH404SEF_TT_INSERT_ARTICLE_ID_TITLE'),
  $this->lists['ContentTitleInsertArticleId'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST'),
  JText::_('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST'),
  $this->lists['shInsertContentArticleIdCatList'] );

  ?>
</table>
<table class="adminlist">  
  <!-- shumisha 2007-04-01 new params for Numerical Id insert  -->
  <thead>
    <tr>
      <th class="title" style="text-align: left;" colspan="3"><?php echo JText::_('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE'); ?></th>
    </tr>
  </thead>
  <?php
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE'),
  JText::_('COM_SH404SEF_TT_INSERT_NUMERICAL_ID'),
  $this->lists['shInsertNumericalId'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST'),
  JText::_('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST'),
  $this->lists['shInsertNumericalIdCatList'] ); 
  
  ?>
  <!-- shumisha 2007-04-01 end of new params for Numerical Id insert  -->  

  </table><?php
  // end of params for regular content  -->
  
    echo $pane->endPanel();

    echo $pane->startPanel( 'Contacts', 'contact' );

  // params for Com_contact  -->
  ?><table class="adminlist"><?php
    
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_USE_CAT_ALIAS'),
  JText::_('COM_SH404SEF_TT_USE_CAT_ALIAS'),
  $this->lists['useContactCatAlias'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT'),
  $this->lists['includeContactCat'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT_CATEGORIES'),
  $this->lists['includeContactCatCategories'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_CATEGORIES_SUFFIX'),
  JText::_('COM_SH404SEF_TT_CATEGORIES_SUFFIX'),
            'contactCategoriesSuffix',
  $this->sefConfig->contactCategoriesSuffix, 30, 30 );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  JText::_('COM_SH404SEF_TT_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  $this->lists['slugForUncategorizedContact'] );
  

  ?></table><?php
  // end of params for Contact  -->
  
    echo $pane->endPanel();
    
    echo $pane->startPanel( 'Weblinks', 'weblinks' );

  // params for Com_weblinks  -->
  ?><table class="adminlist"><?php
    
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_USE_CAT_ALIAS'),
  JText::_('COM_SH404SEF_TT_USE_CAT_ALIAS'),
  $this->lists['useWeblinksCatAlias'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT'),
  $this->lists['includeWeblinksCat'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INCLUDE_CONTENT_CAT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_INCLUDE_CONTENT_CAT_CATEGORIES'),
  $this->lists['includeWeblinksCatCategories'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_CATEGORIES_SUFFIX'),
  JText::_('COM_SH404SEF_TT_CATEGORIES_SUFFIX'),
            'weblinksCategoriesSuffix',
  $this->sefConfig->weblinksCategoriesSuffix, 30, 30 );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  JText::_('COM_SH404SEF_TT_SLUG_FOR_UNCATEGORIZED_ITEMS'),
  $this->lists['slugForUncategorizedWeblinks'] );
  

  ?></table><?php
  // end of params for Contact  -->
  
    echo $pane->endPanel();
    
    
    /*
    echo $pane->startPanel( 'JCal pro', 'jcalpro' );

  // shumisha 2010-01-11 new params for JCalpro 2  -->
  ?><table class="adminlist"><?php
    
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_EVENT_ID'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID'),
  $this->lists['jclInsertEventId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_CATEGORY_ID'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID'),
  $this->lists['jclInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_CALENDAR_ID'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID'),
  $this->lists['jclInsertCalendarId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME'),
  $this->lists['jclInsertCalendarName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_DATE'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_DATE'),
  $this->lists['jclInsertDate'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JCL_INSERT_DATE_IN_EVENT_VIEW'),
  JText::_('COM_SH404SEF_TT_JCL_INSERT_DATE_IN_EVENT_VIEW'),
  $this->lists['jclInsertDateInEventView'] );

  ?></table><?php
  // end of params for JCalpro 2  -->
  
    echo $pane->endPanel();
    
   */
      
    echo $pane->startPanel( 'Virtuemart', 'virtuemart' );
    
  // params for Virtuemart  -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_SHOP_NAME'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shVmInsertShopName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_PRODUCT_NAME'),
  JText::_('COM_SH404SEF_TT_INSERT_PRODUCT_NAME'),
  $this->lists['shVmInsertProductName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_PRODUCT_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_PRODUCT_ID'),
  $this->lists['shInsertProductId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S'),
  JText::_('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S'),
  $this->lists['shVmUseProductSKU'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME'),
  $this->lists['shVmInsertManufacturerName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID'),
  $this->lists['shInsertManufacturerId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_CATEGORIES'),
  $this->lists['shVMInsertCategories'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_CATEGORY_ID'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID'),
  $this->lists['shInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_ADDITIONAL_TEXT'),
  JText::_('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT'),
  $this->lists['shVmAdditionalText'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_INSERT_FLYPAGE'),
  JText::_('COM_SH404SEF_TT_VM_INSERT_FLYPAGE'),
  $this->lists['shVmInsertFlypage'] );

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE'),
  JText::_('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE'),
  $this->lists['shVmUsingItemsPerPage'] );
  
  ?></table><?php
  // end of params for Virtuemart  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Community Builder', 'cb' );
    
  // params for Community Builder  -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertCBName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_USER_NAME'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_USER_NAME'),
  $this->lists['shCBInsertUserName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_USER_ID'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_USER_ID'),
  $this->lists['shCBInsertUserId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_USE_USER_PSEUDO'),
  JText::_('COM_SH404SEF_TT_CB_USE_USER_PSEUDO'),
  $this->lists['shCBUseUserPseudo'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_SHORT_USER_URL'),
  JText::_('COM_SH404SEF_TT_CB_SHORT_USER_URL'),
  $this->lists['shCBShortUserURL'] );
  
  ?></table><?php
  // end of params for Community Builder  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Jomsocial', 'jomsocial' );
    
  // params for JomSocial -->
  ?><table class="adminlist"><?php
  
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shJSInsertJSName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_SHORT_USER_URL'),
  JText::_('COM_SH404SEF_TT_CB_SHORT_USER_URL'),
  $this->lists['shJSShortURLToUserProfile'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_USER_NAME'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_USER_NAME'),
  $this->lists['shJSInsertUsername'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_USER_FULL_NAME'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_USER_FULL_NAME'),
  $this->lists['shJSInsertUserFullName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_USER_ID'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_USER_ID'),
  $this->lists['shJSInsertUserId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY'),
  $this->lists['shJSInsertGroupCategory'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY_ID'),
  $this->lists['shJSInsertGroupCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_GROUP_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_GROUP_ID'),
  $this->lists['shJSInsertGroupId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_GROUP_BULLETIN_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_GROUP_BULLETIN_ID'),
  $this->lists['shJSInsertGroupBulletinId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_DISCUSSION_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_DISCUSSION_ID'),
  $this->lists['shJSInsertDiscussionId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_MESSAGE_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_MESSAGE_ID'),
  $this->lists['shJSInsertMessageId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM'),
  $this->lists['shJSInsertPhotoAlbum'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM_ID'),
  $this->lists['shJSInsertPhotoAlbumId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_PHOTO_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_PHOTO_ID'),
  $this->lists['shJSInsertPhotoId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_VIDEO_CAT'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT'),
  $this->lists['shJSInsertVideoCat'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_VIDEO_CAT_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT_ID'),
  $this->lists['shJSInsertVideoCatId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_JS_INSERT_VIDEO_ID'),
  JText::_('COM_SH404SEF_TT_JS_INSERT_VIDEO_ID'),
  $this->lists['shJSInsertVideoId'] );
 
  ?></table><?php
  // end of params for Jomsocial  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Kunena', 'kunena' );
    
  // params for Kunena -->
  ?><table class="adminlist"><?php
  
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertFireboardName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_CATEGORY_NAME'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME'),
  $this->lists['shFbInsertCategoryName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_CATEGORY_ID'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID'),
  $this->lists['shFbInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT'),
  $this->lists['shFbInsertMessageSubject'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_MESSAGE_ID'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID'),
  $this->lists['shFbInsertMessageId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_SHORT_USER_URL'),
  JText::_('COM_SH404SEF_TT_CB_SHORT_USER_URL'),
  $this->lists['shFbShortUrlToProfile'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_USERNAME'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_USERNAME'),
  $this->lists['shFbInsertUserName'] ); 
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_FB_INSERT_USER_ID'),
  JText::_('COM_SH404SEF_TT_FB_INSERT_USER_ID'),
  $this->lists['shFbInsertUserId'] );

  ?></table><?php
  // end of params for kunena  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Docman', 'docman' );
    
  // params for Docman -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertDocmanName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_DOC_ID'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID'),
  $this->lists['shDocmanInsertDocId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME'),
  $this->lists['shDocmanInsertDocName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CAT_ID'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID'),
  $this->lists['shDMInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES'),
  $this->lists['shDMInsertCategories'] );
  
  ?></table><?php
  // end of params for Docman  -->
  
    echo $pane->endPanel();

    /*

    echo $pane->startPanel( 'Remository', 'remository' );
    
  // params for Remository -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_REMO_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_REMO_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertRemoName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_DOC_ID'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID'),
  $this->lists['shRemoInsertDocId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME'),
  $this->lists['shRemoInsertDocName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CAT_ID'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID'),
  $this->lists['shRemoInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES'),
  $this->lists['shRemoInsertCategories'] );

  ?></table><?php
  // end of params for Remository  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Letterman', 'Letterman' );
    
  // params for Letterman -->
  ?><table class="adminlist"><?php

  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID'),
  JText::_('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID'),
            'shLMDefaultItemid',
  $this->sefConfig->shLMDefaultItemid, 10, 10 );

  ?></table><?php
  // end of params for Letterman  -->
  
    echo $pane->endPanel(); 
    
    */
    echo $pane->startPanel( 'MyBlog', 'MyBlog' );
    
  // params for MyBlog -->
  ?><table class="adminlist"><?php
  
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MYBLOG_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_MYBLOG_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertMyBlogName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MYBLOG_INSERT_POST_ID'),
  JText::_('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID'),
  $this->lists['shMyBlogInsertPostId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MYBLOG_INSERT_TAG_ID'),
  JText::_('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID'),
  $this->lists['shMyBlogInsertTagId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID'),
  JText::_('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID'),
  $this->lists['shMyBlogInsertBloggerId'] );

  ?></table><?php
  // end of params for MyBlog  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'Mosets tree', 'Mtree' );
    
  // params for Mosets Tree -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MTREE_INSERT_NAME'),
  JText::_('COM_SH404SEF_TT_MTREE_INSERT_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertMTreeName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MTREE_INSERT_LISTING_ID'),
  JText::_('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID'),
  $this->lists['shMTreeInsertListingId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MTREE_PREPEND_LISTING_ID'),
  JText::_('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID'),
  $this->lists['shMTreePrependListingId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MTREE_INSERT_LISTING_NAME'),
  JText::_('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME'),
  $this->lists['shMTreeInsertListingName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CAT_ID'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID'),
  $this->lists['shMTreeInsertCategoryId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES'),
  JText::_('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES'),
  $this->lists['shMTreeInsertCategories'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_USER_ID'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_USER_ID'),
  $this->lists['shMTreeInsertUserId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CB_INSERT_USER_NAME'),
  JText::_('COM_SH404SEF_TT_CB_INSERT_USER_NAME'),
  $this->lists['shMTreeInsertUserName'] );

  ?></table><?php
  // end of params for Mosets Tree  -->
  
    echo $pane->endPanel(); 
    
    /*
    
    echo $pane->startPanel( 'iJoomla Mag', 'ijoomlamag' );
    
  // params for iJoomla magazine -->
  ?><table class="adminlist"><?php

  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG'),
  JText::_('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG'),
  $this->lists['shActivateIJoomlaMagInContent'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertIJoomlaMagName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID'),
  $this->lists['shInsertIJoomlaMagMagazineId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID'),
  $this->lists['shInsertIJoomlaMagIssueId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID'),
  $this->lists['shInsertIJoomlaMagArticleId'] ); 
  
  ?></table><?php
  // end of params for iJoomla magazine  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( 'iJoomla News', 'ijoomlanewsp' );
    
  // params for iJoomla NewsPortal -->
  ?><table class="adminlist"><?php
  
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME') . JText::_('COM_SH404SEF_TT_NAME_BY_COMP'),
  $this->lists['shInsertNewsPName'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID'),
  $this->lists['shNewsPInsertCatId'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID'),
  JText::_('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID'),
  $this->lists['shNewsPInsertSecId'] );

  ?></table><?php
  // end of params for iJoomla NewsPortal  -->
  
    echo $pane->endPanel();
    
    */
    
    echo $pane->endPane(); 
  ?>
  
  <!-- end of configuration html -->

    <input type="hidden" name="c" value="config" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="layout" value="ext" />
    <input type="hidden" name="format" value="raw" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="shajax" value="1" />
    <input type="hidden" name="tmpl" value="component" />
    
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>

  <div class="clr"></div>
</div>
  <div class="b">
    <div class="b">
      <div class="b"></div>
    </div>
  </div>
</div>

</div>