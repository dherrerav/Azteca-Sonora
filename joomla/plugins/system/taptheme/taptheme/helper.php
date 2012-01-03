<?php
// no direct access
defined('_JEXEC') or die;

jimport( 'joomla.plugin.plugin' );


class TapThemeHelper {
	
	static $supported_browsers = array('firefox', 'safari', 'ie6', 'ie7', 'ie8', 'opera', 'chrome', 'blackberry', 'iphone', 'ipad', 'android', 'palm');
	
	function getBrowserTemplate($params, $isSite) {
		$agent	= TapThemeHelper::getAgent();
		
		if ($agent === false) :
			return false;
		endif;
		
		if (in_array($agent, TapThemeHelper::$supported_browsers)) :
			$param_name = $isSite ? 'template_site_'.$agent : 'template_admin_'.$agent;
			$template = $this->params->get($param_name);
			if ($template) :
				return $template;
			else :
				return false;
			endif;
		endif;
		return false;
	}
	
	function getAgent() {
		$app	= JFactory::getApplication();
		$agent	= $app->getUserStateFromRequest('taptheme.browser', 'taptheme', '', 'string');
		
		if ($agent == 'default') :
			return false;
		elseif($agent === '' || $agent == 'auto') :
			$agent = TapThemeHelper::getBrowserAgent();
		endif;
		
		return $agent;
	}
	
	function getBrowserAgent() {
		jimport('joomla.environment.browser');
		$browser = JBrowser::getInstance();
		
		$agent_string = $browser->getAgentString();
		
		if(stripos($agent_string,'firefox') !== false) :
			$agent = 'firefox';
		elseif(stripos($agent_string, 'chrome') !== false) :
			$agent = 'chrome';
		elseif(stripos($agent_string, 'msie 8') !== false) :
			$agent = 'ie8';
		elseif(stripos($agent_string, 'msie 7') !== false) :
			$agent = 'ie7';
		elseif(stripos($agent_string, 'msie 6') !== false) :
			$agent = 'ie6';
		elseif(stripos($agent_string,'iphone') !== false || stripos($agent_string,'ipod') !== false) :
			$agent = 'iphone';
		elseif(stripos($agent_string,'ipad') !== false) :
			$agent = 'ipad';
		elseif(stripos($agent_string,'blackberry') !== false) :
			$agent = 'blackberry';
		elseif(stripos($agent_string,'palmos') !== false) :
			$agent = 'palm';
		elseif(stripos($agent_string,'android') !== false) :
			$agent = 'android';
		elseif(stripos($agent_string,'safari') !== false) :
			$agent = 'safari';
		elseif(stripos($agent_string, 'opera') !== false) :
			$agent = 'opera';
		else :
			$agent = null;
		endif;
	
		return $agent;
	}
	
}