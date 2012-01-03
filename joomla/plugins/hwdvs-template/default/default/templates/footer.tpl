{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $print_ads}{if $advert5}<div id="hwdadverts-padding">{$advert5}</div>{/if}{/if}

<div class="footer"><a href="{$rss_recent}" style="float:right;"><img src="{$URL_HWDVS_IMAGES}rss.png" border="0" alt="RSS" title="RSS" /></a>{if $sc}{$cl}{/if}<div style="clear:both;"></div></div>

</div>

{if $print_mb_initialize}
{literal}
<script type="text/javascript">
	var box = {};
	window.addEvent('domready', function(){
		box = new MultiBox('mb');
	});
</script>
{/literal}
{/if}