<div class="articles<?= $moduleclass_sfx ?> videos<?= $moduleclass_sfx ?>">
	<? foreach ($articles as $article) : ?>
	<div class="article">
		<header class="header">
			<h3>
				<a href="<?= $article->link ?>" title="<?= $article->title ?>">
					<?= $article->title ?>
				</a>
			</h3>
		</header>
		<div class="image">
			<a href="<?= $article->link ?>" title="<?= $article->title ?>">
				<img src="<?= $article->image ?>" alt="<?= $article->title ?>" width="100" />
			</a>
		</div>
		<div class="text">
			<p><?= $article->introtext ?></p>
		</div>
	</div>
	<? endforeach ?>
</div>