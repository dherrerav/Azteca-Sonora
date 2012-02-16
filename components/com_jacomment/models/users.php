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

class JACommentModelUsers extends JModel {

    function getParam($userid){
    	global $option; 
		$app = JFactory::getApplication();       
        $db = &JFactory::getDBO();
        
        $query = "SELECT params FROM #__users WHERE id=".$userid;
        $db->setQuery($query);
        $params = $db->loadObjectList();

        $data = '';        
        if($params){
	        foreach ($params as $param){
	        	$data .= $param->params;	
	        }                           
			$params = new JRegistry;
	        $params->loadJSON($data);
        	return $params->_registry['_default']['data'];
        }
        
        return null;       
    }
}
?>
