<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        helper.php
 * @location    /components/modules/mod_HDVideoShareFeatured/helper.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Featured helper 
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');

class modfeaturedVideos {

    function getfeaturedVideos() {

        $db = & JFactory::getDBO();
        $limitrow = modfeaturedVideos::getfeaturedVideossettings();
        $length = $limitrow[0]->sidefeaturedvideorow * $limitrow[0]->sidefeaturedvideocol;
        $featuredquery = "select a.*,b.category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and b.published=1 and a.featured='1' and a.type='0' group by e.vid order by rand() limit 0,$length "; // Query is to display featured videos in home page randomly
        $db->setQuery($featuredquery);
        $featuredvideos = $db->loadobjectList();
        return $featuredvideos;
    }

    function getfeaturedVideossettings() {

        $db = & JFactory::getDBO();
        $featurequery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

}

?>
