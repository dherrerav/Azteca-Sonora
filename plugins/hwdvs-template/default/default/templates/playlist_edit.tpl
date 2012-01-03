{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

<form name="editPlaylist" action="{$form_edit_playlist}" method="post">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="70%" valign="top" style="padding-right: 5px;">
    
<div class="standard">
  <h2>Edit Playlist</h2>
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_TITLE} <font class="required">*</font></td>
      <td><input name="playlist_name" value="{$playlist_name}" class="inputbox" size="20" maxlength="500" style="width: 200px;" /></td>
    </tr>
    <tr>
      <td valign="top">{$smarty.const._HWDVIDS_DESC} <font class="required">*</font></td>
      <td valign="top"><textarea rows="4" cols="20" name="playlist_description" class="inputbox" style="width: 200px;">{$playlist_description}</textarea><br /></td></tr>
    <tr>
      <td colspan="2"><font class="required">*</font> {$smarty.const._HWDVIDS_INFO_REQUIREDFIELDS}</td>
    </tr>
  </table>
</div>

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_OPTIONS}</h2>
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_ACCESS}</td>
      <td>
        <select name="public_private">
          <option value="public" selected>{$smarty.const._HWDVIDS_SELECT_PUBLIC}</option>
          <option value="registered">{$smarty.const._HWDVIDS_SELECT_REG}</option>
        </select>
      </td>
    </tr>
  </table>
</div>

<div class="standard">
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    <tr>
      <td width="150"></td>
      <td><input type="submit" name="send" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_UPDT}" onClick="videoupload.send.disabled=true;" />&#160;<input type="button" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_CANX}" onClick="javascript:history.go(-1)"/></td>
    </tr>
  </table>
</div>
    
    </td>
    <td width="30%" valign="top">
    
<div class="standard">
  <input type="button" id="submitButton" value="Save" style="float:right;margin:3px;" />
  <h2>Playlist Order</h2>

  {if $print_pl_videos}
  
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/animation/animation-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/dragdrop/dragdrop-min.js"></script>

<!--begin custom header content for this example-->

{literal}
<style type="text/css">

div.workarea { width: 100%; }

ul.draglist { 
    position: relative;
    width: 100%; 
    /* height:240px; */
    background: #f7f7f7;
    list-style: none;
    margin:0;
    padding:0;
    float:left;
}

ul.draglist li {
    margin: 1px;
    cursor: move;
    zoom: 1;
    float:left;
}

ul.draglist_alt { 
    position: relative;
    width: 200px; 
    list-style: none;
    margin:0;
    padding:0;
    /*
       The bottom padding provides the cushion that makes the empty 
       list targetable.  Alternatively, we could leave the padding 
       off by default, adding it when we detect that the list is empty.
    */
    padding-bottom:20px;
}

ul.draglist_alt li {
    margin: 0px;
    cursor: move; 
}


li.list1 {
    background-color: #D1E6EC;
    border:1px solid #7EA6B2;
    width: 98%;
    height: 40px;
    margin: 0;
    padding: 0;
}

</style>
{/literal}

<div class="workarea">
  <ul id="hwdps_list" class="draglist">
    {foreach name=outer item=data from=$pl_video_list}
      <li class="list1" id="hwdps{$data->counter}"><img src="{$data->thumbnail_url}" alt="" style="float:right;height:35px;width:60;padding:3px;" /><a href="{$JURL}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=removeVideoFromPlaylist&video_id={$data->vid}&playlist_id={$playlist_id}"><img src="{$URL_HWDVS_IMAGES}icons/delete.png" alt="" style="float:right;height:16px;width:16px;padding:3px;" /></a>{$data->title}<hwdpspid style="display:none;">{$data->vid}</hwdpspid></li>
    {/foreach}
  </ul>

</div>

{literal}
<script type="text/javascript">

