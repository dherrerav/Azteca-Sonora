(function(){tinymce.create('tinymce.plugins.StylePlugin',{init:function(ed,url){ed.addCommand('mceStyleProps',function(){ed.windowManager.open({file:ed.getParam('site_url')+'index.php?option=com_jce&view=editor&layout=plugin&plugin=style',width:620+parseInt(ed.getLang('style.delta_width',0)),height:340+parseInt(ed.getLang('style.delta_height',0)),inline:1},{plugin_url:url,style_text:ed.selection.getNode().style.cssText})});ed.addCommand('mceSetElementStyle',function(ui,v){if(e=ed.selection.getNode()){ed.dom.setAttrib(e,'style',v);ed.execCommand('mceRepaint')}});ed.onNodeChange.add(function(ed,cm,n){cm.setDisabled('styleprops',n.nodeName==='BODY')});ed.addButton('style',{title:'style.desc',cmd:'mceStyleProps'})},getInfo:function(){return{longname:'Style',author:'Moxiecode Systems AB',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/style',version:tinymce.majorVersion+"."+tinymce.minorVersion}}});tinymce.PluginManager.add('style',tinymce.plugins.StylePlugin)})();