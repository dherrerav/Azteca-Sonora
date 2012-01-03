<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Languages component
 *
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @since		1.5
 */
class LanguagesViewLanguage extends JView
{
	public $item;
	public $form;
	public $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/languages.php';

		JRequest::setVar('hidemainmenu', 1);
		$isNew = empty($this->item->lang_id);
		$canDo	= LanguagesHelper::getActions();

		JToolBarHelper::title(JText::_($isNew ? 'COM_LANGUAGES_VIEW_LANGUAGE_EDIT_NEW_TITLE' : 'COM_LANGUAGES_VIEW_LANGUAGE_EDIT_EDIT_TITLE'), 'langmanager.png');

		// If a new item, can save.
		if ($isNew && $canDo->get('core.create')) {
			JToolBarHelper::save('language.save','JTOOLBAR_SAVE');
		}

		//If an existing item, allow to Apply and Save.
		if (!$isNew && $canDo->get('core.edit')) {
			JToolBarHelper::apply('language.apply','JTOOLBAR_APPLY');
			JToolBarHelper::save('language.save','JTOOLBAR_SAVE');
		}

		// If an existing item, can save to a copy only if we have create rights.
		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('language.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		if ($isNew) {
			JToolBarHelper::cancel('language.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('language.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_EXTENSIONS_LANGUAGE_MANAGER_EDIT');
	}
}
