<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        impressionclicks.php
 * @location    /components/com_contushdvideosahre/models/impressionclicks.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :  Get & update the impression clicks to the Ads
 */
// No Direct access
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class Modelcontushdvideoshareimpressionclicks extends JModel {

    function impressionclicks() {
        global $mainframe;
        $db = & JFactory::getDBO();
        $click = JRequest::getVar('click', 'get', '', 'string');
        $id = JRequest::getVar('id', 'get', '', 'int');
        if ($click != 'click')
            $query = "UPDATE #__hdflv_ads SET clickcounts = clickcounts+1  WHERE `id` = $id";
        else
            $query = "UPDATE #__hdflv_ads SET impressioncounts= impressioncounts+1 WHERE `id` = $id";
        $db->setQuery($query);
        $db->query();
        exit();
    }

}

?>
