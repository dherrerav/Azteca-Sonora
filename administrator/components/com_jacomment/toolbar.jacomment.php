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

// DEVNOTE: Pull in the class that will be used to actually display our toolbar.
require_once (JApplicationHelper::getPath ( 'toolbar_html' ));

$view = JRequest::getWord ( 'view', '' );

switch ($view) {
	case 'comments' :
		TOOLBAR_JACOMMENT::JACCOMMENT ( 'JA Comment' );
		break;	
	case 'emailtemplates' :
		TOOLBAR_JACOMMENT::JACEmails ();
		break;
	case 'configs' :
		TOOLBAR_JACOMMENT::JACConfigs ();
		break;
	case 'imexport':	
		TOOLBAR_JACOMMENT::_DEFAULT (' JA Import - Export');
		break;
	case 'customtmpl':
	case 'customcss':
	case 'managelang':
		TOOLBAR_JACOMMENT::JACDesign();
		break;
	case 'moderate':
		TOOLBAR_JACOMMENT::JACModetare();
		break;				
	default :
		TOOLBAR_JACOMMENT::_DEFAULT ();
		break;
}
?>
