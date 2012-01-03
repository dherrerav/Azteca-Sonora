<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        googlead.php
 * @location    /components/com_contushdvideosahre/models/googlead.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description : displaying google ads
 */
// No Direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Modelcontushdvideosharegooglead extends JModel {

    function getgooglead() {
        global $db;
        $db = & JFactory::getDBO();
        $query1 = "select * from #__hdflv_googlead where publish='1' and id='1'";
        $db->setQuery($query1);
        $fields = $db->loadObjectList();
        echo html_entity_decode(stripcslashes($fields[0]->code));
        exit();
    }

}