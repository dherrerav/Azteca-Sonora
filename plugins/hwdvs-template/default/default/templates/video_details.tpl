{*
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
{assign var='showMoreButton' value='0'}
{assign var='showAddButton' value='0'}
{assign var='showEmbedButton' value='0'}
{assign var='showDownloadButton' value='0'}
{assign var='showShareButton' value='0'}
*}

{literal}
<script type="text/javascript">

{/literal}{if $mooVersion eq "1.3"}{literal}
{/literal}{if $showMoreButton}{literal}
var dataTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
	{/literal}{if $showAddButton}{literal}
	var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}
	{/literal}{if $showEmbedButton}{literal}
	var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}
	{/literal}{if $showDownloadButton}{literal}
	var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}

	var videoDataHeight = $('videoData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(videoDataHeight > 0)
	{
		//hide
		var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[1,0],
			'height':[videoDataHeight,0]
		});
	}
	else
	{
		var videoDataHeight = $('videoDataInternal{/literal}{$videoplayer->id}{literal}').getSize().y+20;
		//show
		var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[0,1],
			'height':[0,videoDataHeight]
		});
	}
}

{/literal}{/if}{literal}
{/literal}{if $showAddButton}{literal}
var addTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
	var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
	var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
	var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}

	var addDataHeight = $('addData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(addDataHeight > 0)
	{
		//hide
		var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[1,0],
			'height':[addDataHeight,0]
		});
	}
	else
	{
		var addDataHeight = $('addDataInternal{/literal}{$videoplayer->id}{literal}').getSize().y+20;
		//show
		var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[0,1],
			'height':[0,addDataHeight]
		});
	}
}

{/literal}{/if}{literal}
{/literal}{if $showEmbedButton}{literal}
var embedTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
	var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
	var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
	var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}

	var embedDataHeight = $('embedData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(embedDataHeight > 0)
	{
		//hide
		var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[1,0],
			'height':[embedDataHeight,0]
		});
	}
	else
	{
		var embedDataHeight = $('embedDataInternal{/literal}{$videoplayer->id}{literal}').getSize().y+20;
		//show
		var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[0,1],
			'height':[0,embedDataHeight]
		});
	}
}

{/literal}{/if}{literal}
{/literal}{if $showDownloadButton}{literal}
var saveTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
	var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
	var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
	var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
	{/literal}{/if}{literal}

	var saveDataHeight = $('saveData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(saveDataHeight > 0)
	{
		//hide
		var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[1,0],
			'height':[saveDataHeight,0]
		});
	}
	else
	{
		var saveDataHeight = $('saveDataInternal{/literal}{$videoplayer->id}{literal}').getSize().y+20;
		//show
		var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[0,1],
			'height':[0,saveDataHeight]
		});
	}
}

{/literal}{/if}{literal}
{/literal}{if $showShareButton}{literal}
var shareTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
	var hwdFx = new Fx.Morph('videoData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
	var hwdFx = new Fx.Morph('addData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
	var hwdFx = new Fx.Morph('embedData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
	var hwdFx = new Fx.Morph('saveData{/literal}{$videoplayer->id}{literal}');
	hwdFx.start({
		'opacity':0,
		'height':0
	});
        {/literal}{/if}{literal}

	var shareDataHeight = $('shareData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(shareDataHeight > 0)
	{
		//hide
		var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[1,0],
			'height':[shareDataHeight,0]
		});
	}
	else
	{
		var shareDataHeight = $('shareDataInternal{/literal}{$videoplayer->id}{literal}').getSize().y+20;
		//show
		var hwdFx = new Fx.Morph('shareData{/literal}{$videoplayer->id}{literal}',{duration: 500,transition: Fx.Transitions.Sine.easeOut});
		hwdFx.start({
			'opacity':[0,1],
			'height':[0,shareDataHeight]
		});
	}
}
{/literal}{/if}{literal}
{/literal}{else}{literal}
{/literal}{if $showMoreButton}{literal}
var dataTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
	{/literal}{if $showAddButton}{literal}
	new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}
	{/literal}{if $showEmbedButton}{literal}
	new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}
	{/literal}{if $showDownloadButton}{literal}
	new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}

	var videoDataHeight = $('videoData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(videoDataHeight > 0)
	{
		//hide
		new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height', {duration:500}).start(0);
		new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:300}).start(0);
	}
	else
	{
		var videoDataHeight = $('videoDataInternal{/literal}{$videoplayer->id}{literal}').getSize().scrollSize.y+20;
		//show
		new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:500}).start(1);
		new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height').set(videoDataHeight);
	}
}

