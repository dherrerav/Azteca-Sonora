window.addEvent("load",function() {	
	$$('.gkHighlighterGK4').each(function(el,i) {	
		var $G = $Gavick[el.getProperty("id")];
		new GKNewsHighligher({
            wrapper: el,
            speed: $G['animationSpeed'],
            interval: $G['animationInterval'],
            fun: $G['animationFun'],
            type: $G['animationType'],
            mouseOver: $G['mouseover']
		});
	});
});
var GKNewsHighligher = new Class({
    options: {
        wrapper: null,
        speed: null,
        interval: null,
        fun: null,
        type: null,
        mouseOver: null
    },
    initialize: function(options) {
        this.setOptions(options);
        $this = this;
        this.prev = null;
        this.next = null;
        this.item_anim = false;
        var modInterface = this.options.wrapper.getElement('.gkHighlighterInterface');  
        if(modInterface) {
            if(modInterface.getElement('.next')) {
                this.prev = this.options.wrapper.getElement('.prev');
                this.next = this.options.wrapper.getElement('.next');    
            }			
            this.options.wrapper.getElement('.gkHighlighterWrapper').setStyle('width', ((this.options.wrapper.getSize().x - (modInterface.getSize().x + modInterface.getStyle('margin-left').toInt() + modInterface.getStyle('margin-right').toInt() + modInterface.getStyle('padding-left').toInt() + modInterface.getStyle('padding-right').toInt() + modInterface.getStyle('border-left-width').toInt() + modInterface.getStyle('border-right-width').toInt())) - 1) + "px");
        } else {
            this.options.wrapper.getElement('.gkHighlighterWrapper').setStyle('width', this.options.wrapper.getSize().x + "px");
        }
        
        if(this.options.wrapper.getElement('.gkHighlighterWrapper').getElement('.nowrap')) {
        	this.options.wrapper.getElement('.gkHighlighterWrapper').getElement('.nowrap').setStyle('position', 'static');
        }
        (this.options.type == 'linear') ? this.linear() : this.slides();
    },
    linear: function() {
        var nowrap = $this.options.wrapper.getElement('.nowrap');  
        $this.w = 0;
        $this.options.wrapper.getElements('.nowrap span').each(function(elmt, i){ $this.w += elmt.getSize().x; });
        var time = (($this.w+$this.options.wrapper.getSize().x)/$this.options.speed) * 1000;
        var timeOriginal = time;
        var effect = new Fx.Tween(nowrap, {duration: time, transition: Fx.Transitions.linear, onComplete: function(){
            var w = $this.options.wrapper.getSize().x;
            effect.set('margin-left', w);
            effect.start('margin-left', w, -$this.w);	
        }});
        if($this.options.mouseOver) {
            nowrap.addEvent("mouseenter", function(){
    			effect.pause();
            });

            nowrap.addEvent("mouseleave", function(){effect.resume();});
        }
        effect.set('margin-left', $this.options.wrapper.getSize().x);
        effect.start('margin-left', $this.options.wrapper.getSize().x, -$this.w);
    },
    slides: function() {
        $this.items = $this.options.wrapper.getElements('.gkHighlighterItem');
        $this.items.setStyle('display', 'block');
        $this.effects1 = [];
        $this.effects2 = [];
        $this.actual = 0;
        $this.mouseIsOver = false;
        $this.animPlay = false;
        //
        $this.timer = (function() { $this.timerFunc(); }).periodical($this.options.interval);
        //
		$this.items.each(function(elm, j) {
            elm.setStyle('z-index',$this.items.length - j);
            $this.effects1[j] = new Fx.Tween(elm, {duration: $this.options.speed, transition: $this.options.fun, wait:true, onStart:function(){ $this.animPlay = true; }, onComplete:function(){ $this.animPlay = false; } });
            $this.effects2[j] = new Fx.Tween(elm, {duration: $this.options.speed, transition: $this.options.fun, wait:true });
            if(j != 0) $this.effects1[j].set('opacity', 0);
            if($this.options.type !== 'linear') $this.effects2[j].set('top', 0);	
        });
        //
		if ($this.options.mouseOver) { 
			this.options.wrapper.getElement('.gkHighlighterWrapper').addEvent("mouseenter", function(){ $this.mouseIsOver = true; });
			this.options.wrapper.getElement('.gkHighlighterWrapper').addEvent("mouseleave", function(){ $this.mouseIsOver = false; });
		}
		if($this.next) {
            $this.next.addEvent('click', function(e){
                new Event(e).stop();
                if(!$this.animPlay) {
        			$this.effects1[$this.actual].start('opacity', 0);
                    $this.effects2[$this.actual].start('top', 0,-24);
        			$this.actual++;
        			if($this.actual > $this.items.length-1) $this.actual = 0;
        			$this.effects1[$this.actual].start('opacity', 1);
        			$this.effects2[$this.actual].start('top', 24,0);
        			//
        			$clear($this.timer);
        			$this.timer = (function(){ $this.timerFunc(); }).periodical($this.options.interval);
    			}
			});
			$this.prev.addEvent('click', function(e) {
                new Event(e).stop();
                if(!$this.animPlay) {
    				$this.effects1[$this.actual].start('opacity', 0);
    				$this.effects2[$this.actual].start('top', 0,24);
    				($this.actual == 0) ? $this.actual = $this.items.length-1 : $this.actual--;
    				$this.effects1[$this.actual].start('opacity', 1);
    				$this.effects2[$this.actual].start('top', -24,0);
    				//
    				$clear($this.timer);
    				$this.timer = (function(){ $this.timerFunc(); }).periodical($this.options.interval);
                }
			});
		}
    },
    
    timerFunc: function() {
        if($this.mouseIsOver == false) {
			$this.effects1[$this.actual].start('opacity', 0);
			$this.effects2[$this.actual].start('top', 0,-24);
			$this.actual++;
			if($this.actual > $this.items.length-1) $this.actual = 0;
			$this.effects1[$this.actual].start('opacity', 1);
			$this.effects2[$this.actual].start('top', 24,0);
		}
    }
});
GKNewsHighligher.implement(new Options);	