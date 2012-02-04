<?php

/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 * */
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModelcategory extends JModel {

    function getcategory() {

        global $option, $mainframe;
         $mainframe = JFactory::getApplication();
        $total = 0;
        $filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'asc', 'word');
        $filter_id = $mainframe->getUserStateFromRequest($option . 'filter_id', 'filter_id', '', 'int');
$option = 'com_contushdvideoshare';
        // page navigation
        $limit = $mainframe->getUserStateFromRequest($option . '.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
        $db = & JFactory::getDBO();
        $query = "SELECT count(*) FROM #__hdflv_category ";
        $db->setQuery($query);
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);

        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;
        if ($filter_order) {
            $query = "select * from #__hdflv_category where parent_id <> -1 order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit";
        } else {
            $query = "select * from #__hdflv_category where parent_id <> -1";
        }

        $db->setQuery($query);
        $categorylist = $db->loadObjectList();
        if ($filter_order) {
            $db->setQuery("SELECT * from #__hdflv_category where parent_id=-1 order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit");
        } else {
            $db->setQuery("SELECT * from #__hdflv_category where parent_id=-1");
        }
        $category = $db->loadObjectList();
        if ($category === null)
            JError::raiseError(500, 'Error reading db');

        return array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'lists' => $lists, 'category' => $category, 'categorylist' => $categorylist);
    }

    function getcategary($id) {
        $query = ' SELECT * FROM #__hdflv_category WHERE id = ' . $id;
        $db = $this->getDBO();
        $db->setQuery($query);
        $categary = $db->loadObject();


        $query = "select * from #__hdflv_category where parent_id = -1 order by category asc";
        $db->setQuery($query);
        $categorylist = $db->loadObjectList();

        if ($categary === null)
            JError::raiseError(500, 'detail with ID: ' . $id . ' not found.');
        else
            return array($categary, $categorylist);
    }

    function getNewcategary() {
        $db = $this->getDBO();

        $query = "select * from #__hdflv_category where parent_id = -1 order by category asc";
        $db->setQuery($query);
        $categorylist = $db->loadObjectList();
        $detailTableRow = & $this->getTable('category');
        $detailTableRow->id = 0;
        $detailTableRow->category = '';
        $detailTableRow->published = '';
        return array($detailTableRow, $categorylist);
    }

    function savecategary($detail) {

        $detailTableRow = & $this->getTable('category');

        //code for seo category name
        $seo_category = $detail['category'];
        $seo_category = preg_replace('/[&:\s]+/i','-',$seo_category);
        $detail['seo_category'] = preg_replace('/[\"\']+/i','',$seo_category);

        if (!$detailTableRow->bind($detail)) {
            JError::raiseError(500, 'Error binding data');
        }
        if (!$detailTableRow->check()) {
            JError::raiseError(500, 'Invalid data');
        }
        if (!$detailTableRow->store()) {
            $errorMessage = $detailTableRow->getError();
            JError::raiseError(500, 'Error binding data: ' . $errorMessage);
        }
    }

    function deletecategary($arrayIDs) {
//        echo $arrayIDs;
//        exit;

        $n = count($arrayIDs);

        for ($i = 0; $i < $n; $i++) {
            $query = "DELETE FROM #__hdflv_category WHERE id=" . $arrayIDs[$i];

            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
//		if (!$db->query()){
//			$errorMessage = $this->getDBO()->getErrorMsg();
//			JError::raiseError(500, 'Error deleting category: '.$errorMessage);
//		}
    }

    function pubcategary($arrayIDs) {
        echo $arrayIDs['task'];
        if ($arrayIDs['task'] == "publish") {
            $publish = 1;
        } else {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
//        exit;
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__hdflv_category set published=" . $publish . " WHERE id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
            $query = "UPDATE #__hdflv_upload set published=" . $publish . " WHERE playlistid=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }

}

?>
