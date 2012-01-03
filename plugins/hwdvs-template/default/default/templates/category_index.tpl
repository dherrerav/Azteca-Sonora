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
      function goto_sort(form) { 
        var index=form.select_order.selectedIndex
        if (form.select_order.options[index].value != "0") {
          location=form.select_order.options[index].value;
        }
      }
    </script>
    {/literal}
    <form name="redirect">
      <select name="select_order" onchange="goto_sort(this.form)" size="1">
        <option value="" selected="selected">{$smarty.const._HWDVIDS_TITLE_ORDERING}</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=orderASC">{$smarty.const._HWDVIDS_SELECT_ORDERING} ASC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=orderDESC">{$smarty.const._HWDVIDS_SELECT_ORDERING} DESC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=nameASC">{$smarty.const._HWDVIDS_SELECT_NAME} ASC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=nameDESC">{$smarty.const._HWDVIDS_SELECT_NAME} DESC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=novidsASC">{$smarty.const._HWDVIDS_SELECT_NOVIDS} ASC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=novidsDESC">{$smarty.const._HWDVIDS_SELECT_NOVIDS} DESC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=nosubsASC">{$smarty.const._HWDVIDS_SELECT_NOSUBS} ASC</option>
        <option value="{$mosConfig_live_site}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=categories&hwdcorder=nosubsDESC">{$smarty.const._HWDVIDS_SELECT_NOSUBS} DESC</option>
      </select>
    </form>
  </div>
  {/if}
  <div style="clear:both;"></div>
  
{if $print_categories}
<div class="standard">

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
					<div style="clear:both;">
					</div>
				</div>
			</div>
		{/if}

		{if $data->level eq 0}
		{else}
		{/if}

	{/foreach}
	<div style="clear:both;"></div>
        <div><center>{$pageNavigation}</center></div>

</div>
{/if}

{include file='footer.tpl'}


