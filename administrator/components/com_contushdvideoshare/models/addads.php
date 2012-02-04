<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModeladdads extends JModel {
    function addadsmodel()
    {
        $rs_ads =& JTable::getInstance('contushdvideoshareads', 'Table');
        $add = array('rs_ads' => $rs_ads);
        return $add;
    }
}
?>
