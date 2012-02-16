/*
# ------------------------------------------------------------------------
# JA Comment plugin for Joomla 1.6.x
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

JAFormController = new Class( { 
	Implements: Options,
	
	options: {
		hideRow:true,
		val	: '',
		els_str: '',
		group: 'params'
	},
	
	data: {},
	elements: [],
	controls: [],
	
	_: function (name) {
		if (!name) return ''; 
		return name.replace(/\[|\]/g, '_')
	},
	
	add: function (control, options) {		
		var control_name = 'jform['+this.options.group+']['+control+']';
		options = $extend ({'group': 'params', 'hideRow': true, 'control':control_name}, options);
		if (!this.controls.contains(control_name)) this.controls.push (control_name);
		//elements
		var els = options.els_str.split(',');
		els.each (function(el){
			el_name = 'jform['+this.options.group+']['+el.trim()+']';
			if($(el_name)==undefined){
				el_name = 'jform['+this.options.group+']['+el.trim()+'][]';
			}
			if (!this.elements.contains(el_name)) {
				this.elements.push (el_name);
				this.data[this._(el_name)] = [];
			}
			this.data[this._(el_name)].push (this._(control_name) + '_' + options.val);
			this.data[this._(control_name) + '_' + options.val] = options;
		}, this);
	},
	
	update: function () {
		var activelist = [];
		this.elements.each (function(el){
			//this element will be active if one of its parents active & selected
			this.data[this._(el)].each (function (ctrl_val) {
				if (!this.isActive (this.data[ctrl_val].control)) {
					if (activelist.contains (el)) activelist.erase (el);
					//make this disable
					this.disable (el);
				} else if (this.isSelected (this.data[ctrl_val])) {
					//put to active list
					if (!activelist.contains (el)) activelist.push (el);
					//make this enable
					this.enable (el);
				} else {
					if (!activelist.contains (el)) this.disable (el); 
				}
			}, this);
		}, this);
/*		
		//make active list enable
		activelist.each (function(el){
			this.enable (el);
		}, this);
 */		
		//disable elements not in activelist
		this.elements.each (function(el){
			if (!activelist.contains (el)) this.disable (el);
		}, this);
	},
	
	isActive: function (control) {
		if (this.elements.contains (control)) {
			this.data[this._(control)].each (function(el) {
				var options = this.data[el]; //parent options
				if (!this.isSelected (options) || !this.isActive (options.control)) return false;
			}, this);			
		}
		return true;
	},
	
	isSelected: function (options) {
		var group = $(document.adminForm)[options.control];		
		var val = options.val;

		if(group){
			var type = $type(group);
			if(type == 'collection' || type == 'array'){
				for(var i=0; i<group.length; i++){
					var subgroup = group[i];
					if(!val || ((subgroup.getStyle ('display') != 'none' && !subgroup.disabled) && (subgroup.id && subgroup.value.trim()==val && ( subgroup.type!='radio' || subgroup.checked))  ))
						return true;
				}
			} else {
				if (!val || ( (group.getStyle ('display') != 'none' && !group.disabled) && (group.value.trim()==val)))
					return true;
			}
		}
		return false;
	},
	
	toggle_el: function (el, status, hideRow) {
		var obj = el;
		if (hideRow) {
			var val = status?'block':'none';
			if (this.getParentByTagName (el, 'li')) obj = this.getParentByTagName (el, 'li');
			obj.setStyle ('display', val)
		} else {
			var val = status?'':'disabled';
			obj.disabled = val;
		}
	}, 
	
	enable: function (el) {
		var el_ = $(document.adminForm)[el];
		var options = this.data[this.data[this._(el)][0]];
		var type = $type(el_);
		if(type == 'collection' || type == 'array'){
			for(var i=0; i<el_.length; i++){
				this.toggle_el ($(el_[i]), true, options.hideRow);
			}
		} else {
			this.toggle_el ($(el_), true, options.hideRow);
		}
	},
	
	
	disable: function (el) {
		var options = this.data[this.data[this._(el)][0]];
		var el_ = $(document.adminForm)[el];
		var type = $type(el_);
		if(type == 'collection' || type == 'array'){
			for(var i=0; i<el_.length; i++){
				this.toggle_el ($(el_[i]), false, options.hideRow);
			}
		} else {
			this.toggle_el ($(el_), false, options.hideRow);
		}
	},
	
	start: function( ){
		//build list 
		this.controls.each (function (control) {
			//control elements
			var group = $(document.adminForm)[control];
			
			//bind event
			if(group){
				var type = $type(group);
				if(type == 'collection' || type == 'array'){
					for(var i=0; i<group.length; i++){
						var subgroup = $(group[i]);
						
						if (subgroup.type == 'select-one' || subgroup.type == 'select-multiple'){
							subgroup.addEvent('change', function(){
								this.update();
							}.bind(this));
						}
						else{
							subgroup.addEvent('click', function(){
								this.update();
							}.bind(this));
						}
					}				
				}
				else{
					var group = $(group);
					if (group.type == 'select-one' || group.type == 'select-multiple'){
						group.addEvent('change', function(){
							this.update();
						}.bind(this));
					}
					else{
						group.addEvent('click', function(){
							this.update();
						}.bind(this));
					}
				}
			}
			
		}, this);
		this.update();
	},		
	
	updateHeight: function () {
		var panel = getParentByClassName(this.group, 'jpane-slider');
		if(panel!=null){
			panel.setStyle('height', panel.getElement('fieldset.panelform').offsetHeight);
		}
		window.fireEvent('resize');
	},
	
	getParentByTagName: function (el, tag) {
		if($(el)){
			var parent = $(el).getParent();
			if(parent){
				while (!parent || parent.tagName.toLowerCase() != tag.toLowerCase()) {
					parent = parent.getParent();
				}
				return parent;
			}
		}
		return null;
	}	
});


