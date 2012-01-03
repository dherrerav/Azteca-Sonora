<?php
/**
 * @version		$Id: blog_item.php 17855 2010-06-23 17:46:38Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = &$this->item->params;
$canEdit = $this->user->authorise('core.edit', 'com_content.category.' . $this->item->id);
?>

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?>


<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php
$intro = $this->item->introtext;
preg_match_all('/<img[^>]+>/i', $intro, $images);
preg_match_all('/(alt|title|src)=("[^"]*")/i',$images[0][0], $src);
$src = $src[0][0];
$intro = preg_replace('/<img[^>]+\>/i', '', $intro);
if (empty($src)) :
	$src = 'src="templates/ja_t3_blank/local/themes/tvazteca-default/images/logo-azteca-noticias.png"';
endif;
?>
<div class="item-image">
	<img <?= $src ?> class="item-image">
</div>
<div class="item-content">
	<?php if ($params->get('show_title')) : ?>
		<h2 class="contentheading">
			<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
				<?php echo $this->escape($this->item->title); ?></a>
			<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
			<?php endif; ?>
		</h2>
		<?php endif; ?>
		<?php // to do not that elegant would be nice to group the params ?>
		<?php if ($params->get('access-view')) : ?>
		<a class="content-description" href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
			<?= $intro ?>
		</a>
		<?php endif; ?>
</div>