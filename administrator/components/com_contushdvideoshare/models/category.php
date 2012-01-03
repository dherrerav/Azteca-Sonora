<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        category.php
 * @location    /components/com_contushdvideosahre/models/category.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    category Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModelcategory extends JModel {

    function __construct() {
        parent::__construct();
        //Get configuration
        $app = JFactory::getApplication();
        $config = JFactory::getConfig();
        // Get the pagination request variables
        $this->setState('limit', $app->getUserStateFromRequest('category.limit', 'limit', $config->get('list_limit'), 'int'));
        $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
    }

    function getcategory() {
        global $option, $mainframe;
        $option = "com_contushdvideoshare";
        $app = & JFactory::getApplication();
        $total = 0;
        $filter_order = $app->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'asc', 'word');
        $filter_ordering = $app->getUserStateFromRequest($option . 'filter_ordering', 'filter_ordering', '', 'int');
        $search = $app->getUserStateFromRequest($option . 'search', 'search', '', 'string');
        // page navigation
        $db = & JFactory::getDBO();
        $query = "SELECT count(*) FROM #__hdflv_category ";
        $db->setQuery($query);
        $total = $db->loadResult();
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $this->getState('limitstart'), $this->getState('limit'));
        if ($filter_ordering) {
            $query = "SELECT * from #__hdflv_category";
            $db->setQuery($query);
            $category = $db->loadObjectList();
        }
        if ($filter_order) {
            $db->setQuery("SELECT * from #__hdflv_category where parent_id=-1 order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit");
        } else {
            $db->setQuery("SELECT * from #__hdflv_category where parent_id=-1");
        }
        $category = $db->loadObjectList();
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;
        // search filter
        if ($search) {
            $query = "SELECT * FROM #__hdflv_category where category LIKE '%$search%'";
            $db->setQuery($query);
            $category = $db->loadObjectList();
            $lists['search'] = $search;
        }
        if ($filter_order) {
            $query = "select * from #__hdflv_category where parent_id <> -1 order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit";
        } else {
            $query = "select * from #__hdflv_category where parent_id <> -1";
        }
        $db->setQuery($query);
        $categorylist = $db->loadObjectList();

        if ($category === null)
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['ordering'] = JHTML::_('list.category', 'filter_ordering', 'com_contushdvideoshare', (int) $rs_showorder, $javascript);
        return array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'lists' => $lists, 'rs_showadslistname' => $rs_showorder, 'category' => $category, 'categorylist' => $categorylist, 'searchlist' => $searchlist);
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
        // check the same category already exist or not
        $db = $this->getDBO();
        $query = "select category from #__hdflv_category where category ='" . $detail[category] . "'";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if ($result) {
            echo '<script type="text/javascript"> alert(" Categoryalready exist"); </script>';
            $msg = "Category already exist.. Cannot save category..";
        } else {
            // binding the value to tables
            $detailTableRow = & $this->getTable('category');
            if (!$detailTableRow->bind($detail)) {
                JError::raiseError(500, 'Error binding data');
            }
            if (!$detailTableRow->checkin()) {
                JError::raiseError(500, 'Invalid data');
            }
            if (!$detailTableRow->store()) {
                $errorMessage = $detailTableRow->getError();
                JError::raiseError(500, 'Error binding data: ' . $errorMessage);
            }
            $msg = "caetgory saved successfully";
        }
        $link = 'index.php?option=com_contushdvideoshare&layout=category';
        JFactory::getApplication()->redirect($link, $msg);
    }

    function deletecategary($arrayIDs) {
        $n = count($arrayIDs);
        for ($i = 0; $i < $n; $i++) {
            $query = "DELETE FROM #__hdflv_category WHERE id=" . $arrayIDs[$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }

    function pubcategary($task) {
        $tblname = "";
        $taskname = "";
        $option = 'com_contushdvideoshare';
        global $mainframe;
        //$cid = $task['task'];//JRequest::getVar( 'cid', array(), '', 'array' );
        $n = count($task['cid']);
        $taskname = JRequest::getvar('task', '', 'get', 'var');
        if ($task['task'] == 'publish') {
            $publish = 1;
            $msg = 'Published successfully';
        } else {
            $publish = 0;
            $msg = 'Un Published successfully';
        }
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__hdflv_category set published=" . $publish . " WHERE id=" . $task['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
        $link = 'index.php?option=com_contushdvideoshare&layout=category';
        JFactory::getApplication()->redirect($link, $msg);
    }

}

?>
