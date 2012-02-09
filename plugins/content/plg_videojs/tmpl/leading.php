<a class="video-player" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; background: url(<?= $video->image ?>) no-repeat top left;" id="<?= $video->id ?>" href="<?= $video->source ?>">
	<img class="play-button" src="<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/images/play_large.png' ?>" width="83" height="83" />
</a>
<script type="text/javascript">
$f('<?= $video->id ?>', { src: '<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.swf' ?>', wmode: 'transparent'}, {
	clip: {
		eventCategory: 'Change Campaign'
	},
	plugins: {
		gatracker: {
			url: '<?= 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.analytics.swf' ?>',
			events: {
				all: true,
			},
			debug: true,
			accountId: ''
		}
	}
});
</script>