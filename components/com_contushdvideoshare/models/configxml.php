<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */

//define( '_JEXEC', 1 );
//
//
//
//$str= dirname(__FILE__);
//
//define( 'DS', DIRECTORY_SEPARATOR );
//
//
//$str = str_replace(DS.'components'.DS.'com_contushdvideoshare'.DS.'models','',$str);
//
//
//
//
//define('JPATH_BASE',$str);
//
//
//
//
//
//require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
//
//require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
//
//
//$mainframe =& JFactory::getApplication('site');


defined('_JEXEC') or die();



jimport('joomla.application.component.model');

class Modelcontushdvideoshareconfigxml extends JModel {

    var $current_path = "/";
    var $base;

    function configgetrecords() {

        $base = JURI::base();
        $this->$base = str_replace('components/com_contushdvideoshare/models/', '', $base);
        global $mainframe;
        $playid = 0;
        $playid_playlistname = 0;
        $mid = 0;
        $moduleid = 0;
        $db = & JFactory::getDBO();
        $query = "select * from #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows = $db->loadObjectList();
        if (JRequest::getVar('id', '', 'get', 'int')) {
            $playid = JRequest::getVar('id', '', 'get', 'int');
        }
        $itemid = 0;
        $rs_modulesettings = "";
        $query1 = "select * from #__hdflv_videos where published='1'";
        $db->setQuery($query1);
        $rs_home = $db->loadObjectList();
        $home_bol = "false";
        if (count($rs_home > 0)) {
            for ($k = 0; $k < count($rs_home); $k++) {
                if ($rs_home[$k]->home == 1) {
                    $home_bol = "true";
                }
            }
        }
        $current_path = "components/com_contushdvideoshare/videos/";
        if ($playid) {
            $playid = trim($playid);
            $query = "select * from #__hdflv_videos where published='1' and id=$playid";
        } else {
            if ($home_bol == "true")
                $query = "select * from #__hdflv_videos where published='1' limit 1";
            else
                $query = "select * from #__hdflv_videos where published='1' limit 1";
        }
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $hdvideo = "";
        $video = "";
        $previewimage = "";
        $hd_bol = "false";
        if (count($rows) > 0) {
            if ($rows[0]->filepath == "File" || $rows[0]->filepath == "FFmpeg") {

                $video = $this->$base . $current_path . $rows[0]->videourl;
                ($rows[0]->hdpath != "") ? $hdvideo = $this->$base . $current_path . $rows[0]->hdpath : $hdvideo = "";
                $previewimage = $this->$base . $current_path . $rows[0]->previewurl;
                if ($rows[0]->hdpath)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
            }
            elseif ($rows[0]->filepath == "Url") {
                $video = $rows[0]->videourl;
                $previewimage = $rows[0]->previewurl;
                if ($rows[0]->hdpath)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
                $hdvideo = $rows[0]->hdpath;
            }
            elseif ($rows[0]->filepath == "Youtube") {
                $video = $rows[0]->videourl;
                $previewimage = $rows[0]->previewurl;
                if ($rows[0]->hdpath)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
                $hdvideo = $rows[0]->hdpath;
            }
        }
        $this->configxml($rs_modulesettings, $settingsrows, $video, $previewimage, $hdvideo, $hd_bol, $playid, $itemid, $playid_playlistname, $moduleid, $this->$base);
    }

