<?php
/**
 * @version		$Id: slides.php 576 2011-07-28 10:14:16Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSControllerSlides extends JController {

	function display() {
		JRequest::setVar('view', 'slides');
		parent::display();
	}

	function publish() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->publish();
		$this->setRedirect('index.php?option=com_fpss&view=slides');
	}

	function unpublish() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->unpublish();
		$this->setRedirect('index.php?option=com_fpss&view=slides');
	}

	function saveorder() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id', array(0), 'post', 'array'));
		$model->setState('order', JRequest::getVar('order', array(0), 'post', 'array'));
		$model->saveorder();
		$document = &JFactory::getDocument();
		if($document->getType() == 'html') {
			$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_NEW_ORDERING_SAVED'));
		}
		else {
			$mainframe = &JFactory::getApplication();
			$mainframe->close();
		}
	}

	function featuredsaveorder() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id', array(0), 'post', 'array'));
		$model->setState('featuredOrder', JRequest::getVar('featuredOrder', array(0), 'post', 'array'));
		$model->featuredsaveorder();
		$document = &JFactory::getDocument();
		if($document->getType() == 'html') {
			$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_NEW_ORDERING_SAVED'));
		}
		else {
			$mainframe = &JFactory::getApplication();
			$mainframe->close();
		}
	}

	function featured() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->featured();
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_FEATURED_STATE_UPDATED'));
	}

	function accessregistered() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->accessregistered();
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_NEW_ACCESS_SETTING_SAVED'));
	}

	function accessspecial() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->accessspecial();
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_NEW_ACCESS_SETTING_SAVED'));
	}

	function accesspublic() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->accesspublic();
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_NEW_ACCESS_SETTING_SAVED'));
	}

	function remove() {
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('slides');
		$model->setState('id', JRequest::getVar('id'));
		$model->remove();
		$model->cleanUp();
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_DELETE_COMPLETED'));
	}

	function add() {
		$this->setRedirect('index.php?option=com_fpss&view=slide');
	}

	function edit() {
		$id = JRequest::getVar('id');
		JArrayHelper::toInteger($id);
		$this->setRedirect('index.php?option=com_fpss&view=slide&id='.$id[0]);
	}

	function stats() {
		JLoader::register('FPSSHelperHTML', JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
		$model = & $this->getModel('slides');
		$model->setState('catid', JRequest::getInt('fpssModuleCategory'));
		$model->setState('timeRange', JRequest::getInt('fpssModuleTimeRange'));
		$model->setState('limit', JRequest::getInt('fpssModuleLimit'));
		$response = $model->stats();
		echo FPSSHelperHTML::getJSON($response);
		$mainframe = &JFactory::getApplication();
		$mainframe->close();
	}

}
