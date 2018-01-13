-- 既存のテーブルを全て削除
DROP TABLE IF EXISTS `administrators`;
DROP TABLE IF EXISTS `histories`;
DROP TABLE IF EXISTS `configurations`;
DROP TABLE IF EXISTS `contracts`;
DROP TABLE IF EXISTS `users`;
--

CREATE TABLE `users` (
  `id` char(8)
    NOT NULL
    PRIMARY KEY,
  `name` varchar(64)
    DEFAULT NULL,
  `password` varchar(16)
    NOT NULL
    DEFAULT 'pass',
  `mail` varchar(64)
    NOT NULL
    DEFAULT 'example@mail.com',
  `phone_number` int
    DEFAULT NULL,
  `address` varchar(64)
    DEFAULT NULL,
  `registered_at` timestamp
    NOT NULL
    DEFAULT 0,
  `deleted_at` timestamp
    NOT NULL
    DEFAULT 0,
  `created_at` timestamp
    NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp
    NOT NULL
    DEFAULT 0
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `contracts` (
  `id` char(8)
    NOT NULL
    PRIMARY KEY,
  `user_id` char(8)
    NOT NULL
    REFERENCES users(id),
  `partner` varchar(64)
    DEFAULT NULL,
  `ip_address` int
    DEFAULT 0,
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
    DEFAULT 0
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `configurations` (
  `id` char(8)
    NOT NULL
    PRIMARY KEY,
  `contract_id` char(8)
    REFERENCES contracts(id),
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
    DEFAULT 0
) ENGINE=InnoDB CHARSET=utf8;

create table `histories` (
  `contract_id` char(8)
    NOT NULL
    REFERENCES contracts(id),
  `acted_at` timestamp
    NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  `state` enum('opened', 'no_response', 'go_out', 'return_home')
    NOT NULL
    DEFAULT 'opened'
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `administrators` (
  `id` char(8)
    NOT NULL
    PRIMARY KEY,
  `name` varchar(64)
    DEFAULT NULL,
  `password` varchar(64)
    NOT NULL
    DEFAULT 'pass',
  `created_at` timestamp
    NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp
    NOT NULL
    DEFAULT 0
) ENGINE=InnoDB CHARSET=utf8;
