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

class contushdvideoshareModelshowads extends JModel {

      function __construct() {
            global $mainframe;
        parent::__construct();
        $mainframe = JFactory::getApplication();
        $config = JFactory::getConfig();
       // $this->setState('limit', $mainframe->getUserStateFromRequest('ads.limit', 'limit', $config->get('list_limit'), 'int'));
        //$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
    }


    function showadsmodel()
    {
        global $mainframe;
        $db =& JFactory::getDBO();

        $query = "SELECT * FROM #__hdflv_ads";
        $db->setQuery( $query);
        $rs_showads = $db->loadObjectList();
        return $rs_showads;

    }


    function saveads($task)
    {
        global $option,$mainframe;
        $db =& JFactory::getDBO();

        $rs_save =& JTable::getInstance('contushdvideoshareads', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $rs_save->load($id);

        if (!$rs_save->bind(JRequest::get('post')))
        {
            echo "<script> alert('".$rs_save->getError()."');window.history.go(-1); </script>\n";
            exit();
        }

        $fileoption=$_POST['fileoption'];
        $vpath=VPATH2."/";

        if (!$rs_save->store()) {
            echo "<script> alert('".$rs_save->getError()."'); window.history.go(-1); </script>\n";
            exit();
        }
        $rs_save->checkin();
        $idval=$rs_save->id;
       

        if($fileoption=="Url")
        {
            $postvideopath=$_POST['posturl-value'];
            $query="update #__hdflv_ads SET filepath='$fileoption',postvideopath='$postvideopath' where id=$rs_save->id";
            $db->setQuery($query );
            $db->query();
        }
        
        if($fileoption=="File" || $fileoption=="")   // Checked for file option
        {$target_path ='';
            $normal_video=$_POST['normalvideoform-value'];
            $video_name=explode("uploads/", $normal_video);
            $vpath=VPATH2."/";
            $file_video = '';
            if(isset($video_name[1])) {
            $file_video=$video_name[1];
            }
            if($file_video<>"")
            {
                $exts1=$this->findexts($file_video);
                $vpath2=FVPATH."/images/uploads/".$file_video;
               // $vpath2=FVPATH."/images/uploads/".$file_video."<br>";
                $target_path1=$vpath.$idval."_ads".".".$exts1;
                $file_name=$idval."_ads".".".$exts1;
                 if (file_exists($target_path))
                {
                    unlink($target_path);
                }
                rename($vpath2, $target_path1);
                $fileoption="File";
                $query = "update #__hdflv_ads set postvideopath='$file_name',filepath='$fileoption' WHERE id = $idval ";
                $db->setQuery( $query );
                $db->query();
            }

        }
         $option = 'com_contushdvideoshare';
        switch ($task)
        {
            case 'applyads':
                $msg = 'Changes Saved';
                $link = 'index.php?option=' . $option .'&layout=ads&task=editads&cid[]='. $rs_save->id;
                break;
            case 'saveads':
                default:
                    $msg = 'Saved';
                    $link = 'index.php?option=' . $option.'&layout=ads';
                    break;
        }
        $mainframe->redirect($link, 'Saved');

    }
    function copytovideos($vpath2,$targetpath,$vmfile,$idval,$dbname,$option,$newupload,$filepath)
    {
        global $mainframe;
        $option = JRequest::getCmd('option');
         $option = 'com_contushdvideoshare';
        $db =& JFactory::getDBO();
        $targetpath1=$targetpath;
        if($newupload==1)
        {
            if (file_exists($targetpath))
            {
                unlink($targetpath);
            }
        }
        rename($vpath2, $targetpath1);
        $query = "update #__hdflv_ads set $dbname='$vmfile',filepath='$filepath' WHERE id = $idval ";
        $db->setQuery( $query );
        $db->query();
    }
    function findexts ($filename)
    {
        $filename = strtolower($filename) ;
        $exts = split("[/\\.]", $filename) ;
        $n = count($exts)-1;
        $exts = $exts[$n];
        return $exts;
    }
     function pubads($task) {

        $tblname = "";
        $taskname = "";
        $option = 'com_contushdvideoshare';
        global $mainframe;
        $n = count($task['cid']);
        $taskname = JRequest::getvar('task', '', 'get', 'var');
        if ($task['task'] == 'publish') {
            $publish = 1;
            $msg = 'Published successfully';
        } else {
            $publish = 0;
            $msg = 'Un Published successfully';
        }
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__hdflv_ads set published=" . $publish . " WHERE id=" . $task['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
        $link = 'index.php?option=com_contushdvideoshare&layout=ads';
        JFactory::getApplication()->redirect($link, $msg);
    }
}
?>
