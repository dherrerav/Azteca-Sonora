<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        configxml.php
 * @location    /components/com_contushdvideosahre/models/configxml.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :Generating configxml
 */
// No Direct access
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
        if (JRequest::getVar('Itemid', '', 'get', 'int')) {
            $itemid = JRequest::getVar('Itemid', '', 'get', 'int');
        }
        
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
        $midrollads = "false";
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
         $language = JRequest::getVar('lang');
        if( $language != ''){
        $language = '&lang='.$language;
        }
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
            $playlistxml = "index.php?option=com_contushdvideoshare&amp;view=playxml&amp;id=" . JRequest::getVar('id', '', 'get', 'int') . "&amp;catid=" . JRequest::getVar('catid', '', 'get', 'int');
            $location = $base . "index.php?option=com_contushdvideoshare&amp;view=player&amp;id=" . JRequest::getVar('id', '', 'get', 'int') . "&amp;catid=" . JRequest::getVar('catid', '', 'get', 'int');
        } elseif (JRequest::getVar('id', '', 'get', 'int')) {
            $playlistxml = "index.php?option=com_contushdvideoshare&amp;view=playxml&amp;id=" . JRequest::getVar('id', '', 'get', 'int');
            $location = $base . "index.php?option=com_contushdvideoshare&amp;view=player&amp;id=" . JRequest::getVar('id', '', 'get', 'int');
        } else {
            $playlistxml = "index.php?option=com_contushdvideoshare&amp;view=playxml&amp;featured=true";
            $location = $base . "index.php?option=com_contushdvideoshare&amp;view=player&amp;featured=true";
        }
        //$emailpath=JURI::base()."/index.php?option=com_contushdvideoshare&view=email";
        $adsxml = JRoute::_("index.php?option=com_contushdvideoshare&amp;view=adsxml");
        $midrollxml = JRoute::_("index.php?option=com_contushdvideoshare&amp;view=midrollxml");
        $emailpath = $base .  "components/com_contushdvideoshare/hdflvplayer/email.php" ;
        $logopath = $base . "components/com_contushdvideoshare/videos/" . $settingsrows[0]->logopath;
        $languagexml = JRoute::_("index.php?option=com_contushdvideoshare&amp;view=languagexml");
        $videoshareurl = JRoute::_("index.php?option=com_contushdvideoshare&amp;view=videourl");
        $cssurl = $base . "components/com_contushdvideoshare/hdflvplayer/css/midrollformat.css";
      $playlistxml= JRoute::_($playlistxml);
              //ob_start();
        ob_clean();
        session_start();
        header("cache-control: private");
        header("Pragma: public");
        header("Content-type: application/xml");
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
              playlistXML="' .$playlistxml.  '"
              adXML="' . $adsxml . '"
              midrollXML="' . $midrollxml . '"
              languageXML="' . $languagexml . '"
              cssURL="' . $cssurl . '"
              debug="false"
              shareURL="' . $emailpath . '"
              videoshareURL="' . $videoshareurl . '"
              showPlaylist="' . $playlist . '"
              vast_partnerid="' . $vast_pid . '"
              vast="' . $vast . '"
              UseYouTubeApi="' . $Youtubeapi . '"
              scaleToHideLogo="' . $scaletologo . '"
              location="' . $location . '">';
        echo '<timer>' . $timer . '</timer>';
        echo '<zoom>' . $zoom . '</zoom>';
        echo '<email>' . $share . '</email>';
        echo '<fullscreen>' . $fullscreen . '</fullscreen>';
        echo '</config>';
        exit();
    }

}

