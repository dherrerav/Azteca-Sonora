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
class contushdvideoshareVieweditchannel extends JView
{
function display()
{
$data = JRequest::get( 'post' );//echo '<pre>';print_r($data);exit;
$model = $this->getModel();
if(JRequest::get( 'post' )) {
//save my channel
$saveChannel = $model->saveChannel();
//update recent activity
$updateRecentactivity = $model->updateRecentactivity();
}

//get channel details
$channelDetails = $model->getChanneldetails();//echo '<pre>';print_r($channelDetails);exit;
$this->assignRef('channeldetails', $channelDetails);

//get total uploads
$totalUploads = $model->getTotaluploads();
$this->assignRef('totaluploads', $totalUploads);

//get myvideos
$myVideos = $model->getMyvideos();
$this->assignRef('myvideos', $myVideos);
parent::display();
}

}
?>