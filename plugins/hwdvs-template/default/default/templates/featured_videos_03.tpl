{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="standard">
	<h2>{$featured_video_details->title} {$featured_video_details->editvideo} {$featured_video_details->deletevideo} {$featured_video_details->publishvideo}</h2>
	<div class="padding">
		<center>
			{$featured_video_player}
		</center>
	</div>

	<div class="box">

{literal}
<script type="text/javascript">

{/literal}{if $showMoreButton}{literal}
var dataTweenerFunction  = function() 
{
	var videoDataHeight = $('videoDataInternal').getSize().scrollSize.y+20;
        
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData', 'opacity').set(0);
        new Fx.Style('addData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData', 'opacity').set(0);
        new Fx.Style('embedData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData', 'opacity').set(0);
        new Fx.Style('saveData', 'height').set(0);
        {/literal}{/if}{literal}
        new Fx.Style('shareData', 'opacity').set(0);
        new Fx.Style('shareData', 'height').set(0);
        
        new Fx.Style('videoData', 'opacity', {duration:500}).start(1);
        new Fx.Style('videoData', 'height').set(videoDataHeight);
}

{/literal}{/if}{literal}
{/literal}{if $showAddButton}{literal}
var addTweenerFunction  = function() 
{
	var addDataHeight = $('addDataInternal').getSize().scrollSize.y+20;
        
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData', 'opacity').set(0);
        new Fx.Style('videoData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData', 'opacity').set(0);
        new Fx.Style('embedData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData', 'opacity').set(0);
        new Fx.Style('saveData', 'height').set(0);
        {/literal}{/if}{literal}
        new Fx.Style('shareData', 'opacity').set(0);
        new Fx.Style('shareData', 'height').set(0);
                
        new Fx.Style('addData', 'opacity', {duration:500}).start(1);
        new Fx.Style('addData', 'height').set(addDataHeight);
}

{/literal}{/if}{literal}
{/literal}{if $showEmbedButton}{literal}
var embedTweenerFunction  = function() 
{
	var embedDataHeight = $('embedDataInternal').getSize().scrollSize.y+20;
        
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData', 'opacity').set(0);
        new Fx.Style('videoData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData', 'opacity').set(0);
        new Fx.Style('addData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData', 'opacity').set(0);
        new Fx.Style('saveData', 'height').set(0);
        {/literal}{/if}{literal}
        new Fx.Style('shareData', 'opacity').set(0);
        new Fx.Style('shareData', 'height').set(0);
                   
        new Fx.Style('embedData', 'opacity', {duration:500}).start(1);
        new Fx.Style('embedData', 'height').set(embedDataHeight);
}

{/literal}{/if}{literal}
{/literal}{if $showDownloadButton}{literal}
var saveTweenerFunction  = function() 
{
	var saveDataHeight = $('saveDataInternal').getSize().scrollSize.y+20;
        
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData', 'opacity').set(0);
        new Fx.Style('videoData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData', 'opacity').set(0);
        new Fx.Style('addData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData', 'opacity').set(0);
        new Fx.Style('embedData', 'height').set(0);
        {/literal}{/if}{literal}
        new Fx.Style('shareData', 'opacity').set(0);
        new Fx.Style('shareData', 'height').set(0);
        
        new Fx.Style('saveData', 'opacity', {duration:500}).start(1);
        new Fx.Style('saveData', 'height').set(saveDataHeight);
}

{/literal}{/if}{literal}
{/literal}{if $showShareButton}{literal}
var shareTweenerFunction  = function() 
{
	var shareDataHeight = $('shareDataInternal').getSize().scrollSize.y+20;
        
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData', 'opacity').set(0);
        new Fx.Style('videoData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData', 'opacity').set(0);
        new Fx.Style('addData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData', 'opacity').set(0);
        new Fx.Style('embedData', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData', 'opacity').set(0);
        new Fx.Style('saveData', 'height').set(0);
        {/literal}{/if}{literal}
                                 
        new Fx.Style('shareData', 'opacity', {duration:500}).start(1);
        new Fx.Style('shareData', 'height').set(shareDataHeight);
}
{/literal}{/if}{literal}

{/literal}{if $showMoreButton}{literal}window.addEvent('domready', function() { $('button_more').addEvent('click', dataTweenerFunction); });{/literal}{/if}{literal}
{/literal}{if $showAddButton}{literal}window.addEvent('domready', function() { $('button_add').addEvent('click', addTweenerFunction); });{/literal}{/if}{literal}
{/literal}{if $showEmbedButton}{literal}window.addEvent('domready', function() { $('button_embed').addEvent('click', embedTweenerFunction); });{/literal}{/if}{literal}
{/literal}{if $showDownloadButton}{literal}window.addEvent('domready', function() { $('button_save').addEvent('click', saveTweenerFunction); });{/literal}{/if}{literal}
{/literal}{if $showShareButton}{literal}window.addEvent('domready', function() { $('button_share').addEvent('click', shareTweenerFunction); });{/literal}{/if}{literal}

</script>
{/literal}       
        
	{if $showMoreButton}<div style="float:right;"><img src="{$URL_HWDVS_IMAGES}button_more.png" id="button_more" /></div>{/if}
	{if $print_nextprev}
		<div style="float:right;padding:5px;">{$featured_video_details->nextprev}</div>
	{/if}
        <div>{$featured_video_details->uploader} &raquo; {$featured_video_details->upload_date}</div>
        {if $print_description}<div>{$featured_video_details->description_truncated}</div>{/if}
              
        <div style="clear:right;"></div>
	{$featured_video_details->ratingsystem}
        <div style="clear:right;"></div>

        {if $showAddButton}<img src="{$URL_HWDVS_IMAGES}button_add.png" id="button_add" />{/if}
        {if $showEmbedButton}<img src="{$URL_HWDVS_IMAGES}button_embed.png" id="button_embed" />{/if}
        {if $showDownloadButton}<img src="{$URL_HWDVS_IMAGES}button_save.png" id="button_save" />{/if}
	{$featured_video_details->switchquality}
        {if $showShareButton}<img src="{$URL_HWDVS_IMAGES}button_share.png" id="button_share" />{/if}
                      
        <div id="videoData" style="visibility:hidden;height:0;">
		<div id="videoDataInternal">
			<div>{$smarty.const._HWDVIDS_CATEGORY}: {$featured_video_details->category}</div>       
			{if $print_tags}<div>{$smarty.const._HWDVIDS_TAGS}: {$featured_video_details->tags}</div>{/if}
        		{if $print_description}<div>{$featured_video_details->description}</div>{/if}
		</div>
        </div>
        
        <div id="addData" style="visibility:hidden;height:0;">
		<div id="addDataInternal">
			{if $print_addtogroup}{$featured_video_details->addtogroup}{/if}
			{if $print_addtoplaylist}{$featured_video_details->addtoplaylist}{/if}
		</div>
        </div>
        
	<div id="embedData" style="visibility:hidden;height:0;">
		<div id="embedDataInternal">
			<strong>{$smarty.const._HWDVIDS_INFO_VIDEMBEDCODE}</strong></br />
			<form name="elink"><input type="text" value="{$featured_video_details->embedcode}" width="90%" name="elink" /></form>
		</div>
        </div>

        <div id="saveData" style="visibility:hidden;height:0;">
		<div id="saveDataInternal">
			<div>{$featured_video_details->downloadoriginal}</div>
			<div>{$featured_video_details->vieworiginal}</div>
			<div>{$featured_video_details->downloadflv}</div>
		</div>
        </div>
        
        <div id="shareData" style="visibility:hidden;height:0;">
		<div id="shareDataInternal">
			<div style="padding: 5px 0;">{$featured_video_details->sendToFriend}</div>
          		{if $print_videourl}
			<strong>{$smarty.const._HWDVIDS_TITLE_PERMALINK}</strong></br />
			<form name="vlink"><input type="text" value="{$featured_video_details->videourl}" width="90%" name="vlink" /></form>
          		{/if}
               		<div style="padding:5px 0;">{$featured_video_details->socialbmlinks}</div>
		</div>
        </div>
                
        <div id="add2groupresponse"></div>
        <div id="add2playlistresponse"></div>
        <div style="clear:both;"></div>
        
        <div style="float:right;">{$featured_video_details->avatar}</div>
        {$featured_video_details->favourties}      
        {$featured_video_details->reportmedia}
        <div id="ajaxresponse"></div>

        <div style="clear:both;"></div>
		
	</div>
</div>

{if $print_multiple_featured}
	<div class="standard">
		{foreach name=outer item=data from=$featuredlist}
			{if $smarty.foreach.outer.first}{else}
				<div class="videoBox">
					{include file="video_list_full.tpl"}
				</div>
				{if $smarty.foreach.outer.last}
					<div style="clear:both;"></div>
				{elseif $smarty.foreach.outer.index % $vpr == 0}
					<div style="clear:both;"></div>
				{/if}
			{/if}
		{/foreach}
		<div style="text-align:right;padding:5px;">
			<a href="{$featured_link}" title="{$smarty.const._HWDVIDS_INFO_MOREFEATUREDV}">{$smarty.const._HWDVIDS_INFO_MOREFEATUREDV}</a>
		</div>
	</div>
{/if}

  

