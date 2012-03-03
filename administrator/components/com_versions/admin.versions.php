<?php
/**
 * @package Simple Content Versioning
 * @copyright 2009 - Fatica Consulting L.L.C.
 * @license GPL - This is Open Source Software 
 * $Id: admin.versions.php 978 2012-01-10 06:29:51Z fatica $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe = JFactory::getApplication();

echo JHTML::_( 'behavior.mootools' );

$path = str_replace(DS."components".DS."com_versions","",dirname(__FILE__));
require_once($path .DS."components".DS."com_versions".DS."admin.versions.html.php");

$db =& JFactory::getDBO();
$id = (int)JRequest::getVar('id',0);

$cid 		= JRequest::getVar( 'cid', array(), '', 'array' );
JArrayHelper::toInteger($cid, array());

//load the language .ini file
$lang =& JFactory::getLanguage();
$lang->load( 'com_versions', JPATH_ADMINISTRATOR);

if(!function_exists('getParameterValue')){

	function getParameterValue($parameter){
		
		$plugin =& JPluginHelper::getPlugin('content', 'wfcontent');
		jimport('joomla.html.parameter');
		
		if($plugin){
			$params = new JParameter( $plugin->params );
				
			if(!is_array($params->get($parameter))){
				return strtolower($params->get($parameter));
			}else{
				return $params->get($parameter);
			}
		}
	}
}
/**
 * Load the Autosave features if they exist
 */
$entpath =  JPATH_ROOT . DS."plugins".DS."editors-xtd".DS."autosave_ent.php";

if(file_exists($entpath)){
	require_once($entpath);
}


/**
 * Load the Versioning Pro features if they exist
 */
$entpath =  JPATH_ROOT . DS."plugins".DS."content".DS."enterprise.php";

if(file_exists($entpath)){
	require_once($entpath);
}else{
	//joomla 1.6
	$entpath =  JPATH_ROOT . DS."plugins".DS."content".DS."wfcontent".DS."enterprise.php";
	if(file_exists($entpath)){
		
		require_once($entpath);
	}
}

$task = JRequest::getString('task');
$view = JRequest::getString('view');

//TODO: Need to update after refactoring to MVC
if($view == "userversions" && $task == ""){
	$task = "showversions";
}

//if this is being requested from the components drop-down
if($id == 0 && count($cid) == 0){
	if(JRequest::getString('tmpl') != 'component'){
		$task = "showversions";
	}
}


switch ($task){
	
	case 'deleteautosave':
	case 'delete':{		
		if(delete($id) === false){
			JError::raiseError( 403, JText::_( 'Not authorized:' . $error ) );	
		}
	}break;
	
	case 'remove':{
		removeVersions($cid);		
	}break;
		
	case 'workflow':
	case 'saveworkflow':{
		
	}break;
	
	case 'autosave':{
				
	}break;	
	
	case 'prefs':{
	}break;
			
	case 'getrulesettings':{			
	}break;
	
	case 'getrulerow':{			
	}break;	

	/**
	 * Show versions of content contributed/staged by a user, for their continued edit and submittal
	 */
	case 'cancel':
	case 'showversions':{
		showVersions();
	}break;

	case 'showautosave':{


		if($id > 0){
			
			$query = 	"SELECT * from 
						(SELECT 
						max(id) as id,content_id
						FROM #__version WHERE autosaved = '1' 
						AND content_id = $id group by content_id) as a 
						INNER JOIN  #__version j ON a.id =j.id";		
		}else{
			
			$query = 	"SELECT * from 
						(SELECT 
						max(id) as id,content_id
						FROM #__version WHERE autosaved = '1' 
						  group by content_id) as a 
						INNER JOIN  #__version j ON a.id =j.id
						";
		}

		
		$db->setQuery( $query );
		$rows = $db->loadObjectList();	
		
		//get the current article
		$query = "SELECT * FROM #__content WHERE id=" . $id . " LIMIT 1";
		$db->setQuery( $query );
		$current = $db->loadObject();	
		
		HTML_versions::show($rows,$current);
						
	}break;		
	
	//show the list of versions for this document
	default:{
			
		$rows = null;
		$current = null;
		$sql = '';
		
		if($id > 0){

			//create a workflow record if content from this user group should be staged
			$group_ids = getParameterValue('approval_user_group');
				
			//if this is > 0 we know enterprise.php is included because this parameter is only defined there.
			if($group_ids > 0 || is_array($group_ids)){
			
				$user =& JFactory::getUser();

				$language_id = JRequest::getInt('language_id',0);
				
				if($language_id > 0){
					$sql = " AND language_id = " . $language_id;
				}else{
					$sql = "AND (language_id is NULL or language_id = 0)";					
				}
			
				//if they are at or above the selected user group
				if(inGroup($group_ids)){
				
					$query = "SELECT * FROM #__version WHERE content_id=" . $id . " $sql AND (autosaved != '1' or autosaved is null) ORDER BY id DESC";
					
				}else{
					
					//no access to staging versions
					$query = "SELECT *,'1' as hide_staged FROM #__version WHERE content_id=" . $id . " $sql AND  (autosaved != '1' or autosaved is null) ORDER BY id DESC";
					
				}
		
				
			}else{
				$query = "SELECT * FROM #__version WHERE content_id=" . $id . " $sql AND (autosaved != '1' or autosaved is null) ORDER BY id DESC";
			}
			
			$db->setQuery( $query );
			$rows = $db->loadObjectList();	
						
			//get the current article
			$query = "SELECT * FROM #__content WHERE id=" . $id . " LIMIT 1";
			$db->setQuery( $query );
			$current = $db->loadObject();
		
		}
		
		HTML_versions::show($rows,$current);

		
	}break;
	
}


