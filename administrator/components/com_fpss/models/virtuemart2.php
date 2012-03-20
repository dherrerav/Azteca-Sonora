<?php
/**
 * @version		$Id: virtuemart2.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelVirtuemart2 extends JModel {

	function getData() {
		$db = & $this->getDBO();
		$query = "SELECT #__vm_category.category_name,#__vm_product.product_id,#__vm_product.product_name,#__vm_product.product_sku, #__vm_product.published AS product_publish";
		$query.= " FROM #__vm_product, #__vm_product_category_xref, #__vm_category WHERE ";
		$query .= " #__vm_category.category_id=#__vm_product_category_xref.category_id ";
		$query .= "AND #__vm_product.product_id=#__vm_product_category_xref.product_id ";
		$query .= "AND #__vm_product.product_parent_id=0 ";
		$conditions = array();
		if ($this->getState('published')) {
			$state = ($this->getState('published') == 'Y')?1:0;
			$conditions[]= "#__vm_product.published = ".$state;
		}
		if ($this->getState('catid')) {
			$conditions[]= "#__vm_product_category_xref.category_id=".$this->getState('catid');
		}
		if ($this->getState('search')) {
			$conditions[]= "(LOWER(#__vm_product.product_name) LIKE ".$db->Quote("%".$db->getEscaped($this->getState('search'), true)."%", false)." OR #__vm_product.product_sku = ".$db->Quote($this->getState('search')).")";
		}
		if (count($conditions)) {
			$query.= " AND ".implode(' AND ', $conditions);
		}
		$query .= " ORDER BY ".$this->getState('ordering')." ".$this->getState('orderingDir');
		$db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getTotal() {
		$db = & $this->getDBO();
		$query = "SELECT COUNT(#__vm_product.product_id) ";
		$query.= " FROM #__vm_product, #__vm_product_category_xref, #__vm_category WHERE ";
		$query .= " #__vm_category.category_id=#__vm_product_category_xref.category_id ";
		$query .= "AND #__vm_product.product_id=#__vm_product_category_xref.product_id ";
		$query .= "AND #__vm_product.product_parent_id='' ";
		$conditions = array();
		if ($this->getState('published')) {
			$state = ($this->getState('published') == 'Y')?1:0;
			$conditions[]= "#__vm_product.published = ".$state;
		}
		if ($this->getState('catid')) {
			$conditions[]= "#__vm_product_category_xref.category_id=".$this->getState('catid');
		}
		if ($this->getState('search')) {
			$conditions[]= "(LOWER(#__vm_product.product_name) LIKE ".$db->Quote("%".$db->getEscaped($this->getState('search'), true)."%", false)." OR #__vm_product.product_sku = ".$db->Quote($this->getState('search')).")";
		}
		if (count($conditions)) {
			$query.= " AND ".implode(' AND ', $conditions);
		}
		$db->setQuery($query);
		$total = $db->loadresult();
		return $total;
	}

	function getCategories() {
		require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
		require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctions.php');
		JRequest::setVar('filter_order', 'c.ordering');
		JRequest::setVar('filter_order_Dir', 'ASC');
		$list = ShopFunctions::categoryListTree(array($this->getState('catid')));
		return '<select onchange="this.form.submit();" id="catid" name="catid">'.$list.'</select>';
	}
}
