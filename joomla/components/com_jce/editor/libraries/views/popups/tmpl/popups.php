<?php
/**
 * @version		$Id: popups.php 58 2011-02-18 12:40:41Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

$popups = WFPopupsExtension::getInstance();
?>
<h4><input type="checkbox" id="popup_check" class="checkbox" onclick="WFExtensions.Popups.enablePopups(this);" /><label for="popup_check" class="hastip" title="<?php echo WFText::_('WF_POPUP_ENABLE_DESC');?>"><?php echo WFText::_('WF_POPUP_ENABLE');?></label><?php echo $popups->getPopupList();?></h4>
<table style="display:<?php echo ($popups->get('text') === false) ? 'none' : ''?>;">
	<tr>
		<td><label for="popup_text" class="hastip"
			title="<?php echo WFText::_('WF_POPUP_TEXT_DESC');?>"><?php echo WFText::_('WF_POPUP_TEXT');?></label></td>
		<td><input id="popup_text" type="text" value="" /></td>
	</tr>
</table>
<?php echo $popups->getPopupTemplates();?>