<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_global.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<div class="width-100">
<fieldset class="adminform">
  <legend><?php echo JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_DATA'); ?></legend>
        
    <table class="admintable" cellspacing="1" width="100%">
      <tbody>
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITS') . '::' . JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITS_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_DATA_VISITS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape( $this->analytics->analyticsData->global->visits); ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS') . '::' . JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo  JText::_( 'COM_SH404SEF_ANALYTICS_DATA_VISITORS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape($this->analytics->analyticsData->global->visitors); ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS') . '::' . JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_PAGEVIEWS_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape($this->analytics->analyticsData->global->pageviews); ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT') . '::' . JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->pagesPerVisit)); ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE') . '::' . JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->bounceRate * 100)) . ' %'; ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE') . '::' . JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->avgTimeOnSite)) . ' s.'; ?> 
          </td>
        </tr>
        
        <?php  $title = JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS') . '::' . JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS_DESC'); ?>
        <tr class="hasAnalyticsTip" title="<?php echo $title;?>">  
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->newVisitsPerCent*100)) . ' %'; ?> 
          </td>
        </tr>
        
      </tbody>
    </table>      

</fieldset>        
</div>