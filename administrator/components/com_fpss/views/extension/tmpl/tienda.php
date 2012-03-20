<?php
/**
 * @version		$Id: tienda.php 616 2011-08-01 22:53:18Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post"	name="adminForm">
  <table class="fpssAdminTableFilters">
    <tr>
      <td>
        <button id="fpssSubmitButton"><?php echo JText::_('FPSS_GO'); ?></button>
		<button id="fpssResetButton"><?php echo JText::_('FPSS_RESET'); ?></button>
      	<label for="search"><?php echo JText::_('FPSS_NAME'); ?>:</label>
        <input type="text" name="search" id="search" value="<?php echo $this->filters['search']; ?>" title="<?php echo JText::_('FPSS_FILTER_BY_NAME'); ?>"/>
      	<label for="sku"><?php echo JText::_('FPSS_SKU'); ?>:</label>
        <input type="text" name="sku" id="sku" value="<?php echo $this->filters['sku']; ?>" title="<?php echo JText::_('FPSS_FILTER_BY_SKU'); ?>"/>

      </td>
      <td class="fpssAdminTableFiltersSelects">
	  	<label for="published"><?php echo JText::_('FPSS_STATE'); ?>:</label>
	  	<?php echo $this->filters['published']; ?>
	  	<label for="catid"><?php echo JText::_('FPSS_CATEGORY'); ?>:</label>
	  	<?php echo $this->filters['category']; ?>
	  </td>
    </tr>
  </table>
  <table class="adminlist">
    <thead>
      <tr>
        <th>#</th>
		<th><?php echo JHTML::_('grid.sort', 'FPSS_NAME', 'product_name', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'FPSS_SKU', 'product_sku', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'FPSS_CATEGORY', 'category_name', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_PUBLISHED', 'product_enabled', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      	<th><?php echo JHTML::_('grid.sort', 'FPSS_ID', 'product_id', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
      </tr>
    </tfoot>
    <tbody>
	<?php foreach($this->rows as $key=>$row): ?>
	      <tr class="row<?php echo (($key+1)%2); ?>">
	        <td><?php echo $key+1; ?></td>
			<td><a href="#" onclick="window.parent.jSelectTiendaProduct('<?php echo $row->product_id; ?>', '<?php echo JString::str_ireplace(array("'", "\""), array("\\'", ""), $row->product_name); ?>');"><?php echo $this->escape($row->product_name); ?></a> </td>
			<td><?php echo $row->product_sku; ?></td>
			<td><?php echo implode('<br/>', $row->categories); ?></td>
			<td>
			<?php if ($row->product_enabled): ?>
				<img src="images/tick.png" alt="<?php echo JText::_('FPSS_PRODUCT_IS_PUBLISHED'); ?>"/>
			<?php else: ?>
				<img src="images/publish_x.png" alt="<?php echo JText::_('FPSS_PRODUCT_IS_UNPUBLISHED'); ?>"/>
			<?php endif; ?>
			</td>
			<td><?php echo $row->product_id; ?></td>
	      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <input type="hidden" name="option" value="com_fpss" />
  <input type="hidden" name="view" value="extension" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->filters['ordering']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filters['orderingDir']; ?>" />
  <input type="hidden" name="task" value="com_tienda" />
  <?php echo JHTML::_('form.token'); ?>
</form>