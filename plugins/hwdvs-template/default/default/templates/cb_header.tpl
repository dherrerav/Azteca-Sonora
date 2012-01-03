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
//    This file generates the display for the Community Profile tab header.
//////
//    VARIABLES AVAILBLE IN THIS TEMPLATE FILE:                                        
//    -- $print_usernav.......Only set if hwdVideoShare is configured to display any user navigation options
//    -- $yv.................."Your Videos" link                               
//    -- $yf.................."Your Favourites" link                             
//    -- $yg.................."Your Groups" link            
//    -- $ym.................."Your Group Membership" link            
//    -- $cg.................."Create Group" link                        
//    -- $print_search........Only set if hwdVideoShare is configured to display the search box
//    -- $form_search.........The URL to post the search form
//    -- $searchinput.........The actual search input code
//////
*}

<div id="hwdvids">
<center>
   {if $print_ads}<div id="hwdadverts">{$advert1}</div>{/if}
   {if $print_search}
   <form action="{$form_search}" method="post" name="mainnavform">
      <div id="hwdsearchbar" class="hwdsearchbar">
         <div class="hwdsearchbox">{$searchinput}</div>
      </div>
   </form>
   {/if}
   {if $print_nav}
   <div id="hwdvs_navcontainer">
      <ul id="navlist">
         {if $print_vlink}<li{$von} onMouseOver="document.body.background='#ff0000'">{$vlink}</li>{/if}
	 {if $print_clink}<li{$con}>{$clink}</li>{/if}
	 {if $print_glink}<li{$gon}>{$glink}</li>{/if}
	 {if $print_ulink}<li{$uon}>{$ulink}</li>{/if}
      </ul>
   </div>
   {/if}
   <div style="clear:both;"></div>

   {if $print_usernav}
   <div class="usernav">{$yv}&nbsp;&nbsp;{$yf}&nbsp;&nbsp;{$yg}&nbsp;&nbsp;{$ym}&nbsp;&nbsp;{$cg}</div>
   {/if}
   {if $print_ads}<div id="hwdadverts">{$advert2}</div>{/if}
</center>