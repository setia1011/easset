-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_easset
CREATE DATABASE IF NOT EXISTS `db_easset` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_easset`;

-- Dumping structure for table db_easset.aset_detil
CREATE TABLE IF NOT EXISTS `aset_detil` (
  `id` int(11) DEFAULT NULL,
  `aset_id` int(11) DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `uraian` text,
  `jumlah` float DEFAULT NULL,
  `kondisi` enum('baru','bekas','baik','rusak') DEFAULT NULL,
  `satuan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_detil: ~0 rows (approximately)

-- Dumping structure for table db_easset.aset_header
CREATE TABLE IF NOT EXISTS `aset_header` (
  `id` int(11) DEFAULT NULL,
  `jenis` int(11) DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `uraian` text,
  `jumlah` float DEFAULT NULL,
  `satuan` int(11) DEFAULT NULL,
  `status` enum('ready','reserved','taken') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_header: ~0 rows (approximately)

-- Dumping structure for table db_easset.aset_jenis
CREATE TABLE IF NOT EXISTS `aset_jenis` (
  `id` int(11) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `uraian` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_jenis: ~0 rows (approximately)

-- Dumping structure for table db_easset.aset_satuan
CREATE TABLE IF NOT EXISTS `aset_satuan` (
  `id` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `uraian` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_satuan: ~0 rows (approximately)

-- Dumping structure for table db_easset.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `level` enum('admin','client') DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenis_id` enum('nik','nip','nim','kta') DEFAULT NULL,
  `nomor_id` varchar(50) DEFAULT NULL,
  `status` enum('aktif','tidak aktif') DEFAULT 'tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.user: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
