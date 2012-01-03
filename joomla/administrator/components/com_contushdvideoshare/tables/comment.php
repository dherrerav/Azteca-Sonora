<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        comment.php
 * @location    /components/com_contushdvideosahre/table/comment.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    comment Administrator Table
 */

//No direct acesss
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

    function Tablecomment(&$db) {
        parent::__construct('#__hdflv_comments', 'id', $db);
    }

}

?>