(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

//////////////////////////////////////////////////////////////////////////////
// example app
//////////////////////////////////////////////////////////////////////////////
YAHOO.example.DDApp = {
    init: function() {

        var rows=50,cols=1,i,j;
        for (i=1;i<cols+1;i=i+1) {
            new YAHOO.util.DDTarget("ul"+i);
        }

        for (i=1;i<cols+1;i=i+1) {
            for (j=1;j<rows+1;j=j+1) {
                new YAHOO.example.DDList("hwdps" + j);
            }
        }

        Event.on("submitButton", "click", this.submitOrder);
        Event.on("showButton", "click", this.showOrder);
    },

    submitOrder: function() {
        var parseList = function(ul) {
            var items = ul.getElementsByTagName("li");
            var out = '';
            for (i=0;i<items.length;i=i+1) {
            	var hwdpspidArray = document.getElementsByTagName('hwdpspid');
                out += items[i].id + "--" + hwdpspidArray[i+1].innerHTML + "_";
            }
            return out;
        };

	var url = '{/literal}{$mosConfig_live_site}{literal}';
	var playlist_id = '{/literal}{$playlist_id}{literal}';
        var hwdps_list=Dom.get("hwdps_list");
        var orderdata=parseList(hwdps_list);
	var posturl = url+'/index.php?option=com_hwdvideoshare&task=reorderplaylist&playlist_id='+playlist_id+'&orderdata='+orderdata;

	window.location = posturl;

    },
    
};

//////////////////////////////////////////////////////////////////////////////
// custom drag and drop implementation
//////////////////////////////////////////////////////////////////////////////

YAHOO.example.DDList = function(id, sGroup, config) {

    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);

    this.logger = this.logger || YAHOO;
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent

    this.goingUp = false;
    this.lastY = 0;
};

YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {

    startDrag: function(x, y) {
        this.logger.log(this.id + " startDrag");

        // make the proxy look like the source element
        var dragEl = this.getDragEl();
        var clickEl = this.getEl();
        Dom.setStyle(clickEl, "visibility", "hidden");

        dragEl.innerHTML = clickEl.innerHTML;

        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
        Dom.setStyle(dragEl, "border", "2px solid gray");
    },

    endDrag: function(e) {

        var srcEl = this.getEl();
        var proxy = this.getDragEl();

        // Show the proxy element and animate it to the src element's location
        Dom.setStyle(proxy, "visibility", "");
        var a = new YAHOO.util.Motion( 
            proxy, { 
                points: { 
                    to: Dom.getXY(srcEl)
                }
            }, 
            0.2, 
            YAHOO.util.Easing.easeOut 
        )
        var proxyid = proxy.id;
        var thisid = this.id;

        // Hide the proxy and show the source element when finished with the animation
        a.onComplete.subscribe(function() {
                Dom.setStyle(proxyid, "visibility", "hidden");
                Dom.setStyle(thisid, "visibility", "");
            });
        a.animate();
    },

    onDragDrop: function(e, id) {

        // If there is one drop interaction, the li was dropped either on the list,
        // or it was dropped on the current location of the source element.
        if (DDM.interactionInfo.drop.length === 1) {

            // The position of the cursor at the time of the drop (YAHOO.util.Point)
            var pt = DDM.interactionInfo.point; 

            // The region occupied by the source element at the time of the drop
            var region = DDM.interactionInfo.sourceRegion; 

            // Check to see if we are over the source element's location.  We will
            // append to the bottom of the list once we are sure it was a drop in
            // the negative space (the area of the list without any list items)
            if (!region.intersect(pt)) {
                var destEl = Dom.get(id);
                var destDD = DDM.getDDById(id);
                destEl.appendChild(this.getEl());
                destDD.isEmpty = false;
                DDM.refreshCache();
            }

        }
    },

    onDrag: function(e) {

        // Keep track of the direction of the drag for use during onDragOver
        var y = Event.getPageY(e);

        if (y < this.lastY) {
            this.goingUp = true;
        } else if (y > this.lastY) {
            this.goingUp = false;
        }

        this.lastY = y;
    },

    onDragOver: function(e, id) {
    
        var srcEl = this.getEl();
        var destEl = Dom.get(id);

        // We are only concerned with list items, we ignore the dragover
        // notifications for the list.
        if (destEl.nodeName.toLowerCase() == "li") {
            var orig_p = srcEl.parentNode;
            var p = destEl.parentNode;

            if (this.goingUp) {
                p.insertBefore(srcEl, destEl); // insert above
            } else {
                p.insertBefore(srcEl, destEl.nextSibling); // insert below
            }

            DDM.refreshCache();
        }
    }
});

Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);

})();

</script>
{/literal}
  
  {else}

<div class="padding">
  Playlist contains no videos
</div>

  {/if}
  <div style="clear:both;"></div>
</div>    
    
    </td>
  </tr>
</table>
<input type="hidden" name="playlist_id" value="{$playlist_id}" />
</form>

{include file='footer.tpl'}
