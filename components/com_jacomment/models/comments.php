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

defined ( '_JEXEC' ) or die ();
jimport ( 'joomla.application.component.model' );

class JACommentModelComments extends JModel {
	//var $_pagination = NULL;
	var $_total = 0;
	var $_childTotal = 0;
	var $_limit = 0;
	var $_limitStart = 0;
	var $_table = null;
	var $id = null;
	var $user_id = null;
	var $title = null;
	var $comment = null;
	var $type = null;
	var $arrayComment = null;
	var $mysqlVersion = 0;
	
	function __construct() {
		parent::__construct ();
		$this->mysqlVersion = $this->find_SQL_Version();
	}
	
	/**
	 * Get data list of configuration
	 * @return array  Array of objects contain configuration data
	 */
	function &getData() {
		// load data if it doesnnot already exists
		if (empty ( $this->_data )) {
			$query = $this->_buildQuery ();
			$this->_data = $this->_getList ( $query );
		}
		
		return $this->_data;
	}
	
	function getTotal($search) {
		$db = & JFactory::getDBO ();
		$query = $this->_buildQueryTotal ( $search );
		$db->setQuery ( $query );		
		return $db->loadResult ();
	}
	
	function checkSubOfComment($id) {
		$db = & JFactory::getDBO ();
		$query = "SELECT c.id FROM #__jacomment_items as c WHERE parentid = $id";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _buildQueryTotal($search) {
		// Get the WHERE and ORDER BY clauses for the query
		$where = $this->_buildContentWhere ( $search );
		$orderby = $this->_buildContentOrderBy ();
		
		$query = ' SELECT count(*) ' . ' FROM #__jacomment_items as c ' . $where . $orderby;
		
		return $query;
	}
	
	function getCustomerInfo($uid) {
		$db = JFactory::getDBO ();
		$query = "SELECT * FROM #__users WHERE id = $uid";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	// ++ add by congtq 29/10/2009 
	function array_merge_keys($array1, $array2) {
		foreach ( $array2 as $k => $v ) {
			if (! array_key_exists ( $k, $array1 )) {
				$array1 [$k] = $v;
			} else {
				if (is_array ( $v )) {
					$array1 [$k] = array_merge_keys ( $array1 [$k], $array2 [$k] );
				}
			}
		}
		return $array1;
	}
	
	function getTotalByType($search) {
		$db = JFactory::getDBO ();
		$query = $this->_buildQueryTotalByType ( $search );
		//die($query);		
		$db->setQuery ( $query );			
		$arr2 = $db->loadAssocList ();
		if (sizeof ( $arr2 ) > 0) {
			for($i = 0; $i < sizeof ( $arr2 ); $i ++) {
				$arr [$arr2 [$i] ['type']] = $arr2 [$i] ['total'];
			}
			
			for($j = 0; $j <= 2; $j ++) {
				if (! array_key_exists ( $j, $arr )) {
					$arr [$j] = 0;
				}
			}			 
			return $arr;
		}
	}
	
	function _buildQueryTotalByType($search) {
		// Get the WHERE and ORDER BY clauses for the query
		$where = $this->_buildContentWhere ( $search );
		$query = "SELECT count(*) as total, type FROM #__jacomment_items as c
                    $where
                    GROUP BY c.type";
		
		return $query;
	}
	
	function _buildQueryItemsByType($limitstart, $limit, $dosearch = false) {
		$db = JFactory::getDBO ();
		
		$where = '';
		$where = $this->_buildContentWhere ( $dosearch );
		$orderby = $this->_buildContentOrderBy ();
		//$orderby 	.= "LIMIT $limitstart, $limit";
		

		$feilds = ($dosearch) ? 'c.id' : '*';
		
		$query = "SELECT $feilds " . "FROM #__jacomment_items as c" . $where . $orderby;
		
		return $query;
	}
	
	function parse(&$items) {
		$count = count ( $items );
		if ($count > 0) {
			for($i = 0; $i < $count; $i ++) {
				$item = & $items [$i];
				$item->params = new JRegistry;
		        $item->params->loadJSON($item->params);
			}
		}
	}
	
	/**
	 * @return JTable log table object
	 */
	
	function &_getTable() {
		if ($this->_table == null) {
			$this->_table = &JTable::getInstance ( 'Comments', 'Table' );
		}
		return $this->_table;
	}
	
	function builQueryWhenSearch(&$search){
		$db = &JFactory::getDBO ();
		$query = $this->_buildQuery ( $search); //echo $query;exit;
		$feilds = ($search) ? 'c.id, c.parentid' : '*';
		$orderby = " ORDER BY c.id ";
		
		$query = "SELECT $feilds " . "FROM #__jacomment_items as c WHERE 1=1 " . $search . $orderby;
				
		$db->setQuery ( $query );		
		$items = $db->loadObjectList ();		
		$parentArray = array();
		
		if($items){
			foreach ($items as $item){
				if($item->parentid != 0){
					if(!$this->isExistItemInSearch($items, $item->parentid)){
						$parentArray[] = $item->parentid;	
					}				
					$this->getArrayParent($item->parentid, $parentArray, $items);				
					$this->getQuerySearchWithID($search, $parentArray);				
				}
			}
		}
	}
	
	function isExistItemInSearch($items, $id){				
		foreach ($items as $item){			
			if($item->id == $id){
				return true;
			}
		}		
		return false;
	}
	
	function getParentType($id){		
		$db = &JFactory::getDBO ();
		$query = "SELECT c.parentid FROM #__jacomment_items as c WHERE c.id = ".$id;
		$db->setQuery ( $query );
		
		$parentID = $db->loadResult ();
						
		if($parentID == 0){
			return 1;	
		}else{
			$query = "SELECT c.type FROM #__jacomment_items as c WHERE c.id = ".$parentID;
			$db->setQuery ( $query );
			return $db->loadResult ();						
		}
	}		
	
	function getArrayParent($id, &$parentArray, $itemsAll){
		$db = &JFactory::getDBO ();
		$query = "SELECT c.id, c.parentid FROM #__jacomment_items as c WHERE c.id = ".$id;
				
		$db->setQuery ( $query );
		
		$items = $db->loadObject ();
		
		if($items->parentid != 0){
			if(!$this->isExistItemInSearch($itemsAll, $items->parentid)){				
				$parentArray[] = $items->parentid;	
			}				
			
			$this->getArrayParent($items->parentid, $parentArray, $itemsAll);
		}
	}
	
	function getQuerySearchWithID(&$search, $parentArrays){
		$strPost = strpos($search, "c.email LIKE");
		$searchParent = "";		
		if($strPost !== false){			
			if($parentArrays){				
				foreach ($parentArrays as $parentArray){														
					$searchParent .= " c.id=".$parentArray." OR ";		
				}	
			}			
		}
		 
		$search1 = substr($search,0, $strPost) . $searchParent . substr($search,$strPost);
		$search = $search1;	
	}		
	
	function getItems($search = '', $orderBy = '', $getAll = '') {		
		//$this->_total = $this->getTotal ( $search );
		$session = &JFactory::getSession();
		$session->set('totalComment', $this->getTotal ( $search ));
		
		
		$db = &JFactory::getDBO ();
		$query = $this->_buildQuery ( $search , $orderBy, $getAll); //echo $query;exit;
				
		$db->setQuery ( $query );
		//die($db->getQuery());
		$items = $db->loadObjectList ();
		return $items;
	}
	
	function _buildQuery($search, $orderBy = '', $getAll = '') {
		$db = JFactory::getDBO ();
		$where = '';
		
		$where = $this->_buildContentWhere ( $search );
		$orderby = $this->_buildContentOrderBy ($orderBy);
		//$orderby 	.= "LIMIT $limitstart, $limit";
		if($getAll)
			$feilds = '*';
		else
			$feilds = ($search) ? 'c.id, c.parentid' : '*';
		
		$query = "SELECT $feilds " . "FROM #__jacomment_items as c" . $where . $orderby;
		
		return $query;
	}
	
	function _buildContentWhere($search) {
		global $option;
		$db = JFactory::getDBO ();
		$option_1 = $option . '.jacategories';
		
		$where = ' WHERE 1=1 ' . $search;
		
		return $where;
	}
	
	function _buildContentOrderBy($orderBy = '') {
		global $option;
		
		if(!$orderBy)					
			$orderBy = ' ORDER BY c.id DESC';
		
		return $orderBy;
	}
	
	function getItem($id = 0) {
		static $item;
		if (isset ( $item )) {
			return $item;
		}
		if (! $id) {
			$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
			JArrayHelper::toInteger ( $cid, array (0 ) );
			
			if (isset ( $cid [0] ) && $cid [0] > 0) {
				$id = $cid [0];
			}
		}
		$this->_getTable ();
		
		if ($id) {
			$this->_table->load ( $id );
		}
		
		return $this->_table;
	}
	
	function _getVars() {		
		$app = JFactory::getApplication();
		
		$option = 'moderator';
		
		$list = array ();
		$list ['filter_order'] = $app->getUserStateFromRequest ( $option . '.filter_order', 'filter_order', 'u.username', 'cmd' );
		
		$list ['filter_order_Dir'] = $app->getUserStateFromRequest ( $option . '.filter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		//$list ['limit'] = $app->getUserStateFromRequest ( $option . '.limit', 'limit', 10, 'int' );
		$list ['limit'] = 10;
		//$list ['limitstart'] = $app->getUserStateFromRequest ( $option . '.limitstart', 'limitstart', 0, 'int' );
		$list ['limitstart'] = 0;
		$list ['order'] = '';
		
		$list ['group'] = $app->getUserStateFromRequest ( $option . '.group', 'group', 'moderator', 'string' );
		
		return $list;
	}
	
	function getCommentOption(){
		$db = JFactory::getDBO ();
		
		$query = "SELECT `option` FROM #__jacomment_items GROUP BY `option`";
				
		$db->setQuery($query);
		//die($db->getQuery());
		return $db->loadObjectList ();
	}
    function getCommentSource(){
        $db = JFactory::getDBO ();
        
        $query = "SELECT `source` FROM #__jacomment_items GROUP BY `source` HAVING `source` != ''";
                	
        $db->setQuery($query); 
        //die($db->getQuery());       
        return $db->loadObjectList ();
    }
	
	
	function changeTypeOfComment($id, $type, $updateReport=false, $action='') {
		global $jacconfig;		
		$db = JFactory::getDBO ();
		$dateActive =  $db->Quote(date("Y-m-d H:i:s"));
		//reset report of comment if this comment is approved
		
		$items = $this->getItem($id);
		
		if($updateReport){
			$sql = "UPDATE #__jacomment_items SET type=$type, `date_active` =$dateActive, `report` = 0 WHERE id = $id";			
		}else{
			$sql = "UPDATE #__jacomment_items SET type=$type, `date_active` =$dateActive WHERE id = $id";						
		}		
		
		$session = &JFactory::getSession();
	    		    
	    $jaActiveComments = $session->get("jaActiveComments"); 
		if(isset($jaActiveComments) && !in_array($id, $jaActiveComments))
	    	$jaActiveComments[] = $id;
	    else 
	    	$jaActiveComments[] = $id;
	    // Put a value in a session var
		$session->set('jaActiveComments', $jaActiveComments);
	    
		$db->setQuery ( $sql );		
		$db->query ();

		//is_enabled_email
		if($jacconfig["general"]->get("is_enabled_email", 0)){	
			$helper 		= new JACommentHelpers();				
			$items->comment = $helper->replaceBBCodeToHTML($items->comment);
			if($action){			
				if($action == "reportspam"){
					//send mail to admin if a comment is report spam
					$helper ->sendMailWhenChangeType($items->name, $items->email,$items->comment, $items->referer, $type,$action);
					//send mail to author
					$helper ->sendMailWhenChangeType($items->name, $items->email,$items->comment, $items->referer, $type);
				}					
			}else{
				//remove spam by admin
				if($items->type == 2 && $type==1){
					$helper ->sendMailWhenChangeType($items->name, $items->email,$items->comment, $items->referer, $type,"removeSpam");
				}else{
					//send mail when admin approved new comment
					if($jacconfig["comments"]->get("is_allow_approve_new_comment", 1)){
						if($type == 1 && $items->type == 0 && $items->date_active == "0000-00-00 00:00:00"){
							//send mail when adnew
							if($items->parentid == 0)
								$type = "addNew";
							
							$post["id"] 		= $items->id;
							$post["parentid"]	= $items->parentid;
							$post["contentid"]  = $items->contentid;
							$post["name"]  		= $items->name;
							$post["comment"]  	= $items->comment;
							$post["date"]  		= $items->date;
							$post["email"]  	= $items->email;
							$post["userid"]  	= $items->userid;
							$post["option"]  	= $items->option;
							$post["subscription_type"]  = $items->subscription_type;
							$post["referer"]  	= $items->referer;
							$post["type"]  		= $type;
															
							$wherejatotalcomment = " AND c.type=1 AND c.contentid=".$post['contentid']." AND c.option='". $post['option'] ."'";
							$post["comment"]  = $helper->replaceBBCodeToHTML($post["comment"]);
							$helper ->sendMailWhenNewCommentApproved($items->id,$wherejatotalcomment, $type, $post);		
						}
					}					
					
					$helper ->sendMailWhenChangeType($items->name, $items->email,$items->comment, $items->referer, $type);															
				}		
			}			
		}		
							
		$childArrays = null;
		$this->getChildArray($id, $childArrays);
		if(count($childArrays) > 0){
			foreach ($childArrays as $childArray){
				$this->changeTypeOfComment($childArray->id, $type, $updateReport, $action);
			}
		}
	}
	
	function getChildArray($parentID, &$childArray){
		$db 	= JFactory::getDBO ();
		$sql 	= "SELECT id, type FROM #__jacomment_items WHERE parentid = $parentID";
		$db->setQuery ( $sql );
		$results =  $db->loadObjectList ();
		foreach ($results as $result){
			$childArray[] = $result;			
			$this->getChildArray($result->id, $childArray);	 
		}	
	}
	
	function deleteComment($id) {
		$db = JFactory::getDBO ();		
		$items = $this->getItem($id);				
		$sql = "DELETE FROM #__jacomment_items WHERE id = $id";
		$db->setQuery ( $sql );			
		
		if($db->query()){
			/* Add JomSocial:: activity Stream*/
			if ($items->userid) {					
				$title = sprintf(JText::_('JOMSOCIAL_ACTIVITI_STREAM_TITLE_REMOVE_COMMENT'), $items->referer, $items->contenttitle);
				JACommentHelpers::JomSocial_addActivityStream($items->userid, $title, $items->id, 'remove');
			}
			/* End*/
			return $items;
		}
		
		return false;
	}
	
	function getParentTypeOfComment($id) {
		$db = JFactory::getDBO ();
		$query = "SELECT type FROM #__jacomment_items WHERE id = $id";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	/**
	 * Get page navigator object
	 * @return 
	 */
	function &getPagination($limitstart = 0, $limit = 0, $divId = '', $link = '') {
		//if ($this->_pagination == null) {            
		jimport ( 'joomla.html.pagination' );
		//require_once (JPATH_COMPONENT_SITE . '/helpers/japagination.php');
        require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'japagination.php');
        $session = &JFactory::getSession();
		$totalComment = $session->get('totalComment', 0);
		
		if ($this->_limit != 0 && $this->_limitStart != 0) {
			$this->_pagination = new JACPagination ( $totalComment, $this->_limitStart, $this->_limit, $divId, $link );
			$this->_limitStart = 0;
			$this->_limit = 0;
		} else {
			$this->_pagination = new JACPagination ( $totalComment, $limitstart, $limit, $divId, $link );
		}
		//}
		$this->_pagination->_link = JURI::base(true)."/index.php?";    		                   
		return $this->_pagination;
	}
	
	/*
     * edit a comment
     */
	//    function editComment($id, $title, $comment, $type){
	//        $db = JFactory::getDBO ();
	//        $title = $db->Quocte ( $title );
	//        $comment = $db->Quocte ( $comment );
	//        $sql = "UPDATE #__jacomment_items SET title=$title, comment=$comment, type=$type WHERE id=$id";
	//        die($sql);            
	//        $db->setQuery ( $sql );
	//        $db->query();    
	//    }
	

	function store($post=0, $insert=0) {
		global $jacconfig;
		$helper = new JACommentHelpers();
		$row = $this->getItem ();		
		if(!$post){
			$post = $this->getState ( 'request' );	
		}			
		if (! $row->bind ( $post )) {		
			JError::raiseWarning ( 1, $row->getError ( true ) );
			return false;
		}	
		//insert with comment id when import jacomment		
		if($insert){
			$dbo = $row->getDbo();
			$ret = $dbo->insertObject( $row->getTableName(), $row, $row->getKeyName() );
			if( !$ret )
			{
				$row->setError(get_class( $row ).'::store failed - '.$row->_db->getErrorMsg());
				JError::raiseWarning ( 1, $row->getError ( true ) );
				return false;				
			}			
		}else{
			if (! $row->store ()) {			
				JError::raiseWarning ( 1, $row->getError ( true ) );
				return false;
			}	
		}
		
		/* Add JomSocial:: activity Stream*/		
		if (!$insert) {
			//add new or reply a new comment
			$user = & JFactory::getUser ();																
			if (! isset($post["id"])) {					
				$action = 'add';
				$row->referer = $row->referer . "#jacommentid:".$row->id;
				$title = sprintf(JText::_('JOMSOCIAL_ACTIVITI_STREAM_TITLE_COMMENT_NEW_ITEM'), $row->referer, $row->contenttitle);
				JACommentHelpers::JomSocial_addActivityStream($user->id, $title, $row->id, $action);
			} else {								
				if(JACommentHelpers::isSpecialUser()){
					$action = 'update';					
					$row = $this->getItem ($post["id"]);
					$title = sprintf(JText::_('JOMSOCIAL_ACTIVITI_STREAM_TITLE_UPDATED_COMMENT'), $row->referer, $row->contenttitle);
					JACommentHelpers::JomSocial_addActivityStream($user->id, $title, $row->id, $action);
				}				
			}			
		}
		/* End*/						
		return $row->id;
	}
		
	function getComment($id){
		$db = JFactory::getDBO ();
		$query = "SELECT * FROM #__jacomment_items WHERE id = $id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getNumberChildOfItems($id){
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) FROM #__jacomment_items WHERE parentid = $id AND type=1";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getChildItems($where_more = '', $limit = 10, $limitstart = 0, $order = '', $fields = '', $joins = '', $commentID =0) {
		$db = JFactory::getDBO ();		
		if (! $order) {
			$order = ' c.id';
		}		
		$strFind = "type=";
		if($this->mysqlVersion >= 5){
			if(strpos($where_more, $strFind) === false && strpos($where_more, "type =") === false)
				$fields = "(SELECT count(*) FROM #__jacomment_items WHERE `parentid`=sid) as children ";
			else
				$fields = "(SELECT count(*) FROM #__jacomment_items WHERE `parentid`=sid AND type=1) as children ";
		}				
		if ($fields)
			$fields = "c.*,id as sid, $fields ";
		else
			$fields = 'c.*';
		
		$this->_childTotal = $this->getTotal ( $where_more );
		
		if ($limitstart == '' && $limit == '') {
			if($commentID == 0)
				$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE 1=1 $where_more" . "\n ORDER BY $order ";
			else 
				$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE (1=1 $where_more" . "\n) OR c.id = ". $commentID ." ORDER BY $order ";
		} else {
			if($commentID == 0)
				$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE 1=1 $where_more" . "\n ORDER BY $order ";
			else 
				$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE (1=1 $where_more" . "\n) OR c.id=". $commentID ." ORDER BY $order ";
		}
		
		$db->setQuery ( $sql );				
		//die($db->getQuery());
		return $db->loadObjectList ();
	}
	
	function voteComment($itemID, $value) {
		$db = JFactory::getDBO ();
		$query = "SELECT voted FROM #__jacomment_items WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$currentVote = $db->loadResult ();
		$currentVote = $currentVote + $value;
		
		$query = "UPDATE #__jacomment_items SET `voted` = $currentVote WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$db->query ();
		return $currentVote;
	}
	
	function reportComment($itemID) {
		$db = JFactory::getDBO ();
		$query = "SELECT report FROM #__jacomment_items WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$currentReport = $db->loadResult ();
		$currentReport = $currentReport + 1;
		
		$query = "UPDATE #__jacomment_items SET `report` = $currentReport WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$db->query ();
		return $currentReport;
	}		
	
	function undoReportComment($itemID) {
		$db = JFactory::getDBO ();
		$query = "SELECT report FROM #__jacomment_items WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$currentReport = $db->loadResult ();
		if($currentReport > 0)
			$currentReport = $currentReport - 1;
		
		$query = "UPDATE #__jacomment_items SET `report` = $currentReport WHERE `id`=$itemID";
		$db->setQuery ( $query );
		$db->query ();
		return $currentReport;
	}		
	
	function isExistItemIDParentID($id, $parentID){
		$db = JFactory::getDBO ();
		$sql = "SELECT count(*) FROM #__jacomment_items WHERE id=$id";
		$db->setQuery ( $sql );
				
		if($db->LoadResult ()){
			return "existID";	
		}
		
		if($parentID == 0){
			return "OK";
		}
		
		$sql = "SELECT count(*) FROM #__jacomment_items WHERE id=$parentID";
		$db->setQuery ( $sql );
		if($db->LoadResult ()){
			return "OK";	
		}else{
			return "notExistParent";			
		}				
	}
	
	function getItemFrontEnd($id){
		$db = JFactory::getDBO ();			
		
		$sql = "SELECT *,0 as children FROM #__jacomment_items as c  WHERE id=$id";
		
		$db->setQuery ( $sql );		
		
		return $db->loadObjectList ();
	}
	
	function find_SQL_Version() {
   		$db = JFactory::getDBO ();
   		$db->setQuery("SELECT Version() AS version ");
   		$row = $db->LoadResult();
   		$row = explode("-", $row);
   		$row = explode(".", $row[0]);   		
   		return $row[0];    		
	} 
	
	function getItemsFrontEnd($where_more = '', $limit = 10, $limitstart = 0, $order = '', $fields = '', $joins = '') {
		$db = JFactory::getDBO ();
		
		if (! $order) {
			$order = ' c.id';
		}		
		$strFind = "type=";		
		if($this->mysqlVersion >= 5){			
			if(strpos($where_more, $strFind) === false)
				$fields = "(SELECT count(*) FROM #__jacomment_items WHERE `parentid`=sid) as children ";
			else
				$fields = "(SELECT count(*) FROM #__jacomment_items WHERE `parentid`=sid AND type=1) as children ";
		}	
		if ($fields)
			$fields = "c.*,id as sid, $fields ";
		else
			$fields = 'c.*';
		
		//$this->_total = $this->getTotal ( $where_more );
		$session = &JFactory::getSession();
		$session->set('totalComment', $this->getTotal ( $where_more ));
		
		if($limit == "all"){
			$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE 1=1 $where_more" . "\n ORDER BY $order ";
		}else{
			$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c " . "\n $joins" . "\n WHERE 1=1 $where_more" . "\n ORDER BY $order " . "\n LIMIT $limitstart, $limit";		
		}
		
		//die($sql."---");
		$db->setQuery ( $sql );
		//die ($db->getQuery ( $sql ));;
		
		return $db->loadObjectList ();	
	}
	
	function getParent($id){
		$db = JFactory::getDBO ();
		$sql = "SELECT * FROM #__jacomment_items as c WHERE id = $id";
		$db->setQuery ( $sql );		
		return $db->loadObjectList ();
	}
	
	/*
	 * 
	 */
	function getItemsSendMail($where_more, $order = ''){
		$db = JFactory::getDBO ();	
		if (! $order) {
			$order = ' c.id';
		}	 
		$fields = "c.id, c.name, c.email, c.subscription_type, c.date, c.parentid";		  
				
		$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c INNER JOIN (SELECT MAX(id) AS id FROM #__jacomment_items GROUP BY email) ids ON c.id = ids.id WHERE 1=1 $where_more" . "\n ORDER BY $order";
		
		$db->setQuery ( $sql );		
		return $db->loadObjectList ();
	}
	
	/*
    * 
    */
	function getParamValue($group, $name='', $defaultValue = 1) {
		$db = &JFactory::getDBO ();
		
		$query = "SELECT * FROM #__jacomment_configs as s WHERE s.group='" . $group . "'";
		$db->setQuery ( $query );
		$items = $db->loadObjectList ();
		if (! $items) {
			$items [0]->data = '';
			return $defaultValue;
		}
		
		$data = $items [0]->data;
		$params = new JRegistry;
        $params->loadJSON($data);
		if ($name) { // return only value
			return $params->get ( $name ,$defaultValue);
		
		} else { // return array
			

			return $params;
		}
	}
    
    // ++ add by congtq 19/11/2009
    /*
    * check blocked and blacklist word
    */
    function checkBlockedWord($ip, $email, $word){
        //$in = "'blacklist_email_list', 'blacklist_ip_list', 'blacklist_word_list', 'blocked_email_list', 'blocked_ip_list', 'blocked_word_list'";
        $ins = array('blacklist_email_list', 'blacklist_ip_list', 'blacklist_word_list', 'blocked_email_list', 'blocked_ip_list', 'blocked_word_list');
        
        $db = &JFactory::getDBO();
        
        foreach ($ins as $in){                
	        $query = "SELECT data FROM #__jacomment_configs WHERE `group` = '$in'";	        	       
	        $db->setQuery($query);
	        $arr[] = $db->loadRowList();
        }
                          
        if(sizeof($arr)>0){        
            // array for check
//            $arr_blacklist_email = explode("\n", $arr[0][0]);
//            $arr_blacklist_ip = explode("\n", $arr[1][0]);            
//            $arr_blacklist_word = explode("\n", $arr[2][0]);
//            
//            $arr_blocked_email = explode("\n", $arr[3][0]);
//            $arr_blocked_ip = explode("\n", $arr[4][0]);
//            $arr_blocked_word = explode("\n", $arr[5][0]);
           // print_r($arr);
            $arr_blacklist_email = array();
            $arr_blacklist_ip =  array();            
            $arr_blacklist_word =  array();
            
            $arr_blocked_email =  array();
            $arr_blocked_ip =  array();
            $arr_blocked_word =  array();
           	
            if(isset($arr[0][0][0])){
            	$arr_blacklist_email = explode("\n",$arr[0][0][0]);
            }
            
            if(isset($arr[1][0][0])){
            	$arr_blacklist_ip = explode("\n",$arr[1][0][0]);
            }
            
            if(isset($arr[2][0][0])){            
            	$arr_blacklist_word = explode("\n",$arr[2][0][0]);
            }
            
            if(isset($arr[3][0][0])){
            	$arr_blocked_email = explode("\n",$arr[3][0][0]);
            }
            if(isset($arr[4][0][0])){
            	$arr_blocked_ip = explode("\n",$arr[4][0][0]);
            }
            if(isset($arr[5][0][0])){
            	$arr_blocked_word = explode("\n",$arr[5][0][0]);
            }
            // check for blocked first
           
            array_shift($arr_blocked_ip);            
            if(in_array($ip, $arr_blocked_ip)){            
                return 'IP Blocked';
                exit();            
            }
			
            array_shift($arr_blocked_email);
            if(in_array($email, $arr_blocked_email)){
                return 'Email Blocked';
                exit();
            }
            
            // || strpos(implode(' ', $arr_blocked_word), substr($arr_word[$i],0,4))!==false
            $found_blocked = false;
            array_shift($arr_blocked_word);

        	$arr_word = explode(" ", $word);
            for($i=0; $i<sizeof($arr_word); $i++){
            	$arr_word[$i] = strtoupper($arr_word[$i]);	
            }
            //$arr_blocked_word
        	for($i=0; $i<sizeof($arr_blocked_word); $i++){
            	$arr_blocked_word[$i] = strtoupper($arr_blocked_word[$i]);	
            }
            for($i=0; $count=sizeof($arr_word), $i < $count; $i++){
            	//damn in [damn]
            	
            	if(in_array($arr_word[$i], $arr_blocked_word)){	                	
	                    return 'Word Blocked';
	                    exit();
	            }
	            //damndamn in [damn]	            
            	foreach ($arr_blocked_word as $blocked_word){
           			if($blocked_word){
	           			if(strpos($arr_word[$i], $blocked_word)!==false){
	           				return 'Word Blocked';
	                    	exit();					
	           			}	
           			}            		
           		}            			                        		                            
            }            
            // check for blacklist second
            array_shift($arr_blacklist_ip);
            if(in_array($ip, $arr_blacklist_ip)){
                return 'IP Blacklist';
                exit();            
            }
            array_shift($arr_blacklist_email);            
            if(in_array($email, $arr_blacklist_email)){
                return 'Email Blacklist';
                exit();
            }
            
            $found_blacklist = false;     
            array_shift($arr_blacklist_word);       
            
            
        	for($i=0; $i<sizeof($arr_blacklist_word); $i++){
            	$arr_blacklist_word[$i] = strtoupper($arr_blacklist_word[$i]);	
            }
            
            for($i=0; $count=sizeof($arr_word), $i < $count; $i++){                
            	if(in_array($arr_word[$i],$arr_blacklist_word )){
                    return 'Word Blacklist';
                    exit();
                }
            	foreach ($arr_blacklist_word as $blacklist_word){
           			if($blacklist_word){
	           			if(strpos($arr_word[$i], $blacklist_word)!==false){
	           				return 'Word Blacklist';
	                    	exit();					
	           			}	
           			}            		
           		}
            }            
        }
    }
    
    /*
    * check censored word
    */
    function checkCensoredWord($word, $censored_words, $censored_words_replace){
        $arr_word = explode(" ", $word);
        
        $arr_censored_words = explode(",", str_replace(' ', '', $censored_words));
        
        $str = '';
        $arr_word_replace = array();
        for($i=0; $count=sizeof($arr_word), $i < $count; $i++){
            if(in_array($arr_word[$i], $arr_censored_words)){
                $arr_word_replace[] = $arr_word[$i];
            }
        }
        $str = str_replace($arr_word_replace, $censored_words_replace, $word);

        return $str;
    }
    
    function updateUrl($commentID, $url){
    	$db = JFactory::getDBO ();				    	
    	$url = $db->Quote($url);    	
		$query = "UPDATE #__jacomment_items SET `referer` = $url WHERE `id`=$commentID";
		$db->setQuery ( $query );		
		$db->query ();	
//		$sql = "SELECT * FROM #__jacomment_items WHERE `id`=$commentID";
//		$db->setQuery ( $sql );		
//		print_r($db->loadObjectList ());die();
    }
    
    /*
    * check for send mail
    */
    function checkSendMail($is_notify_admin, $is_notify_author, $is_enabled_email){
        
        
    }
    // -- add by congtq 19/11/2009 
    
    // ++ add by congtq 25/11/2009
    function checkMaxLink($comment, $number_of_links){
    	$count 	  = 0;
    	//$subCount = 0;    	
    	
//        @str_replace("/\[LINK=([\w-]+@([\w-]+\.)+[\w-]+)\]\[\/LINK\]/iUs",'', $comment, $subCount); 
//        $count = $subCount;
//        @str_replace("/\[LINK=([^\]]*)\]\[\/LINK\]/iUs",'', $comment, $subCount); 
//        $count += $subCount;
//        @str_replace("/\[LINK=([\w-]+@([\w-]+\.)+[\w-]+)\](.+)\[\/LINK\]/iUs",'', $comment, $subCount); 
//        $count += $subCount;
//        @str_replace("/\[LINK=([^\]]*)\](.+)\[\/LINK\]/iUs",'', $comment, $subCount);
		 
        //$count += $subCount;
        $count = substr_count($comment, "[LINK=");        
        if (intval($count) > $number_of_links) {
            return 1;
        }
        return 0;   
    }
    // -- add by congtq 25/11/2009
    
	function checkUserId($userID, $commentID){
		$db = JFactory::getDBO ();				    	    	
		$query = "SELECT name FROM #__users WHERE id='".$userID."'";
		$db->setQuery ( $query );
		if($db->loadResult()){			
			return true;
		}else{					
			$query = "UPDATE #__jacomment_items SET `userid` = '0' WHERE `id` ='".$commentID."'";
			$db->setQuery ( $query );			
			$db->Query();			
		}
		return false;
	}
}

?>
