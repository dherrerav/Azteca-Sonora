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

class Tableemailtemplates extends JTable{
 	/** @var int */
 	var $id=0;
 	/** @var varchar */
 	var $name=null;
 	/** @var varchar */
 	var $title=null;
 	/** @var varchar */
 	var $subject=null;
 	/** @var text */
 	var $content=null;
 	/** @var varchar */
 	var $email_from_address=null;
 	/** @var varchar */
 	var $email_from_name=null;
 	/** @var tinyint */
 	var $published=0;
 	/** @var int */
 	var $group=0;
 	/** @var varchar */
 	var $language=null;
 	var $system =0;
 	function __construct(&$db){
 		parent::__construct( '#__jacomment_email_templates', 'id', $db );
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
			return TRUE;
		}
}
?>