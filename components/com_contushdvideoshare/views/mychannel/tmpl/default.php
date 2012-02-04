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
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$user = & JFactory::getUser();
$session = & JFactory::getSession();
$editing = '';
$editor = & JFactory::getEditor();
$mobile = detect_mobile();
$baseurl = JURI::base();
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
<script
	src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
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
<?php if(isset($this->channeldetails[0])) {
		$channelDetails = $this->channeldetails[0];
	}?>
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

<form name="myform" action="" method="post" id="login-form">
	<div class="logout-button">
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $logoutval_2; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<script type="text/javascript">
            window.onload = function(){
            var videodetails=new Array();
            var video_src = "<?php echo JURI::getInstance()->toString(); ?>";
            var pagevalues = "<?php echo JURI::base();?>index.php?option=com_contushdvideoshare&amp;view=mychannel";
            var bookmark = "http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $this->frontvideodetails[0]->title; ?>&p[summary]=<?php echo $this->frontvideodetails[0]->description; ?>&p[medium]="+escape('103')+"&p[video][src]="+escape(video_src)+"&p[url]="+escape(pagevalues)+"&p[images][0]=<?php echo $this->frontvideodetails[0]->thumburl; ?>&redirect_uri=<?php echo urlencode(JRoute::_(JURI::current().'index.php?option=com_contushdvideoshare&view=mychannel'));?>";
            var cmdoption = 1;
            if(cmdoption == 1){
                 document.getElementById('theFacebookComment').style.display = 'block';
            }

            facebook_share_code(bookmark);
            }
            function facebook_share_code(bookmarkf){
                document.getElementById('fbshare').href=bookmarkf;
            }
      </script>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/autoHeight.js"></script>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<script
	type="text/javascript"
	src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/mychannel.js"></script>
<script
	type="text/javascript"
	src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
<div class="player clearfix">
    <?php
