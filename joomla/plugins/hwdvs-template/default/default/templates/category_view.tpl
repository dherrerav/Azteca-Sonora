{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

{if $print_orderselect}
	<div style="float:right;text-align:right;padding:0 0 5px 0;">
		{literal}
		<script language="javaScript">
		function goto_sort(form) 
		{ 
			var index=form.select_order.selectedIndex
			if (form.select_order.options[index].value != "0")
			{
				location=form.select_order.options[index].value;
			}
		}
		</script>
		{/literal}
		<form name="redirect">
		<select name="select_order" onchange="goto_sort(this.form)" size="1">
		<option value="" selected="selected">{$smarty.const._HWDVIDS_TITLE_ORDERING}</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=orderASC">{$smarty.const._HWDVIDS_SELECT_ORDERING} ASC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=orderDESC">{$smarty.const._HWDVIDS_SELECT_ORDERING} DESC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=dateASC">{$smarty.const._HWDVIDS_SELECT_UPLDDATE} ASC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=dateDESC">{$smarty.const._HWDVIDS_SELECT_UPLDDATE} DESC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=nameASC">{$smarty.const._HWDVIDS_SELECT_NAME} ASC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=nameDESC">{$smarty.const._HWDVIDS_SELECT_NAME} DESC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=hitsASC">{$smarty.const._HWDVIDS_SELECT_HITS} ASC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=hitsDESC">{$smarty.const._HWDVIDS_SELECT_HITS} DESC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=voteASC">{$smarty.const._HWDVIDS_SELECT_RATING} ASC</option>
		<option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=viewcategory&cat_id={$category_id}&order=voteDESC">{$smarty.const._HWDVIDS_SELECT_RATING} DESC</option>
		</select>
		</form>
	</div>
{/if}
<div style="clear:both;"></div>
   
{if $category_video_player}
<div class="standard">
	<h2>{$category_name}</h2>
	<div class="padding">
		<p>{$category_description}</p>
		<center>
			{$category_video_player}
		</center>
	</div>
</div>
{/if}

<div class="standard">
	<h2>{$smarty.const._HWDVIDS_TITLE_CATEGORYVIDS}</h2>

	{if $print_subcats}
		{literal}
		<script type="text/javascript">

		document.write('<style type="text/css">.tabber{display:none;}<\/style>');

		var tabberOptions = {

		'manualStartup':true,

		'onLoad': function(argsObj) {
		if (argsObj.tabber.id == 'tab2') {
		alert('Finished loading tab2!');
		}
		},

		'onClick': function(argsObj) {

		var t = argsObj.tabber; 
		var id = t.id; 
		var i = argsObj.index; 
		var e = argsObj.event;

		if (id == 'tab2') {
		return confirm('Swtich');
		}
		},

		'addLinkId': true

		};
		</script>
		{/literal}
		<script type="text/javascript" src="{$link_home}/plugins/hwdvs-template/default/js/tabber.js"></script>

		<div class="tabber" id="tab1">
			<div class="tabbertab">
				<h2><a name="tab1">{$smarty.const._HWDVIDS_VIDEOS}</a></h2>
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
					<div class="padding">{$smarty.const._HWDVIDS_INFO_NCV}</div>
				{/if}
				{$pageNavigation}
			</div>
			<div class="tabbertab {if $defaultTab eq "subcategories"}tabbertabdefault{/if}">
				<h2>{$smarty.const._HWDVIDS_SUBCATS}</h2>
				{foreach name=outer item=data from=$subcatlist}
					<div class="categoryBox">
						{include file="category_list.tpl"}
					</div>
					{if $smarty.foreach.outer.last}
						<div style="clear:both;"></div>
					{elseif $smarty.foreach.outer.index % $cpr-($cpr-1) == 0}
						<div style="clear:both;"></div>
					{/if}
				{/foreach}
				<div style="clear:both;"></div>
			</div>
		</div>
		<script type="text/javascript">
		tabberAutomatic(tabberOptions);
		</script>
	{else}
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
					<div class="padding">{$smarty.const._HWDVIDS_INFO_NCV}</div>
				{/if}
				{$pageNavigation}
	{/if}
</div>

{include file='footer.tpl'}