{/literal}{/if}{literal}
{/literal}{if $showAddButton}{literal}
var addTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}

	var addDataHeight = $('addData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(addDataHeight > 0)
	{
		//hide
		new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height', {duration:500}).start(0);
		new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:300}).start(0);
	}
	else
	{
		var addDataHeight = $('addDataInternal{/literal}{$videoplayer->id}{literal}').getSize().scrollSize.y+20;
		//show
		new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:500}).start(1);
		new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height').set(addDataHeight);
	}
}

{/literal}{/if}{literal}
{/literal}{if $showEmbedButton}{literal}
var embedTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}

	var embedDataHeight = $('embedData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(embedDataHeight > 0)
	{
		//hide
		new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height', {duration:500}).start(0);
		new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:300}).start(0);
	}
	else
	{
		var embedDataHeight = $('embedDataInternal{/literal}{$videoplayer->id}{literal}').getSize().scrollSize.y+20;
		//show
		new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:500}).start(1);
		new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height').set(embedDataHeight);
	}
}

{/literal}{/if}{literal}
{/literal}{if $showDownloadButton}{literal}
var saveTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
	{/literal}{if $showShareButton}{literal}
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
	new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
	{/literal}{/if}{literal}

	var saveDataHeight = $('saveData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(saveDataHeight > 0)
	{
		//hide
		new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height', {duration:500}).start(0);
		new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:300}).start(0);
	}
	else
	{
		var saveDataHeight = $('saveDataInternal{/literal}{$videoplayer->id}{literal}').getSize().scrollSize.y+20;
		//show
		new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:500}).start(1);
		new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height').set(saveDataHeight);
	}
}

{/literal}{/if}{literal}
{/literal}{if $showShareButton}{literal}
var shareTweenerFunction{/literal}{$videoplayer->id}{literal} = function()
{
        {/literal}{if $showMoreButton}{literal}
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('videoData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showAddButton}{literal}
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('addData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showEmbedButton}{literal}
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('embedData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}
        {/literal}{if $showDownloadButton}{literal}
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'opacity').set(0);
        new Fx.Style('saveData{/literal}{$videoplayer->id}{literal}', 'height').set(0);
        {/literal}{/if}{literal}

	var shareDataHeight = $('shareData{/literal}{$videoplayer->id}{literal}').getStyle('height').toInt();
	if(shareDataHeight > 0)
	{
		//hide
		new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height', {duration:500}).start(0);
		new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:300}).start(0);
	}
	else
	{
		var shareDataHeight = $('shareDataInternal{/literal}{$videoplayer->id}{literal}').getSize().scrollSize.y+20;
		//show
		new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'opacity', {duration:500}).start(1);
		new Fx.Style('shareData{/literal}{$videoplayer->id}{literal}', 'height').set(shareDataHeight);
	}
}
{/literal}{/if}{literal}
{/literal}{/if}{literal}

{/literal}{if $showMoreButton}{literal}window.addEvent('domready', function() { $('button_more{/literal}{$videoplayer->id}{literal}').addEvent('click', dataTweenerFunction{/literal}{$videoplayer->id}{literal}); });{/literal}{/if}{literal}
{/literal}{if $showAddButton}{literal}window.addEvent('domready', function() { $('button_add{/literal}{$videoplayer->id}{literal}').addEvent('click', addTweenerFunction{/literal}{$videoplayer->id}{literal}); });{/literal}{/if}{literal}
{/literal}{if $showEmbedButton}{literal}window.addEvent('domready', function() { $('button_embed{/literal}{$videoplayer->id}{literal}').addEvent('click', embedTweenerFunction{/literal}{$videoplayer->id}{literal}); });{/literal}{/if}{literal}
{/literal}{if $showDownloadButton}{literal}window.addEvent('domready', function() { $('button_save{/literal}{$videoplayer->id}{literal}').addEvent('click', saveTweenerFunction{/literal}{$videoplayer->id}{literal}); });{/literal}{/if}{literal}
{/literal}{if $showShareButton}{literal}window.addEvent('domready', function() { $('button_share{/literal}{$videoplayer->id}{literal}').addEvent('click', shareTweenerFunction{/literal}{$videoplayer->id}{literal}); });{/literal}{/if}{literal}

