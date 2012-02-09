<a class="video-player" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; background: url(<?= JURI::base() . $video->image ?>) no-repeat top left;" id="<?= $video->id ?>" href="<?= JURI::base() . $video->source ?>">
	<img class="play-button" src="<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/images/play_large.png' ?>" width="83" height="83" />
</a>
<script type="text/javascript">
flowplayer('<?= $video->id ?>', { src: '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.swf' ?>', wmode: 'transparent'}, {
	clip: {
		eventCategory: 'Change Campaign',
		autoPlay: true,
		autoBuffering: true
	},
	plugins: {
		gatracker: {
			url: '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.analytics.swf' ?>',
			events: {
				all: true,
			},
			accountId: '<?= $this->params->get('google_analytics_account') ?>'
		}
	}
})<?= $this->isIpad() ? '.ipad()' : '' ?><?= (bool)$this->params->get('blog_leading_auto_play', 1) ? '.play()' : '' ?>;
</script>