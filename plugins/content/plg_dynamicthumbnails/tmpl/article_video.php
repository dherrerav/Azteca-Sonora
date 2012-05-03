<?php
var_dump($video);
switch ($this->browser->getPlatform()) :
	case Browser::PLATFORM_IPAD:
	case Browser::PLATFORM_IPHONE:
	case Browser::PLATFORM_IPOD:
	case Browser::PLATFORM_ANDROID:
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
		<div class="video" id="video-<?= $article->id ?>" style="width: 100%; height: 100%; background: transparent url(<?= JURI::base() . $video->preview ?>) no-repeat top left;">
		</div>
	</div>
</div>
<script type="text/javascript">
	try {
		$f('video-<?= $article->id ?>', '<?= $this->getVideoPlayer() ?>', {
			key: '#$4a11216191dd06befb1',
			wmode: 'opaque',
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
				eventCategory: '<?= str_replace(array("\"", "\'"), "&quote;", $article->category_title . " - " . $article->title) ?>',
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