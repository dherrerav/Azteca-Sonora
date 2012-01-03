<?php $this->genBlockBegin ($block); ?>
<?if ($this->countModules('bottom-left') || $this->countModules('bottom-right')) : ?>
	<?php if ($this->countModules('bottom-left')) : ?>
	<div class="footer-bottom bottom-left">
		<jdoc:include type="modules" name="bottom-left" style="xhtml" />
	</div>
	<?php endif; ?>
	<?php if ($this->countModules('bottom-right')) : ?>
	<div class="footer-bottom bottom-right">
		<jdoc:include type="modules" name="bottom-right" style="xhtml" />
	</div>
	<?php endif; ?>
	<script type="text/javascript">
	window.addEvent('load', function() {
		equalHeight('#ja-footer-bottom .footer-bottom');
	});
	</script>
<?endif; ?>
<?php $this->genBlockEnd($block); ?>