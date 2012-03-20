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
 * @version		$Id: template.css.php 644 2011-08-15 03:33:23Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

/* --- Slideshow Container --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-movies {position:relative;width:<?php echo $width+$sidebarWidth; ?>px;height:<?php echo $height; ?>px;margin:8px auto;border:1px solid #999;padding:2px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#000 url(../images/loading_black.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .fpssTimerContainer {position:absolute;bottom:2px;left:2px;right:<?php echo $sidebarWidth+2; ?>px;z-index:101;}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .fpssTimerContainer .fpssTimer {width:0;clear:both;height:6px;background-color:#c00;}
<?php else: ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .fpssTimerContainer,
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .fpssTimerContainer .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;float:left;position:relative;overflow:hidden;background:#3a3a3a;}
.fpss-template-movies .slides-wrapper .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
.fpss-template-movies .slidetext {position:absolute;top:0;left:50px;width:40%;height:<?php echo $height; ?>px;margin:0;padding:0 8px;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-movies .slidetext h1 {padding:20px 0 2px;}
.fpss-template-movies .slidetext h1,
.fpss-template-movies .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:28px;line-height:120%;margin:0;color:#fff;}
.fpss-template-movies .slidetext h1 a {padding:0;}
.fpss-template-movies .slidetext h1 a:hover {color:#c00;text-decoration:none;}
.fpss-template-movies .slidetext h2 {font-size:11px;margin:0;padding:0;color:#bbb;font-weight:normal;}
.fpss-template-movies .slidetext h3 {font-size:11px;margin:0 0 4px 0;padding:0;display:none;}
.fpss-template-movies .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-movies .slidetext p {margin:0;padding:8px 0;background:url(../images/dotted.gif) repeat-x bottom;color:#fff;}
.fpss-template-movies .slidetext a.fpssReadMore {position:absolute;left:8px;bottom:12px;width:100px;margin:0;padding:6px 0 6px 12px;background:url(../images/readmore.png) no-repeat;color:#fff;border:none;text-decoration:none;}
.fpss-template-movies .slidetext a.fpssReadMore:hover {background:url(../images/readmore-hover.png) no-repeat;color:#fff;text-decoration:none;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation-wrapper {width:<?php echo $sidebarWidth; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;float:left;overflow-x:hidden;overflow-y:auto;background:#3a3a3a;}
.fpss-template-movies .navigation {list-style:none;margin:0;padding:0;}
.fpss-template-movies .navigation li {background:#505050 url(../images/nav.gif) repeat-x 0 100%;z-index:7;}
.fpss-template-movies .navigation li.active,
.fpss-template-movies .navigation li:hover,
.fpss-template-movies .navigation-background {background:#d2d2d2 url(../images/nav-active.gif) repeat-x bottom;}
.fpss-template-movies .navigation-background {border:none;position:absolute;z-index:8;}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation li.navigation-button a {display:block;padding:4px 12px;margin:0;text-decoration:none;font-size:11px;color:#fff;position:relative;z-index:9;height:<?php echo $thumbnailViewportHeight+24; ?>px;overflow:hidden;border-top:1px solid #5c5a5b;}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation li.active a,
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation li.navigation-button a:hover {border-top:1px solid #6a6a6a;}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation li.navigation-button:first-child a {border-top:0;}
#fpssContainer<?php echo $mid; ?>.fpss-template-movies .navigation-thumbnail {float:left;width:<?php echo $thumbnailViewportWidth; ?>px;height:<?php echo $thumbnailViewportHeight; ?>px;margin:2px 8px 0 0;overflow:hidden;border:2px solid #232323;background-position:50% 50%;}
.fpss-template-movies .navigation-info {clear:right;}
.fpss-template-movies .navigation-title {color:#fff;display:block;font-size:12px;font-weight:bold;line-height:13px;margin:0;padding:0;}
.fpss-template-movies .navigation-tagline {color:#F2F2F2;font-size:11px;font-weight:normal;line-height:12px;margin:0;padding:0;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-movies a {cursor:pointer;}
.fpss-template-movies a:active,
.fpss-template-movies a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-movies img {border:none;}
.fpss-template-movies .slidetext img,
.fpss-template-movies .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 .fpss-template-movies .navigation-thumbnail {position:relative;z-index:9;}

body.fpssIsIE6 .fpss-clr,
body.fpssIsIE7 .fpss-clr {display:none;}

/* --- End of stylesheet --- */
