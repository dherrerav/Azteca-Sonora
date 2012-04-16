<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
if(!include_once(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_acymailing'.DS.'helpers'.DS.'helper.php')){
	echo "Could not load Acy helper file";
	return;
}
if(defined('JDEBUG') AND JDEBUG) acymailing_displayErrors();
$taskGroup = JRequest::getCmd('ctrl',JRequest::getCmd('gtask','dashboard'));
$config =& acymailing_config();
$doc =& JFactory::getDocument();
$app =& JFactory::getApplication();
$cssBackend = $config->get('css_backend','default');
if(!empty($cssBackend)){
	$doc->addStyleSheet( ACYMAILING_CSS.'component_'.$cssBackend.'.css' );
}
JHTML::_('behavior.tooltip');
$bar = & JToolBar::getInstance('toolbar');
$bar->addButtonPath(ACYMAILING_BUTTON);
if($taskGroup != 'update' && !$config->get('installcomplete')){
	$url = acymailing_completeLink('update&task=install',false,true);
	echo "<script>document.location.href='".$url."';</script>\n";
	echo 'Install not finished... You will be redirected to the second part of the install screen<br/>';
	echo '<a href="'.$url.'">Please click here if you are not automatically redirected within 3 seconds</a>';
	return;
}
if(JRequest::getString('tmpl') !== 'component' && !JRequest::getInt('hidemainmenu') && $config->get('menu_position','under') == 'above'){
	$menuHelper = acymailing_get('helper.acymenu');
	echo $menuHelper->display($taskGroup);
}
if($taskGroup == 'config') $taskGroup = 'cpanel';
include(ACYMAILING_CONTROLLER.$taskGroup.'.php');
$className = ucfirst($taskGroup).'Controller';
$classGroup = new $className();
JRequest::setVar( 'view', $classGroup->getName() );
$classGroup->execute( JRequest::getCmd('task','listing'));
$classGroup->redirect();
if(JRequest::getString('tmpl') !== 'component'){
	echo acymailing_footer();
}