-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table kendaraan.bidangs
CREATE TABLE IF NOT EXISTS `bidangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bidang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.bidangs: ~4 rows (approximately)
DELETE FROM `bidangs`;
INSERT INTO `bidangs` (`id`, `nama_bidang`, `kode`, `created_at`, `updated_at`) VALUES
	(1, 'Sekretariat', 'Sekre', '2025-03-03 18:57:56', '2025-03-03 18:57:56'),
	(2, 'Bidang  Pengelolaan dan Layanan Kearsipan ', 'Arsip 1', '2025-03-03 18:59:34', '2025-03-03 18:59:34'),
	(3, 'Bidang  Pengembangan, Pembinaan dan Pengawasan Kearsipan ', 'Arsip 2', '2025-03-03 18:59:44', '2025-03-03 18:59:44'),
	(4, 'Bidang  Pengembangan dan Pengolahan Bahan Perpustakaan ', 'Perpus 1', '2025-03-03 18:59:57', '2025-03-03 18:59:57'),
	(5, 'Bidang   Pemberdayaan dan Layanan Perpustakaan', 'Perpus 2', '2025-03-03 19:00:07', '2025-03-03 19:00:07');

-- Dumping structure for table kendaraan.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.cache: ~0 rows (approximately)
DELETE FROM `cache`;

-- Dumping structure for table kendaraan.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table kendaraan.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table kendaraan.jabatans
CREATE TABLE IF NOT EXISTS `jabatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.jabatans: ~21 rows (approximately)
DELETE FROM `jabatans`;
INSERT INTO `jabatans` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
	(1, 'Kepala Dinas', '2025-03-03 19:00:18', '2025-03-03 19:00:18'),
	(2, 'Sekretaris Dinas', '2025-03-03 19:00:26', '2025-03-03 19:00:26'),
	(3, 'Subbagian Keuangan dan Barang Milik Daerah', '2025-03-03 19:00:38', '2025-03-03 19:00:38'),
	(4, 'Subbagian Umum dan Kepegawaian ', '2025-03-03 19:00:51', '2025-03-03 19:00:51'),
	(5, 'Subkoordinator Perencanaan dan Evaluasi', '2025-03-03 19:01:05', '2025-03-03 19:08:59'),
	(6, 'Kepala Bidang  Pengelolaan dan Layanan Kearsipan ', '2025-03-03 19:01:49', '2025-03-03 19:01:49'),
	(7, 'Kepala Bidang  Pengembangan, Pembinaan dan Pengawasan Kearsipan', '2025-03-03 19:02:03', '2025-03-03 19:02:03'),
	(8, 'Kepala Bidang  Pengembangan dan Pengolahan Bahan Perpustakaan ', '2025-03-03 19:02:45', '2025-03-03 19:02:45'),
	(9, 'Kepala Bidang   Pemberdayaan dan Layanan Perpustakaan', '2025-03-03 19:03:03', '2025-03-03 19:03:03'),
	(10, 'Subkoordinator  Pengelolaan Arsip Dinamis', '2025-03-03 19:04:08', '2025-03-03 19:04:08'),
	(11, 'Subkoordinator  Pengelolaan Arsip Statis', '2025-03-03 19:04:15', '2025-03-03 19:04:15'),
	(12, 'Subkoordinator  Layanan dan Pemanfaatan  Kerasipan', '2025-03-03 19:04:29', '2025-03-03 19:04:29'),
	(13, 'Subkoordinator Pengembangan dan Sistem Informasi', '2025-03-03 19:04:43', '2025-03-03 19:04:43'),
	(14, 'Subkoordinator  Pembinaan dan Kerja Sama  Kearsipan', '2025-03-03 19:04:54', '2025-03-03 19:04:54'),
	(15, 'Subkoordinator  Pengawasan Kearsipan', '2025-03-03 19:05:03', '2025-03-03 19:05:03'),
	(16, 'Subkoordinator  Akuisisi dan Deposit', '2025-03-03 19:05:12', '2025-03-03 19:05:12'),
	(17, 'Subkoordinator  Pemeliharaan, Preservasi dan  Konservasi', '2025-03-03 19:05:22', '2025-03-03 19:05:22'),
	(18, 'Subkoordinator  Otomasi dan Pengolahan Bahan Perpustakaan', '2025-03-03 19:05:56', '2025-03-03 19:05:56'),
	(19, 'Subkoordinator  Pemberdayaan dan Jejaring  Perpustakaan', '2025-03-03 19:06:10', '2025-03-03 19:06:10'),
	(20, 'Subkoordinator  Layanan Perpustakaan', '2025-03-03 19:06:24', '2025-03-03 19:06:24'),
	(21, 'Subkoordinator  Pembinaan Perpustakaan', '2025-03-03 19:06:34', '2025-03-03 19:06:34'),
	(22, 'KELOMPOK JABATAN FUNGSIONAL ', '2025-03-03 19:06:49', '2025-03-03 19:06:49');

