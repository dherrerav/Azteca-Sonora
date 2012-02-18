<?php
defined('_JEXEC') or die;
$width = round(100 / count($tabs), 2);
$id = modTabsHelper::generateRandomId(16);
?>
<div class="tabs" id="tabs-<?= $id ?>">
	<ul class="tabs-navigation">
		<? foreach ($tabs as $tab) : ?>
		<? $module = $tab[2] ?>
		<li class="tab" style="width: <?= $width ?>%;">
			<a href="#mod-<?= $module->id ?>" title="<?= $module->title ?>">
				<span><?= $module->title ?>
			</a>
		</li>
		<? endforeach ?>
	</ul>
	<? foreach ($tabs as $tab) : ?>
	<? $module = $tab[2] ?>
	<div id="mod-<?= $module->id ?>" class="tab-container">
		<div class="tab-content">
			<?= JModuleHelper::renderModule($module) ?>
		</div>
	</div>
	<? endforeach ?>
</div>
<script type="text/javascript">
$(function() {
	var tab_contents = $('div#tabs-<?= $id ?> div.tab-container');
	$('div#tabs-<?= $id ?> ul.tabs-navigation li a').click(function(e) {
		e.preventDefault();
		tab_contents.hide():
		tab_contents.filter(this.hash).show();
		$('div#tabs-<?= $id ?> ul.tabs-navigation li a').removeClass('selected');
		$(this).addClass('selected');
	});
});
</script>