<?php
defined('_JEXEC') or die('Restricted access');
$style = $this->getBlockStyle($block);
?>
<footer id="footer" class="footer">
	<div class="main">
		<div class="main-inner">
			<div style="float: left; width: 630px;">
				<? if ($this->countModules('footer-left')) : ?>
				<div class="footer left">
					<jdoc:include type="modules" name="footer-left" style="<?= $style ?>" />
				</div>
				<? endif ?>
				<? if ($this->countModules('footer-center')) : ?>
				<div class="footer center">
					<jdoc:include type="modules" name="footer-center" style="<?= $style ?>" />
				</div>
				<? endif ?>
				<? if ($this->countModules('footer-bottom')) : ?>
				<div class="footer bottom">
					<jdoc:include type="modules" name="footer-bottom" style="<?= $style ?>" />
				</div>
				<? endif ?>
			</div>
			<? if ($this->countModules('footer-right')) : ?>
			<div class="footer right">
				<jdoc:include type="modules" name="footer-right" style="<?= $style ?>" />
			</div>
			<? endif ?>
		</div>
	</div>
</footer>