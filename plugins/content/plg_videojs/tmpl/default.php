<a class="video-player" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; display: block; background: url(<?= $video->images['preview'] ?>) no-repeat top left;" id="<?= $video->id ?>" href="<?= $video->source ?>">
	<img class="play-button" src="<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/images/play_large.png' ?>" width="<?= $video->width ?>" height="<?= $video->height ?>" />
</a>
<script type="text/javascript">
$f('<?= $video->id ?>', '<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.swf' ?>');
</script>