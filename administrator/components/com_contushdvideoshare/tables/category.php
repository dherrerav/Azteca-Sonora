<?php

/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 * */
defined('_JEXEC') or die('Restricted Access');

class Tablecategory extends JTable {

    var $id = null;
    var $category = null;
    var $seo_category = null;
    var $parent_id = null;
    var $ordering = null;
    var $published = null;

    function Tablecategory(&$db) {

        parent::__construct('#__hdflv_category', 'id', $db);
    }

}

?>
