{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div id="hwdvids">

{$videoplayer->thumbnail}

{literal}
<script type="text/javascript">
	var box = {};
	window.addEvent('domready', function(){
		box = new MultiBox('{/literal}{$lightbox}{literal}');
	});
</script>
{/literal}

<div style="clear:both;"></div>
</div>