<?php
/**
 * @version		$Id: default.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="clr"></div>
<div id="fpssModule">
	<div id="fpssModuleTitle">
		<a href="index.php?option=com_fpss" title="<?php echo JText::_('COM_FPSS'); ?>">
			<span><?php echo JText::_('COM_FPSS'); ?></span>
		</a>
	</div>
	<div id="fpssModuleFilters">
		<form name="fpssModuleForm" id="fpssModuleForm" method="post" action="<?php echo JRoute::_('index.php'); ?>">
			<?php echo $categoryFilter; ?>
			<select name="fpssModuleTimeRange" id="fpssModuleTimeRange">
				<option value=""><?php echo JText::_('FPSS_SELECT_TIME_RANGE'); ?></option>
				<option value="7"><?php echo JText::_('FPSS_1_WEEK'); ?></option>
				<option value="14"><?php echo JText::_('FPSS_2_WEEKS'); ?></option>
				<option value="30"><?php echo JText::_('FPSS_4_WEEKS'); ?></option>
				<option value="90"><?php echo JText::_('FPSS_3_MONTHS'); ?></option>
				<option value="180"><?php echo JText::_('FPSS_6_MONTHS'); ?></option>
				<option value="365"><?php echo JText::_('FPSS_12_MONTHS'); ?></option>
			</select>
			<select name="fpssModuleLimit" id="fpssModuleLimit">
				<option value=""><?php echo JText::_('FPSS_SELECT_MAXIMUM_NUMBER_OF_SLIDES'); ?></option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
			</select>
			<input type="hidden" name="option" value="com_fpss" />
			<input type="hidden" name="view" value="slides" />
			<input type="hidden" name="task" value="stats" />
		</form>
	</div>
	<div class="clr"></div>
	<div id="fpssChart"></div>
	<?php if(!$componentParams->get('stats', 1)):?>
	<span class="fpssNote"><?php echo JText::_('FPSS_STATISTICS_ARE_DISABLED');?></span>
	<?php endif; ?>
	<div class="clr"></div>
</div>
<div class="clr"></div>



