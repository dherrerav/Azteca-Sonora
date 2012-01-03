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
      <h2>{$videoplayer->title} {$videoplayer->editvideo} {$videoplayer->deletevideo}</h2>
      <div class="padding"><center>{$videoplayer->player}</center></div>
    </div>

{include file='footer.tpl'}
