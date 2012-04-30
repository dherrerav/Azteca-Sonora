<? defined('_JEXEC') or die('Restricted access') ?>
<div id="carousel-<?= $module->id ?>" class="carousel slide">
	<div class="carousel-inner">
		<? $i = 0 ?>
		<? foreach ($slides as $slide) : ?>
		<div class="item<?= $i == 0 ? ' active' : null ?>">
			<a<?= $slide->target ?> href="<?= $slide->link ?>" title="<?= $slide->title ?>">
				<img src="<?= $slide->mainImage ?>" alt="<?= $slide->altTitle ?>" />
			</a>
			<? if ($slide->content) : ?>
			<div class="carousel-caption">
				<? if ($slide->params->get('title')) : ?>
				<h4><a<?= $slide->target ?> href="<?= $slide->link ?>" title="<?= $slide->title ?>"><? $slide->title ?></a></h4>
				<? endif ?>
				<? if ($slide->params->get('text') && $slide->text) : ?>
				<?= $slide->text ?>
				<? endif ?>
			</div>
			<? endif ?>
		</div>
		<? $i++ ?>
		<? endforeach ?>
	</div>
	<a class="carousel-control left" href="#carousel-<?= $module->id ?>" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#carousel-<?= $module->id ?>" data-slide="next">&rsaquo;</a>
</div>