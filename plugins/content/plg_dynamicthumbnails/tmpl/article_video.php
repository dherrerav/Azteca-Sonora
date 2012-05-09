<?php
$platform = $this->browser->getPlatform();
var_dump($videos);
switch ($platform) :
	case Browser::PLATFORM_IPAD:
		$video = $videos['m4v'];
		$clipUrl = '\'' . JURI::base() . $video->source . '\'';
		$playFullscreen = true;
		/*
		$video->width = '100%';
		$video->height = '100%';
		*/
		break;
	case Browser::PLATFORM_IPHONE:
	case Browser::PLATFORM_IPOD:
	case Browser::PLATFORM_ANDROID:
		$video = $videos['m4v'];
		$playFullscreen = true;
		$video->width = $platform === Browser::PLATFORM_ANDROID ? '100%' : $video->width . 'px';
		$video->height = $platform === Browser::PLATFORM_ANDROID ? '100%' : $video->width . 'px';
		$clipUrl = '\'' . JURI::base() . $video->source . '\'';
		break;
	default:
		$video = $videos['m4v'];
		$clipUrl = 'flashembed.isSupported([9, 115]) ? ' .
					'\'' . JURI::base() . $video->source . '\' : ' .
					'\'' . JURI::base() . $videos['m4v']->source . '\'';
		break;
endswitch;
?>
<? if ($platform === Browser::PLATFORM_ANDROID ||
	   $platform === Browser::PLATFORM_IPOD ||
	   $platform === Browser::PLATFORM_IPHONE) : ?>
<video class="video-js vjs-default-skin" id="<?= $video->id ?>"
	height="<?= $video->height ?>"
	width="<?= $video->width ?>"
	poster="<?= JURI::base() . $video->preview ?>"
	controls
	preload="auto"
	data-setup="{}">
	<source src="<?= JURI::base() . $video->source ?>" type="<?= $video->format ?>" />
</video>
<script type="text/javascript">
var video = document.getElementById('<?= $video->id ?>');
video.addEventListener('click', function() {
	video.play();
}, false);
</script>
<? else : ?>
<div class="article-videos">
	<div class="article-videos-inner">
		<div class="video" id="video-<?= $article->id ?>"<?= !$this->browser->isMobile() ? ' style="width: ' . $video->width . 'px; height: '. $video->height . 'px;"' : '' ?>>
			<img src="<?= $video->preview ?>" width="<?= $video->width ?>" height="<?= $video->height ?>" alt="Reproducir" />
		</div>
	</div>
</div>
<script type="text/javascript">
try {
		$f('video-<?= $article->id ?>', '<?= $this->getVideoPlayer() ?>', {
			key: '#$4a11216191dd06befb1',
			autoplay: true,
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
<? endif ?>