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
$app = & JFactory::getApplication();
$user = & JFactory::getUser();
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$username = $user->get('username');
$details1 = $this->detail;
$playerpath = JURI::base() . "index.php?option=com_contushdvideoshare&view=playerbase";
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$user =& JFactory::getUser();
//echo $user->get('aid');die;
?>
<!-- for tooltip window -->
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/autoHeight.js"></script>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<input type="hidden" value="" name="videoidforcmd" id="videoidforcmd">
<input type="hidden" name="category" value="<?php echo $this->videodetails->playlistid; ?>" id="category"/>
<input type="hidden" value="<?php echo $this->videodetails->id; ?>" name="videoid" id="videoid">
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
<?php
if ($details1[0]->googleana_visible == 1) {
?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <script type="text/javascript">
        var pageTracker = _gat._getTracker("<?php echo $details1[0]->googleanalyticsID; ?>");
        pageTracker._trackPageview();
        pageTracker._trackEvent();
    </script>

<?php } ?>
<script type="text/javascript">
    function loadifr()
    {
        ev = document.getElementById('myframe1');
        if(ev!=null)
        {
            setHeight(ev);
            addEvent(ev,'load', doIframe);
        }
    }
    window.onload = function()
    {
<?php if ($this->videodetails->id) { ?>
            setInterval("loadifr()", 500);
<?php } ?>
    }
     function facebook_share_code(bookmarkf){
            document.getElementById('fbshare').href=bookmarkf;
        }
        function downloadlink(file)
        {
            document.getElementById('downloadurl').href = file;
        }
        function embedcode(code){
            document.getElementById('embedcode').value=code;
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
             if(create_date!=null){	document.getElementById('createdate').innerHTML=create_date[0];  }
        var id = videodetails['id'];
        var downloadVal = videodetails['D_load'];
        var memberAccess = videodetails['member_access'];
        if(downloadVal == 'false')
        	 document.getElementById('downloadurl').style.display='none';
        if(memberAccess=='false'){
             document.getElementById('allowEmbed').style.display='none';
             document.getElementById('downloadurl').style.display='none';
        }
        var title = videodetails['title'];
        var views = videodetails['views'];
        var vimeo = videodetails['vimeo'];
        var date = videodetails['date'];
        var category = videodetails['category'];
        var ratecount = videodetails['ratecount'];
        var rating = videodetails['rating'];
        var description = videodetails['description'];

document.getElementById('viewcount').innerHTML=views;
        document.getElementById('id').value=videodetails['id'];
        //document.getElementById('id').value=id;
        var js, xid = 'facebook-jssdk';
     js = document.createElement('script'); js.id = xid; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     document.getElementsByTagName('head')[0].appendChild(js);
     var fid ='<?php echo JURI::base().'index.php?option=com_contushdvideoshare&view=player&id=';?>'+id;

       if(vimeo!=1)
       {
        <?php if ($app->getTemplate() != 'hulutheme') { ?>
            document.getElementById('viewtitle').innerHTML = '<h3><b>'+title+'</h3></b>';
            document.getElementById('category').value=videodetails['category'];
            document.getElementById('videoid').value=videodetails['id'];
            var titlewidth=document.getElementById('viewtitle').style.width;
            var titlewidthvalue=titlewidth.substring(0, (titlewidth.length)-2);
            titlewidthvalue=((parseInt(titlewidthvalue)+140)/13);   //140
            if(title.length>titlewidthvalue)
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title' >"+title.substring(0, titlewidthvalue)+"...</h3>";
            else
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title'>"+title+"</h3>";

    <?php } ?>
        if(document.getElementById('videotitle'))
        {
            document.getElementById('videotitle').innerHTML=title;
            if((description!='undefined') && (description != ''))
             {
            document.getElementById('videoDescription').innerHTML = description;
             }
        }
        document.getElementById('storeratemsg').value=ratecount;
        //document.getElementById('id').value=id;
        resethomepagerate();
         document.getElementById('face-comments').innerHTML=  '<fb:comments  href='+fid+' num_posts="2" xid='+id+' width="700" ></fb:comments>';
}
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

    function stateChanged()
    {
        if (xmlhttp.readyState==4)
        {
            document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
            document.getElementById("commentappended").style.display="block";

        }
    }
    function resethomepagerate()
    {

        document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING; ?> : "+document.getElementById('storeratemsg').value;
    }

</script>
<script>


    function ratecal(rating,ratecount,views)
    {
        //alert(views);
        if(document.getElementById('viewid'))
        {
            document.getElementById('viewid').innerHTML="<b><h3 style='text-align:right'><?php echo _HDVS_VIEWS; ?> : "+views+"</h3></b>";
        }
    //   rating=Math.round(rating/ratecount);

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
 //var cmdoption = document.getElementById('commentoption').value;
//alert(cmdoption);
</script>
<?php
if ($app->getTemplate() != 'hulutheme')
    echo '<link rel="stylesheet" href="' . JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';
?>
<!-- Component Starts Version 1.3-->

<div class="fluid bg playerbg"  >
    <div id="HDVideoshare1" style="position:relative;width:<?php echo $details1[0]->width; ?>px; " >
        <?php if ($app->getTemplate() != 'hulutheme')
                {
                ?>
            <span id="viewtitle" class="floatleft" style="width:<?php echo $details1[0]->width - 140; ?>px;" ></span>
        <?php
                }
        if ($app->getTemplate() != 'hulutheme')
         {
            if (USER_LOGIN == '1')
            {
                if ($user->get('id') != '')
                  {
                        if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="javascript: submitform();"><?php echo _HDVS_LOGOUT; ?></a></div>
            <?php }else { ?>
                <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo _HDVS_LOGOUT; ?></a></div>
           <?php  } }
                else
                {
                    if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><div class="toprightmenu"><a href="index.php?option=com_users&view=registration"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_users&view=login"  alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
           <?php }  else {      ?>
                    <div class="toprightmenu"><a href="index.php?option=com_user&view=register"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_user&view=login" alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
        <?php
                } }
            }
        }
        ?>
        <div class="clear"></div>
        <!----- Flash player Start ----->
        <?php
                if (($this->videodetails->id)&&($this->videodetails->playlistid))
                {
                    $baseref ='&id=' . $this->videodetails->id.'&catid=' . $this->videodetails->playlistid;
                }
                else if($this->videodetails->id)
                {
                    $baseref = '&id=' . $this->videodetails->id;
                }
                else
                {
                    $baseref = '&featured=true';
                } ?>
                <?php  if((preg_match('/vimeo/', $this->videodetails->videourl))&&($this->videodetails->videourl !=''))
                        {$split=explode("/",$this->videodetails->videourl); ?>


         <script type="text/javascript">
            window.onload = function(){
            var videodetails=new Array();
            videodetails['id']='<?php echo $this->videodetails->id; ?>';
            videodetails['category']='<?php echo $this->videodetails->playlistid;?>';
            videodetails['vimeo']='1';
            videodetails['title']='<?php echo $this->htmlVideoDetails->title; ?>';
            videodetails['date']='<?php echo $this->htmlVideoDetails->addedon; ?>';
            videodetails['description']='<?php echo $this->htmlVideoDetails->description; ?>';
            videodetails['views']='<?php echo $this->htmlVideoDetails->times_viewed; ?>';
            videodetails['ratecount']='<?php echo $this->htmlVideoDetails->rate; ?>';
            videodetails['rating']='<?php echo $this->htmlVideoDetails->ratecount; ?>';
            var video_src = "<?php echo JURI::getInstance()->toString(); ?>";
            embedCode = '<iframe src="http://player.vimeo.com/video/<?php echo $split[3]; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=6fde9f" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
            var pagevalues = "<?php echo JURI::base();?>index.php?option=com_contushdvideoshare&amp;view=player&id=<?php echo $this->videodetails->id; ?>&catid=<?php echo $this->videodetails->playlistid; ?>";
            var bookmark = "http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $this->htmlVideoDetails->title; ?>&p[summary]=<?php echo $this->htmlVideoDetails->description; ?>&p[medium]="+escape('103')+"&p[video][src]="+escape(video_src)+"&p[url]="+escape(pagevalues)+"&p[images][0]=<?php echo $this->htmlVideoDetails->thumburl; ?>&p[redirect_uri]=<?php echo 'http://apptha.com';?>";
            var cmdoption = document.getElementById('commentoption').value;
            if(cmdoption == 1){
                 document.getElementById('theFacebookComment').style.display = 'block';
            }
            embedcode(embedCode);
            facebook_share_code(bookmark);
            onVideoChanged(videodetails);}
      </script>
        <iframe src="<?php echo 'http://player.vimeo.com/video/'.$split[3].'?title=0&amp;byline=0&amp;portrait=0';?>" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>" frameborder="0"></iframe>
            <?php }else { ?>
        <div id="flashplayer">
            <object  classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,40,0" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>">
                <param name="wmode" value="opaque"></param>
                <param name="movie" value="<?php echo $playerpath; ?>"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowscriptaccess" value="always"></param>
                <param name="flashvars" value='baserefJ=<?php echo $details1['baseurl']; ?><?php echo $baseref; ?>'></param>
                <embed wmode="opaque" src="<?php echo $playerpath; ?>" type="application/x-shockwave-flash"
                       allowscriptaccess="always" allowfullscreen="true" flashvars="baserefJ=<?php echo $details1['baseurl']; ?><?php  echo $baseref; ?>"  width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"></embed></object>
        </div>
        <!---------------- Flash player End ---------------->
        <!---------------- HTML5 PLAYER START ---------------->
        <script type="text/javascript">
            function failed(e)
            {
                if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7I')
                {
                    alert('Player doesnot support this video.');
                }
            }
        </script>

                       <div id="htmlplayer" style="display:none;">
            <?php
                       $htmlVideoDetails = $this->htmlVideoDetails;
                       if($this->homepageaccess == 'true'){
                       if ($htmlVideoDetails->filepath == "File" || $htmlVideoDetails->filepath == "FFmpeg" || $htmlVideoDetails->filepath == "Url")
                        {
                           $current_path = "components/com_contushdvideoshare/videos/";
                           if ($htmlVideoDetails->filepath == "Url")
                            {
                               $video = $htmlVideoDetails->videourl;
                            }
                            else
                            {
                               $video = JURI::base() . $current_path . $htmlVideoDetails->videourl;
                            } ?>
                           <video id="video" src="<?php echo $video; ?>" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>" autobuffer controls onerror="failed(event)">
                               Html5 Not support This video Format.
                           </video><?php
                       }
                       elseif ($htmlVideoDetails->filepath == "Youtube")
                        {
                           if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $htmlVideoDetails->videourl, $vresult))
                            {
                               $urlArray = explode("=", $vresult[0]);
                               $videoid = trim($urlArray[1]);
                            }
?>
                           <iframe  type="text/html" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"  src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0">
                           </iframe>
<?php
                       }
                       }else{?>
       <div id="video" style="width:<?php echo $details1[0]->width; ?>px; height:<?php echo $details1[0]->height; ?>px; background-color:#000000;" >
       			<h3 style="color:#e65c00;vertical-align: middle;height:<?php echo $details1[0]->height; ?>px;display: table-cell;width:<?php echo $details1[0]->width; ?>px; ">You are not authorized to view this video</h3>
       </div>
<?php  }
?>
                   </div>
                   <script>
                       txt =  navigator.platform ;
                       if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7I')
                       {
                           document.getElementById("htmlplayer").style.display = "block";
                           document.getElementById("flashplayer").style.display = "none";
                       }
                       else
                       {
                           document.getElementById("flashplayer").style.display = "block";
                           document.getElementById("htmlplayer").style.display = "none";
                       }
                   </script>
                   <!---------------- HTML5 PLAYER  END ----------------><?php } ?>
    <?php if (isset($details1['publish']) == '1' && isset($details1['showaddc']) == '1')
        { ?>
                       <div style="clear:both;font-size:0px; height:0px;"></div>
                       <div id="lightm" style="position:absolute;bottom:25px;width:<?php echo $details1[0]->width; ?>px;background:none;"  >
                               <div align="center">  <div class="addcss" style="margin:0 auto;width:470px;"> <img id="closeimgm" src="components/com_contushdvideoshare/images/close.png" class="googlead_img" onclick="googleclose();"></div> <span id="divimgm" style="width:<?php echo $details1[0]->width; ?>px;">
                                   </span>
                                   <iframe height="60" scrolling="no"   align="middle" width="468" id="IFrameName" src=""     name="IFrameName" marginheight="0" marginwidth="0" frameborder="0"></iframe>
                               </div></div>
                           <script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/googlead.js"></script>
 <?php } ?>
                   </div>
               </div>
