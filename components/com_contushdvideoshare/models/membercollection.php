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
class Modelcontushdvideosharemembercollection extends JModel
{
    
/* Following function is to display the videos of a particular registered member */
function getmembercollection()
{
    $session =& JFactory::getSession();
    $user =& JFactory::getUser();
        if(JRequest::getVar('memberidvalue','','post','int'))
        {
            $memberid=JRequest::getVar('memberidvalue','','post','int'); // Getting the memberid
           // $_SESSION['memberid']=$memberid; // Assining it to session for future purpose
           $session->set('memberid', $memberid);
        }
        else
        {
            $memberid=$user->get('id');
        }
        $totalquery="select a.*,b.category,d.username from  #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id left join #__users d on a.memberid=d.id where a.published=1 and a.type=0 and a.memberid=$memberid"; // Query for membercollection pagination display
        $db =& JFactory::getDBO();
        $db->setQuery($totalquery);
        $resulttotal = $db->loadObjectList();
        $subtotal=count($resulttotal);
        $total=$subtotal;
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getmemberpagerowcol();
        $length=$limitrow[0]->memberpagerow * $limitrow[0]->memberpagecol;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        $query="select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and a.type=0 and a.memberid=$memberid group by e.vid order by a.id desc LIMIT $start,$length";// Query for displaying the member collection videos when click on his name
        $db->setQuery($query);
        $rows=$db->LoadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if(count($rows)>0)
        {
            $insert_data_array = array('pageno' => $pageno);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('pages' => $pages);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('start' => $start);
            $rows = array_merge($rows, $insert_data_array);
            $insert_data_array = array('length' => $length);
            $rows = array_merge($rows, $insert_data_array);
        }
       
        // merge code ends here
        return $rows;
}



function getmemberpagerowcol()
{

        $db = $this->getDBO();
        $memberpagequery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($memberpagequery);
        $rows=$db->LoadObjectList();
        return $rows;
}



}
?>