-- Dumping structure for table kendaraan.jenis_kendaraans
CREATE TABLE IF NOT EXISTS `jenis_kendaraans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_roda` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.jenis_kendaraans: ~11 rows (approximately)
DELETE FROM `jenis_kendaraans`;
INSERT INTO `jenis_kendaraans` (`id`, `nama`, `jumlah_roda`, `created_at`, `updated_at`) VALUES
	(1, 'TOYOTA INOVA', 4, '2025-03-03 18:52:31', '2025-03-03 18:52:31'),
	(2, 'TOYOTA RUSH', 4, '2025-03-03 18:52:40', '2025-03-03 18:52:40'),
	(3, 'SUZUKI/ GC415V APV DLX', 4, '2025-03-03 18:52:47', '2025-03-03 18:52:47'),
	(4, 'DAIHATSU LUXIO', 4, '2025-03-03 18:52:53', '2025-03-03 18:52:53'),
	(5, 'TOYOTA HILUX PICK UP', 4, '2025-03-03 18:52:57', '2025-03-03 18:52:57'),
	(6, 'HONDA SUPRA X 125', 2, '2025-03-03 18:53:09', '2025-03-03 18:53:09'),
	(7, 'HONDA NF 125 TR', 2, '2025-03-03 18:53:14', '2025-03-03 18:53:14'),
	(8, 'HONDA REVO', 2, '2025-03-03 18:53:21', '2025-03-03 18:53:21'),
	(9, 'HONDA NF 11 BID M/T', 2, '2025-03-03 18:53:29', '2025-03-03 18:53:29'),
	(10, 'TOYOTA HILUX MERAH', 4, '2025-03-03 18:53:53', '2025-03-03 18:53:53'),
	(11, 'TOYOTA HILUX BIRU', 4, '2025-03-03 18:53:57', '2025-03-03 18:53:57'),
	(12, 'MITSUBISHI FUSO', 4, '2025-03-03 18:54:03', '2025-03-03 18:54:03'),
	(13, 'ISUZU', 4, '2025-03-03 18:54:07', '2025-03-03 18:54:07');

