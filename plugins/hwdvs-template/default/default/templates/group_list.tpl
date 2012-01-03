{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="box">
  <div class="listThumbnail" style="float:left;">{$data->thumbnail}</div>
  <div class="avatar">{$data->avatar}</div>
  <div style="clear:right;float:right;text-align:right;">{$data->groupmembership}</div>
  <div style="clear:right;float:right;text-align:right;">{$data->reportgroup}</div>
  <div class="listtitle">{$data->grouptitle} {$data->editgroup} {$data->deletegroup}</div>
  <div class="listdesc">{$data->groupdescription}</div>
  <div style="clear:left;">
    <div class="listgroupdetails">
        {$smarty.const._HWDVIDS_INFO_TOTMEM}: {$data->totalmembers} |
        {$smarty.const._HWDVIDS_INFO_TOTVID}: {$data->totalvideos} |
        {$data->administrator}
    </div>
  </div>
<div style="clear:both;"></div>
</div>