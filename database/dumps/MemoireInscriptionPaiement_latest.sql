-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: MemoireInscriptionPaiement
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `administrations`
--

DROP TABLE IF EXISTS `administrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personne_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `administrations_personne_id_foreign` (`personne_id`),
  CONSTRAINT `administrations_personne_id_foreign` FOREIGN KEY (`personne_id`) REFERENCES `personnes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrations`
--

LOCK TABLES `administrations` WRITE;
/*!40000 ALTER TABLE `administrations` DISABLE KEYS */;
INSERT INTO `administrations` VALUES (1,31,'2025-07-27 23:35:59','2025-07-27 23:35:59'),(2,37,'2025-08-13 14:09:59','2025-08-13 14:09:59');
/*!40000 ALTER TABLE `administrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `frais_inscription` bigint(20) unsigned NOT NULL DEFAULT 0,
  `frais_mensualite` bigint(20) unsigned NOT NULL DEFAULT 0,
  `frais_soutenance` bigint(20) unsigned NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_libelle_index` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'Licence 1 Groupe A',150000,25000,0,'Description pour Licence 1 Groupe A','2025-07-27 23:35:58','2025-08-12 23:32:42'),(4,'Licence 2 Groupe A',0,0,0,'Description pour Licence 2 Groupe A','2025-07-27 23:35:58','2025-07-27 23:35:58'),(5,'Licence 2 Groupe B',0,0,0,'Description pour Licence 2 Groupe B','2025-07-27 23:35:58','2025-07-27 23:35:58'),(6,'Licence 2 Groupe C',0,0,0,'Description pour Licence 2 Groupe C','2025-07-27 23:35:58','2025-07-27 23:35:58'),(7,'Licence 3 Groupe A',0,0,0,'Description pour Licence 3 Groupe A','2025-07-27 23:35:58','2025-07-27 23:35:58'),(8,'Licence 3 Groupe B',0,0,0,'Description pour Licence 3 Groupe B','2025-07-27 23:35:58','2025-07-27 23:35:58'),(9,'Licence 3 Groupe C',0,0,0,'Description pour Licence 3 Groupe C','2025-07-27 23:35:58','2025-07-27 23:35:58'),(10,'Master 1 Groupe A',220000,60000,0,'Description pour Master 1 Groupe A','2025-07-27 23:35:58','2025-07-27 23:35:58'),(13,'Master 2 Groupe A',0,0,0,'Description pour Master 2 Groupe A','2025-07-27 23:35:58','2025-07-27 23:35:58'),(14,'Master 2 Groupe B',0,0,0,'Description pour Master 2 Groupe B','2025-07-27 23:35:58','2025-07-27 23:35:58'),(15,'Master 2 Groupe C',0,0,0,'Description pour Master 2 Groupe C','2025-07-27 23:35:58','2025-07-27 23:35:58'),(16,'L3 GL',210000,50000,50000,'Licence3 Genie Logiciel','2025-08-12 23:18:55','2025-08-12 23:18:55');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comptables`
--

DROP TABLE IF EXISTS `comptables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comptables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personne_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comptables_personne_id_foreign` (`personne_id`),
  CONSTRAINT `comptables_personne_id_foreign` FOREIGN KEY (`personne_id`) REFERENCES `personnes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comptables`
--

