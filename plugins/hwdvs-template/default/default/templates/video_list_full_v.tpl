{* 
//////
//    @version 2.1.3 Build 21301 Alpha [ Plimmerton ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//////
//    hwdVideoShare Template System:::This template system uses the Smarty Template Engine. 
//    For full documentation, including syntax usage please refer to http://www.smarty.net 
//    or our website at http://www.hwdmediashare.co.uk   
//////
//    This file generates the display for each individual video.
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- $thumbwidth..........The width of the thumbnail image
//    -- $data->k.............The css identifier                          
//    -- $data->thumbnail.....The video thumbnail image                    
//    -- $data->avatar........The avatar of the uploader               
//    -- $data->title.........The video title
//    -- $data->editvideo.....The edit video button
//    -- $data->deletevideo...The delete video button
//    -- $data->category......The video category
//    -- $data->description...The video description
//    -- $data->rating........The current rating of the video
//    -- $data->views.........The total number of views
//    -- $data->duration......The duration of the video
//    -- $data->uploader......The original uploader
//    -- $data->upload_date...The date uploaded
//////
*}

<div class="box">
<div style="width:{$thumbwidth}px;">{$data->thumbnail}</div>
<div >

<div class="listtitle">{$data->title} {$data->editvideo} {$data->deletevideo} {$data->publishvideo}</div>
<div class="listviews">{$data->views} {$smarty.const._HWDVIDS_INFO_VIEWS}</div>
<div class="listcat">{$smarty.const._HWDVIDS_INFO_CATEGORY}: {$data->category}</div>
<div class="listrating">{$data->rating}</div>
<div class="listuploader">{$data->uploader}</div>
<!--<div class="listdesc">{$data->description}</div>-->
<!--<div class="listduration">{$smarty.const._HWDVIDS_INFO_DURATION}: {$data->duration}</div>-->
<!--<div class="listduration">{$smarty.const._HWDVIDS_DETAILS_VDATE}: {$data->upload_date}</div>-->
<!--{$data->avatar}-->
     
</div>
<div style="clear:both;"></div>
</div>
