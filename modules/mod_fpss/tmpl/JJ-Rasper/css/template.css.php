<?php
if(!isset($fpssTemplateIncluded)){
	header("Content-type: text/css; charset: utf-8");
	$width = (int) $_GET['width'];
	$height = (int) $_GET['height'];
	$sidebarWidth = (int) $_GET['sidebarWidth'];
	$thumbnailViewportWidth = (int) $_GET['thumbnailViewportWidth'];
	$thumbnailViewportHeight = (int) $_GET['thumbnailViewportHeight'];
	$timer = (bool) $_GET['timer'];
	$mid = (int) $_GET['mid'];
}
?>
/**
 * @version		$Id: template.css.php 641 2011-08-15 02:00:42Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

/* --- Slideshow Container --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper {position:relative;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:4px auto;border:1px solid #ccc;padding:2px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#000 url(../images/loading_black.gif) no-repeat 50% 50%;z-index:99;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .fpssTimerContainer {position:absolute;bottom:2px;left:2px;right:2px;z-index:101;}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .fpssTimerContainer .fpssTimer {width:0;clear:both;height:6px;background-color:#9c0;}
<?php else: ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .fpssTimerContainer,
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .fpssTimerContainer .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;background:#000;}
.fpss-template-jj-rasper .slides-wrapper .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-rasper .slidetext {position:absolute;top:0;left:50px;width:40%;height:<?php echo $height-24; ?>px;margin:0;padding:12px 8px;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-jj-rasper .slidetext h1,
.fpss-template-jj-rasper .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:24px;line-height:120%;margin:0;padding:0;color:#9c0;}
.fpss-template-jj-rasper .slidetext h1 a:hover {color:#fff;text-decoration:none;}
.fpss-template-jj-rasper .slidetext h2 {font-size:11px;color:#999;margin:0;padding:2px 0;}
.fpss-template-jj-rasper .slidetext h3 {font-size:13px;margin:2px 0;padding:1px 0;color:#ccc;border-top:1px solid #aaa;border-bottom:1px solid #aaa;}
.fpss-template-jj-rasper .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-jj-rasper .slidetext p {margin:4px 0 12px 0;padding:0;color:#fff;}
.fpss-template-jj-rasper .slidetext a.fpssReadMore {margin:0;padding:1px 4px;border:none;background:#222;color:#fff;text-decoration:none;display:inline;}
.fpss-template-jj-rasper .slidetext a.fpssReadMore:hover {margin:0;padding:1px 4px;border:none;background:#fff;color:#222;text-decoration:none;display:inline;}

/* --- Navigation --- */
.fpss-template-jj-rasper .navigation-wrapper {position:absolute;bottom:16px;right:16px;margin:0;padding:0;text-align:right;z-index:97;}
.fpss-template-jj-rasper .navigation {list-style:none;margin:0;padding:0;}
.fpss-template-jj-rasper .navigation li {float:left;margin:0 2px;padding:0;width:16px;}
.fpss-template-jj-rasper .navigation li.navigation-previous a {float:left;display:block;width:16px;height:16px;background:url(../images/nav-left.png) no-repeat;border:none;margin:0;padding:0;}
.fpss-template-jj-rasper .navigation li.navigation-next a {float:left;display:block;width:16px;height:16px;background:url(../images/nav-right.png) no-repeat;border:none;margin:0;padding:0;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-jj-rasper a {cursor:pointer;}
.fpss-template-jj-rasper a:active,
.fpss-template-jj-rasper a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-jj-rasper img {border:none;}
.fpss-template-jj-rasper .slidetext img,
.fpss-template-jj-rasper .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 .fpss-template-jj-rasper .slidetext {bottom:-1px;background:#444;}
body.fpssIsIE6 .fpss-template-jj-rasper .navigation li.navigation-previous a {background:url(../images/nav-left-ie.png) no-repeat;border:1px solid #777;}
body.fpssIsIE6 .fpss-template-jj-rasper .navigation li.navigation-next a {background:url(../images/nav-right-ie.png) no-repeat;border:1px solid #777;}
body.fpssIsIE6 .fpss-clr,
body.fpssIsIE7 .fpss-clr {display:none;}

/* --- End of stylesheet --- */
