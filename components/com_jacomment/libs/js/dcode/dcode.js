/****************** DCODE toolbar helper ******************\
             Courtesy of http://oopstudios.com/
 Prepends a DCODE toolbar before the defined textarea,
  and also adds a few 
\**********************************************************/

DCODE = {};
// Path to self
s = document.getElementsByTagName ('script');
for (var i=0, n=s.length; i<n; i++) {
  if (s[i].src.match ('dcode.js')) {
    DCODE.path = s[i].src.replace ('dcode.js', '');
  }
}
//
// List of all tags
//  TAG: [Title, alternativeTag]
//
DCODE.tags = {
  LARGE:   ['Large title'],
  MEDIUM:  ['Medium title'],
  HR:      ['Horizontal rule'],
  B:       ['Bold text'],
  I:       ['Italic text'],
  U:       ['Underline text'],
  S:       ['Line-Through text'],
  UL:      ['Unordered (bullet) list', '*'],
  OL:      ['Ordered (numbered) list', '#'],
  SUB:     ['Subscript text'],
  SUP:     ['Superscript text'],
  QUOTE:   ['Quotation'],
  LINK:    ['Link / Email'],
  IMG:     ['Image'],
  YOUTUBE: ['Youtube video'],
  HELP:    ['Help docs']
};
//
// This whitelist stores all the tags to use on the toolbar, you can
//  modify it by calling DCODE.addTag, DCODE.removeTag, and DCODE.setTags
//  before activating the <textarea> with DCODE.activate
//
DCODE.whiteList = [];
for (n in DCODE.tags) {
  DCODE.whiteList[n] = true;
}
//
// Tag whitelist modification
//
DCODE.addTag = function (tag) {
  // Add it if OK
  if (DCODE.tags[tag]) {
    DCODE.whiteList[tag] = true;
  }
};
DCODE.removeTag = function (tag) {
  // Negate it if it exists
  if (DCODE.whiteList[tag]) {
    DCODE.whiteList[tag] = false;
  }
};
DCODE.setTags = function (tags) {
  // Turn them all off
  for (n in DCODE.tags) {
    DCODE.whiteList[n] = false;
  }
  // And all the requested ones on
  for (var t=0, l=tags.length; t<l; t++) {
    DCODE.addTag (tags[t]);
  }
};
//
// The "hooks" are functions that intercept tag calls (above), and can be
//  used to customise their function. Typical use would be if you had your own
//  image library, you could open a popup window listing them off, allowing
//  uploads etc. The popup can access DCODE methods and do it's bidding!
//
DCODE.hooks = {};
//
// Prompt for a LINK
//
DCODE.hooks.LINK = function () {
var path = prompt ('Please enter the Link or Email address', '');
  if (path) {
    this.wrapSelection ('[LINK=' + path + ']', '[/LINK]');
  }
};
//
// Prompt for an image path
//
DCODE.hooks.IMG = function (id) {
  var path = prompt ('Please enter the image path', 'http://');
  if (path) {
    this.wrapSelection ('[IMG]' + path + '[/IMG]', '');
  }
};
//
// Prompt for and check a youtube path
//
DCODE.hooks.YOUTUBE = function (id) {
  var path = prompt ('Enter the Youtube link', 'http://');
  if (path) {
    var regx = /v=([a-z0-9-_]+)/i
    res = regx.exec (path);
    if (res != null) {
      this.wrapSelection ('[YOUTUBE]' + res[1] + '[/YOUTUBE]', '');
    } else {
      var regx = /^([a-z0-9-_]+)$/i
      res = regx.exec (path);
      if (res != null) {
        this.wrapSelection ('[YOUTUBE]' + res[1] + '[/YOUTUBE]', '');
      }
    }
  }
};
//
// Opens the help document
//  can be called directly!
//
DCODE.help = DCODE.hooks.HELP = function (id) {
  DCODE.popup (DCODE.path + 'help.html', 500, 500);
};
//
// I need popups for the helpdocs, so this function is seperated
//  in case you want to re-use it for your hooks! ;-)
//
DCODE.popupWin = "";
DCODE.popup = function (url, W, H) {
	// Calculate the position onscreen:
	L = (screen.width-W)/2;
	T = (screen.height-H)/2;
	// Create the window:
	if (DCODE.popupWin.close) {
		DCODE.popupWin.close ();
	}
	DCODE.popupWin = window.open (url, 'dcodePopup', 'width=' + W + ', height=' + H + ', left=' + L + ', top=' + T + ', scrollbars=1, menubar=0, toolbar=0, directories=0, resizable=0, location=0, status=0');
	if (window.focus) {
		DCODE.popupWin.focus();
	}
	// Add on an opener if we need it:
	if (!DCODE.popupWin.opener) {
		DCODE.popupWin.opener = self;
	}
};
//
// The following functions will become methods of the <textarea>
//
  //
  // Performs a tag action
  //
  DCODE.doTag = function (tag) {
    // If the tag has a hook, use it:
    if (DCODE.hooks[tag]) {
      // Call the function (with scope)
      DCODE.hooks[tag].call (this);
    } else {
      var params = DCODE.tags[tag];
      // Figure out the tag:
      var openTag  = '[' + (params[1] || tag) + ']';
      var closeTag = '[/' + (params[1] || tag) + ']';
      if (tag == 'HR') {
        closeTag = '';
      }
      this.wrapSelection (openTag.toUpperCase (), closeTag.toUpperCase ());
    }
    // For links:
    return false;
  };
  //
  // Wraps a selection with the tags specified.
  //  If there is no close tag then the selection is replaced
  //
  DCODE.wrapSelection = function (openTag, closeTag) {
    // Store some information
    var val = this.value;
    var scr = this.scrollTop;
    // Get the selection start and end
    if (this.selectionStart == undefined) {
      this.focus ();
      var range = document.selection.createRange();
      var stored_range = range.duplicate ();
      stored_range.moveToElementText (el);
      stored_range.setEndPoint ('EndToEnd', range);
      var selStart = stored_range.text.length - range.text.length;
      var selEnd   = selStart + range.text.length;
    } else {
      var selStart = this.selectionStart;
      var selEnd   = this.selectionEnd;
    }
    // Check for extra space and remove it from the selection,
    //  this sometimes happens when you double-click a word
    if (val.charAt ((selEnd - 1)) == ' ' && selEnd != selStart) {
      selEnd --;
    }
    // Build the new content with the tags
    var newVal = {};
    newVal.start = val.substr (0, selStart) + openTag;
    if (closeTag) {
      newVal.sel = val.substr (selStart, selEnd - selStart);
      newVal.end = closeTag + val.substr (selEnd, val.length);
    } else {
      newVal.sel = '';
      newVal.end = val.substr (selEnd, val.length);
    }
    this.value = newVal.start + newVal.sel + newVal.end;
    // Refocus with the new selection
    var newSel = {};
    newSel.start = newVal.start.length;
    newSel.end   = newSel.start + newVal.sel.length;
    // Moz first
    if (window.getSelection) {
      this.setSelectionRange (newSel.start, newSel.end);
    } else {
      // Then IE style
      var t = this.createTextRange ();
      newSel.end   -= newSel.start + this.value.slice (newSel.start + 1, newSel.end).split ('\n').length - 1;
      newSel.start -= this.value.slice (0, newSel.start).split ('\n').length - 1;
      t.move ('character', newSel.start);
      t.moveEnd ('character', newSel.end);
      t.select ();
    }
    this.focus();
    // Restore the scroll (just in case)
    this.scrollTop = scr;
    // For links
    return false;
  };
  //
  // Call this function to have the height automatically adjust to its content.
  // Maximum height is set with "activate", but will default to a decent % of the screen height.
  //
  DCODE.autoHeight = function () {
    // Calculate the size...
    var h = (this.scrollHeight > 75 ? this.scrollHeight : 90);
    if (h > this.maxHeight) {
      this.style.height = this.maxHeight + 'px';
      this.style.overflow = 'auto';
    } else {
      this.style.height = h + 'px';
      this.scrollTop = 0;
    }
  };
