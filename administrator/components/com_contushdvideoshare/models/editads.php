<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
//No direct acesss
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class contushdvideoshareModeleditads extends JModel {
    
	function editadsmodel()
    {
        $db =& JFactory::getDBO();
        $rs_edit =& JTable::getInstance('contushdvideoshareads', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $rs_edit->load($id);
        $lists['published'] = JHTML::_('select.booleanlist','published',$rs_edit->published);
        $add = array('rs_ads' => $rs_edit);
        return $add;
	}
    function removeads()
    {
        global $mainframe;
         $mainframe = JFactory::getApplication();
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
        $db =& JFactory::getDBO();
        $cids = implode( ',', $cid );
        if(count($cid))
        {
            $cids = implode( ',', $cid );
            $query = "DELETE FROM #__hdflv_ads WHERE id IN ( $cids )";
            $db->setQuery( $query );
            if (!$db->query())
            {
                echo "<script> alert('".$db->getErrorMsg()."');window.history.go(-1); </script>\n";
            }
        }
        // page redirec
        $mainframe->redirect( 'index.php?option=com_contushdvideoshare&layout=ads' );
    }




}
?>
