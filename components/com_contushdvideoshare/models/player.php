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

class Modelcontushdvideoshareplayer extends JModel {

    function getVideoId($video) {

        $db = & JFactory::getDBO();
        $video = $db->getEscaped($video);
        $query = 'select id,playlistid,videourl from #__hdflv_upload where seotitle="' . $video . '"';
        $db->setQuery($query);
        $videodetails = $db->loadObject();
        return $videodetails;
    }

    function getfeatured() {

        $db = & JFactory::getDBO();
        $query = 'select id from #__hdflv_upload where published="1" and featured="1" and type="0" order by ordering asc';
        $db->setQuery($query);
        $feavideo = $db->loadObject();
        return $feavideo;
    }

    function getVideodetail($video) {

        $db = & JFactory::getDBO();
        $video = $db->getEscaped($video);
        $query = 'select id,playlistid,videourl from #__hdflv_upload where id="' . $video . '"';
        $db->setQuery($query);
        $videodetails = $db->loadObject();
        return $videodetails;
    }

    function showhdplayer($videoid, $categoryid) {

        global $mainframe;
        $playid = 0;
        $thumbid = 0;
        $db = & JFactory::getDBO();
        $user =& JFactory::getUser();

        $query = "select * from #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows = $db->loadObjectList();
        if ($videoid)
        $playid = $videoid;
        $query_all_count = "select * from #__hdflv_upload  where published='1'  order by id desc ";
        $db->setQuery($query_all_count);
        $rs_count = $db->loadObjectList();
        $length = 1;
        $start = 0;
        if ($rs_count > 0)
            $total = count($rs_count);
        else
            $total=0;
        $pageno = 1;
        if (JRequest::getVar('page', '', 'post', 'string')) {
            $pageno = JRequest::getVar('page', '', 'post', 'string');
            $_SESSION['commentappendpageno'] = $pageno;
        }
        if ($settingsrows[0]->nrelated != "")
            $length = $settingsrows[0]->nrelated;
        else
            $length=4;

        if ($length == 0)
            $length = 1;
        $pages = ceil($total / $length);
        if ($pageno == 1)
            $start = 0;
        else
            $start= ( $pageno - 1) * $length;
        $query1 = "select * from #__hdflv_upload where published='1'";
        $db->setQuery($query1);
        $rs_home = $db->loadObjectList();
        $home_bol = "false";
        $current_path = "components/com_contushdvideoshare/images/";
        $query = "select * from #__hdflv_upload where published='1'";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $hdvideo = false;
        if (isset($rows[0]->id))
            $thumbid = $rows[0]->id;
        $hd_bol = "false";
        if (count($rows) > 0) {
            if ($rows[0]->filepath == "File" || $rows[0]->filepath == "FFmpeg") {
                $video = JURI::base() . $current_path . $rows[0]->videourl;
                ($rows[0]->hdurl != "") ? $hdvideo = JURI::base() . $current_path . $rows[0]->hdurl : $hdvideo = "";
                $previewimage = JURI::base() . $current_path . $rows[0]->previewurl;
                if ($rows[0]->hdurl)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
            }
            elseif ($rows[0]->filepath == "Url") {
                $video = $rows[0]->videourl;
                $previewimage = $rows[0]->previewurl;
                if ($rows[0]->hdurl)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
                $hdvideo = $rows[0]->hdurl;
            }
            elseif ($rows[0]->filepath == "Youtube") {
                $video = $rows[0]->videourl;
                $previewimage = $rows[0]->previewurl;
                if ($rows[0]->hdurl)
                    $hd_bol = "true";
                else
                    $hd_bol="false";
                $hdvideo = $rows[0]->videourl;
            }
            $query = "select count(*) from #__hdflv_site_settings where viewedconrtol='1'";
            $db->setQuery($query);
            $nocache = JRequest::getInt('nocache','1','GET');

            $boolval = $db->loadResult();
            if ($videoid) {
                if ($nocache!=1) {
                    $query = "update #__hdflv_upload SET times_viewed=1+times_viewed where id=$playid";
                    $db->setQuery($query);
                    $db->query();
                }
            }
            $playid = $rows[0]->id;
        }
        $query = "select * from #__hdflv_upload  where published='1' and id not in ($playid)  order by ordering asc LIMIT $start,$length ";
        $db->setQuery($query);
        $rs_playlist = $db->loadobjectList();
        $playerpath = JURI::base() . 'components/com_contushdvideoshare/hdflvplayer/hdplayer.swf';
        $baseurl = str_replace(':', '%3A', JURI::base());
        $baseurl = substr_replace($baseurl, "", -1);
        $baseurl = str_replace('/', '%2F', $baseurl);
        $emailpath = JURI::base() . "/index.php?option=com_contushdvideoshare&view=email";
        $youtubeurl = JURI::base() . "/index.php?option=com_contushdvideoshare&view=youtubeurl&url=";
        $logopath = JURI::base() . "/components/com_contushdvideoshare/videos/" . $settingsrows[0]->logopath;
        $playlistXML = '';
        $playlist = "false";
        if ($settingsrows[0]->related_videos == "1" || $settingsrows[0]->related_videos == "3") {
            $playlistXML = JURI::base() . "index.php?option=com_contushdvideoshare&view=xml";

            $playlist = "true";
        }
        $query1 = "select * from #__hdflv_googlead where publish='1' and id='1'";
        $db->setQuery($query1);
        $fields = $db->loadObjectList();
        if (isset($fields[0]->publish))
            $insert_data_array = array('playerpath' => $playerpath, 'baseurl' => $baseurl, 'thumbid' => $thumbid, 'rs_playlist' => $rs_playlist, 'length' => $length, 'total' => $total, 'closeadd' => $fields[0]->closeadd, 'reopenadd' => $fields[0]->reopenadd, 'ropen' => $fields[0]->ropen, 'publish' => $fields[0]->publish, 'showaddc' => $fields[0]->showaddc);
        else
        $insert_data_array = array('playerpath' => $playerpath, 'baseurl' => $baseurl, 'thumbid' => $thumbid, 'rs_playlist' => $rs_playlist, 'length' => $length, 'total' => $total);
        $settingsrows = array_merge($settingsrows, $insert_data_array);
        return $settingsrows;
    }

