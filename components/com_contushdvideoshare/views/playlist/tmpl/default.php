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
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = & JFactory::getUser();
$session = & JFactory::getSession();
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$editing = '';
$requestpage = '';
$requestpage = JRequest::getVar('page', '', 'post', 'int');
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
<div class="player clearfix">

<div id="add_playlist" style="display: none;">
            <h1 class="uploadtitle">
			<?php echo _HDVS_CREATE_PLAYLIST;?>
            </h1>
            <div class="clear"></div>

            <div>
            <form action="<?php echo JRoute::_( 'index.php?option=com_contushdvideoshare&view=playlist' ); ?>" method="post">
                <div  style="float: left;padding: 5px 0 15px 0;"><label><b><?php echo _HDVS_PLAYLIST_NAME;?></b></label>
            <input type="text" id="category" name="category" ></div>

            <div class="clear"></div>
            <h1 Style="width:auto;text-decoration: underline;border:none;font-size: 15px;"><?php echo _HDVS_PLAYLIST_COMMENT;?></h1>
            <?php $myVideos = $this->myvideos;
            for($i=0;$i<count($myVideos);$i++) {
            if ($myVideos[$i]->filepath == "File" || $myVideos[$i]->filepath == "FFmpeg")
            $src_path = "components/com_contushdvideoshare/videos/" . $myVideos[$i]->thumburl;
            if ($myVideos[$i]->filepath == "Url" || $myVideos[$i]->filepath == "Youtube")
            $src_path = $myVideos[$i]->thumburl;?>
            <div  style="float: left;padding:5px;">
            <input type="checkbox" name="playlist_videos[]" value="<?php echo $myVideos[$i]->id;?>"/>
                                        <?php
                                         if (strlen($myVideos[$i]->title) > 23)
                                        {
                                            //echo JHTML::_('string.truncate', ($myVideos[$i]->title), 23);
                                            echo (substr($myVideos[$i]->title, 0, 10)) . "..";
                                        }else {
                                            echo $myVideos[$i]->title;
                                        }
					?>									<div class="movie-entry yt-uix-hovercard">
                                                                              <div class="tooltip">
                                          <p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p>
                                              </div>
                                                                    </div>
                                                                    </div>




            <?php }?>
            <div class="clear"></div>
                <button class="button floatright" type="button" onclick="cancelplaylist();"><?php echo _HDVS_CANCEL;?></button>
                <button style="margin-right:10px;" class="button floatright" type="submit" onclick="return playlistvalidation();"><?php echo _HDVS_SAVE;?></button>

			<input type="hidden" name="controller" value="contushdvideoshare" />
			<input type="hidden" name="option" value="com_contushdvideoshare" />
			</form>
            </div>
            <div class="clear"></div>
         </div>
