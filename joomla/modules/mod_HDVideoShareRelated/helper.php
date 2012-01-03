<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        helper.php
 * @location    /components/modules/mod_HDVideoShareRelated/helper.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Related helper
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');

class modrelatedvideos {

    function getrelatedvideos() {
        $db = & JFactory::getDBO();
        $limitrow = modrelatedvideos::getrelatedvideossettings();
        $length = $limitrow[0]->siderelatedvideorow * $limitrow[0]->siderelatedvideocol;
        if (JRequest::getVar('category', '', 'get', 'string')) {
            $category = JRequest::getVar('category', '', 'get', 'string');
            /* Getting the category value Following code is to change the catgeory name which is passing in the url like -,and to '','&' */
            $final = explode('-', $category);
            $final1 = implode(' ', $final);
            $final2 = explode('and', $final1);
            $final3 = implode('&', $final2);
            //Category change code ends here
            $category = $final3;
            $catidquery = "select id from #__hdflv_category where category='$category'"; // Query is to get the category id based on category value passing in the url
            $db->setQuery($catidquery);
            $catid = $db->loadObjectList();
            foreach ($catid as $cid) {
                $catidnew = $cid->id;
            }
            $_SESSION['related'] = $catidnew; // Storing the category id into session for related videos display
            $categoryid = $catidnew;
            $query = "select a.*,b.id as catid,b.category,e.* from #__hdflv_upload a left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where e.catid=$categoryid and a.published=1 and b.published=1  order by rand() LIMIT 0,$length"; //Quer is to display the related videos in the right hand side
        } else {
            $_SESSION['related'] = "featured";
            $query = "select a.*,b.id as catid,b.category,e.* from #__hdflv_upload a left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and b.published=1 and a.featured=1 group by a.id order by rand() LIMIT 0,$length"; //Quer is to display the related videos in the right hand side
        }
        $db->setQuery($query);
        $relatedvideos = $db->loadObjectList();
        return $relatedvideos;
    }

    
    function getrelatedvideossettings() {
        $db = & JFactory::getDBO();
        $featurequery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

}

?>