-- Dumping structure for table kendaraan.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table kendaraan.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table kendaraan.kategori_pengeluarans
CREATE TABLE IF NOT EXISTS `kategori_pengeluarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.kategori_pengeluarans: ~0 rows (approximately)
DELETE FROM `kategori_pengeluarans`;

-- Dumping structure for table kendaraan.kendaraans
CREATE TABLE IF NOT EXISTS `kendaraans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `merk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_nomor` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_mesin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_rangka` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pengadaan` year NOT NULL,
  `tahun` int DEFAULT NULL,
  `jenis_kendaraan_id` bigint unsigned NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jatah_liter_per_hari` int NOT NULL DEFAULT '1',
  `anggaran_tahunan` decimal(15,2) NOT NULL,
  `tanggal_pajak_tahunan` date DEFAULT NULL,
  `tanggal_stnk_habis` date DEFAULT NULL,
  `status` enum('Aktif','Dalam Perbaikan','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `pemegang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pengguna_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kendaraans_plat_nomor_unique` (`plat_nomor`),
  KEY `kendaraans_jenis_kendaraan_id_foreign` (`jenis_kendaraan_id`),
  KEY `kendaraans_pengguna_id_foreign` (`pengguna_id`),
  CONSTRAINT `kendaraans_jenis_kendaraan_id_foreign` FOREIGN KEY (`jenis_kendaraan_id`) REFERENCES `jenis_kendaraans` (`id`),
  CONSTRAINT `kendaraans_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `penggunas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.kendaraans: ~26 rows (approximately)
DELETE FROM `kendaraans`;
INSERT INTO `kendaraans` (`id`, `merk`, `model`, `plat_nomor`, `nomor_mesin`, `nomor_rangka`, `tahun_pengadaan`, `tahun`, `jenis_kendaraan_id`, `jenis`, `jatah_liter_per_hari`, `anggaran_tahunan`, `tanggal_pajak_tahunan`, `tanggal_stnk_habis`, `status`, `pemegang`, `created_at`, `updated_at`, `pengguna_id`) VALUES
	(1, 'Toyota', 'Innova', 'H 1676 XA', '0000000000', '0000000000', '2017', NULL, 1, NULL, 1, 39603603.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:36:29', '2025-03-03 19:36:29', 1),
	(2, 'Toyota', 'Rush', 'H 1626 IX', '0000000000', '0000000000', '2024', NULL, 2, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:38:07', '2025-03-03 19:38:07', 2),
	(3, 'Toyota', 'Rush', 'H 1675 XA', '0000000000', '0000000000', '2017', NULL, 2, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:41:44', '2025-03-03 19:41:44', 17),
	(4, 'Toyota', 'Rush', 'H 1678 XA', '0000000000', '0000000000', '2017', NULL, 2, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:42:46', '2025-03-03 19:42:46', 10),
	(5, 'Toyota', 'Rush', 'H 9504 BH', '0000000000', '0000000000', '2014', NULL, 2, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:43:39', '2025-03-03 19:43:39', 12),
	(6, 'Suzuki', 'APV', 'H 1578 XA', '0000000000', '0000000000', '2007', NULL, 3, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:45:11', '2025-03-03 19:45:11', 14),
	(7, 'Daihatsu', 'Luxio', 'H 1401 XA', '0000000000', '0000000000', '2011', NULL, 4, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:45:52', '2025-03-03 19:45:52', 5),
	(8, 'Toyota', 'Hilux', 'H 8643 XH', '0000000000', '0000000000', '2009', NULL, 5, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:46:52', '2025-03-03 19:46:52', 5),
	(9, 'Toyota', 'Innova', 'H 19 A', '0000000000', '0000000000', '2015', NULL, 1, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:47:26', '2025-03-03 19:47:26', 5),
	(10, 'Toyota', 'Hilux', 'H 8320 XA', '000000000', '000000000', '2011', NULL, 10, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:50:31', '2025-03-03 19:50:31', 17),
	(11, 'Toyota', 'Hilux', 'B 9018 PQW', '0000000000', '0000000000', '2018', NULL, 11, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:51:11', '2025-03-03 19:51:11', 17),
	(12, 'Mitsubishi', 'Fuso', 'H 9317 CA', '0000000000', '0000000000', '2018', NULL, 12, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:51:44', '2025-03-03 19:51:44', 17),
	(13, 'Isuzu', 'Isuzu', 'H 7102 XA', '0000000000', '0000000000', '2007', NULL, 13, NULL, 1, 34432432.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:52:26', '2025-03-03 19:52:26', 17),
	(14, 'Honda', 'Supra x 125', 'H 6973 XF', '0000000000', '0000000000', '2017', NULL, 6, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:54:48', '2025-03-03 19:56:36', 11),
	(15, 'Honda', 'Supra X 125', 'H 6989 XF', '0000000000', '0000000000', '2017', NULL, 6, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:56:22', '2025-03-03 19:56:22', 3),
	(16, 'Honda', 'Supra x 125', 'H 6726 XH', '0000000000', '0000000000', '2017', NULL, 6, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 19:57:14', '2025-03-03 19:57:14', 5),
	(17, 'Honda', 'Supra x 125', 'H 6988 XF', '0000000000', '0000000000', '2017', NULL, 6, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:04:42', '2025-03-03 20:04:42', 19),
	(18, 'Honda', 'Supra x 125', 'H 6982 XF', '0000000000', '0000000000', '2017', NULL, 6, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:05:33', '2025-03-03 20:05:33', 7),
	(19, 'Honda', 'NF 125 TR', 'H 6522 XF', '0000000000', '0000000000', '2011', NULL, 7, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:06:23', '2025-03-03 20:06:23', 6),
	(20, 'Honda', 'Revo', 'H 6088 XA', '0000000000', '0000000000', '2010', NULL, 8, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:06:55', '2025-03-03 20:06:55', 18),
	(21, 'Honda', 'NF 125 TR', 'H 6180 XF', '0000000000', '0000000000', '2011', NULL, 7, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:07:41', '2025-03-03 20:07:41', 8),
	(22, 'Honda', 'NF 11 BID M/T', 'H 6830 XH', '0000000000', '0000000000', '2009', NULL, 9, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:08:41', '2025-03-03 20:08:41', 9),
	(23, 'Honda', ' NF 125 TR', 'H 6179 XF', '0000000000', '0000000000', '2011', NULL, 7, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:09:15', '2025-03-03 20:10:02', 4),
	(24, 'Honda', 'NF 11 BID M/T', 'H 6087 XA', '0000000000', '0000000000', '2010', NULL, 9, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:09:52', '2025-03-03 20:09:52', 15),
	(25, 'Honda', 'NF 125 TR', 'H 6941 XH', '0000000000', '0000000000', '2011', NULL, 7, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:10:49', '2025-03-03 20:10:49', 16),
	(26, 'Honda', 'NF 125 TR', 'H 6521 XF', '0000000000', '0000000000', '2011', NULL, 7, NULL, 1, 4747747.00, NULL, NULL, 'Aktif', NULL, '2025-03-03 20:12:25', '2025-03-03 20:12:25', 13);

-- Dumping structure for table kendaraan.log_aktivitas
CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `pengguna_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `kilometer_awal` int DEFAULT NULL,
  `kilometer_akhir` int DEFAULT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_kendaraan_id_foreign` (`kendaraan_id`),
  KEY `log_aktivitas_pengguna_id_foreign` (`pengguna_id`),
  CONSTRAINT `log_aktivitas_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`),
  CONSTRAINT `log_aktivitas_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `penggunas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.log_aktivitas: ~0 rows (approximately)
DELETE FROM `log_aktivitas`;

-- Dumping structure for table kendaraan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.migrations: ~19 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_02_26_062429_create_jenis_kendaraans_table', 1),
	(5, '2025_02_26_062707_create_bidangs_table', 1),
	(6, '2025_02_26_062910_create_jabatans_table', 1),
	(7, '2025_02_26_063314_create_penggunas_table', 1),
	(8, '2025_02_26_063545_create_kendaraans_table', 1),
	(9, '2025_02_26_063918_create_kategori_pengeluarans_table', 1),
	(10, '2025_02_26_063941_create_pengeluarans_table', 1),
	(11, '2025_02_26_064044_create_penugasan_kendaraans_table', 1),
	(12, '2025_02_26_064117_create_servis_kendaraans_table', 1),
	(13, '2025_02_26_064143_create_pembayaran_stnks_table', 1),
	(14, '2025_02_26_064218_create_pembelian_table', 1),
	(15, '2025_02_26_064240_create_log_aktivitas_table', 1),
	(16, '2025_03_03_063134_add_pengguna_id_to_kendaraans_table', 1),
	(17, '2025_03_03_073548_add_fields_to_kendaraans_table', 1),
	(18, '2025_03_04_012449_add_columns_to_pembelian_bensins', 1),
	(19, '2025_03_04_064154_create_pembelian_bensins_table', 2),
	(20, '2025_03_04_065614_add_jatah_liter_to_kendaraans_table', 3),
	(21, '2025_03_04_102802_update_jumlah_harga_nullable_in_pembelian_bensins', 4);

-- Dumping structure for table kendaraan.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table kendaraan.pembayaran_stnks
CREATE TABLE IF NOT EXISTS `pembayaran_stnks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `biaya` decimal(15,2) NOT NULL,
  `berlaku_hingga` date NOT NULL,
  `pengeluaran_id` bigint unsigned DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_stnks_kendaraan_id_foreign` (`kendaraan_id`),
  KEY `pembayaran_stnks_pengeluaran_id_foreign` (`pengeluaran_id`),
  CONSTRAINT `pembayaran_stnks_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`),
  CONSTRAINT `pembayaran_stnks_pengeluaran_id_foreign` FOREIGN KEY (`pengeluaran_id`) REFERENCES `pengeluarans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.pembayaran_stnks: ~0 rows (approximately)
