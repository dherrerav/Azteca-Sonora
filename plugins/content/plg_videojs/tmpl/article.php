<? defined('_JEXEC') or die ?>
<? if ($article->video) : ?>
<? var_dump($article->video) ?>
<div class="article-videos">
	<div id="video-<?= $article->id ?>" class="video" style="background-image: url(<?= $article->video->poster ?>); background-repeat: no-repeat; width: 100%; height: 100%;">
		<img src="<?= $article->video->poster ?>" alt="Reproducir video" width="100%" height="100%" />
	</div>
</div>
<script type="text/javascript">
	try {
		flowplayer('video-<?= $article->id ?>', '/plugins/content/plg_videojs/swf/flowplayer.swf', {
			key: '#$4a11216191dd06befb1',
			autoplay: true,
			wmode: 'opaque',
			plugins: {
				pseudo: {
					url: '/plugins/content/plg_videojs/swf/flowplayer.pseudostreaming.swf'
				}
			},
			clip: {
				provider: 'pseudo',
				url: '<?= $article->video->source ?>'
			},
			onFinish: function() {
				this.unload();
			}
		});
	} catch (e) {
		console.debug(e);
	}
</script>
<? endif ?>