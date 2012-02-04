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
class Modelcontushdvideosharepopularvideos extends JModel
{
/* Following function is to display the popular videos */
function getpopularvideos()
{

        $user =& JFactory::getUser();
        $accessid = $user->get('aid');
        $featuredtotal = "select count(*) from #__hdflv_upload where published=1 and type='0' ";  //Query is to get the pagination for related values
        $db = $this->getDBO();
		$db->setQuery($featuredtotal);
		$total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getpopularvideorowcol();
        $length=$limitrow[0]->popularrow * $limitrow[0]->popularcol;
         $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
		$popularquery="select a.*,b.category,b.seo_category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and a.type='0'  group by e.vid ORDER BY a.times_viewed desc LIMIT $start,$length";//Query is to display the popular videos
     
                $db->setQuery($popularquery);
        $rows=$db->LoadObjectList();
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
        return $rows;
}
function getpopularvideorowcol()
{
        $db = $this->getDBO();
        $popularquery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($popularquery);
        $rows=$db->LoadObjectList();
        return $rows;
}
}
?>