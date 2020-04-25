CREATE TABLE `users` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


CREATE TABLE `drinks` (
  `idDrink` int(11) NOT NULL AUTO_INCREMENT,
  `dateDrink` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mlDrink` int(11) NOT NULL,
  PRIMARY KEY (`idDrink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

ALTER TABLE bvzfdagnfqepipz70gyw.drinks ADD userID INT(11) NOT NULL;
ALTER TABLE bvzfdagnfqepipz70gyw.drinks CHANGE userID userID INT(11) NOT NULL AFTER idDrink;


INSERT INTO bvzfdagnfqepipz70gyw.users
(iduser, email, password, name)
VALUES(1, 'rubensnsg@gmail.com.br', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Rubens Nelson Santos Gonçalves'),
(2, 'thomas@reuters.com', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Thomas Reuters'),
(3, 'rubensnsg@hotmail.com.br', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Rubens Nelson S. Gonçalves'),
(5, 'steve@jobs.com', '808945ebe4ded0747207885dbcce498290d29dd7dd5fce2d29d74c24dabf52df', 'Steve Jobs'),
(6, 'michael@jordan.com', '77edcc9998a65fafcd6ecd000318a147c0c85087ebf086f56f3792438d59eed4', 'Michael Jordan'),
(7, 'luigi@mario.com', '39fc8574143f3b9ead326a82d8e0e584a8ffe9451f6e54eee15175ddb6f70dc8', 'Luigi Mario'),
(8, 'cristovao@nav.com', '62582ec0629aaca1380b31d9af6180a3396b9934eddc76fb557dcc588c433f22', 'Cristóvão Colombo');


INSERT INTO bvzfdagnfqepipz70gyw.drinks
(idDrink, userID, dateDrink, mlDrink)
VALUES(1, 2, '2020-03-15 19:42:08', 200),
(3, 2, '2020-03-15 19:42:57', 100),
(4, 5, '2020-03-16 01:42:58', 150),
(5, 3, '2020-03-15 19:42:58', 1320),
(6, 2, '2020-03-15 20:07:33', 300),
(7, 8, '2020-04-30 17:53:16', 680),
(8, 2, '2020-03-15 20:15:28', 130),
(9, 3, '2020-03-16 00:17:14', 420),
(10, 2, '2020-03-15 20:43:38', 200),
(12, 3, '2020-03-16 02:44:55', 80),
(13, 8, '2020-03-15 21:06:01', 820),
(14, 2, '2020-04-25 13:13:08', 450),
(15, 5, '2020-04-25 13:26:25', 450),
(16, 5, '2020-04-25 13:26:36', 180),
(17, 7, '2020-04-25 13:39:57', 180),
(18, 8, '2020-04-25 13:40:06', 530),
(19, 6, '2020-04-25 13:41:10', 250),
(20, 2, '2020-04-20 12:37:14', 1180),
(21, 3, '2020-04-20 10:28:22', 240),
(22, 5, '2020-04-20 17:47:25', 740),
(23, 6, '2020-04-20 20:45:21', 280),
(24, 7, '2020-04-20 21:23:35', 230),
(25, 8, '2020-04-20 15:54:48', 1020),
(26, 2, '2020-04-21 18:19:26', 740),
(27, 3, '2020-04-21 19:31:28', 1200),
(28, 5, '2020-04-21 16:24:40', 260),
(29, 6, '2020-04-21 18:18:30', 790),
(30, 7, '2020-04-21 20:14:18', 890),
(31, 8, '2020-04-21 22:38:13', 160),
(32, 2, '2020-04-22 15:47:48', 200),
(33, 3, '2020-04-22 21:18:22', 1160),
(34, 5, '2020-04-22 15:17:24', 860),
(35, 6, '2020-04-22 17:27:39', 650),
(36, 7, '2020-04-22 11:40:15', 590),
(37, 8, '2020-04-22 14:24:46', 280),
(38, 2, '2020-04-23 15:35:19', 350),
(39, 3, '2020-04-23 17:49:20', 830),
(40, 5, '2020-04-23 16:36:56', 740),
(41, 6, '2020-04-23 18:58:23', 680),
(42, 7, '2020-04-23 20:41:42', 680),
(43, 8, '2020-04-23 10:36:21', 1060),
(44, 2, '2020-04-24 18:58:10', 440),
(45, 3, '2020-04-24 16:53:21', 460),
(46, 5, '2020-04-24 13:47:53', 250),
(47, 6, '2020-04-24 14:20:58', 970),
(48, 7, '2020-04-24 14:14:21', 110),
(49, 8, '2020-04-24 17:11:42', 840),
(50, 2, '2020-04-25 23:20:21', 840),
(51, 3, '2020-04-25 14:55:13', 150),
(52, 5, '2020-04-25 11:49:55', 360),
(53, 6, '2020-04-25 21:13:52', 940),
(54, 7, '2020-04-25 21:41:59', 1100),
(55, 8, '2020-04-25 18:19:43', 320),
(56, 2, '2020-04-26 11:56:27', 250),
(57, 3, '2020-04-26 23:58:28', 1110),
(58, 5, '2020-04-26 11:40:51', 660),
(59, 6, '2020-04-26 15:39:52', 850),
(60, 7, '2020-04-26 12:56:15', 560),
(61, 8, '2020-04-26 19:26:51', 590),
(62, 2, '2020-04-27 15:27:57', 380),
(63, 3, '2020-04-27 18:43:49', 140),
(64, 5, '2020-04-27 20:31:33', 620),
(65, 6, '2020-04-27 16:38:18', 890),
(66, 7, '2020-04-27 11:38:11', 580),
(67, 8, '2020-04-27 12:28:45', 460),
(68, 2, '2020-04-28 13:50:11', 960),
(69, 3, '2020-04-28 17:43:28', 680),
(70, 5, '2020-04-28 20:22:52', 340),
(71, 6, '2020-04-28 14:45:48', 280),
(72, 7, '2020-04-28 21:29:38', 940),
(73, 8, '2020-04-28 19:25:17', 870),
(74, 2, '2020-04-29 18:21:13', 1130),
(75, 3, '2020-04-29 12:53:31', 370),
(76, 5, '2020-04-29 23:31:41', 900),
(77, 6, '2020-04-29 19:37:34', 600),
(78, 7, '2020-04-29 22:35:43', 900),
(79, 8, '2020-04-29 23:16:35', 640),
(80, 2, '2020-04-30 18:48:59', 440),
(81, 3, '2020-04-30 11:17:23', 750),
(82, 5, '2020-04-30 23:57:48', 630),
(83, 6, '2020-04-30 18:24:29', 860),
(84, 7, '2020-04-30 10:31:20', 460),
(85, 8, '2020-04-30 12:44:36', 150),
(86, 2, '2020-04-20 16:35:13', 220),
(87, 3, '2020-04-20 16:19:29', 900),
(88, 5, '2020-04-20 13:48:41', 920),
(89, 6, '2020-04-20 20:34:39', 610),
(90, 7, '2020-04-20 15:11:18', 490),
(91, 8, '2020-04-20 11:36:13', 590),
(92, 2, '2020-04-21 19:29:52', 830),
(93, 3, '2020-04-21 20:49:39', 450),
(94, 5, '2020-04-21 15:41:34', 820),
(95, 6, '2020-04-21 19:49:29', 380),
(96, 7, '2020-04-21 16:34:13', 260),
(97, 8, '2020-04-21 12:31:50', 110),
(98, 2, '2020-04-22 13:12:10', 690),
(99, 3, '2020-04-22 14:38:35', 500),
(100, 5, '2020-04-22 16:43:13', 810),
(101, 6, '2020-04-22 18:19:54', 760),
(102, 7, '2020-04-22 20:23:45', 1030),
(103, 8, '2020-04-22 16:11:49', 150),
(104, 2, '2020-04-23 12:22:43', 1020),
(105, 3, '2020-04-23 23:33:38', 620),
(106, 5, '2020-04-23 19:54:50', 200),
(107, 6, '2020-04-23 13:48:51', 590),
(108, 7, '2020-04-23 16:21:17', 240),
(109, 8, '2020-04-23 14:14:43', 910),
(110, 2, '2020-04-24 17:34:26', 560),
(111, 3, '2020-04-24 22:31:46', 220),
(112, 5, '2020-04-24 14:21:19', 580),
(113, 6, '2020-04-24 10:10:57', 210),
(114, 7, '2020-04-24 10:23:16', 440),
(115, 8, '2020-04-24 22:54:52', 630),
(116, 2, '2020-04-25 18:24:24', 610),
(117, 3, '2020-04-25 18:29:37', 1130),
(118, 5, '2020-04-25 18:13:10', 240),
(119, 6, '2020-04-25 10:44:30', 1010),
(120, 7, '2020-04-25 14:11:31', 860),
(121, 8, '2020-04-25 18:24:47', 1200),
(122, 2, '2020-04-26 10:34:47', 230),
(123, 3, '2020-04-26 16:16:29', 670),
(124, 5, '2020-04-26 22:35:26', 720),
(125, 6, '2020-04-26 13:56:30', 1190),
(126, 7, '2020-04-26 12:52:27', 1050),
(127, 8, '2020-04-26 19:47:47', 670),
(128, 2, '2020-04-27 21:31:45', 120),
(129, 3, '2020-04-27 18:17:54', 590),
(130, 5, '2020-04-27 13:40:46', 700),
(131, 6, '2020-04-27 18:13:58', 150),
(132, 7, '2020-04-27 10:30:32', 870),
(133, 8, '2020-04-27 14:51:14', 130),
(134, 2, '2020-04-28 21:27:25', 200),
(135, 3, '2020-04-28 22:12:20', 250),
(136, 5, '2020-04-28 15:49:21', 290),
(137, 6, '2020-04-28 23:33:39', 390),
(138, 7, '2020-04-28 10:32:31', 270),
(139, 8, '2020-04-28 19:31:23', 810),
(140, 2, '2020-04-29 23:52:18', 320),
(141, 3, '2020-04-29 12:49:50', 790),
(142, 5, '2020-04-29 16:25:22', 350),
(143, 6, '2020-04-29 16:33:24', 310),
(144, 7, '2020-04-29 19:13:28', 620),
(145, 8, '2020-04-29 20:54:51', 970),
(146, 2, '2020-04-30 21:16:52', 600),
(147, 3, '2020-04-30 12:37:31', 920),
(148, 5, '2020-04-30 20:36:41', 1060),
(149, 6, '2020-04-30 15:29:32', 730),
(150, 7, '2020-04-30 21:31:25', 180);
