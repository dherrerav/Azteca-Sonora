<?php
/**
 * @version		$Id: users.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelUsers extends JModel {

	function getData() {
		$db = & $this->getDBO();
		$query = "SELECT a.*, g.name AS groupname FROM #__users AS a 
		INNER JOIN #__core_acl_aro AS aro ON aro.VALUE = a.id 
		INNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.id 
		INNER JOIN #__core_acl_aro_groups AS g ON g.id = gm.group_id";
		$conditions = array();
		if ($this->getState('group')) {
			$conditions[]= "a.gid = ".(int)$this->getState('group');
		}
		if ($this->getState('search')) {
			$conditions[]= "LOWER(a.name) LIKE ".$db->Quote("%".$db->getEscaped($this->getState('search'), true)."%", false) ;
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		$query .= " GROUP BY a.id ORDER BY ".$this->getState('ordering')." ".$this->getState('orderingDir');
		$db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getTotal() {
		$db = & $this->getDBO();
		$query = "SELECT COUNT(a.id) FROM #__users AS a";
		$conditions = array();
		if ($this->getState('group')) {
			$conditions[]= "a.gid = ".(int)$this->getState('group');
		}
		if ($this->getState('search')) {
			$conditions[]= "LOWER(a.name) LIKE ".$db->Quote("%".$db->getEscaped($this->getState('search'), true)."%", false) ;
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		$db->setQuery($query);
		$total = $db->loadresult();
		return $total;
	}
	
	function getUserGroups(){
		$db = & $this->getDBO();
		$query = "SELECT id AS value, name AS text FROM #__core_acl_aro_groups 
		WHERE name != 'ROOT' AND name != 'USERS'";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
}
