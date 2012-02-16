/*
 * jquery.atd.js - jQuery powered writing check with After the Deadline
 * Author      : Raphael Mudge, Automattic Inc.
 * License     : LGPL or MIT License (take your pick)
 * Project     : http://www.afterthedeadline.com/developers.slp
 * Contact     : raffi@automattic.com
 *
 * Derived from: 
 *
 * jquery.spellchecker.js - a simple jQuery Spell Checker
 * Copyright (c) 2008 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://jquery-spellchecker.googlecode.com
 * Contact      : willis.rh@gmail.com
 */

var AtD = 
{
   rpc : 'http://www.your_server_here/directory/proxy.php?url=', /* see the proxy.php that came with the AtD/TinyMCE plugin */
   rpc_css : 'http://www.polishmywriting.com/atd_jquery/server/proxycss.php?data=', /* you may use this, but be nice! */
   api_key : '',

   /* these are the categories of errors AtD should ignore */
   ignore_types : ['Bias Language', 'Cliches', 'Complex Expression', 'Diacritical Marks', 'Double Negatives', 'Hidden Verbs', 'Jargon Language', 'Passive voice', 'Phrases to Avoid', 'Redundant Expression'],

   /* these are the phrases AtD should ignore */
   ignore_strings : [],

   setIgnoreStrings : function(string)
   {
      AtD.ignore_strings = string.split(/,/g);
   },

   showTypes : function(string)
   {
      var show_these_types = string.split(/,/g);

      AtD.ignore_types = jQuery.grep(AtD.ignore_types, function(value)
      {
         return jQuery.inArray(value, show_these_types) == -1; 
      });
   },

   checkCrossAJAX : function(container_id, callback_f)
   {
      AtD.callback_f = callback_f; /* remember the callback for later */
      AtD.remove(container_id);
      var container = jQuery('#' + container_id);

      var html = container.html();
      text     = jQuery.trim(container.html());
      text     = encodeURIComponent( text.replace( /\%/g, '%25' ) ); /* % not being escaped here creates problems, I don't know why. */

      /* do some sanity checks based on the browser */
      if ((text.length > 2000 && navigator.appName == 'Microsoft Internet Explorer') || text.length > 7800)
      {
         if (callback_f != undefined && callback_f.error != undefined)
            callback_f.error("Maximum text length for this browser exceeded");

         return;
      }

      /* do some cross-domain AJAX action with CSSHttpRequest */
      CSSHttpRequest.get(AtD.rpc_css + text + "&nocache=" + (new Date().getTime()), function(response)
      {
            /* do some magic to convert the response into an XML document */
            var xml;
            if (navigator.appName == 'Microsoft Internet Explorer') 
            {
               xml = new ActiveXObject("Microsoft.XMLDOM");
               xml.async = false;
               xml.loadXML(response);
            } 
            else 
            {
               xml = (new DOMParser()).parseFromString(response, 'text/xml');
            }

            /* highlight the errors */

            AtD.container = container_id;
            var count = AtD.processXML(container_id, xml);

            if (AtD.callback_f != undefined && AtD.callback_f.ready != undefined)
		AtD.callback_f.ready(count);

            if (count == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
                AtD.callback_f.success(count);

            AtD.counter = count;
            AtD.count   = count;
      });
   },

   /* check a div for any incorrectly spelled words */
   check : function(container_id, callback_f)
   {
      AtD.callback_f = callback_f; /* remember the callback for later */

      AtD.remove(container_id);	
		
      var container = jQuery('#' + container_id);

      var html = container.html();
      text     = jQuery.trim(container.html());
      text     = encodeURIComponent( text ); /* re-escaping % is not necessary here. don't do it */

      jQuery.ajax({
         type : "POST",
         url : AtD.rpc + '/checkDocument',
         data : 'key=' + AtD.api_key + '&data=' + text,
         format : 'raw', 
         dataType : (jQuery.browser.msie) ? "text" : "xml",

         error : function(XHR, status, error) 
         {
            if (AtD.callback_f != undefined && AtD.callback_f.error != undefined)
               AtD.callback_f.error(status + ": " + error);
         },
	
         success : function(data)
         {
            /* apparently IE likes to return XML as plain text-- work around from:
               http://docs.jquery.com/Specifying_the_Data_Type_for_AJAX_Requests */

            var xml;
            if (typeof data == "string") 
            {
               xml = new ActiveXObject("Microsoft.XMLDOM");
               xml.async = false;
               xml.loadXML(data);
            } 
            else 
            {
               xml = data;
            }

            /* on with the task of processing and highlighting errors */

            AtD.container = container_id;
            var count = AtD.processXML(container_id, xml);

            if (AtD.callback_f != undefined && AtD.callback_f.ready != undefined)
		AtD.callback_f.ready(count);

            if (count == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
               AtD.callback_f.success(count);

            AtD.counter = count;
            AtD.count   = count;
         }
      });
   },
	
   remove : function(container_id) 
   {
      AtD._removeWords(container_id, null);
   }
};

AtD.makeError = function(error_s, tokens, type, seps, pre)
{        
   var struct = new Object();
   struct.type = type;
   struct.string = error_s;
   struct.tokens = tokens;

   if (new RegExp(error_s + '\b').test(error_s))
   {
      struct.regexp = new RegExp("(?!"+error_s+"<)" + error_s.replace(/\s+/g, seps) + "\\b");
   }
   else
   {
      struct.regexp = new RegExp("(?!"+error_s+"<)" + error_s.replace(/\s+/g, seps));
   }
   struct.used   = false; /* flag whether we've used this rule or not */

   return struct;
};

AtD.addToErrorStructure = function(errors, list, type, seps)                 
{
   var parent = this;                  

   jQuery.map(list, function(error)
   {
      var tokens = error["word"].split(/\s+/);
      var pre    = error["pre"];
      var first  = tokens[0];

      if (errors['__' + first] == undefined)
      {      
         errors['__' + first] = new Object();
         errors['__' + first].pretoks  = {};
         errors['__' + first].defaults = new Array();
      }

      if (pre == "")  
      {               
         errors['__' + first].defaults.push(parent.makeError(error["word"], tokens, type, seps, pre));
      }
      else         
      {
         if (errors['__' + first].pretoks['__' + pre] == undefined)
         {
            errors['__' + first].pretoks['__' + pre] = new Array();
         }         

         errors['__' + first].pretoks['__' + pre].push(parent.makeError(error["word"], tokens, type, seps, pre));
      }
   });
};

AtD.buildErrorStructure = function(spellingList, enrichmentList, grammarList)
{
   var seps   = this._getSeparators();
   var errors = {};

   this.addToErrorStructure(errors, spellingList, "hiddenSpellError", seps);            
   this.addToErrorStructure(errors, grammarList, "hiddenGrammarError", seps);
   this.addToErrorStructure(errors, enrichmentList, "hiddenSuggestion", seps);
   return errors;
};

AtD._getSeparators = function()
{
   var re = '', i;
   var str = '"s!#$%&()*+,./:;<=>?@[\]^_{|}';

   // Build word separator regexp
   for (i=0; i<str.length; i++)
   {
      re += '\\' + str.charAt(i);
   }

   return "(?:(?:[\xa0" + re  + "])|(?:\\-\\-))+";
};        

AtD.processXML = function(container_id, responseXML)
{
   /* ignored strings */
   var ignore = {};

   jQuery.map(AtD.ignore_strings, function(string)
   {
     ignore[string] = 1;
   }); 

   /* types of errors to ignore */
   var types = {};

   jQuery.map(AtD.ignore_types, function(type)
   {
      types[type] = 1;
   });

   /* save suggestions in the editor object */
   AtD.suggestions = [];

   /* process through the errors */
   var errors = responseXML.getElementsByTagName('error');

   /* words to mark */
   var grammarErrors    = [];
   var spellingErrors   = [];
   var enrichment       = [];

   for (i = 0; i < errors.length; i++)
   {
      if (errors[i].getElementsByTagName('string').item(0).firstChild != null)
      {
         var errorString      = errors[i].getElementsByTagName('string').item(0).firstChild.data;
         var errorType        = errors[i].getElementsByTagName('type').item(0).firstChild.data;
         var errorDescription = errors[i].getElementsByTagName('description').item(0).firstChild.data;

         var errorContext;
         if (errors[i].getElementsByTagName('precontext').item(0).firstChild != null)
         {
            errorContext = errors[i].getElementsByTagName('precontext').item(0).firstChild.data;   
         }
         else
         {
            errorContext = "";
         }

         /* create a hashtable with information about the error in the editor object, we will use this later
            to populate a popup menu with information and suggestions about the error */

         if (ignore[errorString] == undefined)
         {
            var suggestion = {};
            suggestion["description"] = errorDescription;
            suggestion["suggestions"] = [];

            /* used to find suggestions when a highlighted error is clicked on */
            suggestion["matcher"]     = new RegExp('^' + errorString.replace(/\s+/, AtD._getSeparators()) + '$');

            suggestion["context"]     = errorContext;
            suggestion["string"]      = errorString;
            suggestion["type"]        = errorType;

            AtD.suggestions.push(suggestion);

            if (errors[i].getElementsByTagName('suggestions').item(0) != undefined)
            {
               var suggestions = errors[i].getElementsByTagName('suggestions').item(0).getElementsByTagName('option');
               for (j = 0; j < suggestions.length; j++)
               {
                  suggestion["suggestions"].push(suggestions[j].firstChild.data);
               }
            }

            /* setup the more info url */
            if (errors[i].getElementsByTagName('url').item(0) != undefined)
            {
               var errorUrl = errors[i].getElementsByTagName('url').item(0).firstChild.data;
               suggestion["moreinfo"] = errorUrl + '&theme=tinymce';
            }

            if (types[errorDescription] == undefined)
            {
               if (errorType == "suggestion")
                  enrichment.push({ word: errorString, pre: errorContext });

               if (errorType == "grammar")
                  grammarErrors.push({ word: errorString, pre: errorContext });
            }

            if (errorType == "spelling" || errorDescription == "Homophone")
               spellingErrors.push({ word: errorString, pre: errorContext });

            if (errorDescription == 'Cliches')
               suggestion["description"] = 'Clich&eacute;s'; /* done here for backwards compatability with current user settings */
         }
      }
   }

   /* show a dialog if there are no errors */

   var ecount = spellingErrors.length + grammarErrors.length + enrichment.length;

   if (ecount > 0)
   {
      /* build up a data structure so the world will know our greatness!!!! */

      var errorStruct = AtD.buildErrorStructure(spellingErrors, enrichment, grammarErrors);

      /* markup the users text with our nifty markup */

      ecount = AtD.markMyWords(container_id, errorStruct);
   }

   return ecount;
};

AtD.tokenIterate =
{
     init: function(tokens)
     {
        this.tokens = tokens;
        this.index  = 0;
        this.count  = 0;
        this.last   = 0;
     },

     next: function()
     {
        var current = this.tokens[this.index];
        this.count = this.last;
        this.last += current.length + 1;
        this.index++;
        return current;
     },

     hasNext: function()
     {
        return this.index < this.tokens.length;
     },

     hasNextN: function(n)
     {
        return (this.index + n) < this.tokens.length;
     },

     skip: function(m, n)
     {
        this.index += m;
        this.last += n;

        if (this.index < this.tokens.length)
        {
           this.count = this.last - this.tokens[this.index].length;
        }
     },

     getCount: function()
     {
        return this.count;
     },

     peek: function(n)
     {
        var peepers = new Array();
        var end = this.index + n;
        for (var x = this.index; x < end; x++)
        {
           peepers.push(this.tokens[x]);
        }
        return peepers;
     }
};

AtD.useSuggestion = function(word)
{
   AtD.errorElement.text(word);
   AtD.errorElement.replaceWith(AtD.errorElement.html());

   AtD.counter --;
   if (AtD.counter == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
     AtD.callback_f.success(AtD.count);
};

AtD.editSelection = function()
{
   var parent = AtD.errorElement.parent();

   if (AtD.callback_f != undefined && AtD.callback_f.editSelection != undefined)
      AtD.callback_f.editSelection(AtD.errorElement);

   if (AtD.errorElement.parent() != parent)
   {
      AtD.counter --;
      if (AtD.counter == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
         AtD.callback_f.success(AtD.count);
   }
};

AtD.ignoreSuggestion = function()
{
   AtD.errorElement.replaceWith(AtD.errorElement.html());

   AtD.counter --;
   if (AtD.counter == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
      AtD.callback_f.success(AtD.count);
};

AtD.ignoreAll = function(container_id)
{
   var target = AtD.errorElement.text();
   var removed = AtD._removeWords(container_id, target);

   AtD.counter -= removed;

   if (AtD.counter == 0 && AtD.callback_f != undefined && AtD.callback_f.success != undefined)
      AtD.callback_f.success(AtD.count);

   if (AtD.callback_f != undefined && AtD.callback_f.ignore != undefined) 
   {
      AtD.callback_f.ignore(target);
      AtD.ignore_strings.push(target);
   }
};

AtD.explainError = function()
{
   if (AtD.callback_f != undefined && AtD.callback_f.explain != undefined)
      AtD.callback_f.explain(AtD.explainURL);
};

AtD.suggest = function(element)
{
   /* construct the menu if it doesn't already exist */

   if (jQuery('#suggestmenu').length == 0)
   {
      var suggest = jQuery('<div id="suggestmenu"></div>');
      suggest.prependTo('body');
   }
   else
   {
      var suggest = jQuery('#suggestmenu');
      suggest.hide();
   }

   /* find the correct suggestions object */          

   var text = jQuery(element).text();
   var context = jQuery.trim(jQuery(element).attr('pre')).replace(/[\\,!\\?\\."]/g, '');

   var errorDescription;
   var len = AtD.suggestions.length;

   for (var i = 0; i < len; i++)
   {
      var key = AtD.suggestions[i]["string"];           

      if ((context == "" || context == AtD.suggestions[i]["context"]) && AtD.suggestions[i]["matcher"].test(text))
      {
         errorDescription = AtD.suggestions[i];
         break;
      }
   }

   /* build up the menu y0 */

   AtD.errorElement = jQuery(element);

   suggest.empty();

   if (errorDescription == undefined)
   {
      suggest.append('<strong>No suggestions</strong>');
   }
   else if (errorDescription["suggestions"].length == 0)
   {
      suggest.append('<strong>' + errorDescription['description'] + '</strong>');
   }
   else
   {
      suggest.append('<strong>' + errorDescription['description'] + '</strong>');

      for (var i = 0; i < errorDescription["suggestions"].length; i++)
      {
         (function(sugg)
         {
            suggest.append('<a href="javascript:AtD.useSuggestion(\'' + sugg + '\')">' + sugg + '</a>');
         })(errorDescription["suggestions"][i]);
      }
   }

   /* do the explain menu if configured */

   if (AtD.callback_f != undefined && AtD.callback_f.explain != undefined && errorDescription['moreinfo'] != undefined)
   {
      suggest.append('<a href="javascript:AtD.explainError()" class="spell_sep_top">Explain...</a>');
      AtD.explainURL = errorDescription['moreinfo'];
   }

   /* do the ignore option */

   suggest.append('<a href="javascript:AtD.ignoreSuggestion()" class="spell_sep_top">Ignore suggestion</a>');

   /* add the edit in place and ignore always option */

   if (AtD.callback_f != undefined && AtD.callback_f.editSelection != undefined)
   {
      if (AtD.callback_f != undefined && AtD.callback_f.ignore != undefined)
         suggest.append('<a href="javascript:AtD.ignoreAll(\'' + AtD.container + '\')">Ignore always</a>');
      else
         suggest.append('<a href="javascript:AtD.ignoreAll(\'' + AtD.container + '\')">Ignore all</a>');
 
      suggest.append('<a href="javascript:AtD.editSelection(\'' + AtD.container + '\')" class="spell_sep_bottom spell_sep_top">Edit Selection...</a>');
   }
   else
   {
      if (AtD.callback_f != undefined && AtD.callback_f.ignore != undefined)
         suggest.append('<a href="javascript:AtD.ignoreAll(\'' + AtD.container + '\')" class="spell_sep_bottom">Ignore always</a>');
      else
         suggest.append('<a href="javascript:AtD.ignoreAll(\'' + AtD.container + '\')" class="spell_sep_bottom">Ignore all</a>');
   }

   /* show the menu */

   var pos = jQuery(element).offset();
   var width = jQuery(element).width();
   jQuery(suggest).css({ left: (pos.left + width) + 'px', top: pos.top + 'px' });

   jQuery(suggest).fadeIn(200);

   /* bind events to make the menu disappear when the user clicks outside of it */

   AtD.suggestShow = true;

   setTimeout(function()
   {
      jQuery("body").bind("click", function()
      {
         if (!AtD.suggestShow)
         {
            jQuery('#suggestmenu').fadeOut(200);      
         }
      });
   }, 1);

   setTimeout(function()
   {
      AtD.suggestShow = false;
   }, 2); 
}

AtD.markMyWords = function(container_id, errors)
{
   var seps  = new RegExp(this._getSeparators());
   var nl = new Array();
   var ecount = 0; /* track number of highlighted errors */

   /* Collect all text nodes */             
   /* Our goal--ignore nodes that are already wrapped */

   this._walk(container_id, function(n)
   {   
      if (n.nodeType == 3 && !jQuery(n).hasClass("hiddenSpellError") && !jQuery(n).hasClass("hiddenGrammarError") && !jQuery(n).hasClass("hiddenSuggestion"))
      {
         nl.push(n);  
      }
   });

   /* walk through the relevant nodes */

   var tokenIterate = this.tokenIterate;

   jQuery.map(nl, function(n)
   {
      var v;

      if (n.nodeType == 3)
      {
         v = n.nodeValue; /* we don't want to mangle the HTML so use the actual encoded string */
         var tokens = n.nodeValue.split(seps); /* split on the unencoded string so we get access to quotes as " */

         var previous = "";

         var doReplaces = [];

         tokenIterate.init(tokens);

         while (tokenIterate.hasNext())
         {
            var token = tokenIterate.next();
            var current  = errors['__' + token];
            var defaults;

            if (current != undefined && current.pretoks != undefined)
            {
               defaults = current.defaults;
               current = current.pretoks['__' + previous];

               var done = false;
               var prev, curr;

               prev = v.substr(0, tokenIterate.getCount());
               curr = v.substr(prev.length, v.length);

               var checkErrors = function(error)
               {
                  if (!done && error != undefined && !error.used && error.regexp.test(curr))
                  {
                     var oldlen = curr.length;

                     doReplaces.push([error.regexp, '<span class="'+error.type+'" pre="'+previous+'" onClick=\"AtD.suggest(this);\">$&</span>']);

                     error.used = true;
                     done = true;

                     tokenIterate.skip(error.tokens.length - 1, 0);
                     token = error.tokens[error.tokens.length - 1]; /* make sure the "previous" token is set to the right value at the end of the loop */
                  }
               };

               if (current != undefined)
               {
                  previous = previous + ' ';
                  jQuery.map(current, checkErrors);
               }

               if (!done)
               {
                  previous = '';
                  jQuery.map(defaults, checkErrors);
               }
            }

            previous = token;
         }

         /* do the actual replacements on this span */
         if (doReplaces.length > 0)
         {
            newNode = n;

            for (var x = 0; x < doReplaces.length; x++)
            {
               var regexp = doReplaces[x][0], result = doReplaces[x][1];

               /* it's assumed that this function is only being called on text nodes (nodeType == 3), the iterating is necessary
                  because eventually the whole thing gets wrapped in an mceItemHidden span and from there it's necessary to 
                  handle each node individually. */
               var bringTheHurt = function(node)
               {
                  if (node.nodeType == 3)
                  {
                     ecount++;

                     /* sometimes IE likes to ignore the space between two spans, solution is to insert a placeholder span with
                        a non-breaking space.  The markup removal code substitutes this span for a space later */
                     if (navigator.appName == 'Microsoft Internet Explorer' && node.nodeValue.length > 0 && node.nodeValue.substr(0, 1) == ' ')
                     {
                      	return jQuery('<span class="mceItemHidden"><span class="mceItemHidden">&nbsp;</span>' + node.nodeValue.substr(1, node.nodeValue.length - 1).replace(regexp, result) + '</span>');
                     }
                     else
                     {
                        return jQuery('<span class="mceItemHidden">' + node.nodeValue.replace(regexp, result) + '</span>');
                     }
                  }
                  else
                  {
                     var contents = jQuery(node).contents();

                     for (var y = 0; y < contents.length; y++)
                     {
                        if (contents[y].nodeType == 3 && regexp.test(contents[y].nodeValue))
                        {
                           var nnode = contents[y].nodeValue.replace(regexp, result);
                           jQuery(contents[y]).replaceWith(nnode);

                           ecount++;

                           return node; /* we did a replacement so we can call it quits, errors only get used once */
                        }
                     }

                     return node;
                  }
               };

               newNode = bringTheHurt(newNode);            
            }

            jQuery(n).replaceWith(newNode);
         }
      }
   });

   return ecount;
};

/* this is a helper function to walk the DOM */
AtD._walk = function(container_id, f)
{
   var elements = jQuery('#' + container_id).contents();
   AtD.__walk(elements, f);
};

AtD.__walk = function(elements, f)
{
   var i;
   for (i = 0; i < elements.length; i++)
   {
      f.call(f, elements[i]);   
      AtD.__walk(jQuery(elements[i]).contents(), f);
   }
};

AtD._removeWords = function(container_id, w)     
{    
   var count = 0;  
   var elements = jQuery('#' + container_id).find('span');

   jQuery.map(jQuery.makeArray(elements).reverse(), function(n)
   {
      if (n && (jQuery(n).hasClass('hiddenGrammarError') || jQuery(n).hasClass('hiddenSpellError') || jQuery(n).hasClass('hiddenSuggestion') || jQuery(n).hasClass('mceItemHidden')))
      {
         if (n.innerHTML == '&nbsp;')
         {
            jQuery(n).replaceWith(' ');
         }
         else if (!w || n.innerHTML == w)
         {
            jQuery(n).replaceWith(jQuery(n).html());
            count++;
         }            
      }
   });    

   return count;
};
