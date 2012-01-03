{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $data->level eq 0}
  <div class="box">
    <div class="listThumbnail" style="float:left;">{$data->thumbnail}</div>
    <div class="listtitle">{$data->title} ({if $data->num_vids gt 0 or $data->num_subcats eq 0}{$data->num_vids} {$smarty.const._HWDVIDS_INFO_VIDEOS}{/if}{if $data->num_vids gt 0 and $data->num_subcats gt 0}, {/if}{if $data->num_subcats gt 0}{$data->num_subcats} {$smarty.const._HWDVIDS_INFO_SUBCATS}{/if})</div>
    <div class="listdesc">{$data->description}</div>
    <div style="clear:both;"></div>
  </div>
{elseif $data->level eq 1}
  {if $hideSubcats eq 0}
    <div class="box">
      <div class="listThumbnail" style="float:left;"><img src="{$URL_HWDVS_IMAGES}sub0category.png" style="vertical-align:top;text-align:right;" alt="" /></div>
      <div class="listtitle">{$data->title} ({if $data->num_vids gt 0 or $data->num_subcats eq 0}{$data->num_vids} {$smarty.const._HWDVIDS_INFO_VIDEOS}{/if}{if $data->num_vids gt 0 and $data->num_subcats gt 0}, {/if}{if $data->num_subcats gt 0}{$data->num_subcats} {$smarty.const._HWDVIDS_INFO_SUBCATS}{/if})</div>
      <div class="listdesc">{$data->description}</div>
      <div style="clear:both;"></div>
    </div>
  {/if}
{elseif $data->level eq 2}
  {if $hideSubcats eq 0}
    <div class="box">
      <div class="listThumbnail" style="float:left;"><img src="{$URL_HWDVS_IMAGES}sub1category.png" style="vertical-align:top;text-align:right;" alt="" /></div>
      <div class="listtitle">{$data->title} ({if $data->num_vids gt 0 or $data->num_subcats eq 0}{$data->num_vids} {$smarty.const._HWDVIDS_INFO_VIDEOS}{/if}{if $data->num_vids gt 0 and $data->num_subcats gt 0}, {/if}{if $data->num_subcats gt 0}{$data->num_subcats} {$smarty.const._HWDVIDS_INFO_SUBCATS}{/if})</div>
      <div class="listdesc">{$data->description}</div>
      <div style="clear:both;"></div>
    </div>
  {/if}
{/if}
