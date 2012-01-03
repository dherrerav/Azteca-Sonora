<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sec.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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
    echo $pane->startPanel( JText::_('COM_SH404SEF_SECURITY_TITLE'), 'Title-Sec' ); ?>
    
<table class="adminlist">
  
  <!-- shumisha 2007-09-15 Activate Security  -->
  <?php
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_ACTIVATE_SECURITY'),
  JText::_('COM_SH404SEF_TT_ACTIVATE_SECURITY'),
  $this->lists['shSecEnableSecurity'] );

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_LOG_ATTACKS'),
  JText::_('COM_SH404SEF_TT_LOG_ATTACKS'),
  $this->lists['shSecLogAttacks'] );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_MONTHS_TO_KEEP_LOGS'),
  JText::_('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS'),
              'monthsToKeepLogs',
  $this->sefConfig->monthsToKeepLogs, 5, 2 );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CHECK_POST_DATA'),
  JText::_('COM_SH404SEF_TT_CHECK_POST_DATA'),
  $this->lists['shSecCheckPOSTData'] ); ?>
    
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_ONLY_NUM_VARS'); ?></td>
    <td width="150"><textarea name="shSecOnlyNumVars" cols="20" rows="5"><?php echo $this->lists['shSecOnlyNumVars']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_ONLY_NUM_VARS') ); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_ONLY_ALPHA_NUM_VARS'); ?></td>
    <td width="150"><textarea name="shSecAlphaNumVars" cols="20" rows="5"><?php echo $this->lists['shSecAlphaNumVars']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS') ); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_NO_PROTOCOL_VARS'); ?></td>
    <td width="150"><textarea name="shSecNoProtocolVars" cols="20"
      rows="5"><?php echo $this->lists['shSecNoProtocolVars']; ?></textarea></td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_NO_PROTOCOL_VARS') ); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_IP_WHITE_LIST'); ?></td>
    <td width="150"><textarea name="ipWhiteList" cols="20" rows="5"><?php echo $this->lists['ipWhiteList']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_IP_WHITE_LIST') );?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_IP_BLACK_LIST'); ?></td>
    <td width="150"><textarea name="ipBlackList" cols="20" rows="5"><?php echo $this->lists['ipBlackList']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_IP_BLACK_LIST') ); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_UAGENT_WHITE_LIST'); ?></td>
    <td width="150"><textarea name="uAgentWhiteList" cols="60" rows="5"><?php echo $this->lists['uAgentWhiteList']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_UAGENT_WHITE_LIST')); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_UAGENT_BLACK_LIST'); ?></td>
    <td width="150"><textarea name="uAgentBlackList" cols="60" rows="5"><?php echo $this->lists['uAgentBlackList']; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_UAGENT_BLACK_LIST') );?></td>
  </tr>
  
  </table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_ANTIFLOOD_TITLE'), 'antiflood' );

  // params for Page title configuration  -->
  ?><table class="adminlist"><?php

  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_ACTIVATE_ANTIFLOOD'),
  JText::_('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD'),
  $this->lists['shSecActivateAntiFlood'] );
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST'),
  JText::_('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST'),
  $this->lists['shSecAntiFloodOnlyOnPOST'] );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_ANTIFLOOD_PERIOD'),
  JText::_('COM_SH404SEF_TT_ANTIFLOOD_PERIOD'),
                'shSecAntiFloodPeriod',
  $this->sefConfig->shSecAntiFloodPeriod, 5, 5 );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_ANTIFLOOD_COUNT'),
  JText::_('COM_SH404SEF_TT_ANTIFLOOD_COUNT'),
                'shSecAntiFloodCount',
  $this->sefConfig->shSecAntiFloodCount, 5, 5 ); 
  
  ?></table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_HONEYPOT_TITLE'), 'honeypot' );

  // params for Page title configuration  -->
  ?><table class="adminlist">

  <tr>
    <td colspan="3" align="left">
    <div
      style="border: 1px solid #1D7D9F; margin: 5px; padding: 5px; background-color: #EFFBFF">
      <?php echo JText::_('COM_SH404SEF_CONF_HONEYPOT_DOC'); ?></div>
    </td>
  </tr>
  <?php
  $x = 1;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_CHECK_HONEY_POT'),
  JText::_('COM_SH404SEF_TT_CHECK_HONEY_POT'),
  $this->lists['shSecCheckHoneyPot'] );
  $x++;
  Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_HONEYPOT_KEY'),
  JText::_('COM_SH404SEF_TT_HONEYPOT_KEY'),
                'shSecHoneyPotKey',
  $this->sefConfig->shSecHoneyPotKey, 30, 30 ); ?>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT'); ?></td>
    <td width="150"><textarea name="shSecEntranceText"
      id="shSecEntranceText" cols="60" rows="5"><?php echo $this->sefConfig->shSecEntranceText; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT') ); ?></td>
  </tr>
  <tr <?php $x++; echo ( ( $x % 2 ) ? '' : ' class="row1"' ); ?>>
    <td width="200" valign="top"><?php echo JText::_('COM_SH404SEF_SMELLYPOT_TEXT'); ?></td>
    <td width="150"><textarea name="shSecSmellyPotText"
      id="shSecSmellyPotText" cols="60" rows="5"><?php echo $this->sefConfig->shSecSmellyPotText; ?></textarea>
    </td>
    <td><?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_SMELLYPOT_TEXT') ); ?></td>
  </tr>
  
  </table><?php
  // end of params for content title configuration  -->
  
    echo $pane->endPanel();
    echo $pane->endPane(); 
  ?>
  
  <!-- end of configuration html -->

    <input type="hidden" name="c" value="config" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="layout" value="sec" />
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