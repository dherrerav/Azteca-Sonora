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

class contushdvideoshareModelsortorder extends JModel {


    function categorysortordermodel()
    {
        
        global $mainframe;
        $db =& JFactory::getDBO();
        $listitem=JRequest::getvar('listItem','','get','var');
       foreach ($listitem as $position => $item) :
	    $query = "UPDATE #__hdflv_category SET `sorder` = $position WHERE `id` = $item";
	    $db->setQuery($query );
            $db->query();
        endforeach;
        exit();


    }
 function videosortordermodel()
    {
        
        global $mainframe;
        $db =& JFactory::getDBO();
        $listitem=JRequest::getvar('listItem','','get','var');

        foreach ($listitem as $position => $item) :
	    $query = "UPDATE #__hdflv_upload SET `ordering` = $position WHERE `id` = $item";
	    $db->setQuery($query );
        $db->query();
	    endforeach;
        exit();

    }


    
}
?>
