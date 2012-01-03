<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_headers.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

    <table class="adminlist">

      <thead>
        <tr>
          <td width="18%">
            <?php
               $allFilters = $this->options['showFilters'] == 'yes';
               echo '<a href="javascript: void(0);" onclick="javascript: shSetupAnalytics({forced:1' . ($allFilters ? '' : ',showFilters:\'no\'') . '});" > ['
               . JText::_('COM_SH404SEF_CHECK_ANALYTICS').']</a>';
               echo '&nbsp;';
               echo empty($this->analytics->status) ? JText::_('COM_SH404SEF_ERROR_CHECKING_ANALYTICS') : $this->escape( $this->analytics->statusMessage);
            ?>
          </td>
        </tr>
      </thead>
      <?php 
      if(!empty($this->analytics->status)) :

        echo $this->loadTemplate( 'filters'); 
      
      endif;
      ?>
    
    </table>
 	
	

	