<?php  
defined('_JEXEC') or die('Retricted Access');
JHTML::_('behavior.tooltip');
JHTML::_('behavior.switcher');
$selected = 'selected="selected"';
?>
<script type="text/javascript" language="javascript">
	var actionNumberCharacter = "min";
jQuery(document).ready(function(){
	jQuery.each( ["word","ip","email"], function(i, n){
		jQuery("#add_blocked_" + n + "_link").click(function () {
			jQuery("#add_blocked_" + n + "").show("fast");
			jQuery("#add_blocked_" + n + "_link").hide("");
            jQuery("#ta_blocked_" + n + "_list").focus();
		});
		jQuery("#blocked_" + n + "_cancel").click(function () {
			jQuery("#add_blocked_" + n + "_link").show("");
			jQuery("#add_blocked_" + n + "").hide("");			
			if(jQuery("#jac-" + n + "-error").length >0){
				jQuery("#jac-" + n + "-error").attr('style', 'display:none');	
			}			
		});
	});
    
    jQuery.each( ["enable_terms"], function(i, n){
        jQuery("#is_" + n).click(function () {
            if(jQuery("#is_" + n).is(':checked')){
                jQuery("#ja-block-" + n).show("");    
            }else{
                jQuery("#ja-block-" + n).hide("");    
            }
        });
    });
    
    
    jQuery.each( ["enable_captcha","enable_terms"], function(i, n){
        jQuery("input[id='is_"+n+"']").click(function() {
            show_bar_preview('<?php echo JText::_('PREVIEW')?>', '<?php echo JText::_('CANCEL')?>');
        });  
    });     
    
    

});

function save_blockblack(tab){ 
    data = document.getElementById("ta_"+tab).value;  
    if(data){
        jQuery.ajax({
            type: "POST",
            url: "index.php?tmpl=component&option=com_jacomment&view=configs&group=spamfilters&task=saveblockblack",
            data: "&data=" + data + "&tab=" + tab,
            success: function(html){
                jQuery("#"+tab).html(html);
                document.getElementById("ta_"+tab).value='';
                jQuery("#ta_"+tab).focus();
            }
        });
    }    
}
function remove_blockblack(tab, id){  
    jQuery.ajax({
        type: "POST",
        url: "index.php?tmpl=component&option=com_jacomment&view=configs&group=spamfilters&task=removeblockblack",
        data: "tab=" + tab + "&id=" + id,
        success: function(html){
            jQuery("#"+tab).html(html);
        }
    });    
}    

