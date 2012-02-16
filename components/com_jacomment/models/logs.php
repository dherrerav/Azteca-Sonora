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

class JACommentModelLogs extends JModel {
	var $_table = null;
	function __construct() {
		parent::__construct ();
	}
	
	function _getTable() {
		if ($this->_table == null) {
			$this->_table = &JTable::getInstance ( 'Logs', 'Table' );
		}
		return $this->_table;
	}
	
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
	
	function store($post = null) {
		$row = $this->getItem ();
				
		if (! $row->bind ( $post )) {
			JError::raiseWarning ( 1, $row->getError ( true ) );
			return false;
		}				
		
		if (! $row->store ()) {
			JError::raiseWarning ( 1, $row->getError ( true ) );
			return false;
		}
		
		return $row->id;
	}
	
	function getItemByUser($userID, $itemID) {
		$db = JFactory::getDBO ();
		
		$where_more = "AND l.userid = $userID AND l.itemid = $itemID";
		
		$sql = "SELECT l.* " . "\n FROM #__jacomment_logs as l " . "\n WHERE 1=1 $where_more";
		
		$db->setQuery ( $sql );
		return $db->loadObject ();
	}
	
	function updateReport($id, $report){ 
		$db = JFactory::getDBO ();			
		$sql = "UPDATE #__jacomment_logs SET reports=$report WHERE id=$id";			
		$db->setQuery ( $sql );
		$db->query ();				
	}
	
	function getItems($where_more = '', $limit = 10, $limitstart = 0, $order = '', $fields = '', $joins = '') {
		$db = JFactory::getDBO ();
		
		if (! $order) {
			$order = ' c.id';
		}
		
		if ($fields)
			$fields = "l.id";
		else
			$fields = 'c.*';
		
		$sql = "SELECT $fields " . "\n FROM #__jacomment_logs as l " . "\n $joins" . "\n WHERE 1=1 $where_more" . "\n ORDER BY $order " . "\n LIMIT $limitstart, $limit";
		
		$db->setQuery ( $sql );
		//die ($db->getQuery ( $sql ));;
		

		return $db->loadObjectList ();
	}
}
?>
