<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted Access');

class Tablememberdetails extends JTable {
	var $id = null;
	var $name = null;
    var $username = null;
    var $email = null;
    var $password = null;
    var $created_date = null;
    var $published = null;


	function Tablememberdetails(&$db){

		parent::__construct('#__hdflv_member_details', 'id', $db);

	}
}

?>
