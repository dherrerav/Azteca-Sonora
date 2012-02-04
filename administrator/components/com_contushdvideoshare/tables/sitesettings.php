<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted Access');

class Tablesitesettings extends JTable {
  var $id = null;
  var $published = null;
  var $featurrow = null;
  var $featurcol = null;
  var $recentrow = null;
  var $recentcol = null;
  var $categoryrow = null;
  var $categorycol = null;
  var $popularrow = null;
  var $popularcol = null;
  var $searchrow = null;
  var $searchcol = null;
  var $relatedrow = null;
  var $relatedcol = null;
  var $memberpagerow = null;
  var $memberpagecol = null;
  var $homepopularvideo = null;
  var $homepopularvideorow = null;
  var $homepopularvideocol = null;
  var $homefeaturedvideo = null;
  var $homefeaturedvideorow = null;
  var $homefeaturedvideocol = null;
  var $homerecentvideo = null;
  var $homerecentvideorow = null;
  var $homerecentvideocol = null;
  var $myvideorow = null;
  var $myvideocol = null;
  var $sidepopularvideorow = null;
  var $sidepopularvideocol = null;
  var $sidefeaturedvideorow = null;
  var $sidefeaturedvideocol = null;
  var $siderelatedvideorow = null;
  var $siderelatedvideocol = null;
  var $siderecentvideorow = null;
  var $siderecentvideocol = null;
  var $allowupload =null;
  var $homepopularvideoorder =null;
  var $homefeaturedvideoorder =null;
  var $homerecentvideoorder =null;
  var $user_login =null;
  var $ratingscontrol =null;
  var $viewedconrtol =null;
  var $facebooklike =null;
  var $seo_option =null;


	function Tablesitesettings(&$db){

		parent::__construct('#__hdflv_site_settings', 'id', $db);

	}
}

?>
