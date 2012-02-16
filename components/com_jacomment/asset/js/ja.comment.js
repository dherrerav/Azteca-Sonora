// JavaScript Document
jQuery.noConflict();

var jac_activePopIn = 0;
var jac_idActive = '';
var timeout = '';
var jac_ajax = '';
var isExpandFormAddNew 		= 0;
var isExpandFormEdit		= 0;
var isAutoExpandFormAddNew  = 0;
var jac_header = 'jac-header';
var jac_textarea_cursor = -1;
function jac_init() {	
	jQuery(document).ready(
			function($) {
				$(this).click( function() {					
					if (jac_idActive != '' && jac_activePopIn == 1) {
						$(jac_idActive).removeClass('jac-active');
						jac_activePopIn = 0;
					}
					jac_activePopIn = 1;
				});
				//$('#jav-dialog').hide('slow');
			});	
}


function jac_init_expand(form){		
	jQuery(document).ready(function($) {		
		formName = "#jac-post-new-comment";
		if($type(form)){
			formName = "#jac-edit-comment";
		}
		//add action onclick or onblur in guest name and guest email
		else{					
			$("#jac-post-new-comment .jac-inner-text").focus(function() {
				if($(this).attr('id') == "guestName" && $(this).val() == $("#jac_hid_text_name").val())
					$(this).val("");
				
				if($(this).attr('id') == "guestEmail" && $(this).val() == $("#jac_hid_text_email").val())
					$(this).val("");
				
				if($(this).attr('id') == "guestWebsite" && $(this).val() == $("#jac_hid_text_website").val())
					$(this).val("http://");
				
				if($(this).attr('id') == "textCaptcha" && $(this).val() == $("#jac_hid_text_captcha").val())
					$(this).val("");
				
				if($(this).attr('id') == "newcomment" && $(this).val() == $("#jac_hid_text_comment").val())
					$(this).val("");
			});
			
			$("#jac-post-new-comment .jac-inner-text").blur(function() {
				if($(this).val() == "" || $(this).attr('id') == "guestWebsite"){
					if($(this).attr('id') == "guestName")
						$(this).val($("#jac_hid_text_name").val());
					
					if($(this).attr('id') == "guestEmail")
						$(this).val($("#jac_hid_text_email").val());
					
					if($(this).attr('id') == "guestWebsite" && ($(this).val() == "" || $(this).val() == "http://"))
						$(this).val($("#jac_hid_text_website").val());
					
					if($(this).attr('id') == "textCaptcha")
						$(this).val($("#jac_hid_text_captcha").val());
					
					if($(this).attr('id') == "newcomment")
						$(this).val($("#jac_hid_text_comment").val());
				}				
			});
		}
		
		if($.trim($(formName+ ' .jac-expand-form').html()) == "") return false;
		//if didn't find text area with class jac-expand-field - return
		if($(formName +" textarea.jac-expand-field").length <=0) return false;		
		//add event onclick for textare
		$(formName +" textarea.jac-expand-field").click(function() {			
			//if this form is collapse - expand it			
			if($(formName +"  .jac-expand-form").css("display") == "none"){
				$(formName +"  .jac-expand-form").slideDown("slow", function() {			    
					$(formName +" .jac-act-button a").parent().removeClass("loading");
					$(formName +" .jac-act-button a").html(JACommentConfig.mesCollapseForm);
					$(formName +" .jac-act-button a").attr('title', JACommentConfig.mesCollapseForm);
					$(formName +" .jac-act-button").addClass("loaded");
				});				
			}
			return false;
	    });		
		//check if exist toolbar.
		if($(formName +" .jac-wrapper-actions").length >0 && $(formName +" .jac-act-button").length <=0){
			if($(formName +"  .jac-expand-form").css("display") == "none"){
				$('<li class="jac-act-button"><a title="'+JACommentConfig.mesExpandForm+'" href="#">'+ JACommentConfig.mesExpandForm +'</a></li>').appendTo(formName +"  .jac-wrapper-actions");
			}else{
				$('<li class="jac-act-button loaded"><a title="'+JACommentConfig.mesCollapseForm+'" href="#">'+ JACommentConfig.mesCollapseForm +'</a></li>').appendTo(formName +"  .jac-wrapper-actions");
			}
		}
		//don't exist toolbar.
		else{			
			//don't add action button
			if($(formName +"  .jac-act-button").length <=0){			
				//find element allow add button act				
				if($(formName +" .jac-act-form").length >0){					
					$(formName +" .jac-act-form").show();
					if($(formName +"  .jac-expand-form").css('display') == "none"){
						$('<div class="jac-act-button jac-li-act-only"><a title="'+JACommentConfig.mesExpandForm+'" href="#">'+ JACommentConfig.mesExpandForm +'</a></div>').appendTo(formName +" .jac-act-form");
					}else{										
						$('<div class="jac-act-button jac-li-act-only loaded"><a title="'+JACommentConfig.mesCollapseForm+'" href="#">'+  JACommentConfig.mesCollapseForm +'</a></div>').appendTo(formName +" .jac-act-form");
					}
				}else{							
					if($(formName +"  .jac-expand-form").css('display') == "none"){
						$('<li class="jac-act-button jac-li-act-only"><a title="'+JACommentConfig.mesExpandForm+'" href="#">'+ JACommentConfig.mesExpandForm +'</a></li>').appendTo(formName +"  ul.form-comment");
					}else{										
						$('<li class="jac-act-button jac-li-act-only loaded"><a title="'+JACommentConfig.mesCollapseForm+'" href="#">'+  JACommentConfig.mesCollapseForm +'</a></li>').appendTo(formName +"  ul.form-comment");
					}
				}								
			}							
		}
		
		$(formName +' .jac-act-button a').click(function() {			
			//if form is being slide
			if($(this).parent().attr("class").indexOf("loading") != -1) return false;			
			$(this).parent().addClass("loading");			
			//if form is expand
			if($(this).parent().attr("class").indexOf("loaded") != -1){				
				$(this).parent().removeClass("loaded");
				$(formName +"  .jac-expand-form").slideUp('slow', function() {					
					$(formName +' .jac-act-button a').html(JACommentConfig.mesExpandForm);
					$(formName +" .jac-act-button a").attr('title', JACommentConfig.mesExpandForm);
					$(formName +' .jac-act-button').removeClass("loading");
				});
			}
			//if form is collapse
			else{				
				$(this).parent().addClass("loaded");
				$(formName +"  .jac-expand-form").slideDown('slow', function() {
					$(formName +' .jac-act-button a').html(JACommentConfig.mesCollapseForm);
					$(formName +" .jac-act-button a").attr('title', JACommentConfig.mesCollapseForm);
					$(formName +' .jac-act-button').removeClass("loading");
				});	
			}	
			return false;
	    });						
	});		
}

function jac_auto_expand_textarea(id){	
	if(id){
		idTextArea = "newcommentedit";
	}else{
		idTextArea = "newcomment";
	}
		
	if( JACommentConfig.isEnableAutoexpanding != 0){
		jQuery(document).ready( function($) {
	   var arrayText = jQuery("#jac-container-textarea").find("textarea");
	   var textArea = '';
	   jQuery.each(arrayText, function() {		   
		   if(this.id == idTextArea){
			   textArea = this;
		   }
	   });
	   if(idTextArea == "newcomment"){
	   		jQuery("#jac-container-textarea").html();
	   		jQuery("#jac-container-textarea").html(textArea);
	   }
	   
 	   jQuery('textarea#' + idTextArea).autoResize({
 		    // On resize:
 		    onResize : function() {
 		        $(this).css({opacity:0.8}); 		       
 		    },
 		    // After resize:
 		    animateCallback : function() {
 		        $(this).css({opacity:1});
 		    },
 		    // Quite slow animation:
 		    animateDuration : 300,
 		    // More extra space:
 		    extraSpace : 40,
 		    limit:300
 		}); 
    	});	
	}
	
	if(JACommentConfig.isEnableBBCode != 0){		
		DCODE.setTags (["LARGE", "MEDIUM", "HR", "B", "I", "U", "S", "UL", "OL", "SUB", "SUP", "QUOTE", "LINK", "IMG", "YOUTUBE", "HELP"]);			     			     
		DCODE.activate (idTextArea);
	}
	if(id){
		jac_init_expand("edit");
	}else{
		jac_init_expand();
	}
}

