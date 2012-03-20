CREATE TABLE IF NOT EXISTS `#__fpss_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` char(7) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`),
  KEY `ordering` (`ordering`),
  KEY `language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__fpss_slides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `catid` int(10) unsigned NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  `access` tinyint(1) unsigned NOT NULL,
  `ordering` int(11) NOT NULL,
  `featured` tinyint(1) unsigned NOT NULL,
  `featured_ordering` int(11) NOT NULL,
  `text` text NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `referenceType` varchar(255) NOT NULL,
  `referenceID` int(10) unsigned NOT NULL,
  `custom` varchar(255) NOT NULL,
  `video` tinytext NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `language` char(7) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`),
  KEY `published` (`published`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`),
  KEY `access` (`access`),
  KEY `ordering` (`ordering`),
  KEY `featured` (`featured`),
  KEY `featured_ordering` (`featured_ordering`),
  KEY `language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__fpss_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slideID` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slideID` (`slideID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
