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
 * Description :Get & Displaying category on front page
 */
// No Direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Modelcontushdvideosharecategory extends JModel {
    /* Following function is to display the video results of related category */

    function getcategory() {
        $category = 0;
        $db = $this->getDBO();
        if (JRequest::getVar('catid', '', 'get', 'int')) {
            $catvalue = JRequest::getVar('catid', '', 'get', 'int');
            $catid = $catvalue;
        } else {
            $query_catid = "select id from #__hdflv_category where published=1 order by category asc"; // this query is for category view pagination
            $db->setQuery($query_catid);
            $searchtotal1 = $db->loadObjectList();
            $catid = $searchtotal1[0]->id;
        } //Category id is stored in this catid variable
        $totalquery = "select a.*,b.id as cid,b.category,c.* from #__hdflv_upload a left join #__hdflv_video_category c on a.id=c.vid left join #__hdflv_category b on c.catid=b.id where c.catid=$catid OR a.playlistid=$catid and a.published=1 and a.type='0'"; // this query is for category view pagination
        $db->setQuery($totalquery);
        $searchtotal = $db->loadObjectList();
        $subtotal = count($searchtotal);
        $total = $subtotal;
        $pageno = 1;
        if (JRequest::getVar('page', '', 'post', 'int')) {
            $pageno = JRequest::getVar('page', '', 'post', 'int');
        }
        $limitrow = $this->getcategoryrowcol();
        $length = $limitrow[0]->categoryrow * $limitrow[0]->categorycol;
        $pages = ceil($total / $length);
        if ($pageno == 1)
            $start = 0;
        else
            $start= ( $pageno - 1) * $length;
        $categoryquery = "select a.*,b.id as cid,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on a.id=e.vid left join #__hdflv_category b on e.catid=b.id where (e.catid=$catid OR a.playlistid=$catid) and a.published=1 and a.type='0' group by e.vid order by a.id desc LIMIT $start,$length"; // This query for displaying category's full view display
        $db->setQuery($categoryquery);
        $rows = $db->LoadObjectList();
		 $categoryquery="select category from #__hdflv_category where id=$catid";
        $db->setQuery($categoryquery);
        $category=$db->LoadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if (count($rows) > 0) {
		    $insert_data_array = array('categoryname' => $category);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('pageno' => $pageno);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('pages' => $pages);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('start' => $start);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('length' => $length);
            $rows = array_merge($rows, $insert_data_array);
        } else {
            $categoryquery = "select * from #__hdflv_category where id=$catid"; // This query for displaying category's full view display
            $db->setQuery($categoryquery);
            $rows = $db->LoadObjectList();
        }
        // merge code ends here
        return $rows;
    }

    function getcategoryrowcol() {
        $db = $this->getDBO();
        $popularquery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($popularquery);
        $rows = $db->LoadObjectList();
        return $rows;
    }
}

?>