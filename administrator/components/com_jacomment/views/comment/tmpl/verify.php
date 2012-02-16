<?php
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

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );


$row = $this->row;
if(!$row) {
	$email = '';
	$payment_id = '';
} else {
	$email = $row['email'];
	$payment_id = $row['payment_id'];
}
?>
<script type="text/javascript">
	function submit_license_key(){		
		if($('email').value.trim()=='') {
			alert('<?php echo JText::_('PLEASE_ENTER_YOUR_EMAIL');?>');
			return false;
		}		
		if($('payment_id').value.trim()=='') {
			alert('<?php echo JText::_('PLEASE_ENTER_YOUR_PAYMENT_ID');?>');
			return false;
		}
		return true;
	}
</script>
<fieldset class="adminform TopFieldset">
	<?php echo $this->menu();?>
</fieldset>
<br/>
<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="option" value="com_jacomment" />
  <input type="hidden" name="view" value="comment" />
  <input type="hidden" name="task" value="verify" />
  <fieldset>
  <legend><?php echo JText::_('VERIFY_YOUR_LICENSE');?></legend>
  <table align="center" width="50%">
    <tr>
      <td align="left" title="<?php echo JText::_("LICENSE_FOR_DOMAINS" );?>::<?php echo JText::_("LICENSE_FOR_DOMAINS_DESC" );?>"><?php echo JText::_("LICENSE_FOR_DOMAINS" );?>:</td>
      <td align="left"><?php echo $_SERVER ['HTTP_HOST']; ?></td>
    </tr>
    <tr>
      <td align="left" title="<?php echo JText::_("EMAIL" );?>::<?php echo JText::_("EMAIL_DESC" );?>"><?php echo JText::_("EMAIL" );?>:</td>
      <td align="left"><input type="text" name="email" id="email" value="<?php echo $email; ?>" size="50" /></td>
    </tr>
    <tr>
      <td align="left" title="<?php echo JText::_("PAYMENT_ID" );?>::<?php echo JText::_("PAYMENT_ID_DESC" );?>"><?php echo JText::_("PAYMENT_ID" );?>:</td>
      <td align="left"><input type="text" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>" size="50" /></td>
    </tr>
    <tr>
      <td align="left" colspan="2"><input type="submit"  value="<?php echo JText::_('SUBMIT')?>" onClick="return submit_license_key();"/></td>
    </tr>
  </table>
  </fieldset>
</form>
