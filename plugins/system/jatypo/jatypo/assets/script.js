var JATypo = new Class ({
	initialize: function(options) {
		this.options = $extend({
			offsets: {x:10, y: 10}
		}, options || {});
		
		this.overlay = new Element ('div', {'id':'jatypo-overlay'}).inject ($(document.body));
		this.overlay.setStyles ({'width':window.getScrollWidth(), 'height': window.getScrollHeight()});
		this.wrapper = $('jatypo-wrap');		
		if (!this.wrapper) return;		
		var button2 = new Element ('div', {'class':'button2-right jatypo-btn'});
		button2.innerHTML = '<span>JATypo</span>';
		this.button = new Element ('div', {'class':'button2-left'}).adopt(button2).inject ($('editor-xtd-buttons'));
		
		this.typos = this.wrapper.getElements ('.typo');
		this.typos.addEvents ({
			'mouseenter': function (){this.addClass ('typo-over');},
			'mouseleave': function (){this.removeClass ('typo-over');},
			'click': function (){
				var sample = this.getElement ('.sample');
				var html = sample.innerHTML;
				jInsertEditorText(html, 'jform_articletext');
				$('jatypo-wrap').setStyle ('display', 'none');
			}
		});
		this.wrapper.injectAfter (this.overlay);
		this.button.addEvent ('click', function (event) {
			event = new Event(event);
			//this.locate (event);
			this.position();
			event.stop();
		}.bind (this));
		this.overlay.addEvent ('click', function () {this.wrapper.setStyle ('display', 'none');this.overlay.setStyle ('display', 'none');}.bind(this));
		
		//Typo css into editor (tinymce)
		var doc = $('text_ifr')?($('text_ifr').contentWindow?$('text_ifr').contentWindow.document:$('text_ifr').contentDocument):null;
		if (doc) {
			var head = doc.getElementsByTagName('head')[0];
			var css = doc.createElement ('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = this.options.typocss;
			head.appendChild (css);		
		}		
	},
	
	locate: function(event){
		var win = {'x': window.getWidth(), 'y': window.getHeight()};
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var pwin = {'x': this.wrapper.offsetWidth, 'y': this.wrapper.offsetHeight};
		var prop = {'x': 'left', 'y': 'top'};
		for (var z in prop){
			var pos = event.page[z] + this.options.offsets[z];
			if ((pos + pwin[z] - scroll[z]) > win[z]) pos = event.page[z] - this.options.offsets[z] - pwin[z];
			this.wrapper.setStyle(prop[z], pos);
		};
		
		this.wrapper.setStyle ('display', 'block');
		this.overlay.setStyle ('display', 'block');
	}, 
	
	position: function () {
		this.wrapper.setStyle ('display', 'block');
		this.overlay.setStyle ('display', 'block');
		var pos = this.button.getPosition();
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var pwin = {'x': this.wrapper.offsetWidth, 'y': this.wrapper.offsetHeight};
		this.wrapper.setStyles({
			'left': pos.x + this.options.offsets.x,
			'top': pos.y + this.options.offsets.y - pwin.y
		});
	}
	
});
