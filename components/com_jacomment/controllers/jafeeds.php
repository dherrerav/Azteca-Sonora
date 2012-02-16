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

jimport('joomla.application.component.controller');
/**
* This controller is used for configuration feature of the component
*/
class JACommentControllerJaFeeds extends JACommentController{
	function __construct()
	{
		parent::__construct();	
		
	}

	function display()
	{
		parent::display();
	}

	function save()
	{
		$model = $this->getModel('jafeeds');
		JArrayHelper::toInteger($cid, array(0));
		if ($id=$model->store()) {
			
			$msg = JText::_('SUCCESSFULLY_CREATED_FEED' );
			$this->setRedirect(JRoute::_("index.php?option=". JBCOMNAME ."&view=jafeeds&layout=feed_link&cid[]=$id&Itemid=1000"),$msg);
		} else {
			JError::raiseWarning(1,JText::_('FAIL_TO_SAVE_FEED_TEXT' ));
//			JRequest::setVar('option',JBCOMNAME);
//			JRequest::setVar('view','jafeeds');
			JRequest::setVar('Itemid','1000');
			JRequest::setVar('layout','form');
			JRequest::setVar('postback',true);
			
			parent::display();
		}
		
//		$this->setRedirect( JRoute::_("index.php?option=".JBCOMNAME."&view=jafeeds&cid[]=$id"), $msg );
		
	}
	function cancel()
	{
		$Itemid = &JRequest::getVar('Itemid');
        $this->setRedirect(JRoute::_("index.php?option=". JBCOMNAME ."&view=jafeeds&layout=guide&Itemid=".$Itemid));
	}
}