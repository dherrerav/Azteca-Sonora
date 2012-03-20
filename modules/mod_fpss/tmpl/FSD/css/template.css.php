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
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd {position:relative;width:<?php echo $width+$sidebarWidth ?>px;height:<?php echo $height; ?>px;margin:4px auto;border:1px solid #b0b0b0;padding:0 16px;overflow:hidden;font-family:Georgia,"Times New Roman",Times,serif;-webkit-transform-style:preserve-3d;background:#fff;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slide-loading {position:absolute;width:<?php echo $width+$sidebarWidth; ?>px;height:<?php echo $height; ?>px;background:#fff url(../images/loading.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .fpssTimerContainer {width:<?php echo $sidebarWidth-10; ?>px;height:6px;overflow:hidden;position:absolute;z-index:111;top:8px;left:16px;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .fpssTimerContainer .fpssTimer {width:0;height:6px;background-color:#f90;}
<?php else: ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .fpssTimerContainer,
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .fpssTimerContainer .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slides-wrapper {width:<?php echo $width+$sidebarWidth; ?>px;height:<?php echo $height; ?>px;position:absolute;top:0;left:16px;right:16px;overflow:hidden;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slides-wrapper .slides .slide {width:<?php echo $width+$sidebarWidth; ?>px;height:<?php echo $height; ?>px;overflow:hidden;}

#fpssContainer<?php echo $mid; ?>.fpss-template-fsd a.slide-link {display:block;float:right;width:<?php echo $width; ?>px;height:<?php echo $height-32; ?>px;overflow:hidden;margin:0;padding:16px 0;z-index:1;text-decoration:none;border-left:1px solid #7B7B7B;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd a.slide-link:hover {text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd a.slide-link .slide-read-more {display:block;width:<?php echo $height-40; ?>px;height:20px;padding-left:10px;position:absolute;right:-1px;top:-4px;bottom:0;background:transparent url(../images/readmore.png) repeat;color:#222;text-decoration:none;font-weight:bold;-moz-transform:rotate(-90deg);-o-transform:rotate(-90deg);-webkit-transform:rotate(-90deg);-moz-transform-origin:right bottom;-o-transform-origin:right bottom;-webkit-transform-origin:right bottom;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd a.slide-link:hover .slide-read-more {color:#555;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd a.slide-link .slide-image {display:block;width:<?php echo $width; ?>px;height:<?php echo $height-32; ?>px;overflow:hidden;}

#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slidetext {width:<?php echo $sidebarWidth-12; ?>px;height:<?php echo $height; ?>px;margin:0;padding:16px 8px 4px 2px;position:absolute;z-index:9;top:0;left:0;-webkit-font-smoothing:antialiased;}

/* --- Slide Content --- */
.fpss-template-fsd .slidetext h1,
.fpss-template-fsd .slidetext h1 a {font-family:Georgia, "Times New Roman", Times, serif;font-size:18px;margin:0;padding:0;color:#0088bf;line-height:120%;}
.fpss-template-fsd .slidetext h1 a:hover {color:#cc3300;text-decoration:none;}
.fpss-template-fsd .slidetext h2 {font-size:10px;margin:0;padding:0;color:#999;}
.fpss-template-fsd .slidetext h3 {font-size:13px;margin:0;padding:2px 0;color:#555;font-weight:bold;}
.fpss-template-fsd .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:normal;}
.fpss-template-fsd .slidetext p {margin:0;padding:0;color:#333;}
.fpss-template-fsd .slidetext a.fpssReadMore {display:none;}
.fpss-template-fsd .slidetext a.fpssReadMore:hover {display:none;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .navigation-wrapper {width:<?php echo $sidebarWidth; ?>px;position:absolute;z-index:97;left:14px;bottom:16px;margin:0;padding:0;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .navigation {list-style:none;margin:0;padding:0;position:relative;width:<?php echo $sidebarWidth-12; ?>px;}
.fpss-template-fsd .navigation li.navigation-button {display:block;float:left;margin:2px;z-index:7;position:relative;border:1px solid #bbb;opacity:0.6;filter:alpha(opacity=60);}
.fpss-template-fsd .navigation li.active,
.fpss-template-fsd .navigation li:hover,
.fpss-template-fsd .navigation-background {border-color:#f90;opacity:1.0;filter:alpha(opacity=100);}
.fpss-template-fsd .navigation-background {cursor:pointer;border:1px solid #f90;position:absolute;z-index:8;margin:2px;}
.fpss-template-fsd .navigation li a {display:block;padding:0;margin:0;overflow:hidden;position:relative;z-index:9;text-decoration:none;}
.fpss-template-fsd .navigation li a:hover {text-decoration:none;}
#fpssContainer<?php echo $mid; ?>.fpss-template-fsd .navigation-thumbnail {display:block;width:<?php echo $thumbnailViewportWidth; ?>px;height:<?php echo $thumbnailViewportHeight; ?>px;overflow:hidden;border:none;background-position:50% 50%;position:relative;z-index:9;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-fsd a {cursor:pointer;}
.fpss-template-fsd a:active,
.fpss-template-fsd a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-fsd img {border:none;}
.fpss-template-fsd .slidetext img,
.fpss-template-fsd .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 .fpss-template-fsd .slide-image,
body.fpssIsIE7 .fpss-template-fsd .slide-image {cursor:pointer;}

body.fpssIsIE6 #fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slide-link .slide-read-more,
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slide-link .slide-read-more,
body.fpssIsIE8 #fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slide-link .slide-read-more {background:#fff;top:16px;bottom:0;left:<?php echo ($sidebarWidth+$width)-20; ?>px;filter:progid:DXImageTransform.Microsoft.Matrix(M11=6.123233995736766e-17, M12=1, M21=-1, M22=6.123233995736766e-17, sizingMethod='auto expand');zoom:1;}
body.fpssIsIE9 #fpssContainer<?php echo $mid; ?>.fpss-template-fsd .slide-link .slide-read-more {-ms-transform-origin:right bottom;-ms-transform:rotate(-90deg);}

body.fpssIsIE6 .fpss-template-fsd .slidetext,
body.fpssIsIE7 .fpss-template-fsd .slidetext,
body.fpssIsIE8 .fpss-template-fsd .slidetext {background:#fff;}

/* --- End of stylesheet --- */
