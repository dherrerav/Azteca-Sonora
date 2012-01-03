<?php
$style = $this->getBlockStyle($block);
if ($this->countModules('topbanner')) :
?>
<div id="topbanner">
	<jdoc:include type="modules" name="topbanner" style="<?= $style ?>" />
</div>
<?php endif; ?>