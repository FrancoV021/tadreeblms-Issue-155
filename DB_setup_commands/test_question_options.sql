-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2022 at 07:41 PM
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
-- Table structure for table `test_question_options`
--

CREATE TABLE `test_question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_text` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_right` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_question_options`
--

INSERT INTO `test_question_options` (`id`, `question_id`, `option_text`, `is_right`) VALUES
(1, 1, '<p>1</p>', 0),
(2, 1, '<p>2</p>', 0),
(3, 1, '<p>0</p>', 0),
(4, 1, '<p>4</p>', 1),
(5, 2, '<p>+</p>', 1),
(6, 2, '<p>/</p>', 0),
(7, 2, '<p>*</p>', 1),
(8, 2, '<p>-</p>', 0),
(9, 4, '<p>pink</p>', 0),
(10, 4, '<p>white</p>', 0),
(11, 4, '<p>red</p>', 1),
(12, 4, '<p>green</p>', 1),
(13, 6, '<p>yes</p>', 1),
(14, 6, '<p>partially yes</p>', 0),
(15, 6, '<p>partially no</p>', 0),
(16, 6, '<p>no</p>', 1),
(17, 7, '<p>120</p>', 0),
(18, 7, '<p>125</p>', 0),
(19, 7, '<p>130</p>', 1),
(20, 7, '<p>135</p>', 0),
(21, 8, '<p>6</p>', 0),
(22, 8, '<p>8</p>', 1),
(23, 8, '<p>4</p>', 0),
(24, 8, '<p>2</p>', 0),
(25, 9, '<p>+</p>', 1),
(26, 9, '<p>4</p>', 1),
(27, 9, '<p>-</p>', 0),
(28, 9, '<p>12</p>', 0),
(29, 11, '<p>12</p>', 0),
(30, 11, '<p>30</p>', 1),
(31, 11, '<p>35</p>', 0),
(32, 11, '<p>34</p>', 0),
(33, 12, '<p>sdfdf</p>', 1),
(34, 12, '<p>scszxc</p>', 1),
(35, 12, '<p>erte</p>', 0),
(36, 12, '<p>wefwef</p>', 0),
(37, 14, '<p>may</p>', 0),
(38, 14, '<p>august</p>', 1),
(39, 14, '<p>january</p>', 0),
(40, 14, '<p>september</p>', 0),
(41, 15, '<p>yes</p>', 1),
(42, 15, '<p>no</p>', 0),
(43, 16, '<p>Beyond Tech</p>', 1),
(44, 16, '<p>Test Company</p>', 0),
(45, 16, '<p>No Details</p>', 0),
(46, 16, '<p>Company Pvt Ltd</p>', 0),
(47, 17, '<p>3</p>', 0),
(48, 17, '<p>4</p>', 0),
(49, 17, '<p>6</p>', 1),
(50, 17, '<p>8</p>', 0),
(51, 17, '<p>9</p>', 0),
(52, 17, '<p>10</p>', 0),
(53, 18, '<p>am</p>', 1),
(54, 18, '<p>was</p>', 1),
(55, 18, '<p>is</p>', 0),
(56, 18, '<p>are</p>', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `test_question_options`
--
ALTER TABLE `test_question_options`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test_question_options`
--
ALTER TABLE `test_question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
