<?php
// no direct access
defined('_JEXEC') or die;

jimport( 'joomla.plugin.plugin' );

include_once(JPATH_SITE.'/plugins/system/taptheme/taptheme/helper.php');

class plgSystemTapTheme extends JPlugin
{

	function plgSystemTapTheme(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	function onAfterInitialise()
	{	
		
		$mainframe = &JFactory::getApplication();
		$document = &JFactory::getDocument();
		
		$isSite = $mainframe->isSite();
		
		$switchTemplate = TapThemeHelper::getBrowserTemplate($this->params, $isSite);
		
		if ($switchTemplate) :
			if ($isSite) :
				$split = explode("::", $switchTemplate);
				$style = $split[0];
				$template = $split[1];
				JRequest::setVar('template', $template);
				JRequest::setVar('taptheme.style', $style);
			else :
				JFactory::getUser()->setParam('admin_style', (int)$switchTemplate);
			endif;
		endif;
	}
	
}