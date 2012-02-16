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
jimport( 'joomla.application.component.model' );

/**
 * @package Joomla
 * @subpackage jacomment
 */
class JACommentModelConfigs extends JModel
{
    var $_data;
    var $_table;
    
    /**
    * Get configuration table instance
    * @return JTable Configuration table object
    */
    function &_getTable(){
        if($this->_table == null){
        	$this->_table = &JTable::getInstance('configs', 'Table');
		}
		return $this->_table;
	}		
	function checkComponent($component){
		$query =" SELECT Count(*) FROM #__components as c WHERE c.option ='$component' "	;
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}
	function publishComponent($component,$publish=0){
		$query =" UPDATE #__components SET enabled = $publish WHERE option ='$component' ";
		$this->_db->setQuery($query);
		return $this->_db->query();		
	}
	function getItems(){
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$group = JRequest::getVar('group', 'systems');
		$db = &JFactory::getDBO();
		
		$query = "SELECT * "
        		 ."FROM #__jacomment_configs as s WHERE s.group='".$group."'";
		$db->setQuery($query);
		$items = $db->loadObjectList();
		if(!$items){
			$items[0]->id = 0;
			$items[0]->data = '';
		}
		return $items[0];
	}
	/**
	* Get configuration item
	* @return Config Table object
	*/
	function getItem($cid=0){
		static $item;
		if (isset($item)) {
			return $item;
		}
		$group = JRequest::getVar('group', 'systems');
		$table =& $this->_getTable();

		// Load the current item if it has been defined
		if(!$cid){
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			JArrayHelper::toInteger($cid, array(0));
		}
		if($cid)
			$table->load($cid[0]);
		$table->group = $group;
	    $item = $table;
	    return $item;	    
	}	
	/** 
	* Store configuration item
	* @param array The post array
	*/
	function store(){
	    // Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& $this->getItem();
		$post	= $this->getState( 'request' );
		
		if (!$row->bind( $post )) {
			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return false;
		}
		if (!$row->check())
		{
			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return false;
		}
		if (!$row->store())
		{
			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return false;
		}
		$row->checkin();
		return $row->id;
	}	
	function parse(&$params,$comments){
		$count=count($comments);
		
		if($count>0){
			for($i=0;$i<$count;$i++){	
				$title='';			
				$comment=$comments[$i];				

				if($title=='')$title="<span style='font-weight:bold;' id='jac_parent_title_$comment->id'>----</span>: "."<span id='jac_title_$comment->id'>---</span>";
				$params->set("status_spam_title_{$comment->id}",$title);
			}
		}
	}
	
	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();
		
		$section  = $node->attributes('section');
		$class    = $node->attributes('class');
		if (!$class) {
			$class = "inputbox";
		}
		
		if (!isset ($section)) {
			// alias for section
			$section = $node->attributes('scope');
			if (!isset ($section)) {
				$section = 'content';
			}
		}
		
		if ($section == 'content') {
			// This might get a conflict with the dynamic translation
			// - TODO: search for better solution
			$query = 'SELECT c.id AS value, CONCAT_WS( "/",s.title, c.title ) AS text' .
			' FROM #__categories AS c' .
			' LEFT JOIN #__sections AS s ON s.id=c.section' .
			' WHERE c.published = 1' .
			' AND s.scope = '.$db->Quote($section).
			' ORDER BY s.title, c.title';
		} else {
			$query = 'SELECT c.id AS value, c.title AS text' .
			' FROM #__categories AS c' .
			' WHERE c.published = 1' .
			' AND c.section = '.$db->Quote($section).
			' ORDER BY c.title';
		}
		$db->setQuery($query);
		$options = $db->loadObjectList();
		
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]', 
		  'class="inputbox" size="15" multiple="multiple"',
		  'value', 'text', $value, $control_name.$name);
	
	}
	function getCategories(){
		$db = &JFactory::getDBO();
		$query = "SELECT c.id AS `value`, c.section AS `id`, CONCAT_WS( ' / ', s.title, c.title) AS `text` 
					FROM #__sections AS s INNER JOIN #__categories AS c ON c.section = s.id 
					WHERE s.scope = 'content' ORDER BY s.name,c.name";
		$db->setQuery($query);
		$categories = $db->loadObjectList(); // load the results into an array
		
		return $categories;
	}
    function getBlockBlackByTab($group){
        $db = &JFactory::getDBO();
		
		if($group=='spamfilters')                
	        $query = "SELECT `group`, data FROM #__jacomment_configs 
	            WHERE `group`='blocked_word_list' OR `group`='blocked_ip_list' OR `group`='blocked_email_list'";
		else
			$query = "SELECT `group`, data FROM #__jacomment_configs 
	            WHERE `group`='blacklist_word_list' OR `group`='blacklist_ip_list' OR `group`='blacklist_email_list'";
					
        $db->setQuery($query);
        $blockblackbytab = $db->loadObjectList();
        //print_r($blacklistbytab);
        
        $arr = array();
        for($i=0; $count=sizeof($blockblackbytab), $i<$count; $i++){                    
            $arr[$blockblackbytab[$i]->group] = $blockblackbytab[$i]->data;
        }
        return $arr;        
    }

    function getGroupByName($groupName){
    	$db = &JFactory::getDBO();
        $tab = JRequest::getVar ( 'tab' );
        
        $query = "SELECT data FROM #__jacomment_configs WHERE `group`='".$groupName."'";
        $db->setQuery($query);
        return $db->loadObjectList();        
    }
    
    
    function getBlockBlack(){
        $db = &JFactory::getDBO();
        $tab = JRequest::getVar ( 'tab' );
        
        $query = "SELECT data FROM #__jacomment_configs WHERE `group`='".$tab."'";
        $db->setQuery($query);
        $blockblack = $db->loadObjectList();
        if($blockblack)
            return $blockblack[0]->data;
    }
    function saveBlockBlack($strData=""){
        $data = '';       
        $msg = '';
        
        $db = & JFactory::getDBO ();
        
        $tab = JRequest::getVar ( 'tab' );
        
        // ++ check        
        $query_check = "SELECT data FROM #__jacomment_configs WHERE `group`='".$tab."'";
        $db->setQuery($query_check);
        $items = $db->loadObjectList();
               
        if(sizeof($items)==0){
            $exist = false;
        }else{
            $exist = true;
            $data .= $items[0]->data;
        }
        // -- check
        
        $data = $data."\n".$strData;        
        if($strData){
            if($exist == true){
                $query = "UPDATE #__jacomment_configs SET data='".$data."' WHERE `group`='".$tab."'";
                
            }else{
                $query = "INSERT INTO #__jacomment_configs(`group`, data) VALUES( '".$tab."', '".$data."')";            
                           
            }
            
            $db->setQuery ( $query );
            if (! $db->query ()) {
                return false;
            }
        }
                    
        return true;
    }
    function removeBlockBlack(){
               
        $db = & JFactory::getDBO ();
        
        $tab = JRequest::getVar ( 'tab' );
        $id = JRequest::getVar ( 'id' );   
        
        $arr = explode("\n", $this->getBlockBlack());        
        unset($arr[$id]);        
        
        $data = implode("\n", $arr);
        
        $query = "UPDATE #__jacomment_configs SET data='".$data."' WHERE `group`='".$tab."'";
        $db->setQuery ( $query );
        if (! $db->query ()) {
            return false;
        }
                    
        return true;
    }
}
?>