<?php
/*
 * "ContusHDVideoShare Component" - Version 2.2
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
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$session = & JFactory::getSession();
$editing = '';
if ($user->get('id') == '')
{
    if(version_compare(JVERSION,'1.6.0','ge'))
      {
	$url = $baseurl . "index.php?option=com_users&view=login";
	header("Location: $url");
      }else {
        $url = $baseurl . "index.php?option=com_user&view=login";
	header("Location: $url");
      }
}
?>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<?php
if (JRequest::getVar('url', '', 'post', 'string'))
 {
    $video = new videourl();
    $vurl = JRequest::getVar('url', '', 'post', 'string');
    $video->getVideoType($vurl);
    $description = $video->catchData($vurl);
    $imgurl = $video->imgURL($vurl);
}
?>

<?php $channelSettings = $this->channelsettings;//echo '<pre>';print_r($channelSettings);exit;?>
<?php

$app = & JFactory::getApplication();
if ($app->getTemplate() != 'hulutheme')
{
	echo '<link rel="stylesheet" href="' . JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';

	if ($user->get('id') != '')
	{
		     if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="javascript: submitform();"><?php echo _HDVS_LOGOUT; ?></a></div>
            <?php }else { ?>
                <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo _HDVS_LOGOUT; ?></a></div>
           <?php  }?>



		<?php } else
		{if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><div class="toprightmenu"><a href="index.php?option=com_users&view=registration"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_users&view=login"  alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
           <?php }  else {      ?>
                    <div class="toprightmenu"><a href="index.php?option=com_user&view=register"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_user&view=login" alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
        <?php
                }
			?>

			<?php
		}
}


?>
                    <script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

<script
	type="text/javascript"
	src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/mychannel.js"></script>

<form name="myform" action="" method="post" id="login-form">
	<div class="logout-button">
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $logoutval_2; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/upload_script.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
<div class="player"  id="hsearch">
     <h1>
			<?php echo _HDVS_CHANNEL_SETTINGS;?>
            </h1>
    <div id="clsdetail" class="clearfix">
        <div class="lodinpad moduletable">

            <div class="clear"></div>
            <div>
            <form action="<?php echo JRoute::_( 'index.php?option=com_contushdvideoshare&view=channelsettings' ); ?>" method="post" enctype="multipart/form-data">
            <div class="bot_dot clearfix"><div class="ch_textboxl floatleft"><label><?php echo _HDVS_PLAYER_WIDTH;?></label><input type="text" id="player_width" name="player_width" value="<?php if (isset($channelSettings[0]->player_width)) {
    echo $channelSettings[0]->player_width;
    } ?>" /></div>
            <div class="ch_textboxr floatright"><label><?php echo _HDVS_PLAYER_HEIGHT;?></label><input type="text" id="player_height" name="player_height" value="<?php if (isset($channelSettings[0]->player_height)) {
    echo $channelSettings[0]->player_height;
} ?>"></div></div>
                <div class="bot_dot clearfix"><div class="ch_textboxl floatleft"><label><?php echo _HDVS_NUMBER_ROW;?></label><input type="text" id="video_row" name="video_row" value="<?php if (isset($channelSettings[0]->video_row)) {
    echo $channelSettings[0]->video_row;
} ?>"></div>
            <div class="ch_textboxr floatright"><label><?php echo _HDVS_NUMBER_COLUMNS;?></label><input type="text" id="video_colomn" name="video_colomn" value="<?php if (isset($channelSettings[0]->video_colomn)) {
    echo $channelSettings[0]->video_colomn;
} ?>"></div></div>
                <div class="bot_dot clearfix"><div class="ch_textboxl floatleft"><label><?php echo _HDVS_RECENT_VIDEOS;?></label><select id="recent_videos" name="recent_videos">
                                                <option value="1" <?php if (isset($channelSettings[0]->recent_videos) && $channelSettings[0]->recent_videos == 1) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_ENABLE;?></option>
                                                <option value="0" <?php if (isset($channelSettings[0]->recent_videos) && $channelSettings[0]->recent_videos == 0) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_DISABLE;?></option>
                                            </select></div>
            <div class="ch_textboxr floatright"><label><?php echo _HDVS_POPULAR_VIDEOS;?></label><select id="popular_videos" name="popular_videos">
                                                <option value="1" <?php if (isset($channelSettings[0]->popular_videos) && $channelSettings[0]->popular_videos == 1) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_ENABLE;?></option>
                                                <option value="0" <?php if (isset($channelSettings[0]->popular_videos) && $channelSettings[0]->popular_videos == 0) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_DISABLE;?></option>
                                            </select></div></div>


                <div class="bot_dot clearfix"><div class="ch_textboxl floatleft"><label><?php echo _HDVS_TOPRATED_VIDEOS;?></label><select id="top_videos" name="top_videos">
                                                <option value="1" <?php if (isset($channelSettings[0]->top_videos) && $channelSettings[0]->top_videos == 1) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_ENABLE;?></option>
                                                <option value="0" <?php if (isset($channelSettings[0]->top_videos) && $channelSettings[0]->top_videos == 0) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_DISABLE;?></option>
                                            </select></div>
            <div class="ch_textboxr floatright"><label><?php echo _HDVS_PLAYLIST;?></label><select id="playlist" name="playlist">
                                                <option value="1" <?php if (isset($channelSettings[0]->playlist) && $channelSettings[0]->playlist == 1) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_ENABLE;?></option>
                                                <option value="0" <?php if (isset($channelSettings[0]->playlist) && $channelSettings[0]->playlist == 0) {
    echo 'selected=selected';
} ?>><?php echo _HDVS_DISABLE;?></option>
                                            </select></div></div>


                <div class="bot_dot clearfix"> <div class="ch_textboxl1 floatleft"><label><?php echo _HDVS_ACCESSLEVEL;?></label><input type="radio" name="type" value="1" <?php if (!isset($channelSettings[0]->type) || $channelSettings[0]->type == 1) {
    echo 'checked=checked';
} ?>/> <span><?php echo _HDVS_PUBLIC;?></span>
                                            <input type="radio" name="type" value="0" <?php if (isset($channelSettings[0]->type) && $channelSettings[0]->type == 0) {
    echo 'checked=checked';
} ?>/> <span><?php echo _HDVS_PRIVATE;?></span></div>
            <div class="ch_textboxr floatright"><label><?php echo _HDVS_FB_COMMENT;?></label><select id="fb_comment" name="fb_comment">
                                                <option value="1" <?php if (isset($channelSettings[0]->fb_comment) && $channelSettings[0]->fb_comment == 1) {
                                echo 'selected=selected';
                            } ?>><?php echo _HDVS_ENABLE;?></option>
                                                <option value="0" <?php if (isset($channelSettings[0]->fb_comment) && $channelSettings[0]->fb_comment == 0) {
                                echo 'selected=selected';
                            } ?>><?php echo _HDVS_DISABLE;?></option>
                                            </select></div></div>


               <div class="bot_dot clearfix">  <div class="ch_textboxl1 floatleft"><label><?php echo _HDVS_CHANNEL_VIDEO;?></label><input type="radio" name="start_videotype" id="start_videotype" value="1" onClick="SelectVideo(this.value)" <?php if (!isset($channelSettings[0]->start_videotype) || $channelSettings[0]->start_videotype == 1) {
                                echo 'checked=checked';
                            } ?>/><span><?php echo _HDVS_VIDEO;?></span>
                                            <input type="radio" name="start_videotype" id="start_videotype" value="0" onClick="SelectVideo(this.value)" <?php if (isset($channelSettings[0]->start_videotype) && $channelSettings[0]->start_videotype == 0) {
                                echo 'checked=checked';
                            } ?>/> <span><?php echo _HDVS_SET_PLAYLIST;?></span></div>

                   <div id="my_videos" name="my_videos"  style="display:none;" class="ch_textboxr floatright"><label><?php echo _HDVS_START_VIDEO;?></label><select id="start_video" name="start_video">
            <?php $myVideos = $this->myvideos;
            for($i=0;$i<count($myVideos);$i++) {?>
			  <option <?php if(isset($channelSettings[0]->start_video) && $channelSettings[0]->start_video == $myVideos[$i]->id) { echo 'selected=selected'; }?> value="<?php echo $myVideos[$i]->id;?>"><?php echo $myVideos[$i]->title;?></option>
			  <?php }?>
			</select></div>
                   <div id="my_playlist" name="my_playlist" style="display:none;" class="ch_textboxr floatright"><label><?php echo _HDVS_PLAYLIST;?></label><select id="start_playlist" name="start_playlist">
           <?php $myPlaylist = $this->myplaylist;
           		for($i=0;$i<count($myPlaylist);$i++) {?>
			  <option <?php if(isset($channelSettings[0]->start_playlist) && $channelSettings[0]->start_playlist == $myPlaylist[$i]->id) { echo 'selected=selected'; }?> value="<?php echo $myPlaylist[$i]->id;?>"><?php echo $myPlaylist[$i]->category;?></option>
			  <?php }?>
			</select></div>
                   <div id="bind_value">
                   <?php if(!empty($channelSettings[0]->start_video) && $channelSettings[0]->start_videotype == 1) {?>
			<div class="ch_textboxr floatright">
			<label><?php echo _HDVS_START_VIDEO;?></label>
            <select id="start_video" name="start_video">
            <?php $myVideos = $this->myvideos;
            for($i=0;$i<count($myVideos);$i++) {?>
			  <option <?php if(isset($channelSettings[0]->start_video) && $channelSettings[0]->start_video == $myVideos[$i]->id) { echo 'selected=selected'; }?> value="<?php echo $myVideos[$i]->id;?>"><?php echo $myVideos[$i]->title;?></option>
			  <?php }?>
			</select>
			</div>
			<?php }?>
			<?php if(!empty($channelSettings[0]->start_playlist) && $channelSettings[0]->start_videotype == 0) {?>
                   <div class="ch_textboxr floatright">
                   <label><?php echo _HDVS_PLAYLIST;?></label>
			<select id="start_playlist" name="start_playlist">
           <?php $myPlaylist = $this->myplaylist;
           		for($i=0;$i<count($myPlaylist);$i++) {?>
			  <option <?php if(isset($channelSettings[0]->start_playlist) && $channelSettings[0]->start_playlist == $myPlaylist[$i]->id) { echo 'selected=selected'; }?> value="<?php echo $myPlaylist[$i]->id;?>"><?php echo $myPlaylist[$i]->category;?></option>
			  <?php }?>
			</select> </div>
			<?php }?>
                   </div>
               </div>


                <div class="bot_dot clearfix" style="border:none;"> <div class="ch_textbox2 floatleft"><label><?php echo _HDVS_LOGO;?></label><input type="file" name="logo" id="logo1" style="width: 50%;" />
                        <p style="clear:both;padding-left:115px; "><?php if (isset($channelSettings[0]->logo)) { echo $channelSettings[0]->logo; } ?></p>
                    </div>
			<div class="ch_textboxr floatright"><button class="button floatright" type="submit" onclick="return validation();"><?php echo _HDVS_SAVE;?></button></div></div>

			<input type="hidden" name="controller" value="contushdvideoshare" />
			<input type="hidden" name="option" value="com_contushdvideoshare" />
			<input type="hidden" name="id" value="<?php if(isset($channelSettings[0]->id)) {echo $channelSettings[0]->id; }?>" />
			</form>
            </div></div></div></div>

<script type="text/javascript">
    <?php if (!isset($channelSettings[0]->type)) {?>
    SelectVideo('1');
    <?php }?>
function SelectVideo(val) {
    document.getElementById('bind_value').style.display = "none";
    if(val == 1){
    	document.getElementById('my_videos').style.display = "table-row";
    } else {
    	document.getElementById('my_videos').style.display = "none";
    }
    if(val == 0){
    	document.getElementById('my_playlist').style.display = "table-row";
	} else {
		document.getElementById('my_playlist').style.display = "none";
	}
}
</script>