<?php

/**
* Helper file
* @package News Highlighter GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');
// import com_content route helper
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
// import JString class for UTF-8 problems
jimport('joomla.utilities.string'); 
// Main class
class NH_GK4_Helper {
	var $config = array(); // configuration array
	var $content = array(); // array with generated content
	var $module_id = 0; // module id used in JavaScript
	// module initialization
	
	function __construct(&$params, &$module) {
        // Basic settings
		// getting module ID - automatically (from Joomla! database) or manually
        $this->config['module_id'] = $this->module_id;
		$this->module_id = ($params->get('automatic_module_id',0) == 1) ? 'gkHighlight_'.$module->id : $params->get('module_unique_id',0);      
        // Data source settings   
        $this->config["data_source"] = $params->get("data_source", "com_categories");
		$this->config["com_categories"] = $params->get("com_categories",'');
		$this->config["com_articles"] = $params->get("com_articles",'');
		$this->config["xmlfile"] = $params->get("xmlfile",'');
		$this->config["news_amount"] = $params->get("news_amount",10);
		$this->config['news_sort_value'] = $params->get('news_sort_value','created'); // Parameter for SQL Query - value of sort	
		$this->config['news_sort_order'] = $params->get('news_sort_order','DESC'); // Parameter for SQL Query - sort direct
        $this->config['news_since'] = $params->get('news_since', ''); // since date for source articles
		$this->config['news_frontpage'] = $params->get('news_frontpage',1);
    	$this->config['unauthorized'] = $params->get('unauthorized', 0);
		$this->config['only_frontpage'] = $params->get('only_frontpage', 0);
		$this->config['startposition'] = $params->get('startposition', 0);
        $this->config['time_offset'] = $params->get('time_offset', 0); // time offset for timezones problem             
        // Layout settings
        $this->config['interface'] = (bool) $params->get('interface', 1); 
        $this->config['introtext'] = (bool) $params->get('introtext', 1); 
        $this->config['introtext_value'] = $params->get('introtext_value', ''); 
        $this->config['news_as_links'] = (bool) $params->get('news_as_links', 1); 
        $this->config['show_title'] = (bool) $params->get('show_title', 1); 
        $this->config['show_desc'] = (bool) $params->get('show_desc', 1); 
		$this->config['use_title_alias'] = $params->get('use_title_alias', 0); // use title alias as a title
		$this->config['title_limit_type'] = $params->get('title_limit_type', 'chars');
		$this->config['title_limit'] = $params->get('title_limit', 20); // amount of chars in list element title
		$this->config['desc_limit_type'] = $params->get('desc_limit_type', 'chars'); 
		$this->config['desc_limit'] = $params->get('desc_limit', 40); // amount of chars in list element text	
        // Animation settings
        $this->config['animation_type'] = $params->get('animation_type', 1); // animation type ?
		$this->config['hover_anim'] = (bool) $params->get('hover_anim', 0); // hover animation enabled ?
		$this->config['animation_speed'] = $params->get('animation_speed', 350);
		$this->config['animation_interval'] = $params->get('animation_interval', 5000);
		$this->config['animation_fun'] = $params->get('animation_fun', 'Fx.Transitions.linear');
		// Other content settings
		$this->config['clean_xhtml'] = $params->get('clean_xhtml', 1);
		$this->config['parse_plugins'] = (bool) $params->get('parse_plugins', 0);
		$this->config['clean_plugins'] = (bool) $params->get('clean_plugins', 1);        
        // external file settings
		$this->config['useCSS'] = $params->get('useCSS', 1); 
		$this->config['useScript'] = $params->get('useScript', 2); // add script for this module to page 
		// styling
		$this->config['introtext_color'] = $params->get('introtext_color', '#ffffff');
		$this->config['interface_bg'] = $params->get('interface_bg', '#819510');
		$this->config['interface_radius'] = $params->get('interface_radius', '26');
	}
	// GETTING DATA
	function getDatas() {
		$db = JFactory::getDBO();
		
		if( $this->config["data_source"] == "com_categories" ||
	        $this->config["data_source"] == "com_articles") {	
			// getting instance of Joomla! com_content source class
			$newsClass = new NH_GK4_Joomla_Source();
			// Getting list of categories
			$categories = $newsClass->getSources($this->config);
			// getting content
			$this->content = $newsClass->getArticles($categories, $this->config, $this->config['news_amount']);		   	
		}
	}
	// RENDERING LAYOUT
	function renderLayout() {	
		if( $this->config['data_source'] != 'xmlfile' ) {
    		// tables which will be used in generated content
    		$nh_content = array();
    		// Generating content 
    		$uri =& JURI::getInstance();
    		//
    		for ($i = 0; $i < count($this->content["ID"]); $i++) {			
    			$news_text = $this->content['text'][$i];
   				$news_title = $this->content['title'][$i];
                $news_link = '';
                // links
   				$news_link = JRoute::_(ContentHelperRoute::getArticleRoute($this->content['ID'][$i], $this->content['CID'][$i]));
                // REMOVE XHTML		
                if($this->config['clean_xhtml'] == TRUE) $news_text = strip_tags($news_text);
    			// PARSING PLUGINS
    			if($this->config['parse_plugins'] == TRUE) $news_text = JHTML::_('content.prepare', $news_text);	
    			// CLEANING PLUGINS
    			if($this->config['clean_plugins'] == TRUE) $news_text = preg_replace("/\{.+?\}/", "", $news_text);			
    			// LIMITS
    			$news_text = NH_GK4_Utils::cutText($news_text, $this->config['desc_limit'], $this->config['desc_limit_type'], '');
    			$news_title = NH_GK4_Utils::cutText($news_title, $this->config['title_limit'], $this->config['title_limit_type'], '');
                // GENERATE CONTENT	
                $news_content = '<span>';              
    			if( $this->config['news_as_links'] ) $news_content .= '<a href="'.$news_link.'">'; 
    			if( $this->config['show_title'] ) {   $news_content .= '<span>' . $news_title . '</span>';  
                                                     }
                 if( $this->config['show_desc']) {   $news_content .= ': ';                              
                                                     $news_content .= $news_text; }
                if( $this->config['news_as_links'] ) $news_content .= '</a>';
                                                     $news_content .= '</span>';   
    			// creating table with news content
    			array_push($nh_content, $news_content);
    		}
		} else {
            //
            $nh_content = array();
            $file_path = JPATH_BASE.DS.'modules'.DS.'mod_highlighter_gk4'.DS.'xml'.DS.$this->config['xmlfile'];
            //
            if(file_exists($file_path)) {
                $xml =& JFactory::getXMLParser('Simple');
                if($xml->loadFile($file_path)){
                    foreach( $xml->document->children() as $item ) {
                        $news_title = $item->title[0]->data();
                        $news_text = $item->desc[0]->data();
                        $news_link = $item->link[0]->data();
                        // REMOVE XHTML		
                        if($this->config['clean_xhtml'] == TRUE) $news_text = strip_tags($news_text);
            			// PARSING PLUGINS
            			if($this->config['parse_plugins'] == TRUE) $news_text = JHTML::_('content.prepare', $news_text);	
            			// CLEANING PLUGINS
            			if($this->config['clean_plugins'] == TRUE) $news_text = preg_replace("/\{.+?\}/", "", $news_text);			
            			// LIMITS
            			$news_text = NH_GK4_Utils::cutText($news_text, $this->config['desc_limit'], $this->config['desc_limit_type'], '');
                         $news_title = NH_GK4_Utils::cutText($news_title, $this->config['title_limit'], $this->config['title_limit_type'], '');
                        // GENERATE CONTENT	
                        $news_content = '<span>';
            			if( $this->config['news_as_links'] ) $news_content .= '<a href="'.$news_link.'">'; 
    			         if( $this->config['show_title'] ){   $news_content .= '<span>' . $news_title . '</span>';  
                                                                 }
                        if( $this->config['show_desc']) { $news_content .= ': ';
                                                             $news_content .= $news_text; }
                        if( $this->config['news_as_links'] ) $news_content .= '</a>';
                                                             $news_content .= '</span>';    
            			// creating table with news content
            			array_push($nh_content, $news_content);
                    } 
                }       
            }
		}
		
		/** GENERATING FINAL XHTML CODE START **/
		// create instances of basic Joomla! classes
		$document = JFactory::getDocument();
		$uri = JURI::getInstance();
		// add stylesheets to document header
		if($this->config["useCSS"] == 1) $document->addStyleSheet( $uri->root().'modules/mod_highlighter_gk4/interface/css/style.css', 'text/css' );
		// init $headData variable
		$headData = false;
		// add CSS rules
		$document->addStyleDeclaration('#gkHighlighterGK4-'.$this->config['module_id'].' .gkHighlighterInterface span.text { color: '.$this->config['introtext_color'].'; } #gkHighlighterGK4-'.$this->config['module_id'].' .gkHighlighterInterface { background-color: '.$this->config['interface_bg'].'; border-radius: '.$this->config['interface_radius'].'px; -moz-border-radius: '.$this->config['interface_radius'].'px; -webkit-border-radius: '.$this->config['interface_radius'].'px; }');	
			
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
			if(array_search($uri->root().'modules/mod_highlighter_gk4/interface/scripts/engine.js', $headData_keys) > 0) $engine_founded = true;
			// if mootools file doesn't exists in document head section
			if(!$engine_founded){ 
				// add new script tag connected with mootools from module
				$document->addScript($uri->root().'modules/mod_highlighter_gk4/interface/scripts/engine.js');
			}
		}
		//
		require(JModuleHelper::getLayoutPath('mod_highlighter_gk4', 'content'));
		require(JModuleHelper::getLayoutPath('mod_highlighter_gk4', 'default'));
	}
}
