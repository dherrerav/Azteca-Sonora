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
class UdjaCommentsModelCpanel extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id,full_name,email,url,content,ip,is_spam,is_published');
		//order by
		$query->order('time_added DESC');
		// From the hello table
		$query->from('#__udjacomments');
		return $query;
	}
	
	public function getMediaDir()
	{
		return '../media/com_udjacomments/';
	}
	
	public function getAssets()
	{
		$doc =& JFactory::getDocument();
		$doc->addCustomTag('<style type="text/css">.icon-48-udjacomments { background-image:url("../media/com_udjacomments/images/udjacomments-48x48.png"); }</style>');
		JHTML::_('behavior.mootools');
		JHTML::_('behavior.modal');
	}
	
	/**
	* Method to delete record(s)
	*
	* @access    public
	* @return    boolean    True on success
	*/
	public function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		//get db object
		$dbo = JFactory::getDbo();
		
		foreach($cids as $cid) {
			$sql = 'DELETE FROM `#__udjacomments` WHERE id='.$cid;
			$dbo->setQuery($sql);
			if (!$dbo->Query()) {
				$this->setError('Error deleting comment :: '.$dbo->getErrorMsg());
				return false;
			}
		}
		
		return true;
	}
	
}