if(isset($this->channelvideorowcol[0]->logo)) {?>
    <div class="bot_dot clearfix">
    <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/<?php echo $this->channelvideorowcol[0]->logo;?>" alt="logo" width="36" height="41" />
<h1><?php echo $channelDetails->channel_name;?></h1>
</div>
<?php } else {?>
<div class="bot_dot clearfix">
<img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/default_thumb.jpg" alt="logo" width="36" height="41" class="floatleft"/>
<h1 class="imgtit">HD Videoshare</h1>
</div>
<?php } if(isset($this->channelvideorowcol[0])) {?>
	<div id="videoplayer" style="padding: 5px;">

		<?php if(isset($this->frontvideodetails[0])) {
			$frontVideo = $this->frontvideodetails[0]->id;
			if(JRequest::getVar('title')) {
				$frontVideo = $this->videoid;
			}

                         $width = $this->channelvideorowcol[0]->player_width;
			$height = $this->channelvideorowcol[0]->player_height;
if($mobile === true){
   if ($this->frontvideodetails[0]->filepath == "File" || $this->frontvideodetails[0]->filepath == "FFmpeg"){?>
    <video id="video" src="<?php echo $frontVideo; ?>"  autobuffer controls onerror="failed(event)" width="701" height="303">
             Html5 Not support This video Format.
     </video>
   <?php } elseif ($this->frontvideodetails[0]->filepath == "Youtube")
            {
               if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $this->frontvideodetails[0]->videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
                }
?>
               <iframe  type="text/html" width="<?php echo $width;?>" height="<?php echo $height;?>" src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0">
               </iframe>
<?php
           }
}else{

                        if($this->channelvideorowcol[0]->start_videotype == 1) {
			if (preg_match('/vimeo/', $this->frontvideodetails[0]->videourl)) {
				$split=explode("/",$this->frontvideodetails[0]->videourl);?>
		<iframe
			src="http://player.vimeo.com/video/<?php echo $split[3];?>?title=0&amp;byline=0&amp;portrait=0"
			width="<?php echo $width;?>" height="<?php echo $height;?>"
			frameborder="0" webkitAllowFullScreen mozallowfullscreen
			allowFullScreen></iframe>
			<?php } else {?>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
			width="<?php echo $width;?>" height="<?php echo $height;?>">
			<param name="movie"
				value="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=playerbase" />
			<param name="flashvars"
				value="id=<?php echo $frontVideo;?>&baserefJ=<?php echo JURI::base(); ?>&autoplay=false" />
			<param name="allowFullScreen" value="true" />
			<param name="wmode" value="transparent" />
			<param name="allowscriptaccess" value="always" />
			<embed src="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=playerbase"flashvars="id=<?php echo $frontVideo;?>&baserefJ=<?php echo JURI::base(); ?>&autoplay=false" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>
		</object>
		<?php } } else {?>
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
			width="<?php echo $width;?>" height="<?php echo $height;?>">
			<param name="movie"
				value="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=playerbase" />
			<param name="flashvars"
				value="baserefJ=<?php echo JURI::base(); ?>&id=<?php echo $frontVideo;?>&catid=<?php echo $this->channelvideorowcol[0]->start_playlist;?>&autoplay=false" />
			<param name="allowFullScreen" value="true" />
			<param name="wmode" value="transparent" />
			<param name="allowscriptaccess" value="always" />
			<embed src="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=playerbase"flashvars="id=<?php echo $frontVideo;?>&catid=<?php echo $this->channelvideorowcol[0]->start_playlist;?>&baserefJ=<?php echo JURI::base(); ?>&autoplay=false" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>
		</object>
            <?php } }?>
	</div>
	<script type="text/javascript">
    function relatedvideos(vid,vimeoid,htmlcode,vtype){
        <?php if($mobile === true){?>
                if(vtype =='file')
                    {
var playerCode ='<video id="video" src="'+htmlcode+'"  autobuffer controls onerror="failed(event)" width="600" height="400">Html5 Not support This video Format.</video>';
                    }
            else if(vtype =='youtube')
                    {
var playerCode ="<iframe type='text/html' width='600' height='400' src='http://www.youtube.com/embed/"+htmlcode+"' frameborder='0'></iframe>";
                    }

<?php }else{?>
        document.getElementById("video_id").value=vid;
    	var baseurl = '<?php echo JURI::base()?>';
    	var width = '<?php echo $width;?>';
    	var height = '<?php echo $height;?>';
    	//var vimeoId = vimeoid;
    	if(vimeoid == 0) {
        	var playerCode = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\" width="+ width+" height="+ height+"><param name=\"movie\" value="+ baseurl+"index.php?option=com_contushdvideoshare&view=playerbase\" /><param name=\"flashvars\" value=\"id="+ vid+"&baserefJ="+ baseurl+"&autoplay=false\" /><param name=\"allowFullScreen\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /><param name=\"allowscriptaccess\" value=\"always\" /><embed src=\""+ baseurl+"index.php?option=com_contushdvideoshare&view=playerbase\"flashvars=\"id="+ vid+"&baserefJ="+ baseurl+"&autoplay=false\" style=\"width:"+ width+"px;height:"+ height+"px\" allowFullScreen=\"true\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\" wmode=\"transparent\"></embed></object>";
    	}else {
    		var playerCode = "<iframe src=\"http://player.vimeo.com/video/"+vimeoid+"?title=0&amp;byline=0&amp;portrait=0\" width="+ width+" height="+ height+" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
		}
                <?php }?>
    	document.getElementById('videoplayer').innerHTML = playerCode;
    	}
    </script>
    <input type="hidden" id="video_id" value="">
    <table style="width:<?php if(isset ($width)) { echo $width;} ?>px;">
		<tr style="width:100%;">
                    <td style="width:50%;">
				<div class="centermargin">
					<div contentEditable='false' unselectable='true'>
						<div class="rateimgleft" id="rateimg"
							onmouseover="displayrating('');" onmouseout="resetvalue();">
							<div id="a" class="floatleft"></div>
							<?php
							if (isset($this->frontvideodetails[0]->ratecount) && $this->frontvideodetails[0]->ratecount != 0)
							{
								$ratestar = round($this->frontvideodetails[0]->rate / $this->frontvideodetails[0]->ratecount);
								$ratecount = $this->frontvideodetails[0]->ratecount;
							}
							else
							{
								$ratestar = 0;
								$ratecount = 0;
							}
							?>
							<ul class="ratethis " id="rate">
								<li class="one"><a title="1 Star Rating" onclick="getrate('1');"
									onmousemove="displayrating('1');" onmouseout="resetvalue();">1</a>
								</li>
								<li class="two"><a title="2 Star Ratings"
									onclick="getrate('2');" onmousemove="displayrating('2');"
									onmouseout="resetvalue();">2</a>
								</li>
								<li class="three"><a title="3 Star Ratings"
									onclick="getrate('3');" onmousemove="displayrating('3');"
									onmouseout="resetvalue();">3</a>
								</li>
								<li class="four"><a title="4 Star Ratings"
									onclick="getrate('4');" onmousemove="displayrating('4');"
									onmouseout="resetvalue();">4</a>
								</li>
								<li class="five"><a title="5 Star Ratings"
									onclick="getrate('5');" onmousemove="displayrating('5');"
									onmouseout="resetvalue();">5</a>
								</li>
							</ul></div>
							<div class="floatleft">
								<div class="rateright-views" >
									<span class="clsrateviews" id="ratemsg"
										onmouseover="displayrating('');" onmouseout="resetvalue();"> </span>
									 <span class="rightrateimg" id="ratemsg1"
										onmouseover="displayrating('');" onmouseout="resetvalue();"> </span>

								</div>
							</div>


					</div>
				</div>
			</td>
                        <td style="width:50%;">

				<div class="video_addedon">
                                        <span><b><?php echo _HDVS_VIEWS;?>: </b></span><span style="padding-right:10px;" id="views"></span>
					<span class="addedon"><b><?php echo _HDVS_ADDED_ON;?>: </b></span><span id="createdate"></span>
				</div>
			</td>
		</tr>
	</table>
<?php } else {?>
<div class="novideo"><?php echo _HDVS_FRONTEND_MSG;?></div><?php }?>
    <h3 id="viewtitle"></h3>
    <div id="share">
	<div class="floatleft">
	<a href="" class="fbshare" id="fbshare" target="_blank" ></a>
	<?php $pageURL = str_replace('&', '%26', JURI::getInstance()->toString()); ?>
                        <iframe
                            src="http://www.facebook.com/plugins/like.php?href=<?php echo $pageURL; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21"
                            scrolling="no" frameborder="0"
                            style="border: none; overflow: hidden; width: 100px; height: 25px;"
                            allowTransparency="true"> </iframe>
                    </div>
	</div>
	<div class="floatleft" style="width:105px">
                                <a href="http://twitter.com/share" class="twitter-share-button"
                                   data-count="horizontal">Tweet</a>
                                <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <div class="floatleft" style="width:70px">
                                <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                                <div class="g-plusone" data-size="medium" data-count="true"></div>
    </div><div class="clear"></div>
	<?php if(isset($this->channelvideorowcol[0]->fb_comment) && $this->channelvideorowcol[0]->fb_comment == 1 && isset($this->frontvideodetails[0])) {?>

    <div class="fbcomments" id="theFacebookComment">
                        <h1>Add Your Comments</h1>
                        <br />
                        <?php $facebookapi = '';
                        if(isset($this->sitesettings[0]->facebookapi)) {
                        	$facebookapi = $this->sitesettings[0]->facebookapi; }
                        ?>
                        <div id ="face-comments">
                        <script>
                            window.fbAsyncInit = function() {
                                FB.init({
                                    appId  : "<?php echo $facebookapi; ?>",
                                    status : true, // check login status
                                    cookie : true, // enable cookies to allow the server to access the session
                                    xfbml  : true  // parse XFBML
                                });
                            };
                            (function() {
                                var e = document.createElement('script');
                                e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                                e.async = true;
                                document.getElementById('face-comments').appendChild(e);
                            }());
                        </script>
                            <fb:comments xid="<?php if(isset ($this->frontvideodetails[0])) { echo $this->frontvideodetails[0]->id;} ?>" css="facebook_style.css" simple="1" href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="<?php if(isset ($width)) { echo $width;} ?>" ></fb:comments>
                        </div>
    </div>

	<?php }} else {?>
	<div class="novideo"><?php echo _HDVS_CHANNEL_ALERT;?></div>
	<?php }?>

	<?php $channelId = '';
	if(JRequest::getVar('channelname')) {
		$channelId = $this->channelId;
	}else {
		$channelId = '';
	}
	?>
        <div id="clstabmenu" style="overflow: hidden;">
            <script type="text/javascript">
                var startno = 1001;
