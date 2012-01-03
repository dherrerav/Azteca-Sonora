<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        category.php
 * @location    /components/com_contushdvideosahre/table/category.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    category Administrator Table
 */

//No direct acesss
defined('_JEXEC') or die('Restricted Access');

class Tablecategory extends JTable {

    var $id = null;
    var $category = null;
    var $parent_id = null;
    var $ordering = null;
    var $published = null;

    function Tablecategory(&$db) {

        parent::__construct('#__hdflv_category', 'id', $db);
    }

}

?>
