/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
var JATreeMenu = new function() {
	this.menuid = 'jacom-mainnav';
	this.openedcls = 'opened';
	this.closedcls = 'closed';
	this.initmenu = function () {
		var mainnav = document.getElementById (this.menuid);
		if (!mainnav) return;
		var uls = mainnav.getElementsByTagName ('ul');
		//var menustatus = Cookie.get('menustatus');
		var menustatus = Cookie.read('menustatus');
		
		open_obj = document.getElementById('menu_open');
		close_obj = document.getElementById('menu_close');
		
		if(menustatus==this.closedcls){
			close_obj.className = 'closeall closed';
			open_obj.className = 'openall';
		}
		else{
			open_obj.className = 'openall opened';
			close_obj.className = 'closeall';
		}
		
		for (var i=1; i<uls.length; i++) {
			var li = uls[i].parentNode;
			if (li.tagName.toLowerCase() != 'li') continue;
			
			if (li.className.indexOf('opened') == -1) {
				
				if (menustatus == "" || menustatus == null) {
					menustatus = this.openedcls;
				}				
				li.className += " "+menustatus;
			}
			var a = li.getElementsByTagName ('a')[0];
			a._p = li;
			a._o = this.openedcls;
			a._c = this.closedcls;
			a.onclick = function () {
				var _p = this._p;
				if(_p.className.indexOf(this._o) == -1) {
					_p.className=_p.className.replace(new RegExp(" "+this._c+"\\b"), " "+this._o);
				} else {
					_p.className=_p.className.replace(new RegExp(" "+this._o+"\\b"), " "+this._c);
				}
			}
			a.href = 'javascript:;';
		}
	};
	
	this.openall = function () {
		open_obj = document.getElementById('menu_open');
		open_obj.className = 'openall opened';
		close_obj = document.getElementById('menu_close');
		close_obj.className = 'closeall';
		//Cookie.set('menustatus',this.openedcls);
		Cookie.write('menustatus',this.openedcls);
		var mainnav = document.getElementById (this.menuid);
		if (!mainnav) return;
		var uls = mainnav.getElementsByTagName ('ul');
		for (var i=1; i<uls.length; i++) {
			var li = uls[i].parentNode;
			if (li.tagName.toLowerCase() != 'li') continue;
			li.className=li.className.replace(new RegExp(" "+this.closedcls+"\\b"), " "+this.openedcls);
		}
		
	};
	this.closeall = function () {
		close_obj = document.getElementById('menu_close');
		close_obj.className ='closed closeall';
		open_obj = document.getElementById('menu_open');
		open_obj.className = 'openall';
		Cookie.write('menustatus',this.closedcls);
		//Cookie.set('menustatus',this.closedcls);
		var mainnav = document.getElementById (this.menuid);
		if (!mainnav) return;
		var uls = mainnav.getElementsByTagName ('ul');
		for (var i=1; i<uls.length; i++) {
			var li = uls[i].parentNode;
			if (li.tagName.toLowerCase() != 'li') continue;
			li.className=li.className.replace(new RegExp(" "+this.openedcls+"\\b"), " "+this.closedcls);
		}
	};
}