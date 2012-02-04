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

class Tablecomment extends JTable {
	var $id = null;
	var $parentid = null;
    var $videoid = null;
    var $name = null;
    var $email = null;
    var $subject = null;
    var $message = null;
    var $created = null;
    var $published = null;

   	function Tablecomment(&$db){

		parent::__construct('#__hdflv_comments', 'id', $db);

	}
}

?>
