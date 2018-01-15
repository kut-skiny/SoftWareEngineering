-- 既存のテーブルを全て削除
DROP TABLE IF EXISTS `administrators`;
DROP TABLE IF EXISTS `histories`;
DROP TABLE IF EXISTS `configurations`;
DROP TABLE IF EXISTS `contracts`;
DROP TABLE IF EXISTS `users`;
--

CREATE TABLE users (
  id char(8) NOT NULL,
  name varchar(64),
  password varchar(16),
  mail varchar(64) NOT NULL,
  phone_number int,
  address varchar(64),
  registered_at timestamp,
  deleted_at timestamp default 0,
  created_at timestamp NOT NULL,
  updated_at timestamp,
  PRIMARY KEY (id)
) CHARSET=utf8;

CREATE TABLE `contracts` (
  `id` char(8)
    NOT NULL,
  `user_id` char(8)
    NOT NULL,
  `partner` varchar(64)
    DEFAULT NULL,
  `ip_address` int unsigned
    DEFAULT NULL,
  `started_at` timestamp
    NOT NULL
    DEFAULT 0,
  `closed_at` timestamp
    NOT NULL
    DEFAULT 0,
  `created_at` timestamp NOT NULL
    NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp
    NOT NULL
    DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `configurations` (
  `id` char(8)
    NOT NULL,
  `contract_id` char(8),
  `morning_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `morning_time` time
    NOT NULL
    DEFAULT '08:00:00',
  `noon_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `noon_time` time
    NOT NULL
    DEFAULT '13:00:00',
  `evening_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `evening_time` time
    NOT NULL
    DEFAULT '19:00:00',
  `night_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `night_time` time
    NOT NULL
    DEFAULT '21:00:00',
  `mail` varchar(64)
    DEFAULT NULL,
  `mail_after_blank_time_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `blank_time_for_mail` time
    NOT NULL
    DEFAULT '72:00:00',
  `mail_once_a_day_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `line` varchar(64)
    DEFAULT NULL,
  `line_after_blank_time_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `blank_time_for_line` time
    NOT NULL
    DEFAULT '72:00:00',
  `line_once_a_day_enabled` enum('on', 'off')
    NOT NULL
    DEFAULT 'off',
  `created_at` timestamp
    NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp
    NOT NULL
    DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`contract_id`)
    REFERENCES `contracts` (`id`)
) ENGINE=InnoDB CHARSET=utf8;

create table histories (
  contract_id char(8) NOT NULL,
  acted_at timestamp NOT NULL,
  state enum('opend', 'no_response', 'go_out', 'return_home') NOT NULL,
  FOREIGN KEY (contract_id) REFERENCES contracts(id)
) CHARSET=utf8;

CREATE TABLE administrators (
  id char(8) NOT NULL,
  name varchar(64) NOT NULL,
  password varchar(64) NOT NULL,
  created_at timestamp NOT NULL,
  updated_at timestamp,
  PRIMARY KEY (id)
) CHARSET=utf8;
