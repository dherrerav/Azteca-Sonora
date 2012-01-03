<?php
// No direct access
defined('_JEXEC') or die;

/**
 * Content component helper.
 *
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		1.6
 */
class J2XMLImporterHelper
{
	public static $extension = 'com_j2xmlimporter';

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_content';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}