-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: skinsmart
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_owner` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `price` float NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `item_type` varchar(45) NOT NULL,
  `item_skin` varchar(45) DEFAULT NULL,
  `item_name_color` varchar(45) NOT NULL,
  `skin_wear` varchar(45) DEFAULT 'none',
  `image` tinytext NOT NULL,
  `has_stat_track` tinyint(4) NOT NULL,
  `has_sticker` tinyint(4) NOT NULL,
  `has_nametag` tinyint(4) NOT NULL,
  `is_vanilla` tinyint(4) NOT NULL,
  `is_souvenir` tinyint(4) NOT NULL,
  `float_value` float DEFAULT NULL,
  `paint_seed` int(11) DEFAULT NULL,
  `stickers_1_url` mediumtext DEFAULT NULL,
  `sticker_1_name` varchar(60) DEFAULT NULL,
  `stickers_2_url` mediumtext DEFAULT NULL,
  `sticker_2_name` varchar(60) DEFAULT NULL,
  `stickers_3_url` mediumtext DEFAULT NULL,
  `sticker_3_name` varchar(60) DEFAULT NULL,
  `stickers_4_url` mediumtext DEFAULT NULL,
  `sticker_4_name` varchar(60) DEFAULT NULL,
  `stickers_5_url` mediumtext DEFAULT NULL,
  `sticker_5_name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_item_owner` (`fk_owner`),
  CONSTRAINT `fk_item_owner` FOREIGN KEY (`fk_owner`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_history`
--

DROP TABLE IF EXISTS `sales_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_buyer` int(11) NOT NULL,
  `fk_seller_1` int(11) NOT NULL,
  `fk_item_1` int(11) NOT NULL,
  `item_1_price` float NOT NULL,
  `fk_seller_2` int(11) DEFAULT NULL,
  `fk_item_2` int(11) DEFAULT NULL,
  `item_2_price` float DEFAULT NULL,
  `fk_seller_3` int(11) DEFAULT NULL,
  `fk_item_3` int(11) DEFAULT NULL,
  `item_3_price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_item_idx` (`fk_item_1`),
  KEY `fk_users_buyer` (`fk_buyer`),
  KEY `fk_item_2_idx` (`fk_item_2`),
  KEY `fk_item_idx1` (`fk_item_3`),
  KEY `fk_users_seller_1` (`fk_seller_1`),
  KEY `fk_users_seller_2_idx` (`fk_seller_2`),
  KEY `fk_users_seller_3_idx` (`fk_seller_3`),
  CONSTRAINT `fk_item_1` FOREIGN KEY (`fk_item_1`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_2` FOREIGN KEY (`fk_item_2`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_3` FOREIGN KEY (`fk_item_3`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_buyer` FOREIGN KEY (`fk_buyer`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_seller_1` FOREIGN KEY (`fk_seller_1`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_seller_2` FOREIGN KEY (`fk_seller_2`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_seller_3` FOREIGN KEY (`fk_seller_3`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` float NOT NULL,
  `steam_id` tinytext NOT NULL,
  `steam_name` tinytext NOT NULL,
  `display_name` tinytext DEFAULT NULL,
  `avatar` tinytext NOT NULL,
  `trade_link` tinytext DEFAULT NULL,
  `email` tinytext DEFAULT NULL,
  `email_notif` tinyint(4) DEFAULT NULL,
  `discord_name` tinytext DEFAULT NULL,
  `twitter_name` tinytext DEFAULT NULL,
  `instagram_name` tinytext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-28 16:39:00