//
// Maps the click event on the toolbar links to the <textarea> method
//
DCODE.doClick = function (id, tag) {
  if(document.getElementById (id) != undefined &&  document.getElementById (id).value == undefined){
	  return false;
  }
  el = document.getElementById (id);
  if(document.getElementById (id).className.indexOf("jac-inner-text") != -1){		
	if(document.getElementById (id).value == document.getElementById ("jac_hid_text_comment").value){
		document.getElementById (id).value = "";
	}
  }	
  if(document.getElementById (id).className == "jac-inner-text"){
  }
  el.doTag (tag);
  // For links
  return false;
};
//
// Adds the toolbar to the textarea
//
DCODE.activate = function (id, autoHeight, maxHeight) {
  el = document.getElementById (id);
  // Add the methods to the <textarea>
  el.doTag         = DCODE.doTag;
  el.wrapSelection = DCODE.wrapSelection;
  el.autoHeight    = DCODE.autoHeight;
  // Create the toolbar
  //var d = document.createElement ('DIV');
  //d.className = 'dcode-toolbar';
  // Add the buttons
  //for (n in DCODE.whiteList) {
    //if (DCODE.whiteList[n]) {
      //t = DCODE.tags[n];
     // var tmp = '<a href="#" title="" onclick="return DCODE.doClick (\'' + id + '\', \'' + n + '\');" tabindex="-1"><img src="' + DCODE.path + 'gfx/' + n.toLowerCase () + '.gif" width="25" height="25" /></a>';
      //d.innerHTML += tmp;
    //}
  //};
  //el.parentNode.insertBefore (d, el);
  // Change the class:
  el.className = el.className + " dcode";
  // Auto-Height?
  el.maxHeight = maxHeight || (screen.height < 900) ? screen.height - 250 : 650;
//  if (autoHeight != false) {
//    el.style.overflow = 'hidden';
//    addEventComment (el, "focus", el.autoHeight);
//    addEventComment (el, "keyup", el.autoHeight);
//    el.autoHeight ();
//  }
  // Just in case it's on a link:
  return false;
};
