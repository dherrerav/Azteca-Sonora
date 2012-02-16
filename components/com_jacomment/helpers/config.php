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

defined( '_JEXEC' ) or die( 'Restricted access' );	
//get config general
global $jacconfig;
$app = JFactory::getApplication();
$generalView = "all";
if(!isset($jacconfig['general'])){
	$jacconfig['general'] = new JRegistry;
    $jacconfig['general']->loadJSON('{}');
}
if(isset($jacconfig['general'])){
	$generalView = $jacconfig['general']->get('view', "all");
}

//get config of layout
if(!isset($jacconfig['layout'])){
	$jacconfig['layout'] = new JRegistry;
    $jacconfig['layout']->loadJSON('{}');
}
$enableAvatar 				= $jacconfig['layout']->get('enable_avatar', 0);
$useDefaultAvatar			= $jacconfig['layout']->get('use_default_avatar', 0);
$avatarSize					= $jacconfig['layout']->get('avatar_size', 1);	
$buttonType					= $jacconfig['layout']->get('button_type', 1);
$formPosition				= $jacconfig['layout']->get('form_position');
$enableSubscribeMenu		= $jacconfig['layout']->get('enable_subscribe_menu', 1);
$enableSortingOptions		= $jacconfig['layout']->get('enable_sorting_options', 1);   
$defaultSort				= $jacconfig['layout']->get('default_sort', 1);
$defaultSortType			= $jacconfig['layout']->get('default_sort_type', "ASC");
$enableTimestamp			= $jacconfig['layout']->get('enable_timestamp', 1);
$enableUserRepIndicator		= $jacconfig['layout']->get('enable_user_rep_indicator', 1);		
$footerText					= $jacconfig['layout']->get('footer_text',"");
$theme					 	= $jacconfig['layout']->get('theme', 'default');
$session = &JFactory::getSession();
if(JRequest::getVar("jacomment_theme", '')){
	jimport( 'joomla.filesystem.folder' );
	$themeURL = JRequest::getVar("jacomment_theme");
	if(JFolder::exists('components/com_jacomment/themes/'.$themeURL) || (JFolder::exists('templates/'.$app->getTemplate().'/html/com_jacomment/themes/'.$themeURL))){
		$theme =  $themeURL;						
	}
	$session->set('jacomment_theme', $theme);			
}else{
	if($session->get('jacomment_theme', null)){
		$theme = $session->get('jacomment_theme', $theme);
	}
}

$enableBbcode				= $jacconfig['layout']->get('enable_bbcode', 1);
$enableYoutube				= $jacconfig['layout']->get('enable_youtube', 1);
$enableAfterTheDeadline		= $jacconfig['layout']->get('enable_after_the_deadline', 1);
$enableSmileys				= $jacconfig['layout']->get('enable_smileys', 1);
$smiley 					= $jacconfig['layout']->get('smiley', 'default');
	
//get config of comments
if(!isset($jacconfig['comments'])){
	$jacconfig['comments'] = new JRegistry;
    $jacconfig['comments']->loadJSON('{}');
}
$isEnableWebsiteField		= $jacconfig['comments']->get('is_enable_website_field', 0);
$isEnableEmailSubscription  = $jacconfig['comments']->get('is_enable_email_subscription', 1);
$isAllowVoting				= $jacconfig['comments']->get('is_allow_voting', 1);
$isAttachImage  			= $jacconfig['comments']->get('is_attach_image', 0);
$attachFileType				= $jacconfig['comments']->get('attach_file_type', "doc,docx,pdf,txt,zip,rar,jpg,bmp,gif,png");
$totalAttachFile			= $jacconfig['comments']->get('total_attach_file', 5);
$isAllowReport  			= $jacconfig['comments']->get('is_allow_report', 1);
$maximumCommentInItem 		= $jacconfig['comments']->get('maximum_comment_in_item', 20);
$isEnableThreads			= $jacconfig['comments']->get('is_enable_threads', 1);
$isEnableAutoexpanding		= $jacconfig['comments']->get('is_enable_autoexpanding', 1);
$isEnableRss				= $jacconfig['comments']->get('is_enable_rss', 1);

