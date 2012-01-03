<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        sortorder.php
 * @location    /components/com_contushdvideosahre/models/sortorder.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Sort Order Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelsortorder extends JModel {

    function categorysortordermodel() {
        global $mainframe;
        $db = & JFactory::getDBO();
        $listitem = JRequest::getvar('listItem', '', 'get', 'var');
        foreach ($listitem as $position => $item) :
            $query = "UPDATE #__hdflv_category SET `sorder` = $position WHERE `id` = $item";
            $db->setQuery($query);
            $db->query();
        endforeach;
        exit();
    }

    function videosortordermodel() {
        global $mainframe;
        $db = & JFactory::getDBO();
        $listitem = JRequest::getvar('listItem', '', 'get', 'var');
        foreach ($listitem as $position => $item) :
            $query = "UPDATE #__hdflv_upload SET `ordering` = $position WHERE `id` = $item";
            $db->setQuery($query);
            $db->query();
        endforeach;
        exit();
    }
}

?>
