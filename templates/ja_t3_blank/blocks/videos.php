<?php
$style = $this->getBlockStyle($block);
?>
<?
// Tweets ticker
if ($this->countModules('tweets-ticker')) :
?>
<div class="tweets-ticker">
	<div id="tweet_icon">
		<a href="http://twitter.com/AztecaSonora" target="_blank" title="@AztecaSonora"></a>
	</div>
	<div id="tweet_container">
	</div>
	<jdoc:include type="modules" name="tweets-ticker" style="<?= $style ?>" />
</div>
<?php endif; ?>
<?
if ($this->countModules('video')) :
?>
<div class="video">
	<jdoc:include type="modules" name="video" style="<?= $style ?>" />
</div>
<?php endif; ?>