function removeVersions($cid){

	$db =& JFactory::getDBO();

	$remove = implode("','",$cid);

	$db->setQuery( $query );
	$rows = $db->loadObjectList();	
				
	//get the current article
	$query = "DELETE FROM #__version WHERE content_id in ('" . $remove ."')";
	
	$db->setQuery( $query );

	$db->Query();
	
	$mainframe = JFactory::getApplication();
		
	$mainframe->redirect('index.php?option=com_versions&task=showversions','Versions Removed!');
				
			
	
	
}

/**
 * Initialize the Preferences Screen
 */
function showPrefs($rowonly = false,$id = 0){

	$i = 0;
	$db = JFactory::getDBO();
	
	$query = "SELECT * FROM #__fc_workflow_rules";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
		
	if(count($rows) == 0){
		$rows[0] = 'EMPTY';
	}
	
	foreach($rows as $row){
		
		$lists[$i]['id'] = ($row->id > 0)?($row->id):($id);
		
		$javascript = "onchange=\"changeDynaList( 'catid_" . $lists[$i]['id'] . "', sectioncategories, document.adminForm.sectionid_"  . $lists[$i]['id'] .  ".options[document.adminForm.sectionid_" . $lists[$i]['id'] . ".selectedIndex].value, 0, 0);\"";

		$query = 'SELECT s.id, s.title' .
				' FROM #__sections AS s' .
				' ORDER BY s.ordering';
		
		$db->setQuery($query);

		$sections[] = JHTML::_('select.option', '-1', '- '.JText::_('Select Section').' -', 'id', 'title');
		$sections[] = JHTML::_('select.option', '0', JText::_('All Sections'), 'id', 'title');
		
		$sections = array_merge($sections, $db->loadObjectList());
		$lists[$i]['sectionid'] = JHTML::_('select.genericlist',  $sections, 'sectionid_' . $lists[$i]['id'], 'class="inputbox" size="1" '.$javascript, 'id', 'title', intval($row->sectionid));
		

		foreach ($sections as $section)
		{
			$section_list[] = (int) $section->id;
			// get the type name - which is a special category
			if ($row->sectionid) {
				if ($section->id == $row->sectionid) {
					$contentSection = $section->title;
				}
			} else {
				if ($section->id == $sectionid) {
					$contentSection = $section->title;
				}
			}
		}

		$sectioncategories = array ();
		$sectioncategories[-1] = array ();
		$sectioncategories[-1][] = JHTML::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
		$section_list = implode('\', \'', $section_list);

		$query = 'SELECT id, title, section' .
				' FROM #__categories' .
				' WHERE section IN ( \''.$section_list.'\' )' .
				' ORDER BY ordering';
		
		$db->setQuery($query);
		$cat_list = $db->loadObjectList();

		// Uncategorized category mapped to uncategorized section
		$uncat = new stdClass();
		$uncat->id = 0;
		$uncat->title = JText::_('All Categories');
		$uncat->section = 0;
		$cat_list[] = $uncat;
		
		foreach ($sections as $section)
		{
			$sectioncategories[$section->id] = array ();
			$rows2 = array ();
			foreach ($cat_list as $cat)
			{
				if ($cat->section == $section->id) {
					$rows2[] = $cat;
				}
			}
			foreach ($rows2 as $row2) {
				$sectioncategories[$section->id][] = JHTML::_('select.option', $row2->id, $row2->title, 'id', 'title');
			}
			
				$sectioncategories[$section->id][] = JHTML::_('select.option',0, 'All Categories under ' .  $section->title, 'id', 'title');
		}
		
		$sectioncategories['-1'][] = JHTML::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
		$categories = array();
		
		foreach ($cat_list as $cat) {
			
			if($cat->section == $row->sectionid)
				$categories[] = $cat;
		}

		$categories[] = JHTML::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
		
		$lists[$i]['catid'] = JHTML::_('select.genericlist',  $categories, 'catid_' . $lists[$i]['id'], 'class="inputbox" size="1"', 'id', 'title', intval($row->catid));
	}
	
	HTML_versions::showPrefs($lists,$sectioncategories,$rowonly);
	
}

