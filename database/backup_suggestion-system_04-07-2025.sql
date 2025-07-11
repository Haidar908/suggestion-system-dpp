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


-- Dumping database structure for suggestion_system_dpp
CREATE DATABASE IF NOT EXISTS `suggestion_system_dpp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `suggestion_system_dpp`;

-- Dumping structure for table suggestion_system_dpp.access_codes
CREATE TABLE IF NOT EXISTS `access_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_codes_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.access_codes: ~0 rows (approximately)
INSERT INTO `access_codes` (`id`, `code`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Dpplast01', NULL, 1, '2025-07-10 18:55:34', '2025-07-10 19:02:03'),
	(2, '123456', NULL, 0, '2025-07-10 19:07:55', '2025-07-10 19:07:55');

-- Dumping structure for table suggestion_system_dpp.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.cache: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.cache_locks: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_nama_departemen_unique` (`nama_departemen`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.departments: ~12 rows (approximately)
INSERT INTO `departments` (`id`, `nama_departemen`, `created_at`, `updated_at`) VALUES
	(1, 'PPIC', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(2, 'Produksi Injeksi', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(3, 'Produksi Painting', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(4, 'Engineering', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(5, 'Material Engineering & Painting', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(6, 'Maintenance', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(7, 'Double Seat', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(8, 'Quality', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(9, 'Marketing', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(10, 'Purchasing & Vendor Management', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(11, 'HRD & IT', '2025-07-06 22:57:46', '2025-07-06 22:57:46'),
	(12, 'MR, MDEM, GA & IR', '2025-07-06 22:57:46', '2025-07-06 22:57:46');

-- Dumping structure for table suggestion_system_dpp.failed_jobs
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

-- Dumping data for table suggestion_system_dpp.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.jobs
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

-- Dumping data for table suggestion_system_dpp.jobs: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.job_batches
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

-- Dumping data for table suggestion_system_dpp.job_batches: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_06_29_200239_create_suggestions_table', 2),
	(5, '2025_07_07_041554_add_criteria_and_new_idea_to_suggestions_table', 3),
	(6, '2025_07_07_050033_create_departments_table', 4),
	(7, '2025_07_07_065904_add_department_id_to_suggestions_table', 5),
	(8, '2025_07_08_003716_change_kriteria_column_to_string_in_suggestions_table', 6),
	(9, '2025_07_11_005759_create_access_codes_table', 7);

-- Dumping structure for table suggestion_system_dpp.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table suggestion_system_dpp.sessions
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

-- Dumping data for table suggestion_system_dpp.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('3yKeErFu4HvPlyO4qTmmpB1MxpBgRrFA9nZIqREg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiODdHZURXUEpxNDExWVlDYVB2aG53RDRWY2l1V2VmZWdvNG9ZVjZkZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9zdWdnZXN0aW9uLXN5c3RlbS1kcHAudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752106193),
	('9dZ1gdlRDYm3w2DHDNdeQfYbzVKBYBmm5TcDRapp', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoialFXWVNqU2NnMk9Hck1PVjU2aWJkQk5PZEVpelFKYXJJdTRmMUpUdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9zdWdnZXN0aW9uLXN5c3RlbS1kcHAudGVzdC9zdWdnZXN0aW9ucy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1752200859),
	('u4NpbJXTJWfheSq5xRfAv2GypSfI1B8EAVBY3Wv5', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicml3UXJDdkt1MUpielhyQ0xpaFFBUnlOR21jZkRRT2owdEllQlBpcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9zdWdnZXN0aW9uLXN5c3RlbS1kcHAudGVzdC9hZG1pbi9zdWdnZXN0aW9ucyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1752122968),
	('UgH5cAXvgvpDbXN1MUKm1nuu9niMDBh7nQZ0TAEn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0lEUlhEbG9qRFVtVFhHZnFFdWNqVGdPTVZ0TUJWNnpJS3ZrY0FZbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9zdWdnZXN0aW9uLXN5c3RlbS1kcHAudGVzdC9zdWdnZXN0aW9ucy9jcmVhdGUiO319', 1752138828);

-- Dumping structure for table suggestion_system_dpp.suggestions
CREATE TABLE IF NOT EXISTS `suggestions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_bag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kriteria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tema` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_new_idea` tinyint(1) NOT NULL DEFAULT '1',
  `kondisi_semula_text` text COLLATE utf8mb4_unicode_ci,
  `perbaikan_text` text COLLATE utf8mb4_unicode_ci,
  `tujuan_perbaikan` text COLLATE utf8mb4_unicode_ci,
  `kondisi_semula_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perbaikan_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_perbaikan_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_ss` int DEFAULT NULL,
  `dibuat_oleh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pelaksanaan` date DEFAULT NULL,
  `diperiksa_oleh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disetujui_oleh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suggestions_department_id_foreign` (`department_id`),
  CONSTRAINT `suggestions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.suggestions: ~3 rows (approximately)
INSERT INTO `suggestions` (`id`, `nama`, `npk`, `line_bag`, `kriteria`, `tema`, `is_new_idea`, `kondisi_semula_text`, `perbaikan_text`, `tujuan_perbaikan`, `kondisi_semula_gambar`, `perbaikan_gambar`, `hasil_perbaikan_gambar`, `nilai_ss`, `dibuat_oleh`, `tanggal_pelaksanaan`, `diperiksa_oleh`, `disetujui_oleh`, `created_at`, `updated_at`, `department_id`) VALUES
	(1, 'Budi Santoso', '1902345', 'Assembly Line 1', NULL, 'Pengurangan Waktu Tunggu Mesin', 1, 'Saat ini, mesin sering berhenti selama 5-10 menit saat pergantian material karena operator harus berjalan jauh untuk mengambil material baru.', 'Menempatkan rak material cadangan di samping setiap mesin. Rak ini akan diisi ulang oleh tim logistik setiap pagi.', 'Mengurangi waktu henti mesin (downtime) dan meningkatkan efisiensi operator.', NULL, NULL, NULL, 95, 'Budi Santoso', '2025-06-27', NULL, NULL, '2025-07-06 22:57:46', '2025-07-07 01:49:36', NULL),
	(2, 'Citra Lestari', '2105678', 'Quality Control', NULL, 'Optimalisasi Proses Pengecekan Kualitas', 1, 'Proses pengecekan produk akhir masih manual menggunakan checklist kertas, yang lambat dan rentan kesalahan pencatatan.', 'Mengembangkan aplikasi checklist digital sederhana yang bisa diakses melalui tablet di setiap stasiun QC.', 'Mempercepat proses pencatatan, mengurangi penggunaan kertas, dan meminimalkan human error.', NULL, NULL, NULL, NULL, 'Citra Lestari', '2025-07-02', NULL, NULL, '2025-07-06 22:57:46', '2025-07-06 22:57:46', NULL),
	(3, 'Agus Wijaya', '1801122', 'Warehouse', NULL, 'Peningkatan Keamanan Area Gudang', 1, 'Pencahayaan di lorong gudang bagian belakang sangat minim, sehingga menyulitkan operator forklift saat bekerja di malam hari dan berisiko kecelakaan.', 'Menambah 5 titik lampu LED hemat energi di sepanjang lorong gudang yang gelap.', 'Meningkatkan visibilitas dan keselamatan kerja bagi tim gudang, terutama pada shift malam.', NULL, NULL, NULL, NULL, 'Agus Wijaya', '2025-07-05', NULL, NULL, '2025-07-06 22:57:46', '2025-07-06 22:57:46', NULL),
	(4, 'Siti Aminah', '20231105', 'Area Pengecekan Akhir (Final Inspection)', '"Safety (Potensi kecelakaan kerja)"', 'Pemasangan Lampu Peringatan Lantai Basah di Area Final Inspection', 1, 'Saat ini, setelah lantai di area final inspection dipel, hanya ada papan peringatan standar. Papan ini ukurannya kecil dan kadang tidak terlihat oleh rekan kerja yang sedang fokus memeriksa produk.', 'Menambahkan lampu peringatan berwarna kuning yang berkedip di dinding atas area inspeksi. Lampu ini akan dinyalakan oleh petugas kebersihan selama dan setelah proses pengepelan lantai hingga kering.', 'Meningkatkan kesadaran (awareness) semua orang yang berada di area tersebut untuk mengurangi risiko terpeleset atau kecelakaan kerja secara signifikan.', NULL, NULL, NULL, 100, 'Siti Aminah', '2025-07-07', NULL, NULL, '2025-07-07 01:22:16', '2025-07-07 01:49:56', 8),
	(5, 'Rahmat Hidayat', '20230815', 'Assembly Station 2', 'Productivity (Mempercepat proses, menghilangkan muda,mura,muri)', 'Penggunaan Rak Komponen Kecil (Parts Bin) di Setiap Stasiun Kerja', 1, 'Saat ini, komponen kecil seperti baut, mur, dan ring ditempatkan dalam kotak kardus besar di samping stasiun kerja. Operator harus mencari komponen yang tepat, sehingga memperlambat waktu perakitan dan ada risiko komponen tercampur.', 'Menyediakan rak kecil (parts bin) dengan banyak laci transparan di setiap stasiun kerja. Setiap laci diberi label sesuai dengan jenis komponen di dalamnya. Petugas logistik akan mengisi ulang rak ini setiap pagi.', '1. Mengurangi waktu pengambilan komponen sebesar 70%. 2. Menghilangkan risiko komponen tercampur. 3. Meningkatkan kerapian area kerja sesuai standar 5R.', NULL, NULL, NULL, NULL, 'Rahmat Hidayat', '2025-07-08', NULL, NULL, '2025-07-07 17:57:23', '2025-07-07 17:57:23', 7);

-- Dumping structure for table suggestion_system_dpp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `posisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table suggestion_system_dpp.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `posisi`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin Utama', 'admin@example.com', NULL, 'Administrator', 'admin', '$2y$12$u.viMiu9dffO/RJLsD.vIOyU9loywcININ17/R2mCqYmgOjYL.6b2', NULL, '2025-06-29 12:51:16', '2025-06-29 12:51:16'),
	(3, 'admin 2', 'admin2@gmail.com', NULL, 'General Manager', 'admin', '$2y$12$/cLNMz9ol6UkE9T.941QmO7TS8KIZxPngxeLc9VPd8JxdHsT0UGGm', NULL, '2025-06-30 02:02:04', '2025-06-30 02:02:04'),
	(4, 'admin 3', 'admin3@gmail.com', NULL, 'General Manager', 'admin', '$2y$12$yJJhnoqf4u73giGvoHG7NeOncvXWLOs4KhGedzFdnS.U4UsE8/um.', NULL, '2025-06-30 02:06:51', '2025-06-30 02:06:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
