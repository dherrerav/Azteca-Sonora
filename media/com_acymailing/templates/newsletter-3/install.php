<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
$name = 'Rounders and corners';
$description = '<img src="media/com_acymailing/templates/newsletter-3/newsletter-3.png" />';
$body = JFile::read(dirname(__FILE__).DS.'index.html');
$styles['tag_h1'] = 'margin-bottom:0;margin-top:0;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:26px;color:#d47e7e;vertical-align:top;';
$styles['acymailing_title'] = $styles['tag_h2'] = 'color:#8a8a8a !important;border-bottom:6px solid #d3d09f;font-size:16px;';
$styles['tag_h3'] = 'color:#8a8a8a !important;font-weight:normal;font-size:100%;margin:0;';
$styles['acymailing_readmore'] = 'font-size: 10px; color: #999999;';
$styles['color_bg'] = '#dfe6e8';
$styles['acymailing_content'] = 'text-align:justify;';
$stylesheet = 'div,table{font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}';