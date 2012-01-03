<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'xmlrpc.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'xmlrpcs.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'xmlrpcj2xml.php');

class J2XMLImporterControllerCPanel extends JController
{
	public function import()
	{
		global $xmlrpcString, $xmlrpcBase64, $xmlrpc_internalencoding;
		$app = JFactory::getApplication();
		$params =& JComponentHelper::getParams('com_j2xmlimporter');

		$xmlrpcServer = new xmlrpc_server(
			array(
				'j2xml.import' => array(
					'function' => 'plgXMLRPCJ2XMLServices::import',
					'docstring' => 'Import articles from xml file',
					'signature' => array(
						array($xmlrpcString, $xmlrpcBase64, $xmlrpcString, $xmlrpcString)
						)
				)
			)
			, false);
		// allow casting to be defined by that actual values passed
		$xmlrpcServer->functions_parameters_type = 'phpvals';
		// define UTF-8 as the internal encoding for the XML-RPC server
		$xmlrpcServer->xml_header('UTF-8');
		$xmlrpc_internalencoding = 'UTF-8';
		// debug level
		$xmlrpcServer->setDebug($params->get('debug', 0));
		// start the service
		$xmlrpcServer->service();
	}

}
?>
