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
#fpssContainer<?php echo $mid; ?>.fpss-template-simple {position:relative;width:<?php echo $width; ?>px;margin:8px auto;border-color:#ccc;border-style:solid;border-width:1px 2px 2px 1px;padding:4px;overflow:hidden;font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;-webkit-transform-style:preserve-3d;}

/* --- Loader --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slide-loading {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;background:#fff url(../images/loading.gif) no-repeat center center;z-index:100;}

/* --- Timer (progress bar) --- */
<?php if($timer): ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .fpssTimer {position:absolute;left:0;bottom:0;width:0;clear:both;height:6px;background-color:#c00;z-index:99;}
<?php else: ?>
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .fpssTimer {display:none;}
<?php endif; ?>

/* --- Slide Containers --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin:0;padding:0;position:relative;overflow:hidden;background:#000;}
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides {}
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides .slide {position:absolute;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;overflow:hidden;}
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides .slide a.slide-link {position:absolute;}
#fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides .slide .slidetext {position:absolute;bottom:0;left:0;right:0;width:auto;padding:4px 8px 12px 8px;margin:0;background:url(../images/transparent_bg.png);z-index:1;}

/* --- Slide Content --- */
.fpss-template-simple .slidetext h1,
.fpss-template-simple .slidetext h1 a {font-family:"Trebuchet MS", Trebuchet, Arial, Verdana, sans-serif;font-size:26px;line-height:120%;margin:0;padding:0;color:#fafafa;}
.fpss-template-simple .slidetext h1 a:hover {color:#f00;text-decoration:none;}
.fpss-template-simple .slidetext h2 {font-size:11px;margin:0;padding:0;color:#999;font-weight:normal;}
.fpss-template-simple .slidetext h3 {font-size:13px;margin:0;padding:0;color:#fafafa;}
.fpss-template-simple .slidetext h4 {font-size:11px;margin:0;padding:0;color:#999;font-style:italic;}
.fpss-template-simple .slidetext p {margin:4px 0;padding:0;color:#fff;}
.fpss-template-simple .slidetext a.fpssReadMore {margin:0;padding:1px 8px;background:url(../images/readmore.png) repeat-x center;color:#fff;line-height:20px;border:1px solid #505050;text-decoration:none;display:inline;}
.fpss-template-simple .slidetext a.fpssReadMore:hover {margin:0;padding:1px 8px;background:url(../images/readmore-hover.png) repeat-x center;color:#222;line-height:20px;border:1px solid #505050;text-decoration:none;display:inline;}

/* --- Navigation --- */
#fpssContainer<?php echo $mid; ?>.fpss-template-simple div.navigation-wrapper {width:<?php echo $width; ?>px;border-top:2px solid #404040;margin:0;padding:2px 0;background:#222;}
.fpss-template-simple ul.navigation {background:#222;margin:0;padding:0 16px 0 34px;list-style:none;text-align:right;float:right;}
.fpss-template-simple ul.navigation li {display:block;width:20px;float:left;background:#222;border:1px solid #222;margin-right:4px;z-index:7;}
.fpss-template-simple ul.navigation li.active,
.fpss-template-simple ul.navigation li:hover,
.fpss-template-simple div.navigation-background {border:1px solid #505050;}
.fpss-template-simple div.navigation-background {position:absolute;z-index:8;}
.fpss-template-simple ul.navigation li a {display:block;padding:1px;margin:0;text-decoration:none;font-family:Tahoma, Arial, sans-serif;font-size:10px;color:#fff;overflow:hidden;position:relative;z-index:9;text-align:center;}
.fpss-template-simple ul.navigation li.active a,
.fpss-template-simple ul.navigation li:hover a {color:#f00;}
.fpss-template-simple ul.navigation li.navigation-previous,
.fpss-template-simple ul.navigation li.navigation-next,
.fpss-template-simple ul.navigation li.navigation-control {border:none;padding:1px;width:auto;}

.fpss-template-simple ul.navigation li.navigation-control {clear:right;width:30px;}
.fpss-template-simple ul.navigation li.navigation-control a {text-align:center;}

/* --- Generic Styling (highly recommended) --- */
.fpss-template-simple a {cursor:pointer;}
.fpss-template-simple a:active,
.fpss-template-simple a:focus {outline:0;outline:expression(hideFocus='true');}
.fpss-template-simple img {border:none;}
.fpss-template-simple .slidetext img,
.fpss-template-simple .slidetext p img {display:none;}
.fpss-clr {clear:both;float:none;height:0;line-height:0;margin:0;padding:0;border:0;}

/* --- IE Specific Styling (use body.fpssIsIE6, body.fpssIsIE7, body.fpssIsIE8 to target specific IEs) --- */
body.fpssIsIE6 #fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides .slide .slidetext,
body.fpssIsIE7 #fpssContainer<?php echo $mid; ?>.fpss-template-simple .slides-wrapper .slides .slide .slidetext {width:99%;}
body.fpssIsIE6 .fpss-clr,
body.fpssIsIE7 .fpss-clr {display:none;}

/* --- End of stylesheet --- */