function jacInsertSmiley(which) {
	text = document.getElementById("newcomment").value;
	if($("newcomment").className.indexOf("jac-inner-text") != -1){		
		if($("newcomment").value == $("jac_hid_text_comment").value){
			text = "";
		}
	}	
	document.getElementById("newcomment").value = text.substring(0, jac_textarea_cursor) + which + text.substring(jac_textarea_cursor, text.length);
	jac_textarea_cursor = jac_textarea_cursor + which.length; 
}

function jacInsertSmileyEdit(which) {    
    text = document.getElementById("newcommentedit").value;
	document.getElementById("newcommentedit").value = text.substring(0, jac_textarea_cursor) + which + text.substring(jac_textarea_cursor, text.length);
	jac_textarea_cursor = jac_textarea_cursor + which.length;
}

function jac_ajax_load(url, type_id) {
	jac_displayLoadingSpan();	
	jav_option_type = type_id;
	jQuery(document).ready( function($) {
		jac_displayLoadingSpan();
		jac_ajax = $.getJSON(url, function(res) {
			jac_parseData(res);
		});
	});
}
function jac_ajax_update(url) {
	jQuery(document).ready( function($) {
		jac_ajax = $.getJSON(url, function(res) {
		});
	});
}
function jac_ajax_load_vote(url) {
	jac_displayLoadingSpan();	
	jQuery(document).ready(
			function($) {
				jac_ajax = $.getJSON(url, function(res) {
					jac_parseData(res);
					jav_vote_total = parseInt($('#votes-left-' + jav_option_type).attr('value').trim());
					if(jav_vote_total==-1) jav_vote_total = 1000;
					if (jav_vote_total == 0) {
						checkTypeOfTooltip('#jav-dialog', jav_option_type, 400, 'auto', 3000);
					}
				});
			});
}

function checkTypeOfTooltip(divId, type, width, height, time_delay) {
	jQuery(document).ready( function($) {
		$(divId).css( {
			'width' :width,
			'height' :height
		});
		switch (type) {
		case 'none':
			$(divId).hide('fast');
			break;
		case 'auto_hide':
			$(divId).show('slow');
			timeout = ( function() {
				$(divId).hide('slow');
			}).delay(time_delay);

			$(divId).hover( function() {
				$clear(timeout);
			}, function() {
				timeout = ( function() {
					$(divId).hide('slow');
				}).delay(time_delay);
			});
			break;
		case 'normal':
		default:
			$(divId).show('slow');
		}
	});
}

function jac_parseData(response, isParse) {	
	jQuery(document).ready( function($) {
		if($('#jac-loader')) {
			id='#'+jac_header;
			$(id).css('z-index','10');			
			$('#jac-loader').hide();
		}
		
		if(isParse){
			var reload = 0;
			var myResponse = null;
			if(response.data){
				myResponse = response.data; 
			}else{
				myResponse = response;
			}
			jQuery.each(myResponse, function(i, item) {										
				var divId = item.id;
				var type = item.type;
				var value = item.content;
				
				if ($(divId) != undefined) {
					if (type == 'html') {						
						if ($(divId)){																												
							$(divId).html(value);							
						}
						else
							alert('not fount element');
					} else {
						if (type == 'reload') {
							if (value == 1)
								reload = 1;
						} else {
							if(type=='val'){
								$(divId).val(value);
							}else{
								if(type=="append"){
									if ($(divId, window.parent.document)){										
										if(divId == "#newcomment"){											
											if($(divId, window.parent.document).attr("class").indexOf("jac-inner-text") != -1){
												if($(divId, window.parent.document).val() == $("#jac_hid_text_comment", window.parent.document)) $(divId, window.parent.document).val(""); 
											}
										}
				                        $(divId, window.parent.document).val($(divId, window.parent.document).val() + value);				                        				                                    				                       
				                    }else{
				                        alert('not fount element');
				                    }   
								}else if(type == "appendAfter"){
									if ($(divId, window.parent.document)){				                        
				                        $(divId, window.parent.document).val(value + "\n" + $(divId, window.parent.document).val());				                        
				                    }else{
				                        alert('not fount element');
				                    }   
								}else if(type == "setdisplay"){
									if(value == "show"){
										$(divId).show();
									}else{
										$(divId).hide();
									}
								}else{
									$(divId).attr(type, value);
								}
							}
						}
					}
				}
															    	 				    					    	
			});
		}
	});		
}

function jav_showDiv(divId) {
	jQuery(document).ready( function($) {
		var objDiv = $(divId);		
		var clsDiv = objDiv.attr('class');		
		jac_idActive = divId;

		if (clsDiv != "undefined") {				
			var mainClass = clsDiv.split(' ');
			$('.' + mainClass[0]).removeClass('jac-active');
		}

		if ($chk(objDiv)) {			
			if (clsDiv != "undefined" && clsDiv.indexOf('jac-active') != -1) {
				objDiv.removeClass('jac-active');				
			} else {
				objDiv.addClass('jac-active');				
			}
		}

		jac_activePopIn = 0;
	});
}

function jac_hideDiv(divId) {
	jQuery(document).ready( function($) {
		var objDiv = $(divId);
		if ($chk(objDiv)) {
			objDiv.removeClass('jac-active');
		}

		jac_idActive = '';
		jac_activePopIn = 0;
	});
}

function showWebsiteRules(title){
	jacCreatForm('showwebsiterules&view=comments&layout=showterm',0,600,400,0,0,title,1,'');
}

function jac_isEmail(string) {
	return (string.search(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,5}|[0-9]{1,3})(\]?)$/) != -1);
}

////ajax pagination
//function jac_ajaxPagination(url,divid) {		
//	if(url.indexOf('?') > 0) {
//		url = url + '&type=' + jav_option_type;
//	}else {		
//		url = url + '?type=' + jav_option_type;
//	}
//	
//	var vars = url.split('&');
//	for (var i=0; i<vars.length; i++){
//		if( vars[i].indexOf('task')>-1 || vars[i].indexOf('cid')>-1 || vars[i].indexOf('votes')>-1 || vars[i].indexOf('layout')>-1){
//			vars[i] = '';
//		}
//	}
//	var new_url = '';
//	for (var i=0; i<vars.length; i++){
//		if( vars[i]!='' ) new_url += vars[i] + '&';
//	}
//	new_url += 'layout=paging';
//	alert(url);
//	jac_ajax_load(url, jav_option_type);
//	//pr_ajax = new Ajax(url,{method:'get', update:divid, onComplete:update}).request(); 
//}


function jac_show_all_status( itemid ){		
	jQuery(document).ready( function($) {		
		jav_showDiv('#jac-change-type-' + itemid + ' .statuses');
		$('#jac-change-type-' + itemid + ' .statuses').css('top', '-65px');
	});
}	

function voteComment(ID, typeVote){
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&task=votecomment&id=" + ID + "&typevote="+typeVote;	
	jacomment_ajax_load(url);
}

function buildCommentUrl(url, action){	
	url += "&contentoption=" + JACommentConfig.contentoption;
	url += "&contentid=" + JACommentConfig.contentid;
	url += "&commenttype=" + JACommentConfig.commenttype;
	if(action == "sentParent"){
		if(JACommentConfig.hdCurrentComment != 0)
			url += "&parentid=" + JACommentConfig.hdCurrentComment;
	}
	return url;
}

function displayChild(parentID){		
	if($('childen-comment-of-'+parentID).style.display != "none"){
		$('childen-comment-of-'+parentID).style.display = "none";	
		$('a-show-childen-comment-of-'+parentID).style.display = "block";
		$('a-hide-childen-comment-of-'+parentID).style.display = "none";
				
		jQuery(document).ready( function($) {
			if($('#jac-loader')) {
				id='#'+jac_header;
				$(id).css('z-index','10');			
				$('#jac-loader').hide();
				
			}	
		});		
		changeClassName("jac-row-comment-"+parentID, "isshowchild", "");
	}else{		
		$('childen-comment-of-'+parentID).style.display = "block";
		
		$('a-show-childen-comment-of-'+parentID).style.display = "none";
		$('a-hide-childen-comment-of-'+parentID).style.display = "block";
		changeClassName("jac-row-comment-"+parentID, "", "isshowchild");
				
		var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&layout=showchild&parentid=" + parentID;
		url = buildCommentUrl(url);					
		
		jQuery(document).ready( function($) {					
			var clicked = $('#childen-comment-of-'+parentID).attr('class');
			if (clicked != "undefined" && clicked.indexOf('loaded') == -1) {				
				jac_displayLoadingSpan();
				$.getJSON(url, function(response){													
					var reload = 0;					
					jac_parseData(response,1);												
			     });
				
				$('#childen-comment-of-'+parentID).addClass('loaded');				
			}						
		});
	}
}

