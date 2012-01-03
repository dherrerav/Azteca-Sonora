<?php
/**
 * @copyright	Copyright (C) 2009-2011 Pixel Praise LLC. All rights reserved.
 * @license		All derivate Joomla! code is GNU/GPL, all images and are bound by the Pixel Praise Proprietary License.
 */

// no direct access
defined('_JEXEC') or die;
JLoader::register('APHelper', JPATH_THEMES.'/'.$this->template.'/helper.php');
APHelper::setParams($this);
//1.6 Application
$app = JFactory::getApplication();

// Detecting Active Variables
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
$layout = JRequest::getCmd('layout', '');
$task = JRequest::getCmd('task', '');
$itemid = JRequest::getCmd('Itemid', '');

$controlPanel = $this->params->get('controlPanel');
$defaultButton = $this->params->get('defaultButton');
$siteName = $app->getCfg('sitename');
$menu = & JSite::getMenu();
if ($menu->getActive() == $menu->getDefault()) {
$phoneHome = 1;
} else {
$phoneHome = 0;
}
// Get the page title
$mydoc =& JFactory::getDocument();
$mytitle = $mydoc->getTitle();
if ($phoneHome) {
$mytitle = $siteName;
} else if (empty($mytitle)) {
$mytitle = $siteName;
}
$mytitle = substr($mytitle,0,17); 
if (strlen($mytitle) >= 17) {
	$mytitle = $mytitle . "...";
}

// set custom template theme for user
$user = &JFactory::getUser();
if( !is_null( JRequest::getCmd('templateTheme', NULL) ) ) {
$user->setParam($this->template.'_theme', JRequest::getCmd('templateTheme'));
$user->save(true);
}
if($user->getParam($this->template.'_theme')) {
$this->params->set('templateTheme', $user->getParam($this->template.'_theme'));
}
$templateTheme = $this->params->get('templateTheme');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<link rel="apple-touch-icon" media="screen and (resolution: 163dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-57px.png" />
<link rel="apple-touch-icon" media="screen and (resolution: 132dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-72px.png" />
<link rel="apple-touch-icon" media="screen and (resolution: 326dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-114px.png" />

<meta name="apple-touch-fullscreen" content="yes">

<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

<style type="text/css">
<?php if($this->params->get('themeColor') && $this->params->get('templateTheme') == "theme2"){ ?>
body,div#title,div.moduletable-dark{background-color:<?php echo $this->params->get('themeColor'); ?>;}
div.moduletable-dark,div.moduletable-dark li a,div.moduletable-dark ul{border-color:#000;}
<?php } ?>
<?php if($this->params->get('fontColor')){ ?>
body{color:<?php echo $this->params->get('fontColor'); ?>}
<?php } ?>
<?php if($this->params->get('linkColor')){ ?>
a:link, a:active, a:visited{color:<?php echo $this->params->get('linkColor'); ?>}
<?php } ?>
<?php if($this->params->get('headingColor')){ ?>
h1,h2,h3,h4,h5,.contentheading,.componentheading{color:<?php echo $this->params->get('headingColor'); ?>}
<?php } ?>
<?php if ($phoneHome) { ?>
div#title h1{left:0;}
<?php } ?>
<?php if ($phoneHome && $controlPanel) { ?>
body.homePage{background:#000 none;}
<?php } ?>

/* Landscape */
@media screen and (min-width: 321px)
{
#hometools{
background:url('<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/dock-wide.png') no-repeat 50% 100%;
}
}
</style>
</head>

<body style="-webkit-text-size-adjust:none" class="<?php if($phoneHome){?>homePage<?php } ?> <?php echo $option . " " . $view . " " . $layout . " " . $task . " itemid-" . $itemid . " " . $templateTheme;?>" id="top">

<?php if (!$phoneHome || !$controlPanel) { ?>
		<!-- Page Title -->
		<div id="title">
<?php } ?>

<?php if (!$phoneHome) { ?>
			<a id="back" href="javascript:history.back()">◀</a>
<?php } ?>

<?php if (($this->countModules('mobile-dropdown')) && !$phoneHome) { ?>
			<div id="title-menu">
				<ul class="parent">
					<li><a href="#" class="parent-link">Down</a>
						<jdoc:include type="modules" name="mobile-dropdown" />
					</li>
				</ul>
			</div>
<?php } ?>

<?php if (!$phoneHome || !$controlPanel) { ?>
			<h1 id="pagetitle"><?php echo $mytitle;?></h1>
		</div>
<?php } ?>

<?php if ($phoneHome && $controlPanel) { ?>
		<!--Homepage Cpanel-->
		<div id="phonepanel">
			<jdoc:include type="modules" name="mobile-1" style="xhtml" />
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div id="hometools">
			<jdoc:include type="modules" name="mobile-2" style="xhtml" />
			<div class="clr"></div>
		</div>
<?php } ?>

<?php 
if (!$phoneHome || !$controlPanel) {
//Not Homepage
?>

		<!-- Search -->
		<jdoc:include type="module" name="mod_search" style="xhtml" />
		<!-- Logo -->
		<a id="logo" href="<?php echo $this->baseurl; ?>" title="<?php echo $app->getCfg('sitename');?>"></a>
		<div class="clr"></div>
<?php if ($this->countModules('mobile-3')) { ?>
		<!--Top Menu-->
		<div id="topmenu">
			<jdoc:include type="modules" name="mobile-3" style="xhtml" />
		</div>
<?php } ?>
		<div class="clr"></div>
<?php if ($this->countModules('mobile-4')) { ?>
		<!--Main Menu-->
		<div id="mainmenu">
			<jdoc:include type="modules" name="mobile-4" style="xhtml" />
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
<?php } ?>
<?php if ($this->countModules('mobile-5')) { ?>
		<!--Banner-->
		<div id="banner">
			<jdoc:include type="modules" name="mobile-5" style="xhtml" />
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
<?php } ?>
		<!-- Begin Content -->
		<div id="content">
			<jdoc:include type="message" />
			<jdoc:include type="modules" name="mobile-6" style="xhtml" />
		<div class="rectangle">
		<div class="content">
			<jdoc:include type="component" />
		</div>
		</div>
			<jdoc:include type="modules" name="mobile-7" style="xhtml" />
		</div>
		<!--End Content-->
<?php if ($this->countModules('mobile-8')) { ?>
		<!--Bottom Menu-->
		<div id="bottommenu">
			<jdoc:include type="modules" name="mobile-8" style="xhtml" />
		</div>
<?php } ?>
<?php if ($this->countModules('mobile-9')) { ?>
		<!--Copyright-->
		<div id="copy">
			<jdoc:include type="modules" name="mobile-9" style="xhtml" />
		</div>
<?php } ?>
<?php if($defaultButton) { ?>
		<div id="default">
			View Site in <span class="active-browser">Mobile</span> or <a href="<?php echo $this->baseurl; ?>/?taptheme=default">Desktop</a>
		</div>
<?php } ?>
<a href="#top" id="gototop" class="buttonWhite">Back to Top</a>
<?php if ($this->countModules('mobile-10')) { ?>
		<!--Toolbar-->
		<div id="toolbar">
			<jdoc:include type="modules" name="mobile-10" style="xhtml" />
			<div class="clr"></div>
		</div>
<?php } ?>

<?php 
//Not Homepage
} 
?>
		<jdoc:include type="modules" name="debug" style="xhtml" />
	</body>
</html>
