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
 * @version		$Id: template.css.php 525 2011-07-19 14:03:17Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

/* --- Slideshow Container --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-tt {position:relative;width:<?php echo $width; ?>px;margin:8px auto;padding:4px;border-color:#ccc;border-style:solid;border-width:1px 2px 2px 1px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-tt .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#fff url(../images/loading.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
.fpss-template-tt .fpssTimerContainer {position:absolute;left:4px;right:4px;bottom:4px;}
.fpss-template-tt .fpssTimerContainer .fpssTimer {width:0;clear:both;height:6px;background-color:#9c0;}
<?php else: ?>
.fpss-template-tt .fpssTimerContainer,
.fpss-template-tt .fpssTimerContainer .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-tt .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;background:#000;}
.fpss-template-tt .slides {list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-tt .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;list-style:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-tt .slidetext {position:absolute;bottom:0;left:0;width:<?php echo $width - 32?>px;padding:8px 16px;margin:0;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-tt .slidetext h1,
.fpss-template-tt .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:26px;line-height:120%;margin:0;padding:0;color:#9c0;}
.fpss-template-tt .slidetext h1 a:hover {color:#f90;text-decoration:none;}
.fpss-template-tt .slidetext h2 {font-size:10px;margin:0;padding:0;color:#999;font-weight:normal;}
.fpss-template-tt .slidetext h3 {font-size:12px;margin:0;padding:2px 0;color:#fafafa;}
.fpss-template-tt .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-tt .slidetext p {margin:4px 0;padding:0;color:#fff;}
.fpss-template-tt .slidetext a.fpssReadMore {margin:0;padding:1px 0;background:none;border:none;color:#fff;line-height:14px;}
.fpss-template-tt .slidetext a.fpssReadMore:hover {margin:0;padding:1px 0;background:none;border:none;color:#f90;line-height:14px;}

/* --- Navigation --- */
.fpss-template-tt .navigation-wrapper {border-top:2px solid #505050;background:url(../images/black_stripes.gif) repeat;padding:0;margin:0;}
.fpss-template-tt .navigation-background {cursor:pointer;border:1px solid #f90;position:absolute;z-index:8;margin:0 4px;}
.fpss-template-tt .navigation {list-style:none;margin:0;padding:2px 16px 8px;}

.fpss-template-tt .navigation li.navigation-button {float:left;margin:0 4px;z-index:7;position:relative;border:1px solid #bbb;}
#fpssContainer<?php echo $mid; ?>.fpss-template-tt .navigation li a {display:block;line-height:<?php echo $thumbnailViewportHeight; ?>px;}
.fpss-template-tt .navigation li.navigation-button a {background:#000;}

.fpss-template-tt .navigation li.navigation-next,
.fpss-template-tt .navigation li.navigation-previous,
.fpss-template-tt .navigation li.navigation-control {float:left;margin:0;padding:0;}
.fpss-template-tt .navigation li.navigation-next a,
.fpss-template-tt .navigation li.navigation-previous a,
.fpss-template-tt .navigation li.navigation-control a {font-family:Tahoma, Arial, sans-serif;font-size:10px;border:none;text-align:center;padding:0 4px;margin:0;background:none;color:#9c0;text-decoration:none;}
.fpss-template-tt .navigation li.navigation-next a:hover,
.fpss-template-tt .navigation li.navigation-previous a:hover,
.fpss-template-tt .navigation li.navigation-control a:hover {color:#f90;text-decoration:none;}

.fpss-template-tt .navigation li.active,
.fpss-template-tt .navigation li.navigation-button:hover,
.fpss-template-tt .navigation-background {border:1px solid #f90;}

.fpss-template-tt .navigation li.active a,
.fpss-template-tt .navigation li:hover a {cursor:pointer;}

.fpss-template-tt .navigation li.navigation-button .navigation-thumbnail {opacity:0.6;filter:alpha(opacity=60);}
.fpss-template-tt .navigation li.active .navigation-thumbnail,
.fpss-template-tt .navigation li.navigation-button a:hover .navigation-thumbnail {opacity:1.0;filter:alpha(opacity=100);}

#fpssContainer<?php echo $mid; ?>.fpss-template-tt .navigation-thumbnail {display:block;width:<?php echo $thumbnailViewportWidth; ?>px;height:<?php echo $thumbnailViewportHeight; ?>px;overflow:hidden;border:none;background-position:50% 50%;position:relative;z-index:9;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-tt a {cursor:pointer;}
.fpss-template-tt a:active,
.fpss-template-tt a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-tt img {border:none;}
.fpss-template-tt .slidetext img,
.fpss-template-tt .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 #fpssContainer<?php echo $mid; ?>.fpss-template-tt .navigation,
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-tt .navigation {height:<?php echo $thumbnailViewportHeight+4; ?>px;overflow:hidden;}

/* --- End of stylesheet --- */
