<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        player.php
 * @location    /components/com_contushdvideosahre/models/player.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   showing player, comments updation, ratting updation model page
 */

// No Direct access
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class Modelcontushdvideoshareplayer extends JModel {

    function showhdplayer() {
        global $mainframe;
        $playid = 0;
        $thumbid = 0;
        $db = & JFactory::getDBO();
        $query = "select * from #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows = $db->loadObjectList();
        if (JRequest::getVar('id', '', 'get', 'int'))
            $playid = JRequest::getVar('id', '', 'get', 'int');
        $query_all_count = "select * from #__hdflv_upload  where published='1' order by id desc ";
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
            if (JRequest::getVar('catid', '', 'get', 'int')) {

                $query = "update #__hdflv_upload SET times_viewed=1+times_viewed where id=$playid";
                $db->setQuery($query);
                $db->query();
            }
            $playid = $rows[0]->id;
        }
        $query = "select * from #__hdflv_upload  where published='1' and id not in ($playid) order by ordering asc LIMIT $start,$length ";
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

    function ratting() {
        $db = $this->getDBO();
        if (JRequest::getVar('id', '', 'get', 'int'))
            $id = JRequest::getVar('id', '', 'get', 'int');
        if (JRequest::getVar('rate', '', 'get', 'int')) {
            echo $query = "update #__hdflv_upload SET rate=" . JRequest::getVar('rate', '', 'get', 'int') . "+rate,ratecount=1+ratecount where id=$id";
            $db->setQuery($query);
            $db->query();
            exit;
        }

        if (JRequest::getVar('id', '', 'get', 'int')) {
            /* Get Views counting */
            $titlequery = "select a.times_viewed,a.rate,a.ratecount,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
            $db->setQuery($titlequery);
            $commenttitle = $db->loadObjectList();
            return $commenttitle;
        }
    }

    function displaycomments() {
        if (JRequest::getVar('id', '', 'get', 'int')) {
            $commenttitle = array();
            $db = $this->getDBO();
            $id = JRequest::getVar('id', '', 'get', 'int');
            if (JRequest::getVar('name', '', 'get', 'string') && JRequest::getVar('message', '', 'get', 'string')) {
                $parentid = JRequest::getVar('pid', '', 'get', 'int'); //Getting the parent id value
                $name = JRequest::getVar('name', '', 'get', 'string'); // Getting the name who is posting the comments
                $message = JRequest::getVar('message', '', 'get', 'string'); // Getting the message
                $db = & JFactory::getDBO();
                $commentquery = "insert into #__hdflv_comments(parentid,videoid,name,message,published) values ('$parentid','$id','$name','$message','1')"; // This insert query is to post a new comment for a particular video
                $db->setQuery($commentquery);
                $db->query();
            }
            /* Following code is to display the title and times of views for a particular video */
            $titlequery = "select a.title,a.times_viewed,a.memberid,b.username from #__hdflv_upload a left join #__users b on a.memberid=b.id where a.id=$id"; //This query is to display the title and times of views in the video page
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
        $viewrow = $this->gethomepagebottomsettings();
        $featurelimit = $viewrow[0]->homefeaturedvideorow * $viewrow[0]->homefeaturedvideocol;
        $featuredquery = "select a.*,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.featured='1' and a.type='0' and b.published=1 group by e.vid order by rand() limit 0,$featurelimit"; // Query is to display featured videos in home page randomly
        $db->setQuery($featuredquery);
        $featuredvideos = $db->loadobjectList(); // $featuredvideos contains the results
        $recentlimit = $viewrow[0]->homerecentvideorow * $viewrow[0]->homerecentvideocol;
        $recentquery = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and b.published=1 group by e.vid order by a.id desc limit 0,$recentlimit "; // Query is to display recent videos in home page
        $db->setQuery($recentquery);
        $recentvideos = $db->loadobjectList(); //$recentvideos contains the results
        $popularlimit = $viewrow[0]->homepopularvideorow * $viewrow[0]->homepopularvideocol;
        $popularquery = "select a.*,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and b.published=1 group by e.vid order by a.times_viewed desc limit 0,$popularlimit"; //Query is to display popular videos in home page
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

}