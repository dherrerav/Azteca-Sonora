<?php
/**
 * @version		$Id: users.php 616 2011-08-01 22:53:18Z joomlaworks $
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
	  	<?php echo $this->filters['group']; ?>
	  </td>
    </tr>
  </table>
  <table class="adminlist">
    <thead>
      <tr>
        <th>#</th>
		<th><?php echo JHTML::_('grid.sort', 'FPSS_NAME', 'a.name', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_USERNAME', 'a.username', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_ENABLED', 'a.block', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo (version_compare( JVERSION, '1.6.0', 'ge' ))? JText::_('FPSS_GROUP'): JHTML::_('grid.sort', 'FPSS_GROUP', 'groupname', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'FPSS_EMAIL', 'a.email', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      	<th><?php echo JHTML::_('grid.sort', 'FPSS_ID', 'id', @$this->filters['orderingDir'], @$this->filters['ordering'] ); ?></th>
      </tr>
    </thead>
    <tbody>
	<?php foreach($this->rows as $key=>$row): ?>
	      <tr class="row<?php echo (($key+1)%2); ?>">
	        <td><?php echo $key+1; ?></td>
			<td><a href="#" onclick="window.parent.jSelectUser('<?php echo $row->id?>', '<?php echo JString::str_ireplace(array("'", "\""), array("\\'", ""), $row->name); ?>');"><?php echo $row->name; ?></a> </td>
			<td><?php echo $row->username; ?></td>
			<td class="fpssCenter">
			<?php if ($row->block): ?>
				<img src="images/publish_x.png" alt="<?php echo JText::_('FPSS_USER_IS_DISABLED'); ?>"/>
			<?php else: ?>
				<img src="images/tick.png" alt="<?php echo JText::_('FPSS_USER_IS_ENABLED'); ?>"/>
			<?php endif; ?>
			</td>
			<td><?php echo $row->groupname; ?></td>
			<td><?php echo $row->email; ?></td>
			<td class="fpssCenter"><?php echo $row->id; ?></td>
	      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
      </tr>
    </tfoot>
  </table>
  <input type="hidden" name="option" value="com_fpss" />
  <input type="hidden" name="view" value="extension" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?php echo $this->filters['ordering']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filters['orderingDir']; ?>" />
  <input type="hidden" name="task" value="com_users" />
  <?php echo JHTML::_('form.token'); ?>
</form>