<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        showvideos.php
 * @location    /components/com_contushdvideosahre/models/showvideos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Show vidoes Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelshowvideos extends JModel {

    function __construct() {
        parent::__construct();
        $app = JFactory::getApplication(); //Get configuration
        $config = JFactory::getConfig();
        $this->setState('limit', $app->getUserStateFromRequest('ads.limit', 'limit', $config->get('list_limit'), 'int')); // Get the pagination request variables
        $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
    }

    function showvideosmodel() {
        global $option, $mainframe;
        $app = & JFactory::getApplication();
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.title AS group_name')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $userId = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;
        if ($userId != 0) {
            $where = "where a.usergroupname= '$ugp->group_name'";
        } else {

            $where = "where a.usergroupname != '$ugp->group_name'";
        }
        $db = & JFactory::getDBO();
        $query = "select * from #__hdflv_upload $where";
        $db->setQuery($query);
        $rs_showads = $db->loadObjectList();
        $total = 0;
        $filter_order = $app->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'asc', 'word');
        $filter_playlistid = $app->getUserStateFromRequest($option . 'filter_playlistid', 'filter_playlistid', '', 'int');
        $search = $app->getUserStateFromRequest($option . 'search', 'search', '', 'string');
        $db = & JFactory::getDBO();
        $query = "SELECT count(*) FROM #__hdflv_upload";
        $db->setQuery($query);
        $total = $db->loadResult();
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $this->getState('limitstart'), $this->getState('limit'));
        // show condition for admin and other videos in admin panel
        $actype = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.title AS group_name')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_name;
        if ($actype != '0') {
            if ($ugp->group_name == 'Super Users')
                $where = " a.usergroupname='Super Users' or a.usergroupname='Manager' or a.usergroupname='Administrator'";
            else
                $where = " a.usergroupname='$ugp->group_name'and a.memberid=$userid";
        } else {
            $where = " a.usergroupname!='Super Users' and  a.usergroupname!='Manager' and  a.usergroupname!='Administrator'and a.memberid!='$userid'";
        }

        if ($filter_playlistid) {
            $query = "SELECT * from #__hdflv_category";
            $db->setQuery($query);
            $rs_showupload = $db->loadObjectList();
        }

        if ($filter_order) {
            $query = "SELECT distinct(d.videoid) as cvid,a.*,b.category,c.username FROM #__hdflv_upload a
            inner join #__users c on c.id = a.memberid
            LEFT JOIN #__hdflv_category b ON a.playlistid=b.id
            left join #__hdflv_comments d on d.videoid=a.id where
            $where
            order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit";
            $db->setQuery($query);
            $rs_showupload = $db->loadObjectList();
        }

        // table ordering
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;

        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        // search filter
        if ($search) {
            $query = "SELECT distinct(d.videoid) as cvid,a.*,b.category,c.username FROM #__hdflv_upload a
            inner join #__users c on c.id = a.memberid
            LEFT JOIN #__hdflv_category b ON a.playlistid=b.id
            left join #__hdflv_comments d on d.videoid=a.id where
            ($where) and
            a.title LIKE '%$search%'";
            $db->setQuery($query);
            $rs_showupload = $db->loadObjectList();
            $lists['search'] = $search;
        }
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['playlistid'] = JHTML::_('list.category', 'filter_playlistid', 'com_contushdvideoshare', (int) $rs_showplaylistname, $javascript);
        $showarray1 = array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'lists' => $lists, 'rs_showupload' => $rs_showupload, 'rs_showplaylistname' => $rs_showplaylistname);
        return $showarray1;
    }

    function pubvideo($arrayIDs) {
        if ($arrayIDs['task'] == "publish") {
            $publish = 1;
        } else {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__hdflv_upload set published=" . $publish . " WHERE id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }

    function savevideos($task) {
        $option = 'com_contushdvideoshare';
        $app = & JFactory::getApplication();
        global $mainframe;
        $fileoption = $_POST['fileoption'];
        $db = & JFactory::getDBO();
        $rs_saveupload = & JTable::getInstance('adminvideos', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = $cid[0];
        $rs_saveupload->load($id);
        $createddate = date("Y-m-d h:m:s");
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.title AS group_name')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_name;
        $usertype = $ugp->group_name;
        $userid_old = JRequest::getVar('memberid', '', 'post', 'int'); // ? JRequest::getVar('user_id', '', 'post', 'int') : $userid;
        $usertype_old = JRequest::getVar('usergroupname', '', 'post', 'string'); // ? JRequest::getVar('user_type', '', 'post', 'string') : $usertype;
        $adminvideos = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;
        if ($userid_old) {
            $memberid = $userid_old;
            $usertypes = $usertype_old;
        } else {
            $memberid = $userid;
            $usertypes = $usertype;
        }
        // To get height & width from playersettings for preview images
        $query = "select height,width,ffmpegpath from  #__hdflv_player_settings limit 1";
        $db->setQuery($query);
        $rs_settings = $db->loadObjectList();
        // Get count..
        if (count($rs_settings)) {
            // In Ffmpeg allowed width & height should be even nos.Hence 1 is added if it is odd no.
            if (( $rs_settings[0]->height % 2) == 0)
                $previewheight = $rs_settings[0]->height;
            else
                $previewheight = $rs_settings[0]->height + 1;
            if (( $rs_settings[0]->width % 2) == 0)
                $previewwidth = $rs_settings[0]->width;
            else
                $previewwidth= $rs_settings[0]->width + 1;
            // To make sure ffmpeg path is provided
            if ($rs_settings[0]->ffmpegpath) {
                $ffmpegpath = $rs_settings[0]->ffmpegpath;
            }
        }
        if (!$rs_saveupload->bind(JRequest::get('post'))) {
            exit();
        }
        // chd for fileoption which is given thru radio button
        if ($_POST['fileoption'] == "File") {
            // chd for new function
            if ($_POST['newupload'] == 0) {
                $file_size_videos = $_FILES['videourl']['size'];
                $file_size_thumbimages = $_FILES['thumburl']['size'];
                $file_size_fpreview = $_FILES['previewurl']['size'];
                $file_size_fhd = $_FILES['hdurl']['size'];
                $bol_newedit = "new";
            }
            // chd for edit function
            if ($_POST['newupload'] == 1) {
                if ($_POST['fvideos'] == 1)
                    $file_size_videos = $_FILES['videourl']['size'];
                else
                    $file_size_videos=0;
                if ($_POST['fthumb'] == 1)
                    $file_size_thumbimages = $_FILES['thumburl']['size'];
                else
                    $file_size_thumbimages=0;
                if ($_POST['fpreview'] == 1)
                    $file_size_fpreview = $_FILES['previewurl']['size'];
                else
                    $file_size_fpreview=0;
                if ($_POST['fhd'] == 1)
                    $file_size_fhd = $_FILES['hdurl']['size'];
                else
                    $file_size_fhd=0;
                $bol_newedit = "edit";
            }

            // Php validation to chk for file extensions & file upload max size..
            $this->fn_ffmpegdisable_validation($option, $rs_saveupload->id, $task, $bol_newedit, $file_size_videos, $file_size_thumbimages, $file_size_fpreview, $file_size_fhd);
        }

        if (isset($rs_saveupload->videourl)) {
            if ($rs_saveupload->videourl != "") {
                $rs_saveupload->videourl = trim($rs_saveupload->videourl);
            }
        }

        if (!$rs_saveupload->store()) {
            echo "<script> alert('" . $rs_saveupload->getError() . "');window.history.go(-1); </script>\n";
            exit();
        }

        $videourl = "";
        $thumburl = JURI::base() . "components/com_contushdvideoshare/images/default_thumb.jpg";
        $previewurl = JURI::base() . "components/com_contushdvideoshare/images/default_thumb.jpg";
        $hdurl = "";
        $streamer_option = "";
        $streamer_path = "";

        $streamer_option = $_POST['streameroption-value'];
        if ($fileoption == 'Url') {

            $videourl = $_POST['videourl-value'];
            if ($_POST['thumburl-value'] != "")
                $thumburl = $_POST['thumburl-value'];
            if ($_POST['previewurl-value'] != "")
                $previewurl = $_POST['previewurl-value'];
            $hdurl = $_POST['hdurl-value'];
            ($streamer_option == "rtmp") ? $streamer_path = $_POST['streamerpath-value'] : $streamer_path = "";

            $query = "update #__hdflv_upload SET streameroption= '$streamer_option',streamerpath='$streamer_path', filepath='$fileoption',videourl='$videourl',thumburl='$thumburl',previewurl='$previewurl',hdurl='$hdurl' where id=$rs_saveupload->id";
            $db->setQuery($query);
            $db->query();
        }

        $videourl = $_POST['videourl-value'];
        $str1 = explode('administrator', JURI::base());
        $videoshareurl = $str1[0] . "index.php?option=com_contushdvideoshare&view=videourl";
        $timeout = "";
        $header = "";
        $referer = "";

        if ($fileoption == "Youtube") {

            if (preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $videourl, $vresult)) {

                $imgstr = explode("v=", $videourl);
                $imgval = explode("&", $imgstr[1]);
                $previewurl = "http://img.youtube.com/vi/" . $imgval[0] . "/0.jpg";
                $img = "http://img.youtube.com/vi/" . $imgval[0] . "/1.jpg";
            } else {
                $curl = curl_init();
                if (strstr($referer, "://")) {
                    curl_setopt($curl, CURLOPT_REFERER, $referer);
                }
                curl_setopt($curl, CURLOPT_URL, $videoshareurl . '&url=' . $videourl . '&imageurl=' . $videourl);
                curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
                curl_setopt($curl, CURLOPT_HEADER, (int) $header);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $videoshareurl_location = curl_exec($curl);
                curl_close($curl);
                $location1 = "";
                $location2 = "";
                $location3 = "";
                $location = explode('&', $videoshareurl_location);
                $location1 = explode('location1=', $location[1]);
                $location2 = explode('location2=', $location[2]);
                $location3 = explode('location3=', $location[3]);
                $img = explode('imageurl=', $location[4]);
                $img = $img[1];
                $hdurl = "";
                if ($location2[1] != "")
                    $hdurl = $videourl;
            }



            $db = & JFactory::getDBO();
            $query = "update #__hdflv_upload SET streameroption= '$streamer_option',filepath='$fileoption' ,videourl='$videourl',thumburl='$img',previewurl='$previewurl',hdurl='$hdurl' where id=$rs_saveupload->id";
            $db->setQuery($query);
            $db->query();
        }
        $rs_saveupload->checkin();
        $idval = $rs_saveupload->id;
        // if file option is File then there are 4 upload options are displayed to get videos,
        // thumbimages,preview images & hd
        if ($fileoption == "File") {   // Checked for file option
            $normal_video = $_POST['normalvideoform-value'];
            $video_name = explode("uploads/", $normal_video);
            $file_video = $video_name[1];
            $hd_video = $_POST['hdvideoform-value'];
            $hd_name = explode("uploads/", $hd_video);
            $file_hvideo = $hd_name[1];
            $thumb_video = $_POST['thumbimageform-value'];
            $thumb_name = explode("uploads/", $thumb_video);
            $file_timage = $thumb_name[1];
            if (isset($thumb_name[1]) && $thumb_name[1] != "")
                $file_timage = $thumb_name[1];
            else
                $file_timage=$_POST['thumbimageform-value'];
            $preview_video = $_POST['previewimageform-value'];
            $preview_name = explode("uploads/", $preview_video);
            if (isset($preview_name[1]) && $preview_name[1] != "")
                $file_pimage = $preview_name[1];
            else
                $file_pimage=$_POST['previewimageform-value'];
            $filepath = $_POST['fileoption'];
            $this->fn_savedb_flashenable($option, $idval, $file_video, $file_timage, $file_pimage, $file_hvideo, $_POST['newupload'], $filepath);
            if ($file_video != '')
                $this->unlinkuploadedfiles($file_video);
            if ($file_hvideo != '')
                $this->unlinkuploadedfiles($file_hvideo);
            if ($file_timage != '')
                $this->unlinkuploadedfiles($file_timage);
            if ($file_pimage != '')
                $this->unlinkuploadedfiles($file_pimage);
        }

        if ($fileoption == "FFmpeg") {
            $ffmpeg_video = $_POST['ffmpegform-value'];
            $video_name = explode("uploads/", $ffmpeg_video);
            $file_video = $video_name[1];
            $target_path1 = FVPATH . "/images/uploads/" . $file_video;
            $vpath = VPATH1 . "/"; // To add / fwd slash at the end
            $exts1 = $this->findexts($target_path1);
            $target_path = $vpath . $idval . "_video" . "." . $exts1;
            rename($target_path1, $target_path);
            $target_path1 = $vpath . $idval . "_video" . "." . $exts1;
            $query = "select ffmpegpath from #__hdflv_player_settings";
            $db->setQuery($query);
            $rs_ffmpegpath = $db->loadObjectList();
            // Get ffmpeg path from db
            $ffmpeg_path = $rs_ffmpegpath[0]->ffmpegpath;
            $data = $this->ezffmpeg_vdofile_infos($target_path1, $ffmpeg_path);
            // Get file fmt..
            $hdfile = $data['vdo_format'];
            $duration = $data['vdo_duration_format'];
            // To check for HD or Flv or other movies

            if ($hdfile == "h264") {

                $exts = $this->findexts($file_video);
                $video_name = $idval . '_hd' . ".flv";
                $flvpath = $vpath . $idval . '_hd' . ".flv";
                   // to get hd file thru ffmpeg exe..
                exec($ffmpeg_path . ' ' . '-i' . ' ' . $target_path1 . ' ' . '-sameq' . ' ' . $flvpath . ' ' . '2>&1');
                // To get Thumb image & Preview image from the original video file
                exec($ffmpeg_path . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-r 1 -s 120x68 -f image2" . ' ' . $vpath . $idval . '_thumb' . ".jpeg");
                exec($ffmpeg_path . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-r 1 -s" . ' ' . $previewwidth . "x" . $previewheight . ' ' . " -f image2" . ' ' . $vpath . $idval . '_preview' . ".jpeg");
                $hd_name = $idval . '_video.' . $exts;
            } else {
                exec($ffmpeg_path . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-sameq" . ' ' . $vpath . $idval . '_video' . ".flv  2>&1");
                // To get Thumb image & Preview image from the original video file
                exec($ffmpeg_path . " -i " . $target_path1 . ' ' . "-r 1 -s 120x68 -f image2" . ' ' . $vpath . $idval . '_thumb' . ".jpeg");
                exec($ffmpeg_path . " -i " . $target_path1 . ' ' . "-r 1 -s " . ' ' . $previewwidth . "x" . $previewheight . ' ' . "-f image2" . ' ' . $vpath . $idval . '_preview' . ".jpeg");
                $video_name = $idval . '_video' . ".flv";
                $hd_name = "";
            }
            $thumb_name = $idval . '_thumb' . ".jpeg";
            $preview_name = $idval . '_preview' . ".jpeg";
            // To update the video file name in DB
            $query = "update #__hdflv_upload set filepath='$fileoption', videos='$file_name1',videourl='$video_name',thumburl='$thumb_name',previewurl='$preview_name',hdurl='$hd_name' WHERE id = $idval";
            $db->setQuery($query);
            $db->query();
        }
        $catid = $_POST['playlistid'];
        $query = "update #__hdflv_upload SET usergrupname= '$usertypes', memberid= '$memberid',created_date='$createddate' where id=$idval";
        $db->setQuery($query);
        $db->query();
        $query = "SELECT count(*) FROM #__hdflv_video_category where vid=$idval";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total != 0) {
            $query = "update #__hdflv_video_category SET catid= '$catid' where vid=$idval";

            $db->setQuery($query);
            $db->query();
        } else {
            $query = " insert into #__hdflv_video_category values ('$idval','$catid')";
            $db->setQuery($query);
            $db->query();
        }
        $userTypeRedirect = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos' ) ? "&actype=" . JRequest::getVar('actype', '', 'get', 'string') : "";
        switch ($task) {
            case 'applyvideos':
                $msg = 'Changes Saved';
                $link = 'index.php?option=' . $option . '&layout=adminvideos&task=editvideos' . $userTypeRedirect . '&cid[]=' . $rs_saveupload->id;
                break;
            case 'savevideoupload':
            default:
                $msg = 'Saved';
                $link = 'index.php?option=' . $option . '&layout=adminvideos' . $userTypeRedirect;
                break;
        }
        // redirect
        $app->redirect($link, $msg);
    }

    function unlinkuploadedfiles($unlink_file_name) {
        $targetpath1 = FVPATH . "/images/uploads/$$unlink_file_name";
        if (file_exists($targetpath1)) {
            unlink($targetpath1);
        }
    }

    function fn_ffmpegdisable_validation($option, $idval, $task, $bol_newedit, $file_size_videos, $file_size_thumbimages, $file_size_fpreview, $file_size_fhd) {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        if ($_FILES['videourl']['name'] != '') {
            $file_type = $_FILES['videourl']['type'];
            $file_name = $_FILES['videourl']['name'];
            // Get file extension
            $exts = $this->findexts($file_name);
            // To make sure video file extensions is exists
            if ($exts) {
                if (($exts != "mp3") && ($exts != "m4a") && ($exts != "mp4") && ($exts != "m4v") && ($exts != "mov") && ($exts != "mp4v") && ($exts != "f4v") && ($exts != "flv")) {
                    $bol_type = "video";
                    // Get error msg
                    fn_error_msg_link($task, $option, $bol_type, $bol_newedit, $idval);
                }
            }
        }
        if ($_FILES['hdurl']['name'] != "") {
            $file_type = $_FILES['hdurl']['type'];
            $file_name = $_FILES['hdurl']['name'];
            // Get file extension
            $exts = $this->findexts($file_name);
            // To make sure hd file extensions is exists
            if ($exts) {
                if (($exts != "mp3") && ($exts != "m4a") && ($exts != "mp4") && ($exts != "m4v") && ($exts != "mov") && ($exts != "mp4v") && ($exts != "f4v") && ($exts != "flv")) {
                    $bol_type = "video";
                    // Get error msg
                    fn_error_msg_link($task, $option, $bol_type, $bol_newedit, $idval);
                }
            }
        }

        if ($_FILES['previewurl']['name'] != "") {
            $file_type = $_FILES['previewurl']['type'];
            $file_name = $_FILES['previewurl']['name'];
            $exts = $this->findexts($file_name);
            // Get file extension
            if ($exts) {
                // To make sure preview image extensions is exists
                if (($exts != "png") && ($exts != "gif") && ($exts != "jpeg") && ($exts != "jpg")) { // To check file type
                    $bol_type = "image";
                    // Get error msg
                    fn_error_msg_link($task, $option, $bol_type, $bol_newedit, $idval);
                }
            }
        }


        if ($_FILES['thumburl']['name'] != "") {
            $file_type = $_FILES['thumburl']['type'];
            $file_name = $_FILES['thumburl']['name'];
            $exts = $this->findexts($file_name);
            // Get file extension
            if ($exts) {
                // To make sure thumb image extensions is exists
                if (($exts != 'jpeg') && ($exts != 'png') && ($exts != 'gif') && ($exts != "jpg")) { // To check file type
                    $bol_type = "image";
                    // Get error msg
                    fn_error_msg_link($task, $option, $bol_type, $bol_newedit, $idval);
                }
            }
        }
        // get file size for vides ,hd,preview images & thumb images...
        $total_size = $file_size_videos + $file_size_thumbimages + $file_size_fpreview + $file_size_fhd;

        // To make sure total size should be less than upload max size from php.ini
        if (($total_size) > (ini_get('upload_max_filesize') * 1000 * 1024)) {
            JError::raiseWarning('SOME_ERROR_CODE', JText::_('UPLOAD MAX SIZE : Max file size upload' . ini_get('upload_max_filesize')));
            switch ($task) {
                case 'applyvideos':
                    $msg = 'Not Saved';
                    $link = 'index.php?option=' . $option . '&layout=adminvideos&task=editvideos';
                    break;
                case 'savevideoupload':
                default:
                    $msg = 'Not Saved';
                    $link = 'index.php?option=' . $option . '&layout=adminvideos';
                    break;
            }
            // Page redirect
            $app->redirect($link, $msg);
            exit();
        }
    }

    function findexts($filename) {
        $filename = strtolower($filename);
        $exts = split("[/\\.]", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

    function fn_savedb_flashenable($option, $idval, $file_video, $file_timage, $file_pimage, $file_hvideo, $newupload, $filepath) {
        //echo $file_video."".$file_hvideo."".$file_timage."".$file_pimage;
        // exit();
        global $mainframe;
        $option = JRequest::getCmd('option');
        $db = & JFactory::getDBO();
        // VPATH1 defined at the top to get current path..

        $vpath = VPATH2 . "/";

        // videos
        if ($file_video <> "") {
            $exts1 = $this->findexts($file_video);
            $vpath2 = FVPATH . "/images/uploads/" . $file_video;
            $target_path1 = $vpath . $idval . "_video" . "." . $exts1;
            $fv = $idval . "_video" . "." . $exts1;
            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path1, $fv, $idval, 'videourl', $option, $newupload, $filepath);
        }
        // Thumb Images
        if ($file_timage <> "") {

            $exts2 = $this->findexts($file_timage);
            $vpath2 = FVPATH . "/images/uploads/" . $file_timage;
            $target_path2 = $vpath . $idval . "_thumb" . "." . $exts2;
            $ft = $idval . "_thumb" . "." . $exts2;
            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path2, $ft, $idval, 'thumburl', $option, $newupload, $filepath);
        } else {
            $fp = "default_thumb";
            $target_path3 = $vpath2 = "default_thumb";

            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path3, $fp, $idval, 'thumburl', $option, $newupload, $filepath);
        }
        // Preview Images
        if ($file_pimage <> "") {
            $exts3 = $this->findexts($file_pimage);
            $vpath2 = FVPATH . "/images/uploads/" . $file_pimage;
            $target_path3 = $vpath . $idval . "_preview" . "." . $exts3;
            $fp = $idval . "_preview" . "." . $exts3;
            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path3, $fp, $idval, 'previewurl', $option, $newupload, $filepath);
        } else {

            $fp = "default_thumb";
            $target_path3 = $vpath2 = "default_thumb";
            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path3, $fp, $idval, 'previewurl', $option, $newupload, $filepath);
        }
        // Hd videos
        if ($file_hvideo <> "") {
            $exts4 = $this->findexts($file_hvideo);
            $vpath2 = FVPATH . "/images/uploads/" . $file_hvideo;
            $target_path4 = $vpath . $idval . "_hd" . "." . $exts4;
            $fh = $idval . "_hd" . "." . $exts4;
            // fn to copy from localhost/administrator/components/com_hdflvplayer/imasges/uploads to localhost/components/com_hdflvplayer/videos..
            $this->copytovideos($vpath2, $target_path4, $fh, $idval, 'hdurl', $option, $newupload, $filepath);
        }
    }

    function copytovideos($vpath2, $targetpath, $vmfile, $idval, $dbname, $option, $newupload, $filepath) {
        global $mainframe;
        $option = JRequest::getCmd('option');
        $db = & JFactory::getDBO();
        if ($vpath2 <> "default_thumb") {
            $targetpath1 = $targetpath;
            // To make sure in edit mode video ,hd, thumb image or preview image file is exists..
            // if exists then remove the old one
            if ($newupload == 1) {
                if (file_exists($vpath2) && file_exists($targetpath)) {
                    unlink($targetpath);
                }
            }

            rename($vpath2, $targetpath1);
        } else {
            $vmfile = "default_thumb.jpg";
        }
        $query = "update #__hdflv_upload set streameroption='None',$dbname='$vmfile',filepath='$filepath' WHERE id = $idval ";
        $db->setQuery($query);
        $db->query();
    }

    function ezffmpeg_vdofile_infos($src_filepath, $ffmpeg_path) {
        $EZFFMPEG_BIN_PATH = $ffmpeg_path;
        $commandline = $ffmpeg_path . " -i " . $src_filepath;
        $exec_return = $this->ezffmpeg_exec($commandline);
        $exec_return_content = explode("\n", $exec_return);
        if ($infos_line_id = $this->ezffmpeg_array_search('Video:', $exec_return_content)) {
            $infos_line = trim($exec_return_content[$infos_line_id]);
            $infos_cleaning = explode(': ', $infos_line);
            $infos_datas = explode(',', $infos_cleaning[2]);
            $return_array['vdo_format'] = trim($infos_datas[0]);
        }
        return($return_array);
    }

    function ezffmpeg_array_search($needle, $array_lines) {
        $return_val = false;
        reset($array_lines);
        foreach ($array_lines as $num_line => $line_content) {
            if (strpos($line_content, $needle) !== false) {
                return($num_line);
            }
        }
        return($return_val);
    }

    function ezffmpeg_exec($commandline) {
        $read = '';
        $handle = popen($commandline . ' 2>&1', 'r');
        while (!feof($handle)) {
            $read .= fread($handle, 2096);
        }
        pclose($handle);
        return($read);
    }

    function featuredvideo($arrayIDs) {
        if ($arrayIDs['task'] == "featured") {
            $publish = 1;
        } else {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__hdflv_upload set featured=" . $publish . " WHERE id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }

    function getcomment() {
        global $option, $mainframe;
        $filter_order = $app->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'Id', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
        $search = $app->getUserStateFromRequest($option . 'search', 'search', '', 'string');
        $limit = $app->getUserStateFromRequest($option . '.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $limitstart = $app->getUserStateFromRequest($option . 'limitstart', 'limitstart', 0, 'int');

        $db = $this->getDBO();
        if (JRequest::getVar('cmtid', '', 'get', 'int')) {
            $query = "delete from #__hdflv_comments where id=" . JRequest::getVar('cmtid', '', 'get', 'int') . " or parentid=" . JRequest::getVar('cmtid', '', 'get', 'int');
            $db->setQuery($query);
            $db->query();
        }
        $id = JRequest::getVar('id', '', 'get', 'int');
        $query = "select a.*,b.* from #__hdflv_upload a inner join #__hdflv_comments b on a.id=b.videoid where a.id=$id";
        $db->setQuery($query);
        $commenttotal = $db->loadObjectList();
        $total = count($commenttotal);
        if ($total == 0) {
            $url = $baseurl . "index.php?option=com_contushdvideoshare&layout=adminvideos";
            header("Location: $url");
        }
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);

        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;
        $lists['search'] = $search;
        $limitstart = 0;
        $id = JRequest::getVar('id', '', 'get', 'int');
        $query = "select a.*,b.* from #__hdflv_upload a inner join #__hdflv_comments b on a.id=b.videoid where a.id=$id  LIMIT $limitstart,$limit";
        $db->setQuery($query);
        $comment = $db->loadObjectList();
        $comment = array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'comment' => $comment);
        return $comment;
    }

}

?>