function jac_doPaging( limitstart, limit, order, key ){	
	cancelComment("cancelReply",0,"Reply","Posting");
	jac_displayLoadingSpan();
	var mainUrl = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&layout=paging&limitstart=0&limit=" + eval(limit);
		
	if(order){		
		mainUrl += "&orderby=" + escape(order);
	}else{		
		if($('orderby') != undefined){
			mainUrl += "&orderby=" + escape($('orderby').value);
			typeorderby = getSortType($('orderby').value);	
			mainUrl += "&typeorderby=" + typeorderby;
		}
		
	}	
	if(key){
		mainUrl += "&key=" + escape(key);
	}	
	mainUrl = buildCommentUrl(mainUrl);	
	
	jacomment_ajax_load(mainUrl);	
}

function jacomment_ajax_load(url, data) {				
	jQuery(document).ready( function($) {
		if(data){			 
			jQuery.post(url, data, function(response){				 
				jac_parseData(response, 1);												
		     }, 'json');
		}else{						
			$.getJSON(url, data, function(response){				
				jac_parseData(response, 1);												
		     });
		}
	});	
}

//ajax pagination
function jac_ajaxPagination(url,divid) {		
	cancelComment("cancelReply",0,"Reply","Posting");
	jac_displayLoadingSpan();
	if(url.indexOf('?') > 0) {
		url = url + '&amp;';
	}else {		
		url = url + '?';
	}	
	listID = "list";
	
	url = url + "&limit=" + $(listID).value;	
	if(url.indexOf('limitstart')<=0){
		url = url + "&limitstart=0";
	}
	
	if($('orderby') != undefined){
		url += "&orderby=" + escape($('orderby').value);
		typeorderby = getSortType($('orderby').value);	
		url += "&typeorderby=" + typeorderby;
	}
	
	url = buildCommentUrl(url);
	url = url.replace(/&amp;/g,"&");	
	jacomment_ajax_load(url,"pa");
	//pr_ajax = new Ajax(url,{method:'get', update:divid, onComplete:update}).request(); 
}

function jacclosemessage(IDE){	
	jQuery(document).ready(function($) {
		id='#'+jac_header;
		$(id).css('z-index','10');
		$(IDE).css('display','none');
		$('#jac-msg-succesfull').css('display','none');
	});	
}

function jacdisplaymessage(IDE){
	jQuery(document).ready(function($) {
		id='#'+jac_header;
		$(id).css('z-index','1');
		$(IDE).css('display','');
		$('#jac-msg-succesfull').css('display','');
	});		
	setTimeout('jacclosemessage('+ IDE +')', 2500);	
}


function getSortType(sort){	
	jQuery(document).ready( function($) {
		if(sort == "date"){
			sortID 		= $("#jac-sort-by-date");
		}else{
			sortID 		= $("#jac-sort-by-voted");
		}
		
		if(sortID.attr("class") == "jac-sort-by"){				
			typeorderby = "ASC";						
		}else if(sortID.attr("class") == "jac-sort-by-active-desc"){				
			typeorderby = "DESC";
		}else{						
			typeorderby = "ASC";
		}					
	});
	
	return typeorderby;
}

function sortComment(sort, obj){
	cancelComment("cancelReply",0,"Reply","Posting");
	jac_displayLoadingSpan();
	var limit = 10;
	if($('list') != undefined)
		limit = $('list').value;
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&layout=sort&orderby=" + sort + "&limit=" + limit;		
	
	jQuery(document).ready( function($) {
		if(sort=="date"){
			sortID 		= $("#jac-sort-by-date");
			sortBackID  = $("#jac-sort-by-voted");
		}else{
			sortID 		= $("#jac-sort-by-voted");
			sortBackID  = $("#jac-sort-by-date");
		}
				
		if(sortID.attr("class") == "jac-sort-by"){			
			sortID.removeClass("jac-sort-by");
			sortID.addClass("jac-sort-by-active-asc");
			//edit title
			
			if(sort=="date"){
				sortID.attr("title", JACommentConfig.dateDESC);
			}else{
				sortID.attr("title", JACommentConfig.votedDESC);
			}
			
			typeorderby = "ASC";						
		}else if(sortID.attr("class") == "jac-sort-by-active-desc"){			
			sortID.removeClass("jac-sort-by-active-desc");
			sortID.addClass("jac-sort-by-active-asc");
			typeorderby = "ASC";
			
			if(sort=="date"){
				sortID.attr("title", JACommentConfig.dateDESC);
			}else{
				sortID.attr("title", JACommentConfig.votedDESC);
			}
		}else{				
			sortID.removeClass("jac-sort-by-active-asc");
			sortID.addClass("jac-sort-by-active-desc");
			typeorderby = "DESC";
			
			if(sort=="date"){
				sortID.attr("title", JACommentConfig.dateASC);
			}else{
				sortID.attr("title", JACommentConfig.votedASC);
			}
		}	
		
		if(sortBackID.attr("class") != "jac-sort-by"){			
			if(sortBackID.attr("class") == "jac-sort-by-active-asc")
				sortBackID.removeClass("jac-sort-by-active-asc");			
			else
				sortBackID.removeClass("jac-sort-by-active-desc");
			
			sortBackID.addClass("jac-sort-by");
		}		
	});		
		
	url += "&typeorderby="+typeorderby;				
	url = buildCommentUrl(url);
	
	$('orderby').value = sort;	
	jacomment_ajax_load(url);
}

