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
jac_textarea_cursor = 0;
jQuery.noConflict();
var jav_header = 'ja-header';
var jav_idActive = '';
function jav_init() {	
	jQuery(document).ready(
			function($) {
				$(this).click( function() {					
					if (jav_idActive != '' && jav_activePopIn == 1) {
						$(jav_idActive).removeClass('jav-active');
						jav_activePopIn = 0;
					}
					jav_activePopIn = 1;
				});
				//$('#jav-dialog').hide('slow');
			});
}


function jacChangeDisplay(id, action, isSmiley){	
	if($(id) != undefined){
		$(id).style.display = action;
	}	
	//if click on smiley - save cursor in texarea
	jac_textarea_cursor = jQuery("#newcomment")[0].selectionStart;			

}

function jacInsertSmiley(which) {
	text = document.getElementById("newcomment").value;
	document.getElementById("newcomment").value = text.substring(0, jac_textarea_cursor) + which + text.substring(jac_textarea_cursor, text.length);
	jac_textarea_cursor = jac_textarea_cursor + which.length; 
}


function jav_showDiv(divId) {
	jQuery(document).ready( function($) {
		var objDiv = $(divId);
		var clsDiv = objDiv.attr('class');		
		jav_idActive = divId;		
		if (clsDiv != "undefined") {				
			var mainClass = clsDiv.split(' ');
			$('.' + mainClass[0]).removeClass('jav-active');
		}

		if ($chk(objDiv)) {			
			if (clsDiv != "undefined" && clsDiv.indexOf('jav-active') != -1) {
				objDiv.removeClass('jav-active');				
			} else {
				objDiv.addClass('jav-active');				
			}
		}

		jav_activePopIn = 0;
	});
}

function jac_show_all_status( itemid ){		
	jQuery(document).ready( function($) {			
		jav_showDiv('#jac-change-type-' + itemid + ' .statuses');
		$('#jac-change-type-' + itemid + ' .statuses').css('top', '-65px');
	});
}

function show_bar_preview(text_preview, text_cancel){
    if(jQuery.browser.msie){
        if(jQuery.browser.version=='6.0'){            
            jQuery('#ja-box-action').show();
            jQuery(window).scroll(function() {
                jQuery('#ja-box-action').css({'top': jQuery(window).height()-45 + jQuery(this).scrollTop() + "px", 'right': '0'});
            });

        }
    }
    
    if($('ja-box-action')!=null){
		jQuery('#ja-box-action').animate( {
			bottom :"0px"
		}, 300);
		return;
	}
	
	if(text_preview==null) text_preview = 'Preview';	
	if(text_cancel==null) text_cancel = 'Cancel';	
	
	var box_action = new Element('div', {'id':'ja-box-action'});
	var button_preview = new Element('button', {
											'name':'ja-preview', 
											'id':'ja-preview',
											'class':'button_b',
											'events': {
												'click': function(e){
                                                    // layout & plugin
                                                    
                                                    theme = 'default';
                                                    config_text = 0;
                                                    enable_avatar = 0;
                                                    use_default_avatar = 0;                                                   
                                                    avatar_size = 1;
                                                    button_type = 1;
                                                    enable_comment_form = 0;
                                                    form_position = 1;
                                                    
                                                    enable_login_button = 0;
                                                    enable_subscribe_menu = 0;                                                   
                                                    enable_sorting_options = 0;
                                                    default_sort = 1;
                                                    
                                                    enable_timestamp = 0;
                                                    enable_user_rep_indicator = 1;
                                                    footer_text = '';
                                                    
                                                    enable_addthis = 0;
                                                    enable_addtoany = 0;                                                   
                                                    enable_tweetmeme = 0;
                                                    
                                                    enable_youtube = 0;
													enable_bbcode  = 0;
													enable_activity_stream = 0;
                                                    enable_after_the_deadline = 0;
                                                    enable_smileys = 0;

                                                
                                                    if(jQuery("#default").is(':checked')) theme = 'default';
                                                    else if(jQuery("#classicA").is(':checked')) theme = 'classicA';
                                                    else if(jQuery("#classicB").is(':checked')) theme = 'classicB';
													
                                                    if(jQuery("#config_text_1").is(':checked')) config_text = 1;
                                                    
                                                    if(jQuery("#enable_avatar").is(':checked')) enable_avatar = 1;
                                                    if(jQuery("#use_default_avatar").is(':checked')) use_default_avatar = 1;                                                  
                                                    if(jQuery("#avatar_size_1").is(':checked')) avatar_size = 1;
                                                    else if(jQuery("#avatar_size_2").is(':checked')) avatar_size = 2;
                                                    else if(jQuery("#avatar_size_3").is(':checked')) avatar_size = 3;
                                                    
                                                    if(jQuery("#button_type_1").is(':checked')) button_type = 1;
                                                    else if(jQuery("#button_type_2").is(':checked')) button_type = 2;
                                                    
                                                    if(jQuery("#enable_comment_form").is(':checked')) enable_comment_form = 1;
                                                    if(jQuery("#form_position_1").is(':checked')) form_position = 1;
                                                    else if(jQuery("#form_position_2").is(':checked')) form_position = 2;
                                                    
                                                    if(jQuery("#enable_login_button").is(':checked')) enable_login_button = 1;   
                                                    if(jQuery("#enable_subscribe_menu").is(':checked')) enable_subscribe_menu = 1;   
                                                    if(jQuery("#enable_sorting_options").is(':checked')) enable_sorting_options = 1;
                                                    
                                                    if(jQuery("#default_sort_1").is(':checked')) default_sort = 1;
                                                    else if(jQuery("#default_sort_2").is(':checked')) default_sort = 2;
                                                       
                                                    if(jQuery("#enable_timestamp").is(':checked')) enable_timestamp = 1;   
                                                    if(jQuery("#enable_user_rep_indicator").is(':checked')) enable_user_rep_indicator = 1;   
                                                    
                                                    footer_text = jQuery("#footer_text").val();
                                                    
                                                    if(jQuery("#enable_addthis").is(':checked')) enable_addthis = 1;         
                                                    if(jQuery("#enable_addtoany").is(':checked')) enable_addtoany = 1;                                                                                                      
                                                    
                                                    if(jQuery("#enable_youtube").is(':checked')) enable_youtube = 1;
                                                    if(jQuery("#enable_bbcode").is(':checked')) enable_bbcode = 1;	
													if(jQuery("#enable_activity_stream").is(':checked')) enable_activity_stream = 1;																										
                                                    if(jQuery("#enable_after_the_deadline").is(':checked')) enable_after_the_deadline = 1;
                                                    if(jQuery("#enable_smileys").is(':checked')) enable_smileys = 1;                                                                    
                                                    
                                                    url = "&theme="+theme+"&config_text="+config_text+"&enable_avatar="+enable_avatar+"&use_default_avatar="+use_default_avatar+"&avatar_size="+avatar_size+"&button_type="+button_type+"&enable_comment_form="+enable_comment_form+"&form_position="+form_position+"&enable_login_button="+enable_login_button+"&enable_subscribe_menu="+enable_subscribe_menu+"&enable_sorting_options="+enable_sorting_options+"&default_sort="+default_sort+"&enable_timestamp="+enable_timestamp+"&enable_user_rep_indicator="+enable_user_rep_indicator+"&footer_text="+footer_text+"&enable_addthis="+enable_addthis+"&enable_addtoany="+enable_addtoany+"&enable_tweetmeme="+enable_tweetmeme+"&enable_youtube="+enable_youtube+"&enable_bbcode="+enable_bbcode+"&enable_activity_stream="+enable_activity_stream+"&enable_after_the_deadline="+enable_after_the_deadline+"&enable_smileys="+enable_smileys;
                                                    // comment
                                                    is_enable_threads = 0;
													is_show_child_comment =0;
                                                    is_allow_voting = 0;
                                                    is_attach_image = 0;                                                    
                                                    is_enable_website_field = 0;
                                                    is_enable_autoexpanding = 0;
                                                    is_enable_email_subscription = 0;
                                                    is_allow_report = 0;
                                                    
                                                    if(jQuery("#is_enable_threads").is(':checked')) is_enable_threads = 1;
													if(jQuery("#is_show_child_comment").is(':checked')) is_show_child_comment = 1;
													if(jQuery("#is_allow_voting").is(':checked')) is_allow_voting = 1;
													
                                                    if(jQuery("#is_attach_image").is(':checked')) is_attach_image = 1;  
                                                    
                                                    if(jQuery("#is_enable_website_field").is(':checked')) is_enable_website_field = 1;
                                                    if(jQuery("#is_enable_autoexpanding").is(':checked')) is_enable_autoexpanding = 1;                                                       
                                                    if(jQuery("#is_enable_email_subscription").is(':checked')) is_enable_email_subscription = 1;  
                                                    if(jQuery("#is_allow_report").is(':checked')) is_allow_report = 1;  
                                                    
                                                    url = url+"&is_enable_threads="+is_enable_threads+"&is_show_child_comment="+is_show_child_comment+"&is_allow_voting="+is_allow_voting+"&is_attach_image="+is_attach_image+"&is_enable_website_field="+is_enable_website_field+"&is_enable_autoexpanding="+is_enable_autoexpanding+"&is_enable_email_subscription="+is_enable_email_subscription+"&is_allow_report="+is_allow_report;
                                                    
                                                    // spamfilter
                                                    is_enable_captcha = 0;
                                                    is_enable_terms = 0;
                                                    
                                                    if(jQuery("#is_enable_captcha").is(':checked')) is_enable_captcha = 1;                                                       if(jQuery("#is_enable_terms").is(':checked')) is_enable_terms = 1;
                                                   
                                                    url = url+"&is_enable_captcha="+is_enable_captcha+"&is_enable_terms="+is_enable_terms;
                                                     
                                                    preview_theme('../index.php?tmpl=component&option=com_jacomment&view=comments&task=preview'+url,740,460,'Preview Layout',1);                                                                          											}
											}
									});
	var button_cancel = new Element('button', {
			'name':'ja-cancel', 
			'id':'ja-cancel',
			'class':'button_b',
			'href':'#',
			'events': {
				'click': function(){
                    
                    if(jQuery.browser.msie){
                        if(jQuery.browser.version=='6.0'){            
                            jQuery('#ja-box-action').hide();
                        }
                    }else{
                        jQuery('#ja-box-action').animate( {
                            bottom :"-45px"
                        }, 300);                                                        
                    }
                                       
					
				}
			}
	});
	
	
	var span_text = new Element('span', {});
	//span_text.setText(text_preview);
	span_text.set("text",text_preview);
	span_text.injectTop(button_preview);
	button_preview.injectTop(box_action);		
	
	var span_cancel = new Element('span', {});
	//span_cancel.setText(text_cancel);
	span_cancel.set("text",text_cancel);
	span_cancel.injectTop(button_cancel);
	button_cancel.injectTop(box_action);
	
	box_action.inject($('jacom-maincontent'));
	
	jQuery('#ja-box-action').animate( {
		bottom :"0px"
	}, 300);
	//jQuery('#ja-wrap-content').fadeIn('fast');
}

