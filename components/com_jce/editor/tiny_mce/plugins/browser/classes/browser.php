<?php
/**
* @version		$Id: browser.php 58 2011-02-18 12:40:41Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined( '_JEXEC') or die( 'ERROR_403');
 
require_once(WF_EDITOR_LIBRARIES .DS. 'classes' .DS. 'manager.php');

class WFFileBrowserPlugin extends WFMediaManager
{
	/* 
	* @var string
	*/
	var $_extensions = 'xml=xml;html=htm,html;word=doc,docx;powerpoint=ppt;excel=xls;text=txt,rtf;image=gif,jpeg,jpg,png;acrobat=pdf;archive=zip,tar,gz;flash=swf;winrar=rar;quicktime=mov,mp4,qt;windowsmedia=wmv,asx,asf,avi;audio=wav,mp3,aiff;openoffice=odt,odg,odp,ods,odf';	
	
	/**
	* @access	protected
	*/
	function __construct()
	{		
		if (JRequest::getWord('type', 'file') == 'file') {
			$extensions = 'WF_LABEL_ALL_FILES=*.*;' . $this->getParam('browser.extensions', $this->get('_extensions'));
		} else {
			$extensions = 'image=jpg,jpeg,png,gif';
		}
		
		if (JRequest::getString('filter')) {
			$extensions = 'files=' . JRequest::getString('filter');
		}

		$config = array(
			'filetypes' => $extensions
		);
		
		parent::__construct($config);
	}
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser =Browser::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance()
	{
		static $instance;

		if (!is_object($instance)) {
			$instance = new WFFileBrowserPlugin();
		}
		return $instance;
	}
	
	/**
	 * Display the plugin
	 */
	function display()
	{
		parent::display();
		
		$document = WFDocument::getInstance();		
		$settings = $this->getSettings();

		if ($document->get('standalone') == 1) {
			$document->addScript(array('browser'), 'component');
			
			// load the language file
			if (is_file(WF_EDITOR . DS . 'tiny_mce' . DS . 'langs' . DS . $this->getLanguage() . '_dlg.js')) {
				$document->addScript(array('langs/' . $this->getLanguage() . '_dlg.js'), 'tiny_mce');
			} else {
				$document->addScript(array('langs/en_dlg.js'), 'tiny_mce');
			}
			
			$options = array(
				'plugin' => array(
					'root' 	=> JURI::root(),
					'site' 	=> JURI::base(true) . '/'
				),
				'manager' 	=> $settings
			);
			
			// add element
			if (JRequest::getWord('element')) {
				$options['element'] = JRequest::getWord('element');
			}
			
			$document->addScriptDeclaration('jQuery(document).ready(function($){$.Browser.init('.json_encode($options).');});');
			
			$document->addStyleSheet(array(
				'dialog'
			), 'libraries');		
		} else {
			$document->addScript(array('browser'), 'plugins');		
			$document->addScriptDeclaration('BrowserDialog.settings='.json_encode($settings).';');
		}
	}
	
	function getSettings()
	{
		return parent::getSettings();
	}
}
?>