<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
?>
<?php if (count($this->children[$this->category->id]) > 0) : ?>

<ul class="unstyled">
	<?php foreach($this->children[$this->category->id] as $id => $child) : ?>
	<?php
		if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || count($child->getChildren())) :
			if (!isset($this->children[$this->category->id][$id + 1])) :
				$class = ' class="last"';
			endif;
		?>
	<li<?php echo $class; ?>>
		<?php $class = ''; ?>
		<h3 class="item-title"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id));?>"> <?php echo $this->escape($child->title); ?></a> </h3>
		<?php if ($this->params->get('show_subcat_desc') == 1) :?>
		<?php if ($child->description) : ?>
		<div class="category-desc row-fluid"> <?php echo JHtml::_('content.prepare', $child->description, '', 'com_content.category'); ?> </div>
		<?php endif; ?>
		<?php endif; ?>
		<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
		<p> <span class="label label-info"> <?php echo JText::_('COM_CONTENT_NUM_ITEMS') ; ?> <?php echo $child->getNumItems(true); ?> </span> </p>
		<?php endif ; ?>
		<hr />
		<?php if (count($child->getChildren()) > 0 ) :
				$this->children[$child->id] = $child->getChildren();
				$this->category = $child;
				$this->maxLevel--;
				if ($this->maxLevel != 0) :
					echo $this->loadTemplate('children');
				endif;
				$this->category = $child->getParent();
				$this->maxLevel++;
			endif; ?>
	</li>
	<?php endif; ?>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
