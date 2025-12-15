-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2022 at 07:40 PM
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
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL COMMENT '1: pre-employee, 2: employee',
  `duration` int(11) DEFAULT NULL COMMENT '(in minutes)',
  `start_time` timestamp NULL DEFAULT NULL COMMENT 'datetime of starting assignment',
  `end_time` timestamp NULL DEFAULT NULL COMMENT 'Last time of starting the assignment',
  `buffer_time` int(11) DEFAULT NULL COMMENT '(in minutes)',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `verify_code` varchar(15) DEFAULT NULL,
  `url_code` varchar(255) DEFAULT NULL,
  `total_question` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `test_id`, `user_id`, `user_type`, `duration`, `start_time`, `end_time`, `buffer_time`, `created_at`, `updated_at`, `deleted_at`, `verify_code`, `url_code`, `total_question`) VALUES
(1, 101, NULL, 1, 60, '2022-08-12 10:45:00', '2022-08-12 11:45:00', 10, '2022-08-07 03:11:56', '2022-08-07 03:11:56', NULL, '0AeqJyh2', '8VnrCaYpITliKS1yFB9z', 5),
(3, 101, NULL, 1, 60, '2022-08-10 10:15:00', '2022-08-10 11:15:00', 10, '2022-08-07 03:46:31', '2022-08-07 03:46:31', NULL, 'Delta', 'ZvGz7mRQC1SdeMcL4aob', 5),
(4, 101, NULL, 1, 30, '2022-08-12 09:30:00', '2022-08-12 10:30:00', 10, '2022-08-07 04:00:01', '2022-08-07 04:00:01', NULL, 'DeltaAcademy', 'bTtgxGMrHeBi7JzSY26u', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