function preview_theme(url, jaWidth, jaHeight, title, drag) {
    var Obj = document.getElementById('ja-popup-wrap');
    if (!Obj) {
        var content = jQuery('<div>').attr( {
            'id' :'ja-popup'
        }).appendTo(document.body);
        var jaForm = jQuery('<div>').attr( {
            'id' :'ja-popup-wrap',
            'style' :'top: 0px;display:none;'
        }).appendTo(content);
        //jaForm.appendTo(content);
        
        /* JA POPUP HEADER */
        jQuery('<div>').attr( {
            'id' :'ja-popup-header-wrap'
        }).appendTo(jaForm);
        jQuery('<div>').attr( {
            'id' :'ja-popup-tl'
        }).appendTo(jQuery('#ja-popup-header-wrap'));
        jQuery('<div>').attr( {
            'id' :'ja-popup-tr'
        }).appendTo(jQuery('#ja-popup-header-wrap'));
        jQuery('<div>').attr( {
            'id' :'ja-popup-header'
        }).appendTo(jQuery('#ja-popup-header-wrap'));
        jQuery('<div>').attr( {
            'class' :'inner'
        }).appendTo(jQuery('#ja-popup-header'));

        if (title) {
            jQuery('<h3>').attr( {
                'class' :'ja-popup-title'
            }).appendTo(jQuery('#ja-popup-header .inner'));

            jQuery('.ja-popup-title').html(title);
        }
        jQuery('<a>').attr( {
            'id' :'ja-close-button'
        }).html('Close').appendTo(jQuery('#ja-popup-header .inner'));
        jQuery("#ja-close-button").click( function() { jaFormHide(); } );
        
        /* end JA POPUP HEADER */

        /* JA POPUP CONTENT */
        jQuery('<div>').attr( {
            'id' :'ja-popup-content-wrap'
        }).appendTo(jaForm);
        jQuery('<div>').attr( {
            'id' :'ja-popup-wait',
            'width' :jaWidth
        }).appendTo(jQuery('#ja-popup-content-wrap'));
        jQuery('<div>').attr( {
            'id' :'ja-popup-content'
        }).appendTo(jQuery('#ja-popup-content-wrap'));
        jQuery('<div>').attr( {
            'class' :'inner'
        }).appendTo(jQuery('#ja-popup-content'));

        /* end JA POPUP CONTENT */
        
            
        
        /* JA POPUP FOOTER */
        jQuery('<div>').attr( {
            'id' :'ja-popup-footer-wrap'
        }).appendTo(jaForm);
        jQuery('<div>').attr( {
            'id' :'ja-popup-bl'
        }).appendTo(jQuery('#ja-popup-footer-wrap'));        
        jQuery('<div>').attr( {
            'id' :'ja-popup-br'
        }).appendTo(jQuery('#ja-popup-footer-wrap'));
        jQuery('<div>').attr( {
            'id' :'ja-popup-footer'
        }).appendTo(jQuery('#ja-popup-footer-wrap'));
        jQuery('<div>').attr( {
            'class' :'inner'
        }).appendTo(jQuery('#ja-popup-footer'));
       
        jQuery('<span>').appendTo(jQuery('#ja-popup-footer .inner'));
        jQuery('#ja-popup-footer .inner span').html('&copy; Copyright by JA Comment');
        
        /* end JA POPUP FOOTER */
    }

    // Set jaFormWidth + 40
    if (title)
        jQuery('#ja-popup-title').width(jaWidth-20);

    var myWidth = 0, myHeight = 0;

    myWidth = jQuery(window).width(); 
    myHeight = jQuery(window).height();
  
    var yPos;

    if (jQuery.browser.opera && jQuery.browser.version > "9.5"
            && jQuery.fn.jquery <= "1.2.6") {
        yPos = document.documentElement['clientHeight'] - 20;
    } else {
        yPos = jQuery(window).height() - 20;
    }

    var leftPos = (myWidth - jaWidth) / 2;

    jQuery('#ja-popup-wrap').css('zIndex', cGetZIndexMax() + 1);

    /*
     * jQuery.ajax({ url: jatask, cache: false, success: function(html){
     * jQuery("#ja-popup-content").append(html); } });
     */    
    
    if (jQuery('#iContent').length >0){
        jQuery('#iContent').attr('src',url);
        jQuery('#ja-popup-title').html(title);
    }
    else{
        jQuery('<iframe>').attr( {
            'id' :'iContent',
            'src' :url,
            'width' :jaWidth,
            'height' :jaHeight-80
        }).appendTo(jQuery('#ja-popup-content .inner'));
        jQuery("#iContent").load( function() { loadIFrameComplete(); } );
    }
    /*
     * Set editor position, center it in screen regardless of the scroll
     * position
     */

    jQuery("#ja-popup-wrap").css('marginTop', '5px');
    jQuery('#ja-popup-wrap').css('left', leftPos);

    if(jQuery.browser.msie){
        if(jQuery.browser.version=='6.0'){
            jQuery(window).scroll(function() {
                jQuery('#ja-popup-wrap').css({'top': jQuery(this).scrollTop() + "px", 'left': leftPos});
            });
            
            jQuery("#ja-popup-wrap").css('top', jQuery(this).scrollTop() + 'px');
            jQuery('#ja-popup-wrap').css('left', leftPos);
        }
    }
    /*
    * Dragable
    */
    if(drag){
        jQuery('#ja-popup-header-wrap').css('cursor', 'move'); 
        jQuery('#preview').css('overflow', 'hidden'); 
        jQuery('#ja-popup')
            .bind('drag',function( event ){
                    jQuery( this ).css({
                            left: event.offsetX
                            });
                    });
    }
    /*
     * Set height and width for transparent window
     */

    jQuery('#iContent').css('border', '0px');
    jQuery('#ja-popup-header-wrap').css('width', (jaWidth));
    jQuery('#ja-popup-content-wrap').css('width', (jaWidth));
    jQuery('#ja-popup-footer-wrap').css('width', (jaWidth));

    jQuery('#ja-popup-wrap').fadeIn();

}

