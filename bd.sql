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

INSERT INTO bvzfdagnfqepipz70gyw.drinks
(idDrink, userID, dateDrink, mlDrink)
VALUES(1, 2, '2020-03-15 19:42:08', 200),
(3, 2, '2020-03-15 19:42:57', 100),
(4, 2, '2020-03-16 01:42:58', 150),
(5, 3, '2020-03-15 19:42:58', 1320),
(6, 2, '2020-03-15 20:07:33', 300),
(8, 2, '2020-03-15 20:15:28', 130),
(9, 3, '2020-03-16 00:17:14', 420),
(10, 2, '2020-03-15 20:43:38', 200),
(12, 3, '2020-03-16 02:44:55', 80),
(13, 2, '2020-03-15 21:06:01', 820);


INSERT INTO bvzfdagnfqepipz70gyw.users
(iduser, email, password, name)
VALUES(1, 'rubensnsg@gmail.com.br', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Rubens Nelson Santos Gonçalves'),
(2, 'thomas@reuters.com', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Thomas Reuters'),
(3, 'rubensnsg@hotmail.com.br', 'bda0164d123a070125c455d7c75c4cf8d90e745ff16ec350d3bfcbca7187988d', 'Rubens Nelson S. Gonçalves');
