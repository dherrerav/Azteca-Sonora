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

class Tableplaylist extends JTable {
    var $id = null;
    var $category = null;
    var $seo_category = null;
    var $parent_id = null;
    var $ordering = null;
    var $published = null;
    var $member_id = null;

    function __construct(&$db) {
        parent::__construct('#__hdflv_category', 'id', $db);
    }
	

}

?>