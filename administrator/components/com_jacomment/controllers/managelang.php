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
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package		Joomla
 * @subpackage	Config
 */

class JACommentControllerManagelang extends JACommentController{
	/**
	 * Constructor
	 */
	function __construct( $default = array())
	{
		parent::__construct( $default );	
		$this->registerTask( 'apply', 'save');	
	}

	/**
	 * Display the list of language
	 */
	function display()
	{	
		parent::display();		
	}
	
	/**
	 * cancel  save file
	 * @return redirect to language manager
	 **/
	function cancel(){
		$option	= JRequest::getCmd('option');
		$client = JRequest::getVar('client', 0);
		$this->setRedirect("index.php?option=$option&view=managelang&client=$client");
	}
	
	/**
	 * save  language file
	 * @return void
	 **/
	function save(){
		$option	= JRequest::getCmd('option');
		jimport('joomla.filesystem.file');
		$post	= JRequest::get('post');
		$file = $post['path_lang'].DS.$post['filename'].DS.$post['filename'].'.'.$option.'.ini';		
		JFile::write($file, $post['datalang']);	
		if($this->getTask() == 'apply'){
			$this->setRedirect('index.php?option='.$option.'&view=managelang&task=edit&layout=form&client='.$post['client'].'&lang='.$post['filename'], JText::_('UPDATED_LANGUAGE_FILE_SUCCESSFULLY'));
		}else{
			$this->setRedirect('index.php?option='.$option.'&view=managelang&client='.$post['client'], JText::_('UPDATED_LANGUAGE_FILE_SUCCESSFULLY'));
		}
	}
}
?>