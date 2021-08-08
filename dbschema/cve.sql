
--- cve table shema for getcve.py script

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

CREATE TABLE `cve` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cve_id` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `cvss` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `date_published` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `date_modified` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `cpe_list` text COLLATE utf8_bin,
  `asread` binary(1) DEFAULT NULL,
  `info` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