<?php
                       if (isset($details1['closeadd']))
                         {
                           $closeadd = $details1['closeadd'];
                           $ropen = $details1['ropen'];
?>
                           <script language="javascript">
                               var closeadd =  <?php echo $closeadd * 1000; ?>;
                               var ropen = <?php echo $ropen * 1000; ?>;
                           </script>
                 <?php } ?>

                       <div id="rateid" class="ratingbg" >
<?php
                       $user = & JFactory::getUser();
                       $session = JFactory::getSession();
?>

                       <table <?php if ($app->getTemplate() == 'hulutheme')
                               {
                        ?>class="content_center" <?php } ?> style="width:<?php echo $details1[0]->width; ?>px; "   cellpadding="0" cellspacing="0" border="0">
                           <tr>
                    <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
                                   <td  class="left-rate">
                                       <div class="centermargin" >
                                           <div  contentEditable='false' unselectable='true'>
                                               <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();">
                                                   <div id="a" class="floatleft"></div>
<?php
                           if (isset($this->commentview[0]->ratecount) && $this->commentview[0]->ratecount != 0)
                           {
                               $ratestar = round($this->commentview[0]->rate / $this->commentview[0]->ratecount);
                           }
                           else
                           {
                               $ratestar = 0;
                           }
?>
                            <ul class="ratethis " id="rate" >
                                <li class="one" >
                                    <a title="1 Star Rating"  onclick="getrate('1');"  onmousemove="displayrating('1');" onmouseout="resetvalue();">1</a>
                                </li>
                                <li class="two" >
                                    <a title="2 Star Ratings"  onclick="getrate('2');"  onmousemove="displayrating('2');" onmouseout="resetvalue();">2</a>
                                </li>
                                <li class="three" >
                                    <a title="3 Star Ratings"  onclick="getrate('3');"   onmousemove="displayrating('3');" onmouseout="resetvalue();">3</a>
                                </li>
                                <li class="four" >
                                    <a  title="4 Star Ratings"  onclick="getrate('4');"  onmousemove="displayrating('4');" onmouseout="resetvalue();"  >4</a>
                                </li>
                                <li class="five" >
                                    <a title="5 Star Ratings"  onclick="getrate('5');"  onmousemove="displayrating('5');" onmouseout="resetvalue();" >5</a>
                                </li>
                            </ul>

                            <input type="hidden" name="id" id="id" value="<?php if($this->videodetails->id!='') echo $this->videodetails->id; else echo $this->getfeatured->id; ?>">
                        </div>

                        <div class="floatleft">
                            <div class="rateright-views" style="width:200px;"><b><span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();" > </span></b>
                                <b><span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();"  >  </span></b></div>
                          <input type="hidden" value="" id="storeratemsg" ></div>

                    </div>
                </div></td>
