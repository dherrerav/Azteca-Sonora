<? defined('_JEXEC') or die ?>
<div class="articles<?= $moduleclass_sfx ?>">
<? foreach ($articles as $article) : ?>
	<article class="article">
		<header class="header">
			<h3>
				<a href="<?= $article->link ?>" title="<?= $article->title ?>">
					<?= $article->title ?>
				</a>
			</h3>
		</header>
		<div class="content">
			<?= $article->introtext ?>
		</div>
	</article>
<? endforeach ?>
</div>