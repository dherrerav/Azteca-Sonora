<?php
$style = $this->getBlockStyle($block);
// Tweets ticker
if ($this->countModules('tweets-ticker')) :
?>
<div class="tweets-ticker">
	<div id="tweet_icon">
		<a href="http://twitter.com/AztecaNoticias" target="_blank" title="@AztecaNoticias"></a>
	</div>
	<div id="tweet_container">
	</div>
	<jdoc:include type="modules" name="tweets-ticker" style="<?= $style ?>" />
</div>
<?php endif; ?>
<?php
// Special news carousel
if ($this->countModules('news-special')) :
?>
<div class="news-special">
	<jdoc:include type="modules" name="news-special" style="<?= $style ?>" />
</div>
<?php endif; ?>
<?php if ($this->countModules('featured-articles') || $this->countModules('the-most-read') || $this->countModules('the-most-commented')) : ?>
<div class="the-most">
	<?php if ($this->countModules('featured-articles')) : ?>
	<div class="featured-articles">
		<jdoc:include type="modules" name="featured-articles" style="<?= $style ?>" />
	</div>
	<?php endif; ?>
	<?php if ($this->countModules('the-most-read')) : ?>
	<div class="the-most-read">
		<jdoc:include type="modules" name="the-most-read" style="<?= $style ?>" />
	</div>
	<?php endif; ?>
	<?php if ($this->countModules('the-most-commented')) : ?>
	<div class="the-most-commented">
		<jdoc:include type="modules" name="the-most-commented" style="<?= $style ?>" />
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->countModules('right-ad')) : ?>
<div class="right-ad">
	<jdoc:include type="modules" name="right-ad" style="<?= $style ?>" />
</div>
<?php endif; ?>