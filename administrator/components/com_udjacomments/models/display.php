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
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class UdjaCommentsModelDisplay extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	public function getItem()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		// Select some fields
		$sql = 'SELECT * FROM `#__udjacomments` WHERE id='.JRequest::getInt('id').' LIMIT 1';
		$db->setQuery($sql);
		$db->Query();
		
		$result = $db->loadObject();
		
		return $result;
	}
}