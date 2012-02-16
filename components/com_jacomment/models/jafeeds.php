<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class JobBoardModelJAFeeds extends JModel
{
	var $_table = null;
	var $_data = null;
	var $_id = null;	
	var $_content = null;
	
	function __construct()
	{
		parent::__construct();				
		$id = JRequest::getVar('feed_id',  0, '', 'int');
		$this->setId((int)$id);
	}
	
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}
	
		/**
    * Get email table instance
    * @return JTable Email table object
    */
    function &_getTable(){
        if($this->_table == null){
        	$this->_table = &JTable::getInstance('JA_Feeds', 'JobBoardTable');
		}
		return $this->_table;
	}
	
		/**
	* Get email item by ID
	* @return Email Table object
	*/
	function getItem(){
		static $item;
		if (isset($item)) {
			return $item;
		}

		$table =& $this->_getTable();

		// Load the current item if it has been defined
		$edit	= JRequest::getVar('edit',true);
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		
		if ($edit) {
			$table->load($cid[0]);
		}
		
		if ((($table->id == null)||($table->id==0))&&JRequest::getVar('layout')!='form')
			$table=$this->getDefault($table);
		return $table;	    
	}
	function getDefault($item)
	{
		global $jbconfig;
		$item->feed_type = $jbconfig['feeds']->get('defaultType');
		$item->feed_description = $jbconfig['feeds']->get('description');
		$item->msg_count = $jbconfig['feeds']->get('count');
		$item->msg_orderby = $jbconfig['feeds']->get('orderby');
		$item->msg_numWords = $jbconfig['feeds']->get('numWords');
		$item->feed_renderAuthorFormat = $jbconfig['feeds']->get('renderAuthorFormat');
		$item->feed_renderHTML = $jbconfig['feeds']->get('renderHTML');
		$item->feed_cache = $jbconfig['feeds']->get('cache');
		return $item;
	}
	
	function getURLParams()
	{
		$urlparams = array();
		$urlparams['type'] = JRequest::getVar('type');
		$urlparams['name'] = JRequest::getVar('name');
		$urlparams['description'] = JRequest::getVar('description');
		$urlparams['cache'] = JRequest::getVar('cache');
		$urlparams['category'] = JRequest::getVar('category');
		$urlparams['location'] = JRequest::getVar('location');
		$urlparams['effected_date'] = JRequest::getVar('effected_date');
		$urlparams['premium'] = JRequest::getVar('premium');
		$urlparams['order_by'] = JRequest::getVar('order_by');
		$urlparams['job_number'] = JRequest::getVar('job_number');
		$urlparams['exitems'] = JRequest::getVar('exitems');
		$urlparams['inemployers'] = JRequest::getVar('inemployers');
		$urlparams['exemployers'] = JRequest::getVar('exemployers');
		return $urlparams;
		
	}
	
	function getContent()
	{
		global $jacconfig;
		$app = JFactory::getApplication();
		$feed = getItemByFieldName('ja_feeds','feed_alias',"'".JRequest::getVar('alias')."'");
		if (isset($feed[0]))
			$feed = $feed[0];
		else {
			$feed = & $this->getItem();
			$feed->filter_date = (JRequest::getVar('effected_date')!=null)?JRequest::getVar('effected_date'):$feed->filter_date;
			$feed->msg_count = (JRequest::getVar('job_number')!=null)?JRequest::getVar('job_number'):$feed->msg_count;
			$feed->filter_is_premium = (JRequest::getVar('premium')!=null)?JRequest::getVar('premium'):$feed->filter_is_premium;
			$feed->filter_exitems = (JRequest::getVar('exitems')!=null)?JRequest::getVar('exitems'):$feed->filter_exitems;
			$feed->filter_exemployers = (JRequest::getVar('exemployers')!=null)?JRequest::getVar('exemployers'):$feed->filter_exemployers;
			$feed->filter_inemployers = (JRequest::getVar('inemployers')!=null)?JRequest::getVar('inemployers'):$feed->filter_inemployers;
			$feed->msg_orderby = (JRequest::getVar('order_by')!=null)?JRequest::getVar('order_by'):$feed->msg_orderby;
			$feed->filter_zipcode = (JRequest::getVar('zipcode')!=null)?JRequest::getVar('zipcode'):$feed->filter_zipcode;
		}
		// Filter job - begin -
		require_once(JPATH_COMPONENT_SITE.DS.'models'.DS.'jajobs.php');
		$model = new JobBoardModelJAJobs();
		$where_more = '';
		$where_more .= " and a.status='Approved' ";
        $where_more .= ' and(a.effected_date<=now()) and ( (DATE_ADD(a.effected_date, INTERVAL '. (int)$jbconfig['posts']->get('posts_display_days', 30). ' DAY) >= now()  AND a.is_hotjob=0) or (DATE_ADD(a.effected_date, INTERVAL '. (int)$jbconfig['posts']->get('posts_show_days_elapsed', 30). ' DAY) >= now()  AND a.is_hotjob=1) )';
        if ($feed->filter_zipcode)
			$where_more .= " and a.zipcode='".$feed->filter_zipcode."'";
        if (($feed->filter_date!='')&&($feed->filter_date!=null)&&($feed->filter_date>0))
			$where_more .= " and  (DATE_ADD(a.effected_date, INTERVAL ". (int)$feed->filter_date. " DAY) >= now())";
		if ($feed->filter_is_premium)
			$where_more .= " and a.is_hotjob=1";
		if ($feed->filter_exitems!='')	
			$where_more .= " and !(a.id IN ($feed->filter_exitems))";
		if ($feed->filter_exemployers!='')	
			$where_more .= " and !(a.user_id IN ($feed->filter_exemployers))";
		if ($feed->filter_inemployers!='')	
			$where_more .= " and (a.user_id IN ($feed->filter_inemployers))";
		if ($feed->msg_orderby=='rdate')
			$order_clause = "a.effected_date desc";
		else 	
			$order_clause = "a.effected_date asc";
		//Filter job - end -
		$content = $model->getItems($where_more,$feed->msg_count,0,$order_clause);
		return $content;
		
	}
	
	function getMenuItemArray(){
		$type = 'content_blog_section';
		$database =& JFactory::getDBO();;
		$itemids = NULL;
	
		$database->setQuery("SELECT id, componentid "
							. "\n FROM #__menu "
							. "\n WHERE type = '$type'"
							. "\n AND published = 1");
		$rows = $database->loadObjectList();
		foreach ($rows as $row) {
			$itemids[$row->componentid] = $row->id;
		}
		return $itemids;
	}
	
		function getItems(){
		global $option;
		$app = JFactory::getApplication();
	    $limit				= $app->getUserStateFromRequest( 'global.list.limit',	'limit',$app->getCfg( 'list_limit' ),	'int' );
		$limitstart			= $app->getUserStateFromRequest( $option.'.salary.limitstart','limitstart',0,	'int' );
		
		$db = &JFactory::getDBO();
		$query = $this->_buildQuery(" AND f.is_user=0");
		$db->setQuery($query);
		//print_r($db->getQuery($query));exit;
		$items = $db->loadObjectList();
		
		$total = count( $items );

		jimport('joomla.html.pagination');
		$this->_pagination = new JPagination( $total, $limitstart, $limit );
		
		// slice out elements based on limits
		$list = array_slice( $items, $this->_pagination->limitstart, $this->_pagination->limit );
		
		return $list;
	}
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
			
		}
		
		return $this->_pagination;
	}
	function _buildQuery($where_more = '', $limit = 0, $limitstart = 0)
	{
    	global $option;
    	$db =& JFactory::getDBO();
		$app = JFactory::getApplication();
    	$option_1 = $option.'jafeeds';
    	$search				= $app->getUserStateFromRequest( $option_1.'.feeds.search',              'search',           '',         'string' );
		$filter_order		= $app->getUserStateFromRequest( $option_1.'.feeds.filter_order',		'filter_order',		'f.feed_name',	'cmd' );
		$filter_order_Dir	= $app->getUserStateFromRequest( $option_1.'.feeds.filter_order_Dir',	'filter_order_Dir',	'ASC',	'word' );
		$filter_state		= $app->getUserStateFromRequest( $option_1.'.filter_state', 'filter_state', '',	'word' );
		
		$search				= JString::strtolower( $search );
		$orderby	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
    	$where = ' WHERE 1=1 ';
    	if($search){
    		$where = " AND LOWER(value) like ".$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
    	}
    	if ($where_more!='')
    		$where .= $where_more;
    	if ( $filter_state )
		{
			if ( $filter_state == 'P' ) {
				$where .= ' AND f.published = 1';
			} else if ($filter_state == 'U' ) {
				$where .= ' AND f.published = 0';
			}
		}
        $query = "SELECT   * ".
				 "FROM 	`#__ja_feeds` as f ".
				 $where.
				 $orderby;

        return $query;
	}
	
	function store()
	{
		$db		=& JFactory::getDBO();
		$row	=& $this->getItem();
		$post    = JRequest::get('request', JREQUEST_ALLOWHTML);
		if (is_array($post['filter_cat_id']))
			$post['filter_cat_id'] = implode(',',$post['filter_cat_id']);
		if (is_array($post['filter_location_id']))
			$post['filter_location_id'] = implode(',',$post['filter_location_id']);
		if (!$row->bind( $post )) {
			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return JText::_("NOT_BIND_DATA");
		}

		if ($row->check() != 'SUCCESS')
		{
//			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return false;
		}

		if (!$row->store())
		{
			echo "<script> alert('".$row->getError(true)."'); window.history.go(-1); </script>\n";
			return JText::_('STORE_FAIL');
			//return false;
		}
		return $row->id;
	}
}
?>