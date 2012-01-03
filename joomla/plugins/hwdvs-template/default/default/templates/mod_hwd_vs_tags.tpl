{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $print_cloud}

<object type="application/x-shockwave-flash" data="{$cloud_movie}" width="{$hwdvids_params.width}" height="{$hwdvids_params.height}">';
<param name="movie" value="{$cloud_movie}" />
<param name="bgcolor" value="#{$hwdvids_params.bgcolor}" />
<param name="AllowScriptAccess" value="always" />
<param name="wmode" value="transparent" />
<param name="flashvars" value="tcolor=0x{$hwdvids_params.tcolor}
&amp;tcolor2=0x{$hwdvids_params.tcolor2}
&amp;hicolor=0x{$hwdvids_params.hicolor}
&amp;tspeed={$hwdvids_params.speed}
&amp;distr={$hwdvids_params.distr}
&amp;mode={$hwdvids_params.mode}
&amp;tagcloud={$tagcloud_encoded}
" />
// alternate content
<p>{$tagcloud}</p>
<p>Requires <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> 9 or better.</p>
</object>
		
{else}

<div style="width:{$hwdvids_params.mod_width};text-align:{$hwdvids_params.textalignment};overflow:hidden;line-height:normal;">
  
  {foreach name=outer item=data from=$list}

      <a href="{$data->link}" style="padding:1px 3px;"><span style="font-size: {$data->size}%; filter:alpha(opacity={$data->transparency1}); -moz-opacity:{$data->transparency2}; -khtml-opacity: {$data->transparency2}; opacity: {$data->transparency2};\">{$data->tag}</span></a>

  {/foreach}
  
<div class="clear"></div>
</div>

{/if}