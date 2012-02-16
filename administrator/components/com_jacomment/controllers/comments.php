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
defined('_JEXEC') or die('Restricted access');

class jacommentControllercomments extends JACommentController
{
	
	function __construct( $default = array() )
	{
		parent::__construct( $default );
		// Register Extra tasks
		JRequest::setVar('view','comments');
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'lock', 'lock' );
        $this->registerTask( 'savereply', 'saveReply' );
	}
	
	function display(){	    	
		$user = JFactory::getUser();
		if ($user->id==0)
		{
			JError::raiseWarning(1001,JText::_("YOU_MUST_BE_SIGNED_IN"));
			$this->setRedirect(JRoute::_("index.php?option=com_user&view=login"));
			return ;
		}	        
		parent::display();
	} 
	
	function edit(){
	
		JRequest::setVar('edit', true);    	
		JRequest::setVar('layout','form');        
		parent::display();    	
	} 
	
	function cancel(){
		$this->setRedirect('index.php?option=com_jacomment&view=comments');
		return TRUE; 	  
	}    
	
	function save(&$errors){		
        $task = $this->getTask ();
		$model=& $this->getModel('comments');
		//$item = $model->getItem();
		$row =& JTable::getInstance('comments', 'Table');
       // if (!$row->bind(JRequest::get('post')))
		$post    = JRequest::get('request');
		
		if (!$row->bind( $post )) 
		{
			$errors[]=JText::_("DO_NOT_BIND_DATA");
		
		}  
		if($errors)
		{
			return FALSE;
		}
		$row->title = trim($row->title);
		$errors=$row->check();
		
		if (count($errors)>0)
		{	    	   	
			return FALSE;
		}	 
		$where = " AND c.title = '$row->title' AND c.id!=$row->id";
		$count = $model->getTotal($where);
		if($count>0){
			$errors[] = JText::_( "ERROR DUPLICATE FOR COMMENT TITLE" );
			return FALSE;
		}		

		if (!$item->store())
		{	    	
			$errors[]=JText::_("ERROR_DATA_NOT_SAVED");
			return FALSE;
		}
				
		return $item->id;
    }
    
	function displayInform($error, &$k, &$object){
		$message = '<script type="text/javascript">displaymessageadmin();</script>';
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jac-msg-succesfull';
		$object [$k]->type = 'html';
		$object [$k]->content = $error . $message;
		$k ++;
	}
    
	function uploadFileReply(){
		global $jacconfig;
		$helper = new JACommentHelpers ( );
		$maxSize = (int)$helper->getSizeUploadFile("byte");				
		if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['size']>0 && $_FILES['myfile']['size']<= $maxSize && $_FILES['myfile']['tmp_name']!=''){																										
			jimport( 'joomla.filesystem.folder' );						
									
			if(!isset($_SESSION['countreply'])) $_SESSION['countreply'] = 0;
			
			$fileexist = 0;    
			$img = ''; $link = '';
			
			// Edit upload location here
			
			$fname = basename($_FILES['myfile']['name']);
			$fname = strtolower(str_replace(' ', '', $fname));
			$folder = time().rand().DIRECTORY_SEPARATOR;			 						
			//$folder = JPATH_ROOT.DS."images".DS."stories".DS."ja_comment";						
			
			if(!isset($_SESSION['nameFolderreply'])) $_SESSION['nameFolderreply'] = $folder;
		   	else $folder = $_SESSION['nameFolderreply'];
		   	
			$destination_path = JPATH_ROOT.DS."tmp".DS."ja_comments".DS.$folder;
			
		  	if (!isset($_SESSION['tempreply'])) {
		   		$_SESSION['tempreply'] = $destination_path;
		   	}
						   	
		   	$target_path = $destination_path . '/'.$fname;
		   			   	
		   	if (!is_dir($destination_path)){
		   		JFolder::create($destination_path);		   		   				   				   		
		    }
		    $id = JRequest::getInt("id", 0);
			$listFiles 		= JRequest::getVar("listfile");			
			if (count($listFiles)<$jacconfig['comments']->get("total_attach_file")) {				
				//rebuilt listfile					
				foreach ($listFiles as $listFile){												
					$type = substr(strtolower(trim($listFile)), -3, 3);
					if($type=='ocx'){
					 	$type = "doc";
					}				
					$_SESSION['jaccountedit'] += 1;										 
					$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFile' checked></span>&nbsp;&nbsp;<img src='../components/com_jacomment/themes/default/images/". $type .".gif' alt='". $type ."' /> " .$listFile . "</div>"; 				
				}
				//load file uncheck
				$listFilesInFolders  = JFolder::files($destination_path);					
				foreach ($listFilesInFolders as $listFilesInFolder){
					if(!in_array($listFilesInFolder, $listFiles)){
						$type = substr(strtolower(trim($listFilesInFolder)), -3, 3);
						if($type=='ocx'){
						 	$type = "doc";
						}							
						$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFilesInFolder' disabled='disabled'></span>&nbsp;&nbsp;<img src='../components/com_jacomment/themes/default/images/". $type .".gif' alt='". $type ."' /> " .$listFilesInFolder . "</div>";
					}
				}
				$listFilesInFolders  = JFolder::files(JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id);					
				foreach ($listFilesInFolders as $listFilesInFolder){
					if(!in_array($listFilesInFolder, $listFiles)){
						$type = substr(strtolower(trim($listFilesInFolder)), -3, 3);
						if($type=='ocx'){
						 	$type = "doc";
						}							
						$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFilesInFolder' disabled='disabled'></span>&nbsp;&nbsp;<img src='../components/com_jacomment/themes/default/images/". $type .".gif' alt='". $type ."' /> " .$listFilesInFolder . "</div>";
					}
				}
				
				if(file_exists($target_path) || file_exists(JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id.DS.$fname)){
						$fileexist = 1;
				}
				elseif(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)){
			   		 $_SESSION['countreply'] += 1;	   			   		 
			   		 $type = substr(strtolower(trim($_FILES['myfile']['name'])), -3, 3);
			   		 	   		 
					 if($type=='ocx'){
					 	$type = "doc";
					 }			
					 $img .= "<input type='checkbox' name='listfile[]' value='$fname' checked>&nbsp;&nbsp;<img src='../components/com_jacomment/themes/default/images/". $type .".gif' /> " .$fname . "<br />";
			   }
			}
			
			echo '<script language="javascript" type="text/javascript">
	   		var par = window.parent.document;		
			function stopUpload(par, listfile, count, totalUpload){					  		  
					  par.getElementById(\'err_myfile_reply\').innerHTML = "";   			  					  
					  par.formreply.target = "_self";
					  
					  par.getElementById(\'upload_process_1_reply\').style.display=\'none\';
					  par.getElementById(\'result_upload_reply\').innerHTML = listfile;
					  par.formreply.myfile.value = "";
					  if(eval(count)>=totalUpload){
					  		if(1<=totalUpload){
					  			par.formreply.myfile.disabled = true;
								par.getElementById(\'err_myfile_reply\').innerHTML = "'. JText::_("YOU_ADDED").'" + totalUpload + " '. JText::_("FILE").'!";
					  		}else{						  		
					  			par.formreply.myfile.disabled = true;
								par.getElementById(\'err_myfile_reply\').innerHTML = "'. JText::_("YOU_ADDED").'" + totalUpload + " '. JText::_("FILES").'!";
							}  																
					  }					  
					  return true;   
			}</script>';
								   			 
			if($fileexist){				
				echo '<script language="javascript" type="text/javascript">								
						var par = window.parent.document;													
						par.getElementById(\'err_myfile_reply\').innerHTML = "<span class=\'err\' style=\'color:red\'>'. JText::_("THIS_FILE_EXISTED") .'</span>";									
						par.getElementById("upload_process_1_reply").style.display="none";
					  </script>';														
			}else{
				echo '<script language="javascript" type="text/javascript">stopUpload(par, "'.$img.'", '.$_SESSION['countreply'].', '.$jacconfig['comments']->get("total_attach_file").')</script>';			
			}
		}elseif (isset($_FILES['myfile']['name'])){
			echo '<script type="text/javascript">					
					var par = window.parent.document;
					var content = "";
					if(document.body){
						document.body.innerHTML = "";
					}		
					par.getElementById(\'upload_process_1_reply\').style.display=\'none\';
					par.formreply.myfile.value = "";
					par.getElementById(\'err_myfile_reply\').innerHTML = "'. JText::_("LIMITATION_OF_UPLOAD_IS").$helper->getSizeUploadFile().'.";  		
					par.formreply.myfile.focus();					
				</script>';
		}
	}		
	
	function cancelUploadComment(){
		jimport( 'joomla.filesystem.folder' );		
    	if(isset($_SESSION['tempreply'])){
    		JFolder::delete($_SESSION['tempreply']);
    		unset($_SESSION['tempreply']);
    	}
		if(isset($_SESSION['temp'])){
    		JFolder::delete($_SESSION['tempreply']);
    		unset($_SESSION['temp']);
    	}
    }
	
	function resultReplyComment($currentTypeID, $commentID, $comment, $strUser, $strEmail, $userID){
		$helper = new JACommentHelpers();
		$avatar = $helper->getAvatar($userID);		           		
		$strResult  = '<div class="expand-content-comment subComment" style="clear: both">';
		if(is_array($avatar)){
			$strResult  = '<img alt="" src="'. $avatar[0] .'" style="float: left;margin-right: 10px;'. $avatar[1] .'" />';
		}
						
		$strResult  = '    <div class="span-content-comment"><i>' . $strUser . '</i></div>
						<div class="span-content-comment">'. $comment .'</div></div>';
		$strResult .= '<div id="jac-attach-file-'.$currentTypeID.'-'.$commentID.'" class="list-attach-file"></div>'; 
		
		return $strResult;	
	}
	
	function saveComment(){				
		global $jacconfig;					
		$helper = new JACommentHelpers ( );	
		$model = & $this->getModel ('comments');				
		$parentID = JRequest::getInt('parentid',0);		
		if($parentID){
			$currentUserInfo 	= JFactory::getUser ();
        	$post["parentid"]	= $parentID;
        	$post["type"]		= 1;
        	$post['ip']  		= $_SERVER ["REMOTE_ADDR"];
        	$post['date']  	 	= date("Y-m-d H:i:s");        	
			$post['userid'] 	= $currentUserInfo -> id;
			$post['name']    	= $currentUserInfo -> name;
			$post['email']   	= $currentUserInfo -> email;
			$post['voted']   	= 1;
			$post['date_active']= date("Y-m-d H:i:s");
			
			$parentInfo 		= $model->getItem($parentID);						
			$post['contentid']  = $parentInfo->contentid;
			$post['option']  	= $parentInfo->option;
			$commentUrl 		= str_replace("#jacommentid:".$parentID,"", $parentInfo->referer);
			$post['referer']  	= $commentUrl;																									
		}else{
			$post["id"]	= JRequest::getInt('id',0);        
		}
		$post["comment"] = JRequest::getVar('newcomment','','','', JREQUEST_ALLOWHTML);
		$post["comment"]    = $helper->removeEmptyBBCode($post["comment"]);
		$lengthOfComment = $helper->getRealLengthOfComment($post["comment"]);
							
		if(JRequest::getVar('subscription_type',' ') != ""){
			$post["subscription_type"]		= JRequest::getVar('subscription_type',0);	
		}
		$currentTypeID 			= JRequest::getInt('curenttypeid',0);
		        
        jimport( 'joomla.filesystem.folder' );
        jimport( 'joomla.filesystem.file' );
        $object = array ();
        $k = 0;                
        
		$validateData = 1;
        if($post["comment"] == "" || $lengthOfComment == 0){
			$this->displayInform(JText::_( "You must input your comment" ), $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment < $jacconfig['spamfilters']->get("min_length", 0)){
			$this->displayInform(JText::_( "Your comment is too short" ), $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment > $jacconfig['spamfilters']->get("max_length", 500)){						
			$this->displayInform(JText::_( "Your comment is too long" ), $k, $object);
			$validateData = 0;									    					
		}else{				
			//check link in comment
			if($model->checkMaxLink($post['comment'], $jacconfig['spamfilters']->get("number_of_links", 5))){
				$this->displayInform(JText::_( "Number of links in the comment exceed its maximum" ), $k, $object);
				$validateData = 0;														
			}
		}
		
		if($validateData){			
			//replace censored words
			$post['comment'] = $model->checkCensoredWord($post['comment'], $jacconfig['spamfilters']->get("censored_words",""), $jacconfig['spamfilters']->get("censored_words_replace",""));			
			$currentTypeID = JRequest::getVar ( 'curenttypeid', 99 );
			$model=& $this->getModel('comments');
			             			
			$commentID = $model ->store($post);
					 
			if($commentID){							
				$post['comment'] = $helper ->replaceBBCodeToHTML($post['comment']);
				$post['comment'] = html_entity_decode($helper->showComment($post['comment']));
								
				if($parentID){
					$post['referer'] = $post['referer']."#jacommentid:".$commentID;								
					$model->updateUrl($commentID, $post['referer']);
					$message = '<script type="text/javascript">successWhenReply();</script>';									
				}else{
					$message = '<script type="text/javascript">successWhenEdit();</script>';	
				}				
				$this->displayInform(JText::_( "Save data successfully" ).$message, $k , $object);
				
			if($jacconfig['comments']->get("is_attach_image", 0)){
				//delete file in store image if remove file
				$listFile = JRequest::getVar('listfile', 0);
				
				$file_path 			 =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$commentID;
				
				$listFileOfComments  =  JFolder::files($file_path);															
				$stringAttach = "";
				
				if($listFileOfComments){
					foreach ($listFileOfComments as $listFileOfComment){
						if($listFile){
							if(!in_array($listFileOfComment, $listFile)){
								JFile::delete($file_path.DS.$listFileOfComment);									
							}
						}else{	
							JFile::delete($file_path.DS.$listFileOfComment);															
						}
					}
				}
										
				if($listFile){
					if(isset($_SESSION['tempreply'])){						
						$listFileTemp = JFolder::files($_SESSION['tempreply']);									
						if ($listFileTemp) {
							foreach ($listFileTemp as $file){
								if (!in_array($file, $listFile, true)) {
									JFile::delete($_SESSION['tempreply'].DS.$file);									
								}
							}
						}									
						JRequest::setVar("listfile", implode(',', $listFile));									
														
						//move file
						$target_path =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$commentID;																
						
						if (!is_dir($target_path)){
							JFolder::create($target_path);					   		
					    }							   
					    
					    if ($listFileTemp) {
					       JFolder::copy($_SESSION['tempreply'], $target_path,'', true);	
					    }		 
					    
					    JFolder::delete($_SESSION['tempreply']);					   
					    
					    unset($_SESSION['countreply']);
					    unset($_SESSION['tempreply']);
					    unset($_SESSION['nameFolderreply']);						   						    																																																
						}											   							  
		 			}
		 									
					$listFileOfComments  = JFolder::files($file_path);				
					if($listFileOfComments){
						$theme = $jacconfig['layout']->get('theme', 'default');
						foreach ($listFileOfComments as $listFileOfComment){							
							$linkOfFile 	= "../index.php?tmpl=component&option=com_jacomment&view=comments&task=downloadfile&id=".$commentID."&filename=".$listFileOfComment;
							$type = substr(strtolower(trim($listFileOfComment)), -3, 3);
							$stringAttach 	.= "<a href='". JRoute::_($linkOfFile) ."'><img src='". JURI::root() ."components/com_jacomment/themes/default/images/". $type .".gif' />". $listFileOfComment ."</a><br>";							
						}
					}										
					
					$strTitle = "<div><span>".JText::_('LIST_ATTACH_FILE')."</span></div><div>";
					if($stringAttach!="") $stringAttach = $strTitle.$stringAttach."</div>";
					
					
					$object [$k] = new stdClass ( );
				    $object [$k]->id = '#jac-attach-file-'.$currentTypeID."-".$commentID;
				    $object [$k]->type = 'html';				
				    $object [$k]->content = $stringAttach;
				    $k++;												
				}								
				 
				//if reply a comment
				if($parentID){
					$modelLogs = & $this->getModel ( 'logs' );
					$postLogs ["userid"] 	   = $currentUserInfo->id;						
					$postLogs ["votes"]  	   = 1;												
					$postLogs ["itemid"]  	   = $commentID;						
					$postLogs ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];					
					if (! $modelLogs->store ( $postLogs )) {
						//$this->displayInform(JText::_( "ERROR DATA NOT SAVED" ), $k, $object);							
					} //if data binds is successful					
					
					$strUser  = $currentUserInfo->name. "(".$currentUserInfo->email.")";
					$strEmail = $currentUserInfo->email;
					 
					$object [$k] = new stdClass ( );
					$object [$k]->id 		= "#jac-result-reply-comment-" . $currentTypeID. "-"  . $parentID;
					$object [$k]->type 		= 'html';
					$object [$k]->content 	= $this->resultReplyComment($currentTypeID,$commentID,$post["comment"], $strUser, $strEmail, $currentUserInfo->id);
					$k ++;											

					//if enable send email - send mail					
					if($jacconfig['general']->get("is_enabled_email", 0)){								
						$wherejatotalcomment = " AND c.type=1 AND c.contentid=".$post['contentid']." AND c.option='". $post['option'] ."'";																																	
						$helper->sendAddNewMail ($commentID, $wherejatotalcomment, 'reply', $post);																																	
					}
					
					if(isset($stringAttach)){
						if($stringAttach){
							$object [$k] = new stdClass ( );
							$object [$k]->id 		= "#jac-attach-file-" . $currentTypeID. "-"  . $commentID;
							$object [$k]->type 		= 'html';
							$object [$k]->content 	= $stringAttach;
							$k ++;				
						}			
					}
					
				}
				//edit a comment
				else{											
					$object [$k] = new stdClass ( );
					$object [$k]->id 		= "#commentCollapse" . $currentTypeID. "_"  . $post["id"];
					$object [$k]->type 		= 'html';
					$object [$k]->content 	= $post["comment"];
					$k ++;
				    
					$object [$k] = new stdClass ( );
					$object [$k]->id 		= "#commentExpand" . $currentTypeID. "_"  . $post["id"];
					$object [$k]->type 		= 'html';
					$object [$k]->content 	= $post["comment"];
					$k ++;	
				}							    			   
			}else{
				$this->displayInform(JText::_( "Don't save data successfully" ), $k , $object);							
			}
		}
		
		echo $helper->parse_JSON_new ( $object );
		exit ();		
	}
		    
	function publish()
	{
		$model = $this->getModel('comments');
		if(!$model ->published(1))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} else {
			$msg = JText::_('SAVE_DATA_SUCCESSFULLY' );
		}
		$this->setRedirect('index.php?option=com_jacomment&view=comments',$msg);
	}
	
	function unpublish()
	{
		$model = $this->getModel('comments');
		if(!$model->published(0))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} 
		else 
		{
			$msg = JText::_('SAVE_DATA_SUCCESSFULLY' );
		}
		$this->setRedirect('index.php?option=com_jacomment&view=comments',$msg);
	}
	
	function lock()
	{
		$id = JRequest::getInt ( 'id' );
		$val = JRequest::getInt ( 'val' );
		
		$model = $this->getModel('comments');
		if(!$model ->locked($id, $val))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} else {
			$msg = JText::_('LOCK_DATA_SUCCESSFULLY' );
		}

		if($val){
			$img = 'lock.png';
			$val = '0';
			$title = 'Unlock Item';
		}else{
			$img = 'unlock.png';
			$val = '1';
			$title = 'Lock Item';
		}		
				
		$link = '<a href="javascript: void(0);" onclick="locked('.$id.', '.$val.');">'.JHTML::_('image', JURI::root().'administrator/components/com_jacomment/asset/images/'.$img.'', $title, 'title="'.$title.'"').'</a>';		
		echo $link;
		exit();
	}

	function remove(){
		$model = $this->getModel('comments');
		$errors=$model->remove();
		if($errors){
			foreach ($errors as $error)
				JError::raiseWarning(1001,$error);	
		}else 
			$msg=JText::_("DELETE_DATA_SUCCESSFULLY");
		$this->setRedirect('index.php?option=com_jacomment&view=comments',$msg);
	}
    
    function saveReply(){    	    
    	global $jacconfig;            
        $model=& $this->getModel('comments');
        
        $post    	    = JRequest::get('request');        
        $userInfo 		=  JFactory::getUser();
        $post["uid"] 	= $userInfo -> id;
        $post["name"] 	= $userInfo -> name;
        $post["email"] 	= $userInfo -> email;
                        
       	$parent = $model->getItemFrontEnd($post['parentid']);
        $post["contentid"] 	= $parent[0] -> contentid;
        $post["option"] 	= $parent[0] -> option;
        $post["ip"] 		= $_SERVER ["REMOTE_ADDR"];        
        $post["referer"] 	= $parent[0] -> referer;
        
        $commentID = $model ->store($post);        
        if($commentID){	            	
	       	//send mail when reply successfull
	       	$helper = new JACommentHelpers ( );	       	
	       	//if enable send email - send mail
			if($jacconfig["general"]->get("is_enabled_email", 0)){								
				$wherejatotalcomment = " AND c.type=1 AND c.contentid=".$post['contentid']." AND c.option='". $post['option'] ."'";																											
				$helper->sendAddNewMail ($commentID, $wherejatotalcomment, 'reply', $post);																																	
			}	        	        			        
			               	                     
            $strUser = $userInfo->name. "(".$userInfo->email.")";
            echo '<div class="subComment"><div>				  
				 	<img alt="" src="components/com_jacomment/asset/images/noavatar32.png" style="float: left;margin-right: 10px;">														
				 	<div class="span-content-comment"><i>' . $strUser . '</i></div>				 													
				 </div>';
            echo '<br><div style="clear:both;">' . trim($post['comment']). '</div></div>';
	                	
        }
        
        exit();
    }
	
    // ++ add by congtq 26/11/2009
    function open_youtube(){       	
        JRequest::setVar('layout','youtube');        
        parent::display();        
    } 
    
    function embed_youtube(){
        $helper = new JACommentHelpers ( );   
        
        $post             = JRequest::get('request');        
        $object = array ();
        $k = 0;
        
        if (! $helper->checkYoutubeLink($post['txtYouTubeUrl'])) {
        	$this->displayInform(JText::_("YOUTUBE_VIDEO_URL_IS_INCORRECT" ), $k, $object);            
        }else{
        	$this->displayInform(JText::_("VIDEO_IS_EMBED" ), $k, $object);            
            
            $k = 0;             
            $object [$k] = new stdClass ( );
            $object [$k]->id = '#newcomment';
            $object [$k]->type = 'append';
            $object [$k]->status = 'ok';
            $object [$k]->content = '[youtube '.$post['txtYouTubeUrl'].' youtube]';
            $k ++;
        }
        
        echo $helper->parse_JSON_new ( $object );
		exit ();        
    }
    // -- add by congtq 26/11/2009
    
}
?>