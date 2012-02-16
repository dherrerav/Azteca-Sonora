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
defined('_JEXEC') or die('Retricted Access');

class jacommentConstant{
	
	
	function get_Variable_Email()
	{
		$variable = array();
		$variable[0]->value = '[USER_NAME]';
		$variable[0]->text = 'USER_NAME - User\'s name';
		$variable[1]->value = '[USER_EMAIL]';
		$variable[1]->text = 'USER_EMAIL - User\' email';
		$variable[2]->value = '[ADMIN_NAME]';
		$variable[2]->text = 'ADMIN_NAME - Administrator\'s name';
		$variable[3]->value = '[ADMIN_EMAIL]';
		$variable[3]->text = 'ADMIN_EMAIL - Administrator\'s email';
		$variable[4]->value = '[CONTACT_EMAIL]';
		$variable[4]->text = 'CONTACT_EMAIL - Email for user contacting';
		$variable[5]->value = '[SITE_URL]';
		$variable[5]->text = 'SITE_URL - Website\'s URL';
		$variable[6]->value = '[SITE_NAME]';
		$variable[6]->text = 'SITE_NAME - Site name';
		return $variable;
	}
	
	function getEmailConfig()
	{
		global $jacconfig;
		$app = JFactory::getApplication();
		$emailConfig = array();
		
		$app = JFactory::getApplication('administrator');
		
		$emailConfig['site_contact_email'] = 'jooms@joomsolutions.com';
		$emailConfig['site_title'] = $jbconfig['emails']->get('sitname');
		$emailConfig['root_url'] = $app->getCfg('live_site');
		$emailConfig['fromemail'] = $jbconfig['emails']->get('fromemail');
		$emailConfig['fromname'] = $jbconfig['emails']->get('fromname');
		$emailConfig['admin_email'] = 'phuonglhvn@gmail.com';
		$emailConfig['admin_name'] = 'Lai Huu Phuong';
		return $emailConfig;
	}
	
	function get_Email_Group()
	{
		$result = array(
		'Ja Comment - '.JText::_("COMMENT"),
		'Ja Comment - '.JText::_("HEADER_FOOTER")
		);
		return $result;
	}
} 
?>
