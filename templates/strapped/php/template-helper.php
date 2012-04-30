<?php
// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.plugin.plugin' );
class TemplateHelper {
	static $supported_browsers = array('firefox', 'safari', 'ie6', 'ie7', 'ie8', 'opera', 'chrome', 'blackberry', 'iphone', 'ipad', 'android', 'palm');
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
/*	
	public function mobileDetect()
	{
		$app = JFactory::getApplication();
		include_once( JPATH_BASE . '/templates/' . $app->getTemplate() . '/php/mobile-detect.php' );
		$detect = new Mobile_Detect();
		return $detect;
	}
*/
	public function mobileDetect()
	 {
	  $app = JFactory::getApplication();
	  if (!class_exists('Mobile_Detect'))
	  {
	   include_once( JPATH_BASE . '/templates/' . $app->getTemplate() . '/php/mobile-detect.php' );
	  }
	  $detect = new Mobile_Detect();
	
	  return $detect;
	 }
	public function custom_browser_info()
	{
		// Need to redo these using joomla browser sniffer
		jimport('joomla.environment.browser');
		$browser = JBrowser::getInstance();
		/*
		$browserType = $browser->getBrowser();
	    $browserVersion = $browser->getMajor();
    	if(($browserType == 'msie') && ($browserVersion < 7))
    	{
       		$doc->addStyleSheet( 'css/ie6.css' );
    	}
    	*/
		/* Make Internet Explorer into a shorthand IE */
		if( $browser->getBrowser() == 'Internet Explorer' ) {
			$browser_type = 'ie';
		} else {
			$browser_type = strtolower( $browser->getBrowser() );
		}
		if ( $browser->getVersion() == 'unknown' ) {
			$browser_version = '0';
		} else {
			$browser_version = str_replace('.', '_', $browser->getVersion() );
			$browser_version = substr($browser_version, 0, 3);
		}
		if ( $browser->getVersion() == 'unknown' ) {
			$browser_shortversion = '0';
		} else {
			$browser_shortversion = str_replace('.', '_', $browser->getVersion() );
			$browser_shortversion = substr($browser_shortversion, 0, 1);
		}
		$output = strtolower( $browser->getPlatform() ) . ' ';
		if ( $browser->getBrowser() == 'Internet Explorer' ) {
			$output .= $browser_type . ' ';
			$output .= $browser_type . $browser_shortversion;
		} else {
			$output .= $browser_type;
			if ( $browser_version !== '0' ) {
				$output .= ' v' . $browser_version;
				$output .= ' v' . $browser_shortversion;
			}
		}
		if ( ( ( $browser->getBrowser() == 'Internet Explorer' ) && ( $browser_shortversion == '6' ) ) || ( ( $browser->getBrowser() == 'Internet Explorer' ) && ( $browser_shortversion == '7' ) ) ) {
			$output .= ' ie6-7';
		}
		if ( ( ( $browser->getBrowser() == 'Internet Explorer' ) && ( $browser_shortversion == '6' ) ) || ( ( $browser->getBrowser() == 'Internet Explorer' ) && ( $browser_shortversion == '7' ) ) || ( ( $browser->getBrowser() == 'Internet Explorer' ) && ( $browser_shortversion == '8' ) ) ) {
			$output .= ' ie6-8';
		}
		return $output;
	}
	public function detect_home()
	{
		// Detects the home page by comparing current URL with homepage URL
		$menu = JSite::getMenu();
		if ($menu->getActive() == $menu->getDefault()) {
			$site_home = 1;
		} else {
			$site_home = 0;
		}

		return $site_home;
	}
	public function custom_logo()
	{
		// This does all the fun stuff that needs to happen for a good flexible logo.
		// Checking to see if new logo was uploaded. If so then use that. If not then use logo.png within the template image folder.
		$app = JFactory::getApplication();
		if ( $this->params->get('logo_image') ) {
			$image_path = $this->params->get('logo_image', '');
		} else {
			$image_path = "templates/" . $app->getTemplate() . '/images/logo.png';
		}
		// Automatically detect image size of uploaded image
		$image_size = getimagesize($image_path);
		$image_width = $image_size[0];
		$image_height = $image_size[1];
		// For good SEO your logo should be an H1 tag on homepage, then degrade to a P tag on inner pages.
		if (self::detect_home()) {
			$tag = 'h1';
		} else {
			$tag = 'p';
		}
		// If it's a mobile device then set the CSS style to be 100% of the mobile window and resize the logo background image to be 100% wide and automatically set height to stay in perspective.
		if ( self::mobileDetect()->isMobile() ) {
			$tag_style = 'width:100%;';
			$link_style = 'background: url(\'' . $image_path . '\') no-repeat; width:' . $image_width . 'px; width:100%; max-height:' . $image_height . 'px;';
		} else {
			$tag_style = '';
			$link_style = 'background: url(\'' . $image_path . '\') no-repeat; width:' . $image_width . 'px; height:' . $image_height . 'px;';
		}
		// Pull in tagline if it's set. If it's not suppose to be visible then hide the tagline by positioning it off of the page.
		if ( ( $this->params->get('display-tagline') ) && ( $this->params->get('logo-tagline') ) ) {
			$tagline = '<span class="logo-tagline">' . $this->params->get('logo-tagline', '') . '</span>' ;
		} else {
			$tagline = '';
		}
		// Output the logo. Determine whether it's text or an image, then pull in all the values set previously to display properly.
		if ( $this->params->get('logo-type') == 'text' ) {
		$logo = '<' . $tag . ' class="logo ' . $this->params->get('logo-type') . '" ><a href="' . $app->getCfg('live_site') . '" class="brand">' . $app->getCfg('sitename') . $tagline . '</a></' . $tag . '>';
		} else {
		$logo = '<' . $tag . ' style="' . $tag_style . '" class="logo ' . $this->params->get('logo-type') . '" ><a href="' . $app->getCfg('live_site') . '" style="' . $link_style . '" class="brand"> ' . $app->getCfg('sitename') . $tagline . '</a></' . $tag . '>';
		}
		return $logo;
	}
}