DELETE FROM `pembayaran_stnks`;

-- Dumping structure for table kendaraan.pembelian_bensins
CREATE TABLE IF NOT EXISTS `pembelian_bensins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `tanggal_beli` date DEFAULT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `jatah_liter_per_hari` decimal(10,2) DEFAULT NULL,
  `jatah_liter_per_bulan` decimal(10,2) DEFAULT NULL,
  `jenis_bbm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_liter` decimal(10,2) DEFAULT NULL,
  `harga_per_liter` decimal(10,2) DEFAULT NULL,
  `jumlah_harga` decimal(15,2) DEFAULT NULL,
  `kilometer_kendaraan` int DEFAULT NULL,
  `pengeluaran_id` bigint unsigned DEFAULT NULL,
  `pengguna_id` bigint unsigned DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_bensins_kendaraan_id_foreign` (`kendaraan_id`),
  KEY `pembelian_bensins_pengeluaran_id_foreign` (`pengeluaran_id`),
  KEY `pembelian_bensins_pengguna_id_foreign` (`pengguna_id`),
  CONSTRAINT `pembelian_bensins_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`),
  CONSTRAINT `pembelian_bensins_pengeluaran_id_foreign` FOREIGN KEY (`pengeluaran_id`) REFERENCES `pengeluarans` (`id`),
  CONSTRAINT `pembelian_bensins_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `penggunas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.pembelian_bensins: ~1 rows (approximately)
