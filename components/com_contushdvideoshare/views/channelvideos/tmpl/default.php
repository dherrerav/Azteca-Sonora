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
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = & JFactory::getUser();
$session = & JFactory::getSession();
$editing = '';
if ($user->get('id') == '')
{
    $url = $baseurl . "index.php?option=com_user&view=register";
    header("Location: $url");
}
//echo '<pre>';print_r($this->channelvideos);exit;
ob_clean();
?>

<?php $channelVideo = JRequest::getVar('channel_videos');
if(isset($channelVideo) && $channelVideo == "playlist") {?>
		                        <div class="gr c floatleft"  id="popular_videos">
<?php		if(isset($this->channelvideos)) {
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {

                                                        if (($i % $this->channelvideorowcol[0]->video_colomn) == 0)
                                                            {
?>
                                                            <div class="clear"></div>
                                                      <?php } ?>
                                                        <div class="floatleft">
                                        <?php
                                                        if ($this->channelvideos[$i][0]->filepath == "File" || $this->channelvideos[$i][0]->filepath == "FFmpeg")
                                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                                        if ($this->channelvideos[$i][0]->filepath == "Url" || $this->channelvideos[$i][0]->filepath == "Youtube")
                                                            $src_path = $this->channelvideos[$i][0]->thumburl;
                                                        else
                                                        $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                        ?>
<?php
                                                        $oriname = $this->channelvideos[$i][0]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);
                                                        $orititle = $this->channelvideos[$i][0]->title;
                                                        $newtitle = explode(' ', $orititle);
                                                        $displaytitle = implode('-', $newtitle);
                                                        $final = explode('-', $displaytitle);
                                                        $final1 = implode(' ', $final);
                                                        $final2 = explode('and', $final1);
                                                        $displaytitle11 = implode('&', $final2);
?>

                                                        <div class="home-thumb">
                                                            <div class="home-play-container">
                                                                <span class="play-button-hover">

                                                                    <div class="movie-entry yt-uix-hovercard">
                                                                              <div class="tooltip">
                                                                              <?php if(JRequest::getVar('channelid')) {
                                                                              $channelId = JRequest::getVar('channelid')?>
                                           <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&channelid='.$channelId.'&id='.$this->channelvideos[$i][0]->playlistid,true); ?>"><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                                                              <?php }else {?>
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&id='.$this->channelvideos[$i][0]->playlistid,true); ?>"><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                          <?php }?>
                                              </div>


                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div class="show-title-container" style="font-weight: bold;">
                                                                <a href = "" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->channelvideos[$i][0]->title) > 23)
                                                        {
                                                            echo (substr($this->channelvideos[$i][0]->title, 0, 23)) . "...";
                                                        }
                                                        else
                                                        {
                                                            echo $this->channelvideos[$i][0]->title;
                                                        }
?></a>
                                                </div>
                                                <span class="video-info">
                                                      <?php echo $this->channelvideos[$i][0]->category; ?>
                                                </span>
                                                <div class="clsratingvalue">
                                                    <?php //if ($this->sitesettings[0]->ratingscontrol == 1)
                                                           //{ ?>
                                                <span class="floatleft">

                                                <?php
                                                        if (isset($this->channelvideos[$i][0]->ratecount) && $this->channelvideos[$i][0]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->channelvideos[$i][0]->rate / $this->channelvideos[$i][0]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                            <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                    </span>
                                                    <?php //} ?>
                                             </div>
                                             <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                             <span class="floatright viewcolor view"><?php echo $this->channelvideos[$i][0]->times_viewed; ?></span>

                                                        <div class="clear"></div>
                                                    </div>
<?php $j++; ?>
                                                </div>
<?php
                                                    }
?><div class="clear"></div>
<div id="pagination" style="float: right;">
<?php
$channel_id = $this->channelId;
 $page_rows = $this->channelvideorowcol[0]->video_row * $this->channelvideorowcol[0]->video_colomn;
 //$page_rows = 2;
 $rows = count($this->myplaylist);
 $last = ceil($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
 <a onclick="ajaxpagination('<?php echo $prev;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo 'prev';?></a>
 <?php } for($i=1;$i<=$last;$i++) { ?>
 	<a onclick="ajaxpagination('<?php echo $i;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo $i;?></a>
<?php  }
if($curr_page < $last) {
 ?>
 <a onclick="ajaxpagination('<?php echo $next;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo 'next';?></a>
 <?php }?>
 </div>
<?php } else {?>
<b>No Videos</b>
<?php }?>
                                        </div>
