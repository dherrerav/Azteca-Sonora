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

class JACommentControllerReports extends JACommentController
{
	
	function __construct( $default = array() )
	{
		parent::__construct( $default );
		// Register Extra tasks
		JRequest::setVar('view','reports');
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'dismiss', 'dismiss' );
		$this->registerTask( 'dismiss_all', 'dismiss_all' );
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
		$this->setRedirect('index.php?option=com_jacomment&view=reports');
		return TRUE; 	  
	}    
	
	function save(&$errors=''){
	
		$task = $this->getTask ();
		$model=& $this->getModel('reports');
		$item = $model->getItem();
		$post    = JRequest::get('request');
		
		if (!$item->bind( $post )) 
		{
			$errors[]=JText::_("DO_NOT_BIND_DATA");
		
		}  
		if($errors)
		{
			return FALSE;
		}
		$item->title = trim($item->title);
		$errors=$item->check();
		
		if (count($errors)>0)
		{	    	   	
			return FALSE;
		}	 
		$where = " AND c.title = '$item->title' AND c.id!=$item->id";
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
		else $item->reorder(1);	
		if ($task != 'saveIFrame') {
			
			$link='index.php?option=com_jacomment&view=reports';
			if($this->getTask()=='apply')$link.="&task=edit&cid[]=".$item->id;
			$msg=JText::_('SAVE_DATA_SUCCESSFULLY');
			$this->setRedirect($link,$msg);
		
		}
		return $item->id;
	}
	
	function saveIFrame() {
	
		$post = JRequest::get ( 'request' );

		$errors=array();
		$id = $this->save ($errors);
		$helper = new JACommentHelpers ( );
		$objects = array ();
		
		if (count($errors)==0) {
									
			$model=& $this->getModel('reports');
		
			$item = $model->getItem ($id );	
			
			if($post['id']=='0')
				$objects [] = $helper->parseProperty ( "reload", "#reload" . $item->id, 1 );
			else 
				$objects [] = $helper->parseProperty ( "html", "#system-message", $helper->message ( 0, JText::_( "SAVE DATA SUCCESSFULLY" ) ) );
			$objects [] = $helper->parseProperty ( "html", "#title" . $item->id, $item->title );
		
			$objects [] = $helper->parsePropertyPublish ( "html", "#publish" . $item->id, $item->published,$number);
			
			$objects [] = $helper->parseProperty ( "value", "#order" . $item->id, $item->ordering);
		
		} else {
			$objects [] = $helper->parseProperty ( "html", "#system-message", $helper->message ( 1, $errors ) );
		
		}
		
		echo $helper->parse_JSON_new ( $objects );
		exit ();		
	}
	
	function publish()
	{
		$model = $this->getModel('reports');
		if(!$model ->published(1))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} else {
			$msg = JText::_('SAVE_DATA_SUCCESSFULLY' );
		}
		$this->setRedirect('index.php?option=com_jacomment&view=reports',$msg);
	}
	
	function unpublish()
	{
		$model = $this->getModel('reports');
		if(!$model->published(0))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} 
		else 
		{
			$msg = JText::_('SAVE_DATA_SUCCESSFULLY' );
		}
		$this->setRedirect('index.php?option=com_jacomment&view=reports',$msg);
	}
	function dismiss()
	{
		$id = JRequest::getInt ( 'id' );
		
		$model = $this->getModel('reports');
		if(!$model ->dismiss($id))
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} else {
			$msg = JText::_('DISMISS_DATA_SUCCESSFULLY' );
		}
		exit();
	}
	function dismiss_all()
	{
		$model = $this->getModel('reports');
		if(!$model ->dismiss_all())
		{
			JError::raiseWarning(1001, JText::_('ERROR_DATA_NOT_SAVED' ));
		} else {
			$msg = JText::_('DISMISS_DATA_SUCCESSFULLY' );
		}
		$this->setRedirect('index.php?option=com_jacomment&view=reports',$msg);
	}
	function remove(){
		$model = $this->getModel('reports');
		$errors=$model->remove();
		if($errors){
			foreach ($errors as $error)
				JError::raiseWarning(1001,$error);	
		}else 
			$msg=JText::_("DELETE_DATA_SUCCESSFULLY");
		$this->setRedirect('index.php?option=com_jacomment&view=reports',$msg);
	}

}
?>