<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        adsxml.php
 * @location    /components/com_contushdvideosahre/models/adsxml.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :Generating ads xml 
 */

// No Direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class Modelcontushdvideoshareadsxml extends JModel {

    function getads() {
        $db = & JFactory::getDBO();
        $query_ads = "select * from #__hdflv_ads where published=1 and typeofadd!='mid'"; //and home=1";//and id=11;";
        $db->setQuery($query_ads);
        $rs_ads = $db->loadObjectList();
        $qry_settings = "select * from #__hdflv_player_settings LIMIT 1 "; //and home=1";//and id=11;";
        $db->setQuery($qry_settings);
        $rs_random = $db->loadObjectList();
        $random = $rs_random[0]->random;
        ($random == 1) ? $random = "true" : $random = "false";
        $this->showadsxml($rs_ads, $random);
    }

    function showadsxml($rs_ads, $random) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<ads random="' . $random . '">';
        $current_path = "components/com_contushdvideoshare/videos/";
        $clickpath = JURI::base() . 'index.php?option=com_contushdvideoshare&amp;view=impressionclicks&amp;click=click';
        $impressionpath = JURI::base() . 'index.php?option=com_contushdvideoshare&amp;view=impressionclicks&amp;click=impression';
        if (count($rs_ads) > 0) {
            foreach ($rs_ads as $rows) {
                $timage = "";
                if ($rows->filepath == "File") {
                    $postvideo = JURI::base() . $current_path . $rows->postvideopath;
                } elseif ($rows->filepath == "Url") {
                    $postvideo = $rows->postvideopath;
                }
                echo '<ad id="' . $rows->id . '" url="' . $postvideo . '" targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '">';
                echo '<![CDATA[' . $rows->adsname . ']]>';
                echo '</ad>';
            }
        }
        echo '</ads>';

        exit();
    }

}