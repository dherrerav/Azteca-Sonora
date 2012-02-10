<?php
/**
 * @version		$Id: blog_links.php 16633 2010-05-01 11:27:31Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="items-more">
	<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?><img src="templates/ja_t3_blank/local/themes/tvazteca-default/images/titlebullet.jpg" /></h3>
	<ol class="jlinks">
	<?php
		foreach ($this->link_items as &$item) :
	?>
		<li>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>">
				&raquo;&nbsp;<?php echo $item->title; ?></a>
		</li>
	<?php endforeach; ?>
	<ol>
</div>