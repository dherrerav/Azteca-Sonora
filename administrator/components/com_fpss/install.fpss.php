<?php
/**
 * @version		$Id: install.fpss.php 613 2011-08-01 21:22:26Z joomlaworks $
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

// Set some variables
$status = new JObject();
$status->modules = array();
$src = $this->parent->getPath('source');

if(version_compare( JVERSION, '1.6.0', 'ge' )) {

	$modules = &$this->manifest->xpath('modules/module');
	foreach($modules as $module){
		$mname = $module->getAttribute('module');
		$client = $module->getAttribute('client');
		if(is_null($client)) $client = 'site';
		($client=='administrator')? $path=$src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
		$installer = new JInstaller;
		$result = $installer->install($path);
		$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
	}
	
}
else {

	$modules = &$this->manifest->getElementByPath('modules');
	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {
		foreach ($modules->children() as $module) {
			$mname = $module->attributes('module');
			$client = $module->attributes('client');
			if(is_null($client)) $client = 'site';
			($client=='administrator')? $path=$src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
			$installer = new JInstaller;
			$result = $installer->install($path);
			$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
		}
	}


}


// Publish the statistics module
$db = & JFactory::getDBO();
$query = "UPDATE #__modules SET position='icon', ordering='100', published=1 WHERE module='mod_fpss_stats'";
$db->setQuery($query);
$db->query();
// For Joomla! 1.6 we also need to assign the pages to "All"
if(version_compare( JVERSION, '1.6.0', 'ge' )) {
	$query = "SELECT id FROM #__modules WHERE module = 'mod_fpss_stats'";
	$db->setQuery($query);
	$id = (int)$db->loadResult();
	$query = "INSERT IGNORE INTO #__modules_menu (moduleid, menuid) VALUES({$id}, 0)";
	$db->setQuery($query);
	$db->query();
}


if (JFolder::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements')){

	if(version_compare( JVERSION, '1.6.0', 'ge' )) {
		$elements = &$this->manifest->xpath('joomfish/file');
		foreach ($elements as $element) {
			JFile::copy($src.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data(),JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data());
		}
	}
	else {
		$elements = &$this->manifest->getElementByPath('joomfish');
		if (is_a($elements, 'JSimpleXMLElement') && count($elements->children())) {
			foreach ($elements->children() as $element) {
				JFile::copy($src.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data(),JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.$element->data());
			}
		}
	}

} 
else {
	$mainframe = &JFactory::getApplication();
	$mainframe->enqueueMessage(JText::_('FPSS_JOOMFISH_NOTICE'));
}

// Install sample data
$query = "SELECT COUNT(*) FROM #__fpss_slides";
$db->setQuery($query);
$numOfSlides=$db->loadResult();

$query = "SELECT COUNT(*) FROM #__fpss_categories";
$db->setQuery($query);
$numOfCategories=$db->loadResult();

if($numOfSlides == 0 && $numOfCategories == 0){
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'tables');
	JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models');
	$model = &JModel::getInstance('slides', 'FPSSModel');
	$model->import();
}
?>

<?php $rows = 0; ?>
<h2><?php echo JText::_('FPSS_INSTALLATION_STATUS'); ?></h2>
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
			<td><strong><?php echo JText::_('FPSS_INSTALLED'); ?></strong></td>
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
			<td><strong><?php echo ($module['result'])?JText::_('FPSS_INSTALLED'):JText::_('FPSS_NOT_INSTALLED'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
