<? if ($hasVideo) : ?>
<a id="view-video" href="#" title="Ver video">Ver video</a>
<script type="text/javascript">
	$(function() {
		$('#view-video').click(function(e) {
			e.preventDefault();
			$.scrollTo('#video-<?= $article->id ?>', 1000, {margin: true});
			flowplayer('video-<?= $article->id ?>').play();
		});
	})
</script>
<? endif ?>
<div class="article-images">
	<div class="article-images-inner">
		<? foreach ($images as $image) : ?>
		<div class="article-image">
			<div class="image">
				<img src="<?= $image->src ?>" alt="<?= $image->alt ?>" title="<?= $image->title ?>" />
			</div>
			<div class="text">
				<p><?= $image->alt ?></p>
			</div>
		</div>
		<? endforeach ?>
	</div>
</div>