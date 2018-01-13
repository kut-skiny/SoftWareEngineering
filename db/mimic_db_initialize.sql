DELETE FROM `administrators`;
DELETE FROM `histories`;
DELETE FROM `configurations`;
DELETE FROM `contracts`;
DELETE FROM `users`;

INSERT INTO `users` VALUES (
  '10000001',
  '山田太郎',
  'pass',
  'example@mail.com',
  09012345678,
  '東京都東京市東京1-1',
  '',
  '',
  now(),
  ''
);

INSERT INTO `contracts` VALUES (
  '20000001', 
  '10000001',
  '山田花子',
  111222333444,
  '',
  '',
  now(),
  ''
);

INSERT INTO `configurations` VALUES (
  '30000001',
  '20000001',
  'on',
  '07:00:00',
  'on',
  '12:30:00',
  'on',
  '18:30:00',
  'off',
  '21:00:00',
  'example@mail.com',
  'on',
  '48:00:00',
  'on',
  NULL,
  'off',
  '48:00:00',
  'off',
  now(),
  0
);

INSERT INTO `histories` VALUES (
  '20000001',
  '2009-10-04 12:25:07',
  'opened'
), (
  '20000001',
  '2009-10-04 18:08:55',
  'opened'
), (
  '20000001',
  '2009-10-05 08:13:41',
  'go_out'
);

INSERT INTO `administrators` VALUES (
  'admin',
  '管理者',
  'pass',
  now(),
  0
);
