<?php
/**
 * @version		$Id: default.php 18052 2010-07-08 04:56:08Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');
require_once JPATH_SITE . '/libraries/simple_html_dom.php';
// Create shortcut to parameters.
$params = $this->item->params;
?>
<div class="item-page<?php echo $params->get('pageclass_sfx')?>">
<?php echo $this->item->event->beforeDisplayContent; ?>
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1 class="componentheading">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<?php if ($params->get('show_title')|| $params->get('access-edit')) : ?>
		<h2 class="contentheading">
				<?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
				<a href="<?php echo $this->item->readmore_link; ?>">
						<?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
						<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
		</h2>
<?php endif; ?>

<?php $useDefList = (($params->get('show_author')) OR ($params->get('show_category')) OR ($params->get('show_parent_category'))
	OR ($params->get('show_create_date')) OR ($params->get('show_modify_date')) OR ($params->get('show_publish_date'))
	OR ($params->get('show_hits'))); ?>

<?php if ($params->get('access-edit') ||  $params->get('show_print_icon') || $params->get('show_email_icon') || $useDefList ) : ?>
<div class="article-tools clearfix">
	<?php if ($params->get('access-edit') ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
		<ul class="actions">
		<?php if (!$this->print) : ?>
				<?php if ($params->get('show_print_icon')) : ?>
				<li class="print-icon">
						<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
				</li>
				<?php endif; ?>

				<?php if ($params->get('show_email_icon')) : ?>
				<li class="email-icon">
						<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
				</li>
				<?php endif; ?>
				<?php if ($this->user->authorise('core.edit', 'com_content.article.'.$this->item->id)) : ?>
						<li class="edit-icon">
							<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
						</li>
					<?php endif; ?>
		<?php else : ?>
				<li>
						<?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?>
				</li>
		<?php endif; ?>
		</ul>
<?php endif; ?>

	<?php  if (!$params->get('show_intro')) :
		echo $this->item->event->afterDisplayTitle;
	endif; ?>
<?php if ($useDefList) : ?>
<ul class="article-info clearfix">
<?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
	<li class="createdby">
		<?php $author =  $this->item->author; ?>
		<?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>

		<?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
			<?
			JLoader::import('joomla.application.component.model');
			JLoader::import('contact', JPATH_SITE . DS . 'components' . DS . 'com_contact' . DS . 'models');

			$model =& JModel::getInstance('contact', 'ContactModel');
			$contact = $model->getItem($this->item->contactid);
			?>
			<img src="<?= $contact->image ?>" alt="<?= $author ?>" align="left" style="margin-right: 10px; margin-bottom: 10px;" />
			<?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' , 
			 JHTML::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author)); ?>
		<?php else :?>
			<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
		<?php endif; ?>
	</li>
<?php endif; ?>
<?php if ($params->get('show_publish_date')) : ?>
	<li class="published">
	<?php echo JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2')); ?>
	</li>
<?php endif; ?>
</ul>
 <?php endif; ?>
</div>
<?php endif; ?>
	<?php if (isset ($this->item->toc)) : ?>
		<?php echo $this->item->toc; ?>
	<?php endif; ?>
	<?= $this->item->introtext ?>
	<?= $this->item->fulltext ?>
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
<div class="comments-container">
	
</div>