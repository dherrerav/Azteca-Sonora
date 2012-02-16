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

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

/**
 * @package		JA Comment
 * @subpackage	Comments
 */
class jacommentViewcomments extends JAView {	
	function display($tpl = null) {
		switch ($this->getLayout ()) {
			case 'comment' :
				$this->show_detail ();
				break;
			case 'comments' :
				$this->setLayout ( 'default' );
				$this->changeTab ();
				break;
			case 'changetype' :
				$this->setLayout ( 'default' );
				$this->changeTypeOfComments ();
				break;		
			case 'paging':
				$this->setLayout ( 'default' );
				$this->pagingData();
				break;	
			case 'checksubofcomment':
				$this->setLayout ( 'default' );
				$this->checkSubOfComment();
			case 'editcomment':				
				$this->setLayout ( 'default' );
				$this->showFormEdit();
			case 'replycomment':				
				$this->setLayout ( 'default' );
				$this->showFormReply();	
			case 'youtube':
                $this->showYouTube();
                break; 			
			case 'sortcomment':
				$this->setLayout ( 'default' );
				$this->sortComment();
			default :				
				$this->displayItems ();
		}
		
		parent::display ( $tpl );
	}
	
	function showFormEdit(){			
		$model 			= $this->getModel();
		$helper = new JACommentHelpers ( );
		
		$id     		= JRequest::getInt( 'id', 0 );		
		$curentTypeID 	= JRequest::getInt( 'currenttypeid', 0 );
				
		$item = $model->getItem($id);	
		
		//print_r($item);die();
		
		$this->assign("item", $item);
		$this->assign("id", $id);		
		$this->assign("curentTypeID", $curentTypeID);
		
		$k = 0;
		$object = array ();
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jac-edit-comment-'.$curentTypeID."-".$id;
		$object [$k]->type = 'html';
		$object [$k]->content = $this->loadTemplate( 'edit' );
		$k++;
		
		echo $helper->parse_JSON_new ( $object );
		exit ();					
	}
	
	function showFormReply(){			
		$model 			= $this->getModel();
		$helper = new JACommentHelpers ( );
		
		$id     		= JRequest::getInt( 'id', 0 );		
		$curentTypeID 	= JRequest::getInt( 'currenttypeid', 0 );
		$replyTo		= JRequest::getVar( 'replyto', '' );		
		$item = $model->getItem($id);	
		
		//print_r($item);die();
		
		$this->assign("item", $item);
		$this->assign("id", $id);		
		$this->assign("replyTo", $replyTo);
		$this->assign("curentTypeID", $curentTypeID);
		
		$k = 0;
		$object = array ();
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jac-result-reply-comment-'.$curentTypeID."-".$id;
		$object [$k]->type = 'html';
		$object [$k]->content = $this->loadTemplate( 'reply');
		$k++;
		
		echo $helper->parse_JSON_new ( $object );
		exit ();			
	}
	
