<? $style = $this->getBlockStyle($block) ?>
<?php $this->genBlockBegin ($block) ?>
<?if ($this->countModules('breaking-news') || $this->countModules('news-right')) : ?>
	<? if ($this->countModules('breaking-news')) : ?>
	<div class="breaking-news" id="breaking-news">
		<jdoc:include type="modules" name="breaking-news" style="<?= $style ?>" />
	</div>
	<? endif ?>
	<?if ($this->countModules('news-right')) : ?>
	<div class="main-news" id="news-right">
		<jdoc:include type="modules" name="news-right" style="xhtml" />
	</div>
	<?endif; ?>
	<script type="text/javascript">
	window.addEvent('load', function() {
		equalHeight('#ja-mainnews .main-news, #ja-mainnews .breaking-news');
	});
	</script>
<?php endif; ?>