<?php
defined('_JEXEC') or die('Retricted Access');
$app = JFactory::getApplication();
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

$selected = 'selected="selected"';
?>
<form action="index.php" method="post" name="adminForm">
<div class="col100">
	<fieldset class="adminform TopFieldset">
		<?php echo $this->getTabs();?>
	</fieldset>
	<br />
    <div id="GeneralSettings">
		<div class="box">
			<h2><?php echo JText::_('PERMISSIONS' ); ?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li>
						<label>	
							<span class="editlinktip hasTip" title="<?php echo JText::_('VIEW_COMMENTS' );?>::<?php echo JText::_('SELECT_WHO_CAN_VIEW_COMMENTS' ); ?>">
							<?php echo JText::_("VIEW_COMMENTS");?>
							</span>
							<select name="permissions[view]" id="view" onchange="changeViewComment(this.value)">
							<option value="all"<?php if($this->params->get('view')=='all') echo $selected;?>><?php echo JText::_("ALL");?></option>
							<option value="member"<?php if($this->params->get('view')=='member') echo $selected;?>><?php echo JText::_("ONLY_MEMBER");?></option>
							</select>
						</label>
					</li>
					<li>
						<label>    
							<span class="editlinktip hasTip" title="<?php echo JText::_('POST_COMMENTS' );?>::<?php echo JText::_('SELECT_WHO_CAN_POST_COMMENTS' ); ?>">
							<?php echo JText::_("POST_COMMENTS");?>
							</span>
							<select name="permissions[post]" id="post" onchange="changeStatusComment(this)">
								<option value="all"<?php if($this->params->get('post')=='all') echo $selected;?>><?php echo JText::_("ALL");?></option>
								<option value="member"<?php if($this->params->get('post')=='member') echo $selected;?>><?php echo JText::_("ONLY_MEMBER");?></option>
							</select>
							<p style="color: red;display: none;" id="error_post"><?php echo JText::_("POST_COMMENT_APPLIES_ONLY_TO_MEMBER_BECAUSE_VIEW_COMMENT_IS_ONLY_MEMBER");?></p>
						</label>
					</li>
					<li>
						<label>    
							<span class="editlinktip hasTip" title="<?php echo JText::_('VOTE_COMMENTS' );?>::<?php echo JText::_('SELECT_WHO_CAN_VOTE_ON_COMMENTS' ); ?>">
							<?php echo JText::_("VOTE_COMMENTS");?>
							</span>
							<select name="permissions[vote]" id="vote" onchange="changeStatusComment(this)">
								<option value="all"<?php if($this->params->get('vote')=='all') echo $selected;?>><?php echo JText::_("ALL");?></option>
								<option value="member"<?php if($this->params->get('vote')=='member') echo $selected;?>><?php echo JText::_("ONLY_MEMBER");?></option>
							</select>
							<p style="color: red;display: none;" id="error_vote"><?php echo JText::_("VOTE_COMMENT_APPLIES_ONLY_TO_MEMBER_BECAUSE_VIEW_COMMENT_IS_ONLY_MEMBER");?></p>
						</label>
						<div style="padding-left:30px;">
							<?php $typeVoting = $this->params->get('type_voting', 1);?>
							<ul>
								<li>
									<label class="child"><input type="radio" id="type_voting_1" name="permissions[type_voting]" value="1" <?php if($typeVoting=="1") echo 'checked="checked"';?> /><?php echo JText::_("ONLY_ONCE_FOR_EACH_COMMENT_ITEM");?></label>
								</li>
								<li>
									<label class="child"><input type="radio" id="type_voting_2" name="permissions[type_voting]" value="2" <?php if($typeVoting=="2") echo 'checked="checked"';?> /><?php echo JText::_("ONLY_ONCE_FOR_EACH_COMMENT_ITEM_FOR_EACH_SESSION");?></label>
								</li>
								<li>
									<label class="child"><input type="radio" id="type_voting_3" name="permissions[type_voting]" value="3" <?php if($typeVoting=="3") echo 'checked="checked"';?> />
									<?php echo JText::_("LAG");?>
									<input onkeypress="return isNumberKey(event)" onkeyup="checkValidKey(this.value,'lag_voting')" maxlength="20" type="text" value="<?php echo $this->params->get('lag_voting', '');?>" id="lag_voting" name="permissions[lag_voting]" <?php if($typeVoting!="3") echo 'disabled="disabled"';?> />(<?php echo JText::_("SECONDS_BETWEEN_VOTES");?>)</label>      
								</li>
							</ul>
						</div>
					</li>
					<li>
						<label>    
							<span class="editlinktip hasTip" title="<?php echo JText::_('REPORT_COMMENTS' );?>::<?php echo JText::_('SELECT_WHO_CAN_REPORT_COMMENTS_AS_SPAM' ); ?>">
							<?php echo JText::_("REPORT_COMMENTS");?>
							</span>
							<select name="permissions[report]" id="report" onchange="changeStatusComment(this)">
								<option value="all"<?php if($this->params->get('report')=='all') echo $selected;?>><?php echo JText::_("ALL");?></option>
								<option value="member"<?php if($this->params->get('report')=='member') echo $selected;?>><?php echo JText::_("ONLY_MEMBER");?></option>
							</select>
							<p style="color: red;display: none;" id="error_report"><?php echo JText::_("REPORT_COMMENT_APPLIES_ONLY_TO_MEMBER_BECAUSE_VIEW_COMMENT_IS_ONLY_MEMBER");?></p>
						</label>
						<br style="clear:both;" />
						<div>
							<label for="total_to_report_spam" class="child">
								<?php echo JText::_("TOTAL_NUMBER_OF_REPORTS_TO_CONFIRM_COMMENT_AS_SPAM");?>      
								<?php $totalToReportSpam = $this->params->get('total_to_report_spam', 0);?>
								<input type="text" onkeyup="checkValidKey(this.value,'total_to_report_spam')" value="<?php echo $this->params->get('total_to_report_spam', '10');?>" id="total_to_report_spam" name="permissions[total_to_report_spam]">                                                    
							</label>
						</div>
					</li>
					<li>
						<label>    
							<span class="editlinktip hasTip" title="<?php echo JText::_('EDIT_COMMENTS' );?>::<?php echo JText::_('SELECT_TIME_USER_CAN_EDIT_COMMENTS' ); ?>">
							<?php echo JText::_("EDIT_COMMENTS_ONLY_MEMBER");?>
							</span>							
						</label>
						<br style="clear:both;" />
						<div style="padding-left:30px;">
							<?php $typeEditing = $this->params->get('type_editing', 1);?>
							<ul>
								<li>
									<label class="child"><input type="radio" id="type_editing_1" name="permissions[type_editing]" value="1" <?php if($typeEditing=="1") echo 'checked="checked"';?> /><?php echo JText::_("ALWAYS_EDIT_COMMENT");?></label>
								</li>
								<li>
									<label class="child"><input type="radio" id="type_editing_2" name="permissions[type_editing]" value="2" <?php if($typeEditing=="2") echo 'checked="checked"';?> /><?php echo JText::_("ONLY_ONCE_FOR_EACH_COMMENT_ITEM_IN_AN_UNIQUE_SECTION");?></label>
								</li>
								<li>
									<label class="child"><input type="radio" id="type_editing_3" name="permissions[type_editing]" value="3" <?php if($typeEditing=="3") echo 'checked="checked"';?> />
									<?php echo JText::_("LAG");?>
									<input onkeypress="return isNumberKey(event)" onkeyup="checkValidKey(this.value,'lag_editing')" type="text" maxlength="20" value="<?php echo $this->params->get('lag_editing', '172800');?>" id="lag_editing" name="permissions[lag_editing]" <?php if($typeEditing!="3") echo 'disabled="disabled"';?> />(<?php echo JText::_("SECONDS_AFTER_NEW_POST_NOT_ALLOW_THE_USER_TO_EDIT_COMMENT");?>)</label>      
								</li>
							</ul>
						</div>
					</li>
				</ul>					
			</div>
		</div>
	</div>		
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="configs" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="group" value="<?php echo $this->group; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->cid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>	
</form>
<script> 