DELETE FROM `pembelian_bensins`;

-- Dumping structure for table kendaraan.pengeluarans
CREATE TABLE IF NOT EXISTS `pengeluarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `kategori_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengeluarans_kendaraan_id_foreign` (`kendaraan_id`),
  KEY `pengeluarans_kategori_id_foreign` (`kategori_id`),
  KEY `pengeluarans_created_by_foreign` (`created_by`),
  CONSTRAINT `pengeluarans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `penggunas` (`id`),
  CONSTRAINT `pengeluarans_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pengeluarans` (`id`),
  CONSTRAINT `pengeluarans_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.pengeluarans: ~0 rows (approximately)
DELETE FROM `pengeluarans`;

-- Dumping structure for table kendaraan.penggunas
CREATE TABLE IF NOT EXISTS `penggunas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint unsigned NOT NULL,
  `bidang_id` bigint unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penggunas_jabatan_id_foreign` (`jabatan_id`),
  KEY `penggunas_bidang_id_foreign` (`bidang_id`),
  CONSTRAINT `penggunas_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`),
  CONSTRAINT `penggunas_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.penggunas: ~19 rows (approximately)
DELETE FROM `penggunas`;
INSERT INTO `penggunas` (`id`, `nama`, `nip`, `jabatan_id`, `bidang_id`, `email`, `no_telp`, `created_at`, `updated_at`) VALUES
	(1, 'FX Bambang Suranggono, S.Sos', '196604271986031005', 1, 1, NULL, NULL, '2025-03-03 19:07:19', '2025-03-03 19:07:19'),
	(2, 'Dr. Muhammad Ahsan, S.Ag,M.Kom', '197412241999031002', 2, 1, NULL, NULL, '2025-03-03 19:07:39', '2025-03-03 19:07:39'),
	(3, 'Reza Noordian, SE, MM', '198110152010011014', 5, 1, NULL, NULL, '2025-03-03 19:11:06', '2025-03-03 19:11:06'),
	(4, 'Ida Variana, S.E', '196909082002122002', 3, 1, NULL, NULL, '2025-03-03 19:11:25', '2025-03-03 19:11:25'),
	(5, 'Asilah, SE', '197805242010012001', 4, 1, NULL, NULL, '2025-03-03 19:11:40', '2025-03-03 19:11:40'),
	(6, 'Riyani, A.Md', '198001062011012007', 22, 1, NULL, NULL, '2025-03-03 19:11:59', '2025-03-03 19:11:59'),
	(7, 'Eka Yulianti', '198404222006042009', 22, 1, NULL, NULL, '2025-03-03 19:13:24', '2025-03-03 19:13:24'),
	(8, 'Kistina Arumsari,A.Md', '198501112019022003', 22, 1, NULL, NULL, '2025-03-03 19:13:39', '2025-03-03 19:13:39'),
	(9, 'Sardjijanto', '196803292009011001', 22, 1, NULL, NULL, '2025-03-03 19:13:54', '2025-03-03 19:13:54'),
	(10, 'Nanie Widyanti, SE', '197005211996032001', 6, 2, NULL, NULL, '2025-03-03 19:14:14', '2025-03-03 19:14:14'),
	(11, 'Yetty Nur Indriati, S.Sos ', '196801111989032012', 10, 2, NULL, NULL, '2025-03-03 19:14:57', '2025-03-03 19:14:57'),
	(12, 'Laily Widyaningtyas, S.Sos, M.Si', '196810031990032004', 7, 3, NULL, NULL, '2025-03-03 19:15:45', '2025-03-03 19:15:45'),
	(13, 'Afif Choirul Falah, A.Md', '199212232019021002', 22, 3, NULL, NULL, '2025-03-03 19:16:09', '2025-03-03 19:16:09'),
	(14, 'Titik Suharni, SH, M.Si', '196902251997032004', 8, 4, NULL, NULL, '2025-03-03 19:16:36', '2025-03-03 19:16:36'),
	(15, 'Sapto Nugroho, SE', '197202011992031006', 16, 4, NULL, NULL, '2025-03-03 19:21:31', '2025-03-03 19:21:31'),
	(16, 'Ira Fajar Putri, SH, MM', '198206082010012001', 18, 4, NULL, NULL, '2025-03-03 19:21:51', '2025-03-03 19:21:51'),
	(17, 'Yuni Sailawati, S.KM', '197106011994032004', 9, 5, NULL, NULL, '2025-03-03 19:24:52', '2025-03-03 19:24:52'),
	(18, 'Yudiani, S.Sos', '197303211997032012', 21, 5, NULL, NULL, '2025-03-03 19:25:23', '2025-03-03 20:02:52'),
	(19, 'Eni Kurniawati, SE', '197503151994032001', 19, 5, NULL, NULL, '2025-03-03 20:01:26', '2025-03-03 20:01:26');

