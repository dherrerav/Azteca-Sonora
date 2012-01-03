<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        memberdetails.php
 * @location    /components/com_contushdvideosahre/models/memberdetails.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Memberdetails Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelmemberdetails extends JModel {

    function __construct() {
        parent::__construct();
        //Get configuration
        $app = JFactory::getApplication();
        $config = JFactory::getConfig();
        // Get the pagination request variables
        $this->setState('limit', $app->getUserStateFromRequest('ads.limit', 'limit', $config->get('list_limit'), 'int'));
        $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
    }

    function getmemberdetails() {
        global $option, $mainframe;
        $option = 'com_contushdvideoshare';
        $app = & JFactory::getApplication();
        $db = $this->getDBO();
        $query = "SELECT * FROM #__hdflv_user";
        $db->setQuery($query);
        $allowupld = $db->loadObjectList();
        $db->setQuery('SELECT a.*,b.allowupload from #__users a left join #__hdflv_user b on a.id = b.member_id ');
        $memberdetails = $db->loadObjectList();
        if ($memberdetails === null)
            JError::raiseError(500, 'Error reading db');
        $filter_order = $app->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'Id', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
        $search = $app->getUserStateFromRequest($option . 'search', 'search', '', 'string');
        $db = & JFactory::getDBO();
        $query = "SELECT * FROM #__users";
        $db->setQuery($query);
        $memberdetails = $db->loadObjectList();
        $db = & JFactory::getDBO();
        $query = "SELECT count(*) FROM #__users";
        $db->setQuery($query);
        $total = $db->loadResult();
        $query = "SELECT count(*) FROM #__users";
        $db->setQuery($query);
        $total = $db->loadResult();
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $this->getState('limitstart'), $this->getState('limit'));
        if ($filter_order) {
            $query = "SELECT *from #__users order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit";
            $db->setQuery($query);
            $memberdetails = $db->loadObjectList();
        }
        // table ordering
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        // search filter
        if ($search) {
            $query = "SELECT * FROM #__users where name LIKE '%$search%'";
            $db->setQuery($query);
            $memberdetails = $db->loadObjectList();
            $lists['search'] = $search;
        }

        $javascript = 'onchange="document.adminForm.submit();"';
        $query = "SELECT allowupload from #__hdflv_site_settings";
        $db->setQuery($query);
        $settingupload = $db->loadObjectList();
        $memberdetails = array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'lists' => $lists, 'memberdetails' => $memberdetails, 'settingupload' => $settingupload, 'allowupld' => $allowupld);
        return $memberdetails;
    }

    function pubcategary($arrayIDs) {
        if ($arrayIDs['task'] == "publish") {
            $publish = 0;
        } else {
            $publish = 1;
        }
        $n = count($arrayIDs['cid']);
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__users set block=" . $publish . " WHERE usertype <> 'Super Users' and id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }

    function pubupload($arrayIDs) {
        if ($arrayIDs['task'] == "allowupload") {
            $publish = 1;
        } else {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
        for ($i = 0; $i < $n; $i++) {
            $query = "SELECT count(*) FROM #__hdflv_user where member_id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total != 0) {
                $query = "UPDATE #__hdflv_user set allowupload=" . $publish . " WHERE member_id=" . $arrayIDs['cid'][$i];
                $db = $this->getDBO();
                $db->setQuery($query);
                $db->query();
            } else {
                $idval = $arrayIDs['cid'][$i];
                $query = " insert into #__hdflv_user (member_id,allowupload) values ('$idval','$publish')";
                $db = $this->getDBO();
                $db->setQuery($query);
                $db->query();
            }
        }
    }

}

?>