/**
 * Save the posted rules
 */
function savePrefs(){
	
	$db =& JFactory::getDBO();
	
	$rulecount = (int)JRequest::getInt('rulecount',0);
	
	$rulecount = $rulecount + 1; 
	
	$x = 0;
	
	/*wipe out existing rules */
	$sql = "DELETE FROM #__fc_workflow_rules";
	$db->setQuery($sql);
	$db->Query();

	
	for($x =0; $x <= $rulecount; $x++){
		
		$rule 		= JRequest::getVar('rules_' . $x,'');
		$sectionid 	= JRequest::getInt('sectionid_' . $x,0);
		$catid	 	= JRequest::getInt('catid_' . $x,0);
		$setting	= JRequest::getVar('settings_' . $x,'');

		
		
		if(strlen($setting) > 0){
									
			$sql = "INSERT INTO #__fc_workflow_rules(rule,sectionid,catid,params) VALUES ('$rule',$sectionid,$catid,'$setting') ";

			$db->setQuery($sql);
			$db->Query();
			
		}

	}
	
	$mainframe = JFactory::getApplication();
		
	$mainframe->redirect('index.php?option=com_versions&task=showversions','Preferences Saved!');
	
	
}


	function diff($old, $new){
		$maxlen =0;
		
		try{
			
	        foreach($old as $oindex => $ovalue){
	                $nkeys = array_keys($new, $ovalue);
	                foreach($nkeys as $nindex){
	                        $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
	                                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
	                        if($matrix[$oindex][$nindex] > $maxlen){
	                                $maxlen = $matrix[$oindex][$nindex];
	                                $omax = $oindex + 1 - $maxlen;
	                                $nmax = $nindex + 1 - $maxlen;
	                        }
	                }       
	        }
	        if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
	        return array_merge(
	                diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
	                array_slice($new, $nmax, $maxlen),
	                diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
		}catch (Exception $e) {
    		return array(array('i' => 'Article to large to parse') );
		}
	}
	
	
	
	function htmlDiff($old, $new){
		
		$old = str_replace('<hr id="system-readmore" />','',$old);
		$new = str_replace('<hr id="system-readmore" />','',$new);
		
		$old = array(str_replace(' />','/>',$old));
		$new = array(str_replace(' />','/>',$new));
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR . '/Text/Diff.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR . '/Text/Diff/Renderer.php');
		require_once(JPATH_COMPONENT_ADMINISTRATOR . '/Text/Diff/Renderer/inline.php');
		
		$diff = new Text_Diff('auto', array($old, $new));
		$renderer = new Text_Diff_Renderer_inline(   array(
		        'ins_prefix' => '<span class="ins">',
		        'ins_suffix' => '</span>',
		        'del_prefix' => '<span class="del">',
		        'del_suffix' => '</span>',
    			)
			);
			
		return $renderer->render($diff);
	}
	
	/*
	function htmlDiff($old, $new){
		$ret = "";
					
			$old = str_replace('<hr id="system-readmore" />','',$old);
			$new = str_replace('<hr id="system-readmore" />','',$new);
			
			$old = str_replace(' />','/>',$old);
			$new = str_replace(' />','/>',$new);
			
			$old = explode(' ', $old);
			$new = explode(' ', $new);
						
	        $diff = diff($old,$new);
	        
	        foreach($diff as $k){
	                if(is_array($k))
	                        $ret .= (!empty($k['d'])?"<span class=\"ins\">".implode(' ',$k['d'])."</span> ":'').
	                                (!empty($k['i'])?"<span class=\"del\">".implode(' ',$k['i'])."</span> ":'');
	                else $ret .= $k . ' ';
	        }
	        return $ret;
	}
	*/
	/**
	 * Check the Joomla version
	 *
	 */
	function checkVersion(){
					
	}
	
	/**
	 * Show a list of articles (article manager style)
	 * for the logged in user
	 */
	function showVersions(){
		
		
		$database =& JFactory::getDBO();
		$mainframe = JFactory::getApplication();
		$user =& JFactory::getUser();

		$db =& JFactory::getDBO();
		
		$option = JRequest::getVar('option');
				
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
		
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.filter_order',		'filter_order',		'v.content_id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( $option.'.filter_state',		'filter_state',		'',				'word' );
		
		$search				= $mainframe->getUserStateFromRequest($option . '.search',				'search',			'',	'string');
		$search				= JString::strtolower($search);
		
		if($filter_order == "countv.id"){
			$filter_order = "count(v.id)";
		}
		if($filter_order == "countv.stage"){
			$filter_order = "count(v.stage)";
		}
		
		if($filter_order == "maxv.modified"){
			$filter_order = "max(v.modified)";
		}	
		
		if($user->id > 0){	

			$where = " WHERE 1 ";
			
			$where .=" AND c.state != -2";
			
			$app = JFactory::getApplication();
			
			if($app->isSite()){
			 	$where .=" AND c.created_by = {$user->id}";
			}
			
			// Keyword filter
			if ($search) {
				$where .= ' AND LOWER( v.title ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			}

			// get the total number of records
			$query = 'SELECT COUNT(*) FROM (SELECT
					COUNT(v.`id`) AS version_count,
					c.title,v.content_id,count(v.stage) as staged,max(v.modified) as date
					FROM 
						#__content c 
					INNER JOIN 
						#__version v 
					ON (v.content_id = c.id AND v.created_by = c.created_by)';
			
			$query .= $where;
			$query .=" 
					GROUP BY c.title,v.content_id
					";					
			$query .= ') as a';
		
			$db->setQuery( $query );
			$total = $db->loadResult();
			
			// Create the pagination object
			jimport('joomla.html.pagination');
			
			$pageNav = new JPagination($total, $limitstart, $limit);
			
			$sql = "SELECT 
					COUNT(v.`id`) AS version_count,
					c.title,v.content_id,count(v.stage) as staged, max(v.modified) as date, max(v.created) as cdate
					FROM 
						#__content c 
					INNER JOIN 
						#__version v 
					ON (v.content_id = c.id AND v.created_by = c.created_by)
					 ";
			$sql .= $where;
			$sql .=" 
					GROUP BY c.title,v.content_id
					ORDER BY $filter_order $filter_order_Dir
					";
	
			$lists['order_Dir']	= $filter_order_Dir;
			$lists['order']		= $filter_order;
	
			$database->setQuery( $sql, $pageNav->limitstart, $pageNav->limit );
			$rows = $database->loadObjectList();	
			HTML_versions::showVersions($rows,$pageNav,$lists);
			
		}else{
			JError::raiseWarning( 403, JText::_( 'Not authorized:  You must be logged in to access your article version history' ) );		
		}
		
	}

	/**
	 * Delete a document revision
	 *
	 * @param int $id
	 * @return unknown
	 */
	function delete($id){
		
		$database =& JFactory::getDBO();
		
		$error = "";
		
		$candelete = false;
				
		
		//for some reason $my doesn't work here
		$user =& JFactory::getUser();

		//TODO: what;s the real way to check this?
		$isAdmin = ($user->usertype == "Super Administrator")?(true):(false);
		
		//prevent variable injection by type
		$id = (int)$id;
		$user_id  = (int)$user->id;
		
	
		//you must be logged in
		if($user_id > 0){
			
			//must be a valid content version id
			if($id > 0){
				
				//check if they created this version
				$query = "SELECT id FROM #__version WHERE id=" . $id . " and created_by = $user_id LIMIT 1";
				$database->setQuery( $query );
				$rows = $database->loadObjectList();	
				
				//allow deletion
				if(count($rows) > 0 || $isAdmin){
					
					$candelete = true;	
					
				}else{
					 
					$error =  JText::_('You did not create this version.');
					
					if($isAdmin){
						$error .=  JText::_('You must be admin to delete versions you did not create.');
					}
				}
	
				//If they created this version or they're admin, delete it.
				if($candelete === true){
					
					if($_REQUEST['task'] == 'deleteautosave'){
						$query = "DELETE FROM #__version WHERE content_id=" . $id . " and created_by = $user_id LIMIT 1";											
					}else{
						$query = "DELETE FROM #__version WHERE id=" . $id . " LIMIT 1";
					}
	
					$database->setQuery( $query );
					$database->Query();
					return true;
					
				}else{
					JError::raiseError( 403, JText::_( 'Not authorized:' . $error ) );	
				}
				return false;	
			}
			return false;
		}
		return false;
	}

?>