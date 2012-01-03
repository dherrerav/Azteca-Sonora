<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        adminvideos.php
 * @location    /components/com_contushdvideosahre/table/adminvideos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    adminvideos Administrator Table
 */

//No direct acesss
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
    var $created_date = null;
    var $scaletologo = null;
    var $usergroupname = null;
    var $tags = null;

    function Tableadminvideos(&$db) {
        parent::__construct('#__hdflv_upload', 'id', $db);
    }
}

?>
