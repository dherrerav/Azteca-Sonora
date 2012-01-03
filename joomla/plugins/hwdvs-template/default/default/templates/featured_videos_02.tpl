{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $print_multiple_featured}
	<div class="standard">
		<h2>{$smarty.const._HWDVIDS_FEATURED_VIDEOS}</h2>
			{foreach name=outer item=data from=$featuredlist}
				<div class="videoBox">
					{include file="video_list_full.tpl"}
				</div>
				{if $smarty.foreach.outer.last}
					<div style="clear:both;"></div>
				{elseif $smarty.foreach.outer.index % $vpr-($vpr-1) == 0}
					<div style="clear:both;"></div>
				{/if}
			{/foreach}
		<div style="text-align:right;padding:5px;">
			<a href="{$featured_link}" title="{$smarty.const._HWDVIDS_INFO_MOREFEATUREDV}">{$smarty.const._HWDVIDS_INFO_MOREFEATUREDV}</a>
		</div>
	</div>
{/if}