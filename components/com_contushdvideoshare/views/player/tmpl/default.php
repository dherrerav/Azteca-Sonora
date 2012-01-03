<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/com_contushdvideosahre/views/player/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : player page layouts
 */
// No direct Access
defined('_JEXEC') or die('Restricted access');
$app = & JFactory::getApplication();
$user = & JFactory::getUser();
    $language = JRequest::getVar('lang');
     if( $language != ''){
        $language = '&lang='.$language;
        $languages = '&jlang='.JRequest::getVar('lang');
        }
$app = JFactory::getApplication();
$router = $app->getRouter();
$sefURL = $router->getMode();
        if($sefURL==1)
        {
            $language = JRequest::getVar('lang');
            if( $language != ''){
            $languages = '&slang='.JRequest::getVar('lang');
            }

        }
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
//$user->get('username');
$username = $user->get('username');
//echo $username;
$itemid = JRequest::getVar('Itemid', '', 'get', 'int');
$details1 = $this->detail;
$playerpath = JRoute::_("index.php?option=com_contushdvideoshare&view=playerbase");
$logoutval_1 = "index.php?option=com_users&task=user.logout&return=";
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player&Itemid=' . $itemid);
$loginval_1 = JURI::base() . "index.php?option=com_contushdvideoshare&view=commentlogin";

?>
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


<!-- for tooltip window -->

