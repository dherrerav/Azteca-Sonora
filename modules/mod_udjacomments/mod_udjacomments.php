<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package mod_udjacomments
**/ 

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
//instantiate helper
$helper		= new modUdjaCommentsHelper($params->get('use_css',0));

//detect if we should be displaying the module
if ($helper->getViewable())
{

	//get the user (if they're logged in)
	$user		= JFactory::getUser();

	//get current URL - This is important
	$juri = JFactory::getUri();
	$currentUrl	= JURI::Current();
	$currentUrl .= ($juri->getQuery()) ? '?'.$juri->getQuery() : '';
	$comment_url = str_ireplace(JURI::base(),'',$currentUrl);
	
	//default to displaying the form
	$displayForm = true;
		
	//Are we dealing with a submission?
	if (JRequest::getString('hdnCommentForm'))
	{
		
		if ($helper->saveComment($comment_url))
		{
			$helper->sendNotifications($comment_url);
			$application = JFactory::getApplication();
			$application->redirect($currentUrl, JText::_('MOD_UDJACOMMENTS_COMMENTSAVE_SUCCESS'), 'message');
			$displayForm = false;
		}
	}

	require JModuleHelper::getLayoutPath('mod_udjacomments', $params->get('layout', 'default'));
	
}