<?php if (isset($this->channelvideorowcol[0]->popular_videos) && $this->channelvideorowcol[0]->popular_videos == 1) { ?>
                    startno = 1001;
<?php } elseif (isset($this->channelvideorowcol[0]->recent_videos) && $this->channelvideorowcol[0]->recent_videos == 1) { ?>
                   startno = 1002;
<?php } elseif (isset($this->channelvideorowcol[0]->top_videos) && $this->channelvideorowcol[0]->top_videos == 1) { ?>
                    startno = 1003;
<?php } else {?>
    startno = 1004;
    <?php }?>

            </script>
            <h1><?php echo _HDVS_SORT_VIDEOS;?></h1>
	<?php if(isset($this->channelvideorowcol[0]->popular_videos) && $this->channelvideorowcol[0]->popular_videos == 1) {?>
            <button class="button" id="1001" type="button" style="cursor: pointer"
			onclick="channelvideos('popular','<?php echo $channelId?>','1001',startno)"><?php echo _HDVS_POPULAR_VIDEOS;?></button>
			<?php } if(isset($this->channelvideorowcol[0]->recent_videos) && $this->channelvideorowcol[0]->recent_videos == 1) {?>
		<button class="button" id="1002" type="button" style="cursor: pointer"
			onclick="channelvideos('recent','<?php echo $channelId?>','1002',startno)"><?php echo _HDVS_RECENT_VIDEOS;?></button>
			<?php } if(isset($this->channelvideorowcol[0]->top_videos) && $this->channelvideorowcol[0]->top_videos == 1) {?>
		<button class="button" id="1003" type="button" style="cursor: pointer"
			onclick="channelvideos('toprated','<?php echo $channelId?>','1003',startno)"><?php echo _HDVS_TOPRATED_VIDEOS;?></button>
			<?php } if(isset($this->channelvideorowcol[0]->playlist) && $this->channelvideorowcol[0]->playlist == 1) {?>
		<button class="button" id="1004" type="button" style="cursor: pointer"
			onclick="channelvideos('playlist','<?php echo $channelId?>','1004',startno)"><?php echo _HDVS_MY_PLAYLISTS;?></button>
			<?php }?>
	</div>

        <div id="channel_videos">
	<script type="text/javascript">
            <?php if($this->channelvideorowcol[0]->popular_videos == 1) {?>
	channelvideos('popular','<?php echo $channelId;?>','1001',startno);
        <?php } elseif($this->channelvideorowcol[0]->recent_videos == 1) {?>
            channelvideos('recent','<?php echo $channelId?>','1002',startno);
            <?php } elseif($this->channelvideorowcol[0]->top_videos == 1) {?>
                channelvideos('toprated','<?php echo $channelId?>','1003',startno);
                <?php } elseif($this->channelvideorowcol[0]->playlist == 1) {?>
                    channelvideos('playlist','<?php echo $channelId?>','1004',startno);
                    <?php }?>
	</script>
	</div>

        <?php if(isset($channelDetails)) {?>
			<div class="description_display">

				<h1><?php echo _HDVS_DESCRIPTION;?></h1>
				<?php if(isset($channelDetails->description)) { echo $channelDetails->description; }?>
			</div>
			<?php } ?>
	<div class="clear"></div>
	<div class="channeldetails">
        <div class="channelhead">
            <h1><?php echo _HDVS_CHANNEL_DETAILS;?></h1>
	<?php if(!JRequest::getVar('channelname')) {?>
			<button class="button" type="button" id="editbtn" onclick="editchannel()"><?php echo _HDVS_EDIT;?></button>
		<?php }?></div>
            <div id="channel_details">
            <?php if(isset($channelDetails)) {?>

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

			<?php } else{?>

                    <div class="bot_dot1 clearfix"><div class="leftdiv"><?php echo _HDVS_CHANNEL_VIEWS;?> :</div>
					<div class="rightdiv">0</div></div>
                    <div class="bot_dot1 clearfix"><div class="leftdiv"><?php echo _HDVS_TOTAL_UPLOADS;?> :</div>
                        <div class="rightdiv">0</div></div>
                        <div class="bot_dot1 clearfix"><div class="leftdiv"><?php echo _HDVS_RECENT_ACTIVITY;?> :</div>
					<div class="rightdiv">0</div></div>

			<?php }?>
