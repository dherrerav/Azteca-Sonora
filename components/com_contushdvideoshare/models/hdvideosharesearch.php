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
class Modelcontushdvideosharehdvideosharesearch extends JModel
{
/* Following function is to display the search results */
 function getsearch()
 {
        $db = $this->getDBO();
        $session =& JFactory::getSession();
        $searchtotal="select a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.published=1 group by c.id";
        if(JRequest::getVar('searchtxtbox','','post','string'))
        {
            $search=JRequest::getVar('searchtxtbox','','post','string'); // Getting the search  text  box value
            $session->set('search', $search);
        }
        else
        {
            $search=$session->get('search');
        }
        $kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
        // Now let us generate the sql
        while(list($key,$search)=each($kt)){
         if($search<>" " and strlen($search) > 0)
            {
            $searchtotal="select a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.published=1 and (c.title like '%$search%' OR c.tags like '%$search%' OR a.category like '%$search%' OR d.username like '%$search%')  group by c.id"; // Query for displayin the pagination results
            }
            }
        $db->setQuery($searchtotal);
        $resulttotal = $db->loadObjectList();
        $subtotal=count($resulttotal);
        $total=$subtotal;
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getsearchrowcol();
        $length=$limitrow[0]->searchrow * $limitrow[0]->searchcol;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        if(JRequest::getVar('searchtxtbox','','post','string'))
        {
            $search=JRequest::getVar('searchtxtbox','','post','string');
            $session->set('search', $search);
        }
        else
        {
            $search=$session->get('search');
        }
        $kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
        // Now let us generate the sql
        $searchquery="select a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.published=1  group by c.id LIMIT $start,$length";//Query for displaying the search value results
        
        while(list($key,$search)=each($kt)){
            if($search<>" " and strlen($search) > 0){
        $searchquery="select a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.published=1 and (c.title like '%$search%' OR c.tags like '%$search%' OR a.category like '%$search%' OR d.username like '%$search%')  group by c.id LIMIT $start,$length";//Query for displaying the search value results
               }}
        $db->setQuery($searchquery);
        $rows = $db->loadObjectList();
        if(count($rows)>0)
        {
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        $insert_data_array = array('pageno' => $pageno);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('pages' => $pages);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('start' => $start);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('length' => $length);
        $rows = array_merge($rows, $insert_data_array);
        // merge code ends here
        }       
        return $rows;        
    }
function getsearchrowcol()
{
        $db = $this->getDBO();
	$searchquery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($searchquery);
        $rows=$db->LoadObjectList();
        return $rows;
}
}
?>