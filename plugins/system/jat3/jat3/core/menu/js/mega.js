/*
# ------------------------------------------------------------------------
# JA T3 System plugin for Joomla 1.6
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/

var jaMegaMenuMoo = new Class({

	initialize: function(menu, options){
		this.options = Object.extend({
			slide:	true, //enable slide
			duration: 300, //slide speed. lower for slower, bigger for faster
			fading: false, //Enable fading
			bgopacity: 0.9, //set the transparent background. 0 to disable, 0<bgopacity<1: the opacity of the background
			delayHide: 300,
			direction: 'down',
			action: 'mouseenter', //mouseenter or click
			tips: false,	//enable jatooltips
			hidestyle: 'normal'
		}, options || {});
		this.menu = menu;
		this.childopen = new Array();
		/*
		if (typeof(window.loaded) == 'undefined' || window.loaded) {
			this.imageloaded = false;
			this.start();
		} else {*/
			this.imageloaded = false;
			//window.addEvent('load', this.start.bind(this));
			this.start();
		//}
	},
	
	start: function () {
		this.menu = $(this.menu);
		//preload images
		var images = this.menu.getElements ('img');
		if (images && images.length && !this.imageloaded) {
			var imgs = [];
			images.each (function (image) {imgs.push(image.src)});
			if (imgs.length) {
				new Asset.images(imgs, {			
					onComplete: function(){
						this.imageloaded = true;
						this.start();
					}.bind(this)
				});
				return ;
			}
		}
		this.items = this.menu.getElements ('li.mega');
		//this.items.setStyle ('position', 'relative');
		this.items.each (function(li) {
			//link item
			if ((a = li.getElement('a.mega')) && this.isChild (a, li)) li.a = a;
			else li.a = null;
			//parent
			li._parent = this.getParent (li);
			//child content
			if ((childcontent = li.getElement('.childcontent')) && this.isChild (childcontent, li)) {
				li.childcontent = childcontent;
				li.childcontent_inner = li.childcontent.getElement ('.childcontent-inner-wrap');
				var coor = li.childcontent_inner.getCoordinates ();
				li._w = li.getElement('.childcontent-inner').offsetWidth;
				li._h = li.getElement('.childcontent-inner').offsetHeight;

				li.level0 = li.getParent().hasClass('level0');
				//
				li.childcontent.setStyles ({'width':li._w+50, 'height':li._h});
				li.childcontent_inner.setStyles ({'width':li._w});
				//fix for overflow
				li.childcontent_inner1 = li.childcontent.getElement ('.childcontent-inner');
				li.childcontent_inner1.ol = false;
				if (li.childcontent_inner1.getStyle ('overflow') == 'auto' || li.childcontent_inner1.getStyle ('overflow') == 'scroll') {
					li.childcontent_inner1.ol = true;
					//fix for ie6/7
					if (window.ie6 || window.ie7) {
						li.childcontent_inner1.setStyle ('position', 'relative');
					}
					
					if (window.ie6) {
						li.childcontent_inner1.setStyle ('height', li.childcontent_inner1.getStyle ('max-height') || 400);
					}
				}

				//show direction
				if (this.options.direction == 'up') {
					if (li.level0) {
						li.childcontent.setStyle ('top', -li.childcontent.offsetHeight); //ajust top position
					} else {
						li.childcontent.setStyle ('bottom', 0);
					}
				}
	
				if (li.level0) {
					var pos = li.getPosition();
					var win = {'x': window.getWidth(), 'y': window.getHeight()};
					var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
					if (pos['x'] + li.childcontent.offsetWidth > win['x'] + scroll ['x']) li.childcontent.setStyle ('right', 0);
				}
			}
			else li.childcontent = null;
			
			if (li.childcontent && this.options.bgopacity) {
				//Make transparent background
				var bg = new Element ('div', {'class':'childcontent-bg'});
				bg.injectTop (li.childcontent_inner);
				bg.setStyles ({'width':'100%', 'height':li._h, 'opacity':this.options.bgopacity,
								'position': 'absolute', 'top': 0, 'left': 0, 'z-index': 1
								});
				if (li.childcontent.getStyle('background')) bg.setStyle ('background', li.childcontent.getStyle('background'));
				if (li.childcontent.getStyle('background-image')) bg.setStyle ('background-image', li.childcontent.getStyle('background-image'));
				if (li.childcontent.getStyle('background-repeat')) bg.setStyle ('background-repeat', li.childcontent.getStyle('background-repeat'));
				if (li.childcontent.getStyle('background-color')) bg.setStyle ('background-color', li.childcontent.getStyle('background-color'));
				li.childcontent.setStyle ('background', 'none');
				li.childcontent_inner.setStyles ({'position':'relative', 'z-index': 2});
			}
			
			if (li.childcontent && (this.options.slide || this.options.fading)) {
				//li.childcontent.setStyles ({'width': li._w});
				li.childcontent.setStyles ({'left':'auto'});
				if (li.childcontent.hasClass ('right')) li.childcontent.setStyle ('right', 0);
				if (this.options.slide) {
					li.childcontent.setStyles ({'left':'auto', 'overflow':'hidden'});
					if (li.level0) {
						if (this.options.direction == 'up') {
							li.childcontent_inner.setStyle ('bottom', -li._h-20);
						} else {
							li.childcontent_inner.setStyle ('margin-top', -li._h-20);
						}
						
					} else {					
						li.childcontent_inner.setStyle ('margin-left', -li._w-20);
					}
				}
				if (this.options.fading) {
					li.childcontent_inner.setStyle ('opacity', 0);
				}
				//Init Fx.Styles for childcontent
				//li.fx = new Fx.Styles(li.childcontent_inner, {duration: this.options.duration, transition: Fx.Transitions.linear, onComplete: this.itemAnimDone.bind(this, li)});
				li.fx = new Fx.Tween (li.childcontent_inner, {duration: this.options.duration, transition: Fx.Transitions.linear, onComplete: this.itemAnimDone.bind(this, li)});
				//effect
				li.eff_on = {p:[],to:[]};
				li.eff_off = {p:[],to:[]};
				if (this.options.slide) {
					if (li.level0) {
						if (this.options.direction == 'up') {
							//li.eff_on.p ['bottom'] = 0;
							//li.eff_off ['bottom'] = -li._h;
							li.eff_on.p.push ('bottom');
							li.eff_on.to.push (0);
							li.eff_off.p.push ('bottom');
							li.eff_off.to.push (-li._h);
						} else {
							//li.eff_on ['margin-top'] = 0;
							//li.eff_off ['margin-top'] = -li._h;
							li.eff_on.p.push ('margin-top');
							li.eff_on.to.push (0);
							li.eff_off.p.push ('margin-top');
							li.eff_off.to.push (-li._h);
						}
					} else {
						//li.eff_on['margin-left'] = 0;
						//li.eff_off['margin-left'] = -li._w;
						li.eff_on.p.push ('margin-left');
						li.eff_on.to.push (0);
						li.eff_off.p.push ('margin-left');
						li.eff_off.to.push (-li._w);
					}
				}
				if (this.options.fading) {
					//li.eff_on=['opacity',1];
					//li.eff_off=['opacity',0];
					li.eff_on.p.push ('opacity');
					li.eff_on.to.push (1);
					li.eff_off.p.push ('opacity');
					li.eff_off.to.push (0);
				}
			}
			
			if (this.options.action=='click' && li.childcontent) {
				li.addEvent('click', function(e) {
					var event = new Event (e);
					if (li.hasClass ('group')) return;
					if (li.childcontent) {
						if (li.status == 'open') {
							if (this.cursorIn (li, event)) {
								this.itemHide (li);
							} else {
								this.itemHideOthers(li);
							}
						} else {
							this.itemShow (li);
						}
					} else {
						if (li.a) location.href = li.a.href;
					}
					event.stop();
				}.bind (this));
			
				//If action is click, click on windows will close all submenus
				this.windowClickFn = function (e) {		
					this.itemHideOthers(null);
				}.bind (this);				
			}

			if (this.options.action == 'mouseover' || this.options.action == 'mouseenter') {
				li.addEvent('mouseenter', function(e) {
					if (li.hasClass ('group')) return;
					$clear (li.timer);
					this.itemShow (li);
					e.stop();
				}.bind (this));
				
				li.addEvent('mouseleave', function(e) {
					if (li.hasClass ('group')) return;
					$clear (li.timer);
					if (li.childcontent) li.timer = setTimeout(this.itemHide.bind(this, [li, e]), this.options.delayHide);
					else this.itemHide (li, e);
					e.stop();
				}.bind (this));
				
				//if has childcontent, don't goto link before open childcontent - fix for touch screen
				if (li.a && li.childcontent) {
					li.clickable = false;
					li.a.addEvent ('click',function (e){
						if (!li.clickable) {
							new Event(e).stop();
						}
					}.bind (this));
				}
				
			}
			
			//when click on a link - close all open childcontent
			if (li.a && !li.childcontent) {
				li.a.addEvent ('click',function (e){
					this.itemHideOthers (null);
					//Remove current class
					this.menu.getElements ('.active').removeClass ('active');
					//Add current class
					var p = li;
					while (p) {
						p.addClass ('active');
						p.a.addClass ('active');
						p = p._parent;
					}
					//new Event (e).stop();
				}.bind (this));
			}			
		},this);
		
		if (this.options.slide || this.options.fading) {
			//hide all content child
			this.menu.getElements('.childcontent').setStyle ('display', 'none');
		}
		
		//tooltips
		if (this.options.tips) {
			this.options.tips = this.buildTooltips ();
		}
		
	}, 
	
	getParent: function (li) { 
		var p = li;
		while ((p=p.getParent())) {
			if (this.items.contains (p) && !p.hasClass ('group')) return p;
			if (!p || p == this.menu) return null;
		}
	},
	
	cursorIn: function (el, event) {
		if (!el || !event) return false;
		var pos = $merge (el.getPosition(), {'w':el.offsetWidth, 'h': el.offsetHeight});;
		var cursor = {'x': event.page.x, 'y': event.page.y};
	
		if (cursor.x>pos.x && cursor.x<pos.x+el.offsetWidth
				&& cursor.y>pos.y && cursor.y<pos.y+el.offsetHeight) return true;			
		return false;
	},
	
	isChild: function (child, parent) {
		return !!parent.getChildren().contains (child);
	},
	
	itemOver: function (li) {
		if (li.hasClass ('haschild')) 
			li.removeClass ('haschild').addClass ('haschild-over');
		li.addClass ('over');
		if (li.a) {
			li.a.addClass ('over');
		}
	},
	
	itemOut: function (li) {
		if (li.hasClass ('haschild-over'))
			li.removeClass ('haschild-over').addClass ('haschild');
		li.removeClass ('over');
		if (li.a) {
			li.a.removeClass ('over');
		}
	},

	itemShow: function (li) {		
		clearTimeout(li.timer);
		if (li.status == 'open') return; //don't need do anything
		//Setup the class
		this.itemOver (li);
		//push to show queue
		li.status = 'open';
		this.enableclick.delay (100, this, li);
		this.childopen.push (li);
		//hide other
		this.itemHideOthers (li);
		if (li.childcontent) {
			if (this.options.action=='click' && this.childopen.length && !this.windowClickEventAdded) {
				//addEvent click for window
				$(document.body).addEvent ('click', this.windowClickFn);
				this.windowClickEventAdded = true;
			}
		}
		
		if (!$defined(li.fx) || !$defined(li.childcontent)) return;
		
		li.childcontent.setStyle ('display', 'block');

		li.childcontent.setStyles ({'overflow': 'hidden'});		
		if (li.childcontent_inner1.ol) li.childcontent_inner1.setStyles ({'overflow': 'hidden'});
		li.fx.cancel();
		li.fx.start (li.eff_on.p, li.eff_on.to);
		//disable tooltip for this item
		this.disableTooltip (li);
		//if (li._parent) this.itemShow (li._parent);
	},
	
	itemHide: function (li, e) {
		if (e && e.page) { //if event
			if (this.cursorIn (li, e) || this.cursorIn (li.childcontent, e)) {
				return;
			} //cursor in li
			var p=li._parent;
			if (p && !this.cursorIn (p, e) && !this.cursorIn(p.childcontent, e)) {
				p.fireEvent ('mouseleave', e); //fire mouseleave event
			}
		}
		clearTimeout(li.timer);
		this.itemOut(li);
		li.status = 'close';
		this.childopen.erase (li);
		if (li.childcontent) {
			if (this.options.action=='click' && !this.childopen.length && this.windowClickEventAdded) {
				//removeEvent click for window
				$(document.body).removeEvent ('click', this.windowClickFn);
				this.windowClickEventAdded = false;
			}
		}
		
		if (!$defined(li.fx) || !$defined(li.childcontent)) return;
		
		if (li.childcontent.getStyle ('opacity') == 0) return;
		li.childcontent.setStyles ({'overflow': 'hidden'});
		if (li.childcontent_inner1.ol) li.childcontent_inner1.setStyles ({'overflow': 'hidden'});
		li.fx.cancel();
		switch (this.options.hidestyle) {
		case 'fast': 
			li.fx.options.duration = 100;
			//li.fx.start ($merge(li.eff_off,{'opacity':0}));
			li.fx.start(li.eff_off.p, li.eff_off.to);
			break;
		case 'fastwhenshow': //when other show
			if (!e) { //force hide, not because of event => hide fast
				li.fx.options.duration = 100;
				//li.fx.start ($merge(li.eff_off,{'opacity':0}));
				li.fx.start(li.eff_off.p, li.eff_off.to);
			} else {	//hide as normal
				//li.fx.start (li.eff_off);
				li.fx.start(li.eff_off.p, li.eff_off.to);
			}
			break;
		case 'normal':
		default:
			//li.fx.start (li.eff_off);
			li.fx.start(li.eff_off.p, li.eff_off.to);
			break;
		}
		//li.fx.start (li.eff_off);		
	},
	
	itemAnimDone: function (li) {
		//hide done
		if (li.status == 'close'){
			//reset duration and enable opacity if not fading
			if (this.options.hidestyle.test (/fast/)) {
				li.fx.options.duration = this.options.duration;
				if (!this.options.fading) li.childcontent_inner.setStyle ('opacity', 1);
			}
			//hide
			li.childcontent.setStyles ({'display': 'none'});
			//enable tooltip
			this.enableTooltip (li);
			this.disableclick.delay (100, this, li);
		}
		
		//show done
		if (li.status == 'open'){
			li.childcontent.setStyles ({'overflow': ''});
			if (li.childcontent_inner1.ol) li.childcontent_inner1.setStyles ({'overflow-y': 'auto'});
		}
	},
	
	itemHideOthers: function (el) {
		var fakeevent = null
		if (el && !el.childcontent) fakeevent = {};
		var curopen = this.childopen;
		curopen.each (function(li) {
			if (li && typeof (li.status) != 'undefined' && (!el || (li != el && !li.hasChild (el)))) {
				this.itemHide(li, fakeevent);
			}
		},this);
	},

	buildTooltips: function () {
		this.tooltips = new Tips (this.menu.getElements ('.hasTipThumb'), {'className':'ja-toolbar-thumb', 'fixed':true, offsets:{'x':100, 'y': this.options.direction=='up'?-180:20}, 'direction': this.options.direction});
		this.tooltips1 = new Tips (this.menu.getElements ('.hasTipThumb2'), {'className':'ja-toolbar-thumb2', 'fixed':true, offsets:{'x':100, 'y': 20}, 'direction': this.options.direction});
		return true;
	},
	
	disableTooltip: function (el) {
		if (this.options.tips) this.tooltips.disableTip(el);
		return;
	},
	
	enableTooltip: function (el) {
		if (this.options.tips) this.tooltips.enableTip(el);
		return;
	},

	enableclick: function (li) {
		if (li.a && li.childcontent) li.clickable = true;
	},
	disableclick: function (li) {
		if (li.a && li.childcontent) li.clickable = false;
	}
});
