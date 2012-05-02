<? defined('_JEXEC') or die ?>
<? if ($article->video) : ?>
<? var_dump($article->video) ?>
<video id="video-<?= $article->id ?>" class="video-js vjs-default-skin"
	width="100%"
	height="100%"
	preload>
	<source src="<?= $article->video->source ?>" type="<?= $article->video->format ?>">
</video>
<script type="text/javascript" charset="utf-8">
	try {
		var video = _V_('video-<?= $article->id ?>', {
			controls: true,
			poster: '<?= $article->video->poster ?>'
		});
	} catch (e) {
		alert(e.message);
	}
</script>
<? endif ?>