<?php } ?>
                    <td>
                        <div class="video_addedon">
                            <span class="addedon"><?php echo _HDVS_ADDED_ON;?>:</span><span id="createdate"></span>
                        </div>
                    </td>
            <?php
                        if ($app->getTemplate() == 'hulutheme')
                          {
             ?>
                            <td align="right" class="rightrate" >
                                <div class="bottomviews"  id="viewid"></div>
                            </td>
                    <?php } ?>
                    </tr></table>
                <script language="javascript">
<?php if (isset($ratestar) && isset($this->commentview[0]->ratecount) && isset($this->commentview[0]->times_viewed)) { ?>
                    ratecal('<?php echo $ratestar; ?>','<?php echo $this->commentview[0]->ratecount; ?>','<?php echo $this->commentview[0]->times_viewed; ?>');
<?php } ?>
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
                    //alert('index.php?option=com_contushdvideoshare&view=player&id='+id+'&rate='+t+'&nocache = '+nocache);
                    http.open('get', 'index.php?option=com_contushdvideoshare&view=player&ajaxview=&id='+id+'&rate='+t+'&nocache = '+nocache,true);
                    http.onreadystatechange = insertReply;
                    http.send(null);
                    //return true;
                    document.getElementById('rate').style.visibility='disable';
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
<?php
                        if (isset($this->commentview[0]->ratecount))
                           {
                       ?>
                        document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING;?> :  <?php echo $this->commentview[0]->ratecount; ?>";
                     <?php }
                     else { ?>
                                document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING;?> : "+document.getElementById('storeratemsg').value;
                    <?php } ?>
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

                </script>
            </div>
            <div class="clscenter" style="width:<?php echo $details1[0]->width; ?>px;">
    <?php
                        if (isset($this->commenttitle))
                         {
                            foreach ($this->commenttitle as $row)
                               {
                           ?>
                                <div style="float:left;<?php
                                if ($app->getTemplate() != 'hulutheme')
                                {
                                    echo "width:60%;";
                                }
    ?>">
                                    <br />
                                    <h2 class="nospace" id="videotitle" style="font-size:19px;margin-top:0px;padding-top:0px;"><?php echo $row->title; ?></h2>
                                    <h4 id="videoDescription" style="font-size:14px;margin-top:8px;"><?php echo $row->description; ?></h4>
                           </div>
<?php
                                if ($app->getTemplate() != 'hulutheme')
                                  {
?>
                <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1)
                                    {
                    ?>
                                        <div style="float:right;"><br><h3 style="margin:0px;padding:0px;" ><?php echo _HDVS_VIEWS;?> : <span id="viewcount"><?php echo $row->times_viewed; ?></span></h3></div>

    <?php
                                    }
                                  }
    ?>
                                <div style="clear:both"></div>
                             <div class="sharing_vid">
                        <?php if($this->homepagebottomsettings[0]->facebooklike == 1){?>
                          <div id="share_like">
                            <div id="fb-root" class="floatleft">
                                <div
                                    style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div>
                            </div>
                            <a href="" class="fbshare" id="fbshare" target="_blank" ></a>

                            <div class="floatleft" style="width:105px">
                                <a href="http://twitter.com/share" class="twitter-share-button"
                                   data-count="horizontal">Tweet</a>
                                <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                            </div>

                            <!-- Google plus one Start -->
                            <div class="floatleft" style="width:70px">
                                <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                                <div class="g-plusone" data-size="medium" data-count="true"></div>
                            </div>

                            <script src="http://connect.facebook.net/en_US/all.js"></script>
                            <!-- layout=button_count&amp; -->
        <?php $pageURL = str_replace('&', '%26', JURI::getInstance()->toString()); ?>
                        <iframe
                            src="http://www.facebook.com/plugins/like.php?href=<?php echo $pageURL; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21"
                            scrolling="no" frameborder="0"
                            style="border: none; overflow: hidden; width: 100px; height: 25px;"
                            allowTransparency="true"> </iframe>
                    </div>
                  <?php } ?>
                    <div class="vinfo_right_embed">
                        <a href="" id="downloadurl">Download</a>
                        <?php if($this->homepagebottomsettings[0]->facebooklike == 1){?>
                        <a onclick="enableEmbed()" class="embed" id="allowEmbed">Embed </a><?php } ?>
<div class="clear"></div>
                        <textarea id="embedcode" name="embedcode" style="display:none;width:<?php
                        if ($details1[0]->width > 10) {
                            echo ($details1[0]->width) - (17);
                        } else {
                            echo $details1[0]->width;
                        }
        ?>px;}" rows="7" ></textarea>
              <input type="hidden" name="flagembed" id="flagembed" />
          </div>
          <div class="vid_description">
              <div id="description" style="margin-bottom:20px;"> </div>
          </div>
      </div>
      <script type="text/javascript">
          function enableEmbed(){
              embedFlag = document.getElementById('flagembed').value
              if(embedFlag != 1){
                  document.getElementById('embedcode').style.display="block";
                  document.getElementById('flagembed').value = '1';
              }
              else{
                  document.getElementById('embedcode').style.display="none";
                  document.getElementById('flagembed').value = '0';
              }
          }
      </script>
        <?php
                                break;
                            }
                        }
        ?>
                    </div><div class="clear"></div>
                        <!-- Add Facebook Comment -->
                        <div class="fbcomments" style="display:none" id="theFacebookComment">
                        <h3>Add Your Comments</h3>
                        <?php
                        $this->homepagebottomsettings[0]->facebookapi = isset($this->homepagebottomsettings[0]->facebookapi) ? $this->homepagebottomsettings[0]->facebookapi : '';
                        if ($this->homepagebottomsettings[0]->facebookapi)
                            $facebookapi = $this->homepagebottomsettings[0]->facebookapi;
                        ?>
                        <br />
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
                        <fb:comments xid="<?php echo JRequest::getVar('id'); ?>" css="facebook_style.css" simple="1" href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="700"></fb:comments>
                        </div>
                        </div>
    <?php
                        if ($this->videodetails->id)
                         {
                          ?>
                        <input type="hidden" value="<?php echo $this->homepagebottomsettings[0]->comment; ?>" id="commentoption" name="commentoption">
                        <div id="commentappended" class="clscenter" style="<?php if ($this->homepagebottomsettings[0]->comment == 1) {
                         ?>display:none;<?php } ?>width:<?php echo $details1[0]->width; ?>px;">


                         <?php if ($this->homepagebottomsettings[0]->comment != 0) { ?>
                                    <!--
                                    <iframe src="index.php?option=com_contushdvideoshare&view=commentappend&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>" width="900" height="1200" frameborder="0" scrolling="no" id="commentappendediframe" name="commentappendediframe" style="display:none;" ></iframe>

                                    -->
                                    <br/><br/>
                                    <div id="container" style="margin-top:0px;">
                                        <iframe id="myframe1" height="100%" width="<?php echo $details1[0]->width; ?>" name="myframe1" class="autoHeight" frameborder="0" scrolling="no" src="index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>"  ></iframe>
                                    </div>
                           <?php
                            }
                            if ($this->homepagebottomsettings[0]->comment == 2)
                             {
                                $tot = count($this->commenttitle);
                            ?>
                                    <script type="text/javascript">
                                    {
                                        function parentvalue(parentid)
                                        {
                                            document.getElementById('parentvalue').value=parentid;
                                            document.getElementById('name').focus();
                                        }
                                    }
                                     </script>
                                     <script type="text/javascript">

                                    //
                                    function changepage(pageno)
                                    {
                                        document.getElementById("page").value=pageno;
                                        document.pagination.submit();
                                    }
                                    function validation(form)
                                    {
                                        var username=form.username.value;
                                        if(username.length==0)
                                        {
                                            alert("Enter Your Name");
                                            document.getElementById('username').focus();
                                            return false;
                                        }
                                        var comments=form.message.value;
                                        if(comments.length==0)
                                        {
                                            alert("Enter Your Message");
                                            form.message.focus();
                                            return false;
                                        }
                                        return true;
                                    }
                                    function GetXmlHttpObject()
                                    {
                                        if (window.XMLHttpRequest)
                                        {
                                            // code for IE7+, Firefox, Chrome, Opera, Safari
                                            return new XMLHttpRequest();
                                        }
                                        if (window.ActiveXObject)
                                        {
                                            // code for IE6, IE5
                                            return new ActiveXObject("Microsoft.XMLHTTP");
                                        }
                                        return null;
                                    }
                                    var xmlhttp;
                                    var nocache = 0;
                                    function insert()
                                    {
                                        document.getElementById('txt').style.display="none";
                                        var name= document.getElementById('username').value;
                                        var message = document.getElementById('message').value;
                                        var id= document.getElementById('videoid').value;
                                        var category= document.getElementById('category').value;
                                        var parentid= document.getElementById('parentvalue').value;
                                        // Set te random number to add to URL request
                                        nocache = Math.random();
                                        xmlhttp=GetXmlHttpObject();
                                        if (xmlhttp==null)
                                        {
                                            alert ("Browser does not support HTTP Request");
                                            return;
                                        }
                                        document.getElementById('prcimg').style.display="block";
                                        var url="index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id="+id+"&catid="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&cmdid=2&&nocache = "+nocache;
                                        url=url+"&sid="+Math.random();

                                        xmlhttp.onreadystatechange=stateChanged;
                                        xmlhttp.open("GET",url,true);
                                        xmlhttp.send(null);

                                    }
                                    function stateChanged()
                                    {

                                        if (xmlhttp.readyState==4)
                                        {

                                            document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
                                            document.getElementById("commentappended").style.display="block";

                                        }
                                    }

                                    function comments()
                                    {
                                        var d=document.getElementById('txt').innerHTML;
                                        document.getElementById('initial').innerHTML=d;
                                    }

                                    function CountLeft(field, count, max)
                                    {
                                        // if the length of the string in the input field is greater than the max value, trim it
                                        if (field.value.length > max)
                                            field.value = field.value.substring(0, max);
                                        else
                                            count.value = max - field.value.length;
                                    }
                                    function textdisplay(rid)
                                    {

                                        if(document.getElementById('divnum').value>0 )
                                        {
                                            document.getElementById(document.getElementById('divnum').value).innerHTML="";

                                        }
                                        document.getElementById('initial').innerHTML=" ";
                                        var r=rid;
                                        var d=document.getElementById('txt').innerHTML;
                                        document.getElementById(r).innerHTML=d;
                                        document.getElementById('txt').style.display="none";
                                        document.getElementById('divnum').value=r;
                                    }
                                    function hidebox()
                                    {
                                        document.getElementById('txt').style.display="none";
                                        document.getElementById('initial').innerHTML=" ";
                                    }
                                       </script>
<?php } ?>
                        </div>

