CREATE TABLE IF NOT EXISTS `monitoring_tool_records` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_by` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_year` varchar(30) NOT NULL,
  `payload` mediumtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
