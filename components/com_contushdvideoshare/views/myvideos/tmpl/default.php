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
$session = & JFactory::getSession();
$user = & JFactory::getUser();
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$requestpage = JRequest::getVar('page', '', 'post', 'int');
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
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
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
<div class="player clearfix">
    <div id="clsdetail">
        <div class="lodinpad">
            <h1> <?php echo _HDVS_MY_VIDEOS; ?></h1>        
            <div>
                <ul id="myclstopul"  >
                    <li ><?php echo _HDVS_SORT_BY; ?> :</li>
                    <li><a  title="Sort by title"  class="namelink cursor_pointer" onclick="sortvalue('1');"><?php echo _HDVS_TITLE; ?></a></li>
                    <li >|</li>
                    <li ><a  title="Sort by Date"  class="namelink cursor_pointer" onclick="sortvalue('2');"><?php echo _HDVS_DATE_ADDED; ?></a></li>
                    <li >|</li>
                    <li ><a  title="Sort by Views"  class="namelink cursor_pointer" onclick="sortvalue('3');"><?php echo _HDVS_VIEWS; ?></a></li>
                </ul>
                <div style="padding: 5px 0 10px;float:right;">
                <?php
                $searchTxtbox = '';
                if (isset($_POST['searchtxtboxmember']))
                {
                 $searchTxtbox = $_POST['searchtxtboxmember'];
                }
?>
                <form name="hsearch" id="hsearch" method="post" action='index.php?option=com_contushdvideoshare&view=myvideos' >
                    <input type="text"  name="searchtxtboxmember" value="<?php echo $searchTxtbox; ?>" id="searchtxtboxmember" class="clstextfield clscolor"  onkeypress="validateenterkey(event,'hsearch');" stye="color:#000000; "/>
                    <input type="submit" name="search_btn" id="search_btn" class="button myvideos_search" value="<?php echo _HDVS_SEARCH; ?>" />
                    <input type="hidden" name="searchval" id="searchval" value="<?php echo $searchTxtbox; ?>" />
                    <?php
                    if ($this->deletevideos['allowupload'] == 1)
                            {
                   ?>
                               <input type="button" class="button" value="<?php echo _HDVS_ADD_VIDEO; ?>" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload'); ?>','_self');">
