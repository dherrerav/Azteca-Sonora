<?php

/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  
<div id="cpanel">

  <div id="left" class="cp-block">
  
    <?php 
    
      $pane = &JPane::getInstance('Tabs', array('allowAllClose' => true, 'useCookie' => true));
    
      // prepare Analytics output
      $sefConfig = & Sh404sefFactory::getConfig();
      $analyticsAvailable = $sefConfig->analyticsReportsEnabled && !empty( $sefConfig->analyticsUser) && !empty( $sefConfig->analyticsPassword);

      $analyticsOutput = $pane->startPanel( JText::_('COM_SH404SEF_ANALYTICS'), 'analytics' )
      . $this->loadTemplate( 'dashboard')
      . $pane->endPanel();
      
      // start pane
      echo $pane->startPane("left-pane");
      
      // if enabled, we display analytics panel, in first place
      if ($analyticsAvailable ) {
        echo $analyticsOutput;
      }
      
      // management icons
      echo $pane->startPanel( JText::_('COM_SH404SEF_MANAGEMENT'), 'management' );
      
    ?>
    
        <fieldset class="adminform" id="sh404sef-management-area">
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'urlmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'aliasesmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'pageidmanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( '404manager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'metamanager'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'analytics'); ?>
        </div>
        <div class="iconothers">
          <?php echo Sh404sefHelperHtml::getCPImage( 'doc'); ?>
        </div>
        </fieldset>
        
    <?php 
      //</div>
      // <div class="cp-icons-others">
      echo $pane->endPanel();
      
      // configuration icons
      echo $pane->startPanel( JText::_('COM_SH404SEF_CONFIGURATION'), 'config' );
    
     ?>
     
        <fieldset class="adminform">
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_base'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_ext'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_seo'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_analytics'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_sec'); ?>
        </div>
        <div class="iconconfig">
          <?php echo Sh404sefHelperHtml::getCPImage( 'config_error_page'); ?>
        </div>
        </fieldset>
        
    <?php 
    echo $pane->endPanel();

    // if analytics data is not available, or not properly setup
    // the tab is still created, but at last position
    // if reports are set to not being displayed however
    // we don't display at all
    if (!$analyticsAvailable && $sefConfig->analyticsReportsEnabled) {
      echo $analyticsOutput;
    }

    echo $pane->endPane();
    //</div>
    ?>
      
  </div>
  
  <div id="right" class="cp-block">
  
    <div id="right-bottom" class="cp-inner-block">
    
    <?php 
      $pane = &JPane::getInstance('Tabs', array('allowAllClose' => true));
      echo $pane->startPane("content-pane");
      
      echo $pane->startPanel( JText::_('COM_SH404SEF_QUICK_START'), 'qcontrol' );
      
    ?>
      <div id="qcontrolcontent" class="qcontrol">
        <div class="sh-ajax-loading">&nbsp;</div>
      </div>
      
    <?php 
      echo $pane->endPanel();
      
      // security stats
      echo $pane->startPanel( JText::_('COM_SH404SEF_SEC_STATS_TITLE'), 'security' );
    
     ?>
   
    <div id="secstatscontent" class="secstats">

    </div>
      
    <?php
    echo $pane->endPanel();
    
      $tabTitle = $this->updates->shouldUpdate ? '<b><font color="red">(!) ' . JText::_('COM_SH404SEF_VERSION_INFO') . '</font></b>' : JText::_('COM_SH404SEF_VERSION_INFO');
      
      echo $pane->startPanel( $tabTitle, 'infos' );
      
    ?>
    <table class="adminlist">
      <thead>
        <tr>
          <td width="130"><?php echo JText::_('COM_SH404SEF_INSTALLED_VERS') ;?></td>
          <td><?php if (!empty($this->sefConfig)) echo $this->sefConfig->version;
          else echo 'Please review and save configuration first'; ?></td>
        </tr>
      </thead>
      <tr>
        <td><?php echo JText::_('COM_SH404SEF_COPYRIGHT') ;?></td>
        <td><a href="http://anything-digital.com/sh404sef/seo-analytics-and-security-for-joomla.html">&copy; 2006-<?php echo date('Y');?>
        Yannick Gaultier - Anything Digital</a></td>
      </tr>
      <tr>
        <td><?php echo JText::_('COM_SH404SEF_LICENSE') ;?></td>
        <td><a
          href="http://anything-digital.com/tos.html"
          target="_blank">see License &amp; terms</a></td>
      </tr>
    </table>

    <div id="updatescontent" class="updates">

    </div>
    
      <?php 
      echo $pane->endPanel();
        
      // configuration and global stats
      $output = '';
      foreach ($this->sefConfig->fileAccessStatus as $file => $access) {
        if ($access == JText::_('COM_SH404SEF_UNWRITEABLE')) {
          $output .= '<tr><td>'.$file.'</td><td colspan="2">'.JText::_('COM_SH404SEF_UNWRITEABLE').'</td></tr>';
        }
      }
      if (!empty($output)) {
        $output =  '<th class="cpanel" colspan="3" >'.JText::_('COM_SH404SEF_NOACCESS').'</th>' . $output;
      }
      
      // ad red on tab title if something special
      if (!empty($output) || $this->sefConfig->debugToLogFile) {
        $tabTitle = '<b><font color="red">(!) ' . JText::_('COM_SH404SEF_ACCESS_URLS_STATS') . '</font></b>';
      } else {
        $tabTitle = JText::_('COM_SH404SEF_ACCESS_URLS_STATS');
      }
      
      echo $pane->startPanel( $tabTitle, 'stats' );
    ?>
    <table class="adminform" width="100%">
      <tr>
      <?php 
        if (!empty($output)) {
          echo $output;
        }
        if ($this->sefConfig->debugToLogFile) {
          echo '<tr><th class="cpanel" colspan="3" >DEBUG to log file : ACTIVATED <small>at '
          .date('Y-m-d H:i:s', $this->sefConfig->debugStartedAt).'</small></th></tr>';
        }
      ?>
      </tr>
    </table> 
     
    <table class="adminform" width="100%">
      <tr>
        <th class="cpanel" colspan="8"> <?php echo JText::_('COM_SH404SEF_URLS_STATS'); ?></th>
      </tr>  
      <tr>
        <td width="8%"><?php echo JText::_('COM_SH404SEF_REDIR_TOTAL').':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->sefCount+$this->Count404+$this->customCount; ?>
        </td>
        <td width="8%"><?php echo JText::_('COM_SH404SEF_REDIR_SEF').':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->sefCount; ?>
        </td>
        <td width="8%"><?php echo JText::_('COM_SH404SEF_REDIR_404').':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->Count404; ?>
        </td>
        <td width="8%"><?php echo JText::_('COM_SH404SEF_REDIR_CUSTOM').':'; ?></td>
        <td align="left" width="12%" style="font-weight: bold"><?php echo $this->customCount; ?>
        </td>
      </tr>
    </table>    
    <?php 
    echo $pane->endPanel();
    
    echo $pane->endPane();
    ?>
     
     </div>
  </div>

</div>