<script type="text/javascript">
                    function editchannel() {
	if(document.getElementById('edit_channel').style.display = "none") {
	document.getElementById('edit_channel').style.display = "block";
	document.getElementById('channel_details').style.display = "none";
        document.getElementById('editbtn').style.display = "none";
	}
}
function searchchannel() {
	if(document.getElementById('search_channel').style.display = "none") {
	document.getElementById('search_channel').style.display = "block";
         document.getElementById('cancel_search').style.display = "none";
	}
}
function cancelChannel() {
	document.getElementById('search_channel').style.display = "none";
        document.getElementById('cancel_search').style.display = "block";
        document.getElementById('output').style.display = "none";

}
function cancelChanneldetail() {
    document.getElementById('edit_channel').style.display = "none";
    document.getElementById('channel_details').style.display = "block";
    document.getElementById('editbtn').style.display = "block";
}
</script>
                    </div>
                <div id="edit_channel" style="display: none;">

                    <div class="bot_dot1 clearfix">
                            <div class="leftdiv"><?php echo _HDVS_CHANNEL_NAME;?></div>
                            <div class="rightdiv"><input type="text" id="channel_name" name="channel_name"
						value="<?php if(isset($channelDetails->channel_name)) { echo $channelDetails->channel_name; }?>" />
					</div>
				</div>
				<div class="bot_dot1 clearfix">
					<div class="leftdiv"><?php echo _HDVS_DESCRIPTION;?></div>
					<div class="rightdiv">

                                            <div id="clsinsertbtns">
                                                <?php
					if(isset($channelDetails->description))	{
						$channelDescription = $channelDetails->description;
					}	else {
						$channelDescription = '';
					}
				 echo $editor->display( 'description',  $channelDescription , '100%', '300', '75', '20' ) ;?>
                                            </div></div>
				</div>
                    <div class="bot_dot1 clerfix">
                        <div class="leftdiv"><?php echo _HDVS_ABOUT_ME;?></div>
                        <div class="rightdiv"><textarea name="about_me" id="about_me" ><?php if(isset($channelDetails->about_me)) { echo $channelDetails->about_me; }?></textarea></div>
				</div>
                    <div class="bot_dot1 clearfix">
                        <div class="leftdiv"><?php echo _HDVS_TAGS;?></div>
					<div class="rightdiv"><textarea name="tags" id="tags" rows="2" cols="20"><?php if(isset($channelDetails->tags)) { echo $channelDetails->tags; }?></textarea><!--Separated by space--></div>
				</div>
                    <div class="bot_dot1 clearfix">
                        <div class="leftdiv"><?php echo _HDVS_WEBSITE;?></div>
                        <div class="rightdiv"><input type="text" id="website" name="website" 	value="<?php if(isset($channelDetails->website)) { echo $channelDetails->website; }?>" />
					</div>
				</div>
				<div class="bot_dot1 clearfix">

					<button class="button floatright" type="button"
							onclick="cancelChanneldetail();"><?php echo _HDVS_CANCEL;?></button>
                                        <button style="margin-right:10px;"  class="button floatright" type="button"
							onclick="return editChanneldetail();"><?php echo _HDVS_SAVE;?></button>
				</div>

		</div></div>

		<div id="edit_channeldetails"></div>
		<input type="hidden" name="controller" value="contushdvideoshare" /> <input
			type="hidden" name="option" value="com_contushdvideoshare" /> <input
			type="hidden" name="channelid" id="channelid"
			value="<?php if(isset($channelDetails->id)) {echo $channelDetails->id; }?>" />


		<div id="other_channels">
                    <div class="channelhead"><h1><?php echo _HDVS_FAVORITE_CHANNEL;?></h1>
			<?php if(!JRequest::getVar('channelname')) {?>
				<button class="button" type="button" id="cancel_search" onclick="searchchannel()"><?php echo _HDVS_ADD;?></button>
			<?php }?>
                        </div>
			<div id="output"></div>
			<?php if(isset($this->otherchannels)) {for($i=0;$i<count($this->otherchannels);$i++) {?>
                        <div class="bot_dot2" id="<?php echo $this->otherchannels[$i]->other_channel?>"><div class="leftdiv">
                                <?php if($this->otherchannels[$i]->logo) {?>
                                <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/<?php echo $this->otherchannels[$i]->logo;?>" alt="logo" width="36" height="41" class="floatleft"/>
                                <?php } else {?>
                                <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/default_thumb.jpg" alt="logo" width="36" height="41" class="floatleft"/>
                                <?php }?>
                                <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=mychannel&channelname='.$this->otherchannels[$i]->channel_name,true); ?>"><?php echo $this->otherchannels[$i]->channel_name?></a>
                            </div>
                                <?php if(!JRequest::getVar('channelname')) {?>

                            <div class="rightdiv clsdeletebtn"><button class="button" type="submit" onclick="deleteChannel('<?php echo $this->otherchannels[$i]->other_channel;?>');" style=" margin-top: 10px;"><?php echo _HDVS_DELETE;?></button></div>



                                <?php }?>
                                </div>
				<?php }
			}
			?>

			<div id="search_channel" style="display: none;">
                            <div id="channel_list"></div>
                            <div class="bot_dot3">
                                <div class="leftdiv"><input type="text" id="other_channel" name="other_channel"
							value="" /></div>
						<div class="rightdiv"><button class="button floatright" type="submit" onclick="return otherChannel()"><?php echo _HDVS_SEARCH;?></button>
						</div>
					</div>
                            <div class="bot_dot3">
                                <div class="leftdiv">
                                    <button class="button" type="submit" onclick="applyChannel()" style="margin-right: 8px;"><?php echo _HDVS_APPLY;?></button>
                                    <button class="button" type="submit" onclick="cancelChannel()"><?php echo _HDVS_CANCEL;  ?></button>
						</div>
					</div>


			</div>
		</div>
