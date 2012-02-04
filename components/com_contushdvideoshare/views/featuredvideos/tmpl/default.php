<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: June 15 2010
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
if ($app->getTemplate() != 'hulutheme')//conditon to check hulu theme or not
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
<div class="section videoscenter" >
    <div class="standard tidy">
        <div class="layout b-c">
            <div class="gr b" >
                <div class="layout a-b-c">
                    <div class="gr a">
                        <div class="callout-header-home titlespace">
                            <h2 class="home-link hoverable"><?php ECHO _HDVS_FEATURED_VIDEOS; ?></h2>
                        </div>
                        <table>
<?php
        $totalrecords = '';
        $seoOption = '';
        $src_path = '';
        $totalrecords = $this->featurevideosrowcol[0]->featurcol * $this->featurevideosrowcol[0]->featurrow;
        if (count($this->featuredvideos) - 4 < $totalrecords)
        {
            $totalrecords = count($this->featuredvideos) - 4;
        }

        $no_of_columns = $this->featurevideosrowcol[0]->featurcol;//get the no of columns to display featured videos
        $current_column = 1;
        for ($i = 0; $i < $totalrecords; $i++)
        {
            $colcount = $current_column % $no_of_columns;
            if ($colcount == 1)
            {
                echo '<tr>';
            }
            /* Seo Option Settings */
            $seoOption = $this->featurevideosrowcol[0]->seo_option;

            if ($seoOption == 1)
            {
                $featuredCategoryVal = "category=" . $this->featuredvideos[$i]->seo_category;
                $featuredVideoVal = "video=" . $this->featuredvideos[$i]->seotitle;
            }
            else
            {
                $featuredCategoryVal = "catid=" . $this->featuredvideos[$i]->catid;
                $featuredVideoVal = "id=" . $this->featuredvideos[$i]->id;
            }
            if ($this->featuredvideos[$i]->filepath == "File" || $this->featuredvideos[$i]->filepath == "FFmpeg")
            {
                $src_path = "components/com_contushdvideoshare/videos/" . $this->featuredvideos[$i]->thumburl;
            }
            if ($this->featuredvideos[$i]->filepath == "Url" || $this->featuredvideos[$i]->filepath == "Youtube")
            {
                $src_path = $this->featuredvideos[$i]->thumburl;
            }

            if ($this->featuredvideos[$i]->id != '')
            {
                    $orititle = $this->featuredvideos[$i]->title;       //Title name changed here for seo url purpose
                    $newtitle = explode(' ', $orititle);
                    $displaytitle1 = implode('-', $newtitle);
                    $displaytitle = str_replace('.', '', $displaytitle1);
             ?>
            <td class="rightrate">
            <div class="home-thumb">
            <div class="home-play-container" >
            <span class="play-button-hover">
            <div class="movie-entry yt-uix-hovercard">

                                            <div class="tooltip">
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $featuredCategoryVal . "&amp;" . $featuredVideoVal); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="125" height="69" title=""  /></p></a>
                                                  <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $this->featuredvideos[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $this->featuredvideos[$i]->description.'</p>'; ?>

                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $this->featuredvideos[$i]->times_viewed; ?></span></div>
                                                          </div></div>

               </div>
                </span>
               </div>
                <div class="show-title-container">
                    <a href="<?php echo 'index.php?option=com_contushdvideoshare&view=player&'.$featuredCategoryVal; ?>&<?php echo $featuredVideoVal; ?>" class="show-title-gray info_hover">
                    <?php if (strlen($this->featuredvideos[$i]->title) > 18)//check the category length
                            {
                                echo JHTML::_('string.truncate', ($this->featuredvideos[$i]->title), 18);
                                    //echo (substr($this->featuredvideos[$i]->title, 0, 18)) . '...';//split the title length to 18 digits
                            }
                          else
                             {
                                    echo $this->featuredvideos[$i]->title;
                             } ?>
                    </a>
                </div>
                <span class="video-info">
                   <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $featuredCategoryVal; ?>"><?php echo $this->featuredvideos[$i]->category; ?></a>
                </span>
                <span class="floatleft">

<?php
                                if (isset($this->featuredvideos[$i]->ratecount) && $this->featuredvideos[$i]->ratecount != 0)
                                {
                                    $ratestar = round($this->featuredvideos[$i]->rate / $this->featuredvideos[$i]->ratecount);
                                }
                                else
                                {
                                    $ratestar = 0;
                                } ?>
                                 <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                 </span>


                        <span class="floatright viewcolor"> <?php ECHO _HDVS_VIEWS; ?></span>
                        <span class="floatright viewcolor view"><?php echo $this->featuredvideos[$i]->times_viewed; ?></span>

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
        </div>     <table cellpadding="0" cellspacing="0" border="0"   class="page_align"   id="pagination" >
            <tr align="right">
                <td align="right"  class="page_rightspace">
                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                        <tr>
<?php                           $hiddenPage = '';
                                $pages = $this->featuredvideos['pages'];
                                $pageNo = $this->featuredvideos['pageno'];
                                $previousPage = $this->featuredvideos['pageno'] - 1;
                                $hiddenPage = JRequest::getVar('page', '', 'post', 'int');
                                if ($this->featuredvideos['pageno'] > 1)
                                    echo('<td align="right"><a onclick="changepage('.$previousPage.');">' . _HDVS_PREVIOUS . '</a></td>');
                                if (isset($hiddenPage))
                                {
                                    if ($hiddenPage > 3)
                                     {
                                        $page = $hiddenPage - 2;
                                        if ($hiddenPage > 2)
                                        {
                                            echo('<td align="right"><a onclick="changepage("1")">1</a></td>');
                                            echo ('<td align="right">...</td>');
                                        }
                                    }
                                    else
                                    {
                                        $page=1;
                                    }
                                }
                                else
                                {
                                    $page=1;
                                }
                                if($pages>1){
                                for ($i = $page, $j = 1; $i <= $pages; $i++, $j++)
                                {
                                    if ($pageNo != $i)
                                    {
                                        echo('<td align="right"><a onclick="changepage(' . $i . ')">' . $i . '</a></td>');
                                    }
                                    else
                                    {
                                        echo('<td align="right"><a onclick="changepage('.$i.');" class="active">'.$i.'</a></td>');

                                    }
                                    if ($j > 2)
                                        break;
                                }
                                if ($i < $pages)
                                {
                                    if ($i + 1 != $pages)
                                      echo ('<td align="right">...</td>');
                                      echo('<td align="right"><a onclick="changepage(' . $pages . ')">' . $pages . '</a></td>');
                                }
                                $pageNumber = $pageNo + 1;
                                if ($pageNo < $pages)
                                    echo ('<td align="right"><a onclick="changepage('.$pageNumber.');">' . _HDVS_NEXT . '</a></td>');}
?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <!--  PAGINATION STARTS HERE-->
        <br/><br/><br/>
        <br/>
        <?php
        $memberidvalue = '';
        if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                {
                      $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                }
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