<?php } else { ?>
                        <table  class="content_center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <div class="section "  >
                                        <div class="standard tidy"  >
                                            <div class="layout b-c">
                                                <div class="gr b" style="margin:0px;"  >
                                                    <div class="layout a-b-c"   >
<?php
                            /* home page bottom */
                            for ($coun_tmovie_post = 1; $coun_tmovie_post <= 3; $coun_tmovie_post++)
                            {
                                if ($this->homepagebottomsettings[0]->homefeaturedvideo == 1 && $this->homepagebottomsettings[0]->homefeaturedvideoorder == $coun_tmovie_post)
                                   {
?>
                                    <div class="gr a floatleft"  id="populared">
                                        <div class="callout-header-home">
                                            <h2 class="home-link hoverable" ><a href="index.php?option=com_contushdvideoshare&view=featuredvideos" title="Featured Videos"> <?php echo _HDVS_FEATURED_VIDEOS; ?></a></h2>
                                        </div>
                                <?php
                                    $totalrecords = count($this->rs_playlist1[0]);
                                    $j = 0;
                                    $k = 0;
                                    for ($i = 0; $i < $totalrecords; $i++)
                                    {
                                ?>    <?php if (($i % $this->homepagebottomsettings[0]->homefeaturedvideocol) == 0)
                                        {
                                ?>
                                            <div class="clear"></div>
                                  <?php } ?>
                                        <div class="floatleft">
                                    <?php
                                        //For SEO settings
                                        $seoOption = $this->homepagebottomsettings[0]->seo_option;

                                        if ($seoOption == 1)
                                        {

                                            $featureCategoryVal = "category=" . $this->rs_playlist1[0][$i]->seo_category;
                                            $featureVideoVal = "video=" . $this->rs_playlist1[0][$i]->seotitle;
                                        }
                                        else
                                         {
                                            $featureCategoryVal = "catid=" . $this->rs_playlist1[0][$i]->catid;
                                            $featureVideoVal = "id=" . $this->rs_playlist1[0][$i]->id;
                                         }

                                        if ($this->rs_playlist1[0][$i]->filepath == "File" || $this->rs_playlist1[0][$i]->filepath == "FFmpeg")
                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[0][$i]->thumburl;
                                        if ($this->rs_playlist1[0][$i]->filepath == "Url" || $this->rs_playlist1[0][$i]->filepath == "Youtube")
                                            $src_path = $this->rs_playlist1[0][$i]->thumburl;
                                    ?>


                                        <?php
                                        $oriname = $this->rs_playlist1[0][$i]->category;     //category name changed here for seo url purpose
                                        $newrname = explode(' ', $oriname);
                                        $link = implode('-', $newrname);
                                        $link1 = explode('&', $link);
                                        $category = implode('and', $link1);
                                        $orititle = $this->rs_playlist1[0][$i]->title;
                                        $newtitle = explode(' ', $orititle);
                                        $displaytitle = implode('-', $newtitle);
                                        $final = explode('-', $displaytitle);
                                        $final1 = implode(' ', $final);
                                        $final2 = explode('and', $final1);
                                        $displaytitle11 = implode('&', $final2);
                                        ?>
                                        <div class="home-thumb">
                                            <div class="home-play-container" >
                                                <span class="play-button-hover" >
                                                    <div class="movie-entry yt-uix-hovercard">
                                                      <div class="tooltip">
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$featureCategoryVal.'&'.$featureVideoVal,true); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                              <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->rs_playlist1[0][$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->rs_playlist1[0][$i]->description.'</p>'; ?>
                                                     <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?></span></div>
                                                           <?php } ?></div></div>

                                                    </div>
                                                </span>
                                            </div>
                                            <div class="show-title-container">
                                                <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$featureCategoryVal.'&'.$featureVideoVal,true); ?>" class="show-title-gray info_hover"><?php
                                        if (strlen($this->rs_playlist1[0][$i]->title) > 23)
                                        {
                                            echo JHTML::_('string.truncate', ($this->rs_playlist1[0][$i]->title), 23);
                                            //echo (substr($this->rs_playlist1[0][$i]->title, 0, 23)) . "...";
                                        }
                                        else
                                        {
                                            echo $this->rs_playlist1[0][$i]->title;
                                        }
?> </a>
                                            </div>
                                            <span class="video-info">
                                                  <a href = "<?php echo  JRoute::_('index.php?option=com_contushdvideoshare&view=category&'.$featureCategoryVal,true); ?>"><?php echo $this->rs_playlist1[0][$i]->category; ?></a>
                                            </span>
                                             <div class="clsratingvalue">
                                                    <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1)
                                                           { ?>
                                                <span class="floatleft">

                                                <?php
                                                        if (isset($this->rs_playlist1[0][$i]->ratecount) && $this->rs_playlist1[0][$i]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->rs_playlist1[0][$i]->rate / $this->rs_playlist1[0][$i]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                            <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                    </span>
                                                    <?php } ?>
                                             </div>
                                                <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1)
                                                      { ?>

                                                        <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                                        <span class="floatright viewcolor view"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?></span>

                                                <?php } ?>
                                                    <div class="clear"></div>
                                              <?php
?>                                                       </div>
<?php $j++; ?></div>
<?php
                                                }
                                            }
