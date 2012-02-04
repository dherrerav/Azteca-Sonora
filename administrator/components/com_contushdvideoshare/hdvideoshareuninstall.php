<?php
/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        hdvideoshareuninstall.php
 * @location    /components/com_contushdvideosahre/hdvideoshareuninstall.php
 * @package	Joomla 1.5
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Uninstallation file
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);
// Imports
jimport('joomla.installer.installer');
$db = &JFactory::getDBO();
$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_category` TO `#__hdflv_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_comments_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_comments` TO `#__hdflv_comments_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_player_settings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_player_settings` TO `#__hdflv_player_settings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_site_settings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_site_settings` TO `#__hdflv_site_settings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_upload_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_upload` TO `#__hdflv_upload_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_video_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_video_category` TO `#__hdflv_video_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_googlead_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_googlead` TO `#__hdflv_googlead_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_ads_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_ads` TO `#__hdflv_ads_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_user_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_user` TO `#__hdflv_user_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_channel_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_channel` TO `#__hdflv_channel_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_channelsettings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_channelsettings` TO `#__hdflv_channelsettings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_channellist_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_channellist` TO `#__hdflv_channellist_backup`");
$db->query();
?>
