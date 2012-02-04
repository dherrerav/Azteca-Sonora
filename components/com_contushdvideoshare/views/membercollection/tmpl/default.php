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
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = & JFactory::getUser();
$requestpage = '';
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
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
    if (USER_LOGIN == '1')
            {
                if ($user->get('id') != '')
                  {
                        if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <span class="toprightmenu"><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="javascript: submitform();"><?php echo _HDVS_LOGOUT; ?></a></b></span>
            <?php }else { ?>
                <span class="toprightmenu"><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>
           <?php  } }
                else
                {
                    if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><span class="toprightmenu"><b><a href="index.php?option=com_users&view=registration"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_users&view=login"  alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></b></span>
           <?php }  else {      ?>
                    <span class="toprightmenu"><b><a href="index.php?option=com_user&view=register"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_user&view=login" alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></b></span>
        <?php
                } }
            }
}
?>
<div class="section videoscenter" >
<?php
foreach ($this->membercollection as $rows)
 {
 ?>
        <h1 class="underline"><?php echo _HDVS_VIDEO_ADDED_BY; ?>
        <?php if ($rows->username == '')
          {
              echo "Administrator";
          }
          else
           {
              echo ucwords($rows->username);
           } ?></h1>
<?php break;
} ?>
    <div class="videoheadline"></div>
    <?php
    $totalrecords = count($this->membercollection);
    $totalrecords = $this->memberpagerowcol[0]->memberpagecol * $this->memberpagerowcol[0]->memberpagerow;
    if (count($this->membercollection) - 4 < $totalrecords)
    {
        $totalrecords = count($this->membercollection) - 4;
    }
    ?>
    <div class="standard tidy">
        <div class="layout b-c">
            <div class="gr b" >
                <div class="layout a-b-c">
                    <div class="gr a">
                        <table>
<?php
    $no_of_columns = $this->memberpagerowcol[0]->memberpagecol;
    $current_column = 1;
    for ($i = 0; $i < $totalrecords; $i++)
    {
        $colcount = $current_column % $no_of_columns;
        if ($colcount == 1)
        {
            echo '<tr>';
        }
        if ($this->membercollection[$i]->filepath == "File" || $this->membercollection[$i]->filepath == "FFmpeg")
        {
            $src_path = "components/com_contushdvideoshare/videos/" . $this->membercollection[$i]->thumburl;
        }
        if ($this->membercollection[$i]->filepath == "Url" || $this->membercollection[$i]->filepath == "Youtube")
        {
            $src_path = $this->membercollection[$i]->thumburl;
        }
?>
                            <?php if ($this->membercollection[$i]->id != '') {
 ?>
                                <td class="rightrate">
                            <?php
                                $orititle = $this->membercollection[$i]->title;       //Title name changed here for seo url purpose
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
                                          <a class=" info_hover featured_vidimg" href="<?php echo 'index.php?option=com_contushdvideoshare&view=player&id='.$this->membercollection[$i]->id.'&catid='.$this->membercollection[$i]->catid; ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  /></p></a>


                                                <div class="Tooltipwindow clearfix" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->membercollection[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->membercollection[$i]->description.'</p>'; ?>

                                                        <?php if ($this->memberpagerowcol[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->membercollection[$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>


                                            </div>
                                        </span></div>
                                    <div class="show-title-container">
                                        <a href=" <?php echo 'index.php?option=com_contushdvideoshare&view=player&id='.$this->membercollection[$i]->id.'&catid='.$this->membercollection[$i]->catid; ?>" class="show-title-gray info_hover">
<?php
                                if (strlen($this->membercollection[$i]->title) > 18)
                                {
                                    echo JHTML::_('string.truncate', ($this->membercollection[$i]->title), 18);
                                    //echo (substr($this->membercollection[$i]->title, 0, 18)) . '...';
                                }
                                else
                                {
                                    echo $this->membercollection[$i]->title;
                                }
?></a>
                                    </div>
                                   <span class="video-info">
                               <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&catid='.$this->membercollection[$i]->catid); ?>"><?php echo $this->membercollection[$i]->category; ?></a>
                                    </span>
                                <?php if ($this->memberpagerowcol[0]->ratingscontrol == 1)
                                      { ?>
                                          <span class="floatleft">

<?php
                                            if (isset($this->membercollection[$i]->ratecount) && $this->membercollection[$i]->ratecount != 0)
                                            {
                                                $ratestar = round($this->membercollection[$i]->rate / $this->membercollection[$i]->ratecount);
                                            }
                                            else
                                            {
                                                $ratestar = 0;
                                            }
?>
                                        <span class="floatleft"><div class="ratethis1 <?php echo $ratingview[$ratestar]; ?> "></div></span>
                                    </span>
                                <?php } ?>

                                    <?php if ($this->memberpagerowcol[0]->viewedconrtol == 1)
                                            {
 ?>

                                                            <span class="floatright viewcolor"><?php echo _HDVS_VIEWS; ?></span>
                                                            <span class="floatright viewcolor view"><?php echo $this->membercollection[$i]->times_viewed; ?></span>

                                    <?php } ?>
                                                    <div class="clear"></div>
                                                </div>
<?php } ?>
                                            <!----------First row---------->
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
                                            } ?>
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
                                            $this->membercollection['pages']=isset($this->membercollection['pages'])?$this->membercollection['pages']:'';
                                            $this->membercollection['pageno']=isset($this->membercollection['pageno'])?$this->membercollection['pageno']:'';
                                            $pages = $this->membercollection['pages'];
                                            $q = $this->membercollection['pageno'];
                                            $q1 = $this->membercollection['pageno'] - 1;
                                            if ($this->membercollection['pageno'] > 1)
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
                                                echo ("<td align='right'><a onclick='changepage($p);'>" . _HDVS_NEXT . "</a></td>");
?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                   <?php
                       if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                {
                                      $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                }
                                $memberidvalue=isset($memberidvalue)?$memberidvalue:'';
                      ?>
                                            <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                                <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
                                            </form>
<?php
                                            $page = $_SERVER['REQUEST_URI'];
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
                        <script type="text/javascript">
                            function membervalue(memid)
                            {
                                document.getElementById('memberidvalue').value=memid;
                                document.memberidform.submit();
                            }
                            function changepage(pageno)
                            {
                                document.getElementById("page").value=pageno;
                                document.pagination.submit();
                            }
                        </script>
