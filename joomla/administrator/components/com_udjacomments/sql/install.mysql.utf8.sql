
CREATE TABLE IF NOT EXISTS `#__udjacomments` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(250) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `content` text NOT NULL,
  `parent_id` int(16) NOT NULL DEFAULT '0',
  `comment_url` text,
  `is_published` int(1) DEFAULT NULL,
  `is_spam` int(1) DEFAULT NULL,
  `receive_notifications` int(1) DEFAULT NULL,
  `receive_emailers` int(1) DEFAULT NULL,
  `time_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;