?>
                                    <!-- Code end here for featured videos in home page display -->
                                            <?php if ($this->homepagebottomsettings[0]->homepopularvideo == 1 && $this->homepagebottomsettings[0]->homepopularvideoorder == $coun_tmovie_post)
                                                   {
                                            ?>
                                        <!-- Code begin here for popular videos in home page display  -->
                                        <div class="gr b floatleft" >
                                            <div class="callout-header-home">
                                                <h2 class="home-link hoverable"><a href="index.php?option=com_contushdvideoshare&view=popularvideos" title="Popular Videos"><?php echo _HDVS_POPULAR_VIDEOS; ?></a></h2>
                                                    </div>
<?php
                                                $totalrecords = count($this->rs_playlist1[2]);
                                                $j = 0;
                                                $k = 0;
                                                for ($i = 0; $i < $totalrecords; $i++)
                                                {
                                                    //For SEO settings
                                                    $seoOption = $this->homepagebottomsettings[0]->seo_option;
                                                    if ($seoOption == 1)
                                                    {
                                                        $popularCategoryVal = "category=" . $this->rs_playlist1[2][$i]->seo_category;
                                                        $popularVideoVal = "video=" . $this->rs_playlist1[2][$i]->seotitle;
                                                    }
                                                    else
                                                    {
                                                        $popularCategoryVal = "catid=" . $this->rs_playlist1[2][$i]->catid;
                                                        $popularVideoVal = "id=" . $this->rs_playlist1[2][$i]->id;
                                                    }

                                                    if (($i % $this->homepagebottomsettings[0]->homepopularvideocol) == 0)
                                                        {
?>
                                                        <div class="clear"></div>
                                                  <?php } ?>
                                                    <div class="floatleft">
                                        <?php
                                                    if ($this->rs_playlist1[2][$i]->filepath == "File" || $this->rs_playlist1[2][$i]->filepath == "FFmpeg")
                                                        $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[2][$i]->thumburl;
                                                    if ($this->rs_playlist1[2][$i]->filepath == "Url" || $this->rs_playlist1[2][$i]->filepath == "Youtube")
                                                        $src_path = $this->rs_playlist1[2][$i]->thumburl;
                                        ?>
<?php
                                                    $oriname = $this->rs_playlist1[2][$i]->category;     //category name changed here for seo url purpose
                                                    $newrname = explode(' ', $oriname);
                                                    $link = implode('-', $newrname);
                                                    $link1 = explode('&', $link);
                                                    $category = implode('and', $link1);
                                                    $orititle = $this->rs_playlist1[2][$i]->title;
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
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$popularCategoryVal.'&'.$popularVideoVal,true); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                              <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->rs_playlist1[2][$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->rs_playlist1[2][$i]->description.'</p>'; ?>
                                                     <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>

                                                                                                                                    </div>
                                                            </span>
                                                        </div>
                                                        <div class="show-title-container" >
                                                            <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$popularCategoryVal.'&'.$popularVideoVal,true); ?>" class="show-title-gray info_hover"><?php
                                                    if (strlen($this->rs_playlist1[2][$i]->title) > 23)
                                                    {
                                                        echo JHTML::_('string.truncate', ($this->rs_playlist1[2][$i]->title), 23);
                                                        //echo (substr($this->rs_playlist1[2][$i]->title, 0, 23)) . "...";
                                                    }
                                                    else
                                                    {
                                                        echo $this->rs_playlist1[2][$i]->title;
                                                    }
                                                            ?></a>
                                                </div>
                                                <span class="video-info">
                                                      <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $popularCategoryVal; ?>"><?php echo $this->rs_playlist1[2][$i]->category; ?></a>
                                                </span><div class="clsratingvalue">
                                                        <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1)
                                                              {
                                                        ?>
                                                    <span class="floatleft">

<?php
                                                            if (isset($this->rs_playlist1[2][$i]->ratecount) && $this->rs_playlist1[2][$i]->ratecount != 0)
                                                            {
                                                                $ratestar = round($this->rs_playlist1[2][$i]->rate / $this->rs_playlist1[2][$i]->ratecount);
                                                            }
                                                            else
                                                            {
                                                                $ratestar = 0;
                                                            }
?>                                                                <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                            </span>
                                                    <?php   } ?>
                                                     </div>
                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1)
                                                           {
                                                    ?>

                                                            <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                                            <span class="floatright viewcolor view"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?></span>

                                                    <?php } ?>
                                                        <div class="clear"></div>

                                                                                                       </div>
                                                <?php if ($j != 1)
                                                       {
                                                ?>
                                                <?php  } $j++; ?>
                                                </div>
