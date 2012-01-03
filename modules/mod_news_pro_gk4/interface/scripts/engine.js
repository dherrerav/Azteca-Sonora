/**
* Main script file
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.4 $
**/

window.addEvent("load", function(){	
	$$('.nspMain').each(function(module){	
		if(!module.hasClass('activated')) {
			module.addClass('activated');	
			var $G = $Gavick[module.getProperty('id')];
			var arts_actual = 0;
			var list_actual = 0;
			var arts_block_width = module.getElement('.nspArts') ? module.getElement('.nspArts').getSize().x : null;
			var links_block_width = module.getElement('.nspList') ? module.getElement('.nspList').getSize().x : null;
			var arts = module.getElements('.nspArt');
			var links = (module.getElement('.nspList')) ? module.getElement('.nspList').getElements('li') : [];
			var arts_per_page = $G['news_column'] * $G['news_rows'];
			var pages_amount = Math.ceil(arts.length / arts_per_page);
			var links_pages_amount = Math.ceil(Math.ceil(links.length / $G['links_amount']) / $G['links_columns_amount']);
			var hover_anim = module.hasClass('hover');
			var animation = true;
			var modInterface = { 
				top: module.getElement('.nspTopInterface'), 
				bottom: module.getElement('.nspBotInterface')
			};
			// arts
			if(arts.length > 0){
				for(var i = 0; i < pages_amount; i++){
					var div = new Element('div');
					div.setProperty('class', "nspArtPage");
					div.setStyles({ "width" : arts_block_width+"px", "float" : "left" });
					div.inject(arts[0], 'before');
				}	
				var j = 0;
				for(var i = 0; i < arts.length; i++) {
					if(i % arts_per_page == 0 && i != 0) { j++; }
					if(Browser.Engine.trident) arts[i].setStyle('width', (arts[i].getStyle('width').toInt() - 0.2) + "%");
					arts[i].inject(module.getElements('.nspArtPage')[j], 'bottom');
					arts[i].removeClass('unvisible');
				}
				var main_scroll = new Element('div');
				main_scroll.setProperty('class', "nspArtScroll1");
				main_scroll.setStyles({ "width" : arts_block_width + "px", "overflow" : "hidden" });
				main_scroll.innerHTML = '<div class="nspArtScroll2"></div>';
				main_scroll.inject(module.getElement('.nspArtPage'), 'before');
				var long_scroll = module.getElement('.nspArtScroll2');
				long_scroll.setStyle('width','100000px');
				module.getElements('.nspArtPage').inject(long_scroll, 'bottom');
				var art_scroller = new Fx.Scroll(main_scroll, {duration:$G['animation_speed'], wait:false, wheelStops:false, transition: $G['animation_function']});
			}
			// links
			if(links.length > 0){
				for(var i = 0; i < links_pages_amount * $G['links_columns_amount']; i++){
					var ul = new Element('ul');
					ul.setStyles({ "width" : Math.floor(links_block_width / $G['links_columns_amount']) +"px", "float" : "left" });
					ul.setProperty("class","nspList");
					ul.inject(module.getElement('.nspLinks'), 'top');
				}
				
				var k = 0;
				for(var i = 0; i < links.length; i++) {
					if(i % $G['links_amount'] == 0 && i != 0) { k++; }
					links[i].inject(module.getElements('ul.nspList')[k], 'bottom');
					links[i].removeClass('unvisible');
				}
				var linkLists = module.getElements('.nspList');
				linkLists[linkLists.length - 1].dispose();
				var link_scroll = new Element('div');
				link_scroll.setProperty("class","nspLinkScroll1");
				link_scroll.setStyles({ "width" : links_block_width + "px", "overflow" : "hidden" });
				link_scroll.innerHTML = '<div class="nspLinkScroll2"></div>';
				link_scroll.inject(module.getElement('.nspLinks'), 'top');
				var long_link_scroll = module.getElement('.nspLinkScroll2');
				long_link_scroll.setStyle('width','100000px');
				module.getElements('.nspList').inject(long_link_scroll, 'bottom');
				var link_scroller = new Fx.Scroll(link_scroll, {duration:$G['animation_speed'], wait:false, wheelStops:false, transition: $G['animation_function']});
			}
			// top interface
			nsp_art_list(0, module, modInterface.top, pages_amount);
			nsp_art_list(0, module, modInterface.bottom, links_pages_amount);
			if(modInterface.top && modInterface.top.getElement('.nspPagination')){
				modInterface.top.getElement('.nspPagination').getElements('li').each(function(item,i){
					item.addEvent(hover_anim ? 'mouseenter' : 'click', function(){
						art_scroller.start(i*arts_block_width, 0);
						arts_actual = i;
						if(Browser.Engine.presto){
				 			new Fx.Tween(module.getElement('.nspArtScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left',-1 * arts_actual * arts_block_width);
						}
						nsp_art_list(i, module, modInterface.top, pages_amount);
						animation = false;
						(function(){animation = true;}).delay($G['animation_interval'] * 0.8);
					});	
				});
			}
			
			if(modInterface.top && modInterface.top.getElement('.nspPrev')){
				modInterface.top.getElement('.nspPrev').addEvent("click", function(){
					if(arts_actual == 0) arts_actual = pages_amount - 1;
					else arts_actual--;
					art_scroller.start(arts_actual * arts_block_width, 0);
					if(Browser.Engine.presto){
				 		new Fx.Tween(module.getElement('.nspArtScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * arts_actual * arts_block_width);	
					}
					nsp_art_list(arts_actual, module, modInterface.top, pages_amount);
					animation = false;
					(function(){animation = true;}).delay($G['animation_interval'] * 0.8);
				});
				modInterface.top.getElement('.nspNext').addEvent("click", function(){
					if(arts_actual == pages_amount - 1) arts_actual = 0;
					else arts_actual++;
					art_scroller.start(arts_actual * arts_block_width, 0);
					if(Browser.Engine.presto){
				 		new Fx.Tween(module.getElement('.nspArtScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * arts_actual * arts_block_width);	
					}
					nsp_art_list(arts_actual, module, modInterface.top, pages_amount);
					animation = false;
					(function(){animation = true;}).delay($G['animation_interval'] * 0.8);
				});
			}
			// bottom interface
			if(modInterface.bottom && modInterface.bottom.getElement('.nspPagination')){
				modInterface.bottom.getElement('.nspPagination').getElements('li').each(function(item,i){
					item.addEvent(hover_anim ? 'mouseenter' : 'click', function(){
						link_scroller.start(i*links_block_width, 0);
						list_actual = i;
						if(Browser.Engine.presto){
				 			new Fx.Tween(module.getElement('.nspLinkScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * list_actual * links_block_width);	
						}
						nsp_art_list(i, module, modInterface.bottom, links_pages_amount);
					});	
				});
			}
			if(modInterface.bottom && modInterface.bottom.getElement('.nspPrev')){
				modInterface.bottom.getElement('.nspPrev').addEvent("click", function(){
					if(list_actual == 0) list_actual = links_pages_amount - 1;
					else list_actual--;
					link_scroller.start(list_actual * links_block_width, 0);
	
					if(Browser.Engine.presto){
			 			new Fx.Tween(module.getElement('.nspLinkScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * list_actual * links_block_width);	
					}
					nsp_art_list(list_actual, module, modInterface.bottom, links_pages_amount);
				});
				modInterface.bottom.getElement('.nspNext').addEvent("click", function(){
					if(list_actual == links_pages_amount - 1) list_actual = 0;
					else list_actual++;
					link_scroller.start(list_actual * links_block_width, 0);
					if(Browser.Engine.presto){
	 					new Fx.Tween(module.getElement('.nspLinkScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * list_actual * links_block_width);	
					}
					nsp_art_list(list_actual, module, modInterface.bottom, links_pages_amount);
				});
			}
			if(module.hasClass('autoanim')){
				(function(){
					if(modInterface.top.getElement('.nspNext')){
						if(animation) modInterface.top.getElement('.nspNext').fireEvent("click");
					}else{
						if(arts_actual == pages_amount - 1) arts_actual = 0;
						else arts_actual++;
						art_scroller.start(arts_actual * arts_block_width, 0);
						if(Browser.Engine.presto){
					 		new Fx.Tween(module.getElement('.nspArtScroll2'), {duration:$G['animation_speed'], wait:false, transition: $G['animation_function']}).start('margin-left', -1 * arts_actual * arts_block_width);	
						}
						nsp_art_list(arts_actual, module, modInterface.top, pages_amount);
					}
				}).periodical($G['animation_interval']);
			}
		}
	});
	function nsp_art_list(i, module, position, num){
		if(position && position.getElement('.nspPagination')){
			var pagination = position.getElement('.nspPagination');
			pagination.getElements('li').setProperty('class', '');
			pagination.getElements('li')[i].setProperty('class', 'active');
		}
		
		if(position && position.getElement('.nspCounter')){
			position.getElement('.nspCounter').getElement('span').innerHTML =  (i+1) + ' / ' + num;
		}
	}
});