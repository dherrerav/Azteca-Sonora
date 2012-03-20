<?php
/**
 * @version		$Id: categories.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSControllerCategories extends JController {

	function display() {
		JRequest::setVar('view', 'categories');
		parent::display();
	}

	function publish() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('categories');
		$model->setState('id', JRequest::getVar('id'));
		$model->publish();
		$this->setRedirect('index.php?option=com_fpss&view=categories');
	}

	function unpublish() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('categories');
		$model->setState('id', JRequest::getVar('id'));
		$model->unpublish();
		$this->setRedirect('index.php?option=com_fpss&view=categories');
	}

	function remove() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('categories');
		$model->setState('id', JRequest::getVar('id'));
		$model->remove();
		$this->setRedirect('index.php?option=com_fpss&view=categories', JText::_('FPSS_DELETE_COMPLETED'));
	}

	function add() {
		$this->setRedirect('index.php?option=com_fpss&view=category');
	}

	function edit() {
		$id = JRequest::getVar('id');
		JArrayHelper::toInteger($id);
		$this->setRedirect('index.php?option=com_fpss&view=category&id='.$id[0]);
	}
	
	function saveorder() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('categories');
		$model->setState('id', JRequest::getVar('id', array(0), 'post', 'array'));
		$model->setState('order', JRequest::getVar('order', array(0), 'post', 'array'));
		$model->saveorder();
		$document = &JFactory::getDocument();
		if($document->getType() == 'html') {
			$this->setRedirect('index.php?option=com_fpss&view=categories', JText::_('FPSS_NEW_ORDERING_SAVED'));
		}
		else {
			$mainframe = &JFactory::getApplication();
			$mainframe->close();
		}
	}
}