function scrollEditor(e) {
    var offset = jQuery(e).scrollTop();
    offset = offset * -1;
    offset = '0 ' + offset + 'px';
    jQuery(e).css('background-position', offset);

}

function checkError() {
    var flag = true;
    var requireds = jQuery('#iContent').contents().find('input.required');
    jQuery.each(requireds, function(i, item) {
        if (jQuery(item).attr('value') == '') {
            var li_parent = jQuery(item.parentNode.parentNode);
            li_parent.addClass('error');
        }
    });
    var errors = jQuery('#iContent').contents().find('li.error');
    errors.each( function() {
        flag = false;
        return;
    });    
    return flag;
}

function submitbuttonAdmin() {
    var flag = checkError();
    if (flag) {
        jQuery(document).ready(
                function($) {
                    $('#ja-popup-wait').css( {
                        'display' :''
                    });

                    $.post("index.php", $("#iContent").contents().find(
                            "#adminForm").serialize(), function(res) {
                        jaFormHideIFrame();
                        parseData_admin(res);
                    }, 'json');
                });
    }else
        alert("Invalid data! Please insert information again!");
}

function parseData_admin(response) {
    
	jQuery(document, window.parent.document).ready( function($) {    	
    	var reload = 0;
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
                            jaFormHideIFrame(); 
                        }  
                        
                    }else{
                        alert('not fount element');
                    }    
                }else if (type == 'append') {
                    if ($(divId, window.parent.document)){
                        $(divId, window.parent.document).val($(divId, window.parent.document).val() + value);
                        
                        if(item.status!='ok'){
                            $('#ja-popup-wait').css( {
                                'display' :'none'
                            });
                        }else{                            
                            jaFormHideIFrame(); 
                        }                   
                        
                    }else{
                        alert('not fount element');
                    }  
                }else if (type == 'append_id') {
                    if ($(divId, window.parent.document)){
                        $(divId, window.parent.document).append(value);
                        
                        if(item.status!='ok'){
                            $('#ja-popup-wait').css( {
                                'display' :'none'
                            });
                        }else{                            
                            jaFormHideIFrame(); 
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

function hiddenMessage() {
    jQuery('#system-message', window.parent.document).html('');
}

function getCookie(name) {
    var start = document.cookie.indexOf(name + "=");
    var len = start + name.length + 1;
    if ((!start) && (name != document.cookie.substring(0, name.length))) {
        return null;
    }
    if (start == -1)
        return null;
    var end = document.cookie.indexOf(";", len);
    if (end == -1)
        end = document.cookie.length;
    return unescape(document.cookie.substring(len, end));
}

function hiddenNote(type, display, hidden) {
    jQuery(document).ready( function($) {
        var value = 0;
        if ($('#jac-system-message').css('display') == 'block') {
            $('#jac-system-message').attr('style', 'display:none');
            value = 1;
            $('#jac_help').html(display);
        } else {
            $('#jac-system-message').attr('style', 'display:block');
            value = 0;
            $('#jac_help').html(hidden);
        }
        setCookie('hidden_message_' + type, value, 365);
    });
}
function setCookie(name, value, expires, path, domain, secure) {
    var today = new Date();
    today.setTime(today.getTime());
    if (expires) {
        expires = expires * 1000 * 60 * 60 * 24;
    }
    var expires_date = new Date(today.getTime() + (expires));
    document.cookie = name + "=" + escape(value)
            + ((expires) ? ";expires=" + expires_date.toGMTString() : "")
            + ((path) ? ";path=" + path : "")
            + ((domain) ? ";domain=" + domain : "")
            + ((secure) ? ";secure" : "");
}


function jcomment_createTabs(tabId){	
	jQuery(document)
	.ready( function($) {
			$("ul.javtabs-title li")
					.click( function() {							
							var activeTab = '#' + $(this).find("a").attr("class"); // Find the href
							var clicked = $(this).attr('class');							
							var obj = $(this);
							clstype_id = $(this).attr('id');							
							if (clicked != "undefined" && clicked.indexOf('loaded') == -1) {
								jav_displayLoadingSpan();
								jav_ajax = $.getJSON($(this).find("a").attr("href"), 
											function(res) {
												jav_parseData(res);																										
												if (clstype_id != "undefined"  && clstype_id!='') {
													clstype = clstype_id.split('_');
													type_id = parseInt(clstype[1]);	
													var jav_pathway = $('#jav-pathway-' + type_id);							
													if (jav_pathway) {
														$('.jav-pathway-main').hide();
														jav_pathway.show();	
													}
												}

												$("ul.javtabs-title li").removeClass("active"); // Remove any "active" class														
												// class to selected tab
												$(".javtabs-panel").hide(); // Hide all tab																			// content
												
												$(activeTab).show(); 
												obj.addClass("active"); // Add "active"
											});															
											$(this).addClass('loaded');
							} else {								
								if (clstype_id != "undefined"  && clstype_id!='') {
									clstype = clstype_id.split('_');
									type_id = parseInt(clstype[1]);									
									var jav_pathway = $('#jav-pathway-' + type_id);							
									if (jav_pathway) {
										$('.jav-pathway-main').hide();
										jav_pathway.show();	
									}
									//set current tab in hidden									
									$('#currentTypeID').val(type_id); 
								}
								
								$("ul.javtabs-title li").removeClass("active"); // Remove any "active" class
								// class to selected tab
								$(".javtabs-panel").hide(); // Hide all tab content
								$(activeTab).show(); 
								$(this).addClass("active"); // Add "active"
							}
							return false;
						});
		});

}
function jav_parseData(response) {    
	jQuery(document).ready( function($) {
        if($('#loader')) {
            id='#'+jav_header;
            $(id).css('z-index','10');            
            $('#loader').hide();
        }        
        if(response.data){			
			myResponse = response.data; 
		}else{			
			myResponse = response;
		}
        $.each(myResponse, function(i, item) {
            var divId = item.id;
            var type = item.attr;
            if(type == undefined){
				type = item.type;
			}
            var content = item.content;
            if ($(divId) != "undefined") {
                if (type == 'html') {
                    $(divId).html(content);
                } else if (type == 'class') {
                    $(divId).attr('class', '');
                    $(divId).addClass(content);
                }
                else if (type == 'css') {
                    var arr = content.split(',');
                    $(divId).css(arr[0], arr[1]);
                }
                else if(type=='reload'){
                    location.href = content;
                }
                else {
                    $(divId).attr(type, content);
                }
            }
        });
    });
    
}
function jav_displayLoadingSpan() {
    jQuery(document).ready( function($) {
        id='#'+jav_header;
        $(id).css('z-index','1');        
        $('#loader').show();
    });    
}

function saveCommentToCokie(id, action){
	if(!jQuery.isFunction(jQuery.cookie)) return;
	strJaCokie = jQuery.cookie("jac-status-comment");
	//delete session	
	if(action){
		if(strJaCokie){
			//delete the first comment in cookie
			if(strJaCokie.indexOf(id) == 0){				
				if(strJaCokie.indexOf(id + "-") != -1){					
					strJaCokie = strJaCokie.replace(id + "-", "" );					
				}else{					
					strJaCokie =  strJaCokie.replace(id, "" );					
				}								
			}else{				
				if(strJaCokie.indexOf(id) != -1){					
					strJaCokie = strJaCokie.replace("-"+id, "" );
				}
			}																
		}
	}else{
		if(strJaCokie){
			if(strJaCokie.lastIndexOf(id) == -1)
				strJaCokie += "-" + id;			
		}else{			
				strJaCokie = id;
		}
	}
	jQuery.cookie("jac-status-comment", null);
	jQuery.cookie("jac-status-comment", strJaCokie);		
}

function disableActionComment(commentID, typeID){
	if($("expandComment"+typeID+"-"+commentID).style.display == "none"){
		$("actionCollapseComment"+typeID+"-"+commentID).style.display = "none";			
	}else{
		$("actionExpandComment"+typeID+"-"+commentID).style.display = "none";				
	}
}

function getObjectByName(divName, tab) {
    var allTds = document.getElementsByTagName(tab);    
    var matchingDivs = new Array();    
    
    for (var i = 0; i < allTds.length; i++){    	
    	if(allTds.item(i).getAttribute( 'name' ) == divName){
    		matchingDivs.push( allTds.item(i) );
    	}    	    	  
    }        
    return matchingDivs;
}

function performExpandOrCollapse(currentTypeID){
//	var divCollapseComment = getObjectByName('collapseComment'+currentTypeID,'div');
//	var divExpandComment   = getObjectByName('expandComment'+currentTypeID,'div');
	
	var divCollapseComment =  $$('div[id^=collapseComment'+currentTypeID+']');
	var divExpandComment   =  $$('div[id^=expandComment'+currentTypeID+']');
//	divCollapseComment.each(function(div){alert(div.getProperty('id'))});
	
	var hiddenstatus = $('jav-mainbox-'+currentTypeID).getElements('input[name^=hidStatus'+ currentTypeID +'-]'); 

	if($("hidAllStatus"+currentTypeID).value != 1){
		$("expandOrCollapse"+currentTypeID).innerHTML = "[-] "+ $('hidCollapseAll').value;		
		for(i=0; i< divCollapseComment.length; i++){
			divCollapseComment[i].style.display = "none";
			divExpandComment[i].style.display   = "block";
			//set status of comment is 1
			hiddenstatus[i].value = 1;
			indexOfComment = divCollapseComment[i].id.lastIndexOf("-") + 1;
			commentID = divCollapseComment[i].id.substring(indexOfComment);
			saveCommentToCokie(commentID);
		}		
		//
		//set status of all comment is collapse
		$("hidAllStatus"+currentTypeID).value = 1;
	}
	//collapse all if choise collapse
	else{
		$("expandOrCollapse"+currentTypeID).innerHTML = "[+] " + $('hidExpandAll').value;
		for(i=0; i< divCollapseComment.length; i++){
			divCollapseComment[i].style.display = "block";
			divExpandComment[i].style.display   = "none";
			
			//set status of comment is 1
			hiddenstatus[i].value = 0;
			indexOfComment = divCollapseComment[i].id.lastIndexOf("-") + 1;
			commentID = divCollapseComment[i].id.substring(indexOfComment);
			saveCommentToCokie(commentID, "delete");
		}
		//set status of all comment is expand
	
		$("hidAllStatus"+currentTypeID).value = 2;
	}
	//if($(expandOrCollapse))
}

function actionInComment(commentID, typeID){			
	//collapseComment  expandComment actionComment
	//alert("actionComment"+commentID);
	//$("actionComment"+commentID).innerHTML = "action now";
	if($("expandComment"+typeID+"-"+commentID).style.display == "none"){
		$("collapseComment"+typeID+"-"+commentID).style.display = "none";
		$("actionCollapseComment"+typeID+"-"+commentID).style.display = "none";
		$("expandComment"+typeID+"-"+commentID).style.display 	 = "block";		
		$("hidStatus"+typeID+"-"+commentID).value = 1;
		
		var divExpandComment   =  $$('div[id^=expandComment'+typeID+']');
		checkExpandAll = 1;
		for(i=0; i< divExpandComment.length; i++){
			if(divExpandComment[i].style.display == "none"){				
				checkExpandAll = 0;
				break;
			}
		}
		if(checkExpandAll == 1){			
			$("expandOrCollapse"+typeID).innerHTML = "[-] "+ $('hidCollapseAll').value;
			$("hidAllStatus"+typeID).value = 1;
		}
		
		//save status of comment to session
		saveCommentToCokie(commentID);
	}else{
		$("expandComment"+typeID+"-"+commentID).style.display   = "none";
		$("actionExpandComment"+typeID+"-"+commentID).style.display = "none";
		$("collapseComment"+typeID+"-"+commentID).style.display = "block";
		$("hidStatus"+typeID+"-"+commentID).value = 0;
		
		var divCollapseComment =  $$('div[id^=collapseComment'+typeID+']');
		checkCollapse = 1;
		for(i=0; i< divCollapseComment.length; i++){
			if(divCollapseComment[i].style.display == "none"){
				checkCollapse = 0;				
				break;
			}
		}
		
		if(checkCollapse == 1){
			$("expandOrCollapse"+typeID).innerHTML = "[+] " + $('hidExpandAll').value;
			$("hidAllStatus"+typeID).value = 2;			
		}
		
		saveCommentToCokie(commentID, "delete");
	}
}

function showActionComment(commentID, typeID){	
	if($("expandComment"+typeID+"-"+commentID).style.display == "none"){
		$("actionCollapseComment"+typeID+"-"+commentID).style.display = "block";
		$("actionCollapseComment"+typeID+"-"+commentID).innerHTML = "[+] " + $('hidClickToExpand').value;	
	}else{
		$("actionExpandComment"+typeID+"-"+commentID).style.display = "block";
		$("actionExpandComment"+typeID+"-"+commentID).innerHTML = "[-] " + $('hidClickToCollapse').value;
	}			
}



function changeTypeOfComment(type,id,removeTabID,currentTypeID){
	jQuery(document).ready( function($) {
        ids='#'+jav_header;
        $(ids).css('z-index','1');        
        $('#loader').show();
    });
	
	url = "index.php?option=com_jacomment&view=comments&type="+ type +"&layout=changetype&id="+ id +"&curenttypeid="+ currentTypeID +"&tmpl=component";
	
	//collapse comment
	saveCommentToCokie(id, "delete");
	
	if($('limitstart'+currentTypeID) != undefined)
			limitstart = $('limitstart'+currentTypeID).value;
	
	if($('list'+currentTypeID) != undefined)
		limit = $('list'+currentTypeID).value;
	
	if($('keywordsearch') != undefined && $('keywordsearch').value!= ""){
		url += "&keyword=" + $('keywordsearch').value;
	}
	
	if($('slComponent') != undefined && $('slComponent').value != ""){
		url += "&optionsearch=" + escape($('slComponent').value);		
	}
    if($('slSource') != undefined){
        url += "&sourcesearch=" + escape($('slSource').value);        
    }		
	
	if($('jacReported') != undefined){
		if($('jacReported').checked == true)
			url += "&reported=" + escape($('jacReported').value);        
	}	
	
	url = getUrlSort(url);
	
	jQuery(document).ready( function($) {
		//url += "&"+$("#adminForm" + currentTypeID).serialize();	
		//url = getCheckBoxSelected(url);		
		//remove class loaded - reload comment of spam   	 	   	 		   	
		$.getJSON(url, function(response){
			jav_parseData(response);
			var reload = 0;
			
			if(currentTypeID != 99){
				var clicked = $("#jav-typeid_99").attr('class');			
				if(clicked.indexOf('loaded') != -1){
					$("#jav-typeid_99").removeClass('loaded');
				}
				
				clicked = $("#jav-typeid_" + type).attr('class');			
				if(clicked.indexOf('loaded') != -1){
					$("#jav-typeid_" + type).removeClass('loaded');
				}
			}else{				
				clicked = $("#jav-typeid_" + type).attr('class');			
				if(clicked.indexOf('loaded') != -1){
					$("#jav-typeid_" + type).removeClass('loaded');
				}
				
				clicked = $("#jav-typeid_" + removeTabID).attr('class');			
				if(clicked.indexOf('loaded') != -1){
					$("#jav-typeid_" + removeTabID).removeClass('loaded');
				}
					
			}											
	     });
	});
}
	
function deleteComment(id, currentTypeID, parentType){	
	var action  = confirm($('hidDeleteComment').value);
	var errorDelete = $("hidYouMustDelete").value;
	var reload = 0;
	
	if (action){		
		//check sub of comment
		url = "index.php?option=com_jacomment&view=comments&type=delete&layout=checksubofcomment&id="+ id +"&curenttypeid="+ currentTypeID +"&tmpl=component";		
		jQuery.ajax({
			   type: "POST",
			   url: url,			   
			   success: function(msg){
				msg = jQuery.trim(msg);
			     if(msg != "OK"){			    	 
			    	 //alert($("#jav-typeid_0").attr('class'));
			    	 //alert($('#hidYouMustDelete').val());
			    	 alert(errorDelete);
			    	 return;
			     }else{
			    	 url = "index.php?option=com_jacomment&view=comments&type=delete&layout=changetype&id="+ id +"&curenttypeid="+ currentTypeID +"&tmpl=component";
					 if($('keywordsearch') != undefined && $('keywordsearch').value!= ""){
						url += "&keyword=" + $('keywordsearch').value;
					}
					
					if($('slComponent') != undefined && $('slComponent').value != ""){
						url += "&optionsearch=" + escape($('slComponent').value);		
					}
                    if($('slSource') != undefined){
                        url += "&sourcesearch=" + escape($('slSource').value);        
                    }	
					if($('jacReported') != undefined){
						if($('jacReported').checked == true)
	                        url += "&reported=" + escape($('jacReported').value);        
                    }	
					
					url = getUrlSort(url);
					
			 		//url = "index.php?option=com_jacomment&view=comments&type=delete&layout=comments&limitstart=0&tmpl=component";
			 		limitstart = $('limitstart'+currentTypeID).value;
					if($('list'+currentTypeID) != undefined)
				 		limit = $('list'+currentTypeID).value;
			 		url += "&limitstart="+limitstart+"&limit="+limit;
			 		
			 		jQuery(document).ready( function($) {
			 			//url += "&"+$("#adminForm" + currentTypeID).serialize();
						//url = getCheckBoxSelected(url);
			 			$.getJSON(url, function(response){
			 				jav_parseData(response);
			 				var reload = 0;
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
			 									$(divId).attr(type, value);
			 								}
			 							}
			 						}
			 					}
			 								
			 								    	 				    					    	 
			 				});
			 				
			 				if(currentTypeID != 0){
			 					var clicked = $("#jav-typeid_0").attr('class');			
			 					if(clicked.indexOf('loaded') != -1){
			 						$("#jav-typeid_0").removeClass('loaded');
			 					}										
			 				}else{				
			 					clicked = $("#jav-typeid_" + parentType).attr('class');			
			 					if(clicked.indexOf('loaded') != -1){
			 						$("#jav-typeid_" + parentType).removeClass('loaded');
			 					}																
			 				}
			 				
			 				if (reload == 1)
			 					window.document.adminForm.submit();
			 				else
			 					setTimeout("hiddenMessage()", 5000);				
			 		     });
			 		});

			     }
			   }
		});						
				
	}
}

