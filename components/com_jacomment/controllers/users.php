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
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JACommentControllerUsers extends JACommentController {
	
	function display() {
		parent::display ();
	}
	
	
	function setEmailNotificationReferences() {
		$db = & JFactory::getDBO ();
		$user = & JFactory::getUser ();
		
		if ($user->id) {	
			$user->setParam ( 'votedCommentUpdateNotification', JRequest::getInt("votedCommentUpdateNotification",0) );
			$user->setParam ( 'receive', JRequest::getInt("receive",0) );	
			$user->setParam ( 'often', JRequest::getInt('often',0));
			$user->save();			
		}
		
		$object = array();
		$k = 0;
		$object[$k] = new stdClass();
		$object[$k]->id = '#jav-email-preference .jav-msg-successful';
		$object[$k]->attr = 'html';
		$object[$k]->content = JText::_('SAVE_SUCCESSFUL');
				
		$helper = new JACommentHelpers();		
		echo $helper->parse_JSON_new ( $object );
		exit ();
	}
    
    function login_old()
    {
        $helper = new JACommentHelpers ( );
        $app = JFactory::getApplication();
        // Check for request forgeries
        JRequest::checkToken('request') or jexit( 'Invalid Token' );
		
        $options = array();

        $credentials = array();
        $credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
        $credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

        $object = array ();
        $k = 0;
        
        //preform the login action
        $error = $app->login($credentials, $options);

        if(JError::isError($error))
        {
            $helper->displayInform(JText::_ ( "Username or password is incorrect" ), $k, $object);
        }
        else
        {
            $k = 0;
            $object [$k] = new stdClass ( );
            
            $object [$k]->id = '#jac-text-guest';
            $object [$k]->type = 'html';
            $object [$k]->status = 'ok';
            $object [$k]->content = 'Posting as '.$credentials['username'].'(<a href="'.JURI::base().'index.php?option=com_jacomment&view=users&task=logout_rpx">Logout<\/a>)';
            $k++;
            
            $helper->displayInform(JText::_ ( "Login successfully" ), $k, $object);
            
            //
            $jquery = '';
            $arrid = explode(',', 'comment_as,other_field');
            for($i=0; $count=sizeof($arrid), $i<$count; $i++){
                $jquery .= "jQuery('#".$arrid[$i]."').remove();";
            }

            $jq = "<script language='javascript' type='text/javascript'>
                        jQuery(document).ready( function() { 
                                                ".$jquery."                                                
                                            });
                    </script>";
            $helper->showOtherField($jq, $k, $object);
            
            // ++ add by congtq 08/12/2009
            $currentUserInfo = JFactory::getUser ();            
            $model = $this->getModel('comments');               
            $items = $model->getItems(' AND userid='.$currentUserInfo->id);
            //print_r($items);
            for($k=0; $count=sizeof($items), $k<$count; $k++){
                $object [$k+3]->id = '#edit-delete-'.$items[$k]->id;
                $object [$k+3]->type = 'html';
                $object [$k+3]->status = 'ok';
                $object [$k+3]->content = '<a href="javascript:editComment('.$items[$k]->id.', \''.JText::_("REPLY").'\')" title="'.JText::_("EDIT_COMMENT").'">'.JText::_("EDIT").'</a>&nbsp;<a href="javascript:deleteComment('.$items[$k]->id.'" title="'. JText::_("DELETE_COMMENT") .'" title="'.JText::_("EDIT_COMMENT").'">'.JText::_("DELETE").'</a>';
                
            }
            $k ++;
            // -- add by congtq 08/12/2009
         
        }
        
       	echo $helper->parse_JSON_new ( $object );
		exit ();
    }
    
    function signin_old(){
		$app = JFactory::getApplication();
        
        // Check for request forgeries
        JRequest::checkToken('request') or jexit( 'Invalid Token' );

        $options = array(); 
        
        $credentials = array();
        $credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
        $credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);
        
        //preform the login action
        $error = $app->login($credentials, $options);

        if(JError::isError($error)){
            JRequest::setVar('view', 'users');        
            JRequest::setVar('layout', 'login');        
            parent::display();           
                                                                                                   
        }else{
            $document =& JFactory::getDocument();
            $helper = new JACommentHelpers ( );
            
            $jquery = '';
                
            // hide #comment_as, #other_field
            $arrid = explode(',', 'comment_as,other_field');
            for($i=0; $count=sizeof($arrid), $i<$count; $i++){
                $jquery .= "jQuery('#".$arrid[$i]."', window.parent.document).remove();";
            }                      
            
            // get comment
            $currentUserInfo = JFactory::getUser ();
            $model = $this->getModel('comments');               
                  
            
            $isSpecialUser = $helper->isSpecialUser();

            $cond = '';
            // if is NOT SpecialUser then show links by UserID, else show all link Edit/Delete
            if(!$isSpecialUser){
                $cond = ' AND userid='.$currentUserInfo->id;
            }
            $items = $model->getItems($cond);
            
            for($k=0; $count=sizeof($items), $k<$count; $k++){
                $jquery .= "jQuery('#edit-delete-".$items[$k]->id."', window.parent.document).html('<a href=\"javascript:editComment(\'".$items[$k]->id."\', \'".JText::_("EDIT")."\')\" title=\'" . JText::_("EDIT") . "\'>".JText::_("EDIT")."</a>&nbsp;<a href=\"javascript:deleteComment(\'".$items[$k]->id."\', \'".JText::_("DELETE")."\')\" title=\'". JText::_("DELETE") ."\'>".JText::_("DELETE")."</a>');";
            }           
            
            // show link logout and close popup
            $logout = JTEXT::_('Posting as ').$currentUserInfo->username.'(<a href="'.JURI::base().'index.php?option=com_jacomment&view=users&task=logout_rpx">'.JTEXT::_('Logout').'</a>)';
            $jquery .= "
                        jQuery('#jac-text-guest', window.parent.document).html('".$logout."');
                        jQuery('#ja-popup', window.parent.document).fadeOut('slow', function() {
                            jQuery('#ja-popup', window.parent.document).remove();
                        });            
            ";
            
            // show and hide some #id            
                                        
            $document->addScriptDeclaration("jQuery(document).ready( function() { 
                                                   ".$jquery."                                            
                                                });");
                                                            
        }
    }
    
    function signin(){
		$app = JFactory::getApplication();
        
        // Check for request forgeries
        JRequest::checkToken('request') or jexit( 'Invalid Token' );

        $options = array(); 
        
        $credentials = array();
        $credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
        $credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);
        
        //preform the login action
        $error = $app->login($credentials, $options);

        if(JError::isError($error)){
            JRequest::setVar('view', 'users');        
            JRequest::setVar('layout', 'login');        
            parent::display();           
                                                                                                   
        }else{                    	
			$session = &JFactory::getSession();
			$return  = $session->get('returnLink', null);
			if(!$return)
				$return  = JRequest::getVar('return');	
			
            $document =& JFactory::getDocument();
            $document->addScriptDeclaration("jQuery(document).ready( function() { 
                                                   window.parent.document.location.href = '".$return."'
                                                   jQuery('#ja-popup', window.parent.document).remove();
                                                });");
        }
    }
    // for rpx
    function login(){
        $currentUserInfo = JFactory::getUser ();
        $ses_url  = "";
        if($currentUserInfo->id){             
        	if(isset( $_SESSION['ses_url'])){
	        	$ses_url = $_SESSION['ses_url'];
	            $this->setRedirect($ses_url);
        	}
        }
        JRequest::setVar('view', 'users');        
        JRequest::setVar('layout', 'login');
        parent::display();            
    }
    
    function logout_rpx(){        
        // logout joomla account
        $app = JFactory::getApplication();
        $app->logout();

        // return
        $return = $_SERVER['HTTP_REFERER'];
        $this->setRedirect($return); 
        
    } 
}

?>