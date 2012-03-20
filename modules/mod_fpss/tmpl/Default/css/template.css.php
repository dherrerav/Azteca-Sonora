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
 * @version		$Id: template.css.php 630 2011-08-12 13:13:19Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

/* CONTAINER */
#fpssContainer<?php echo $mid; ?>.fpss-template-default {position:relative; width:<?php echo $width; ?>px;margin:8px auto;border-color:#cccccc;border-style:solid;border-width:1px 2px 2px 1px;padding:4px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* LOADER */
#fpssContainer<?php echo $mid; ?>.fpss-template-default .slide-loading {position:absolute; width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#fff url(../images/loading.gif) no-repeat center center;z-index:100;}

/* TIMER */
<?php if($timer): ?>
.fpss-template-default .timer {position:absolute;left:0;bottom:0;width:0;clear:both;height:6px;background-color:#c00;z-index:10;}
<?php else: ?>
.fpss-template-default .timer {display:none;}
<?php endif; ?> 

/* SLIDES */
#fpssContainer<?php echo $mid; ?>.fpss-template-default .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;}
.fpss-template-default .slides {list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-default .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
.fpss-template-default .slidetext {position:absolute;bottom:0;left:0;right:0;width:auto;padding:4px 8px 12px 8px;margin:0;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-default .slidetext h1,
.fpss-template-default .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:26px;line-height:120%;margin:0;padding:0;color:#fafafa;}
.fpss-template-default .slidetext h1 a:hover {color:#f00;text-decoration:none;}
.fpss-template-default .slidetext h2 {font-size:11px;margin:0;padding:0;color:#999;font-weight:normal;}
.fpss-template-default .slidetext h3 {font-size:13px;margin:0;padding:2px 0;color:#eee;}
.fpss-template-default .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-default .slidetext p {margin:4px 0;padding:0;color:#fff;}
.fpss-template-default .slidetext a.fsReadMore {margin:0;padding:1px 8px;background:url(../images/readmore.png) repeat-x center;color:#fff;line-height:20px;border:1px solid #505050;text-decoration:none;display:inline;}
.fpss-template-default .slidetext a.fsReadMore:hover {margin:0;padding:1px 8px;background:url(../images/readmore-hover.png) repeat-x center;color:#222;line-height:20px;border:1px solid #505050;text-decoration:none;display:inline;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-default .navigation-wrapper {width:<?php echo $width; ?>px;border-top:2px solid #404040;margin:0;padding:0;background:#222;}
.fpss-template-default .navigation {background:#222;margin:0;padding:0 16px 0 34px;list-style:none;text-align:right;float:right;}
.fpss-template-default .navigation li {display:block;width:30px;float:left;background:#222;border:1px solid #222;margin-right:4px;z-index:7;}
.fpss-template-default .navigation li.active,
.fpss-template-default .navigation li:hover,
.fpss-template-default .navigation-background {border:1px solid #505050;}
.fpss-template-default .navigation-background {position:absolute;z-index:8;}
.fpss-template-default .navigation li a {display:block;padding:1px;margin:0;text-decoration:none;font-family:Tahoma, Arial, sans-serif;font-size:10px;color:#fff;overflow:hidden;position:relative;z-index:9;text-align:center;}
.fpss-template-default .navigation li.active a,
.fpss-template-default .navigation li:hover a {color:#f00;}
.fpss-template-default .navigation .navigation-control {clear:right;}
.fpss-template-default .navigation .navigation-control a {text-align:center;}

.fpss-template-default .navigation .navigation-previous a,
.fpss-template-default .navigation .navigation-next a,
.fpss-template-default .navigation .navigation-control a {border:none;}


/* --- Generic Styling (highly recommended) --- */
.fpss-template-default a {cursor:pointer;}
.fpss-template-default a:active,
.fpss-template-default a:focus {outline:0;}
.fpss-template-default img {border:none;}
.fpss-template-default .slidetext img,
.fpss-template-default .slidetext p img {display:none;}
.fpss-clr {clear:both;height:0;line-height:0;}

/* IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) */
body.fpssIsIE6 .fpss-template-default a:active,
body.fpssIsIE6 .fpss-template-default a:focus {outline:expression(hideFocus='true');}
body.fpssIsIE6 .fpss-clr, 
body.fpssIsIE7 .fpss-clr {display:none;}

/* --- End of stylesheet --- */
