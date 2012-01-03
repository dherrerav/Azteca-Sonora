<?php
/**
 * @version		$Id: spellchecker.php 54 2011-02-09 16:45:24Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
require_once (WF_EDITOR_LIBRARIES . DS . 'classes' . DS . 'plugin.php');

class WFSourcePlugin extends WFEditorPlugin {
	/**
	 * Constructor activating the default information of the class
	 *
	 * @access	protected
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns a reference to a plugin object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $advlink =AdvLink::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function & getInstance()
	{
		static $instance;

		if(!is_object($instance)) {
			$instance = new WFSourcePlugin();
		}
		return $instance;
	}

	function execute()
	{
		// check token
		WFToken::checkToken('GET') or die('RESTRICTED');

		$wf = WFEditor::getInstance();

		wfimport('admin.classes.packer');

		$base = dirname(dirname(__FILE__));
		$theme = JRequest::getWord('theme', 'textmate');

		$start = '';
		$end = '';

		switch (JRequest::getWord('type', 'js')) {
			case 'js' :
				$files = array();
				$names = array('ace-uncompressed', 'mode-css', 'mode-html', 'mode-javascript');

				foreach($names as $name) {
					$files[] = $base . DS . 'js' . DS . 'ace' . DS . $name . '.js';
				}

				// load theme
				$files[] = $base . DS . 'js' . DS . 'ace' . DS . 'theme-' . $theme . '.js';

				$start = '(function(){';
				$end = '})();';

				// javascript

				$type = 'javsacript';

				break;
			case 'css' :

				// load css
				$files = array($base . DS . 'css' . DS . 'ace' . DS . 'editor.css');

				// load theme
				$file = $base . DS . 'css' . DS . 'ace' . DS . $theme . '.css';

				if(is_file($file)) {
					$files[] = $file;
				} else {
					$files[] = $base . DS . 'css' . DS . 'ace' . DS . 'textmate.css';
				}

				$type = 'css';

				break;
		}

		$packer = new WFPacker( array('type' => $type));

		// set start content
		$packer->setContentStart($start);
		// set files
		$packer->setFiles($files);
		// set end content
		$packer->setContentEnd($end);
		// pack!
		$packer->pack();
	}

}
