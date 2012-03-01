<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="content-most-article<?= $params->get('moduleclass_sfx') ?>">
<? if ($article->image !== null) { ?>
	<img src="<?= $article->image->src ?>" title="<?= $article->image->title ?>" alt="<?= $article->image->alt ?>" <?= $article->image->width ?> <?= $article->image->height ?> />
<? } ?>
<? if ($params->get('item_title')) { ?>
	<<?= $params->get('item_heading') ?> class="content-most-title<?= $params->get('moduleclass_sfx') ?>">
	<? if ($params->get('link_titles') && $article->link != '') { ?>
	<a href="<?= $article->link ?>">
		<?= $article->title ?>
	</a>
	<? } else {?>
	<?= $article->title ?>
	<? } ?>
	</<?= $params->get('item_heading') ?>>
<? } ?>
</div>
<script type="text/javascript">
	window.addEventListener('load', function() {
		equalHeight('.content-most-articles-list li');
	});
</script>