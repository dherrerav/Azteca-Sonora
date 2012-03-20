<?php
/**
 * @version		$Id: view.html.php 41 2010-09-09 12:10:00Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewInfo extends JView {

	function display($tpl = null) {
	   
		$db = & JFactory::getDBO();
		$db_version = $db->getVersion();
		$php_version = phpversion();
		$server = $this->get_server_software();
		$gd_check = extension_loaded('gd');
		$media_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'com_fpss');
		$cache_folder_check = is_writable(JPATH_ROOT.DS.'cache');
		$this->assignRef('server',$server);
		$this->assignRef('php_version',$php_version);
		$this->assignRef('db_version',$db_version);
		$this->assignRef('gd_check',$gd_check);
		$this->assignRef('media_folder_check',$media_folder_check);
		$this->assignRef('cache_folder_check',$cache_folder_check);
		$title = JText::_('FPSS_INFORMATION');
		$this->assignRef('title', $title);
		JToolBarHelper::title($title, 'fpss-logo.png' );
		JToolBarHelper::preferences('com_fpss', '300','500', 'FPSS_OPTIONS');
		JSubMenuHelper::addEntry ( JText::_('FPSS_SLIDES'), 'index.php?option=com_fpss&view=slides' );
		JSubMenuHelper::addEntry ( JText::_('FPSS_CATEGORIES'), 'index.php?option=com_fpss&view=categories' );
		JSubMenuHelper::addEntry ( JText::_('FPSS_INFORMATION'), 'index.php?option=com_fpss&view=info', true );		
		parent::display($tpl);

	}
	
	function get_server_software()
	{
		if (isset($_SERVER['SERVER_SOFTWARE'])) {
			return $_SERVER['SERVER_SOFTWARE'];
		} else if (($sf = getenv('SERVER_SOFTWARE'))) {
			return $sf;
		} else {
			return JText::_('FPSS_NA');
		}
	}


}