jQuery(function() {
    jQuery(document).ajaxSend(function() {
        jQuery('#indicator').html('<?php echo JHTML::_('image', JURI::root().'administrator/components/com_jacomment/asset/images/loading.gif', '', '');?>');    
    });
    jQuery(document).ajaxStop(function() {
        jQuery('#indicator').html('');    
    });
});    
</script>
<form action="index.php" method="post" name="adminForm">
<div class="col100">
	<fieldset class="adminform TopFieldset">
		<?php echo $this->getTabs();?>
	</fieldset>
	<br/>
	
	<div id="SpamFiter">
		<div class="box">
			<h2><?php echo JText::_('SPAM_FILTER_SETTINGS');?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-1 ja-section-title">
						<h4><?php echo JText::_('CAPTCHA_SETTINGS')?></h4>
					</li>
					<li class="row-0">				
						<label for="is_enable_captcha" class="editlinktip hasTip" title="<?php echo JText::_('ENABLE_CAPTCHA_IMAGE_SECURITY' );?>::<?php echo JText::_('ENABLE_CAPTCHAIMAGE_FOR_GUEST_POSTER_NEEDS_TO_TYPE_IN_THE_DISPLAYED_CHARACTER_IN_ORDER_TO_POST_A_NEW_COMMENT' ); ?>">
							<?php $isEnableCaptcha = $this->params->get('is_enable_captcha', 0);?>
							<input type="checkbox" onclick="checkValidCaptcha(this);" <?php if($isEnableCaptcha){?>checked="checked"<?php }?> value="1" name="spamfilters[is_enable_captcha]" id="is_enable_captcha"/> 
							<?php echo JText::_('ENABLE_CAPTCHA_IMAGE_SECURITY')?>
						</label>						
					</li>
					
					<li class="row-0">
						<label for="is_enable_captcha_user" class="editlinktip hasTip" title="<?php echo JText::_('ENABLE_CAPTCHA_FOR_REGISTERED_USER' );?>::<?php echo JText::_('ENABLE_CAPTCHAIMAGE_FOR_REGISTERED_USER_POSTER_NEEDS_TO_TYPE_IN_THE_DISPLAYED_CHARACTER_IN_ORDER_TO_POST_A_NEW_COMMENT' ); ?>">
							<?php $isEnableCaptchaUser = $this->params->get('is_enable_captcha_user', 0);?>
							<input type="checkbox" <?php if($isEnableCaptchaUser){?>checked="checked"<?php }?> onclick="checkValidCaptcha(this);" value="1" name="spamfilters[is_enable_captcha_user]" id="is_enable_captcha_user"/> 
							<?php echo JText::_("ENABLE_CAPTCHA_FOR_REGISTERED_USER");?>
						</label>						
					</li>
					
					<!--<li class="row-0 ja-section-title">
						<b><?php echo JText::_('AKISMET_SPAM_DETECTION')?></b>
					</li>			
					<li class="row-1">
						<label for="is_use_akismet">
							<?php $isUseAkismet = $this->params->get('is_use_akismet', 0);?>
							<input type="checkbox" <?php if($isEnableCaptcha){?>checked="checked"<?php }?> value="1" name="spamfilters[is_use_akismet]" id="is_use_akismet" onclick="isuseakismet($('is_use_akismet'))"/> 
							<span class="editlinktip hasTip" title="<?php echo JText::_('USE_AKISMET_SPAM_DETECTION_SERVICE' );?>::<?php echo JText::_('USE_AKISMET_SPAM_DETECTION_SERVICE_TOOLTIP' ); ?>">
								<?php echo JText::_("USE_AKISMET_SPAM_DETECTION_SERVICE");?>
							</span>
						</label>
						<div class="child clearfix" id='div_display_akismet'>
							<div class="editlinktip hasTip" title="<?php echo JText::_('AKISMET_ACCESS_KEY' );?>::<?php echo JText::_('AKISMET_ACCESS_KEY_TOOLTIP' );?>">
								<?php echo JText::_("AKISMET_ACCESS_KEY");?>
							</div>					
							<input type="text" name="spamfilters[akismet_key]" value="<?php echo $this->params->get('akismet_key');?>" id="akismet_key" size="40"/>
							<br/>
							<small><?php echo JText::_('TO_RETRIEVE_YOUR_AKISMET_API')?></small>
						</div>	
					</li>-->
					
					<li class="row-1 ja-section-title" style="margin-top: 13px;">
						<b><?php echo JText::_('TERMS_AND_CONDITIONS')?></b>
					</li>			
					<li class="row-0">				
						<label for="is_enable_terms">
							<?php $isEnableTerms = $this->params->get('is_enable_terms', 0);?>
							<input type="checkbox" <?php if($isEnableTerms){?>checked="checked"<?php }?> value="1" name="spamfilters[is_enable_terms]" id="is_enable_terms" onclick="isenableterms($('is_enable_terms'))"/> 
							<span class="editlinktip hasTip" title="<?php echo JText::_('ENABLE_TERMS_AND_CONDITIONS' );?>::<?php echo JText::_('ENABLE_THE_TERMS_AND_CONDITIONS_AT_COMMENT_PAGE')?>">
								<?php echo JText::_("ENABLE_TERMS_AND_CONDITIONS");?>
							</span>
						</label>
						<div id="ja-block-enable_terms"<?php if(!$isEnableTerms){?>style="display:none"<?php } ?>>
							<div class="child clearfix" id='div_display_terms'>
								<div class="editlinktip hasTip" title="<?php echo JText::_('TERMS_OF_USAGE' );?>::<?php echo JText::_('TERMS_OF_USAGE_TOOLTIP' );?>">
									<?php echo JText::_("TERMS_OF_USAGE");?>:
								</div>					
								<textarea name="spamfilters[terms_of_usage]" id="terms_of_usage" cols="50" rows="5"><?php echo $this->params->get('terms_of_usage');?></textarea>
							</div>
						</div>					
					</li>
					
					<li class="row-1 ja-section-title" style="margin-top: 13px;">
						<b><?php echo JText::_('BLOCK_SETTINGS')?></b>
					</li>
					
					<li class="row-0 pd10">
						<div class="tab_list">
							<ul id="ja-tabs" class="page-words">
								<li><a id="words" class="active"><?php echo JText::_('WORDS')?></a></li>
								<li><a id="ips"><?php echo JText::_('IP_ADDRESSES')?></a></li>
								<li><a id="emails"><?php echo JText::_('EMAIL_ADDRESSES')?></a></li>
							</ul>				
							<span id="indicator"></span>
							<div class="clr"></div>
							<div id="ja-tabs-content">
								<div id="page-words" class="tab">
									<p><?php echo JText::_('THE_COMMENTS_CONTAINING_THESE_ADDED_WORDS_HERE_WILL_BE_AUTOMATICALLY_DELETED');?></p>
									<ul id="blocked_word_list"><?php echo $this->lists['blocked_word_list'];?></ul>
									<div id="add_blocked_word" style="display: none; width: 400px;">
										<textarea id="ta_blocked_word_list" name="blocked_word_list" style="width: 400px;text-transform:uppercase;"></textarea><p>
											<span style="float: right; display: inline;">
											<a href="javascript: void('');" id="blocked_word_cancel" class="btn_add cancel"><?php echo JText::_('CANCEL');?></a>
											<input value="<?php echo JText::_('SAVE');?>" class="button btn_add" type="button" onclick="javascript:save_blockblack('blocked_word_list');"></span>
											<span><?php echo JText::_('ADD_MULTIPLE_WORDS_SEPARATED_BY_A_SPACE');?></span>
										</p>
									</div>
									<p style="display: block;" id="add_blocked_word_link">
										<a href="javascript: void('');" class="btn_add"><?php echo JText::_('ADD_WORD_S');?></a>
									</p>
								</div>
								<div id="page-ips" class="tab">
									<p><?php echo JText::_('THE_COMMENTS_COMING_FROM_ADDED_IP_ADDRESSES_HERE_WILL_BE_AUTOMATICALLY_DELETED');?></p>
									<ul id="blocked_ip_list"><?php echo $this->lists['blocked_ip_list'];?></ul>
									<div id="add_blocked_ip" style="display: none; width: 400px;">
										<textarea id="ta_blocked_ip_list" class="text" style="width: 400px;"></textarea>
										<p>
											<span style="float: right; display: inline;">
											<a href="javascript: void('');" id="blocked_ip_cancel" class="btn_add cancel"><?php echo JText::_('CANCEL');?></a>
											<input value="<?php echo JText::_('SAVE');?>" class="button btn_add" type="button" onclick="javascript:save_blockblack('blocked_ip_list');"></span>
											<span><?php echo JText::_('ADD_MULTIPLE_IPS_SEPARATED_BY_A_SPACE');?></span>
										</p>
									</div>
									<p style="display: block;" id="add_blocked_ip_link">
										<a href="javascript: void('');" class="btn_add"><?php echo JText::_('ADD_IP_ADDRESS_ES');?></a>
									</p>
								</div>
								<div id="page-emails" class="tab">
									<p><?php echo JText::_('THE_COMMENTS_COMING_FROM_ADDED_EMAIL_ADDRESSES_HERE_WILL_BE_AUTOMATICALLY_DELETED');?></p>
									<ul id="blocked_email_list"><?php echo $this->lists['blocked_email_list'];?></ul>
									<div id="add_blocked_email" style="display: none; width: 400px;">
										<textarea id="ta_blocked_email_list" class="text" style="width: 400px;"></textarea>
										<p>
											<span style="float: right; display: inline;">
											<a href="javascript: void('');" id="blocked_email_cancel" class="btn_add cancel"><?php echo JText::_('CANCEL');?></a>
											<input value="<?php echo JText::_('SAVE');?>" class="button btn_add" type="button" onclick="javascript:save_blockblack('blocked_email_list');"></span>
											<span><?php echo JText::_('ADD_MULTIPLE_EMAILS_SEPARATED_BY_A_SPACE');?></span>
										</p>
									</div>
									<p style="display: block;" id="add_blocked_email_link">
										<a href="javascript: void('');" class="btn_add"><?php echo JText::_('ADD_EMAIL_ADDRESS_ES');?></a>
									</p>
								</div>
							</div>
							<div class="clr"></div>
						</div>
					</li>
					
					<li class="row-1 ja-section-title" style="margin-top: 13px;">
						<b><?php echo JText::_('OTHER_SPAM_SETTINGS')?></b>
					</li>
					<li class="row-0">				
						<label for="min_length">
							<a href='#' name="#min_length"></a>
							<input type="text" onkeypress="return isNumberKey(event, this)" onkeyup="checkValidKey(this.value,'min_length')" maxlength="4" name="spamfilters[min_length]" value="<?php echo $this->params->get('min_length', 10);?>" id="min_length" size="3" onfocus="checkNumberCharacter('min', this)" /> 
							<?php echo JText::_("CHARACTER_S_IS_MINIMUM_REQUIRED_FOR_A_COMMENT");?>
						</label>
						<p style="color: red;" id="error_min_length"></p>
						<p><?php echo JText::_('THE_MINIMUM_NUMBER_OF_CHARACTER_S_A_USER_MUST_POST' ); ?></p>
						<input type="hidden" id="hidden_min_length" value="<?php echo $this->params->get('min_length', 10);?>" />
						<label for="max_length">					
							<input type="text" onkeypress="return isNumberKey(event, this)" onkeyup="checkValidKey(this.value,'max_length')" maxlength="4" name="spamfilters[max_length]" value="<?php echo $this->params->get('max_length', 300);?>" id="max_length" size="3" onchange="checkNumberCharacter('max', this)"/> 
							<?php echo JText::_("CHARACTER_S_IS_THE_MAXIMUM_ALLOWED_FOR_A_COMMENT");?>
						</label>
						<p style="color: red;" id="error_max_length"></p>
						<p><?php echo JText::_('THE_MAXIMUM_NUMBER_OF_CHARACTER_S')?></p>

						<label for="censored_words">
							<span class="editlinktip hasTip" title="<?php echo JText::_('CENSORED_WORDS' );?>::<?php echo JText::_("ALL_CENSORED_WORDS_WILL_APPEAR" ); ?>">
								<?php echo JText::_("CENSORED_WORDS");?>
							</span>
						</label>
						<div class="child clearfix">								
							<textarea name="spamfilters[censored_words]" id="censored_words" cols="50" rows="5"><?php echo $this->params->get('censored_words');?></textarea>
						</div>	

						<label for="censored_words_replace">					
							<span class="editlinktip hasTip" title="<?php echo JText::_('WORD_FOR_REPLACEMENT' );?>::<?php echo JText::_('WORD_FOR_REPLACEMENT_TOOLTIP' ); ?>">
								<?php echo JText::_("WORD_FOR_REPLACEMENT");?>
							</span>
						</label>
						<div class="child clearfix">								
							<input type="text" name="spamfilters[censored_words_replace]" maxlength="<?php if($this->params->get('max_length', 300)>100){echo "100";}else{echo $this->params->get('max_length', 300);}?>" value="<?php echo $this->params->get('censored_words_replace');?>" id="censored_words_replace" size="70"/>
							<input type="hidden" id="hidden_censored_words_replace" value="<?php echo $this->params->get('censored_words_replace');?>"/>
						</div>	

						<label for="is_nofollow">	
							<?php $isNofollow = $this->params->get('is_nofollow', 1);?>
							<input type="checkbox" <?php if($isNofollow){?>checked="checked"<?php }?> value="1" name="spamfilters[is_nofollow]" id="is_nofollow"/>				
							<?php echo JText::_("TEXT_ADD_REL");?>
						</label>
						<p><?php echo JText::_("TEXT_BY_ADDING_ADD")?></p>

						<label for="number_of_links">
							<input type="text" onkeypress="return isNumberKey(event, this)" onkeyup="checkValidKey(this.value,'number_of_links')" maxlength="4" name="spamfilters[number_of_links]" value="<?php echo $this->params->get('number_of_links',5);?>" id="number_of_links" size="3" onchange="checkMaxLink()"/> 
							<?php echo JText::_("LINK_S_IS_THE_MAXIMUM_ALLOWED_PER_COMMENT");?>
						</label>
						<p style="color: red;" id="error_number_of_links"></p>
						<p><?php echo JText::_('THE_MAXIMUM_NUMBER_OF_LINK')?></p>
					</li>
				</ul>
			</div>
		</div>
	</div>			
