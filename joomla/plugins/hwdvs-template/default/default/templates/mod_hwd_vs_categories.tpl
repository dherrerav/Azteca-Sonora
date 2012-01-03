{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $hwdvids_params.mod_style eq 4}
	<div id="hwdvids">
		{foreach name=outer item=data from=$list}
			{if $smarty.foreach.outer.first}
				<div class="categoryBox">
					<div class="padding">
			{elseif $data->level eq 0}
					</div>
				</div>
				{if $data->countTopLevel % $cpr == 0}
					<div style="clear:both;"></div>
				{/if}
				<div class="categoryBox">
					<div class="padding">      
			{else}
			{/if}
						{include file="category_list.tpl"}
			{if $smarty.foreach.outer.last}
						<div style="clear:both;"></div>
					</div>
				</div>
			{/if}

			{if $data->level eq 0}
			{else}
			{/if}
		{/foreach}
		<div style="clear:both;"></div>
	</div>
{else}

	{if $hwdvids_params.mod_style eq 2}<ol>{elseif $hwdvids_params.mod_style eq 3}<ul>{/if}

		{foreach name=outer item=data from=$list}

		{if $hwdvids_params.mod_style eq 2}<li>{elseif $hwdvids_params.mod_style eq 3}<li>{/if}
		
		{$data->title} {if $hwdvids_params.mod_showcount eq 1}({if $data->num_vids gt 0 or $data->num_subcats eq 0}{$data->num_vids} {$smarty.const._HWDVIDS_INFO_VIDEOS}{/if}{if $data->num_vids gt 0 and $data->num_subcats gt 0}, {/if}{if $data->num_subcats gt 0}{$data->num_subcats} {$smarty.const._HWDVIDS_INFO_SUBCATS}{/if}){/if}{if $smarty.foreach.outer.last}{else}{if $hwdvids_params.mod_style eq 0},&nbsp{elseif $hwdvids_params.mod_style eq 1}&nbsp;|&nbsp;{/if}{/if}
		
		{if $hwdvids_params.mod_style eq 2}</li>{elseif $hwdvids_params.mod_style eq 3}</li>{/if}

		{/foreach}

	{if $hwdvids_params.mod_style eq 2}</ol>{elseif $hwdvids_params.mod_style eq 3}</ul>{/if}

{/if}
