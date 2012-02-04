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
//define ('DIRECTORY_SEPARATOR', "/");
//define( 'DS', DIRECTORY_SEPARATOR );
class Modelcontushdvideoshareplaylist extends JModel {

    //var $usergroup = null;
   function __construct()
    {
       parent::__construct();
       global $usergroup;


    }

    /*function to get myvideos*/
    function getMyvideos(){
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $myVideos = $db->loadObjectList();
        return $myVideos;
    }

    function savePlaylist() {

    	$playlistVideos = JRequest::getVar('playlist_videos');
    	$db = $this->getDBO();
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	JRequest::setVar( 'member_id', $memberId, 'post' );
    	JRequest::setVar( 'published', '1', 'post' );
        JRequest::setVar( 'parent_id', '-1', 'post' );
	   	$row =& $this->getTable('playlist');

	    $data = JRequest::get( 'post' );            
            $data['seo_category'] = $data['category'];
	    // Bind the form fields to the hello table
	    if (!$row->bind($data)) {
	        $this->setError($this->_db->getErrorMsg());
	        return false;
	    }

	    // Make sure the hello record is valid
	    if (!$row->check()) {
	        $this->setError($this->_db->getErrorMsg());
	        return false;
	    }

	    // Store the web link table to the database
	    if (!$row->store()) {
	        $this->setError($this->_db->getErrorMsg());
	        return false;
	    }
	    $lastinsertedId = $row->id;
	    for($i=0;$i<count($playlistVideos);$i++) {
	    $query=' update #__hdflv_upload SET playlistid="'.$lastinsertedId.'" where id='.$playlistVideos[$i];
        $db->setQuery($query);
        $db->query();

        $query1=' update #__hdflv_video_category SET catid="'.$lastinsertedId.'" where vid='.$playlistVideos[$i];
        $db->setQuery($query1);
        $db->query();
	    }
	    return true;
    }

/*function for getting playlist*/
    function getPlaylist() {
    	$limit = '';
    	$db = $this->getDBO();
    	if(JRequest::getVar('channelid')) {
    		$channelId = JRequest::getVar('channelid');
    		$query = "select user_id from #__hdflv_channel where id = $channelId";
	    	$db->setQuery($query);
	        $memberId = $db->loadResult();
    	}else {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	}
    	$query = "select distinct(playlistid) from #__hdflv_upload where memberid=$memberId";
    	$db->setQuery($query);
        $total = $db->loadobjectList();
        $total = count($total);
        $pageno = 1;
    	if(JRequest::getVar('page'))
        {
            $pageno = JRequest::getVar('page');
        }        
        $length = 12;
        if($length != 0) {
    	$pages = ceil($total/$length);
        }
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
    	$playlistquery = "select distinct(playlistid) from #__hdflv_upload where memberid=$memberId LIMIT $start,$length";
    	//$playlistquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.playlistid in (select distinct(playlistid) from #__hdflv_upload where memberid=$memberId) group by e.vid limit 0,$limit ";
        $db->setQuery($playlistquery);
        $playlist = $db->loadobjectList();
        if(!empty($playlist)) {
        for($i=0;$i<count($playlist);$i++) {
        	$playlistId = $playlist[$i]->playlistid;
        	$query = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.memberid=$memberId and a.playlistid=$playlistId limit 1";
        	$db->setQuery($query);
        	$playlistdvideos = $db->loadobjectList();
        	$playList[$i] = $playlistdvideos;

        }
        return $playList;
        }
    }

/*function to get channel settings*/
    function channelSettings(){
    	if(JRequest::getVar('channelid')) {
    		$channelId = JRequest::getVar('channelid');
    	}else {
    	$channelId = $this->getChannel();
    	}
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_channelsettings where channel_id = $channelId";
    	$db->setQuery($query);
        $channelSettings = $db->loadObjectList();
        return $channelSettings;
    }

    /*function to get channel id*/
function getChannel() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select channel_name from #__hdflv_channel where user_id = $memberId";
    	$db->setQuery($query);
        $channelId = $db->loadResult();
        return $channelId;
    }

    /*function to get playlist videos*/
function getplaylistVideos() {
    $db = $this->getDBO();
	if(JRequest::getVar('channelid')) {
    		$channelId = JRequest::getVar('channelid');
    		$query = "select user_id from #__hdflv_channel where id = $channelId";
	    	$db->setQuery($query);
	        $memberId = $db->loadResult();
    	}else {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	}
        $playlistName = JRequest::getString('category');
        $query = "select id from #__hdflv_category where category = '$playlistName'";
	$db->setQuery($query);
	$playlistId = $db->loadResult();
	//$playlistId = JRequest::getVar('id');//echo $playlistId;exit;
	$featuredtotal = "select count(*) from #__hdflv_upload where memberid=$memberId and playlistid=$playlistId";  //Query is to get the pagination for related values
        $db->setQuery($featuredtotal);
	$total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $length=12;
         $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
	$playlistquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.type='0' and a.memberid=$memberId and a.playlistid=$playlistId LIMIT $start,$length";
    $db->setQuery($playlistquery);
    $playlistvideos = $db->loadobjectList();//echo '<pre>';print_r($playlistvideos);exit;
    $rows = $playlistvideos;
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

/* function for updating recent activity */
function updateRecentactivity() {
        $channelId = $this->getChannel();
        $db = $this->getDBO();
        $query='update #__hdflv_channel SET updated_date=now() where id='.$channelId;
        $db->setQuery($query);
        $db->query();
    }

    /*function to check playlist availability*/
    function playlistExists() {
        $db = $this->getDBO();
        $data = JRequest::get( 'post' );
        $category = $data['category'];
        $query = "select * from #__hdflv_category where category='$category'";
        $db->setQuery($query);
        $playlist = $db->loadobjectList();
        return $playlist;
    }


}
?>