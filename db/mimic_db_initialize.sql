DELETE FROM administrators;
DELETE FROM histories;
DELETE FROM configurations;
DELETE FROM contracts;
DELETE FROM users;

INSERT INTO users VALUES (
  '10000001',
  '山田太郎',
  'pass',
  'example@mail.com',
  09012345678,
  '東京都東京市東京1-1',
  NULL,
  NULL,
  now(),
  NULL
);

INSERT INTO contracts VALUES (
  '20000001',
  '10000001',
  '山田花子',
  111222333444,
  NULL,
  NULL,
  now(),
  NULL
);

INSERT INTO configurations VALUES (
  '30000001',
  '20000001',
  '07:00:00',
  '12:30:00',
  '18:30:00',
  '21:00:00',
  'example@mail.com',
  'on',
  '72:00:00',
  'on',
  'lineid00',
  'off',
  NULL,
  'off',
  now(),
  NULL
);

INSERT INTO histories VALUES (
  '20000001',
  '2009-10-04 12:25:07',
  'opened'
);

INSERT INTO histories VALUES (
  '20000001',
  '2009-10-04 18:08:55',
  'opened'
);

INSERT INTO histories VALUES (
  '20000001',
  '2009-10-05 08:13:41',
  'opened'
);

INSERT INTO administrators VALUES (
  'admin',
  '管理者',
  'pass',
  now(),
  NULL
);