function getCodeTypeOfTab(task){
	if(task == "approve"){
		return 1;
	}else if(task == "unapprove"){
		return 0;
	}else if(task == "delete"){
		return "delete";
	}else{
		return 2;
	}
}

function jac_doPaging( limitstart, limit, order, keyword ){
	var mainUrl = "index.php?tmpl=component&option=com_jacomment&view=comments&layout=paging&limitstart=0&limit=" + eval(limit) + "&curenttypeid="+ $('currentTypeID').value;	
	
	if(order){
		mainUrl += "&order=" + escape(order);
	}
	
	if(keyword){
		mainUrl += "&keyword=" + escape(keyword);
	}
	
	if($('slComponent') != undefined && $('slComponent').value != ""){
		mainUrl += "&optionsearch=" + escape($('slComponent').value);		
	}
    if($('slSource') != undefined){
        mainUrl += "&sourcesearch=" + escape($('slSource').value);        
    }	
	
	if($('jacReported') != undefined){
		if($('jacReported').checked == true)
			mainUrl += "&reported=" + escape($('jacReported').value);        
	}	
	
	mainUrl = getUrlSort(mainUrl);
	
	jcomment_ajax_load(mainUrl, $('currentTypeID').value);	
}

//ajax pagination
function jac_ajaxPagination(url,divid) {	
	if(url.indexOf('?') > 0) {
		url = url + '&curenttypeid='+ $('currentTypeID').value;
	}else {		
		url = url + '?curenttypeid='+ $('currentTypeID').value;
	}	
	listID = "list" + $("currentTypeID").value;
	url = url + "&limit=" + $(listID).value;	
	if(url.indexOf('limitstart')<=0){
		url = url + "&limitstart=0";
	}
	
	if($('keywordsearch') != undefined && $('keywordsearch').value!= ""){
		url += "&keyword=" + $('keywordsearch').value;
	}
	
	if($('slComponent') != undefined && $('slComponent').value != ""){
		url += "&optionsearch=" + escape($('slComponent').value);		
	}
    if($('slSource') != undefined){
        url += "&sourcesearch=" + escape($('slSource').value);        
    }
	
    if($('jacReported') != undefined){
		if($('jacReported').checked == true)
			url += "&reported=" + escape($('jacReported').value);        
	}	
	
	url = getUrlSort(url);
	jcomment_ajax_load(url, $('currentTypeID').value);
	//pr_ajax = new Ajax(url,{method:'get', update:divid, onComplete:update}).request(); 
}

