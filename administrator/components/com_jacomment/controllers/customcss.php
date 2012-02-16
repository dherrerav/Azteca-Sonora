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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
/**
* This controller is used for JAEmail feature of the component
*/
class JACommentControllerCustomcss extends JACommentController {
/**
     * Constructor
     */
    function __construct( $location = array())
    {
        parent::__construct( $location ); 
        // Register Extra tasks
        $this->registerTask( 'apply',   'save' );        
    }
    
    /**
    * Display current customcss of the component to administrator
    * 
    */
    function display(){
    	
    	switch($this->getTask())
		{			
			case 'edit':
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'edit', true );
				JRequest::setVar( 'layout', 'form' );				
			} break;
		}
		
		parent::display();
    }
    
    /**
    * Cancel current operation
    * 
    */
 	function cancel(){
    	$option	= JRequest::getCmd('option'); 	
        $this->setRedirect("index.php?option=$option&view=customcss");
	    return TRUE; 	  
 	}           
	
	/**
	* Save categories record
	*/
	function save(){
		$option	= JRequest::getCmd('option');
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$content = JRequest::getVar('content', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$file = JRequest::getVar('file', '');
		$path='';
		$template=JACommentHelpers::checkFileTemplate($file);
		if($template)
			$path=$template;
		else
			$path = JPATH_COMPONENT_SITE.DS.'asset'.DS.'css'.DS.$file;
		$msg='';
		if(JFile::exists($path)){
			$res = JFile::write($path, $content);
			if ($res) {
				$msg = JText::_('SAVE_DATA_SUCCESSFULLY').': '.$file;
			} else {
				JError::raiseWarning(1001,JText::_("ERROR_DATA_NOT_SAVED")." ".$file);	
			}			
		}
		else 
			JError::raiseWarning(1001,JText::_("FILE_NOT_FOUND_TO_EDIT"));

		
		switch ( $this->_task ) {
			case 'apply':
				$this->setRedirect( "index.php?option=$option&view=customcss&task=edit&file=$file" , $msg );
				break;

			case 'save':
			default:
				$this->setRedirect( "index.php?option=$option&view=customcss", $msg );
				break;
		}
		return TRUE;
	}
				
}