<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted access');
ob_clean();
header ("content-type: text/xml");
    echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<language>';
    echo'<play>';
    echo '<![CDATA['._HDVS_PLAY.']]>';
    echo  '</play>';
    echo '<pause>';
    echo '<![CDATA['._HDVS_PAUSE.']]>';
    echo '</pause>';
    echo '<hdison>';
    echo '<![CDATA['._HDVS_HD_IS_ON.']]>';
    echo '</hdison>';
    echo '<hdisoff>';
    echo '<![CDATA['._HDVS_HD_IS_OFF.']]>';
    echo '</hdisoff>';
    echo '<zoom>';
    echo '<![CDATA['._HDVS_ZOOM.']]>';
    echo '</zoom>';
    echo'<share>';
    echo '<![CDATA['._HDVS_SHARE.']]>';
    echo '</share>';
    echo'<fullscreen>';
    echo '<![CDATA['._HDVS_FULL_SCREEN.']]>';
    echo '</fullscreen>';
    echo'<relatedvideos>';
    echo '<![CDATA['._HDVS_RELATED_VIDEOS.']]>';
    echo '</relatedvideos>';
    echo'<sharetheword>';
    echo '<![CDATA['._HDVS_SHARE_THE_WORD.']]>';
    echo '</sharetheword>';
    echo'<sendanemail>';
    echo '<![CDATA['._HDVS_SEND_AN_EMAIL.']]>';
    echo '</sendanemail>';
    echo'<to>';
    echo '<![CDATA['._HDVS_TO.']]>';
    echo '</to>';
    echo'<from>';
    echo '<![CDATA['._HDVS_FROM.']]>';
    echo '</from>';
    echo'<note>';
    echo '<![CDATA['._HDVS_NOTE.']]>';
    echo '</note>';
    echo'<send>';
    echo '<![CDATA['._HDVS_SEND.']]>';
    echo '</send>';
    echo'<copylink>';
    echo '<![CDATA['._HDVS_COPY_LINK.']]>';
    echo '</copylink>';
    echo'<copyembed>';
    echo '<![CDATA['._HDVS_COPY_EMBED.']]>';
    echo '</copyembed>';
    echo'<facebook>';
    echo '<![CDATA['._HDVS_FACEBOOK.']]>';
    echo '</facebook>';
    echo'<reddit>';
    echo '<![CDATA['._HDVS_RED_IT.']]>';
    echo '</reddit>';
    echo'<friendfeed>';
    echo '<![CDATA['._HDVS_FRIEND_FEED.']]>';
    echo '</friendfeed>';
    echo'<slashdot>';
    echo '<![CDATA['._HDVS_SLASH_DOT.']]>';
    echo '</slashdot>';
    echo'<delicious>';
    echo '<![CDATA['._HDVS_DELICIOUS.']]>';
    echo '</delicious>';
    echo'<myspace>';
    echo '<![CDATA['._HDVS_MY_SPACE.']]>';
    echo '</myspace>';
    echo'<wong>';
    echo '<![CDATA['._HDVS_WONG.']]>';
    echo '</wong>';
    echo'<digg>';
    echo '<![CDATA['._HDVS_DIGG.']]>';
    echo '</digg>';
    echo'<blinklist>';
    echo '<![CDATA['._HDVS_BLINK_LINT.']]>';
    echo '</blinklist>';
    echo'<bebo>';
    echo '<![CDATA['._HDVS_BEBO.']]>';
    echo '</bebo>';
    echo'<fark>';
    echo '<![CDATA['._HDVS_FARK.']]>';
    echo '</fark>';
    echo'<tweet>';
    echo '<![CDATA['._HDVS_TWEET.']]>';
    echo '</tweet>';
    echo'<furl>';
    echo '<![CDATA['._HDVS_FURL.']]>';
    echo '</furl>';
    echo '<adindicator><![CDATA[Your selection will follow this sponsors message in - seconds]]>';
    echo '</adindicator>';
    echo '<Skip><![CDATA[Skip this Video]]></Skip>';
    echo '<Skip><![CDATA[You are not Authorized Member to view this Video]]></Skip>';
    echo '</language>';
exit();
?>