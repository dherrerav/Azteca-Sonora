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

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JACommentControllerComments extends JACommentController {
	
	function __construct($default = array()) {
		parent::__construct ( $default );
        
//        if(session_is_registered('session_auth')){
//            $session_auth = $_SESSION['session_auth'];
//        }else{
//            $session_auth['providerName'] = ''; 
//        }
        //$this->registerTask( 'button', 'getButton' );
        $this->registerTask( 'preview', 'previewItems' );
	
	}
    
    function previewItems(){
        JRequest::setVar( 'option', 'com_jacomment' );
        JRequest::setVar( 'view', 'comments' );
        JRequest::setVar( 'layout', 'default'  );
        parent::display();
        
    }
	
//	function getButton() {
//        JRequest::setVar( 'option', 'com_jacomment' );
//        JRequest::setVar( 'view', 'comments' );
//        JRequest::setVar( 'layout', 'button'  );
//        parent::display();
//        
//
//        //$links = JRequest::getVar('links');
//        //require(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'views'.DS.'comments'.DS.'tmpl'.DS.'getbutton.php');
//        //echo '<a class="jac_links" href="'.$links.'#jacomments" title="'.JText::_('ADD_A_JACOMMENT').'">'.JText::_('ADD_A_JACOMMENT').'</a>';
//	}
//    
//	function getList() {
//        require_once(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'views'.DS.'comments'.DS.'tmpl'.DS.'getlist.php');
//    }
	
	function edit(){	
		JRequest::setVar('edit', true);    	
		JRequest::setVar('layout','form');        
		parent::display();    	
	} 
	
	function cancel(){
		$this->setRedirect('index.php?option=com_jacomment&view=comments');
		return TRUE; 	  
	}  		
	
	function displaycaptchaaddnew(){
		global $jacconfig;
		$helper = new JACommentHelpers ( );
		
    	$captcha = new jacapcha();
    	
    	//custimize captcha image
    	require_once $helper->jaLoadBlock("captcha/captcha.php");
    	
    	$captcha->buildImage("addnew");    	    	
    	die();
    }
    function displaycaptchareply(){
    	$captcha = new jacapcha();
    	$captcha->buildImage("reply");    	    	
    	die();
    }
            
	function validatecaptchaaddnew($arg){
    	$captcha = new jacapcha();
		$captcha->text_entered = $arg;
	    $captcha->validateText("addnew");
        if($captcha->valid_text){
           return true; 
        }else{
           return false;
        }	
	}
	
    function validatecaptchareply($arg){
    	$captcha = new jacapcha();
		$captcha->text_entered = $arg;
	     $captcha->validateText("reply");
        if($captcha->valid_text){
           return true; 
        }else{
           return false;
        }	
	}			
	
	function downloadfile(){
		$commentID = JRequest::getVar("id", 0);
		$filename  = JRequest::getVar("filename", "");
		$dlfilename = 'images/stories/ja_comment/'.$commentID.'/'.$filename;
		if ($filename == ''){
			echo "<html><head><title>Downloads</title></head><body>".JText::_('DOWNLOAD_FILE_NOT_SPECIFIED')."</body></html>";
			exit;
		}
		else if (!file_exists($dlfilename)){
			echo "<html><head><title>Downloads</title></head><body>ERROR: File not found.<!--".$filename."--></body></html>";
			exit;
		}
		
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		
		switch ($file_extension){
			case "asf": $ctype="video/x-ms-asf"; break;
			case "avi": $ctype="video/avi"; break;
			case "doc": $ctype="application/msword"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "gif": $ctype="image/gif"; break;
			case "html": $ctype="text/html"; break;
			case "htm": $ctype="text/html"; break;
			case "jpeg": $ctype="image/jpg"; break;
			case "jpg": $ctype="image/jpg"; break;
			case "mp3": $ctype="audio/mpeg3"; break;
			case "pdf": $ctype="application/pdf"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "png": $ctype="image/png"; break;
			case "wav": $ctype="audio/wav"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "zip": $ctype="application/zip"; break;
			default: $ctype="application/force-download";
		}		
					

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $ctype; name=\"".basename($filename)."\";");
		// change, added quotes to allow spaces in filenames, by Rajkumar Singh
		header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($dlfilename));
		readfile("$dlfilename");
		exit();			
	}
	
	function cancelUploadComment(){			
    	if(isset($_SESSION['jactemp'])){
    		jimport( 'joomla.filesystem.folder' );
    		JFolder::delete($_SESSION['jactemp']);
    		unset($_SESSION['jaccount']);
		    unset($_SESSION['tempreply']);
		    unset($_SESSION['nameFolderreply']);
		    echo '<script language="javascript" type="text/javascript">alert("1");</script>';    		
    	}		
    }
	
    function showwebsiterules(){
    	global $jacconfig;    	
    	echo '<div class="jac-text-terms" id="jac-text-terms">'. $jacconfig['spamfilters']->get('terms_of_usage', 0) .'</div>';
    	exit();
    }
    
	function uploadFileEdit(){
		global $jacconfig;
		$app = JFactory::getApplication();							
		$helper = new JACommentHelpers ( );			
		$maxSize = (int)$helper->getSizeUploadFile("byte");	
		$theme   = $jacconfig["layout"]->get("theme", "default");
		$session = &JFactory::getSession();
		if(JRequest::getVar("jacomment_theme", '')){
			jimport( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar("jacomment_theme");
			if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
				$theme =  $themeURL;						
			}
			$session->set('jacomment_theme', $theme);			
		}else{
			if($session->get('jacomment_theme', null)){
				$theme = $session->get('jacomment_theme', theme);
			}
		}
							
		if (isset($_FILES['myfileedit']['name']) && $_FILES['myfileedit']['size']>0 && $_FILES['myfileedit']['size']<= $maxSize && $_FILES['myfileedit']['tmp_name']!=''){			
			if($this->checkFileUpload($_FILES, "edit")){					
				jimport( 'joomla.filesystem.folder' );									
				if(!isset($_SESSION['jaccountedit'])) $_SESSION['jaccountedit'] = 0;					
				$fileexist = 0;    
				$img = ''; $link = '';					
				// Edit upload location here
						
				$fname = basename($_FILES['myfileedit']['name']);
				$fname = strtolower(str_replace(' ', '', $fname));
				$folder = time().rand().DIRECTORY_SEPARATOR;			 						
				//$folder = JPATH_ROOT.DS."images".DS."stories".DS."ja_comment";						
				
				if(!isset($_SESSION['jacnameFolderedit'])) $_SESSION['jacnameFolderedit'] = $folder;
			   	else $folder = $_SESSION['jacnameFolderedit'];
			   	
				$destination_path = JPATH_ROOT.DS."tmp".DS."ja_comments".DS.$folder;
				
			  	if (!isset($_SESSION['jactempedit'])) {
			   		$_SESSION['jactempedit'] = $destination_path;
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
						$img .= "<div style='float: left; clear: both;'>
									<span>
										<input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFile' checked>
									</span>&nbsp;&nbsp;
									<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$listFile . "</div>"; 				
					}
					//load file uncheck
					$listFilesInFolders  = JFolder::files($destination_path);					
					foreach ($listFilesInFolders as $listFilesInFolder){
						if(!in_array($listFilesInFolder, $listFiles)){
							$type = substr(strtolower(trim($listFilesInFolder)), -3, 3);
							if($type=='ocx'){
							 	$type = "doc";
							}							
							$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFilesInFolder' disabled='disabled'></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$listFilesInFolder . "</div>";
						}
					}
					$listFilesInFolders  = JFolder::files(JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id);					
					foreach ($listFilesInFolders as $listFilesInFolder){
						if(!in_array($listFilesInFolder, $listFiles)){
							$type = substr(strtolower(trim($listFilesInFolder)), -3, 3);
							if($type=='ocx'){
							 	$type = "doc";
							}							
							$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$listFilesInFolder' disabled='disabled'></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$listFilesInFolder . "</div>";
						}
					}					
					
					if(file_exists($target_path) || file_exists(JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id.DS.$fname)){
						$fileexist = 1;
					}
					elseif(@move_uploaded_file($_FILES['myfileedit']['tmp_name'], $target_path)){
				   		 $_SESSION['jaccountedit'] += 1;	   			   		 
				   		 $type = substr(strtolower(trim($_FILES['myfileedit']['name'])), -3, 3);
				   		 	   		 
						 if($type=='ocx'){
						 	$type = "doc";
						 }			
						 $img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFileEdit()' name='listfile[]' value='$fname' checked></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/". $theme ."/images/". $type .".gif' alt='". $type ."' /> " .$fname . "</div>";
				   }
				}
						
				echo '<script language="javascript" type="text/javascript">
		   		var par = window.parent.document;		
				function stopUpload(par, listfile, count, totalUpload){					  		  
						  par.getElementById(\'err_myfileedit\').innerHTML = "";   			  					  
						  par.form1edit.target = "_self";
						  
						  par.getElementById(\'jac_upload_processedit\').style.display=\'none\';						  
						  par.getElementById(\'result_uploadedit\').innerHTML = listfile;
						  par.form1edit.myfileedit.value = "";
						  if(eval(count)>=totalUpload){
						  		if(1<=totalUpload){
						  			par.form1edit.myfileedit.disabled = true;
									par.getElementById(\'err_myfileedit\').innerHTML = "'. JText::_("YOU_ADDED").'" +" "+ totalUpload + " '. JText::_("FILE").'!";
						  		}else{						  		
						  			par.form1edit.myfileedit.disabled = true;
									par.getElementById(\'err_myfileedit\').innerHTML = "'. JText::_("YOU_ADDED").'" + " " + totalUpload + " '. JText::_("FILES").'!";
								}  																
						  }
						  return true;   
				}</script>';
				if($fileexist){				
					echo '<script language="javascript" type="text/javascript">								
							var par = window.parent.document;		
							par.getElementById(\'jac_upload_processedit\').style.display=\'none\';											
							par.getElementById(\'err_myfileedit\').innerHTML = "<span class=\'err\' style=\'color:red\'>'. JText::_("THIS_FILE_EXISTED") .'</span>";									
							par.getElementById("jac_upload_processedit").style.display="none";
						  </script>';														
				}else{
					echo '<script language="javascript" type="text/javascript">stopUpload(par, "'.$img.'", '.$_SESSION['jaccountedit'].', '.$jacconfig['comments']->get("total_attach_file").')</script>';								
				}			   						
			}else{
				$attachFileTypes	= $jacconfig['comments']->get('attach_file_type', "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");
				$strTypeFile = JText::_("SUPPORT_FILE_TYPE").": ".$attachFileTypes." ".JText::_("ONLY");
				echo '<script language="javascript" type="text/javascript">
							var par = window.parent.document;
							par.getElementById(\'err_myfileedit\').innerHTML = "<span class=\'err\' style=\'color:red\'>'. $strTypeFile .'</span>";
							par.getElementById("jac_upload_processedit").style.display="none";
						  </script>';	
				
				
			}						
		}else{
			echo '<script type="text/javascript">					
					var par = window.parent.document;
					var content = "";
					if(document.body){
						document.body.innerHTML = "";
					}		
					par.getElementById(\'jac_upload_processedit\').style.display=\'none\';
					par.form1edit.myfileedit.value = "";
					par.getElementById(\'err_myfileedit\').innerHTML = "'.JText::_("LIMITATION_OF_UPLOAD_IS")." ".$helper->getSizeUploadFile().'.";  		
					par.form1edit.myfileedit.focus();
					
				</script>';
		}
	}
	
	function checkFileUpload($file, $action = ''){
		global $jacconfig;
		if($action)
			$filename = strtolower(basename($file['myfileedit']['name']));
		else 
			$filename = strtolower(basename($file['myfile']['name']));
  		$ext = substr($filename, strrpos($filename, '.') + 1);
  		$attachFileTypes	= $jacconfig['comments']->get('attach_file_type', "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");
  		$attachFileTypes = explode(",", $attachFileTypes);
  			  		  		
  		if(in_array($ext, $attachFileTypes)){
  			return true;
  		}
  		
  		return false;
	}
	
	function uploadFile(){
		global $jacconfig;	
		$app = JFactory::getApplication();							
		$helper  = new JACommentHelpers ( );	
		$maxSize = (int)$helper->getSizeUploadFile("byte");		
		$theme   = $jacconfig["layout"]->get("theme", "default");
		$session = &JFactory::getSession();
		if(JRequest::getVar("jacomment_theme", '')){
			jimport( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar("jacomment_theme");
			if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
				$theme =  $themeURL;						
			}
			$session->set('jacomment_theme', $theme);			
		}else{
			if($session->get('jacomment_theme', null)){
				$theme = $session->get('jacomment_theme', $theme);
			}
		}
		//check is valid file type - size of file
		if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['size']>0 && $_FILES['myfile']['size']<= $maxSize && $_FILES['myfile']['tmp_name']!=''){						
			//check extension of file			
			if($this->checkFileUpload($_FILES)){
				jimport( 'joomla.filesystem.folder' );
				jimport('joomla.filesystem.file');																	
				$_SESSION['jaccount'] = 0;
				//echo '<script language="javascript" type="text/javascript">alert("000");</script>';											
				$fileexist = 0;    
				$img = ''; $link = '';
				
				// Edit upload location here
				
				$fname = basename($_FILES['myfile']['name']);
				$fname = strtolower(str_replace(' ', '', $fname));
				$folder = time().rand().DIRECTORY_SEPARATOR;			 						
				//$folder = JPATH_ROOT.DS."images".DS."stories".DS."ja_comment";						
				
				if(!isset($_SESSION['jacnameFolder'])) $_SESSION['jacnameFolder'] = $folder;
			   	else $folder = $_SESSION['jacnameFolder'];
			   	
				$destination_path = JPATH_ROOT.DS."tmp".DS."ja_comments".DS.$folder;
				
			  	if (!isset($_SESSION['jactemp'])) {
			   		$_SESSION['jactemp'] = $destination_path;
			   	}
							   	
			   	$target_path = $destination_path . '/'.$fname;
			   			   	
			   	if (!is_dir($destination_path)){		   		   				   					   		
			   		JFolder::create($destination_path);
			    }

			    //get array listfile and rebuilt
			    $listFiles 		= JRequest::getVar("listfile");
			    $numberOfFile 	= count($listFiles);			     			    			   
				if ($numberOfFile <$jacconfig['comments']->get("total_attach_file")) {
					//rebuilt listfile					
					foreach ($listFiles as $listFile){												
						$type = substr(strtolower(trim($listFile)), -3, 3);
						if($type=='ocx'){
						 	$type = "doc";
						}				
						$_SESSION['jaccount'] += 1;										 
						$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFile()' name='listfile[]' value='$listFile' checked></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$listFile . "</div>"; 				
					}
					//load file uncheck
					$listFilesInFolders  = JFolder::files($destination_path);					
					foreach ($listFilesInFolders as $listFilesInFolder){
						if(!in_array($listFilesInFolder, $listFiles)){
							$type = substr(strtolower(trim($listFilesInFolder)), -3, 3);
							if($type=='ocx'){
							 	$type = "doc";
							}							
							$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFile()' name='listfile[]' value='$listFilesInFolder' disabled='disabled'></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$listFilesInFolder . "</div>";
						}
					}
					
					if(file_exists($target_path) || in_array($fname, $listFiles)){
						$fileexist = 1;
					}
					elseif(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)){
				   		// $_SESSION['jaccount'] += 1;	  
				   		 $numberOfFile ++; 			   		 
				   		 $type = substr(strtolower(trim($_FILES['myfile']['name'])), -3, 3);
				   		 	   		 
						 if($type=='ocx'){
						 	$type = "doc";
						 }			
						$_SESSION['jaccount'] += 1;
						$img .= "<div style='float: left; clear: both;'><span><input type='checkbox' onclick='checkTotalFile()' name='listfile[]' value='$fname' checked></span>&nbsp;&nbsp;<img src='".JURI::root()."/components/com_jacomment/themes/" . $theme . "/images/". $type .".gif' alt='". $type ."' /> " .$fname . "</div>";
				   }
				}								
				
				echo '<script language="javascript" type="text/javascript">
		   		var par = window.parent.document;		
				function stopUpload(par, listfile, count, totalUpload){					  		  
						  par.getElementById(\'err_myfile\').innerHTML = "";   			  					  
						  par.form1.target = "_self";						 
						  par.getElementById(\'jac_upload_process\').style.display=\'none\';
						  par.getElementById(\'result_upload\').innerHTML = listfile;						   
						  par.form1.myfile.value = "";
						  if(eval(count)>=totalUpload){
						  		if(1<=totalUpload){
						  			par.form1.myfile.disabled = true;
									par.getElementById(\'err_myfile\').innerHTML = "'. JText::_("YOU_ADDED").'" +" "+ totalUpload + " '. JText::_("FILE").'!";
						  		}else{
						  			par.form1.myfile.disabled = true;
									par.getElementById(\'err_myfile\').innerHTML = "'. JText::_("YOU_ADDED").'" +" "+ totalUpload + " '. JText::_("FILES").'!";
						  		}
						  		  																
						  }						  		  						  						  						 
						  return true;   
				}</script>';
				
				if($fileexist){
					echo '<script language="javascript" type="text/javascript">							
							var par = window.parent.document;
							par.getElementById(\'jac_upload_process\').style.display=\'none\';
							par.getElementById(\'err_myfile\').innerHTML = "<span class=\'err\' style=\'color:red\'>'. JText::_("THIS_FILE_EXISTED") .'</span>";
							par.getElementById("jac_upload_process").style.display="none";
						  </script>';										
				}else{			   
					echo '<script language="javascript" type="text/javascript">stopUpload(par, "'.$img.'", '.$numberOfFile.', '.$jacconfig['comments']->get("total_attach_file").')</script>';
				}
				
			}
			//if extension don't valid
			else{
				$attachFileTypes	= $jacconfig['comments']->get('attach_file_type', "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");
				$strTypeFile = JText::_("SUPPORT_FILE_TYPE").": ".$attachFileTypes." ".JText::_("ONLY");
				echo '<script language="javascript" type="text/javascript">
							var par = window.parent.document;
							par.getElementById(\'err_myfile\').innerHTML = "<span class=\'err\' style=\'color:red\'>'. $strTypeFile .'</span>";
							par.getElementById("jac_upload_process").style.display="none";
						  </script>';								
			}																										
		}else{						
			echo '<script type="text/javascript">
					var par = window.parent.document;
					var content = "";					
					par.getElementById(\'jac_upload_process\').setStyle(\'display\',\'none\');
					par.form1.myfile.value = "";
					par.getElementById(\'err_myfile\').innerHTML = "'.JText::_("LIMITATION_OF_UPLOAD_IS").' '.$helper->getSizeUploadFile().'!";  		
					par.form1.myfile.focus();
					
				</script>';			
		}
	}
	
	function resultChangeType(&$k, &$object, $id, $action = ''){
		global $jacconfig;
		//disable button reply
		if($action == "delete"){
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-span-reply-'.$id;
			$object [$k]->type = 'html';						
			$object [$k]->content = "";
			$k++;
			
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-div-quote-'.$id;
			$object [$k]->type = 'html';						
			$object [$k]->content = "";
			$k++;			
		}
		//enable button reply
		else{
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-span-reply-'.$id;
			$object [$k]->type = 'html';						
			$object [$k]->content = '<a id="jac-a-reply-'.$id.'" href="javascript:replyComment('.$id.',\''.JText::_("POSTING").'\',\''.JText::_("REPLY").'\')" title="'.JText::_("REPLY_COMMENT").'"><span id="reply-'.$id.'">'.JText::_("REPLY").'</span></a>';			
			$k++;
			
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-div-quote-'.$id;
			$object [$k]->type = 'html';									
			$object [$k]->content = '<a id="jac-a-quote-'.$id.'" href="javascript:replyComment(\''.$id.'\',\''.JText::_("QUOTING").'\',\''.JText::_("QUOTE").'\',\'quote\')" title="'.JText::_("QUOTE_THIS_COMMENT_AND_REPLY").'"><span id="quote-'.$id.'">'.JText::_("QUOTE").'</span></a>';
			$k++;			
		}
	}
	
	function savetosession(){
		$id = JRequest::getInt("id", 0);
		if($id != 0){
			$session = &JFactory::getSession();
            // Put a value in a session var
            $session->set('jaCommentID', $id);
            //jac-lll	
            $jaCommentID = $session->get('jaCommentID');                       
			echo $jaCommentID;
			exit();
		}else{
			$session = &JFactory::getSession();
            // Put a value in a session var
            $session->set('jaCommentID', 0);            
            echo $session->get('jaCommentID', 0);
			exit();
		}
	}
	
	//buil action.
	function reBuildChangeType($type, $itemID, $isSpecialUser){		
		$outputHtml = "";
		$helper 	 = new JACommentHelpers();
		$isAllowEditComment  = 1;
		$parentType 	= 1;		
		$model 		 	= $this->getModel('comments');
		$parentType		= $model->getParentType($itemID);
			
		ob_start ();
		require $helper->jaLoadBlock("comments/actions.php");
		$content = ob_get_contents ();
		ob_end_clean ();
		
		return $content;
	}
	
	function changeCodeToClass($code){
		if($code == 1){ return "status-isapproved";
		}else if($code == 2){ return "status-isspam";}
		else{ return "status-isunapproved";}
	}
	
	function changeType(){
		global $jacconfig;		 			
		$helper 	 = new JACommentHelpers();
		$isSpecialUser = $helper->isSpecialUser();		
		$model 		 = $this->getModel('comments');  
		$id 	 	 = JRequest::getInt("id", 0);
		$type 		 = JRequest::getInt("type", 1);
		$currentType = JRequest::getInt("currenttype", 1);

		//check current user is special user
		if($isSpecialUser && $id){
			//change type of comment
			$model -> changeTypeOfComment($id,$type);	
						
			$document=& JFactory::getDocument();
			//get the view name from the query string
   			$viewName = JRequest::getVar('view', 'comments');
   			$viewType= $document->getType();
   			//get our view
			$view = &$this->getView($viewName, $viewType);				 
			//some error chec     
		    if (!JError::isError($model)){			
		    	$view->setModel ($model, true);
		    } 
			
			//get data
			$object = array ();
			$k = 0;
			
			$removeClass 	= $this->changeCodeToClass($currentType);
			$addClass 		= $this->changeCodeToClass($type);
			
			$message = '<script type="text/javascript">changeClassName(\'jac-change-type-'. $id .'\', "'. $removeClass .'", "'. $addClass .'");</script>';			
			$object [$k] = new stdClass ( );
			$object [$k]->id = '#jac-change-type-'.$id;
			$object [$k]->type = 'html';
			$object [$k]->content = $this->reBuildChangeType($type, $id, $isSpecialUser).$message;
			$k++;
			
			//disable reply button when change type
			if($currentType == 1){
				if($type != 1){
					$this->resultChangeType($k, $object, $id, "delete");
				}
			}else{
				//show button reply when approved comment
				if($type == 1){
					$this->resultChangeType($k, $object, $id);
				}
			}
			
			if($currentType == 0){
				$message = '<script type="text/javascript">changeClassName(\'jac-content-of-comment-'. $id .'\', "comment-ispending", "");</script>';				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-msg-succesfull';
				$object [$k]->type = 'html';
				$object [$k]->content = $message;
				$k++;
				
				$message = '<script type="text/javascript">jacChangeDisplay(\'jac-badge-pending-'. $id .'\', "none");</script>';				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-msg-succesfull';
				$object [$k]->type = 'html';
				$object [$k]->content = $message;
				$k++;
			}else{
				if($type == 0){
					$message = '<script type="text/javascript">changeClassName(\'jac-content-of-comment-'. $id .'\', "", "comment-ispending");</script>';				
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-msg-succesfull';
					$object [$k]->type = 'html';
					$object [$k]->content = $message;
					$k++;	
					
					$message = '<script type="text/javascript">jacChangeDisplay(\'jac-badge-pending-'. $id .'\', "block");</script>';				
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-msg-succesfull';
					$object [$k]->type = 'html';
					$object [$k]->content = $message;
					$k++;
				}
			}
			
			$childArrays = null;
			$model->getChildArray($id, $childArrays);
			if(count($childArrays) > 0){
				foreach ($childArrays as $childArray){																	
					if($addClass == "status-isspam"){
						$message .= '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isunapproved", "");</script>';
						$message = '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isapproved", "'. $addClass .'");</script>';						
					}else if($addClass == "status-isapproved"){
						$message = '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isspam", "");</script>';
						$message .= '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isunapproved", "'. $addClass .'");</script>';	
					}else{
						$message = '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isspam", "'. $addClass .'");</script>';
						$message .= '<script type="text/javascript">changeClassName(\'jac-change-type-'. $childArray->id .'\', "status-isunapproved", "'. $addClass .'");</script>';	
					}
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-change-type-'.$childArray->id;
					$object [$k]->type = 'html';
					$object [$k]->content = $this->reBuildChangeType($type, $childArray->id, $isSpecialUser).$message;
					$k++;
					
					//disable reply button when change type
					if($currentType == 1){
						if($type != 1){
							$this->resultChangeType($k, $object, $childArray->id, "delete");
						}
					}else{
						//show button reply when approved comment
						if($type == 1){
							$this->resultChangeType($k, $object, $childArray->id);
						}
					}
					if($addClass == "status-isspam" || $addClass == "status-isapproved"){
						$message = '<script type="text/javascript">changeClassName(\'jac-content-of-comment-'. $childArray->id .'\', "comment-ispending", "");</script>';
						$message .= '<script type="text/javascript">jacChangeDisplay(\'jac-badge-pending-'. $childArray->id .'\', "none");</script>';												
					}else{
						$message = '<script type="text/javascript">changeClassName(\'jac-content-of-comment-'. $childArray->id .'\', "", "comment-ispending");</script>';
						$message .= '<script type="text/javascript">jacChangeDisplay(\'jac-badge-pending-'. $childArray->id .'\', "block");</script>';	
					}
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-msg-succesfull';
					$object [$k]->type = 'html';
					$object [$k]->content = $message;
					$k++;
															
				}
			}
			
			echo $helper->parse_JSON_new ( $object );
			exit ();
		}
		exit ();	
	}
	
	function deleteComment(){
		global $jacconfig;
		$id 		= JRequest::getInt('id',0);
		$model 		= $this->getModel('comments');
		
		$wherejatotalcomment 	= "";
		$wherejacomment 		= "";
		$this->buildWhereComment($wherejatotalcomment, $wherejacomment);
        
		$limit 		= JRequest::getInt ( 'limit', $jacconfig["comments"]->get("number_comment_in_page",10) );
		$limitstart = JRequest::getInt ( 'limitstart', '0' );
		$helper = new JACommentHelpers ( );
		jimport( 'joomla.filesystem.folder' );
		jimport('joomla.filesystem.file');
		
		$object = array ();
		$k = 0;
		if($id != ''){								 							
			$result = $model -> checkSubOfComment($id);				
			if(count($result)>0){				
				$message = '<script type="text/javascript">jacdisplaymessage();</script>';
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-msg-succesfull';
				$object [$k]->type = 'html';
				$object [$k]->content = $message.JText::_("ERROR_HAS_SUB_COMMENT");
				$k ++;								
			}else{									
				//delete comment
				$comment = $model->deleteComment($id);										
				//send mail for author of comment
				
				$userID 	= $comment->userid;
								
				if($userID == 0){
					$userEmail  = $comment->email;
					$userName   = $comment->name; 						
				}else{
					$userInfo = JFactory::getUser($userID);					
					$userEmail  = $userInfo->email;
					$userName   = $userInfo->name; 
				}
				$currentUserInfo = JFactory::getUser();
				$content    = $helper->replaceBBCodeToHTML($comment->comment);

				if($jacconfig["general"]->get("is_enabled_email", 0)){
					$helper->sendMailWhenDelete($userName, $userEmail, $content, $comment->referer, $currentUserInfo->name);	
				}
				
				if($jacconfig['comments']->get("is_attach_image", 0)){								
					$file_path 	=  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$id;					
					if (is_dir($file_path)) {
						JFolder::delete($file_path);						
					}																	
				}
												
				$helper->displayInform(JText::_("COMMENT_WAS_DELETED"), $k, $object);								
								
				$document=& JFactory::getDocument();
				//get the view name from the query string
      			$viewName = JRequest::getVar('view', 'comments');
      			$viewType= $document->getType();
      			//get our view
				$view = &$this->getView($viewName, $viewType);				 
				//some error chec     
			    if (!JError::isError($model)){			
			    	$view->setModel ($model, true);
			    } 
		        $totalType 			= $model->getTotalByType($wherejatotalcomment);        
				if($totalType)       
					$totalAll         		= (int)array_sum($totalType);
				else 
					$totalAll         		= 0;		        
				
		        					        				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-number-total-comment';
				$object [$k]->type = 'html';
				if($totalAll<=1){
					$message = JText::_("COMMENT");				
				}else{
					$message = JText::_("COMMENTS");
				}
				$object [$k]->content = $totalAll." ".$message;
				$k++;
				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-container-comment';
				$object [$k]->type = 'html';				
				$object [$k]->content = $view->loadContentChangeData($wherejatotalcomment, $wherejacomment, $limit, $limitstart, 'paging');
				$k++;									
				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-container-new-comment';
				$object [$k]->type = 'setdisplay';				
				$object [$k]->content = 'show';
				$k++;
					
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-container-new-comment';
				$object [$k]->type = 'html';				
				$object [$k]->content = '';
				$k++;	
				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#limitstart';
				$object [$k]->type = 'value';				
				$object [$k]->content = $limitstart;		
				$k++;
				$view->getObjectPaging($object, $k);																								      			     							
			}
		}
						
		echo $helper->parse_JSON_new ( $object );
		exit ();		
	}
		
//	function displayInform($error, &$k, &$object){
//		$message = '<script type="text/javascript">displaymessage();</script>';
//		$object [$k] = new stdClass ( );
//		$object [$k]->id = '#jac-msg-succesfull';
//		$object [$k]->type = 'html';
//		$object [$k]->content = $error . $message;
//		$k ++;
//	}
	
	function resultTextVote($id, $avatarSize, $voted){
		if($voted == 0){
			$jacVoteClass = "jac-vote0";
			$totalVote = "(+".$voted.")";
		}else if($voted > 0){
			$totalVote = "(+".$voted.")";
			$jacVoteClass = "jac-vote1";
		}else{
			$totalVote = "(".$voted.")";
			$jacVoteClass = "jac-vote-1";
		}	
		$txt = '<span class="vote-comment-'.$avatarSize.' '.$jacVoteClass.'" id="voted-of-'.$id.'">'.$totalVote.'&nbsp;<strong>'.JText::_("THANKS_FOR_YOUR_VOTE").'</strong></span>';		
		return $txt;
	}
	
	function voteComment() {
		global $jacconfig;
        $app = JFactory::getApplication();
		//if don't enable voting
		if(!$jacconfig['comments']->get('is_allow_voting', 1)){			
			exit();
		}
		
		$helper = new JACommentHelpers ( );
        $model = & $this->getModel ('comments');
		
		$avatarSize = $jacconfig['layout']->get('avatar_size');	;
		
		$currentUserInfo = JFactory::getUser ();
		
		$id = JRequest::getInt ( 'id', '0' );
		$typeVote = JRequest::getVar ( 'typevote', '1' );		
		if($typeVote == "up"){
			$numberVote = 1;
		}else{
			$numberVote = -1;
		}
		
		$object = array ();
		$k = 0;
		
		$typeVote = $jacconfig['permissions']->get ( 'type_voting', 1 );
		
		//if user is loged
		if (! $currentUserInfo->guest) {						
			$modelLogs = & $this->getModel ( 'logs' );
			$logs = $modelLogs->getItemByUser ( $currentUserInfo->id, $id );
			
			//----------Only one for earch comment item---------- 
			if ($typeVote == 1) {									
				//if user don't vote
				if (! $logs || $logs->votes == 0) {
					//insert or update voted in table Logs
					if(isset($logs->id)){
						$post["id"]		   = $logs->id; 						
					}
					$post ["userid"] 	   = $currentUserInfo->id;						
					$post ["votes"]  	   = 1;												
					$post ["itemid"]  	   = $id;						
					$post ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
											
					//update voted in table comments
					$numberVote = $model->voteComment ( $id, $numberVote );
											
					//if data binds have error
					if (! $modelLogs->store ( $post )) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);							
					} //if data binds is successful
					else {
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);														
					}
				} else {
					$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT" ), $k, $object);						
				}
			} 
			//----------Only one for earch comment item in a session-------- 
			else if ($typeVote == 2) {
				// Returns a reference to the global JSession object, only creating it if it doesn't already exist
				$session = &JFactory::getSession();
				
				// Get a value from a session var
				$sessionVote = $session->get('vote', null);
				
				//if comment don't exit in session vote												
				if(!isset($sessionVote[$id])){									
					$sessionVote[$id] = $numberVote;						
					// Put a value in a session var
					$session->set('vote', $sessionVote);																	
					//insert or update voted in table Logs						
					$post ["userid"] 	   = $currentUserInfo->id;
					if($logs){
						$post ["id"] 	   	   = $logs->id;
						$post ["votes"]  	   = $logs->votes + 1;		
					}else{
						$post ["votes"]  	   = 1;						
					}
					$post ["itemid"]  	   = $id;						
					$post ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
											
					//update voted in table comments
					$numberVote = $model->voteComment ( $id, $numberVote );
											
					//if data binds have error
					if (! $modelLogs->store ( $post )) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);							
					} //if data binds is successful
					else {
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);							
					}						
				}else{													
					$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT" ), $k, $object);														
				}																		
			} 
			//----------use lag to voting----------------------
			else {
				$lagUserVoting 	= $jacconfig['permissions']->get ( 'lag_voting', 0 );
				//if user don't vote comment
				if (! $logs || $logs->votes == 0) {
					//insert or update voted in table Logs						
					$post ["userid"] 	   = $currentUserInfo->id;						
					$post ["votes"]  	   = 1;												
					$post ["itemid"]  	   = $id;
					$post ["time_expired"] = time() + $lagUserVoting;						
					$post ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
											
					//update voted in table comments
					$numberVote = $model->voteComment ( $id, $numberVote );
											
					//if data binds have error
					if (! $modelLogs->store ( $post )) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);														
					} //if data binds is successful
					else {
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);							
					}	
				}
				//if user already voted for comment
				else{						
					$timeExpired = $logs->time_expired;
					//don't allow user vote because the lag don't over
					if(time() < $timeExpired){
					  	$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT" ), $k, $object);	
					}else{							
						$post ["userid"] 	   = $currentUserInfo->id;
						if($logs){
							$post ["id"] 	   	   = $logs->id;
							$post ["votes"]  	   = $logs->votes + 1;		
						}else{
							$post ["votes"]  	   = 1;						
						}
						$post ["itemid"]  	   = $id;		
						$post ["time_expired"] = time() + $lagUserVoting;									
						$post ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
												
						//update voted in table comments
						$numberVote = $model->voteComment ( $id, $numberVote );
						
						//if data binds have error
						if (! $modelLogs->store ( $post )) {
							$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);													
						} //if data binds is successful
						else {
							$object [$k] = new stdClass ( );
							$object [$k]->id = '#jac-vote-comment-' . $id;
							$object [$k]->type = 'html';
							$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
							$k ++;
							
							$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);							
						}
						
					}
				}					
			}			
		} //if user is guest
		else {
			//param guest voting	
			$allowGuestVoting = $jacconfig['permissions']->get ( 'vote', 0 );						
			//allow guest voting
			if ($allowGuestVoting == "all") {								
				//----Only one for earch comment item------//
				if($typeVote == "1"){
					$lagGuestVoting 	= $jacconfig['permissions']->get ( 'lag_voting', 0 );
					$cookieName = JUtility::getHash ( $app->getName () . 'comments' . $id );
					
					// ToDo - may be adding those information to the session?
					$voted = JRequest::getVar ( $cookieName, '0', 'COOKIE', 'INT' );
					if ($voted) {
						$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT" ), $k, $object);					
					} else {
						setcookie ( $cookieName, '1', 0 );
						
						$numberVote = $model->voteComment ( $id, $numberVote );
						
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);					
					}	
				}
				//-Only one for earch comment item in a session
				else if($typeVote == "2"){
					// Returns a reference to the global JSession object, only creating it if it doesn't already exist
					$session = &JFactory::getSession();
					
					// Get a value from a session var
					$sessionVote = $session->get('vote', null);
					
					//if comment don't exit in session vote												
					if(!isset($sessionVote[$id])){																					
						$sessionVote[$id] = $numberVote;												
						// Put a value in a session var
						$session->set('vote', $sessionVote);																																		
												
						//update voted in table comments
						$numberVote = $model->voteComment ( $id, $numberVote );
																														
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);

						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
					}else{																		
						$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT" ), $k, $object);														
					}			
				}
				//-set lag voting
				else{
					$lagGuestVoting 	= $jacconfig['permissions']->get ( 'lag_voting', 0 );
					$cookieName = JUtility::getHash ( $app->getName () . 'comments' . $id );
					
					// ToDo - may be adding those information to the session?
					$voted = JRequest::getVar ( $cookieName, '0', 'COOKIE', 'INT' );
					if ($voted) {
						$helper->displayInform(JText::_ ( "YOU_ALREADY_VOTED_FOR_THIS_COMMENT TODAY" ), $k, $object);					
					} else {
						setcookie ( $cookieName, '1', time () + $lagGuestVoting );
						
						$numberVote = $model->voteComment ( $id, $numberVote );
						
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-vote-comment-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultTextVote($id, $avatarSize, $numberVote) ;
						$k ++;
						
						$helper->displayInform(JText::_ ( "THANKS_FOR_YOUR_VOTE" ), $k, $object);					
					}	
				}								
			} //don't allow guest voting
			else {
				$helper->displayInform(JText::_ ( "YOU MUST LOGIN TO VOTE" ), $k, $object);				
			}
		}
		
		$helper = new JACommentHelpers ( );		
        echo $helper->parse_JSON_new ( $object );
		exit ();        		
	}			
	
	function saveEditComment(){		
		global $jacconfig;
        $app = JFactory::getApplication();
		$model = & $this->getModel ('comments');
		$helper = new JACommentHelpers ( );	
		jimport( 'joomla.filesystem.folder' );
		jimport('joomla.filesystem.file');		
		$object = array ();
		$k = 0;
		$validateData = 1;
		
		$post["id"] 		= JRequest::getInt("id", 0);
		$ip  				= $_SERVER ["REMOTE_ADDR"];
		$currentUserInfo = JFactory::getUser ();								
		$email   			= $currentUserInfo -> email;
			
		$messEnableButton = '<script type="text/javascript">enableAddNewComment("btlEditComment");</script>';

		$post["comment"]	= JRequest::getVar( 'newcomment','','','', JREQUEST_ALLOWHTML);		
		$post["comment"]    = $helper->removeEmptyBBCode($post["comment"]);		
		$lengthOfComment = $helper->getRealLengthOfComment($post["comment"]);
										
		if($post["comment"] == "" || $lengthOfComment == 0){
			$helper->displayInform(JText::_ ( "YOU_MUST_INPUT_YOUR_COMMENT" ).$messEnableButton, $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment < $jacconfig['spamfilters']->get("min_length", 0)){
			if($validateData)
				$helper->displayInform(JText::_ ( "YOUR_COMMENT_IS_TOO_SHORT" ).$messEnableButton, $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment > $jacconfig['spamfilters']->get("max_length", 500)){
			if($validateData)						
				$helper->displayInform(JText::_ ( "YOUR_COMMENT_IS_TOO_LONG" ).$messEnableButton, $k, $object);
			$validateData = 0;									    					
		}else{				
			//check link in comment	
			//$post["comment"] = $helper ->replaceURLWithHTMLLinks($post["comment"]);
			//$post['comment'] = $helper->replaceBBCodeToHTML($post['comment']);
								
			if($model->checkMaxLink($post['comment'], $jacconfig['spamfilters']->get("number_of_links", 5))){				
				if($validateData)
					$helper->displayInform(JText::_ ( "NUMBER_OF_LINKS_IN_THE_COMMENT_EXCEED_ITS_MAXIMUM" ).$messEnableButton, $k, $object);
				$validateData = 0;														
			}			
		}	
		
		$listFile = JRequest::getVar('listfile', 0);		
		
		if($validateData){	
			$checkComment = $model -> checkBlockedWord($ip , $email, $post['comment']);			
			switch ($checkComment){
				case "IP Blocked":
					$helper->displayInform(JText::_ ( "YOUR_IP_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;
				case "Email Blocked":
					$helper->displayInform(JText::_ ( "YOUR_EMAIL_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;
				case "Word Blocked";
				 	$helper->displayInform(JText::_ ( "YOUR_WORD_IN_THE_COMMENT_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;				
				default:
					$messageBlacklist = "";					
					if($checkComment == "IP Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your IP is included in the blacklist; therefore, it shall be checked before being shown";	
					}else if($checkComment == "Email Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your Email is included in the blacklist; therefore, it shall be checked before being shown";
					}else if($checkComment == "Word Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your word in the comment is included in the blacklist; therefore, it shall be checked before being shown";
					}else{
						if($jacconfig['comments']->get("is_allow_approve_new_comment",0) && !$helper->isSpecialUser()){
							$messageBlacklist = "Your comment shall be approved before being shown";						
							$post['type']	= 0;							
						}else{ 
							$post['type']	= 1;
							$post['date_active'] = date("Y-m-d H:i:s");
						}			
					}								
					//replace censored words
					$post['comment'] = $model->checkCensoredWord($post['comment'], $jacconfig['spamfilters']->get("censored_words",""), $jacconfig['spamfilters']->get("censored_words_replace",""));
						
					if($jacconfig["comments"]->get("is_enable_email_subscription", 0))
						$post["subscription_type"] = JRequest::getVar("subscription_type", 0);
						
					$commentID = $model->store ( $post );
					
					if(!$commentID){
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ).$messEnableButton, $k, $object);		
					}else{
						$message = '<script type="text/javascript">actionWhenEditSuccess("'. $commentID .'");</script>';
						$helper->displayInform(JText::_ ( "Data is saved" ).$message.$messageBlacklist, $k, $object);
						
						if($jacconfig['comments']->get("is_attach_image", 0)){
							//delete file in store image if remove file
							$listFile = JRequest::getVar('listfile', 0);
							
							$file_path 			 =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$post["id"];												
							$listFileOfComments  =  JFolder::files($file_path);					

							$stringAttach = "";					
							
							//merger and delete if exit file submit in list file. 
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
								if(isset($_SESSION['jactempedit']) && $_SESSION['jaccountedit'] >0){							
									$listFileTemp = JFolder::files($_SESSION['jactempedit']);																
									if ($listFileTemp) {
										foreach ($listFileTemp as $file){
											if (!in_array($file, $listFile, true)) {
												JFile::delete($_SESSION['jactempedit'].DS.$file);										
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
								       JFolder::copy($_SESSION['jactempedit'], $target_path, '', true);		
								    }		 						   	
								    JFolder::delete($_SESSION['jactempedit']);
								    
								    unset($_SESSION['jaccountedit']);
								    unset($_SESSION['jactempedit']);
								    unset($_SESSION['jacnameFolderedit']);						   						    																																																
								}											   							  
					 		}
					 							
						$listFileOfComments  = JFolder::files($file_path);
						if($listFileOfComments){
							$theme = $jacconfig['layout']->get('theme', 'default');
							$session = &JFactory::getSession();
							if(JRequest::getVar("jacomment_theme", '')){
								jimport( 'joomla.filesystem.folder' );
								$themeURL = JRequest::getVar("jacomment_theme");
								if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
									$theme =  $themeURL;						
								}
								$session->set('jacomment_theme', $theme);			
							}else{
								if($session->get('jacomment_theme', null)){
									$theme = $session->get('jacomment_theme', $theme);
								}
							}
							foreach ($listFileOfComments as $listFileOfComment){							
								$linkOfFile 	= "index.php?tmpl=component&amp;option=com_jacomment&amp;view=comments&amp;task=downloadfile&amp;id=".$post['id']."&amp;filename=".$listFileOfComment;
								$type = substr(strtolower(trim($listFileOfComment)), -3, 3);
								$stringAttach 	.= "<a href='". JRoute::_($linkOfFile) ."'><img src='". JURI::root() ."components/com_jacomment/themes/". $theme ."/images/". $type .".gif' /> ". $listFileOfComment ."</a><br>";													
							}
						}				
						if($stringAttach){
							$stringAttach = "<div class='jac-list-upload-title'>".JText::_('LIST_UPLOAD_FILE')."</div><div class='jac-list-upload-title'>".$stringAttach."</div>";									 
						}
						
						$object [$k] = new stdClass ( );
					    $object [$k]->id = '#jac-attach-file-'.$post["id"];
					    $object [$k]->type = 'html';				
					    $object [$k]->content = $stringAttach;
					    $k++;																												
					}																
//					$post["comment"] = $helper ->replaceURLWithHTMLLinks($post["comment"]);
					$post['comment'] = $helper->replaceBBCodeToHTML($post['comment']);
					$object [$k] = new stdClass ( );
				    $object [$k]->id = '#jac-text-'.$post["id"];
				    $object [$k]->type = 'html';				
				    $object [$k]->content = html_entity_decode($helper->showComment($post["comment"]));
				    $k++;
					}
			}
		}
		echo $helper->parse_JSON_new ( $object );
		exit ();
	}		
	
	function addNewComment(){	   
		global $jacconfig, $session_auth;
        
		$app = JFactory::getApplication();
		if(!isset($jacconfig['comments'])){
			$jacconfig['comments'] = new JRegistry;
            $jacconfig['comments']->loadJSON('{}'); 
		}
		if(!isset($jacconfig['permissions'])){
        	$jacconfig['permissions'] = new JRegistry;
            $jacconfig['permissions']->loadJSON('{}');
		}
		if(!isset($jacconfig['spamfilters'])){
            $jacconfig['spamfilters'] = new JRegistry;
            $jacconfig['spamfilters']->loadJSON('{}');
		}
		//set cid is 0 when add new comment
		JRequest::setVar("cid", 0);
		$model = & $this->getModel ('comments');				
		$currentUserInfo = JFactory::getUser ();
		$helper = new JACommentHelpers ( );	
		
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );				
		
		$post['parentid']		= JRequest::getVar ( 'parentid', 0 );	
		$object = array ();
		$k = 0;
		
		$messEnableButton = '<script type="text/javascript">enableAddNewComment("btlAddNewComment");</script>';	
		
		$validateData = 1;
		//check total		
		$currentTotal = JRequest::getInt("currenttotal", 1);
		if($currentTotal >= $jacconfig["comments"]->get("maximum_comment_in_item", 20)){
			$helper->displayInform(JText::_ ( "COMMENT IN THIS ARTICLE IS FULL TEXT" ).$messEnableButton, $k, $object);
			$validateData = 0;
		}
		
		//check permission of user post
		if($currentUserInfo->guest){
			if($jacconfig['permissions']->get("post", "all") != "all"){
				if($validateData)
					$helper->displayInform(JText::_ ( "YOU MUST LOGIN TO POST COMMENT" ).$messEnableButton, $k, $object);
					$validateData = 0;	
			}
		}
		if(!$helper->isSpecialUser()){			
			if($duration = $jacconfig["comments"]->get("duration_post_comment", 0)){				
				$session = &JFactory::getSession();
				//if have posted
				if($latest_post_time = $session->get('jacomment_latest_post', null)){
					//die($latest_post_time."--");
					//die((time()-$latest_post_time)."--");
					if((time()-$latest_post_time) <= $duration){
						$helper->displayInform(JText::_ ( "You can wait to add new comment." ).$messEnableButton, $k, $object);
						$validateData = 0;
					}
				}
				
				if($validateData){									
					$session->set('jacomment_latest_post', time());
				}
			}
			//check captcha
			$isEnableCaptcha 		= $jacconfig['spamfilters']->get("is_enable_captcha", 1);
			$isEnableCaptchaUser	= $jacconfig['spamfilters']->get("is_enable_captcha_user", 0);
			
			if(($currentUserInfo->guest && $isEnableCaptcha) || (!$currentUserInfo->guest && $isEnableCaptcha && $isEnableCaptchaUser)){
				if($jacconfig['spamfilters']->get("is_enable_captcha", 1)){
					$captcha = JRequest::getVar ( 'captcha', '' );											
				    if(!$this->validatecaptchaaddnew($captcha)){					
						if($validateData){
							//$helper->displayInform(JText::_ ( "Retype captcha!" ), $k, $object);
							$object [$k] = new stdClass ( );
							$object [$k]->id = '#err_textCaptcha';
							$object [$k]->type = 'setdisplay';
							$object [$k]->content = 'show';
							$k ++;
							
							$message = '<script type="text/javascript">displayErrorAddNew();jacLoadNewCaptcha();</script>';
							$object [$k] = new stdClass ( );
							$object [$k]->id = '#err_textCaptcha';
							$object [$k]->type = 'html';
							$object [$k]->content = JText::_("YOUR_CAPTCHA_WAS_INVALID_TEXT").$message.$messEnableButton;
							$k ++;
							$validateData = 0;
						}					
					}																						
				}			
			}									
		}
		//get data
				
		$post["comment"] = JRequest::getVar( 'newcomment','','','', JREQUEST_ALLOWHTML);		
		$post["comment"] = trim($helper->removeEmptyBBCode($post["comment"]));		
		$lengthOfComment = $helper->getRealLengthOfComment($post["comment"]);															
		if($post["comment"] == "" || $lengthOfComment == 0){
			if($validateData)
				$helper->displayInform(JText::_ ( "YOU_MUST_INPUT_YOUR_COMMENT" ).$messEnableButton, $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment < $jacconfig['spamfilters']->get("min_length", 0)){
			if($validateData)
				$helper->displayInform(JText::_ ( "YOUR_COMMENT_IS_TOO_SHORT" ).$messEnableButton, $k, $object);
			$validateData = 0;							
		}else if($lengthOfComment > $jacconfig['spamfilters']->get("max_length", 1000)){
			if($validateData)						
				$helper->displayInform(JText::_ ( "YOUR_COMMENT_IS_TOO_LONG" ).$messEnableButton, $k, $object);
			$validateData = 0;									    					
		}else{													
			//check link in comment
			if($model->checkMaxLink($post['comment'], $jacconfig['spamfilters']->get("number_of_links", 5))){
				if($validateData)
					$helper->displayInform(JText::_ ( "NUMBER_OF_LINKS_IN_THE_COMMENT_EXCEED_ITS_MAXIMUM" ).$messEnableButton, $k, $object);
				$validateData = 0;														
			}
		}							
				
		$post['ip']  			= $_SERVER ["REMOTE_ADDR"];			
		$post['date']  	 		= date("Y-m-d H:i:s");
		$post['contentid']  	= JRequest::getVar ( 'contentid', 0 );
		$post['option']  		= JRequest::getVar ( 'contentoption', 0 );
		$post['contenttitle']  = JRequest::getVar ( 'contenttitle', '' );
				
		$session = &JFactory::getSession();			
		//$post['referer']  		= $session->get('commenturl', null);						
		$post['referer']  		= JRequest::getVar ( 'jacomentUrl', $session->get('commenturl', null) );
		if($jacconfig['comments']->get("is_enable_email_subscription")){
			$post['subscription_type']  = JRequest::getVar ( 'subscription_type', 0 );		
		}			
		//if user is loged
		if (! $currentUserInfo->guest) {				
			$post['userid'] 	 	= $currentUserInfo -> id;
			$post['name']    		= $currentUserInfo -> name;
			$post['email']   		= $currentUserInfo -> email;															
            
            // ++ add by congtq 03/12/2009
            if($currentUserInfo -> params){
				$params = new JRegistry;
		        $params->loadJSON($currentUserInfo -> params);		        
	            if(array_key_exists('providerName', $params)){	                
	                $post['usertype'] = $params->get("providerName");                     
	            }
            }            
            // -- add by congtq 03/12/2009
		}
       
		//if user is a guest
		else {										
			$post['name']    		= JRequest::getVar ( 'name', '' );
			$post['email']   		= JRequest::getVar ( 'email', '' );
			
			if($post['name'] == ''){
				if($validateData)
					$helper->displayInform(JText::_ ( "YOU MUST INPUT YOUR NAME" ).$messEnableButton, $k, $object);
				$validateData = 0;
				//jac-text-user
				//islogin
				if(JRequest::getInt ( 'islogin', 0 )==1){
					$object [$k] = new stdClass ( );
			        $object [$k]->id = '#jac-text-user';
			        $object [$k]->type = 'html';
			        $object [$k]->content = '<script type="text/javascript">refreshPage();</script>';
			        $k ++;	
				}		        
			}
			
			if($post['email'] == ''){
				if($validateData)
					$helper->displayInform(JText::_ ( "YOU MUST INPUT YOUR EMAIL" ).$messEnableButton, $k, $object);
				$validateData = 0;
			}
			
			$post['website']  		= JRequest::getVar ( 'website', '' );				
		}					
		
		if($validateData){																	
			$checkComment = $model -> checkBlockedWord($post['ip'] , $post['email'], $post['comment']);			
			switch ($checkComment){
				case "IP Blocked":
					$helper->displayInform(JText::_ ( "YOUR_IP_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;
				case "Email Blocked":
					$helper->displayInform(JText::_ ( "YOUR_EMAIL_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;
				case "Word Blocked";
				 	$helper->displayInform(JText::_ ( "YOUR_WORD_IN_THE_COMMENT_IS_BLOCKED_TEXT" ).$messEnableButton, $k, $object);
					break;				
				default:								
					$messageBlacklist = "";					
					if($checkComment == "IP Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your IP is included in the blacklist; therefore, it shall be checked before being shown";	
					}else if($checkComment == "Email Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your Email is included in the blacklist; therefore, it shall be checked before being shown";
					}else if($checkComment == "Word Blacklist"){
						$post['type']		= 2;
						$messageBlacklist 	= "Your word in the comment is included in the blacklist; therefore, it shall be checked before being shown";
					}else{
						//if admin need approve comment and this user isn't special user
						if($jacconfig['comments']->get("is_allow_approve_new_comment",0) && !$helper->isSpecialUser()){
							$messageBlacklist = "Your comment shall be approved before being shown";						
							$post['type']	= 0;							
						}else{ 
							$post['type']	= 1;
							$post['date_active'] = date("Y-m-d H:i:s");
						}			
					}										
					
					//replace censored words
					$post['comment'] = $model->checkCensoredWord($post['comment'], $jacconfig['spamfilters']->get("censored_words",""), $jacconfig['spamfilters']->get("censored_words_replace",""));																																												
					$post['voted']	= 1;																				
										
					if (! $commentID = $model->store ( $post )) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);													
					} //if data binds is successful
					//$commentID = 269;
					//if data binds have error					
					if (! $commentID) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ).$messEnableButton, $k, $object);							
					}else{												
						$post['referer'] = $post['referer']."#jacommentid:".$commentID;								
						$model->updateUrl($commentID, $post['referer']);
												
						//assign value edit comment.
						if(!$helper->isSpecialUser() && !$currentUserInfo->guest){
							$typeEditing = $jacconfig["permissions"]->get("type_editing", 1);
							if($typeEditing == 2){
								// Returns a reference to the global JSession object, only creating it if it doesn't already exist
								$session = &JFactory::getSession();								
								// Get a value from a session var
								$sessionAddnew = $session->get('jacaddNew', null);								
								//if comment don't exit in session addNew												
								if(!in_array($commentID, $sessionAddnew)){									
									$sessionAddnew[] = $commentID;
									$session->set('jacaddNew', $sessionAddnew);
								}
							}
						}
												
						//infor result												
						if($post["parentid"]){
							$message = '<script type="text/javascript">cancelComment("completeReply",0,"'. JText::_("REPLY") .'","'. JText::_("POSTING") .'");</script>';							
						}else{
							$message = '<script type="text/javascript">completeAddNew('. $commentID .');</script>';
						}						
						if($messageBlacklist){
							$helper->displayInform($messageBlacklist.$message.$messEnableButton, $k, $object, "8000");
						}else{
							$helper->displayInform(JText::_ ( "Data is saved" ).$message.$messEnableButton, $k, $object);
						}							
						
						//insert vote in log						
						if(!$currentUserInfo->guest){							
							$modelLogs = & $this->getModel ( 'logs' );
							$postLogs ["userid"] 	   = $currentUserInfo->id;						
							$postLogs ["votes"]  	   = 1;												
							$postLogs ["itemid"]  	   = $commentID;						
							$postLogs ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
							
							$modelLogs->store ( $postLogs );																						
						}
						
						//BEGIN--save upload
						if($jacconfig['comments']->get("is_attach_image", 0)){
							//post in reply														
							$listFile = JRequest::getVar('listfile', 0);
							
							if($listFile){
								if(isset($_SESSION['jaccount']) && $_SESSION['jaccount']>0){
								//delete some file not in array																																									
																										
								$listFileTemp = JFolder::files($_SESSION['jactemp']);
//								print_r($listFile);
//								print_r($listFileTemp);die();																
								if ($listFileTemp) {
									foreach ($listFileTemp as $file){
										if (!in_array($file, $listFile, true)) {
											JFile::delete($_SESSION['jactemp'].DS.$file);												
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
							       JFolder::copy($_SESSION['jactemp'], $target_path, '', true);										   
							    }		 
							    
							    JFolder::delete($_SESSION['jactemp']);								    
							    
							    unset($_SESSION['jaccount']);
							    unset($_SESSION['jactemp']);
							    unset($_SESSION['jacnameFolder']);
							   
							    $object [$k] = new stdClass ( );
							    $object [$k]->id = '#result_upload';
							    $object [$k]->type = 'html';				
							    $object [$k]->content = "";
							    $k++;					   							   
							  }	
							}																																																							  				
						}							
						//END -- save upload
						
						$wherejatotalcomment 	= "";
						$wherejacomment 		= "";
						$this->buildWhereComment($wherejatotalcomment, $wherejacomment);
						
						$totalType 					= $model->getTotalByType($wherejatotalcomment);        
						if($totalType)       
							$totalAll         		= (int)array_sum($totalType);
						else 
							$totalAll         		= 0;

					    //check current total of comment in currentItems - 
					    //if total of comment is bigger - don't allow post new comment
					    if($totalAll >= $jacconfig['comments']->get("maximum_comment_in_item")){
					    	$script = '<script type="text/javascript">disableReplyButton();</script>';					    	
					    	$object [$k] = new stdClass ( );
							$object [$k]->id = '#jac-post-new-comment';
							$object [$k]->type = 'html';				
							$object [$k]->content = $script;
							$k++;
					    }
					    					    
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-number-total-comment';
						$object [$k]->type = 'html';	
						if($totalAll<=1){
							$message = JText::_("COMMENT");				
						}else{
							$message = JText::_("COMMENTS");
						}
						$object [$k]->content = $totalAll." ".$message;									
						$k++;											
												
						$document=& JFactory::getDocument();
						//get the view name from the query string
		      			$viewName = JRequest::getVar('view', 'comments');
		      			$viewType= $document->getType();
		      			//get our view
						$view = &$this->getView($viewName, $viewType);				 
						//some error chec     
					    if (!JError::isError($model)){			
					    	$view->setModel ($model, true);
					    } 
						
					    $item = $model->getItemFrontEnd($commentID);
					     					    					    					    				
					    //reply comment
					    if($post['parentid']){					    	
					    	$numberOfChild = $model->getNumberChildOfItems($post['parentid']);
					    	$script = '<script type="text/javascript">updateTotalChild("'. $post['parentid'] .'");</script>';
							if($numberOfChild == 1){
								$object [$k] = new stdClass ( );
								$object [$k]->id = '#jac-div-show-child-'.$post['parentid'];
								$object [$k]->type = 'html';
								$object [$k]->content = '<a href="Javascript:displayChild(\''. $post['parentid'] .'\')" title="'.JText::_("SHOW_ALL_CHILDREN_COMMENT_OF_THIS_COMMENT").'" class="showreply-btn" id="a-show-childen-comment-of-'. $post['parentid'] .'" style="display: none;">'.JText::_('SHOW').'									
																<span id=\'jac-total-childen-'. $post['parentid'] .'\'>1 </span>'. JText::_("REPLY").'  																	
														</a>
														<a href="Javascript:displayChild(\''. $post['parentid'] .'\')" title="'.JText::_("HIDE_ALL_CHILDREN_COMMENT_OF_THIS_COMMENT").'" class="hidereply-btn" id="a-hide-childen-comment-of-'. $post['parentid'] .'">'.JText::_('HIDE').'									
																<span id=\'jac-total-childen-'. $post['parentid'] .'\'>1 </span>'. JText::_("REPLY").'  																	
														</a>'.$script;
																
								$k++;						
							}else{								
								$object [$k] = new stdClass ( );
								$object [$k]->id = '#jac-show-total-childen-'.$post['parentid'];
								$object [$k]->type = 'html';
								$object [$k]->content = $numberOfChild.$script;
								$k++;			
												
								$object [$k] = new stdClass ( );
								$object [$k]->id = '#jac-hide-total-childen-'.$post['parentid'];
								$object [$k]->type = 'html';
								$object [$k]->content = $numberOfChild;
								$k++;										
							}														
						
					   	 	//if enable email subcription - send mail
							if($jacconfig['general']->get("is_enabled_email", 0)){
								//send mail 																								
								$helper->sendAddNewMail ($commentID, $wherejatotalcomment, 'reply', $post);								
							}			
																	
							$message = '<script type="text/javascript">moveBackground('. $commentID .', "'. JURI::root() .'")</script>';																													
							$object [$k] = new stdClass ( );
							$object [$k]->id = '#childen-comment-of-'.$post['parentid'];
							$object [$k]->type = 'html';
							
							if($post["type"] == 0)																															
								$object [$k]->content = $view->loadContentChangeData($wherejatotalcomment, $wherejacomment, '', '', 'getChilds', $commentID).$message;
							else 
								$object [$k]->content = $view->loadContentChangeData($wherejatotalcomment, $wherejacomment, '', '', 'getChilds').$message;								
							$k++;												    						    						    											    					  
					    }
					    //add new comment
					    else{
					    	$message = '<script type="text/javascript">moveBackground('. $commentID .', "'. JURI::root() .'")</script>';
                            $object [$k] = new stdClass ( );
                            $object [$k]->id = '#jac-container-new-comment';
                            $object [$k]->type = 'setdisplay';				
                            $object [$k]->content = 'show';
                            $k++;
                            
							$object [$k] = new stdClass ( );
							$object [$k]->id 		= '#jac-container-new-comment';
							$object [$k]->type 		= 'html';				
							$object [$k]->content 	= $view->showComment($item).$message;
							$k++;	
							
					    	//if enable email subcription - send mail
							if($jacconfig['general']->get("is_enabled_email")){																																
								$helper->sendAddNewMail ($commentID, $wherejatotalcomment, 'addNew', $post);																													
							}													    					   																									    	
					    }
												
					}		
			}													
		}			
											
		echo $helper->parse_JSON_new ( $object );
		exit ();							
	}		
	
	function buildWhereComment(&$wherejatotalcomment, &$wherejacomment){
		$helper = new JACommentHelpers ( );
		$contentOption 	= JRequest::getVar ( 'contentoption', '');
		$contentID 	   	= JRequest::getInt ( 'contentid', 0);
		$commentType   	= JRequest::getInt ( 'commenttype', 1);
		$parentID   	= JRequest::getInt ( 'parentid', 0);
				
		$wherejatotalcomment 	 = " AND c.option= '".$contentOption."'";
		$wherejatotalcomment 	.= " AND c.contentid= '".$contentID."'";
		//check user is specialUser
        $isSpecialUser = $helper->isSpecialUser();                
        //get aproved comment if user isn't special User
        if(!$isSpecialUser){                	 
        	$wherejatotalcomment 	.= " AND c.type = ".$commentType;
        }
		$wherejacomment 		 = $wherejatotalcomment;
		$wherejacomment 		.= " AND c.parentid = ".$parentID."";
	}
	
	function resultReportComment($id){
		//$result = '<input type="button" disabled="disabled" id="btl-jac-report-'.$id.'" value="'.JText::_("REPORT").'" onclick="reportComment('.$id.')">';
		$result = "<a href='javascript:undoReportComment(". $id .")' class='jac-undo-report' title='".JText::_("UNDO_REPORT")."'>[". JText::_("UNDO") ."]</a>";
		return $result;	
	}
	
	function resultUndoReportComment($id){		
		global $jacconfig;
		//layout[button_type]		
		$result = '<a class="report-btn" href="javascript:reportComment('. $id .')" title="'.JText::_("FLAGGED_REPORT_TEXT").'">'. JText::_("REPORT") .'</a>';		
		return $result;	
	}
	
	function undoReportComment(){		
		global $jacconfig;
        $app = JFactory::getApplication();				
		if(!$jacconfig["comments"]->get("is_allow_report", 0)){
			exit();	
		}
		
		$helper = new JACommentHelpers ( );
		
		$model = & $this->getModel ('comments');		
		$totalToReportSpam 	= $jacconfig['permissions']->get('total_to_report_spam');		
		$currentUserInfo 	= JFactory::getUser ();	
		
		//id of comment
		$id = JRequest::getInt ( 'id', '0' );				
		
		$object = array ();
		$k = 0;
		
		//if user is loged
		if (! $currentUserInfo->guest) {
			$isAllowReport = $jacconfig['comments']->get ( 'is_allow_report', 0 );			
			//if allow user voting comment
			if ($isAllowReport) {				
				$modelLogs = & $this->getModel ( 'logs' );
				$logs = $modelLogs->getItemByUser ( $currentUserInfo->id, $id );																
				
				//update voted in table comments
				$numberReport = $model->undoReportComment ( $id );								
				
				$modelLogs->updateReport($logs->id, 0);				
				
				if($numberReport == ($totalToReportSpam -1)){
					$model->changeTypeOfComment ( $id,1 );						
				}
				
				$object [$k] = new stdClass ( );
				$object [$k]->id = '#jac-show-report-' . $id;
				$object [$k]->type = 'html';
				$object [$k]->content = $this->resultUndoReportComment($id);
				$k++;																			
				
				$helper->displayInform(JText::_ ( "UNDO REPORT SUCCESSFUL" ), $k, $object);																											
			} //don't allow user voting comment
			else {
				$helper->displayInform(JText::_ ( "NOT ALLOW REPORT COMMENT" ), $k, $object);								
			}
		} //if user is guest
		else {
			//param guest voting	
				$isAllowReport = $jacconfig['comments']->get ( 'is_allow_report', 0 );			
						
			//allow guest voting
			if ($isAllowReport) {
				$cookieName = JUtility::getHash ( $app->getName () . 'reportcomments' . $id );
				
				// ToDo - may be adding those information to the session?
				$voted = JRequest::getVar ( $cookieName, '0', 'COOKIE', 'INT' );
				if ($voted) {							
					setcookie($cookieName, "1", time()-3600);
					
					$numberReport = $model->undoReportComment ( $id );
					
					if($numberReport == ($totalToReportSpam -1)){
						$model->changeTypeOfComment ( $id,1 );						
					}
					
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-show-report-' . $id;
					$object [$k]->type = 'html';
					$object [$k]->content = $this->resultUndoReportComment($id);
					$k ++;
														
					$helper->displayInform(JText::_ ( "UNDO REPORT SUCCESSFUL" ), $k, $object);						
				} 
			} //don't allow guest voting
			else {
				$helper->displayInform(JText::_ ( "YOU MUST LOGIN TO REPORT" ), $k, $object);				
			}
		}
		
		$helper = new JACommentHelpers ( );		
		echo $helper->parse_JSON_new ( $object );
		exit ();	
	}
	
	function reportcomment(){		
		global $jacconfig;
        $app = JFactory::getApplication();
		$helper = new JACommentHelpers ( );
		
		if(!$jacconfig["comments"]->get("is_allow_report", 0)){
			exit();	
		}
		
		$model = & $this->getModel ('comments');		
		$totalToReportSpam 	= $jacconfig['permissions']->get('total_to_report_spam');		
		$currentUserInfo 	= JFactory::getUser ();	
		
		//id of comment
		$id = JRequest::getInt ( 'id', '0' );				
		
		$object = array ();
		$k = 0;
		
		//if user is loged
		if (! $currentUserInfo->guest) {
			$isAllowReport = $jacconfig['comments']->get ( 'is_allow_report', 0 );			
			//if allow user report comment
			if ($isAllowReport) {				
				$modelLogs = & $this->getModel ( 'logs' );
				$logs = $modelLogs->getItemByUser ( $currentUserInfo->id, $id );				
				//----------Only one for earch comment item---------- 
											
				//if user don't report
				if (! $logs || $logs->reports == 0) {
					//insert or update voted in table Logs
					
					if(isset($logs)){
						$post ["id"] 	   = $logs->id;							
					}
					
					$post ["userid"] 	   = $currentUserInfo->id;						
					$post ["reports"]  	   = 1;												
					$post ["itemid"]  	   = $id;						
					$post ["remote_addr"]  = $_SERVER ["REMOTE_ADDR"];
					
					//update voted in table comments
					$numberReport = $model->reportComment ( $id );
					//set comment is spam comment if number report of comment equal totalReport										
									
					//if data binds have error
					if (! $modelLogs->store ( $post )) {
						$helper->displayInform(JText::_ ( "ERROR_OCCURRED_NOT_SAVE" ), $k, $object);							
					} //if data binds is successful
					else {		
						//mask spam comment in database
						if($numberReport == $totalToReportSpam){						
							$model->changeTypeOfComment ( $id,2, false, "reportspam" );
						}
						$object [$k] = new stdClass ( );
						$object [$k]->id = '#jac-show-report-' . $id;
						$object [$k]->type = 'html';
						$object [$k]->content = $this->resultReportComment($id);
						$k++;																			
						
						$helper->displayInform(JText::_ ( "THANKS FOR YOUR REPORT" ), $k, $object);														
					}
				} else {
					$helper->displayInform(JText::_ ( "YOU ALREADY REPORT FOR THIS COMMENT" ), $k, $object);						
				}
							
			} //don't allow user voting comment
			else {
				$helper->displayInform(JText::_ ( "NOT ALLOW REPORT COMMENT" ), $k, $object);								
			}
		} //if user is guest
		else {
			//param guest voting	
			$isAllowReport = $jacconfig['comments']->get ( 'is_allow_report', 0 );			
			
			
			//allow guest voting
			if ($isAllowReport) {
				$cookieName = JUtility::getHash ( $app->getName () . 'reportcomments' . $id );
				
				// ToDo - may be adding those information to the session?
				$voted = JRequest::getVar ( $cookieName, '0', 'COOKIE', 'INT' );
				if ($voted) {
					$helper->displayInform(JText::_ ( "YOU ALREADY REPORT FOR THIS COMMENT" ), $k, $object);					
				} else {
					setcookie ( $cookieName, '1', 0);
					
					$numberReport = $model->reportComment ( $id );
					//mask spam comment in database
					if($numberReport == $totalToReportSpam){						
						$model->changeTypeOfComment ( $id,2 , false, "reportspam");
					}
					//set comment is spam comment if number report of comment equal totalReport										
					$object [$k] = new stdClass ( );
					$object [$k]->id = '#jac-show-report-' . $id;
					$object [$k]->type = 'html';
					$object [$k]->content = $this->resultReportComment($id);
					$k ++;
					
					$helper->displayInform(JText::_ ( "THANKS FOR YOUR REPORT" ), $k, $object);	
																		
				}
			} //don't allow guest voting
			else {
				$helper->displayInform(JText::_ ( "YOU MUST LOGIN TO REPORT" ), $k, $object);				
			}
		}
						
		echo $helper->parse_JSON_new ( $object );
		exit ();	
	}
	
	function attachFile(){
		jimport('joomla.filesystem.file');
		$a = JRequest::getVar("userfile","");				
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name']!=''){
			$desk = JPATH_COMPONENT_ADMINISTRATOR.DS.'temp'.DS.substr($_FILES['userfile']['name'], 0, strlen($_FILES['userfile']['name'])-4).time().rand().substr($_FILES['userfile']['name'], -4, 4);

			if(JFile::upload($_FILES['userfile']['tmp_name'], $desk)){
				$filecontent = JFile::read($desk);
				if(!$model->import($filecontent)){
					return $this->setRedirect( "index.php?option=$option&view=jaemail" );
				}
				
				$filter_lang = $app->getUserStateFromRequest( $option.'.jaemail.filter_lang', 'filter_lang', 'en-GB',	'string' );	
				return $this->setRedirect( "index.php?option=$option&view=jaemail&filter_lang=$filter_lang", JText::_('IMPORT_SUCCESS') );
			}
			unset($_FILES['userfile']);
			JError::raiseWarning(1, JText::_('UPLOAD_FILE_NOT_SUCCESS'));
			return $this->setRedirect( "index.php?option=$option&view=jaemail&task=show_import" );
		}				
	}
    
    // ++ add by congtq 26/11/2009
    function open_youtube(){    
		global $jacconfig;
    	$cid = JRequest::getVar( 'cid', '' );
        $id = $cid[0]?$cid[0]:'';                        	
		
		$helper = new JACommentHelpers();
		require_once $helper->jaLoadBlock("comments/youtube.php");        
    } 
    
    function embed_youtube(){
        $helper = new JACommentHelpers ( );   
        
        $post             = JRequest::get('request');
        
        $object = array ();
        $k = 0;
        
        if (! $helper->checkYoutubeLink($post['txtYouTubeUrl'])) {
            $helper->displayInform(JText::_ ( "Youtube Video Url is incorrect" ), $k, $object);                            
        }else{
            $element = $post['id']?"edit":"";
            
            $k = 0;             
            $object [$k] = new stdClass ( );
            $object [$k]->id = '#newcomment'.$element;
            $object [$k]->type = 'append';
            $object [$k]->status = 'ok';
            $object [$k]->content = '[youtube '.$post['txtYouTubeUrl'].' youtube]';
            $k ++;

            $helper->displayInform(JText::_ ( "Video is embed" ), $k, $object);
        }
        
        echo $helper->parse_JSON_new ( $object );
		exit ();
        
    }
    // -- add by congtq 26/11/2009        
    
    // ++ add by congtq 01/12/2009
    function open_login(){    
        $currentUserInfo = JFactory::getUser ();
        if($currentUserInfo->id){ 
            $ses_url = $_SESSION['ses_url'];
            $this->setRedirect($ses_url);
            
//            
//            $jquery = '';
//            
            // hide #comment_as, #other_field
//            $arrid = explode(',', 'comment_as,other_field');
//            for($i=0; $count=sizeof($arrid), $i<$count; $i++){
//                $jquery .= "jQuery('#".$arrid[$i]."', window.parent.document).remove();";
//            }                      
//            
            // get comment
//            $model = $this->getModel('comments');               
//            
//            $helper = new JACommentHelpers ( );
//            $isSpecialUser = $helper->isSpecialUser();

//            $cond = '';
            // if is NOT SpecialUser then show links by UserID, else show all link Edit/Delete
//            if(!$isSpecialUser){
//                $cond = ' AND userid='.$currentUserInfo->id;
//            }
//            $items = $model->getItems($cond);
//            
//            for($k=0; $count=sizeof($items), $k<$count; $k++){
//                $jquery .= "jQuery('#edit-delete-".$items[$k]->id."', window.parent.document).html('<a href=\"javascript:editComment(\'".$items[$k]->id."\', \'".JText::_("EDIT")."\')\">".JText::_("EDIT")."</a>&nbsp;<a href=\"javascript:deleteComment(\'".$items[$k]->id."\', \'".JText::_("DELETE")."\')\">".JText::_("DELETE")."</a>');";
//            }           
//            
            // show link logout and close popup
//            $logout = JTEXT::_('Posting as ').$currentUserInfo->username.'(<a href="'.JURI::base().'index.php?option=com_jacomment&view=users&task=logout_rpx">'.JTEXT::_('Logout').'</a>)';
//            $jquery .= "
//                        jQuery('#jac-text-guest', window.parent.document).html('".$logout."');
//                        jQuery('#ja-wrap-content', window.parent.document).remove();
//                        ";
//            
            // show and hide some #id            
//            $document =& JFactory::getDocument();                            
//            $document->addScriptDeclaration("jQuery(document).ready( function() { 
//                                               ".$jquery."                                            
//                                            });"); 
//                                        

//             
        }else{
            JRequest::setVar('view', 'users');        
            JRequest::setVar('layout', 'login');        
            parent::display();        
        }
    }
    // -- add by congtq 01/12/2009
    
    function open_attach_file(){    	
		global $jacconfig;
    	$cid = JRequest::getVar( 'cid', '' );
        $id = $cid[0]?$cid[0]:'';        
        $action = "addnew";        
		$totalAttachFile = $jacconfig["comments"]->get("total_attach_file", 5);				
		$theme = $jacconfig["layout"]->get("theme", "default");	
		$session = &JFactory::getSession();
		if(JRequest::getVar("jacomment_theme", '')){
			jimport( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar("jacomment_theme");
			if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
				$theme =  $themeURL;						
			}
			$session->set('jacomment_theme', $theme);			
		}else{
			if($session->get('jacomment_theme', null)){
				$theme = $session->get('jacomment_theme', $theme);
			}
		}
		$attachFileType	 = $jacconfig["comments"]->get("attach_file_type", "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");				
		$listFiles		 = JRequest::getVar("listfile");		
		
		$helper = new JACommentHelpers();
		require_once $helper->jaLoadBlock("comments/attach.php");
    }
    
    function open_attach_file_edit(){
    	global $jacconfig;
    	$cid = JRequest::getVar( 'cid', '' );
        $id = $cid[0]?$cid[0]:'';        
        $action = "edit";        
		$totalAttachFile = $jacconfig["comments"]->get("total_attach_file", 5);				
		$theme = $jacconfig["layout"]->get("theme", "default");
		$session = &JFactory::getSession();	
		if(JRequest::getVar("jacomment_theme", '')){
			jimport( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar("jacomment_theme");
			if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
				$theme =  $themeURL;						
			}
			$session->set('jacomment_theme', $theme);			
		}else{
			if($session->get('jacomment_theme', null)){
				$theme = $session->get('jacomment_theme', $theme);
			}
		}				
		$attachFileType	 = $jacconfig["comments"]->get("attach_file_type", "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");				
		$listFiles		 = JRequest::getVar("listfile");		
		
		$helper = new JACommentHelpers();
		require_once $helper->jaLoadBlock("comments/attach.php");
    }
    
    function show_quote(){    	
        $object = array ();
        $k = 0;
        $id = JRequest::getInt("id",0);
        $model = & $this->getModel ('comments');
        $helper = new JACommentHelpers();
        $item = $model->getItem($id);
        //textCounter('newcomment', 'jaCountText');
                          
        $object [$k] = new stdClass ( );
        $object [$k]->id = '#newcomment';
        $object [$k]->type = 'appendAfter';
        $object [$k]->status = 'ok';     
        if(strpos($item->comment, "[QUOTE") !== false && strpos($item->comment, "[/QUOTE") !== false){
        	$item->comment = preg_replace("/\[QUOTE(.*)\[\/QUOTE\]/iUs", "", $item->comment);	   
        }
        
        $object [$k]->content = '[QUOTE='.$item->name.':'. $item->id .']'.trim($item->comment).'[/QUOTE]';
                        
        echo $helper->parse_JSON_new ( $object );
		exit ();	
    }
    
    function getCommentAnchor(){
    	$id = JRequest::getInt("id", 0);
    	setcookie('commentid1', $id);
    	$_COOKIE['commentid1'] = $id;
    	echo $_COOKIE['commentid1'];exit;
    	/*
    	$session = &JFactory::getSession();																
		$session->set('JACommentID', $id);
		echo $id;
		exit();*/
    }
    
}
?>
