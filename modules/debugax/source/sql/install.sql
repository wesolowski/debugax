CREATE TABLE IF NOT EXISTS `adodb_debugphp_logsql` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `sql0` varchar(250) COLLATE latin1_general_ci NULL,
  `sql1` text COLLATE latin1_general_ci NOT NULL,
  `params` text COLLATE latin1_general_ci NOT NULL,
  `tracer` text COLLATE latin1_general_ci NULL,
  `timer` decimal(16,6) NULL,
  `type` char(50) COLLATE latin1_general_ci NOT NULL,
  `ident` char(50) COLLATE latin1_general_ci NOT NULL,
  `check` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `ident` (`ident`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
