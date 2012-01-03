<?php
/**
 *    @version [ Nightly Build ]
 *    @package hwdVideoShare
 *    @copyright (C) 2007 - 2009 Highwood Design
 *    @license Creative Commons Attribution-Non-Commercial-No Derivative Works 3.0 Unported Licence
 *    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $print_ulink, $print_glink, $smartyvs, $hwdvsTemplateOverride, $j15, $j16;
$c = hwd_vs_Config::get_instance();
$app = & JFactory::getApplication();
$doc = & JFactory::getDocument();

jimport( 'joomla.html.parameter' );
$plugin =& JPluginHelper::getPlugin('hwdvs-template', 'default');
$pluginParams = new JParameter( $plugin->params );
$hwdvsTemplateOverride['thumbWidth1'] = $pluginParams->def( 'thumbWidth1', '120' );
$hwdvsTemplateOverride['thumbWidth2'] = $pluginParams->def( 'thumbWidth2', '60' );
$hwdvsTemplateOverride['thumbWidth3'] = $pluginParams->def( 'thumbWidth3', '60' );
$hwdvsTemplateOverride['thumbWidth4'] = $pluginParams->def( 'thumbWidth4', '60' );
$hwdvsTemplateOverride['thumbWidth5'] = $pluginParams->def( 'thumbWidth5', '120' );
$hwdvsTemplateOverride['thumbWidth6'] = $pluginParams->def( 'thumbWidth6', '90' );
$hwdvsTemplateOverride['thumbWidth7'] = $pluginParams->def( 'thumbWidth7', '50' );
$hwdvsTemplateOverride['thumbWidth8'] = $pluginParams->def( 'thumbWidth8', '50' );
$hwdvsTemplateOverride['thumbWidth9'] = $pluginParams->def( 'thumbWidth9', '50' );
$hwdvsTemplateOverride['beingWatchNow'] = $pluginParams->def( 'beingWatchNow', '2' );
$hwdvsTemplateOverride['vpr'] = $pluginParams->def( 'vpr', '3' );
$hwdvsTemplateOverride['cpr'] = $pluginParams->def( 'cpr', '2' );
$hwdvsTemplateOverride['gpr'] = $pluginParams->def( 'gpr', '1' );
$hwdvsTemplateOverride['hideSubcats'] = $pluginParams->def( 'hideSubcats', '0' );
$hwdvsTemplateOverride['playerAlign'] = $pluginParams->def( 'playerAlign', 'L' );
$hwdvsTemplateOverride['loadCarousel'] = 1;
$hwdvsTemplateOverride['wrapText'] = $pluginParams->def( 'wrapText', '0' );

$hwdvsTemplateOverride['show_thumbnail'] 	= $pluginParams->def( 'show_thumbnail', '1' );
$hwdvsTemplateOverride['show_title'] 		= $pluginParams->def( 'show_title', '1' );
$hwdvsTemplateOverride['show_views'] 		= $pluginParams->def( 'show_views', '1' );
$hwdvsTemplateOverride['show_category'] 	= $pluginParams->def( 'show_category', '1' );
$hwdvsTemplateOverride['show_rating'] 		= $pluginParams->def( 'show_rating', '1' );
$hwdvsTemplateOverride['show_uploader'] 	= $pluginParams->def( 'show_uploader', '1' );
$hwdvsTemplateOverride['show_description'] 	= $pluginParams->def( 'show_description', '0' );
$hwdvsTemplateOverride['show_duration'] 	= $pluginParams->def( 'show_duration', '0' );
$hwdvsTemplateOverride['show_upload_date'] 	= $pluginParams->def( 'show_upload_date', '0' );
$hwdvsTemplateOverride['show_avatar'] 		= $pluginParams->def( 'show_avatar', '1' );
$hwdvsTemplateOverride['show_comments'] 	= $pluginParams->def( 'show_comments', '0' );
$hwdvsTemplateOverride['show_tags'] 		= $pluginParams->def( 'show_tags', '0' );
$hwdvsTemplateOverride['show_timesince'] 	= $pluginParams->def( 'show_timesince', '0' );

$smartyvs->assign("hwdvsTemplateOverride", $hwdvsTemplateOverride);

$nav_width = null;
if ($c->diable_nav_videos == "0") {$nav_width = $nav_width + 102;}
if ($c->diable_nav_catego == "0") {$nav_width = $nav_width + 102;}
if ($print_glink) {$nav_width = $nav_width + 102;}
if ($print_ulink) {$nav_width = $nav_width + 102;}

$template_folder = $app->getUserState( "com_hwdvideoshare.template_folder", '' );
$template_element = $app->getUserState( "com_hwdvideoshare.template_element", '' );
if (!empty($template_folder) && !empty($template_element))
{
	$c->hwdvids_template_path = $template_folder;
	$c->hwdvids_template_file = $template_element;
}
if (empty($c->hwdvids_template_file)) { $c->hwdvids_template_file = "default"; }
if ($j16)
{
	$templateDirectoryUrl = JURI::root( true ).'/plugins/hwdvs-template/'.$c->hwdvids_template_file.'/'.$c->hwdvids_template_file.'/';
}
else
{
	$templateDirectoryUrl = JURI::root( true ).'/plugins/hwdvs-template/'.$c->hwdvids_template_file.'/';
}
if($doc->getType() == 'html')
{
	$doc->addCustomTag('<link rel="stylesheet" href="'.$templateDirectoryUrl.'template.css" type="text/css" />');
	$doc->addCustomTag('<link rel="stylesheet" href="'.$templateDirectoryUrl.'css/rating.css" type="text/css" />');
}

$smartyvs->assign("vpr", $hwdvsTemplateOverride['vpr']);
$smartyvs->assign("gpr", $hwdvsTemplateOverride['gpr']);
$smartyvs->assign("cpr", $hwdvsTemplateOverride['cpr']);
$smartyvs->assign("hideSubcats", 1);

if ($hwdvsTemplateOverride['hideSubcats'] == "1") {
	$smartyvs->assign("hideSubcats", 1);
} else {
	$smartyvs->assign("hideSubcats", 0);
}

if ($c->show_vp_info == "0") {
	$smartyvs->assign("playerAlign", "N");
} else if ($hwdvsTemplateOverride['playerAlign'] == "C") {
	$smartyvs->assign("playerAlign", "C");
} else if ($hwdvsTemplateOverride['playerAlign'] == "R") {
	$smartyvs->assign("playerAlign", "R");
} else  {
	$smartyvs->assign("playerAlign", "L");
}

$psvboxwidth = intval(100/$hwdvsTemplateOverride['vpr'])-2;
$psgboxwidth = intval(100/$hwdvsTemplateOverride['gpr'])-2;
$pscboxwidth = intval(100/$hwdvsTemplateOverride['cpr'])-2;

$smartyvs->assign("searchinput_alt", "<input name=\"pattern\" id=\"menudo_search_field\" type=\"text\" onblur=\"if(this.value=='') this.value='"._HWDVIDS_SEARCHBAR."';\" onfocus=\"if(this.value=='"._HWDVIDS_SEARCHBAR."') this.value='';\" value=\""._HWDVIDS_SEARCHBAR."\" class=\"field\" autocomplete=\"off\" maxlength=\"50\" />");

$css = "#hwdvs_navcontainer
{
	width: ".$nav_width."px;
}

#hwdvs_navcontainer ul li, #hwdvs_navcontainer ul, #hwdvids ul.tabbernav, #hwdvids ul.tabbernav li, #hwdvids .box {
	list-style-image: url('".JURI::root( true )."/images/blank.png')!important;
	background-image: url('".JURI::root( true )."/images/blank.png')!important;
}

#hwdvs_navcontainer ul li
{
	background: url('".$templateDirectoryUrl."images/button_nav_off.png') no-repeat top center!important;
}

#hwdvs_navcontainer li#active
{
	background: url('".$templateDirectoryUrl."images/button_nav_on.png') no-repeat top center!important;
}

#hwdvs_navcontainer ul li:hover
{
	background: url('".$templateDirectoryUrl."images/button_nav_hover.png') no-repeat top center!important;
}

#hwdvids .box
{
	background: transparent url('".JURI::root( true )."/images/blank.png') no-repeat top center!important;
}

#hwdvids .videoBox {
	width: ".$psvboxwidth ."%;
	float:left;
}
#hwdvids .groupBox {
	width: ".$psgboxwidth ."%;
	float:left;
}
#hwdvids .categoryBox {
	width: ".$pscboxwidth ."%;
	float:left;
}

#hwdvids .menudo_image {
	background:transparent url('".$templateDirectoryUrl."images/search_bar.png') no-repeat scroll 0px 0px;
}";

require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'helpers'.DS.'draw.php');
hwdvsDrawFile::processDynamicCSS($css, true);

return;

function templateSetCategoryTab($tab='videos')
{
	global $smartyvs;
	if ($tab=='videos') {
		$smartyvs->assign('defaultTab', 'videos');
	} else {
		$smartyvs->assign('defaultTab', 'subcategories');
	}
}

?>