LOCK TABLES `comptables` WRITE;
/*!40000 ALTER TABLE `comptables` DISABLE KEYS */;
INSERT INTO `comptables` VALUES (2,43,'2025-09-07 22:17:20','2025-09-07 22:17:20'),(3,44,'2025-09-07 23:02:27','2025-09-07 23:02:27');
/*!40000 ALTER TABLE `comptables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personne_id` bigint(20) unsigned NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `accepte_email` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `etudiants_matricule_unique` (`matricule`),
  KEY `etudiants_personne_id_foreign` (`personne_id`),
  KEY `etudiants_matricule_index` (`matricule`),
  CONSTRAINT `etudiants_personne_id_foreign` FOREIGN KEY (`personne_id`) REFERENCES `personnes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiants`
--

LOCK TABLES `etudiants` WRITE;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` VALUES (1,1,'ET-2025-4531',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(2,2,'ET-2025-2783',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(3,3,'ET-2025-6327',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(4,4,'ET-2025-1454',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(5,5,'ET-2025-4448',0,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(6,6,'ET-2025-2673',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(7,7,'ET-2025-4005',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(8,8,'ET-2025-3174',1,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(31,34,'2025-ETU-0001',0,'2025-08-11 21:08:31','2025-08-11 21:08:31'),(32,35,'2025-ETU-0002',0,'2025-08-13 10:44:02','2025-08-13 10:44:02'),(33,36,'2025-ETU-0003',0,'2025-08-13 12:48:44','2025-08-13 12:48:44'),(34,38,'2025-ETU-0004',0,'2025-08-15 18:27:29','2025-08-15 18:27:29'),(35,39,'2025-ETU-0005',0,'2025-08-17 13:20:16','2025-08-17 13:20:16'),(36,40,'2025-ETU-0006',0,'2025-08-17 14:16:45','2025-08-17 14:16:45'),(37,41,'2025-ETU-0007',0,'2025-08-17 15:15:40','2025-08-17 15:15:40'),(38,42,'2025-ETU-0008',0,'2025-09-07 22:13:10','2025-09-07 22:13:10');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `etudiant_id` bigint(20) unsigned NOT NULL,
  `classe_id` bigint(20) unsigned NOT NULL,
  `administration_id` bigint(20) unsigned DEFAULT NULL,
  `annee_academique` varchar(255) NOT NULL,
  `date_inscription` date NOT NULL,
  `confirmation_envoyee` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut` enum('en_attente','valide','rejeté') NOT NULL DEFAULT 'en_attente',
  PRIMARY KEY (`id`),
  KEY `inscriptions_etudiant_id_foreign` (`etudiant_id`),
  KEY `inscriptions_classe_id_foreign` (`classe_id`),
  KEY `inscriptions_administration_id_foreign` (`administration_id`),
  CONSTRAINT `inscriptions_administration_id_foreign` FOREIGN KEY (`administration_id`) REFERENCES `administrations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `inscriptions_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inscriptions_etudiant_id_foreign` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscriptions`
--

LOCK TABLES `inscriptions` WRITE;
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
INSERT INTO `inscriptions` VALUES (7,3,9,1,'2025-2026','2025-04-28',0,'2025-07-27 23:35:59','2025-08-10 20:42:47','valide'),(19,1,10,1,'2025-2026','2025-04-28',1,'2025-07-27 23:35:59','2025-08-10 23:19:02','valide'),(21,6,15,1,'2025-2026','2025-03-13',1,'2025-07-27 23:35:59','2025-08-11 18:27:56','valide'),(27,4,15,1,'2025-2026','2025-07-27',0,'2025-07-27 23:35:59','2025-07-27 23:35:59','en_attente'),(30,4,5,1,'2025-2026','2025-03-29',1,'2025-07-27 23:35:59','2025-07-27 23:35:59','en_attente'),(35,5,14,1,'2025-2026','2025-04-29',1,'2025-07-27 23:35:59','2025-07-27 23:35:59','en_attente'),(41,32,16,NULL,'2025-2026','2025-08-13',0,'2025-08-13 11:30:00','2025-08-13 11:30:00','en_attente'),(43,31,16,2,'2025-2026','2025-08-13',0,'2025-08-13 11:40:46','2025-08-13 15:05:15','valide'),(44,33,16,2,'2025-2026','2025-08-13',0,'2025-08-13 12:49:34','2025-08-13 15:04:49','valide'),(45,34,16,2,'2025-2026','2025-08-15',0,'2025-08-15 18:28:51','2025-08-15 18:32:22','valide'),(46,33,10,2,'2025-2026','2025-08-16',0,'2025-08-16 01:55:02','2025-08-17 23:10:18','valide'),(47,33,10,2,'2025-2026','2025-08-16',0,'2025-08-16 01:59:18','2025-08-16 01:59:50','valide'),(48,36,10,2,'2025-2026','2025-08-17',0,'2025-08-17 14:24:21','2025-08-17 14:24:35','valide'),(49,37,10,2,'2025-2026','2025-08-17',0,'2025-08-17 15:16:58','2025-08-17 15:18:26','valide'),(50,38,16,2,'2025-2026','2025-09-07',0,'2025-09-07 23:13:18','2025-09-08 18:03:24','valide');
/*!40000 ALTER TABLE `inscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_27_190125688679dd50828_create_classes_table',1),(5,'2025_07_27_190125688679dd726aa_create_personnes_table',1),(6,'2025_07_27_190125688680dd81b31_create_etudiants_table',1),(7,'2025_07_27_190314_create_personal_access_tokens_table',1),(8,'2025_07_27_191125688679dd4e1f6_create_administrations_table',1),(9,'2025_07_27_191125688679dd5da01_create_comptables_table',1),(10,'2025_07_27_191125688679dd6c659_create_inscriptions_table',1),(11,'2025_07_27_191125688679dd709ed_create_paiements_table',1),(12,'2025_08_07_182931_add_role_to_users_table',2),(13,'2025_07_10_114230_add_foreign_key_user_id_to_personnes_table',3),(14,'2025_08_10_171759_add_statut_to_inscriptions_table',4),(15,'2025_08_12_154602_add_motif_to_paiements_table',5),(16,'2025_08_12_204509_add_frais_to_classes_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paiements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inscription_id` bigint(20) unsigned NOT NULL,
  `comptable_id` bigint(20) unsigned DEFAULT NULL,
  `date_paiement` date NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `motif` enum('inscription','mensualite','examen','soutenance','autre') NOT NULL DEFAULT 'autre',
  `reference_transaction` varchar(255) NOT NULL,
  `mode_paiement` enum('espece','virement','wave','orange_money') NOT NULL,
  `statut` enum('en_attente','valide','rejete','annule') NOT NULL DEFAULT 'en_attente',
  `validation_email_envoye` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `paiements_reference_transaction_unique` (`reference_transaction`),
  KEY `paiements_inscription_id_foreign` (`inscription_id`),
  KEY `paiements_comptable_id_foreign` (`comptable_id`),
  CONSTRAINT `paiements_comptable_id_foreign` FOREIGN KEY (`comptable_id`) REFERENCES `administrations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `paiements_inscription_id_foreign` FOREIGN KEY (`inscription_id`) REFERENCES `inscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiements`
--

LOCK TABLES `paiements` WRITE;
/*!40000 ALTER TABLE `paiements` DISABLE KEYS */;
INSERT INTO `paiements` VALUES (7,21,1,'2025-06-19',88381.93,'autre','PAY-zply18-6582','virement','rejete',0,'2025-07-27 23:35:59','2025-07-27 23:35:59'),(20,19,1,'2025-06-12',340874.23,'autre','PAY-rold22-4888','wave','valide',0,'2025-07-27 23:35:59','2025-07-27 23:35:59'),(25,27,1,'2025-07-27',392845.89,'autre','PAY-aixz34-7872','espece','valide',0,'2025-07-27 23:35:59','2025-08-13 20:59:34'),(52,35,1,'2025-05-07',74307.53,'autre','PAY-rqzj52-8248','virement','valide',0,'2025-07-27 23:35:59','2025-08-14 07:22:01'),(53,27,1,'2025-05-12',71687.51,'autre','PAY-nxnh18-9449','orange_money','valide',0,'2025-07-27 23:35:59','2025-08-14 08:00:09'),(54,21,1,'2025-07-20',221577.69,'autre','PAY-sjuy08-1827','orange_money','valide',0,'2025-07-27 23:35:59','2025-08-14 08:00:55'),(65,44,NULL,'2025-08-16',210000.00,'autre','INS_44_1755303377','orange_money','valide',0,'2025-08-16 00:16:17','2025-08-16 01:50:52'),(66,47,NULL,'2025-08-16',220000.00,'autre','INS_47_1755311173','orange_money','valide',0,'2025-08-16 02:26:13','2025-08-17 14:33:34'),(67,48,NULL,'2025-08-17',220000.00,'autre','INS_48_1755440857','orange_money','valide',0,'2025-08-17 14:27:37','2025-08-17 14:33:21'),(68,49,NULL,'2025-08-17',220000.00,'autre','INS_49_1755444124','orange_money','valide',0,'2025-08-17 15:22:04','2025-08-17 15:24:11'),(69,48,NULL,'2025-08-29',60000.00,'autre','INS_48_1756499716','orange_money','en_attente',0,'2025-08-29 20:35:16','2025-08-29 20:35:16'),(70,44,NULL,'2025-09-05',50000.00,'autre','INS_44_1757085692','orange_money','en_attente',0,'2025-09-05 15:21:32','2025-09-05 15:21:32'),(73,44,NULL,'2025-09-05',50000.00,'autre','INS_44_1757091448','orange_money','en_attente',0,'2025-09-05 16:57:28','2025-09-05 16:57:28'),(76,46,NULL,'2025-09-05',60000.00,'autre','INS_46_1757095858','orange_money','en_attente',0,'2025-09-05 18:10:58','2025-09-05 18:10:58');
/*!40000 ALTER TABLE `paiements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnes`
--

DROP TABLE IF EXISTS `personnes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `nom_d_utilisateur` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personnes_email_unique` (`email`),
  UNIQUE KEY `personnes_nom_d_utilisateur_unique` (`nom_d_utilisateur`),
  KEY `personnes_nom_prenom_index` (`nom`,`prenom`),
  KEY `personnes_email_index` (`email`),
  KEY `personnes_nom_d_utilisateur_index` (`nom_d_utilisateur`),
  KEY `personnes_user_id_foreign` (`user_id`),
  CONSTRAINT `personnes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnes`
--

LOCK TABLES `personnes` WRITE;
/*!40000 ALTER TABLE `personnes` DISABLE KEYS */;
INSERT INTO `personnes` VALUES (1,8,'Stamm','Cleveland','vconn@example.net','+1.850.591.4651','1977-05-23','47446 Kennedi Spur\nAbbottchester, NE 83504-6442','etud_daryl89',NULL,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(2,7,'Harris','Dejah','johns.nora@example.com','878.708.1456','1995-08-20','46657 Schaefer Estates\nNorth Bethelborough, UT 62296-1030','etud_treynolds',NULL,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(3,6,'Bernier','Jaunita','qherzog@example.com','352.300.5090','2007-01-11','849 Sasha Vista\nHeidenreichport, DC 92982','etud_sjaskolski',NULL,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(4,5,'Funk','Ansel','karolann93@example.org','754.805.2203',NULL,'3036 Cremin Trace\nAnnalisefort, AR 83947','etud_helga.graham',NULL,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(5,4,'Gerlach','Ferne','cornell44@example.org','+1-941-490-5659','1996-08-20','7314 Madison Rapid Suite 347\nNorth Rhett, WY 44752','etud_iheller','https://via.placeholder.com/200x200.png/00ffbb?text=people+corporis','2025-07-27 23:35:58','2025-07-27 23:35:58'),(6,3,'Ondricka','Elbert','forest96@example.com','754-907-8700','2004-04-17','3996 O\'Conner Path Suite 803\nStrackechester, MI 11217','etud_lilyan.sanford','https://via.placeholder.com/200x200.png/00ffdd?text=people+vel','2025-07-27 23:35:58','2025-07-27 23:35:58'),(7,2,'Schulist','Stephan','huel.hellen@example.net','606-842-0430','2023-10-05','937 Koepp Heights Suite 115\nCorwinstad, AZ 15355','etud_reese.walter','https://via.placeholder.com/200x200.png/0077aa?text=people+vitae','2025-07-27 23:35:58','2025-07-27 23:35:58'),(8,8,'Faye','Modou','modou855@gmail.com','1-820-278-4082','1979-11-18','3507 Considine Neck\nHaleyborough, MT 86419-7512','Modou','https://via.placeholder.com/200x200.png/008822?text=people+velit','2025-07-27 23:35:58','2025-07-27 23:35:58'),(31,1,'Admin','Ecole','admin@ecole.edu',NULL,NULL,NULL,'admin.ecole',NULL,'2025-07-27 23:35:59','2025-07-27 23:35:59'),(33,11,'Diouf','Amina','amina@gmail.com','774445566','1992-01-11','Dakar Ouest Foire','amigallas','photos/f4K1nreEr8giHrcWkuxBztUz7fw7FFB3GgQYYaNk.jpg','2025-08-11 20:43:02','2025-08-11 20:43:02'),(34,13,'Fall','Djibril','djibi@gmail.com','771112233','2006-10-18','Thies Diakhao','djiby dit Moustapha','photos/7mH70Wx4HDmY8OmOofA6keYrcmsELxMb0jKHUgCT.png','2025-08-11 21:08:31','2025-08-11 21:08:31'),(35,14,'Ndiaye','Madiagne','madiagne@gmail.com','771222268','1996-06-09','Diakhao Thially Thies','Madiagne','photos/BwsZJUuFkzurmPKlU1EQhulXT0opPYSND7xfwGKU.png','2025-08-13 10:44:02','2025-08-13 10:44:02'),(36,15,'MBENGUE','Mame Dior','mbenguemamedior9@gmail.com','778552619','1994-03-11','Bargny Guedj','Diodio','photos/savc1WWZNWPefSeZysl8kqutxSRvcfsM6Rgf4QoR.jpg','2025-08-13 12:48:44','2025-08-13 12:48:44'),(37,16,'MBACKE','Mouhamed El Bachir','bachir@gmail.com','784108868','1990-05-15','Thies Diakhao','Bachir','photos/rR1bPlrtJLCLXb39JVxpwTTvsVDBcuOXgOvB3OVr.jpg','2025-08-13 14:09:59','2025-08-13 14:09:59'),(38,18,'Ndiaye','Mouhamed','mikey@gmail.com','770001122','2000-10-30','Thies Park mbame','mikeyndiaye','photos/xzLprzDIZH4BSZOnaTn1yQPA8uFBrCdBCaBjo9th.jpg','2025-08-15 18:27:29','2025-08-15 18:27:29'),(39,21,'Ndiaye','Ousmane','oussou@gmail.com','771002267','1999-05-05','Cite des eaux','Ouz','photos/FMiey4mhnsaaJffygi7D8ilm8PHm9EzTxgUaH1HV.jpg','2025-08-17 13:20:16','2025-08-17 13:20:16'),(40,22,'MBACKE','Aicha','mbackeaicha03@gmail.com','775556677','2002-12-01','K Massar Station','Aicha','photos/jHBmbpWrTgUqhk7OGsQteqoNOAQ8IkRYpghxL4gc.png','2025-08-17 14:16:45','2025-08-17 14:16:45'),(41,23,'Mbacke','Sata','mbackeaicha859@gmail.com','771113355','2003-12-01','Hann Mariste Villa S/49','aicha1','photos/pq15KyA4VTjbT9vj6PClt9hYaY93X9ZrXCkzej7Y.jpg','2025-08-17 15:15:40','2025-08-17 15:15:40'),(42,25,'Diagne','Adja','adja@gmail.com','774445566','2001-06-12','Diakhao Thies','Adja','photos/W9VCAduzLqd7kqiUiZGtRzqPFJw3n5Dhm7UDwTUI.png','2025-09-07 22:13:10','2025-09-07 22:13:10'),(43,26,'Sine','Moulaye','moulaye@gmail.com','775556677','1988-10-26','Diakhao Kanda Thies','moulaye','photos/6g4n3CJ3gX64bM9rFUt4ybcHWwqPTcc89C1ACrJY.png','2025-09-07 22:17:20','2025-09-07 22:17:20'),(44,27,'Sarr','Mor Sow','morsow@gmail.com','776667788','1986-10-19','Sofraco Thies','Morsow','photos/GEW9gWyvxUQdQNqRpEXauISPeU5F5pOGCaGdbi4I.jpg','2025-09-07 23:02:27','2025-09-07 23:02:27');
/*!40000 ALTER TABLE `personnes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Z1NJjAyFKH11qSvwNhtXBf7IQegTAdgLxp2aKjxF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUVlY2NBbDhWZDdkbGNaWWpadmJQaWxjMWhSUWdyZkV4elNPSnM3ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=',1757454505);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('etudiant','admin','comptable') NOT NULL DEFAULT 'etudiant',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin System','admin@ecole.edu','etudiant',NULL,'$2y$12$des0RJ6jATQ6z2WusIXccOaFmWTRXOJhEMHg/rzCbLJSMyA0yXqRG',NULL,'2025-07-27 23:35:58','2025-07-27 23:35:58'),(2,'Test User','test@example.com','etudiant',NULL,'$2y$12$ciS/eHnrvGXljvPz/deuju.x1bsPZ2VQE3P4g31kFRcZPy87zw0ia',NULL,'2025-07-27 23:36:00','2025-07-27 23:36:00'),(3,'admin','admin@gmail.com','etudiant',NULL,'$2y$12$qL/nxUJTBeJrMBnQ2d/tle8Ls7XCfhFP9T3.NSgQR2erBmmLz6wWm',NULL,'2025-07-29 09:29:56','2025-07-29 09:29:56'),(4,'Admin','admin123@gmail.com','admin',NULL,'$2y$12$jWMAtjBVCSa/Y1BtryOOyelz3KEs6I8t9tdW38kf8/5FR8PcW/SNy',NULL,'2025-08-01 23:33:33','2025-08-01 23:33:33'),(5,'Thierno Adama Mbacke','thieradam86@yahoo.fr','admin',NULL,'$2y$12$p.ZAeg3OuPJH9vWz.HC3je7IFfp.cKI7DrwWgdp1armW.UyPJ5mJ6',NULL,'2025-08-02 20:39:48','2025-08-02 20:39:48'),(6,'Mouhamed Rassoul Mbacke','rassoul@gmail.com','etudiant',NULL,'$2y$12$pQwZg5i0wCzIybQTpYp/IOZUHvPun.ZIb6sakGZCyMXqPwnE78sVG',NULL,'2025-08-06 12:32:59','2025-08-06 12:32:59'),(7,'Demba Ka','demba@gmail.com','etudiant',NULL,'$2y$12$nbpmC4J2vb4QFe8O1tftqu3.BSsn8cheg/U5EUaoWJX52YXMG6WH2',NULL,'2025-08-06 12:39:11','2025-08-06 12:39:11'),(8,'Modou Faye','modou855@gmail.com','etudiant',NULL,'$2y$12$.FwTrQfqzTOfLoMDPut7kusFvsdJGSiJmS1tcp5hmRlLtxviAfqWe',NULL,'2025-08-08 10:05:44','2025-08-08 10:05:44'),(9,'Mamour Diallo','mamour@gmail.com','comptable',NULL,'$2y$12$qmz2FeQyv1z1mpUu.DW5p.FK/oBhOTYvCL4IT4xPMUfPZdJ/Kym5.',NULL,'2025-08-08 17:42:14','2025-08-08 17:42:14'),(10,'Abdoulaye','faylay@gmail.com','admin',NULL,'$2y$12$4/LedBJBk9DxzIUgyvFwOuT5NM5xXKJ9doUAg9WhgzcJPfpqSDEo2',NULL,'2025-08-10 16:42:11','2025-08-10 16:42:11'),(11,'Diouf Amina','amina@gmail.com','comptable',NULL,'$2y$12$71..g9mZ/sCAqD7eFtuErucwXRnNXxsZNiqENtg5OW4yXxmuwffBK',NULL,'2025-08-11 20:43:00','2025-08-11 20:43:00'),(12,'Fall Djibril','djiby@gmail.com','etudiant',NULL,'$2y$12$dkzciGd7ieD5mRfX65Vxrezpy.BnIxw8CxgoQjqUFThSAf8DRDkYa',NULL,'2025-08-11 21:01:17','2025-08-11 21:01:17'),(13,'Fall Djibril','djibi@gmail.com','etudiant',NULL,'$2y$12$YpY7efnQetKoQCowlw.8N.jlwIPeVnONvx5VFzvM/85I8WLNpvz/G',NULL,'2025-08-11 21:08:31','2025-08-11 21:08:31'),(14,'Ndiaye Madiagne','madiagne@gmail.com','etudiant',NULL,'$2y$12$PZLY2QcQdSXgf7MuMFKJfOkJszZLXCsVKvscc/SJYMll6I4/gjczG',NULL,'2025-08-13 10:44:00','2025-08-13 10:44:00'),(15,'MBENGUE Mame Dior','mbenguemamedior9@gmail.com','etudiant',NULL,'$2y$12$g18F0.s555wMLrGdPpzwseyHtaJdCHhqfP.ACBq7tMuI5HI3FC8GW',NULL,'2025-08-13 12:48:44','2025-09-04 17:12:10'),(16,'MBACKE Mouhamed El Bachir','bachir@gmail.com','admin',NULL,'$2y$12$3YG8dq7iETgtafuA3MoCeucE08svg9d.zYLhU0rV0oSU2MatDEmEC',NULL,'2025-08-13 14:09:59','2025-08-19 22:13:42'),(17,'Mouhamed Ndiaye','ndiayemouhamed@gmail.com','etudiant',NULL,'$2y$12$A5AyJvrFMgZMBl4RQfdYEeVG.BUDLMojx3fimB8wWTRKXdUyLBhmW',NULL,'2025-08-15 18:05:37','2025-08-15 18:05:37'),(18,'Ndiaye Mouhamed','mikey@gmail.com','etudiant',NULL,'$2y$12$derr0aIK4Vn4WABp/hfjOOyUNzeCOUxWTn1KFRKjK8Zbb7NcwE.ja',NULL,'2025-08-15 18:27:26','2025-08-15 18:27:26'),(20,'Aissata Balla Mbacke','sata@gmail.com','admin',NULL,'$2y$12$Yddm9WYIIoX38IkIVcxhoeNuyxSvpF2kjlYz4jSlX6kNidop8ZsMa',NULL,'2025-08-17 13:07:35','2025-08-17 13:07:35'),(21,'Ndiaye Ousmane','oussou@gmail.com','etudiant',NULL,'$2y$12$wGZPsf7mT2Zntc6PqHbdXe7z30OAN/8xqVLs9bfIfz3t1BOnp5.j2',NULL,'2025-08-17 13:20:15','2025-08-17 13:20:15'),(22,'MBACKE Aicha','mbackeaicha03@gmail.com','etudiant',NULL,'$2y$12$piIdhL0ylPhJSegiTwa20.nYMf/ArDGm/KoAIDWjYO68iZy6As5re',NULL,'2025-08-17 14:16:43','2025-08-17 14:16:43'),(23,'Mbacke Sata','mbackeaicha859@gmail.com','etudiant',NULL,'$2y$12$klhxi/8fj0k56FH0iytJhei19w4TByriMVNmBGAlznEQ2Xb56Ho.a',NULL,'2025-08-17 15:15:40','2025-08-17 15:15:40'),(25,'Diagne Adja','adja@gmail.com','etudiant',NULL,'$2y$12$2iuo1JHv7FI8f0EdUFKppOhA84UCPeY.vJTCD9aCPrp/7SFQSrYpa',NULL,'2025-09-07 22:13:08','2025-09-07 23:04:29'),(26,'Sine Moulaye','moulaye@gmail.com','comptable',NULL,'$2y$12$Ldaphapj1tE6poxEBPwIc.TcaZA3Wa9RvzLNdhUrqJDxUFPF6YOtW',NULL,'2025-09-07 22:17:20','2025-09-07 22:17:20'),(27,'Sarr Mor Sow','morsow@gmail.com','comptable',NULL,'$2y$12$rHp2WiIVtick2.OQRAc/3.CgArkZ/BxL6GPLITOHnKVSet3O.HTMa',NULL,'2025-09-07 23:02:27','2025-09-07 23:02:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-10 19:34:31
