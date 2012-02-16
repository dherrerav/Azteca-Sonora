<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class JACommentViewConfigs extends JAView {
	/**
	 * Display the view
	 */
	function display($tmpl = null) {
		$task = JRequest::getVar ( 'task', NULL );
		
        if(!JRequest::getVar('group')) JRequest::setVar('group', 'general');
        $group = JRequest::getVar ( 'group', 'general' );
		
        $model = & $this->getModel ( 'configs' );
		$item = $model->getItems ();
		
		$data = $item->data;
		$params = new JRegistry;
		$params->loadJSON($data);
		if ($task) {
			$this->setLayout ( $task );
			if ($group == 'moderator') {
				$this->editmoderator ( $params );
			} 
            
            if ($group == 'layout') {
                $theme = JRequest::getVar('theme');
                $this->editcss ( $theme );
            } 
			
		} else {
						
			if ($group == "general"){
				$lists['categories'] = $model->getCategories();
            }else if ($group == 'blacklisting' || $group == 'spamfilters') {
                $blockblacktab = $model->getBlockBlackByTab($group);
                
                $lists['blocked_word_list'] = '';
                $lists['blocked_ip_list'] = '';
                $lists['blocked_email_list'] = '';
                $lists['blacklist_word_list'] = '';
                $lists['blacklist_ip_list'] = '';
                $lists['blacklist_email_list'] = '';
                
                foreach($blockblacktab as $k => $v){
                    
                    $arr_str[$k] = explode("\n", $v);
                    if(sizeof($arr_str[$k])>1){
                        asort($arr_str[$k]);
                        $str[$k] = '';
                        foreach($arr_str[$k] as $key => $val){
                            if($val){
                                $str[$k] .= "<li id='".$k."_".$key."' onclick='javascript: remove_blockblack(\"".$k."\", \"".$key."\");'>".$val."</li>";    
                            }    
                        }
                    }else{
						if($k == "blocked_word_list"){
                        	$str[$k] = JText::_('NO_KEYWORD_IS_CURRENTLY_BLOCKED' );
						}else if($k == "blocked_ip_list"){
                        	$str[$k] = JText::_('NO_IP_ADDRESS_IS_CURRENTLY_BLOCKED' );							
						}else if($k == "blocked_email_list"){
							$str[$k] = JText::_('NO_EMAIL_ADDRESS_IS_CURRENTLY_BLOCKED' );													
						}else if($k == "blacklist_word_list"){
							$str[$k] = JText::_('NO_KEYWORD_IS_CURRENTLY_BLACKLISTED' );													
						}else if($k == "blacklist_ip_list"){
							$str[$k] = JText::_('NO_IP_ADDRESS_IS_CURRENTLY_BLACKLISTED' );													
						}else{
							$str[$k] = JText::_('NO_EMAIL_ADDRESS_IS_CURRENTLY_BLACKLISTED' );													
						}
                    }
                    
                    $lists[$k] = $str[$k];
                }
                
			}else if ($group == 'language') {
				$helper = new JACommentHelpers ();
				
				$dir_language = $helper -> readFolder(JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'languages');
                $lists['language'] = $dir_language;
				
				$dir_language_admin = $helper -> readFolder(JPATH_COMPONENT . DS . 'languages');
                $lists['language_admin'] = $dir_language_admin;
				
			}else if ($group == 'moderator'){
				$this->moderator ( $params );
			}			
			$this->setLayout ( $group );
		}		
        $this->assignRef ( 'lists', $lists );		
		$this->assignRef ( 'group', $group );
		$this->assignRef ( 'params', $params );
		$this->assignRef ( 'cid', $item->id );
		parent::display ( $tmpl );		
	}
	
	function getTabs() {
		$option	= JRequest::getCmd('option');
		$group = JRequest::getVar ( 'group', '' );
		$tabs = '<div class="submenu-box">
						<div class="submenu-pad">
							<ul id="submenu" class="configuration">
								<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=general"';
		if ($group == 'general' || $group == '') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';
		$tabs .= JText::_ ( 'General' ) . '</a></li>';
								
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=comments"';
		if ($group == 'comments') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_ ( 'Comments' ) . '</a></li>';
		
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=spamfilters"';
		if ($group == 'spamfilters') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';				
		$tabs .= JText::_ ( 'Spam Filters' ) . '</a></li>';		
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=blacklisting"';
		if ($group == 'blacklisting') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_ ( 'Blacklisting' ) . '</a></li>';	
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=moderator"';
		if ($group == 'moderator') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_ ( 'Moderator' ) . '</a></li>';	
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=permissions"';
		if ($group == 'permissions') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_( 'Permissions' ) . '</a></li>';
        
        $tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=layout"';
        if ($group == 'layout') {
            $tabs .= ' class="active" ';
        }
        $tabs .= '>';        
        $tabs .= JText::_( 'LAYOUT_AND_PLUGINS' ) . '</a></li>';
			
		
		$tabs .= '				</ul>
							<div class="clr"></div>
						</div>
					</div>
					<div class="clr"></div>';		
		return $tabs;
	}
	
	function moderator($params) {
		
		$model = & JModel::getInstance ( 'moderator', 'JACommentModel' );
		$lists = $model->_getVars ();
		$where_more = '';
		$order = '';
		if (isset ( $lists ['filter_order'] ) && $lists ['filter_order'] != '') {
			$order = $lists ['filter_order'] . ' ' . @$lists ['filter_order_Dir'];
		}
		$ids = $params->get ( 'moderator', '' );		
		if ($ids != '') $where_more .= " AND a.id IN($ids)";
		else $where_more .= " AND map2.group_id IN (SELECT id FROM #__usergroups WHERE parent_id=6)";
		
		jimport ( 'joomla.html.pagination' );
		$total = $model->getTotal ( $where_more );
		$pageNav = new JPagination ( $total, $lists ['limitstart'], $lists ['limit'] );
		
		$items = $model->getItems ( $where_more, $lists ['limit'], $lists ['limitstart']);
		
		$this->assign ( 'items', $items );
		$this->assign ( 'lists', $lists );
		$this->assign ( 'pageNav', $pageNav );
	}
	function editmoderator($params) {
		global $jacconfig;
//		die("111");
		$listUser = $params->get ( 'moderator', '' );		
		$app = JFactory::getApplication();
		$items = '';
		$option = 'moderator';
		$helper = new JACommentHelpers ( );
		$postback = $helper->isPostBack ();
		$model = & JModel::getInstance ( 'moderator', 'JACommentModel' );
		
		$lists = $model->_getVars ();
		
		$where = "";				
		$lists ['groupname'] = JRequest::getInt("groupname",0); 		
		if($lists ['groupname']){
			$where = ' AND map2.group_id = '.$lists ['groupname'];	
		}
		$searchName = JRequest::getVar("search","");
		if($searchName){
			$where .= " AND a.username LIKE '%{$searchName}%'";	
		}
		if($listUser){
			$where .= " AND a.id NOT IN(".$listUser.")";
		}
		if ($postback) {									
			$items = $model->getItems ($where);						
		}
		$this->assign ( 'items', $items );
		
		$groupUser = $helper->getGroupUser ( '', 'groupname', 'class="inputbox" size="1"', $lists ['groupname'], 1 );
		
		$this->assign ( 'groupUser', $groupUser );
		$this->assign ( 'postback', $postback );
		$this->assign ( 'lists', $lists );
		$this->assign ( 'params', $params );
	
	}
    
    function editcss($theme) {    	
        $content = '';
        // Read the content of css
        jimport('joomla.filesystem.file');        
        $systemTheme 	= JACommentHelpers::getTemplate(0); 
        //$themeFolders = JPATH_SITE.'/components/com_jacomment/themes/';
        $file = $theme.'/css/style.css';   
        
		if(file_exists(JPATH_SITE.'/templates/'.$systemTheme.'/html/com_jacomment/themes/'.$file)){
			$file = JPATH_SITE.'/templates/'.$systemTheme.'/html/com_jacomment/themes/'.$file; 	
		}else if(file_exists(JPATH_SITE.'/components/com_jacomment/themes/'.$file)){
			$file = JPATH_SITE.'/components/com_jacomment/themes/'.$file;
		}else{
			echo JText::_("NO_EXIST_CSS_FILE_IN_THIS_TEPLATE");
			exit();
		}
		
		$content = JFile::read($file);        
        $this->assign ( 'theme', $theme );
        $this->assign ( 'content', $content );                        
    }	
}
?>