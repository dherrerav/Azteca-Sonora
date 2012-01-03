<?php

/**
 * @package             Joomla Admin Mobile
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('E_RECOVERABLE_ERROR')) {
        define('E_RECOVERABLE_ERROR', 4096);
}

$params =& JComponentHelper::getParams('com_joomlaadminmobile');
if($params->get("debug"))
{
	function JoomlaAdminMobileErrorHandler($errno, $errstr, $errfile, $errline)
	{
		print $errno.": ".$errstr." (".$errline.")";
		exit;
	}

	//error_reporting(E_ALL);
	ini_set('display_errors', '1');
	// http://us2.php.net/manual/en/errorfunc.constants.php
	set_error_handler("JoomlaAdminMobileErrorHandler", E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);
}
else
{
	// Try to force display_errors to zero for our users to avoid warnings.
	ini_set('display_errors', '0');
}

if(JRequest::getMethod() != "POST") {
	$uri = JURI::getInstance();
	$path = $uri->getPath();
	$query = $uri->getQuery();
	$fragment = $uri->getFragment();
	$fullpath = $path.($query == "" ? "" : "?".$query).($fragment == "" ? "" : "#".$fragment);
?>
	<p>
		The Joomla Admin Mobile component is installed correctly.  Use the following information in the Joomla Admin Mobile application for your site info to connect to this site:
	</p>
	<p>
		<b>Host:</b> <?php print $uri->getHost(); ?>
		<br />
		<b>Path:</b> <?php print $fullpath; ?>
	</p>
	<p>
		You will also need to provide the username and password for a user on this site.  Be sure the user is in a user group that is allowed to access the JAM component.
	</p>
	</p>
		For more information, please see the Get Started Guide here: <a target="_blank" href="http://www.covertapps.com/get-started-with-j-admin-mobile?start=3">http://www.covertapps.com/get-started-with-j-admin-mobile?start=3</a>
	</p>
<?php
	exit;
}

if(JRequest::getCmd('testwarning')) {
        trigger_error('This is testing warnings from php', E_USER_WARNING);
}
if(JRequest::getCmd('testerror')) {
        trigger_error('This is testing errors from php', E_USER_ERROR);
}

if($params->get("detach_nonjoomla_user_plugins")) {
	// We need to extend these classes to access protected variables in 1.7
	class JDispatcherJAM extends JDispatcher {
		static function getObservers($dispatcher) {
			return $dispatcher->_observers;
		}
	}
	class JPluginJAM extends JPlugin {
		static function getPluginType($plugin) {
			return $plugin->_type;
		}
		static function getPluginName($plugin) {
			return $plugin->_name;
		}
	}

	// Make sure the user plugins have been imported.
	JPluginHelper::importPlugin('user');

	// Loop over all the observers and remove any user plugins that are not the joomla one.
	$dispatcher = &JDispatcher::getInstance();
	$observers = JDispatcherJAM::getObservers($dispatcher);
	foreach($observers as $observer) {
		if(JPluginJAM::getPluginType($observer) == "user" && JPluginJAM::getPluginName($observer) != "joomla") {
			$dispatcher->detach($observer);
		}
	}
}

// Be careful not to include xmlrpc twice or we get - Cannot redeclare xmlrpc_encode_entitites().  I'm not sure how it was happening, but a user reported it with 1.5.23
if(!defined('PHP_XMLRPC_COMPAT_DIR') && !function_exists('xmlrpc_encode_entitites'))
{
	require('phpxmlrpc'.DS.'xmlrpc.php');
}
if(!function_exists('_xmlrpcs_getCapabilities'))
{
	require('phpxmlrpc'.DS.'xmlrpcs.php');
}
require('joomlaadminmobilexmlrpc.php');

// Disable response compression.
$config =& JFactory::getConfig();
$config->setValue('config.gzip', 0);

$xmlrpcServer = new xmlrpc_server(JoomlaAdminMobileXmlRpc::onGetWebServices(), false);
// allow casting to be defined by that actual values passed
$xmlrpcServer->functions_parameters_type = 'phpvals';
// define UTF-8 as the internal encoding for the XML-RPC server
// Disable response compression.
$xmlrpcServer->compress_response = 0;
$encoding = "UTF-8";
$xmlrpcServer->xml_header($encoding);
$xmlrpc_internalencoding = $encoding;
$GLOBALS['xmlrpc_internalencoding'] = $encoding;

if($params->get("replace_escaped_chars", 0))
{
	function joomlaadminmobile_replace_escaped_chars($data)
	{
		return str_replace(array("&quot;", "&amp;", "&apos;", "&lt;", "&gt;"), array("&#34;", "&#38;", "&#39;", "&#60;", "&#62;"), $data);
	}

	$data = joomlaadminmobile_replace_escaped_chars(file_get_contents('php://input'));
}
else
{
	$data = null;
}

// debug level
$xmlrpcServer->setDebug(0);
// start the service
$xmlrpcServer->service($data);

if($params->get("exit_after_executing"))
{
	exit;
}

?>