function checkdataString(el, class_css) {
	var li_parent = $(el.parentNode.parentNode);
	if (el.value != '')
		li_parent.removeClass(class_css);
	else
		li_parent.addClass(class_css);
}

function closemessage(){
	jQuery(document).ready(function($) {
		id='#'+jav_header;
		$(id).css('z-index','10');
		$('#jac-msg-succesfull').css('display','none');
	});	
}

function displaymessageadmin(){
	jQuery(document).ready(function($) {
		id='#'+jav_header;
		$(id).css('z-index','1');
		$('#jac-msg-succesfull').css('display','');
	});	
	setTimeout('closemessage()', 4500);	
}

function displaymessage(){
	jQuery(document).ready(function($) {
		id='#'+jav_header;
		$(id).css('z-index','1');
		$('#jav-msg-succesfull').css('display','');
	});	
}

function jcomment_ajax_load(url) {	
	jQuery(document).ready( function($) {
		$.getJSON(url, function(response){
			jQuery(document).ready( function($) {
		        if($('#loader')) {
		            id='#'+jav_header;
		            $(id).css('z-index','10');            
		            $('#loader').hide();
		        }
		    });
			
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
				if(type == undefined){
					type = item.attr;
				}
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
								$(divId).attr(type, value);
							}
						}
					}
				}															    	 				    					    
			});									
	     });
	});	
}

