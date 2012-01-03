<?php
defined('_JEXEC') or die('Restricted access');

class modMostReadContentHelper {
	public function getItems(&$params) {
		global $mainframe;
		// get a reference to the database
		$db							=& JFactory::getDBO();
		$user						=& JFactory::getUser();
		$componentused  = trim($params->get('componentused', 'com_content'));
		$count		    	= intval($params->get('count', 5));
		$menuid		    	= intval($params->get('itemidmenu'), 0);
		$username				= trim($params->get('username', 'name'));
		$adminflag			= intval($params->get('adminarticles', 0));
		$frontpage			= intval($params->get('frontpagearticles', 0));
		$incl_excl      = intval($params->get('incl_excl', '1'));
		$sec_cat_ids		= trim($params->get('sec_cat_ids', ',^,'));
		$aid	   	    	= $user->get('aid', 0);
		$nullDate				= $db->getNullDate();
		$listtype				= intval($params->get('listtype', 1));
		$mostreadtime		= intval($params->get('mostreadtime', 90));
		$date =& JFactory::getDate();
		$now  = $date->toMySQL();

		$where = '';
		if(preg_match('/^[0-9\^\,]*$/', $sec_cat_ids)){
			$sec_cats = explode("^",$sec_cat_ids);
			$sections = substr($sec_cats[0], 1, strlen($sec_cats[0])-2);
			$categories = substr($sec_cats[1], 1, strlen($sec_cats[1])-2);
			$where = '';
			if(strlen($sections) > 0){
				$where = ' AND a.sectionid ' . (($incl_excl == '0')?'NOT':'') . ' IN (' . $sections . ')';
			}
			if(strlen($categories) > 0){
				$where = ' AND a.catid ' . (($incl_excl == '0')?'NOT':'') . ' IN (' . $categories . ')';
			}
		}

		$orderby = '';
		switch($listtype){
			case 1:
				//Latest Articles
				$orderby = ' ORDER BY a.created DESC';
				break;
			case 2:
				//Oldest Articles
				$orderby = ' ORDER BY a.created ASC';
				break;
			case 3:
				//Most Read
				$orderby = ' ORDER BY a.hits DESC';
				break;
			case  4:
				//Most Read In Time
				$orderby = ' ORDER BY a.hits DESC';
				$where .= ' AND a.created >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $mostreadtime . ' DAY)';
				break;
			case 5:
				//Last Modified
				$orderby = ' ORDER BY a.modified DESC';
				break;
		}
		$query = 'SELECT a.id, a.alias, a.title, cc.title as category,'.
				 ' u.'. $username .' as author, cc.access AS cat_access, cc.published AS cat_state,'.
				 ' a.hits,' .
				 ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
				 ' CASE WHEN CHAR_LENGTH(cc.title) THEN CONCAT_WS(":", cc.id, cc.title) ELSE cc.id END as catslug'.
				 ' FROM #__content AS a' .
				 ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' .
				 ' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
				 ' LEFT JOIN #__users AS u ON u.id = a.created_by' .
				 ' WHERE a.state > 0' . $where .
				 ' AND a.access <= ' .(int) $user->get('aid', 0) .
				 ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )' .
				 ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' .
				 ($frontpage == '0' ? ' AND f.content_id IS NULL' : '') . $orderby;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();
		var_dump($query);
		$i = 0;
		if($rows) {
			for($i=0; $i<count($rows);$i++) {
				if (($rows[$i]->cat_state == 1 || $rows[$i]->cat_state == '') && ($rows[$i]->cat_access <= $user->get('aid', 0) || $rows[$i]->cat_access == '')) {
	  				$rows[$i]->href = JRoute::_(ContentHelperRoute::getArticleRoute($rows[$i]->slug, $rows[$i]->catslug));
				}
			}
		} else {
			$rows = Array();
		}
		return $rows;
	}
}