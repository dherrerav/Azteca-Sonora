{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{literal}
<script type="text/javascript">

document.write('<style type="text/css">.tabber{display:none;}<\/style>');

var tabberOptions = {

  'manualStartup':true,

  'onLoad': function(argsObj) {
    if (argsObj.tabber.id == 'tab2') {
      alert('Finished loading tab2!');
    }
  },

  'onClick': function(argsObj) {

    var t = argsObj.tabber; 
    var id = t.id; 
    var i = argsObj.index; 
    var e = argsObj.event;

    if (id == 'tab2') {
      return confirm('Swtich');
    }
  },

  'addLinkId': true

};
</script>
{/literal}
<script type="text/javascript" src="{$link_home}/plugins/hwdvs-template/default/js/tabber.js"></script>

  {if $print_pane}{$startpane}{/if}
    {if $print_mvtd or $print_mvtw or $print_mvtm or $print_mvat}
    {if $print_pane}{$starttab_mostviewed}{/if}
    
    <div class="tabber" id="tab-viewed">

      {if $print_mvtd}
      {if $hwdvids_params.starttab eq 1}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MVTD}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostviewed_today}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}

	    <div id="mostviewed_today_frame"><img id="mostviewed_today_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostviewed_today_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <div style="clear:both"></div>
	    <center>

	      <div id="mostviewed_today">

	        <ul id="mostviewed_today_content">  
		  {foreach name=outer item=data from=$rows_mostviewed_today}
		    <li class="mostviewed_today_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}

      {if $print_mvtw}
      {if $hwdvids_params.starttab eq 2}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MVTW}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostviewed_thisweek}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostviewed_thisweek_frame"><img id="mostviewed_thisweek_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostviewed_thisweek_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <div style="clear:both"></div>
	    <center>

	      <div id="mostviewed_thisweek">

	        <ul id="mostviewed_thisweek_content">  
		  {foreach name=outer item=data from=$rows_mostviewed_thisweek}
		    <li class="mostviewed_thisweek_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
 
      {if $print_mvtm}
      {if $hwdvids_params.starttab eq 3}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MVTM}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostviewed_thismonth}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostviewed_thismonth_frame"><img id="mostviewed_thismonth_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostviewed_thismonth_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostviewed_thismonth">

	        <ul id="mostviewed_thismonth_content">  
		  {foreach name=outer item=data from=$rows_mostviewed_thismonth}
		    <li class="mostviewed_thismonth_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
      {if $print_mvat}
      {if $hwdvids_params.starttab eq 4}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MVAT}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostviewed_alltime}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostviewed_alltime_frame"><img id="mostviewed_alltime_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostviewed_alltime_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostviewed_alltime">

	        <ul id="mostviewed_alltime_content">  
		  {foreach name=outer item=data from=$rows_mostviewed_alltime}
		    <li class="mostviewed_alltime_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
    </div>
    
    {if $print_pane}{$endtab}{/if}
    {/if}
    {if $print_mptd or $print_mptw or $print_mptm or $print_mpat}
    {if $print_pane}{$starttab_mostpopular}{/if}

    <div class="tabber" id="tab-popular">

      {if $print_mptd}
      {if $hwdvids_params.starttab eq 5}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MPTD}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostpopular_today}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostpopular_today_frame"><img id="mostpopular_today_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostpopular_today_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostpopular_today">

	        <ul id="mostpopular_today_content">  
		  {foreach name=outer item=data from=$rows_mostpopular_today}
		    <li class="mostpopular_today_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
      {if $print_mptw}
      {if $hwdvids_params.starttab eq 6}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MPTW}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostpopular_thisweek}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostpopular_thisweek_frame"><img id="mostpopular_thisweek_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostpopular_thisweek_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostpopular_thisweek">

	        <ul id="mostpopular_thisweek_content">  
		  {foreach name=outer item=data from=$rows_mostpopular_thisweek}
		    <li class="mostpopular_thisweek_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
 
      {if $print_mptm}
      {if $hwdvids_params.starttab eq 7}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MPTM}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostpopular_thismonth}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostpopular_thismonth_frame"><img id="mostpopular_thismonth_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostpopular_thismonth_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostpopular_thismonth">

	        <ul id="mostpopular_thismonth_content">  
		  {foreach name=outer item=data from=$rows_mostpopular_thismonth}
		    <li class="mostpopular_thismonth_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
      {if $print_mpat}
      {if $hwdvids_params.starttab eq 8}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MPAT}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostpopular_alltime}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostpopular_alltime_frame"><img id="mostpopular_alltime_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostpopular_alltime_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostpopular_alltime">

	        <ul id="mostpopular_alltime_content">  
		  {foreach name=outer item=data from=$rows_mostpopular_alltime}
		    <li class="mostpopular_alltime_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
    </div>

    {if $print_pane}{$endtab}{/if}
    {/if}
    {if $print_mftd or $print_mftw or $print_mftm or $print_mfat}
    {if $print_pane}{$starttab_mostfavoured}{/if}

    <div class="tabber" id="tab-favoured">

      {if $print_mftd}
      {if $hwdvids_params.starttab eq 9}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MFTD}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostfavoured_today}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostfavoured_today_frame"><img id="mostfavoured_today_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostfavoured_today_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostfavoured_today">

	        <ul id="mostfavoured_today_content">  
		  {foreach name=outer item=data from=$rows_mostfavoured_today}
		    <li class="mostfavoured_today_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}

      {if $print_mftw}
      {if $hwdvids_params.starttab eq 10}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MFTW}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostfavoured_thisweek}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostfavoured_thisweek_frame"><img id="mostfavoured_thisweek_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostfavoured_thisweek_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostfavoured_thisweek">

	        <ul id="mostfavoured_thisweek_content">  
		  {foreach name=outer item=data from=$rows_mostfavoured_thisweek}
		    <li class="mostfavoured_thisweek_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
 
      {if $print_mftm}
      {if $hwdvids_params.starttab eq 11}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MFTM}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostfavoured_thismonth}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostfavoured_thismonth_frame"><img id="mostfavoured_thismonth_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostfavoured_thismonth_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostfavoured_thismonth">

	        <ul id="mostfavoured_thismonth_content">  
		  {foreach name=outer item=data from=$rows_mostfavoured_thismonth}
		    <li class="mostfavoured_thismonth_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
      
      {if $print_mfat}
      {if $hwdvids_params.starttab eq 12}
        <div class="tabbertab tabbertabdefault">
      {else}
        <div class="tabbertab">
      {/if}
        <h2><a>{$smarty.const._HWDVIDS_MFAT}</a></h2>
	<div id="hwdvids">
	<div class="standard">
	  {if $hwdvids_params.style eq 2}
	      {foreach name=outer item=data from=$rows_mostfavoured_alltime}
		  <div style="width:{$static_width}%;float:left;">
		    {include file="mod_hwd_vs_list.tpl"}
		  </div>
		  {if $smarty.foreach.outer.last}
		     <div style="clear:both;"></div>
		  {elseif $smarty.foreach.outer.index % $hwdvids_params.novpr-($hwdvids_params.novpr-1) == 0}
		     <div style="clear:both;"></div>
		  {/if}
	      {/foreach}
	  {else}
	    <div id="mostfavoured_alltime_frame"><img id="mostfavoured_alltime_next" src="{$URL_HWDVS_IMAGES}arrow_next.png" alt="Next" style="padding: 5px 5px 5px 0;" /><img id="mostfavoured_alltime_prev" src="{$URL_HWDVS_IMAGES}arrow_prev.png" alt="Previous" style="padding: 5px 0;" /></div>
	    <center>

	      <div id="mostfavoured_alltime">

	        <ul id="mostfavoured_alltime_content">  
		  {foreach name=outer item=data from=$rows_mostfavoured_alltime}
		    <li class="mostfavoured_alltime_item">
		      {include file="mod_hwd_vs_list.tpl"}
		    </li>   
		  {/foreach}
	        </ul>  

	      </div> 

	    </center>
	  {/if}
	</div>
	</div>
        </div>
      {/if}
    
    </div>

    {if $print_pane}{$endtab}{/if}
    {/if}    
  {if $print_pane}{$endpane}{/if}
  
  
<script type="text/javascript">tabberAutomatic();</script>
