<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package com_udjacomments
**/ 
defined('_JEXEC') or die('Restricted access');
$item = $this->item;
?>

<h1><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_DETAIL_TITLE'); ?></h1>

<table class="adminlist">
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_ID')?></strong></td>
		<td><?php echo $item->id ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_NAME')?></strong></td>
		<td><?php echo $item->full_name ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_EMAIL')?></strong></td>
		<td><?php echo $item->email ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_WEBSITE')?></strong></td>
		<td><?php echo $item->url ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IP')?></strong></td>
		<td><?php echo $item->ip ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_COMMENT')?></strong></td>
		<td><?php echo $item->content ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_URL')?></strong></td>
		<?php $commentUrl = str_ireplace('/administrator','',JURI::base()) . $item->comment_url; ?>
		<td><a href="<?php echo $commentUrl?>" target="_blank" title="View comment on page"><?php echo $commentUrl?></a></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_PARENT_ID')?></strong></td>
		<td><?php echo $item->parent_id ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IS_PUBLISHED')?></strong></td>
		<td><?php echo $item->is_published ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_IS_SPAM')?></strong></td>
		<td><?php echo $item->is_spam ?></td>
	</tr>
	<tr>
		<td><strong><?php echo JText::_('COM_UDJACOMMENTS_CPANEL_HEADING_TIME_ADDED')?></strong></td>
		<td><?php echo $item->time_added ?></td>
	</tr>
</table>