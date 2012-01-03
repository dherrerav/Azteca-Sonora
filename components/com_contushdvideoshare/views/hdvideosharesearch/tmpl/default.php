<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/com_contushdvideosahre/views/hdvideosearch/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : front page video search page layout
 */

// No Direct access
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$itemid = JRequest::getVar('Itemid', '', 'get', 'int');
$user = & JFactory::getUser();
?>
<?php
$app = & JFactory::getApplication();
if ($app->getTemplate() != 'hulutheme')
    JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css', array(), true);
?>

<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<div class="player clearfix">
    <div id="clsdetail">
        <div class="lodinpad">
            <?php
            if ($app->getTemplate() != 'hulutheme') {
                if (USER_LOGIN == '1') {
                    if ($user->get('id') != '') {
            ?>
            <span style='float:right'><b><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=myvideos"); ?>"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_users&task=user.logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&Itemid=' . $itemid); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>
            <?php } else { ?>
            <span class="toprightmenu">
                <b>
                    <a href="<?php echo JRoute::_(JURI::base() . "index.php?option=com_users&view=registration"); ?>"><?PHP ECHO _HDVS_REGISTER; ?></a> |
                    <a href="<?php echo JRoute::_(JURI::base() . "index.php?option=com_users&view=login"); ?>"> <?PHP ECHO _HDVS_LOGIN; ?></a>
                </b>
            </span>
            <?php
                        }
                    }
                }
            ?>

            <?php
            $totalrecords = $this->searchrowcol[0]->searchcol * $this->searchrowcol[0]->searchrow;
            if (count($this->search) - 4 < $totalrecords) {
                $totalrecords = count($this->search) - 4;
            }


            if ($totalrecords == -4) {
            ?>
            <div class="callout-header-home">
                <h2 class="home-link hoverable"><?PHP ECHO _HDVS_SEARCH_RESULT; ?></h2>
            </div>
            <?php
            echo '<div align="center" style="padding-top:10px;color:#274576;font-weight:bold;"> ' . _HDVS_NO_RECORDS_FOUND . ' </div>';
            } else {
            ?>
            <div class="videoheadline"></div>
            <div class="section" >
                <div class="standard tidy">
                    <div class="layout b-c">
                        <div class="gr b" >
                            <div class="layout a-b-c">
                                <div class="gr a">
                                    <div class="callout-header-home">
                                        <h2 class="home-link hoverable"><?PHP ECHO _HDVS_SEARCH_RESULT; ?></h2>
                                    </div>
                                    <table>
                                        <?php
                                            $no_of_columns = $this->searchrowcol[0]->searchcol;
                                            $current_column = 1;
                                            for ($i = 0; $i < $totalrecords; $i++) {
                                                $colcount = $current_column % $no_of_columns;
                                                if ($colcount == 1) {
                                                    echo '<tr>';
                                                }
                                                if ($this->search[$i]->filepath == "File" || $this->search[$i]->filepath == "FFmpeg")
                                                    $src_path = "components/com_contushdvideoshare/videos/" . $this->search[$i]->thumburl;
                                                if ($this->search[$i]->filepath == "Url" || $this->search[$i]->filepath == "Youtube")
                                                    $src_path = $this->search[$i]->thumburl;
                                        ?>
                                        <?php if ($this->search[$i]->vid != '') {  ?>
                                            <td style="vertical-align:top;">
                                            <div class="home-thumb">
                                                <div class="home-play-container" >
                                                    <span class="play-button-hover">
                                                        <div class="movie-entry yt-uix-hovercard">
                                                            <a class="tooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->search[$i]->id . "&catid=" . $this->search[$i]->catid); ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                <div class="clearfix"></div>
                                                                <div id="Tooltipwindow" style="clear:both">
                                                                    <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->search[$i]->category; ?></p>
                                                                    <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->search[$i]->description; ?></p>
                                                                        <?php if ($this->searchrowcol[0]->viewedconrtol == 1) { ?>
                                                                        <hr>
                                                                        <span ><?php echo $this->search[$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
                                                                               <?php } ?>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </span>
                                                </div>
                                               <div class="show-title-container">
                                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $this->search[$i]->vid . "&catid=" . $this->search[$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($this->search[$i]->title) > 18) { echo (substr($this->search[$i]->title, 0, 18)) . "..."; } else { echo $this->search[$i]->title; } ?></a>
                                                </div>
                                                <span class="video-info"> <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $this->search[$i]->catid); ?>"><?php echo $this->search[$i]->category; ?></a> </span>
                                                <?php if ($this->searchrowcol[0]->ratingscontrol == 1) { ?>
                                                    <span class="video-info">
                                                        <span style="float:left"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                            <?php
                                                                if (isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount != 0) {
                                                                $ratestar = round($this->search[$i]->rate / $this->search[$i]->ratecount);
                                                                } else {
                                                                $ratestar = 0;
                                                                }
                                                            ?>
                                                        <span class="floatleft"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                        </span>
                                                <?php } ?>
                                                    <div class="clear"></div>
                                                    <?php if ($this->searchrowcol[0]->viewedconrtol == 1) { ?>
                                                        <span class="video-info">
                                                            <span class="floatleft">  <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                            <span class="floatleft"><?php echo $this->search[$i]->times_viewed; ?></span>
                                                        </span>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                    </div>

                                            <?php } ?>
                                                <!----------First row---------->
                                            <?php
                                                if ($colcount == 0) {
                                                    echo '</tr><div class="clear"></div>';
                                                    $current_column = 0;
                                                }
                                                $current_column++;
                                            }
                                            if ($current_column != 0) {
                                                $rem_columns = $no_of_columns - $current_column + 1;
                                                echo "<td colspan=$rem_columns></td></tr>";
                                            }
                                            //  echo '</table>';
                                        }
                                            ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!--  PAGINATION STARTS HERE-->
        <br/><br/>
        <table cellpadding="0" cellspacing="0" border="0"   class="page_align"  id="pagination" >
            <tr align="right">
                <td align="right"  class="page_rightspace">
                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                        <tr>
                            <?php
                                if (isset($this->search['pages']))
                                    $pages = $this->search['pages'];
                                if (isset($this->search['pageno'])) {
                                    $q = $this->search['pageno'];
                                    $q1 = $this->search['pageno'] - 1;

                                    if ($this->search['pageno'] > 1)
                                        echo("<td align='right'><a onclick='changepage($q1);'>" . _HDVS_PREVIOUS . "</a></td>");
                                }
                                if (JRequest::getVar('page', '', 'post', 'int')) {
                                    if (JRequest::getVar('page', '', 'post', 'int') > 3) {
                                        $page = JRequest::getVar('page', '', 'post', 'int') - 2;
                                        if (JRequest::getVar('page', '', 'post', 'int') > 2) {
                                            echo("<td align='right'><a onclick='changepage(1)'>1</a></td>");
                                            echo ("<td align='right'>...</td>");
                                        }
                                    }
                                    else
                                        $page=1;
                                }
                                else
                                    $page=1;
                                if (isset($pages)) {
                                    for ($i = $page, $j = 1; $i <= $pages; $i++, $j++) {
                                        if ($q != $i)
                                            echo("<td align='right'><a onclick='changepage(" . $i . ")'>" . $i . "</a></td>");
                                        else
                                            echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                                        if ($j > 2)
                                            break;
                                    }
                                    if ($i < $pages) {
                                        if ($i + 1 != $pages)
                                            echo ("<td align='right'>...</td>");
                                        echo("<td align='right'><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></td>");
                                    }
                                    $p = $q + 1;
                                    if ($q < $pages)
                                        echo ("<td align='right'><a onclick='changepage($p);'>" . _HDVS_NEXT . "</a></td>");
                                }
                            ?>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br/><br/>
    </div>
</div>
<form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
    <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php if (JRequest::getVar('memberidvalue', '', 'post', 'int')) { echo JRequest::getVar('memberidvalue', '', 'post', 'int'); }; ?>" />
</form>
<?php $page = $_SERVER['REQUEST_URI']; ?>
<form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
    <input type="hidden" id="page" name="page" value="<?php if (JRequest::getVar('page', '', 'post', 'int')) { echo JRequest::getVar('page', '', 'post', 'int'); }; ?>" />
    <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php if (JRequest::getVar('searchtxtbox', '', 'post', 'string')) { echo JRequest::getVar('searchtxtbox', '', 'post', 'string'); } else { echo JRequest::getVar('hidsearchtxtbox', '', 'post', 'string'); }; ?>" />
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
