# Dump of permissions table
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source_type` varchar(255) NOT NULL,
  `source_id` int(11) unsigned NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `permission_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`),
  KEY `object_type_id` (`object_type`,`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
