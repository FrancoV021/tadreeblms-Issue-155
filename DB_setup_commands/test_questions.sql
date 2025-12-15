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
-- Table structure for table `test_questions`
--

CREATE TABLE `test_questions` (
  `id` int(11) NOT NULL,
  `question_type` int(11) DEFAULT NULL COMMENT '1: single_choice, 2: multiple_choice, 3: short_answer',
  `test_id` int(11) DEFAULT NULL,
  `question_text` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `solution` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `marks` int(11) NOT NULL DEFAULT 0,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `option_json` longtext DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`id`, `question_type`, `test_id`, `question_text`, `solution`, `marks`, `comment`, `option_json`, `is_deleted`) VALUES
(1, 1, 101, '<p>2*2=?</p>', '<p>2*2=4</p>', 2, '<p>NA</p>', '[[\"<p>1</p>\",0],[\"<p>2</p>\",0],[\"<p>0</p>\",0],[\"<p>4</p>\",1]]', 0),
(2, 2, 1, '<p>2__2 = 4</p>', '<p>2*2=4</p>\n\n<p>2+2=4</p>', 2, '<p>NA</p>', '[[\"<p>+</p>\",1],[\"<p>/</p>\",0],[\"<p>*</p>\",1],[\"<p>-</p>\",0]]', 0),
(3, 3, 2, '<h2>What is Lorem Ipsum?</h2>', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 2, '<p>No Comment</p>', NULL, 0),
(4, 2, 101, '<p>Colors in rainow:</p>', '<p>VIBGYOR</p>', 2, NULL, '[[\"<p>pink</p>\",0],[\"<p>white</p>\",0],[\"<p>red</p>\",1],[\"<p>green</p>\",1]]', 0),
(5, 3, 101, '<p>How are you?</p>', '<p>I am fine</p>', 2, NULL, NULL, 0),
(6, 2, 101, '<p>I have some doubt</p>', '<p>Yes and No are the right answers</p>', 2, NULL, '[[\"<p>yes</p>\",1],[\"<p>partially yes</p>\",0],[\"<p>partially no</p>\",0],[\"<p>no</p>\",1]]', 0),
(7, 1, 101, '<p>65*2</p>', '<p>130 is the right answer</p>', 2, NULL, '[[\"<p>120</p>\",0],[\"<p>125</p>\",0],[\"<p>130</p>\",1],[\"<p>135</p>\",0]]', 0),
(8, 1, 101, '<p>4+4=?</p>', '<p>4+4=8</p>', 2, NULL, '[[\"<p>6</p>\",0],[\"<p>8</p>\",1],[\"<p>4</p>\",0],[\"<p>2</p>\",0]]', 0),
(9, 2, 101, '<p>4__ = 8</p>', '<p>4+4=8</p>', 2, NULL, '[[\"<p>+</p>\",1],[\"<p>4</p>\",1],[\"<p>-</p>\",0],[\"<p>12</p>\",0]]', 0),
(10, 3, 101, '<p>Descripbe Indo-China War</p>', '<p>The&nbsp;<strong>Sino-Indian War</strong>&nbsp;between&nbsp;<a href=\"https://en.wikipedia.org/wiki/China\">China</a>&nbsp;and&nbsp;<a href=\"https://en.wikipedia.org/wiki/India\">India</a>&nbsp;occurred in October&ndash;November 1962. A disputed&nbsp;<a href=\"https://en.wikipedia.org/wiki/Himalayas\">Himalayan</a>&nbsp;border was the main cause of the war. There had been a series of violent border skirmishes between the two countries after the&nbsp;<a href=\"https://en.wikipedia.org/wiki/1959_Tibetan_uprising\">1959 Tibetan uprising</a>, when India granted asylum to the&nbsp;<a href=\"https://en.wikipedia.org/wiki/14th_Dalai_Lama\">Dalai Lama</a>. India initiated a defensive&nbsp;<a href=\"https://en.wikipedia.org/wiki/Events_leading_to_the_Sino-Indian_War#Forward_policy\">Forward Policy</a>&nbsp;from 1960 to hinder Chinese military patrols and logistics, in which it placed outposts along the border, including several north of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/McMahon_Line\">McMahon Line</a>, the eastern portion of the&nbsp;<a href=\"https://en.wikipedia.org/wiki/Line_of_Actual_Control\">Line of Actual Control</a>&nbsp;proclaimed by&nbsp;<a href=\"https://en.wikipedia.org/wiki/Premier_of_the_People%27s_Republic_of_China\">Chinese Premier</a>&nbsp;<a href=\"https://en.wikipedia.org/wiki/Zhou_Enlai\">Zhou Enlai</a>&nbsp;in 1959</p>', 2, NULL, NULL, 0),
(11, 1, 101, '<p>6*5=?</p>', '<p>sdfsdf</p>', 2, NULL, '[[\"<p>12</p>\",0],[\"<p>30</p>\",1],[\"<p>35</p>\",0],[\"<p>34</p>\",0]]', 0),
(12, 2, 101, '<p>zfzc</p>', '<p>sdcvsd</p>', 2, NULL, '[[\"<p>sdfdf</p>\",1],[\"<p>scszxc</p>\",1],[\"<p>erte</p>\",0],[\"<p>wefwef</p>\",0]]', 0),
(13, 3, 101, '<p>shiort ansers</p>', '<p>sdvdv dfvsdvsdf gdv fgdfgdfgdfg fgdfg</p>', 2, NULL, NULL, 0),
(14, 1, 101, '<p>Which month comes after july</p>', '<p>August is the right answer</p>', 2, NULL, '[[\"<p>may</p>\",0],[\"<p>august</p>\",1],[\"<p>january</p>\",0],[\"<p>september</p>\",0]]', 0),
(15, 1, 101, '<p>is <strong>Information Technology</strong> is the full form of IT?</p>', '<p><strong>IT: Information Technology</strong></p>', 2, NULL, '[[\"<p>yes</p>\",1],[\"<p>no</p>\",0]]', 0),
(16, 1, 101, '<p>the name of the company is : *********</p>', '<p>Beyond Tech</p>', 2, NULL, '[[\"<p>Beyond Tech</p>\",1],[\"<p>Test Company</p>\",0],[\"<p>No Details</p>\",0],[\"<p>Company Pvt Ltd</p>\",0]]', 0),
(17, 1, 101, '<p>2*3==?</p>', '<p>2*3=6</p>', 2, NULL, '[[\"<p>3</p>\",0],[\"<p>4</p>\",0],[\"<p>6</p>\",1],[\"<p>8</p>\",0],[\"<p>9</p>\",0],[\"<p>10</p>\",0]]', 0),
(18, 2, 101, '<p>i _/_ there</p>', '<p>is/was</p>', 2, NULL, '[[\"<p>am</p>\",1],[\"<p>was</p>\",1],[\"<p>is</p>\",0],[\"<p>are</p>\",0]]', 0),
(19, 3, 101, '<p>What is google?</p>', '<p>Google is&nbsp; a search engine</p>', 2, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `test_questions`
--
ALTER TABLE `test_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
