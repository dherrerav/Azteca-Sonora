<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<table class="admintable" cellspacing="1">
	<tr id="trfileupload">
		<td class="key" >
			<?php echo JText::_('UPLOAD_FILE'); ?>
		</td>
		<td>
			<input type="file" size="50" name="importfile" />
			<?php echo JText::sprintf('MAX_UPLOAD',(acymailing_bytes(ini_get('upload_max_filesize')) > acymailing_bytes(ini_get('post_max_size'))) ? ini_get('post_max_size') : ini_get('upload_max_filesize')); ?>
		</td>
	</tr>
	<?php if($this->config->get('require_confirmation')){ ?>
	<tr id="trfileconfirm">
		<td class="key" >
			<?php echo JText::_('IMPORT_CONFIRMED'); ?>
		</td>
		<td>
			<?php echo JHTML::_('select.booleanlist', "import_confirmed" , '',JRequest::getInt('import_confirmed',1),JText::_('JOOMEXT_YES'),JTEXT::_('JOOMEXT_NO') ); ?>
		</td>
	</tr>
	<?php } ?>
	<tr id="trfilegenerate">
		<td class="key" >
			<?php echo JText::_('GENERATE_NAME'); ?>
		</td>
		<td>
			<?php echo JHTML::_('select.booleanlist', "generatename" , '',JRequest::getInt('generatename',1),JText::_('JOOMEXT_YES'),JTEXT::_('JOOMEXT_NO') ); ?>
		</td>
	</tr>
	<tr id="trfileoverwrite">
		<td class="key" >
			<?php echo JText::_('OVERWRITE_EXISTING'); ?>
		</td>
		<td>
			<?php echo JHTML::_('select.booleanlist', "overwriteexisting" , '',JRequest::getInt('overwriteexisting',0),JText::_('JOOMEXT_YES'),JTEXT::_('JOOMEXT_NO') ); ?>
		</td>
	</tr>
	<tr id="trfilecharset">
		<td class="key" >
			<?php echo JText::_('CHARSET_FILE'); ?>
		</td>
		<td>
			<?php $charsetType = acymailing_get('type.charset'); array_unshift($charsetType->values,JHTML::_('select.option', '',JText::_('UNKNOWN'))); echo $charsetType->display('charsetconvert',JRequest::getString('charsetconvert','')); ?>
		</td>
	</tr>
</table>