//Spam Fiters
if(!isset($jacconfig['spamfilters'])){
	$jacconfig['spamfilters'] = new JRegistry;
    $jacconfig['spamfilters']->loadJSON('{}');
}
$isEnableCaptcha			= $jacconfig['spamfilters']->get('is_enable_captcha', 1);
$isEnableCaptchaUser		= $jacconfig['spamfilters']->get('is_enable_captcha_user', 0);
$isEnableTerms				= $jacconfig['spamfilters']->get('is_enable_terms', 0);		
$termsOfUsage				= $jacconfig['spamfilters']->get('terms_of_usage', 0);
$minLength					= $jacconfig['spamfilters']->get('min_length', 0);
$maxLength				    = $jacconfig['spamfilters']->get('max_length', 1000);
$numberOfLinks				= $jacconfig['spamfilters']->get('number_of_links', 5);

//Moderator

//Permissions
if(!isset($jacconfig['permissions'])){
	$jacconfig['permissions'] = new JRegistry;
    $jacconfig['permissions']->loadJSON('{}');
}
$postComment				= $jacconfig['permissions']->get('post', "all");

$voteComment				= $jacconfig['permissions']->get('vote', "all");
$typeVote					= $jacconfig['permissions']->get('type_voting', 1);

$reportComment				= $jacconfig['permissions']->get('report',"all");
$totalToReportSpam			= $jacconfig['permissions']->get('total_to_report_spam', 10);

$typeEditing				= $jacconfig['permissions']->get('type_editing', 1);
$lagEditing					= $jacconfig['permissions']->get('lag_editing', 172800);


//info of current user
$currentUserInfo = JFactory::getUser();

$isShowCaptcha 		= 0;

if($currentUserInfo->guest){
	//check to show captcha
	if($isEnableCaptcha)
		$isShowCaptcha = 1;
	//check to show button report		
}else{
	//check to show captcha
	if($isEnableCaptcha && $isEnableCaptchaUser)
		$isShowCaptcha = 1;
			
}

//check user is allow edit or delete comment
$helper = new JACommentHelpers ( );
$isSpecialUser = $helper->isSpecialUser();
if($isSpecialUser){
	$isShowCaptcha = 0;
	$isEnableTerms = 0;
}
jimport( 'joomla.filesystem.folder' );	

$task = JRequest::getVar('task', null, 'default', 'cmd'); 
if($task=='preview'){
    // layout & plugin
    $theme = JRequest::getVar('theme');
    $enableAvatar = JRequest::getInt('enable_avatar');
    $useDefaultAvatar = JRequest::getInt('use_default_avatar');
    $avatarSize = JRequest::getInt('avatar_size');    
    $buttonType = JRequest::getInt('button_type');
    $enableCommentForm = JRequest::getInt('enable_comment_form');
    $formPosition = JRequest::getInt('form_position');
    $enableSortingOptions = JRequest::getInt('enable_sorting_options');
    $defaultSort = JRequest::getInt('default_sort');
    $defaultSortType = JRequest::getInt('default_sort_type');
    $enableTimestamp = JRequest::getInt('enable_timestamp');
    $footerText = JRequest::getVar('footer_text');
    
    // comment
    $isEnableThreads = JRequest::getInt('is_enable_threads');       
    $isAllowVoting = JRequest::getInt('is_allow_voting');
    $isAttachImage = JRequest::getInt('is_attach_image');
    $isEnableWebsiteField = JRequest::getInt('is_enable_website_field');
    
    $isEnableAutoexpanding = JRequest::getInt('is_enable_autoexpanding');
    $isEnableEmailSubscription = JRequest::getInt('is_enable_email_subscription');    
    $isAllowReport = JRequest::getInt('is_allow_report');

    // spamfilter
    $isShowCaptcha = JRequest::getInt('is_enable_captcha');       
    $isEnableTerms = JRequest::getInt('is_enable_terms');
}			
?>