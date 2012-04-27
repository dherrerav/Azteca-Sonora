<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<?php if($params->get('displaythumbnail')):?>
<div align="center">
	<img id="tpscurimg" src="<?php echo $lists['current_image'];?>" width="<?php echo $params->get('width', 140);?>" onerror="this.src='<?php echo JURI::base(true);?>/modules/mod_templateselector/images/no_image.png';"/>
</div>
<?php endif;?>
<form method="post" id="jTmplSelectForm" name="tmplSelectForm">
	<div align="center">
	<?php echo $lists['list'];?>
	</div>
	<div align="center">
		<input type="submit" class="button" id="jTemplateReset" name="resetTemplate" value="<?php echo $params->get('resetbtn', JText::_('MOD_TEMPLATE_SELECTOR_RESET'));?>" />
		<input type="submit" class="button" id="jTemplateChange" name="changeTemplate" value="<?php echo $params->get('switchbtn', JText::_('MOD_TEMPLATE_SELECTOR_SWITCH'));?>" />
		<input type="submit" class="button" id="jTemplateRolling" name="rollingTemplate" value="<?php echo $params->get('rollbtn', JText::_('MOD_TEMPLATE_SELECTOR_ROLLING'));?>" />
		<input type="hidden" id="jTemplateDirectory" name="templatedirectory" value="<?php echo $lists['selected'];?>" />
	</div>
</form>