-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2022 at 07:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delta_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment_accounts`
--

CREATE TABLE `assessment_accounts` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `elapsed_time` bigint(20) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: started, 2: completed',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `total_assignment_marks` int(11) NOT NULL DEFAULT 0,
  `result_marks` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assessment_accounts`
--

INSERT INTO `assessment_accounts` (`id`, `assignment_id`, `first_name`, `last_name`, `email`, `phone`, `code`, `active`, `elapsed_time`, `status`, `created_at`, `updated_at`, `deleted_at`, `total_assignment_marks`, `result_marks`) VALUES
(1, 4, 'Manish', 'Giri', 'mg@gmail.com', '7477374417', 'iFnbqa', 0, 745, 1, '2022-08-07 06:56:27', '2022-08-07 11:55:53', NULL, 0, 0),
(2, 3, 'Manish', 'Giri', 'ma@gmail.com', '7477374417', 'qrikLV', 0, 70, 1, '2022-08-08 09:59:13', '2022-08-08 10:06:15', NULL, 0, 0),
(6, 3, 'Anirban', 'Pan', 'ap@gmail.com', '7845741200', 'KWMjoQ', 0, 3600, 1, '2022-08-08 10:40:43', '2022-08-08 10:47:55', NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessment_accounts`
--
ALTER TABLE `assessment_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessment_accounts`
--
ALTER TABLE `assessment_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