	function checkSubOfComment(){
		$id = JRequest::getVar ( 'id', '' );
		$model = & $this->getModel ();
		if($id != ''){								 							
			$result = $model -> checkSubOfComment($id);				
			if(count($result)>0){
				echo "HASSUB";
			}else{
				echo "OK";
			}
		}else{
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );			
			foreach ($cid as $id){				
				$results = $model -> checkSubOfComment($id);				
				if(count($results)>0){
					foreach ($results as $result){
						$numberOfComment = count($cid);
						for($i=0; $i<$numberOfComment;$i++ ){
							if($result->id == $cid[$i]){
								break;				
							}	
						}						
						if($i >= $numberOfComment){
							echo "HASSUB";
							exit;			
						}
					}
					
				}				
			}        	
		}
		exit;
	}
		
	/*
	 * Change type or delete comment 
	 */				
	function changeTypeOfComments() {
		global $jacconfig;
		$isSendDeleteMail = $jacconfig["general"]->get("is_enabled_email", 0);	
		$isAttachImage    = $jacconfig['comments']->get("is_attach_image", 0);	
		$id = JRequest::getVar ( 'id', '' );
		$type = JRequest::getVar ( 'type', '' );
		$model = & $this->getModel ();
		$currentTypeID = JRequest::getVar ( 'curenttypeid', 99 );
		$limitstart = JRequest::getVar ( 'limitstart', 0 );
		$limit = JRequest::getVar ( 'limit', 10 );
		$helper = new JACommentHelpers ( );
		$currentUserInfo = JFactory::getUser();
		
        $search = '';
        $searchComponent = JRequest::getVar( 'optionsearch', '' );
		if($searchComponent) $search .= " AND `option` = '" . $searchComponent . "'";
        
        $searchSource = JRequest::getVar( 'sourcesearch', '' );
        if($searchSource) $search .= " AND `source` = '" . $searchSource . "'";
        
		$reported = JRequest::getInt('reported', 0);
		if($reported==1){                
			$search .= " AND report > 0";
		}
		
		$keyword = JRequest::getVar ( 'keyword' );
        if($keyword){
            $search .= " AND (c.email LIKE '%".$keyword."%' OR c.id LIKE '%".$keyword."%' OR c.contenttitle LIKE '%".$keyword."%' OR c.name LIKE '%".$keyword."%' OR c.comment LIKE '%".$keyword."%')";
            $model->builQueryWhenSearch($search);   
        }
                                   
		//if action is delete comments
		if(JRequest::getVar ( 'type', '' ) == "delete"){
			if($id != ''){								 			
				$db = JFactory::getDBO ();				 				
												
				//delete comment
				$comment = $model->deleteComment($id);										
				//send mail for author of comment
												
				if($isSendDeleteMail){
					$userID 	= $comment->userid;								
					if($userID == 0){
						$userEmail  = $comment->email;
						$userName   = $comment->name; 						
					}else{
						$userInfo = JFactory::getUser($userID);					
						$userEmail  = $userInfo->email;
						$userName   = $userInfo->name; 
					}
					$content    = $helper->replaceBBCodeToHTML($comment->comment);
				
					$helper->sendMailWhenDelete($userName, $userEmail, $content, $comment->referer, $currentUserInfo->name);	
				}					
				
				if($isAttachImage){								
					$file_path 			 =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id;					
					if (is_dir($file_path)) {
						jimport( 'joomla.filesystem.folder' );
						JFolder::delete($file_path);

					}															    					  										
				}													
			}else{
				$cid = JRequest::getVar( 'cid', array(0), '', 'array' );			
				foreach ($cid as $id){									
					$comment = $model -> deleteComment($id);
					
					if($isSendDeleteMail){
						$userID 	= $comment->userid;								
						if($userID == 0){
							$userEmail  = $comment->email;
							$userName   = $comment->name; 						
						}else{
							$userInfo = JFactory::getUser($userID);					
							$userEmail  = $userInfo->email;
							$userName   = $userInfo->name; 
						}
						$content    = $helper->replaceBBCodeToHTML($comment->comment);
						$helper->sendMailWhenDelete($userName, $userEmail, $content, $comment->referer, $currentUserInfo->name);	
					}		
					
					if($isAttachImage){								
						$file_path 			 =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id;					
						if (is_dir($file_path)) {
							jimport( 'joomla.filesystem.folder' );
							JFolder::delete($file_path);						
						}															    					  										
					}
				}        	
			}
		}
		//if action is changetype of comment
		else{			
			if($id != ''){
				$model -> changeTypeOfComment($id,$type);								
			}else{
				$cid = JRequest::getVar( 'cid', array(0), '', 'array' );			
				foreach ($cid as $id){														
					$model -> changeTypeOfComment($id,$type);	
				}        					
			}
		}
		$totalType = $model->getTotalByType($search);
		
        if($totalType)       
			$totalAll         		= (int)array_sum($totalType);
		else 
			$totalAll         		= 0;
		
        $totalUnApproved 	= (int)$totalType[0];
        $totalApproved     	= (int)$totalType[1];
        $totalSpam         	= (int)$totalType[2];        
        

		$k = 0;
		$object = array ();
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#number-of-tab-99';
		$object [$k]->type = 'html';
		$object [$k]->content = $totalAll;
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#number-of-tab-0';
		$object [$k]->type = 'html';
		$object [$k]->content = $totalUnApproved;
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#number-of-tab-1';
		$object [$k]->type = 'html';
		$object [$k]->content = $totalApproved;
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#number-of-tab-2';
		$object [$k]->type = 'html';
		$object [$k]->content = $totalSpam;
		$k++;								
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#jav-mainbox-".$currentTypeID;
		$object [$k]->type = 'html';
		//get Item have type
		if($currentTypeID != 99)
        	$search .= " AND type = $currentTypeID"; 							
		$object [$k]->content = $this->loadContentChangeData($search, $currentTypeID, $limit, $limitstart, 'changetype');		
		
		$k++;
						
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#expandOrCollapse".$currentTypeID;
		$object [$k]->type = 'html';
		$statusAll = JRequest::getVar ( 'hidAllStatus'.$currentTypeID, 0 ) ;
		if($statusAll == 1){
			$object [$k]->content = JText::_("_COLLAPSE_ALL_COMMENTS");					
		}else{
			$object [$k]->content = JText::_("_EXPAND_ALL_COMMENTS");
		}
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#hidAllStatus".$currentTypeID;
		$object [$k]->type = 'value';
		$statusAll = JRequest::getVar ( 'hidAllStatus'.$currentTypeID, 0 ) ;
		if($statusAll == 1){
			$object [$k]->content = 1;					
		}else if($statusAll == 0){
			$object [$k]->content = 0;
		}else{
			$object [$k]->content = 2;
		}
		$k++;
		
		//jav-page-links-0
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jav-pagination-'.$currentTypeID;
		$object [$k]->attr = 'html';		
		$pagination = &$model->getPagination($limitstart, $limit, 'jav-pagination-'.$currentTypeID);		
		$lists['limitstart'] = $limitstart;
		$lists['limit'] = $limit;
		$lists['order'] = "";		        	
       	$this->assignRef('lists', $lists);       	
       	$this->assignRef('pagination', $pagination);       			
		$object [$k]->content = $this->loadTemplate('paging');				
		$k++;
				
		if(JRequest::getVar('displaymessage') == "show"){
			$message = '<script type="text/javascript">displaymessageadmin();</script>';
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-msg-succesfull';
			$object [$k]->attr = 'html';				       			
			$object [$k]->content = JText::_( "Save data successfully" ).$message;	
		}				
								
		echo $helper->parse_JSON_new ( $object );
		exit ();	
	}	
		
	/*
	 * action is change tab 
	 */
	function changeTab() {
		global $jacconfig;
        $currentTypeID = JRequest::getVar ( 'curenttypeid', '99' );		
        $search = '';
        $searchComponent = JRequest::getVar( 'optionsearch', '' );
        if($searchComponent) $search .= " AND `option` = '" . $searchComponent . "'";
        
        // ++
        $reported = JRequest::getInt('reported', 0);
        if($reported==1){            
            $search .= " AND report > 0";
        }
        // --
            
        $searchSource = JRequest::getVar( 'sourcesearch', '' );
        if($searchSource) $search .= " AND `source` = '" . $searchSource . "'";
        
        if($currentTypeID != 99)            
        	$search .= " AND type = $currentTypeID";
        $keyword = JRequest::getVar ( 'keyword' );
        if($keyword || $reported){
            $search .= " AND (c.email LIKE '%".$keyword."%' OR c.id LIKE '%".$keyword."%' OR c.contenttitle LIKE '%".$keyword."%' OR c.name LIKE '%".$keyword."%' OR c.comment LIKE '%".$keyword."%')";
            $model = & $this->getModel ();
            $model->builQueryWhenSearch($search);   
        }
        
		$object = array ();
		$k = 0;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#currentTypeID';
		$object [$k]->attr = 'value';		
		$object [$k]->content = $currentTypeID;
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jav-mainbox-' . $currentTypeID;
		$object [$k]->attr = 'html';		
		$object [$k]->content = $this->loadContentChangeData($search, $currentTypeID);
		$k++;
										
		$helper = new JACommentHelpers ( );
		
		echo $helper->parse_JSON_new ( $object );
		exit ();
	}
		
	/*
	 * when action is complete - load data again
	 */	
	function loadContentChangeData($where, $currentTypeID, $limit=10, $limitstart=0, $action = ''){
		$model = & $this->getModel ();
		$sortType = JRequest::getVar ( 'sorttype', 'DESC' );		
		$orderBy = "";
        if($sortType == "DESC"){
			$orderBy = ' ORDER BY c.id DESC';
			$this->assign("sortType", "DESC");
        }else{ 
		  	$orderBy = ' ORDER BY c.id ASC';
		  	$this->assign("sortType", "ASC");
        }

        //buil struct of comment.
		$items = $this->builtTreeComment($where,$currentTypeID, $orderBy);
						
		
		$lists['search'] = '';			
		$lists['limitstart'] = $limitstart;
		$lists['limit'] = $limit;			
		$lists['order'] = "";					        
       	$this->assignRef('lists', $lists);
		//display item by paging
		$count = ($lists['limit']<count($items))?$lists['limit']:count($items);			
		$this->assignRef('count_items',$count);	
       			
		$this->assign ( 'items', $items );
		$this->assign ( 'currentTypeID', $currentTypeID );
		
		$this->assign ( 'codeApproved', '1');
		$this->assign ( 'codeUnApproved', '0');
		$this->assign ( 'codeSpam', '2');		
		return  $this->loadTemplate('comments');		
	}
		
	function sumaryComment($comment) {
		$helper = new JACSmartTrim ( );
		return $helper->mb_trim($comment, 0, 300);
	}
	
	function sortComment(){						
		$model = & $this->getModel ();				
		$currentTypeID = JRequest::getVar ( 'curenttypeid', 99 );		
		$limitstart = JRequest::getVar ( 'limitstart', 0 );
		$limit = JRequest::getVar ( 'limit', 10 );
		$helper = new JACommentHelpers ( );
		$currentUserInfo = JFactory::getUser();
		
        $search = '';
        $searchComponent = JRequest::getVar( 'optionsearch', '' );
		if($searchComponent) $search .= " AND `option` = '" . $searchComponent . "'";
        
        $searchSource = JRequest::getVar( 'sourcesearch', '' );
        if($searchSource) $search .= " AND `source` = '" . $searchSource . "'";
        
		$reported = JRequest::getInt('reported', 0);
		if($reported==1){                
			$search .= " AND report > 0";
		}
		
		$keyword = JRequest::getVar ( 'keyword' );
        if($keyword || $reported){
            $search .= " AND (c.email LIKE '%".$keyword."%' OR c.id LIKE '%".$keyword."%' OR c.contenttitle LIKE '%".$keyword."%' OR c.name LIKE '%".$keyword."%' OR c.comment LIKE '%".$keyword."%')";
			$model = & $this->getModel ();
            $model->builQueryWhenSearch($search);   
        }
        					
		$k = 0;
		$object = array ();
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#jav-mainbox-".$currentTypeID;
		$object [$k]->type = 'html';		
		//get Item have type
		if($currentTypeID != 99)
        	$search = " AND type = $currentTypeID"; 							
		$object [$k]->content = $this->loadContentChangeData($search, $currentTypeID, $limit, $limitstart, 'changetype');		
		
		$k++;
						
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#expandOrCollapse".$currentTypeID;
		$object [$k]->type = 'html';
		$statusAll = JRequest::getVar ( 'hidAllStatus'.$currentTypeID, 0 ) ;
		if($statusAll == 1){
			$object [$k]->content = JText::_("_COLLAPSE_ALL_COMMENTS");					
		}else{
			$object [$k]->content = JText::_("_EXPAND_ALL_COMMENTS");
		}
		$k++;
		
		$object [$k] = new stdClass ( );
		$object [$k]->id = "#hidAllStatus".$currentTypeID;
		$object [$k]->type = 'value';
		$statusAll = JRequest::getVar ( 'hidAllStatus'.$currentTypeID, 0 ) ;
		if($statusAll == 1){
			$object [$k]->content = 1;					
		}else if($statusAll == 0){
			$object [$k]->content = 0;
		}else{
			$object [$k]->content = 2;
		}
		$k++;
		
		//jav-page-links-0
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jav-pagination-'.$currentTypeID;
		$object [$k]->attr = 'html';		
		$pagination = &$model->getPagination($limitstart, $limit, 'jav-pagination-'.$currentTypeID);		
		$lists['limitstart'] = $limitstart;
		$lists['limit'] = $limit;
		$lists['order'] = "";		        	
       	$this->assignRef('lists', $lists);       	
       	$this->assignRef('pagination', $pagination);       			
		$object [$k]->content = $this->loadTemplate('paging');				
		$k++;							
								
		echo $helper->parse_JSON_new ( $object );
		exit ();				
	}
	
	/*
	 * peform when user start page
	 */
	function displayItems() {		
		global $jacconfig;
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$task = JRequest::getCmd('task');				
		$model = & $this->getModel ();				
				
		if($task == 'edit'){
			$cid = JRequest::getVar( 'cid', array(0), '', '' );			
			$item = $model->getItem ($cid[0]);						
			$this->assign ( 'item', $item );
		}		
		else{
			$limit = JRequest::getVar ( 'limit', 10 );
			$limitstart = JRequest::getVar ( 'limitstart', 0 );
			$search = '';
			
			$searchComponent = JRequest::getVar( 'optionsearch', '' );
			if($searchComponent) $search .= " AND `option` = '" . $searchComponent . "'";
            $listSearchSources = $model->getCommentSource();						

			$searchSource = JRequest::getVar( 'sourcesearch', '' );
            if($searchSource != "")
            	$search .= " AND `source` = '" . $searchSource . "'";
            $listSearchOptions = $model->getCommentOption();
            
			                        
            $reported = JRequest::getInt('reported', 0);
            if($reported==1){                
                $search .= " AND report > 0";
            }                                    
			
            $keyword = JRequest::getVar ( 'keyword' );            
            if($keyword || $reported){            	
               	$search .= " AND (c.email LIKE '%".$keyword."%' OR c.id LIKE '%".$keyword."%' OR c.contenttitle LIKE '%".$keyword."%' OR c.name LIKE '%".$keyword."%' OR c.comment LIKE '%".$keyword."%')";
               	$model->builQueryWhenSearch($search);   
            }			                        			                        
            
            $totalType = $model->getTotalByType($search);
            if($totalType)            
            	$totalAll         	= (int)array_sum($totalType);
            else 
            	$totalAll         	= 0;
            	
            $totalUnApproved 	= (int)$totalType[0];
            $totalApproved     	= (int)$totalType[1];
            $totalSpam         	= (int)$totalType[2];            		        	                                 
            
			$items = $this->builtTreeComment($search);						
			
			$session = &JFactory::getSession();
			$jaActiveComments = $session->get("jaActiveComments");
			if($jaActiveComments)
				$session->clear("jaActiveComments");
			
			$lists['search'] = '';						
			$lists['limitstart'] = $limitstart;
			$lists['limit'] = $limit;			
			$lists['order'] = "";					        
	       	$this->assignRef('lists', $lists);      
	      	
			$this->assign ( 'keyword', $keyword );
            $this->assign ( 'reported', $reported );
			$this->assign ( 'searchComponent', $searchComponent );
            $this->assign ( 'searchSource', $searchSource );
            $this->assign ( 'totalAll', $totalAll );
			$this->assign ( 'totalApproved', $totalApproved );
			$this->assign ( 'totalSpam', $totalSpam );
			$this->assign ( 'totalUnApproved', $totalUnApproved );		
			$this->assign ( 'items', $items );
			
			$this->assign ( 'listSearchOptions', $listSearchOptions );
            $this->assign ( 'listSearchSources', $listSearchSources );
			
			$this->assign ( 'codeApproved', '1');
			$this->assign ( 'codeUnApproved', '0');
			$this->assign ( 'codeSpam', '2');
			
			//display item by paging
			$count = ($lists['limit']<count($items))?$lists['limit']:count($items);			
			$this->assignRef('count_items',$count);		
			$this->assign ( 'currentTypeID', 99 );	
		}	
	}		
	
	/*
	 * get text type of comment
	 */
	function getTextTypeOfComment($commentType) {
		if ($commentType == 1){			
			return JText::_("APPROVED");
		}else if($commentType == 0){
			return JText::_("UNAPPROVED");
		}
		else
			return JText::_("SPAM");
	}
		
	/*
	 * paging page
	 */	
	function getPaging($type_id){
		$model = $this->getModel();	
                
		$limitstart = JRequest::getVar ( 'limitstart', '' );		
		$limit = JRequest::getVar ( 'limit', '' );
					
        $keyword = JRequest::getVar ( 'keyword');

        if(!$limitstart) JRequest::setVar('limitstart', '0');
        if(!$limit) JRequest::setVar('limit', '0');
        if(!$keyword) JRequest::setVar('keyword', '');
        
       
        $link = '';
        if($keyword) $link = "index.php?keyword=".$keyword;
        
		if($limit == ''){   			
			$lists = $model->_getVars();		
       		$pagination = &$model->getPagination($lists['limitstart'], $lists['limit'], 'jav-pagination-'.$type_id, $link);       	        	
       		$this->assignRef('lists', $lists);
       		$this->assignRef('pagination', $pagination);	
		}else{			
			$lists['limitstart'] = $limitstart;
			$lists['limit'] = $limit;	
			$lists['order'] = '';	
			
       		$pagination = &$model->getPagination($limitstart, $limit, 'jav-pagination-'.$type_id, $link);       		       		
       		
       		$this->assignRef('lists', $lists);
       		$this->assignRef('pagination', $pagination);	
		}						

		//print_r($pagination);die();
       	return $this->loadTemplate('paging');
	}
	
	function getListLimit($limitstart, $limit, $order=''){		
    	$array = array(5, 10, 15, 20, 50, 100);
    	$list_html = array();
    	foreach ($array as $value){
    		$list_html[] = JHTML::_('select.option', $value, $value);  
    	}
    	//limitstart, limit, order
    	$onchange = "$limitstart, $limit, '$order'";
    	$keyword = JRequest::getVar('keyword');
    	$listID = "list";    	
    	$currentTypeID = JRequest::getVar ( 'curenttypeid', '99' );
    	$listID .= $currentTypeID;    	
    	$list_html = JHTML::_('select.genericlist',   $list_html, $listID, ' onchange="jac_doPaging('.$limitstart.', this.value, \''.$order.'\', \''.$keyword.'\')"', 'value', 'text', $limit);
    	
    	return $list_html;
    }
    
    /*
     * perform when user click page number, list limit or search comment
     */
    function pagingData(){
    	$model = & $this->getModel ();		
		$currentTypeID = JRequest::getVar ( 'curenttypeid', '99' );
		$limitstart = JRequest::getVar ( 'limitstart', '0' );		
		$limit = JRequest::getVar ( 'limit', '10' );										
		
        $search = '';
        $searchComponent = JRequest::getVar( 'optionsearch', '' );
		if($searchComponent) $search .= " AND `option` = '" . $searchComponent . "'";
        
        $searchSource = JRequest::getVar( 'sourcesearch', '' );
        if($searchSource) $search .= " AND `source` = '" . $searchSource . "'";
		
        $reported = JRequest::getInt('reported', 0);
		if($reported==1){                
			$search .= " AND report > 0";
		}
		            
        $keyword = JRequest::getVar ( 'keyword' );
    	if($currentTypeID != 99)            
        	$search .= " AND type = $currentTypeID";        
        if($keyword || $reported){
            $search .= " AND (c.email LIKE '%".$keyword."%' OR c.id LIKE '%".$keyword."%' OR c.contenttitle LIKE '%".$keyword."%' OR c.name LIKE '%".$keyword."%' OR c.comment LIKE '%".$keyword."%')";
            $model->builQueryWhenSearch($search);   
        }
        
		$object = array ();
		$k = 0;
				
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jav-mainbox-' . $currentTypeID;
		$object [$k]->attr = 'html';				
		$object [$k]->content = $this->loadContentChangeData($search, $currentTypeID, $limit, $limitstart, 'paging');
		$k++;
				
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#limitstart' . $currentTypeID;
		$object [$k]->attr = 'value';				
		$object [$k]->content = $limitstart;		
		
		$helper = new JACommentHelpers ( );
		
		echo $helper->parse_JSON_new ( $object );
		exit ();
    }
    
    /**
	 * Built tree
	 * */
	
	function builtTreeComment($search, $currentTypeID=99, $orderBy =''){
  		// get data items
        $model = $this->getModel();        
        
        $searchAll = '';   			 
      	//get all items of tab
      	
      	$searchComponent = JRequest::getVar( "optionsearch", '' );  
      	if($searchComponent) $searchAll .= " AND `option` = '" . $searchComponent . "'";
        
        $searchSource = JRequest::getVar( 'sourcesearch', '' );        
        if($searchSource) $searchAll .= " AND `source` = '" . $searchSource . "'";
		
        $items = array();
        if($currentTypeID == 99)
       		$items = $model->getItems($searchAll,$orderBy,1);       	 		
       	
       	//get array item search
       	//if ($search){
       		if($currentTypeID <> 99) 
				$search_rows = $model->getItems($search, $orderBy, 1);
			else
				$search_rows = $model->getItems($search, $orderBy);             			  	
       	//}		       	
       	
        $children = array();
		// first pass - collect children
		$list 		= array();
		$listSearch = array(); 
		if($items){			
			foreach ($items as $v )
			{
				$pt = $v->parentid;			
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;			
			}	
									
			$list = $this->treerecurse(0, '', array(), $children );						
			
			if($list){
				foreach ($list as $i => $item) {
					$treename = $item->treename;			
					$treename = JFilterOutput::ampReplace($treename);
					$treename = str_replace('"', '&quot;', $treename);
					if($item->id == 0)
						$list[$i]->treename = $treename;
					else 	
						$list[$i]->treename = $treename;
				}
			}
		}
				
		//if ($search) {	
			if($currentTypeID == 99){		
			$list1 = array();
				if($search_rows){					
					//group search rows
					$childrenSearch = array();
					foreach ($search_rows as $v ){
						$pt = $v->parentid;			
						$listSearch = @$childrenSearch[$pt] ? $childrenSearch[$pt] : array();
						array_push( $listSearch, $v );
						$childrenSearch[$pt] = $listSearch;			
					}	
										
					$listSearch = $this->treerecurse(0, '', array(), $childrenSearch );
					
					//print_r($listSearch);die();
					
					foreach ($listSearch as $srow )
					{
						foreach ($list as $item)
						{
							if ($item->id == $srow->id) {
								$list1[] = $item;
							}
						}
					}
				}
				// replace full list with found items
				$list = $list1;
			}else{
				$list = $search_rows;
			}
		//}				
		return $list;
  	}      	  	  	
  	
	function treerecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 )
	{
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v->id;
				$txt = "";
				if ( $type ) {				
					$pre 	= '|_&nbsp;';
					$spacer = '';
					if($level >0)					
						$spacer = '.';
				} else {					
					$pre 	= '- ';
					$spacer = '&nbsp;&nbsp;';
				}

				if ( $v->parentid != 0 ) {
					$txt 	= $pre;					
				}
											
				$pt = $v->parentid;
				$list[$id] = $v;
				
				$list[$id]->treename = "$indent$txt";				
				$list[$id]->children = count( @$children[$id] );
				$list[$id]->level 	 = $level + 1;
				$list = $this->treeRecurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
			}
		}			
		return $list;
	}
	
	function &_getViewLists()
	{
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$db		=& JFactory::getDBO();

		$option_1 = $option.'.jacategories';
		$app = JFactory::getApplication('administrator');
		
  		$lists['limitstart'] 	= $app->getUserStateFromRequest( "$option_1.limitstart", 'limitstart', 	0 );
  		$lists['limit'] 		= $app->getUserStateFromRequest( "$option_1.limit", 'limit', 	20 );
  		$filter_order		    = $app->getUserStateFromRequest( "$option_1.filter_order",		'filter_order',		's.ordering',	'cmd' );
		$filter_order_Dir		= $app->getUserStateFromRequest( "$option_1.filter_order_Dir",	'filter_order_Dir',	'ASC',			'word' );
		$filter_state			= $app->getUserStateFromRequest( "$option_1.filter_state",		'filter_state',		'',				'word' );
		$search					= $app->getUserStateFromRequest( "$option_1.search",			'search',			'',				'string' );
		$search					= JString::strtolower( $search );		

		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		
		$lists['option']	= $option;

		// search filter
		$lists['search']= $search;

		return $lists;
	}
 // ++ add by congtq 26/11/2009     
    function showYouTube(){
        $cid = JRequest::getVar( 'cid', '' );
        $id = $cid[0]?$cid[0]:'';
        $this->assign ("id", $id);        
    }
    
    function showYouTubeLink($id){
        $document =& JFactory::getDocument();
                            
        $document->addScriptDeclaration("jQuery(document).ready( function() { 
                                            jQuery('#".$id."').append('&nbsp;<a href=\"javascript:open_embed();\" class=\"plugin\"><img title=\"Add a YouTube Video\" alt=\"YouTube\" src=\"http://www.youtube.com/favicon.ico\"> <span>".JText::_("EMBED_VIDEO")."<\/span><\/a>');
                                            
                                        });");
                                        
        $document->addScriptDeclaration("function open_embed(){
                                            jaCreatForm('open_youtube',0,340,300,0,0,'".JText::_("EMBED_A_YOUTUBE_VIDEO")."',0,'".JText::_("EMBED_VIDEO")."');
                                        }");                                                        
    }
    
    function showAfterDeadLineLink($id){
        $document =& JFactory::getDocument();        
        if(!defined('JACOMMENT_PLUGIN_ATD')){        	
            JHTML::stylesheet('atd.css', JURI::root().'components/com_jacomment/asset/css/');            
            JHTML::script('jquery.atd.js', JURI::root().'components/com_jacomment/libs/js/atd/');
            JHTML::script('csshttprequest.js', JURI::root().'components/com_jacomment/libs/js/atd/');
            JHTML::_('script', 'atd.js',JURI::root().'components/com_jacomment/libs/js/atd/');                                                              
            define('JACOMMENT_PLUGIN_ATD', true);            
        }

        $document->addScriptDeclaration("jQuery(document).ready( function() { 
                                            jQuery('#".$id."').append('&nbsp;<a href=\"javascript:jac_check_atd(\'\')\"><img title=\"Proofread Comment w/ After the Deadline\" alt=\"AtD\" src=\"http://www.polishmywriting.com/atd_jquery/images/atdbuttontr.gif\"> <span id=\"checkLink\">". JText::_("CHECK_SPELLING") ."<\/span><\/a>');
                                        });");
                                   
    }
    // -- add by congtq 26/11/2009
    
    function showSmileys($id, $cid){
        //$cid = '';
        $cid = $cid?$cid:'';
//        if($cid){
//            $func = 'jacInsertSmileyEdit';
//        }else{
            $func = 'jacInsertSmiley';
//        }
        
        $this->assign ("func", $func); 
        $this->assign ("cid", $cid); 
        
        return $this->loadTemplate('smiley');
    }
    
    function showParamsUser($userid){
        require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'users.php'); 
        $modelusers = new JACommentModelUsers();
        $paramsUsers = $modelusers->getParam ($userid);                             

        return $paramsUsers;
    }

    function showBBCode(){
    	$this->assign("textAreaID","newcomment");        
        return $this->loadTemplate('bbcode');
    }
    
	function checkUserId($userID, $commentID){
		$model = $this->getModel();
		return $model->checkUserId($userID, $commentID);		
	}
}
?>