</div>
<input type="hidden" id="hdInvalidCharacter" value="<?php echo JText::_("INVALID_INPUTING_NUMBER_OF_CHARACTERS_IN_COMMENT_THE_MAXIMUM_NUMBER_IS_ALWAYS_GREATER_THAN_MINIMUM");?>" />
<input type="hidden" id="hdInvalidMin" value="<?php echo JText::_("MINIMUM_MUST_BE_NUMBER_NOT_NULL_AND_GREATER_THAN_0");?>" />
<input type="hidden" id="hdInvalidMax" value="<?php echo JText::_("MAXIMUM_MUST_BE_NUMBER_NOT_NULL_AND_GREATER_THAN_0");?>" />
<input type="hidden" id="hdInvalidMaxLink" value="<?php echo JText::_("MAXIMUM_OF_LINK_MUST_BE_NUMBER_NOT_NULL_AND_GREATER_THAN_0");?>" />
<input type="hidden" id="hdCurrentInputCharacter" value="min_length" />
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="configs" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="group" value="<?php echo $this->group; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->cid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>	
</form>
<script>
//function isuseakismet(obj){
//	if(!obj.checked) $('akismet_key').disabled = true;
//	else $('akismet_key').disabled = false;
//	
//}
//isuseakismet($('is_use_akismet'));

