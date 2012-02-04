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

jimport( 'joomla.application.component.model' );

class Modelcontushdvideoshareplayerbase extends JModel
{
   
    function playerskin()
    {
        $playerpath = realpath(dirname(__FILE__) . '/../hdflvplayer/hdplayer.swf');
        $this->showplayer($playerpath);
       
    }

    function showplayer($playerpath)
    {
       
        ob_clean();
        header("content-type:application/x-shockwave-flash");
        readfile($playerpath);
        exit();
        
    }
}