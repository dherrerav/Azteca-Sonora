<?php
/**
 * @version		$Id: uninstall.fpss.php 613 2011-08-01 21:22:26Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');

// Load language file
$lang = &JFactory::getLanguage();
$lang->load('com_fpss');

$status = new JObject();
$status->modules = array ();

if(version_compare( JVERSION, '1.6.0', 'ge' )) {
	$modules = & $this->manifest->xpath('modules/module');
	foreach($modules as $module){
		$mname = $module->getAttribute('module');
		$client = $module->getAttribute('client');
		$db = & JFactory::getDBO();
		$query = "SELECT `extension_id` FROM `#__extensions` WHERE `type`='module' AND element = ".$db->Quote($mname)."";
		$db->setQuery($query);
		$IDs = $db->loadResultArray();
		if (count($IDs)) {
			foreach ($IDs as $id) {
				$installer = new JInstaller;
				$result = $installer->uninstall('module', $id);
			}
		}
		$status->modules[] = array ('name'=>$mname, 'client'=>$client, 'result'=>$result);
	}

	if (JFolder::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements')){
		$elements = &$this->manifest->xpath('joomfish/files');
		if (is_a($elements, 'JSimpleXMLElement') && count($elements->children())) {
			foreach ($elements->children() as $element) {
				if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data()))
				JFile::delete(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data());
			}
		}
	}
	
}
else {


	$modules = & $this->manifest->getElementByPath('modules');

	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {

		foreach ($modules->children() as $module) {

			$mname = $module->attributes('module');
			$client = $module->attributes('client');
			$db = & JFactory::getDBO();
			$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$modules = $db->loadResultArray();
			if (count($modules)) {
				foreach ($modules as $module) {
					$installer = new JInstaller;
					$result = $installer->uninstall('module', $module, 0);
				}
			}
			$status->modules[] = array ('name'=>$mname, 'client'=>$client, 'result'=>$result);
		}
	}

	if (JFolder::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements')){
		$elements = &$this->manifest->getElementByPath('joomfish/files');
		if(is_array($elements)) {
			foreach ($elements as $element) {
				if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data()))
				JFile::delete(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data());
			}
		}
		
	}

}

?>
<?php $rows = 0; ?>
<h2><?php echo JText::_('FPSS_REMOVAL_STATUS'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('FPSS_EXTENSION'); ?></th>
			<th width="30%"><?php echo JText::_('FPSS_STATUS'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'FPSS '.JText::_('FPSS_COMPONENT'); ?></td>
			<td><strong><?php echo JText::_('FPSS_REMOVED'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('FPSS_MODULE'); ?></th>
			<th><?php echo JText::_('FPSS_CLIENT'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('FPSS_REMOVED'):JText::_('FPSS_NOT_REMOVED'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

