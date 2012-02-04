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
jimport('joomla.application.component.view');
class contushdvideoshareViewchannelvideos extends JView
{
function display()
{
//echo 'hi'.JRequest::getVar('channelid');exit;
$channelVideo = JRequest::getVar('channel_videos');
$model = $this->getModel();
//get channel videos based on request
if($channelVideo == 'popular') {
//get popular videos
$popularVideos = $model->getPopularvideos();//echo '<pre>';print_r($popularVideos);
$this->assignRef('channelvideos', $popularVideos);
} elseif ($channelVideo == 'recent') {
//get recent videos
$recentVideos = $model->getRecentvideos();//echo '<pre>';print_r($recentVideos);exit;
$this->assignRef('channelvideos', $recentVideos);
}elseif ($channelVideo == 'toprated') {
//get top rated videos
$topratedVideos = $model->getTopratedvideos();//echo '<pre>';print_r($topratedVideos);exit;
$this->assignRef('channelvideos', $topratedVideos);
}
elseif ($channelVideo == 'playlist') {
//get playlist videos
$playlistVideos = $model->getPlaylistvideos();//echo '<pre>';print_r($playlistVideos);exit;
$this->assignRef('channelvideos', $playlistVideos);	
}
JRequest::setVar( 'channelVideo', $channelVideo, 'post' );   

//get channel settings
$channelSettings = $model->channelSettings();//echo '<pre>';print_r($channelSettings);
$this->assignRef('channelvideorowcol', $channelSettings);

//get myvideos
$myVideos = $model->getMyvideos();
$this->assignRef('myvideos', $myVideos);

//get playlist
$myPlaylist = $model->getMyplaylist();
$this->assignRef('myplaylist', $myPlaylist);

//get channel id
$channelId = $model->getChannel();
$this->assignRef('channelId', $channelId);


parent::display();
}

}
?>