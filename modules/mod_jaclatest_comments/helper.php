<?php
/**
 * @version		$Id: helper.php 10857 2008-08-30 06:41:16Z willebil $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

require_once (JPATH_SITE . DS . 'components' . DS . 'com_jacomment' . DS . 'models' . DS . 'comments.php');
require_once (JPATH_SITE . DS . 'components' . DS . 'com_jacomment' . DS . 'helpers' . DS . 'jahelper.php');

class modJACLatestItemsHelper {			
	/*
	 * 
	 */
	function getList(&$params) {
		global $mainframe;
		$source = $params->get("type", "com_content");
		$items  = array();
		
		$order = '';
		$type  = $params->get("sort_type", 1);
		if($type == "1"){
			$order = " cm.id";
		}else{
			$order = " cm.voted";
		}
		
		$count = $params->get("count", 1);
		
		switch ($source){
			case "com_content":
				$items = modJACLatestItemsHelper::getLatestFromContent($params, $order, $count);
				break;
			case "com_k2":
				$items = modJACLatestItemsHelper::getLatestFromk2($params,$order,$count);
				break;
			default:
				$items = modJACLatestItemsHelper::getLatestFromOther($params, $order,$count);
		}
		return $items;
	}
	
	/*
	 * 
	 */	
	function getLatestFromContent($params, $order ,$count){
		global $mainframe;		
		$db = JFactory::getDBO ();
		
		$content_category = $params->get("content_category", array());
		
		$where = " AND cm.type = 1";
		$where .= " AND cm.option = 'com_content'";
		$where .= " AND c.state != -2";		
		if(count($content_category) <=1){
			if(count($content_category) == 1)
				$where .= " AND c.catid = {$content_category[0]}";
		}else{
			$where .= " AND c.catid in (".implode(',', $content_category).")";
		}				
		
		$query = "SELECT cm.* FROM #__jacomment_items as cm"
				. "\n LEFT JOIN #__content as c ON cm.contentid = c.id"
				. "\n WHERE 1 {$where}"
				. "\n ORDER BY {$order} DESC"
				. "\n LIMIT " . intval( $count );
				 		
		$db->setQuery ( $query );		
		return $db->loadObjectList ();				
	}
	
	function getLatestFromk2($params,$order,$count){
		global $mainframe;		
		$db = JFactory::getDBO ();
		
		$content_category = $params->get("k2_category", array());
		$where = " AND cm.type = 1";
		$where .= " AND cm.option = 'com_k2'";
		$where .= " AND i.published = 1";
		
		if(count($content_category) <=1){
			if(count($content_category) == 1)
				$where .= " AND i.catid = {$content_category[0]}";
		}else{
			$where .= " AND i.catid in (".implode(',', $content_category).")";
		}		

		$query = "SELECT cm.* FROM #__jacomment_items as cm"
				. "\n LEFT JOIN #__k2_items as i ON cm.contentid = i.id"
				. "\n WHERE 1 {$where}"
				. "\n ORDER BY {$order} DESC"
				. "\n LIMIT " . intval( $count );
				 		
		$db->setQuery ( $query );		
		return $db->loadObjectList ();	
	}
	
	function getLatestFromOther($params,$order,$count){
		global $mainframe;		
		$db = JFactory::getDBO ();
				
		$other_component = $params->get("other_component", '');
		$where = " AND cm.type = 1";
		
		$other_component = explode(",", $other_component);
		
		if(count($other_component) <=1){
			$where .= " AND cm.option = '{$other_component[0]}'";			
		}else{
			$where .= " AND cm.option in (".implode(',', $other_component).")";
		}		
		
		$query = "SELECT cm.* FROM #__jacomment_items as cm"				
				. "\n WHERE 1 {$where}"
				. "\n ORDER BY {$order} DESC"
				. "\n LIMIT " . intval( $count );
				 		
		$db->setQuery ( $query );
		return $db->loadObjectList ();		
	}
	
	/*
	 * get avatar, author info, content, title
	 */
	function parseItems($params, &$items){
		$helperSub = new JACSmartTrim ( );
		$helperCom = new JACommentHelpers ( );
		$typeAvatar = 0;
		require_once(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'comments.php');
        $model = new JACommentModelComments();
        $typeAvatar = $model->getParamValue( "layout", "type_avatar" ,0);        
		if(!$items) return;		
		foreach ($items as &$item){			
			if($params->get("showcontent",1)){				
				//$item->comment = html_entity_decode($helper->replaceBBCodeToHTML($item->comment));				
				$item->comment = html_entity_decode($helperCom->showComment($helperCom->replaceBBCodeToHTML($item->comment,$params->get("showbbcode",1),1), false, $params->get("showsmiles",1)));
				$item->comment = $helperSub->mb_trim($item->comment, 0, $params->get("length",50));				
			}
						
			if($params->get("show_content_title",1)){ 
				$item->contenttitle = $helperSub->mb_trim($item->contenttitle,0, $params->get("limit_content_title",50));
			}
			if($params->get("avatar", "1")){							
				$item->avatar = JACommentHelpers::getAvatar($item->userid, 1, $params->get("avatar_size",32), $typeAvatar);
			}
			
			if($author_info = $params->get("show_author_info",1)){
				//show real name
				$userInfo = JFactory::getUser($item->userid);								
				if($userInfo->id == 0){						
					if($author_info == "3"){
						$item->author_info = $item->email;	
					}else{
						$item->author_info = $item->name;
					}		
				}else{
					if($author_info == "1"){
						$item->author_info = $userInfo->name;	
					}else if($author_info == "2"){
						$item->author_info = $userInfo->username;
					}else{
						$item->author_info = $userInfo->email;
					}					
				}					
				
				if($item->website && stristr($item->website, 'http://') === FALSE) {
					$item->author_info = "<a href='http://{$item->website}'/>".$item->author_info."</a>";	
				}else{
					$item->author_info = $item->author_info; 	
				}	
			}
			if($params->get("show_date",1) == 2){
				$item->date = $helperCom->generatTimeStamp(strtotime($item->date));
			}else{
				$item->date = date("d M Y",strtotime($item->date));
			}
			if($params->get("showcommentcount",1)){
	        	$search  = '';
				$search .= ' AND c.option="'.$item->option.'"';
				$search .= ' AND c.contentid='.$item->contentid.'';
								
				$totalType = $model->getTotalByType($search);
				
				$item->commentcount = (int)array_sum($totalType);
	        }
	        
			if(strpos($item->referer, "http://") === false){
				$item->referer = JURI::base().$item->referer;
			}
			//$params->get("avatar_size", "20")."px"
		}		
	}
	/*
	 * 
	 */
	function loadStyle($module){															
		$mainframe = JFactory::getApplication();
		//load style of module
		JHTML::stylesheet( 'modules/'.$module->module.'/assets/'.$module->module.'.css' );
		
		require_once(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'comments.php');
		$model = new JACommentModelComments();
        $enableSmileys = $model->getParamValue( "layout", "enable_smileys" ,1);	
        $smiley 	   = $model->getParamValue( "layout", "smiley" ,"default");        
		if($enableSmileys && !defined("JACOMMENT_GLOBAL_CSS_SMILEY")){
			$style = '
			       #jac-wrapper .plugin_embed .smileys,.jac-mod_content .smileys{
			            top: 17px;
			        	background:#ffea00;
			            clear:both;
			            height:84px;
			            width:105px;	            
			            padding:2px 1px 1px 2px !important;
			            position:absolute;
			            z-index:51;
			            -webkit-box-shadow:0 1px 3px #999;box-shadow:1px 2px 3px #666;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;
			        }        
			        #jac-wrapper .plugin_embed .smileys li,.jac-mod_content .smileys li{
			            display: inline;
			            float: left;
			            height:20px;
			            width:20px;
			            margin:0 1px 1px 0 !important;
			            border:none;
			            padding:0
			        }
			        #jac-wrapper .plugin_embed .smileys .smiley,.jac-mod_content .smileys .smiley{
			            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys_bg.png) no-repeat;
			            display:block;
			            height:20px;
			            width:20px;
			        }
			        #jac-wrapper .plugin_embed .smileys .smiley:hover,.jac-mod_content .smileys .smiley:hover{
			            background:#fff;
			        }
			        #jac-wrapper .plugin_embed .smileys .smiley span, .jac-mod_content .smileys .smiley span{
			            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys.png) no-repeat;
			            display: inline;
			            float: left;
			            height:12px;
			            width:12px;
			            margin:4px !important;
			        }
			        #jac-wrapper .plugin_embed .smileys .smiley span span, .jac-mod_content .smileys .smiley span span{
			            display: none;
			        } 
			        #jac-wrapper .comment-text .smiley {
			            font-family:inherit;
						font-size:100%;
						font-style:inherit;
						font-weight:inherit;
						text-align:justify;
			        }
			        #jac-wrapper .comment-text .smiley span, .jac-mod_content .smiley span{
			            background: url('.JURI::base().'components/com_jacomment/asset/images/smileys/'.$smiley.'/smileys.png) no-repeat scroll 0 0 transparent;
						display:inline;
						float:left;
						height:12px;
						margin:4px !important;
						width:12px;
			        }
			        .comment-text .smiley span span,.jac-mod_content .smiley span span{
			            display:none;
			        }
			';
			
			$doc = & JFactory::getDocument();
			$doc->addStyleDeclaration($style);
		}

		
		if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/'.$module->module.'.css')){
			JHTML::stylesheet( '.css','templates/'.$mainframe->getTemplate().'/css/'.$module->module );		
		}		
		
		$lang =& JFactory::getLanguage();											
		if ( $lang->isRTL() ) {
			if(file_exists(JPATH_BASE.DS.'modules/mod_jaclatest_comments/assets/'.$module->module.'_rlt.css')){
				JHTML::stylesheet( 'modules/mod_jaclatest_comments/assests/'.$module->module.'_rtl.css' );		
			}			
			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/'.$module->module.'_rtl.css')){
				JHTML::stylesheet( 'templates/'.$mainframe->getTemplate().'/css/'.$module->module.'_rtl.css' );		
			}			
		}

		if(!defined('JACOMMENT_GLOBAL_CSS')){
			$theme = JACommentModelComments::getParamValue("layout","themes", "default");		
			$session = &JFactory::getSession();
			
			if(JRequest::getVar("jacomment_theme", '')){
				jimport( 'joomla.filesystem.folder' );
				$themeURL = JRequest::getVar("jacomment_theme");
				
				if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$mainframe->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
					$theme =  $themeURL;											
				}
				$session->set('jacomment_theme', $theme);			
			}else{
				if($session->get('jacomment_theme', null)){
					$theme = $session->get('jacomment_theme', $theme);
				}
			}       			
			//add style for japopup
			if(file_exists('components/com_jacomment/asset/css/ja.popup.css')){			      
				JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.popup.css');
			}
			//override template for japopup in template
			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.popup.css')){
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.popup.css');
			}

			//add style for all componennt
			if(file_exists('components/com_jacomment/asset/css/ja.comment.css')){
				JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.comment.css');
			}
			//override for all component
			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.comment.css')){
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.comment.css');
			}
			
			//add style only IE for all component
			if(file_exists('components/com_jacomment/asset/css/ja.ie.php')){
				JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.ie.php');
			}            							
			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.ie.php')){
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.ie.php');
			}					
			
			//add style of template for component
			if(file_exists('components/com_jacomment/themes/'.$theme.'/css/style.css')){					
				JHTML::stylesheet('components/com_jacomment/themes/'.$theme.'/css/'.'style.css');
			}
			if(file_exists(JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.css")){		
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/'.'style.css');	 
			}
			
			if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style.ie.css')){
				JHTML::stylesheet('components/com_jacomment/themes/'.$theme.'/css/'.'style_ie.css');
			}	
			if(file_exists(JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.ie.css")){		
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/'.'style.ie.css');	 
			}
			//override for all component
			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.comment.css')){
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.comment.css');
			}
																	
			if ( $lang->isRTL() ) {						
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.popup_rtl.css')){															
					JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.popup_rtl.css');	
				}					
				if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.popup_rtl.css')){															
					JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.popup_rtl.css');	
				}
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.comment_rtl.css')){						
					JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.comment_rtl.css');		
				}																
				if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.comment_rtl.css')){															
					JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.comment_rtl.css');	
				}
				
				//add style only IE for all component
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/asset/css/ja.ie_rtl.php')){
					JHTML::stylesheet('components/com_jacomment/asset/css/'.'ja.ie.php');            		
				}					
				if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.ie_rtl.php')){
					JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.ie_rtl.php');
				}					
				
				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style_rtl.css')){
					JHTML::stylesheet('components/com_jacomment/themes/'.$theme.'/css/'.'style_rtl.css');
				}
				if(file_exists(JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style_rtl.css")){		
					JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/'.'style_rtl.css');	 
				}

				if(file_exists(JPATH_BASE.DS.'components/com_jacomment/themes/'.$theme.'/css/style.ie_rtl.css')){
					JHTML::stylesheet('components/com_jacomment/themes/'.$theme.'/css/'.'style_ie_rtl.css');
				}	
				if(file_exists(JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS. $theme .DS."css".DS."style.ie_rtl.css")){		
					JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/html/com_jacomment/themes/'.$theme.'/css/'.'style.ie_rtl.css');	 
				}
			}				            						  

			if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/ja.comment.custom.css')){
				JHTML::stylesheet('templates/'.$mainframe->getTemplate().'/css/'.'ja.comment.custom.css');
			}
			
			define('JACOMMENT_GLOBAL_CSS', true);
		}			
		
		
		
		
	}
}
