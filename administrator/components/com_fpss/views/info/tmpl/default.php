<?php
/**
 * @version		$Id: default.php 41 2010-09-09 12:10:00Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm">
	<table cellpadding="0" cellspacing="0" border="0" id="fpssInfoPage">
		<tr>
			<td>
			  <fieldset class="adminform">
			    <legend><?php echo JText::_('FPSS_SYSTEM_INFORMATION'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('FPSS_CHECK'); ?></th>
			          <th><?php echo JText::_('FPSS_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_WEB_SERVER'); ?></strong></td>
			          <td><?php echo $this->server; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_PHP_VERSION'); ?></strong></td>
			          <td><?php echo $this->php_version; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_MYSQL_VERSION'); ?></strong></td>
			          <td><?php echo $this->db_version; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_GD_IMAGE_LIBRARY'); ?></strong></td>
			          <td><?php if ($this->gd_check) {$gdinfo=gd_info(); echo $gdinfo["GD Version"];} else echo JText::_('FPSS_DISABLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_UPLOAD_LIMIT'); ?></strong></td>
			          <td><?php echo ini_get('upload_max_filesize'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('FPSS_MEMORY_LIMIT'); ?></strong></td>
			          <td><?php echo ini_get('memory_limit'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>
			</td>
			<td>
			  <fieldset class="adminform">
			    <legend><?php echo JText::_('FPSS_DIRECTORY_PERMISSIONS'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('FPSS_CHECK'); ?></th>
			          <th><?php echo JText::_('FPSS_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong>media/com_fpss</strong></td>
			          <td><?php if ($this->media_folder_check) echo JText::_('FPSS_WRITABLE'); else echo JText::_('FPSS_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>cache</strong></td>
			          <td><?php if ($this->cache_folder_check) echo JText::_('FPSS_WRITABLE'); else echo JText::_('FPSS_NOT_WRITBLE'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>	
			  <fieldset class="adminform">
			    <legend><?php echo JText::_('FPSS_MODULES'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('FPSS_CHECK'); ?></th>
			          <th><?php echo JText::_('FPSS_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong>mod_fpss</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_fpss')))?JText::_('FPSS_NOT_INSTALLED'):JText::_('FPSS_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_fpss_stats</strong> (<?php echo JText::_('FPSS_ADMINISTRATOR'); ?>)</td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_fpss'))) ? JText::_('FPSS_NOT_INSTALLE') : JText::_('FPSS_INSTALLED'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>	
			</td>
		</tr>
	</table>
</form>
