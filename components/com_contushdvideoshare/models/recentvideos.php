<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        recentvideos.php
 * @location    /components/com_contushdvideosahre/models/recentvideos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   recent videos related model page 
 */

// No Direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Modelcontushdvideosharerecentvideos extends JModel {
    /* Following function is to display the recent videos */

    function getrecentvideos() {
        $featuredtotal = "select count(*) from #__hdflv_upload where published=1 and type='0'";  //Query is to get the pagination for related values
        $db = $this->getDBO();
        $db->setQuery($featuredtotal);
        $total = $db->loadResult();
        $pageno = 1;
        if (JRequest::getVar('page', '', 'post', 'int')) {
            $pageno = JRequest::getVar('page', '', 'post', 'int');
        }
        $limitrow = $this->getrecentvideosrowcol();
        $length = $limitrow[0]->recentrow * $limitrow[0]->recentcol;
        $pages = ceil($total / $length);
        if ($pageno == 1)
            $start = 0;
        else
            $start= ( $pageno - 1) * $length;
        $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and a.type='0' group by e.vid desc LIMIT $start,$length"; //Query is to display the recent videos
        $db->setQuery($query);
        $rows = $db->LoadObjectList();

        if (count($rows) > 0) {
            $insert_data_array = array('pageno' => $pageno);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('pages' => $pages);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('start' => $start);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('length' => $length);
            $rows = array_merge($rows, $insert_data_array);
        } else {
            $insert_data_array = array('pageno' => 0);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('pages' => 0);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('start' => 0);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('length' => 0);
            $rows = array_merge($rows, $insert_data_array);
        }
        return $rows;
    }

    function getrecentvideosrowcol() {
        $db = $this->getDBO();
        $recentvideosquery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($recentvideosquery);
        $rows = $db->LoadObjectList();
        return $rows;
    }
}

?>