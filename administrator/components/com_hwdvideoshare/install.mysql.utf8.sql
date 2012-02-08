CREATE TABLE IF NOT EXISTS `#__hwdvidscategories` (
  `id` int(50) NOT NULL auto_increment,
  `parent` int(50) NOT NULL default '0',
  `category_name` varchar(250) default NULL,
  `category_description` text,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `access_b_v` tinyint(1) NOT NULL default '0',
  `access_u_r` varchar(7) NOT NULL default 'RECURSE',
  `access_v_r` varchar(7) NOT NULL default 'RECURSE',
  `access_u` int(11) NOT NULL default '-2',
  `access_lev_u` varchar(250) NOT NULL default '0,1',
  `access_v` int(11) NOT NULL default '-2',
  `access_lev_v` varchar(250) NOT NULL default '0,1',
  `thumbnail` text NOT NULL default '',
  `num_vids` int(50) NOT NULL default '0',
  `num_subcats` int(50) NOT NULL default '0',
  `order_by` varchar(15) NOT NULL default '0',
  `ordering` int(50) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=12 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsfavorites` (
  `id` int(50) NOT NULL auto_increment,
  `userid` int(50) default NULL,
  `videoid` int(50) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsflagged_videos` (
  `id` int(50) NOT NULL auto_increment,
  `userid` int(50) default NULL,
  `videoid` int(50) default NULL,
  `status` varchar(250) NOT NULL default 'Unread',
  `ignore` tinyint(1) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsflagged_groups` (
  `id` int(50) NOT NULL auto_increment,
  `userid` int(50) default NULL,
  `groupid` int(50) default NULL,
  `status` varchar(250) NOT NULL default 'Unread',
  `ignore` tinyint(1) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsgroup_membership` (
  `id` int(50) NOT NULL auto_increment,
  `memberid` int(50) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `groupid` int(50) default NULL,
  `approved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsgroups` (
  `id` int(50) NOT NULL auto_increment,
  `group_name` text,
  `public_private` varchar(250) NOT NULL default 'public',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `allow_comments` tinyint(1) NOT NULL default '0',
  `require_approval` tinyint(1) NOT NULL default '0',
  `group_description` text,
  `featured` tinyint(1) NOT NULL default '0',
  `adminid` int(50) default NULL,
  `thumbnail` text NOT NULL default '',
  `total_members` int(50) default '0',
  `total_videos` int(50) default '0',
  `ordering` int(50) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT (`group_name`,`group_description`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsplaylists` (
  `id` int(50) NOT NULL auto_increment,
  `playlist_name` text,
  `playlist_description` text,
  `playlist_data` text,
  `public_private` varchar(250) NOT NULL default 'public',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `allow_comments` tinyint(1) NOT NULL default '0',
  `user_id` int(50) default NULL,
  `thumbnail` text NOT NULL default '',
  `total_videos` int(50) default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `featured` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT (`playlist_name`,`playlist_description`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidschannels` (
  `id` int(50) NOT NULL auto_increment,
  `channel_name` text,
  `channel_description` text,
  `channel_thumbnail` text NOT NULL default '',
  `public_private` varchar(250) NOT NULL default 'public',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` int(50) default NULL,
  `views` int(50) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `featured` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT (`channel_name`,`channel_description`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsgroup_videos` (
  `id` int(50) NOT NULL auto_increment,
  `videoid` int(50) default NULL,
  `groupid` int(50) default NULL,
  `memberid` int(50) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsrating` (
  `id` int(50) NOT NULL auto_increment,
  `userid` int(50) default NULL,
  `videoid` int(50) default NULL,
  `ip` varchar(15) NOT NULL default '192.168.100.1',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsvideos` (
  `id` int(50) NOT NULL auto_increment,
  `video_type` varchar(250) default NULL,
  `video_id` text,
  `title` text,
  `description` text,
  `tags` text,
  `category_id` int(50) default NULL,
  `date_uploaded` datetime NOT NULL default '0000-00-00 00:00:00',
  `video_length` varchar(250) default NULL,
  `allow_comments` tinyint(1) NOT NULL default '0',
  `allow_embedding` tinyint(1) NOT NULL default '0',
  `allow_ratings` tinyint(1) NOT NULL default '0',
  `rating_number_votes` int(50) default 0,
  `rating_total_points` int(50) default 0,
  `updated_rating` float(4,2) default 0,
  `public_private` varchar(250) default NULL,
  `thumb_snap` varchar(7) default '0:00:00',
  `thumbnail` text NOT NULL default '',
  `approved` varchar(250) default NULL,
  `number_of_views` int(50) default 0,
  `number_of_comments` int(50) default 0,
  `age_check` int(50) default -1,
  `user_id` int(50) default NULL,
  `password` varchar(100) NOT NULL default '',
  `featured` tinyint(1) NOT NULL default '0',
  `ordering` int(50) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_user_id` (`user_id`),
  FULLTEXT (`title`,`tags`,`description`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsgs` (
  `id` int(50) NOT NULL auto_increment,
  `setting` varchar(250) default NULL,
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsss` (
  `id` int(50) NOT NULL auto_increment,
  `setting` varchar(250) default NULL,
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidslogs_views` (
  `id` int(50) NOT NULL auto_increment,
  `videoid` int(50) NOT NULL default '0',
  `userid` int(50) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_videoid` (`videoid`),
  KEY `idx_date` (`date`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidslogs_votes` (
  `id` int(50) NOT NULL auto_increment,
  `videoid` int(50) NOT NULL default '0',
  `userid` int(50) NOT NULL default '0',
  `vote` int(50) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_videoid` (`videoid`),
  KEY `idx_date` (`date`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidslogs_favours` (
  `id` int(50) NOT NULL auto_increment,
  `videoid` int(50) NOT NULL default '0',
  `userid` int(50) NOT NULL default '0',
  `favour` tinyint( 1 ) NOT NULL default '0', 
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_videoid` (`videoid`),
  KEY `idx_date` (`date`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidslogs_archive` (
  `id` int(50) NOT NULL auto_increment,
  `videoid` varchar(250) default NULL,
  `views` int(50) NOT NULL default '0',
  `number_of_votes` int(50) NOT NULL default '0',
  `sum_of_votes` int(50) NOT NULL default '0',
  `rating` int(50) NOT NULL default '0',
  `favours` int(50) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsantileech` (
  `index` int(8) NOT NULL auto_increment,
  `expiration` varchar(32) NOT NULL default '',
  `count` int(3) NOT NULL default '0',
  PRIMARY KEY  (`index`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidssubs` (
  `id` int(50) NOT NULL auto_increment,
  `userid` int(50) NOT NULL default '0',
  `memberid` int(50) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hwdvidsvideo_category` (
  `videoid` int(50) NOT NULL default '0',
  `categoryid` int(50) NOT NULL default '0',
  KEY `idx_videoid` (`videoid`),
  KEY `idx_categoryid` (`categoryid`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci` AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `#__hwdvidsss` (`id`, `setting`, `value`) 
VALUES (1, 'ffmpegpath', '/usr/local/bin/ffmpeg'),
(2, 'flvtool2path', '/usr/bin/flvtool2'),
(3, 'mencoderpath', '/usr/local/bin/mencoder'),
(4, 'phppath', '/usr/bin/php'),
(5, 'wgetpath', '/usr/bin/wget'),
(6, 'qtfaststart', '/usr/local/bin/qt-faststart');

INSERT IGNORE INTO `#__hwdvidsgs` (`id`, `setting`, `value`) 
VALUES (1, 'vpp', '5'),
(2, 'fpfeaturedvids', '3'),
(3, 'gpp', '5'),
(4, 'fpfeaturedgroups', '3'),
(5, 'aav', '1'),
(6, 'aag', '1'),
(7, 'aac', '1'),
(8, 'hwdvids_language_path', 'hwdvs-language'),
(9, 'hwdvids_language_file', 'english'),
(10, 'hwdvids_template_path', 'hwdvs-template'),
(11, 'hwdvids_template_file', 'default'),
(12, 'diable_nav_videos', '0'),
(13, 'diable_nav_catego', '0'),
(14, 'diable_nav_groups', '0'),
(15, 'diable_nav_upload', '0'),
(16, 'radiusrc', '0'),
(17, 'logconvert', '0'),
(18, 'debugconvert', '1'),
(19, 'deleteoriginal', '1'),
(20, 'mailvideonotification', '0'),
(21, 'mailgroupnotification', '0'),
(22, 'mailnotifyaddress', ''),
(23, 'cbint', '0'),
(24, 'disablelocupld', '0'),
(25, 'flvplay_width', '450'),
(26, 'flvplay_height', '400'),
(27, 'disablecaptcha', '1'),
(28, 'aa3v', '1'),
(29, 'showcredit', '1'),
(30, 'allowvidedit', '1'),
(31, 'allowviddel', '1'),
(32, 'locupldmeth', '0'),
(33, 'requiredins', '1'),
(34, 'ft_mpg', 'on'),
(35, 'ft_mpeg', 'on'),
(36, 'ft_avi', 'on'),
(37, 'ft_divx', 'on'),
(38, 'ft_mp4', 'on'),
(39, 'ft_flv', 'on'),
(40, 'ft_wmv', 'on'),
(41, 'ft_rm', 'on'),
(42, 'ft_mov', 'on'),
(43, 'ft_moov', 'on'),
(44, 'ft_asf', 'on'),
(45, 'ft_swf', 'on'),
(46, 'ft_vob', 'on'),
(47, 'maxupld', '10'),
(48, 'flvplayer', 'osflv'),
(49, 'flvalign', '0'),
(50, 'infoalign', '1'),
(51, 'usershare1', '1'),
(52, 'shareoption1', '1'),
(53, 'usershare2', '1'),
(54, 'shareoption2', '1'),
(55, 'usershare3', '1'),
(56, 'shareoption3', '1'),
(57, 'usershare4', '1'),
(58, 'shareoption4', '1'),
(59, 'cbavatar', '1'),
(60, 'avatarwidth', '61'),
(61, 'gtree_core', '-2'),
(62, 'gtree_core_child', 'RECURSE'),
(63, 'gtree_upld', '-1'),
(64, 'gtree_upld_child', 'RECURSE'),
(65, 'gtree_grup', '-2'),
(66, 'gtree_grup_child', 'RECURSE'),
(67, 'thumbwidth', '120'),
(68, 'reconvertflv', '0'),
(69, 'abortthumbfail', '1'),
(70, 'diable_nav_search', '0'),
(71, 'diable_nav_user', '0'),
(72, 'trunvdesc', '70'),
(73, 'truncdesc', '200'),
(74, 'trungdesc', '70'),
(75, 'truntitle', '25'),
(76, 'sb_digg', 'on'),
(77, 'sb_reddit', 'on'),
(78, 'sb_delicious', 'on'),
(79, 'sb_google', 'on'),
(80, 'sb_live', 'on'),
(81, 'sb_facebook', 'on'),
(82, 'sb_slashdot', 'on'),
(83, 'sb_netscape', 'on'),
(84, 'sb_technorati', 'on'),
(85, 'sb_stumbleupon', 'on'),
(86, 'sb_spurl', 'on'),
(87, 'sb_wists', 'on'),
(88, 'sb_simpy', 'on'),
(89, 'sb_newsvine', 'on'),
(90, 'sb_blinklist', 'on'),
(91, 'sb_furl', 'on'),
(92, 'sb_fark', 'on'),
(93, 'sb_blogmarks', 'on'),
(94, 'sb_yahoo', 'on'),
(95, 'sb_smarking', 'on'),
(96, 'sb_netvouz', 'on'),
(97, 'sb_shadows', 'on'),
(98, 'sb_rawsugar', 'on'),
(99, 'sb_magnolia', 'on'),
(100, 'sb_plugim', 'on'),
(101, 'sb_squidoo', 'on'),
(102, 'sb_blogmemes', 'on'),
(103, 'sb_feedmelinks', 'on'),
(104, 'sb_blinkbits', 'on'),
(105, 'sb_tailrank', 'on'),
(106, 'sb_linkagogo', 'on'),
(107, 'showrating', '1'),
(108, 'showviews', '1'),
(109, 'showduration', '0'),
(110, 'showuplder', '1'),
(111, 'autoconvert', '1'),
(112, 'commssys', '0'),
(113, 'gjint', ''),
(114, 'uploadcriteria', '1'),
(115, 'ad1show', '0'),
(116, 'ad1_ad_client', ''),
(117, 'ad1_ad_channel', ''),
(118, 'ad1_ad_type', 'text_image'),
(119, 'ad1_ad_uifeatures', '6'),
(120, 'ad1_ad_format', '125x125_as'),
(121, 'ad1_color_border1', 'D5D5D5'),
(122, 'ad1_color_bg1', 'FFFFFF'),
(123, 'ad1_color_link1', '0033FF'),
(124, 'ad1_color_text1', '333333'),
(125, 'ad1_color_url1', '008000'),
(126, 'ad1custom', ''),
(127, 'customencode', ''),
(128, 'encoder', 'MENCODER'),
(129, 'flvplay_autostart', '1'),
(130, 'flvplay_overstretch', '1'),
(131, 'flvplay_logo', '/components/com_hwdvideoshare/images/logo.png'),
(132, 'flvplay_volume', '70'),
(133, 'flvplay_fg', 'FFFFFF'),
(134, 'flvplay_bg', '2f3030'),
(135, 'fporder', 'recent'),
(136, 'pathubr_upload', ''),
(137, 'cnvt_vbitrate', '600'),
(138, 'cnvt_abitrate', '64'),
(139, 'cnvt_asr', '22050'),
(140, 'cnvt_fsize', '320x240'),
(141, 'usegetheaders', '0'),
(142, 'ajaxratemeth', '2'),
(143, 'ajaxfavmeth', '1'),
(144, 'ajaxrepmeth', '1'),
(145, 'ajaxa2gmeth', '1'),
(146, 'cbitemid', '0'),
(147, 'applywmvfix', '1'),
(148, 'tpfunc', '1'),
(149, 'diable_nav_user1', '0'),
(150, 'diable_nav_user2', '0'),
(151, 'diable_nav_user3', '0'),
(152, 'diable_nav_user4', '0'),
(153, 'diable_nav_user5', '0'),
(154, 'showrate', '1'),
(155, 'showatfb', '1'),
(156, 'showrpmb', '1'),
(157, 'showcoms', '1'),
(158, 'showvurl', '1'),
(159, 'showvebc', '1'),
(160, 'showdesc', '1'),
(161, 'showtags', '1'),
(162, 'showscbm', '1'),
(163, 'showuldr', '1'),
(164, 'showa2gb', '1'),
(165, 'gtree_plyr_child', 'RECURSE'),
(166, 'gtree_plyr', '-2'),
(167, 'initialise_now', '1'),
(168, 'hwdvids_videoplayer_path', '../../../components/com_hwdvideoshare/core/videoplayer/jwflv'),
(169, 'hwdvids_videoplayer_file', 'jwflv'),
(170, 'accesslevel_main', '0,1'),
(171, 'accesslevel_upld', '0,1'),
(172, 'accesslevel_plyr', '0,1'),
(173, 'accesslevel_grps', '0,1'),
(174, 'access_method', '0'),
(175, 'xmlcache_today', '3600'),
(176, 'xmlcache_thisweek', '86400'),
(177, 'xmlcache_thismonth', '604800'),
(178, 'xmlcache_alltime', '604800'),
(179, 'xmlcustom01', ''),
(180, 'xmlcustom02', ''),
(181, 'xmlcustom03', ''),
(182, 'xmlcustom04', ''),
(183, 'xmlcustom05', ''),
(184, 'mailreportnotification', '0'),
(185, 'sharedlibrarypath', ''),
(186, 'standaloneswf', '1'),
(187, 'playlocal', '0'),
(188, 'frontpage_watched', '1'),
(189, 'frontpage_viewed', '0'),
(190, 'frontpage_favoured', '0'),
(191, 'frontpage_popular', '0'),
(192, 'jaclint', '0'),
(193, 'loadmootools', 'off'),
(194, 'loadprototype', 'off'),
(195, 'loadscriptaculous', 'off'),
(196, 'loadswfobject', 'off'),
(197, 'tpwidth', '427'),
(198, 'embedreturnlink', '0'),
(199, 'nicepriority', '10'),
(200, 'showdlor', '0'),
(201, 'showvuor', '1'),
(202, 'mbtu_no', '4'),
(203, 'showprnx', '0'),
(204, 'showdlfl', '1'),
(205, 'maintenance_bkgd', 'wget'),
(206, 'playlist_bkgd', 'wget'),
(207, 'showrevi', '1'),
(208, 'revi_no', '4'),
(209, 'fvid_w', '0'),
(210, 'fvid_h', '350'),
(211, 'var_c', '1'),
(212, 'var_fb', '0.75'),
(213, 'tar_fb', '0.75'),
(214, 'udt', '1'),
(215, 'oformats', '3gp,mkv'),
(216, 'bwn_no', '3'),
(217, 'cordering', 'order'),
(218, 'cvordering', 'date'),
(219, 'custordering', '0'),
(220, 'userdisplay', '1'),
(221, 'gtree_dnld', '-2'),
(222, 'gtree_dnld_child', 'RECURSE'),
(223, 'gtree_ultp', '-2'),
(224, 'gtree_ultp_child', 'RECURSE'),
(225, 'bviic', '1'),
(226, 'accesslevel_dnld', '0,1'),
(227, 'accesslevel_ultp', '0,1'),
(228, 'ieoa_fix', '0'),
(229, 'swfobject', '1'),
(230, 'allowgr', '0'),
(231, 'con_thumb_n', '120'),
(232, 'con_thumb_l', '500'),
(233, 'con_gen_hd', '0'),
(234, 'showmftc', '0'),
(235, 'mftc_no', '4'),
(236, 'feat_show', '1'),
(237, 'feat_as', 'global'),
(238, 'feat_rand', '0'),
(239, 'scroll_no', '3'),
(240, 'scroll_as', '0.25'),
(241, 'scroll_au', '3000'),
(242, 'scroll_wr', 'true'),
(243, 'cat_he', 0),
(244, 'thumb_ts', 0),
(245, 'gtree_mdrt', '24'),
(246, 'gtree_mdrt_child', 'RECURSE'),
(247, 'show_vp_info', 1),
(248, 'show_tooltip', 1),
(249, 'usehq', 1),
(250, 'uselibx264', 1),
(251, 'countcvids', 0),
(252, 'search_method', 1),
(253, 'search_title', 'on'),
(254, 'search_descr', 'on'),
(255, 'search_keywo', 'on'),
(256, 'vsdirectory', ''),
(257, 'use_protection', '1'),
(258, 'protection_level', '3'),
(259, 'cnvt_keyf', '6'),
(260, 'age_check', '0'),
(261, 'gtree_edtr', '24'),
(262, 'gtree_edtr_child', 'RECURSE'),
(263, 'disable_nav_playlist', '0'),
(264, 'disable_nav_channel', '0'),
(265, 'storagetype', '0'),
(266, 'cnvt_fsize_hd', '640x360'),
(267, 'cnvt_hd_preset', '0'),
(268, 'keep_ar', '0'),
(269, 'warpAccountKey', ''),
(270, 'warpSecretKey', ''),
(271, 'cpp', '50'),
(272, 'ipod320', '0'),
(273, 'ipod640', '0'),
(274, 'multiple_cats', '0');