function checkErrorNewComment(ID){										
	checkError = 0;		
	var textEnd				  = "";		
	$("ja-addnew-error").innerHTML = "";
	//check if user is check spelling edit text.
	if($("newcomment").innerHTML != undefined && $("newcomment").value == undefined && $("checkLink") != undefined){			
		$("err_newcomment").style.display = "block";		
		$("err_newcomment").innerHTML = JACommentConfig.hidEndEditText;		
		changeClassName("newcomment","ja-error", "ja-error");
		changeClassName("jac-editor-addnew","ja-error", "ja-error");		
		i++;
		checkError = 1
	}	
	
	if($('newcomment') != undefined && checkError == 0){					
		currentID = JACommentConfig.hdCurrentComment;
		realText  = "";
		if($("jac-a-reply-" +currentID) != undefined && $("jac-a-reply-" +currentID).style.display == "none"){
			if($('newcomment').value != undefined)
				realText = trim(stripcode($('newcomment').value, false, true));
		}else{
			if($('newcomment').value != undefined)
				realText = trim(stripcode($('newcomment').value, false, false));
		}
				
		if($('newcomment').value == '' || realText == '' || $('newcomment') == undefined){				
			$("err_newcomment").style.display = "block";			
			$("err_newcomment").innerHTML = JACommentConfig.hidInputComment;			
			changeClassName("newcomment","ja-error", "ja-error");
			changeClassName("jac-editor-addnew","ja-error", "ja-error");
			if(checkError == 0)
				$('newcomment').focus();			
			checkError = 1
		}else{								
			//check length of comment.		
			//alert(JACommentConfig.minLengthComment + "aa" + realText.length);
			if(realText.length < JACommentConfig.minLengthComment){											
				changeClassName("newcomment","ja-error", "ja-error");
				changeClassName("jac-editor-addnew","ja-error", "ja-error");				
				$("err_newcomment").style.display = "block";				
				$("err_newcomment").innerHTML = JACommentConfig.errorMinLength;												
				if(checkError == 0)
					$('newcomment').focus();						
				checkError = 1;
			}
			
			if(realText.length > JACommentConfig.maxLengthComment){
				//tinyMCE.execInstanceCommand("comment-editor-new"+ID, "mceFocus");
				changeClassName("newcomment","ja-error", "ja-error");
				changeClassName("jac-editor-addnew","ja-error", "ja-error");				
				$("err_newcomment").style.display = "block";				
				$("err_newcomment").innerHTML = JACommentConfig.errorMaxLength;								
				if(checkError == 0)
					$('newcomment').focus();
				checkError = 1
			}
		}
	}		
	if(checkError == 0){				
		changeClassName("newcomment","ja-error", "");
		changeClassName("jac-editor-addnew","ja-error", "");		
		$("err_newcomment").style.display = "none";		
		$("err_newcomment").innerHTML = "";
	}
	
	//is user is guest
	if($('guestName') != undefined) {				
		if($('guestName').value == "" || ($('guestName').value == $('jac_hid_text_name').value && $("guestName").className.indexOf("jac-inner-text"))){
			changeClassName("guestName","ja-error", "ja-error");			
			$("err_guestName").style.display = "block";			
			$("err_guestName").innerHTML = JACommentConfig.hidInputName;	
			
			if(checkError == 0)
				$('guestName').focus();
			checkError = 1
		}else{
			changeClassName("guestName","ja-error", "");
			$("err_guestName").innerHTML = "";			
			$("err_guestName").style.display = "none";			
		}
		
		if($('guestEmail').value == "" || ($('guestEmail').value == $('jac_hid_text_email').value && $("guestEmail").className.indexOf("jac-inner-text"))){				
			changeClassName("guestEmail","ja-error", "ja-error");			
			$("err_guestEmail").style.display = "block";			
			$("err_guestEmail").innerHTML = JACommentConfig.hidInputEmail;			
			if(checkError == 0)
				$('guestEmail').focus();
			checkError = 1
		}else{
			//changeClassName("guestEmail","ja-error", "");
			$("err_guestEmail").innerHTML = "";
			var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test($('guestEmail').value)) {					
				changeClassName("guestEmail","ja-error", "ja-error");				
				$("err_guestEmail").style.display = "block";			
				$("err_guestEmail").innerHTML = JACommentConfig.hidValidEmail;								
				if(checkError == 0)
					$('guestEmail').focus();
				checkError = 1
			}else{
				changeClassName("guestEmail","ja-error", "");
				$("err_guestEmail").innerHTML = "";				
				$("err_guestEmail").style.display = "none";
			}
		}
				
	}
	
	//check input captchar
	if($("textCaptcha") != undefined){
		if($("textCaptcha").value == "" || ($('textCaptcha').value == $("jac_hid_text_captcha").value && $("textCaptcha").className.indexOf("jac-inner-text"))){
			changeClassName("textCaptcha","ja-error", "ja-error");			
			$("err_textCaptcha").style.display = "block";			
			$("err_textCaptcha").innerHTML = JACommentConfig.hidInputCaptcha;			
			if(checkError == 0)
				$('textCaptcha').focus();
			checkError = 1
		}else{
			changeClassName("textCaptcha","ja-error", "");
			$("err_textCaptcha").innerHTML = "";			
			$("err_textCaptcha").style.display = "none";			
		}
	}
	
	if($("chkTermsAddnew")!= undefined){
		if($("chkTermsAddnew").checked == false){
			changeClassName("jac-terms","ja-error", "ja-error");			
			$("err_TermsAddnew").style.display = "block";			
			$("err_TermsAddnew").innerHTML = JACommentConfig.hidAgreeToAbide;			
			checkError = 1
		}else{
			changeClassName("jac-terms","ja-error", "");
			$("err_TermsAddnew").innerHTML = "";			
			$("err_TermsAddnew").style.display = "none";			
		}
	}
						
	if(checkError == 1){
		jacLoadNewCaptcha(0);
		return false;		
	}
		
	return true;
}
function refreshPage(){
	window.location = document.location;
}
function postNewComment(id){		
	var flag = checkErrorNewComment(id);	
	if (flag) {							
		if($("btlAddNewComment") != undefined)
			$("btlAddNewComment").disabled = true;
		else{
			$("jac_post_new_comment").style.display = "none";
			$("jac_span_post_new_comment").style.display = "block";
		}
		jac_displayLoadingSpan();
		jQuery(document).ready(
			function($) {											
				url  = JACommentConfig.jac_base_url + "index.php?option=com_jacomment&view=comments&task=addnewcomment&tmpl=component";
				data = '';
				data += "newcomment=" + encodeURIComponent($("#newcomment").val());
				
				if($("#subscription_type").val() != undefined)
					data +="&subscription_type=" + $("#subscription_type").val();				
				
				if($("#textCaptcha").val() != undefined)
					data +="&captcha=" + escape($("#textCaptcha").val());
				
				if($("#guestName").val() != undefined){
					data +="&name=" + encodeURIComponent($("#guestName").val());
				}else{
					if($("#jac-text-user").html() != undefined){
						data +="&islogin=1";
					}
				}
													
				if($("#guestEmail").val() != undefined){
					data +="&email=" + escape($("#guestEmail").val());
				}
				
				if($("#guestWebsite").val() != undefined && CheckValidUrl($("#guestWebsite").val())){					
					data +="&website=" + escape($("#guestWebsite").val());
				}

				url = buildCommentUrl(url, "sentParent");
				data += "&jacomentUrl=" + escape(JACommentConfig.jacomentUrl);
				data += "&contenttitle=" + encodeURIComponent(JACommentConfig.contenttitle);				
				data +="&currenttotal=" + $("#jac-number-total-comment").html();
				
				if($("#form1") != undefined){
					data += "&"+$("#form1").serialize();					
				}				
				
				jacomment_ajax_load(url, data);		
		});						
	}else{
		jac_init_expand();
	}
}


function CheckValidUrl(strUrl){
        var RegexUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return RegexUrl.test(strUrl);
}

function showButtonAddNew(obj1, obj2){	
	return;
	$(obj2).disabled = !$(obj1).checked;
}

function reportComment(ID){	
	jac_displayLoadingSpan();
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&task=reportcomment&id=" + ID;			
	url = buildCommentUrl(url);		
	url += "&orderby=" + $('orderby').value;		
	url += "&limitstart=" + $('limitstart').value;
	if($('list') != undefined)
		url += "&limit=" + $('list').value;	
	jacomment_ajax_load(url)
}

function undoReportComment(ID){	
	jac_displayLoadingSpan();
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&task=undoReportComment&id=" + ID;			
	url = buildCommentUrl(url);	
	url += "&orderby=" + $('orderby').value;		
	url += "&limitstart=" + $('limitstart').value;
	if($('list') != undefined)
		url += "&limit=" + $('list').value;
	
	jacomment_ajax_load(url)
}

function deleteComment(ID, UserID, UserEmail, UserName){	
	cancelComment("delete");	
	if($('list') != undefined)
		limit = $('list').value;
	
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&task=deletecomment&id="+ID;	
	url += "&orderby=" + $('orderby').value;
	typeorderby = getSortType($('orderby').value);	
	url += "&typeorderby=" + typeorderby;
	url += "&limitstart=" + $('limitstart').value;
	if($('list') != undefined)
		url += "&limit=" + $('list').value;		
	
	url = buildCommentUrl(url);
	
	jacomment_ajax_load(url);
}

function editComment(ID, reply){	
	jac_displayLoadingSpan();		
	cancelComment("edit", ID, reply);
	var url = JACommentConfig.jac_base_url + "index.php?tmpl=component&option=com_jacomment&view=comments&layout=showformedit&id="+ID;		
	jacomment_ajax_load(url);
	JACommentConfig.hdCurrentComment = ID; 
}

function cancelEditComment(ID){
	url = JACommentConfig.jac_base_url +  "index.php?tmpl=component&option=com_jacomment&view=comments&task=cancelUploadComment";
	jacomment_ajax_load(url);	
	$('jac-div-footer-'+ID).style.display 			= "block";
	$('jac-content-of-comment-'+ID).style.display 	= "block";
	$('jac-edit-comment-'+ID).innerHTML = "";
	$('jac-edit-comment-'+ID).style.display = "none";
	JACommentConfig.hdCurrentComment = 0;
	jac_init_expand();
	if($('jac-attach-file-'+ID) != undefined)
		$('jac-attach-file-'+ID).style.display = "block";
	$('jac-wrapper-form-add-new').style.display = "block";
	isExpandFormEdit = 0;  
}

function displayErrorAddNew(){	
	$('textCaptcha').focus();
}

