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

class jacommentControllercomment extends JACommentController
{
	
 function __construct( $default = array() )
    {
        parent::__construct( $default );
        // Register Extra tasks
        JRequest::setVar('view','comment');
        $this->registerTask( 'add',        'edit' );
        $this->registerTask( 'apply',    'save' );
    }
    
 	function display(){	    	
    	$user = JFactory::getUser();
 		$task =$this->getTask();
		switch ($task){
			case 'verify':
				$post = JRequest::get ( 'post', JREQUEST_ALLOWHTML );				
				if(count($post) > 0 && $post['email'] != '' && $post['payment_id'] != '') {					
					$objVerify = new JACommentLicense($post['email'], $post['payment_id']);
					$objVerify->verify_license($post['email'], $post['payment_id']);
				}
				JRequest::setVar ( 'layout', 'verify' );
				break;			
			default:				
		}
        if ($user->id==0)
        {
        	JError::raiseWarning(1001,JText::_("YOU_MUST_BE_SIGNED_IN"));
        	$this->setRedirect(JRoute::_("index.php?option=com_user&view=login"));
        	return ;
        }	        
		parent::display();
    }     	
}
?>