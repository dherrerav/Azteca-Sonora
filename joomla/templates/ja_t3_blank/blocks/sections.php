<?php
$style = $this->getBlockStyle($block);
if ($this->countModules('sections-list')) :
?>
<div class="sections-list">
	<jdoc:include type="modules" name="sections-list" style="<?= $style ?>" />
</div>
<?php endif; ?>
<?php if ($this->countModules('right-content')) : ?>
<div class="right-content">
	<jdoc:include type="modules" name="right-content" style="<?= $style ?>" />
</div>
<?php endif; ?>