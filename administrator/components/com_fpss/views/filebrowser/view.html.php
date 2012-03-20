<?php
/**
 * @version		$Id: view.html.php 636 2011-08-14 07:28:34Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewFileBrowser extends JView {

	function display($tpl = null) {
		$params = &JComponentHelper::getParams('com_media');
		$path = $params->get('image_path', 'media');

		$document = &JFactory::getDocument();
		$document->addScriptDeclaration("
			var elementID = '".JRequest::getCmd('elementID')."';
			var imagePath = '".$path."/';
		");
		$document->addScript(JURI::base(true).'/components/com_fpss/js/filebrowser.js');

		parent::display($tpl);
	}

}
