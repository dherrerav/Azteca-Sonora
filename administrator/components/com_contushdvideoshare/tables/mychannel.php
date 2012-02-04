<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: December 16 2011
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablemychannel extends JTable {

    var $id = null;
    var $user_id = null;
    var $channel_name = null;
    var $description = null;
    var $about_me = null;
    var $tags = null;
    var $logo = null;
    var $website = null;
    var $country = null;
    var $channel_views = null;
    var $total_uploads=null;
    var $recent_activity=null;
    var $created_date=null;
    var $updated_date=null;    
    

    function __construct(&$db) {
        parent::__construct('#__hdflv_channel', 'id', $db);
    }

}

?>