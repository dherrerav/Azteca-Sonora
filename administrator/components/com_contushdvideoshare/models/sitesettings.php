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

class contushdvideoshareModelsitesettings extends JModel
{

    function getsitesettings()
    {
        $db = $this->getDBO();
        $db->setQuery('SELECT * from #__hdflv_site_settings');
        $settings = $db->loadObjectList();
        if ($settings === null)
            JError::raiseError(500, 'Error reading db');
        return $settings;
    }

    function getsitesetting($id)
    {
        $jcomment = $jomcomment = 0;
        $query = ' SELECT * FROM #__hdflv_site_settings WHERE id = 1';
        $db = $this->getDBO();
        $db->setQuery($query);
        $settings = $db->loadObject();
       
        $query1 = " SELECT * FROM  #__components where `option`='com_jomcomment' and enabled =1";
        $db->setQuery($query1);
        $jomcommentquery = $db->loadObject();
        $jomcomment = count($jomcommentquery);
        $query1 = " SELECT * FROM  #__components where `option`='com_jcomments' and enabled =1";
        $db->setQuery($query1);
        $jcommentquery = $db->loadObject();
        $jcomment = count($jcommentquery);
        if ($settings === null)
            JError::raiseError(500, 'detail with ID: ' . $id . ' not found.');
        else
            return array($settings, $jomcomment, $jcomment);
    }

    function savesitesettings($detail)
    {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        $db = & JFactory::getDBO();
        //$showsitesettings =& JTable::getInstance('contushdvideoshare', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = $cid[0];

        $detailTableRow = & $this->getTable('sitesettings');
        if (!$detailTableRow->bind($detail))
        {
            JError::raiseError(500, 'Error binding data');
        }

        if (!$detailTableRow->check())
        {
            JError::raiseError(500, 'Invalid data');
        }

        if (!$detailTableRow->store())
        {
            $errorMessage = $detailTableRow->getError();
            JError::raiseError(500, 'Error binding data: ' . $errorMessage);
        }
        $savepagesettings = " featurrow=" . $detail["featurrow"] . ", featurcol=" . $detail["featurcol"] . ", recentrow=" . $detail["recentrow"] . ", recentcol=" . $detail["recentcol"] . ", popularrow=" . $detail["popularrow"] . ", popularcol=" . $detail["popularcol"] . ", categoryrow=" . $detail["categoryrow"] . ", categorycol=" . $detail["categorycol"] . ", searchrow=" . $detail["searchrow"] . ", searchcol=" . $detail["searchcol"] . ", relatedrow=" . $detail["relatedrow"] . ", relatedcol=" . $detail["relatedcol"] . ", myvideorow=" . $detail["myvideorow"] . ", myvideocol=" . $detail["myvideocol"] . ", memberpagerow=" . $detail["memberpagerow"] . ", memberpagecol=" . $detail["memberpagecol"] . ", homepopularvideo=" . $detail["homepopularvideo"] . ", homepopularvideorow=" . $detail["homepopularvideorow"] . ", homepopularvideocol=" . $detail["homepopularvideocol"] . ", homefeaturedvideo=" . $detail["homefeaturedvideo"] . ", homefeaturedvideorow=" . $detail["homefeaturedvideorow"] . ", homefeaturedvideocol=" . $detail["homefeaturedvideocol"] . ", homerecentvideo=" . $detail["homerecentvideo"] . ", homerecentvideorow=" . $detail["homerecentvideorow"] . ", homerecentvideocol=" . $detail["homerecentvideocol"] . ", sidepopularvideorow=" . $detail["sidepopularvideorow"] . ", sidepopularvideocol=" . $detail["sidepopularvideocol"] . ", sidefeaturedvideorow=" . $detail["sidefeaturedvideorow"] . ", sidefeaturedvideocol=" . $detail["sidefeaturedvideocol"] . ", siderelatedvideorow=" . $detail["siderelatedvideorow"] . ", siderelatedvideocol=" . $detail["siderelatedvideocol"] . ", siderecentvideorow=" . $detail["siderecentvideorow"] . ", siderecentvideocol=" . $detail["siderecentvideocol"] . ", comment=" . $detail["comment"] . ", language_settings='" . $detail["language_settings"] . "'";
        $query = "update #__hdflv_site_settings set " . $savepagesettings;
        $db->setQuery($query);
        $db->query();

    }

    function fn_imagevalidation_settings(&$logoname, &$task, &$option, &$id)
    {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        // Get file extension
        $exts = $this->findexts($logoname);
        // To make sure exts is exists
        if ($exts)
        {
            if (($exts != "png") && ($exts != "gif") && ($exts != "jpeg") && ($exts != "jpg"))
            { // To check file type
                JError::raiseWarning('SOME_ERROR_CODE', JText::_('File Extensions:Allowed Extensions for image file is .jpg,.jpeg,.png'));
            }
        }
    }
    function findexts($filename)
    {
        $filename = strtolower($filename);
        $exts = split("[/\\.]", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

}
?>
