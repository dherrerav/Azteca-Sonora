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
jimport('joomla.application.component.model');
class contushdvideoshareViewsearchchannel extends JView
{
function display()
{
 $model = $this->getModel(); 
 $searchValue = JRequest::getVar('other_channel');
 $applyChannel = JRequest::getVar('apply_channel');
 $deleteChannel = JRequest::getVar('delete_channel');
 //$searchValue = 'hd';
 //get channel availability
 $searchChannel = $model->searchChannel($searchValue);//echo '<pre>';print_r($searchChannel);
 $this->assignRef('searchannel', $searchChannel);

 if(isset ($searchChannel[0])) {
 $searchChannelId = $searchChannel[0]->id;
 $checkAvailability = $model->checkAvailability($searchChannelId);
 $this->assignRef('searchannelid', $checkAvailability);
 }
 if(isset($applyChannel)){
 	$insertChannel = $model->insertOtherchannel();
 }
 if(isset($deleteChannel)) {
 	$deleteChannel = $model->deleteChannel();
 }
 parent::display();
}

}
?>