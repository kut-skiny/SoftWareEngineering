-- 既存のテーブルを全て削除
DROP TABLE IF EXISTS administrators;
DROP TABLE IF EXISTS histories;
DROP TABLE IF EXISTS configurations;
DROP TABLE IF EXISTS contracts;
DROP TABLE IF EXISTS users;
--

CREATE TABLE users (
  id char(8) NOT NULL,
  name varchar(64),
  password varchar(16),
  mail varchar(64) NOT NULL,
  phone_number int,
  address varchar(64),
  registered_at timestamp,
  deleted_at timestamp,
  created_at timestamp NOT NULL,
  updated_at timestamp,
  PRIMARY KEY (id)
) CHARSET=utf8;

CREATE TABLE contracts (
  id char(8) NOT NULL,
  user_id char(8) NOT NULL,
  partner varchar(64),
  ip_address int,
  started_at timestamp,
  closed_at timestamp,
  created_at timestamp NOT NULL,
  updated_at timestamp,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
) CHARSET=utf8;

CREATE TABLE configurations (
  id char(8) NOT NULL,
  contract_id char(8),
  morning_time time,
  noon_time time,
  evening_time time,
  night_time time,
  mail varchar(64),
  mail_after_blank_time enum('on', 'off'),
  blank_time_for_mail time,
  mail_once_a_day enum('on', 'off'),
  line varchar(64),
  line_after_blank_time enum('on', 'off'),
  blank_time_for_line time,
  line_once_a_day enum('on', 'off'),
  created_at timestamp NOT NULL,
  updated_at timestamp,
  PRIMARY KEY (id),
  FOREIGN KEY (contract_id) REFERENCES contracts(id)
) CHARSET=utf8;

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

