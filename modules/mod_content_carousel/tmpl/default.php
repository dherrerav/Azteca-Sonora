<div class="content-carousel">
	<ul class="articles">
		<? foreach ($articles as $article) : ?>
		<li class="article" style="width: <?= $width ?>px;">
			<h3 class="article-title">
				<a href="<?= $article->link ?>" title="<?= str_replace('"', '&quote;', $article->title) ?>"><?= $article->title ?></a>
			</h3>
			<div class="article-image">
				<img src="<?= $article->image ?>" alt="<?= $article->title ?>" title="<?= $article->title ?>" />
			</div>
		</li>
		<? endforeach ?>
	</ul>
	<script type="text/javascript">
	window.addEvent('load', function() {
		equalHeight('ul.articles li.article h3.article-title');
	});
	</script>
</div>