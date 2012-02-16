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
?> 
<fieldset class="adminform TopFieldset">
	<?php echo $this->menu();?>
</fieldset>
<br/>	
  <fieldset>
  <legend><?php echo JText::_('YOUR_LICENSE_INFORMATION');?></legend>
  <table align="center" class="admintable" width="50%">
  <tr>
    <td class="key hasTip" align="left" title="<?php echo JText::_("LICENSE_FOR_DOMAINS" );?>::<?php echo JText::_("LICENSE_FOR_DOMAINS_DESC" );?>">
	<?php echo JText::_("LICENSE_FOR_DOMAINS" );?>:</td>
    <td align="left"><?php echo $_SERVER ['HTTP_HOST']; ?></td>
  </tr>
  <tr>
        <td class="key hasTip" align="left" title="<?php echo JText::_("EMAIL_OR_USERNAME" );?>::<?php echo JText::_("EMAIL_OR_USERNAME_DESC" );?>">
		<?php echo JText::_("EMAIL_OR_USERNAME" );?>:</td>
        <td align="left"><?php echo $row['email']; ?></td>
    </tr>
    <tr>
        <td class="key hasTip" align="left" title="<?php echo JText::_("PAYMENT_ID" );?>::<?php echo JText::_("PAYMENT_ID_DESC" );?>">
		<?php echo JText::_("PAYMENT_ID" );?>:</td>
        <td align="left"><?php echo $row['payment_id']; ?></td>
    </tr>
    <tr>
        <td align="left" colspan="2">
        <input type="button" value="<?php echo JText::_('CHANGE')?>" onclick="window.location.href='index.php?option=com_jacomment&amp;view=comment&amp;task=verify'; return false;" title="">
        </td>
    </tr>
    </table>
  </fieldset>