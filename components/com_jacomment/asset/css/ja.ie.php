<?php header("Content-type: text/css"); ?>
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
<?php

$component_path = dirname( dirname( $_SERVER['REQUEST_URI'] ) );
global $color;
function ieversion() {
  ereg('MSIE ([0-9]\.[0-9])',$_SERVER['HTTP_USER_AGENT'],$reg);
  if(!isset($reg[1])) {
    return -1;
  } else {
    return floatval($reg[1]);
  }
}
$iev = ieversion();

?>
<?php /*All IE*/ ?>

<?php
/*IE 6*/
if ($iev == 6) {
?>

#ja-popup { position: absolute; z-index: 99999; } 

 
#ja-box-action {
    -moz-background-clip: border;
    -moz-background-inline-policy: continuous;
    -moz-background-origin: padding;
    background: transparent url(../images/settings/layout/box-action-bg.png)
        no-repeat scroll left top;
    height: 39px;
    padding-right: 6px;
    padding-top: 6px;
    text-align: center;
    width: 229px;
    float: right;
    position: absolute;
    bottom: -39px;
    right: 0;
}

<?php
}
?>


<?php
/*IE 7*/
if ($iev == 7) {
?>


<?php
}
?>


<?php
/*IE 8*/
if ($iev == 8) {
?>

<?php
}
?>