function saveComment(ID){						
	checkError = 0;
		
	//check if user is check spelling edit text.
	if($("newcommentedit").innerHTML != undefined && $("newcommentedit").value == undefined && $("checkLink") != undefined){	
		changeClassName("newcommentedit","ja-error", "ja-error");
		//$("ja-edit-error").innerHTML = JACommentConfig.hidEndEditText;
		$("err_newcommentedit").innerHTML = JACommentConfig.hidEndEditText;
		checkError = 1;
	}	
	
	if($('newcommentedit').value != undefined){
		realText  = "";
		if($('newcommentedit').value != undefined){
			if($('newcomment').value.indexOf("[QUOTE") != -1)
				realText = trim(stripcode($('newcommentedit').value, false, true));
			else 
				realText = trim(stripcode($('newcommentedit').value, false, false));
	}
		
		if(realText == '' || $('newcommentedit') == undefined){	
			changeClassName("newcommentedit","ja-error", "ja-error");
			$("err_newcommentedit").innerHTML = JACommentConfig.hidInputComment;
						
			if(checkError == 0)
				$('newcommentedit').focus();			
			checkError = 1
		}else{						
			if(realText.length < JACommentConfig.minLengthComment){											
				changeClassName("newcommentedit","ja-error", "ja-error");
				$("err_newcommentedit").innerHTML = JACommentConfig.errorMinLength;
				
				if(checkError == 0)
					$('newcommentedit').focus();			
				
				checkError = 1;
			}
			
			if(realText.length > JACommentConfig.maxLengthComment){			
				changeClassName("newcommentedit","ja-error", "ja-error");
				$("err_newcommentedit").innerHTML = JACommentConfig.errorMaxLength;
				
				if(checkError == 0)
					$('newcommentedit').focus();
				checkError = 1
			}
		}
	}			
	
	if(checkError == 1)
		return;
		
	if($('btlEditComment') != undefined){
		$('btlEditComment').disabled = true; 
	}else{
		$('jac_edit_comment').style.display = "none";
		$('jac_span_edit_comment').style.display = "block";
	}

	jQuery(document).ready(
		function($) {											
			url = JACommentConfig.jac_base_url + "index.php?option=com_jacomment&view=comments&task=saveEditComment&tmpl=component&id=" + ID;
			data = '';
			data += "&newcomment=" + encodeURIComponent($("#newcommentedit").val());
			
			if($("#subscription_type").val() != undefined)
				data +="&subscription_type=" + $("#subscription_type").val();				
								
			data = buildCommentUrl(data);
			
			if($("#form1edit")[0] && $("#form1edit").serialize()){
				data += "&"+$("#form1edit").serialize();				
			}		
				
			jacomment_ajax_load(url, data);		
	});		
}

function actionWhenEditSuccess(ID){	
	$('jac-edit-comment-'+ID).innerHTML = "";
	$('jac-edit-comment-'+ID).style.display = "none";
	$('jac-div-footer-'+ID).style.display 			= "block";
	$('jac-content-of-comment-'+ID).style.display 	= "block";
	if($('jac-attach-file-'+ID) != undefined)
		$('jac-attach-file-'+ID).style.display = "block";
	if($("jac-wrapper-form-add-new") != undefined){
		$("jac-wrapper-form-add-new").style.display = "block";
	}
	isExpandFormEdit = 0;
}

function parseData_admin(response) {
    jQuery(document, window.parent.document).ready( function($) {    	
    	var reload = 0;    	
    	var myResponse = null;
    	if(response.data){
			myResponse = response.data; 
		}else{
			myResponse = response;
		}
        $.each(myResponse, function(i, item) {
            var divId = item.id;
            var type = item.type;
            var value = item.content;            

            if ($(divId, window.parent.document) != undefined) {
                if (type == 'html') {
                    if ($(divId, window.parent.document)){
                        $(divId, window.parent.document).html(value);
                        
                        if(item.status!='ok'){
                            $('#ja-popup-wait').css( {
                                'display' :'none'
                            });
                        }else{                            
                            jacFormHideIFrame(); 
                        }  
                        
                    }else{
                        alert('not fount element');
                    }    
                }else if (type == 'append') {
                    if ($(divId, window.parent.document)){                    	
                    	if(divId == "#newcomment"){											
							if($(divId, window.parent.document).attr("class").indexOf("jac-inner-text") != -1){
								if($(divId, window.parent.document).val() == $("#jac_hid_text_comment", window.parent.document).val()) $(divId, window.parent.document).val(""); 
							}
						}
                        $(divId, window.parent.document).val($(divId, window.parent.document).val() + value);
                        
                        if(item.status!='ok'){
                            $('#ja-popup-wait').css( {
                                'display' :'none'
                            });
                        }else{                            
                            jacFormHideIFrame(); 
                        }                   
                        
                    }else{
                        alert('not fount element');
                    }    
                } else {
                    if (type == 'reload') {
                        if (value == 1)
                            reload = 1;
                    } else {
                        if(type=='val'){
                            $(divId, window.parent.document).val(value);
                        }else{
                            $(divId, window.parent.document).attr(type, value);
                        }
                    }
                }
            }
        });         
    });

}

function actionBeforEditReply(ID, reply, action, post){
		
}

function replyComment(ID, post, reply, action){	
	if($('reply-'+ID).innerHTML != undefined){
		if(post == $('reply-'+ID).innerHTML){
			return;
		}	
	}
	if($('quote-'+ID).innerHTML != undefined){
		if(post == $('quote-'+ID).innerHTML){
			return;
		}	
	}	
	
	if(action){
		//load content of comment.		
		cancelComment("quote", ID, reply, post);
		url = JACommentConfig.jac_base_url + "index.php?option=com_jacomment&view=comments&task=show_quote&tmpl=component&id=" + ID;
		jacomment_ajax_load(url);
	}else{
		cancelComment("reply", ID, reply, post);
	}
	strNewComment = $("newcomment").value;	
	if($('guestName') != undefined){strGuestName = $("guestName").value;}	
	if($('guestEmail') != undefined){strGuestEmail = $("guestEmail").value;}		
	if($('guestWebsite') != undefined){strGuestWebsite = $("guestWebsite").value;}	
	if($('chkTermsAddnew') != undefined){isChkTermsAddnew = $("chkTermsAddnew").checked;}			
	
	//load form reply from reply to reply.
	if(JACommentConfig.hdCurrentComment != 0 && $("jac-result-reply-comment-" + JACommentConfig.hdCurrentComment).innerHTML != ""){													
		$("jac-result-reply-comment-" + ID).innerHTML =  $("jac-result-reply-comment-" + JACommentConfig.hdCurrentComment).innerHTML;
		$("jac-result-reply-comment-" + ID).style.display = "block";
		$("jac-result-reply-comment-" + JACommentConfig.hdCurrentComment).innerHTML = "";
		$("jac-result-reply-comment-" + JACommentConfig.hdCurrentComment).style.display = "none";
		
		if($("jac_cancel_comment_link") != undefined)
			$("jac_cancel_comment_link").style.display = "block";						
		if($("btlCancelComment") != undefined)
			$("btlCancelComment").style.display = "block";							
	}
	//load from add new form to reply form.
	else{			
		if($("jac-wrapper-form-add-new").style.display == "none"){
			$("jac-wrapper-form-add-new").style.display = "block";
		}								
		$("jac-result-reply-comment-" + ID).innerHTML=$("jac-wrapper-form-add-new").innerHTML;
		$("jac-result-reply-comment-" + ID).style.display = "block";
		$("jac-wrapper-form-add-new").innerHTML = "";		
			
		if($("jac_cancel_comment_link") != undefined)
			$("jac_cancel_comment_link").style.display = "block";
			
		if($("btlCancelComment") != undefined)
			$("btlCancelComment").style.display = "block";								
	}
	
	$("newcomment").value = strNewComment;	
	if($('guestName') != undefined){$("guestName").value = strGuestName;}
	if($('guestEmail') != undefined){$("guestEmail").value = strGuestEmail;}			
	if($('guestWebsite') != undefined){$("guestWebsite").value = strGuestWebsite;}	
	if($('chkTermsAddnew') != undefined){$("chkTermsAddnew").checked = isChkTermsAddnew;}		
	
	var url = location.href.split('#')[0];
	location.href=url+"#jacommentid:"+ID;
	
	//setHrefInPage(ID);
	JACommentConfig.hdCurrentComment = ID;	
    
    $("newcomment").focus();
    
    jac_auto_expand_textarea();
}

