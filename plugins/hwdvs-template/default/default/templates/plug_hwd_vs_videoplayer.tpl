{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div id="hwdvids">
	<div class="sic-container">
		<div class="sic-right">
			<div class="standard">
				<div class="padding">{include file='video_details.tpl'}</div>
			</div>
		</div>
		<div class="sic-center">
			<div class="standard">
				<h2>{$videoplayer->title} {$videoplayer->editvideo} {$videoplayer->deletevideo}</h2>
				<div class="padding"><center>{$videoplayer->player}</center></div>
			</div>
		</div>
	</div>
<div style="clear:both;"></div>
</div>