    function configxml($rs_modulesettings, $settingsrows, $video, $previewimage, $hdvideo, $hd_bol, $playid, $itemid, $playid_playlistname, $moduleid, $base) {
        global $mainframe;
        $skin = $base . "components/com_contushdvideoshare/hdflvplayer/skin/" . $settingsrows[0]->skin;
        $stagecolor = "0x" . $settingsrows[0]->stagecolor;
        if ($settingsrows[0]->autoplay == 1)
            $autoplay = "true";
        else
            $autoplay="false";
        if ($settingsrows[0]->Youtubeapi == 1)
            $Youtubeapi = "flash";
        else
            $Youtubeapi="php";
        if ($settingsrows[0]->zoom == 1)
            $zoom = "true";
        else
            $zoom="false";
        if ($settingsrows[0]->fullscreen == 1)
            $fullscreen = "true";
        else
            $fullscreen="false";
        if ($settingsrows[0]->skin_autohide == 1)
            $skin_autohide = "true";
        else
            $skin_autohide="false";
        if ($settingsrows[0]->timer == 1)
            $timer = "true";
        else
            $timer="false";
        if ($settingsrows[0]->shareurl == 1)
            $share = "true";
        else
            $share="false";
        if ($settingsrows[0]->playlist_autoplay == 1)
            $playlist_autoplay = "true";
        else
            $playlist_autoplay="false";
        if ($settingsrows[0]->hddefault == 1)
            $hddefault = "true";
        else
            $hddefault="false";
        if ($settingsrows[0]->scaletologo == 1)
            $scaletologo = "true";
        else
            $scaletologo="false";
        $playlistxml = "";
        $playlist = "false";
        if ($settingsrows[0]->related_videos == "1" || $settingsrows[0]->related_videos == "3") {
            $playlist = "true";
        }
        $license = "";
        if ($settingsrows[0]->licensekey != '')
            $license = $settingsrows[0]->licensekey;
        else
            $license="";
        $buffer = $settingsrows[0]->buffer;
        $normalscale = $settingsrows[0]->normalscale;
        $fullscreenscale = $settingsrows[0]->fullscreenscale;
        $volume = $settingsrows[0]->volume;
        $video1 = "";
        $playlist_open = "false";
        $postrollads = "false";
        $prerollads = "false";
        $ads = "false";
        $vast = "false";
        $vast_pid = 0;
        ($settingsrows[0]->playlist_open == 1) ? $playlist_open = "true" : $playlist_open = "false";
        ($settingsrows[0]->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
        ($settingsrows[0]->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
        ($settingsrows[0]->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
        ($settingsrows[0]->ads == 0) ? $ads = "false" : $ads = "true";
        ($settingsrows[0]->vast == 0) ? $vast = "false" : $vast = "true";
        $vast_pid = $settingsrows[0]->vast_pid;
        $playlistxml = $base . "components/com_contushdvideoshare/models/playxml.php";
        if ($playid) {
            if ($playid == -1) {
                $video = $video1;
            } else {
                $video = $video;
                $hdvideo = $hdvideo;
                $previewimage = $previewimage;
            }
        } else {
            $video = "";
            $hdvideo = "";
            $previewimage = "";
        }
        if (JRequest::getVar('catid', '', 'get', 'int')) {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int') . "&catid=" . JRequest::getVar('catid', '', 'get', 'int');
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player&id=" . JRequest::getVar('id', '', 'get', 'int') . "&catid=" . JRequest::getVar('catid', '', 'get', 'int');
        } elseif (JRequest::getVar('id', '', 'get', 'int')) {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int');
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player&id=" . JRequest::getVar('id', '', 'get', 'int');
        } else {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&featured=true";
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player&featured=true";
        }
//$emailpath=JURI::base()."/index.php?option=com_contushdvideoshare&view=email";
        $adsxml = JURI::base() . "index.php?option=com_contushdvideoshare&view=adsxml";
        $emailpath = $base . "components/com_contushdvideoshare/hdflvplayer/email.php";
        $logopath = $base . "components/com_contushdvideoshare/videos/" . $settingsrows[0]->logopath;
        $languagexml = $base . "index.php?option=com_contushdvideoshare&view=languagexml";
        $midrollxml = $base . "index.php?option=com_contushdvideoshare&view=midrollxml";
        $videoshareurl = $base . "index.php?option=com_contushdvideoshare&view=videourl";
        ob_clean();
        header("content-type:text/xml;charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<config
        license="' . $license . '"
        autoplay="' . $autoplay . '"
        playlist_open="' . $playlist_open . '"
        buffer="' . $buffer . '"
        normalscale="' . $normalscale . '"
        fullscreenscale="' . $fullscreenscale . '"
        logopath="' . $logopath . '"
        logo_target="' . $settingsrows[0]->logourl . '"
        logoalign="' . $settingsrows[0]->logoalign . '"
        Volume="' . $settingsrows[0]->volume . '"
        preroll_ads="' . $prerollads . '"
        midroll_ads="' . $midrollads . '"
        postroll_ads="' . $postrollads . '"
        HD_default="' . $hddefault . '"
        Download="false"
        logoalpha="' . $settingsrows[0]->logoalpha . '"
        skin_autohide="' . $skin_autohide . '"
        stagecolor="' . $stagecolor . '"
        skin="' . $skin . '"
        embed_visible="true"
        playlistXML="' . $playlistxml . '"
        adXML="' . $adsxml . '"
        midrollXML="' . $midrollxml . '"
        languageXML="' . $languagexml . '"
        debug="false"
        shareURL="' . $emailpath . '"
        videoshareURL="' . $videoshareurl . '"
        showPlaylist="' . $playlist . '"
        vast_partnerid="' . $vast_pid . '"
        vast="' . $vast . '"
        UseYouTubeApi="' . $Youtubeapi . '"
        scaleToHideLogo="' . $scaletologo . '"
        location="' . $locaiton . '">';
        echo '<timer>' . $timer . '</timer>';
        echo '<zoom>' . $zoom . '</zoom>';
        echo '<email>' . $share . '</email>';
        echo '<fullscreen>' . $fullscreen . '</fullscreen>';
        echo '</config>';
        exit();
    }

}
