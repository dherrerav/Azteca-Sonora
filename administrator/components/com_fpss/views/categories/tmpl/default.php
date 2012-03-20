<?php
/**
 * @version		$Id: default.php 616 2011-08-01 22:53:18Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post"	name="adminForm">

  <table class="fpssAdminTableFilters">
		<tr>
			<td class="fpssAdminTableFiltersSearch">
				<?php echo JText::_('FPSS_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->filters['search']; ?>" title="<?php echo JText::_('FPSS_FILTER_BY_NAME'); ?>" />
				<button id="fpssSubmitButton"><?php echo JText::_('FPSS_GO'); ?></button>
				<button id="fpssResetButton"><?php echo JText::_('FPSS_RESET'); ?></button>
			</td>
			<td class="fpssAdminTableFiltersSelects">
				<?php echo $this->filters['published']; ?>
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
				<th class="fpssLeft"><?php echo JHTML::_('grid.sort', 'FPSS_NAME', 'category.name', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_ORDER', 'category.ordering', @$this->filters['orderingDir'], @$this->filters['ordering']); ?> <?php if($this->orderingFlag) echo JHTML::_('grid.order', $this->rows ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_PUBLISHED', 'category.published', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_NUMBER_OF_SLIDES', 'numOfSlides', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
				<th><?php echo JText::_('FPSS_VIEW_SLIDES'); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'FPSS_ID', 'category.id', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
			</tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
      </tr>
    </tfoot>
    <tbody class="fpssSortable">
			<?php foreach($this->rows as $key=>$row): ?>
			<tr class="row<?php echo (($key+1)%2); ?>">
				<td class="fpssCenter"><?php echo JHTML::_('grid.id', $key, $row->id, false, 'id' ); ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_fpss&view=category&id='.$row->id); ?>"><?php echo $row->name; ?></a> </td>
				<td class="fpssOrder order">
				<?php if($this->orderingFlag): ?>
				<span class="handle hasTip" title="<?php echo JText::_('FPSS_DRAG_N_DROP_CATEGORIES_TO_CHANGE_THEIR_ORDERING'); ?>"></span>
				<?php endif; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php  if(!$this->orderingFlag) echo 'disabled="disabled"'; ?> />
				</td>
				<td class="fpssCenter"><?php echo JHTML::_('grid.published', $row, $key ); ?></td>
				<td class="fpssCenter"><?php echo $row->numOfSlides; ?></td>
				<td class="fpssCenter"><?php if($row->numOfSlides): ?><a href="<?php echo JRoute::_('index.php?option=com_fpss&view=slides&catid='.$row->id); ?>"><img alt="<?php echo JText::_('FPSS_VIEW_SLIDES'); ?>" src="<?php echo JURI::base().'components/com_fpss/images/view-slides.png'?>"/></a><?php endif; ?></td>
				<td class="fpssCenter"><?php echo $row->id; ?></td>
			</tr>
			<?php endforeach; ?>
    </tbody>

  </table>
  <input type="hidden" name="option" value="com_fpss" />
  <input type="hidden" name="view" value="categories" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->filters['ordering']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filters['orderingDir']; ?>" />
  <input type="hidden" name="task" value="" />
  <?php echo JHTML::_('form.token'); ?>
</form>
