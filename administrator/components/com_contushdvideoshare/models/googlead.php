<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModelgooglead extends JModel {


	function getgooglead()
    {
        $db = $this->getDBO();
		
        $rs_googlead =& JTable::getInstance('googlead', 'Table');
        //$cid = JRequest::getVar( 'cid', array(0), '', 'array' );

        // To get the id no to be edited...
        $id = 1;
        $rs_googlead->load($id);
        $lists['published'] = JHTML::_('select.booleanlist','published',$rs_googlead->publish);

        return $rs_googlead;
	}

    function savegooglead($task)
    {
         $option = 'com_contushdvideoshare';
        global $mainframe;
        $db =& JFactory::getDBO();
        $rs_saveaddgoogle =& JTable::getInstance('googlead', 'Table');
        $id = 1;
        if($_POST['showoption'] == '0') {
            $_POST['closeadd'] = '';
        }
        if(!isset($_POST['reopenadd'])) {
            $_POST['reopenadd'] = '1';
            $_POST['ropen'] = '';
        }
        if(!isset($_POST['showaddc'])) {
            $_POST['showaddc'] ='0';
        }
        if(!isset($_POST['showaddm'])) {
            $_POST['showaddm'] ='0';
        }
        if(!isset($_POST['showaddp'])) {
            $_POST['showaddp'] ='0';
        }
        $_POST['code']= htmlentities(stripslashes($_POST['code']));
        $rs_saveaddgoogle->load($id);
        if (!$rs_saveaddgoogle->bind($_POST)) {
            echo "<script> alert('".$rs_saveaddgoogle->getError()."');window.history.go(-1); </script>\n";
            exit();
        }
        if (!$rs_saveaddgoogle->store()) {
            echo "<script> alert('".$rs_saveaddgoogle->getError()."'); window.history.go(-1); </script>\n";
            exit();
        }
        switch ($task) {
            case 'apply':
                $msg = 'Changes Saved';
                $link = 'index.php?option=' . $option .'&layout=googlead';
                break;
            case 'save':
            default:
                $msg = 'Saved';
                $link = 'index.php?option=' . $option.'&layout=googlead';
                break;
        }
        // page redirect
//        $mainframe->redirect($link, 'Saved');
    }

	

}
?>
