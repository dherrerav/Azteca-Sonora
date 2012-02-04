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

class contushdvideoshareModeleditvideos extends JModel {
    
	function editvideosmodel()
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id,category FROM #__hdflv_category where published=1 order by id desc";
        $db->setQuery( $query);
        $rs_play = $db->loadObjectList();

        $query = "SELECT id,adsname FROM #__hdflv_ads where published=1 and typeofadd <> 'mid' order by adsname asc";
        $db->setQuery( $query);
        $rs_ads = $db->loadObjectList();

        $rs_editupload =& JTable::getInstance('adminvideos', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        // To get the id no to be edited...
        $id = $cid[0];
        $rs_editupload->load($id);
        $lists['published'] = JHTML::_('select.booleanlist','published',$rs_editupload->published);
        // To call html function class name: HTML_player function name:editUpload
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
        $editadd = array('rs_editupload' => $rs_editupload,'rs_play'=>$rs_play,'rs_ads'=>$rs_ads,'user_groups'=>$usergroups);
        return $editadd;

	}
    function removevideos()
    {
        $option = 'com_contushdvideoshare';
            global $mainframe;
            $cid = JRequest::getVar( 'cid', array(), '', 'array' );
            $db =& JFactory::getDBO();
            $cids = implode( ',', $cid );
			
            $qry="Select videos,videourl,thumburl,previewurl,hdurl from #__hdflvplayerupload where id IN ( $cids )";
            $db->setQuery( $qry );
            $rs_removeupload = $db->loadObjectList();
            $vpath=VPATH1."/";
            if(count(  $rs_removeupload ))
            {
                for ($i=0; $i < count($rs_removeupload); $i++)
                {
                    if($rs_removeupload[$i]->videos)
                    unlink($vpath.$rs_removeupload[$i]->videos);
                    if($rs_removeupload[$i]->videourl)
                    unlink($vpath.$rs_removeupload[$i]->videourl);
                    if($rs_removeupload[$i]->thumburl)
                    unlink($vpath.$rs_removeupload[$i]->thumburl);
                    if($rs_removeupload[$i]->previewurl)
                    unlink($vpath.$rs_removeupload[$i]->previewurl);
                    if($rs_removeupload[$i]->hdurl)
                    unlink($vpath.$rs_removeupload[$i]->hdurl);
                }
            }
            // Get count
            if(count($cid))
            {
                $cids = implode( ',', $cid );
                $query = "DELETE FROM #__hdflv_upload WHERE id IN ( $cids )";
                $db->setQuery( $query );
                if (!$db->query())
                {
                    echo "<script> alert('".$db->getErrorMsg()."');window.history.go(-1); </script>\n";
                }
				else
				{
				 $query = "DELETE FROM #__hdflv_video_category WHERE vid IN ( $cids )";
                 $db->setQuery( $query );
				}
            }
            // page redirect
            $mainframe = & JFactory::getApplication();
            $msg = JText::_('Video file Deleted');
            $mainframe->redirect( 'index.php?option=' . $option.'&layout=adminvideos'.'&userid='.JRequest::getVar('userid'),$msg);
    }




}
?>
