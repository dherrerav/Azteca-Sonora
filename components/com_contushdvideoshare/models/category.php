<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Modelcontushdvideosharecategory extends JModel {
    /* Following function is to display the video results of related category */
    function getcategory()
    {
        $category = 0;
        $db = $this->getDBO();
        $flatCatid = is_numeric(JRequest::getString('category'));
        if (JRequest::getString('category') && $flatCatid != 1) {
            $catvalue = str_replace(':', '-', JRequest::getString('category'));
            $query = 'select id from #__hdflv_category where seo_category="' . $catvalue . '"';
            $db->setQuery($query);
            $catid = $db->loadResult();
        } else if ($flatCatid == 1) {
            $catid = JRequest::getString('category');
        } else if (JRequest::getInt('catid')) {
            $catid = JRequest::getInt('catid');
        } else {
            $query_catid = "select id from #__hdflv_category where published=1 order by category asc"; // this query is for category view pagination
            $db->setQuery($query_catid);
            $searchtotal1 = $db->loadObjectList();
            //     print_r($searchtotal1);
            $catid = $searchtotal1[0]->id;
        } //Category id is stored in this catid variable
        $catid = $db->getEscaped($catid);


        $totalquery = "select a.*,b.id as cid,b.category,b.seo_category,b.parent_id,c.* from #__hdflv_upload a left join #__hdflv_video_category c on a.id=c.vid left join #__hdflv_category b on c.catid=b.id where (c.catid=$catid OR b.parent_id = $catid OR a.playlistid=$catid) and a.published=1 and a.type='0' order by b.id asc"; // this query is for category view pagination
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
            $categoryquery = "select a.*,b.id as cid,b.category,b.seo_category,b.parent_id,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on a.id=e.vid left join #__hdflv_category b on e.catid=b.id where (e.catid=$catid OR a.playlistid=$catid OR b.parent_id = $catid ) and a.published=1  group by e.vid order by b.id asc LIMIT $start,$length"; // This query for displaying category's full view display
        $db->setQuery($categoryquery);
        $rows = $db->LoadObjectList();

        $categoryquery = "select category from #__hdflv_category where id=$catid"; // This query for displaying category's full view display
        $db->setQuery($categoryquery);
        $category = $db->LoadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if (count($rows) > 0)
         {
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
    function getcategoryrowcol()
    {
        $db = $this->getDBO();
        $popularquery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($popularquery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

 function getcategoryList()
    {
        $db = $this->getDBO();
        $flatCatid = is_numeric(JRequest::getString('category'));
        if (JRequest::getString('category') && $flatCatid != 1) {
            $catvalue = str_replace(':', '-', JRequest::getString('category'));
            $catvalue = $db->getEscaped($catvalue);

            $query = 'select id from #__hdflv_category where seo_category="' . $catvalue . '"';
            $db->setQuery($query);
            $catid = $db->loadResult();
        } else if ($flatCatid == 1) {
            $catid = JRequest::getString('category');
        } else if (JRequest::getInt('catid')) {
            $catid = JRequest::getInt('catid');
        } else {
            $query_catid = "select id from #__hdflv_category where published=1 order by category asc"; // this query is for category view pagination
            $db->setQuery($query_catid);
            $searchtotal1 = $db->loadObjectList();
            //print_r($searchtotal1);
            $catid = $searchtotal1[0]->id;
        }
        $catid = $db->getEscaped($catid);
        $categoryquery = "select * from #__hdflv_category where id=$catid or parent_id=$catid "; //Query is to select the popular videos row
        $db->setQuery($categoryquery);
        $rows = $db->LoadObjectList();
        return $rows;
    }
}
?>