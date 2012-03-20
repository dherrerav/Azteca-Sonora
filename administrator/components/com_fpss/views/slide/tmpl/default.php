<?php
/**
 * @version		$Id: default.php 658 2011-08-23 14:08:13Z lefteris.kavadas $
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
		submitform( pressbutton );
		return;
	}
	if ($FPSS.trim($FPSS(\'#title\').val())==\'\') {
		alert( \''.JText::_('FPSS_SLIDE_MUST_HAVE_A_TITLE', true).'\' );
		$FPSS(\'#title\').focus();
		return;
	}
	if ($FPSS(\'#catid\').val()==\'0\') {
		alert( \''.JText::_('FPSS_PLEASE_SELECT_A_CATEGORY', true).'\' );
		$FPSS(\'#catid\').focus();
		return;
	}
	if ($FPSS.trim($FPSS(\'#image\').val())==\'\') {
		alert( \''.JText::_('FPSS_PLEASE_SELECT_AN_IMAGE', true).'\' );
		return;
	}
	submitform( pressbutton );
}
');

?>

<div class="fpssBackendEditPageContainer slideForm">
	<h1 class="fpssViewTitle">
		<span><?php echo $this->title; ?></span><?php if($this->row->title) echo ' '.$this->row->title; ?>
	</h1>

	<form action="index.php" method="post" name="adminForm">
		<div class="fpssTabs">
			<ul>
				<li><a href="#fpssSlideMainTab"><?php echo JText::_('FPSS_SLIDE_CONTENT'); ?></a></li>
				<li><a href="#fpssSlideAdvancedTab"><?php echo JText::_('FPSS_ADVANCED_SETTINGS'); ?></a></li>
			</ul>
			<div id="fpssSlideMainTab">

				<h2>1. <?php echo JText::_('FPSS_FIRST_CHOOSE_THE_SLIDESHOW_CATEGORY'); ?></h2>
				<div class="fpssField">
					<?php echo $this->lists['category']; ?>
					<span id="currentDimensions">
						(<?php echo JText::_('FPSS_COM_PARAMETERS_FOR_SELECTED_CATEGORY'); ?>: <?php echo JText::_('FPSS_MAIN_IMAGE_WIDTH'); ?> <strong><span id="mainImageWidth"><?php echo $this->lists['mainImageWidth']; ?></span>px</strong> / <?php echo JText::_('FPSS_THUMB_IMAGE_WIDTH'); ?> <strong><span id="thumbImageWidth"><?php echo $this->lists['thumbImageWidth']; ?></span>px</strong> / <?php echo JText::_('FPSS_PREVIEW_IMAGE_WIDTH'); ?> <strong><span id="previewImageWidth"><?php echo $this->lists['previewImageWidth']; ?></span>px</strong>)
					</span>
					<div class="fpssNote"><?php echo JText::_('FPSS_NOTE_CHANGING_THIS_WILL_AFFECT_THE_SLIDE_IMAGES_DIMENSIONS_MAKE_SURE_YOU_SET_THIS_BEFORE_SETTING_THE_SLIDE_IMAGES'); ?></div>
				</div>

				<h2>2. <?php echo JText::_('FPSS_SELECT_YOUR_SLIDE_SOURCE'); ?></h2>
				<div class="fpssField">
					<div id="cpanel">
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-custom" href="#">
							    <img alt="<?php echo JText::_('FPSS_CUSTOM_URL'); ?>" src="components/com_fpss/images/custom.png" />
							    <span><?php echo JText::_('FPSS_CUSTOM_URL'); ?></span>
						    </a>
					    </div>
				    </div>
					    
						<div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_content" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="<?php echo $this->articlesModalLink; ?>">
							    <img alt="<?php echo JText::_('FPSS_JOOMLA_ARTICLE'); ?>" src="components/com_fpss/images/com_content.png" />
							    <span><?php echo JText::_('FPSS_JOOMLA_ARTICLE'); ?></span>
						    </a>
					    </div>
					   </div>
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_menus" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_fpss&amp;view=extension&amp;task=com_menus">
							    <img alt="<?php echo JText::_('FPSS_JOOMLA_MENU_ITEM'); ?>" src="components/com_fpss/images/com_menus.png" />
							    <span><?php echo JText::_('FPSS_JOOMLA_MENU_ITEM'); ?></span>
						    </a>
					    </div>
				    </div>
				    <?php if(FPSSHelperExtension::isInstalled('k2')): ?>
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_k2" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_k2&amp;view=items&amp;task=element&amp;tmpl=component">
							    <img alt="<?php echo JText::_('FPSS_K2_ITEM'); ?>" src="components/com_fpss/images/com_k2.gif" />
							    <span><?php echo JText::_('FPSS_K2_ITEM'); ?></span>
						    </a>
					    </div>
				    </div>
				    <?php endif; ?>
				    <?php if(FPSSHelperExtension::isInstalled('virtuemart')): ?>
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_virtuemart" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_fpss&amp;view=extension&amp;task=com_virtuemart">
							    <img alt="<?php echo JText::_('FPSS_VIRTUEMART_PRODUCT'); ?>" src="components/com_fpss/images/com_virtuemart.gif" />
							    <span><?php echo JText::_('FPSS_VIRTUEMART_PRODUCT'); ?></span>
						    </a>
					    </div>
				    </div>
				    <?php endif; ?>
				    <?php if(FPSSHelperExtension::isInstalled('redshop')): ?>
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_redshop" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_redshop&amp;view=product&amp;task=element&amp;tmpl=component">
							    <img alt="<?php echo JText::_('FPSS_REDSHOP_PRODUCT'); ?>" src="components/com_fpss/images/com_redshop.png" />
							    <span><?php echo JText::_('FPSS_REDSHOP_PRODUCT'); ?></span>
						    </a>
					    </div>
				    </div>
				    <?php endif; ?>
				    <?php if(FPSSHelperExtension::isInstalled('tienda')): ?>
				    <div class="icon-wrapper">
					    <div class="icon">
						    <a id="source-com_tienda" class="modal" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_fpss&amp;view=extension&amp;task=com_tienda">
							    <img alt="<?php echo JText::_('FPSS_TIENDA_PRODUCT'); ?>" src="components/com_fpss/images/com_tienda.png" />
							    <span><?php echo JText::_('FPSS_TIENDA_PRODUCT'); ?></span>
						    </a>
					    </div>
				    </div>
				    <?php endif; ?>

						<div class="clr"></div>
					</div>
				</div>

				<h2>3. <?php echo JText::_('FPSS_EDIT_YOUR_SLIDE_DATA'); ?></h2>
				<div class="fpssField">
					<input type="text" name="title" id="title" class="no-label" title="<?php echo JText::_('FPSS_TITLE'); ?>" size="50" maxlength="255" value="<?php echo $this->row->title; ?>" />
					<br /><br />
					<input type="checkbox" name="featured" id="featured" value="1" <?php if($this->row->featured) { echo 'checked="checked"'; }?>/> <label for="featured"><?php echo JText::_('FPSS_FEATURED'); ?></label>
					<br /><br />
					<div class="fpssEditor">
						<?php if($this->params->get('wysiwyg')): ?>
						<?php echo $this->lists['wysiwyg']; ?>
						<?php else: ?>
						<textarea id="text" name="text" cols="50" rows="10"><?php echo $this->row->text; ?></textarea>
						<?php endif; ?>
					</div>
					<br /><br />
					<input type="text" name="tagline" id="tagline" class="no-label" title="<?php echo JText::_('FPSS_TAGLINE'); ?>" size="50" value="<?php echo $this->row->tagline; ?>" />
					<br /><br />
					<input type="text" name="reference" id="reference" class="no-label" title="<?php echo JText::_('FPSS_URL'); ?>" disabled="disabled" size="50" value="<?php echo $this->row->reference; ?>" /> <span class="fpssNote"></span>
					<br /><br />
					
					<input type="hidden" name="referenceType" id="referenceType" value="<?php echo $this->row->referenceType?>" />
					<input type="hidden" name="referenceID" id="referenceID" value="<?php echo $this->row->referenceID?>" />
					<input type="hidden" id="image" name="image" value="<?php echo $this->row->mainImage; ?>" />
					<input type="hidden" id="thumb" name="thumb" value="<?php echo $this->row->thumbnailImage; ?>" />
					<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
					<input type="hidden" name="dummy" value="" />
					<input type="hidden" name="option" value="com_fpss" />
					<input type="hidden" name="view" value="slide" />
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="params[useOriginal]" id="useOriginalValue" value="<?php echo $this->row->useOriginal; ?>" />
					<?php echo JHTML::_('form.token'); ?>
				</div>
			</div>
			<div id="fpssSlideAdvancedTab">
				<div class="params-block">
					<table class="fpssTable" cellspacing="0">
					  <?php if($this->row->id): ?>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_CREATED_BY'); ?></label>
					    </td>
					    <td><span id="fpssAuthor"><?php echo $this->lists['created_by']; ?></span>
					      <div class="button2-left">
					        <div class="blank"> <a class="modal button" rel="{handler:'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_fpss&amp;view=extension&amp;task=com_users"><?php echo JText::_('FPSS_SELECT_USER'); ?></a> </div>
					      </div>
					      <input type="hidden" name="created_by" value="<?php echo $this->row->created_by; ?>" />
					    </td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_CREATED_ON'); ?></label>
					    </td>
					    <td><?php echo $this->lists['created']; ?></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_LAST_MODIFIED_BY'); ?></label>
					    </td>
					    <td><?php echo $this->lists['modified_by']; ?></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_LAST_MODIFIED_ON'); ?></label>
					    </td>
					    <td><?php echo $this->lists['modified']; ?></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_HITS'); ?></label>
					    </td>
					    <td><?php echo $this->row->hits; ?>
					      <?php if($this->row->hits): ?>
					      <input id="fpssResetHitsButton" type="button" value="<?php echo JText::_('FPSS_RESET'); ?>" class="button" name="fpssResetHitsButton" />
					      <?php endif; ?>
					    </td>
					  </tr>
					  <?php endif; ?>
					  <tr>
					    <td class="key">
					      <label><?php echo JText::_('FPSS_PUBLISHED'); ?></label>
					    </td>
					    <td><?php echo $this->lists['published']; ?></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label for="publish_up"><?php echo JText::_('FPSS_START_PUBLISHING'); ?></label>
					    </td>
					    <td><input type="text" name="publish_up" class="fpssDatePicker" value="<?php echo $this->row->publish_up; ?>" /></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label for="publish_down"><?php echo JText::_('FPSS_FINISH_PUBLISHING'); ?></label>
					    </td>
					    <td><input type="text" name="publish_down" class="fpssDatePicker" value="<?php echo $this->row->publish_down; ?>" /></td>
					  </tr>
					  <tr>
					    <td class="key">
					      <label for="access"><?php echo JText::_('FPSS_ACCESS_LEVEL'); ?></label>
					    </td>
					    <td><?php echo $this->lists['access']; ?></td>
					  </tr>
					  <?php if(isset($this->lists['language'])): ?>
					  <tr>
					    <td class="key">
					      <label for="language"><?php echo JText::_('FPSS_LANGUAGE'); ?></label>
					    </td>
					    <td><?php echo $this->lists['language']; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if(version_compare( JVERSION, '1.6.0', 'ge' )) : ?>
					  <?php foreach ($this->form->getFieldset('slide-view-options') as $field) : ?>
					  <tr>
					    <td class="key"><?php echo $field->label; ?></td>
					    <td><?php echo $field->input; ?></td>
					  </tr>
					  <?php endforeach; ?>
					  <?php else: ?>
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
				</div>
			</div>
		</div>
	</form>

	<div id="imagesContainer">
		<h2>4. <?php echo JText::_('FPSS_SET_THE_SLIDE_IMAGE'); ?></h2>
		<div class="fpssTabs">
			<ul>
				<li><a href="#fpssSlideImageTab"><?php echo JText::_('FPSS_MAIN_IMAGE'); ?></a></li>
				<li><a href="#fpssSlideThumbTab"><?php echo JText::_('FPSS_THUMBNAIL_IMAGE'); ?></a></li>
			</ul>
			<div id="fpssSlideImageTab">
				<form action="index.php" method="post" enctype="multipart/form-data" name="imageForm" id="imageForm" target="imageFormTarget">
					<div class="fpssField">
						<label for="imageFile"><?php echo JText::_('FPSS_UPLOAD_FROM_YOUR_COMPUTER'); ?></label>
						<input type="file" name="imageFile" class="file" id="imageFile" />
						
						<label for="existingImage"><?php echo JText::_('FPSS_OR_SELECT_AN_IMAGE_FROM_THE_SERVER'); ?></label>
						<input type="text" name="existingImage" id="existingImage" readonly="readonly" /> <button id="browseServerForImage" class="browseServerButton"><?php echo JText::_('FPSS_BROWSE_SERVER'); ?></button>
						
						<br /><br />
						<input type="checkbox" id="useOriginal" name="useOriginal" value="1" <?php echo ($this->row->useOriginal)? 'checked="checked"':''; ?> />
						<label for="useOriginal"><?php echo JText::_('FPSS_DO_NOT_RESIZE_SOURCE_IMAGE'); ?></label>
					</div>
					
					<img id="imagePreview" class="preview<?php if(!$this->row->id) echo ' unavailable'; ?>" src="<?php echo ($this->row->mainImage) ? $this->row->mainImage.'?t='.time() : 'components/com_fpss/images/placeholder.png'; ?>" alt="<?php echo JText::_('FPSS_IMAGE_PREVIEW'); ?>" />
					
					<div id="imageLog" class="fpssNote">test</div>
					
					<input type="hidden" name="option" value="com_fpss" />
					<input type="hidden" name="view" value="slide" />
					<input type="hidden" name="task" value="upload" />
					<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
					<input type="hidden" name="dummy" value="" />
					<input type="hidden" name="catid" value="<?php echo $this->row->catid; ?>" />
					<?php echo JHTML::_('form.token'); ?>
				</form>
				<iframe id="imageFormTarget" name="imageFormTarget" class="targetFrame"></iframe>
			</div>
			<div id="fpssSlideThumbTab">
				<form action="index.php" method="post" enctype="multipart/form-data" name="thumbForm" id="thumbForm" target="thumbFormTarget">
					<div class="fpssField">
						<label for="thumbFile"><?php echo JText::_('FPSS_UPLOAD_FROM_YOUR_COMPUTER'); ?></label>
						<input type="file" name="thumbFile" class="file" id="thumbFile" />
						<label for="existingThumb"><?php echo JText::_('FPSS_OR_SELECT_AN_IMAGE_FROM_THE_SERVER'); ?></label>
						<input type="text" name="existingThumb" id="existingThumb" readonly="readonly" /> <button id="browseServerForThumb" class="browseServerButton"><?php echo JText::_('FPSS_BROWSE_SERVER'); ?></button>
						<?php echo JText::_('FPSS_OR'); ?>
						<a href="#" id="resetThumbButton"><?php echo JText::_('FPSS_DONT_USE_DIFFERENT_IMAGE_FOR_THE_SLIDE_THUMBNAIL'); ?></a>
					</div>
					<img id="thumbPreview" class="preview<?php if(!$this->row->id) { echo ' unavailable'; }?>" src="<?php echo ($this->row->thumbnailImage) ? $this->row->thumbnailImage.'?t='.time() : 'components/com_fpss/images/placeholder.png'?>" alt="<?php echo JText::_('FPSS_THUMBNAIL_PREVIEW'); ?>" />
					<div id="thumbLog" class="fpssNote"></div>
					<input type="hidden" name="option" value="com_fpss" />
					<input type="hidden" name="view" value="slide" />
					<input type="hidden" name="task" value="upload" />
					<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
					<input type="hidden" name="dummy" value="" />
					<input type="hidden" name="catid" value="<?php echo $this->row->catid; ?>" />
					<?php echo JHTML::_('form.token'); ?>
				</form>
				<iframe id="thumbFormTarget" name="thumbFormTarget" class="targetFrame"></iframe>
			</div>
		</div>
		<div id="imageStore"></div>
	</div>
</div>