-- Dumping structure for table kendaraan.penugasan_kendaraans
CREATE TABLE IF NOT EXISTS `penugasan_kendaraans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `pengguna_id` bigint unsigned NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penugasan_kendaraans_kendaraan_id_foreign` (`kendaraan_id`),
  KEY `penugasan_kendaraans_pengguna_id_foreign` (`pengguna_id`),
  CONSTRAINT `penugasan_kendaraans_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`),
  CONSTRAINT `penugasan_kendaraans_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `penggunas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.penugasan_kendaraans: ~0 rows (approximately)
DELETE FROM `penugasan_kendaraans`;

-- Dumping structure for table kendaraan.servis_kendaraans
CREATE TABLE IF NOT EXISTS `servis_kendaraans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint unsigned NOT NULL,
  `tanggal_servis` date NOT NULL,
  `jenis_servis` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kilometer_kendaraan` int DEFAULT NULL,
  `bengkel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `pengeluaran_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servis_kendaraans_pengeluaran_id_foreign` (`pengeluaran_id`),
  KEY `servis_kendaraans_kendaraan_id_foreign` (`kendaraan_id`),
  CONSTRAINT `servis_kendaraans_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`),
  CONSTRAINT `servis_kendaraans_pengeluaran_id_foreign` FOREIGN KEY (`pengeluaran_id`) REFERENCES `pengeluarans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.servis_kendaraans: ~0 rows (approximately)
