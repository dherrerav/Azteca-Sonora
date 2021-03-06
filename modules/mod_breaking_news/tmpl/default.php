<?php
defined('_JEXEC') or die;
$i = 0;
$column = 0;
$width = round(100 / (int)$params->get('columns')) - 2;
$images_per_column = explode(',', $params->get('show_images'));
$featured_per_column= explode(',', $params->get('featured_per_column'));
$show_category_title_in = $params->get('show_category_title_in');
?>
<div class="breaking-news">
	<ul class="breaking-news-articles<?= $moduleclass_sfx ?> column-<?= $column ?>" style="width: <?= $width ?>%;">
	<? foreach ($articles as $article) : ?>
		<? $article_title = str_replace(array('"', '\''), '&quote;', $article->title) ?>
		<? if ($i === (int)$articles_per_column[$column]) : ?>
		</ul>
		<ul class="breaking-news-articles<?= $moduleclass_sfx ?>" style="width: <?= $width ?>%;">
		<? $column++ ?>
		<? $i = 0 ?>
		<? endif ?>
		<li class="article first">
			<? if ($article->image !== null && $i < $images_per_column[$column]) : ?>
			<div class="image">
				<a href="<?= $article->link ?>" title="<?= $article_title ?>">
					<img src="<?= $article->image->src ?>" alt="<?= $article->image->alt ?>" title="<?= $article->image->title ?>" width="<?= $params->get('image_width') ?>" height="<?= $params->get('image_height') ?>" />
				</a>
			</div>
			<? endif ?>
			<div class="heading">
				<h<?= $item_heading ?>>
				<? if ($i == 0) : ?>
				<span class="bullet">>></span>
				<? endif ?>
				<? if (in_array($article->catid, $show_category_title_in)) : ?>
				<?= $article->category_title ?>
				<? elseif (in_array($article->parent_id, $show_category_title_in)) : ?>
				<?= $article->parent_title ?>
				<? endif ?>
				<? if ($params->get('link_titles')) : ?>
					<a href="<?= $article->link ?>" title="<?= $article_title ?>"><?= $article->title ?></a>
				<? else : ?>
					<?= $article->title ?>
				<? endif ?>
				</h<?= $item_heading ?>>
			</div>
			<? if ($params->get('show_intro') !== 0) : ?>
			<div class="text">
				<p>
					<?= $article->introtext ?>
					<? if ($article->date) : ?>
					<span class="date"><?= $article->date ?></span>
					<? endif ?>
				</p>
			</div>
			<? if (isset($article->related)) : ?>
			<div class="related<?= $moduleclass_sfx ?>">
				<ul class="related-articles<?= $moduleclass_sfx ?>">
					<? foreach ($article->related as $related) : ?>
					<li class="article">
						<div class="title">
							<h2>
								<a href="<?= $related->link ?>" title="<?= str_replace(array('"', '\''), '&quote;', $related->title) ?>"><?= $related->title ?></a>
							</h2>
						</div>
					</li>
					<? endforeach ?>
				</ul>
			</div>
			<? endif ?>
			<? endif ?>
		</li>
		<? $i++ ?>
	<? endforeach ?>
	</ul>
</div>
<script type="text/javascript">
$(function() {
	$('.breaking-news-articles<?= $moduleclass_sfx ?> li').last().css({
		'margin-bottom': 0
	});
});
</script>