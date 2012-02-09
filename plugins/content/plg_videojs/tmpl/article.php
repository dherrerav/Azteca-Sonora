<a class="video-player" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; background: url(<?= JURI::base() . $video->image ?>) no-repeat top left;" id="<?= $video->id ?>" href="<?= JURI::base() . $video->source ?>">
	<img class="play-button" src="<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/images/play_large.png' ?>" width="83" height="83" />
</a>
<script type="text/javascript">
<? if ($this->isIpad()) : ?>
$f('<?= $video->id ?>', '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.swf' ?>', {
	clip: {
		eventCategory: '<?= $article->title ?>',
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
}).ipad();
<? else : ?>
flowplayer('<?= $video->id ?>', { src: '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.swf' ?>', wmode: 'transparent'}, {
	clip: {
		eventCategory: '<?= $article->title ?>',
		provider: 'pseudo',
		url: flashembed.isSupported([9, 115]) ?
			'<?= JURI::base() . $video->mp4 ?>' :
			'<?= JURI::base() . $video->flv ?>'
	},
	plugins: {
		pseudo: {
			url: '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.pseudostreaming.swf' ?>'
		},
		gatracker: {
			url: '<?= JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/swf/flowplayer.analytics.swf' ?>',
			events: {
				all: true,
			},
			accountId: '<?= $this->params->get('google_analytics_account') ?>'
		}
	}
})<?= (bool)$this->params->get('article_auto_play', 1) ? '.play()' : '' ?>;
<? endif ?>
</script>