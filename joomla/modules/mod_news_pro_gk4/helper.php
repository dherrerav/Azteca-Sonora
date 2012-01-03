<?php

/**
* Helper file
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.3 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');
// import com_content route helper
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
// import JString class for UTF-8 problems
jimport('joomla.utilities.string'); 
// Main class
class NSP_GK4_Helper {
	var $config = array(); // configuration array
	var $content = array(); // array with generated content
	var $module_id = 0; // module id used in JavaScript
	// module initialization
	function init($module, $params) {
		// getting module ID - automatically (from Joomla! database) or manually
		$this->module_id = ($params->get('automatic_module_id',0) == 1) ? 'nsp_'.$module->id : $params->get('module_unique_id',0);
		$this->config['module_id'] = $this->module_id;
		// module dimensions
		$this->config["module_width"] = $params->get("module_width", 100);
		$this->config["links_margin"] = $params->get("links_margin", "0");    
 		$this->config["links_position"] = $params->get("links_position", "bottom");
 		$this->config["links_width"] = $params->get("links_width", 0);  
		// source settings
		$this->config["data_source"] = $params->get("data_source", "com_categories");
		$this->config["com_categories"] = $params->get("com_categories",'');
		$this->config["com_articles"] = $params->get("com_articles",'');
		$this->config['news_sort_value'] = $params->get('news_sort_value','created'); // Parameter for SQL Query - value of sort	
		$this->config['news_sort_order'] = $params->get('news_sort_order','DESC'); // Parameter for SQL Query - sort direct
		$this->config['news_frontpage'] = $params->get('news_frontpage',1);
		$this->config['unauthorized'] = $params->get('unauthorized', 0);
		$this->config['only_frontpage'] = $params->get('only_frontpage', 0);
		$this->config['startposition'] = $params->get('startposition', 0);
		// Settings of source amount
		$this->config['news_full_pages'] = $params->get('news_full_pages', 3); // max. amount of full articles to load
		$this->config['news_short_pages'] = $params->get('news_short_pages', 3); // max. amount of links to articles to load
		$this->config['news_column'] = $params->get('news_column', 1); // amount of news columns
		$this->config['news_rows'] = $params->get('news_rows', 1); // amount of news rows 
		$this->config['art_padding'] = $params->get('art_padding', '0 20px 20px 0'); // article block padding 	
		$this->config['links_amount'] = $params->get('links_amount', 3); // amount of links
		// Interface settings
		$this->config['top_interface_style'] = $params->get('top_interface_style','arrows');
		$this->config['bottom_interface_style'] = $params->get('bottom_interface_style','arrows');
		// Content settings
		$this->config['news_header_link'] = $params->get('news_header_link', 1); // add link to header ? (boolean)
		$this->config['news_image_link'] = $params->get('news_image_link', 1); // add link to image ? (boolean)
		$this->config['news_text_link'] = $params->get('news_text_link', 0); // add link to text ? (boolean)
		$this->config['info_format'] = $params->get('info_format', '%COMMENTS %DATE %HITS %CATEGORY %AUTHOR'); // date format
		$this->config['info2_format'] = $params->get('info2_format', ''); // date format
		$this->config['category_link'] = $params->get('category_link', 1); // showing category name
		$this->config['date_format'] = $params->get('date_format', '%d %b %Y'); // date format
		$this->config['date_publish'] = (bool) $params->get('date_publish', 0); // date publish or create ?
		$this->config['username'] = $params->get('username', 0);
		$this->config['user_avatar'] = $params->get('user_avatar', 1);
		$this->config['avatar_size'] = $params->get('avatar_size', 16);
		// Content positions
		$this->config['news_content_header_pos'] = $params->get('news_content_header_pos', 'left'); // text-align for news header
		$this->config['news_content_image_pos'] = $params->get('news_content_image_pos', 'left'); // text-align for news image
		$this->config['news_content_text_pos'] = $params->get('news_content_text_pos', 'left'); // text-align for news text
		$this->config['news_content_info_pos'] = $params->get('news_content_info_pos', 'left'); // text-align for news info
		$this->config['news_content_readmore_pos'] = $params->get('news_content_readmore_pos', 'right'); // text-align for news readmore button
		$this->config['news_content_info2_pos'] = $params->get('news_content_info2_pos', 'left'); // text-align for news info
		
		$this->config['news_content_header_float'] = $params->get('news_content_header_float', 'left'); // float for news header
		$this->config['news_content_image_float'] = $params->get('news_content_image_float', 'left'); // float for news image
		$this->config['news_content_text_float'] = $params->get('news_content_text_float', 'left'); // float for news text
		$this->config['news_content_info_float'] = $params->get('news_content_info_float', 'none'); // float for news info
		$this->config['news_content_info2_float'] = $params->get('news_content_info2_float', 'left'); // float for news info
		
		$this->config['news_header_order'] = $params->get('news_header_order', 1); // order of news header
		$this->config['news_image_order'] = $params->get('news_image_order', 3); // order of news image
		$this->config['news_text_order'] = $params->get('news_text_order', 4); // order of news text
		$this->config['news_info_order'] = $params->get('news_info_order', 2);
		$this->config['news_info2_order'] = $params->get('news_info2_order', 5);
		$this->config['news_header_enabled'] = $params->get('news_header_enabled', 1);
		$this->config['news_image_enabled'] = $params->get('news_image_enabled', 1);
		$this->config['news_text_enabled'] = $params->get('news_text_enabled', 1);
		$this->config['news_info_enabled'] = $params->get('news_info_enabled', 1);
		$this->config['news_info2_enabled'] = $params->get('news_info2_enabled', 1);
		$this->config['news_readmore_enabled'] = $params->get('news_readmore_enabled', 1);
		// Limits
		$this->config['news_limit_type'] = $params->get('news_limit_type', 'words'); // type of limit fo news text
		$this->config['news_limit'] = $params->get('news_limit', 30); // amount of limit "units"
		$this->config['title_limit_type'] = $params->get('title_limit_type', 'chars');
		$this->config['title_limit'] = $params->get('title_limit', 40); // amount of limit "units"
		$this->config['list_title_limit_type'] = $params->get('list_title_limit_type', 'words');
		$this->config['list_title_limit'] = $params->get('list_title_limit', 20); // amount of chars in list element title
		$this->config['list_text_limit_type'] = $params->get('list_text_limit_type', 'words'); 
		$this->config['list_text_limit'] = $params->get('list_text_limit', 30); // amount of chars in list element text		 	
		// Other content settings
		$this->config['clean_xhtml'] = $params->get('clean_xhtml', 1); // cleaning XHTML in news
		$this->config['more_text_value'] = $params->get('more_text_value','...'); // text overflow value
		$this->config['parse_plugins'] = (bool) $params->get('parse_plugins', 0);
		$this->config['clean_plugins'] = (bool) $params->get('clean_plugins', 0);
		// Thumbnails settings
		$this->config['create_thumbs'] = $params->get('create_thumbs', 0); // use generated thumbs
		$this->config['img_height'] = $params->get('img_height', 0); // image height
		$this->config['img_width'] = $params->get('img_width', 0); // image width
		$this->config['img_margin'] = $params->get('img_margin', '6px 14px 0 0'); // image margin
		$this->config['img_bg'] = $params->get('img_bg', '#000'); // image background
		$this->config['img_stretch'] = $params->get('img_stretch', 0); // image stretch
		$this->config['img_quality'] = $params->get('img_quality', 95); // image quality
		$this->config['cache_time'] = $params->get('cache_time', 30); // cache time
		// Animation settings
		$this->config['autoanim'] = (bool) $params->get('autoanim', 0); // autoanimation enabled ?
		$this->config['hover_anim'] = (bool) $params->get('hover_anim', 0); // hover animation enabled ?
		$this->config['animation_speed'] = $params->get('animation_speed', 400);
		$this->config['animation_interval'] = $params->get('animation_interval', 5000);
		$this->config['animation_function'] = $params->get('animation_function', 'Fx.Transitions.Expo.easeIn');
		// external file settings
		$this->config['useCSS'] = $params->get('useCSS', 1); 
		$this->config['useScript'] = $params->get('useScript', 2); // add script for this module to page 
		$this->config['counter_text'] = '<strong>'.JText::_('MOD_NEWS_PRO_GK4_NSP_PAGE').'</strong>';
		
		// new GK4 v.2.0 options
		$this->config['use_title_alias'] = $params->get('use_title_alias', 0); // use title alias as a title
		$this->config['show_list_description'] = $params->get('show_list_description', 1); // enable/disable list description
		$this->config['no_comments_text'] = $params->get('no_comments_text', 1); // showing of other text when article has no comments
		$this->config['module_font_size'] = $params->get('module_font_size', 100); // specify font-size inside the module
		$this->config['img_keep_aspect_ratio'] = $params->get('img_keep_aspect_ratio', 0); // keeping aspect ratio of images
		$this->config['news_since'] = $params->get('news_since', ''); // since date for source articles
		$this->config['time_offset'] = $params->get('time_offset', 0); // time offset for timezones problem
	    $this->config['links_columns_amount'] = $params->get('links_columns_amount', 1); // amount of links columns
		
		// small validation
		if($this->config['list_title_limit'] == 0 && $this->config['list_text_limit'] == 0){
			$this->config['news_short_pages'] = 0;
		}
		
		if($this->config['news_header_enabled'] == 0) $this->config['news_content_header_pos'] = 'disabled';
		if($this->config['news_image_enabled']  == 0) $this->config['news_content_image_pos'] = 'disabled';
		if($this->config['news_text_enabled']  == 0) $this->config['news_content_text_pos'] = 'disabled';
		if($this->config['news_info_enabled'] == 0) $this->config['news_content_info_pos'] = 'disabled';
		if($this->config['news_info2_enabled'] == 0) $this->config['news_content_info2_pos'] = 'disabled';
		if($this->config['news_readmore_enabled'] == 0) $this->config['news_content_readmore_pos'] = 'disabled';
	}
	// GETTING DATA
	function getDatas(){
		$db = JFactory::getDBO();	
		// getting instance of Joomla! con_content source class
		$newsClass = new NSP_GK4_Joomla_Source();
		// Getting list of categories
		$categories = $newsClass->getSources($this->config);
		// getting content
		$this->content = $newsClass->getArticles($categories, $this->config, (($this->config['news_column'] * $this->config['news_rows'] * $this->config['news_full_pages']) + ($this->config['links_amount'] * $this->config['news_short_pages'] * $this->config['links_columns_amount'])));		   	
		
	}
	// RENDERING LAYOUT
	function renderLayout() {	
		$renderer = new NSP_GK4_Layout_Parts();
		// tables which will be used in generated content
		$news_list_tab = array();
		$news_html_tab = array();
		// Generating content 
		$uri = JURI::getInstance();
		$li_counter = 0;
		//
		for($i = 0; $i < count($this->content["ID"]); $i++) {	
			if($i < ($this->config['news_column'] * $this->config['news_rows'] * $this->config['news_full_pages'])) {
				// GENERATING NEWS CONTENT
				// GENERATING HEADER
				$news_header = $renderer->header($this->config, $this->content['ID'][$i], $this->content['CID'][$i], $this->content['title'][$i]);
				// GENERATING IMAGE
				$news_image = $renderer->image($this->config, $uri, $this->content['ID'][$i], $this->content['IID'][$i], $this->content['CID'][$i], $this->content['text'][$i], $this->content['title'][$i]);
				// GENERATING READMORE
				$news_readmore = $renderer->readMore($this->config, $this->content['ID'][$i], $this->content['CID'][$i]);
				// GENERATING TEXT
				$news_textt = $renderer->text($this->config, $this->content['ID'][$i], $this->content['CID'][$i], $this->content['text'][$i], $news_readmore);	
				// GENERATE NEWS INFO
				$news_infoo = $renderer->info($this->config, $this->content['catname'][$i], $this->content['CID'][$i], $this->content['author'][$i], $this->content['email'][$i], ($this->config['date_publish'] == TRUE) ? $this->content['date_publish'][$i] : $this->content['date'][$i], $this->content['hits'][$i], $this->content['ID'][$i], $this->content['rating_count'][$i], $this->content['rating_sum'][$i]);
				// GENERATE NEWS INFO2
				$news_infoo2 = $renderer->info($this->config, $this->content['catname'][$i], $this->content['CID'][$i], $this->content['author'][$i], $this->content['email'][$i], ($this->config['date_publish'] == TRUE) ? $this->content['date_publish'][$i] : $this->content['date'][$i], $this->content['hits'][$i], $this->content['ID'][$i], $this->content['rating_count'][$i], $this->content['rating_sum'][$i], 2);		
				// PARSING PLUGINS
				if($this->config['parse_plugins'] == TRUE) {
					$news_textt = JHtml::_('content.prepare', $news_textt);
				}	
				// CLEANING PLUGINS
				if($this->config['clean_plugins'] == TRUE) {
					$news_textt = preg_replace("/\{.+?\}/", "", $news_textt);	
				}			
				// GENERATE CONTENT FOR TAB	
				$news_generated_content = ''; // initialize variable
				//
				for($j = 1;$j < 6;$j++) {
					if($this->config['news_header_order'] == $j) $news_generated_content .= $news_header;
					if($this->config['news_image_order'] == $j) $news_generated_content .= $news_image;
					if($this->config['news_text_order'] == $j) $news_generated_content .= $news_textt;
					if($this->config['news_info_order'] == $j) $news_generated_content .= $news_infoo;
					if($this->config['news_info2_order'] == $j) $news_generated_content .= $news_infoo2;
				}			
				//
				if($this->config['news_content_readmore_pos'] != 'after') {
					$news_generated_content .= $news_readmore;
				}
				// creating table with news content
				array_push($news_html_tab, $news_generated_content);
			} else { 
				array_push($news_list_tab, $renderer->lists($this->config, $this->content['ID'][$i], $this->content['CID'][$i], $this->content['title'][$i], $this->content['text'][$i], $li_counter % 2, $li_counter));
				//
				$li_counter++;
			}
		}
		
		/** GENERATING FINAL XHTML CODE START **/
		// create instances of basic Joomla! classes
		$document = JFactory::getDocument();
		$uri = JURI::getInstance();
		// add stylesheets to document header
		if($this->config["useCSS"] == 1) {
			$document->addStyleSheet( $uri->root().'modules/mod_news_pro_gk4/interface/css/style.css', 'text/css' );
		}
		// add script to the document header
		if($this->config['useScript'] == 1) {
			$document->addScript($uri->root().'modules/mod_news_pro_gk4/interface/scripts/engine.js');
		}
		// init $headData variable
		$headData = false;
		// add scripts with automatic mode to document header
		if($this->config['useScript'] == 2) {
			// getting module head section datas
			unset($headData);
			$headData = $document->getHeadData();
			// generate keys of script section
			$headData_keys = array_keys($headData["scripts"]);
			// set variable for false
			$engine_founded = false;
			// searching phrase mootools in scripts paths
			if(array_search($uri->root().'modules/mod_news_pro_gk4/interface/scripts/engine.js', $headData_keys) > 0) {
				$engine_founded = true;
			}
			// if engine doesn't exists in the head section
			if(!$engine_founded){ 
				// add new script tag connected with mootools from module
				$document->addScript($uri->root().'modules/mod_news_pro_gk4/interface/scripts/engine.js');
			}
		}
		//
		require(JModuleHelper::getLayoutPath('mod_news_pro_gk4', 'content'));
		require(JModuleHelper::getLayoutPath('mod_news_pro_gk4', 'default'));
	}
}

?>