function setHrefInPage(ID){	
	link = document.location.href;
	lastIndex = link.lastIndexOf("#");
	if(lastIndex == -1){
		link = link + "#jacommentid:"+ID;
	}else{
		link = link.substring(0, lastIndex);
		link = link + "#jacommentid:"+ID;		
		//remove old link
	}
	window.location = link;	
}

function restoreAddnewForm(){
	currentID = JACommentConfig.hdCurrentComment; 	
	JACommentConfig.hdCurrentComment = 0;
	if(currentID != 0){
		if($("jac-a-quote-" + currentID).style.display == "none"){
				
		}
		
		if($("jac-a-reply-" + currentID).style.display == "none"){
			
		}
	}
}

function cancelComment(action, ID,  reply, post){					
	currentID = JACommentConfig.hdCurrentComment;	
	if(currentID != 0){		
		//undo display when user is editting.	
		if($("jac-edit-comment-" + currentID).innerHTML != ""){
			$("jac-edit-comment-" + currentID).innerHTML = "";
			$('jac-edit-comment-'+currentID).style.display = "none";
			$('jac-content-of-comment-'+currentID).style.display =  "block";
			$('jac-div-footer-'+currentID).style.display = "block";
			if($('jac-attach-file-'+currentID) != undefined)
				$('jac-attach-file-'+currentID).style.display = "block";
			JACommentConfig.hdCurrentComment = 0;
		}		
		
		if($("reply-"+currentID) != undefined){
			//undo display when user is repling
			if($("reply-"+currentID).disabled == true){
				$("reply-"+currentID).value = reply;
				$("reply-"+currentID).disabled = false;	
				$("quote-"+currentID).disabled = false;
			}else if($("reply-"+currentID).innerHTML == JACommentConfig.textPosting){
				$("reply-"+currentID).innerHTML = JACommentConfig.textReply;	
				if($("jac-a-quote-"+currentID).style.display == "none"){					
					$("jac-a-quote-"+currentID).style.display = "block";						
				}
				if($("jac-change-type-" +currentID) != undefined && $("jac-change-type-" +currentID).style.display == "none"){
					$("jac-change-type-" +currentID).style.display = "block";
				}
			}
		}
		//undo display when user is quocting
		if($("quote-"+currentID) != undefined){
			if($("quote-"+currentID).disabled == true){
				$("quote-"+currentID).value = reply;
				$("quote-"+currentID).disabled = false;	
				$("reply-"+currentID).disabled = false;
			}else if($("quote-"+currentID).innerHTML == JACommentConfig.textQuoting){
				$("quote-"+currentID).innerHTML = JACommentConfig.textQuote;
				if($("jac-a-reply-"+currentID).style.display == "none"){					
					$("jac-a-reply-"+currentID).style.display = "block";						
				}
				if($("jac-change-type-" +currentID) != undefined && $("jac-change-type-" +currentID).style.display == "none"){
					$("jac-change-type-" +currentID).style.display = "block";
				}
				$("newcomment").value = "";
			}
		}
	}
			
	if(action == "edit"){
		$('jac-div-footer-'+ID).style.display = "none";
		$('jac-content-of-comment-'+ID).style.display = "none";
		
		if($('jac-attach-file-'+ID) != undefined)
			$('jac-attach-file-'+ID).style.display = "none";
		
		if(currentID != 0){			
			if($("jac-wrapper-form-add-new").innerHTML == ""){
				strNewComment = $("newcomment").value;	
				if($('guestName') != undefined){strGuestName = $("guestName").value;}	
				if($('guestEmail') != undefined){strGuestEmail = $("guestEmail").value;}		
				if($('guestWebsite') != undefined){strGuestWebsite = $("guestWebsite").value;}	
				if($('chkTermsAddnew') != undefined){isChkTermsAddnew = $("chkTermsAddnew").checked;}
				
				$("jac-wrapper-form-add-new").innerHTML = $("jac-result-reply-comment-" + currentID).innerHTML;
				$("jac-result-reply-comment-" + currentID).innerHTML = "";
				$("jac-result-reply-comment-" + currentID).style.display = "none";
				
				$("newcomment").value = strNewComment;	
				if($('guestName') != undefined){$("guestName").value = strGuestName;}
				if($('guestEmail') != undefined){$("guestEmail").value = strGuestEmail;}			
				if($('guestWebsite') != undefined){$("guestWebsite").value = strGuestWebsite;}	
				if($('chkTermsAddnew') != undefined){$("chkTermsAddnew").checked = isChkTermsAddnew;}
				jac_auto_expand_textarea();
			}
		}
		$("jac-wrapper-form-add-new").style.display = "none";
		$("jac-edit-comment-"+ID).style.display = "block";
	}
	
	if(action == "reply"){			
		if($("jac-change-type-" +ID) != undefined){
			$("jac-change-type-" +ID).style.display = "none";
		}	
		if($("reply-"+ID).value != undefined){
			$("reply-"+ID).value = post;
			$("reply-"+ID).disabled = "true";			
		}else{
			if($("reply-"+ID).innerHTML != undefined){				
				$("reply-"+ID).innerHTML = post;							
			}
			if($("quote-"+ID).value == undefined){				
				if($("quote-"+ID).innerHTML != undefined){
					$("jac-a-quote-"+ID).style.display = "none";
				}
			}
		}
	}	
	
	if(action == "quote"){
		if($("jac-change-type-" +ID) != undefined){
			$("jac-change-type-" +ID).style.display = "none";
		}
		if($("quote-"+ID).value != undefined){
			$("quote-"+ID).value = post;
			$("quote-"+ID).disabled = "true";			
		}else{
			if($("quote-"+ID).innerHTML != undefined){
				$("quote-"+ID).innerHTML = post;				
			}
			
			if($("reply-"+ID).value == undefined){
				if($("reply-"+ID).innerHTML != undefined){
					$("jac-a-reply-"+ID).style.display = "none";
				}
			}										
		}		
	}
	
	if(action == "delete"){
		if(currentID != 0){
			action = "cancelReply";
		}		
		$("jac-wrapper-form-add-new").style.display = "block";
		return;				
	}
	
	if(action == "completeReply"){		
		if($('err_myfile') != undefined && $('err_myfile').innerHTML != "")
			$('err_myfile').innerHTML = "";

		if($("childen-comment-of-" + currentID) != undefined){
			$("childen-comment-of-" + currentID).style.display = "block";
		}
		
		if(currentID != 0){			
			strNewComment = $("newcomment").value;									
		}
		if($("jac_cancel_comment_link") != undefined)
			$("jac_cancel_comment_link").style.display = "none";
		
		if($("btlCancelComment") != undefined)
			$("btlCancelComment").style.display = "none";											
		
		if($("quote-"+currentID)!= undefined &&  $("quote-"+currentID).value == undefined){						
			if($("quote-"+currentID).innerHTML != undefined){
				if($("quote-"+currentID).innerHTML == JACommentConfig.textQuoting){
					$("quote-"+currentID).innerHTML = JACommentConfig.textQuote;
					$("newcomment").value = "";
				}
				if($("jac-a-quote-"+currentID).style.display == "none"){					
					$("jac-a-quote-"+currentID).style.display = "block";						
				}
			}
		}
		
		if($("reply-"+currentID) != undefined && $("reply-"+currentID).value == undefined){			
			if($("reply-"+currentID).innerHTML != undefined){										
				if($("jac-a-reply-"+currentID) != undefined && $("jac-a-reply-"+currentID).style.display == "none"){
					$("jac-a-reply-"+currentID).style.display = "block";
				}
			}
		}
		
		$("jac-wrapper-form-add-new").innerHTML = $("jac-result-reply-comment-" + currentID).innerHTML;
		$("jac-result-reply-comment-" + currentID).innerHTML = "";	
		$("jac-result-reply-comment-" + currentID).style.display = "none";
		
		//textCounter('newcomment', 'jaCountText');
		
		jac_auto_expand_textarea();
		
		JACommentConfig.hdCurrentComment = 0;
	}
	
	if(action == "cancelReply"){		
		if($("newcomment") != undefined && $("newcomment").innerHTML != undefined && $("newcomment").value == undefined && $("checkLink") != undefined){
			jacRestoreTextArea();
		}		
		if(JACommentConfig.hdCurrentComment == 0){
			$("jac-wrapper-form-add-new").style.display = "block";
		}
		if(currentID != 0 && JACommentConfig.hdCurrentComment != 0){						
			strNewComment = $("newcomment").value;	
			if($('guestName') != undefined){strGuestName = $("guestName").value;}	
			if($('guestEmail') != undefined){strGuestEmail = $("guestEmail").value;}		
			if($('guestWebsite') != undefined){strGuestWebsite = $("guestWebsite").value;}	
			if($('chkTermsAddnew') != undefined){isChkTermsAddnew = $("chkTermsAddnew").checked;}
			
			$("jac-wrapper-form-add-new").innerHTML = $("jac-result-reply-comment-" + currentID).innerHTML;
			$("jac-result-reply-comment-" + currentID).innerHTML = "";	
			$("jac-result-reply-comment-" + currentID).style.display = "none";			
			$("newcomment").value = strNewComment;	
			if($('guestName') != undefined){$("guestName").value = strGuestName;}
			if($('guestEmail') != undefined){$("guestEmail").value = strGuestEmail;}			
			if($('guestWebsite') != undefined){$("guestWebsite").value = strGuestWebsite;}	
			if($('chkTermsAddnew') != undefined){$("chkTermsAddnew").checked = isChkTermsAddnew;}
			
			jac_auto_expand_textarea();
			
			if($("quote-"+currentID)!= undefined &&  $("quote-"+currentID).value == undefined){						
				if($("quote-"+currentID).innerHTML != undefined){
					if($("quote-"+currentID).innerHTML == JACommentConfig.textQuoting){
						$("quote-"+currentID).innerHTML = JACommentConfig.textQuote;							
						$("newcomment").value = "";
					}
					if($("jac-a-quote-"+currentID).style.display == "none"){					
						$("jac-a-quote-"+currentID).style.display = "block";						
					}
				}
			}
			
			if($("reply-"+currentID) != undefined && $("reply-"+currentID).value == undefined){			
				if($("reply-"+currentID).innerHTML != undefined){										
					if($("jac-a-reply-"+currentID) != undefined && $("jac-a-reply-"+currentID).style.display == "none"){						
						$("jac-a-reply-"+currentID).style.display = "block";
						$("reply-"+currentID).innerHTML = JACommentConfig.textPosting;
					}
				}
			}
			
		}
										
		if($("jac_cancel_comment_link") != undefined)
			$("jac_cancel_comment_link").style.display = "none";
		
		if($("btlCancelComment") != undefined){			
			$("btlCancelComment").style.display = "none";
		}				
		
		jacLoadNewCaptcha(0);
		
		JACommentConfig.hdCurrentComment = 0;
	}    	
}

