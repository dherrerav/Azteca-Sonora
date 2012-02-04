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

class Tablegooglead extends JTable {
	var $id = null;
	var $code = null;
    var $showoption = null;
    var $closeadd = null;
	var $reopenadd = null;
    var $publish = null;
    var $ropen = null;
	var $showaddc  = null;
    var $showaddm = null;
    var $showaddp = null;

   

	function Tablegooglead(&$db){
        
		parent::__construct('#__hdflv_googlead', 'id', $db);
     
	}
}

?>
