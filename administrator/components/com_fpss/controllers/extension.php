<?php
/**
 * @version		$Id: extension.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSControllerExtension extends JController {

	function com_menus() {
		JRequest::setVar('tmpl', 'component');
		$model = &$this->getModel('menus');
		$view = &$this->getView('extension', 'html');
		$view->setModel($model);
		$view->com_menus();
	}

	function com_virtuemart() {
		JRequest::setVar('tmpl', 'component');
		if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php')){
			$model = &$this->getModel('virtuemart');
		}
		else {
			$model = &$this->getModel('virtuemart2');
		}
		$view = &$this->getView('extension', 'html');
		$view->setModel($model, true);
		$view->com_virtuemart();
	}
	
	function com_tienda(){
		JRequest::setVar('tmpl', 'component');
		$view = &$this->getView('extension', 'html');
		$view->com_tienda();		
	}
	
	function com_users(){
		JRequest::setVar('tmpl', 'component');
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$this->setRedirect('index.php?option=com_users&view=users&layout=modal&tmpl=component&field=FPSS_created_by');
			return true;
		}
		$model = &$this->getModel('users');
		$view = &$this->getView('extension', 'html');
		$view->setModel($model, true);
		$view->com_users();	
	}
}
