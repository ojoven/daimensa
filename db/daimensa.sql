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
-- Table structure for table `lesson_words`
--

DROP TABLE IF EXISTS `lesson_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lesson_words` (
  `lesson_id` int(11) NOT NULL,
  `word` varchar(64) COLLATE utf8_bin NOT NULL,
  `frequency` int(11) NOT NULL,
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `lesson_words_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_words`
--

LOCK TABLES `lesson_words` WRITE;
/*!40000 ALTER TABLE `lesson_words` DISABLE KEYS */;
INSERT INTO `lesson_words` VALUES (18,'on',49),(18,'à',22),(18,'de',21),(18,'la',20),(18,'et',19),(18,'un',17),(18,'en',14),(18,'vous',14),(18,'que',13),(18,'va',12),(18,'pas',12),(18,'colorant',11),(18,'les',10),(18,'une',10),(18,'le',10),(18,'peu',9),(18,'il',9),(18,'pâte',9),(18,'bien',9),(18,'ça',9),(18,'pour',8),(18,'des',8),(18,'maintenant',8),(18,'du',8),(18,'ce',8),(18,'tout',7),(18,'mettre',7),(18,'petit',7),(18,'modeler',7),(18,'mais',6),(18,'là',6),(18,'parce',6),(18,'peut',6),(18,'c\'est',6),(18,'si',5),(18,'est',5),(18,'donc',5),(18,'a',5),(18,'par',4),(18,'faut',4),(18,'dans',4),(18,'qui',4),(18,'ne',4),(18,'huile',4),(18,'mélange',4),(18,'très',4),(18,'au',3),(18,'hop',3),(18,'couleurs',3),(18,'feu',3),(18,'chose',3),(18,'beaucoup',3),(18,'plus',3),(18,'quantité',3),(18,'je',3),(18,'cette',3),(18,'quelque',3),(18,'tous',3),(18,'g',3),(18,'coup',3),(18,'À',3),(18,'utiliser',3),(18,'chimique',3),(18,'quand',3),(18,'soit',3),(18,'met',3),(18,'ou',3),(18,'malaxer',3),(18,'fois',3),(18,'même',3),(18,'hein',3),(18,'prend',3),(18,'sel',3),(18,'levure',3),(18,'rajouter',2),(18,'texture',2),(18,'se',2),(18,'voilà',2),(18,'large',2),(18,'suivant',2),(18,'laisser',2),(18,'autres',2),(18,'petites',2),(18,'conserver',2),(18,'grande',2),(18,'notre',2),(18,'vraiment',2),(18,'avec',2),(18,'gros',2),(18,'plastique',2),(18,'éteint',2),(18,'euh',2),(18,'obtient',2),(18,'avoir',2),(18,'sur',2),(18,'côté',2),(18,'enfants',2),(18,'farine',2),(18,'faudra',2),(18,'elle',2),(18,'eau',2),(18,'bon',2),(18,'conseille',2),(18,'liquide',2),(18,'étale',2),(18,'gel',2),(18,'maïzena',2),(18,'avez',2),(18,'poudre',2),(18,'être',2),(18,'allez',2),(18,'sinon',2),(18,'partout',2),(18,'boule',2),(18,'couleur',2),(18,'fait',2),(18,'grumeaux',2),(18,'ensemble',2),(18,'ajoute',2),(18,'ajouter',2),(18,'arrête',1),(18,'voulait',1),(18,'sûr',1),(18,'vives',1),(18,'final',1),(18,'éventuellement',1),(18,'quasiment',1),(18,'fiole',1),(18,'entier',1),(18,'où',1),(18,'ensuite',1),(18,'moment',1),(18,'dessus',1),(18,'gants',1),(18,'joueront',1),(18,'intégré',1),(18,'ils',1),(18,'bah',1),(18,'nouveau',1),(18,'peur',1),(18,'colorent',1),(18,'doigts',1),(18,'auront',1),(18,'sera',1),(18,'hermétiques',1),(18,'unes',1),(18,'déteindre',1),(18,'juste',1),(18,'bout',1),(18,'bleue',1),(18,'jaune',1),(18,'vont',1),(18,'elles',1),(18,'contre',1),(18,'trop',1),(18,'autre',1),(18,'force',1),(18,'stocker',1),(18,'sans',1),(18,'souci',1),(18,'partagez-le',1),(18,'tuto',1),(18,'partagez',1),(18,'oubliez',1),(18,'chaîne',1),(18,'abonner',1),(18,'aimé',1),(18,'mois',1),(18,'suivante',1),(18,'emballe',1),(18,'hopla',1),(18,'referme',1),(18,'plusieurs',1),(18,'ranger',1),(18,'entre',1),(18,'pointe',1),(18,'puissant',1),(18,'couteau',1),(18,'mon',1),(18,'surement',1),(18,'avis',1),(18,'aussi',1),(18,'besoin',1),(18,'ainsi',1),(18,'remalaxe',1),(18,'suite',1),(18,'voulez',1),(18,'aurez',1),(18,'suffisant',1),(18,'abri',1),(18,'sulfurisé',1),(18,'papier',1),(18,'comme',1),(18,'faire',1),(18,'séparations',1),(18,'boite',1),(18,'prévoyez',1),(18,'boites',1),(18,'air',1),(18,'sacs',1),(18,'congélation',1),(18,'zip',1),(18,'élastique',1),(18,'convaincant',1),(18,'malaxera',1),(18,'après',1),(18,'fera',1),(18,'jolie',1),(18,'puis',1),(18,'dramatique',1),(18,'faites',1),(18,'mélanger',1),(18,'rapidement',1),(18,'grossièrement',1),(18,'franchement',1),(18,'finir',1),(18,'hésiter',1),(18,'pleins',1),(18,'boulga',1),(18,'dedans',1),(18,'grave',1),(18,'cuire',1),(18,'globi',1),(18,'globi-boulga',1),(18,'prévoir',1),(18,'pourrait',1),(18,'fin',1),(18,'instant',1),(18,'déjà',1),(18,'supermarché',1),(18,'près',1),(18,'sachet',1),(18,'cuillères',1),(18,'soupe',1),(18,'colorants',1),(18,'litre',1),(18,'maison',1),(18,'aujourd’hui',1),(18,'propose',1),(18,'réaliser',1),(18,'votre',1),(18,'simple',1),(18,'casserole',1),(18,'remplacer',1),(18,'bicarbonate',1),(18,'trouve',1),(18,'rayon',1),(18,'quad',1),(18,'rare',1),(18,'verser',1),(18,'nos',1),(18,'ingrédients',1),(18,'secs',1),(18,'doux',1),(18,'régulièrement',1),(18,'chaque',1),(18,'colorer',1),(18,'utilise',1),(18,'alimentaire',1),(18,'dangereuse',1),(18,'mieux',1),(18,'lisse',1),(18,'morceaux',1),(18,'écrasant',1),(18,'voit',1),(18,'devient',1),(18,'Ça',1),(18,'super',1),(18,'plutôt',1),(18,'puisqu’en',1),(18,'falloir',1),(18,'intègre',1),(18,'quel',1),(18,'importe',1),(18,'salé',1),(18,'cas',1),(18,'avale',1),(18,'panique',1),(18,'prélève',1),(18,'arranger',1),(18,'normal',1),(18,'encore',1),(18,'sec',1),(18,'sent',1),(18,'moins',1),(18,'rien',1),(18,'ressemble',1),(18,'jusqu\'à',1),(18,'épaississe',1),(18,'truc',1),(18,'plâtre',1),(18,'gluant',1),(18,'heure',1),(18,'toujours',1),(18,'bonjour',1),(18,'niveau',1),(18,'effet',1),(18,'refroidi',1),(18,'vraie',1),(18,'refroidir',1),(18,'avant',1),(18,'magie',1),(18,'transformera',1),(18,'diluer',1);
/*!40000 ALTER TABLE `lesson_words` ENABLE KEYS */;
UNLOCK TABLES;

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
  `text` text COLLATE utf8_bin NOT NULL COMMENT 'Text of the lesson (captions, article)',
  `url` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'URL of the content',
  `type` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'Type of the content: youtube, article, empty',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (18,'fr','DIY Pâte à modeler maison - Comment faire de la pâte à modeler ?','DIY Pâte à modeler maison Faire sa propre pâte à modeler avec des ingrédients non-toxiques, c\'est facile, écologique et économique. \\/. LE BANDEAU (cliquez.',' Bonjour à tous Aujourd’hui je vous propose de réaliser votre pâte à modeler maison Il vous faudra 400 g de farine 1 2 litre d\'eau 100 g de maïzena 1 sachet de levure chimique 100 g de sel à peu près 4 cuillères à soupe d\'huile et des colorants C\'est très simple Dans une casserole on va verser tous nos ingrédients secs la maïzena le sel la levure chimique si vous n\'avez pas de levure chimique bon ce qui est rare quad même hein mais on peut quand même la remplacer par du bicarbonate qu\'on trouve au rayon sel du supermarché la farine On va déjà mélanger un petit coup tout ça rapidement grossièrement On va maintenant ajouter l\'eau qu\'on ajoute petit à petit mais franchement Si vous faites des grumeaux ce n\'est pas dramatique parce qu\'après on la malaxera bien et ça fera une jolie pâte quand même Et puis on ajoute l\'huile pour finir L\'huile il ne faut pas hésiter à prévoir un peu large par ce que suivant la texture on pourrait en rajouter à la fin Pour l\'instant on mélange on obtient un gros globi-boulga avec pleins de grumeaux dedans Ce n\'est pas grave du tout et on va mettre maintenant à cuire À feu doux et on mélange On mélange régulièrement jusqu\'à ce que ça épaississe On obtient un gros truc de plâtre un peu qui ne ressemble à rien mais encore une fois c\'est vraiment normal On éteint le feu maintenant C\'est bien sec On sent que c\'est moins gluant que tout à l\'heure Donc on éteint le feu et on va laisser refroidir avant de la malaxer et par magie elle se transformera en vraie pâte à modeler La pâte a maintenant refroidi ce n\'est toujours pas très convaincant euh niveau effet pâte à modeler mais on va arranger ça Donc on en prélève des morceaux et là on va bien la malaxer en écrasant et on voit que d\'un coup ça devient quelque chose de beaucoup plus lisse Voilà Donc là on a quelque chose de beaucoup mieux Et maintenant on va colorer chaque boule de couleur On utilise du colorant alimentaire ce qui fait que l\'ensemble de cette pâte à modeler n\'est pas du tout dangereuse pour les enfants Ça ne va pas être super bon parce que ça va être très salé mais en tout cas s\'il avale pas de panique On prend n\'importe quel colorant Je vous conseille plutôt un colorant liquide ou un colorant en gel puisqu’en poudre il va falloir vraiment euh beaucoup plus malaxer pour que ça s\'intègre bien Ou sinon il faudra diluer un peu le colorant en poudre Prévoyez une large en quantité de colorant parce qu\'au final pour avoir des couleurs bien vives il faut quasiment mettre une fiole en entier par boule On étale un peu et on met le colorant dessus Et là on peut utiliser des gants hein parce que là on va s\'en mettre partout hein Bah il ne faut pas avoir peur vous allez vous en mettre partout au moment où vous allez mettre le colorant Et une fois qu\'il sera bien intégré quand les enfants joueront à la pâte à modeler ils n\'auront pas les doigts qui se colorent Ensuite on mélange à nouveau Une fois qu\'on a la couleur qu\'on voulait on arrête d\'ajouter du colorant bien sûr Et éventuellement suivant la texture que ça a on peut rajouter un tout petit peu d\'huile pour qu\'elle soit plus élastique Maintenant on remalaxe un petit coup Et maintenant on fait ainsi de suite avec les autres couleurs Si vous voulez utiliser du colorant en gel vous n\'aurez pas besoin du tout d\'une aussi grande quantité que le colorant liquide parce que c\'est très puissant On prend la pointe d\'un couteau et on étale un peu À mon avis c\'est surement suffisant cette quantité Et voilà on a notre pâte à modeler Maintenant pour la conserver il faut la laisser à l\'abri de l\'air Donc on la met soit dans des petites boites en plastique soit dans des sacs congélation à zip bien hermétiques Sinon on peut tous les mettre ensemble dans une grande boite en plastique Mais là je vous conseille d\'utiliser un petit peu de papier sulfurisé ou quelque chose comme ça pour faire des petites séparations entre parce que si vous les ranger trop l\'une contre l\'autre à force de les stocker les couleurs elles vont un peu déteindre les unes sur les autres Donc là hop on prend juste un petit bout on le met sur le côté hop À côté de la jaune on peut mettre la bleue sans souci Hop On emballe la suivante Hopla On referme bien et on peut conserver cette pâte à modeler plusieurs mois Si vous avez aimé ce tuto partagez-le et n\'oubliez pas de vous abonner à notre chaîne ','https://www.youtube.com/watch?v=NRIsz2FIW_Q','youtube','2016-07-02 14:41:26','2016-07-02 14:41:26');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mikel Torres','elmistik@hotmail.com','1_facebook_10154341562508746.jpeg','10154341562508746','es','fr','2016-06-18 14:04:00','2016-06-18 16:38:59'),(2,'Mikel D. Torres','michel@majesticmedia.ca','','2061763684047771','en','','2016-07-02 14:45:08','2016-07-02 14:45:08');
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

--
-- Table structure for table `youtube_video_captions`
--

DROP TABLE IF EXISTS `youtube_video_captions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `youtube_video_captions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `caption` varchar(512) COLLATE utf8_bin NOT NULL,
  `start` decimal(10,3) NOT NULL,
  `end` decimal(10,3) NOT NULL,
  `duration` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtube_video_captions`
--

LOCK TABLES `youtube_video_captions` WRITE;
/*!40000 ALTER TABLE `youtube_video_captions` DISABLE KEYS */;
INSERT INTO `youtube_video_captions` VALUES (1,18,'Bonjour à tous ! Aujourd’hui, je vous propose\nde réaliser votre pâte à modeler maison.',7.299,12.170,4.871),(2,18,'Il vous faudra :\n400 g de farine,',12.170,15.389,3.219),(3,18,'1/2 litre d&#39;eau,\n100 g de maïzena,',15.389,19.000,3.611),(4,18,'1 sachet de levure chimique,\n100 g de sel,',19.000,22.630,3.630),(5,18,'à peu près 4 cuillères à soupe d&#39;huile,\net des colorants.',22.630,25.710,3.080),(6,18,'C&#39;est très simple. Dans une casserole, on\nva verser tous nos ingrédients secs, la maïzena,',25.710,32.009,6.299),(7,18,'le sel, la levure chimique (si vous n&#39;avez\npas de levure chimique, bon, ce qui est rare',32.009,37.180,5.171),(8,18,'quad même hein, mais on peut quand même\nla remplacer par du bicarbonate qu&#39;on trouve',37.180,41.210,4.030),(9,18,'au rayon sel du supermarché), la farine.\nOn va déjà mélanger un petit coup tout',41.210,47.210,6.000),(10,18,'ça rapidement grossièrement.\nOn va maintenant ajouter l&#39;eau, qu&#39;on ajoute',47.210,54.219,7.009),(11,18,'petit à petit, mais franchement. Si vous\nfaites des grumeaux, ce n&#39;est pas dramatique',54.219,57.030,2.811),(12,18,'parce qu&#39;après on la malaxera bien et ça\nfera une jolie pâte quand même. Et puis,',57.030,66.710,9.680),(13,18,'on ajoute l&#39;huile pour finir. L&#39;huile, il\nne faut pas hésiter à prévoir un peu large,',66.710,74.650,7.940),(14,18,'par ce que suivant la texture, on pourrait\nen rajouter à la fin. Pour l&#39;instant, on',74.650,79.540,4.890),(15,18,'mélange, on obtient un gros globi-boulga\navec pleins de grumeaux dedans. Ce n&#39;est pas',79.540,85.310,5.770),(16,18,'grave du tout et on va mettre maintenant à\ncuire. À feu doux et on mélange. On mélange',85.310,93.490,8.180),(17,18,'régulièrement jusqu&#39;à ce que ça épaississe.\nOn obtient un gros truc de plâtre un peu',93.490,107.700,14.210),(18,18,'qui ne ressemble à rien, mais encore une\nfois, c&#39;est vraiment normal.',107.700,112.610,4.910),(19,18,'On éteint le feu maintenant. C&#39;est bien sec.\nOn sent que, c&#39;est moins gluant que tout à',112.610,116.510,3.900),(20,18,'l&#39;heure. Donc, on éteint le feu et on va\nlaisser refroidir avant de la malaxer et par',116.510,121.750,5.240),(21,18,'magie, elle se transformera en vraie pâte\nà modeler.',121.750,125.140,3.390),(22,18,'La pâte a maintenant refroidi, ce n&#39;est toujours\npas très convaincant, euh, niveau effet pâte',125.140,129.539,4.399),(23,18,'à modeler, mais on va arranger ça. Donc,\non en prélève des morceaux et là, on va',129.539,135.260,5.721),(24,18,'bien la malaxer en écrasant et on voit que\nd&#39;un coup ça devient quelque chose de beaucoup',135.260,139.730,4.470),(25,18,'plus lisse. Voilà ! Donc là, on a quelque\nchose de beaucoup mieux.',139.730,144.450,4.720),(26,18,'Et maintenant, on va colorer chaque boule\nde couleur. On utilise du colorant alimentaire,',144.450,157.930,13.480),(27,18,'ce qui fait que l&#39;ensemble de cette pâte\nà modeler n&#39;est pas du tout dangereuse pour',157.930,161.950,4.020),(28,18,'les enfants. Ça ne va pas être super bon\nparce que ça va être très salé, mais en',161.950,164.890,2.940),(29,18,'tout cas s&#39;il avale, pas de panique. On prend\nn&#39;importe quel colorant. Je vous conseille',164.890,170.970,6.080),(30,18,'plutôt un colorant liquide ou un colorant\nen gel puisqu’en poudre, il va falloir vraiment',170.970,175.980,5.010),(31,18,'euh beaucoup plus malaxer pour que ça s&#39;intègre\nbien. Ou sinon, il faudra diluer un peu le',175.980,180.680,4.700),(32,18,'colorant en poudre. Prévoyez une large en\nquantité de colorant, parce qu&#39;au final,',180.680,185.860,5.180),(33,18,'pour avoir des couleurs bien vives, il faut\nquasiment mettre une fiole en entier par boule.',185.860,190.590,4.730),(34,18,'On étale un peu et on met le colorant dessus.\nEt là, on peut utiliser des gants hein parce',190.590,195.010,4.420),(35,18,'que là, on va s&#39;en mettre partout hein. Bah\nil ne faut pas avoir peur, vous allez vous',195.010,198.540,3.530),(36,18,'en mettre partout au moment où vous allez\nmettre le colorant. Et une fois qu&#39;il sera',198.540,202.230,3.690),(37,18,'bien intégré, quand les enfants joueront\nà la pâte à modeler, ils n&#39;auront pas les',202.230,206.010,3.780),(38,18,'doigts qui se colorent. Ensuite, on mélange\nà nouveau. Une fois qu&#39;on a la couleur qu&#39;on',206.010,220.180,14.170),(39,18,'voulait, on arrête d&#39;ajouter du colorant\nbien sûr. Et éventuellement, suivant la',220.180,226.099,5.919),(40,18,'texture que ça a, on peut rajouter un tout\npetit peu d&#39;huile, pour qu&#39;elle soit plus',226.099,230.090,3.991),(41,18,'élastique.\nMaintenant, on remalaxe un petit coup. Et',230.090,236.319,6.229),(42,18,'maintenant, on fait ainsi de suite avec les\nautres couleurs. Si vous voulez utiliser du',236.319,260.220,23.901),(43,18,'colorant en gel, vous n&#39;aurez pas besoin du\ntout d&#39;une aussi grande quantité que le colorant',260.220,264.710,4.490),(44,18,'liquide parce que c&#39;est très puissant. On\nprend la pointe d&#39;un couteau et on étale',264.710,272.520,7.810),(45,18,'un peu. À mon avis, c&#39;est surement suffisant\ncette quantité. Et voilà, on a notre pâte',272.520,290.559,18.039),(46,18,'à modeler.\nMaintenant, pour la conserver, il faut la',290.559,293.740,3.181),(47,18,'laisser à l&#39;abri de l&#39;air. Donc, on la met,\nsoit dans des petites boites en plastique,',293.740,297.759,4.019),(48,18,'soit dans des sacs congélation à zip bien\nhermétiques. Sinon, on peut tous les mettre',297.759,302.249,4.490),(49,18,'ensemble dans une grande boite en plastique.\nMais là, je vous conseille d&#39;utiliser un',302.249,306.879,4.630),(50,18,'petit peu de papier sulfurisé ou quelque\nchose comme ça pour faire des petites séparations',306.879,311.809,4.930),(51,18,'entre, parce que si vous les ranger trop l&#39;une\ncontre l&#39;autre, à force de les stocker, les',311.809,316.900,5.091),(52,18,'couleurs elles vont un peu déteindre les\nunes sur les autres. Donc là, hop, on prend',316.900,326.389,9.489),(53,18,'juste un petit bout, on le met sur le côté,\nhop. À côté de la jaune, on peut mettre',326.389,332.360,5.971),(54,18,'la bleue sans souci. Hop ! On emballe la suivante.\nHopla ! On referme bien et on peut conserver',332.360,353.360,21.000),(55,18,'cette pâte à modeler plusieurs mois.\nSi vous avez aimé ce tuto, partagez-le et',353.360,358.330,4.970),(56,18,'n&#39;oubliez pas de vous abonner à notre chaîne\n!',358.330,359.939,1.609);
/*!40000 ALTER TABLE `youtube_video_captions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `youtube_videos`
--

DROP TABLE IF EXISTS `youtube_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `youtube_videos` (
  `lesson_id` int(11) NOT NULL,
  `youtube_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `channel_id` varchar(32) COLLATE utf8_bin NOT NULL,
  `duration` varchar(12) COLLATE utf8_bin NOT NULL,
  `proportion_words` decimal(10,3) NOT NULL,
  `definition` varchar(12) COLLATE utf8_bin NOT NULL,
  `view_count` int(11) NOT NULL,
  `like_count` int(11) NOT NULL,
  `dislike_count` int(11) NOT NULL,
  `favorite_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `published_date` datetime NOT NULL,
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `youtube_videos_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtube_videos`
--

LOCK TABLES `youtube_videos` WRITE;
/*!40000 ALTER TABLE `youtube_videos` DISABLE KEYS */;
INSERT INTO `youtube_videos` VALUES (18,'NRIsz2FIW_Q','UC1Q6XM50dzA0m6YmTi8lrdg','377',1.000,'hd',228932,2815,127,0,177,'2015-08-27 09:00:01');
/*!40000 ALTER TABLE `youtube_videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-02 21:22:40