function saveReplyComment(currentTypeID){
	parentID = $("currentCommentID").value;	
	//checking spelling - return
	if($("newcomment").innerHTML != undefined && $("newcomment").value == undefined && $("checkLink") != undefined){	
		$("err_newcomment").innerHTML = $("hidEndEditText").value;
		return;
	}
	
	if($("newcomment").value != undefined){
		realText = "";
		if($('newcomment').value != undefined)
			realText = trim(stripcode($('newcomment').value, false, true));		
		if(realText == ""){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidInputComment").value;
			return;
		}else if(realText.length <   minLengthComment){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidShortComment").value;
			return;
		}else if(realText.length > maxLengthComment){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidLongComment").value;
			return;
		}
	}		
	
				
	jQuery(document).ready(
			function($) {				
				//url = "index.php?curenttypeid=" + currentTypeID + "&" +$("#adminFormReply").serialize();
				url = "index.php?curenttypeid=" + currentTypeID;
				url += "&option=com_jacomment&view=comments&task=saveComment&tmpl=component";
				url +="&newcomment=" + encodeURIComponent($("#newcomment").val()); 
				url +="&subscription_type=" + escape($("#subscription_type").val());
				
				if($("#formreply") != undefined){
					if($("#formreply").serialize() != "")
						url += "&"+$("#formreply").serialize();
				}
				url +="&parentid=" + parentID;	
				
				jcomment_ajax_load(url);																																											
	});	
}

