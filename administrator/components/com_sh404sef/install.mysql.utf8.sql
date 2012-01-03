CREATE TABLE IF NOT EXISTS `#__sh404sef_urls` (
        `id` int(11) NOT
        NULL auto_increment,
        `cpt` int(11) NOT NULL default '0',
        `rank`
        int(11) NOT NULL default '0',
        `oldurl` varchar(255) NOT NULL default
        '',
        `newurl` varchar(255) NOT NULL default '',
        `dateadd` date NOT NULL
        default '0000-00-00',
        PRIMARY KEY (`id`),
        KEY `newurl` (`newurl`),
        KEY
        `rank` (`rank`),
        KEY `oldurl` (`oldurl`)
        ) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__sh404sef_metas` (
        `id` int(11)
        NOT NULL auto_increment,
        `newurl` varchar(255) NOT NULL default '',
        `metadesc` varchar(255) default '',
        `metakey` varchar(255) default
        '',
        `metatitle` varchar(255) default '',
        `metalang` varchar(30)
        default '',
        `metarobots` varchar(30) default '',
        PRIMARY KEY (`id`),
        KEY `newurl` (`newurl`)
        ) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__sh404sef_aliases` (
        `id` int(11)
        NOT NULL auto_increment,
        `newurl` varchar(255) NOT NULL default '',
        `alias` varchar(255) NOT NULL default '',
        `type` tinyint(3) NOT NULL
        DEFAULT '0',
        `hits` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `newurl`
        (`newurl`),
        KEY `alias` (`alias`),
        KEY `type` (`type`)
        ) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__sh404sef_pageids` (
        `id` int(11) NOT NULL auto_increment,
        `newurl` varchar(255) NOT NULL default '',
        `pageid` varchar(255) NOT NULL default '',
        `type` tinyint(3) NOT NULL DEFAULT '0',
        `hits` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `newurl` (`newurl`),
        KEY `alias` (`pageid`),
        KEY `type` (`type`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        CREATE TABLE IF NOT EXISTS `#__sefexts` (
        `id` int(11) NOT NULL auto_increment,
        `file` varchar(100) NOT NULL,
        `filters` text,
        `params` text,
        `title` varchar(255),
        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;
