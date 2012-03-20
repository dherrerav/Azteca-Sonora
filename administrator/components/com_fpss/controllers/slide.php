<?php
/**
 * @version		$Id: slide.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSControllerSlide extends JController {

	function display() {
		JRequest::setVar('view', 'slide');
		parent::display();
	}

	function save(){
		JRequest::checkToken() or jexit('Invalid Token');
		$data = JRequest::get('post');
		$data['text'] = JRequest::getVar('text', '', 'post', 'string', 2);
		$data['featured'] = (int)JRequest::getBool('featured');
		$data['dummy'] = JRequest::getCmd('dummy');
		$model = &$this->getModel('slide');
		$model->setState('data', $data);
		if(!$model->save()){
			$this->setRedirect('index.php?option=com_fpss&view=slide', $model->getError(), 'error');
			return false;
		}
		$this->setRedirect('index.php?option=com_fpss&view=slides', JText::_('FPSS_SLIDE_SAVED'));		
	}

	function apply(){
		JRequest::checkToken() or jexit('Invalid Token');
		$data = JRequest::get('post');
		$data['text'] = JRequest::getVar('text', '', 'post', 'string', 2);
		$data['featured'] = (int)JRequest::getBool('featured');
		$data['dummy'] = JRequest::getCmd('dummy');
		$model = &$this->getModel('slide');
		$model->setState('data', $data);
		if(!$model->save()){
			$this->setRedirect('index.php?option=com_fpss&view=slide', $model->getError(), 'error');
			return false;
		}
		$this->setRedirect('index.php?option=com_fpss&view=slide&id='.$model->getState('id'), JText::_('FPSS_SLIDE_SAVED'));
	}

	function saveAndNew(){
		JRequest::checkToken() or jexit('Invalid Token');
		$data = JRequest::get('post');
		$data['text'] = JRequest::getVar('text', '', 'post', 'string', 2);
		$data['featured'] = (int)JRequest::getBool('featured');
		$data['dummy'] = JRequest::getCmd('dummy');
		$model = &$this->getModel('slide');
		$model->setState('data', $data);
		if(!$model->save()){
			$this->setRedirect('index.php?option=com_fpss&view=slide', $model->getError(), 'error');
			return false;
		}
		$this->setRedirect('index.php?option=com_fpss&view=slide', JText::_('FPSS_SLIDE_SAVED'));
	}
	
	function cancel(){
		JRequest::checkToken() or jexit('Invalid Token');
		$model = &$this->getModel('slides');
		$model->setState('id', JRequest::getCmd('dummy'));
		$model->cleanUp();
		$this->setRedirect('index.php?option=com_fpss&view=slides');
	}
	
	function upload(){
		JRequest::checkToken() or jexit('Invalid Token');
		JLoader::register('FPSSHelperHTML', JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
		$params = &JComponentHelper::getParams('com_fpss');
		$memoryLimit = (int)$params->get('memoryLimit');
		if($memoryLimit > (int)ini_get('memory_limit')) {
			ini_set('memory_limit', $memoryLimit.'M');
		}
		$model = &$this->getModel('slide');
		$model->setState('data', JRequest::get('post'));
		$model->setState('files', JRequest::get('files'));
		$response = $model->upload();
		echo FPSSHelperHTML::getJSON($response);
		$mainframe = &JFactory::getApplication();
		$mainframe->close();
	}

	function populate(){
		JLoader::register('FPSSHelperHTML', JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
		$model = &$this->getModel('slide');
		$model->setState('id', JRequest::getInt('id'));
		$model->setState('type', JRequest::getCmd('type'));
		$response = $model->populate();
		echo FPSSHelperHTML::getJSON($response);
		$mainframe = &JFactory::getApplication();
		$mainframe->close();
	}

	function getLiveTitle(){
		$model = &$this->getModel('slide');
		$model->setState('id', JRequest::getInt('id'));
		$model->setState('type', JRequest::getCmd('type'));
		$response = $model->getLiveTitle();
		echo $response;
		$mainframe = &JFactory::getApplication();
		$mainframe->close();
	}
	
	function resetHits(){
		JRequest::checkToken() or jexit('Invalid Token');
		$model = &$this->getModel('slide');
		$model->setState('id', JRequest::getInt('id'));
		$model->resetHits();
		$this->setRedirect('index.php?option=com_fpss&view=slide&id='.$model->getState('id'), JText::_('FPSS_SUCCESSFULLY_RESET_SLIDE_HITS'));
	}

}