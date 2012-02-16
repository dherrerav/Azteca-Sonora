<div class="latest-news-videos">
	<? $i = 0 ?>
	<? foreach ($articles as $article) : ?>
	<? if ($i == 0) : ?>
	<div class="news-video main video-<?= $i ?>">
		<div class="star">
		</div>
		<div class="play">
		</div>
		<div class="image">
			<img src="<?= $article->image ?>" width="<?= $article->width ?>" height="<?= $article->height ?>" title="<?= replaceQuotes($article->title) ?>" />
		</div>
		<div class="text">
			<a href="<= $article->link ?>" title="<? replaceQuotes($article->title) ?>"><?= $article->title ?></a>
		</div>
	</div>
	<? else : ?>
	<div class="news-video video-<?= $i ?>">
		<div class="play">
		</div>
		<div class="image">
			<img src="<?= $article->image ?>" width="<?= $article->width ?>" height="<?= $article->height ?>" title="<?= replaceQuotes($article->title) ?>" />
		</div>
		<div class="text">
			<a href="<= $article->link ?>" title="<? replaceQuotes($article->title) ?>"><?= $article->title ?></a>
		</div>
	</div>
	<? endif ?>
	<? $i++ ?>
	<? endforeach ?>
</div>
<?
function replaceQuotes($text) {
	return str_replace(array('"', '\''), '', $text);
}
?>