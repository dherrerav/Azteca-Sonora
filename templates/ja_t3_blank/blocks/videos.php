<?php
$style = $this->getBlockStyle($block);
if ($this->countModules('video')) :
?>
<div class="video">
	<jdoc:include type="modules" name="video" style="<?= $style ?>" />
</div>
<?php endif; ?>