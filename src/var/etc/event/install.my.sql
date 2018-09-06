CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `registration_available` tinyint(3) unsigned DEFAULT NULL,
  `max_participants` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `event_ci_event` (
  `id` int(11) NOT NULL,
  `size_type` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `event_page_controller` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `event_participant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `event_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_participant_index_1` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `event_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `n2n_locale` varchar(12) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_t_index_1` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `event_t_content_items` (
  `event_t_id` int(10) unsigned NOT NULL,
  `content_item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`event_t_id`,`content_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;