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
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td width="5">
			<?php echo $item->id; ?>
		</td>
		<td width="20" class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center">
			<a href="index.php?option=com_udjacomments&amp;view=cpanel&amp;toggler=is_spam&amp;val=<?php echo $item->is_spam?>&amp;id=<?php echo $item->id?>" title="Toggle Spam">
				<?php echo ($item->is_spam) ? '<img src="'.$this->mediaDir.'images/btnIsSpam.png" alt="Is Spam" />' : '<img src="'.$this->mediaDir.'images/btnIsNotSpam.png" alt="Is Not Spam" />'; ?>
			</a>
		</td>
		<td class="center">
			<a href="index.php?option=com_udjacomments&amp;view=cpanel&amp;toggler=is_published&amp;val=<?php echo $item->is_published?>&amp;id=<?php echo $item->id?>" title="Toggle Published">
				<?php echo ($item->is_published) ? '<img src="'.$this->mediaDir.'images/btnIsPublished.png" alt="Is Published" />' : '<img src="'.$this->mediaDir.'images/btnIsNotPublished.png" alt="Is Not Published" />'; ?>
			</a>
		</td>
		<td>
			<a rel="{handler: 'iframe', size: {x: 875, y: 450}, onClose: function() {}}" href="index.php?option=com_udjacomments&amp;view=display&amp;id=<?php echo $item->id?>&amp;tmpl=component" class="modal" title="View all details">
				<?php echo $item->full_name; ?>
			</a>
		</td>
		<td>
			<a href="mailto:<?php echo $item->email?>" title="Contact <?php echo $item->email?>">
				<?php echo $item->email; ?>
			</a>
		</td>
		<td>
			<a href="<?php echo $item->url?>" title="Goto <?php echo $item->url?>" target="_blank">
				<?php echo $item->url; ?>
			</a>
		</td>
		<td>
			<?php echo substr($item->content,0,100); ?>
			<a rel="{handler: 'iframe', size: {x: 875, y: 450}, onClose: function() {}}" href="index.php?option=com_udjacomments&amp;view=display&amp;id=<?php echo $item->id?>&amp;tmpl=component" class="modal" title="View all details">View everything...</a>
		</td>
		<td>
			<?php echo $item->ip; ?>
		</td>
	</tr>
<?php endforeach; ?>