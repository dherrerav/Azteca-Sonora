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
//    This file generates the display for the content mambot.
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- $thumbwidth..........The width of the thumbnail images
//    -- $videoplayer.........The video player containing the inserted video   
//    -- $ratingsystem........The rating system for the video   
//    -- $favouritebutton.....The add/remove from favourites button   
//    -- $message.............Contains any impotant error messages or notices (generally empty)   
//    -- $data->k.............The css identifier
//    -- $data->thumbnail.....The video thumbnail   
//    -- $data->avatar........The uploader avatar  
//    -- $data->title.........The video title  
//    -- $data->editvideo.....The edit video button  
//    -- $data->deletevideo...The delete video button 
//    -- $data->category......The video category
//    -- $data->description...The video description
//    -- $data->rating........The current video rating
//    -- $data->views.........The number fo views for the video
//    -- $data->duration......The video duration
//    -- $data->uploader......The user details of the original uploader
//////
*}

<div id="hwdvids">

<div class="sic-container">
  
  <div class="sic-right">

    <div class="standard">

      <div style="float:right;"><div class="padding">{$data->avatar}</div></div>
      {if $print_videourl}
          <div class="padding"><form name="vlink"><div>{$smarty.const._HWDVIDS_TITLE_PERMALINK}</div><input type="text" value="{$data->videourl}" name="vlink" /></form></div>
      {/if}
      {if $print_embedcode}
          <div class="padding"><form name="elink"><div>{$smarty.const._HWDVIDS_INFO_VIDEMBEDCODE}</div><input type="text" value="{$data->embedcode}" name="elink" /></form></div>
      {/if}
      <div style="clear:both;"></div>

    </div>

    <div class="standard"><div class="padding">{$data->ratingsystem}</div></div>

    <div class="standard">
      <div class="padding">
        <div>{$data->thumbnail}</div>
        <div>{$smarty.const._HWDVIDS_INFO_CATEGORY}: {$data->category}</div>
        <div class="listdesc">{$data->description}</div>
      </div>    
    </div>
    
  </div>
  
  <div class="sic-center">
  
    <div class="standard">
      <h2>{$data->title} {$data->editvideo} {$data->deletevideo}</h2>
      <div class="padding"><center>{$data->player}</center></div>
    </div>
    
  </div>

</div>
<div style="clear:both;"></div>
</div>

