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
//    This file generates the "simple" display for each individual video.
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
//////
*}

<div style="clear:both;text-align:left;">
  <div style="float:left;padding: 0 5px 5px 0;">{$data->thumbnail}</div>
  <div style="float:right;">{$data->rating}</div>
  {$data->title}
</div>
<div style="clear:both;text-align:left;"></div>
