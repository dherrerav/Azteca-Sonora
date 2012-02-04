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
$requestpage = JRequest::getVar('page', '', 'post', 'int');
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
                    <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="javascript: submitform();"><?php echo _HDVS_LOGOUT; ?></a></div>
            <?php }else { ?>
                <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo _HDVS_LOGOUT; ?></a></div>
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
<div class="player clearfix">
    <div id="clsdetail">
        <div class="lodinpad">
<?php
$totalrecords = $this->categoryrowcol[0]->categorycol * $this->categoryrowcol[0]->categoryrow;
if (count($this->categoryview) - 5 < $totalrecords) {
    $totalrecords = count($this->categoryview) - 5;
}
if ($totalrecords <= 0) { // If the count is 0 then this part will be executed
 ?>
            <div class="callout-header-home">
                <h2 class="home-link hoverable"><?php echo $this->categoryview[0]->category; ?></h2>
            </div>
            <?php
            echo '<div  class="no-record"> ' . _HDVS_NO_CATEGORY_VIDEOS_FOUND . ' </div>';
        } else {
            ?>
            <div class="videoheadline"></div>
            <div class="section" >
                <div class="standard tidy">
                    <div class="layout b-c">
                        <div class="gr b" >
                            <div class="layout a-b-c">

                                <div class="gr a">

                                    <table>
<?php
					            $no_of_columns = $this->categoryrowcol[0]->categorycol; // specifying the no of columns
					        	foreach($this->categoryList as $val){
                                        	$current_column = 1;
                                        	$l=0;
                                        for ($i = 0; $i < $totalrecords; $i++) {
                                            if($val->parent_id == $this->categoryview[$i]->parent_id && $val->category == $this->categoryview[$i]->category){
                                            	$colcount = $current_column % $no_of_columns;
                                            	if($colcount == 1 && $l==0){
                                            		echo  "<thead>
												      	<tr>
												         <th><h2 class='home-link hoverable'> $val->category </h2></th>
												      	</tr>
											   		</thead>";
                                            	}
                                            if ($colcount == 1) {
                                                echo "<tr>";
                                                   $l++;
                                            }

//For SEO settings
                $seoOption = $this->categoryrowcol[0]->seo_option;

                if ($seoOption == 1) {
                    $categoryCategoryVal = "category=" . $this->categoryview[$i]->seo_category;
                    $categoryVideoVal = "video=" . $this->categoryview[$i]->seotitle;
                } else {
                    $categoryCategoryVal = "catid=" . $this->categoryview[$i]->catid;
                    $categoryVideoVal = "id=" . $this->categoryview[$i]->id;
                }

                if ($this->categoryview[$i]->filepath == "File" || $this->categoryview[$i]->filepath == "FFmpeg")
                    $src_path = "components/com_contushdvideoshare/videos/" . $this->categoryview[$i]->thumburl;
                if ($this->categoryview[$i]->filepath == "Url" || $this->categoryview[$i]->filepath == "Youtube")
                    $src_path = $this->categoryview[$i]->thumburl;
?>
                    <?php if ($this->categoryview[$i]->id != '')
                           {
 ?>
                                            <td class="rightrate">
                                    <?php
                                            $orititle = $this->categoryview[$i]->title;       //Title name changed here for seo url purpose
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
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $categoryCategoryVal . "&amp;" . $categoryVideoVal); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="125" height="69" title=""  /></p></a>

                                                <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->categoryview[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->categoryview[$i]->description.'</p>'; ?>

                                                        <?php if ($this->categoryrowcol[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->categoryview[$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>
                                                                                                                </div>
                                                    </span>
                                                </div>
                                                <div class="show-title-container">
                                                    <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $categoryCategoryVal; ?>&<?php echo $categoryVideoVal; ?>" class="show-title-gray info_hover"><?php if (strlen($this->categoryview[$i]->title) > 18) {
                                               // echo (substr($this->categoryview[$i]->title, 0, 18)) . "...";
                                                        echo JHTML::_('string.truncate', ($this->categoryview[$i]->title), 18);
                                            } else {
                                                echo $this->categoryview[$i]->title;
                                            } ?></a>
                                                </div>
                                                <span class="video-info">
                                               <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $categoryCategoryVal; ?>"><?php echo $this->categoryview[$i]->category; ?></a>
                                                </span>
                                        <?php if ($this->categoryrowcol[0]->ratingscontrol == 1)
                                               { ?>
                                                <span class="floatleft">

                                                    <?php
                                                    if (isset($this->categoryview[$i]->ratecount) && $this->categoryview[$i]->ratecount != 0)
                                                    {
                                                        $ratestar = round($this->categoryview[$i]->rate / $this->categoryview[$i]->ratecount);
                                                    }
                                                    else
                                                    {
                                                        $ratestar = 0;
                                                    } ?>
                                                    <span class="floatleft"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                </span>
                                          <?php } ?>

                                                <?php if ($this->categoryrowcol[0]->viewedconrtol == 1)
                                                       {
 ?>

                                                        <span class="floatright viewcolor"> <?php echo _HDVS_VIEWS; ?></span>
                                                        <span class="floatright viewcolor view"><?php echo $this->categoryview[$i]->times_viewed; ?></span>

                                                <?php } ?>
                                                    <div class="clear"></div>
                                                </div>
                                            </td>
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
								            }
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
                </div>
                <!--  PAGINATION STARTS HERE-->
                <table cellpadding="0" cellspacing="0" border="0"  class="floatright" id="pagination" >
                    <tr align="right">
                        <td align="right"  class="page_rightspace">
                            <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                <tr>
<?php
                                            if (isset($this->categoryview['pageno']))
                                              {
                                                $q = $this->categoryview['pageno'] - 1;
                                                if ($this->categoryview['pageno'] > 1)
                                                    echo("<td align='right'><a onclick='changepage($q);'>" . _HDVS_PREVIOUS . "</a></td>");
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
                                                if($this->categoryview['pages']>1){
                                                for ($i = $page, $j = 1; $i <= $this->categoryview['pages']; $i++, $j++)
                                                 {
                                                    if ($this->categoryview['pageno'] != $i)
                                                        echo("<td align='right'><a onclick='changepage(" . $i . ")'>" . $i . "</a></td>");
                                                    else
                                                        echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                                                    if ($j > 3)
                                                        break;
                                                }
                                                if ($i < $this->categoryview['pages'])
                                                 {
                                                    if ($i + 1 != $this->categoryview['pages'])
                                                        echo ("<td align='right'>...</td>");
                                                    echo("<td align='right'><a onclick='changepage(" . $this->categoryview['pages'] . ")'>" . $this->categoryview['pages'] . "</a></td>");
                                                }
                                                $p = $this->categoryview['pageno'] + 1;
                                                if ($this->categoryview['pageno'] < $this->categoryview['pages'])
                                                    echo ("<td align='right'><a onclick='changepage($p);'>" . _HDVS_NEXT . "</a></td>");}
                                            }
?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>   <!--  PAGINATION END HERE-->
                                <?php }
                                ?>
                    <br/><br/>
                </div>
            </div>
        </div>
         <?php if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
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
        if($requestpage)
        {
            $hidden_page = $requestpage;
        }
        else
        {
            $hidden_page = '';
        }
        if($searchtextbox)
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