#
# Table structure for table `groups`
#

CREATE TABLE `groups` (
  `groupname` varchar(32) NOT NULL default '',
  `gid` smallint(6) unsigned NOT NULL auto_increment,
  `members` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gid`),
  UNIQUE KEY `groupname` (`groupname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='ProFTPd group table';

#
# Table structure for table `users`
#

CREATE TABLE `users` (
  `id` smallint(2) unsigned NOT NULL auto_increment,
  `userid` varchar(32) NOT NULL default '',
  `uid` smallint(6) unsigned default NULL,
  `gid` smallint(6) unsigned default NULL,
  `passwd` varchar(265) NOT NULL default '',
  `homedir` varchar(255) NOT NULL default '',
  `comment` varchar(255) NOT NULL default '',
  `disabled` smallint(2) unsigned NOT NULL default '0',
  `shell` varchar(32) NOT NULL default '/bin/false',
  `email` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(5) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `bytes_in_used` bigint(20) unsigned NOT NULL default '0',
  `bytes_out_used` bigint(20) unsigned NOT NULL default '0',
  `files_in_used` bigint(20) unsigned NOT NULL default '0',
  `files_out_used` bigint(20) unsigned NOT NULL default '0',
  `login_count` int(11) unsigned NOT NULL default '0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='ProFTPd user table';

CREATE TABLE `sftp_host_keys` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `host` VARCHAR(256) NOT NULL DEFAULT '',
    `sftp_key` VARCHAR(8192) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `host_key` (`host`, `sftp_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='ProFTPd SFTP host public keys table';

CREATE TABLE `sftp_keys` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` VARCHAR(256) NOT NULL DEFAULT '',
    `sftp_key` VARCHAR(8192) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_key` (`user`, `sftp_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='ProFTPd SFTP public keys table';

CREATE TABLE `settings` (
    `id` TINYINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `value` TEXT NOT NULL,
    `defval` VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_key` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='ProFTPd settings table';
