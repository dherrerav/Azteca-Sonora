<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
defined ( '_JEXEC' ) or die ();

jimport( 'joomla.application.component.model' );

class JACommentModelAddons extends JModel {
    
    var $_script = null;
    
    /*
    * name: addthis, addtoany_comment, ...
    */
    function getScript($name=""){ 
        //$model = & JModel::getInstance ( 'Configs', 'JACommentModel' );        
        $group = JRequest::getVar('group', 'layout');
        $db = &JFactory::getDBO();
        
        $query = "SELECT * FROM #__jacomment_configs as s WHERE s.group='".$group."'";
        $db->setQuery($query);
        $items = $db->loadObjectList();
        if(!$items){
            $items[0]->data = '';
        }
        
        $data = $items[0]->data;
		$params = new JRegistry;
        $params->loadJSON($data);
        
        if($name){ // return only value
            return $params->get($name);        
            
        }else{ // return array
        
            return $params;
        }
    }
    
    /*
     * 
     */
    function getConfig(){     
        $db = &JFactory::getDBO();
        
        $query = "SELECT * FROM #__jacomment_configs as s";
        $db->setQuery($query);
        $items = $db->loadObjectList();
        
        $data = '';        
        if($items){
	        foreach ($items as $item){
	        	$data .= $item->data;	
	        }                         
			$params = new JRegistry;
	        $params->loadJSON($data);
        	return $params;
        }
        
        return null;       
    }
}
?>
