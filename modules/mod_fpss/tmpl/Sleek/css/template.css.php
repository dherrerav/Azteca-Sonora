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
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek {position:relative;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;border:2px solid #ccc;margin:4px auto;padding:0;overflow:hidden;font-family:Tahoma, Arial, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#000 url(../images/loading_black.gif) no-repeat 50% 50%;z-index:101;} /* Use highest z-index to hide all slideshow contents */

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
.fpss-template-sleek .fpssTimer {width:0;clear:both;position:absolute;bottom:0;height:6px;background:#9c0;}
<?php else: ?>
.fpss-template-sleek .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;background:#000;}
.fpss-template-sleek .slides-wrapper .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .slides-wrapper .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .slides-wrapper .slide .slidetext {position:absolute;bottom:25px;left:0;width:<?php echo $width-$sidebarWidth-16-30; ?>px;padding:4px 8px;margin:0;background:url(../images/transparent_bg.png) repeat;z-index:1;}

/* --- Slide Content --- */
.fpss-template-sleek .slidetext h1,
.fpss-template-sleek .slidetext h1 a {margin:0;padding:0;font-weight:bold;font-size:16px;line-height:120%;color:#9c0;}
.fpss-template-sleek .slidetext h1 a:hover {color:#f90;text-decoration:none;}
.fpss-template-sleek .slidetext h2 {display:none;}
.fpss-template-sleek .slidetext h3 {margin:0;padding:0;color:#fff;font-size:12px;font-weight:normal;}
.fpss-template-sleek .slidetext h4 {display:none;}
.fpss-template-sleek .slidetext p {display:none;}
.fpss-template-sleek .slidetext a.fpssReadMore,
.fpss-template-sleek .slidetext a.fpssReadMore:hover {display:none;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation-wrapper {position:absolute;right:0;bottom:16px;width:<?php echo $sidebarWidth; ?>px;padding:0;margin:0;z-index:97;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation-wrapper .navigation-pseudo-container {position:absolute;top:6px;left:0;right:0;margin:0;padding:0;background:#444;opacity:0.8;filter:alpha(opacity=80);width:<?php echo $sidebarWidth; ?>px;height:<?php echo $thumbnailViewportHeight+4; ?>px;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation-wrapper .navigation-background {cursor:pointer;margin:7px 2px 0;border:1px solid #fff;position:absolute;z-index:8;width:<?php echo $thumbnailViewportWidth; ?>px!important;height:<?php echo $thumbnailViewportHeight; ?>px!important;}
.fpss-template-sleek .navigation-wrapper .navigation {list-style:none;margin:0;padding:0;text-align:right;display:block;}
.fpss-template-sleek .navigation-wrapper .navigation .navigation-button {float:left;margin:0 2px;z-index:7;position:relative;}

#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-button a {display:block;float:left;background:none;height:<?php echo $thumbnailViewportHeight+12; ?>px;line-height:<?php echo $thumbnailViewportHeight+12; ?>px;margin:0;padding:7px 0 0 0;text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .active a,
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-button a:hover {background:url(../images/nav-current.gif) no-repeat 50% 0;text-decoration:none;}

.fpss-template-sleek .navigation-wrapper .navigation .navigation-button a span.navigation-thumbnail {border:1px solid #aaa;opacity:0.7;filter:alpha(opacity=70);}
.fpss-template-sleek .navigation-wrapper .active a span.navigation-thumbnail,
.fpss-template-sleek .navigation-wrapper .navigation-button a:hover span.navigation-thumbnail,
.fpss-template-sleek .navigation-wrapper .navigation-background {border:1px solid #fff;opacity:1.0;filter:alpha(opacity=100);}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation-wrapper .navigation .navigation-button a span.navigation-thumbnail {display:block;width:<?php echo $thumbnailViewportWidth; ?>px;height:<?php echo $thumbnailViewportHeight; ?>px;overflow:hidden;background-position:50% 50%;position:relative;z-index:9;}

#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-previous {float: left;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-previous a,
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-next a {display:block;float:left;width:9px;height:<?php echo $thumbnailViewportHeight+2; ?>px;line-height:<?php echo $thumbnailViewportHeight+2; ?>px;margin:7px 2px 0;padding:0;overflow:hidden;position:relative;z-index:9;text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-previous a {background:url(../images/nav-prev.gif) no-repeat 50% 50%;}
#fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-next a {background:url(../images/nav-next.gif) no-repeat 50% 50%;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-sleek a {cursor:pointer;}
.fpss-template-sleek a:active,
.fpss-template-sleek a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-sleek img {border:none;}
.fpss-template-sleek .slidetext img,
.fpss-template-sleek .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation-wrapper .navigation-pseudo-container {top:22px;}
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-sleek .navigation .navigation-previous a {margin-top:24px;}
body.fpssIsIE6 .fpss-clr,
body.fpssIsIE7 .fpss-clr {display:none;}

/* --- End of stylesheet --- */