function actionBeforEditReply(id, currentTypeID, action){		
	//disable form edit of current id
	if($("currentCommentID").value != 0 && $("currentCommentID") != undefined){
		currentID = $("currentCommentID").value;
		var currentTypeArray = new Array (99, 0, 1, 20);		
		for(i = 0 ; i < currentTypeArray.length; i++){			
			if($("fotter-comment-right-"+currentTypeArray[i]+"-"+currentID) != undefined){
				if($("fotter-comment-right-"+currentTypeArray[i]+"-"+currentID).style.display == "none"){
					//when edit
					if($("commentExpand"+currentTypeArray[i]+"_"+currentID ).style.display == "none"){
						$("jac-edit-comment-"+currentTypeArray[i]+"-"+currentID ).innerHTML  = "";
						$("commentExpand"+currentTypeArray[i]+"_"+currentID ).style.display = "block";						
						if($("jac-attach-file-"+currentTypeArray[i]+"-"+currentID))
							$("jac-attach-file-"+currentTypeArray[i]+"-"+currentID).style.display = "block";
					}else{
						$("jac-result-reply-comment-"+currentTypeArray[i]+"-"+currentID ).innerHTML  = "";
					}
					$("fotter-comment-right-"+currentTypeArray[i]+"-"+currentID ).style.display = "block";
				}				
			}			
		}				
		
	}
	
	//disable form edit:
	
	$("fotter-comment-right-"+currentTypeID+"-"+id).style.display = "none";
	
	if(!action){
		$("commentExpand"+currentTypeID+"_"+id).style.display = "none";					
		if($("jac-attach-file-"+currentTypeID+"-"+id) != undefined)
			$("jac-attach-file-"+currentTypeID+"-"+id).style.display = "none";
	}
		
	$("currentCommentID").value = id;
}

function editComment(id,currentTypeID){	
	if($("expandComment"+currentTypeID+"-"+id).style.display == "none"){
		$("collapseComment"+currentTypeID+"-"+id).style.display = "none";
		$("actionCollapseComment"+currentTypeID+"-"+id).style.display = "none";
		$("expandComment"+currentTypeID+"-"+id).style.display 	 = "block";		
		$("hidStatus"+currentTypeID+"-"+id).value = 1;
		
		//save status of comment to session
		saveCommentToCokie(id);
	}
	url = "index.php?tmpl=component&option=com_jacomment&view=comments&layout=editcomment";
	url += "&id="+id+"&currenttypeid="+currentTypeID;	
	
	actionBeforEditReply(id, currentTypeID);
		
	jcomment_ajax_load(url);		  
}

function cancelEditComment(id, currentTypeID){	
	url = "index.php?tmpl=component&option=com_jacomment&view=comments&task=cancelUploadComment";
	jcomment_ajax_load(url);
	
	$("commentExpand"+currentTypeID+"_"+id).style.display = "block";	
	$("fotter-comment-right-"+currentTypeID+"-"+id).style.display = "block";
	$("jac-edit-comment-"+currentTypeID+"-"+id).innerHTML = "";
	if($("jac-attach-file-"+currentTypeID+"-"+id) != undefined)
		$("jac-attach-file-"+currentTypeID+"-"+id).style.display = "block";
	$("currentCommentID").value = 0;
}

function updateComment(id, currentTypeID) {		
	if($("newcomment").innerHTML != undefined && $("newcomment").value == undefined && $("checkLink") != undefined){		
		$("err_newcomment").innerHTML = $("hidEndEditText").value;	
		return;
	}		
	
	if($("newcomment").value != undefined){		
		realText = trim(stripcode($('newcomment').value, false, false));
		
		if(realText == ""){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidInputComment").value;
			return;
		}else if(realText.length <   minLengthComment){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidShortComment").value;
			return;
		}else if(realText.length > maxLengthComment){
			$("newcomment").focus();
			$("err_newcomment").innerHTML = $("hidLongComment").value;
			return;
		}
	}else{
		return;
	}
	
		jQuery(document).ready(
		function($) {
			url = "index.php?curenttypeid=" + currentTypeID + "&" +$("#adminForm"+currentTypeID+"-"+id).serialize();			
			if($("#formreply") != undefined){				
				url += "&"+$("#formreply").serialize();
			}										
			jcomment_ajax_load(url);
    	});				
}

function successWhenReply(){
	id = $("currentCommentID").value;
	currentTypeIDReply = $("currentTypeID").value;	
	$("fotter-comment-right-"+currentTypeIDReply+"-"+id).style.display = "block";
	$("currentCommentID").value = 0;
}

function successWhenEdit(){
	id 			  = $("currentCommentID").value;
	currentTypeIDEdit = $("currentTypeID").value;	
	$("commentExpand"+currentTypeIDEdit+"_"+id).style.display = "block";	
	$("fotter-comment-right-"+currentTypeIDEdit+"-"+id).style.display = "block";
	$("jac-edit-comment-"+currentTypeIDEdit+"-"+id).innerHTML = "";
	if($("jac-attach-file-"+currentTypeIDEdit+"-"+id) != undefined)
		$("jac-attach-file-"+currentTypeIDEdit+"-"+id).style.display = "block";
	$("currentCommentID").value = 0;
}

