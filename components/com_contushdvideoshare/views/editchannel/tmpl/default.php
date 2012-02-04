<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
//check login or not
//include($baseurl."components/com_contushdvideoshare/language/danish.php");
$user = & JFactory::getUser();
$session = & JFactory::getSession();
ob_clean();
?>

  <?php if(isset($this->channeldetails[0])) {
    $channelDetails = $this->channeldetails[0];
    }?>
<div id="channel_details" class="channel_details">
                    <div class="bot_dot1 clearfix">
                        <div class="leftdiv"><?php echo _HDVS_CHANNEL_NAME;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->channel_name)) { echo $channelDetails->channel_name; }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo _HDVS_CHANNEL_VIEWS;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->channel_views)) { echo $channelDetails->channel_views; }?></div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo _HDVS_TOTAL_UPLOADS;?> :</div>
						<div class="rightdiv"><?php if(isset($this->totaluploads)) { echo $this->totaluploads; }?></div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo _HDVS_RECENT_ACTIVITY;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->updated_date)) {echo date('Y-m-d H:i:s',strtotime($channelDetails->updated_date)); }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo _HDVS_ABOUT_ME;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->about_me)) { echo $channelDetails->about_me; }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo _HDVS_TAGS;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->tags)) { echo $channelDetails->tags; }?>
						</div>
					</div>
					<div class="bot_dot1">
						<div class="leftdiv"><?php echo _HDVS_WEBSITE;?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->website)) { echo $channelDetails->website; }?>
						</div>
					</div>
</div>
<?php exit();?>
