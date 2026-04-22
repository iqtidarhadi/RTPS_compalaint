-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 24, 2025 at 05:26 AM
-- Server version: 5.7.26-log
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grewrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'deleted', 'App\\Models\\User', 'deleted', 211, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"xen.kohistan_lower\", \"text\": null}}', NULL, '2025-03-22 03:52:50', '2025-03-22 03:52:50'),
(2, 'default', 'deleted', 'App\\Models\\User', 'deleted', 209, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"xen.kohistan_upper\", \"text\": null}}', NULL, '2025-03-22 03:53:20', '2025-03-22 03:53:20'),
(3, 'default', 'updated', 'App\\Models\\User', 'updated', 210, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"xen.battagram\", \"text\": null}, \"attributes\": {\"name\": \"xen.battagram1\", \"text\": null}}', NULL, '2025-03-23 21:32:31', '2025-03-23 21:32:31'),
(4, 'default', 'updated', 'App\\Models\\User', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"Developer\", \"text\": null}, \"attributes\": {\"name\": \"Developer\", \"text\": null}}', NULL, '2025-03-23 22:18:27', '2025-03-23 22:18:27'),
(5, 'default', 'updated', 'App\\Models\\User', 'updated', 1, 'App\\Models\\User', 1, '{\"old\": {\"name\": \"Developer\", \"text\": null}, \"attributes\": {\"name\": \"Developer\", \"text\": null}}', NULL, '2025-03-23 22:20:21', '2025-03-23 22:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"f\";s:7:\"menu_id\";s:1:\"r\";s:5:\"roles\";s:1:\"l\";s:10:\"is_generic\";}s:11:\"permissions\";a:28:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"user-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:1;s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"user-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:1;s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"user-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:1;s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:1;s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"role-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:2;s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:2;s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:2;s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:2;s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"district-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:4;}i:9;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"district-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:4;}i:10;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:13:\"district-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:4;}i:11;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"district-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:4;}i:12;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"tehsil-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:5;}i:13;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"tehsil-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:5;}i:14;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:11:\"tehsil-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:5;}i:15;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"tehsil-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:5;}i:16;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:13:\"division-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:12;}i:17;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:15:\"division-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:12;}i:18;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:13:\"division-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:12;}i:19;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"division-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:12;}i:20;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:11:\"status-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:15;}i:21;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:13:\"status-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:15;}i:22;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:11:\"status-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:15;}i:23;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"status-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:15;}i:24;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:13:\"app_flow-list\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:16;}i:25;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:15:\"app_flow-create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:16;}i:26;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"app_flow-edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:16;}i:27;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:15:\"app_flow-delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";i:16;}}s:5:\"roles\";a:1:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"Developer\";s:1:\"c\";s:3:\"web\";s:1:\"l\";i:0;}}}', 1742874652);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `districtCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `status`, `deleted_at`, `created_at`, `updated_at`, `description`, `longitude`, `latitude`, `districtCode`) VALUES
(1, 'Abbottabad', 1, NULL, '2022-08-27 11:26:28', '2023-02-10 02:17:38', NULL, NULL, NULL, NULL),
(2, 'Bannu', 1, NULL, '2022-08-27 11:26:33', '2022-08-27 11:26:33', NULL, NULL, NULL, NULL),
(3, 'Battagram', 1, NULL, '2022-08-27 11:26:39', '2022-08-27 11:26:39', NULL, NULL, NULL, NULL),
(4, 'Buner', 1, NULL, '2022-08-27 11:26:43', '2022-08-27 11:26:43', NULL, NULL, NULL, NULL),
(5, 'Charsadda', 1, NULL, '2022-08-27 11:26:51', '2022-08-27 11:26:51', NULL, NULL, NULL, NULL),
(6, 'Chitral Upper', 1, NULL, '2022-08-27 11:26:58', '2022-08-27 11:26:58', NULL, NULL, NULL, NULL),
(7, 'Chitral Lower', 1, NULL, '2022-08-27 11:27:05', '2022-08-27 11:27:05', NULL, NULL, NULL, NULL),
(8, 'Dera Ismail Khan', 1, NULL, '2022-08-27 11:27:16', '2022-08-27 11:27:16', NULL, NULL, NULL, NULL),
(9, 'Dir Lower', 1, NULL, '2022-08-27 11:27:21', '2022-08-27 11:27:21', NULL, NULL, NULL, NULL),
(10, 'Dir Upper', 1, NULL, '2022-08-27 11:27:25', '2022-08-27 11:27:25', NULL, NULL, NULL, NULL),
(11, 'Hangu', 1, NULL, '2022-08-27 11:27:30', '2022-08-27 11:27:30', NULL, NULL, NULL, NULL),
(12, 'Haripur', 1, NULL, '2022-08-27 11:27:34', '2022-08-27 11:27:34', NULL, NULL, NULL, NULL),
(13, 'Karak', 1, NULL, '2022-08-27 11:27:38', '2022-08-27 11:27:38', NULL, NULL, NULL, NULL),
(14, 'Kohat', 1, NULL, '2022-08-27 11:27:42', '2022-08-27 11:27:42', NULL, NULL, NULL, NULL),
(15, 'Kohistan Upper', 1, NULL, '2022-08-27 11:27:47', '2022-08-27 11:27:47', NULL, NULL, NULL, NULL),
(16, 'Kohistan Lower', 1, NULL, '2022-08-27 11:27:53', '2022-08-27 11:27:53', NULL, NULL, NULL, NULL),
(17, 'Kolai Palas', 1, NULL, '2022-08-27 11:27:59', '2022-08-27 11:27:59', NULL, NULL, NULL, NULL),
(18, 'Lakki Marwat', 1, NULL, '2022-08-27 11:28:05', '2022-08-27 11:28:05', NULL, NULL, NULL, NULL),
(19, 'Malakand', 1, NULL, '2022-08-27 11:28:09', '2022-08-27 11:28:09', NULL, NULL, NULL, NULL),
(20, 'Mansehra', 1, NULL, '2022-08-27 11:28:16', '2022-08-27 11:28:16', NULL, NULL, NULL, NULL),
(21, 'Mardan', 1, NULL, '2022-08-27 11:28:20', '2022-08-27 11:28:20', NULL, NULL, NULL, NULL),
(22, 'Nowshera', 1, NULL, '2022-08-27 11:28:29', '2022-08-27 11:28:29', NULL, NULL, NULL, NULL),
(23, 'Peshawar', 1, NULL, '2022-08-27 11:28:34', '2022-08-27 11:28:34', NULL, NULL, NULL, NULL),
(24, 'Shangla', 1, NULL, '2022-08-27 11:28:51', '2022-08-27 11:28:51', NULL, NULL, NULL, NULL),
(25, 'Swabi', 1, NULL, '2022-08-27 11:28:55', '2022-08-27 11:28:55', NULL, NULL, NULL, NULL),
(26, 'Swat', 1, NULL, '2022-08-27 11:28:58', '2022-08-27 11:28:58', NULL, NULL, NULL, NULL),
(27, 'Tank', 1, NULL, '2022-08-27 11:29:02', '2022-08-27 11:29:02', NULL, NULL, NULL, NULL),
(28, 'Torghar', 1, NULL, '2022-08-27 11:29:07', '2022-08-27 11:29:07', NULL, NULL, NULL, NULL),
(29, 'Bajour', 1, NULL, '2022-08-27 11:29:30', '2022-08-27 11:29:30', NULL, NULL, NULL, NULL),
(30, 'Kurram', 1, NULL, '2022-08-27 11:29:35', '2022-08-27 11:29:35', NULL, NULL, NULL, NULL),
(31, 'Orakzai', 1, NULL, '2022-08-27 11:29:39', '2022-08-27 11:29:39', NULL, NULL, NULL, NULL),
(32, 'North Waziristan', 1, NULL, '2022-08-27 11:29:46', '2022-08-27 11:29:46', NULL, NULL, NULL, NULL),
(33, 'South Waziristan', 1, NULL, '2022-08-27 11:29:56', '2022-08-27 11:29:56', NULL, NULL, NULL, NULL),
(34, 'Mohmand', 1, NULL, '2022-08-27 11:30:07', '2022-08-27 11:30:07', NULL, NULL, NULL, NULL),
(35, 'Khyber', 1, NULL, '2022-08-27 11:30:11', '2022-08-27 11:30:11', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executive_office_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_divisions_districts` (`district_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `code`, `executive_office_id`, `status`, `created_at`, `updated_at`, `district_id`) VALUES
(1, 'SUPERINTENDING ENGINEER, C&W CIRCLE, PESHAWAR', 'PR4940', 2, 1, NULL, NULL, NULL),
(2, 'SUPERINTENDING ENGINEER, C&W CIRCLE, MARDAN', 'MR4397', 2, 1, NULL, NULL, NULL),
(3, 'SUPERINTENDANT ENGINEER C & W TRIBAL DISTRICT CIRCLE PESHAWAR (SE Khyber)', 'PR8081', 2, 1, NULL, NULL, NULL),
(4, 'SUPERINTENDING ENGINEER, C&W CIRCLE, ABBOOTTABAD', 'AD4341', 6, 1, NULL, NULL, NULL),
(5, 'SUPERINTENDING ENGINEER C&W CIRCLE MANSEHRA', 'MA4413', 6, 1, NULL, NULL, NULL),
(6, 'SUPERINTENDING ENG. PROVINCIAL BUILDING MAINTENANCE CELL', 'PR5224', 3, 1, NULL, NULL, NULL),
(7, 'SUPERINTENDING ENGINEER MEGA PROJECTS PESHAWAR', 'PR4116', 4, 1, NULL, NULL, NULL),
(8, 'SUPERINTENDING ENGINEER MEGA PROJECTS MARDAN', 'MR4820', 4, 1, NULL, NULL, NULL),
(9, 'SUPERINTENDING ENGINEER MEGA PROJECTS NMAS KOHAT', 'KT4561', 4, 1, NULL, NULL, NULL),
(10, 'SUPERINTENDING ENGINEER, C&W CIRCLE, SWAT', 'SW4481', 7, 1, NULL, NULL, NULL),
(11, 'SUPERINTENDING ENGINEER, C&W CIRCLE, DIR LOWER', 'DA4267', 7, 1, NULL, NULL, NULL),
(12, 'SUPERINTENDING ENGINEER C&W CIRCLE MALAKAND', 'MD4351', 7, 1, NULL, NULL, NULL),
(13, 'SUPERINTENDING ENGINEER, C&W CIRCLE, KOHAT', 'KT4397', 29, 1, NULL, '2024-11-26 09:23:19', NULL),
(14, 'SUPERINTENDING ENGINEER NMAS HANGU', 'HG4199', 29, 1, NULL, '2024-11-26 09:23:31', NULL),
(15, 'SUPERINTENDING ENGINEER MERGED AREAS CIRCLE BANNU (SE Waziristan)', 'BU4499', 9, 1, NULL, NULL, NULL),
(16, 'SUPERINTENDING ENGINEER, C&W CIRCLE, BANNU', 'BU4430', 9, 1, NULL, NULL, NULL),
(17, 'SUPERINTENDING ENGINEER, C&W CIRCLE, DI KHAN', 'DI4367', 9, 1, NULL, NULL, NULL),
(18, 'REGIONAL ROADS RESEARCH & MATERIAL TESTING LABORATORY PESHAWAR', 'PR5440', 5, 1, NULL, NULL, NULL),
(19, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, ABBOTTABAD', 'AD4342', 5, 1, NULL, NULL, NULL),
(20, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, BANNU', 'BU4431', 5, 1, NULL, NULL, NULL),
(21, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, DIR LOWER', 'DA4268', 5, 1, NULL, NULL, NULL),
(22, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, D.I.KHAN', 'DI4368', 5, 1, NULL, NULL, NULL),
(23, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, KOHAT', 'KT4398', 5, 1, NULL, NULL, NULL),
(24, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY MARDAN', 'MR4398', 5, 1, NULL, NULL, NULL),
(25, 'ROADS RESEARCH & MATERIAL TESTING LAB', 'MA4414', 5, 1, NULL, NULL, NULL),
(26, 'ROADS RESEARCH & MATERIAL TESTING LABORATORY, C&W CIRCLE, SWAT', 'SW4482', 5, 1, NULL, NULL, NULL),
(27, 'PRINCIPAL CONSULTING ARCHITECT, C&W DEPARTMENT PESHAWAR.', 'PR5445', 5, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_branch_id_foreign` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `status`, `branch_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'user', 1, NULL, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:39'),
(2, 'role', 1, NULL, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:39'),
(4, 'district', 1, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:39', '2023-10-17 00:21:39'),
(5, 'tehsil', 1, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:39', '2023-10-17 00:21:39'),
(12, 'division', 1, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:39', '2023-10-17 00:21:39'),
(15, 'status', 1, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:40', '2023-10-17 00:21:40'),
(16, 'App Flow', 1, NULL, '2023-10-17 00:21:39', '2023-10-17 00:21:40', '2023-10-17 00:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_22_041304_create_activity_log_table', 2),
(5, '2025_03_22_041305_add_event_column_to_activity_log_table', 3),
(6, '2025_03_22_041306_add_batch_uuid_column_to_activity_log_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  KEY `permissions_menu_id_foreign` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `menu_id`) VALUES
(1, 'user-list', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 1),
(2, 'user-create', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 1),
(3, 'user-edit', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 1),
(4, 'user-delete', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 1),
(5, 'role-list', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 2),
(6, 'role-create', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 2),
(7, 'role-edit', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 2),
(8, 'role-delete', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 2),
(13, 'district-list', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 4),
(14, 'district-create', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 4),
(15, 'district-edit', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 4),
(16, 'district-delete', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 4),
(17, 'tehsil-list', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 5),
(18, 'tehsil-create', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 5),
(19, 'tehsil-edit', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 5),
(20, 'tehsil-delete', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 5),
(45, 'division-list', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 12),
(46, 'division-create', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 12),
(47, 'division-edit', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 12),
(48, 'division-delete', 'web', '2023-10-17 00:21:39', '2023-10-17 00:21:39', 12),
(57, 'status-list', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 15),
(58, 'status-create', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 15),
(59, 'status-edit', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 15),
(60, 'status-delete', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 15),
(61, 'app_flow-list', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 16),
(62, 'app_flow-create', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 16),
(63, 'app_flow-edit', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 16),
(64, 'app_flow-delete', 'web', '2023-10-17 00:21:40', '2023-10-17 00:21:40', 16);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_generic` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_generic`) VALUES
(1, 'Developer', 'web', '2025-03-23 21:47:38', '2025-03-23 21:47:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YxYGQnK3kuPCIQWVNR0ZY50GdvV4QRELlkW5nGdo', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYktpS0pGRGRoaUNkZnRaeHJaQXFuc1daaEpZQVcwWXFDT3BXUFJKNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjYwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBwL3NldHRpbmcvdXNlci1tYW5hZ21lbnQvdXNlcnMvZXlKcGRpSTZJbmhUVEVKUmFUTk5VRmgyVTB4Nk1tUklURzlFTUZFOVBTSXNJblpoYkhWbElqb2lWbFJYUTNReVRXRXlTVzV1YURaRmNESkNNMlpTZHowOUlpd2liV0ZqSWpvaU1UWTRPR1JpTnpNMVltSTRZak16TVdOaU16WTNOVE0wT0RrMU9UVXhOekZpWm1FelptVXpZalF4WkRZeFlUSTRZbVk1WmpnME4yUTRPV1ExTXpoaFpDSXNJblJoWnlJNklpSjkvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwcC9zZXR0aW5nL3VzZXItbWFuYWdtZW50L3VzZXJzIjt9fQ==', 1742793259);

-- --------------------------------------------------------

--
-- Table structure for table `tehsils`
--

DROP TABLE IF EXISTS `tehsils`;
CREATE TABLE IF NOT EXISTS `tehsils` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tehsils_district_id_foreign` (`district_id`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tehsils`
--

INSERT INTO `tehsils` (`id`, `name`, `district_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Charsadda', 5, 1, NULL, '2022-09-09 22:27:45', '2022-09-09 22:27:45'),
(3, 'Tangi', 5, 1, NULL, '2022-09-09 22:27:59', '2022-09-09 22:27:59'),
(4, 'Shabqadar', 5, 1, NULL, '2022-09-09 22:28:11', '2022-09-09 22:28:11'),
(5, 'Bettani', 18, 1, NULL, '2022-09-14 00:18:19', '2022-09-15 05:22:17'),
(6, 'Ghazni Khel', 18, 1, NULL, '2022-09-14 00:18:30', '2022-09-14 00:18:30'),
(7, 'Khar', 29, 1, NULL, '2022-09-14 00:30:40', '2022-09-14 00:30:40'),
(8, 'Nawagai', 29, 1, NULL, '2022-09-14 00:30:58', '2022-09-14 00:30:58'),
(9, 'Loi Mamund', 29, 1, NULL, '2022-09-14 00:31:34', '2022-09-15 05:18:44'),
(10, 'Chamarkand', 29, 1, NULL, '2022-09-14 00:31:53', '2022-09-14 00:31:53'),
(11, 'Wara Mamund', 29, 1, NULL, '2022-09-14 00:32:07', '2022-09-15 05:19:25'),
(12, 'Barang', 29, 1, NULL, '2022-09-14 00:32:26', '2022-09-14 00:32:26'),
(13, 'Salarzai', 29, 1, NULL, '2022-09-14 00:32:40', '2022-09-15 05:19:59'),
(14, 'Battagram', 3, 1, NULL, '2022-09-14 00:33:43', '2022-09-14 00:33:43'),
(15, 'Alai', 3, 1, NULL, '2022-09-14 00:34:03', '2022-09-14 00:34:03'),
(16, 'Daggar', 4, 1, NULL, '2022-09-14 00:35:25', '2022-09-14 00:35:25'),
(17, 'Gagra', 4, 1, NULL, '2022-09-14 00:35:40', '2022-09-14 00:35:40'),
(18, 'Gagra', 4, 1, NULL, '2022-09-14 00:36:02', '2022-09-14 00:36:02'),
(19, 'Khaddo Khel', 4, 1, NULL, '2022-09-14 00:36:18', '2022-09-14 00:36:18'),
(20, 'Totali Mandan', 4, 1, NULL, '2022-09-14 00:36:33', '2022-09-14 00:36:33'),
(21, 'Gadezai', 4, 1, NULL, '2022-09-14 00:36:50', '2022-09-14 00:36:50'),
(22, 'Chagarzai', 4, 1, NULL, '2022-09-14 00:37:07', '2022-09-14 00:37:07'),
(23, 'Hangu', 11, 1, NULL, '2022-09-14 00:43:25', '2022-09-14 00:43:25'),
(24, 'Tall', 11, 1, NULL, '2022-09-14 00:53:03', '2022-09-14 00:53:03'),
(25, 'Haripur', 12, 1, NULL, '2022-09-14 00:53:31', '2022-09-14 00:53:31'),
(26, 'Ghazi', 12, 1, NULL, '2022-09-14 00:53:49', '2022-09-14 00:53:49'),
(27, 'Khanpur', 12, 1, NULL, '2022-09-14 00:54:13', '2022-09-14 00:54:13'),
(28, 'Kohat', 14, 1, NULL, '2022-09-14 00:54:56', '2022-09-14 00:54:56'),
(29, 'Lachi', 14, 1, NULL, '2022-09-14 00:55:10', '2022-09-14 00:55:10'),
(30, 'Dara Adam Khel', 14, 1, NULL, '2022-09-14 00:55:27', '2022-09-14 00:55:27'),
(31, 'Gumbat', 14, 1, NULL, '2022-09-14 00:55:44', '2022-09-14 00:55:44'),
(32, 'Bataira Kolai', 17, 1, NULL, '2022-09-14 00:56:14', '2022-09-14 00:56:14'),
(33, 'Palas', 17, 1, NULL, '2022-09-14 00:56:31', '2022-09-14 00:56:31'),
(34, 'Lower Kurram', 30, 1, NULL, '2022-09-14 00:57:02', '2022-09-14 00:57:02'),
(35, 'Upper Kurram', 30, 1, NULL, '2022-09-14 00:57:22', '2022-09-14 00:57:22'),
(36, 'Central Kurram', 30, 1, NULL, '2022-09-14 00:58:06', '2022-09-14 00:58:06'),
(37, 'Dargai', 19, 1, NULL, '2022-09-14 00:59:33', '2022-09-14 00:59:33'),
(38, 'batkhela', 19, 1, NULL, '2022-09-14 00:59:47', '2022-09-14 00:59:47'),
(39, 'Thana Baizai', 19, 1, NULL, '2022-09-14 01:00:34', '2022-09-14 01:00:34'),
(40, 'Mansehra', 20, 1, NULL, '2022-09-14 01:01:15', '2022-09-14 01:01:15'),
(41, 'Balakot', 20, 1, NULL, '2022-09-14 01:01:29', '2022-09-14 01:01:29'),
(42, 'Oghi', 20, 1, NULL, '2022-09-14 01:01:42', '2022-09-14 01:01:42'),
(43, 'Baffa Pakhal', 20, 1, NULL, '2022-09-14 01:01:59', '2022-09-14 01:01:59'),
(44, 'Darband', 20, 1, NULL, '2022-09-14 01:02:15', '2022-09-14 01:02:15'),
(45, 'Mardan', 21, 1, NULL, '2022-09-14 01:02:41', '2022-09-14 01:02:41'),
(46, 'Takhtbai', 21, 1, NULL, '2022-09-14 01:03:00', '2022-09-14 01:03:00'),
(47, 'Katlang', 21, 1, NULL, '2022-09-14 01:03:22', '2022-09-14 01:03:22'),
(48, 'Rustam', 21, 1, NULL, '2022-09-14 01:03:37', '2022-09-14 01:03:37'),
(49, 'Garhi Kapoora', 21, 1, NULL, '2022-09-14 01:03:51', '2022-09-14 01:03:51'),
(50, 'Central Mohmand', 34, 1, NULL, '2022-09-14 01:04:30', '2022-09-14 01:04:30'),
(51, 'Lower Mohmand', 34, 1, NULL, '2022-09-14 01:04:49', '2022-09-14 01:04:49'),
(52, 'Upper Mohmand', 34, 1, NULL, '2022-09-14 01:05:16', '2022-09-14 01:05:16'),
(53, 'Mirali', 32, 1, NULL, '2022-09-14 01:06:23', '2022-09-14 01:06:23'),
(54, 'Miranshah', 32, 1, NULL, '2022-09-14 01:11:04', '2022-09-14 01:11:04'),
(55, 'Razmak', 32, 1, NULL, '2022-09-14 01:12:02', '2022-09-14 01:12:02'),
(56, 'Datta Khel', 32, 1, NULL, '2022-09-14 01:12:21', '2022-09-14 01:12:21'),
(57, 'Dossali', 32, 1, NULL, '2022-09-14 01:12:37', '2022-09-14 01:12:37'),
(58, 'Gharyum', 32, 1, NULL, '2022-09-14 01:12:50', '2022-09-14 01:12:50'),
(59, 'Ghulam Khan', 32, 1, NULL, '2022-09-14 01:13:04', '2022-09-14 01:13:04'),
(60, 'Shewa', 32, 1, NULL, '2022-09-14 01:13:17', '2022-09-14 01:13:17'),
(61, 'Spinwam', 32, 1, NULL, '2022-09-14 01:13:30', '2022-09-14 01:13:30'),
(62, 'Lower Orakzai', 31, 1, NULL, '2022-09-14 01:15:12', '2022-09-14 01:15:12'),
(63, 'Upper Orakzai', 31, 1, NULL, '2022-09-14 01:15:25', '2022-09-14 01:15:25'),
(64, 'Alpuri', 24, 1, NULL, '2022-09-14 01:16:56', '2022-09-14 01:16:56'),
(65, 'Puran', 24, 1, NULL, '2022-09-14 01:17:10', '2022-09-14 01:17:10'),
(66, 'Besham', 24, 1, NULL, '2022-09-14 01:17:25', '2022-09-14 01:17:25'),
(67, 'Chakisar', 24, 1, NULL, '2022-09-14 01:17:40', '2022-09-14 01:17:40'),
(68, 'Martung', 24, 1, NULL, '2022-09-14 01:17:53', '2022-09-14 01:17:53'),
(69, 'Swabi', 25, 1, NULL, '2022-09-14 01:18:31', '2022-09-14 01:18:31'),
(70, 'Razar', 25, 1, NULL, '2022-09-14 01:18:46', '2022-09-14 01:18:46'),
(71, 'Topi', 25, 1, NULL, '2022-09-14 01:19:06', '2022-09-14 01:19:06'),
(72, 'lahor', 25, 1, NULL, '2022-09-14 01:19:19', '2022-09-14 01:19:19'),
(78, 'Chamkani', 23, 1, NULL, '2022-09-14 01:22:43', '2022-09-14 01:22:43'),
(77, 'Badhaber', 23, 1, NULL, '2022-09-14 01:22:28', '2022-09-14 01:22:28'),
(76, 'Peshawar', 23, 1, NULL, '2022-09-14 01:22:07', '2022-09-14 01:22:07'),
(79, 'Hassan Khel', 23, 1, NULL, '2022-09-14 01:23:03', '2022-09-14 01:23:03'),
(80, 'Mathra', 23, 1, NULL, '2022-09-14 01:23:16', '2022-09-14 01:23:16'),
(81, 'Pishtakhara', 23, 1, NULL, '2022-09-14 01:23:33', '2022-09-14 01:23:33'),
(82, 'Shah Alam', 23, 1, NULL, '2022-09-14 01:23:50', '2022-09-14 01:23:50'),
(83, 'Domail', 2, 1, NULL, '2022-09-14 01:24:40', '2022-09-14 01:24:40'),
(84, 'Bannu', 2, 1, NULL, '2022-09-14 01:24:52', '2022-09-14 01:24:52'),
(85, 'Wazir', 2, 1, NULL, '2022-09-14 01:25:03', '2022-09-14 01:25:03'),
(86, 'Baka Khel', 2, 1, NULL, '2022-09-14 01:25:21', '2022-09-14 01:25:21'),
(87, 'Kakki', 2, 1, NULL, '2022-09-14 01:25:34', '2022-09-14 01:25:34'),
(88, 'Meryan', 2, 1, NULL, '2022-09-14 01:25:47', '2022-09-14 01:25:47'),
(1, 'Abbottabad', 1, 1, NULL, '2022-09-14 01:26:36', '2022-09-14 01:26:36'),
(90, 'Havelian', 1, 1, NULL, '2022-09-14 01:27:00', '2022-09-14 01:27:00'),
(91, 'Lower Tanawal', 1, 1, NULL, '2022-09-14 01:27:25', '2022-09-14 01:27:25'),
(92, 'Lora', 1, 1, NULL, '2022-09-14 01:27:42', '2022-09-14 01:27:42'),
(152, 'Lakki Marwat', 18, 1, NULL, '2022-09-14 17:42:50', '2022-09-14 17:42:50'),
(94, 'Karak', 13, 1, NULL, '2022-09-14 01:30:21', '2022-09-14 01:30:21'),
(95, 'Takht-e-Nasrati', 13, 1, NULL, '2022-09-14 01:30:36', '2022-09-14 01:30:36'),
(96, 'Banda Daud Shah', 13, 1, NULL, '2022-09-14 01:30:58', '2022-09-14 01:30:58'),
(97, 'Nowshera', 22, 1, NULL, '2022-09-14 01:32:02', '2022-09-14 01:32:02'),
(98, 'Pabbi', 22, 1, NULL, '2022-09-14 01:32:19', '2022-09-14 01:32:19'),
(99, 'Jehangira', 22, 1, NULL, '2022-09-14 01:32:41', '2022-09-14 01:32:41'),
(100, 'Babozai', 26, 1, NULL, '2022-09-14 01:33:49', '2022-09-14 01:33:49'),
(101, 'Kabal', 26, 1, NULL, '2022-09-14 01:34:02', '2022-09-14 01:34:02'),
(102, 'Khuazakhela', 26, 1, NULL, '2022-09-14 01:34:15', '2022-09-14 01:34:15'),
(103, 'Barikot', 26, 1, NULL, '2022-09-14 01:34:32', '2022-09-14 01:34:32'),
(104, 'Bahrain', 26, 1, NULL, '2022-09-14 01:34:49', '2022-09-14 01:34:49'),
(105, 'Charbagh', 26, 1, NULL, '2022-09-14 01:35:02', '2022-09-14 01:35:02'),
(106, 'Matta', 26, 1, NULL, '2022-09-14 01:35:18', '2022-09-14 01:35:18'),
(107, 'D.I Khan', 8, 1, NULL, '2022-09-14 01:36:28', '2022-09-14 15:13:13'),
(108, 'Paroa', 8, 1, NULL, '2022-09-14 01:36:43', '2022-09-14 01:36:43'),
(109, 'Kulachi', 8, 1, NULL, '2022-09-14 01:36:56', '2022-09-14 15:12:29'),
(110, 'Paharpur', 8, 1, NULL, '2022-09-14 01:37:08', '2022-09-14 01:37:08'),
(111, 'Daraban', 8, 1, NULL, '2022-09-14 01:37:24', '2022-09-14 15:12:50'),
(112, 'Darazinda', 8, 1, NULL, '2022-09-14 01:37:41', '2022-09-14 01:37:41'),
(113, 'Adanzai', 9, 1, NULL, '2022-09-14 01:38:10', '2022-09-14 01:38:10'),
(114, 'Khaal', 9, 1, NULL, '2022-09-14 01:38:24', '2022-09-14 01:38:24'),
(115, 'Munda', 9, 1, NULL, '2022-09-14 01:38:47', '2022-09-14 01:38:47'),
(116, 'Timargara', 9, 1, NULL, '2022-09-14 01:39:04', '2022-09-14 01:39:04'),
(118, 'Balambat', 9, 1, NULL, '2022-09-14 01:39:43', '2022-09-14 01:39:43'),
(119, 'Lal Qilla', 9, 1, NULL, '2022-09-14 01:40:01', '2022-09-14 01:40:01'),
(120, 'Samarbagh', 9, 1, NULL, '2022-09-14 01:40:23', '2022-09-14 01:40:23'),
(121, 'Dir', 10, 1, NULL, '2022-09-14 01:40:40', '2022-09-14 01:40:40'),
(122, 'Sharingal', 10, 1, NULL, '2022-09-14 01:40:55', '2022-09-14 01:40:55'),
(123, 'Warri', 10, 1, NULL, '2022-09-14 01:41:31', '2022-09-14 01:41:31'),
(124, 'Barawal', 10, 1, NULL, '2022-09-14 01:42:06', '2022-09-14 01:42:06'),
(125, 'Kalkot', 10, 1, NULL, '2022-09-14 01:42:21', '2022-09-14 01:42:21'),
(126, 'Larjum', 10, 1, NULL, '2022-09-14 01:42:58', '2022-09-14 01:42:58'),
(127, 'Larjum', 10, 1, NULL, '2022-09-14 01:43:01', '2022-09-14 01:43:01'),
(128, 'Larjum', 10, 1, NULL, '2022-09-14 01:43:03', '2022-09-14 01:43:03'),
(129, 'Drosh', 7, 1, NULL, '2022-09-14 01:45:51', '2022-09-14 01:45:51'),
(130, 'Chitral', 7, 1, NULL, '2022-09-14 01:46:21', '2022-09-14 01:46:21'),
(131, 'Mastuj', 6, 1, NULL, '2022-09-14 01:47:29', '2022-09-14 01:47:29'),
(132, 'Mulkhow Tork', 6, 1, NULL, '2022-09-14 01:47:57', '2022-09-14 01:47:57'),
(133, 'Pattan', 16, 1, NULL, '2022-09-14 01:48:54', '2022-09-14 01:48:54'),
(134, 'Bankand / Ranolia', 16, 1, NULL, '2022-09-14 01:49:11', '2022-09-14 01:49:11'),
(135, 'Dassu', 15, 1, NULL, '2022-09-14 01:49:40', '2022-09-14 01:49:40'),
(136, 'Kundiya', 15, 1, NULL, '2022-09-14 01:49:57', '2022-09-14 01:49:57'),
(137, 'Harban Basha', 15, 1, NULL, '2022-09-14 01:50:27', '2022-09-14 01:50:27'),
(138, 'Seo', 15, 1, NULL, '2022-09-14 01:51:15', '2022-09-14 01:51:15'),
(139, 'Tank', 27, 1, NULL, '2022-09-14 01:53:32', '2022-09-14 01:53:32'),
(140, 'Jandola', 27, 1, NULL, '2022-09-14 01:53:46', '2022-09-14 01:53:46'),
(141, 'Daur Maira', 28, 1, NULL, '2022-09-14 01:57:44', '2022-09-14 01:57:44'),
(142, 'Hassan Zai', 28, 1, NULL, '2022-09-14 01:58:02', '2022-09-14 01:58:02'),
(143, 'Judbah', 28, 1, NULL, '2022-09-14 01:58:42', '2022-09-14 01:58:42'),
(144, 'Ladha', 33, 1, NULL, '2022-09-14 02:00:29', '2022-09-14 02:00:29'),
(145, 'Serwekai', 33, 1, NULL, '2022-09-14 02:01:09', '2022-09-14 02:01:09'),
(146, 'Wana', 33, 1, NULL, '2022-09-14 02:01:24', '2022-09-14 02:01:24'),
(147, 'Jamrud', 35, 1, NULL, '2022-09-14 02:02:30', '2022-09-14 02:02:30'),
(148, 'Landi Kotal', 35, 1, NULL, '2022-09-14 02:02:51', '2022-09-14 02:02:51'),
(149, 'Bara', 35, 1, NULL, '2022-09-14 02:03:12', '2022-09-14 02:03:12'),
(150, 'Test 1 Tehsil', 36, 1, NULL, '2022-09-14 16:41:38', '2022-09-14 16:41:38'),
(151, 'Test 2 Tehsil', 36, 1, NULL, '2022-09-14 16:42:49', '2022-09-14 16:42:49'),
(153, 'Serai Naurang', 18, 1, NULL, '2022-09-14 17:43:16', '2022-09-14 17:43:16'),
(154, 'Kana', 24, 1, NULL, '2022-09-14 17:51:43', '2022-09-14 17:51:43'),
(155, 'Utmankhel', 29, 1, NULL, '2022-09-15 05:20:32', '2022-09-15 05:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tehsil_id` bigint(20) UNSIGNED DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` text COLLATE utf8mb4_unicode_ci,
  `is_offline_enable` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_tehsil_id_foreign` (`tehsil_id`),
  KEY `users_district_id_foreign` (`district_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `tehsil_id`, `district_id`, `status`, `email_verified_at`, `password`, `remember_token`, `api_token`, `is_offline_enable`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 'admin@admin.com', 81, 23, 1, '2025-03-24 02:46:26', '$2y$12$WLSQoC8gQJDqjMG5P2jsheyfjorsONTi810k9tHa3S6qTyQdYzPla', NULL, NULL, 0, NULL, '2025-03-24 02:46:26', '2025-03-23 22:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('executive_office','division','subdivision') COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
