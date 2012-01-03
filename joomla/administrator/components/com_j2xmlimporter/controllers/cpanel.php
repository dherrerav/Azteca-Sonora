<?php
/**
 * @version		1.6.0.54 controllers/cpanel.php
 *
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		File available since Release v1.5.3
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

jimport( 'joomla.application.component.controller' );

class J2XMLImporterControllerCPanel extends JController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array())
	{
		parent::__construct($default);
	}

	function display( )
	{
		JRequest::setVar('view', 'cpanel');
		JRequest::setVar('layout', 'default');
		parent::display();
	}

	function import()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		$app =& JFactory::getApplication('administrator');
		$msg='';
		$db =& JFactory::getDBO();
		$date = JFactory::getDate();
		$now = $date->toMYSQL();
		$params =& JComponentHelper::getParams('com_j2xmlimporter');

		libxml_use_internal_errors(true);
		
		//Retrieve file details from uploaded file, sent from upload form:
		$file = JRequest::getVar('file_upload', null, 'files', 'array');
		if ($file['name'])
		{
			$local = false;
			$filename = $file['tmp_name'];
		}
		else
		{
			$local = true;
			$filename = JPATH_COMPONENT_ADMINISTRATOR.DS.'files'.DS.JRequest::getVar('local_file', null);			
		}	
		// check if file is compress
		$path_info = pathinfo($filename);
		if ($path_info['extension'] == 'gz')
			$data = implode(gzfile($filename));
		else
			$data = file_get_contents($filename);
		if (function_exists('iconv'))
			$data = iconv("UTF-8","UTF-8//IGNORE",$data);
		$xml = simplexml_load_string($data);
		
		if (!$xml)
		{
			$errors = libxml_get_errors();
			foreach ($errors as $error) {
				$msg = $error->code.' - '.JText::_($error->message);
			    switch ($error->level) {
		    	default:
		        case LIBXML_ERR_WARNING:
		        	$app->enqueueMessage($msg,'message');
		            break;
		         case LIBXML_ERR_ERROR:
		        	$app->enqueueMessage($msg,'notice');
		            break;
		        case LIBXML_ERR_FATAL:
		        	$app->enqueueMessage($msg,'error');
		            break;
			    }
			}
			libxml_clear_errors();
		}

		if(!isset($xml['version']))
   			$app->enqueueMessage(JText::sprintf('COM_J2XMLIMPORTER_MSG_FILE_FORMAT_UNKNOWN'),'error');
		else 
		{
			require_once (JPATH_COMPONENT.DS.'helpers'.DS.'importer.php');
			
			$xmlVersion = $xml['version'];
			$version = explode(".", $xmlVersion);
			$xmlVersionNumber = $version[0].$version[1].substr('0'.$version[2], strlen($version[2])-1); 
	
			if (($xmlVersionNumber == 1505) || ($xmlVersionNumber == 1506))
			{
				set_time_limit(120);
				j2xmlImporter::import($xml,$xmlVersionNumber);
			}
			else
				$app->enqueueMessage(JText::sprintf('COM_J2XMLIMPORTER_MSG_FILE_FORMAT_NOT_SUPPORTED', $xmlVersion),'error');
		}	
		$this->setRedirect('index.php?option=com_j2xmlimporter');	
	}
}