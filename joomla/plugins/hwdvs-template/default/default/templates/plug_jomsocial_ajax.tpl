{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div class="standard">
    
    <div class="padding" style="float:right;">{$videoplayer->deletevideo}&nbsp;{$videoplayer->editvideo}&nbsp{$videoplayer->publishvideo}</div>
    
    <h2>{$videoplayer->title}</h2>
    
    <div class="padding">
    
        <div class="padding" style="float:right;">
            <a href="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&task=viewvideo&Itemid={$Itemid}&video_id={$videoplayer->id}" class="swap">{$smarty.const._HWDVIDS_GTVP}</a> &raquo;
        </div>
        <div style="clear:both;"></div>
        
        <center>{$videoplayer->player}<center>
    
    </div>
    
</div>

<div class="standard">
    <div class="padding" style="float:right;">
        <div>
            {$videoplayer->ratingsystem}
        </div>
    </div>
    <div class="padding" style="float:left;">
        <div>
            {$smarty.const._HWDVIDS_TITLE_PERMALINK}<br /><input type="text" value="{$videoplayer->videourl}" />
        </div>
    </div>
    <div class="padding" style="float:left;">
        <div>
            {$smarty.const._HWDVIDS_INFO_VIDEMBEDCODE}<br /><input type="text" value="{$videoplayer->embedcode}" />
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<div class="standard" style="text-align:left;">{$videoplayer->socialbmlinks}</div>
<div class="standard" style="text-align:left;">{$videoplayer->comments}</div>
