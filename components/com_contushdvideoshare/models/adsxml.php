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

class Modelcontushdvideoshareadsxml extends JModel {

    /**
     * Gets the greeting
     *
     * @return string The greeting to be displayed to the user
     */
    function getads() {
        $db = & JFactory::getDBO();
        $query_ads = "select * from #__hdflv_ads where published=1 and typeofadd='prepost' "; //and home=1";//and id=11;";
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
        $clickpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=click';
        $impressionpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=impression';

        if (count($rs_ads) > 0) {
            foreach ($rs_ads as $rows) {
                $timage = "";
                if ($rows->filepath == "File") {
                    $postvideo = JURI::base() . $current_path . $rows->postvideopath;
                    //$prevideo=JURI::base().$current_path.$rows->prevideopath;
                } elseif ($rows->filepath == "Url") {
                    $postvideo = $rows->postvideopath;
                    // $prevideo=$rows->prevideopath;
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