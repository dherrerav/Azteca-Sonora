{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="box">
	<div class="listThumbnail" style="float:left;position:relative;">{$data->thumbnail}</div>
	<div>
		<div><strong>{$data->title}</strong> {$data->editvideo} {$data->deletevideo}</div>
		<div style="font-style:italic;font-size:90%;">{$data->views} {$smarty.const._HWDVIDS_INFO_VIEWS}</div>
     	</div>
	<div style="clear:both;"></div>
</div>