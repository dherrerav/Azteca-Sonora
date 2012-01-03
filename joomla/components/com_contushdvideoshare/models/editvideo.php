<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        editvideo.php
 * @location    /components/com_contushdvideosahre/models/editvideo.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :uploading videos, editing videos
 */
// No Direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Modelhdvideoshareeditvideo extends JModel {
    /* Following function is to save a particular video which is being edited */

    function geteditdetails() {
        $user = & JFactory::getUser();
        $session = & JFactory::getSession();
        $success = "";
        if (isset($_POST['editbtn'])) {
            if ($user->get('id')) {

                $memberid = $user->get('id'); // Getting the memberid
            }
            if (JRequest::getVar('id', '', 'get', 'int')) {
                $videoid = JRequest::getVar('id', '', 'get', 'int'); //Getting the video id
            }
            $title = JRequest::getVar('title', '', 'post', 'string');
            $description = JRequest::getVar('descr', '', 'post', 'string');
            $type = JRequest::getVar('type', '', 'post', 'string');
            $db = & JFactory::getDBO();
            $query = "update #__hdflv_upload set title='$title',description='$description',type='$type' where id='$videoid' and memberid='$memberid'"; //Query is to update a particular video details
            $db->setQuery($query);
            $db->query();
            $success = "Your video Details Updated Successfully";
            $url = JRoute::_("index.php?option=com_hdvideoshare&view=myvideos");
            header("Location: $url");
        }

        // Following code is to get a particulat video for edit
        if (JRequest::getVar('id', '', 'get', 'int')) {
            $videoid = JRequest::getVar('id', '', 'get', 'int'); // Getting the video id of a particular video
        }
        $db = $this->getDBO();
        $query = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and a.id=$videoid group by e.vid"; // Query to get a particular video for edit action
        $db->setQuery($query);
        $rows = $db->LoadObjectList();
        $memberid = "";
        $user = & JFactory::getUser();
        if ($user->get('id')) {
            $memberid = $user->get('id'); //Setting the loginid into session
        }
        if ($memberid != "")
            $myvideorowcolquery = "select allowupload  from #__hdflv_user  where member_id=" . $memberid;
        else
            $myvideorowcolquery="select allowupload  from #__hdflv_site_settings";
        $db = $this->getDBO();
        $db->setQuery($myvideorowcolquery);
        $row = $db->LoadObjectList();
        if (count($row) == 0) {
            $myvideorowcolquery = "select allowupload  from #__hdflv_site_settings";
            $db = $this->getDBO();
            $db->setQuery($myvideorowcolquery);
            $row = $db->LoadObjectList();
            $query = " insert into #__hdflv_user (member_id,allowupload) values ('$memberid','$row[0]->allowupload')";
            $db->setQuery($query);
            $db->query();
        }
        $rows = array_merge($rows, $row);
        return array($rows, $success);
    }

}

?>