<?php }else {?>

                        <div class="gr c floatleft"  id="popular_videos">
<?php		if(isset($this->channelvideos)) {
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {

                                                        if (($i % $this->channelvideorowcol[0]->video_colomn) == 0)
                                                            {
?>
                                                            <div class="clear"></div>
                                                      <?php } ?>
                                                        <div class="floatleft">
                                        <?php
                                                        if ($this->channelvideos[$i]->filepath == "File" || $this->channelvideos[$i]->filepath == "FFmpeg")
                                                            $src_path = JURI::base()."components/com_contushdvideoshare/videos/" . $this->channelvideos[$i]->thumburl;
                                                        if ($this->channelvideos[$i]->filepath == "Url" || $this->channelvideos[$i]->filepath == "Youtube")
                                                            $src_path = $this->channelvideos[$i]->thumburl;
                                                        else
                                                        $src_path = JURI::base()."components/com_contushdvideoshare/videos/" . $this->channelvideos[$i]->thumburl;
                                        ?>
<?php
                                                        $oriname = $this->channelvideos[$i]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);
                                                        $orititle = $this->channelvideos[$i]->title;
                                                        $newtitle = explode(' ', $orititle);
                                                        $displaytitle = implode('-', $newtitle);
                                                        $final = explode('-', $displaytitle);
                                                        $final1 = implode(' ', $final);
                                                        $final2 = explode('and', $final1);
                                                        $displaytitle11 = implode('&', $final2);
                                                        $type  ='';
?>

                                                        <div class="home-thumb">
                                                            <div class="home-play-container">
                                                                <span class="play-button-hover">

                                                                    <div class="movie-entry yt-uix-hovercard">
                                                                              <div class="tooltip">
                                                   <?php if (preg_match('/vimeo/', $this->channelvideos[$i]->videourl)) {
										    	      $split=explode("/",$this->channelvideos[$i]->videourl);
										    	      $vimeoid = $split[3];
                                                    }else {
                                                    $vimeoid = 0; }

    if ($this->channelvideos[$i]->filepath == "File" || $this->channelvideos[$i]->filepath == "FFmpeg"){

        $htmlCode = $this->channelvideos[$i]->vid ;
        $type= 'file';

        } elseif ($this->channelvideos[$i]->filepath == "Youtube")
            {
               if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $this->channelvideos[$i]->videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
                }
        $htmlCode = $videoid;
        $type = "youtube";
           }
                                                    ?>
                                          <a class=" info_hover featured_vidimg" onclick="relatedvideos('<?php echo $this->channelvideos[$i]->vid;?>','<?php echo $vimeoid;?>','<?php echo $htmlCode;?>','<?php echo $type;?>');"><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title="" alt="video" /></p></a>
                                              </div>


                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div class="show-title-container" style="font-weight: bold;">
                                                                <a href = "" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->channelvideos[$i]->title) > 23)
                                                        {
                                                            echo (substr($this->channelvideos[$i]->title, 0, 23)) . "...";
                                                        }
                                                        else
                                                        {
                                                            echo $this->channelvideos[$i]->title;
                                                        }
?></a>
                                                </div>
                                                <span class="video-info">
                                                     <?php echo $this->channelvideos[$i]->category; ?>
                                                </span>
                                                <div class="clsratingvalue">
                                                    <?php //if ($this->sitesettings[0]->ratingscontrol == 1)
                                                           //{ ?>
                                                <span class="floatleft">

                                                <?php
                                                        if (isset($this->channelvideos[$i]->ratecount) && $this->channelvideos[$i]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->channelvideos[$i]->rate / $this->channelvideos[$i]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                            <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                    </span>
                                                    <?php //} ?>
                                             </div>
                                             <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                             <span class="floatright viewcolor view"><?php echo $this->channelvideos[$i]->times_viewed; ?></span>

                                                        <div class="clear"></div>
                                                    </div>
<?php $j++; ?>
                                                </div>
<?php
                                                    }
?><div class="clear"></div>
<div id="pagination" style="float: right;">
<?php
$channel_id = $this->channelId;
 $page_rows = $this->channelvideorowcol[0]->video_row * $this->channelvideorowcol[0]->video_colomn;
 //$page_rows = 2;
 $rows = count($this->myvideos);
 $last = ceil($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
 <a onclick="ajaxpagination('<?php echo $prev;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo 'prev';?></a>
 <?php } for($i=1;$i<=$last;$i++) { ?>
 	<a onclick="ajaxpagination('<?php echo $i;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo $i;?></a>
<?php  }
if($curr_page < $last) {
 ?>
 <a onclick="ajaxpagination('<?php echo $next;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo 'next';?></a>
 <?php }?>
 </div>
<?php } else {?>
<b>No Videos</b>
<?php }?>
                                        </div>
                                        <?php }exit();?>


