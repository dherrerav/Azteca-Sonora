<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class Modelcontushdvideosharecommentappend extends JModel
{
 
    function getcomment()
    {

        if(JRequest::getVar('id','','get','int'))
        {
        $commenttitle = array();
        $db = $this->getDBO();
        $id=JRequest::getVar('id','','get','int');
        if(JRequest::getVar('name','','get','string') && JRequest::getVar('message','','get','string'))
        {
        $parentid=JRequest::getVar('pid','','get','int'); //Getting the parent id value
        $name=JRequest::getVar('name','','get','string'); // Getting the name who is posting the comments
        $message=JRequest::getVar('message','','get','string'); // Getting the message
        $db =& JFactory::getDBO();
        $commentquery="insert into #__hdflv_comments(parentid,videoid,name,message,published) values ('$parentid','$id','$name','$message','1')"; // This insert query is to post a new comment for a particular video
        $db->setQuery($commentquery);
        $db->query();
        }
        /* Following code is to display the title and times of views for a particular video */
        $titlequery="select a.title,a.times_viewed,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
        $db->setQuery( $titlequery );
        $commenttitle = $db->loadObjectList();
        /* Title query for video ends here */
        $commenttotalquery = "select count(*) from #__hdflv_comments where published=1 and videoid=$id"; // Query is to get the pagination value for comments display
        $db->setQuery( $commenttotalquery );
        $total = $db->loadResult();
        $pageno = 1;
        if(isset($_SESSION['commentappendpageno']))
        {
        if( $_SESSION['commentappendpageno'])
        {
            $pageno =  $_SESSION['commentappendpageno'];
            $_SESSION['commentappendpageno']="";
        }}
        $length=10;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        $commentscount="SELECT id as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid = 0 and published=1 and videoid=$id union select parentid as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid !=0 and published=1 and videoid=$id order by number desc,parentid ";// Query is to display the comments posted for particular video
        $db->setQuery( $commentscount );
        $rowscount = $db->loadObjectList();
        $totalcomment=count($rowscount);
        $comments="SELECT id as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid = 0 and published=1 and videoid=$id union select parentid as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid !=0 and published=1 and videoid=$id order by number desc,parentid LIMIT $start,$length";// Query is to display the comments posted for particular video
        $db->setQuery( $comments );
        $rows = $db->loadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        $insert_data_array = array('pageno' => $pageno);
        $commenttitle = array_merge($commenttitle, $insert_data_array);
        $insert_data_array = array('pages' => $pages);
        $commenttitle = array_merge($commenttitle, $insert_data_array);
        $insert_data_array = array('start' => $start);
        $commenttitle = array_merge($commenttitle, $insert_data_array);
        $insert_data_array = array('length' => $length);
        $commenttitle = array_merge($commenttitle, $insert_data_array);
         $insert_data_array = array('totalcomment' => $totalcomment);
        $commenttitle = array_merge($commenttitle, $insert_data_array);
        // merge code ends here
        $playersettings="select * from #__hdflv_player_settings";
        $db->setQuery( $playersettings );
        $playersettingsresult = $db->loadObjectList();
        return array($commenttitle, $rows,$playersettingsresult);
}

    }


    function ratting()
    {

        $db = $this->getDBO();
        if(JRequest::getVar('id','','get','int'))
        $id=JRequest::getVar('id','','get','int');

if(JRequest::getVar('rate','','get','int'))
{

         echo $query="update #__hdflv_upload SET rate=".JRequest::getVar('rate','','get','int')."+rate,ratecount=1+ratecount where id=$id";
         $db->setQuery($query );
         $db->query();
         exit;
}

if(JRequest::getVar('id','','get','int'))
{
        /*Get Views counting*/
        $titlequery="select a.times_viewed,a.rate,a.ratecount,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
        $db->setQuery( $titlequery );
        $commenttitle = $db->loadObjectList();
        //print_r($commenttitle);
        return $commenttitle;
}
    }
}
        ?>