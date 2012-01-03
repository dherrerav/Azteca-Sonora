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
	<h2>{$playlist_name}</h2>
	<div class="padding">
		{$playlist_description}
	</div>
</div> 

<div class="standard">
	<div id="hwdvs_player_container{$random}"><div class="padding">{$video_player}</div></div>
	{if $print_extended}
		{literal}
			<script type='text/javascript'>window.addEvent('domready', function(){ hwdvs_insert_playlist_video({/literal}{$vid}{literal}) });</script>
		{/literal}
		<div style="clear:both;"></div>

		<div id="thumbnails_container">
			{foreach name=outer item=data from=$list}
				<div class="thumbnail">
					{$data->thumbnail}
				</div>
			{/foreach}
		</div>

		<div style="clear:both;"></div>
	{/if}
</div>    

{literal}
<script language='javascript' type='text/javascript'>
	var fullWidth = document.getElementById("hwdvids").offsetWidth;
	document.getElementById("thumbnails_container").style.width = fullWidth + "px";
</script>
{/literal}

{include file='footer.tpl'}
