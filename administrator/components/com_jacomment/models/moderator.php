<?php
defined ( '_JEXEC' ) or die ();
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
jimport ( 'joomla.application.component.model' );

class JACommentModelModerator extends JModel {

	function __construct() {
		parent::__construct ();
	}

	function getTotal($where_more = '', $joins = '') {
		$db = JFactory::getDBO ();
		
		$query = "SELECT count(u.id) FROM #__users as u" . "\n  $joins" . "\n WHERE 1=1 $where_more";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getItems($where="",$limit = 100, $limitStart=0) {
		$db = JFactory::getDBO ();						
		$order = ' u.id';						
		$fields = 'u.*';																
								
		$sql = 'SELECT a.*,COUNT(map.group_id) AS group_count,GROUP_CONCAT(g2.title SEPARATOR '.$db->Quote("\n").') AS group_names'
				. ' FROM `#__users` AS a'
				. ' LEFT JOIN #__user_usergroup_map AS map'
				. ' ON map.user_id = a.id'
				. ' LEFT JOIN #__usergroups AS g2'
				. ' ON g2.id = map.group_id'
				. ' LEFT JOIN #__user_usergroup_map AS map2'
				. ' ON map2.user_id = a.id'
				. ' WHERE 1=1'.$where
				. ' GROUP BY a.id'
				. ' ORDER BY a.name asc'
				. ' LIMIT '.$limitStart.', '.$limit;
										
		$db->setQuery ( $sql ); //echo $db->getQuery ( $sql ), '<br>';
		return $db->loadObjectList ();
	}
	
	function parse(&$items){
		$count=count($items);
		if($count>0){
			for($i=0;$i<$count;$i++){
				$item = & $items[$i];
				$params = new JRegistry;
		        $params->loadJSON($item->params);
				$item->params=$params;
			}
		}
	}
	
	function getItem($cid = array(0)) {
		
		$edit = JRequest::getVar ( 'edit', true );
		if (! $cid || @! $cid [0]) {
			$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		
		}
		$this->_getTable ();
		JArrayHelper::toInteger ( $cid, array (0 ) );
		if ($edit) {
			$this->_table->load ( $cid [0] );
		}
		
		return $this->_table;
	}
	
	function _getVars() {
		$app = JFactory::getApplication();		
		$option = 'moderator';
		
		$app = JFactory::getApplication('administrator');
		
		$list = array ();
		$list ['filter_order'] = $app->getUserStateFromRequest ( $option . '.filter_order', 'filter_order', 'u.username', 'cmd' );
		
		$list ['filter_order_Dir'] = $app->getUserStateFromRequest ( $option . '.filter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$list ['limit'] = $app->getUserStateFromRequest ( $option . 'list_limit', 'limit', $app->getCfg ( 'list_limit' ), 'int' );
		
		$list ['limitstart'] = $app->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
				
		
		$list ['group'] = $app->getUserStateFromRequest ( $option . '.group', 'group', 'moderator', 'string' );
		
		return $list;
	}
}

?>