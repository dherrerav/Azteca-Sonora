{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="standard">
	<h2>{$smarty.const._HWDVIDS_FEATURED_VIDEOS} {$featured_video_details->editvideo} {$featured_video_details->deletevideo} {$featured_video_details->publishvideo}</h2>
	<div class="padding">
		<center>
			{$featured_video_player}
		</center>
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
