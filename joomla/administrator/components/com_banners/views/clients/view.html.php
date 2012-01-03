<?php
/**
 * @version		$Id: view.html.php 21148 2011-04-14 17:30:08Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of clients.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class BannersViewClients extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/banners.php';

		$canDo	= BannersHelper::getActions();

		JToolBarHelper::title(JText::_('COM_BANNERS_MANAGER_CLIENTS'), 'banners-clients.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('client.add','JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('client.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('clients.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('clients.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('clients.archive','JTOOLBAR_ARCHIVE');
			JToolBarHelper::custom('clients.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('clients.trash','JTOOLBAR_TRASH');
		}
		if ( $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'clients.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_banners');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_BANNERS_CLIENTS');
	}
}