function enableAddNewComment(id){	
	if(id == "btlAddNewComment"){
		if($("btlAddNewComment") != undefined)
			$("btlAddNewComment").disabled = false;
		else{
			$("jac_post_new_comment").style.display = "block";
			$("jac_span_post_new_comment").style.display = "none";
		}
	}else if(id == "btlEditComment"){
		if($("btlEditComment") != undefined)
			$("btlEditComment").disabled = false;
		else{
			$("jac_edit_comment").style.display = "block";
			$("jac_span_edit_comment").style.display = "none";
		}
	}
	else{
		$(id).disabled = false;
	}
}

function jac_displayLoadingSpan() {	
	jQuery(document).ready( function($) {
		id='#'+jac_header;
		$(id).css('z-index','1');		
		$('#jac-loader').show();
	});		
}

function disableReplyButton(){
	jQuery(document).ready(function($) {											
		 buttonReply = jQuery("input[name='jac-button-Reply']");		 
		 $("reply-10").attr("style", "display='block'");
		 jQuery.each(buttonReply, function(i, item) {	
			 //item.css("display", "none");			
		 });		 
	});		
}

function attachFile(ID){		
	var str=$('userfile').value;	
	var ext=str.substring(str.length,str.length-3);
	if ( ext == "exe")
	{
		alert("File is invalid");
		return false;
	}
	else
	{
		jQuery(document).ready(
				function($) {											
					//url = "index.php?" + $("#uploadForm"+ID).serialize();
					if(!ID){
						url = "index.php?" + $("#uploadForm").serialize();
					}else{
						url = "index.php?" + $("#uploadForm"+ID).serialize();
					}										
					jacomment_ajax_load(url);						
		});		
	};
	return false;
}

function open_login(title){
    if(title)
		jacCreatForm('login&view=users&layout=login&createlink=1',0,650,400,0,0,title,1,'');
	else
		jacCreatForm('login&view=users&layout=login&createlink=1',0,650,400,0,0,JACommentConfig.strLogin,1,'');
}

function completeAddNew(){
	if($("newcomment").value != undefined){
		$("newcomment").value = "";
	}
	
	if($("guestName") != undefined){
		if($("guestName").className.indexOf("jac-inner-text") != -1){
			$("guestName").value = $("jac_hid_text_name").value;	
		}else{			
			$("guestName").value = "";
		}
	}
	
	if($("guestEmail") != undefined){
		if($("guestEmail").className.indexOf("jac-inner-text") != -1){
			$("guestEmail").value = $("jac_hid_text_email").value;	
		}else{			
			$("guestEmail").value = "";
		}
	}
	
	if($("guestWebsite") != undefined){
		if($("guestWebsite").className.indexOf("jac-inner-text") != -1){
			$("guestWebsite").value = $("jac_hid_text_website").value;	
		}else{			
			$("guestWebsite").value = "http://";
		}
	}	
	
	if($('chkTermsAddnew') != undefined){
		$('chkTermsAddnew').checked = false;
	}
	
	if($('err_myfile') != undefined && $('err_myfile').innerHTML != ""){
		$('err_myfile').innerHTML = "";
	}
	
	if($('jac_image_captcha') != undefined){
		jacLoadNewCaptcha();		
		if($("textCaptcha").className.indexOf("jac-inner-text") !== -1){			
			$("textCaptcha").value = $("jac_hid_text_captcha").value;			
		}else{			
			$("textCaptcha").value = "";
		}
	}
	
	if($("myfile") != undefined){
		$("myfile").disabled = false;
	}	
	jac_auto_expand_textarea();
	//textCounter('newcomment', 'jaCountText');
}

function moveBackground(id, rooturl){		
	if(id == 0 || $('jac-row-comment-'+id) == undefined) return;
	var url = location.href.split('#')[0];
	location.href=url+"#jacommentid:"+id;
	
	$("jac-content-of-comment-"+id).addClass("just-reply");
	$("jac-content-of-comment-"+id).addClass("jac-move-back");
	
//	if(typeof(JACommentConfig.bgImage) == 'undefined'){
//		$("jac-content-of-comment-"+id).style.backgroundImage  = "url('" + rooturl + "components/com_jacomment/themes/default/images/new-comment-bg.jpg')";
//		$("jac-content-of-comment-"+id).addClass  = "jac-move-back";
//	}else{
//		$("jac-content-of-comment-"+id).addClass  = "jac-move-back";
//		
//		$("jac-content-of-comment-"+id).style.backgroundImage  = "url('"+ JACommentConfig.bgImage +"')";
//	}
	//$("jac-content-of-comment-"+id).style.backgroundRepeat = "repeat-x"; 	
	heightOfComment = $("jac-row-comment-"+id).offsetHeight;		
	setTimeout("fadeBackGround('"+id+"', '" + heightOfComment  + "');", 2000);
}

function fadeBackGround(id, heightOfComment){
	var count = 0;
	
	for(i = (500 - heightOfComment); i<=500; i++ ){
		//moving back ground
		setTimeout("movingBack('"+id+"', '"+ -i +"');", count * 12);
		count++;
		//remove back ground
		if(i == 500){
			setTimeout("removeFace('"+id+"');", ((count*12)+250));
		}
	}	
}

function movingBack(id, i){
	$("jac-content-of-comment-"+id).style.backgroundPosition = "0 " + i + "px";
}

function removeFace(id){
	jQuery(document).ready(function($) {
		if($("#jac-content-of-comment-"+id)!= undefined){
			$("#jac-content-of-comment-"+id).removeAttr("style");			    				    				    		
			$("#jac-content-of-comment-"+id).removeClass("jac-move-back");
		}	    		
	});	
}

