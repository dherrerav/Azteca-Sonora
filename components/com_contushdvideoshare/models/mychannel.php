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
class Modelcontushdvideosharemychannel extends JModel {

    //var $usergroup = null;
   function __construct()
    {
       parent::__construct();
       global $usergroup;


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
    	$db = $this->getDBO();
    	if(JRequest::getVar('channelname')) {
    		$channelName = JRequest::getVar('channelname');
    		$query = "select * from #__hdflv_channel where channel_name = '$channelName'";
    	}else {
	    	$user =& JFactory::getUser();
	    	$memberId = $user->get('id');
	    	$query = "select * from #__hdflv_channel where user_id = $memberId";
    	}
    	$db->setQuery($query);
        $channelDetails = $db->loadObjectList();
        return $channelDetails;
    }


    /*function to update views*/
    function updateViews() {
    	//echo JRequest::getVar('rate', '', 'get', 'int');exit;
    	$db = $this->getDBO();
    	$user =& JFactory::getUser();
    	if(JRequest::getVar('channelname')) {
    		$channelName = JRequest::getVar('channelname');
    		$query = "update #__hdflv_channel SET channel_views=1+channel_views where channel_name='$channelName'";
    	}else {
    	$memberId = $user->get('id');
    	$query = "update #__hdflv_channel SET channel_views=1+channel_views where user_id=$memberId";
    	}
        $db->setQuery($query);
        $db->query();
    }



    /*function to save channel */
    function saveChannel() {
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	JRequest::setVar( 'user_id', $memberId, 'post' );
    	$date = date();
    	JRequest::setVar( 'created_date', $date, 'post' );

    	$row =& JTable::getInstance('mychannel', 'Table');

	    $data = JRequest::get( 'post' );
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

/*function to get channel settings*/
    function channelSettings(){
    	$channelId = $this->getChannel();
    	$db = $this->getDBO();
    	$query = "select * from #__hdflv_channelsettings where channel_id = $channelId";
    	$db->setQuery($query);
        $channelSettings = $db->loadObjectList();
        return $channelSettings;
    }

    /*function to get front end video details*/
    function getfrontvideodetails() {
    	$startVideo = '';
        $startVideodetails = '';
    	$user =& JFactory::getUser();
    	$memberId = $user->get('id');
    	$db = $this->getDBO();
    	$channelSettings = $this->channelSettings();
    	if(isset($channelSettings[0])) {
    	if($channelSettings[0]->start_videotype == 1) {
	    	$startVideo = $channelSettings[0]->start_video;
	    	$query = "select * from #__hdflv_upload where id = $startVideo";
    	}elseif ($channelSettings[0]->start_videotype == 0) {
    		$startVideo = $channelSettings[0]->start_playlist;
    		$query = "select * from #__hdflv_upload where playlistid = $startVideo and $memberId limit 1";
    	}
        $db->setQuery($query);
        $startVideodetails = $db->loadObjectList();
    	}
        return $startVideodetails;
    }

    function getChannel() {
    	$db = $this->getDBO();
    	if(JRequest::getVar('channelname')) {
    		$channelName = JRequest::getVar('channelname');
    		$query = "select user_id from #__hdflv_channel where channel_name = '$channelName'";
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

    function getOtherchannels(){
    	$channelId = $this->getChannel();
    	$db = $this->getDBO();
    	$query = "select a.other_channel,b.channel_name,d.logo,d.type from #__hdflv_channellist a left join #__hdflv_channel b on a.other_channel = b.id left join #__hdflv_channelsettings d on d.channel_id = b.id where a.channel_id = $channelId and d.type=1";
    	$db->setQuery($query);
        $otherChannel = $db->loadObjectList();
        return $otherChannel;
    }

	function gethomepagebottomsettings() {
        $db = $this->getDBO();
        $homepagebottomsettings = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($homepagebottomsettings);
        $rows = $db->LoadObjectList();
        return $rows;
    }
   

    /*function to get video id*/
    function getVideoid(){
        $title = JRequest::getVar('title');
        $db = $this->getDBO();
        $query = "select id from #__hdflv_upload where title = '$title'";
        $db->setQuery($query);
        $channelId = $db->loadResult();
        return $channelId;
    }



    }
?>