<?php
                                                    }

?><div class="clear"></div>
                                                    <br/>
                                                </div>
                                        <?php } ?>
                                        <?php if ($this->homepagebottomsettings[0]->homerecentvideo == 1 && $this->homepagebottomsettings[0]->homerecentvideoorder == $coun_tmovie_post)
                                                {
                                        ?>
                                                <!-- Code end here for Popular videos in home page display -->

                                                <!-- Code begin here for Recent videos in home page display  -->
                                                <div class="gr c floatleft"  >
                                                    <div class="callout-header-home">
                                                        <h2 class="home-link hoverable"><a href = "<?php echo jRoute::_('index.php?option=com_contushdvideoshare&view=recentvideos');?>" title="Recent Videos"> <?php echo _HDVS_RECENT_VIDEOS; ?></a></h2>
                                                        </div>
<?php
                                                    $totalrecords = count($this->rs_playlist1[1]);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {
                                                        //For SEO settings
                                                        $seoOption = $this->homepagebottomsettings[0]->seo_option;
                                                        if ($seoOption == 1)
                                                        {
                                                            $recentCategoryVal = "category=" . $this->rs_playlist1[1][$i]->seo_category;
                                                            $recentVideoVal = "video=" . $this->rs_playlist1[1][$i]->seotitle;
                                                        }
                                                        else
                                                        {
                                                            $recentCategoryVal = "catid=" . $this->rs_playlist1[1][$i]->catid;
                                                            $recentVideoVal = "id=" . $this->rs_playlist1[1][$i]->id;
                                                        }
                                                        if (($i % $this->homepagebottomsettings[0]->homerecentvideocol) == 0)
                                                            {
?>
                                                            <div class="clear"></div>
                                                      <?php } ?>
                                                        <div class="floatleft">
                                        <?php
                                                        if ($this->rs_playlist1[1][$i]->filepath == "File" || $this->rs_playlist1[1][$i]->filepath == "FFmpeg")
                                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[1][$i]->thumburl;
                                                        if ($this->rs_playlist1[1][$i]->filepath == "Url" || $this->rs_playlist1[1][$i]->filepath == "Youtube")
                                                            $src_path = $this->rs_playlist1[1][$i]->thumburl;
                                        ?>
<?php
                                                        $oriname = $this->rs_playlist1[1][$i]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);
                                                        $orititle = $this->rs_playlist1[1][$i]->title;
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
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$recentCategoryVal.'&'.$recentVideoVal,true); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                              <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->rs_playlist1[1][$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->rs_playlist1[1][$i]->description.'</p>'; ?>
                                                     <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>


                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div class="show-title-container">
                                                                <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$recentCategoryVal.'&'.$recentVideoVal,true); ?>" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->rs_playlist1[1][$i]->title) > 23)
                                                        {
                                                            echo JHTML::_('string.truncate', ($this->rs_playlist1[1][$i]->title), 23);
                                                            //echo (substr($this->rs_playlist1[1][$i]->title, 0, 23)) . "...";
                                                        }
                                                        else
                                                        {
                                                            echo $this->rs_playlist1[1][$i]->title;
                                                        }
