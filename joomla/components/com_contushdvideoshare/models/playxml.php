<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        playxml.php
 * @location    /components/com_contushdvideosahre/models/playxml.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   creating play list xml page
 */

// No Direct access
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class Modelcontushdvideoshareplayxml extends JModel {

    function playgetrecords() {
        global $mainframe;
        $db = & JFactory::getDBO();
        $playlistid = 0;
        $mid = 0;
        $itemid = 0;
        $rs_modulesettings = "";
        $moduleid = 0;
        $id = 0;
        $playlistautoplay = "false";
        $midrollads = "false";
        $postrollads = "false";
        $prerollads = "false";
        $videoid = 0;
        $home_bol = "false";
        if (JRequest::getvar('id', '', 'get', 'int')) {
            $videoid = JRequest::getvar('id', '', 'get', 'int');
            $videocategory = JRequest::getvar('catid', '', 'get', 'int');
            if ($videoid != "") {
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and b.published=1 and a.id=$videoid ";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
            }
            if (count($rows) > 0) {
                $where = "and b.id=" . JRequest::getvar('catid', '', 'get', 'int') . " and a.id not in($videoid)";
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and b.published='1' and b.id=" . JRequest::getvar('catid', '', 'get', 'int') . " and a.id != $videoid";
                $db->setQuery($query);
                $playlist = $db->loadObjectList();
            }
        } else {
            $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and b.published=1 and a.type='0' group by e.vid order by a.ordering asc"; // Query is to display recent videos in home page
            $db->setQuery($query);
            $rs_video = $db->loadObjectList();
        }

        if (isset($rows) && count($rows) > 0)
            $rs_video = array_merge($rows, $playlist);
        $qry_settings = "select * from #__hdflv_player_settings LIMIT 1";
        $db->setQuery($qry_settings);
        $rs_settings = $db->loadObjectList();
        if (count($rs_settings) > 0) {
            $playlistautoplay = ($rs_settings[0]->playlist_autoplay == 1) ? $playlistautoplay = "true" : $playlistautoplay = "false";
        }
        $this->showxml($rs_video, $playlistautoplay);
    }

    function showxml($rs_video, $playlistautoplay) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<playlist autoplay="' . $playlistautoplay . '">';
        $current_path = "components/com_contushdvideoshare/videos/";
        $hdvideo = "";
        if (count($rs_video) > 0) {
            foreach ($rs_video as $rows) {
                $timage = "";
                $streamername = "";
                if ($rows->filepath == "File" || $rows->filepath == "FFmpeg") {
                    $video = JURI::base() . $current_path . $rows->videourl;
                    ($rows->hdurl != "") ? $hdvideo = JURI::base() . $current_path . $rows->hdurl : $hdvideo = "";
                    $previewimage = JURI::base() . $current_path . $rows->previewurl;
                    $timage = JURI::base() . $current_path . $rows->thumburl;
                    if ($rows->hdurl)
                        $hd_bol = "true";
                    else
                        $hd_bol="false";
                }
                elseif ($rows->filepath == "Url") {
                    $video = $rows->videourl;
                    $previewimage = $rows->previewurl;
                    $timage = $rows->thumburl;
                    if ($rows->hdurl)
                        $hd_bol = "true";
                    else
                        $hd_bol="false";
                    $hdvideo = $rows->hdurl;
                }
                elseif ($rows->filepath == "Youtube") {
                    $video = $rows->videourl;
                    $regexwidth = '/\components\/(.*?)/i';

                    $str2 = strstr($rows->previewurl, 'components');

                    if ($str2 != "") {
                        $previewimage = JURI::base() . $rows->previewurl;
                        $timage = JURI::base() . $rows->thumburl;
                    } else {
                        $previewimage = $rows->previewurl;
                        $timage = $rows->thumburl;
                    }
                    $hd_bol = "false";
                    $hdvideo = "";
                }
                ($rows->streameroption == "lighttpd") ? $streamername = $rows->streameroption : $streamername = $rows->streamerpath;
                ($rows->streameroption == "rtmp") ? $streamername = $rows->streamerpath : $streamername = "";
                ($rows->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
                ($rows->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
                ($rows->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
                ($rows->download == 0) ? $download = "false" : $download = "true";
                ($rows->targeturl == "") ? $targeturl = "" : $targeturl = $rows->targeturl;
                ($rows->postrollads == "1") ? $postrollid = $rows->postrollid : $postrollid = 0;
                ($rows->prerollads == "1") ? $prerollid = $rows->prerollid : $prerollid = 0;
                $title = $rows->title;
                $rate = $rows->rate;
                $ratecount = $rows->ratecount;
                $views = $rows->times_viewed;
                $islive = "false";
                $tags = $rows->tags;
                if ($streamername != "")
                    $islive = "true";
                echo '<mainvideo  rating="' . $rate . '" views="' . $views . '" ratecount="' . $ratecount . '" category="' . $rows->playlistid . '" url="' . $video . '" isLive ="' . $islive . '" allow_download="' . $download . '" preroll_id="' . $prerollid . '" postroll_id="' . $postrollid . '" postroll="' . $postrollads . '" preroll="' . $prerollads . '" midroll="' . $midrollads . '" streamer="' . $streamername . '" Preview="' . $previewimage . '" hdpath="' . $hdvideo . '" thu_image="' . $timage . '" id="' . $rows->id . '" hd="' . $hd_bol . '"  tags="' . $tags . '" >';
                echo '<title>';
                echo '<![CDATA[' . $rows->title . ']]>';
                echo '</title>';
                echo '</mainvideo>';
            }
        }
        echo '</playlist>';
        exit();
    }

}

