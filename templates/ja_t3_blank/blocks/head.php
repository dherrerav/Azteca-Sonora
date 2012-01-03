<?php
/*
# ------------------------------------------------------------------------
# JA T3 System plugin for Joomla 1.6
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# ------------------------------------------------------------------------
*/
?>
<script type="text/javascript">
var siteurl='<?php echo JURI::base(true) ?>/';
var tmplurl='<?php echo JURI::base(true)."/templates/".T3_ACTIVE_TEMPLATE ?>/';
var isRTL = <?php echo $this->isRTL()?'true':'false' ?>;
</script>
<jdoc:include type="head" />
<?php if (T3Common::mobile_device_detect()=='iphone'):?>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1; user-scalable=1;" />
<meta name="apple-touch-fullscreen" content="YES" />
<?php endif;?>

<?php if (T3Common::mobile_device_detect()):?>
<meta name="HandheldFriendly" content="true" />
<?php endif;?>

<link href="<?php echo T3Path::getUrl('images/favicon.ico') ?>" rel="shortcut icon" type="image/x-icon" />

<?php JHTML::stylesheet ('', 'templates/system/css/system.css') ?>
<?php JHTML::stylesheet ('', 'templates/system/css/general.css') ?>

<!--[if IE 7.0]>
<style>
.clearfix { display: inline-block; } /* IE7xhtml*/

.tab_panel .nspLinks ul {
	width: 215px;
}
</style>
<![endif]-->
<script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAEaQev8MoXie5-m8w5K47BxQVYiRsYSMF-Z8kPGSZI1Xkvo-48RSipaJfIPB_Q9e41uy-DxiwOTUWlg"></script>
<script type="text/javascript">
//<![CDATA[
google.load('jquery', '1.6.2');
//]]>
</script>
<script type="text/javascript">
window.jQuery || document.write('<script src="' + siteurl + 'media/system/js/jquery.min.js">\x3C/script>');
jQuery.noConflict();
</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'es'}
</script>
<script type="text/javascript" src="/media/system/js/jcarousellite_1.0.1.pack.js"></script>
<!--[if IE > 7]>
<link type="text/css" href="/templates/ja_t3_blank/local/themes/tvazteca-default/css/ie.css" />
<![endif]-->