<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package mod_udjacomments
**/ 

// no direct access
defined('_JEXEC') or die;

?>

<form name="frmCommentPost" id="frmCommentPost" action="<?php echo $currentUrl; ?>#frmCommentPost" method="post">
	
	<h3 class="commentsTitle"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_TITLE') ?></h3>
	
	<fieldset class="commentFields">
		
		<p class="textboxWrapper">
			<label for="txtUdjaName"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLNAME') ?><span class="required">*</span></label>
			<input type="text" class="textbox mandatory" name="txtUdjaName" id="txtUdjaName" value="<?php echo JRequest::getString('txtUdjaName') ?>" <?php if ($helper->getUser()) { echo 'readonly="readonly"'; } ?> />
		</p>
		<div class="clear"></div>
		<p class="textboxWrapper">
			<label for="txtUdjaEmail"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLEMAIL') ?><?php if ($helper->getRequired('email')) { echo '<span class="required">*</span>'; } ?></label>
			<input type="text" class="textbox<?php if ($helper->getRequired('email')) { echo ' mandatory'; } ?>" name="txtUdjaEmail" id="txtUdjaEmail" value="<?php echo JRequest::getString('txtUdjaEmail') ?>" <?php if ($helper->getUser()) { echo 'readonly="readonly"'; } ?> />
		</p>
		<div class="clear"></div>
		<p class="textboxWrapper">
			<label for="txtUdjaWebsite"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLWEBSITE') ?><?php if ($helper->getRequired('url')) { echo '<span class="required">*</span>'; } ?></label>
			<input type="text" class="textbox<?php if ($helper->getRequired('url')) { echo ' mandatory'; } ?>" name="txtUdjaWebsite" id="txtUdjaWebsite" value="<?php echo JRequest::getString('txtUdjaWebsite') ?>" />
		</p>
		<div class="clear"></div>
		<p class="textareaWrapper">
			<label for="txtUdjaComment"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLCOMMENT') ?><span class="required">*</span></label>
			<textarea type="text" class="textarea mandatory" name="txtUdjaComment" id="txtUdjaComment"><?php echo JRequest::getString('txtUdjaComment') ?></textarea>
		</p>
		<?php if ($recaptcha = $helper->getRecaptcha()) : ?>
			<p class="reCaptchaWrapper">
				<div class="recaptchaWrapper">
					<script type="text/javascript"
						src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $recaptcha->publicKey; ?>">
					</script>
					<noscript>
						<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $recaptcha->publicKey; ?>"
							height="300" width="500" frameborder="0"></iframe><br>
						<textarea name="recaptcha_challenge_field" rows="3" cols="40">
						</textarea>
						<input type="hidden" name="recaptcha_response_field"
							value="manual_challenge">
					</noscript>
				</div>
			</p>
		<?php endif; ?>
		<div class="clear"></div>
		<?php if ($helper->getFieldEnabled('notifications')) : ?>
			<p class="checkboxWrapper">
				<input type="checkbox" class="checkbox" name="txtUdjaNotifications" id="txtUdjaNotifications" value="1" <?php if (JRequest::getInt('txtUdjaNotifications')) { echo 'checked="checked"'; } ?> />
				<label for="txtUdjaNotifications"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLNOTIFICATIONS') ?></label>
			</p>
		<?php endif; ?>
		<div class="clear"></div>
		<?php if ($helper->getFieldEnabled('signup')) : ?>
			<p class="checkboxWrapper">
				<input type="checkbox" class="checkbox" name="txtUdjaSignup" id="txtUdjaSignup" value="1" <?php if (JRequest::getInt('txtUdjaNotifications')) { echo 'checked="checked"'; } ?> />
				<label for="txtUdjaSignup"><?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLSIGNUP') ?></label>
			</p>
		<?php endif; ?>
		<div class="clear"></div>
		<p class="submitButtonWrapper">
			<?php $isReply = JRequest::getInt('hdnIsReply'); ?>
			<input type="hidden" id="hdnIsReply" name="hdnIsReply" value="<?php echo ($isReply) ? $isReply : 0?>" />
			<input type="hidden" name="hdnCommentForm" value="1" />
			<input type="submit" class="submitButton" name="btnUdjaSubmit" id="btnUdjaSubmit" value="<?php echo JText::_('MOD_UDJACOMMENTS_FORM_LBLSUBMIT') ?>" />
		</p>
		
	</fieldset>

</form>