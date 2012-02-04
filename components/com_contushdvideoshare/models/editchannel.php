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
class Modelcontushdvideoshareeditchannel extends JModel {

    //var $usergroup = null;
   function __construct()
    {
       parent::__construct();
       global $usergroup;


    }

    /*function to check channel availability*/
    function searchChannel($searchValue) {
    	$db = $this->getDBO();
    	$query = "select a.channel_name,b.type from #__hdflv_channel a left join #__hdflv_channelsettings b on a.id=b.channel_id where b.type=1 and a.channel_name like '$searchValue%'";
    	$db->setQuery($query);//echo $query;exit;
        $channelDetails = $db->loadObjectList();
        return $channelDetails;
    }

    /*function to get total uploads*/

    function getTotaluploads() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select count(*) from #__hdflv_upload where memberid = $memberId";
    	$db->setQuery($query);
        $totalUploads = $db->loadResult();
        return $totalUploads;
    }

/*function to get channel details*/
    function getChanneldetails(){
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_channel where user_id = $memberId";
    	$db->setQuery($query);
        $channelDetails = $db->loadObjectList();
        return $channelDetails;
    }


    /*function to save channel */
    function saveChannel() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	JRequest::setVar( 'user_id', $memberId, 'post' );
    	$row =& JTable::getInstance('mychannel', 'Table');
	    $data = JRequest::get( 'post' );
	    $data['description'] = JRequest::getVar('description','','POST','STRING',JREQUEST_ALLOWHTML);
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

    /*function to get myplaylist*/
    function getMyplaylist() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_category where published=1 and member_id = $memberId";
    	$db->setQuery($query);
        $myPlaylist = $db->loadObjectList();
        return $myPlaylist;
    }

    /*function to save channel settings */
    function saveSettings() {
	$data = JRequest::get( 'post' );//echo '<pre>';print_r($data);exit;
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	JRequest::setVar( 'channel_id', $memberId, 'post' );
    	//echo $_POST['channel_id'];
	   	$row =& $this->getTable('channelsettings');


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

    	/*$playerWidth = JRequest::getVar('player_width');
    	$playerHeight = JRequest::getVar('player_height');
    	$videosRow = JRequest::getVar('videos_row');
    	$videosColumn = JRequest::getVar('videos_column');
    	$recentVideos = JRequest::getVar('recent_videos');
    	$popularVideos = JRequest::getVar('popular_videos');
    	$playlist = JRequest::getVar('playlist');
    	$type = JRequest::getVar('type');
    	$fbComments = JRequest::getVar('fb_comments');
    	$startvideoType = JRequest::getVar('startvideo_type');
    	$startVideo = JRequest::getVar('start_video');
    	$startPlaylist = JRequest::getVar('start_playlist');
    	$db = $this->getDBO();
    	$query = "select count(*) from #__hdflv_channelsettings where channel_id = $memberId";
    	$db->setQuery($query);
        $myPlaylist = $db->loadResult();
        if($myPlaylist == 0) {
        		$query='insert into #__hdflv_channelsettings(channel_id,player_width,player_height,video_row,video_colomn,recent_videos,popular_videos,top_videos,playlist,type,start_videotype,start_video,start_playlist,fb_comment) values ("'.$memberId.'","'.$playerWidth.'","'.$playerHeight.'","'.$videosRow.'","'.$videosColumn.'","'.$recentVideos.'","'.$popularVideos.'","'.$playlist.'","'.$type.'","'.$startvideoType.'","'.$startVideo.'","'.$startPlaylist.'","'.$fbComments.'")';
                $db->setQuery($query);
                $db->query();
                $db_insert_id=$db->insertid();
        }*/

    }

    /*function to get channel settings*/
    function channelSettings(){
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_channelsettings where channel_id = $memberId";
    	$db->setQuery($query);
        $channelSettings = $db->loadObjectList();
        return $channelSettings;
    }
    /* function for updating recent activity */
    function updateRecentactivity() {
        $channelId = $this->getChannel();
        $db = $this->getDBO();
        $query='update #__hdflv_channel SET updated_date=now() where id='.$channelId;
        $db->setQuery($query);
        $db->query();
    }

        /*function to get channel id*/
function getChannel() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$query = "select id from #__hdflv_channel where user_id = $memberId";
    	$db->setQuery($query);
        $channelId = $db->loadResult();
        return $channelId;
    }



    }
?>