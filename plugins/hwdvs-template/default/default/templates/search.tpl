{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

{literal}
<script type="text/javascript">

var asTweenerFunction  = function() 
{
	var asDataHeight = $('asData').getStyle('height').toInt();
	if(asDataHeight > 0)
	{
		//hide
		new Fx.Style('asData', 'height', {duration:500}).start(0);
		new Fx.Style('asData', 'opacity', {duration:500}).start(0);
	}
	else
	{
		var asDataHeight = $('asDataInternal').getSize().scrollSize.y+20;
		//show
		new Fx.Style('asData', 'height', {duration:500}).start(asDataHeight);
		new Fx.Style('asData', 'opacity', {duration:500}).start(1);
	}
}

window.addEvent('domready', function() { $('button_as').addEvent('click', asTweenerFunction); });

</script>
{/literal}

<div class="standard">
        
	<div id="button_as"><h2>{$smarty.const._HWDVIDS_ADSEARCH} +</h2></div>
	<div id="asData" style="height:0;visibility:hidden;overflow:hidden;">
	<div id="asDataInternal">
	<div class="padding">
		<form method="POST" action="{$form_search}" name="advancedSearch">
		<table cellspacing="0" cellpadding="2" width="100%">
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_ASALL}:</label>
				</td>
				<td>
					<input type="text" value="{$pattern}" name="pattern">
				</td>
			</tr>
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_ASEXACT}:</label>
				</td>
				<td>
					<input type="text" value="{$ep}" name="ep">
				</td>
			</tr>
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_ASEX}:</label>
				</td>
				<td>
					<input type="text" value="{$ex}" name="ex">
				</td>
			</tr>
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_CATEGORY}:</label>
				</td>
				<td>
					{$categorySearchSelect}
				</td>
			</tr>
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_RPP}:</label>
				</td>
				<td>
					<select name="rpp">
						<option value="10" {if $rpp eq 10}selected="selected"{/if}>10</option>
						<option value="20" {if $rpp eq 20}selected="selected"{/if}>20</option>
						<option value="30" {if $rpp eq 30}selected="selected"{/if}>30</option>
						<option value="50" {if $rpp eq 50}selected="selected"{/if}>50</option>
						<option value="100" {if $rpp eq 100}selected="selected"{/if}>100</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>{$smarty.const._HWDVIDS_ORGANISE}:</label>
				</td>
				<td>
					<select name="sort">
						<option value="0" {if $sort eq 0}selected="selected"{/if}>{$smarty.const._HWDVIDS_RELEVANCE}</option>
						<option value="1" {if $sort eq 1}selected="selected"{/if}>{$smarty.const._HWDVIDS_TITLE}</option>
						<option value="2" {if $sort eq 2}selected="selected"{/if}>{$smarty.const._HWDVIDS_DATEUPLD}</option>
						<option value="3" {if $sort eq 3}selected="selected"{/if}>{$smarty.const._HWDVIDS_RATING}</option>
						<option value="4" {if $sort eq 4}selected="selected"{/if}>{$smarty.const._HWDVIDS_INFO_VIEWS}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type=submit value="{$smarty.const._HWDVIDS_BUTTON_ADSEARCH}">
				</td>
			</tr>
		</table>
		</form>
	</div>
	</div>
	</div>
</div>
<div style="clear:both;"></div>

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_VIDMATCHING} "{$searchterm}"</h2>
  {if $print_matchvids}
    {foreach name=outer item=data from=$matchingvids}
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
    <div class="padding">{$mvempty}</div>
  {/if}
  {$vpageNavigation}
</div>

{if $print_glink}
<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_GROUPMATCHING} "{$searchterm}"</h2>
  {if $print_matchgrps}
    {foreach name=outer item=data from=$matchinggroups}
          <div style="width: 49%; float:left;">
	  {include file="group_list.tpl"}
	  </div>
	  {if $smarty.foreach.outer.last}
	     <div style="clear:both;"></div>
	  {elseif $smarty.foreach.outer.index % 2-1 == 0}
	     <div style="clear:both;"></div>
	  {/if}
    {/foreach}
  {else}
    <div class="padding">{$mgempty}</div>
  {/if}
  {$gpageNavigation}
</div>
{/if}

{include file='footer.tpl'}
