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

class TableComments extends JTable{
 	/** @var int */
 	var $id=0;
    /** @var int */
     var $parentid=null;
	/** @var int */
 	var $contentid=null;
 	/** @var varchar */
 	var $contenttitle=null;
 	/** @var varchar */
 	var $ip=null;
	/** @var varchar */
 	var $name=null;	
 	/** @var varchar */
 	var $comment=null;
 	/** @var datetime */
 	var $date=null;
 	/** @var int */
 	var $ordering=0;
 	/** @var tinyint */
 	var $published=1;
	/** @var tinyint */
 	var $locked=0;
 	/** @var varchar */
 	var $email=null; 	
 	/** @var varchar */
 	var $website=null; 
	/** @var int */
 	var $star=0;
	/** @var int */
 	var $userid=null;
    /** @var mediumtext */
     var $usertype=null;	
 	/** @var varchar */
 	var $option=null;
	/** @var smallint */
 	var $voted=null;
	/** @var smallint */
 	var $report=null;
	/** @var tinyint */
 	var $subscription_type=null;
	/** @var varchar */
 	var $referer=null; 
    /** @var varchar */
    var $source=null; 
    /** @var varchar */
    var $date_active = null;    
    /*
    0: Unapproved
    1: Approved
    2: Spam
    */
    /** @var tinyint */
    var $type=null;
	
	function __construct(&$db){
		parent::__construct( '#__jacomment_items', 'id', $db );
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
		//if(!$this->title)
		//	$error[]=JText::_("TITLE_MUST_NOT_BE_NULL");		
		if(!isset($this->id))
			$error[]=JText::_("ID_MUST_NOT_BE_NULL");
		elseif(!is_numeric($this->id))
			$error[]=JText::_("ID_MUST_BE_NUMBER");
		if(!isset($this->comment))
			$error[]=JText::_("COMMENT_MUST_NOT_BE_NULL");
		
		return $error;
	}
	
//	function load($key)
//	{
//		parent::load($key);
//		$this->name = JFilterInput::_decode($this->name);
//		$this->name = JFilterInput::clean($this->name);
//		return $this;
//	}
}
?>