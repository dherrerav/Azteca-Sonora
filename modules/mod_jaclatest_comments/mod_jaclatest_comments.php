<?php
defined('_JEXEC') or die('Restricted access');

if(file_exists(JPATH_SITE.DS."components".DS."com_jacomment".DS."jacomment.php")){
	// Include the syndicate functions only once
	require_once (dirname(__FILE__).DS.'helper.php');
	modJACLatestItemsHelper::loadStyle($module);
	$list = modJACLatestItemsHelper::getList($params);
	modJACLatestItemsHelper::parseItems($params,$list);
	require(JModuleHelper::getLayoutPath('mod_jaclatest_comments'));
}else{
	echo JText::_("PLEASE_SETUP_JACOMMENT_COMPONENT");
}
?>