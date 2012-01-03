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
//    This file generates the display for the Community Profile tabs
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- $novideos.......Text to display if the profile tab has no videos  
//////
*}


{include file='cb_header.tpl'}
  
<div class="standard">
  {if $print_videolist}
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
  {else}
    <div class="padding">{$noitems}</div>
  {/if}
  {$pageNavigation}
</div>

{include file='cb_footer.tpl'}




