<div class="article-images">
	<div class="article-images-inner">
		<? for ($i = 0; $i < count($videos); $i++) : ?>
		<img src="<?= JURI::base() . $video->preview ?>" />
		<? if ($i == 1) break; ?>
		<? endfor ?>
	</div>
</div>