function changeViewComment(value){
	if(value == "member"){
		if($("post").selectedIndex == 0)
			$("post").selectedIndex = 1;
		if($("vote").selectedIndex == 0)
			$("vote").selectedIndex = 1;
		if($("report").selectedIndex == 0)
			$("report").selectedIndex = 1;
	}
}

function checkValidKey(value,obj){		
	if(value == 0){
		$(obj).value = "";
	}
}

function changeStatusComment(obj){
	if($("view").value == "member"){		
		if(obj.value == "all"){			
			obj.selectedIndex = 1;
			$("error_" + obj.id).style.display = "block";
		}	
	}
}

function isNumberKey(evt){
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}


jQuery(document).ready(function(){
    jQuery.each( ["1","2"], function(i, n){
        jQuery("#type_voting_" + n).click(function () {
            jQuery("#lag_voting").attr('disabled', 'disabled'); ;
        });
    });
    jQuery("#type_voting_3").click(function () {
        jQuery("#lag_voting").removeAttr('disabled');
        jQuery("#lag_voting").focus();
    });
    
    jQuery.each( ["1","2"], function(i, n){
        jQuery("#type_editing_" + n).click(function () {
            jQuery("#lag_editing").attr('disabled', 'disabled'); ;
        });
    });
    jQuery("#type_editing_3").click(function () {
        jQuery("#lag_editing").removeAttr('disabled');
        jQuery("#lag_editing").focus();
    });
});

</script> 