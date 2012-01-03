{* 
//////
//    @version 2.1.2 Build 21202 Alpha [ Shannon ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//////
//    hwdVideoShare Template System:::This template system uses the Smarty Template Engine. 
//    For full documentation, including syntax usage please refer to http://www.smarty.net 
//    or our website at http://www.hwdmediashare.co.uk   
//////
//    This file generates the display for the upload page (ADVANCED PERL METHOD). Use caution when editing, because you might
//    accidentally prevent the upload tool from working correctly.
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- TO BE ADDED
//////
*}

{include file='header.tpl'}

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_UPLOAD2}</h2>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td>
        <div><b>{$smarty.const._HWDVIDS_INFO_LIMUPLD} {$maximum_upload}MB</b></div>
        <div>{$smarty.const._HWDVIDS_INFO_ALLUPLD} {$allowed_formats}</div>
        <div align="center">
          <div class="ubr_alert" id="ubr_alert"></div>
          <div id="progress_bar" style="display:none;">
            <div class="bar1" id="upload_status_wrap">
              <div class="bar2" id="upload_status"></div>
            </div>
            {$uu_progress_info}
          </div>
          {$uu_extra_code}
          <br />
          {$uu_upload_form}
        </div> 
      </td>
    </tr>
  </table>
</div>

{include file='footer.tpl'}



