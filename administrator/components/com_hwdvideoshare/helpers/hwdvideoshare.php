<?php
/**
 *    @version [ Nightly Build ]
 *    @package hwdVideoShare
 *    @copyright (C) 2007 - 2011 Highwood Design
 *    @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 ***
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * hwdVideoShare helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_hwdvideoshare
 * @since		1.6
 */
class hwdVideoShareHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 * @since	1.6
	 */
	public static function addSubmenu($vName = 'videos')
	{
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_HOME),
			'index.php?option=com_hwdvideoshare',
			$vName == 'home'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_VIDEOS),
			'index.php?option=com_hwdvideoshare&task=videos',
			$vName == 'videos'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_CATS),
			'index.php?option=com_hwdvideoshare&task=categories',
			$vName == 'categories'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_GROUPS),
			'index.php?option=com_hwdvideoshare&task=groups',
			$vName == 'groups'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_SS),
			'index.php?option=com_hwdvideoshare&task=serversettings',
			$vName == 'serversettings'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_GS),
			'index.php?option=com_hwdvideoshare&task=generalsettings',
			$vName == 'generalsettings'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_CONVERTOR),
			'index.php?option=com_hwdvideoshare&task=converter',
			$vName == 'converter'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_APPROVALS),
			'index.php?option=com_hwdvideoshare&task=approvals',
			$vName == 'approvals'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_FLAGGED),
			'index.php?option=com_hwdvideoshare&task=reported',
			$vName == 'reported'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_IMPORT),
			'index.php?option=com_hwdvideoshare&task=import',
			$vName == 'import'
		);
		JSubMenuHelper::addEntry(
			JText::_(_HWDVIDS_SECTIONHEAD_CLUP),
			'index.php?option=com_hwdvideoshare&task=maintenance',
			$vName == 'maintenance'
		);
		//if ($vName=='categories') {
		//	JToolBarHelper::title(
		//		JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('com_weblinks')),
		//		'weblinks-categories');
		//}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
	}
}
