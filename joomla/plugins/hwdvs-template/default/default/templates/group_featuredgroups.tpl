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
      <h2>{$smarty.const._HWDVIDS_TITLE_FEATUREDGROUPS}</h2>
      {if $print_grouplist}

          {foreach name=outer item=data from=$list}
          <div style="width:49%; float:left;">
	  {include file="group_list.tpl"}
	  </div>
	  {if $smarty.foreach.outer.last}
	     <div style="clear:both;"></div>
	  {elseif $smarty.foreach.outer.index % 2-1 == 0}
	     <div style="clear:both;"></div>
	  {/if}
          {/foreach}
      
      {else}
        <div class="padding">{$smarty.const._HWDVIDS_INFO_NFEATG}</div>
      {/if}
      {$pageNavigation}
    </div>
    
{include file='footer.tpl'}
