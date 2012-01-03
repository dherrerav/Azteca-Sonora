/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2011
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: list.js 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

function shStopEvent(event) {

	// cancel the event
	new Event(event).stop();

}

function shProcessToolbarClick(id, pressbutton) {

	if (pressbutton != 'cancel') {
		var el = document.getElementById(id);
		var options = el.rel;
		if (typeof this.baseurl == 'undefined') {
			this.baseurl = [];
		}
		if (typeof this.baseurl[pressbutton] == 'undefined') {
			this.baseurl[pressbutton] = el.href;
		}
		var url = baseurl[pressbutton];
		var cid = document.getElementsByName('cid[]');
		var list = '';
		if (cid) {
			var length = cid.length;
			for ( var i = 0; i < length; i++) {
				if (cid[i].checked) {
					list += '&cid[]=' + cid[i].value;
				}
			}
		}
		url += list;
		el.href = url;
		window.parent.SqueezeBox.fromElement(el, {parse:'rel'});
	}

	return false;
}

function shHideMainMenu() {
	if (document.adminForm.hidemainmenu) {
		document.adminForm.hidemainmenu.value=1;
	}
}

Joomla.submitbutton = function (pressbutton) {
	if (pressbutton == "cancelPopup") {
		window.parent.shReloadModal = false;
		window.parent.SqueezeBox.close();
	} else if (pressbutton == "backPopup") {
		window.parent.shReloadModal = true;
		window.parent.SqueezeBox.close();
	} else {
		if (pressbutton == "selectnfredirect") {
			window.parent.shReloadModal = true;
		}
		if (pressbutton) {
			document.adminForm.task.value = pressbutton;
		}
		if (typeof document.adminForm.onsubmit == "function") {
			document.adminForm.onsubmit();
		}
		document.adminForm.submit();
	}
};
