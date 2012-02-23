<?php
######################################################################
# BIGSHOT Google Analytics          	          	          	     #
# Copyright (C) 2010 by BIGSHOT  	   	   	   	   	   	   	   	   	 #
# Homepage   : www.thinkBIGSHOT.com		   	   	   	   	   	   		 #
# Author     : Jeff Henry	    		   	   	   	   	   	   	   	 #
# Email      : JeffH@thinkBIGSHOT.com 	   	   	   	   	   	   	     #
# Version    : 1.7                        	   	    	   	   		 #
# License    : http://www.gnu.org/copyleft/gpl.html GNU/GPL          #
######################################################################

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');
jimport( 'joomla.html.parameter');

class plgSystemBigshotgoogleanalytics extends JPlugin
{
	function plgSystemBigshotgoogleanalytics(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'bigshotgoogleanalytics' );
		$this->_params = new JParameter( $this->_plugin->params );
	}
	
	function onAfterRender()
	{
		$mainframe = &JFactory::getApplication();
		$web_property_id = $this->params->get('web_property_id', '');
		if($web_property_id == '' || $mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
		{
			return;
		}

		$buffer = JResponse::getBody();
		$google_analytics_javascript = "
<script type='text/javascript'>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '".$web_property_id."']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
";

		
		$buffer = str_replace ("</head>", $google_analytics_javascript."</head>", $buffer);
		JResponse::setBody($buffer);
		return true;
	}
}
?>