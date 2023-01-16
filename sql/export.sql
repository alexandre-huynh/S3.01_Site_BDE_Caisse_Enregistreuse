-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnueabihf (armv8l)
--
-- Host: localhost    Database: e12102253
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin` (
  `id_admin` int(11) NOT NULL,
  `num_etudiant` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Date_creation` date DEFAULT NULL,
  `Pts_fidelite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `num_etudiant` (`num_etudiant`),
  CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`num_etudiant`) REFERENCES `Authentification` (`num_etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (0,11131517,'Blanc','Laurent','0987654321','laurent.blanc@univ-paris13.fr','2000-05-20',20),(1,11223344,'Dupont','Christine','0655443322','christine.dupont@univ-paris13.fr','2002-10-04',2),(2,19181716,'Testeur-Admin','Jean-Paul',NULL,'jeanpaul.testeuradmin@gmail.com','2023-01-08',5),(3,12564365,'Norris','Chuck',NULL,'chuck.norris@gmail.com','2023-01-08',0);
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Authentification`
--

DROP TABLE IF EXISTS `Authentification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Authentification` (
  `num_etudiant` int(11) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`num_etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Authentification`
--

LOCK TABLES `Authentification` WRITE;
/*!40000 ALTER TABLE `Authentification` DISABLE KEYS */;
INSERT INTO `Authentification` VALUES (11131517,'cryptmdp'),(11223344,'$2y$10$uQrNE/Mw4Z8E40oJnYYcNefvr7AhX6MHl3KRkNrMyMRT5ZDi6Vmsy'),(12100971,'$2y$10$bDbwxvAHf3uT6PB6GirtseqkAe21cDDqrsqrPwfdRSWUi.WQbcnle'),(12107666,'$2y$10$PAMlToH5XiXKDg3i8VWEou3hL3cTVQ3byp/AT/0GoZioSw9/suI2a'),(12131514,'$2y$10$Gi.SB1lkL7aNFmznKRE//euDywUqaxHZwNse4XK70BJ49mlLvQRjO'),(12141618,'mdpcrypt'),(12564365,'$2y$10$PE4PvQ64EB/9M1nO5BuRmOG3qDyOdRDi3QY1lIkEMuOepFTy/1aQu'),(12899910,'$2y$10$44634d8OIPBIIMT4fEcxGug0bIW3dbJZuV7yGthDIr3cOcuDQY.fa'),(14151614,'$2y$10$S0thCaWvnHz0OG9o4kkqaeF.IcumSYqiXgLOv/mLDMpmE5Rv1GK4W'),(19181716,'$2y$10$UT3iqUCGrXSC5dWutTWxHOP7k.PWEa6RgKDx2/Qy.n25dLcZCQYlq'),(53423323,'$2y$10$Z/rHgI/1Em5vitfTxJ.RYOdwFefW7ChKI8FOJZSPs/5p9A7SG3F0W'),(56432212,'unmdpcrypter');
/*!40000 ALTER TABLE `Authentification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Client`
--

DROP TABLE IF EXISTS `Client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Client` (
  `id_client` int(11) NOT NULL,
  `num_etudiant` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Date_creation` date DEFAULT NULL,
  `Pts_fidelite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_client`),
  KEY `num_etudiant` (`num_etudiant`),
  CONSTRAINT `Client_ibfk_1` FOREIGN KEY (`num_etudiant`) REFERENCES `Authentification` (`num_etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Client`
--

LOCK TABLES `Client` WRITE;
/*!40000 ALTER TABLE `Client` DISABLE KEYS */;
INSERT INTO `Client` VALUES (0,12141618,'Bernard','Jean','0123456789','jean.bernard@univ-paris13.fr','2004-02-02',16),(1,56432212,'Pierre','Hugo','2356891346','pierre_hugo@univ-paris13.fr','2003-01-20',0),(2,12131514,'Test','Arthur',NULL,'arthur.test@gmail.com','2023-01-04',2),(3,53423323,'Vinci','Léonard','08562374323','leonard.vinci@gmail.com','2023-01-04',0),(4,12107666,'Aubert','Cleante',NULL,'cleante95@gmail.com','2023-01-05',0),(5,14151614,'Larran','Aurélien','06 42 34 56 22','aurelien.larran@edu.univ-paris13.fr','2023-01-10',1),(6,12899910,'Jean','Pierre',NULL,'jean-pierre@yahoo.com','2023-01-10',0),(7,12100971,'Balendran','Angela',NULL,'angela.balendran@gmail.com','2023-01-16',0);
/*!40000 ALTER TABLE `Client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produit`
--

DROP TABLE IF EXISTS `Produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Produit` (
  `id_produit` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Categorie` varchar(50) DEFAULT NULL,
  `Prix` float DEFAULT NULL,
  `Img_produit` varchar(50) DEFAULT NULL,
  `Date_ajout` date DEFAULT NULL,
  `Pts_fidelite_requis` int(11) DEFAULT NULL,
  `Pts_fidelite_donner` int(11) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Nb_ventes` int(11) DEFAULT NULL,
  `Visible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Produit`
--

LOCK TABLES `Produit` WRITE;
/*!40000 ALTER TABLE `Produit` DISABLE KEYS */;
INSERT INTO `Produit` VALUES (0,'Kinder Bueno','Snack',0.8,'kinder_bueno.png','2004-05-12',10,2,27,20,1),(1,'Cristaline (50cl)','Boisson',0.5,'cristaline_(50cl).png','2004-04-12',3,1,3,10,1),(2,'Coca - Cola','Soda',0.8,'coca_-_cola.png','2004-03-12',10,2,9,5,1),(3,'Lays Nature','Snack',0.6,'lays_nature.png','2004-06-20',7,1,27,26,1),(4,'Lays Barbecue','Snack',0.7,'lays_barbecue.png','2004-06-20',7,1,24,17,1),(5,'Mars','Snack',0.7,'produit_5','2023-01-08',10,1,14,1,1),(6,'Malabar','Snack',0.1,'produit_6','2023-01-08',5,1,40,0,1),(7,'Kit Kat','Snack',0.7,'produit_7','2023-01-08',10,1,9,0,1),(8,'Kinder Bueno White','Snack',0.8,'produit_8','2023-01-08',10,1,20,0,1),(9,'Capri Sun (200 ml)','Boisson',0.5,'produit_9','2023-01-08',10,1,20,0,1),(10,'Oasis Tropical (33cl)','Boisson',0.8,'produit_10','2023-01-08',10,1,20,0,1),(11,'Oasis Pomme Cassis (33cl)','Boisson',0.8,'produit_11','2023-01-08',10,1,20,0,1),(12,'Lipton Ice Tea (33cl)','Boisson',0.8,'produit_12','2023-01-08',10,1,20,0,1),(13,'Coca - Cola Cherry','Soda',0.8,'produit_13','2023-01-08',10,1,20,0,1),(14,'Fanta Citron','Soda',0.8,'produit_14','2023-01-08',10,1,20,0,1),(15,'Eau + Sirop Fraise','Sirop',0.8,'produit_15','2023-01-08',10,1,20,0,1),(16,'Eau + Sirop Pêche','Sirop',0.8,'produit_16','2023-01-08',10,1,20,0,1),(17,'Eau + Sirop Cassis','Sirop',0.8,'produit_17','2023-01-08',10,1,20,0,1),(18,'Eau + Sirop Pomme Verte','Sirop',0.8,'produit_18','2023-01-08',10,1,20,0,1),(19,'Eau + Sirop Fruits de la Passion','Sirop',0.8,'produit_19','2023-01-08',10,1,20,0,1),(20,'TEST','Soda',1,'produit_20','2023-01-12',10,1,10,0,0);
/*!40000 ALTER TABLE `Produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SuperAdmin`
--

DROP TABLE IF EXISTS `SuperAdmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SuperAdmin` (
  `id_superadmin` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_superadmin`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `SuperAdmin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `Admin` (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SuperAdmin`
--

LOCK TABLES `SuperAdmin` WRITE;
/*!40000 ALTER TABLE `SuperAdmin` DISABLE KEYS */;
INSERT INTO `SuperAdmin` VALUES (0,0),(1,2);
/*!40000 ALTER TABLE `SuperAdmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vente`
--

DROP TABLE IF EXISTS `Vente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vente` (
  `num_vente` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `Date_vente` date DEFAULT NULL,
  `Paiement` varchar(50) DEFAULT NULL,
  `Use_fidelite` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`num_vente`),
  KEY `id_client` (`id_client`),
  KEY `id_admin` (`id_admin`),
  KEY `id_produit` (`id_produit`),
  CONSTRAINT `Vente_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `Client` (`id_client`),
  CONSTRAINT `Vente_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `Admin` (`id_admin`),
  CONSTRAINT `Vente_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vente`
--

LOCK TABLES `Vente` WRITE;
/*!40000 ALTER TABLE `Vente` DISABLE KEYS */;
INSERT INTO `Vente` VALUES (0,1,0,2,'2004-06-12','Carte bancaire',0),(1,1,0,2,'2004-06-12','Espece',1),(2,4,1,0,'2023-01-07','Espece',0),(3,4,1,4,'2023-01-07','Espece',0),(4,3,0,0,'2023-01-07','Carte bancaire',0),(5,3,0,0,'2023-01-07','Carte bancaire',0),(6,3,0,0,'2023-01-07','Espece',0),(7,3,0,4,'2023-01-07','Carte bancaire',1),(8,3,0,3,'2023-01-06','Espece',1),(9,3,0,3,'2023-01-09','Espece',0),(10,5,3,3,'2023-01-13','Espece',0),(11,0,0,7,'2023-01-13','Espece',0),(12,2,3,3,'2023-01-15','Espece',0),(13,2,3,5,'2023-01-15','Carte bancaire',1);
/*!40000 ALTER TABLE `Vente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnes`
--

DROP TABLE IF EXISTS `personnes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnes` (
  `Nom` varchar(255) DEFAULT NULL,
  `Prénom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnes`
--

LOCK TABLES `personnes` WRITE;
/*!40000 ALTER TABLE `personnes` DISABLE KEYS */;
INSERT INTO `personnes` VALUES ('Jean Sans Terre','Edouard'),('D’aquitaine','Éléonore'),('Cœur de Lion','Richard');
/*!40000 ALTER TABLE `personnes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-16  9:37:28