</div>

<input type="hidden" name="id" id="id" value="">
<input type="hidden" value="" id="storeratemsg" >
	<script type="text/javascript">

function createObject()
{
var request_type;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
    request_type = new ActiveXObject("Microsoft.XMLHTTP");
}else{
    request_type = new XMLHttpRequest();
}
return request_type;
}
var http = createObject();
var nocache = 0;
function getrate(t)
{

if(t=='1')
{
    document.getElementById('rate').className="ratethis onepos";
    document.getElementById('a').className="ratethis onepos";

}
if(t=='2')
{
    document.getElementById('rate').className="ratethis twopos";
    document.getElementById('a').className="ratethis twopos";

}
if(t=='3')
{
    document.getElementById('rate').className="ratethis threepos";
    document.getElementById('a').className="ratethis threepos";

}
if(t=='4')
{
    document.getElementById('rate').className="ratethis fourpos";
    document.getElementById('a').className="ratethis fourpos";
}
if(t=='5')
{
    document.getElementById('rate').className="ratethis fivepos";
    document.getElementById('a').className="ratethis fivepos";
}
document.getElementById('rate').style.display="none";
document.getElementById('ratemsg').innerHTML="Thanks for rating!";

var id= document.getElementById('id').value;

nocache = Math.random();

http.open('get', 'index.php?option=com_contushdvideoshare&view=player&ajaxview=&id='+id+'&rate='+t+'&nocache = '+nocache,true);
http.onreadystatechange = insertReply;
http.send(null);
//return true;
//document.getElementById('rate').style.visibility='disable';
}
function insertReply()
{
if(http.readyState == 4)
{
  document.getElementById('rate').className="";
}
}

