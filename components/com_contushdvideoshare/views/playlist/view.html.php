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
class contushdvideoshareViewplaylist extends JView
{
function display()
{

$model = $this->getModel();

//save playlist
//save settings
if(JRequest::get( 'post' )) {
$playlistExists = $model->playlistExists();
if(!$playlistExists) {
    $saveSettings = $model->savePlaylist();
}else {
    echo '<p style="color:red">'._HDVS_PLAYLIST_EXISTS.'</p>';
}
//update recent activity
$updateRecentactivity = $model->updateRecentactivity();
}

//get myvideos
$myVideos = $model->getMyvideos();
$this->assignRef('myvideos', $myVideos);

//get playlists
$playList = $model->getPlaylist();//echo '<pre>';print_r($playList);exit;
$this->assignRef('channelvideos', $playList);

if(JRequest::getString('category')) {
//get videos for playlist
$playlistVideos = $model->getplaylistVideos();
$this->assignRef('playlistvideos', $playlistVideos);
}

$channelName = $model->getChannel();
$this->assignRef('channelName', $channelName);


parent::display();
}

}
?>