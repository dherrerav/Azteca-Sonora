{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

{if $print_mostviewed or $print_mostviewed or $print_mostpopular}
<div class="sic-container">
  
  <div class="sic-right">

    {if $print_mostviewed}
    <div class="standard">
      <h2>{$title_mostviewed}</h2>
      <div class="scoller">
      <div class="list">
        <div class="box">
          {foreach name=outer item=data from=$mostviewedlist}
	  {include file="video_list_small.tpl"}
	  <div style="clear:both;"></div>
          {/foreach}
        </div>
      </div>  
      </div>
    </div>
    {/if}

    {if $print_ads}{if $advert4}<div class="standard"><div class="padding"><div id="hwdadverts-nopadding">{$advert4}</div></div></div>{/if}{/if}
    
    {if $print_mostfavoured}
    <div class="standard">
      <h2>{$title_mostfavoured}</h2>
      <div class="scoller">
      <div class="list">
        <div class="box">
          {foreach name=outer item=data from=$mostfavouredlist}
	  {include file="video_list_small.tpl"}
	  <div style="clear:both;"></div>
          {/foreach}
        </div>
      </div>  
      </div>
    </div>
    {/if}

    {if $print_mostpopular}
    <div class="standard">
      <h2>{$title_mostpopular}</h2>
      <div class="scoller">
      <div class="list">
        <div class="box">
          {foreach name=outer item=data from=$mostpopularlist}
	  {include file="video_list_small.tpl"}
	  <div style="clear:both;"></div>
          {/foreach}
        </div>
      </div>  
      </div>
    </div>
    {/if}
  
  </div>
  
  <div class="sic-center">
{/if}
  
	{if $print_featured}
		<div class="hwdmodule-h3">
			{if $print_featured_player}
				{if $showFeaturedDetails}
					{include file="featured_videos_03.tpl"}
				{else}
					{include file="featured_videos_01.tpl"}
				{/if}
			{else}
				{include file="featured_videos_02.tpl"}
			{/if}
		</div>
	{/if}

    {if $print_ads}{if $advert3}<div class="standard"><div class="padding"><div id="hwdadverts-nopadding">{$advert3}</div></div></div>{/if}{/if}
    
    {if $print_nowlist}
      <div class="hwdmodule-h4">
        {include file="video_beingwatched.tpl"}
      </div>
    {/if}
    
    <div style="float:right;padding:5px;">
    {include file='navigation_selects.tpl'}
    </div>
    <div class="standard">
      <h2>{$title}</h2>
      {if $print_videolist}

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
      
      {else}
        <div class="padding">{$smarty.const._HWDVIDS_INFO_NRV}</div>
      {/if}
      <div><center>{$pageNavigation}</center></div>
    </div>

{if $print_mostviewed or $print_mostviewed or $print_mostpopular}
  </div>
</div>
{/if}
<div style="clear:both;"></div>

{include file='footer.tpl'}