DELETE FROM `servis_kendaraans`;
INSERT INTO `servis_kendaraans` (`id`, `kendaraan_id`, `tanggal_servis`, `jenis_servis`, `kilometer_kendaraan`, `bengkel`, `biaya`, `keterangan`, `pengeluaran_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2025-01-30', 'Lorem Ipsum Dolor Sit Amet', 11230, 'Saudara Motor', 2300000.00, NULL, NULL, '2025-03-03 23:02:09', '2025-03-03 23:02:09');

-- Dumping structure for table kendaraan.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('7MVvtMpOM71KCPRbcGDAnAp2nWSUMNIgfN0COvTc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiN1FHcWgybURDYkoxWFlqaGtkQzRwZGZ2WFhuNGdxdWp4VmN6SDNlUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRpMWYzMVQ3MEh6WGg1bXRlbHltVk9lNlc1VFZoeXVlOVhVbWhYckl3V25jYWhXSGtZUjhtcSI7czoxNzoiZGFzaGJvYXJkX2ZpbHRlcnMiO2E6MTp7czo1OiJidWxhbiI7czo3OiIyMDI1LTAxIjt9fQ==', 1741226589),
	('CrIWRPtwnfBvdR2iwP2xxDEs5k89Yr1sRM31TkUd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1J1dGZ5NVNaQXJlZkZUUndQOVFkdVlPdjRDbkZmZmRDek5NQ2JGRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly9lYWM4LTEwMy0xMDEtNTItMTg1Lm5ncm9rLWZyZWUuYXBwL2FkbWluL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovL2VhYzgtMTAzLTEwMS01Mi0xODUubmdyb2stZnJlZS5hcHAvYWRtaW4iO319', 1741225893),
	('d0mp4SIaa6NKOFooXC2dPJ0Al5YdlQHfrWO8Fl9d', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUU9ET2xaWmpicnlQVzdtWDl2Zm5acFhVWFk2d2dBTlNscHVmN3d1RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8zNWY1LTEwMy0xMDEtNTItMTg1Lm5ncm9rLWZyZWUuYXBwL2FkbWluL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovLzM1ZjUtMTAzLTEwMS01Mi0xODUubmdyb2stZnJlZS5hcHAvYWRtaW4iO319', 1741224207),
	('Lh24d0l1K49UivNgtJMhbvqbNaZTPI6e33QgfFjX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVVVRZWpBSHhkc2V5bHd4SWplbEQyUjIySkxsUXRRcW9pVGNWSE1UaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xYTNiLTEwMy0xMDEtNTItMTg1Lm5ncm9rLWZyZWUuYXBwL2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRpMWYzMVQ3MEh6WGg1bXRlbHltVk9lNlc1VFZoeXVlOVhVbWhYckl3V25jYWhXSGtZUjhtcSI7fQ==', 1741223683);

-- Dumping structure for table kendaraan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kendaraan.users: ~0 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@semarangkota.go.id', NULL, '$2y$12$i1f31T70HzXh5mtelymVOe6W5TVhyue9XUmhXrIwWncahWHkYR8mq', '86ejaZac9KlHzlKgArxNyeySlMwaMTuPCOM1Cq0oEoEfViS6yvwXrwg74nEY', '2025-03-03 18:36:51', '2025-03-03 18:36:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
