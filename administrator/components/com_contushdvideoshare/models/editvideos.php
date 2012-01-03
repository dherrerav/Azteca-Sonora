<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        editvideos.php
 * @location    /components/com_contushdvideosahre/models/editvideos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    edit videos Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModeleditvideos extends JModel {

    function editvideosmodel() {
        $db = & JFactory::getDBO();
        $query = "SELECT id,category FROM #__hdflv_category where published=1 order by id desc";
        $db->setQuery($query);
        $rs_play = $db->loadObjectList();
        $query = "SELECT id,adsname FROM #__hdflv_ads where published=1 and typeofadd!='mid' order by adsname asc";
        $db->setQuery($query);
        $rs_ads = $db->loadObjectList();
        $rs_editupload = & JTable::getInstance('adminvideos', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        // To get the id no to be edited...
        $id = $cid[0];
        $rs_editupload->load($id);
        $lists['published'] = JHTML::_('select.booleanlist', 'published', $rs_editupload->published);
        // To call html function class name: HTML_player function name:editUpload
        $editadd = array('rs_editupload' => $rs_editupload, 'rs_play' => $rs_play, 'rs_ads' => $rs_ads);
        return $editadd;
    }

    function removevideos() {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $db = & JFactory::getDBO();
        $cids = implode(',', $cid);
        $qry = "Select videos,videourl,thumburl,previewurl,hdurl from #__hdflvplayerupload where id IN ( $cids )";
        $db->setQuery($qry);
        $rs_removeupload = $db->loadObjectList();
        $vpath = VPATH1 . "/";
        if (count($rs_removeupload)) {
            for ($i = 0; $i < count($rs_removeupload); $i++) {
                if ($rs_removeupload[$i]->videos)
                    unlink($vpath . $rs_removeupload[$i]->videos);
                if ($rs_removeupload[$i]->videourl)
                    unlink($vpath . $rs_removeupload[$i]->videourl);
                if ($rs_removeupload[$i]->thumburl)
                    unlink($vpath . $rs_removeupload[$i]->thumburl);
                if ($rs_removeupload[$i]->previewurl)
                    unlink($vpath . $rs_removeupload[$i]->previewurl);
                if ($rs_removeupload[$i]->hdurl)
                    unlink($vpath . $rs_removeupload[$i]->hdurl);
            }
        }
        // Get count
        if (count($cid)) {
            $cids = implode(',', $cid);
            $query = "DELETE FROM #__hdflv_upload WHERE id IN ( $cids )";
            $db->setQuery($query);
            if (!$db->query()) {
                echo "<script> alert('" . $db->getErrorMsg() . "');window.history.go(-1); </script>\n";
            } else {
                $query = "DELETE FROM #__hdflv_video_category WHERE vid IN ( $cids )";
                $db->setQuery($query);
            }
        }
        // page redirect
        $app = & JFactory::getApplication();
        $app->redirect('index.php?option=' . $option . '&layout=adminvideos' . '&actype=' . JRequest::getVar('actype'));
    }

}

?>
