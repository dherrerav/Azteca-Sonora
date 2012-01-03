<?php
$user =&JFactory::getUser();
$doc = &JFactory::getDocument();
$url  = $app->isAdmin() ? $app->getSiteURL() : JURI::base();

// set custom template theme for user
if( !is_null( JRequest::getCmd('templateTheme', NULL) ) ) {
$user->setParam($this->template.'_theme', JRequest::getCmd('templateTheme'));
$user->save(true);
}
if($user->getParam($this->template.'_theme')) {
$this->params->set('templateTheme', $user->getParam($this->template.'_theme'));
}
		
$logoFile = 'templates/'. $this->template .'/logo.png';

$profilelink = "<a href=\"" . $url . "administrator/index.php?option=com_users&view=user&task=edit&cid[]=" . $user->get('id') . "\">". JText::_( 'PROFILE' ) ."</a>";

$ap_task_set = JRequest::getCmd('ap_task') != null;
$ap_task     = JRequest::getCmd('ap_task');
$option      = JRequest::getCmd('option');
$task        = JRequest::getCmd('task');
$view        = JRequest::getCmd('view');
$layout      = JRequest::getCmd('layout');
$client      = JRequest::getCmd('client');
$section     = JRequest::getCmd('section');
$scope       = JRequest::getCmd('scope');
$menutype    = JRequest::getCmd('menutype');
$itemid    = JRequest::getCmd('Itemid');

//Template Params
$templateTheme    = $this->params->get('templateTheme');
$browserSpecific = $this->params->get('browserSpecific');

$controlPanel = $this->params->get('controlPanel');
$iconShine = $this->params->get('iconShine');

$menu = & JSite::getMenu();
if ($menu->getActive() == $menu->getDefault()) {
$padHome = 1;
} else {
$padHome = 0;
}

$showQuickAdd  = $this->params->get('showQuickAdd', 0);
$showComponentList  = $this->params->get('showComponentList', 1);
$switchSidebar  = 1;
$bottomStatus = 0;
$showBreadCrumbs = $this->params->get('showBreadCrumbs', 0);
$showCopyright  = $this->params->get('showCopyright', 1);
$showBack  = $this->params->get('showBack', 0);
$showConfig  = $this->params->get('showConfig', 0);
$showStatus  = $this->params->get('showStatus', 1);
$themeSelect  = $this->params->get('themeSelect', 0);
$decorativeBackground  = $this->params->get('decorativeBackground', 1);
$defaultButton  = $this->params->get('defaultButton', 1);

$menusAcl = $this->params->get('menusAcl', 0);
$sectionsAcl = $this->params->get('sectionsAcl', 0);
$categoriesAcl = $this->params->get('categoriesAcl', 0);
$articlesAcl = $this->params->get('articlesAcl', 0);
$componentsAcl = $this->params->get('componentsAcl', 0);
$modulesAcl = $this->params->get('modulesAcl', 0);
$pluginsAcl = $this->params->get('pluginsAcl', 0);
$templatesAcl = $this->params->get('templatesAcl', 0);
$usersAcl = $this->params->get('usersAcl', 0);
$adminAcl = $this->params->get('adminAcl', 0);
$installAcl = $this->params->get('installAcl', 0);

$flexicontentAcl = $this->params->get('flexicontentAcl', 0);
$k2Acl = $this->params->get('k2Acl', 0);
$projectforkAcl = $this->params->get('projectforkAcl', 0);
$sobi2Acl = $this->params->get('sobi2Acl', 0);
$tiendaAcl = $this->params->get('tiendaAcl', 0);
$virtuemartAcl = $this->params->get('virtuemartAcl', 0);

$wideComponents = explode(',', $this->params->get('wideComponents'));
if (in_array($option, $wideComponents) || ($task =="edit") || ($task =="add") || ($view =="item") || ($layout =="form") || (!$this->countModules('pad-side'))) {
$showSidebar = 0;
} else {
$showSidebar = 1;
}

if ($padHome && $controlPanel) {
$showSidebar = 0;
$padPanel = 1;
} else {
$padPanel = 0;
}

if ($option == "com_search") {
$showSidebar = 0;
$padPanel = 0;
$controlPanel = 0;
}

$isIpad  = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');

// Detecting Home
$menu = & JSite::getMenu();
if ($menu->getActive() == $menu->getDefault()) {
$siteHome = 1;
} else {
$siteHome = 0;
}
?>
