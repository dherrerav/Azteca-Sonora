<?php

/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/models/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Settings Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelcontrolpanel extends JModel {

    function controlpaneldetails()
    {
        $db = & JFactory::getDBO();
        $query = "SELECT count(id) FROM #__hdflv_upload where usergroupid='8' or usergroupid='6' or usergroupid='7'";
        $db->setQuery($query);
        $count_admin = $db->loadObject();
        $query = "SELECT count(id) FROM #__hdflv_upload where usergroupid !='8' and usergroupid !='6' and usergroupid !='7'";
        $db->setQuery($query);
        $count_member = $db->loadObject();
        $query = "SELECT  count(b.memberid) as count ,a.username as username FROM #__users a left join  #__hdflv_upload b on b.memberid = a.id group by a.id";
        $db->setQuery($query);
        $member_detail = $db->loadObjectList();
        $popularquery = "select id,title,times_viewed from #__hdflv_upload where published=1 and type='0'  ORDER BY times_viewed desc LIMIT 0,4"; //Query is to display the popular videos
        $db->setQuery($popularquery);
        $popularvideos = $db->LoadObjectList();
        $latestquery = "select id,title,created_date from #__hdflv_upload where published=1 and type='0'  ORDER BY id desc LIMIT 0,4"; //Query is to display the popular videos
        $db->setQuery($latestquery);
        $latestvideos = $db->LoadObjectList();
        $count = array('adminvideocount' => $count_admin,'membervideocount' => $count_member,'membervideos' => $member_detail,'popularvideos' => $popularvideos,'latestvideos' => $latestvideos);
        return $count;
    }

    
}

?>
