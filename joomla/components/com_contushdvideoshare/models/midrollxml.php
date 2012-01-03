<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        midrollxml.php
 * @location    /components/com_contushdvideosahre/models/midrollxml.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :  Gets the Ads and The Ads to be displayed to the user
 */
// No Direct access
defined('_JEXEC') or die();
// implementing default component
jimport('joomla.application.component.model');

class Modelcontushdvideosharemidrollxml extends JModel {

    function getads() {
        global $mainframe;
        $db = & JFactory::getDBO();
        $playlistid = 0;
        $mid = 0;
        $itemid = 0;
        $rs_modulesettings = "";
        $moduleid = 0;
        $id = 0;
        $playlistautoplay = "false";
        $postrollads = "false";
        $prerollads = "false";
        $videoid = 0;
        $home_bol = "false";
        $playlistrandom = "false";
        $query = "SELECT a.* FROM `#__hdflv_ads` as a WHERE a.published=1 and typeofadd='mid' ";
        $db->setQuery($query);
        $rs_modulesettings = $db->loadObjectList();
        $qry_settings = "select * from #__hdflv_player_settings LIMIT 1 "; //and home=1";//and id=11;";
        $db->setQuery($qry_settings);
        $rs_random = $db->loadObjectList();
        $random = $rs_random[0]->random;
        $adrotate = $rs_random[0]->midadrotate;
        $interval = $rs_random[0]->midinterval;
        $begin = $rs_random[0]->midbegin;
        ($random == 1) ? $random = "true" : $random = "false";
        ($adrotate == 1) ? $adrotate = "true" : $adrotate = "false";
        if ($rs_modulesettings) {
            $this->showadsxml($rs_modulesettings, $random, $begin, $interval, $adrotate);
        }
    }

    function showadsxml($midroll_video, $random, $begin, $interval, $adrotate) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<midrollad begin="' . $begin . '" adinterval="' . $interval . '" random="' . $random . '" adrotate="' . $adrotate . '">';
        $current_path = "components/com_contushdvideoshare/videos/";
        if (count($midroll_video) > 0) {
            foreach ($midroll_video as $rows) {
                if ($rows->clickurl == '')
                    $clickpath = JURI::base() . 'index.php?option=com_contushdvideoshare&view=impressionclicks&click=click&id=' . $rows->id;
                else
                    $clickpath = $rows->clickurl;

                if ($rows->impressionurl == '')
                    $impressionpath = JURI::base() . 'index.php?option=com_contushdvideoshare&view=impressionclicks&click=impression&id=' . $rows->id;
                else
                    $impressionpath = $rows->impressionurl;

                echo '<midroll targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '" >';
                echo '<![CDATA[';
                echo '<span class="heading">' . $rows->adsname;
                echo '</span><br><span class="midroll">' . $rows->adsdesc;
                echo '</span><br><span class="webaddress">' . $rows->targeturl;
                echo '</span>]]>';
                echo '</midroll>';
            }
        }
        echo '</midrollad>';
        exit();
    }

}