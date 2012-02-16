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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class JACommentViewEmailtemplates extends JAView 
{
   /**
     * Display the view
     */
    function display($tmpl = null)
    {    
		$task = JRequest::getVar("task", '');
		switch ($task){
			case 'add':
			case 'edit':				
				$this->displayForm();
				break;	
				
			case 'show_duplicate':
				$this->show_duplicate();	
				break;	
			case 'show_import':
				$this->show_import();
				break;			
			default:
				$this->displayListItems();
		}
		parent::display($tmpl);
  	}
  	
  	
  	/**
  	* Display List of items
  	*/
  	function displayListItems(){	
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
        $option_1 = $option.'.emailtemplates';
		$app = JFactory::getApplication('administrator');
		
		$search	= $app->getUserStateFromRequest( "$option_1.search", 'search', 	'',	'string' );
		$lists['search']	= JString::strtolower($search );
		$lists['order']		= $app->getUserStateFromRequest( $option_1.'.filter_order',		'filter_order',		'name',	'cmd' );
		$lists['order_Dir']	= $app->getUserStateFromRequest( $option_1.'.filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$lists['search']	= $app->getUserStateFromRequest( "$option_1.search", 'search', 	'',	'string' );
		$lists['option']	= $option;
		
		$filter_state		= $app->getUserStateFromRequest( $option_1.'.filter_state', 'filter_state', '',	'word' );				
		$filter_lang		= $app->getUserStateFromRequest( $option_1.'.filter_lang', 'filter_lang', 'en-GB',	'string' );				
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );
		
		$modelEmailTemplate = $this->getModel('emailtemplates'); 
  	    $languages = $modelEmailTemplate->getLanguages(0);
  	      	    
		$languages   = JHTML::_('select.genericlist', $languages, 'filter_lang', 'class="inputbox" size="1" onChange="$(\'task\').value=\'\'; form.submit()"','language', 'name', $filter_lang );	
		$this->assignRef('languages', $languages);
		$this->assignRef('filter_lang', $filter_lang);
		
		$arr_group = JACommentConstant::get_Email_Group();  
        // get data items
        
        $model = $this->getModel();
        
        $items = $model->getItems(); 
        $this->assign('counts', count($items));
        if($items) $items = $model->group_filter($items, $arr_group, 'group');
        $this->assignRef('items', $items);

       	
        $en_items = array();
        if($filter_lang!='en-GB'){
        	$en_items = $model->getItems('en-GB');
        	if($en_items){
        		$en_items = $model->group_filter($en_items, $arr_group, 'group');        		        		
        	}
        }       
        $this->assign('en_items', $en_items);
             
//        for ($i=0;$i<count($items);$i++) 
//        	$items[$i]->group  = $arr_group[$items[$i]->group];
        
//        $pagination = &$this->get('Pagination');
        
        $this->assignRef('arr_group', $arr_group);
        $this->assignRef('lists', $lists);
       
//        $this->assignRef('pagination', $pagination);
        
  	}
  	/**
  	* Display edit form
  	*/
  	function displayForm(){  	    
  		$option	= JRequest::getCmd('option');
  	    $item = &$this->get('Item');  
  	    	
		if(!$item->language) $item->language = 'en-GB';
  	    //$languages = $this->getModel('emailtemplates')->getLanguages(0);
  	    $modelEmailTemplate = $this->getModel('emailtemplates'); 
  	    $languages = $modelEmailTemplate->getLanguages(0);
  	      	    
		$languages   = JHTML::_('select.genericlist', $languages, 'language', 'class="inputbox" size="1"','language', 'name', $item->language );	
		$this->assignRef('languages',$languages);
		
		$PARSED_EMAIL_TEMPLATES_CONFIG = $modelEmailTemplate->parse_email_config();
				
		$this->assignRef('comment', $PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['comment']);
		
		/// get message tags
	    $tags = array();
	    if (isset($PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['tagsets']))
	    foreach ((array)$PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['tagsets'] as $ts){
	        $tags = array_merge_recursive($tags, $PARSED_EMAIL_TEMPLATES_CONFIG['tagset'][$ts]);
	    }
	    if (isset($PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['tags']))
	    foreach ((array)$PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['tags'] as $k => $v){
	        $tags[$k] = $v;
	    }
		if (count($tags) <=1) {
			if (isset($PARSED_EMAIL_TEMPLATES_CONFIG['emails'][$item->name]['tagsets']))
			foreach ((array)$PARSED_EMAIL_TEMPLATES_CONFIG['emails']['default']['tagsets'] as $ts){
				$tags = array_merge_recursive($tags, $PARSED_EMAIL_TEMPLATES_CONFIG['tagset'][$ts]);
			}
		}
		$i = 0;
	    $tags_to_assign = array();
	    foreach ($tags as $k=>$v){
	    	$row = new stdClass();
	    	$row->value = '{' . $k . '}';
	    	$row->text = '{' . $k . '} - '  . $v;
			$tags_to_assign[$i] = $row;
			$i++;
	    }
	    $default = array();
	    $default[] = JHTML::_('select.option',  '', JText::_('_PLEASE_CHOOSE_AN_OPTION_BELOW_AND_IT_WILL_BE_INSERTED_INTO_EMAIL_MESSAGE_'));
	    $tags_to_assign = array_merge($default, $tags_to_assign);
	    $tags_to_assign   = JHTML::_('select.genericlist', $tags_to_assign, 'tags', 'class="small" style="background-color: buttonface; width:100%; color: black;" onclick="insertVariable(this)" size="20"','value', 'text');	
	   
	    $this->assignRef('tags', $tags_to_assign);
    
    	
  	    // clean item data
		$put[] = JHTML::_('select.option',  '1', JText::_('YES' ));
		$put[] = JHTML::_('select.option',  '0', JText::_('NO' ));
		$option_group = array();
		$arr_group = JACommentConstant::get_Email_Group();
		for($i = 0, $n = count($arr_group); $i < $n; $i++){
		$option_group[] = JHTML::_('select.option',$i,$arr_group[$i]);
		}
		$html_group = JHTML::_('select.genericlist',   $option_group, 'group', 'class="inputbox" size="1"', 'value', 'text', $item->group);
		
		
		// If not a new item, trash is not an option
		
		if ( !$item->id) {
			$item->published = 1;
		}
		$published = JHTML::_('select.radiolist',  $put, 'published', '', 'value', 'text', $item->published );
		
		// clean item data
		JFilterOutput::objectHTMLSafe( $item, ENT_QUOTES, '' );
		
		$editor =& JFactory::getEditor();

		$item->name = JRequest::getVar('tpl', $item->name);
		
		$this->assignRef('editor',$editor);
		$this->assignRef('group',$html_group);
		
  	    $this->assignRef('option', $option);
  	    $this->assignRef('published', $published);
  	    $this->assignRef('item', $item);
	}
	
	
	function show_duplicate(){
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$app = JFactory::getApplication('administrator');		
		$filter_lang		= $app->getUserStateFromRequest( $option.'.emailtemplates.filter_lang', 'filter_lang', 'en-GB',	'string' );
		
		$this->assign('option', $option);		
		$modelEmailTemplate = $this->getModel('emailtemplates'); 
  	    $languages = $modelEmailTemplate->getLanguages(0);
		//$languages = $this->getModel('emailtemplates')->getLanguages(0);
		/*foreach ($languages as $k=>$lang){
			if ($lang->language==$filter_lang) {
				unset($languages[$k]);
			}
		}*/
		$languages   = JHTML::_('select.genericlist', $languages, 'filter_lang', 'class="inputbox" size="1"','language', 'name', $filter_lang );
		$this->assign('languages', $languages);
		
		
		$cid = JRequest::getVar('cid', array(), '', 'array');		
		JArrayHelper::toInteger($cid);
		$cid = implode(',', $cid);
		$this->assign('cid', $cid);
	}
	
	function show_import(){
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$this->assign('option', $option);		
		
		$modelEmailTemplate = $this->getModel('emailtemplates'); 
  	    $languages = $modelEmailTemplate->getLanguages(0);
		//$languages = $this->getModel('emailtemplates')->getLanguages(0);
		
		$languages   = JHTML::_('select.genericlist', $languages, 'filter_lang', 'class="inputbox" size="1"','language', 'name', '' );
		$this->assign('languages', $languages);				
	}
		
}
?>