    function ratting($videoid, $categoryid) {
        $db = $this->getDBO();
        if ($videoid)
            $id = $videoid;
        else {
            $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.featured='1' and a.type='0' group by e.vid order by a.ordering asc"; // Query is to display recent videos in home page
            $db->setQuery($query);
            $rs_video = $db->loadObjectList();
            $id = $rs_video[0]->id;
        }
        if (JRequest::getVar('rate', '', 'get', 'int')) {
            echo $query = "update #__hdflv_upload SET rate=" . JRequest::getVar('rate', '', 'get', 'int') . "+rate,ratecount=1+ratecount where id=$id";
            $db->setQuery($query);
            $db->query();
            exit;
        }
        if ($id != '') {
            /* Get Views counting */
            $titlequery = "select a.times_viewed,a.rate,a.ratecount,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
            $db->setQuery($titlequery);
            $commenttitle = $db->loadObjectList();
            //print_r($commenttitle);
            return $commenttitle;
        }
    }

    function displaycomments($videoid, $categoryid) {
        $user = & JFactory::getUser();

        if ($videoid) {
            $commenttitle = array();
            $db = $this->getDBO();
            $id = $videoid;
            if (JRequest::getVar('name', '', 'get', 'string') && JRequest::getVar('message', '', 'get', 'string')) {
                $parentid = JRequest::getVar('pid', '', 'get', 'int'); //Getting the parent id value
                $name = JRequest::getVar('name', '', 'get', 'string'); // Getting the name who is posting the comments
                $message = JRequest::getVar('message', '', 'get', 'string'); // Getting the message
                $db = & JFactory::getDBO();
                $name = $db->getEscaped($name);
                $message = $db->getEscaped($message);
                $commentquery = "insert into #__hdflv_comments(parentid,videoid,name,message,published) values ('$parentid','$id','$name','$message','1')"; // This insert query is to post a new comment for a particular video
                $db->setQuery($commentquery);
                $db->query();
            }
            /* Following code is to display the title and times of views for a particular video */
            $titlequery = "select a.title,a.description,a.times_viewed,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
            $db->setQuery($titlequery);
            $commenttitle = $db->loadObjectList();
            /* Title query for video ends here */
            $commenttotalquery = "select count(*) from #__hdflv_comments where published=1 and videoid=$id"; // Query is to get the pagination value for comments display
            $db->setQuery($commenttotalquery);
            $total = $db->loadResult();
            $pageno = 1;
            if (JRequest::getVar('page', '', 'post', 'int')) {
                $pageno = JRequest::getVar('page', '', 'post', 'int');
            }
            $length = 10;
            $pages = ceil($total / $length);
            if ($pageno == 1)
                $start = 0;
            else
                $start= ( $pageno - 1) * $length;
            $commentscount = "SELECT id as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid = 0 and published=1 and videoid=$id union select parentid as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid !=0 and published=1 and videoid=$id order by number desc,parentid "; // Query is to display the comments posted for particular video
            $db->setQuery($commentscount);
            $rowscount = $db->loadObjectList();
            $totalcomment = count($rowscount);
            $comments = "SELECT id as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid = 0 and published=1 and videoid=$id union select parentid as number,id,parentid,videoid,subject,name,created,message from #__hdflv_comments where parentid !=0 and published=1 and videoid=$id order by number desc,parentid LIMIT $start,$length"; // Query is to display the comments posted for particular video
            $db->setQuery($comments);
            $rows = $db->loadObjectList();
            // Below code is to merge the pagination values like pageno,pages,start value,length value
            $insert_data_array = array('pageno' => $pageno);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('pages' => $pages);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('start' => $start);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('length' => $length);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('totalcomment' => $totalcomment);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            // merge code ends here
            return array($commenttitle, $rows);
        }
    }
    function gethomepagebottom() {
        $db = $this->getDBO();
        $user =& JFactory::getUser();

        $viewrow = $this->gethomepagebottomsettings();
        $featurelimit = $viewrow[0]->homefeaturedvideorow * $viewrow[0]->homefeaturedvideocol;
        $featuredquery = "select a.*,b.category,b.seo_category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.featured='1' and a.type='0'  group by e.vid order by rand() limit 0,$featurelimit "; // Query is to display featured videos in home page randomly
        $db->setQuery($featuredquery);
        $featuredvideos = $db->loadobjectList(); // $featuredvideos contains the results
        $recentlimit = $viewrow[0]->homerecentvideorow * $viewrow[0]->homerecentvideocol;
        $recentquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0'  group by e.vid order by a.id desc limit 0,$recentlimit "; // Query is to display recent videos in home page
        $db->setQuery($recentquery);
        $recentvideos = $db->loadobjectList(); //$recentvideos contains the results
        $popularlimit = $viewrow[0]->homepopularvideorow * $viewrow[0]->homepopularvideocol;
        $popularquery = "select a.*,b.category,b.seo_category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0'  group by e.vid order by a.times_viewed desc limit 0,$popularlimit"; //Query is to display popular videos in home page

        $db->setQuery($popularquery);
        $popularvideos = $db->loadobjectList(); //$popularvideos contains the results
        return array($featuredvideos, $recentvideos, $popularvideos); // Merging the featured,recent,popular videos results
    }
    /* Function ends here */
    function gethomepagebottomsettings() {
        $db = $this->getDBO();
        $homepagebottomsettings = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($homepagebottomsettings);
        $rows = $db->LoadObjectList();
        return $rows;
    }
    function getHTMLVideoDetails($videoId) {
        if (isset($videoId) && $videoId != '') {
            $condition = 'id=' . $videoId;
        } else {
            $condition = 'featured=1 order by id asc limit 1';
        }
        $db = $this->getDBO();
        $query = "select * from #__hdflv_upload where " . $condition; //Query is to select the popular videos row
        $db->setQuery($query);
        $rows = $db->LoadObject();
        return $rows;
    }

