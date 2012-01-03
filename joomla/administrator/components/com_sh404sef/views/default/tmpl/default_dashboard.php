<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_dashboard.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<div id="sh-progress-analyticsprogress"></div>

<div id="analyticscontent_headers"></div>

<table width="100%" class="qcontrol" id="sh404sef-analytics-wrapper">

    <tr>
      <td  width="100%" colspan="3" style="text-align: center;vertical-align: top;">
        <div id="analyticscontent_visits"></div>
      </td>  
    </tr>  
    
    <tr>
    
       <td width="50%" style="vertical-align: top;">
          <div id="analyticscontent_sources"></div>
       </td>
       
       <td width="50%" height="100%" style="vertical-align: top;">
         <div id="analyticscontent_global"></div>
       </td>
       
    </tr>

    <tr>
    
       <td colspan="2" style="vertical-align: top;">
         <div id="analyticscontent_perf"></div>
       </td>
       
    </tr>
    
</table>
  
<table width="100%">    
    
    <tr>
       <td style="vertical-align: top;">
         <div id="analyticscontent_top5urls"></div>
       </td>
    </tr>
    <tr>   
       <td style="vertical-align: top;">
         <div id="analyticscontent_top5referrers"></div>
       </td>
       
    </tr>
    
</table> 
	

	