<?php if(JRequest::getString('category')) {?>
<div id="playlist_videos">
<div class="section videoscenter" >
    <div class="standard tidy">
        <div class="layout b-c">
            <div class="gr b" >
                <div class="layout a-b-c">
                    <div class="gr a">
                        <div class="callout-header-home titlespace">
                            <h1 class="home-link hoverable"><?php echo $this->playlistvideos[0]->category; ?></h1>
                        </div>
                        <table>
                            <?php
                            $totalrecords = 12;
                            if (count($this->playlistvideos) - 4 < $totalrecords)
                            {
                                $totalrecords = count($this->playlistvideos) - 4;
                            }
                            $no_of_columns = 4;
                            $current_column = 1;
                            for ($i = 0; $i < $totalrecords; $i++)
                            {
                                $colcount = $current_column % $no_of_columns;
                                if ($colcount == 1)
                                {
                                    echo '<tr>';
                                }
//For SEO settings
                                //$seoOption = $this->playlistvideosrowcol[0]->seo_option;

                                    $popularCategoryVal = "catid=" . $this->playlistvideos[$i]->catid;
                                    $popularVideoVal = "title=" . $this->playlistvideos[$i]->title;
                                    $channelIdval = "channelname=".$this->channelName;

                                if ($this->playlistvideos[$i]->filepath == "File" || $this->playlistvideos[$i]->filepath == "FFmpeg")
                                    $src_path = "components/com_contushdvideoshare/videos/" . $this->playlistvideos[$i]->thumburl;
                                if ($this->playlistvideos[$i]->filepath == "Url" || $this->playlistvideos[$i]->filepath == "Youtube")
                                    $src_path = $this->playlistvideos[$i]->thumburl;
                            ?>
                                <td class="rightrate">
                                <?php
                                $orititle = $this->playlistvideos[$i]->title;       //Title name changed here for seo url purpose
                                $newtitle = explode(' ', $orititle);
                                $displaytitle1 = implode('-', $newtitle);
                                $displaytitle = str_replace('.', '', $displaytitle1);
                                $final = explode('-', $displaytitle);
                                $final1 = implode(' ', $final);
                                $final2 = explode('and', $final1);
                                $displaytitle11 = implode('&', $final2);
                                ?>
                                <div class="home-thumb">
                                    <div class="home-play-container" >
                                        <span class="play-button-hover">
                                            <div class="movie-entry yt-uix-hovercard">

                                                <div class="tooltip">
                                                 <a class=" info_hover featured_vidimg" href="<?php echo 'index.php?option=com_contushdvideoshare&view=mychannel&'.$channelIdval.'&'.$popularVideoVal; ?>" class="info_hover" >
                                                    <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></a>



                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="show-title-container">
                                        <a href="<?php echo 'index.php?option=com_contushdvideoshare&view=player&'.$popularCategoryVal.'&'.$popularVideoVal; ?>" class="show-title-gray info_hover">
                                        <?php
                                        if (strlen($this->playlistvideos[$i]->title) > 23)
                                        {
                                            echo JHTML::_('string.truncate', ($this->playlistvideos[$i]->title), 23);
                                            //echo (substr($this->rs_playlist1[0][$i]->title, 0, 23)) . "...";
                                        }else {
                                            echo $this->playlistvideos[$i]->title;
                                        }
//                                                    if (strlen($this->playlistvideos[$i]->title) > 18)
//                                                    {
//                                                        echo (substr($this->playlistvideos[$i]->title, 0, 18)) . "...";
//                                                    }
//                                                    else
//                                                    {
//                                                        echo $this->playlistvideos[$i]->title;
//                                                    }
?></a>
                                                </div>
                                                <span class="video-info">
 <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&'.$popularCategoryVal);?>"><?php echo $this->playlistvideos[$i]->category; ?></a>
                                                    </span>
                                        <?php $var = 1;if ($var == 1)
                                                {
                                         ?>
                                                    <span class="floatleft">

                                        <?php
                                                        if (isset($this->playlistvideos[$i]->ratecount) && $this->playlistvideos[$i]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->playlistvideos[$i]->rate / $this->playlistvideos[$i]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                        ?>
                                                            <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                        </span>
<?php } ?>

                                    <?php //if ($this->playlistvideosrowcol[0]->viewedconrtol == 1)
                                            //{
                                    ?>

                                                            <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                                            <span class="floatright viewcolor view"><?php echo $this->playlistvideos[$i]->times_viewed; ?></span>

                                       <?php //} ?>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </td>
                            <?php
                                                    if ($colcount == 0)
                                                    {
                                                        echo '</tr><div class="clear"></div>';
                                                        $current_column = 0;
                                                    }
                                                    $current_column++;
                                                }
                                                if ($current_column != 0)
                                                {
                                                    $rem_columns = $no_of_columns - $current_column + 1;
                                                    echo "<td colspan=$rem_columns></td></tr>";
                                                }
                            ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0"   class="page_align"   id="pagination" >
                            <tr align="right">
                                <td align="right"  class="page_rightspace">
                                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                        <tr>
                        <?php
                                                $pages = $this->playlistvideos['pages'];
                                                $q = $this->playlistvideos['pageno'];
                                                $q1 = $this->playlistvideos['pageno'] - 1;
                                                if ($this->playlistvideos['pageno'] > 1)
                                                    echo("<td align='right'><a onclick='changepage($q1);'>" . _HDVS_PREVIOUS . "</a></td>");
                                                if ($requestpage)
                                                 {
                                                    if ($requestpage > 3)
                                                      {
                                                        $page = $requestpage - 2;
                                                        if ($requestpage > 2)
                                                        {
                                                            echo("<td align='right'><a onclick='changepage(1)'>1</a></td>");
                                                            echo ("<td align='right'>...</td>");
                                                        }
                                                    }
                                                    else
                                                        $page=1;
                                                }
                                                else
                                                    $page=1;
                                                if($pages>1){
                                                for ($i = $page, $j = 1; $i <= $pages; $i++, $j++)
                                                {
                                                    if ($q != $i)
                                                        echo("<td align='right'><a onclick='changepage(" . $i . ")'>" . $i . "</a></td>");
                                                    else
                                                        echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                                                    if ($j > 3)
                                                        break;
                                                }
                                                if ($i < $pages)
                                                {
                                                    if ($i + 1 != $pages)
                                                        echo ("<td align='right'>....</td>");
                                                    echo("<td align='right'><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></td>");
                                                }
                                                $p = $q + 1;
                                                if ($q < $pages)
                                                    echo ("<td align='right'><a onclick='changepage($p);'>" . _HDVS_NEXT . "</a></td>");}
                        ?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

<?php
                                                $page = $_SERVER['REQUEST_URI'];
                                                $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                                $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                                                $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                                                if ($requestpage)
                                                {
                                                    $hidden_page = $requestpage;
                                                } else {
                                                    $hidden_page = '';
                                                }
                                                if ($searchtextbox) {
                                                    $hidden_searchbox = $searchtextbox;
                                                } else {
                                                    $hidden_searchbox = $hiddensearchbox;
                                                }
?>
                                                <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                                                    <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                                                    <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                                                </form>
                            <script type="text/javascript">
                                function changepage(pageno)
                                {
                                    document.getElementById("page").value=pageno;
                                    document.pagination.submit();
                                }
                            </script>


</div>
<?php }else {?>
<div id="playlist">
<h1><?php echo _HDVS_MY_PLAYLISTS;?></h1> <button id="addnewbutton" type="button" class="button floatright" onclick="addplaylist()"><?php echo _HDVS_ADD_NEW;?></button>
<?php //echo '<pre>';print_r($this->playlist);exit;?>
<?php		if(isset($this->channelvideos)) {
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {?>
                                                    <?php
                                                        if ($this->channelvideos[$i][0]->filepath == "File" || $this->channelvideos[$i][0]->filepath == "FFmpeg")
                                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                                        if ($this->channelvideos[$i][0]->filepath == "Url" || $this->channelvideos[$i][0]->filepath == "Youtube")
                                                            $src_path = $this->channelvideos[$i][0]->thumburl;
                                                        else
                                                        $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                        ?>
                                        <div  style="float: left;padding:5px;">
                                        <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&category='.$this->channelvideos[$i][0]->category,true); ?>"><?php echo $this->channelvideos[$i][0]->category; ?></a>
														<div class="movie-entry yt-uix-hovercard">
                                                                              <div class="tooltip">
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&category='.$this->channelvideos[$i][0]->category,true); ?>"><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                              </div>


                                                                    </div>
                                                                    </div>
                                                  <?php   }
?><div class="clear"></div>
<div>
<?php
$channel_id = JRequest::getVar('channelid');
 $page_rows = 12;
 $rows = count($this->channelvideos);
 $last = round($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
 <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$prev,true); ?>"><?php echo 'prev';?></a>
 <?php }
 for($i=1;$i<=$last;$i++) { ?>
 	<a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$i,true); ?>"><?php echo $i;?></a>
<?php  }
if($curr_page <= $last) {
 ?>
 <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$next,true); ?>"><?php echo 'next';?></a>
 <?php }?>
 </div>
<?php } else {?>
<b><?php echo _HDVS_NO_PLAYLIST;?></b>
<?php }?>
</div>
<?php }?>
</div>