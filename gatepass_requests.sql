-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 09:37 AM
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
('260005', '2026-03-23', 'EMP002', 'ICTD', 'Gaming', 'Home', 'N/A', 'Approved', 'Kulang', NULL, NULL, NULL, NULL, NULL, '2026-03-22 22:42:18', '2026-03-22 22:50:24', 'gatepass_qr/260005.png', '2026-03-23 06:43:12'),
('260006', '2026-03-24', 'EMP002', 'ICTD', 'YGHN', 'Apartment', NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-23 17:16:04', '2026-03-23 17:16:04', NULL, NULL),
('260007', '2026-03-24', 'EMP002', 'ICTD', 'sdsa', 'sdadas', NULL, 'Incoming Partial', NULL, NULL, '2026-03-24 18:01:12', 5, NULL, NULL, '2026-03-23 17:19:49', '2026-03-24 18:01:36', 'gatepass_qr/260007.png', '2026-03-24 01:20:14'),
('260008', '2026-03-24', 'EMP002', 'ICTD', 'dun', 'test', NULL, 'Returned', NULL, NULL, '2026-03-23 17:35:46', 5, NULL, NULL, '2026-03-23 17:32:45', '2026-03-23 17:35:46', 'gatepass_qr/260008.png', '2026-03-24 01:32:53'),
('260009', '2026-03-24', 'EMP002', 'ICTD', 'SADAS', 'asa', NULL, 'Rejected', NULL, NULL, '2026-03-23 18:42:23', 5, NULL, NULL, '2026-03-23 17:54:50', '2026-03-23 18:56:35', 'gatepass_qr/260009.png', '2026-03-24 01:55:13'),
('260010', '2026-03-24', 'EMP002', 'ICTD', 'asa', 'asdsa', NULL, 'Approved', NULL, NULL, '2026-03-23 22:01:44', 7, NULL, NULL, '2026-03-23 18:57:44', '2026-03-23 22:02:26', 'gatepass_qr/260010.png', '2026-03-24 02:57:50'),
('260011', '2026-03-24', 'EMP002', 'ICTD', 'Gaming', 'sada', NULL, 'Returned', NULL, NULL, '2026-03-23 21:44:34', 7, NULL, NULL, '2026-03-23 19:18:10', '2026-03-23 21:44:34', 'gatepass_qr/260011.png', '2026-03-24 03:18:29'),
('260012', '2026-03-24', 'EMP002', 'ICTD', 'Team Building', 'Cubao', 'N/A', 'Approved', NULL, NULL, '2026-03-23 22:13:04', 7, NULL, NULL, '2026-03-23 22:07:12', '2026-03-23 22:14:13', 'gatepass_qr/260012.png', '2026-03-24 06:09:14'),
('260013', '2026-03-25', 'EMP002', 'ICTD', 'ML', 'Bootcamp BGC', NULL, 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-24 18:21:41', '2026-03-24 18:21:41', NULL, NULL),
('260014', '2026-03-25', 'EMP002', 'ICTD', 'For ML, CODM', 'Bootcamp BGC Campus', NULL, 'Approved', NULL, NULL, '2026-03-24 19:24:29', 5, NULL, NULL, '2026-03-24 18:24:18', '2026-03-24 19:24:56', 'gatepass_qr/260014.png', '2026-03-25 02:24:59'),
('260015', '2026-03-25', 'EMP002', 'ICTD', 'To Play God of War', 'Home', NULL, 'Returned', NULL, NULL, '2026-03-24 23:51:09', 5, NULL, NULL, '2026-03-24 23:44:25', '2026-03-24 23:51:09', 'gatepass_qr/260015.png', '2026-03-25 07:45:26'),
('GP2617', '2026-03-25', 'EMP002', 'ICTD', 'GTA 5', 'Bootcamp Shangrila BGC', NULL, 'Approved', NULL, NULL, '2026-03-25 00:04:08', 5, NULL, NULL, '2026-03-24 23:59:09', '2026-03-25 21:02:39', 'gatepass_qr/GP2617.png', '2026-03-25 08:00:33'),
('GP2618', '2026-03-26', 'EMP002', 'ICTD', 'Work From Home', 'Mind Lounge Uptown', NULL, 'Approved', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-25 18:28:23', '2026-03-25 18:29:42', 'gatepass_qr/GP2618.png', '2026-03-26 02:29:42'),
('GP2619', '2026-03-26', 'EMP005', 'Admin', 'WFH', 'Home', 'Charger', 'Returned', NULL, NULL, '2026-03-25 21:08:12', 5, NULL, NULL, '2026-03-25 20:47:17', '2026-03-25 21:08:12', 'gatepass_qr/GP2619.png', '2026-03-26 04:59:02'),
('GP2620', '2026-03-30', 'EMP006', 'ICTD', 'MPL', 'Indonesia', 'I need Charger', 'Approved', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-29 21:00:50', '2026-03-29 21:01:13', 'gatepass_qr/GP2620.png', '2026-03-30 05:01:13');

--
-- Indexes for dumped tables
--

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
-- Constraints for dumped tables
--

--
-- Constraints for table `gatepass_requests`
--
ALTER TABLE `gatepass_requests`
  ADD CONSTRAINT `fk_gatepass_authorized_by` FOREIGN KEY (`authorized_by_employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_noted_by` FOREIGN KEY (`noted_by_employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gatepass_requester` FOREIGN KEY (`requester_employee_id`) REFERENCES `employees` (`employee_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gatepass_requests_incoming_inspected_by_foreign` FOREIGN KEY (`incoming_inspected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
