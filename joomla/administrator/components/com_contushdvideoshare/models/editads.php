<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        editads.php
 * @location    /components/com_contushdvideosahre/models/editads.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    edit ads Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModeleditads extends JModel {

    function editadsmodel() {
        $db = & JFactory::getDBO();
        $rs_edit = & JTable::getInstance('contushdvideoshareads', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = $cid[0];
        $rs_edit->load($id);
        $lists['published'] = JHTML::_('select.booleanlist', 'published', $rs_edit->published);
        $add = array('rs_ads' => $rs_edit);
        return $add;
    }

    function removeads() {
        global $mainframe;
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $db = & JFactory::getDBO();
        $cids = implode(',', $cid);
        if (count($cid)) {
            $cids = implode(',', $cid);
            $query = "DELETE FROM #__hdflv_ads WHERE id IN ( $cids )";
            $db->setQuery($query);
            if (!$db->query()) {
                echo "<script> alert('" . $db->getErrorMsg() . "');window.history.go(-1); </script>\n";
            }
        }
        // page redirec
        $app = & JFactory::getApplication();
        $app->redirect('index.php?option=com_contushdvideoshare&layout=ads');
    }

}

?>
