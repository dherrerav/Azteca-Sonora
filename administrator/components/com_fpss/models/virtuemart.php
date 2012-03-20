<?php
/**
 * @version		$Id: virtuemart.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelVirtuemart extends JModel {

	function getData() {
		$database = & $this->getDBO();
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php';
		$db = new ps_DB;
		$query = "SELECT #__{vm}_category.category_name,#__{vm}_product.product_id,#__{vm}_product.product_name,#__{vm}_product.product_sku,product_publish";
		$query.= " FROM #__{vm}_product, #__{vm}_product_category_xref, #__{vm}_category WHERE ";
		$query .= " #__{vm}_category.category_id=#__{vm}_product_category_xref.category_id ";
		$query .= "AND #__{vm}_product.product_id=#__{vm}_product_category_xref.product_id ";
		$query .= "AND #__{vm}_product.product_parent_id='' ";
		$conditions = array();
		if ($this->getState('published')) {
			$conditions[]= "#__{vm}_product.product_publish = ".$database->Quote($this->getState('published'));
		}
		if ($this->getState('catid')) {
			$conditions[]= "#__{vm}_product_category_xref.category_id=".$this->getState('catid');
		}
		if ($this->getState('search')) {
			$conditions[]= "(LOWER(#__{vm}_product.product_name) LIKE ".$database->Quote("%".$database->getEscaped($this->getState('search'), true)."%", false)." OR #__{vm}_product.product_sku = ".$database->Quote($this->getState('search')).")";
		}
		if (count($conditions)) {
			$query.= " AND ".implode(' AND ', $conditions);
		}
		$query .= " ORDER BY ".$this->getState('ordering')." ".$this->getState('orderingDir');
		$query .= " LIMIT ".$this->getState('limitstart').", ".$this->getState('limit');
		$db->query($query);
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getTotal() {
		$database = & $this->getDBO();
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php';
		$db = new ps_DB;
		$query = "SELECT COUNT(#__{vm}_product.product_id) ";
		$query.= " FROM #__{vm}_product, #__{vm}_product_category_xref, #__{vm}_category WHERE ";
		$query .= " #__{vm}_category.category_id=#__{vm}_product_category_xref.category_id ";
		$query .= "AND #__{vm}_product.product_id=#__{vm}_product_category_xref.product_id ";
		$query .= "AND #__{vm}_product.product_parent_id='' ";
		$conditions = array();
		if ($this->getState('published')) {
			$conditions[]= "#__{vm}_product.product_publish = ".$database->Quote($this->getState('published'));
		}
		if ($this->getState('catid')) {
			$conditions[]= "#__{vm}_product_category_xref.category_id=".$this->getState('catid');
		}
		if ($this->getState('search')) {
			$conditions[]= "(LOWER(#__{vm}_product.product_name) LIKE ".$database->Quote("%".$database->getEscaped($this->getState('search'), true)."%", false)." OR #__{vm}_product.product_sku = ".$database->Quote($this->getState('search')).")";
		}
		if (count($conditions)) {
			$query.= " AND ".implode(' AND ', $conditions);
		}
		$db->query($query);
		$total = $db->loadresult();
		return $total;
	}


	function getCategories($category_id="", $cid='0', $level='0', $selected_categories=Array(), $disabledFields=Array()) {
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php';
		$db = new ps_DB;
		static $rows = array();
		$level++;
		$query = "SELECT category_id, category_child_id,category_name FROM #__{vm}_category,#__{vm}_category_xref ";
		$query .= "WHERE #__{vm}_category_xref.category_parent_id='$cid' ";
		$query .= "AND #__{vm}_category.category_id=#__{vm}_category_xref.category_child_id ";
		$query .= "ORDER BY #__{vm}_category.list_order, #__{vm}_category.category_name ASC";
		$db->setQuery($query);
		$db->query();
		while ($db->next_record()) {
			$child_id = $db->f("category_child_id");
			if ($child_id != $cid) {
				$row = new JObject();
				$row->value = $child_id;
				$row->text = '';
				for ($i=0;$i<$level;$i++) {
					$row->text.= "&#151;";
				}
				$row->text.= "|$level|";
				$row->text.= "&nbsp;" . $db->f("category_name");
				$rows[]=$row;
			}
			$this->getCategories($category_id, $child_id, $level, $selected_categories, $disabledFields);
		}
		$option = new JObject();
		$option->value = 0;
		$option->text = JText::_('FPSS_ANY');
		array_unshift($rows, $option);
		return JHTML::_('select.genericlist', $rows, 'catid', 'onchange="this.form.submit();"', 'value', 'text', $this->getState('catid'));
	}
}
