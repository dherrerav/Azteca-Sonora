{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $show_page_title eq "1"}<div class="componentheading{$pageclass_sfx}">{$page_title}</div>{/if}

<div id="hwdvids">
<center>
   {if $print_ads}{if $advert1}<div id="hwdadverts-padding">{$advert1}</div>{/if}{/if}
			{if $print_search}
			<div id="hwdvs_searchbar" class="hwdsearchbar">
				<div class="rounded_input">
					<div class="contain menudo_image">
						<form action="{$form_search}" method="post">
							{$searchinput_alt}
							<input type="submit" value="" onclick="menudo_search(); return false;" class="button" />
						</form>
					</div>
				</div>
			</div>
			{/if}
   {if $print_nav}
   <div id="hwdvs_navcontainer">
      <ul id="navlist">
         {if $print_vlink}<li{$von}>{$vlink}</li>{/if}
	 {if $print_clink}<li{$con}>{$clink}</li>{/if}
	 {if $print_glink}<li{$gon}>{$glink}</li>{/if}
	 {if $print_ulink}<li{$uon}>{$ulink}</li>{/if}
      </ul>
   </div>
   {/if}
   
   <div style="clear:both;"></div>
   
   {if $print_moderation}
   <div class="usernav">{$pending}{$reportedvideos}{$reportedgroups}</div>
   {/if}
   
   <div style="clear:both;"></div>
   
   {if $print_usernav}
   <div class="usernav">{$yv}{$yf}{$yg}{$ym}{$yp}</div>
   {/if}
   
   {if $print_usernav}
   <div class="usernav">{$cg}{$cp}{$yc}</div>
   {/if}   
   
   {if $print_ads}{if $advert2}<div id="hwdadverts-padding">{$advert2}</div>{/if}{/if}
</center>


