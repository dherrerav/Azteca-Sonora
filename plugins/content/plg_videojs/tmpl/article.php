<video id="<?= $video->id ?>" class="video-js vjs-default-skin" controls preload="auto" width="<?= $video->width ?>" height="<?= $video->height ?>" poster="<?= JURI::base() . $video->image ?>" data-setup="{}">
	<source src="<?= $video->source ?>" type="video/mp4">
</video>