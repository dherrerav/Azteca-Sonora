{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $showdetails}

	<h2>{$videoplayer->title}</h2>

	<div class="padding">
		<div style="float:left;padding-right:5px;">
		{/if}
			{$videoplayer->player}
		{if $showdetails}
		</div>

		<div id="videoDetails">{include file='video_details.tpl'}</div>
	</div>

{/if}
