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
class JACommentModelImexport extends JModel
{
    var $OtherCommentSystem; 
    /**
    * Return the query is used to retrive all row from database
    * @return string The query is used 
    */    

	function getItems(){
		$db = &JFactory::getDBO();
		$num = JRequest::getInt('num');
		
		$limit = '';
		if($num>0) $limit = " LIMIT 0, $num";
		
		$query = "SELECT * FROM #__jacomment_items ".$limit;
					
        $db->setQuery($query);
        $arr_obj = $db->loadObjectList();
        
        return $arr_obj;
	}
	
	function download($content,$file,$download=true)
	{
		if(is_file($content)) $content=file_get_contents($content);
		
		if($download){
			header("Cache-Control: ");// leave blank to avoid IE errors
			header("Pragma: ");// leave blank to avoid IE errors
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$file\"");
			echo $content;
			
			return true;
		}else{
			return false;
		}
	}
	
    function updateParent($source, $parent)
    {
        $db = & JFactory::getDBO ();
         
        $query = "SELECT id, parentid FROM #__jacomment_items WHERE `source`= '".$source."' AND parentid <> 0";
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        foreach($rows as $row) {
            if (isset($parent[$row->parentid])) {
                $db->setQuery("UPDATE #__jacomment_items SET parentid = " . $parent[$row->parentid] . " WHERE id = " . $row->id);
                $db->query();
            }
        }
    }
    
    function importDataJAComment($rows){
    	$db = & JFactory::getDBO ();
    	// Returns a reference to the global JSession object, only creating it if it doesn't already exist
		$session 				= &JFactory::getSession();
		$ArrayExitsID 	  		= array();
		$ArrayNotExitsParent    = array(); 							
		//$sessionVote = $session->get('vote', null);				
    	foreach ($rows as $key => $val){    		                                                                                  
            $model = &JModel::getInstance('comments', 'jacommentModel');
            $result = $model->isExistItemIDParentID($val["id"], $val["parentid"]);
            //if exits comment id in datase - get error.                        
            if($result == "existID"){                	
            	$ArrayExitsID[] = $val;
            }
            //if not exits parentid of comment in database - get error and not insert in database
            else if($result == "notExistParent"){            	
            	$ArrayNotExitsParent[] = $val;
            }else{                        	
	            //$model->setState ( 'request', $val );	            
	            if(! $id = $model->store($val, 1)){
	                JError::raiseWarning(1, $row->getError(true));
	                return false;  
	            }
	            //$model->setState ( 'request', '' );	            
            }                                   
        }            
        if(sizeof($ArrayExitsID)>0 || sizeof($ArrayNotExitsParent)>0){        	
        	$ArrayError = array("errorID"=>$ArrayExitsID, "erorParentID"=>$ArrayNotExitsParent);
        	return $ArrayError;
        }
        return "importSuc";    	
    }
    
    function importDataDisqus($source, $rows){
    	$db = & JFactory::getDBO ();
    	if(JRequest::getInt("deleteDisqusComment", 0)){
    		$db->setQuery( "DELETE FROM #__jacomment_items WHERE source = '".$source."'" );
        	$db->query();	
    	}    	    	
        $countComment = 0;
     	foreach ($rows as $key => $val){                                    
            $val['type'] = 1; // set is unapproved                                   
            $val['source'] = $source;                        
                                                
            $model = &JModel::getInstance('comments', 'jacommentModel');
                      
            $model->setState ( 'request', $val );
            
            if(! $id = $model->store()){
                JError::raiseWarning(1, $row->getError(true));
                return false;  
            }
			
            $this->updateUrl($id, $val["referer"]."#jacommentid:".$id);
            $countComment ++;                        
        }
        return $countComment;
    }
    
	function updateUrl($commentID, $url){
    	$db = &JFactory::getDBO ();				    	
    	$url = $db->Quote($url);    	
		$query = "UPDATE #__jacomment_items SET `referer` = $url WHERE `id`=$commentID";
		$db->setQuery ( $query );			
		$db->query ();	
    }
    
	function importData($source, $other, $rows){
        $db = & JFactory::getDBO ();
        // delete old comment
        if($source <> "jacomment"){
        	$db->setQuery( "DELETE FROM #__jacomment_items WHERE source = '".$source."'" );
        	$db->query();
        }
		//print_r($rows);die();
        foreach ($rows as $key => $val){            
            
            $val['cid'] = $val['id'];            
            $val['id'] = '';
            $val['type'] = 0; // set is unapproved
            
            if($other) $val['referer'] = $other['url'];
            
            $val['source'] = $source;
            
            if($source=='intensedebate'){        
                $val['voted'] = $val['score'];    
            }else if($source=='disqus'){
                //$val['comment']
            	$val['comment'] = $val['message'];
                $val['voted'] = $val['points'];
                $val['ip'] = $val['ip_address'];
                $val['website'] = $val['url'];
                $val['date'] = date("Y-m-d H:i:s", strtotime($val['date']));
            }else if($source=='joomlacomment'){
                $val['voted'] = $val['voting_yes']-$val['voting_no'];        
                if($val['parentid']<0) $val['parentid']=0;
            }
            
            
            
            $model = &JModel::getInstance('comments', 'jacommentModel');
                      
            $model->setState ( 'request', $val );
            
            if(! $id = $model->store()){
                JError::raiseWarning(1, $row->getError(true));
                return false;  
            }
            
            $parent[$val['cid']] = $id;            
            $this->updateParent($source, $parent);
        }    

        return true;
	} 
    
	function checkExistComponent($componentOption){
		global $db;
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT COUNT(*) FROM #__components WHERE `option` ="' . $componentOption.'"' );        
        return $db->loadResult();
	}
	
    function totalRecord($table)
    {
        global $db;
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT COUNT(*) FROM ' . $table );
        $total = $db->loadResult();
        return $total;
    }
    
    function showTables()
    {
        global $db;
        $db = & JFactory::getDBO();
        $db->setQuery('SHOW tables');
        $tables = $db->loadResultArray();
        return $tables;
    }
	
    function getDataFromK2($itemID){
    	global $db;
        $db 	= & JFactory::getDBO();
        
    	$query  = 'SELECT c.id, c.title,c.alias, cc.alias as categoryalias, cc.id as catID, cc.title as catTitle' .
				' FROM #__k2_items AS c' .
				' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
				' WHERE c.id = "'.$itemID.'"';
							
		$db->setQuery($query);			
		$result = $db->loadObject();
        return $result;
    }
    
    
    function getComponentFromAricleID($link){
    	global $db;
        $db 	= & JFactory::getDBO();                    
		
		$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
				' FROM #__content AS c' .
				' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
				' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
				" WHERE c.id = $link";
				
        $db->setQuery($query);               
        return $db->loadObject();
    }
    /*
     * get article from title
     */
    function getArticleFromTitle($component, $title){
    	global $db;
        $db 	= & JFactory::getDBO();        
        if($component == "com_myblog"){        	
	    	$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
								' FROM #__content AS c' .				        		
								' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
								' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
								' WHERE c.title = "'.$title.'"';
	    	$db->setQuery($query);			
	        $result = $db->loadObject();		        
	        if($result) return $result;	 
        }else if($component == "com_k2"){	        				
			$query  = 'SELECT c.id, c.title,c.alias, cc.alias as categoryalias, cc.id as catID, cc.title as catTitle' .
				' FROM #__k2_items AS c' .
				' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
				' WHERE c.title = "'.$title.'"';
							
			$db->setQuery($query);			
			$result = $db->loadObject();
	        if($result)return $result;			
					
        }else if($component == "com_content"){      
			$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
								' FROM #__content AS c' .				        		
								' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
								' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
								' WHERE c.title = "'.$title.'"';
			
			$db->setQuery($query);$result = $db->loadObject();
	        if($result)return $result;								
        }
		return '';
    }
    
    /*
     * get artile
     */
    function getArticle($component, $link){
    	global $db;
        $db 	= & JFactory::getDBO();
        if($component == "com_myblog"){
        	for($i =strlen($link); $i> 0; $i--){
				if(substr($link,$i,1) == "/"){
					break;	   
				}
			}
			$permalink = substr($link, $i+1);			
			
	    	$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
								' FROM #__content AS c' .
				        		' LEFT JOIN #__myblog_permalinks AS p ON p.contentid = c.id' .
								' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
								' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
								' WHERE p.permalink = "'.$permalink.'"';
	    	$db->setQuery($query);			    	
		    $result = $db->loadObject();		        
		    if($result) return $result;
        }else if($component == "com_k2"){
	        $pos = strpos($link, "id=");
			if($pos !== false){
				$link = substr($link,$pos+3);$pos  = strpos($link, ":");$id   = substr($link,0,$pos);
				$query  = 'SELECT c.id, c.title, cc.id as catID, cc.title as catTitle' .
					' FROM #__k2_items AS c' .
					' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
					" WHERE c.id = $id";
								
				$db->setQuery($query);$result = $db->loadObject();
		        if($result)return $result;			
			}
	
			preg_match_all("/\/\d+/", $link, $matches);
					
			foreach ($matches[0] as $matche){									
				$id = substr($matche,1);
							
				$query  = 'SELECT c.id, c.title, cc.id as catID, cc.title as catTitle' .
					' FROM #__k2_items AS c' .
					' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
					" WHERE c.id = $id";
							
				$db->setQuery($query);			
		        $result = $db->loadObject();		        
		        if($result) return $result;	        
			}	
        }else if($component == "com_content"){
        	$pos = strpos($link, "id=");
			if($pos !== false){
				$link = substr($link,$pos+3);$pos  = strpos($link, ":");$id   = substr($link,0,$pos);
				$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
					' FROM #__content AS c' .
					' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
					' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
					" WHERE c.id = $id";
				
				$db->setQuery($query);$result = $db->loadObject();
		        if($result)return $result;			
			}
	
			preg_match_all("/\/\d+/", $link, $matches);
					
			foreach ($matches[0] as $matche){									
				$id = substr($matche,1);			
				$query  = 'SELECT s.name, c.id, c.title, cc.id as catID, cc.title as catTitle' .
					' FROM #__content AS c' .
					' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
					' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
					" WHERE c.id = $id";				
				$db->setQuery($query);			
		        $result = $db->loadObject();		        
		        if($result) return $result;	        
			}	
        }
		return '';
    }
    
	function getComponentFromAricleLink($link){
    	global $db;
        $db 	= & JFactory::getDBO();
        
        //get destination and source component
        $desComponent 	= JRequest::getVar("desComponent");
        $sourComponent  = JRequest::getVar("sourComponent");
        
        //if source component equal destination
        if($desComponent == $sourComponent){
        	return $this->getArticle($sourComponent, $link);
        }
        
        $article = $this->getArticle($sourComponent, $link);
        if($article){            	    	
        	return $this->getArticleFromTitle($desComponent, $article->title);	        
        }                
        return '';               	
    }
    
    
    function getMyBlogLink($id){
    	global $db;
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT permalink FROM #__myblog_permalinks WHERE `contentid` = '.$id);                
        return $db->loadResult();       
    }
    
    function getAllComponent(){
    	global $db;
        $db = & JFactory::getDBO();
        $db->setQuery('SELECT DISTINCT(`option`) FROM #__components WHERE `option` != ""');        
        return $db->loadObjectList();                       	
    }
    
    function JAOtherCommentSystem() {
                 
        $OtherCommentSystems[] =array( 
                                'code' => 'JomComment', 
                                'name' => 'Jom Comment', 
                                'website' => 'http://www.azrul.com', 
                                'table' => '#__jomcomment',
                                'status' => false,
                                'total' => 0
                            ); 
        $OtherCommentSystems[] =array( 
                                'code' => 'JoomlaComment', 
                                'name' => 'Joomla Comment', 
                                'website' => 'http://www.cavo.co.nr', 
                                'table' => '#__comment',
                                'status' => false,
                                'total' => 0
                            ); 
        $OtherCommentSystems[] =array( 
                                'code' => 'JComments', 
                                'name' => 'JComments', 
                                'website' => 'http://www.joomlatune.com', 
                                'table' => '#__jcomments',
                                'status' => false,
                                'total' => 0
                            );      
                                                  
        return $OtherCommentSystems;
    } 
	
}
?>