{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $print_nowlist eq 2}

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_BWN}</h2>
  <center>
    {$bwn_modContent}
  </center>
</div>

{else}

<div class="standard">
  <div id="{$iCID}_frame"><img id="{$iCID}_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 0 0;" /><img id="{$iCID}_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
  <h2>{$smarty.const._HWDVIDS_BWN}</h2>
  <center>
    <div id="{$iCID}">
      <ul id="{$iCID}_content">  
        {foreach name=outer item=data from=$nowlist}
          <li class="{$iCID}_item"><div class="box">{$data->thumbnail}</div></li>  
        {/foreach}
      </ul>  
    </div> 
  </center>
</div>

{/if}








 
