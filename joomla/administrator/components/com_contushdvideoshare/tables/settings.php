<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/table/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Player settings Administrator Table
 */

//No direct acesss
defined('_JEXEC') or die('Restricted access');

class Tablesettings extends JTable
{
    var $id = null;
    var $published=null;
    var $buffer=null;
    var $normalscale=null;
    var $fullscreenscale=null;
    var $autoplay=null;
    var $volume=null;
    var $logoalign=null;
    var $logoalpha = null;
    var $skin_autohide=null;
    var $stagecolor=null;
    var $skin=null;
    var $embedpath=null;
    var $fullscreen=null;
    var $zoom=null;
    var $width=null;
    var $height=null;
    var $uploadmaxsize=null;
    var $ffmpeg=null;
    var $ffmpegpath=null;
    var $related_videos=null;
    var $timer=null;
    var $logopath=null;
    var $logourl=null;
    var $nrelated=null;
    var $shareurl=null;
    var $playlist_autoplay=null;
    var $hddefault=null;
    var $ads=null;
    var $prerollads=null;
    var $postrollads=null;
    var $random=null;
    var $midrollads=null;
    var $midbegin=null;
    var $midinterval=null;
    var $midrandom=null;
    var $midadrotate=null;
    var $playlist_open=null;
    var $licensekey=null;
    var $Youtubeapi=null;
    var $scaletologo=null;
    var $googleanalyticsID=null;
    var $googleana_visible=null;
    
    function __construct(&$db)
    {
        parent::__construct( '#__hdflv_player_settings', 'id', $db );

    }
}

?>