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
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package		Joomla
 * @subpackage	Config
 */

class JACommentControllerImexport extends JACommentController{
	/**
	 * Constructor
	 */
	function __construct( $default = array())
	{		
		parent::__construct( $default );	
		$this->registerTask( 'export', 'export');	

        $type = JRequest::getVar('type');        
        
        if($type=='xml'){
            $this->registerTask( 'import', 'importxml');    
        }else{
            $this->registerTask( 'import', 'import');    
        }    
	}

	/**
	 * Display the list of language
	 */
	function display()
	{					
		parent::display();				
	}
	
	/**
	 * export to xml
	 * 
	 **/
	function export(){			
		JRequest::setVar('layout','export');
		
		$model = & $this->getModel ( 'imexport' );
		$arr_obj = $model->getItems();		
		$out = '<?xml version="1.0" encoding="utf-8"?><output>';	
		foreach( $arr_obj as $k => $obj ){
			$out .= '
					<comments>';			
			foreach( $obj as $key => $val ){
				if($key!='referer'){
					if($val!=''){
						$val = str_replace("&amp;","&",$val);
						$val = str_replace("&","&amp;",$val);
						$out .= '<'.$key.'>'.$val.'</'.$key.'>';
					}else{
						$out .= '<'.$key.'/>';
					}
				}	
			}
			$out .= '</comments><br/>';
			
		}
		$out .= '</output>';			
		$download = $model->download($out, 'jacomment.xml');
		exit();
	}
	
	function showcomment(){
		parent::display();
	}
	
