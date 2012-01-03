<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        helper.php
 * @location    /components/modules/mod_HDVideoShareRecent/helper.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare recent helper
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');

class modrecentvideos {

    function getrecentvideos() {
        $db = & JFactory::getDBO();
        $limitrow = modrecentvideos::getrecentvideossettings();
        $length = $limitrow[0]->siderecentvideorow * $limitrow[0]->siderecentvideocol;
        $recentquery = "select a.*,b.category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and b.published=1 and a.type='0' group by e.vid order by a.id desc limit 0,$length "; // Query is to display recent videos in home page
        $db->setQuery($recentquery);
        $recentvideos = $db->loadobjectList();
        return $recentvideos;
    }

    function getrecentvideossettings() {
        $db = & JFactory::getDBO();
        $featurequery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows = $db->LoadObjectList();
        return $rows;
    }
}

?>
