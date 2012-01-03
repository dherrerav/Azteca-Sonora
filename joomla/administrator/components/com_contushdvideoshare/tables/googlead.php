<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        googlead.php
 * @location    /components/com_contushdvideosahre/table/googlead.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Google Ad Administrator Table
 */

//No direct acesss
defined('_JEXEC') or die('Restricted Access');

class Tablegooglead extends JTable {

    var $id = null;
    var $code = null;
    var $showoption = null;
    var $closeadd = null;
    var $reopenadd = null;
    var $publish = null;
    var $ropen = null;
    var $showaddc = null;
    var $showaddm = null;
    var $showaddp = null;

    function Tablegooglead(&$db) {
        parent::__construct('#__hdflv_googlead', 'id', $db);
    }

}

?>
