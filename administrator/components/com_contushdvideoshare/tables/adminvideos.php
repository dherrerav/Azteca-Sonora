<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted Access');
class Tableadminvideos extends JTable {
    var $id = null;
    var $published = null;
    var $title = null;
    var $times_viewed = null;
    var $videos = null;
    var $filepath = null;
    var $videourl = null;
    var $thumburl = null;
    var $previewurl = null;
    var $hdurl = null;
    var $playlistid = null;
    var $duration = null;
    var $ordering = null;
    var $home = null;
    var $streameroption = null;
    var $streamerpath = null;
    var $postrollads = null;
    var $prerollads = null;
    var $midrollads = null;
    var $description = null;
    var $targeturl = null;
    var $download = null;
    var $prerollid = null;
    var $postrollid = null;
    var $memberid = null;
    var $type = null;
    var $featured = null;
    var $rate = null;
    var $ratecount = null;
    var $addedon = null;
    var $usergroupid = null;
    var $created_date = null;
    var $scaletologo = null;
    var $tags=null;
    var $seotitle=null;
    var $useraccess = null;
    function Tableadminvideos(&$db) {
        parent::__construct('#__hdflv_upload', 'id', $db);
    }
}
?>
