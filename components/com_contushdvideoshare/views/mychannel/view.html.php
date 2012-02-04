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
class contushdvideoshareViewmychannel extends JView
{
function display()
{

$model = $this->getModel();

//get channel details
$channelDetails = $model->getChanneldetails();//echo '<pre>';print_r($channelDetails);exit;
$this->assignRef('channeldetails', $channelDetails);

//get total uploads
$totalUploads = $model->getTotaluploads();
$this->assignRef('totaluploads', $totalUploads);

//update channel views
$channelViews = $model->updateViews();

//update recent activity
//$videoViews = $model->updatevideoViews();

//get channel settings
$channelSettings = $model->channelSettings();
$this->assignRef('channelvideorowcol', $channelSettings);

//get front video details
$frontVideodetails = $model->getfrontvideodetails();
$this->assignRef('frontvideodetails', $frontVideodetails);

//get other channels
$otherChannels = $model->getOtherchannels();
$this->assignRef('otherchannels', $otherChannels);

//get myvideos
$myVideos = $model->getMyvideos();
$this->assignRef('myvideos', $myVideos);

//get channel id
$channelId = $model->getChannel();
$this->assignRef('channelId', $channelId);

//get video id
if(JRequest::getVar('title')) {
$videoId = $model->getVideoid();
$this->assignRef('videoid', $videoId);
}

//get home page settings
$siteSettings = $model->gethomepagebottomsettings();
$this->assignRef('sitesettings', $siteSettings);
parent::display();
}

}
?>