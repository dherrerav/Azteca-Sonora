<?php
defined('_JEXEC') or die();

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
jimport('joomla.application.component.model');

class javoiceModelsendmail extends JModel
{
	var $_filename='';
 function __construct()
	{
		parent::__construct();
		
	}	
	function setFilename($value){
		$this->_filename = $value;	
	}
	function writeLogFileChange($contents,$filename=''){
		jimport('joomla.filesystem.file');
		if($filename=='')$filename = $this->_filename;
		JFile::write($filename,$contents);
	}
	function readFile($path){
		jimport('joomla.filesystem.file');
		$files=JFolder::files($path);
		$parms='';
		if($files){
			$this->_filename=$path.DS.$files[0];
			$content = JFile::read($this->_filename);
			$params = new JRegistry;
		    $params->loadJSON($content);
		}else return FALSE;
		return $parms;
	}
	function deleteFile(){
		jimport('joomla.filesystem.file');
		if(JFile::exists($this->_filename))
			JFile::delete($this->_filename);
	}
	function checkSendMail(){
		$db = JFactory::getDBO();
		$sql = " SELECT value FROM #__jav_temp_data WHERE id=1";
		$db->setQuery($sql);
		$value = $db->loadResult();
		$value = $value?$value:0;
		if(time() > $value + 10  )
				return TRUE;
				
		return FALSE;
	}
	function checkOut(){
		$db = JFactory::getDBO();	
		$sql = " DELETE FROM #__jav_temp_data WHERE id=1"	;
		$db->setQuery($sql);
		return $db->query();
	}
	function checkIn(){
		if($this->checkSendMail()){
			if($this->checkOut()){
				$db = JFactory::getDBO();
				$tem = new stdClass();
				$tem->id=1;
				$tem->name="Send mail";
				$tem->value =time() ;
				if($db->insertObject("#__jav_temp_data",$tem))
					return TRUE;			
			}
		}
		return FALSE;	

	}
}
?>