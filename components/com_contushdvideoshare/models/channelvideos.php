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
class Modelcontushdvideosharechannelvideos extends JModel {

    //var $usergroup = null;
   function __construct()
    {
       parent::__construct();
       global $usergroup;


    }

/*function for getting popular videos*/
    function getPopularvideos() {
    	$limit = '';
    	$length = '';
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
    	$viewrow = $this->channelSettings();
    	$query = "select count(*) from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $total = $db->loadResult();
        $pageno = 1;
    	if(JRequest::getVar('page'))
        {
            $pageno = JRequest::getVar('page');
        }
        if(isset($viewrow[0])) {
        $length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
        }
        if($length != 0) {
    	$pages = ceil($total/$length);
        }
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        $popularquery = "select a.*,b.category,b.seo_category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.memberid=$memberId group by e.vid order by a.times_viewed desc LIMIT $start,$length";
        $db->setQuery($popularquery);
        $popularvideos = $db->loadobjectList();//echo '<pre>';print_r($popularvideos);
        $rows = $popularvideos;
        return $rows;
    }

    /*function for getting recent videos*/
    function getRecentvideos() {
    	$limit = '';
    	$length = '';
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
    	$viewrow = $this->channelSettings();
    	$query = "select count(*) from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $total = $db->loadResult();
        $pageno = 1;
    	if(JRequest::getVar('page'))
        {
            $pageno = JRequest::getVar('page');
        }
        if(isset($viewrow[0])) {
        $length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
        }
        if($length != 0) {
    	$pages = ceil($total/$length);
        }
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
    	$recentquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.memberid=$memberId group by e.vid order by a.id desc LIMIT $start,$length";
        $db->setQuery($recentquery);
        $recentvideos = $db->loadobjectList();//echo '<pre>';print_r($recentvideos);exit;
        $rows = $recentvideos;
        return $rows;
    }

/*function for getting top rated videos*/
    function getTopratedvideos() {
    	$limit = '';
    	$length = '';
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
    	$viewrow = $this->channelSettings();
    	$query = "select count(*) from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $total = $db->loadResult();
        $pageno = 1;
    	if(JRequest::getVar('page'))
        {
            $pageno = JRequest::getVar('page');
        }
        if(isset($viewrow[0])) {
        $length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
        }
        if($length != 0) {
    	$pages = ceil($total/$length);
        }
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
    	$topratedquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.memberid=$memberId group by e.vid order by a.rate desc limit $start,$length";
        $db->setQuery($topratedquery);
        $topratedvideos = $db->loadobjectList();//echo '<pre>';print_r($topratedvideos);
        return $topratedvideos;
    }

    /*function for getting playlist videos*/
    function getPlaylistvideos() {
    	$limit = '';
    	$length = '';
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
    	$viewrow = $this->channelSettings();
    	$query = "select count(*) from #__hdflv_category where member_id = $memberId";
    	$db->setQuery($query);
        $total = $db->loadResult();
        $pageno = 1;
    	if(JRequest::getVar('page'))
        {
            $pageno = JRequest::getVar('page');
        }
        if(isset($viewrow[0])) {
        $length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
        }
        if($length != 0) {
    	$pages = ceil($total/$length);
        }
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
    	$playlistquery = "select distinct(playlistid) from #__hdflv_upload where memberid=$memberId limit $start,$length";
    	//$playlistquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.playlistid in (select distinct(playlistid) from #__hdflv_upload where memberid=$memberId) group by e.vid limit 0,$limit ";
        $db->setQuery($playlistquery);
        $playlist = $db->loadobjectList();//print_r($playlist);
        if(!empty($playlist)) {
        for($i=0;$i<count($playlist);$i++) {
        	//echo $i;
        	$playlistId = $playlist[$i]->playlistid;
        	$query = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.memberid=$memberId and a.playlistid=$playlistId limit 1";
        	$db->setQuery($query);
        	$playlistdvideos = $db->loadobjectList();
        	$playlistArray[$i] = $playlistdvideos;
        }
        return $playlistArray;
        }
    }

/*function to get channel settings*/
    function channelSettings(){
    	$channelId = $this->getChannel();
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_channelsettings where channel_id = $channelId";
    	$db->setQuery($query);
        $channelSettings = $db->loadObjectList();
        return $channelSettings;
    }

    /*function to get channel id*/
function getChannel() {
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
    	$query = "select id from #__hdflv_channel where user_id = $memberId";
    	$db->setQuery($query);
        $channelId = $db->loadResult();
        return $channelId;
    }

 /*function to get myvideos*/
    function getMyvideos(){
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
    	$query = "select * from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $myVideos = $db->loadObjectList();
        return $myVideos;
    }

/*function to get myplaylist*/
    function getMyplaylist() {
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
    	$query = "select * from #__hdflv_category where member_id = $memberId";
    	$db->setQuery($query);
        $myPlaylist = $db->loadObjectList();
        return $myPlaylist;
    }


    }
?>