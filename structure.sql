
-- Adminer 4.8.1 MySQL 8.0.32-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET cp1250 COLLATE cp1250_general_ci NOT NULL,
  `description` char(255) CHARACTER SET cp1250 COLLATE cp1250_general_ci NOT NULL,
  `category` char(255) CHARACTER SET cp1250 COLLATE cp1250_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  `value` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  `date` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  `remote_addr` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` char(255) CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL,
  `email` char(255) CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL,
  `password` char(255) CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL,
  `role` char(255) CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL,
  `image_base64` longtext CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL,
  `remote_addr` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  `token` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2023-02-03 11:45:36