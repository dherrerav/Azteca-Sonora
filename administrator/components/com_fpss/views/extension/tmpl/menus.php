<?php
/**
 * @version		$Id: menus.php 616 2011-08-01 22:53:18Z joomlaworks $
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
      	<label for="search"><?php echo JText::_('FPSS_FILTER'); ?>:</label>
        <input type="text" name="search" id="search" value="<?php echo $this->filters['search']; ?>" title="<?php echo JText::_('FPSS_FILTER_BY_NAME'); ?>"/>
      	<button id="fpssSubmitButton"><?php echo JText::_('FPSS_GO'); ?></button>
		<button id="fpssResetButton"><?php echo JText::_('FPSS_RESET'); ?></button>
      </td>
      <td class="fpssAdminTableFiltersSelects">
	  	<label for="published"><?php echo JText::_('FPSS_STATE'); ?>:</label>
	  	<?php echo $this->filters['published']; ?>
	  	<label for="menuType"><?php echo JText::_('FPSS_MENU'); ?>:</label>
	  	<?php echo $this->filters['menuType']; ?>
	  </td>
    </tr>
  </table>
  <table class="adminlist">
    <thead>
      <tr>
        <th>#</th>
		<th><?php echo JHTML::_('grid.sort', 'FPSS_NAME', 'name', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_PUBLISHED', 'published', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_ORDER', 'ordering', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_MENU_TYPE', 'menutype', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      	<th><?php echo JHTML::_('grid.sort', 'FPSS_ITEM_ID', 'id', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
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
			<td><a href="#" onclick="window.parent.jSelectMenu('<?php echo $row->id?>', '<?php echo JString::str_ireplace(array("'", "\""), array("\\'", ""), $row->name); ?>');"><?php echo $row->treename; ?></a> </td>
			<td>
			<?php if ($row->published): ?>
				<img src="images/tick.png" alt="<?php echo JText::_('FPSS_MENU_ITEM_IS_PUBLISHED'); ?>"/>
			<?php else: ?>
				<img src="images/publish_x.png" alt="<?php echo JText::_('FPSS_MENU_ITEM_IS_UNPUBLISHED'); ?>"/>
			<?php endif; ?>
			</td>
			<td><?php echo $row->ordering; ?></td>
			<td><?php echo $row->menutype; ?></td>
			<td><?php echo $row->id; ?></td>
	      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <input type="hidden" name="option" value="com_fpss" />
  <input type="hidden" name="view" value="extension" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->filters['ordering']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filters['orderingDir']; ?>" />
  <input type="hidden" name="task" value="com_menus" />
  <?php echo JHTML::_('form.token'); ?>
</form>