<?php                       }
?>
                </form>
            </div>
            </div>
            <div class="clear"></div>
            <table width="auto">
                <?php
                $totalrecords = $this->myvideorowcol[0]->myvideorow * $this->myvideorowcol[0]->myvideocol;
                if (count($this->deletevideos) - 4 < $totalrecords)
                {
                    $totalrecords = count($this->deletevideos) - 4;
                }
                for ($i = 0; $i < $totalrecords; $i++)
                {
                    if (isset($this->deletevideos[$i]->filepath))
                     {
                        if ($i == 0) 
                         {
                           ?><tr><?php
                         }
                        if (($i % $this->myvideorowcol[0]->myvideocol) == 0) 
                         {
                ?>
                        </tr><tr>
                   <?php } ?>
                    <td class="rightrate">
                        <?php
                        if ($this->deletevideos[$i]->filepath == "File" || $this->deletevideos[$i]->filepath == "FFmpeg")
                        {
                            if ($this->deletevideos[$i]->thumburl != "")
                            {
                                $src_path = "components/com_contushdvideoshare/videos/" . $this->deletevideos[$i]->thumburl;
                            }
                            else
                            {
                                $src_path="";
                            }
                        }
                        if ($this->deletevideos[$i]->filepath == "Url" || $this->deletevideos[$i]->filepath == "Youtube")
                        {
                            $src_path = $this->deletevideos[$i]->thumburl;
                        }
                        ?>
                        <?php if ($this->deletevideos[$i]->vid != '') { ?>
                            <div id="imiddlecontent1" >
                                <div class="featurecontent clearfix">
                                    <div class="middleleftcontent">
                                        <div class="videopic" >
                                        <?php
                                        $orititle = $this->deletevideos[$i]->title;       //Title name changed here for seo url purpose
                                        $newtitle = explode(' ', $orititle);
                                        $displaytitle1 = implode('-', $newtitle);
                                        $displaytitle = str_replace('.', '', $displaytitle1);
                                        $final = explode('-', $displaytitle);
                                        $final1 = implode(' ', $final);
                                        $final2 = explode('and', $final1);
                                        $displaytitle11 = implode('&', $final2);
                                        $img_path = "components/com_contushdvideoshare/images/default_thumb.jpg";
                                        ?>
                                        <?php
                                        $seoOption = $this->myvideorowcol[0]->seo_option;
                                         if ($seoOption == 1)
                                        {

                                         $myCategoryVal = "category=" . $this->deletevideos[$i]->category;
                                            $myVideoVal = "video=" . $this->deletevideos[$i]->seotitle;
                                        }
                                        else
                                         {
                                            $myCategoryVal = "catid=" . $this->deletevideos[$i]->catid;
                                            $myVideoVal = "id=" . $this->deletevideos[$i]->vid;
                                         }

                                        ?>
                                        <div class="bottomalign"  >
                                            <div class="movie-entry yt-uix-hovercard">

                                                 <div class="tooltip">
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$myCategoryVal.'&'.$myVideoVal,true); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>
                                               

                                                <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->deletevideos[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->deletevideos[$i]->description.'</p>'; ?>
                                               
                                                        <?php if ($this->myvideorowcol[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->deletevideos[$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>
                                                
                                                


                                            </div>
                                        </div>
                                        <?php if ($this->myvideorowcol[0]->viewedconrtol == 1) { ?>
                                                        <div class="floatright viewcolor"> <?php echo $this->deletevideos[$i]->times_viewed. ' '. _HDVS_VIEWS ; ?></div>
                                                         <?php } ?>
                                                    <span class="floatleft viewcolor view">  <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->deletevideos[$i]->vid . "&catid=" . $this->deletevideos[$i]->catid); ?>"><?php if (isset($this->deletevideos[$i]->total)) { echo $this->deletevideos[$i]->total; } ?></a>
                                                    <?php echo _HDVS_COMMENTS; ?>
                                                    </span>
                                            </div></div>
                                        <div class="featureright">
                                            <p class="myview"><a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&id='.$this->deletevideos[$i]->vid .'&catid='.$this->deletevideos[$i]->catid); ?>" title="<?php echo $this->deletevideos[$i]->title; ?>">
                                            <?php if (strlen($this->deletevideos[$i]->title) > 15) {
                                                echo JHTML::_('string.truncate', ($this->deletevideos[$i]->title), 15);
                                                //echo (substr($this->deletevideos[$i]->title, 0, 15)) . '...';
                                            } else
                                              {
                                                echo $this->deletevideos[$i]->title;
                                              } ?></a></p>
                                    <?php
                                                    $addeddate = $this->deletevideos[$i]->addedon;
                                                    $addedon = date('F j, Y', strtotime($addeddate));
                                    ?>
                                                    <p class="myview"> <?php echo $addedon; ?></p>
                                    <?php
                                                    if ($this->deletevideos[$i]->type == 0)
                                                    {
                                                        $vtype = _HDVS_PUBLIC;
                                                    } 
                                                    else
                                                    {
                                                        $vtype = _HDVS_PRIVATE;
                                                    }
                                    ?>
                                                    <p class="myview viewcolor"> <?php echo _HDVS_VIDEO. " : " . ' ' . $vtype.'/'; ?>
                                    <?php
                                                    if ($this->deletevideos[$i]->published == 1)
                                                    {
                                                        $status = _HDVS_ACTIVE;
                                                    } 
                                                    else
                                                    {
                                                        $status = _HDVS_BLOCKED;
                                                    }
                                    ?>
                                                    <?php echo $status; ?></p>
                                                    <div class="myvideosbtns">
                                                        <input type="button" name="playvideo" id="playvideo" onclick="window.open('<?php echo 'index.php?option=com_contushdvideoshare&view=player&id=' . $this->deletevideos[$i]->vid . '&catid=' . $this->deletevideos[$i]->catid; ?>','_self')" value="<?php echo _HDVS_PLAY; ?>" class="button"  />
                                                        <input type="button" name="videoedit" id="videoedit" onclick="window.open('<?php echo 'index.php?option=com_contushdvideoshare&view=videoupload&id=' . $this->deletevideos[$i]->vid . '&type=edit'; ?>','_self')" value="<?php echo _HDVS_EDIT; ?>" class="button" />
                                                        <input type="button" name="videodelete" id="videodelete" value="<?php echo _HDVS_DELETE; ?>" class="button" onclick="var flg=my_message(<?php echo $this->deletevideos[$i]->vid; ?>); return flg;" />
                                                                    </div>
                                      </div>
                                                            </div>
                                                        </div>
                                                    </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php } ?>
                                                <!----------First row---------->
<?php
                                            }
                                        }
?>
                                </table>
                                <!--  PAGINATION STARTS HERE-->
                                <table cellpadding="0" cellspacing="0" border="0" id="pagination" align="right">
                                    <tr align="right">
                                        <td align="right"  class="page_rightspace">
                                            <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                                <tr>
                                <?php
                                        $pages = $this->deletevideos['pages'];
                                        $q = $this->deletevideos['pageno'];
                                        $q1 = $this->deletevideos['pageno'] - 1;
                                        if ($this->deletevideos['pageno'] > 1)
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
                                                echo ("<td align='right'>...</td>");
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
                    <br/>
                </div>
            </div>
        </div>
                             <?php $page = $_SERVER['REQUEST_URI'];
                                   $deleteVideo = '';
                                   $memberIdValue = '';
                                   $sorting = '';
                                    if (JRequest::getVar('deletevideo', '', 'post', 'int'))
                                     {
                                        $deleteVideo = JRequest::getVar('deletevideo', '', 'post', 'int');
                                     }
                                    if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                    {
                                        $memberIdValue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                    }
                                    if (JRequest::getVar('sorting', '', 'post', 'string'))
                                    {
                                        $sorting = JRequest::getVar('sorting', '', 'post', 'string');
                                    }

                             ?>
                             <form name="deletemyvideo"  action="<?php echo $page; ?>" method="post">
                                 <input type="hidden" name="deletevideo" id="deletevideo" value="<?php echo $deleteVideo; ?>">
                                        </form>
                                        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberIdValue;  ?>" />
                                        </form>
<?php
                                        $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                        $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                                        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                                        if ($requestpage)
                                        {
                                            $hidden_page = $requestpage;
                                        } 
                                        else
                                        {
                                            $hidden_page = '';
                                        }
                                        if ($searchtextbox)
                                        {
                                            $hidden_searchbox = $searchtextbox;
                                        } 
                                        else
                                        {
                                            $hidden_searchbox = $hiddensearchbox;
                                        }
?>
                                        <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                                            <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                                            <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                                        </form>
                                         <form name="sortform"  action="<?php echo $page; ?>" method="post">
                                            <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
                                         </form>

                                <script type="text/javascript">

                                    function changepage(pageno)
                                    {
                                        document.getElementById("page").value=pageno;
                                        document.pagination.submit();
                                    }

                                    function my_message(vid)
                                    {
                                        var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
                                        if (flg)
                                        {
                                            var r=document.getElementById('deletevideo').value=vid;
                                            document.deletemyvideo.submit();
                                            return true;
                                        }
                                        else
                                        {
                                            return false;
                                        }
                                    }
                                    function videoplay(vid,cat)
                                    {
                                        window.open('index.php?option=com_contushdvideoshare&view=player&id='+vid+'&catid='+cat,'_self');
                                    }
                                    function editvideo(evid)
                                    {

                                        window.open(evid,'_self');
                                    }
                                    function sortvalue(sortvalue)
                                    {
                                        document.getElementById("sorting").value=sortvalue;
                                        document.sortform.submit();
                                    }
                                    function membervalue(memid)
                                    {
                                        document.getElementById('memberidvalue').value=memid;
                                        document.memberidform.submit();
                                    }

                                </script>
