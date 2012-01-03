<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        memberdetails.php
 * @location    /components/com_contushdvideosahre/table/memberdetails.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Member Details Administrator Table
 */

//No direct acesss
defined('_JEXEC') or die('Restricted Access');

class Tablememberdetails extends JTable {

    var $id = null;
    var $name = null;
    var $username = null;
    var $email = null;
    var $password = null;
    var $created_date = null;
    var $published = null;

    function Tablememberdetails(&$db) {
        parent::__construct('#__hdflv_member_details', 'id', $db);
    }

}

?>
