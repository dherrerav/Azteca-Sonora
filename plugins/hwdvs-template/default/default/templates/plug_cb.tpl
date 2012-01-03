{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='plug_cb_header.tpl'}

{$hwdvs_community_js}

{if $hwdvids_params.style eq 0}
	{if $print_videolist}
	      {foreach name=outer item=data from=$list}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	{else}
	<div class="padding">{$noitems}</div>
	{/if}
	{$pageNavigation}
{else}
	{if $print_videolist}
	<div id="{$iCID}_frame"><img id="{$iCID}_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="{$iCID}_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	<center>

	  <div id="{$iCID}">

	      <ul id="{$iCID}_content">  
		{foreach name=outer item=data from=$list}
		  <li class="{$iCID}_item">
		    {include file="mod_hwd_vs_list.tpl"}
		  </li>   
		{/foreach}
	       </ul>  

	  </div> 

	</center>
	{else}
	<div class="padding">{$noitems}</div>
	{/if}
{/if}
	
<div id="community_video_player_space"></div>

{include file='plug_cb_footer.tpl'}




