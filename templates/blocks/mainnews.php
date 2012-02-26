<? $style = $this->getBlockStyle($block) ?>
<?php $this->genBlockBegin ($block) ?>
<?if ($this->countModules('news-left') || $this->countModules('news-center') || $this->countModules('news-right')) : ?>
	<?if ($this->countModules('news-left')) : ?>
	<div class="main-news" id="news-left">
		<jdoc:include type="modules" name="news-left" style="<?= $style ?>" />
	</div>
	<?endif;?>
	<?if ($this->countModules('news-center')) : ?>
	<div class="main-news" id="news-center">
		<jdoc:include type="modules" name="news-center" style="<?= $style ?>" />
	</div>
	<?endif; ?>
	<?if ($this->countModules('news-right')) : ?>
	<div class="main-news" id="news-right">
		<jdoc:include type="modules" name="news-right" style="<?= $style ?>" />
	</div>
	<?endif; ?>
<?php endif; ?>