</script>
{/literal}

	{if $showMoreButton}<div style="float:right;"><img src="{$URL_HWDVS_IMAGES}button_more.png" id="button_more{$videoplayer->id}" /></div>{/if}
	{if $print_nextprev}
		<div style="float:right;padding:5px;">{$videoplayer->nextprev}</div>
	{/if}
        <div>{$videoplayer->uploader} &raquo; {$videoplayer->upload_date}</div>
        {if $print_description}<div>{$videoplayer->description_truncated}</div>{/if}

        <div style="clear:right;"></div>
	{$videoplayer->ratingsystem}
        <div style="clear:right;"></div>

        {if $showAddButton}<img src="{$URL_HWDVS_IMAGES}button_add.png" id="button_add{$videoplayer->id}" />{/if}
        {if $showEmbedButton}<img src="{$URL_HWDVS_IMAGES}button_embed.png" id="button_embed{$videoplayer->id}" />{/if}
        {if $showDownloadButton}<img src="{$URL_HWDVS_IMAGES}button_save.png" id="button_save{$videoplayer->id}" />{/if}
	{$videoplayer->switchquality}
        {if $showShareButton}<img src="{$URL_HWDVS_IMAGES}button_share.png" id="button_share{$videoplayer->id}" />{/if}

        <div id="videoData{$videoplayer->id}" style="visibility:hidden;height:0;">
		<div id="videoDataInternal{$videoplayer->id}">
			<div>{$smarty.const._HWDVIDS_CATEGORY}: {$videoplayer->category}</div>
			{if $print_tags}<div>{$smarty.const._HWDVIDS_TAGS}: {$videoplayer->tags}</div>{/if}
        		{if $print_description}<div>{$videoplayer->description}</div>{/if}
		</div>
        </div>

        <div id="addData{$videoplayer->id}" style="visibility:hidden;height:0;">
		<div id="addDataInternal{$videoplayer->id}">
			{if $print_addtogroup}{$videoplayer->addtogroup}{/if}
			{if $print_addtoplaylist}{$videoplayer->addtoplaylist}{/if}
		</div>
        </div>

	<div id="embedData{$videoplayer->id}" style="visibility:hidden;height:0;">
		<div id="embedDataInternal{$videoplayer->id}">
			<strong>{$smarty.const._HWDVIDS_INFO_VIDEMBEDCODE}</strong></br />
			<form name="elink"><input type="text" value="{$videoplayer->embedcode}" width="90%" name="elink" /></form>
		</div>
        </div>

        <div id="saveData{$videoplayer->id}" style="visibility:hidden;height:0;">
		<div id="saveDataInternal{$videoplayer->id}">
			<div>{$videoplayer->downloadoriginal}</div>
			<div>{$videoplayer->vieworiginal}</div>
			<div>{$videoplayer->downloadflv}</div>
		</div>
        </div>

        <div id="shareData{$videoplayer->id}" style="visibility:hidden;height:0;">
		<div id="shareDataInternal{$videoplayer->id}">
			<div style="padding: 5px 0;">{$videoplayer->sendToFriend}</div>
          		{if $print_videourl}
			<strong>{$smarty.const._HWDVIDS_TITLE_PERMALINK}</strong></br />
			<form name="vlink"><input type="text" value="{$videoplayer->videourl}" width="90%" name="vlink" /></form>
          		{/if}
               		<div style="padding:5px 0;">{$videoplayer->socialbmlinks}</div>
		</div>
        </div>

        <div id="add2groupresponse"></div>
        <div id="add2playlistresponse"></div>
        <div style="clear:both;"></div>

        <div style="float:right;">{$videoplayer->avatar}</div>
        {$videoplayer->favourties}
        {$videoplayer->reportmedia}
        <div id="ajaxresponse"></div>

        <div style="clear:both;"></div>
        