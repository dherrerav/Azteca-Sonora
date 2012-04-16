<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
function com_uninstall(){
	$uninstallClass = new acymailingUninstall();
	$uninstallClass->unpublishModules();
	$uninstallClass->message();
}
class acymailingUninstall{
	var $db;
	function acymailingUninstall(){
		$this->db =& JFactory::getDBO();
	}
	function message(){
		?>
		You uninstalled the AcyMailing component.<br/>
		AcyMailing also unpublished the modules attached to the component.<br/><br/>
		If you want to completely uninstall AcyMailing, please select all the AcyMailing modules and plugins and uninstall them from the Joomla Extensions Manager.<br/>
		Then execute this query via phpMyAdmin to remove all AcyMailing data:<br/><br/>
		DROP TABLE <?php
		$this->db->setQuery("SHOW TABLES LIKE '".$this->db->getPrefix()."acymailing%' ");
		echo implode(' , ',$this->db->loadResultArray());
		?>;<br/><br/>
		If you don't execute the query, you will be able to install AcyMailing again without loosing data.<br/>
		Please note that you don't have to uninstall AcyMailing to install a new version, simply install the new one without uninstalling your current version.
		<?php
	}
	function unpublishModules(){
		$this->db->setQuery("UPDATE `#__modules` SET `published` = 0 WHERE `module` LIKE '%acymailing%'");
		$this->db->query();
	}
}