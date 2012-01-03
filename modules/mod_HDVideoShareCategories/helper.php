<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        helper.php
 * @location    /components/modules/mod_HDVideoShareCategories/helper.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare categories helper
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');

class modcategorylist {

    function getcategorylist() {
        $db = & JFactory::getDBO();
        $query = "select * from #__hdflv_category where parent_id=-1 and published=1 order by ordering asc";
        $db->setQuery($query);
        $rs = $db->loadObjectList();
        return $rs;
    }

}

?>