    function getHTMLVideoAccessLevel(){
        global $mainframe;
        $db = & JFactory::getDBO();
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
        $videoid = 0;

        if (JRequest::getvar('id', '', 'get', 'int')) {
            $videoid = JRequest::getvar('id', '', 'get', 'int');
            if ($videoid != "") {
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and a.id=$videoid ";
                $db->setQuery($query);
                $rowsVal = $db->loadAssoc();
            }
        } else if (JRequest::getvar('video')) {
            $videoName = JRequest::getvar('video');
            $videoName = str_replace(":", "-", $videoName);
            if ($videoName != "") {
                $videoName = $db->getEscaped($videoName);
                $query = "select distinct a.*,b.category from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id where a.published='1' and a.seotitle='$videoName'";
                $db->setQuery($query);
                $rowsVal = $db->loadAssoc();
            }
        } else {
            $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.featured='1' and a.type='0' group by e.vid order by a.ordering asc"; // Query is to display recent videos in home page
            $db->setQuery($query);
            $rowsVal = $db->loadAssoc();
            if (count($rowsVal) == 0) {
                $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' group by e.vid order by a.ordering asc limit 0,1"; // Query is to display recent videos in home page
                $db->setQuery($query);
                $rowsVal = $db->loadAssoc();
            }
        }
        if (count($rowsVal) > 0) {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $db = &JFactory::getDBO();
                $query = $db->getQuery(true);
                if($rowsVal['useraccess'] == 0){ $rowsVal['useraccess'] = 1;}
                $query->select('rules as rule')
                        ->from('#__viewlevels AS view')
                        ->where('id = ' . (int) $rowsVal['useraccess']);
                $db->setQuery($query);
                $message = $db->loadResult();
                $accessLevel = json_decode($message);
            }
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
                if ($rowsVal['useraccess'] != 0) {
                    if ($accessid != $rowsVal['useraccess'] && $accessid != 2) {
                        $member = "false";
                    }
                }
            }
            return $member;
        }
    }

}