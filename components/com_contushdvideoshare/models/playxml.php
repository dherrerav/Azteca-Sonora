<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
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
        $postrollads = "false";
        $prerollads = "false";
        $videoid = 0;
        $home_bol = "false";
        if (JRequest::getvar('id', '', 'get', 'int')) {
            $videoid = JRequest::getvar('id', '', 'get', 'int');
            $videocategory = JRequest::getvar('catid', '', 'get', 'int');
            if ($videoid != "") {
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and a.id=$videoid ";
                $db->setQuery($query);
                $rows = $db->loadObjectList();
            }
            if (count($rows) > 0) {
                $where = "and b.id=" . JRequest::getvar('catid', '', 'get', 'int') . " and a.id not in($videoid)";
                // $query="select distinct a.*,b.* from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id  where a.published='1' $where group by a.id order by a.ordering asc";
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and b.id=" . JRequest::getvar('catid', '', 'get', 'int') . " and a.id != $videoid";
                $db->setQuery($query);
                $playlist = $db->loadObjectList();
            }
        } else {
            $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.featured='1' and a.type='0' group by e.vid order by a.ordering asc"; // Query is to display recent videos in home page
            $db->setQuery($query);
            $rs_video = $db->loadObjectList();
            if (count($rs_video) == 0) {
                $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' group by e.vid order by a.ordering asc limit 0,1"; // Query is to display recent videos in home page
                $db->setQuery($query);
                $rs_video = $db->loadObjectList();
            }
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
        $user = & JFactory::getUser();
        $rows = '';
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $uid = $user->get('id');
            if ($uid) {
                $db = &JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('g.id AS group_id')
                        ->from('#__usergroups AS g')
                        ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                        ->where('map.user_id = ' . (int) $uid);
                $db->setQuery($query);
                $message = $db->loadObjectList();
                foreach ($message as $mess) {
                    $accessid[] = $mess->group_id;
                }
            } else {
                $accessid[] = 1;
            }
        } else {
            $accessid = $user->get('aid');
        }



        ob_clean();
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<playlist autoplay="' . $playlistautoplay . '">';
        $current_path = "components/com_contushdvideoshare/videos/";
        $hdvideo = "";
        //print_r($rs_video);
        if (count($rs_video) > 0) {
            foreach ($rs_video as $rows) {
                $timage = "";
                $streamername = "";
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db = &JFactory::getDBO();
                    $query = $db->getQuery(true);
                    if($rows->useraccess == 0) $rows->useraccess = 1;
                    $query->select('rules as rule')
                            ->from('#__viewlevels AS view')
                            ->where('id = ' . (int) $rows->useraccess);
                    $db->setQuery($query);
                    $message = $db->loadResult();
                    $accessLevel = json_decode($message);
                }
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
                    //$video=$rows->protected_url;

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
                $db = & JFactory::getDBO();
                $query_ads = "select * from #__hdflv_ads where published=1 and id=$rows->postrollid"; //and home=1";//and id=11;";
                $db->setQuery($query_ads);
                $rs_ads = $db->loadObjectList();
                if (count($rs_ads) > 0) {
                    ($rows->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
                } else {
                    $postrollads = "false";
                }
                $query_ads = "select * from #__hdflv_ads where published=1 and id=$rows->prerollid"; //and home=1";//and id=11;";

                $db->setQuery($query_ads);
                $rs_ads = $db->loadObjectList();
                if (count($rs_ads) > 0) {
                    ($rows->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
                } else {
                    $prerollads = "false";
                }
                $query_ads = "select * from #__hdflv_ads where published=1 and typeofadd='mid' "; //and home=1";//and id=11;";
                $db->setQuery($query_ads);
                $rs_ads = $db->loadObjectList();
                if (count($rs_ads) > 0) {
                    ($rows->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
                } else {
                    $midrollads = "false";
                }

                ($rows->download == 0) ? $download = "false" : $download = "true";
                $member = "true";

                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $member = "false";
                    foreach ($accessLevel as $useracess) {
                        if (in_array("$useracess", $accessid) || $useracess == 1) {
                            $member = "true";
                            break;
                        }
                    }
                } else {
                    if ($rows->useraccess != 0) {
                        if ($accessid != $rows->useraccess && $accessid != 2) {
                            $member = "false";
                        }
                    }
                }
                ($rows->targeturl == "") ? $targeturl = "" : $targeturl = $rows->targeturl;
                ($rows->postrollads == "1") ? $postrollid = $rows->postrollid : $postrollid = 0;
                ($rows->prerollads == "1") ? $prerollid = $rows->prerollid : $prerollid = 0;
                $title = $rows->title;
                $rate = $rows->rate;
                $ratecount = $rows->ratecount;
                $views = $rows->times_viewed;
                if ($rows->filepath == "Youtube") {
                    $download = "false";
                }
                $islive = "false";
                $date = '';
                $date = date("m-d-Y", strtotime($rows->addedon));
                if ($streamername != "")
                    $islive = "true";
                $tags = $rows->tags;
                if (!preg_match('/vimeo/', $video)) {
                    echo '<mainvideo member = "' . $member . '" date="' . $date . '" rating="' . $rate . '" views="' . $views . '" ratecount="' . $ratecount . '" category="' . $rows->playlistid . '" url="' . $video . '" isLive ="' . $islive . '" allow_download="' . $download . '" preroll_id="' . $prerollid . '" midroll="' . $midrollads . '" postroll_id="' . $postrollid . '" postroll="' . $postrollads . '" preroll="' . $prerollads . '" streamer="' . $streamername . '" Preview="' . $previewimage . '" hdpath="' . $hdvideo . '" thu_image="' . $timage . '" id="' . $rows->id . '" hd="' . $hd_bol . '" tags="' . $tags . '" >';
                    echo '<title>';
                    echo '<![CDATA[' . $rows->title . ']]>';
                    echo '</title>';
                    echo '<tagline targeturl="' . $targeturl . '">';
                    if ($rows->description != "") {
                        echo '<![CDATA[<b>' . $rows->description . '</b>]]>';
                    }
                    echo '</tagline>';
                    echo '</mainvideo>';
                }
            }
        }
        echo '</playlist>';
        exit();
    }
}