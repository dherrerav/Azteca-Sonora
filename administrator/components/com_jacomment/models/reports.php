<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.model' );

class JACommentModelReports extends JModel {
	var $_table = null;
	
	function __construct() {
		parent::__construct ();
	}
	/**
	 * Get configuration item
	 * @return Table object
	 */
	function &_getTable() {
		if ($this->_table == null) {
			$this->_table = &JTable::getInstance ( 'comments', 'Table' );
		}
		return $this->_table;
	}
	/**
	 * Get configuration item
	 * @return Table object
	 */
	
	function getItem($id = 0) {
		static $item;
		if (isset ( $item )) {
			return $item;
		}
		if (! $id) {
			$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
			JArrayHelper::toInteger ( $cid, array (0 ) );
			
			if (isset ( $cid [0] ) && $cid [0] > 0) {
				$id = $cid [0];
			}
		}
		$this->_getTable ();
		
		if ($id) {
			$this->_table->load ( $id );
		}
		
		return $this->_table;
	}
	
	function _getVars() {
		$app = JFactory::getApplication();
		$option = 'comments';
		$list = array ();
		$app = JFactory::getApplication('administrator');
		$list ['filter_order'] 		= $app->getUserStateFromRequest ( $option . '.filter_order', 'filter_order', 'c.ordering', 'cmd' );
		$list ['filter_order_Dir'] 	= $app->getUserStateFromRequest ( $option . '.filter_order_Dir', 'filter_order_Dir', '', 'word' );
		$list ['limit'] 			= $app->getUserStateFromRequest ( $option . 'list_limit', 'limit', $app->getCfg ( 'list_limit' ), 'int' );
		$list ['limitstart'] 		= $app->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
		$list ['search'] 			= $app->getUserStateFromRequest ( $option . '.search', 'search', '', 'string' );
		return $list;
	}
	
	function getWhereClause($lists) {
		//where clause 
		$where = array ();
		if ($lists ['search']) {
			if (is_numeric ( $lists ['search'] ))
				$where [] = " c.id ='" . $lists ['search'] . "' ";
			else
				$where [] = " c.title LIKE '%" . $lists ['search'] . "%' ";
		}
		$where = count ( $where ) ? " AND " . implode ( ' AND ', $where ) : '';
		Return $where;
	}
	
	function getItems($where = '', $groupby='', $orderby = '', $limitstart = 0, $limit = 0, $fields = '', $joins = '') {
		$db = JFactory::getDBO ();
		$query = " SELECT c.* ";
		if ($fields)
			$query .= " ,$fields ";
		$query .= " FROM #__jacomment as c ";
		if ($joins)
			$query .= " $joins ";
		$query .= " WHERE 1 $where ";
		if ($groupby)
			$query .= " GROUP BY $groupby ";
		if ($orderby)
			$query .= " ORDER BY $orderby ";
		if ($limit > 0)
			$query .= " LIMIT $limitstart,$limit ";
		
		$db->setQuery ( $query );

		return $db->loadObjectList ();
	}

	function getDyamicItems($where = '', $orderby = '', $limitstart = 0, $limit = 0, $fields = '', $joins = '') {
		$db = JFactory::getDBO ();
		$query='';		
		if ($fields)
			$query .= "SELECT $fields ";
		else 
			$query .= " SELECT c.* ";
			
		$query .= " FROM #__jacomment as c ";
		if ($joins)
			$query .= " $joins ";
		$query .= " WHERE 1 $where ";
		if ($orderby)
			$query .= " ORDER BY $orderby ";
		if ($limit > 0)
			$query .= " LIMIT $limitstart,$limit ";
		
		$db->setQuery ( $query );
	
		return $db->loadResultArray ();
	}
		
	function getTotal($where = '', $joins = '') {
		$db = & JFactory::getDBO ();
		$query = " SELECT COUNT(c.id) " . " FROM #__jacomment as c " . "\n  $joins" . " WHERE 1 $where ";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getTotalReports($commentid) {
		$db = & JFactory::getDBO ();
		$query = " SELECT COUNT(r.id) as total_reports " . " FROM #__jacomment_reports as r " . " WHERE commentid= '".$commentid."' ";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getOrdering($item) {
		$query = 'SELECT ordering AS value, title AS text' . ' FROM #__jacomment' . ' ORDER BY ordering';
		return JHTML::_ ( 'list.specificordering', $item, $item->id, $query );
	}
	function published($publish) {
		$db = & JFactory::getDBO ();
		
		$ids = JRequest::getVar ( 'cid', array () );
		$ids = implode ( ',', $ids );
		
		$query = "UPDATE #__jacomment" . " SET published = " . intval ( $publish ) . " WHERE id IN ( $ids )";
		$db->setQuery ( $query );
		if (! $db->query ()) {
			return false;
		}
		return true;
	}
	function dismiss($id){
		$db = & JFactory::getDBO ();
		
		$query = "DELETE FROM #__jacomment_reports WHERE commentid = '".intval($id)."'";
		$db->setQuery ( $query );
		if (! $db->query ()) {
			return false;
		}
		
		$query = "INSERT INTO #__jacomment_reported(commentid) VALUES( '".intval($id)."')";
		$db->setQuery ( $query );
		if (! $db->query ()) {
			return false;
		}			
		
		return true;
	}
	function dismiss_all() {
		$db = & JFactory::getDBO ();
		
		$ids = JRequest::getVar ( 'cid', array () );
		
		for($i=0; $i<sizeof($ids); $i++){
			$query = "DELETE FROM #__jacomment_reports WHERE commentid = '".intval($ids[$i])."'";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				return false;
			}
			
			$query2 = "INSERT INTO #__jacomment_reported(commentid) VALUES( '".intval($ids[$i])."')";
			$db->setQuery ( $query2 );
			if (! $db->query ()) {
				return false;
			}
		}		
		return true;
	}	
	function remove() {
		$db=JFactory::getDBO();
		$cids = JRequest::getVar ( 'cid', null, 'post', 'array' );
		$count = count ( $cids );
		$errors = array ();
		$is_fail=array();
		if ($count > 0) {
			foreach ( $cids as $cid ) {
				$query = "DELETE FROM #__jacomment WHERE id=$cid";
				$db->setQuery ( $query );
				if(!$db->query ()){
					$is_fail[]=$cid;
				}
			}
			if(count($is_fail)>0){
				$errors[]= "[ID: ".implode(',',$is_fail)."]".JText::_('FAILURE_TO_DELETE_COMMENT');
			}
		}
		return $errors;
	}
}

?>
