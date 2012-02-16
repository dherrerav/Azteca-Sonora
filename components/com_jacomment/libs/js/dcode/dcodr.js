/************ DCODR - Enhanced CTRL+C features ************\
             Courtesy of http://oopstudios.com/
 Intercepts CTRL+C and modifies the user-selection so that
  instead of plain text, DCODE formatting is sent to the
  clipboard! Well handy for forums etc...
 You can append certain variables (only one at the moment)
  when including this script to modify its behaviour:
   * nocopyevents
  for example:
 /dcode/dcode.js?nocopyevents
\**********************************************************/

DCODR = {};
// Create the prefs object
DCODR.prefs = {};
// Path to self
s = document.getElementsByTagName ('script');
for (var i=0, n=s.length; i<n; i++) {
  if (s[i].src.match ('dcodr.js')) {
    // Index
    var n = s[i].src.lastIndexOf ("dcodr.js");
    // Base path
    DCODR.path = s[i].src.substring (0, n);
    // Have we passed any vars?
    var v = s[i].src.substring (n).split ("?");
    if (v.length > 1) {
      // Add the prefs
      v = v[1].split ("&");
      for (p=0; p<v.length; p++) {
        DCODR.prefs[v[p]] = true;
      }
    }
    // Done
    break;
  }
}
//
// The regex to convert HTML into DCODE
//  Note that extra work has been put in to make sure that the formatting
//   is visually appealing, especially with newlines!!
//  Also note that it assumes all line-breaks have been removed already!
//
DCODR.regx = [
  // Pre-cleaning
    { regx: /<script[^>]*>.*<\/script>/gi, tag: '' },    // Script tags
    { regx: /<style[^>]*>.*<\/style>/gi,   tag: '' },    // Style tags
    { regx: /<br(\s+[^>]*)?>/gi,           tag: '\n' },  // BR's are OK
    { regx: /\[/gi,                        tag: '\\[' }, // Escape brackets
    { regx: /<img(\s+[^>]*)?class="dlink_icon"(\s+[^>]*)?>/gi, tag: '' }, // Ignore DLINK icons
  // Inline elements
    { regx: /<(\/?)(b|strong)(\s+[^>]*)?>/gi, tag: '[$1B]' }, // Bold
    { regx: /<(\/?)(i|em)(\s+[^>]*)?>/gi,     tag: '[$1I]' }, // Italic
    { regx: /<(\/?)(u)(\s+[^>]*)?>/gi,        tag: '[$1U]' }, // Underline
    { regx: /<(\/?)(s|strike)(\s+[^>]*)?>/gi, tag: '[$1S]' }, // Strike
  // Advanced inline elements
    { regx: /<a(\s+[^>]*)?href="(mailto\:\s*)?([^"]*)"(\s+[^>]*)?>/gi,  tag: '[LINK=$3]' }, // Links
    { regx: /<\/a>/gi,                                    tag: '[/LINK]' },                 // Links
    { regx: /<img(\s+[^>]*)?src="([^"]*)"(\s+[^>]*)?>/gi, tag: '[IMG]$2[/IMG]' }, // Images
  // Block elements
    { regx: /<(h1|h2|h3)(\s+[^>]*)?>/gi, tag: '\n[LARGE]' },   // Large
    { regx: /<\/(h1|h2|h3)>/gi,          tag: '[/LARGE]\n' },  // Large
    { regx: /<(h4|h5|h6)(\s+[^>]*)?>/gi, tag: '\n[MEDIUM]' },  // Medium
    { regx: /<\/(h4|h5|h6)>/gi,          tag: '[/MEDIUM]\n' }, // Medium
    { regx: /<hr(\s+[^>]*)?>/gi,         tag: '\n[HR]\n' },    // HR
  // Lists
    { regx: /<uli>/gi,   tag: '\n[*]' },  // Unordered
    { regx: /<\/uli>/gi, tag: '[/*]\n' }, // Unordered
    { regx: /<oli>/gi,   tag: '\n[#]' },  // Ordered
    { regx: /<\/oli>/gi, tag: '[/#]\n' }, // Ordered
    { regx: /\[\/\*\]\s{2,}\[\*\]/gi, tag: '[/*]\n[*]' }, // Tidy 
    { regx: /\[\/#\]\s{2,}\[#\]/gi,   tag: '[/#]\n[#]' }, // Tidy
  // Post-cleaning
    { regx: /<(\/?)(p)(\s+[^>]*)?>/gi,      tag: '\n' },   // P tags (breaks)
    { regx: /<\/?[^>]*>/gi,                 tag: '' },     // Rid other tags
    { regx: /</gi,                          tag: '&lt;' }, // <
    { regx: />/gi,                          tag: '&gt;' }, // >
    { regx: /(\n\n+)/g,                     tag: '\n\n' }, // Fix multibreaks
    { regx: /(\n[\f\t\v ]*|[\f\t\v ]*\n)/g, tag: '\n' },   // Trim whitespace (per line)
    { regx: /^\s+|\s+$/g,                   tag: '' }      // Trim whitespace
];
//
// Gets the HTML of the selection
//
DCODR.getHTML = function () {
  var userSelection;
  if (window.getSelection) {
    // W3C Ranges
    userSelection = window.getSelection ();
    // Get the range:
    if (userSelection.getRangeAt)
      var range = userSelection.getRangeAt (0);
    else {
      var range = document.createRange ();
      range.setStart (userSelection.anchorNode, userSelection.anchorOffset);
      range.setEnd (userSelection.focusNode, userSelection.focusOffset);
    }
    // And the HTML:
    var clonedSelection = range.cloneContents ();
    var div = document.createElement ('div');
    div.appendChild (clonedSelection);
    return div.innerHTML;
  } else if (document.selection) {
    // Explorer selection, return the HTML
    userSelection = document.selection.createRange ();
    return userSelection.htmlText;
  } else {
    return '';
  }
};
//
// Formats HTML into DCODE
//
DCODR.formatHTML = function (html, fixIE) {
  // Remove newlines and attributes
  html = html.replace (/(\r|\n)/g, '');
  // Is explorer "normalising" my closing </li> tags?
  if (fixIE && navigator.userAgent.indexOf ("MSIE") != -1) {
    // Convert <li> to </li><li>
    html = html.replace (/<li(\s+[^>]*)?>/gi, '</li><li>');
    // Then remove any that double up with the opening tag
    html = html.replace (/(<(ul|ol)(\s+[^>]*)?>)\s*<\/li>/gi, '$1');
  }
  //
  // Differentiate between <ul> and <ol>
  //  A bottleneck to be sure!
  //
  html = html.replace (/<(ul|ol|li)(\s+[^>]*)?>/gi, '<$1>'); // No attributes
  html = html.replace (/<(\/?)(LI|Li|lI)>/g, '<$1li>'); // Lowercase <li> tags
  if (html.indexOf ("<ul>") != -1 || html.indexOf ("<ol>") != -1) {
    while (html.indexOf ("</li>") != -1) {
      // Convert all <li> into either <uli> or <oli> depending upon their wrapper
      html = html.replace (/<(ul|ol)>(.*?)<(\/?)li>/gi, '<$1>$2<$3$1i>');
    }
  } else {
    // Convert all <li> into <uli> regardless
    html = html.replace (/<(\/?)li>/gi, '<$1uli>');
  }
  // Convert to DCODE style:
  for (j=0; j<DCODR.regx.length; j++) {
    html = html.replace (DCODR.regx[j].regx, DCODR.regx[j].tag);
  }
  // And relax
  return html;
};
//
// The "hidden" (but interactable) textarea for copy interception
//
DCODR.timer = 0;
DCODR.clip = document.createElement ("DIV");
DCODR.clip.innerHTML = "<div id=\"DCODR-clip\" style=\"background: #D5BCE6; color: #282828; text-align: center; font-weight: bold; position: fixed; top: 0; left: 50%; width: 180px; margin: 0 0 0 -90px; height: 20px; overflow: hidden; line-height: 20px; font-size: 13px;\">"+JACommentConfig.txtCopiedDecode+"</div>";
//
// Keystroke detection (wait for CTRL+C)
//
DCODR.doKey = function (e) {
  // The event:
  if (!e) var e = window.event;
  // Whats the code?
  cd = e.charCode || e.keyCode || e.which;
  // The modifiers...
  if (e.modifiers) {
    e.altKey   = e.modifiers & Event.ALT_MASK;
    e.ctrlKey  = e.modifiers & Event.CONTROL_MASK;
    e.shiftKey = e.modifiers & Event.SHIFT_MASK;
    e.metaKey  = e.modifiers & Event.META_MASK;
  }
  // Give me the correct modifiers!
  if ((e.ctrlKey || e.metaKey) && (!e.altKey && ! e.shiftKey)) {
    // Give me a C!
    if (cd == 67) {
      // Get the HTML
      var html = DCODR.getHTML ();
      // Format it
      html = DCODR.formatHTML (html, true);
      //
      // Now for the really magic part, copying the new value.
      //  To copy the DCODE I create a textarea with the desired content,
      //   give it focus and allow the event to bubble up as usual!
      // There's multiple nests to solve a few problems with display and
      //  linefeeds on IE. But no worries, it *is* clean and OK!
      //
      // Make sure the clip element has been added to the DOM
      if (!document.getElementById ("DCODR-clip")) {
        document.body.appendChild (DCODR.clip);
      }
      var clip = document.getElementById ("DCODR-clip");
      // Remove the old "textarea" from clip
      if (document.getElementById ("DCODR-div")) {
        var el = document.getElementById ("DCODR-div");
        clip.removeChild (el);
      }
      // Create the new "textarea"
      var el = document.createElement ("div");
      el.id = "DCODR-div";
      el.innerHTML = "<textarea id=\"DCODR-textarea\" style=\"position: absolute; top: 0px; left: 0px; width: 1px; height: 1px;\">" + html + "</textarea>";
      // Add it and select it
      clip.appendChild (el);
      var el = document.getElementById ("DCODR-textarea");
      el.select ();
      el.focus ();
      // Tell it to bugger off in a mo...
      el = document.getElementById ("DCODR-clip");
      el.style.height = "20px";
      clearTimeout (DCODR.timer);
      DCODR.timer = setTimeout (function () { el = document.getElementById ("DCODR-clip"); el.style.height = "0px"; }, 1500);
    }
  }
};
//
// Automatically add the key event to the page?
//
if (!DCODR.prefs["nocopyevents"]) {
  if (document.attachEvent) document.attachEvent ("onkeydown", DCODR.doKey);
  else document.addEventListener ("keydown", DCODR.doKey, false);
}
