<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModeladdvideos extends JModel {

    function addvideosmodel()
    {
        $db = & JFactory::getDBO();
        // query to get ffmpegpath & file max upload size from #__hdflv_player_settings
        $query = "select ffmpeg, uploadmaxsize from #__hdflv_player_settings";
        $db->setQuery($query);
        $rs_playersettings = $db->loadObjectList();
        //to get total no.of records
        if (count($rs_playersettings) > 0)
         {
            // To set max file size in php.ini
            ini_set('upload_max_filesize', $rs_playersettings[0]->uploadmaxsize . "M"); // to assign value to the php.ini file
            // To set max execution_time in php.ini
            ini_set('max_execution_time', 3600); // max execution time 5 Min
            ini_set('max_input_time', 3600);
            $ffmpeg_val = $rs_playersettings[0]->ffmpeg; // To get ffmpeg val like enabled or disabled
            $upload_maxsize = $rs_playersettings[0]->uploadmaxsize;
        }
        global $mainframe;
        $db = & JFactory::getDBO();
        $rs_editupload = & JTable::getInstance('adminvideos', 'Table');
        // To call html function class name: HTML_player function name:newUpload
        $query = "select * from  #__hdflv_category where published=1 order by category asc";
        $db->setQuery($query);
        $rs_play = $db->loadObjectList();
        $allow_status = 0;
        $per_video = 0;
        $per_upload = 0;
        $allow_fileuploads = 0;
        $allow_youtube = 0;
        if (ini_get('allow_url_fopen') == 1)
            $allow_status = 1;
        if (ini_get('file_uploads') == 1)
            $allow_fileuploads = 1;
        $videopathw = VPATH1 . "/";
        $uploadpathw = FVPATH . "/images/uploads/";
        if (is_writable("$videopathw"))
            $per_video = 1;
        if (is_writable("$uploadpathw"))
            $per_upload = 1;
        $query = "SELECT id,adsname FROM #__hdflv_ads where published=1 and typeofadd!='mid' order by adsname asc";
        $db->setQuery($query);
        $rs_ads = $db->loadObjectList();
        $query = "SELECT id,adsname FROM #__hdflv_ads where published=1 and typeofadd ='mid' order by adsname asc";
        $db->setQuery($query);
        $rs_midads = $db->loadObjectList();
         if(version_compare(JVERSION,'1.6.0','ge'))
        {
       $query = "SELECT id as id ,title as title FROM #__viewlevels order by id asc";
//          $query->select('g.id AS group_id')
//                ->from('#__usergroups AS g')
//                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id');
        }
        else
        {
     $query = "SELECT id as id ,name as title FROM #__groups order by id asc";
  //echo    $query = "select g.id AS group_id from #__usergroups AS g leftjoin #__user_usergroup_map AS map ON map.group_id = g.id ";
        }
       $db->setQuery($query);
        $usergroups = $db->loadObjectList();
        
        $add = array('upload_maxsize' => $upload_maxsize, 'rs_play' => $rs_play, 'per_upload' => $per_upload, 'per_upload' => $per_upload, 'allow_status' => $allow_status, 'rs_editupload' => $rs_editupload, 'rs_ads' => $rs_ads, 'rs_midads' => $rs_midads,'user_groups' => $usergroups);
        return $add;
    }

}

?>
