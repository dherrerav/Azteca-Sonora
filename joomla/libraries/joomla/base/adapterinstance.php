<?php
/**
 * @version		$Id: adapterinstance.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Framework
 * @subpackage	Base
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Adapter Instance Class
 *
 * @package		Joomla.Framework
 * @subpackage	Base
 * @since		1.6
 */
class JAdapterInstance extends JObject {

	/**
	 * @var		object	Parent
	 * @since	1.6
	 */
	protected $parent = null;

	/**
	 * @var		object	Database
	 * @since	1.6
	 */
	protected $db = null;

	/**
	 * Constructor
	 *
	 * @param	object	$parent		Parent object [JAdapter instance]
	 * @param	object	$db			Database object [JDatabase instance]
	 * @param 	array	$options	Configuration Options
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function __construct(&$parent, &$db, $options = Array())
	{
		// set the properties from the options array that is passed in
		$this->setProperties($options);

		// set the parent and db in case $options for some reason overrides it
		$this->parent = &$parent;
		$this->db = &$db ? $db : JFactory::getDBO(); // pull in the global dbo in case
	}

	/**
	 * Retrieves the parent object
	 *
	 * @return 	object parent
	 * @since 	1.6
	 */
	public function getParent()
	{
		return $this->parent;
	}
}