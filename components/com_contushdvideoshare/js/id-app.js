identity=identity||{};identity.app=function(){var r={},model={},view={},controller={},validation={},panel,mask,glow="",$,addListener,removeListener,statusListenerIds={},cancelListenerId,userfeedback,lang=[],panelState="closed";var css_class_panelSpinner="id-panel-working",css_class_panelAnimating="id-panel-animating",css_class_formSpinner="working-spinner",css_class_panelContent="c",css_class_panelNoHeader="panel-noHeader",css_class_panelContentHead="hd",css_class_panelContentFoot="ft",css_id_signinForm_username="bbcid_username",css_id_signinForm_password="bbcid_password",css_id_signinForm_remember_me="bbcid_remember_me",css_id_status="id-status",css_element_status=["#",css_id_status].join(""),css_element_notificationArea="#blq-pre-mast",css_element_notificationClose="#idNotifyClose",css_element_panel=".panel-identity",css_element_panelContent=[css_element_panel," .",css_class_panelContent].join(""),css_element_formSpinner=[css_element_panel," .working-spinner"].join(""),css_element_backLink=[css_element_panel," a.id-back"].join(""),css_element_signinLink=[css_element_panel," a.id-signin"].join(""),css_element_signinLink_span=[css_element_signinLink," span"].join(""),css_element_registerLink=[css_element_panel," a.id-register"].join(""),css_element_registerLink_span=[css_element_registerLink," span"].join(""),css_element_helpLink=[css_element_panel," a.id-help"].join(""),css_element_explainLink=[css_element_panel," .id-explain-dob a"].join(""),css_element_termsLink=[css_element_panel," a.id-terms"].join(""),css_element_termsLink_span=[css_element_termsLink," span"].join(""),css_element_signinForm=[css_element_panel," #id-signin-form"].join(""),css_element_signinForm_username=[css_element_signinForm," input#",css_id_signinForm_username].join(""),css_element_signinForm_password=[css_element_signinForm," input#",css_id_signinForm_password].join(""),css_element_signinForm_remember_me=[css_element_signinForm," input#",css_id_signinForm_remember_me].join(""),css_element_cancelButton=[css_element_panel," #id-actions .negative"].join(""),css_element_buttonSubmit=[css_element_panel," #id-actions .positive"].join(""),css_element_status_signinLink="a#idSignin";var status_url=["/users/widget/status/?ptrt=",window.location].join("");var default_locale="en-GB";function _getUrlArgsFromEvent(eventObj){var urlParts=eventObj.attachedTo.href.split("?"),params="";if(urlParts.length==2){params="?"+urlParts[1]}return params}var Controller=function(){this.views={};this.currentView=""};Controller.prototype.getView=function(viewName,locale){locale=locale||default_locale;this.views[locale]=this.views[locale]||[];if(!(viewName in this.views[locale])&&view[viewName]){this.views[locale][viewName]=new view[viewName](controller);this.views[locale][viewName].setLocale(locale);this.loadErrorCodes(locale)}return this.views[locale][viewName]};Controller.prototype.emptyViewCache=function(){var localeIndex,viewIndex,view;for(localeIndex in this.views){for(viewIndex in this.views[localeIndex]){view=this.views[localeIndex][viewIndex];view.emptyCache()}}};Controller.prototype.getLocaleFromUrl=function(url){return identity.util.getArgsFromUrl(url)["loc"]||false};Controller.prototype.getLocaleFromFormElement=function(element){var form,action;element=$(element);if(element.is("form")){action=element[0].action}else{try{action=element.ancestors().filter(function(){return $(this).is("form")?true:false})[0].action}catch(exception){}}return action?this.getLocaleFromUrl(action):undefined};Controller.prototype.isDate16YearsAgo=function(day,month,year){if(day>0&&month>0&&year>0){var now=new Date();if((now.getFullYear()-year)>16){return false}else{if((now.getFullYear()-year)<16){return true}else{if((now.getMonth()+1)>month){return false}else{if((now.getMonth()+1)<month){return true}else{if(now.getDate()>=day){return false}else{if(now.getDate()<day){return true}}}}}}}else{return false}};Controller.prototype.scrollToEventLinkTarget=function(e){if(typeof e!="undefined"){var originator=$(e.attachedTo);var href=originator.attr("href");if(originator.length&&href){target=href.substring(href.indexOf("#"));if(href.indexOf("#")!=-1&&target.length){var scrolltop=identity.util.getScrollPosition("y");window.location=target;window.scrollTo(0,scrolltop)}}}};Controller.prototype.decodeSecureFormCookie=function(data,fieldNames){if(!data.match(/^[ulsgmvhfe]$/i)&&!data.match(/^mm$/i)&&!data.match(/^[abc](\|[a-z]{2}([a-z]{2})?)+$/i)){return false}var json={};data=data.split("|");if(data[0]=="u"){controller.handleUpgrade()}else{if(data[0]=="l"){controller.handleAccountLocked()}else{if(data[0]=="s"){controller.handleSessionExpired(controller.currentView.getLocale())}else{if(data[0]=="g"){controller.handleAgeMismatch()}else{if(data[0]=="m"){controller.handleMoreDetails()}else{if(data[0]=="v"){controller.handleValidation()}else{if(data[0]=="h"){controller.handleHouseRules()}else{if(data[0]=="f"){controller.handleSigninFail()}else{if(data[0]=="e"){controller.handleServiceError(controller.currentView.getLocale())}else{if(data[0]=="mm"){controller.handleMaintenanceModeError()}else{if(data[0]=="a"){json._error=true;json._valid=false}else{if(data[0]=="b"){json._error=false;json._valid=false}else{if(data[0]=="c"){json._error=false;json._valid=true}}}}}}}}}}}}}for(var i=1;i<data.length;i++){var field=data[i].charAt(0);var fieldstatus=data[i].charAt(1);var fieldhint=(data[i].length>2)?lang[this.currentView.getLocale()][data[i].substr(2,2)]:"";field=fieldNames[field];json[field]={};if(fieldstatus=="a"){json[field]._error=true;json[field]._valid=false}else{if(fieldstatus=="b"){json[field]._error=false;json[field]._valid=false}else{if(fieldstatus=="c"){json[field]._error=false;json[field]._valid=true}}}json[field].container=["#bbcid_",field,"_container"].join("");json[field].message=fieldhint;json[field].messageContainer=["#bbcid_",field,"_container .hint"].join("")}return json};Controller.prototype.handleUpgrade=function(e){var url=[idProperties.secureServer,"/users/upgrade"].join("");window.location=url};Controller.prototype.handleSigninFail=function(e){var url=[idProperties.secureServer,"/users/signin/fail"].join("");window.location=url};Controller.prototype.handleServiceError=function(locale){var thisView=this.getView("ServiceErrorView",locale);thisView.setContentParameters("?loc="+locale);thisView.nonJSEquiv=["/users/error/serviceerror?ptrt=",window.location,"&loc=",locale].join("");thisView.show()};Controller.prototype.handleMaintenanceModeError=function(locale){var thisView=this.getView("MaintenanceModeView",locale);thisView.setContentParameters("?loc="+locale);thisView.nonJSEquiv=["/users/error/maintenancemode?ptrt=",window.location,"&loc=",locale].join("");thisView.show()};Controller.prototype.handleSignin=function(e){if(e){e.preventDefault()}var locale=this.getLocaleFromUrl(e.attachedTo);var thisView=this.getView("SigninView",locale);thisView.nonJSEquiv=[idProperties.secureServer,"/users/signin?ptrt=",window.location].join("");thisView.show()};Controller.prototype.handleAccountLocked=function(e){var url=[idProperties.secureServer,"/users/signin/locked"].join("");window.location=url};Controller.prototype.handleSessionExpired=function(locale){var thisView=this.getView("SessionExpiredView",locale);thisView.setContentParameters("?loc="+locale);thisView.nonJSEquiv=["/users/error/sessionexpired?ptrt=",window.location,"&loc=",locale].join("");thisView.show()};Controller.prototype.handleAgeMismatch=function(e){var url=[idProperties.secureServer,"/users/signin/age"].join("");window.location=url};Controller.prototype.handleMoreDetails=function(e){var url=[idProperties.secureServer,"/users/signin/more"].join("");window.location=url};Controller.prototype.handleValidation=function(e){var url=[idProperties.secureServer,"/users/signin/validate"].join("");window.location=url};Controller.prototype.handleHouseRules=function(e){var url=[idProperties.secureServer,"/users/signin/houserules"].join("");window.location=url};Controller.prototype.handleSigninFormSubmit=function(e){var ctrl=this,locale=ctrl.getLocaleFromFormElement(e.attachedTo);var thisView=this.getView("SigninView",locale);if(e){e.preventDefault()}thisView.validation.validate("submit",{onSuccess:function(){var sf=new identity.forms.SecureForm(thisView.config.secureFormSettings.form,{secureUrl:thisView.config.secureFormSettings.secureUrl,handleResult:function(args){thisView.hideFormSpinner();if(args._valid){var e=new glow.events.Event();glow.events.fire(identity,"signin",e)}else{ctrl.getView("SigninView",locale).validation.processValidationResult({validationResult:args,event:""});controller.handleErrorFailures()}}});thisView.showFormSpinner();sf.submit(function(data,fieldnames){return ctrl.decodeSecureFormCookie(data,fieldnames)})},onFailure:function(){controller.handleErrorFailures()}})};Controller.prototype.handleSigninFormUsernameBlur=function(e){var locale=this.getLocaleFromFormElement(e.attachedTo);this.getView("SigninView",locale).validation.validate("blur",{id:css_id_signinForm_username,onFailure:controller.handleErrorFailures,onSuccess:function(){controller.handleErrorSuccess(css_id_signinForm_username)}})};Controller.prototype.handleSigninFormPasswordBlur=function(e){var locale=this.getLocaleFromFormElement(e.attachedTo);this.getView("SigninView",locale).validation.validate("blur",{id:css_id_signinForm_password,onFailure:controller.handleErrorFailures,onSuccess:function(){controller.handleErrorSuccess(css_id_signinForm_password)}})};Controller.prototype.handleOpenHelpDrawer=function(e){if(e){e.preventDefault()}var self=this;glow.net.get("/users/help.js",{onLoad:function(response){panel.getDrawer().update(["<div>",response.text(),"</div>"].join("")).open({onComplete:function(){self.scrollToEventLinkTarget(e)}})}})};Controller.prototype.handleOpenTermsDrawer=function(e){var self=this;if(e){e.preventDefault()}glow.net.get("/users/register/terms.js",{onLoad:function(response){panel.getDrawer().update(["<div>",response.text(),"</div>"].join("")).open({onComplete:function(){self.scrollToEventLinkTarget(e)}})}})};Controller.prototype.handleCloseDrawer=function(e){if(e){e.preventDefault()}panel.getDrawer().close()};Controller.prototype.handleShowDrawer=function(e){if(e){e.preventDefault()}panel.getDrawer().show()};Controller.prototype.handleHideDrawer=function(e){if(e){e.preventDefault()}panel.getDrawer().hide()};Controller.prototype.handleErrorFailures=function(){$("form.id-form .error").filter(function(){return $(this).is("input, select, textarea")?false:true}).each(function(i){var element=$(this),hint=element.get(".hint"),context=element.get("input, select").filter(function(i){return $(this).attr("type")!="hidden"});context.each(function(){userfeedback.hide("hint",$(this).attr("id"))});userfeedback.error(hint.text(),context).show()})};Controller.prototype.handleErrorSuccess=function(key){userfeedback.hide("error",key)};Controller.prototype.removeAllErrors=function(){userfeedback.hideAll();userfeedback.flushRegister()};Controller.prototype.loadErrorCodes=function(locale){if(!(locale in lang)){glow.net.get("/users/configuration/error_codes.json?loc="+locale,{onLoad:function(r){var response=r.json();if(response.codes){lang[locale]=response.codes}},onError:function(r){}})}};view.View=function(controller){this.controller=controller;this.loaded=false;this.contentUrlParams="";this.locale=default_locale;userfeedback.hideAll()};view.View.prototype.setContentParametersFromEvent=function(eventObj){this.setContentParameters(_getUrlArgsFromEvent(eventObj));return this};view.View.prototype.setContentParameters=function(params){this.contentUrlParams=params;return this};view.View.prototype.setLocale=function(locale){this.locale=locale;return this};view.View.prototype.getLocale=function(){return this.locale};view.View.prototype.show=function(){this.controller.removeAllErrors();if(panelState=="closed"){mask=(typeof mask=="undefined")?(new glow.widgets.Mask()):mask;var status=$(css_element_status)}else{if(controller.currentView&&controller.currentView.validation){controller.currentView.validation.stopAll()}}if(typeof (panel)=="undefined"){panel=new idPanel(glow.dom.create("<p></p>"),{closeOnMaskClick:false,width:"355px",theme:"identity",mask:mask});if(window.location.pathname.match(/^\/cbbc($|\/)/)){panel.container.addClass("bbcid-cbbc-panel")}}var self=this;var onDrawerReady=function(){var prevHeight=panel.container.get(css_element_panelContent).height();panel.hideContent();if(panelState!="open"){panel.container.get(css_element_panel).css("width","100px").parent().css("width","100px").get([".",css_class_panelContent].join("")).css("height","65px")}else{panel.container.get(css_element_panelContent).css("height",prevHeight)}self.showSpinner();panel.container.addClass(css_class_panelAnimating);if(!self.loaded||self.config.useViewCache===false){identity.status.showSpinner();if(!self.loaded){panelState="loading";glow.net.get(self.configUrl+self.contentUrlParams,{onLoad:function(r){self.config=r.json();self.show_pt2()},onError:function(){},timeout:6000})}else{self.show_pt2()}}else{self.show_pt3()}};if(panel.hasDrawer()){panel.getDrawer().close({onComplete:onDrawerReady})}else{onDrawerReady()}};view.View.prototype.show_pt2=function(){if(!this.loaded||this.config.useViewCache===false){panelState="loading";var self=this,showPanelWithData=function(data){this.config.content=data.text();this.config.saveState="";identity.status.hideSpinner();this.show_pt3()};glow.net.get([this.config.contentUrl,this.contentUrlParams].join(""),{onLoad:function(data){showPanelWithData.call(self,data)},onError:function(data){controller.decodeSecureFormCookie(identity.util.getCookie("IDENTITY-ERRORS").split("*")[2])}})}else{this.show_pt3()}};view.View.prototype.show_pt3=function(){panel.showContent();if(!this.loaded||this.config.useViewCache===false){this.loaded=true}if(this.controller.currentView){this.controller.currentView.removeListeners()}var newContent;if(this.config.saveState!==""){newContent=glow.dom.create(this.config.saveState);this.config.saveState=""}else{newContent=glow.dom.create(this.config.content)}var labels=newContent.get("label");labels.each(function(){if($(this).get("span.hint").length===0){$(this).append('<span class="hint"><span class="t"></span><span class="b"></span></span>')}});var self=this;panel.showWith(newContent,{width:this.config.width,callback:function(){panel.container.removeClass(css_class_panelAnimating);self.hideSpinner();self.show_pt4()}})};view.View.prototype.show_pt4=function(){if(!this.validation&&this.config.validation){this.validation=new identity.forms.Validator({onFailure:controller.handleErrorFailures});this.validation.parseChecksObject(this.config.validation)}panel.show();this.eventListenerIds=[];this.addEvents();this.controller.currentView=this;panel.newpanel=false;identity.app.fixLayout();panel.setPosition();if(glow.env.ie&&glow.env.ie<=7){panel.content.get("div.c").css("zoom",1)}panelState="open";var self=this;setTimeout(function(){self.sendFocus()},50)};view.View.prototype.hide=function(e){if(e){e.preventDefault()}if(panelState=="open"){panelState="close_anim";panel.container.addClass(css_class_panelAnimating);panel.newpanel=true;if(controller.currentView.validation){controller.currentView.validation.stopAll()}controller.handleHideDrawer();controller.removeAllErrors();this.removeListeners();var self=this;panel.hide();panelState="closed"}};view.View.prototype.sendFocus=function(){var focusElement=$(this.config.focusId);if(focusElement.length){focusElement[0].focus()}};view.View.prototype.removeListeners=function(){for(var eid in this.eventListenerIds){glow.events.removeListener(this.eventListenerIds[eid])}};view.View.prototype.saveState=function(){panel.body.get("input, select, textarea").each(function(){var formItem=glow.dom.get(this);var itemType=formItem.attr("type");if(itemType=="text"||itemType=="password"){formItem.attr("value",formItem.val())}else{if(itemType=="checkbox"||itemType=="radio"){if(typeof (formItem.val())=="string"){formItem.attr("checked","checked")}else{formItem.removeAttr("checked")}}else{if(formItem.is("select")){formItem.get("option").each(function(){var thisOpt=$(this);if(formItem.val()==thisOpt.attr("value")){formItem.attr("selected","selected")}else{formItem.removeAttr("selected")}})}else{if(formItem.is("textarea")){formItem.html(formItem.val())}}}}});var panelHeader=panel.header.html();var panelBody=panel.body.html();var panelFooter=panel.footer.html();if(glow.env.ie){panelHeader=panelHeader.replace(/__[^"\s]+"[^"\s]+"/g,"");panelBody=panelBody.replace(/__[^"\s]+"[^"\s]+"/g,"");panelFooter=panelFooter.replace(/__[^"\s]+"[^"\s]+"/g,"")}this.config.saveState=[panelHeader,panelBody,panelFooter].join("")};view.View.prototype.deleteState=function(){this.config.saveState=""};view.View.prototype.emptyCache=function(){this.deleteState();this.config.content="";this.loaded=false};view.View.prototype.showSpinner=function(){panel.container.get(css_element_panelContent).addClass(css_class_panelSpinner)};view.View.prototype.hideSpinner=function(){panel.container.get(css_element_panelContent).removeClass(css_class_panelSpinner)};view.View.prototype.showFormSpinner=function(){var submitButton=$(css_element_buttonSubmit);var spinner=submitButton.parent().append(['<span class="',css_class_formSpinner,'">Working...</span>'].join("")).get([".",css_class_formSpinner].join(""));spinner.css("top",[(((submitButton.offset().top-submitButton.parent().offset().top)+(submitButton.height()/2))-(spinner.height()/2)),"px"].join("")).css("left",[((submitButton.offset().left-submitButton.parent().offset().left-spinner.width())-5),"px"].join(""))};view.View.prototype.hideFormSpinner=function(){$(css_element_formSpinner).remove();return this};view.SigninView=function(){arguments.callee.base.apply(this,arguments);this.configUrl="/users/configuration/signin.js"};view.SigninView.prototype.addEvents=function(){this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_registerLink_span),"mouseover",function(e){$(this).addClass("hovered")});this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_registerLink_span),"mouseout",function(e){$(this).removeClass("hovered")});this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_cancelButton),"click",function(e){e.preventDefault();this.hide();glow.events.fire(identity,"signinCancel")},this);this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_helpLink),"click",controller.handleOpenHelpDrawer,controller);this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_signinForm),"submit",controller.handleSigninFormSubmit,controller);this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_signinForm_username),"blur",controller.handleSigninFormUsernameBlur,controller);this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_signinForm_password),"blur",controller.handleSigninFormPasswordBlur,controller);var targets=[css_element_signinForm_username,css_element_signinForm_password,css_element_signinForm_remember_me];for(var i=0;i<targets.length;i++){userfeedback.setPanel(targets[i],this.eventListenerIds)}};view.SessionExpiredView=function(){arguments.callee.base.apply(this,arguments);this.configUrl="/users/configuration/sessionexpired.js"};view.SessionExpiredView.prototype.addEvents=function(){this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_buttonSubmit),"click",this.hide,this)};view.ServiceErrorView=function(){arguments.callee.base.apply(this,arguments);this.configUrl="/users/configuration/serviceerror.js"};view.ServiceErrorView.prototype.addEvents=function(){this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_buttonSubmit),"click",this.hide,this)};view.MaintenanceModeView=function(){arguments.callee.base.apply(this,arguments);this.configUrl="/users/configuration/maintenancemode.js"};view.MaintenanceModeView.prototype.addEvents=function(){this.eventListenerIds[this.eventListenerIds.length]=addListener($(css_element_buttonSubmit),"click",this.hide,this)};var Userfeedback=function(){this.panels={};this.panelAnims={};this.template='<div class="panel-id-hint"><div class="{type}"><div class="infoPanel-pointerT"></div><div class="infoPanel-pointerL"></div><div class="infoPanel-pointerR"></div><div class="panel-hd"></div><div class="panel-bd"></div><div class="panel-ft"></div><div class="infoPanel-pointerB"></div></div></div>';this.dummyTemplate='<div style="position:absolute;top:0px;left:0px;visibility:hidden" id="id-height-calculate" class="panel-id-hint glowNoMask blq-rst"><div class="light"><div class="infoPanel-pointerT"></div><div class="infoPanel-pointerL"></div><div class="infoPanel-pointerR"></div><div class="panel-hd"></div><div class="panel-bd"><p></p></div><div class="panel-ft"></div><div class="infoPanel-pointerB"></div></div></div>'};Userfeedback.prototype.hint=function(content,context){return this.create(content,context,"hint")};Userfeedback.prototype.error=function(content,context){return this.create(content,context,"error")};Userfeedback.prototype.setPanel=function(target,eventListenerIds){var context=$(target),hint=context.parent().get(".hint"),infopanel,hintText;if(!hint.length||hint.text()==""){var altHint=context.parent().parent().get("legend .hint");if(altHint.length&&altHint.text()!=""){hintText=altHint.text()}else{hintText=""}}else{hintText=hint.text()}if(hintText){infopanel=userfeedback.hint(hintText,context);eventListenerIds[eventListenerIds.length]=addListener(context,"focus",function(){if(!context.parent().parent().hasClass("error")&&!(context.parent().parent().is("fieldset")&&context.parent().parent().parent().hasClass("error"))){userfeedback.updateOffset(infopanel,context);infopanel.setPosition();if(this.panelAnims.hint&&this.panelAnims.hint[context.attr("id")]){try{this.panelAnims.hint[context.attr("id")].stop();this.panelAnims.hint[context.attr("id")].goTo(0)}catch(e){}}infopanel.show()}},this);eventListenerIds[eventListenerIds.length]=addListener(context,"blur",function(){userfeedback.hide("hint",context.attr("id"))},this)}};Userfeedback.prototype.create=function(text,context,type){context=$(context);this.panels[type]=this.panels[type]||{};if(this.panels[type][context.attr("id")]&&this.panels[type][context.attr("id")].body.get("p").text()==text){return this.panels[type][context.attr("id")]}else{var panelKey=context.attr("id");var containerCheck=context.parent().parent();if(containerCheck[0].nodeName.toLowerCase()=="fieldset"){context=containerCheck.parent()}else{if(containerCheck.hasClass("checkbox")){context=containerCheck}}if(this.panels[type][panelKey]){this.panels[type][panelKey].hide();this.panels[type][panelKey].container.remove()}this.panels[type][panelKey]=new idInfoPanel(glow.dom.create(["<p>",text,"</p>"].join("")),{context:context,returnTo:"",pointerPosition:"l",focusOnShow:false,modal:false,template:glow.lang.interpolate(this.template,{type:type}),pointerRegisters:{l:{x:0,y:(this.calculateHeight(text)/2)}}});this.panels[type][panelKey].content.addClass("blq-rst");this.updateOffset(this.panels[type][panelKey],context);return this.panels[type][panelKey]}};Userfeedback.prototype.updateOffset=function(infopanel,context){var offsetX,offsetY=14,containerCheck;containerCheck=context.parent().parent();if(containerCheck[0].nodeName.toLowerCase()=="fieldset"){offsetY=context.offset().top-containerCheck.parent().offset().top;context=containerCheck.parent();offsetX=context[0].offsetWidth-2}else{if(containerCheck.hasClass("checkbox")){offsetY=context.offset().top-containerCheck.offset().top;context=containerCheck;offsetX=context[0].offsetWidth-7}else{offsetX=context[0].offsetWidth+4}}infopanel.setOffsetInContext({x:offsetX,y:offsetY})};Userfeedback.prototype.calculateHeight=function(text){var containerElement=$("#id-height-calculate");if(!containerElement[0]){containerElement=glow.dom.create(this.dummyTemplate).appendTo($("body"))}containerElement.get(".panel-bd p").text(text);return containerElement.height()};Userfeedback.prototype.setPosition=function(){for(type in this.panels){for(hint in this.panels[type]){this.panels[type][hint].setPosition()}}};Userfeedback.prototype.hide=function(type,key){if(this.panels[type]&&this.panels[type][key]){var element=this.panels[type][key];this.panelAnims[type]=this.panelAnims[type]||{};this.panelAnims[type][key]=glow.anim.css(element.container,0.3,{opacity:{to:0}});glow.events.addListener(this.panelAnims[type][key],"complete",function(){element.hide();element.container.css("opacity",1)});this.panelAnims[type][key].start();return true}else{return false}};Userfeedback.prototype.hideAll=function(){for(type in this.panels){for(hint in this.panels[type]){this.hide(type,hint)}}};Userfeedback.prototype.flushRegister=function(){this.panels={}};userfeedback=new Userfeedback();r.parseStatusLinks=function(){if(statusListenerIds.signin){removeListener(statusListenerIds.signin)}var signin=$(css_element_status_signinLink);if(signin.length){statusListenerIds.signin=addListener(signin,"click",function(e){e.preventDefault();if(panelState=="closed"&&!identity.status.hasChanged()){controller.handleSignin(e)}},controller)}};r.extendViews=function(){glow.lang.extend(view.SigninView,view.View,view.SigninView.prototype);glow.lang.extend(view.SessionExpiredView,view.View,view.SessionExpiredView.prototype);glow.lang.extend(view.ServiceErrorView,view.View,view.ServiceErrorView.prototype);glow.lang.extend(view.MaintenanceModeView,view.View,view.MaintenanceModeView.prototype)};r.getPanel=function(){return panel};r.showPanel=function(panelToShow,e){switch(panelToShow){case"signin":controller.getView("SigninView",controller.getLocaleFromUrl(e.attachedTo.href)).setContentParametersFromEvent(e).show();break;default:break}};r.getCSS=function(css){if(css.substr(0,3)=="css"&&eval(["typeof(",css,")=='string'"].join(""))){return eval(css)}else{return false}};r.fixLayout=function(){if(glow.env.webkit){$("#bbcid_date_of_birth-container legend").css("margin-left","0").css("margin-right","0")}};r.init=function(g,e){glow=g;$=glow.dom.get;addListener=glow.events.addListener;removeListener=glow.events.removeListener;this.extendViews();controller=new Controller();addListener(identity,"signin",function(e){controller.currentView.hideFormSpinner().hide()});glow.events.addKeyListener("ESC","press",function(){if(panel.isVisible()){controller.currentView.hide()}})};return r}();if(identity&&identity.statusbar&&identity.statusbar.scriptLoadCallback){identity.statusbar.scriptLoadCallback("id-app.js")};