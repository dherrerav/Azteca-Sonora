{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

      <div style="float:right;text-align:right;padding:5px;">{include file="channel_navigation_selects.tpl"}</div>
{if $channelExists}
	<div class="standard">
	<h2>{$channelTitle} {$channelData->editchannel}</h2>
	<div class="padding">
	<div style="float:right;width:200px;padding:5px;">
	{$smarty.const._HWDVIDS_CHANNELVIEWS}: {$channelData->views}<br />
	{$smarty.const._HWDVIDS_TOTALUPLOADS}: {$channelData->uploads}<br />
	{$smarty.const._HWDVIDS_JOINED}: {$channelData->registerDate}<br />
	{$smarty.const._HWDVIDS_LASTVISIT}: {$channelData->lastvisitDate}<br />
	{$smarty.const._HWDVIDS_SUBCRIBERS}: {$channelData->subscribers}<br />
	</div>
	<div style="float:left;padding:0 5px 5px 0;"><center>{if $displayChannelThumbnail}<img src="{$channelData->thumbnail}" /><br />{/if}{$channelData->subscribe}</center></div>
	<p>{$channelData->channel_description}</p>

	<div style="clear:both;"></div>
	</div>
	</div>
{else}
	<div style="clear:both;"></div>
{/if}
    
<div class="sic-container">
  
  <div class="sic-right">

    <div class="standard">
      <h2>{$smarty.const._HWDVIDS_FAVOURITEVIDEOS}</h2>
      <div class="scoller">
      <div class="list">
        <div class="box">
          {foreach name=outer item=data from=$list_favourites}
	  {include file="video_list_small.tpl"}
	  <div style="clear:both;"></div>
          {/foreach}
        </div>
      </div>  
      </div>
    </div>

    <div class="standard">
      <h2>{$smarty.const._HWDVIDS_RECENTLYVIEWED}</h2>
      <div class="scoller">
      <div class="list">
        <div class="box">
          {foreach name=outer item=data from=$list_recentlyviewed}
	  {include file="video_list_small.tpl"}
	  <div style="clear:both;"></div>
          {/foreach}
        </div>
      </div>  
      </div>
    </div>
  
  </div>

  <div class="sic-center">

    <div class="standard">
      <h2>{$title}</h2>

	{if $print_list}
		{if $type eq "videos"}
			{foreach name=outer item=data from=$list}
				<div class="videoBox">
					{include file="video_list_full.tpl"}
				</div>
				{if $smarty.foreach.outer.last}
					<div style="clear:both;"></div>
				{elseif $smarty.foreach.outer.index % $vpr-($vpr-1) == 0}
					<div style="clear:both;"></div>
				{/if}
			{/foreach}
		{elseif $type eq "groups"}
			{foreach name=outer item=data from=$list}
				<div class="groupBox">
					{include file="group_list.tpl"}
				</div>
				{if $smarty.foreach.outer.last}
					<div style="clear:both;"></div>
				{elseif $smarty.foreach.outer.index % $gpr-($gpr-1) == 0}
					<div style="clear:both;"></div>
				{/if}
			{/foreach}
		{elseif $type eq "playlists"}
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
		{/if}
		{$pageNavigation}
	{else}
		<div class="padding">{$noItems}</div>
	{/if}
      
    </div>
    
  </div>

</div>

<div style="clear:both;"></div>

{include file='footer.tpl'}



