/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2011
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: notfound.js 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

function shAjaxHandler(task, options, closewindow) {

	var form = document.id('adminForm');
	form.task.value = task;
	form.format.value = "raw";

	// Create a progress indicator
	var update = document.id("sh-message-box").empty();
	update.set("html","<div class='sh-ajax-loading'>&nbsp;</div>");
	document.id("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	var onSuccessFn = function(response, responseXML) {
		var root, status, message;
		try {
			root = responseXML.documentElement;
			status = root.getElementsByTagName("status").item(0).firstChild.nodeValue;
			message = root.getElementsByTagName("message").item(0).firstChild.nodeValue;
		} catch (err) {
			status = 'failure';
			message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please retry or cancel</li></ul></div>";
		}

		// remove progress indicator
		var update = document.id("sh-message-box").empty();

		// insert results
		if (status == "success") {
			update.set("html",message);
			if (closewindow) {
				setTimeout("window.parent.SqueezeBox.close()", 1500);
			} else {
				setTimeout("document.id('sh-message-box').empty()", 3000);
			}
		} else if (status == 'redirect') {
			setTimeout("parent.window.location='" + message + "';", 100);
			window.parent.shReloadModal = false;
			window.parent.SqueezeBox.close();
		} else {
			document.id('sh-error-box').set("html",message);
			setTimeout("document.id('sh-error-box').empty();", 5000);
		}

	};

	// Send the form.
	form.set( 'send', {url: 'index.php', method: 'post', onSuccess: onSuccessFn});
	form.send();
}

function shStopEvent(event) {

	// cancel the event
	new Event(event).stop();

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

function shListItemAjaxTask(id, task, options, closewindow) {
	var f = document.adminForm;
	cb = eval('f.' + id);
	if (cb) {
		for (i = 0; true; i++) {
			cbx = eval('f.cb' + i);
			if (!cbx)
				break;
			cbx.checked = false;
		} // for
		cb.checked = true;
		f.boxchecked.value = 1;
		shAjaxHandler(task, options, closewindow);
	}
	return false;
}
