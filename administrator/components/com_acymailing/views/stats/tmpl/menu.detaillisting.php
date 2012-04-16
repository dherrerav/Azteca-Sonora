<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<fieldset>
	<div class="header icon-48-stats" style="float: left;"><?php echo $this->mailing->subject; ?></div>
	<div class="toolbar" id="toolbar" style="float: right;">
		<table><tr>
		<td><a href="<?php $app=JFactory::getApplication(); $link = $app->isAdmin() ? 'diagram&task=mailing' : 'newsletter&task=stats&listid='.JRequest::getInt('listid'); echo acymailing_completeLink($link.'&mailid='.JRequest::getInt('filter_mail'),true); ?>" ><span class="icon-32-cancel" title="<?php echo JText::_('ACY_CANCEL',true); ?>"></span><?php echo JText::_('ACY_CANCEL'); ?></a></td>
		</tr></table>
	</div>
</fieldset>