<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablecontushdvideoshareads extends JTable {

    var $id = null;
    var $published = null;
    var $adsname = null;
    var $filepath = null;
    var $postvideopath = null;
    var $home = null;
    var $targeturl = null;
    var $clickurl = null;
    var $impressionurl = null;
    var $clickcounts = null;
    var $impressioncounts=null;
    var $adsdesc=null;
    var $typeofadd=null;

    function __construct(&$db) {
        parent::__construct('#__hdflv_ads', 'id', $db);
    }

}

?>