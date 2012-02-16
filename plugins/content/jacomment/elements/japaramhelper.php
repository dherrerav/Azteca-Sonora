<?php
/*
# ------------------------------------------------------------------------
# JA Comment plugin for Joomla 1.6.x
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldJaparamhelper extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'Japaramhelper';

	protected function getInput(){
		if (!defined ('_JA_PARAM_HELPER')) {
			define ('_JA_PARAM_HELPER', 1);
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator", "", $uri);
			JHtml::_('behavior.mootools');
			JHTML::stylesheet($uri.'/assets/css/japaramhelper.css');
			JHTML::script($uri.'/assets/js/japaramhelper.js');
		}
		$func 	= (string)$this->element['function']?(string)$this->element['function']:'';
		$value 	= $this->value?$this->value:(string)$this->element['default'];

		if (substr($func, 0, 1) == '@'  ) {
			$func = substr($func, 1);
			if (method_exists ($this, $func)) {
				return $this->$func ();
			}
		} else {
			$subtype = ( isset( $this->element['subtype'] ) ) ? trim($this->element['subtype']) : '';
			if (method_exists ($this, $subtype)) {
				return $this->$subtype ();
			}
		}
		return; 
	}
	
	/**
	 * render js to control setting form.
	 */
	function categories(){
		$data =   JHtml::_('category.options', 'com_content');
		$categories = array();
		$categories[0] = new stdClass();
		$categories[0]->value = '';
		$categories[0]->text = JText::_("_SELECT_ALL_");
		$data = array_merge($categories,$data);
		
		$value 			= $this->value?$this->value:(string)$this->element['default'];						
		return JHTML::_( 'select.genericlist', 
						 $data, $this->name."[]",
						 'class="inputbox" style="width:95%;" multiple="multiple" size="10"',
						 'value', 
						 'text', 
						 $value );
	}          
    
    /**
    * Subtype - Categories, multiselect: subtype="menus"
    */
    function menus (){    	
        $all->value = '';
        $all->text  = JText::_("_SELECT_ALL_");
        
        $menus = JHTML::_('menu.linkoptions');
        array_unshift($menus, $all);
        
        $value 			= $this->value?$this->value:(string)$this->element['default']; 
        
        return JHTML::_('select.genericlist',  $menus, $this->name."[]", 'class="inputbox" style="width:95%;" multiple="multiple" size="10"', 'value', 'text', $value );
    }       
	
    function getParamValue($group, $param, $default){
    	require_once(JPATH_BASE.DS.'components'.DS.'com_jacomment'.DS.'models'.DS.'comments.php');
        $model = new JACommentModelComments();
        $paramValue = $model->getParamValue( $group, $param ,$default);
        return $paramValue;   
    }
    
    function getLinkButton($fileName){
		$app = JFactory::getApplication();
    	$templateJaName = $this->getParamValue('layout', 'theme' , 'default');
    							
		$templateDirectory  =  JPATH_BASE.DS.'templates'.DS.$app->getTemplate().DS.'html'.DS."com_jacomment".DS."themes".DS.$templateJaName.DS."html";									
		 if(file_exists($templateDirectory.DS.$fileName)){
		 	return $templateDirectory.DS.$fileName;	
		 }else{		 			 	
		 	if(file_exists('components/com_jacomment/themes/'.$templateJaName.'/html/'.$fileName)){		 			
				return 'components/com_jacomment/themes/'.$templateJaName.'/html/'.$fileName;
		 	}else{
		 		return 'components/com_jacomment/themes/default/html/'.$fileName; 	
		 	}
		 }			
    }
	
	
} 