?></a>
                                                </div>
                                                <span class="video-info">
                                                      <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&'.$recentCategoryVal,true); ?>"><?php echo $this->rs_playlist1[1][$i]->category; ?></a>
                                                </span>
                                                            <div class="clsratingvalue">
                                                        <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1)
                                                              {
                                                        ?>
                                                    <span class="floatleft">

<?php
                                                            if (isset($this->rs_playlist1[1][$i]->ratecount) && $this->rs_playlist1[1][$i]->ratecount != 0)
                                                            {
                                                                $ratestar = round($this->rs_playlist1[1][$i]->rate / $this->rs_playlist1[1][$i]->ratecount);
                                                            }
                                                            else
                                                            {
                                                                $ratestar = 0;
                                                            }
?>                                                                <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                            </span>
<?php } ?></div>

                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1)
                                                           {
                                                    ?>

                                                            <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                                            <span class="floatright viewcolor view"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?></span>

                                                <?php     } ?>
                                                        <div class="clear"></div>
                                                    </div>
<?php $j++; ?>
                                                </div>
<?php
                                                    }
?><div class="clear"></div>
                                        </div> <div class="clear"></div>
                                                <?php }
                                            } ?>
                                    <!-- Code end here for Recent videos in home page display -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </td>
    </tr>
</table>
<?php } $memberidvalue = '' ?>
                    <?php if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                {
                                      $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                }
                          ?>
                        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
                        </form>
                        <script type="text/javascript" language="javascript">
                            function membervalue(memid)
                            {
                                document.getElementById('memberidvalue').value=memid;
                                document.forms['memberidform'].action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>";
                                document.forms['memberidform'].submit();
                        }

                        </script>
                        <input type="hidden" value="" id="storeratemsg" >
                        <script type="text/javascript">
	                        txt =  navigator.platform ;
	                        if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7I')
	                        {
                                        document.getElementById('downloadurl').style.display = 'none';
                                        document.getElementById('allowEmbed').style.display = 'none';
                                        document.getElementById('share_like').style.display = 'none';
                                    var cmdoption = document.getElementById('commentoption').value;
	                             if(cmdoption == 1){
	                                 document.getElementById('theFacebookComment').style.display = 'block';
	                               }
	                        }
                        </script>
