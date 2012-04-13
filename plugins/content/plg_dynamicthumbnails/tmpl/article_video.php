<?php
switch ($this->browser->getPlatform()) :
	case Browser::PLATFORM_IPAD:
	case Browser::PLATFORM_IPHONE:
	case Browser::PLATFORM_IPOD:
		$video = $videos['m4v'];
		$clipUrl = '\'' . JURI::base() . $video->source . '\'';
		break;
	default:
		$video = $videos['flv'];
		$clipUrl = 'flashembed.isSupported([9, 115]) ? ' .
					'\'' . JURI::base() . $video->source . '\' : ' .
					'\'' . JURI::base() . $videos['m4v']->source . '\'';
		break;
endswitch;
?>
<div class="article-videos">
	<div class="article-videos-inner">
		<div class="video" id="video-<?= $article->id ?>" style="width: <?= $video->width ?>px; height: <?= $video->height ?>px; background: transparent url(<?= JURI::base() . $video->preview ?>) no-repeat top left;">
			<img class="button-play" src="<?= JURI::base() ?>plugins/content/plg_dynamicthumbnails/images/play_large.png" width="83" height="83" />
		</div>
	</div>
</div>
<script type="text/javascript">
	try {
		$f('video-<?= $article->id ?>', '<?= $this->getVideoPlayer() ?>', {
			key: '#$4a11216191dd06befb1',
			autoplay: true,
			wmode: 'transparent',
			<?= $this->browser->getPlatform() === Browser::PLATFORM_IPAD ? 'simulateiDevice: true,' : '' ?>
			plugins: {
				pseudo: {
					url: '<?= $this->getFlowplayerPlugin('pseudostreaming') ?>'
				},
				gatracker: {
					url: '<?= $this->getFlowPlayerPlugin('analytics') ?>',
					events: {
						all: true
					},
					accountId: '<?= $this->_pluginParams->get('google_analytics_account') ?>'
				}
			},
			clip: {
				eventCategory: '<?= str_replace(array('"', '\''), '&quote;', $article->category_title . ' - ' . $article->title) ?>',
				provider: 'pseudo',
				url: <?= $clipUrl ?>
			},
			onFinish: function() {
				this.unload();
			}
		})<?= $this->browser->getPlatform() === Browser::PLATFORM_IPAD ? '.ipad()' : '' ?>;
	} catch (e) {
		console.debug(e);
	}
</script>
