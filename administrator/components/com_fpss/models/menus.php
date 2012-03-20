<?php
/**
 * @version		$Id: menus.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelMenus extends JModel {

	function getData() {
		$db = & $this->getDBO();
		$query = "SELECT * FROM #__menu ";
		$conditions = array();
		if ($this->getState('published')!=-1) {
			$conditions[]= "published = ".$this->getState('published');
		}
		if ($this->getState('search')) {
			$conditions[]= "LOWER(name) LIKE ".$db->Quote("%".$db->getEscaped($this->getState('search'), true)."%", false);
		}
		if ($this->getState('menuType')) {
			$conditions[]= "menutype = ".$db->Quote($this->getState('menuType'));
		}
		if(version_compare( JVERSION, '1.6.0', 'ge' )){
			$conditions[]= "client_id = 0 AND id!=1";
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		$query .= " ORDER BY ".$this->getState('ordering')." ".$this->getState('orderingDir');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$menuItems = array();
		if ($this->getState('search')) {
			foreach ($rows as $row) {
				$row->treename = $row->name;
				$menuItems[]=$row;
			}
		}
		else {
			$children = array ();
			if(count($rows)){
				foreach ($rows as $v) {
					if(version_compare( JVERSION, '1.6.0', 'ge' )){
						$v->parent = $v->parent_id;
						$v->name = $v->title;
						if($v->parent==1) {
							$v->parent = 0;
						}
					}
					$pt = $v->parent;
					$list = @$children[$pt]?$children[$pt]: array ();
					array_push($list, $v);
					$children[$pt] = $list;
				}
			}
			$menuItems = JHTML::_('menu.treerecurse', 0, '', array (), $children);
		}
		if($this->getState('limit')) {
			$menuItems = @array_slice($menuItems, $this->getState('limitstart'), $this->getState('limit'));
		}
		$result = new JObject();
		$result->rows = $menuItems;
		$result->total = count($rows);
		return $result;
	}

	function getMenuTypes() {
		$db = & $this->getDBO();
		$query = "SELECT menutype AS `value`, title AS `text` FROM #__menu_types";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
}
