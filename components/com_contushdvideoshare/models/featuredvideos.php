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
class Modelcontushdvideosharefeaturedvideos extends JModel
{
/* Followinf function is to display a featured videos */
function getfeaturedvideos()
{

        
        $featuredtotal = "select count(*) from #__hdflv_upload where published=1 and featured=1)"; //Query is to get the pagination for related values
        $db = $this->getDBO();
		$db->setQuery($featuredtotal);
		$total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getfeaturevideorowcol();
        $length=$limitrow[0]->featurrow * $limitrow[0]->featurcol;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
      $featuredquery="select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on a.id=e.vid left join #__hdflv_category b on e.catid=b.id where a.published=1 and a.featured=1 and a.type='0'  group by e.vid order by a.id desc LIMIT $start,$length";//Query is to display the featured videos
  
     $db->setQuery($featuredquery);
        $rows=$db->LoadObjectList();
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

function getfeaturevideorowcol()
{

        $db = $this->getDBO();
	$featurequery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows=$db->LoadObjectList();
        return $rows;
}


}
?>