<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<input type="hidden" value="" name="videoidforcmd" id="videoidforcmd">
<input type="hidden" name="category" value="<?php echo JRequest::getVar('catid', '', 'get', 'int'); ?>" id="category"/>
<input type="hidden" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>" name="videoid" id="videoid">
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
<?php if (JRequest::getVar('id', '', 'get', 'int')) { ?>
            //setInterval("loadifr()", 500);
<?php } ?>
    }
    function onVideoChanged(videodetails)

    {
        var id = videodetails['id'];
        var title = videodetails['title'];
        var views = videodetails['views'];
        var date = videodetails['date'];
        var category = videodetails['category'];
        var ratecount = videodetails['ratecount'];
        var rating = videodetails['rating'];
        var description = videodetails['description'];
        var tags=videodetails['tags'];
        if((tags.value=="")|| (tags.value=="undefined"))
        {
            document.getElementById('tagstxt').innerHTML = '';
        }
        else
        {
            document.getElementById('tagstxt').innerHTML = '<b>'+tags+'</b>';
        }
        
        document.getElementById('id').value=id;
		if(document.getElementById('homecomments')!=null)
			{
document.getElementById('homecomments').href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&id='); ?>"+id;
}
<?php if ($app->getTemplate() != 'hulutheme') { ?>
            document.getElementById('viewtitle').innerHTML = '<h3><b>'+title+'</h3></b>';
            document.getElementById('category').value=videodetails['category'];
            document.getElementById('videoid').value=videodetails['id'];
            //alert(document.getElementById('viewtitle').style.width);
            var titlewidth=document.getElementById('viewtitle').style.width;
            ////alert(titlewidth);
            var titlewidthvalue=titlewidth.substring(0, (titlewidth.length)-2);
            //alert(parseInt(titlewidthvalue)+140);
            titlewidthvalue=((parseInt(titlewidthvalue)+140)/13);   //140
            if(title.length>titlewidthvalue)
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title' >"+title.substring(0, titlewidthvalue)+"...</h3>";
            else
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title'>"+title+"</h3>";

<?php } ?>
        if(document.getElementById('videotitle'))
        {
            document.getElementById('videotitle').innerHTML=title;
        }
        document.getElementById('storeratemsg').value=ratecount;
        document.getElementById('id').value=id;
        resethomepagerate();

        function createObject() {
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
        <?php  if($sefURL!=1)
                {   ?>
        http.open('get', '<?php echo $language;?>'+'/index.php?option=com_contushdvideoshare&view=player&id='+id+'&nocache = '+nocache,true);
        <?php   }
         else {
            ?>
                    http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&nocache = '+nocache+'<?php echo $language;?>',true);
        <?php }
        ?>
        http.onreadystatechange = insertReply;
        http.send(null);

        function insertReply() {
            if(http.readyState == 4){
                var url="";
                if(document.getElementById('commentoption'))
                {
                    var cmdoption=document.getElementById('commentoption').value;
                    if( cmdoption==2 || cmdoption==3)
                    {
                             <?php  if($sefURL!=1)
                                    {   ?>
                                    url= '<?php echo JURI::base();?>index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption+'<?php echo $language;?>';
                                    <?php   }
                                     else {
                                        ?>
                                                url= '<?php echo JURI::base();?><?php echo $language;?>'+'/index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
                                    <?php }
                                    ?>

                        
                        document.getElementById('myframe1').src=url;
                        document.getElementById('myframe1').style.display="block";
                        //        alert(document.getElementById('myframe').contentWindow.document.body.scrollHeight);

                    }
                    if(cmdoption!=0 && cmdoption!=2 && cmdoption!=3)
                    {
                        url= '<?php echo JURI::base();?>index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
						
                        commentappendfunction(url);
                    }
                }
            }
        }
  ratecal(rating,ratecount,views);
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
        if(document.getElementById('viewid'))
        {
            document.getElementById('viewid').innerHTML="<b><h3 style='text-align:right'><?php echo _HDVS_VIEWS; ?> : "+views+"</h3></b>";
        }
        rating=Math.round(rating/ratecount);

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
        document.getElementById('ratemsg').innerHTML="Ratings :"+ratecount;


    }

</script>
<?php
if ($app->getTemplate() != 'hulutheme')
    JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css', array(), true);
?>

<div class="fluid bg playerbg">
    <div id="HDVideoshare1" style="position:relative;width:<?php echo $details1[0]->width; ?>px; " >
        <?php if ($app->getTemplate() != 'hulutheme') { ?>
            <span id="viewtitle" class="floatleft" style="width:<?php echo $details1[0]->width - 140; ?>px;" ></span>
            <?php
                }
                if ($app->getTemplate() != 'hulutheme') {
                    if (USER_LOGIN == '1') {
                        if ($user->get('id') != '') {
            ?>
            <span class="toprightmenu"><b><a href="<?php echo JRoute::_(JURI::base() . "index.php?option=com_contushdvideoshare&view=myvideos"); ?>"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="<?php echo JRoute::_($logoutval_1 . $logoutval_2); ?>" > <?php echo _HDVS_LOGOUT; ?></a></b></span>
             <?php } else { ?>
            <span class="toprightmenu">
                <b>
                    <a href="<?php echo JRoute::_(JURI::base() . "index.php?option=com_users&view=registration"); ?>"><?PHP ECHO _HDVS_REGISTER; ?></a>                     |
                    <a href="<?php echo JRoute::_(JURI::base() . "index.php?option=com_users&view=login"); ?>"> <?PHP ECHO _HDVS_LOGIN; ?></a>
                </b>
            </span>
                <?php
                        }
                    }
                }
                ?>
        <div class="clear"></div>
        <object  classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,40,0" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>">
            <param name="wmode" value="opaque"></param>
            <param name="movie" value="<?php echo $playerpath; ?>"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <param name="flashvars" value='baserefJ=<?php echo $details1['baseurl']; ?><?php if (JRequest::getVar('id', '', 'get', 'int')) { echo '&id=' . JRequest::getVar('id', '', 'get', 'int'); } else { echo '&featured=true'; } ?><?php if (JRequest::getvar('catid', '', 'get', 'int')) { echo '&catid=' . JRequest::getvar('catid', '', 'get', 'int'); } ?> <?php if ($languages!='') { echo $languages; } ?>'></param>
            <embed wmode="opaque" src="<?php echo $playerpath; ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" flashvars="baserefJ=<?php echo $details1['baseurl']; ?><?php if (JRequest::getVar('id', '', 'get', 'int')) { echo '&id=' . JRequest::getVar('id', '', 'get', 'int'); } else { echo '&featured=true'; } ?><?php if (JRequest::getvar('catid', '', 'get', 'int')) { echo '&catid=' . JRequest::getvar('catid', '', 'get', 'int'); } ?> <?php if ($languages!='') { echo $languages; } ?>"  width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"></embed>
        </object>
        <?php if (isset($details1['publish']) == '1' && isset($details1['showaddc']) == '1') { ?>
            <div style="clear:both;font-size:0px; height:0px;"></div>
            <div id="lightm" style="position:absolute;bottom:25px;width:<?php echo $details1[0]->width; ?>px;background:none;"  >
                <div align="center">  <div class="addcss" style="margin:0 auto;width:470px;"> <img id="closeimgm" src="components/com_contushdvideoshare/images/close.png" class="googlead_img" onclick="googleclose();"></div> <span id="divimgm" style="width:<?php echo $details1[0]->width; ?>px;">
                           </span>
                           <iframe height="60" scrolling="no"   align="middle" width="468" id="IFrameName" src=""     name="IFrameName" marginheight="0" marginwidth="0" frameborder="0"></iframe>
                </div>
            </div>
                   <script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/googlead.js"></script>
        <?php } ?>
           </div>
       </div>
            <?php
                   if ($this->homepagebottomsettings[0]->tagconrtol == 1) {
            ?>
               <script type="text/javascript">
                   window.addEvent('domready', function(){  new Accordion($$('.panel h2.jpane-toggler'), $$('.panel div.jpane-slider'), {onActive: function(toggler, i) { toggler.addClass('jpane-toggler-down'); toggler.removeClass('jpane-toggler'); },onBackground: function(toggler, i) { toggler.addClass('jpane-toggler'); toggler.removeClass('jpane-toggler-down'); },duration: 300,opacity: false,alwaysHide: true,show:0}); });
               </script>
               <style type="text/css">
                   #selectyourhost { border:#CCCCCC solid 1px; width:<?php echo $details1[0]->width - 2; ?>px;background:#fff;}
                           #selectyourhost .yourhost { background:#eeeeee; border:#ffffff solid 1px; width:<?php echo $details1[0]->width - 4; ?>px;  line-height:10px;padding-top:0px; }
                           #selectyourhost .yourhost h2 { color:#000000; font-size:15px;margin:0px;padding:5px 0 5px 7px;width:auto; }

                           .floatleft{float:left;}
                           .floatright{float:right}
                           .clear { clear:both; height:0px; font-size:0px;}
                           .clearfix:after {
                               clear: both;
                               display: block;
                               content: " ";
                               height: 0px;
                               visibility: hidden;
                           }

                           /* pane-sliders  */
                           .pane-sliders .title {

                               cursor: pointer;
                           }
                           .jpane-toggler  span     {background: transparent url(<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/default.jpg) 0px 80% no-repeat; padding-left: 20px; }
                           .jpane-toggler-down span {background: transparent url(<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/default1.jpg) 0px 50% no-repeat; padding-left: 20px; }

                           .jpane-toggler-down { }


                           /** cpanel settings **/

                           #cpanel div.icon {
                               text-align: center;

                               float: left;

                           }

                           #cpanel div.icon a {
                               display: block;
                               float: left;

                           }

                           #cpanel div.icon a:hover {

                           }

                           #cpanel img  { padding: 10px 0; margin: 0 auto; }
                           #cpanel span { display: block; text-align: center; }
                           #selectyourhost h3{color:#000000; font-size:12px;margin:0px;width:auto; }
                       </style>
                       <br>
                       <div id="content-pane" class="pane-sliders">
                           <div id="selectyourhost"  class="panel" >
                               <div class="yourhost clearfix">
                                   <h3 class="floatleft" style="padding:3px 0px 0px 2px;"><?php echo _HDVS_TAGS; ?></h3>
                                   <div style="float:right; ">
                                       <h2  class="jpane-toggler title"> <span>&nbsp;</span></h2>
                                   </div>
                               </div>
                               <div class="jpane-slider content">
                                   <div id="tagstxt" style="padding:5px;">  </div>
                               </div>
                           </div>
                       </div>
                       <?php } ?>
                        <?php
                               if (isset($details1['closeadd'])) {
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
                       <table <?php if ($app->getTemplate() == 'hulutheme') { ?>class="content_center" <?php } ?> style="width:<?php echo $details1[0]->width; ?>px; "   cellpadding="0" cellspacing="0" border="0">
                           <tr>
                               <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
                                    <td  class="left-rate">
                                       <div class="centermargin" >
                                           <div  contentEditable='false' unselectable='true'>
                                               <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();">
                                                   <div id="a" class="floatleft"></div>
                                               <?php
                                               if (isset($this->commentview[0]->ratecount) && $this->commentview[0]->ratecount != 0) {
                                                   $ratestar = round($this->commentview[0]->rate / $this->commentview[0]->ratecount);
                                               } else {
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
                                               <input type="hidden" name="id" id="id" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>">
                                           </div>
                                           <div class="floatleft">
                                               <div class="rateright-views" style="width:200px;"><b><span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();" > </span></b>
                                                   <b><span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();"  >  </span></b></div>
                                               <input type="hidden" value="" id="storeratemsg" ></div>
                                       </div>
                                   </div>
                                    </td>
                                    <?php } ?>
                                    <?php if ($app->getTemplate() == 'hulutheme') { ?>
                                 <td align="right" class="rightrate" >
                                    <div class="bottomviews"  id="viewid"></div>
                                </td>
                                <?php } 
    if(!JRequest::getVar('id','','get','int'))

{?>

<td style="vertical-align:middle;text-align:center;"><a href="#" id="homecomments" ><strong>Comments</strong></a></td>
<?php
}
?>
                            </tr>
                       </table>
                <script language="javascript">
                <?php if (isset($ratestar) && isset($this->commentview[0]->ratecount) && isset($this->commentview[0]->times_viewed)) { ?>
                            ratecal('<?php echo $ratestar; ?>','<?php echo $this->commentview[0]->ratecount; ?>','<?php echo $this->commentview[0]->times_viewed; ?>');
                <?php } ?>
                    function createObject() {
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
                           <?php  if($sefURL!=1)
            {   ?>
            http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&rate='+t+'&nocache = '+nocache+"<?php echo $language;?>",true);
            <?php   }
             else {
                ?>
                        http.open('get', "<?php echo $language;?>"+'/index.php?option=com_contushdvideoshare&view=player&id='+id+'&rate='+t+'&nocache = '+nocache,true);
            <?php }
            ?>
                    
                    http.onreadystatechange = insertReply;
                    http.send(null);
                    document.getElementById('rate').style.visibility='disable';
                    }
                    function insertReply() {
                    if(http.readyState == 4){
                    document.getElementById('rate').className="";
                    }
                    }

                    function resetvalue()
                    {
                    document.getElementById('ratemsg1').style.display="none";
                    document.getElementById('ratemsg').style.display="block";
                    <?php
                        if (isset($this->commentview[0]->ratecount)) {
                    ?>
                    document.getElementById('ratemsg').innerHTML="Ratings : <?php echo $this->commentview[0]->ratecount; ?>";
                    <?php } else { ?>
                        document.getElementById('ratemsg').innerHTML="Ratings : "+document.getElementById('storeratemsg').value;
                    <?php } ?>
                    }
                    function displayrating(t)
                    {
                    if(t=='1')
                    {
                    document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_POOR; ?>";
                    }
                    if(t=='2')
                    {
                    document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_NOTHING_SPECIAL; ?>";
                    }
                    if(t=='3')
                    {
                    document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_WORTH_WATCHING; ?>";
                    }
                    if(t=='4')
                    {
                    document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_PRETTY_COOL; ?>";
                    }
                    if(t=='5')
                    {
                    document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_AWESOME; ?>";
                    }
                    document.getElementById('ratemsg1').style.display="none";
                    document.getElementById('ratemsg').style.display="block";
                    }
                </script>
            </div>
            <div class="clscenter" style="width:<?php echo $details1[0]->width; ?>px;">
                    <?php
                        if (isset($this->commenttitle)) {
                            foreach ($this->commenttitle as $row) {
                    ?>
                                <div style="float:left;<?php if ($app->getTemplate() != 'hulutheme') { echo "width:60%;"; } ?>">
                                    <br /><h2 class="nospace" id="videotitle" style="font-size:19px;margin-top:0px;padding-top:0px;"><?php echo $row->title; ?></h2>
                                </div>

                            <?php
                                if ($app->getTemplate() != 'hulutheme') {
                            ?>
                            <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                        <div style="float:right;"><br><h3 style="margin:0px;padding:0px;">Views : <?php echo $row->times_viewed; ?></h3></div>

                            <?php
                                    }
                                }
                            ?>

                                <div style="clear:both"></div>
                                <div style="float:left;margin:5px 0 0 0;padding:0px;" >
                                    <?php $mid = $row->memberid; ?>
                                    <?php if ($row->username != '') { ?><div class="viewsubname"> <?php echo _HDVS_SUBMITED_BY; ?> : <strong><a  title="<?php echo $row->username; ?>" class="namelink cursor_pointer" onclick="membervalue(<?php echo $mid; ?>);"><?php echo $row->username; ?></a></strong></div><?php } else { echo '<div class="viewsubname">Submitted by:Admin</div>'; } ?>
                                </div>
                            <?php
                                break;
                            }
                        }
                            ?>
                    </div>
                    <?php
                        if (JRequest::getVar('id', '', 'get', 'int')) { ?>
                            <input type="hidden" value="<?php echo $this->homepagebottomsettings[0]->comment; ?>" id="commentoption" name="commentoption">
                            <div id="commentappended" class="clscenter" style="<?php if ($this->homepagebottomsettings[0]->comment == 1) { ?>display:none;<?php } ?>width:<?php echo $details1[0]->width; ?>px;">
                    <?php if ($this->homepagebottomsettings[0]->comment != 0) { ?>
                                <br/><br/>
                                <div id="container" style="margin-top:0px;">
                                    <iframe id="myframe1" height="100%" width="<?php echo $details1[0]->width; ?>" name="myframe1" class="autoHeight" frameborder="0" scrolling="no" src="index.php?option=com_contushdvideoshare&view=commentappend&id=<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>"  ></iframe>
                                </div>
                    <?php
                            }
                            if ($this->homepagebottomsettings[0]->comment == 1) {
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
                            function insert() {

                            document.getElementById('txt').style.display="none";
                            // Required: verify that all fileds is not empty. Use encodeURI() to solve some issues about character encoding.
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
                                <?php  if($sefURL!=1)
                                {   ?>
                                var url="index.php?option=com_contushdvideoshare&view=commentappend&id="+id+"&catid="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&cmdid=1&nocache = "+nocache+"<?php echo $language;?>";
                                <?php   }
                                 else {
                                    ?>
                                            var url="<?php echo $language;?>"+"/index.php?option=com_contushdvideoshare&view=commentappend&id="+id+"&catid="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&cmdid=1&nocache = "+nocache;
                                <?php }
                                ?>
                            
                            url=url+"&sid="+Math.random();
                            alert(url);
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
                                                            for ($coun_tmovie_post = 1; $coun_tmovie_post <= 3; $coun_tmovie_post++) {
                                                                if ($this->homepagebottomsettings[0]->homefeaturedvideo == 1 && $this->homepagebottomsettings[0]->homefeaturedvideoorder == $coun_tmovie_post && (count($this->rs_playlist1[0]) >= 1)) {
                                                            ?>
                                                                    <div class="gr a floatleft"  id="populared">
                                                                        <div class="callout-header-home">
                                                                            <h2 class="home-link hoverable" ><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=featuredvideos"); ?>" title="Featured Videos"> <?php echo _HDVS_FEATURED_VIDEOS; ?></a></h2>
                                                                        </div>
                                                                <?php
                                                                    $totalrecords = count($this->rs_playlist1[0]);
                                                                    $j = 0;
                                                                    $k = 0;
                                                                    for ($i = 0; $i < $totalrecords; $i++) {
                                                                    if (($i % $this->homepagebottomsettings[0]->homefeaturedvideocol) == 0) { ?>
                                                                            <div class="clear"></div>
                                                                    <?php } ?>
                                                                        <div class="floatleft">
                                                                    <?php
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
                                                                                            <a class="tooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[0][$i]->id . "&catid=" . $this->rs_playlist1[0][$i]->catid); ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                                                <div class="clearfix"></div>
                                                                                                <div id="Tooltipwindow" style="clear:both">
                                                                                                    <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[0][$i]->category; ?></p>
                                                                                                    <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[0][$i]->description; ?></p>
                                                                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                                        <hr>
                                                                                                        <span ><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
                                                                                                                <?php } ?>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                                <div class="show-title-container">
                                                                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[0][$i]->id . "&catid=" . $this->rs_playlist1[0][$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($this->rs_playlist1[0][$i]->title) > 18) { echo (substr($this->rs_playlist1[0][$i]->title, 0, 18)) . "..."; } else { echo $this->rs_playlist1[0][$i]->title; } ?> </a>
                                                                                </div>
                                                                                <span class="video-info">
                                                                                    <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&catid=<?php echo $this->rs_playlist1[0][$i]->catid; ?>"><?php echo $this->rs_playlist1[0][$i]->category; ?></a>
                                                                                </span>
                                                                                <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
                                                                                <span class="video-info">
                                                                                        <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                                                    <?php
                                                                                    if (isset($this->rs_playlist1[0][$i]->ratecount) && $this->rs_playlist1[0][$i]->ratecount != 0) {
                                                                                        $ratestar = round($this->rs_playlist1[0][$i]->rate / $this->rs_playlist1[0][$i]->ratecount);
                                                                                    } else {
                                                                                        $ratestar = 0;
                                                                                    }
                                                                                    ?>
                                                                                    <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                                                </span>
                                                                                <?php } ?>

                                                                                <div class="clear"></div>

                                                                                <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                <span class="video-info">
                                                                                    <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                                                    <span class="floatleft"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?></span>
                                                                                </span>
                                                                                <?php } ?>
                                                                                <div class="clear"></div>


                                                                          </div>
                                                                         <?php $j++; ?>
                                                                        </div>
                                                                <?php } ?>
                                                                            <div class="clear"></div>
                                                                <br/>
                                                            </div>
                                                            <?php } ?>
                                                    <!-- Code end here for featured videos in home page display -->
                                                                                                        <?php if ($this->homepagebottomsettings[0]->homepopularvideo == 1 && $this->homepagebottomsettings[0]->homepopularvideoorder == $coun_tmovie_post && (count($this->rs_playlist1[2]) >= 1)) { ?>
                                                    <!-- Code begin here for popular videos in home page display  -->
                                                    <div class="gr b floatleft" >
                                                        <div class="callout-header-home">
                                                            <h2 class="home-link hoverable">
                                                                <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=popularvideos"); ?>" title="Popular Videos"><?php echo _HDVS_POPULAR_VIDEOS; ?></a>
                                                            </h2>
                                                        </div>
                                                        <?php
                                                            $totalrecords = count($this->rs_playlist1[2]);
                                                            $j = 0;
                                                            $k = 0;
                                                            for ($i = 0; $i < $totalrecords; $i++) {
                                                                if (($i % $this->homepagebottomsettings[0]->homepopularvideocol) == 0) {
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
                                                                                <a class="tooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[2][$i]->id . "&catid=" . $this->rs_playlist1[2][$i]->catid); ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                                    <div class="clearfix"></div>
                                                                                    <div id="Tooltipwindow" style="clear:both">
                                                                                        <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[2][$i]->category; ?></p>
                                                                                        <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[2][$i]->description; ?></p>
                                                                                        <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                            <hr>
                                                                                            <span ><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </span>
                                                                    </div>
                                                                    <div class="show-title-container" >
                                                                        <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[2][$i]->id . "&catid=" . $this->rs_playlist1[2][$i]->catid); ?>" class="show-title-gray info_hover"><?php
                                                                                        if (strlen($this->rs_playlist1[2][$i]->title) > 18) {
                                                                                            echo (substr($this->rs_playlist1[2][$i]->title, 0, 18)) . "...";
                                                                                        } else {
                                                                                            echo $this->rs_playlist1[2][$i]->title;
                                                                                        }
                                                                                        ?></a>
                                                                                </div>
                                                                                <span class="video-info">
                                                                                <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $this->rs_playlist1[2][$i]->catid); ?>"><?php echo $this->rs_playlist1[2][$i]->category; ?></a>
                                                                                </span>
                                                                                <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
                                                                                <span class="video-info">
                                                                                    <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                                                        <?php
                                                                                            if (isset($this->rs_playlist1[2][$i]->ratecount) && $this->rs_playlist1[2][$i]->ratecount != 0) {
                                                                                                $ratestar = round($this->rs_playlist1[2][$i]->rate / $this->rs_playlist1[2][$i]->ratecount);
                                                                                            } else {
                                                                                                $ratestar = 0;
                                                                                            }
                                                                                        ?>
                                                                                <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                                            </span>
                                                                    <?php } ?>
                                                                                <div class="clear"></div>
                                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                    <span class="video-info">
                                                                        <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                                        <span class="floatleft"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?></span>
                                                                    </span>
                                                                    <?php } ?>
                                                                    <div class="clear"></div>
                                                                </div>
                                                            <?php if ($j != 1) {
                                                            ?>
                                                        <?php } $j++; ?>
                                                    </div>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        <br/>
                                                    </div>
                                                        <?php } ?>
                                                        <?php if ($this->homepagebottomsettings[0]->homerecentvideo == 1 && $this->homepagebottomsettings[0]->homerecentvideoorder == $coun_tmovie_post && (count($this->rs_playlist1[1]) >= 1)) { ?>
                                                        <!-- Code end here for Popular videos in home page display -->
                                                        <!-- Code begin here for Recent videos in home page display  -->
                                                        <div class="gr c floatleft"  >
                                                            <div class="callout-header-home">
                                                                <h2 class="home-link hoverable"><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=recentvideos"); ?>" title="Recent Videos"> <?php echo _HDVS_RECENT_VIDEOS; ?></a></h2>
                                                            </div>
                                                            <?php
                                                                $totalrecords = count($this->rs_playlist1[1]);
                                                                $j = 0;
                                                                $k = 0;
                                                                for ($i = 0; $i < $totalrecords; $i++) {

                                                                    if (($i % $this->homepagebottomsettings[0]->homerecentvideocol) == 0) {
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
                                                                            <a class="tooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[1][$i]->id . "&catid=" . $this->rs_playlist1[1][$i]->catid); ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                                <div class="clearfix"></div>
                                                                                <div id="Tooltipwindow" style="clear:both">
                                                                                    <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[1][$i]->category; ?></p>
                                                                                    <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[1][$i]->description; ?></p>
                                                                                        <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                    <hr>
                                                                                    <span ><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                                <div class="show-title-container">
                                                                <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->rs_playlist1[1][$i]->id . "&catid=" . $this->rs_playlist1[1][$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($this->rs_playlist1[1][$i]->title) > 18) { echo (substr($this->rs_playlist1[1][$i]->title, 0, 18)) . "..."; } else { echo $this->rs_playlist1[1][$i]->title; } ?></a>
                                                                </div>
                                                                <span class="video-info">
                                                                <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=". $this->rs_playlist1[1][$i]->catid); ?>"><?php echo $this->rs_playlist1[1][$i]->category; ?></a>
                                                                </span>
                                                                <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
                                                                    <span class="video-info">
                                                                        <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                                    <?php
                                                                        if (isset($this->rs_playlist1[1][$i]->ratecount) && $this->rs_playlist1[1][$i]->ratecount != 0) {
                                                                            $ratestar = round($this->rs_playlist1[1][$i]->rate / $this->rs_playlist1[1][$i]->ratecount);
                                                                        } else {
                                                                            $ratestar = 0;
                                                                        }
                                                                    ?>
                                                                        <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                                    </span>
                                                                <?php } ?>
                                                                    <div class="clear"></div>
                                                                <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                <span class="video-info">
                                                                    <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                                    <span class="floatleft"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?></span>
                                                                </span>
                                                                <?php } ?>
                                                                <div class="clear"></div>
                                                        </div>
                                                        <?php $j++; ?>
                                                    </div>
                                                    <?php } ?>
                                                        <div class="clear"></div>
                                                    </div>
                                                        <div class="clear"></div>
                                                    <?php
                                                    }
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
            <?php } ?>
    <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php if (JRequest::getVar('memberidvalue', '', 'post', 'int')) { echo JRequest::getVar('memberidvalue', '', 'post', 'int'); }; ?>" />
    </form>
    <script type="text/javascript" language="javascript">
        function membervalue(memid)
            {
                document.getElementById('memberidvalue').value=memid;
                document.forms['memberidform'].action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>";
                document.forms['memberidform'].submit();
            }
    </script>