	function importxml(){			
		JRequest::setVar('layout','import');
		
		$model = & $this->getModel ( 'imexport' );
		
        $source = JRequest::getVar( 'source' );
        
		jimport('joomla.filesystem.file'); 
        
		if(isset($_FILES[$source]) && $_FILES[$source]['name']!='' && strtolower(substr($_FILES[$source]['name'], -3, 3))=='xml'){
		    $file = JPATH_COMPONENT_ADMINISTRATOR.DS.'temp'.DS.substr($_FILES[$source]['name'], 0, strlen($_FILES[$source]['name'])-4).time().rand().substr($_FILES[$source]['name'], -4, 4);
            
			if(JFile::upload($_FILES[$source]['tmp_name'], $file)){
			    unset($_FILES[$source]);
                
                $xml =& JFactory::getXMLParser( 'simple' );
     
                $xml->loadFile( $file );
                $out =& $xml->document; 
				
                //check is valid xml document
                if($out == false){
                	JError::raiseNotice(1, JText::_('PLEASE_BROWSE_A_VALID_XML_FILE'));
        			return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import", '');        	
                }else{
                	if($source == "jacomment"){
                		//for jacomment
                		$i = 0;                		
                		$allComments = $out->children();
                		//print_r($allComments[0]);die();
                		//check is jacomment xml
                		if($allComments[0]->name() != "comments"){
                			JError::raiseNotice(1, JText::_('PLEASE_SELECT_XML_FILE_OF_JACOMMENT_COMPONENT'));
	                   	 	return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");	 
                		}
                		foreach ($allComments as $comments) {                              			  			                				                
                			foreach ($comments->children() as $key => $value) {	                            
	                        	$rows[$i][$value->name()] = $value->data();                                                    	                            
		                    }
		                    $i++;
                		} 
                		               		                		
                		$results = $model->importDataJAComment($rows);                		
                		if($results == "importSuc"){                			                			
//	                    	JError::raiseNotice(1, JText::_('CAN_NOT_IMPORT_THE_DATA'));
//	                   	 	return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");
							JFile::delete($file);
	                		$message = JText::_( "Import data successfully ".sizeof($rows)." record(s)" );                    
	                	}else{	                			                	
	                		$arrayExitsIDs 		= array();
	                		$arrayExitsParentIDs = array();
	                		
	                		$arrayExitsIDs 		 = $results["errorID"];
	                		$arrayExitsParentIDs = $results["erorParentID"];	                		
	                		$strErrorID = "";
	                		$strErrorParentID = "";
	                		if(count($arrayExitsIDs) >0){	                			
	                			if(count($arrayExitsIDs) >1){
	                				$strErrorID = JText::_("CAN't import some comment:");	                				             				
	                				foreach ($arrayExitsIDs as $arrayExitsID){
	                					$strErrorID .= " ".$arrayExitsID["id"].",";	
	                				}
	                				$strErrorID = substr($strErrorID, 0, -1);	                				
	                				$strErrorID .=". Therefor they were existed in database.";	                				
	                			}else{
	                				$strErrorID = JText::_("CAN't import comment: ").$arrayExitsIDs[0]["id"].JText::_("_BECAUSE_IT_ALREADY_EXISTS")."<br />";	
	                			}
	                			JError::raiseNotice(1, $strErrorID);
	                		}	                		
	                		if(count($arrayExitsParentIDs) > 0){	                			
	                			if(count($arrayExitsParentIDs) >1){
	                				$strErrorParentID = JText::_("CAN't import some comment: ");	                					                				
	                				foreach ($arrayExitsParentIDs as $arrayExitsParentID){	                						                						                					                							                						
	                					$strErrorParentID .= " ".$arrayExitsParentID["id"].",";	                						
	                				}	                				
	                				$strErrorParentID = substr($strErrorParentID, 0, -1);	                               				
	                				$strErrorParentID .=". Because we can't find parent of it in database.";
	                			}else{
	                				$strErrorParentID = JText::_("CAN't import comment: ").$arrayExitsParentIDs[0]["id"].JText::_("_BECAUSE_WE_CAN't find parent of it in database.")."<br />";	
	                			}
	                			JError::raiseNotice(1, $strErrorParentID);
	                		}
	                		$resultsSus = sizeof($rows) - (sizeof($arrayExitsIDs)+ sizeof($arrayExitsParentIDs));
	                		if($resultsSus >0){
	                			$message = JText::_( "Import successfully ".$resultsSus." record(s)" );
	                		}
	                		//return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");
	                	}	                	                	                		                		                	
                	}else{
                		$allComments = $out->children();
                		if($source == "intensedebate"){
                			if($allComments[0]->name() != "blogpost"){
                				JError::raiseNotice(1, JText::_('PLEASE_SELECT_XML_FILE_OF_INTENSEDEBATE_COMMENTS'));
	                   	 		return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");		 	
                			}
                		}else if($source == "disqus"){
                			if($allComments[0]->name() != "article"){
                				JError::raiseNotice(1, JText::_('PLEASE_SELECT_XML_FILE_OF_DISQUS_COMMENTS'));
	                   	 		return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");		 	
                			}
                		}                		
	                	// intensedebate, disqus                          	    
		                foreach ( $allComments as $blogpost) {	                			                    
		                	foreach ($blogpost->children() as $comments) {	                    	
		                        $other[$comments->name()] = $comments->data();	    										                        		                                            
		                        foreach ($comments->children() as $key => $value) {	                            
		                        	$comment[$key] = $value->children();                                                    
		                            foreach ($comment[$key] as $k => $v) {	                            	
		                                $rows[$key][$v->name()] = $v->data();
		                                if(isset($other["url"]) && $other["url"] != "")
		                                	$rows[$key]["link"]		= $other["url"];
		                            }
		                        }
		                    }
		                }
		                
		                //print_r($rows);die();
		                
						if(!$model->importData($source, $other, $rows)){
	                    	JError::raiseNotice(1, JText::_('CAN_NOT_IMPORT_THE_DATA'));
	                   	 	return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");                    
	                	}
	                
	                	JFile::delete($file);
	                	$message = JText::_( "Import data successfully ".sizeof($rows)." record(s)" );
                	}
           		}                   	                	                	               
           }else{
           	   	JError::raiseNotice(1, JText::_('CAN_NOT_IMPORT_THE_DATA'));
               	return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");                             	                                 
           }
		}else{
            JError::raiseNotice(1, JText::_('CAN_NOT_IMPORT_THE_DATA_PLEASE_BROWSE_AN_XML_FILE'));  
        }
        
		return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import", $message);
		
	}
    
