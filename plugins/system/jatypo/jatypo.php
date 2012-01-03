<?php
/*
# ------------------------------------------------------------------------
# JA Typo plugin For Joomla 1.6
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
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemJATypo extends JPlugin
{
	
	function __construct(&$subject, $config) {
		parent::__construct ( $subject, $config );
	}
	
	/**
	 * readmore button
	 * @return array A two element array of ( imageName, textToInsert )
	 */
	function onAfterInitialise()
	{
		global $mainframe;
		$mainframe = JFactory::getApplication();
		
		if($mainframe->isAdmin()) {
			JHTML::_('stylesheet', JURI::root().'plugins/system/jatypo/jatypo/assets/style.css', array(), true);
			JHtml::_('behavior.mootools');
			JHTML::_('script',JURI::root().'plugins/system/jatypo/jatypo/assets/script.js', false, true);
		}
		JHTML::_('stylesheet', JURI::root().'plugins/system/jatypo/jatypo/typo/typo.css', array(), true);
	}
	
	function onAfterRender () {
		$mainframe = JFactory::getApplication();

		$jatypo = JRequest::getCmd ('jatypo');
		if (!$mainframe->isAdmin() && !$jatypo) return;

		$tmpl = dirname (__FILE__).DS.'jatypo'.DS.'tmpl'.DS.'default.php';		
		$html = $this->loadTemplate ($tmpl);
		
		$buffer = JResponse::getBody();
		if($mainframe->isAdmin()) {
			if (preg_match ('/id=\"editor-xtd-buttons\"/', $buffer)) {				
				$buffer = preg_replace ('/<\/body>/', "\n$html\n</body>", $buffer);
				JResponse::setBody ($buffer);
			}
			return;
		}
		
		//replace body by the sample
		$buffer = preg_replace ('/<body([^>]*)>.*<\/body>/s', "<body\\1>$html</body>", $buffer);
		JResponse::setBody ($buffer);
	}
	
	function loadTemplate ($template) {
		if (!is_file ($template)) return '';
		ob_start();
		include ($template);
		$content = ob_get_clean();
		return $content;
	}
}