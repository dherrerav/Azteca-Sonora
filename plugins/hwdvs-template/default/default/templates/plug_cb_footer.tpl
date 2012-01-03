{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

</div>

{if $print_mb_initialize}
{literal}
<script type="text/javascript">
	var box = {};
	window.addEvent('domready', function(){
		box = new MultiBox('{/literal}{$mb_id}{literal}');
	});
</script>
{/literal}
{/if}