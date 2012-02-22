<div class="article-videos">
	<div class="article-videos-inner">
		<div class="video" id="video-<?= $article->id ?>" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; background: transparent url(<?= JURI::base() . $video->preview ?>) no-repeat top left;">
			<a href="<?= $article->link ?>" title="<?= str_replace(array('"', '\''), '&quote;', $article->title) ?>">
				<img class="button-play" src="<?= JURI::base() ?>plugins/content/plg_dynamicthumbnails/images/play_large.png" width="83" height="83" />
			</a>
		</div>
	</div>
</div>