-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 03:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gatepass_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` varchar(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_name` varchar(150) NOT NULL,
  `center` varchar(100) NOT NULL,
  `empl_status` varchar(20) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `user_id`, `employee_name`, `center`, `empl_status`, `created_at`, `updated_at`) VALUES
('EMP001', 1, 'Zoro Roronoa', 'ICTD', 'active', '2026-03-16 05:40:15', '2026-03-16 06:03:10'),
('EMP003', 7, 'Nicole De Jesus', 'ICTD', 'active', '2026-03-23 05:57:47', '2026-03-23 06:00:10'),
('EMP004', 4, 'Juan Dela Cruz', 'ICTD', 'active', '2026-03-16 05:21:19', '2026-03-16 05:21:19'),
('EMP007', 5, 'Nicolas', 'GRDP', 'active', '2026-03-23 08:01:59', '2026-03-23 22:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_items`
--

CREATE TABLE `gatepass_items` (
  `gatepass_item_id` bigint(20) UNSIGNED NOT NULL,
  `gatepass_no` varchar(20) NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `item_remarks` varchar(500) DEFAULT NULL,
  `item_status` varchar(32) DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `last_inspected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `inspection_remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatepass_items`
--

INSERT INTO `gatepass_items` (`gatepass_item_id`, `gatepass_no`, `inventory_id`, `item_remarks`, `item_status`, `returned_at`, `last_inspected_by`, `inspection_remarks`, `created_at`, `updated_at`) VALUES
(4, '260000', 14, NULL, NULL, NULL, NULL, NULL, '2026-03-17 18:55:04', '2026-03-24 02:16:53'),
(5, '260000', 21, NULL, NULL, NULL, NULL, NULL, '2026-03-17 18:55:04', '2026-03-24 02:16:53'),
(6, '260001', 23, NULL, NULL, NULL, NULL, NULL, '2026-03-18 16:49:46', '2026-03-24 02:16:53'),
(7, '260002', 21, NULL, NULL, NULL, NULL, NULL, '2026-03-18 19:04:59', '2026-03-24 02:16:53'),
(8, '260003', 14, NULL, NULL, NULL, NULL, NULL, '2026-03-22 18:18:09', '2026-03-24 02:16:53'),
(9, '260003', 21, NULL, NULL, NULL, NULL, NULL, '2026-03-22 18:18:09', '2026-03-24 02:16:53'),
(10, '260003', 23, NULL, NULL, NULL, NULL, NULL, '2026-03-22 18:18:09', '2026-03-24 02:16:53'),
(11, '260004', 21, NULL, 'returned', '2026-03-22 20:45:17', 5, NULL, '2026-03-22 20:36:31', '2026-03-22 20:45:17'),
(12, '260004', 23, NULL, 'returned', '2026-03-22 20:45:17', 5, NULL, '2026-03-22 20:36:31', '2026-03-22 20:45:17'),
(13, '260005', 25, NULL, NULL, NULL, NULL, NULL, '2026-03-22 22:42:18', '2026-03-24 02:16:53'),
(14, '260006', 25, NULL, NULL, NULL, NULL, NULL, '2026-03-23 17:16:04', '2026-03-24 02:16:53'),
(15, '260007', 25, NULL, 'missing', NULL, 5, NULL, '2026-03-23 17:19:49', '2026-03-24 18:01:12'),
(16, '260007', 26, NULL, 'returned', '2026-03-24 18:01:12', 5, NULL, '2026-03-23 17:19:49', '2026-03-24 18:01:12'),
(17, '260008', 27, NULL, 'returned', '2026-03-23 17:35:46', 5, NULL, '2026-03-23 17:32:45', '2026-03-23 17:35:46'),
(18, '260009', 27, NULL, 'pending_return', NULL, 5, NULL, '2026-03-23 17:54:50', '2026-03-23 18:42:23'),
(19, '260009', 26, NULL, 'pending_return', NULL, 5, NULL, '2026-03-23 17:54:50', '2026-03-23 18:42:23'),
(20, '260010', 25, NULL, NULL, NULL, NULL, NULL, '2026-03-23 18:57:44', '2026-03-23 22:02:26'),
(21, '260010', 27, NULL, NULL, NULL, NULL, NULL, '2026-03-23 18:57:44', '2026-03-23 22:02:26'),
(22, '260011', 26, NULL, 'pending_return', NULL, 7, NULL, '2026-03-23 19:18:10', '2026-03-23 21:44:34'),
(23, '260012', 26, NULL, NULL, NULL, NULL, NULL, '2026-03-23 22:07:12', '2026-03-23 22:14:13'),
(24, '260012', 27, NULL, NULL, NULL, NULL, NULL, '2026-03-23 22:07:12', '2026-03-23 22:14:13'),
(25, '260013', 29, NULL, NULL, NULL, NULL, NULL, '2026-03-24 18:21:41', '2026-03-24 18:21:41'),
(26, '260014', 30, NULL, NULL, NULL, NULL, NULL, '2026-03-24 18:24:18', '2026-03-24 19:24:56'),
(27, '260014', 29, NULL, NULL, NULL, NULL, NULL, '2026-03-24 18:24:18', '2026-03-24 19:24:56'),
(28, '260015', 31, NULL, 'returned', '2026-03-24 23:51:09', 5, NULL, '2026-03-24 23:44:26', '2026-03-24 23:51:09'),
(29, '260015', 32, NULL, 'returned', '2026-03-24 23:51:09', 5, NULL, '2026-03-24 23:44:26', '2026-03-24 23:51:09'),
(30, 'GP2617', 31, NULL, 'returned', '2026-03-25 00:04:08', 5, NULL, '2026-03-24 23:59:09', '2026-03-25 00:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_logs`
--

CREATE TABLE `gatepass_logs` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `gatepass_no` varchar(20) NOT NULL,
  `log_type` enum('OUTGOING','INCOMING','PARTIAL') NOT NULL,
  `scanned_by_guard_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requester_employee_id` varchar(20) NOT NULL,
  `log_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatepass_logs`
--

INSERT INTO `gatepass_logs` (`log_id`, `gatepass_no`, `log_type`, `scanned_by_guard_id`, `requester_employee_id`, `log_datetime`, `remarks`, `created_at`, `updated_at`) VALUES
(11, '260001', 'OUTGOING', 5, 'EMP001', '2026-03-19 07:42:39', NULL, '2026-03-18 23:42:39', '2026-03-18 23:42:39'),
(12, '260001', 'INCOMING', 5, 'EMP001', '2026-03-23 02:13:38', NULL, '2026-03-22 18:13:38', '2026-03-22 18:13:38'),
(13, '260004', 'OUTGOING', 5, 'EMP001', '2026-03-23 04:41:25', NULL, '2026-03-22 20:41:25', '2026-03-22 20:41:25'),
(14, '260004', 'INCOMING', 5, 'EMP001', '2026-03-23 04:45:17', NULL, '2026-03-22 20:45:17', '2026-03-22 20:45:17'),
(15, '260007', 'OUTGOING', 5, 'EMP003', '2026-03-24 01:23:30', NULL, '2026-03-23 17:23:30', '2026-03-23 17:23:30'),
(16, '260007', 'INCOMING', 5, 'EMP003', '2026-03-24 01:26:07', NULL, '2026-03-23 17:26:07', '2026-03-23 17:26:07'),
(17, '260007', 'OUTGOING', 5, 'EMP003', '2026-03-24 01:28:08', NULL, '2026-03-23 17:28:08', '2026-03-23 17:28:08'),
(18, '260008', 'OUTGOING', 5, 'EMP003', '2026-03-24 01:34:51', NULL, '2026-03-23 17:34:51', '2026-03-23 17:34:51'),
(19, '260008', 'INCOMING', 5, 'EMP003', '2026-03-24 01:35:46', NULL, '2026-03-23 17:35:46', '2026-03-23 17:35:46'),
(20, '260009', 'OUTGOING', 5, 'EMP003', '2026-03-24 02:21:12', NULL, '2026-03-23 18:21:12', '2026-03-23 18:21:12'),
(21, '260009', 'INCOMING', 5, 'EMP003', '2026-03-24 02:42:23', NULL, '2026-03-23 18:42:23', '2026-03-23 18:42:23'),
(22, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 03:03:42', NULL, '2026-03-23 19:03:42', '2026-03-23 19:03:42'),
(23, '260010', 'INCOMING', 7, 'EMP003', '2026-03-24 03:04:16', NULL, '2026-03-23 19:04:16', '2026-03-23 19:04:16'),
(24, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 03:04:35', NULL, '2026-03-23 19:04:35', '2026-03-23 19:04:35'),
(25, '260010', 'INCOMING', 7, 'EMP003', '2026-03-24 03:16:40', NULL, '2026-03-23 19:16:40', '2026-03-23 19:16:40'),
(26, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 03:17:05', NULL, '2026-03-23 19:17:05', '2026-03-23 19:17:05'),
(27, '260011', 'OUTGOING', 7, 'EMP003', '2026-03-24 03:20:41', NULL, '2026-03-23 19:20:41', '2026-03-23 19:20:41'),
(28, '260011', 'INCOMING', 7, 'EMP003', '2026-03-24 03:20:52', NULL, '2026-03-23 19:20:52', '2026-03-23 19:20:52'),
(29, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 03:29:37', NULL, '2026-03-23 19:29:37', '2026-03-23 19:29:37'),
(30, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 05:09:41', NULL, '2026-03-23 21:09:41', '2026-03-23 21:09:41'),
(31, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 05:37:19', NULL, '2026-03-23 21:37:19', '2026-03-23 21:37:19'),
(32, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 05:37:51', NULL, '2026-03-23 21:37:51', '2026-03-23 21:37:51'),
(33, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 05:42:04', NULL, '2026-03-23 21:42:04', '2026-03-23 21:42:04'),
(34, '260011', 'OUTGOING', 7, 'EMP003', '2026-03-24 05:44:21', NULL, '2026-03-23 21:44:21', '2026-03-23 21:44:21'),
(35, '260011', 'INCOMING', 7, 'EMP003', '2026-03-24 05:44:34', NULL, '2026-03-23 21:44:34', '2026-03-23 21:44:34'),
(36, '260010', 'INCOMING', 7, 'EMP003', '2026-03-24 05:46:14', NULL, '2026-03-23 21:46:14', '2026-03-23 21:46:14'),
(37, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 05:46:29', NULL, '2026-03-23 21:46:29', '2026-03-23 21:46:29'),
(38, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 05:50:37', NULL, '2026-03-23 21:50:37', '2026-03-23 21:50:37'),
(39, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 05:50:56', NULL, '2026-03-23 21:50:56', '2026-03-23 21:50:56'),
(40, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 05:51:22', NULL, '2026-03-23 21:51:22', '2026-03-23 21:51:22'),
(41, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 06:00:15', NULL, '2026-03-23 22:00:15', '2026-03-23 22:00:15'),
(42, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:00:34', NULL, '2026-03-23 22:00:34', '2026-03-23 22:00:34'),
(43, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:00:56', NULL, '2026-03-23 22:00:56', '2026-03-23 22:00:56'),
(44, '260010', 'OUTGOING', 7, 'EMP003', '2026-03-24 06:01:17', NULL, '2026-03-23 22:01:17', '2026-03-23 22:01:17'),
(45, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:01:52', NULL, '2026-03-23 22:01:52', '2026-03-23 22:01:52'),
(46, '260010', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:02:26', NULL, '2026-03-23 22:02:26', '2026-03-23 22:02:26'),
(47, '260012', 'OUTGOING', 7, 'EMP003', '2026-03-24 06:11:11', NULL, '2026-03-23 22:11:11', '2026-03-23 22:11:11'),
(48, '260012', 'INCOMING', 7, 'EMP003', '2026-03-24 06:12:12', NULL, '2026-03-23 22:12:12', '2026-03-23 22:12:12'),
(49, '260012', 'OUTGOING', 7, 'EMP003', '2026-03-24 06:12:44', NULL, '2026-03-23 22:12:44', '2026-03-23 22:12:44'),
(50, '260012', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:13:33', NULL, '2026-03-23 22:13:33', '2026-03-23 22:13:33'),
(51, '260012', 'PARTIAL', 7, 'EMP003', '2026-03-24 06:14:13', NULL, '2026-03-23 22:14:13', '2026-03-23 22:14:13'),
(52, '260007', 'PARTIAL', 5, 'EMP003', '2026-03-25 02:01:36', NULL, '2026-03-24 18:01:36', '2026-03-24 18:01:36'),
(53, '260014', 'OUTGOING', 5, 'EMP003', '2026-03-25 02:26:40', NULL, '2026-03-24 18:26:40', '2026-03-24 18:26:40'),
(54, '260014', 'PARTIAL', 5, 'EMP003', '2026-03-25 02:27:49', NULL, '2026-03-24 18:27:49', '2026-03-24 18:27:49'),
(55, '260014', 'OUTGOING', 5, 'EMP003', '2026-03-25 02:42:08', NULL, '2026-03-24 18:42:08', '2026-03-24 18:42:08'),
(56, '260014', 'PARTIAL', 5, 'EMP003', '2026-03-25 02:43:32', NULL, '2026-03-24 18:43:32', '2026-03-24 18:43:32'),
(57, '260014', 'OUTGOING', 5, 'EMP003', '2026-03-25 02:43:57', NULL, '2026-03-24 18:43:57', '2026-03-24 18:43:57'),
(58, '260014', 'PARTIAL', 5, 'EMP003', '2026-03-25 03:02:16', NULL, '2026-03-24 19:02:16', '2026-03-24 19:02:16'),
(59, '260014', 'OUTGOING', 5, 'EMP003', '2026-03-25 03:03:55', NULL, '2026-03-24 19:03:55', '2026-03-24 19:03:55'),
(60, '260014', 'INCOMING', 5, 'EMP003', '2026-03-25 03:24:29', NULL, '2026-03-24 19:24:29', '2026-03-24 19:24:29'),
(61, '260014', 'OUTGOING', 5, 'EMP003', '2026-03-25 03:24:56', NULL, '2026-03-24 19:24:56', '2026-03-24 19:24:56'),
(62, '260015', 'OUTGOING', 5, 'EMP003', '2026-03-25 07:48:38', NULL, '2026-03-24 23:48:38', '2026-03-24 23:48:38'),
(63, '260015', 'INCOMING', 5, 'EMP003', '2026-03-25 07:51:09', NULL, '2026-03-24 23:51:09', '2026-03-24 23:51:09'),
(64, 'GP2617', 'OUTGOING', 5, 'EMP003', '2026-03-25 08:02:51', NULL, '2026-03-25 00:02:51', '2026-03-25 00:02:51'),
(65, 'GP2617', 'INCOMING', 5, 'EMP003', '2026-03-25 08:04:08', NULL, '2026-03-25 00:04:08', '2026-03-25 00:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_rejection_missing_items`
--

CREATE TABLE `gatepass_rejection_missing_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gatepass_no` varchar(255) NOT NULL,
  `gatepass_item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gatepass_rejection_missing_items`
--

INSERT INTO `gatepass_rejection_missing_items` (`id`, `gatepass_no`, `gatepass_item_id`, `created_at`, `updated_at`) VALUES
(1, '260001', 6, '2026-03-22 18:11:46', '2026-03-22 18:11:46'),
(2, '260001', 6, '2026-03-22 18:14:44', '2026-03-22 18:14:44'),
(3, '260003', 8, '2026-03-22 18:31:50', '2026-03-22 18:31:50'),
(4, '260003', 8, '2026-03-22 19:18:43', '2026-03-22 19:18:43'),
(5, '260003', 9, '2026-03-22 19:18:43', '2026-03-22 19:18:43'),
(6, '260003', 10, '2026-03-22 19:18:43', '2026-03-22 19:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_requests`
--

CREATE TABLE `gatepass_requests` (
  `gatepass_no` varchar(20) NOT NULL,
  `request_date` date NOT NULL,
  `requester_employee_id` varchar(20) NOT NULL,
  `center` varchar(100) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `rejection_reason` text DEFAULT NULL,
  `incoming_inspection_remarks` text DEFAULT NULL,
  `incoming_inspected_at` timestamp NULL DEFAULT NULL,
  `incoming_inspected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `noted_by_employee_id` varchar(20) DEFAULT NULL,
  `authorized_by_employee_id` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qr_code_path` varchar(255) DEFAULT NULL,
  `qr_code_generated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatepass_requests`
--

INSERT INTO `gatepass_requests` (`gatepass_no`, `request_date`, `requester_employee_id`, `center`, `purpose`, `destination`, `remarks`, `status`, `rejection_reason`, `incoming_inspection_remarks`, `incoming_inspected_at`, `incoming_inspected_by`, `noted_by_employee_id`, `authorized_by_employee_id`, `created_at`, `updated_at`, `qr_code_path`, `qr_code_generated_at`) VALUES
('260000', '2026-03-18', 'EMP001', 'ICTD', 'Gaming', 'Apartment', NULL, 'Rejected', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-17 18:55:04', '2026-03-19 00:01:07', 'gatepass_qr/260000.svg', '2026-03-19 02:18:48'),
('260001', '2026-03-19', 'EMP001', 'ICTD', 'Gaming Room', 'Binondo', NULL, 'Rejected', 'Rejected by guard: missing item(s) - AR9485', NULL, NULL, NULL, NULL, NULL, '2026-03-18 16:49:46', '2026-03-22 18:11:46', 'gatepass_qr/260001.svg', '2026-03-19 02:19:41'),
('260002', '2026-03-19', 'EMP001', 'ICTD', 'Team Building', 'Canada', 'For Testing lang', 'Approved', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-18 19:04:59', '2026-03-18 21:21:55', 'gatepass_qr/260002.svg', '2026-03-19 05:21:55'),
('260003', '2026-03-23', 'EMP001', 'ICTD', 'School Purpose', 'UMAK', NULL, 'Rejected', 'Rejected by guard: missing item(s) - AR0091, AR8593, AR9485', NULL, NULL, NULL, NULL, NULL, '2026-03-22 18:18:09', '2026-03-22 19:18:43', 'gatepass_qr/260003.png', '2026-03-23 02:18:40'),
('260004', '2026-03-23', 'EMP001', 'ICTD', 'For Camping', 'UMAK', 'Dipende Kay Nicole', 'Approved', NULL, NULL, '2026-03-22 20:45:17', 5, NULL, NULL, '2026-03-22 20:36:31', '2026-03-22 23:24:50', 'gatepass_qr/260004.png', '2026-03-23 04:37:00'),
('260005', '2026-03-23', 'EMP003', 'ICTD', 'Gaming', 'Home', 'N/A', 'Approved', 'Kulang', NULL, NULL, NULL, NULL, NULL, '2026-03-22 22:42:18', '2026-03-22 22:50:24', 'gatepass_qr/260005.png', '2026-03-23 06:43:12'),
('260006', '2026-03-24', 'EMP003', 'ICTD', 'YGHN', 'Apartment', NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-23 17:16:04', '2026-03-23 17:16:04', NULL, NULL),
('260007', '2026-03-24', 'EMP003', 'ICTD', 'sdsa', 'sdadas', NULL, 'Incoming Partial', NULL, NULL, '2026-03-24 18:01:12', 5, NULL, NULL, '2026-03-23 17:19:49', '2026-03-24 18:01:36', 'gatepass_qr/260007.png', '2026-03-24 01:20:14'),
('260008', '2026-03-24', 'EMP003', 'ICTD', 'dun', 'test', NULL, 'Returned', NULL, NULL, '2026-03-23 17:35:46', 5, NULL, NULL, '2026-03-23 17:32:45', '2026-03-23 17:35:46', 'gatepass_qr/260008.png', '2026-03-24 01:32:53'),
('260009', '2026-03-24', 'EMP003', 'ICTD', 'SADAS', 'asa', NULL, 'Rejected', NULL, NULL, '2026-03-23 18:42:23', 5, NULL, NULL, '2026-03-23 17:54:50', '2026-03-23 18:56:35', 'gatepass_qr/260009.png', '2026-03-24 01:55:13'),
('260010', '2026-03-24', 'EMP003', 'ICTD', 'asa', 'asdsa', NULL, 'Approved', NULL, NULL, '2026-03-23 22:01:44', 7, NULL, NULL, '2026-03-23 18:57:44', '2026-03-23 22:02:26', 'gatepass_qr/260010.png', '2026-03-24 02:57:50'),
('260011', '2026-03-24', 'EMP003', 'ICTD', 'Gaming', 'sada', NULL, 'Returned', NULL, NULL, '2026-03-23 21:44:34', 7, NULL, NULL, '2026-03-23 19:18:10', '2026-03-23 21:44:34', 'gatepass_qr/260011.png', '2026-03-24 03:18:29'),
('260012', '2026-03-24', 'EMP003', 'ICTD', 'Team Building', 'Cubao', 'N/A', 'Approved', NULL, NULL, '2026-03-23 22:13:04', 7, NULL, NULL, '2026-03-23 22:07:12', '2026-03-23 22:14:13', 'gatepass_qr/260012.png', '2026-03-24 06:09:14'),
('260013', '2026-03-25', 'EMP003', 'ICTD', 'ML', 'Bootcamp BGC', NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-24 18:21:41', '2026-03-24 18:21:41', NULL, NULL),
('260014', '2026-03-25', 'EMP003', 'ICTD', 'For ML, CODM', 'Bootcamp BGC Campus', NULL, 'Approved', NULL, NULL, '2026-03-24 19:24:29', 5, NULL, NULL, '2026-03-24 18:24:18', '2026-03-24 19:24:56', 'gatepass_qr/260014.png', '2026-03-25 02:24:59'),
('260015', '2026-03-25', 'EMP003', 'ICTD', 'To Play God of War', 'Home', NULL, 'Returned', NULL, NULL, '2026-03-24 23:51:09', 5, NULL, NULL, '2026-03-24 23:44:25', '2026-03-24 23:51:09', 'gatepass_qr/260015.png', '2026-03-25 07:45:26'),
('GP2617', '2026-03-25', 'EMP003', 'ICTD', 'GTA 5', 'Bootcamp Shangrila BGC', NULL, 'Returned', NULL, NULL, '2026-03-25 00:04:08', 5, NULL, NULL, '2026-03-24 23:59:09', '2026-03-25 00:04:08', 'gatepass_qr/GP2617.png', '2026-03-25 08:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `current_prop_no` varchar(8) DEFAULT NULL,
  `serial_no` varchar(30) DEFAULT NULL,
  `acct_code` varchar(10) DEFAULT NULL,
  `pn_old` varchar(6) DEFAULT NULL,
  `pn_code_old` varchar(6) DEFAULT NULL,
  `mrr_no` varchar(9) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `center` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `accountability` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `employee_id`, `current_prop_no`, `serial_no`, `acct_code`, `pn_old`, `pn_code_old`, `mrr_no`, `description`, `center`, `status`, `accountability`, `created_at`, `updated_at`) VALUES
(14, 'EMP001', 'AR0091', '6GHH909', '253-381', NULL, NULL, '566455', 'MCBOOK PRO', 'ICTD', 'A', 'Accountable', '2026-03-16 21:46:47', '2026-03-16 22:43:43'),
(21, 'EMP001', 'AR8593', '74HDHHR', '940-393', NULL, NULL, 'N/A', 'PREDATOR', 'ICTD', 'I', 'Accountable', '2026-03-17 00:03:40', '2026-03-17 16:53:58'),
(22, 'EMP004', 'ARO056', '55RRY', '655-543', NULL, NULL, 'N/A', 'LENOVO LEGION 5', 'Admin', 'I', 'Accountable', '2026-03-17 00:04:54', '2026-03-17 00:05:03'),
(23, 'EMP001', 'AR9485', NULL, '930-224', NULL, NULL, 'N/A', 'POCO X8 PRO', 'Admin', 'A', 'Accountable', '2026-03-17 18:50:46', '2026-03-17 18:50:46'),
(25, 'EMP003', 'AR28241', 'A7464HDU4', '920-283', NULL, NULL, NULL, 'SAMSUNG GALAXY S25 ULTRA', 'ICTD', 'A', 'Accountable', '2026-03-22 22:04:28', '2026-03-22 22:04:44'),
(26, 'EMP003', 'AR28321', 'JD3831DJVT', '931-245', NULL, NULL, NULL, 'IPHONE 17 PRO MAX 1TB', 'Admin', 'A', 'Accountable', '2026-03-23 17:09:40', '2026-03-23 17:09:50'),
(27, 'EMP003', 'AR3821', 'URHDHI213492', '515-321', NULL, NULL, NULL, 'IPAD M7', 'ICTD', 'A', 'Accountable', '2026-03-23 17:13:20', '2026-03-23 17:13:39'),
(28, 'EMP007', 'AR9489', NULL, '201-124', NULL, NULL, NULL, 'LEGION 5i', 'ICTD', 'A', 'Accountable', '2026-03-23 22:28:27', '2026-03-23 22:28:27'),
(29, 'EMP003', 'AR3321', '8584JJFJFUE', '542-311', NULL, NULL, NULL, 'NUBIA NEO 5 GT 5G', 'Admin', 'A', 'Accountable', '2026-03-24 18:20:30', '2026-03-24 18:35:57'),
(30, 'EMP003', 'AR1134', '8JDFU4841', '399-321', NULL, NULL, NULL, 'RedMagic 11 Pro', 'ICTD', 'A', 'Accountable', '2026-03-24 18:23:22', '2026-03-24 18:35:49'),
(31, 'EMP003', 'AR03921', NULL, '938-121', NULL, NULL, NULL, 'STEAM DECK', 'ICTD', 'A', 'Accountable', '2026-03-24 23:40:32', '2026-03-24 23:40:32'),
(32, 'EMP003', 'AR03994', NULL, '733-124', NULL, NULL, NULL, 'ASUS ROG ALLY', 'ICTD', 'A', 'Accountable', '2026-03-24 23:41:07', '2026-03-24 23:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_end_user_history`
--

CREATE TABLE `inventory_end_user_history` (
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `end_user` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `unassigned_at` datetime DEFAULT NULL,
  `assigned_by` varchar(20) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_end_user_history`
--

INSERT INTO `inventory_end_user_history` (`assignment_id`, `inventory_id`, `end_user`, `created_at`, `unassigned_at`, `assigned_by`, `notes`) VALUES
(5, 14, 'Juan Dela Cruz', '2026-03-17 13:46:47', NULL, NULL, NULL),
(12, 21, 'Zoro Roronoa', '2026-03-17 16:03:40', NULL, NULL, NULL),
(13, 22, 'Juan Dela Cruz', '2026-03-17 16:04:54', NULL, NULL, NULL),
(14, 23, 'Zoro Roronoa', '2026-03-18 10:50:46', NULL, NULL, NULL),
(16, 25, 'Nicole De Jesus', '2026-03-23 14:04:28', NULL, NULL, NULL),
(17, 26, 'Nicole De Jesus', '2026-03-24 09:09:40', NULL, NULL, NULL),
(18, 27, 'Nicole De Jesus', '2026-03-24 09:13:20', NULL, NULL, NULL),
(19, 28, 'Nicolas', '2026-03-24 14:28:27', NULL, NULL, NULL),
(20, 29, 'Nicole De Jesus', '2026-03-25 10:20:30', NULL, NULL, NULL),
(21, 30, 'Nicole De Jesus', '2026-03-25 10:23:22', NULL, NULL, NULL),
(22, 31, 'Nicole De Jesus', '2026-03-25 15:40:32', NULL, NULL, NULL),
(23, 32, 'Nicole De Jesus', '2026-03-25 15:41:07', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_propno_history`
--

CREATE TABLE `inventory_propno_history` (
  `history_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `prop_no` varchar(8) NOT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `changed_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_propno_history`
--

INSERT INTO `inventory_propno_history` (`history_id`, `inventory_id`, `prop_no`, `is_current`, `changed_at`, `created_at`, `updated_at`, `changed_by`) VALUES
(7, 14, 'AR0090', 0, '2026-03-16 21:46:47', '2026-03-16 21:46:47', '2026-03-16 21:47:14', NULL),
(8, 14, 'AR0091', 1, '2026-03-16 21:47:14', '2026-03-16 21:47:14', '2026-03-16 21:47:14', NULL),
(16, 21, 'AR8593', 1, '2026-03-17 00:03:40', '2026-03-17 00:03:40', '2026-03-17 00:03:40', NULL),
(17, 22, 'ARO056', 1, '2026-03-17 00:04:54', '2026-03-17 00:04:54', '2026-03-17 00:04:54', NULL),
(18, 23, 'AR9485', 1, '2026-03-17 18:50:46', '2026-03-17 18:50:46', '2026-03-17 18:50:46', NULL),
(20, 25, 'AR28241', 1, '2026-03-22 22:04:28', '2026-03-22 22:04:28', '2026-03-22 22:04:28', NULL),
(21, 26, 'AR28321', 1, '2026-03-23 17:09:40', '2026-03-23 17:09:40', '2026-03-23 17:09:40', NULL),
(22, 27, 'AR3821', 1, '2026-03-23 17:13:20', '2026-03-23 17:13:20', '2026-03-23 17:13:20', NULL),
(23, 28, 'AR9489', 1, '2026-03-23 22:28:27', '2026-03-23 22:28:27', '2026-03-23 22:28:27', NULL),
(24, 29, 'AR3321', 1, '2026-03-24 18:20:30', '2026-03-24 18:20:30', '2026-03-24 18:20:30', NULL),
(25, 30, 'AR1134', 1, '2026-03-24 18:23:22', '2026-03-24 18:23:22', '2026-03-24 18:23:22', NULL),
(26, 31, 'AR03921', 1, '2026-03-24 23:40:32', '2026-03-24 23:40:32', '2026-03-24 23:40:32', NULL),
(27, 32, 'AR03994', 1, '2026-03-24 23:41:07', '2026-03-24 23:41:07', '2026-03-24 23:41:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_remarks_history`
--

CREATE TABLE `inventory_remarks_history` (
  `remark_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `remark_text` varchar(500) DEFAULT NULL,
  `remark_type` varchar(50) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_remarks_history`
--

INSERT INTO `inventory_remarks_history` (`remark_id`, `inventory_id`, `remark_text`, `remark_type`, `created_by`, `created_at`) VALUES
(4, 14, 'wala', NULL, NULL, '2026-03-17 05:46:47'),
(5, 14, 'wala lang', NULL, NULL, '2026-03-17 05:49:58'),
(12, 14, 'Testing Lods', NULL, NULL, '2026-03-17 08:01:49'),
(13, 21, NULL, NULL, NULL, '2026-03-17 08:03:40'),
(14, 22, NULL, NULL, NULL, '2026-03-17 08:04:54'),
(15, 23, NULL, NULL, NULL, '2026-03-18 02:50:46'),
(17, 25, NULL, NULL, NULL, '2026-03-23 06:04:28'),
(18, 26, NULL, NULL, NULL, '2026-03-24 01:09:40'),
(19, 27, NULL, NULL, NULL, '2026-03-24 01:13:20'),
(20, 28, NULL, NULL, NULL, '2026-03-24 06:28:27'),
(21, 29, NULL, NULL, NULL, '2026-03-25 02:20:30'),
(22, 30, NULL, NULL, NULL, '2026-03-25 02:23:22'),
(23, 31, NULL, NULL, NULL, '2026-03-25 07:40:32'),
(24, 32, NULL, NULL, NULL, '2026-03-25 07:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_unit_cost_history`
--

CREATE TABLE `inventory_unit_cost_history` (
  `cost_history_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `effective_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `changed_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_unit_cost_history`
--

INSERT INTO `inventory_unit_cost_history` (`cost_history_id`, `inventory_id`, `unit_cost`, `effective_date`, `remarks`, `changed_by`, `created_at`) VALUES
(6, 14, 50000.00, NULL, NULL, NULL, '2026-03-17 05:46:47'),
(7, 14, 50001.00, NULL, NULL, NULL, '2026-03-17 05:48:42'),
(14, 21, 75000.00, NULL, NULL, NULL, '2026-03-17 08:03:40'),
(15, 22, 75000.00, NULL, NULL, NULL, '2026-03-17 08:04:54'),
(16, 23, 75000.00, NULL, NULL, NULL, '2026-03-18 02:50:46'),
(18, 25, 70000.00, NULL, NULL, NULL, '2026-03-23 06:04:28'),
(19, 23, 19990.00, NULL, NULL, NULL, '2026-03-23 08:32:20'),
(20, 26, 70000.00, NULL, NULL, NULL, '2026-03-24 01:09:40'),
(21, 27, 53000.00, NULL, NULL, NULL, '2026-03-24 01:13:20'),
(22, 28, 30000.00, NULL, NULL, NULL, '2026-03-24 06:28:27'),
(23, 29, 40000.00, NULL, NULL, NULL, '2026-03-25 02:20:30'),
(24, 30, 34000.00, NULL, NULL, NULL, '2026-03-25 02:23:22'),
(25, 31, 35000.00, NULL, NULL, NULL, '2026-03-25 07:40:32'),
(26, 32, 45000.00, NULL, NULL, NULL, '2026-03-25 07:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_11_072218_add_role_to_users_table', 2),
(5, '2026_03_16_043147_create_employee_profiles_table', 3),
(6, '2026_03_17_044944_add_is_current_to_inventory_propno_history', 4),
(7, '2026_03_16_235227_create_inventory_table', 5),
(8, '2026_03_17_052349_add_current_prop_no_to_inventory_table', 6),
(9, '2026_03_17_052357_rename_remarks_to_remark_text_in_inventory_remarks_history', 6),
(10, '2026_03_17_052450_add_is_current_and_changed_at_to_inventory_propno_history', 6),
(11, '2026_03_17_054004_add_pn_old_columns_to_inventory', 7),
(12, '2026_03_17_054138_add_missing_inventory_columns_for_coordinator', 8),
(13, '2026_03_17_054359_add_timestamps_to_inventory_propno_history', 9),
(15, '2026_03_19_075142_add_rejection_reason_to_gatepass_requests_table', 10),
(16, '2026_03_23_020457_create_gatepass_rejection_missing_items_table', 11),
(17, '2026_03_23_042902_add_item_return_tracking_to_gatepass_items_and_requests', 12),
(18, '2026_03_24_021620_alter_item_status_default_on_gatepass_items_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('375xLhkk6dd38TgIRnerBFIlRb3XSCANwPey7JEH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/2.5.25 Chrome/142.0.7444.265 Electron/39.4.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNk1IVGU0a0hTRUV2SlFrRWhmWXl4anY5Yjg4TTYxdmpyT3JTRkh3aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774488932),
('c14Y5H6hNX1YqLzF9VhOmCh9aKUuImyQTQHp72sj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/2.5.25 Chrome/142.0.7444.265 Electron/39.4.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjZJWGlkWjRCalFYM3E0NG9BZklLWkx4N0tzcWR1eURUb1V1aks0ZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774488912),
('HyvmrLwwMX8OakWQYnvkJi9XUYXAKdbxt27g0ow5', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEVueG9iRXlXWXVhTkFxb0Y3dGdGYWl5WmEzVmZ5SE05V0RKdGEyciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ndWFyZCI7czo1OiJyb3V0ZSI7czo1OiJndWFyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1774426717),
('QEhUPXbRSL1KCpV7gejaOVihXLVfRQ6lYmTrGOnd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmh2MTVwUDZQMDVaTWxQWUNpNHpRUEpEVVpuejRQbVFTZzJ2eEVObyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1774426094),
('UMfuYH2GWE59SlE5SgWn4wPmDx765cX0AIfWbKh4', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOUNRNnFiT3NKemE1a29JT01wTHdpcjlTVnNpYUNNTlU0T0FjbXVQeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ndWFyZCI7czo1OiJyb3V0ZSI7czo1OiJndWFyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1774489764);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Vince', 'employee@dap.com', NULL, '$2y$12$w7dN29T33iMT5NXxUFF5...1.9RImUn7zy86fWzFgN.QwJMchcbUK', NULL, NULL, '2026-03-10 23:46:47', 'employee'),
(2, 'Admin User', 'admin@dap.com', NULL, '$2y$12$s0KVLyvIAJI/4mVitVOTRu5YNncw.Wi2ekRYDPJZmUFlt1Yz9V.qC', NULL, '2026-03-12 18:45:25', '2026-03-12 18:45:25', 'admin'),
(3, 'Admin Coordinator', 'coordinator@dap.com', NULL, '$2y$12$B/M7CCKg3UE7xGhFhwq34OmA/fu4jUT/rl9H6KYA3l/osI6HOaYnW', NULL, '2026-03-12 21:36:24', '2026-03-12 21:36:24', 'coordinator'),
(4, 'Juan Dela Cruz', 'juan@dap.com', NULL, '$2y$12$WMMRa8V6N56nOWOQX0znLe/ALt6k5SVmG4EpPnlMsmwpv9seLJ9f.', NULL, '2026-03-15 20:36:56', '2026-03-15 20:36:56', 'employee'),
(5, 'Guard User', 'guard@dap.com', NULL, '$2y$12$OinyG5Y88oPAaWk1k7lOr.MSRjI1TrrAWAnlh3dbiUBpKfeWHFVAi', NULL, '2026-03-18 19:18:28', '2026-03-18 19:18:28', 'guard'),
(7, 'Nicole', 'nicole@dap.com', NULL, '$2y$12$YfZbV/EZu/ECZlqN5pgACe5q/BTGSJFD9iBai83gxVbznqlwntJm2', NULL, '2026-03-22 21:57:01', '2026-03-22 21:57:01', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gatepass_items`
--
ALTER TABLE `gatepass_items`
  ADD PRIMARY KEY (`gatepass_item_id`),
  ADD UNIQUE KEY `uq_gatepass_inventory` (`gatepass_no`,`inventory_id`),
  ADD KEY `fk_gatepass_items_inventory` (`inventory_id`),
  ADD KEY `gatepass_items_last_inspected_by_foreign` (`last_inspected_by`);

--
-- Indexes for table `gatepass_logs`
--
ALTER TABLE `gatepass_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_gatepass_logs_gatepass` (`gatepass_no`),
  ADD KEY `fk_gatepass_logs_requester` (`requester_employee_id`),
  ADD KEY `fk_gatepass_logs_scanned_by_guard` (`scanned_by_guard_id`);

--
-- Indexes for table `gatepass_rejection_missing_items`
--
ALTER TABLE `gatepass_rejection_missing_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gatepass_requests`
--
ALTER TABLE `gatepass_requests`
  ADD PRIMARY KEY (`gatepass_no`),
  ADD KEY `fk_gatepass_requester` (`requester_employee_id`),
  ADD KEY `fk_gatepass_noted_by` (`noted_by_employee_id`),
  ADD KEY `fk_gatepass_authorized_by` (`authorized_by_employee_id`),
  ADD KEY `gatepass_requests_incoming_inspected_by_foreign` (`incoming_inspected_by`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `current_prop_no` (`current_prop_no`),
  ADD KEY `fk_inventory_employee` (`employee_id`);

--
-- Indexes for table `inventory_end_user_history`
--
ALTER TABLE `inventory_end_user_history`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `fk_enduser_history_inventory` (`inventory_id`),
  ADD KEY `fk_enduser_history_employee` (`assigned_by`);

--
-- Indexes for table `inventory_propno_history`
--
ALTER TABLE `inventory_propno_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `fk_prop_history_inventory` (`inventory_id`),
  ADD KEY `fk_prop_history_employee` (`changed_by`);

--
-- Indexes for table `inventory_remarks_history`
--
ALTER TABLE `inventory_remarks_history`
  ADD PRIMARY KEY (`remark_id`),
  ADD KEY `fk_remarks_history_inventory` (`inventory_id`),
  ADD KEY `fk_remarks_history_employee` (`created_by`);

--
-- Indexes for table `inventory_unit_cost_history`
--
ALTER TABLE `inventory_unit_cost_history`
  ADD PRIMARY KEY (`cost_history_id`),
  ADD KEY `fk_cost_history_inventory` (`inventory_id`),
  ADD KEY `fk_cost_history_employee` (`changed_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepass_items`
--
ALTER TABLE `gatepass_items`
  MODIFY `gatepass_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gatepass_logs`
--
ALTER TABLE `gatepass_logs`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `gatepass_rejection_missing_items`
--
ALTER TABLE `gatepass_rejection_missing_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `inventory_end_user_history`
--
ALTER TABLE `inventory_end_user_history`
  MODIFY `assignment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `inventory_propno_history`
--
ALTER TABLE `inventory_propno_history`
  MODIFY `history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inventory_remarks_history`
--
ALTER TABLE `inventory_remarks_history`
  MODIFY `remark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `inventory_unit_cost_history`
--
ALTER TABLE `inventory_unit_cost_history`
  MODIFY `cost_history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gatepass_items`
--
ALTER TABLE `gatepass_items`
  ADD CONSTRAINT `fk_gatepass_items_gatepass` FOREIGN KEY (`gatepass_no`) REFERENCES `gatepass_requests` (`gatepass_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_items_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gatepass_items_last_inspected_by_foreign` FOREIGN KEY (`last_inspected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gatepass_logs`
--
ALTER TABLE `gatepass_logs`
  ADD CONSTRAINT `fk_gatepass_logs_gatepass` FOREIGN KEY (`gatepass_no`) REFERENCES `gatepass_requests` (`gatepass_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_logs_requester` FOREIGN KEY (`requester_employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_logs_scanned_by_guard` FOREIGN KEY (`scanned_by_guard_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `gatepass_requests`
--
ALTER TABLE `gatepass_requests`
  ADD CONSTRAINT `fk_gatepass_authorized_by` FOREIGN KEY (`authorized_by_employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_noted_by` FOREIGN KEY (`noted_by_employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_requester` FOREIGN KEY (`requester_employee_id`) REFERENCES `employees` (`employee_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gatepass_requests_incoming_inspected_by_foreign` FOREIGN KEY (`incoming_inspected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inventory_end_user_history`
--
ALTER TABLE `inventory_end_user_history`
  ADD CONSTRAINT `fk_enduser_history_employee` FOREIGN KEY (`assigned_by`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_enduser_history_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_propno_history`
--
ALTER TABLE `inventory_propno_history`
  ADD CONSTRAINT `fk_prop_history_employee` FOREIGN KEY (`changed_by`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prop_history_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_remarks_history`
--
ALTER TABLE `inventory_remarks_history`
  ADD CONSTRAINT `fk_remarks_history_employee` FOREIGN KEY (`created_by`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_remarks_history_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_unit_cost_history`
--
ALTER TABLE `inventory_unit_cost_history`
  ADD CONSTRAINT `fk_cost_history_employee` FOREIGN KEY (`changed_by`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cost_history_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
