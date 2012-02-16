<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
if (!class_exists ('JAView')) {
	class JAView extends JView
	{
		function display($tpl = null)
		{
			$viewmenu = JRequest::getVar('viewmenu',1);			
			if (!$viewmenu) {
				parent::display($tpl);
				return;
			}else {
				
				$path = str_replace (JPATH_BASE, '', dirname(__FILE__));
				$path = 'administrator'.str_replace ('\\', '/', $path).'/assets/';
//				JHTML::stylesheet ('style.css', $path);
//				JHTML::script ('menu.js', $path);
		
				JHTML::_('stylesheet', JURI::root().$path.'style.css');
				JHTML::_('script', JURI::root().$path.'menu.js');				
				
				
				if (JRequest::getVar('menuId',0)) {
					$_SESSION['menuId'] = JRequest::getVar('menuId',0);
				}
				require_once (dirname(__FILE__).DS.'menu.class.php');
				//$model = $this->getModel('jaview');
				
						include (dirname(__FILE__).DS.'tmpl'.DS.'main.php');
			}
		}
		
	    	
	}
}
