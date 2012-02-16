-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 10, 2009 at 02:36 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

-- 
-- Database: `ja_comment`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `#__jacomment_configs`
-- 


CREATE TABLE IF NOT EXISTS `#__jacomment_configs` (
  `id` int(11) NOT NULL auto_increment,
  `group` varchar(100) COLLATE utf8_general_ci COLLATE utf8_general_ci default NULL,
  `data` text COLLATE utf8_general_ci,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci  AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `#__jacomment_configs`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `#__jacomment_email_templates`
-- 

CREATE TABLE IF NOT EXISTS `#__jacomment_email_templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) COLLATE utf8_general_ci default NULL,
  `title` varchar(525) COLLATE utf8_general_ci default NULL,
  `subject` varchar(525) COLLATE utf8_general_ci default NULL,
  `content` text,
  `email_from_address` varchar(255) COLLATE utf8_general_ci default NULL,
  `email_from_name` varchar(255) COLLATE utf8_general_ci default NULL,
  `published` tinyint(1) default '0',
  `group` int(11) default '0',
  `language` varchar(20) COLLATE utf8_general_ci default NULL,
  `system` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=36 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__jacomment_items`
-- 

CREATE TABLE IF NOT EXISTS `#__jacomment_items` (
  `id` int(10) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `contentid` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `name` varchar(200) COLLATE utf8_general_ci default NULL,
  `contenttitle` varchar(200) COLLATE utf8_general_ci NOT NULL default '',
  `comment` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `locked` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL default '',
  `website` varchar(100) COLLATE utf8_general_ci NOT NULL default '',
  `star` tinyint(3) unsigned NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `usertype` mediumtext NOT NULL,
  `option` varchar(50) NOT NULL default 'com_content',
  `voted` smallint(6) NOT NULL default '0',
  `report` smallint(6) NOT NULL default '0',
  `subscription_type` tinyint(4) NOT NULL default '0',
  `referer` varchar(255) COLLATE utf8_general_ci NOT NULL default '',
  `source` varchar(20) COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) default NULL,
  `date_active` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `option` (`option`),
  KEY `contentid` (`contentid`),
  KEY `published` (`published`)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `#__jacomment_items`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `#__jacomment_logs`
-- 

CREATE TABLE IF NOT EXISTS `#__jacomment_logs` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `itemid` int(11) default NULL,
  `votes` int(4) NOT NULL default '0',
  `reports` int(4) NOT NULL default '0',
  `time_expired` int(11) default NULL,
  `remote_addr` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=428 ;

-- 
-- Dumping data for table `#__jacomment_logs`
-- 