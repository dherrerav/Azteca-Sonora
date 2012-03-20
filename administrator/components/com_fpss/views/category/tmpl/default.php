<?php
/**
 * @version		$Id: default.php 626 2011-08-11 18:45:53Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$document = & JFactory::getDocument();
$document->addScriptDeclaration('
Joomla.submitbutton = function(pressbutton){
	if (pressbutton == \'cancel\') {
		submitform(pressbutton);
		return;
	}
	if ($FPSS.trim($FPSS(\'#name\').val())==\'\') {
		alert( \''.JText::_('FPSS_CATEGORY_MUST_HAVE_A_NAME', true).'\' );
		$FPSS(\'#name\').focus();
	} else {
		submitform(pressbutton);
	}
}
');

?>

<div class="fpssBackendEditPageContainer categoryForm">
	<h1 class="fpssViewTitle">
		<span><?php echo $this->title; ?></span><?php if($this->row->name) echo ' '.$this->row->name; ?>
	</h1>
	
	<form action="index.php" method="post" name="adminForm">
		<input type="text" name="name" id="name" size="50" maxlength="255" class="no-label" value="<?php echo $this->row->name; ?>" title="<?php echo JText::_('FPSS_NAME'); ?>" />
		<br /><br />
		<table cellpadding="0" cellspacing="0" class="fpssTable">
			<tr>
				<td class="key"><label><?php echo JText::_('FPSS_PUBLISHED'); ?></label></td><td><?php echo $this->lists['published']; ?></td>
			</tr>
			<?php if(isset($this->lists['language'])): ?>
			<tr>
				<td class="key"><label for="language"><?php echo JText::_('FPSS_LANGUAGE'); ?></label></td><td><?php echo $this->lists['language']; ?></td>
			</tr>
			<?php endif; ?>
			<?php if(version_compare( JVERSION, '1.6.0', 'ge' )) : ?>
			<?php foreach ($this->form->getFieldset('slide-resize-options') as $field) : ?>
			<tr>
				<td class="key"><?php echo $field->label; ?></td><td><?php echo $field->input; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php foreach ($this->form->getFieldset('slide-view-options') as $field) : ?>
			<tr>
				<td class="key"><?php echo $field->label; ?></td><td><?php echo $field->input; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<?php foreach ($this->form->getParams('params', 'slide-resize-options') as $param): ?>
			<tr>
				<?php if ($param[0]): ?>
				<td class="key"><?php echo $param[0]; ?></td>
				<td><?php echo $param[1]; ?></td>
				<?php else: ?>
				<td><?php echo $param[1]; ?></td>
				<?php endif; ?>
		  </tr>
			<?php endforeach; ?>
			<?php foreach ($this->form->getParams('params', 'slide-view-options') as $param): ?>
			<tr>
				<?php if ($param[0]): ?>
				<td class="key"><?php echo $param[0]; ?></td>
				<td><?php echo $param[1]; ?></td>
				<?php else: ?>
				<td><?php echo $param[1]; ?></td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
	
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="option" value="com_fpss" />
		<input type="hidden" name="view" value="category" />
		<input type="hidden" name="task" value="" />
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>
