<?php

/**
* Layout parts class
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class NSP_GK4_Layout_Parts {
	// header generator
	function header($config, $news_id, $news_cid, $news_title) {
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$title = str_replace('"', "&quot;", $title);
            $link = ($news_id !== 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid)) : JRoute::_('index.php?option=com_user&view=login');
			//
			$bullet = $config['module_id'] === 'main-news' ? '<span class="bullet">»</span>' : '';
			if($config['news_header_link'] == 1)
				return '<h4 class="nspHeader'.$class.'">' . $bullet . '<a href="'.$link.'" title="'.$news_title.'">'.$title.'</a></h4>';	
			else
				return '<h4 class="nspHeader'.$class.'" title="'.$news_title.'">' . $bullet . $title . '</h4>';
		} else
			return '';		
	}
	// article text generator
	function text($config, $news_id, $news_cid, $news_text, $news_readmore) {
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);
			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = ($news_id !== 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid)) : JRoute::_('index.php?option=com_user&view=login');
			//
			$news_text = ($config['news_text_link'] == 1) ? '<a href="'.$link.'">'.$news_text.'</a>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nspText'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nspText'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image($config, $uri, $news_id, $news_iid, $news_cid, $news_text, $news_title){		
		$news_title = str_replace('"', "&quot;", $news_title);
        $IMG_SOURCE = '';
		$IMG_LINK = ($news_id !== 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid)) : JRoute::_('index.php?option=com_user&view=login');	
		
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');
			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	
			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
		}
		//
		if($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config) !== FALSE) {
					$uri = JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif($config['create_thumbs'] == 1) {
					jimport('joomla.filesystem.file');
					
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';
					}
				} else
					$IMG_SOURCE = '';
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');
			
			if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float']; 
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><a href="'.$IMG_LINK.'"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'"  /></a></div>' : '<a href="'.$IMG_LINK.'"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'"  /></a>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' /></div>' : '<img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore($config, $news_id, $news_cid) {
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			$link = ($news_id !== 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid)) : JRoute::_('index.php?option=com_user&view=login'); 
			//
			if($config['news_content_readmore_pos'] == 'after') {
				return '<a class="readon inline" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			} else {
				return '<a class="readon '.$class.'" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			}
		} else
			return '';
	}
	// article information generator
	function info($config, $news_catname, $news_cid, $news_author, $news_author_email, $news_date, $news_hits, $news_id, $rating_count, $rating_sum, $num = 1) {
		// %AUTHOR %DATE %HITS %CATEGORY
		$news_info = '';
		//
		if($num == 1){
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		} else {
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];
			}			
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nspInfo '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<a href="'.(($news_id !== 0) ? JRoute::_(ContentHelperRoute::getCategoryRoute($news_cid)) : JRoute::_('index.php?option=com_user&view=login')).'" >'.$news_catname.'</a>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'. NSP_GK4_Utils::avatarURL($news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nspAvatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('MOD_NEWS_PRO_GK4_NHITS').$news_hits;
            $info_rate = ($rating_count > 0) ? '<span class="nspRate">' . JText::_('MOD_NEWS_PRO_GK4_NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
        }
		//
		return $news_info;		
	}
	// rest link list generator	
	function lists($config, $news_id, $news_cid, $news_title, $news_text, $odd, $num) {
		if($config['news_short_pages'] > 0) {
            $text = '';
            
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
                $text =  preg_replace("/\{.+?\}/", "", $text);
			}
			
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			$title = str_replace('"', "&quot;", $title);
			$link = ($news_id !== 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($news_id, $news_cid)) : JRoute::_('index.php?option=com_user&view=login');
			if(JString::strlen($title) > 0) $title = '<h4><a href="'.$link.'" title="'.$news_title.'">'.$title.'</a></h4>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}
    /** K2 elements **/
    
	// header generator
	function header_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_header_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_header_pos'].' f'.$config['news_content_header_float'];
			$title = NSP_GK4_Utils::cutText($news_title, $config['title_limit'], $config['title_limit_type'], '&hellip;');
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_header_link'] == 1)
				return '<h4 class="nspHeader'.$class.'"><a href="'.$link.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';	
			else
				return '<h4 class="nspHeader'.$class.'" title="'.str_replace('"', '', $news_title).'">'.$title.'</h4>';
		} else
			return '';		
	}
	// article text generator
	function text_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_readmore) {
		if($config['news_content_text_pos'] != 'disabled') {
			if($config['clean_xhtml'] == 1) $news_text = strip_tags($news_text);

			$news_text = NSP_GK4_Utils::cutText($news_text, $config['news_limit'], $config['news_limit_type'], $config['more_text_value']);
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			$news_text = ($config['news_text_link'] == 1) ? '<a href="'.$link.'">'.$news_text.'</a>' : $news_text; 
			$class = ' t'.$config['news_content_text_pos'].' f'.$config['news_content_text_float'];
			//
			if($config['news_content_readmore_pos'] == 'after') 
				return '<p class="nspText'.$class.'">'.$news_text.' '.$news_readmore.'</p>';
			else
				return '<p class="nspText'.$class.'">'.$news_text.'</p>';
		}
	}
	// article image generator
	function image_k2($config, $uri, $news_id, $news_alias, $news_cat_id, $news_cat_alias, $news_text, $news_title) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		
		$item_image_exists = false;
		$img_src = '';
		
		if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_L.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_L.jpg';
			$item_image_exists = true;
        }elseif(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news_id).'_S.jpg')){  
			$img_src = JURI::root().'media/k2/items/cache/'.md5("Image".$news_id).'_S.jpg';
			$item_image_exists = true;
		}
		//
		$IMG_SOURCE = '';
		$IMG_LINK = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
		$IMG_REL = '';
		//
		if(preg_match('/\<img.*src=.*?\>/',$news_text)){
			$imgStartPos = JString::strpos($news_text, 'src="');

			if($imgStartPos)  $imgEndPos = JString::strpos($news_text, '"', $imgStartPos + 5);	

			if($imgStartPos > 0) $IMG_SOURCE = JString::substr($news_text, ($imgStartPos + 5), ($imgEndPos - ($imgStartPos + 5)));
			$match_res = array();

			if(preg_match('/\<img.*class="(.*?)".*?\>/',$news_text, $match_res)) {
				$IMG_REL = $match_res[1];
			}
		}
		//
		if($config['create_thumbs'] == 1 && $config['k2_thumbs'] == 1 && $item_image_exists == true){
			// try to override standard image
			if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true, false, $IMG_REL) !== FALSE) {
				$uri = JURI::getInstance();
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
			} elseif($config['create_thumbs'] == 1) {
				jimport('joomla.filesystem.file');

				if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';
				}
			} else
				$IMG_SOURCE = '';	
		} elseif($config['create_thumbs'] == 1 && $IMG_SOURCE != ''){
			// try to override standard image
			if(strpos($IMG_SOURCE,'http://') == FALSE) {
				if(NSP_GK4_Thumbs::createThumbnail($IMG_SOURCE, $config) !== FALSE) {
					$uri = JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($IMG_SOURCE,$config['module_id']);
				} elseif ($item_image_exists == true) { 
					if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
						$uri = JURI::getInstance();
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
					} else {
						jimport('joomla.filesystem.file');

						if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
							$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';
						} else {
							$IMG_SOURCE = '';
						}
					}
				} else {
					jimport('joomla.filesystem.file');
					
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';	
					} else {
						$IMG_SOURCE = '';
					}
				}
			}	
		} elseif($config['create_thumbs'] == 1) {
			jimport('joomla.filesystem.file');

			if($item_image_exists == true){
				if(NSP_GK4_Thumbs::createThumbnail($img_src, $config, true) !== FALSE) {
					$uri = JURI::getInstance();
					$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/'.NSP_GK4_Thumbs::translateName($img_src,$config['module_id'], true);
				} else {
					jimport('joomla.filesystem.file');
					
					if(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
						$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';	
					} else {
						$IMG_SOURCE = '';
					}
				}
			}
			elseif(is_file(JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS.'default'.DS.'default'.$config['module_id'].'.png')) {
				$IMG_SOURCE = $uri->root().'modules/mod_news_pro_gk4/cache/default/default'.$config['module_id'].'.png';			
			}
		}
		//
		if($IMG_SOURCE != '' && $config['news_content_image_pos'] != 'disabled') {
			$class = ' t'.$config['news_content_image_pos'].' f'.$config['news_content_image_float'];
			$size = '';
			//
			if($config['img_width'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'width:'.$config['img_width'].'px;';
			if($config['img_height'] != 0 && !$config['img_keep_aspect_ratio']) $size .= 'height:'.$config['img_height'].'px;';
			if($config['img_margin'] != '') $size .= 'margin:'.$config['img_margin'].';';
			//
			if($config['news_image_link'] == 1) {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><a href="'.$IMG_LINK.'" title="'.$news_title.'" class="'.$class.'"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'" title="'.$news_title.'" /></a></div>' : '<a href="'.$IMG_LINK.'" class="'.$class.'" title="'.$news_title.'"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" style="'.$size.'"  title="'.$news_title.'" /></a>';
			} else {
				return ($config['news_content_image_pos'] == 'center') ? '<div class="center"><img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" '.$size.' title="'.$news_title.'" /></div>' : '<img class="nspImage'.$class.'" src="'.$IMG_SOURCE.'" alt="'.$news_title.'" title="'.$news_title.'" style="'.$size.'" />';
			}
		} else
			return '';
	}
	// ReadMore button generator
	function readMore_k2($config, $news_id, $news_alias, $news_cat_id, $news_cat_alias) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_content_readmore_pos'] != 'disabled') {
			$class = ' f'.$config['news_content_readmore_pos'];
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cat_id.':'.urlencode($news_cat_alias))));
			//
			if($config['news_content_readmore_pos'] != 'after') {
				return '<a class="readon '.$class.'" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			} else {
				return '<a class="readon inline" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			}

			if($config['news_content_readmore_pos'] == 'after') {
				return '<a class="readon inline" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			} else {
				return '<a class="readon '.$class.'" href="'.$link.'">'.JText::_('MOD_NEWS_PRO_GK4_NSP_READMORE').'</a>';
			}
		} else
			return '';
	}
	// article information generator
	function info_k2($config, $news_catname, $news_cid, $news_cat_alias, $news_author, $news_author_id, $news_author_email, $news_date, $news_hits, $news_id, $news_alias, $comments, $rating_count, $rating_sum, $num = 1) {
		//
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
        // %AUTHOR %COMMENTS %DATE %HITS %CATEGORY %RATE
		$news_info = '';
		//
		if($num == 1) {
			if($config['news_content_info_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info_pos'].' f'.$config['news_content_info_float'];	
			}
		} else {
			if($config['news_content_info2_pos'] != 'disabled') {
				$class = ' t'.$config['news_content_info2_pos'].' f'.$config['news_content_info2_float'];	
			}		
		}
		//
		if(($config['news_content_info_pos'] != 'disabled' && $num == 1) || ($config['news_content_info2_pos'] != 'disabled' && $num == 2)) {
            $news_info = '<p class="nspInfo '.$class.'">'.$config['info'.(($num == 2) ? '2' : '').'_format'].'</p>';
            //
            $info_category = ($config['category_link'] == 1) ? '<a href="'.urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($news_cid.':'.urlencode($news_cat_alias)))).'" >'.$news_catname.'</a>' : $news_catname;
            $info_author = ($config['user_avatar'] == 1) ? '<span><img src="'.K2HelperUtilities::getAvatar($news_author_id, $news_author_email, $config['avatar_size']).'" alt="'.$news_author.' - avatar" class="nspAvatar" width="'.$config['avatar_size'].'" height="'.$config['avatar_size'].'" /> '.$news_author.'</span>' : $news_author;				
            $info_date = JHTML::_('date', $news_date, $config['date_format']);			
            $info_hits = JText::_('NHITS').$news_hits;
            //
            if($config['no_comments_text'] && (!isset($comments['art'.$news_id]) || $comments['art'.$news_id] == 0)){
                $comments_amount = JText::_('MOD_NEWS_PRO_GK4_NO_COMMENTS');
            } else {
                $comments_amount = JText::_('MOD_NEWS_PRO_GK4_COMMENTS').' ('.(isset($comments['art'.$news_id]) ? $comments['art'.$news_id] : '0' ) . ')';
            }
            
            $info_comments = '<a class="nspComments" href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'#itemCommentsAnchor">'.$comments_amount.'</a>';
            //
            $info_rate = ($rating_count > 0) ? '<span class="nspRate">' . JText::_('MOD_NEWS_PRO_GK4_NSP_RATE') .' '. number_format($rating_sum / $rating_count, 2) . '</span>': '';
            // 
            $news_info = str_replace('%AUTHOR', $info_author, $news_info);
            $news_info = str_replace('%COMMENTS', $info_comments, $news_info);
            $news_info = str_replace('%DATE', $info_date, $news_info);
            $news_info = str_replace('%HITS', $info_hits, $news_info);
            $news_info = str_replace('%CATEGORY', $info_category, $news_info);
            $news_info = str_replace('%RATE', $info_rate, $news_info);
		}
        //
		return $news_info;		
	}
    // rest link list generator	
	function lists_k2($config, $news_id, $news_alias, $news_cid, $news_cat_alias, $news_title, $news_text, $odd, $num) {
		// 
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		//
		if($config['news_short_pages'] > 0) {
			$text = '';
			
            if($config['show_list_description']) {
                $text = NSP_GK4_Utils::cutText(strip_tags(preg_replace("/\{.+?\}/", "", $news_text)), $config['list_text_limit'], $config['list_text_limit_type'], '&hellip;');
            }
            
			if(JString::strlen($text) > 0) $text = '<p>'.$text.'</p>';
			$title = $news_title;
			$title = NSP_GK4_Utils::cutText($title, $config['list_title_limit'], $config['list_title_limit_type'], '&hellip;');
			
			if(JString::strlen($title) > 0) $title = '<h4><a href="'.urldecode(JRoute::_(K2HelperRoute::getItemRoute($news_id.':'.urlencode($news_alias), $news_cid.':'.urlencode($news_cat_alias)))).'" title="'.str_replace('"', '', $news_title).'">'.$title.'</a></h4>';
			// creating rest news list
			return '<li class="'.(($odd == 1) ? 'odd' : 'even').(($num >= $config['links_amount'] * $config['links_columns_amount']) ? ' unvisible' : '').'">'.$title.$text.'</li>';	
		}
	}	
}

/* EOF */