function actionjacLoadNewCaptcha(action){
	//show image load new
	if(action){
		$('jac-refresh-image').style.display = "block";
	}
	//dis able image load new
	else{
		$('jac-refresh-image').style.display = "none";
	}
}

function urlCheck(str) { 
	var tomatch= /^(https?|ftp):\/\/.*$/i;	
	if (tomatch.test(str)){               
		return true;
    }
	return false;
}

function checkWordLength(text, action, countTextID){				
	//changeClassName("newcomment", "jac-error", "");	
	var str1 			= "";
	var str2 			= "";
	var tmp  			= 0;
	var checkTag 		= 0;
	//[B]123[B]
	for(i = 0; i< text.length; i++){								
		if(text.charAt(i) != " " && text.charAt(i) != "\n" && text.charAt(i) != "[" && text.charAt(i) != "]" && text.charAt(i) != "="){												
			if(str1.length <100){				
				str1 += text.charAt(i);								
			}else{											
				//check str1 is link
				if(!urlCheck(str1)){
					str2 += str1 + " ";					
					tmp = 1;
					str1 = text.charAt(i);						
				}else{
					str1 += text.charAt(i);
				}				
			}			
		}else{						
			str2 += str1 + text.charAt(i);			
			str1 = "";				
		}			
	}	
	str2 += str1;
	if(tmp == 1){
		$(action).value = str2;		
		alert(JACommentConfig.hidInputWordInComment);
	}
}

function jacLoadNewCaptcha(){	            				
	if($("jac_image_captcha") != undefined){
		$("jac_image_captcha").src = JACommentConfig.jac_base_url + "index.php?option=com_jacomment&task=displaycaptchaaddnew&tmpl=component&ran=" + Math.random();
	}
}

function removeAttrOfDiv(id){
	jQuery(id).removeAttr("style");
}

function setHeight(id){
	jQuery(id).attr("style", "height:auto;");	
}

function changeTypeOfComment(type, itemID, currentType , currentTabID){
	jac_displayLoadingSpan();		
	var url = JACommentConfig.jac_base_url + "index.php?option=com_jacomment&task=changeType&type="+ type +"&id="+ itemID +"&tmpl=component&currenttype="+currentType;	
	jacomment_ajax_load(url);		
}

function changeClassName(divID, removeClass, addClass){			
	if($(divID) != undefined){
		if($(divID).className.indexOf(removeClass)){
			$(divID).className = $(divID).className.replace(removeClass, "");
		}
		if($(divID).className.indexOf(addClass) == -1)
		$(divID).className = $(divID).className + " " + addClass;
	}
}

function openAttachFile(id){
	if(id !=0 || id != ""){
		//edit
		if($("jac-form-uploadedit").style.display == "none")
			$("jac-form-uploadedit").style.display = "block";
		else
			$("jac-form-uploadedit").style.display = "none";
	}
	//add new
	else{
		if($("jac-form-upload").style.display == "none")
			$("jac-form-upload").style.display = "block";
		else
			$("jac-form-upload").style.display = "none";
	}
}

function updateTotalChild(id){
	parentID = $("jac-parent-of-comment-" + id).value;	
	if(parentID != 0){		
		if($("jac-show-total-childen-" + parentID) != undefined){
			$("jac-show-total-childen-" + parentID).innerHTML = parseInt($("jac-show-total-childen-" + parentID).innerHTML,10) + 1;			
		}
		if($("jac-hide-total-childen-" + parentID) != undefined)
			$("jac-hide-total-childen-" + parentID).innerHTML = parseInt($("jac-hide-total-childen-" + parentID).innerHTML,10) + 1;
		updateTotalChild(parentID);
	}
}

function jacChangeDisplay(id, action, isSmiley){	
	if($(id) != undefined){
		$(id).style.display = action;
	}	
	//if click on smiley - save cursor in texarea
	if(isSmiley){
		if(id == "jacSmileys-"){
			if(jQuery("#newcomment")[0].selectionStart == undefined){
				//jac_textarea_cursor = jQuery("#newcomment")[0].selectionStart;
				jQuery("#newcomment")[0].focus ();
				var range = document.selection.createRange();
				var stored_range = range.duplicate ();
				stored_range.moveToElementText (el);
				stored_range.setEndPoint ('EndToEnd', range);
				jac_textarea_cursor = stored_range.text.length - range.text.length;
				
			}else{
				jac_textarea_cursor = jQuery("#newcomment")[0].selectionStart;
			}			
		}else{
			if(jQuery("#newcommentedit")[0].selectionStart == undefined){
				//jac_textarea_cursor = jQuery("#newcomment")[0].selectionStart;
				jQuery("#newcommentedit")[0].focus ();
				var range = document.selection.createRange();
				var stored_range = range.duplicate ();
				stored_range.moveToElementText (el);
				stored_range.setEndPoint ('EndToEnd', range);
				jac_textarea_cursor = stored_range.text.length - range.text.length;
				
			}else{
				jac_textarea_cursor = jQuery("#newcommentedit")[0].selectionStart;
			}
		}					
	}
}

function parseLink(){
	url = window.location.href;		
	c_url = url.split('#');
	id = 0;
	tmp = 0;
	if(c_url.length >= 1){		
		for(i=1; i< c_url.length; i++){			
			if(c_url[i].indexOf("jacommentid:") >-1){				
				tmp = c_url[i].split('-')[1];				
				if(tmp != ""){
					id = parseInt(tmp, 10);
				}
			}
		}
	}			
	//jQuery.cookie("JACurrentComment", 0);
	//Cookie.write('JACurrentComment', id);
	document.cookie = 'JACurrentComment=' + id;
}

function selectRange(textAreaID,start,end){
	jQuery(document).ready(function($) {
		$(textAreaID).focus();
		alert(Browser);
		if(Browser.Engine.trident){
			var range=this.createTextRange();
			range.collapse(true);
			range.moveStart('character',start);
			range.moveEnd('character',end-start);
			range.select();return this
		}this.setSelectionRange(start,end);
	});
}

function insertIntoTextare(textAreaID, tag){
	jQuery(document).ready(function($) {	
		text      		= jQuery(textAreaID).val();		
		var len   		= text.length;
		var start 		= jQuery(textAreaID)[0].selectionStart;		
		var end   		= jQuery(textAreaID)[0].selectionEnd;		
		var textSelect  = text.substring(start, end);
		textAdded = text.substring(0, start) + tag + text.substring(end, text.length);
		jQuery(textAreaID).val(textAdded);
//		end += openTag.length + closeTag.length; 		
//		selectRange(textAreaID, start, end);
//		
	});
}
//END -- BBJACODE
function stripcode(F,G,isQuote){
	//if(!is_regexp){return F}
	
	if(isQuote){
		var C=new Date().getTime();
		
		while((startindex=F.indexOf("[QUOTE")) != -1){
			if(new Date().getTime()-C>2000){break;}			
			if((stopindex=F.indexOf("[/QUOTE]"))!= -1){
					fragment=F.substr(startindex,stopindex-startindex+8);
					F=F.replace(fragment,"");
			}else{
				break;
			}			
			F=trim(F);			
		}
	}
	if(G){
		F=F.replace(/<img[^>]+src="([^"]+)"[^>]*>/gi,"$1");
		var H=new RegExp("<(\\w+)[^>]*>","gi");
		var E=new RegExp("<\\/\\w+>","gi");
		F=F.replace(H,"");
		F=F.replace(E,"");
		var D=new RegExp("(&nbsp;)","gi");
		F=F.replace(D," ")
	}else{
		var A=new RegExp("\\[(\\w+)(=[^\\]]*)?\\]","gi");
		var I=new RegExp("\\[\\/(\\w+)\\]","gi");
		F=F.replace(A,"");
		F=F.replace(I,"")}
	return F
}
function trim(A){
	while(A.substring(0,1)==" "){
		A=A.substring(1,A.length)
	}
	while(A.substring(A.length-1,A.length)==" "){
		A=A.substring(0,A.length-1)
	}
	while(A.substring(0,1)=="\n"){
		A=A.substring(1,A.length)
	}
	while(A.substring(A.length-1,A.length)=="\n"){
		A=A.substring(0,A.length-1)
	}
	return A
}