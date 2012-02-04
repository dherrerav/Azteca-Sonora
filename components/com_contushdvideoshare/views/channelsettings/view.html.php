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
class contushdvideoshareViewchannelsettings extends JView
{
function display()
{

$model = $this->getModel();

//get myvideos
$myVideos = $model->getMyvideos();
$this->assignRef('myvideos', $myVideos);

//get playlist
$myPlaylist = $model->getMyplaylist();
$this->assignRef('myplaylist', $myPlaylist);

//save settings
if(JRequest::get( 'post' )) {
$saveSettings = $model->saveSettings();
//update recent activity
$updateRecentactivity = $model->updateRecentactivity();
}

//get channel settings value
$channelSettings = $model->channelSettings();//echo '<pre>';print_r($channelSettings);exit;
$this->assignRef('channelsettings', $channelSettings);




parent::display();
}

}
?>