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
-- Table structure for table `assignment_questions`
--

CREATE TABLE `assignment_questions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `assessment_account_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `is_correct` int(11) NOT NULL DEFAULT 0,
  `marks` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment_questions`
--

INSERT INTO `assignment_questions` (`id`, `assignment_id`, `assessment_account_id`, `question_id`, `answer`, `is_correct`, `marks`) VALUES
(1, 4, 1, 17, '49', 0, 0),
(2, 4, 1, 4, '[\"11\",\"12\"]', 0, 0),
(3, 4, 1, 15, '41', 0, 0),
(4, 4, 1, 5, 'I am fine', 0, 0),
(5, 4, 1, 11, '30', 0, 0),
(21, 3, 6, 1, '4', 0, 0),
(22, 3, 6, 19, 'It\'s a search Engine', 0, 0),
(23, 3, 6, 6, '[\"13\",\"14\"]', 0, 0),
(24, 3, 6, 16, '43', 0, 0),
(25, 3, 6, 17, '49', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
