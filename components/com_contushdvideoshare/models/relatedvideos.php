<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class Modelcontushdvideosharerelatedvideos extends JModel
{
/* Following function is to display the related videos */
function getrelatedvideos()
{
        $db = $this->getDBO();
        $session =& JFactory::getSession();
       
        $categoryid=JRequest::getVar('catid','','get','int');
        $totalquery="select a.*,b.id as catid,b.category,e.* from #__hdflv_upload a left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where e.catid=$categoryid and a.published=1  group by e.vid"; //Query for getting the pagination values
        $db->setQuery( $totalquery );
        $resulttotal = $db->loadObjectList();
        $subtotal=count($resulttotal);
        $total=$subtotal;
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getrelatedvideosrowcol();
        $length=$limitrow[0]->relatedrow * $limitrow[0]->relatedcol;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        if($categoryid!="featured")
        $query = "select a.*,b.id as catid,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where e.catid=$categoryid and a.published=1  group by e.vid order by a.id desc LIMIT $start,$length";//Query for displaying the related videos when click the more videos in the player page
        else
        $query = "select a.*,b.id as catid,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.featured=1 and a.published=1  group by e.vid order by a.id desc LIMIT $start,$length";//Query for displaying the related videos when click the more videos in the player page
        $db->setQuery( $query );
        $rows = $db->loadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if(count($rows)>0){
        $insert_data_array = array('pageno' => $pageno);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('pages' => $pages);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('start' => $start);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('length' => $length);
        $rows = array_merge($rows, $insert_data_array);
        }
        else{
        $insert_data_array = array('pageno' => 0);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('pages' => 0);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('start' => 0);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('length' => 0);
        $rows = array_merge($rows, $insert_data_array);
        }
        // merge code ends here
        return $rows;
}
function getrelatedvideosrowcol()
{
        $db = $this->getDBO();
	$relatedvideosquery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($relatedvideosquery);
        $rows=$db->LoadObjectList();
        return $rows;
}
}
?>