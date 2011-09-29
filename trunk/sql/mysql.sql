CREATE TABLE `todo_list` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `note` text,
  `priority` tinyint(4) NOT NULL default '0',
  `complete` tinyint(3) unsigned NOT NULL default '0',
  `published` datetime NOT NULL,
  `weight` int(11) NOT NULL COMMENT 'order weight',
  `percent` tinyint(3) unsigned default NULL COMMENT 'percent of completition',
  PRIMARY KEY  (`id`),
  KEY `weight` (`weight`),
  KEY `complete` (`complete`)
) TYPE=MyISAM COMMENT='todo' ;
