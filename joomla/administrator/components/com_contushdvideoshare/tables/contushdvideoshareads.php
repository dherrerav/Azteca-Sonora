<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        contushdvideoshareads.php
 * @location    /components/com_contushdvideosahre/table/contushdvideoshareads.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Ads Administrator Table
 */

//No direct acesss
defined('_JEXEC') or die('Restricted access');

class Tablecontushdvideoshareads extends JTable {
    function __construct(&$db) {
        parent::__construct('#__hdflv_ads', 'id', $db);
    }
    var $id = null;
    var $published = null;
    var $adsname = null;
    var $filepath = null;
    var $postvideopath = null;
    var $home = null;
    var $targeturl = null;
    var $clickurl = null;
    var $impressionurl = null;
    var $impressioncounts = null;
    var $clickcounts = null;
    var $adsdesc = null;
    var $typeofadd = null;
}

?>
