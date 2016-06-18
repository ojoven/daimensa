-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: daimensa
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

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
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Language of the content',
  `title` varchar(256) COLLATE utf8_bin NOT NULL COMMENT 'Title of the YouTube video / articles, etc.',
  `description` varchar(512) COLLATE utf8_bin DEFAULT NULL COMMENT 'Description of the YouTube video, articles, etc.',
  `url` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'URL of the content',
  `youtube_id` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT 'Key of the YouTube video',
  `type` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'Type of the content: youtube, article, empty',
  `level` int(11) NOT NULL COMMENT 'Level / Difficultness of the content',
  `average_rating` decimal(10,0) NOT NULL COMMENT 'Average rating of the content',
  `num_ratings` int(11) NOT NULL COMMENT 'Num ratings of the content',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,'fr','Une astuce drôle pour avancer vers la connaissance de soi ;-)','Voici le lien pour savoir quelle célébrité est née le même jour que vous : http://www.anniversaire-celebrite.com\r\n\r\nVoici le lien pour accéder au programme sur la confiance en soi : http://sophrodeclic.com/devenez-confi...\r\n\r\nLien pour aller sur Sophro’Déclic : http://www.sophrodeclic.com\r\n\r\nLien pour une séance de sophrologie gratuite : http://sophrodeclic.com/bonus-flash','https://www.youtube.com/watch?v=COL_Ty6MWjs','COL_Ty6MWjs','youtube',5,4,4,'2016-06-18 00:00:00','2016-06-18 00:00:00');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `image` varchar(64) COLLATE utf8_bin NOT NULL,
  `facebook_id` varchar(32) COLLATE utf8_bin NOT NULL,
  `mother_tongue` varchar(2) COLLATE utf8_bin NOT NULL COMMENT 'Mother tongue of the user in ISO 639-1 format',
  `languages` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'List of languages to learn, separated by commas',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mikel Torres','elmistik@hotmail.com','1_facebook_10154341562508746.jpeg','10154341562508746','es','fr','2016-06-18 14:04:00','2016-06-18 16:38:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `word_forms`
--

DROP TABLE IF EXISTS `word_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `word_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_form` varchar(128) COLLATE utf8_bin NOT NULL,
  `word_id` int(11) NOT NULL,
  `frequency` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word_forms`
--

LOCK TABLES `word_forms` WRITE;
/*!40000 ALTER TABLE `word_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `word_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `words`
--

DROP TABLE IF EXISTS `words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(128) COLLATE utf8_bin NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `words`
--

LOCK TABLES `words` WRITE;
/*!40000 ALTER TABLE `words` DISABLE KEYS */;
/*!40000 ALTER TABLE `words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-18 21:21:21
