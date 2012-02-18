<?php
defined('_JEXEC') or die;
$width = round(100 / count($tabs), 2);
var_dump($width);
?>
<div class="tabs">
	<ul class="tabs-navigation">
		<? foreach ($tabs as $tab) : ?>
		<? $module = $tab[2] ?>
		<li class="tab">
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