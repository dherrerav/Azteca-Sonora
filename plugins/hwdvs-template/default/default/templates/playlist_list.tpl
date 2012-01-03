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
  <div class="listtitle">{$data->playlisttitle} ({$data->totalvideos} Videos) {$data->editplaylist} {$data->deleteplaylist}</div>
  <div class="listdesc">{$data->playlistdescription}</div>
  <div style="clear:both;"></div>
</div>