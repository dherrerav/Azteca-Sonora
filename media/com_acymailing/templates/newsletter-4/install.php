<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
$name = 'Notification template';
$description = '<img src="media/com_acymailing/templates/newsletter-4/newsletter-4.png" />';
$body = JFile::read(dirname(__FILE__).DS.'index.html');
$styles['tag_h1'] = 'color:#393939 !important; font-size:14px; font-weight:normal; font-weight:bold;';
$styles['tag_h2'] = 'color: #309fb3 !important; font-size: 14px; font-weight: normal; text-align:left; margin:0px; padding:0px;';
$styles['tag_h3'] = 'color: #393939 !important; font-size: 18px; font-weight: bold; text-align:left; margin:0px; padding-bottom:5px; border-bottom:1px solid #bdbdbd;';
$styles['tag_h4'] = 'color: #309fb3 !important; font-size: 14px; font-weight: bold; text-align:left; margin:0px; padding:0px;';
$styles['tag_a'] = 'color:#4d4d4d; text-decoration:none; font-style:italic; cursor:pointer;';
$styles['acymailing_readmore'] = 'font-size: 10px; color: #999999;';
$styles['acymailing_online'] = 'color:#a3a3a3; text-decoration:none; font-size:11px;';
$styles['color_bg'] = '#ffffff';
$styles['acymailing_content'] = 'text-align:justify;';
$stylesheet = 'div,table{font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;} div.info{text:align:center;padding:10px;}';