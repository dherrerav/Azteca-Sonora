<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        addads.php
 * @location    /components/com_contushdvideosahre/models/addads.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Add 'Ads' Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModeladdads extends JModel {

    function addadsmodel() {
        $rs_ads = & JTable::getInstance('contushdvideoshareads', 'Table');
        $add = array('rs_ads' => $rs_ads);
        return $add;
    }

}

?>
