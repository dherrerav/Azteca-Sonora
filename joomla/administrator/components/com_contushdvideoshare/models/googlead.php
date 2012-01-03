<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        googlead.php
 * @location    /components/com_contushdvideosahre/models/googlead.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Google Ads Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelgooglead extends JModel {

    function getgooglead() {
        $db = $this->getDBO();
        $rs_googlead = & JTable::getInstance('googlead', 'Table');
        // To get the id no to be edited...
        $id = 1;
        $rs_googlead->load($id);
        $lists['published'] = JHTML::_('select.booleanlist', 'published', $rs_googlead->publish);
        return $rs_googlead;
    }

    function savegooglead($task) {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        $db = & JFactory::getDBO();
        $rs_saveaddgoogle = & JTable::getInstance('googlead', 'Table');
        $id = 1;
        if ($_POST['showoption'] == '0') {
            $_POST['closeadd'] = '';
        }
        if (!isset($_POST['reopenadd'])) {
            $_POST['reopenadd'] = '1';
            $_POST['ropen'] = '';
        }
        if (!isset($_POST['showaddc'])) {
            $_POST['showaddc'] = '0';
        }
        if (!isset($_POST['showaddm'])) {
            $_POST['showaddm'] = '0';
        }
        if (!isset($_POST['showaddp'])) {
            $_POST['showaddp'] = '0';
        }
        $_POST['code'] = htmlentities(stripslashes($_POST['code']));
        $rs_saveaddgoogle->load($id);
        if (!$rs_saveaddgoogle->bind($_POST)) {
            echo "<script> alert('" . $rs_saveaddgoogle->getError() . "');window.history.go(-1); </script>\n";
            exit();
        }
        if (!$rs_saveaddgoogle->store()) {
            echo "<script> alert('" . $rs_saveaddgoogle->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }
        switch ($task) {
            case 'apply':
                $msg = 'Changes Saved';
                $link = 'index.php?option=' . $option . '&layout=googlead';
                break;
            case 'save':
            default:
                $msg = 'Saved';
                $link = 'index.php?option=' . $option . '&layout=googlead';
                break;
        }
    }
}

?>
