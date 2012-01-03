{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

<div class="standard">

  <h2>{$group_name}</h2>
  <div class="padding">
  <div style="padding:5px;float:right;">
    {$group->deletegroup}<br />
    {$group->editgroup}
  </div>
  <p>{$group_description}</p>
  <div style="clear:both;"></div>
  </div>
</div>

<div class="standard">

  <div style="padding:5px;text-align:center;">
    {$smarty.const._HWDVIDS_INFO_TOTMEM}: {$group->totalmembers} |
    {$smarty.const._HWDVIDS_INFO_TOTVID}: {$group->totalvideos} |
    {$smarty.const._HWDVIDS_INFO_CREATEDBY} {$group->administrator}
    <div style="clear:both;margin:3px;"></div>
    {$group->groupmembership}
    {$group->reportgroup}
  </div>
  <div style="clear:both;"></div>
  
</div>

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_DETAILS_MEMBERSG}</h2>
  <div class="padding">
    {if $print_memberslist}
      {foreach name=outer item=data from=$memberslist}
        {$data->username}{if $smarty.foreach.outer.last}{else},{/if}
      {/foreach}
    {else}
      <div class="padding">{$fpempty}</div>
    {/if}
  </div>
</div>

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_GRPVIDS}</h2>
  {if $print_videolist}
    {foreach name=outer item=data from=$list}
          <div class="videoBox"">
	  {include file="video_list_full.tpl"}
	  </div>
	  {if $smarty.foreach.outer.last}
	     <div style="clear:both;"></div>
	  {elseif $smarty.foreach.outer.index % $vpr-($vpr-1) == 0}
	     <div style="clear:both;"></div>
	  {/if}
    {/foreach}
  {else}
    <div class="padding">{$smarty.const._HWDVIDS_INFO_NGV}</div>
  {/if}
  {$pageNavigation}
</div>

{if $print_comments}
<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_GROUPCOMMS}</h2>
  {$group->comments}
</div>
{/if}  
		
{include file='footer.tpl'}










