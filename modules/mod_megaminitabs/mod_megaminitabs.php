<?php
/**===========================================================================================
# mod_megaminitabs		Mega Mini Tabs module for Joomla 1.6.0
#=============================================================================================
# author				OmegaTheme.com
# copyright				Copyright (C) 2011 OmegaTheme.com. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website				http://omegatheme.com
# Technical support		Forum - http://omegatheme.com/forum/
#=============================================================================================*/


/**------------------------------------------------------------------------
* file: mod_megaminitabs.php 1.6.0 00001, Mar 2011 12:00:00Z OmegaTheme:Linh $
* package:	Mega Mini Tabs module free version
* description: main module file	
*------------------------------------------------------------------------*/

defined('_JEXEC') or die ('Restricteted access');

JHTML::_('behavior.framework', true);
$doc = &Jfactory::getDocument();
$doc->addStyleSheet(JURI::root().'modules/mod_megaminitabs/css/mod_megaminitabs.css');

require_once (dirname(__FILE__).DS.'helper.php');
$list_of_tabs = modMegaMiniTabsHelper::getTabsSelection($params);

require JModuleHelper::getLayoutPath('mod_megaminitabs', $params->get('layout', 'default'));
?>