    function import(){
        $model = & $this->getModel ( 'imexport' );
        
        $source = strtolower(JRequest::getVar( 'source' ));
        
        $db=JFactory::getDBO();
        
        switch( $source ){
            case 'joomlacomment':
                $db->setQuery( "SELECT * FROM `#__comment`" );
                break;
            case 'jomcomment':
                $db->setQuery( "SELECT * FROM `#__jomcomment`" );
                break;    
            case 'jcomments':
                $db->setQuery( "SELECT * FROM `#__jcomments`" );
                break;     
        }
        
        $rows = $db->loadAssocList();
        
        if(!$model->importData($source, '', $rows)){
            JError::raiseNotice(1, JText::_('CAN_IMPORT_THE_DATA'));
        }

        $message = JText::_( "Import data successfully ".sizeof($rows)." record(s)" );
        return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import", $message);        
    }
	
    function open_content(){
    	JRequest::setVar('layout','showcontent');        
        parent::display();        
    	exit();	
    }
    
    function open_k2(){
    	JRequest::setVar('layout','showcontentk2');        
        parent::display();        
    	exit();
    }
    
    function getComponent(){
    	$id = JRequest::getVar("id", 0);
    	$model 	= & $this->getModel ( 'imexport' );
    	if(JRequest::getVar("desoption") == "com_k2"){
    		include_once JPATH_SITE.DS."components".DS."com_k2".DS."helpers".DS."route.php";
    		$result = $model->getDataFromK2($id);
    		$link = K2HelperRoute::getItemRoute($result->id.':'.urlencode($result->alias),$result->catID.':'.urlencode($result->categoryalias));																				    	
    		echo "com_k2";    					
			echo  "---".urldecode(JRoute::_($link));	
    	}else{	    	
	    	$result = $model->getComponentFromAricleID($id);
	    	if(isset($result->name)){
	    		if($result->name == "MyBlog"){    			
					echo "com_myblog";
					$permalink	= $model->getMyBlogLink($id);
					echo  "---".JRoute::_("index.php?option=com_myblog&show={$permalink}&Itemid={$id}");		    
	    		}else{
	    			echo "com_content";
	    			require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');					
					echo "---".JRoute::_(ContentHelperRoute::getArticleRoute($result->id.":".$result->title,$result->catID.":".$result->catTitle));	
	    		}
	    	}else{
	    		echo "com_content";
	    		require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');				
				echo "---".JRoute::_(ContentHelperRoute::getArticleRoute($result->id.":".$result->title,$result->catID.":".$result->catTitle));
	    	}
    	}
    	exit();
    }    	
    
    function saveImportComment(){ 		
 		$chkComments= JRequest::getVar("chkComment");
    	$comments 	= JRequest::getVar("comment");
 		$names	 	= JRequest::getVar("name");
 		$emails	 	= JRequest::getVar("email");
 		$websites	= JRequest::getVar("website");
 		$dates	 	= JRequest::getVar("date");
 		$referers   = JRequest::getVar("referer");
 		$ip_address	= JRequest::getVar("ip_address");
 		$options	= JRequest::getVar("contentoption");
 		$titles		= JRequest::getVar("title");
 		$voteds		= JRequest::getVar("voted");
 		$contentids	= JRequest::getVar("contentid");
		$post = array();				
								
		foreach($chkComments as $i){					
 			$post[] = array("comment" => $comments[$i], "name"=>$names[$i], "email" => $emails[$i], "website"=>$websites[$i], "date"=> date("Y-m-d H:i:s", strtotime($dates[$i])), "ip"=>$ip_address[$i], "option" => $options[$i], "contentid" => $contentids[$i], "referer" => $referers[$i], "contenttitle" => $titles[$i], "voted"=>$voteds[$i]); 				 						
		}
		
 		$model = & $this->getModel ( 'imexport' );
 		
    	if(!$model->importDataDisqus("disqus", $post)){
            JError::raiseNotice(1, JText::_('CAN_IMPORT_THE_DATA'));
            return $this->setRedirect("index.php?option=com_jacomment&view=imexport&group=import");
        }
 		 		
 		$message = JText::_( "Import data successfully ".sizeof($post)." record(s)" );         
 		$this->setRedirect("index.php?option=com_jacomment&view=comments&sourcesearch=disqus", $message); 		 		   
    }
}
?>