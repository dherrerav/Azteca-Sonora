<div class="article-images">
	<div class="article-images-inner">
		<? foreach ($videos as $video) : ?>
		<img src="<?= JURI::base() . $video->preview ?>" />
		<? endforeach ?>
	</div>
</div>