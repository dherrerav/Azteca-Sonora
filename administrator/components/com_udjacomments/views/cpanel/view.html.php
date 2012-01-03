<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package com_udjacomments
**/ 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * HelloWorlds View
 */
class UdjaCommentsViewCpanel extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null) 
	{		
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->mediaDir = $this->get('MediaDir');
		
		//deal with published/spam toggling
		$this->toggler();
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		
		//get necessary JS/CSS
		$this->get('Assets');
		
		// Set the toolbar
		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function toggler()
	{
		if (JRequest::getString('toggler') && JRequest::getInt('id') && !is_null(JRequest::getInt('val')))
		{
			//set vals for query
			$newVal = (JRequest::getInt('val') == 1) ? '0' : '1';
			$id = JRequest::getInt('id');
			$col = JRequest::getString('toggler');
			
			//if $col=is_spam and $newVal=1 we unpublish as well.
			$additional = ($col=='is_spam' && $newVal=='1') ? ', is_published=0' : '';
			
			//setup sql
			$sql = 'UPDATE `#__udjacomments` SET ' . $col . '=' . $newVal . $additional . ' WHERE id=' . $id;
			
			// Create a new query object.		
			$db = JFactory::getDBO();
			$db->setQuery($sql);
			$db->Query();
			
			//redirect out of headers
			$controller = JController::getInstance('UdjaComments');
			$controller->setRedirect( 'index.php?option=com_udjacomments', JText::_('COM_UDJACOMMENTS_TOGGLE_SUCCESS_MESSAGE'));
		}
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_UDJACOMMENTS_MANAGER_CPANEL'),'udjacomments');
		JToolBarHelper::deleteListX('', 'Cpanel.delete');
		JToolBarHelper::preferences('com_udjacomments');
	}
	
	
}