-- Adminer 4.8.1 MySQL 5.5.5-10.4.19-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `bec_forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `bec_forum`;

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
    `value` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
    `date` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
    `remote_addr` char(255) CHARACTER SET cp1250 COLLATE cp1250_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2021-07-08 03:50:41