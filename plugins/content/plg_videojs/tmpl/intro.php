<div class="video-preview" style="background: url(<?= $video->image ?>) no-repeat top left; width: <?= $video->width ?>px; height: <?= $video->height ?>px;">
	<a href="<?= $article->link ?>" title="<?= $article->title ?>">
		<img class="play-button" src="<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/images/play_small.png' ?>" alt="<?= $article->title ?>" title="<?= $article->title ?>" />
	</a>
</div>