var japaramhelper = new JAFormController();

function japh_addgroup (control, options) {
	japaramhelper.add (control, options);
}


window.addEvent('load', function() {
	japaramhelper.start.delay (100, japaramhelper);
});


// Control show/hide Region:
function showRegion(regionID, level){
	var tr = $(regionID).getParent();
	
	while( tr.getNext()!=null && tr.getNext().getElement('h4.block-head')==null){
		var h4 = tr.getNext().getElement('h4.block-head');
		if($type(h4)){
			 h4.removeClass("open");
			 h4.removeClass("close");
			 h4.addClass("open");
		}
		tr.getNext().removeClass('disable-row');
		tr.getNext().addClass('enable-row');
		tr = tr.getNext();
	}	
    $(regionID).removeClass("open");
    $(regionID).removeClass("close");
    $(regionID).addClass("open");  
}

function hideRegion(regionID, level){
	var tr = $(regionID).getParent();
	while( tr.getNext()!=null && tr.getNext().getElement('h4.block-head')==null){
		var h4 = tr.getNext().getElement('h4.block-head');
		if($type(h4)){
			 tr.getNext().removeClass('disable-row');
			 tr.getNext().addClass('enable-row');			
			 h4.removeClass("open");
			 h4.removeClass("close");
			 h4.addClass("close");
		}
		else{
			tr.getNext().removeClass('enable-row');
			tr.getNext().addClass('disable-row');			
		}
		
		tr = tr.getNext();
	}	
    
    $(regionID).removeClass("open");
    $(regionID).removeClass("close");
    $(regionID).addClass("close");

    
}
function showHideRegion(regionID, level){
	if($(regionID).className.indexOf('close')>-1){
		showRegion(regionID, level);
	}
	else if($(regionID).className.indexOf('open')>-1){
		hideRegion(regionID, level);
	}
	var panel = getParentByClassName($(regionID), 'jpane-slider');
	if(panel!=null){
		panel.setStyle('height', panel.getElement('fieldset.panelform').offsetHeight);
	}
	window.fireEvent('resize');
}

function getParentByClassName (el, classname) {
	if($(el)){
		var parent = $(el).getParent();
		if(parent!=null){
			while (parent!=null && !parent.hasClass(classname)) {
				parent = parent.getParent();
			}
			return parent;
		}
	}
	return null;
}