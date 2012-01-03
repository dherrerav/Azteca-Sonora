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

require_once('assets/variables'.DS.'variables.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo  $this->language; ?>" lang="<?php echo  $this->language; ?>" dir="<?php echo  $this->direction; ?>" id="minwidth" >
<head>
<jdoc:include type="head" />


<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<link rel="apple-touch-startup-image" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/ajax-loader.gif" />

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/portrait.css">
<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/landscape.css">
<link rel="stylesheet" media="only screen and (max-device-width: 480px)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/iphone.css" type="text/css" /> 

<link rel="apple-touch-icon" media="screen and (resolution: 163dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-57px.png" />
<link rel="apple-touch-icon" media="screen and (resolution: 132dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-72px.png" />
<link rel="apple-touch-icon" media="screen and (resolution: 326dpi)" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/iOS-114px.png" />

<script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>

<?php
// Fade out system messages
if ($this->getBuffer('message')) { ?>
<script type="text/javascript">
window.addEvent('domready',function() {
        var div = $('hiddenDiv').setStyles({
                display:'block',
                opacity: 1
        }); 
        new Fx.Style('hiddenDiv', 'opacity', {duration:2000, onComplete:
function() {
                
        new Fx.Style('hiddenDiv', 'opacity', {duration:2000}).start(0);
        }}).start(1);
}); 
</script>
<?php } ?>
</head>
<body id="minwidth-body" class="<?php echo $templateTheme. " " . $option . " " .$view . " ap-" . $task;if($showSidebar){echo " minwidth";}else{echo " fullwidth";}if($siteHome){echo " sitehome";}if($padPanel){echo " padPanel";}if($iconShine){echo " iconShine";}if($decorativeBackground){echo " decorativeBackground";}?>">
<a name="top"></a>
<?php if($showStatus) { ?>
<div id="module-status" class="logo ap-status <?php if ($bottomStatus){echo "status-bottom";}?>">
<?php if($themeSelect){
require_once('html/mod_adminpad_theme/'.DS.'mod_adminpad_theme.php');
}?>
<jdoc:include type="modules" name="pad-status" />
</div>
<?php } ?>
<div class="ap-main">
<jdoc:include type="module" name="mod_sessionbar" />
	<div id="ap-header">
		<div class="clear"></div>
		<div id="ap-mainmenu">
		<?php if($this->countModules('pad-side')){?>
		<div id="ap-sidemenu">
			<ul>
				<li>
					<a href="#" onclick="toggle_visibility('ap-sidelist');">▼
					</a>
					<ul id="ap-sidelist" style="display:none;">
						<li>
							<div id="ap-sidebar2">
								<div id="sidebar-submenu2" class="panel">
									<jdoc:include type="modules" name="pad-side" style="xhtml" />
									<div class="clear"></div>
								</div>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<?php } ?>
		<?php if(($showConfig) && ($user->get('gid') == 25)) { ?>
		<div id="ap-config">
			<form id="config_form" name="config_form" action="index.php" method="get">
				<select onchange="location 
				= document.config_form.add_select.options [document.config_form.add_select.selectedIndex].value;" name="add_select" id="filter_menutype">
					<option> - <?php echo JText::_( 'CONFIG' );?> - </option>
					<option value=""><?php echo JText::_( 'LOGOUT' );?></option>
					<option value="<?php echo $this->baseurl; ?>/index.php?option=com_login&task=logout"><?php echo JText::_( 'LOGOUT' );?></option>
					<option value="<?php echo $this->baseurl; ?>/administrator"><?php echo JText::_( 'ADMINSITE' );?></option>
				</select>
			</form>
		</div>
		<?php } ?>
		<?php if(($showQuickAdd) && ($user->get('gid') >= 23)) { ?>
					<div id="ap-quickadd">
						<form id="add_form" name="add_form" action="index.php" method="get">
							<select onchange="location 
		= document.add_form.add_select.options [document.add_form.add_select.selectedIndex].value;" name="add_select" id="filter_menutype">
								<option> - <?php echo JText::_( 'QUICK ADD' );?> - </option>
								<option value="<?php echo $this->baseurl; ?>/index.php?option=com_content&view=article&layout=form&Itemid=9999"><?php echo JText::_( 'NEW ARTICLE' );?></option>
								<option value="<?php echo $this->baseurl; ?>/index.php?option=com_weblinks&view=weblink&layout=form&Itemid=9999"><?php echo JText::_( 'NEW WEBLINK' );?></option>
							</select>
						</form>
					</div>
				<?php } ?>
				<?php if($showBreadCrumbs) { ?>
				<div id="ap-crumbs">
				<!--Begin Crumbs-->
				<?php
					require_once('html'.DS.'mod_breadcrumbs'.DS.'mod_breadcrumbs.php');
					breadcrumbs(); 
				?>
				<!--End Crumbs-->
				</div>
				<?php } ?>
			<!--begin-->
			<ul>
				<?php if((!$siteHome) && ($showBack)){?>
				<li class="ap_back"><a  href="#" onClick="history.back()">◀</a></li>
				<?php } ?>
			</ul>
			<jdoc:include type="modules" name="pad-menu" />
			<!--end-->
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="clear"></div>
	
	<div id="ap-mainbody">
	<div id="hiddenDiv"><jdoc:include type="message" />
	</div>
		<?php if(($task !="edit") && ($task !="add") && ($showSidebar)){ ?>
		<div id="ap-sidebar" class="<?php if($switchSidebar){?>dl20<?php } else { ?>dr20<?php } ?>">
			<div id="sidebar-submenu" class="panel">
				<jdoc:include type="modules" name="pad-side" style="xhtml" />
				<div class="clear"></div>
			</div>
		</div>
		<?php } ?>	
		<div id="ap-content" class="<?php if(($switchSidebar) && ($showSidebar)){?>ml20<?php } else if($showSidebar) { ?>mr20<?php } ?> <?php if($showSidebar){?>fluid<?php } ?>">	
			<div id="ap-content-inner">	
			
			<div id="ap-title">
				
				<?php
				// Get the component title div
				$title = $doc->getTitle();
				// Echo title if it exists
				if ($title) {
					echo "<div class=\"header\">" .$title. "</div>";
				} else {
				  echo "<div class=\"header\">" .$app->getCfg( 'sitename' ). "</div>";
				}
				?>
				<jdoc:include type="module" name="search" />
				<div class="clear"></div>
			</div>

			<div class="clear"></div>
			<jdoc:include type="modules" name="pad-before" />
			<div id="ap-content-wrap">
				<?php if ($padHome && $controlPanel) { ?>
				<div id="padpanel">
					<jdoc:include type="modules" name="pad-panel" style="xhtml" />
					<div class="clr"></div>
				</div>
				<?php } else { ?>
				<jdoc:include type="modules" name="pad-top" style="xhtml" />
				<jdoc:include type="component" />
				<jdoc:include type="modules" name="pad-bototm" style="xhtml" />
				<?php } ?>
			</div>
			<jdoc:include type="modules" name="pad-after" />
			<div class="clear"></div>
			<div id="ap-footer" class="ap-padding">
				<jdoc:include type="modules" name="pad-footer" />
				<!--begin-->
				<?php if($defaultButton) { ?>
						<div id="default">
							View Site for <span class="active-browser">iPad</span> or <a href="<?php echo $this->baseurl; ?>/?taptheme=default">Desktop</a>
						</div>
				<?php } ?>
				<p class="backtop"><a href="#top" id="gototop" class="buttonWhite">Back to Top</a></p>
				<?php if($showCopyright) { ?>
				<p class="copyright">
				<a target="_blank" href="http://www.taptheme.com/" title="Joomla! iPhone Templates">Joomla! iPhone Templates</a>
				&amp; <a target="_blank" href="http://www.taptheme.com/" title="Joomla! iPad Templates">Joomla! iPad Templates</a>
				by <a target="_blank" href="http://www.taptheme.com/" title="Joomla! iPhone and iPad Templates and Extensions">TapTheme</a>.
				</p>
				<?php } ?>
				<!--end-->
				<div class="clear">&nbsp;</div>
			</div>
		</div>
		<div class="clear"></div>
		</div>
		
	</div>
	
</div>
<jdoc:include type="modules" name="debug" />
</body>
</html>