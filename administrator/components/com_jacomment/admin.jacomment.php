<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/*
 * Make sure the user is authorized to view this page
 */
/* Require Helper */
require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'jahelper.php');
$GLOBALS['jacconfig'] = array();    
JACommentHelpers::get_config_system();

require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'asset' . DS . 'jaconstants.php';
// Require the base controller
require_once (JPATH_COMPONENT . DS . 'controller.php');

//Require the submenu for component

require_once (JPATH_COMPONENT.DS.'views'.DS.'jaview'.DS.'view.html.php');

JHTML::_('behavior.mootools');

if(!defined('JACOMMENT_GLOBAL_SKIN')){
//	JHTML::_('stylesheet', 'ja.comment.css',JURI::root().'administrator/components/com_jacomment/asset/css/');
//	JHTML::_('stylesheet', 'ja.popup.css',JURI::root().'components/com_jacomment/asset/css/');    
//  JHTML::_('stylesheet', 'ja.ie.php',JURI::root().'components/com_jacomment/asset/css/');    
//        
//	JHTML::_('script', 'jquery-1.4.2.js',JURI::root().'components/com_jacomment/asset/js/');	
//	JHTML::_('script', 'ja.comment.js',JURI::root().'administrator/components/com_jacomment/asset/js/');
//	JHTML::_('script', 'jquery.savecomment.js',JURI::root().'administrator/components/com_jacomment/asset/js/');
//	JHTML::_('script', 'ja.popup.js',JURI::root().'administrator/components/com_jacomment/asset/js/');
	
	JHTML::_('stylesheet', JURI::root().'administrator/components/com_jacomment/asset/css/'.'ja.comment.css');
	JHTML::_('stylesheet', JURI::root().'components/com_jacomment/asset/css/ja.popup.css');           
        
	JHTML::_('script', JURI::root().'components/com_jacomment/asset/js/jquery-1.4.2.js');	
	JHTML::_('script', JURI::root().'administrator/components/com_jacomment/asset/js/ja.comment.js');
	JHTML::_('script', JURI::root().'administrator/components/com_jacomment/asset/js/jquery.savecomment.js');
	JHTML::_('script', JURI::root().'administrator/components/com_jacomment/asset/js/ja.popup.js');	
		
   	define('JACOMMENT_GLOBAL_SKIN', true);
}

if(!defined('JACOMMENT_PLUGIN_ATD')){
	JHTML::_('stylesheet', JURI::root().'components/com_jacomment/asset/css/atd.css');    
	JHTML::_('script', JURI::root().'components/com_jacomment/libs/css/js/atd/jquery.atd.js');    
	JHTML::_('script', JURI::root().'components/com_jacomment/libs/css/js/atd/atdcsshttprequest.js');    
	JHTML::_('script', JURI::root().'components/com_jacomment/libs/css/js/atd/atd.js');    
	                               
    define('JACOMMENT_PLUGIN_ATD', true);            
}

               

jimport('joomla.application.component.model'); 
JModel::addIncludePath(JPATH_ROOT.DS.'components'.DS.'com_jacomment'.DS.'models');

if(!JRequest::getCmd('view')) JRequest::setVar('view', 'comments');

if($controller = JRequest::getCmd('view')) {	
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
$view = $controller;
if(!JRequest::getVar('tmpl')&& $view!='emailtemplates'){
	echo '<div id="jac-msg-succesfull" style="display:none"></div>';
	?>
		<script type="text/javascript">
			var siteurl = '<?php echo JURI::base()."index.php?tmpl=component&option=com_jacomment&view=".$view;?>';
			//var message=$('jac-msg-succesfull');
//			if(!message){
//				var myMessage  = new Element('div', {id: 'jac-msg-succesfull', style: 'display:none'});
//				myMessage.inject($('element-box'), 'before');				
//			}

		</script>
	<?php
}

// Create the controller
$classname = 'JACommentController' . ucfirst ( $controller );
$controller = new $classname ( );

$task = JRequest::getVar ( 'task', null, 'default', 'cmd' );

// Perform the Request task
$controller->execute ( $task );

// Redirect if set by the controller
$controller->redirect ();
?>