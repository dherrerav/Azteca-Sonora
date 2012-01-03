<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: seo.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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
    echo $pane->startPanel( JText::_('COM_SH404SEF_TITLE_META_MANAGEMENT'), 'content' ); ?>
    
<table class="adminlist">
  <tr>
  
    <td colspan="3" align="left">
    <div
      style="border: 1px solid #FF0000; margin: 5px; padding: 5px; background-color: #FFEFEF">
      <?php echo JText::_('COM_SH404SEF_CONF_META_DOC'); ?></div>
    </td>
  </tr>
  
  <!-- shumisha 2007-07-01 Activate Meta management  -->
  <tr <?php 
    $x=0;
    $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200"><?php echo JText::_('COM_SH404SEF_META_MANAGEMENT_ACTIVATED'); ?></td>
    <td width="150"><?php echo $this->lists['shMetaManagementActivated']; ?></td>
    <td><?php echo JHTML::_('tooltip',JText::_('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED') ); ?></td>
  </tr>

  <!-- shumisha 2007-07-01 Remove Joomla Generator tag  -->
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200"><?php echo JText::_('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR'); ?></td>
    <td width="150"><?php echo $this->lists['shRemoveGeneratorTag']; ?></td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR') ); ?></td>
  </tr>

  <!-- shumisha 2007-07-01 Put <h1>tags around content titles -->
  <?php
  
  /*
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_PUT_H1_TAG'),
  JText::_('COM_SH404SEF_TT_PUT_H1_TAG'),
  $this->lists['shPutH1Tags'] );
  */

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MULTIPLE_H1_TO_H2'),
  JText::_('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2'),
  $this->lists['shMultipleH1ToH2'] );
  /*
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE'),
  JText::_('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE'),
  $this->lists['shInsertReadMorePageTitle'] );
  */
  // V 1.3.1
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE'),
  JText::_('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE'),
  $this->lists['shInsertOutboundLinksImage'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_OUTBOUND_LINKS_IMAGE'),
  JText::_('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE'),
  $this->lists['shImageForOutboundLinks'] );

  ?></table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_PAGE_TITLE_TITLE'), 'pagetitle' );

  // params for Page title configuration  -->
  ?><table class="adminlist"><tr><?php

  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_PAGE_TITLE_SEPARATOR'),
  JText::_('COM_SH404SEF_TT_PAGE_TITLE_SEPARATOR'),
                'pageTitleSeparator',
  $this->sefConfig->pageTitleSeparator, 5, 15 );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_PREPEND_TO_PAGE_TITLE'),
  JText::_('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE'),
                'prependToPageTitle',
  $this->sefConfig->prependToPageTitle, 60, 250 );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_APPEND_TO_PAGE_TITLE'),
  JText::_('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE'),
                'appendToPageTitle',
  $this->sefConfig->appendToPageTitle, 60, 250 );

  
  ?></table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_CONTENT_TITLE_TITLE'), 'contenttitle' );

  // params for content title configuration  -->
  ?><table class="adminlist"><tr><?php
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CONTENT_TITLE_USE_ALIAS'),
  JText::_('COM_SH404SEF_TT_CONTENT_TITLE_USE_ALIAS'),
  $this->lists['ContentTitleUseAlias'] );

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CONTENT_TITLE_INCLUDE_CAT'),
  JText::_('COM_SH404SEF_TT_CONTENT_TITLE_INCLUDE_CAT'),
  $this->lists['contentTitleIncludeCat'] );
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CONTENT_TITLE_USE_CAT_ALIAS'),
  JText::_('COM_SH404SEF_TT_CONTENT_TITLE_USE_CAT_ALIAS'),
  $this->lists['ContentTitleUseCatAlias'] );

  ?></table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_MOBILE_CONFIG'), 'mobileconfig' );

  // params for mobile template configuration  -->
  ?><table class="adminlist"><tr><?php
  
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_MOBILE_SWITCH_ENABLED'),
  JText::_('COM_SH404SEF_TT_MOBILE_SWITCH_ENABLED'),
  $this->lists['mobile_switch_enabled'] );
  
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_MOBILE_SWITCH_TEMPLATE'),
  JText::_('COM_SH404SEF_TT_MOBILE_SWITCH_TEMPLATE'),
                'mobile_template',
  $this->lists['mobile_template'], 30, 30 );
  
  ?></table>
    
  <?php
    echo $pane->endPanel(); 
    echo $pane->endPane(); 
  ?>
  
  <!-- end of configuration html -->

    <input type="hidden" name="c" value="config" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="layout" value="seo" />
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
