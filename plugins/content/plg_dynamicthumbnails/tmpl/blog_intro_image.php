<div class="article-images">
	<div class="article-images-inner">
		<? foreach ($images as $image) : ?>
		<div class="article-image">
			<div class="image">
				<img src="<?= $image->src ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $image->alt ?>" title="<?= str_replace(array('"', '\''), '&quote;', $image->title) ?>" />
			</div>
			<div class="text">
				<p><?= $image->alt ?></p>
			</div>
		</div>
		<? endforeach ?>
	</div>
</div>