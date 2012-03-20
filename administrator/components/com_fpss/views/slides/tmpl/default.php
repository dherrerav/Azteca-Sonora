<?php
/**
 * @version		$Id: default.php 652 2011-08-23 11:35:30Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm">
	<table class="fpssAdminTableFilters">
		<tr>
			<td class="fpssAdminTableFiltersSearch">
				<?php echo JText::_('FPSS_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->filters['search']; ?>" title="<?php echo JText::_('FPSS_FILTER_BY_TITLE'); ?>" />
				<button id="fpssSubmitButton"><?php echo JText::_('FPSS_GO'); ?></button>
				<button id="fpssResetButton"><?php echo JText::_('FPSS_RESET'); ?></button>
			</td>
			<td class="fpssAdminTableFiltersSelects">
				<?php echo $this->filters['published']; ?>
				<?php echo $this->filters['featured']; ?>
				<?php echo $this->filters['category']; ?>
				<?php echo $this->filters['author']; ?>
				<?php if(isset($this->filters['language'])): ?>
				<?php echo $this->filters['language']; ?>
				<?php endif; ?>
			</td>
		</tr>
	</table>
  <table class="adminlist">
    <thead>
      <tr>
				<th><input id="jToggler" type="checkbox" name="toggle" value="" /></th>
				<th class="fpssLeft"><?php echo JHTML::_('grid.sort', 'FPSS_TITLE', 'slide.title', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_FEATURED', 'slide.featured', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_PUBLISHED', 'slide.published', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_ORDER', 'slide.ordering', @$this->filters['orderingDir'], @$this->filters['ordering']); ?> <?php if($this->orderingFlag) echo JHTML::_('grid.order', $this->rows ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_FEATURED_ORDER', 'slide.featured_ordering', @$this->filters['orderingDir'], @$this->filters['ordering']); ?> <?php if($this->featuredOrderingFlag) echo JHTML::_('grid.order', $this->rows, 'filesave.png', 'featuredsaveorder' ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_CATEGORY', 'category.name', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_SOURCE', 'slide.referenceType', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_AUTHOR', 'author.name', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_LAST_MODIFIED_BY', 'moderator.name', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_ACCESS_LEVEL', 'slide.access', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_CREATED', 'slide.created', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_MODIFIED', 'slide.modified', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_HITS', 'slide.hits', @$this->filters['orderingDir'], @$this->filters['ordering']); ?></th>
				<th><?php echo JText::_('FPSS_QUICK_PREVIEW'); ?></th>
				<th><?php echo JHTML::_('grid.sort','FPSS_ID', 'slide.id', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="16"><?php echo $this->pagination->getListFooter(); ?></td>
      </tr>
    </tfoot>
    <tbody class="fpssSortable">
			<?php foreach($this->rows as $key=>$row): ?>
			<tr class="row<?php echo (($key+1)%2); ?>">
				<td class="fpssCenter"><?php echo JHTML::_('grid.id', $key, $row->id, false, 'id' ); ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_fpss&view=slide&id='.$row->id); ?>"><?php echo $row->title; ?></a></td>
				<td class="fpssCenter"><?php echo FPSSHelperHTML::featured($row, $key); ?></td>
				<td class="fpssCenter"><?php echo JHTML::_('grid.published', $row, $key ); ?></td>
				<td class="fpssOrder order">
					<?php if($this->orderingFlag): ?>
					<span class="handle hasTip" title="<?php echo JText::_('FPSS_DRAG_N_DROP_SLIDES_TO_CHANGE_THEIR_ORDERING'); ?>"></span>
					<?php endif; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php  if(!$this->orderingFlag) echo 'disabled="disabled"'; ?> />
				</td>
				<td class="fpssOrder order">
					<?php if($this->featuredOrderingFlag): ?>
					<span class="handle hasTip" title="<?php echo JText::_('FPSS_DRAG_N_DROP_SLIDES_TO_CHANGE_THEIR_FEATURED_ORDERING'); ?>"></span>
					<?php endif; ?>
					<input type="text" name="featuredOrder[]" size="5" value="<?php echo $row->featured_ordering; ?>" <?php  if(!$this->featuredOrderingFlag) echo 'disabled="disabled"'; ?> />
				</td>
				<td class="fpssCenter"><a href="<?php echo JRoute::_('index.php?option=com_fpss&view=category&id='.$row->catid); ?>"><?php echo $row->categoryName; ?></a></td>
				<td class="fpssCenter"><?php echo $row->reference; ?></td>
				<td class="fpssCenter"><a href="<?php echo JRoute::_('index.php?option=com_users&view=user&task=edit&cid[]='.$row->created_by); ?>"><?php echo $row->authorName; ?></a></td>
				<td class="fpssCenter"><a href="<?php echo JRoute::_('index.php?option=com_users&view=user&task=edit&cid[]='.$row->modified_by); ?>"><?php echo $row->moderatorName; ?></a></td>
				<td class="fpssCenter"><?php echo (version_compare( JVERSION, '1.6.0', 'ge' ))?strip_tags(JHTML::_('grid.access', $row, $key )):JHTML::_('grid.access', $row, $key ); ?></td>
				<td class="fpssCenter"><?php echo $row->created; ?></td>
				<td class="fpssCenter"><?php echo $row->modified; ?></td>
				<td class="fpssCenter"><?php echo $row->hits; ?></td>
				<td class="fpssCenter"><a title="<?php echo JText::_('FPSS_IMAGE_PATH_ON_SERVER'); ?>: <b><?php echo str_replace(JURI::root(true),'',$row->mainImage); ?></b>" rel="lightbox[fpss_<?php echo md5($row->categoryName); ?>]" href="<?php echo $row->mainImage; ?>"><img alt="<?php echo JText::_('FPSS_PREVIEW'); ?>" src="templates/<?php echo $this->template; ?>/images/menu/icon-16-media.png"/></a></td>
				<td class="fpssCenter"><?php echo $row->id; ?></td>
			</tr>
			<?php endforeach; ?>
    </tbody>
  </table>
  <input type="hidden" name="option" value="com_fpss" />
  <input type="hidden" name="view" value="slides" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->filters['ordering']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filters['orderingDir']; ?>" />
  <input type="hidden" name="task" value="" />
  <?php echo JHTML::_('form.token'); ?>
</form>
