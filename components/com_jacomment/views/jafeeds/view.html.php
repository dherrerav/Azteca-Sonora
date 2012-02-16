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

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );
/*
 * 
 */
class JACommentViewJAfeeds extends JView {	
	/**	
	 * Display the view
	 */
	function display($tmpl = null) {	
		switch ($this->getLayout ()) {
			case "guide" :
				break;              	                    
			default :				              
				$this->displayItems ();		
		}				
		parent::display ( $tmpl );
	}			
		
	function displayItems(){
		global $jacconfig;
		$contentID = JRequest::getInt("contentid", 0);
		$contentOption = JRequest::getVar("contentoption", "com_content");
		$search = "";
		
        $search .= " AND `option` = '" . $contentOption . "'";
        $search .= " AND `contentid` = '" . $contentID . "'";
        $search .= " AND `type` =1 ";
        
        $items = $this->builtTreeComment($search); 
        $this->assign( 'enableAvatar',$jacconfig['layout']->get('enable_avatar', 0));
        $avatarSize = $jacconfig['layout']->get('avatar_size', 1);     
		if($avatarSize == 1){
			//$size = 'height:18px; width:18px;';
			$this->assign( 'itemImageSize',"18px");			
		}else if($avatarSize == 2){
		    //$size = 'height:26px; width:26px;';
		    $this->assign( 'itemImageSize',"26px");
		}else if($avatarSize == 3){
		    //$size = 'height:42px; width:42px;';
		    $this->assign( 'itemImageSize',"42px");
		}  
		$this->assign( 'cache', 0 );		        
		$this->assign( 'type', "RSS2.0" );
		$this->assign( 'title', "JAComment rss" );
		$this->assignRef ( 'items', $items );
		$this->assign ( 'imgUrl', "" );				
		$this->setLayout('rss');        	
	}
	
	
	/**
	 * Built tree
	 * */	
	function builtTreeComment($search, $orderBy =''){
  		// get data items
  		$model = & JModel::getInstance('comments','JACommentModel');  		 	
       	$items = $model->getItems($search,$orderBy,1);       	 		
       	       	       	       	
        $children = array();
		// first pass - collect children
		$list 		= array();
		$listSearch = array(); 
		if($items){			
			foreach ($items as $v )
			{
				$pt = $v->parentid;			
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;			
			}	
									
			$list = $this->treerecurse(0, '', array(), $children );						
			
			if($list){
				foreach ($list as $i => $item) {
					$treename = $item->treename;			
					$treename = JFilterOutput::ampReplace($treename);
					$treename = str_replace('"', '&quot;', $treename);
					if($item->id == 0)
						$list[$i]->treename = $treename;
					else 	
						$list[$i]->treename = $treename;
				}
			}
		}				
		return $list;
  	}
  	  
	function treerecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 )
	{
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v->id;
				$txt = "";
				if ( $type ) {				
					$pre 	= '|_&nbsp;';
					$spacer = '';
					if($level >0)					
						$spacer = '.';
				} else {					
					$pre 	= '- ';
					$spacer = '&nbsp;&nbsp;';
				}

				if ( $v->parentid != 0 ) {
					$txt 	= $pre;					
				}
											
				$pt = $v->parentid;
				$list[$id] = $v;
				
				$list[$id]->treename = "$indent$txt";				
				$list[$id]->children = count( @$children[$id] );
				$list[$id]->level 	 = $level + 1;
				$list = $this->treeRecurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
			}
		}			
		return $list;
	}
}
?>