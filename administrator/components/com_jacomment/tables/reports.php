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
defined('_JEXEC') or die('Restricted access');

class TableReports extends JTable{
 	/** @var int */
 	var $id=0;
	/** @var varchar */
 	var $ip=null;
	/** @var int */
 	var $userid=0;	
	/** @var int */
 	var $commentid=0;
 	/** @var varchar */
 	var $option=null;
 	/** @var tinytext */
 	var $reason=null;
	/** @var tinyint */
 	var $status=0;
	
	function __construct(&$db){
		parent::__construct( '#__jacomment_reports', 'id', $db );
	}
	function bind( $array, $ignore='' ){
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array, $ignore);
	}
	function check(){
		$error=array();
		/** check error data */
		if(!$this->title)
			$error[]=JText::_("TITLE_MUST_NOT_BE_NULL");		
		if(!isset($this->id))
			$error[]=JText::_("ID_MUST_NOT_BE_NULL");
		elseif(!is_numeric($this->id))
			$error[]=JText::_("ID_MUST_BE_NUMBER");

		return $error;
	}
}
?>