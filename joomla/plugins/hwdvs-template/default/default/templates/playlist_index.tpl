{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

{if $print_featured}
    
    <div class="standard">
      <h2>{$smarty.const._HWDVIDS_FEATVIDEOPLAYLISTS}</h2>

          {foreach name=outer item=data from=$featuredlist}
          <div class="playlistBox">
	  {include file="playlist_list.tpl"}
	  </div>
	  {if $smarty.foreach.outer.last}
	     <div style="clear:both;"></div>
	  {elseif $smarty.foreach.outer.index % $gpr-($gpr-1) == 0}
	     <div style="clear:both;"></div>
	  {/if}
          {/foreach}
      
    <div style="text-align:right;padding:5px;"><a href="{$featured_link}" title="{$smarty.const._HWDVIDS_INFO_MOREFEATUREDG}">{$smarty.const._HWDVIDS_INFO_MOREFEATUREDG}</a></div>
    </div>
{/if}

    <div class="standard">
      <h2>{$smarty.const._HWDVIDS_VIDEOPLAYLISTS}</h2>
      {if $print_grouplist}

          {foreach name=outer item=data from=$list}
          <div class="playlistBox">
	  {include file="playlist_list.tpl"}
	  </div>
	  {if $smarty.foreach.outer.last}
	     <div style="clear:both;"></div>
	  {elseif $smarty.foreach.outer.index % $gpr-($gpr-1) == 0}
	     <div style="clear:both;"></div>
	  {/if}
          {/foreach}
      
      {else}
        <div class="padding">{$smarty.const._HWDVIDS_INFO_NOP}</div>
      {/if}
      {$pageNavigation}
    </div>
    
{include file='footer.tpl'}
