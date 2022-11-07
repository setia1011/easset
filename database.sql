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

-- Dumping structure for table db_easset.aset
CREATE TABLE IF NOT EXISTS `aset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` int(11) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `uraian` text,
  `kondisi` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `satuan` int(11) DEFAULT NULL,
  `creator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `editor` int(11) DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('available','not available') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset: ~7 rows (approximately)
DELETE FROM `aset`;
INSERT INTO `aset` (`id`, `jenis`, `merk`, `nama`, `uraian`, `kondisi`, `foto`, `jumlah`, `satuan`, `creator`, `created_at`, `editor`, `edited_at`, `status`) VALUES
	(1, 2, 'KK', 'Kursi', 'Kursi kayu dari jepara', 7, '1667277849_33b29f513d5252d103ff.jpg', 12, 3, 1, '2022-10-07 22:41:27', NULL, '2022-11-01 04:44:10', 'available'),
	(2, 2, 'KK', 'Kursi', 'Kursi kayu dari jepara', 7, '1665182491_bea6eab29aa0ec28e6ba.jpg', 12, 3, 1, '2022-10-07 22:41:31', NULL, NULL, 'available'),
	(3, 2, 'KK', 'Kursi', 'Kursi kayu dari jepara', 7, '1667295638_df094fab18f1c60ef08d.jpg', 0, 3, 1, '2022-10-07 22:41:35', NULL, '2022-11-01 09:40:38', 'available'),
	(4, 2, 'Mejo', 'Meja', 'Meja kayu jati', 1, '1665182903_c593d2f3aaeabe1eb5c2.jpg', 100, 2, 1, '2022-10-07 22:48:24', NULL, NULL, 'available'),
	(5, 1, 'Pilot', 'Pensil', 'Pensil Hitam', 1, '1665183103_034ce8cb8d409bd6b292.jpg', 100, 1, 1, '2022-10-07 22:51:43', NULL, NULL, 'available'),
	(6, 1, 'Pilot', 'Bolpoin', 'Bolpin Merah', 1, '1667792348_1769e21c3904c7a2d68f.png', 100, 1, 1, '2022-10-07 22:52:15', NULL, '2022-11-07 03:39:08', 'available'),
	(7, 1, 'Pilot', 'Bolpoin', 'Bolpin warna merah', 1, '1667792468_f528376e24344bc9d284.jpg', 100, 1, 1, '2022-10-07 23:10:13', NULL, '2022-11-07 03:41:08', 'not available');

-- Dumping structure for table db_easset.aset_book
CREATE TABLE IF NOT EXISTS `aset_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aset_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `status` enum('book','cancel','allocated','returned') DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_book: ~3 rows (approximately)
DELETE FROM `aset_book`;
INSERT INTO `aset_book` (`id`, `aset_id`, `qty`, `user`, `status`, `admin`, `created_at`, `updated_at`) VALUES
	(3, 2, 1, 1, 'book', NULL, '2022-11-07 08:28:57', NULL),
	(4, 1, 1, 1, 'book', NULL, '2022-11-07 08:29:02', NULL),
	(6, 6, 1, 1, 'book', NULL, '2022-11-07 08:32:12', NULL);

