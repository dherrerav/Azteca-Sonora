<?php
/**
 * @version		$Id: category.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSControllerCategory extends JController {

	function display() {
		JRequest::setVar( 'view', 'category' );
		parent::display();
	}

	function save(){
		JRequest::checkToken() or jexit('Invalid Token');
		$model = &$this->getModel('category');
		$model->setState('data', JRequest::get('post'));
		if(!$model->save()){
			$this->setRedirect('index.php?option=com_fpss&view=categories', $model->getError(), 'error');
			return false;
		}
		$this->setRedirect('index.php?option=com_fpss&view=categories', JText::_('FPSS_CATEGORY_SAVED'));
	}

	function apply(){
		JRequest::checkToken() or jexit('Invalid Token');
		$model = &$this->getModel('category');
		$model->setState('data', JRequest::get('post'));
		if(!$model->save()){
			$this->setRedirect('index.php?option=com_fpss&view=category&id='.$model->getError(), 'error');
			return false;
		}
		$this->setRedirect('index.php?option=com_fpss&view=category&id='.$model->getState('id'));
	}

	function cancel(){
		$this->setRedirect('index.php?option=com_fpss&view=categories');
	}

}