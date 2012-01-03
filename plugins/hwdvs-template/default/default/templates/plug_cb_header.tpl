{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div id="hwdvids">

	{if $hwdvids_params.navigation eq "full"}

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
	
	{elseif $hwdvids_params.navigation eq "basic"}
	
        	{if $navlinks_print}
        		<div class="padding">
        			<a href='{$uservideos_link}'>{$smarty.const._HWDVIDS_VIEWALL}</a> | <a href='{$myvideos_link}'>{$smarty.const._HWDVIDS_NAV_YOURVIDS}</a> | <a href='{$uploadvideos_link}'>{$smarty.const._HWDVIDS_NAV_UPLOAD}</a>
        		</div>
        	{/if}
		
	{/if}