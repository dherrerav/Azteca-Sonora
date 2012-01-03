<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/modules/mod_HDVideoShareFeatured/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Featured
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
 JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css', array(), true);
 JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/tool_tip.css', array(), true);
?>
<span class="module_menu <?php echo $class;?> ">
    <br/>
    <div  align="center" id="module_videos" >
        <table style="margin-top:-20px;">
            <?php
            $totalrecords = count($result);
            $j = 0;
            for ($i = 0; $i < $totalrecords; $i++) {

                if ($i == 0) {
            ?>
                    <tr>
                <?php }
                if (($i % $result1[0]->sidefeaturedvideocol) == 0 && $i != 0) {
                ?>
                </tr><tr>
                <?php } ?>
                <td >

                    <?php
                    if ($result[$i]->filepath == "File" || $result[$i]->filepath == "FFmpeg")
                        $src_path = JURI::base() . "components/com_contushdvideoshare/videos/" . $result[$i]->thumburl;
                    if ($result[$i]->filepath == "Url" || $result[$i]->filepath == "Youtube")
                        $src_path = $result[$i]->thumburl;
                    ?>
                    <div class=" clearfix">
                        <div class="">
                            <?php
                            $orititle = $result[$i]->title;
                            $newtitle = explode(' ', $orititle);
                            $displaytitle = implode('-', $newtitle);
                            ?>
                            <div class="home-thumb">
                                <div class="home-play-container">
                                    <span class="play-button-hover">
                                        <div class="movie-entry yt-uix-hovercard">
                                            <a class="tooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $result[$i]->id . "&catid=" . $result[$i]->catid); ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                <div class="clearfix"></div>
                                                <div id="Tooltipwindow" style="clear:both">
                                                    <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $result[$i]->category; ?></p>
                                                    <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $result[$i]->description; ?></p>
                                                        <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                                    <hr>
                                                    <span ><?php echo $result[$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
                                                           <?php } ?>
                                                </div>
                                            </a>
                                        </div>
                                    </span>
                                </div>
                                <div class="show-title-container" id="title">
                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $result[$i]->id . "&catid=" . $result[$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($result[$i]->title) > 18) { echo (substr($result[$i]->title, 0, 18)) . "..."; } else { echo $result[$i]->title; } ?></a>
                                </div>
                                <div class="video-info" id="catagory-view">
                                    <span><?PHP ECHO _HDVS_CATEGORY; ?>: </span>
                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $result[$i]->catid); ?>"><?php echo $result[$i]->category; ?></a>
                                </div>
                                        <?php if ($result1[0]->ratingscontrol == 1) { ?>
                                                <span class="video-info">
                                                    <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                <?php
                                                    if (isset($result[$i]->ratecount) && $result[$i]->ratecount != 0) {
                                                        $ratestar = round($result[$i]->rate / $result[$i]->ratecount);
                                                    } else {
                                                        $ratestar = 0;
                                                    }
                                                ?>
                                                        <span class="floatleft innerrating"><div id="<?php echo $ratearray[$ratestar]; ?>"></div></span>
                                                </span>
                                        <?php } ?>
                                                <div class="clear"></div>
                                        <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                                    <span class="video-info">
                                                        <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                        <span class="floatleft"><?php echo $result[$i]->times_viewed; ?></span>
                                                    </span>
                                        <?php } ?>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $j++;
                                            }
                                   ?>
                    </tr>
                </table>
            </div>
        </span>
<?php $t = count($result); if ($t > 1) { ?><div class="clear"></div> <div align="right" class="morevideos"><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=featuredvideos"); ?>"><?php echo _HDVS_MORE_VIDEOS; ?></a></div><?php } ?>
<div class="clear"></div>