function checkValidCaptcha(obj){
	if(obj.id == "is_enable_captcha_user"){
		if(obj.checked == true){
			$("is_enable_captcha").checked = true;
		}
	}else{
		if(obj.checked == false){
			$("is_enable_captcha_user").checked = false;
		}
	}	
}

function checkValidKey(value,obj){	
	if(value == 0){
		$(obj).value = "";
	}
}

function isNumberKey(evt, obj){
	   var charCode = (evt.which) ? evt.which : evt.keyCode
	   if (charCode > 31 && (charCode < 48 || charCode > 57))
	      return false;	   	
	   return true;
}

function checkMaxLink(){
	var checkInteger  = /(^\d\d*$)/;
	if(!checkInteger($("number_of_links").value)){		
		$("error_number_of_links").innerHTML = $("hdInvalidMaxLink").value;
	}else{
		$("error_number_of_links").innerHTML = "";
	}
}

function checkNumberCharacter(action, obj){		
	var checkInteger  = /(^\d\d*$)/;
	numberMax  = $("max_length").value;
	numberMin  = $("min_length").value; 

	if(action == "max"){
		if(numberMax>100){
			$("censored_words_replace").maxLength = 100;
		}else{
			$("censored_words_replace").maxLength = numberMax;
		}
		$("censored_words_replace").value = $("hidden_censored_words_replace").value.substring(0, numberMax);  
	}
	
	if(!checkInteger(numberMax) || !checkInteger(numberMin)){
		//error_min_length
		if(!checkInteger(numberMax)){
			$("error_max_length").innerHTML = $("hdInvalidMax").value;						
		}
		if(!checkInteger(numberMin)){
			$("error_min_length").innerHTML = $("hdInvalidMin").value;						
		}		
		return;		
	}else{								
		if( parseInt(numberMin,10) >= parseInt(numberMax,10)){						
			if(action == "min"){				
				//$("error_min_length").innerHTML = $("hdInvalidCharacter").value;
				$("max_length").value = parseInt(numberMin,10) + 1;		
			}else{				
				//$("error_max_length").innerHTML = $("hdInvalidCharacter").value;
				if(numberMax <= 0){
					$("error_max_length").innerHTML = $("hdInvalidMax").value;
					$("max_length").value = 1;
					$("min_length").value = 0;		
				}else{
					$("min_length").value = numberMax - 1;
				}
				actionNumberCharacter = "max";
			}													
			return;
		}		
	}
			
	$("error_max_length").innerHTML = "";
	$("error_min_length").innerHTML = "";
}

function isenableterms(obj){
	if(!obj.checked) $('terms_of_usage').disabled = true;
	else $('terms_of_usage').disabled = false;	
}
isenableterms($('is_enable_terms'));

window.addEvent('domready', function(){
 	toggler = $('ja-tabs');
  	element = $('ja-tabs-content');
  	if(element) {		
		document.switcher = new JSwitcher(toggler, element);  		
  	}
});
</script>