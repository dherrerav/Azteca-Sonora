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

class Tablechannelsettings extends JTable {

    var $id = null;
    var $channel_id = null;
    var $player_width = null;
    var $player_height = null;
    var $video_row = null;
    var $video_colomn = null;
    var $recent_videos = null;
    var $popular_videos = null;
    var $top_videos = null;
    var $playlist = null;
    var $type=null;
    var $start_videotype=null;
    var $start_video=null;
    var $start_playlist=null;
    var $fb_comment=null;
    var $logo=null;
    

    function __construct(&$db) {
        parent::__construct('#__hdflv_channelsettings', 'id', $db);
    }

}

?>