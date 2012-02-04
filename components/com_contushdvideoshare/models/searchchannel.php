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
class Modelcontushdvideosharesearchchannel extends JModel {

    //var $usergroup = null;
   function __construct()
    {
       parent::__construct();
       global $usergroup;


    }

    /*function to check channel availability*/
    function searchChannel($searchValue) {
    	$db = $this->getDBO();
    	$query = "select a.channel_name,a.id,b.type,b.logo from #__hdflv_channel a left join #__hdflv_channelsettings b on a.id=b.channel_id where b.type=1 and a.channel_name='$searchValue'";
    	$db->setQuery($query);//echo $query;exit;
        $channelDetails = $db->loadObjectList();
        return $channelDetails;
    }

    function checkAvailability($searchChannelId) {
        $db = $this->getDBO();
        $channelId = $this->getChannel();
        $query = "select id from #__hdflv_channellist where channel_id = $channelId and other_channel = $searchChannelId";
    	$db->setQuery($query);
        $channelResult = $db->loadResult();
        return $channelResult;
    }

    /*function to save other channels*/
    function insertOtherchannel() {
    	//echo '<pre>';print_r($_POST);exit;
    	$channelId = $this->getChannel();
    	$otherChannel = JRequest::getVar('channel_id');
    	$db = $this->getDBO();
    	$query='insert into #__hdflv_channellist(channel_id,other_channel) values ("'.$channelId.'","'.$otherChannel.'")';
        $db->setQuery($query);
        $db->query();
        $db_insert_id=$db->insertid();
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

/*function to delete other channels*/
    function deleteChannel() {
    	//echo '<pre>';print_r($_POST);exit;
    	$channelId = $this->getChannel();
    	$otherChannel = JRequest::getVar('channel_id');
    	$db = $this->getDBO();
    	$query="delete from #__hdflv_channellist where other_channel = $otherChannel and channel_id = $channelId";
        $db->setQuery($query);
        $db->query();
    }



    }
?>