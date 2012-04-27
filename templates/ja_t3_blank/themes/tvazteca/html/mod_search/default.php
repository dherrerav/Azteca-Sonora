<?php
defined('_JEXEC') or die;
$document =& JFactory::getDocument();
?>
<ul class="social-icons">
	<li>
		<a href="http://www.facebook.com/pages/Azteca-Sonora/126413310795698">
			<img src="http://www.statictvazteca.com/plantillas/maquetacion/footer2011/images/facebook.png" alt="Facebook">
		</a>
	</li>
	<li>
		<a href="http://twitter.com/aztecasonora">
			<img src="http://www.statictvazteca.com/plantillas/maquetacion/footer2011/images/twitter.png" alt="Twitter">
		</a>
	</li>
</ul>
<div class="search-button-container">
	<div class="search-button-inner">
		<?php
		//echo JRoute::_('index.php');
		?>
		<form action="index.php" method="post" class="search-form<?php echo $params->get('moduleclass_sfx') ?>">
			<input name="searchword" id="mod-search-searchword" class="search-textbox<?= $moduleclass_sfx ?>" type="text" value=" <?= $text ?>" />
			<input type="submit" value="<?= $button_text ?>" class="search-button" onclick="this.form.searchword.focus();" />
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="option" value="com_search" />
			<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
		</form>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#mod-search-searchword').focusout(function() {
		var text = $(this).val();
		if (text == '') {
			//$(this).val('<?= $text ?>');
			console.debug(text);
		}
	});
	$('#mod-search-searchword').focus(function() {
		var text = $(this).val();
		if (text == '<?= $text ?>') {
			//$(this).val('');
			console.debug(text);
		}
	});
});
</script>