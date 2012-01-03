<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
$i = 0;
if (count($articles) >= 3) {
	$articlesSlice = $articles;
	$linksSlice = $articles;
	$articles = array_splice($articlesSlice, 0, 3);
	$links = array_splice($linksSlice, 3);
} else if (count($articles) <= 3) {
	$links = null;
} else {
	$articles = null;
	$links = null;
}
if ($articles !== null) {
?>
<div class="content-most-articles<?= $moduleclass_sfx ?>">
	<ul class="content-most-articles-list">
	<? foreach ($articles as $article) { ?>
		<li><? require JModuleHelper::getLayoutPath('mod_the_most', '_article') ?></li>
	<? } ?>
	</ul>
</div>
<?php
}
if ($links !== null) {
	$i = 0;
?>
<div class="content-most-links<?= $moduleclass_sfx ?>">
	<? foreach ($links as $link) { ?>
	<? if ($i == 0) { ?>
	<ul class="content-most-links-list">
	<? } else if ($i >= 3) {
		$i = 0;
	?>
	</ul>
	<ul class="content-most-links-list">
	<? } ?>
		<li><? require JModuleHelper::getLayoutPath('mod_the_most', '_link') ?></li>
	<?
		$i++;
	} ?>
	</ul>
</div>
<?
}
?>