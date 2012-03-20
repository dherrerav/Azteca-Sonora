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
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs {position:relative;width:<?php echo $width; ?>px;margin:8px auto;border:1px solid #ccc;padding:2px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#fff url(../images/loading.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .fpssTimer {width:0;clear:both;height:6px;background-color:#f90;margin:4px 0 0 0;}
<?php else: ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;background:#000;}
.fpss-template-jj-obs .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .slidetext {position:absolute;bottom:0;left:0;width:<?php echo $width - 32; ?>px;padding:8px 16px;margin:0;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-jj-obs .slidetext h1,
.fpss-template-jj-obs .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:26px;line-height:120%;margin:0;padding:0;color:#fafafa;}
.fpss-template-jj-obs .slidetext h1 a:hover {color:#f00;text-decoration:none;}
.fpss-template-jj-obs .slidetext h2 {font-size:11px;margin:0;padding:0;color:#999;font-weight:normal;}
.fpss-template-jj-obs .slidetext h3 {font-size:13px;margin:0;padding:0;color:#fafafa;}
.fpss-template-jj-obs .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-jj-obs .slidetext p {margin:4px 0;padding:0;color:#fff;}
.fpss-template-jj-obs .slidetext a.fpssReadMore,
.fpss-template-jj-obs .slidetext a.fpssReadMore:hover {display:none;}

/* --- Navigation --- */
.fpss-template-jj-obs .navigation-wrapper {background:#ececec url(../images/navbar.png) repeat-x 50% 0;padding:4px 0 0 0;margin:0;}
.fpss-template-jj-obs .navigation {list-style:none;margin:0;padding:0;}
.fpss-template-jj-obs .navigation li.navigation-button {float:left;margin:0 4px;z-index:7;position:relative;border:1px solid #fff;opacity:0.6;filter:alpha(opacity=60);}
.fpss-template-jj-obs .navigation li.active,
.fpss-template-jj-obs .navigation li:hover,
.fpss-template-jj-obs .navigation-background {border-color:#f90;opacity:1.0;filter:alpha(opacity=100);}
.fpss-template-jj-obs .navigation-background {cursor:pointer;border:1px solid #f90;position:absolute;z-index:8;margin:0 4px;}
.fpss-template-jj-obs .navigation li.active a,
.fpss-template-jj-obs .navigation li:hover a {color:#555;text-decoration:none;}

#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation .navigation-control a {display:block;border:none;color:#999;height:<?php echo $thumbnailViewportHeight; ?>px;line-height:<?php echo $thumbnailViewportHeight; ?>px;margin:0;padding:0;text-align:center;cursor:pointer;position:relative;z-index:9;text-decoration:none;}

.fpss-template-jj-obs .navigation .navigation-control,
.fpss-template-jj-obs .navigation .navigation-next,
.fpss-template-jj-obs .navigation .navigation-previous {float:right;margin-right:4px;height:<?php echo $thumbnailViewportHeight; ?>px;;line-height:<?php echo $thumbnailViewportHeight; ?>px;}

.fpss-template-jj-obs .navigation .navigation-previous {background:url(../images/prev.gif) 50% 50% no-repeat;width:12px;}
.fpss-template-jj-obs .navigation .navigation-next {background:url(../images/next.gif) 50% 50% no-repeat;width:12px;}

#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation .navigation-previous a {display:block;line-height:<?php echo $thumbnailViewportHeight; ?>px;text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation .navigation-next a {display:block;line-height:<?php echo $thumbnailViewportHeight; ?>px;text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation-thumbnail {display:block;width:<?php echo $thumbnailViewportWidth; ?>px;height:<?php echo $thumbnailViewportHeight; ?>px;overflow:hidden;border:none;background-position:50% 50%;position:relative;z-index:9;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-jj-obs a {cursor:pointer;}
.fpss-template-jj-obs a:active,
.fpss-template-jj-obs a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-jj-obs img {border:none;}
.fpss-template-jj-obs .slidetext img,
.fpss-template-jj-obs .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 #fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation,
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-jj-obs .navigation {height:<?php echo $thumbnailViewportHeight+4; ?>px;overflow:hidden;}

/* --- End of stylesheet --- */