-- Dumping structure for table db_easset.aset_jenis
CREATE TABLE IF NOT EXISTS `aset_jenis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) DEFAULT NULL,
  `uraian` text,
  `creator` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `editor` int(11) DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('aktif','tidak aktif') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis` (`jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_jenis: ~3 rows (approximately)
DELETE FROM `aset_jenis`;
INSERT INTO `aset_jenis` (`id`, `jenis`, `uraian`, `creator`, `created_at`, `editor`, `edited_at`, `status`) VALUES
	(1, 'atk', 'atk', 1, '2022-09-29 03:15:59', 1, '2022-09-29 05:11:18', 'tidak aktif'),
	(2, 'furniture', 'furniture', 1, '2022-09-29 03:16:00', 1, '2022-09-29 05:11:42', 'tidak aktif'),
	(4, 'mobil', 'kendaraan roda empat', 1, '2022-09-29 03:16:01', 1, '2022-09-29 03:16:53', 'aktif');

-- Dumping structure for table db_easset.aset_kondisi
CREATE TABLE IF NOT EXISTS `aset_kondisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kondisi` varchar(50) DEFAULT NULL,
  `uraian` text,
  `creator` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `editor` int(11) DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('aktif','tidak aktif') DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `kondisi` (`kondisi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_kondisi: ~6 rows (approximately)
DELETE FROM `aset_kondisi`;
INSERT INTO `aset_kondisi` (`id`, `kondisi`, `uraian`, `creator`, `created_at`, `editor`, `edited_at`, `status`) VALUES
	(1, 'new', 'new', 1, '2022-09-29 07:51:39', 1, '2022-09-29 07:54:12', 'tidak aktif'),
	(3, 'used like new', 'used like new', 1, '2022-09-29 07:54:32', NULL, NULL, 'aktif'),
	(4, 'used very good', 'used very good', 1, '2022-09-29 07:55:33', NULL, NULL, 'aktif'),
	(5, 'used good', 'used good', 1, '2022-09-29 07:55:42', NULL, NULL, 'aktif'),
	(6, 'used acceptable', 'used acceptable', 1, '2022-09-29 07:55:54', 1, '2022-09-30 00:15:52', 'tidak aktif'),
	(7, 'renewed', 'renewed', 1, '2022-09-29 07:56:28', NULL, NULL, 'aktif');

-- Dumping structure for table db_easset.aset_satuan
CREATE TABLE IF NOT EXISTS `aset_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(50) DEFAULT NULL,
  `uraian` text,
  `creator` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `editor` int(11) DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('aktif','tidak aktif') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `satuan` (`satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.aset_satuan: ~3 rows (approximately)
DELETE FROM `aset_satuan`;
INSERT INTO `aset_satuan` (`id`, `satuan`, `uraian`, `creator`, `created_at`, `editor`, `edited_at`, `status`) VALUES
	(1, 'pce', 'piece', 1, NULL, 1, '2022-09-29 07:18:33', 'tidak aktif'),
	(2, 'unit', 'unit', 1, NULL, 1, '2022-09-29 07:18:33', 'aktif'),
	(3, 'tes', 'asas', 1, NULL, 1, '2022-09-29 07:18:02', 'aktif');

-- Dumping structure for table db_easset.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` enum('admin','user') DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `jenis_id` enum('nik','nip','nim','kta') DEFAULT NULL,
  `nomor_id` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('aktif','tidak aktif') DEFAULT 'tidak aktif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_easset.user: ~18 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `username`, `password`, `level`, `nama`, `email`, `jenis_id`, `nomor_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `status`) VALUES
	(1, 'setia', '$2y$10$LC/OwC3H1fy7TMl5EBAfuuVI0BOnaI1sAX0wP8EAoOKVIn4DO7R0m', 'admin', 'Setiadi H.', 'setiadi@techack.id', 'nim', '1119110187', 1, '2022-09-21 22:55:09', 1, '2022-09-23 13:40:51', 'aktif'),
	(2, 'anon', '$2y$10$LC/OwC3H1fy7TMl5EBAfuuVI0BOnaI1sAX0wP8EAoOKVIn4DO7R0m', 'user', 'Anon Name', 'anon@techack.id', 'nik', '1212121212121212', NULL, '2022-09-22 02:24:19', NULL, '2022-11-01 09:57:44', 'tidak aktif'),
	(4, 'wafi', '$2y$10$1/DLHlvYUHgOXO9zLzUrpuNlHJtQ1g9rXBC8Wvuz.67rhZ21vi0GS', 'user', 'Wafi D. El Fahmi', 'wafiduha@techack.id', 'nim', '1212121212', NULL, '2022-09-22 02:48:54', 1, '2022-11-01 09:59:47', 'aktif'),
	(6, 'gon', '123', 'admin', 'Gon Freecs', 'gonfreecs@gmail.com', 'nik', '12121212', NULL, '2022-09-22 03:28:24', NULL, NULL, 'aktif'),
	(9, 'selan', '1223', 'admin', 'Selan Lingam', 'selanlingam@gmail.com', 'kta', '1212121', NULL, '2022-09-22 03:32:34', NULL, NULL, 'aktif'),
	(16, 'alex', '$2y$10$J1jFkAmcl3dbOd3spAO/FOtvHH7Usl5rs/cuVi96cSm1WjeMq0qZC', 'user', 'Alexandrea Papandrae', 'alex@gmail.com', 'nip', '121212', NULL, '2022-09-22 03:42:35', NULL, '2022-11-01 09:58:31', 'aktif'),
	(17, 'fix', '1233', 'user', 'Fix D. Factor', 'fixfix@gmail.com', 'kta', '12121212', NULL, '2022-09-22 03:51:34', 1, '2022-09-24 10:37:01', 'tidak aktif'),
	(18, 'john', '123', 'user', 'John D. Door', 'johndoor@gmail.com', 'nip', '121212w', NULL, '2022-09-22 03:57:48', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(21, 'johnx', '123', 'user', 'John D. Door', 'johndoor@gmail.com', 'nip', '121212w', NULL, '2022-09-22 04:02:24', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(22, 'luffy', '1233', 'user', 'Luffy D. Monkey', 'luffy@gmail.com', 'nip', '121212', NULL, '2022-09-22 04:03:04', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(23, 'aji', '$2y$10$S15QKUhSoGNPtHKU1L.Xd.vuhBqIlyFF/y5zaRCJ8aThSiLszh0Hq', 'user', 'Aji Jumantara', 'ajijumantara@gmail.com', 'nip', '334234234', NULL, '2022-09-22 04:36:49', 1001, '2022-09-24 10:37:01', 'aktif'),
	(24, 'felix', '123', 'user', 'Felix Felix', 'felix@gmail.com', 'nim', '121454545', NULL, '2022-09-22 07:16:51', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(25, 'max', '123', 'user', 'Max M. MIlion', 'maxmile@gmail.com', 'nip', '12312321312', NULL, '2022-09-22 23:32:23', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(26, 'andre', '123', 'user', 'Andre F. Fahri', 'andree@gmail.com', 'nip', '12312321', NULL, '2022-09-22 23:34:26', 1, '2022-09-24 10:37:01', 'aktif'),
	(27, 'omar', '$2y$10$BxrZkQE8ey3IQQapbDENuOkVhJ9eDBhjQiVkprqNfBDkWWSP2KKrS', 'user', 'Omar Duha', 'omarduha@gmail.com', 'nik', '1212121', 16, '2022-09-23 02:21:50', NULL, '2022-09-24 10:37:01', 'tidak aktif'),
	(28, 'green', '$2y$10$vRRsABT6ND.GWIR2jo.jg.cIdknBAj2x4fNuqvM6Ft36pjipTWK.C', 'admin', 'Green D. Arrow', 'greenarrow@gmail.com', 'nim', '12345555', 1, '2022-09-23 03:38:11', 1, '2022-09-23 03:39:00', 'aktif'),
	(29, 'sanji', '$2y$10$QRSoFDkjHh/BQR8q2LAiXOxaHbGcQtQJ5X17QqnQmDAi1XHQNUI3y', 'user', 'Vinsmoke Sanji', 'sanji@vinsmoke.id', 'nik', '122222', 1, '2022-09-23 03:41:58', 1, '2022-09-24 10:37:01', 'aktif'),
	(30, 'thousands', '$2y$10$XX.p7tDkNBCl9CnHSWXpOex5Y6RD.T.7OjS/ICk3JZirqXl10gop2', 'user', 'Thousand Sunny', 'thousand@techack.id', 'nim', '12321312332', 1, '2022-09-23 13:39:51', 1, '2022-09-24 10:37:01', 'aktif');

-- Dumping structure for view db_easset.v_aset
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_aset` (
	`id` INT(11) NOT NULL,
	`jenis_id` INT(11) NULL,
	`jenis` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`merk` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`nama` VARCHAR(500) NULL COLLATE 'utf8mb4_general_ci',
	`uraian` TEXT NULL COLLATE 'utf8mb4_general_ci',
	`kondisi_id` INT(11) NULL,
	`kondisi` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`foto` VARCHAR(100) NULL COLLATE 'utf8mb4_general_ci',
	`jumlah` FLOAT NULL,
	`satuan_id` INT(11) NULL,
	`satuan` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`creator` INT(11) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`editor` INT(11) NULL,
	`edited_at` TIMESTAMP NULL,
	`status` ENUM('available','not available') NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_easset.v_book
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_book` (
	`id` INT(11) NOT NULL,
	`jenis_id` INT(11) NULL,
	`jenis` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`merk` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`nama` VARCHAR(500) NULL COLLATE 'utf8mb4_general_ci',
	`uraian` TEXT NULL COLLATE 'utf8mb4_general_ci',
	`kondisi_id` INT(11) NULL,
	`kondisi` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`foto` VARCHAR(100) NULL COLLATE 'utf8mb4_general_ci',
	`jumlah` FLOAT NULL,
	`satuan_id` INT(11) NULL,
	`satuan` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`creator` INT(11) NOT NULL,
	`created_at` TIMESTAMP NULL,
	`created_atx` VARCHAR(24) NULL COLLATE 'utf8mb4_general_ci',
	`editor` INT(11) NULL,
	`edited_at` TIMESTAMP NULL,
	`status` ENUM('available','not available') NULL COLLATE 'utf8mb4_general_ci',
	`book_qty` INT(11) NULL,
	`user` INT(11) NULL,
	`book_user` VARCHAR(50) NULL COLLATE 'utf8mb4_general_ci',
	`book_status` ENUM('book','cancel','allocated','returned') NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_easset.v_aset
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_aset`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_aset` AS SELECT 
	a.id,
	a.jenis jenis_id,
	b.jenis,
	a.merk,
	a.nama,
	a.uraian,
	a.kondisi kondisi_id,
	c.kondisi,
	a.foto,
	a.jumlah,
	a.satuan satuan_id,
	d.satuan,
	a.creator,
	a.created_at,
	a.editor,
	a.edited_at,
	a.`status` 
FROM aset a 
INNER JOIN aset_jenis b ON a.jenis = b.id
INNER JOIN aset_kondisi c ON a.kondisi = c.id
INNER JOIN aset_satuan d ON a.satuan = d.id ;

-- Dumping structure for view db_easset.v_book
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_book`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_book` AS SELECT 
	a.id, 
	a.jenis_id,
	a.jenis,
	a.merk,
	a.nama,
	a.uraian,
	a.kondisi_id,
	a.kondisi,
	a.foto,
	a.jumlah,
	a.satuan_id,
	a.satuan,
	a.creator,
	a.created_at,
	DATE_FORMAT(a.created_at, '%d/%m/%Y %H:%i:%s') created_atx,
	a.editor,
	a.edited_at,
	a.`status`,
	b.qty book_qty, 
	b.user,
	c.nama book_user,
	b.`status` book_status 
FROM v_aset a INNER JOIN aset_book b ON a.id = b.aset_id 
INNER JOIN user c ON b.user = c.id ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
