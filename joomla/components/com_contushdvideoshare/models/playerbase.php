<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        playerbase.php
 * @location    /components/com_contushdvideosahre/models/playerbase.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   showing player and hdplayerskin 
 */

// No Direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class Modelcontushdvideoshareplayerbase extends JModel {

    function playerskin() {
        $playerpath = realpath(dirname(__FILE__) . '/../hdflvplayer/hdplayer.swf');
        $this->showplayer($playerpath);
    }

    function showplayer($playerpath) {

        ob_clean();
        header("content-type:application/x-shockwave-flash");
        readfile($playerpath);
        exit();
    }

}