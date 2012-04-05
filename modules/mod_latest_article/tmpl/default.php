<div id="<?= $module->module . '-' . $module->id ?>" class="latest-article<?= $moduleclass_sfx ?>">
	<? if ($params->get('header')) : ?>
	<div class="image-header">
		<img src="<?= JURI::base(true) . '/modules/mod_latest_article/images/' . $params->get('header') ?>" width="636" />
	</div>
	<? endif ?>
<? foreach ($articles as $article) : ?>
	<div class="article" style="padding-right: 10px; display: inline-block;">
		<h2 class="header">
			<a style="color: #222;" href="<?= $article->link ?>" title="<?= $article->title ?>">
				<?= $article->title ?>
			</a>
		</h2>
		<? if ($params->get('show_image') && isset($article->image)) : ?>
		<div class="image-container">
			<div class="image">
				<img src="<?= $article->image->src ?>" title="<?= $article->title ?>" />
			</div>
			<div class="caption">
				<p><?= $article->image->title ?></p>
			</div>
		</div>
		<? endif ?>
		<div class="content">
			<?= $article->text ?>
			<? if ($params->get('show_readmore')) : ?>
			<div class="readmore" style="float: right; padding-bottom: 10px;">
				<a href="<?= $article->link ?>" title="Leer m&aacute;s">
					<img src="<?= JURI::base(true) ?>/modules/mod_latest_article/images/readmore.png" />
				</a>
			</div>
			<? endif ?>
		</div>
	</div>
<? endforeach ?>
</div>