function cancelReplyComment(currentTypeID){
	id = $("currentCommentID").value;	
	$("fotter-comment-right-"+currentTypeID+"-"+id).style.display = "block";
	$("jac-result-reply-comment-"+currentTypeID+"-"+id).innerHTML = "";
}

function replyComment(currentTypeID, id, replyto){
	if($("expandComment"+currentTypeID+"-"+id).style.display == "none"){
		$("collapseComment"+currentTypeID+"-"+id).style.display = "none";
		$("actionCollapseComment"+currentTypeID+"-"+id).style.display = "none";
		$("expandComment"+currentTypeID+"-"+id).style.display 	 = "block";		
		$("hidStatus"+currentTypeID+"-"+id).value = 1;
		
		//save status of comment to session
		saveCommentToCokie(id);
	}
	url = "index.php?tmpl=component&option=com_jacomment&view=comments&layout=replycomment";
	url += "&id="+id+"&currenttypeid="+currentTypeID;	
	url += "&replyto="+replyto;		
	
	if($('keywordsearch') != undefined && $('keywordsearch').value!= ""){
		url += "&keyword=" + $('keywordsearch').value;
	}
	
	if($('slComponent') != undefined && $('slComponent').value != ""){
		url += "&optionsearch=" + escape($('slComponent').value);		
	}	
    if($('slSource') != undefined){
        url += "&sourcesearch=" + escape($('slSource').value);        
    }
    if($('jacReported') != undefined){
		if($('jacReported').checked == true)
			url += "&reported=" + escape($('jacReported').value);        
	}	
	
	url = getUrlSort(url);
	
	actionBeforEditReply(id, currentTypeID, "reply");
		
	jcomment_ajax_load(url);
}

function cancelComment(curenttypeid, id){
	url = "index.php?tmpl=component&amp;option=com_jacomment&amp;view=comments&amp;task=cancelUploadComment";
	jcomment_ajax_load(url);
	
    jQuery("#reply_comment_"+ curenttypeid + "_" + id).hide("");
}

function saveReply(curenttypeid, id){
    comment = document.getElementById("ta_reply_comment_"+ curenttypeid + "_" +id).value; 
	url = "index.php?tmpl=component&amp;option=com_jacomment&amp;view=comments&amp;task=savereply&no_html=1&displaymessage=show&comment=" + comment + "&parentid=" + id;	
    if(comment){
        jQuery.ajax({
            type: "POST",
            url:url,
            success: function(html){            	
            	jQuery("#ta_reply_comment_"+ curenttypeid + "_" + id).val("");            	            	
                jQuery("#show_reply_"+ curenttypeid + "_" + id).html(jQuery("#show_reply_"+ curenttypeid + "_" + id).html() + html);                
                jQuery("#reply_comment_"+ curenttypeid + "_" + id).hide("");
            }
        });
    }
}

function jac_displayLoadingSpan() {	
	jQuery(document).ready( function($) {
		id='#'+jav_header;
		$(id).css('z-index','1');		
		$('#loader').show();
	});		
}

function getUrlSort(url){
	jQuery(document).ready( function($) {
		if($("#jac_sort_comment") != undefined){
			if($("#jac_sort_comment").attr("class") == "jac_sort_by_oldest"){
				url += "&sorttype=DESC";
			}else{
				url += "&sorttype=ASC";
			}
		}
	});	
	return url;
}

function sortComment(type, textDESC, textASC){		
	getcurrentTypeID = $("currentTypeID").value;
	jac_displayLoadingSpan();
	if(type == "DESC"){	 				
		url = "index.php?tmpl=component&option=com_jacomment&view=comments&layout=sortcomment&sorttype=DESC";
	}else{
		url = "index.php?tmpl=component&option=com_jacomment&view=comments&layout=sortcomment&sorttype=ASC";
	}
		url += "&curenttypeid="+getcurrentTypeID;
		
		$("jac_sort_comment").style.display = "none";
		jQuery(document).ready(function($) {
			$("#jac_span_sort_comment").removeAttr("style");
		});
				
		if($('limitstart'+getcurrentTypeID) != undefined)
			limitstart = $('limitstart'+getcurrentTypeID).value;
		if($('list'+getcurrentTypeID).value != undefined)
			limit = $('list'+getcurrentTypeID).value;
		
		url += "&limitstart="+limitstart+"&limit="+limit;
		
		if($('keywordsearch') != undefined && $('keywordsearch').value!= ""){
			url += "&keyword=" + $('keywordsearch').value;
		}
		
		if($('slComponent') != undefined && $('slComponent').value != ""){
			url += "&optionsearch=" + escape($('slComponent').value);		
		}
        
        if($('slSource') != undefined){
            url += "&sourcesearch=" + escape($('slSource').value);        
        }
		if($('jacReported') != undefined){
			if($('jacReported').checked == true)
			url += "&reported=" + escape($('jacReported').value);        
		}	
		jcomment_ajax_load(url);			
}

function displaymessage(timeDelay){
    jQuery(document).ready(function($) {
        id='#'+jav_header;
        $(id).css('z-index','1');
        $('#jac-msg-succesfull').css('display','');
    });    
    if(timeDelay)
        setTimeout('closemessage()', timeDelay);
    else
        setTimeout('closemessage()', 4000);
}

function getCheckBoxSelected(url){
	getCurrentTypeID = $("currentTypeID").value;
	arrayCheckBox = $('jav-mainbox-'+getCurrentTypeID).getElements('input[name^=cid]');
	arrayCheckBox.each(function(checkBox){
		if(checkBox.checked == true){
			url +="&cid[]=" + checkBox.value;
			saveCommentToCokie(checkBox.value, "delete");
		}
	});
	//hidAllStatus
	url += "&hidAllStatus"+ getCurrentTypeID +"=" + $("hidAllStatus" + getCurrentTypeID).value;
	
//	arrayStatus = $('jav-mainbox-'+getCurrentTypeID).getElements('input[id^=hidStatus' + getCurrentTypeID +  ']');
//	arrayStatus.each(function(status){
//		url += "&" + status.id +"=" + status.value ;
//	});
//	alert(url);
	return url;
}

function showListCommentFromDisqus(source, type){
	//err-select-disqus
	if($("select-file-disqus").value == ""){
		$("err-select-disqus").style.display = "block";
		return false;
	}
	frm = document.adminForm;    
    frm.source.value = source;
    frm.type.value = "showcomment";
	frm.group.value = "showcomment";
	frm.task.value = "showcomment";
    frm.action = "index.php?option=com_jacomment&view=imexport&task=showcomment";
    frm.submit();
    return true;
}

//END -- BBJACODE
function stripcode(F,G,isQuote){	
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