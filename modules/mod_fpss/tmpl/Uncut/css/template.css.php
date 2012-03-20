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
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut {position:relative;width:<?php echo $width+$sidebarWidth; ?>px;height:<?php echo $height; ?>px;margin:8px auto;border:1px solid #333;padding:0;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;background:#000;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#000 url(../images/loading_black.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
.fpss-template-uncut .fpssTimer {width:0;clear:both;height:4px;background-color:#C32851;position:absolute;left:0;right:0;bottom:0;z-index:101;}
<?php else: ?>
.fpss-template-uncut .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;float:left;position:relative;overflow:hidden;background:#000;}
.fpss-template-uncut .slides-wrapper .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut .slides-wrapper .slides .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut .slides-wrapper .slides .slide .slidetext {position:absolute;left:0;bottom:0;width:<?php echo $width-24; ?>px;margin:0;padding:4px 12px 8px;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-uncut .slidetext h1,
.fpss-template-uncut .slidetext h1 a {color:#fff;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:20px;margin:0;padding:0;line-height:120%;}
.fpss-template-uncut .slidetext h1 a:hover {color:#fff;text-decoration:none;}
.fpss-template-uncut .slidetext h2 {color:#fafafa;font-size:10px;padding:0;margin:0;}
.fpss-template-uncut .slidetext h3 {display:none;}
.fpss-template-uncut .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-weight:normal;font-style:normal;}
.fpss-template-uncut .slidetext p {margin:4px 0;padding:0;color:#fff;}
.fpss-template-uncut .slidetext a.fpssReadMore,
.fpss-template-uncut .slidetext a.fpssReadMore:hover {display:none;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-uncut .navigation-wrapper {width:<?php echo $sidebarWidth; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;float:left;overflow-x:hidden;overflow-y:auto;background:#363636;}
.fpss-template-uncut .navigation {list-style:none;margin:0;padding:0;}
.fpss-template-uncut .navigation li {background:#141414 url(../images/nav.gif) repeat-x bottom;z-index:7;height:56px;border-bottom:1px solid #333;}
.fpss-template-uncut .navigation li.active,
.fpss-template-uncut .navigation li:hover,
.fpss-template-uncut .navigation-background {background:#C32851 url(../images/nav-over.gif) repeat-x bottom;}
.fpss-template-uncut .navigation-background {border:none;position:absolute;z-index:8;}
.fpss-template-uncut .navigation li a {display:block;padding:4px;margin:0;text-decoration:none;font-size:11px;color:#fff;overflow:hidden;position:relative;z-index:9;}

.fpss-template-uncut .navigation-title {display:block;font-size:14px;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-weight:bold;color:#fff;line-height:13px;padding-bottom:2px;}
.fpss-template-uncut .navigation-tagline {font-weight:normal;font-size:11px;color:#fafafa;margin:0;padding:0;line-height:12px;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-uncut a {cursor:pointer;}
.fpss-template-uncut a:active,
.fpss-template-uncut a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-uncut img {border:none;}
.fpss-template-uncut .slidetext img,
.fpss-template-uncut .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE7 .fpss-template-uncut .navigation li {margin-top:-1px;}

/* --- End of stylesheet --- */
