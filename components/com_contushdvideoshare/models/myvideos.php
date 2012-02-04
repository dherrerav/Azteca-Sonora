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
class Modelcontushdvideosharemyvideos extends JModel
{
/* Following function is to delete a particular video */
function getdeletevideo()
{
  $user =& JFactory::getUser();
      $session =& JFactory::getSession();
     if(JRequest::getVar('deletevideo','','post','int'))
        {
            $id=JRequest::getVar('deletevideo','','post','int'); //Getting the video id which is going to be deleted
        
        $db = $this->getDBO();
        $deletequery="delete from #__hdflv_upload where id=$id"; // Query for deleting a selected video
        $db->setQuery($deletequery);
        $db->query();
        }
        /* Video Delete function Ends here */

        // Following code for displaying videos of the particular member when he logged in

        if($user->get('id'))
        {
            $memberid=$user->get('id'); //Setting the loginid into session
        }
        $db = $this->getDBO();
        $myvideostotal = "select count(*) from #__hdflv_upload where published=1 and memberid=$memberid"; // Query to get the pagination values
        $db->setQuery( $myvideostotal );
        $total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getmyvideorowcol();
        $length=$limitrow[0]->myvideorow * $limitrow[0]->myvideocol;
        $myvideorowcolquery="select allowupload  from #__hdflv_user where member_id=".$memberid;//Query is to select the popular videos row
        $db = $this->getDBO();
       $db->setQuery($myvideorowcolquery);
        $row=$db->LoadObjectList();
       
        if(count($row)!=0)
        {
        $allowupload = $row[0]->allowupload;
     
        }
        else
        {
        $allowupload = $limitrow[0]->allowupload;
        }
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;

        if(JRequest::getVar('sorting','','post','int')=="1")
        {
        $query="select a.*,b.category,d.username,e.*,count(f.videoid) as total from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id left join #__hdflv_comments f on f.videoid=a.id where a.published=1 and a.memberid=$memberid group by a.id order by a.title asc LIMIT $start,$length";// Query is to display the myvideos results order by title
        }
        else if(JRequest::getVar('sorting','','post','int')=="2")
        {
        $query="select a.*,b.category,d.username,e.*,count(f.videoid) as total from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id left join #__hdflv_comments f on f.videoid=a.id where a.published=1 and a.memberid=$memberid group by a.id order by a.addedon desc LIMIT $start,$length";// Query is to display the myvideos results order by added date
        }
        else if(JRequest::getVar('sorting','','post','int')=="3")
        {
        $query="select a.*,b.category,d.username,e.*,count(f.videoid) as total from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id left join #__hdflv_comments f on f.videoid=a.id where a.published=1 and a.memberid=$memberid group by a.id order by a.times_viewed desc LIMIT $start,$length";// Query is to display the myvideos results order by time sof views
        }
        else if(strlen(JRequest::getVar('searchtxtboxmember','','post','string'))>0)
        {
        $search=JRequest::getVar('searchtxtboxmember','','post','string');
        //$query="select a.*,b.category,d.username,e.*,count(f.videoid) as total from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id left join #__hdflv_comments f on f.videoid=a.id where a.published=1 and a.memberid=$memberid group by a.id order by a.id desc LIMIT $start,$length";// Query is to display the myvideos results
        $query="select a.id,a.category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.memberid=$memberid and (c.title like '%$search%'  OR a.category like '%$search%' OR d.username like '%$search%')  group by c.id"; // Query for displayin the pagination results
        }
        else
        {
        $query="select a.*,b.category,d.username,e.*,count(f.videoid) as total from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id left join #__hdflv_comments f on f.videoid=a.id where a.published=1 and a.memberid=$memberid group by a.id order by a.id desc LIMIT $start,$length";// Query is to display the myvideos results
        }
         $db->setQuery($query);
        $rows=$db->LoadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if(count($rows)>0){
        $insert_data_array = array('pageno' => $pageno);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('allowupload' => $allowupload);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('pages' => $pages);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('start' => $start);
        $rows = array_merge($rows, $insert_data_array);
        $insert_data_array = array('length' => $length);
        $rows = array_merge($rows, $insert_data_array);
        }
        else{
        $insert_data_array = array('allowupload' => $allowupload);
        $rows = array_merge($rows, $insert_data_array);
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


function getmyvideorowcol()
{
 $user =& JFactory::getUser();
 $memberid="";
   if($user->get('id'))
        {
            $memberid=$user->get('id'); //Setting the loginid into session
        }
        $db = $this->getDBO();
		$myvideorowcolquery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($myvideorowcolquery);
        $rows=$db->LoadObjectList();

       
       
        return $rows;
}

}
?>