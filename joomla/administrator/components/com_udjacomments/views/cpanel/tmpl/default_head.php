<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package com_udjacomments
**/ 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IS_SPAM'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IS_PUBLISHED'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_NAME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_EMAIL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_WEBSITE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_COMMENT'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IP'); ?>
	</th>
</tr>