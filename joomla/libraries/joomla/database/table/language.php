<?php
/**
 * @version		$Id: language.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

jimport('joomla.database.table');

/**
 * Languages table.
 *
 * @package		Joomla.Framework
 * @subpackage	Table
 * @since		1.6
 */
class JTableLanguage extends JTable
{
	/**
	 * Constructor
	 *
	 * @param	JDatabase
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__languages', 'lang_id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @return boolean True on success
	 */
	public function check()
	{
		if (trim($this->title) == '') {
			$this->setError(JText::_('JLIB_DATABASE_ERROR_LANGUAGE_NO_TITLE'));
			return false;
		}

		return true;
	}
}
