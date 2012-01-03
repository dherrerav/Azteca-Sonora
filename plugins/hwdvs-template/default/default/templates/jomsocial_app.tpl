{* 
//////
//    @version 2.1.3 Build 21301 Alpha [ Plimmerton ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//////
//    hwdVideoShare Template System:::This template system uses the Smarty Template Engine. 
//    For full documentation, including syntax usage please refer to http://www.smarty.net 
//    or our website at http://www.hwdmediashare.co.uk   
//////
//    This file generates the display for the JomSocial plugin page.
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- TO BE ADDED
//////
*}

<div id="hwdvids">

  <div class="standard">
    <div class="padding">
      {if $showall_print}
        <a href='{$showall_link}'>{$showall_text}</a> |
      {/if}
      {if $btp_print}
        <a href='{$btp_link}'>{$btp_text}</a> |
      {/if}
      {if $navlinks_print}
        <a href='{$myvideos_link}'>{$smarty.const._HWDVIDS_NAV_YOURVIDS}</a> | <a href='{$uploadvideos_link}'>{$smarty.const._HWDVIDS_NAV_UPLOAD}</a>
      {/if}
    </div>
  </div>

  {if $print_videodata}

  {$jomsocial_js}
  
  <div class="standard">
    <div class="padding">
      <center>
	<div id="carousel_jomsocial" class="carousel-component">
	<div><img id="prev-arrow_jomsocial" class="left-button-image" src="{$JURL}/components/com_hwdvideoshare/images/modules/left-enabled.png" alt="Previous Button"/></div>
	<div><img id="next-arrow_jomsocial" class="right-button-image" src="{$JURL}/components/com_hwdvideoshare/images/modules/right-enabled.png" alt="Next Button"/></div>
	<div class="carousel_jomsocial-clip-region">
	  <ul class="carousel_jomsocial-list">
	    <!-- Filled in via the loadInitHandler, loadNextHandler, and loadPrevHandler -->
	  </ul>
	</div>
	</div>
	<a name="video"></a>
	<div id="joms_hwdvs_videoplayer"></div>
      </center>
    </div>
  </div>

  {if $print_app}

  <div class="standard">
  <h2>{$smarty.const._HWDVIDS_USERS_VIDEOS}</h2>
    {foreach name=outer item=data from=$list}
      <div style="width: 24%; float:left;">
        {include file="video_list_full_v.tpl"}
      </div>
      {if $smarty.foreach.outer.last}
        <div style="clear:both;"></div>
      {elseif $smarty.foreach.outer.index % 4-3 == 0}
        <div style="clear:both;"></div>
      {/if}
    {/foreach}
  </div>
  
  <div class="standard"><div class="padding">{$pageNavigation}</div></div>

  {/if}

  {else}
      {if $display eq "own"}
          <div class="standard"><div class="padding">{$smarty.const._HWDVIDS_CN_NOUV}</div></div>
      {else}
          <div class="standard"><div class="padding">{$smarty.const._HWDVIDS_CN_NOFV}</div></div>
      {/if}
  {/if}

</div>
<div style='clear:both;'></div>