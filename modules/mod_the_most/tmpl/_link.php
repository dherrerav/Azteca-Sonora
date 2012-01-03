<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="content-most-link<?= $params->get('moduleclass_sfx') ?>">
<? if ($params->get('item_title')) { ?>
	<<?= $params->get('item_heading') ?> class="content-most-title<?= $params->get('moduleclass_sfx') ?>">
	<? if ($params->get('link_titles') && $link->link != '') { ?>
	<a href="<?= $link->link ?>">
		<?= $link->title ?>
	</a>
	<? } else {?>
	<?= $link->title ?>
	<? } ?>
	</<?= $params->get('item_heading') ?>>
<? } ?>
</div>
<script type="text/javascript">
	window.addEventListener('load', function() {
		equalHeight('.content-most-links ul');
	});
</script>