function resetvalue()
{

document.getElementById('ratemsg1').style.display="none";
document.getElementById('ratemsg').style.display="block";

            document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING;?> : "+document.getElementById('storeratemsg').value;

}
function displayrating(t)
{
//alert("DFsdg");

if(t=='1')
{
    document.getElementById('ratemsg').innerHTML="<?php ECHO _HDVS_POOR; ?>";
}
if(t=='2')
{
    document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_NOTHING_SPECIAL; ?>";
}
if(t=='3')
{
    document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_WORTH_WATCHING; ?>";
}
if(t=='4')
{
    document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_PRETTY_COOL; ?>";
}
if(t=='5')
{
    document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_AWESOME; ?>";
}
document.getElementById('ratemsg1').style.display="none";
document.getElementById('ratemsg').style.display="block";
}
//document.getElementById('ratemsg1').style.display="none";
//document.getElementById('ratemsg').style.display="block";

        function downloadlink(file)
        {
           // document.getElementById('downloadurl').href = file;
        }
        function embedcode(code){
           // document.getElementById('embedcode').value=code;
        }
function onVideoChanged(videodetails)
{
var create_date = videodetails['date'];
        var create_date = create_date.split('-');
         var create_date = create_date[1]+'-'+create_date[0]+'-'+create_date[2];
        if(create_date == undefined){
            create_date = '';
        }else{
            create_date = create_date.split(" ");
        }
         if(create_date!=null){document.getElementById('createdate').innerHTML=create_date[0];}
    var id = videodetails['id'];
    var title = videodetails['title'];
    var views = videodetails['views'];
    var vimeo = videodetails['vimeo'];
    var date = videodetails['date'];
    var category = videodetails['category'];
    var ratecount = videodetails['ratecount'];
    var rating = videodetails['rating'];
    var ratestar = videodetails['rating']/videodetails['ratecount'];
      document.getElementById('id').value=videodetails['id'];
        //document.getElementById('id').value=id;
        var js, xid = 'facebook-jssdk';
     js = document.createElement('script'); js.id = xid; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     document.getElementsByTagName('head')[0].appendChild(js);
     var fid ='<?php echo JURI::base().'index.php?option=com_contushdvideoshare&view=player&id=';?>'+id;
     document.getElementById('face-comments').innerHTML=  '<fb:comments  href='+fid+' num_posts="2" xid='+id+' width="700" ></fb:comments>';

    document.getElementById('views').innerHTML =  views;
    document.getElementById('viewtitle').innerHTML = title;
    document.getElementById('id').value=videodetails['id'];

    ratecal(rating,ratecount);
 function createObject()
        {
            var request_type;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                request_type = new ActiveXObject("Microsoft.XMLHTTP");
            }else{
                request_type = new XMLHttpRequest();
            }
            return request_type;
        }

        var http = createObject();
        var nocache = 0;
        nocache = Math.random();
        http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&nocache= '+nocache,true);
        http.onreadystatechange = insertReply;
        http.send(null);

        function insertReply() {
            if(http.readyState == 4){
                var url="";
                if(document.getElementById('commentoption'))
                {
                    var cmdoption=document.getElementById('commentoption').value;
                    if(cmdoption == 1)
                        {
                            document.getElementById('theFacebookComment').style.display = 'block';
                        }
                    if( cmdoption==2 || cmdoption==3 || cmdoption==4)
                    {

                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id='+id+'&cmdid='+cmdoption;
                        document.getElementById('myframe1').src=url;
                        document.getElementById('myframe1').style.display="block";
                        //        alert(document.getElementById('myframe').contentWindow.document.body.scrollHeight);

                    }
                    if(cmdoption != 0 && cmdoption != 1 && cmdoption != 3  && cmdoption != 4)
                    {
                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id='+id+'&cmdid='+cmdoption;
                        commentappendfunction(url);
                    }
                }

            }
        }

}
 function commentappendfunction(url)
    {

        function createObject() {
            var xmlhttp;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }else{
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }
        xmlhttp = createObject();
        var nocache = 0;
        nocache = Math.random();
        url= url+'&nocache = '+nocache;
        xmlhttp.onreadystatechange=stateChanged;
        xmlhttp.open("GET",url,true);
        xmlhttp.send(null);

    }
function ratecal(rating,ratecount)
{
resetvalue();
    rating=Math.round(rating/ratecount);
     document.getElementById('a').className = '';
    document.getElementById('rate').style.display='block';
   document.getElementById('rate').className="ratethis";
document.getElementById('storeratemsg').value = ratecount;
    if(rating==1)
        document.getElementById('rate').className="ratethis onepos";
    else if(rating==2)
        document.getElementById('rate').className="ratethis twopos";
    else if(rating==3)
        document.getElementById('rate').className="ratethis threepos";
    else if(rating==4)
        document.getElementById('rate').className="ratethis fourpos";
    else if(rating==5)
        document.getElementById('rate').className="ratethis fivepos";
    else
        document.getElementById('rate').className="ratethis nopos";

    document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING;?> : "+ratecount;



}


</script>
<input type="hidden" id="loadingimg" value="<?php echo JURI::base();?>components/com_contushdvideoshare/images/ajax-loader.gif">
<?php
function detect_mobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';

    $mobile_browser = '0';

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', $agent))
        $mobile_browser++;

    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;

    $mobile_ua = substr($agent,0,4);
    $mobile_agents = array(
                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                        'wapr','webc','winw','xda','xda-'
                        );

    if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;

    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;

    // Pre-final check to reset everything if the user is on Windows
    if(strpos($agent, 'windows') !== false)
        $mobile_browser=0;

    // But WP7 is also Windows, with a slightly different characteristic
    if(strpos($agent, 'windows phone') !== false)
        $mobile_browser++;

    if($mobile_browser>0)
        return true;
    else
        return false;
}
?>