-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 05:14 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exams`
--

-- --------------------------------------------------------

--
-- Table structure for table `examquestions`
--

CREATE TABLE `examquestions` (
  `id` int(10) NOT NULL,
  `examid` int(10) NOT NULL,
  `question` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `examquestions`
--

INSERT INTO `examquestions` (`id`, `examid`, `question`) VALUES
(27, 2, 'مجموع 5 + 443'),
(28, 2, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `questionanswers`
--

CREATE TABLE `questionanswers` (
  `id` int(10) NOT NULL,
  `questionid` int(10) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionanswers`
--

INSERT INTO `questionanswers` (`id`, `questionid`, `answer`, `status`) VALUES
(61, 27, '43', 0),
(62, 27, '65', 1),
(63, 28, 'test a', 1),
(64, 28, 'test b', 0),
(65, 28, 'test c', 0),
(66, 28, 'test d', 0),
(67, 29, 'sdf', 1),
(68, 29, 'fdsf', 0),
(69, 29, 'sdfsd', 0),
(70, 29, 'sdf', 0),
(60, 27, '345', 0),
(59, 27, '34', 0),
(58, 26, '32', 0),
(57, 26, '1', 0),
(56, 26, '2', 0),
(55, 26, '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentexamsessionanswers`
--

CREATE TABLE `studentexamsessionanswers` (
  `id` int(10) NOT NULL,
  `sessionid` int(10) NOT NULL,
  `questionid` int(10) NOT NULL,
  `studentanswer` varchar(20) NOT NULL,
  `truefalse` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentexamsessionanswers`
--

INSERT INTO `studentexamsessionanswers` (`id`, `sessionid`, `questionid`, `studentanswer`, `truefalse`) VALUES
(1, 1, 27, '59', 1),
(2, 1, 26, '56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `studentexamsessionquestions`
--

CREATE TABLE `studentexamsessionquestions` (
  `id` int(10) NOT NULL,
  `sessionid` int(10) NOT NULL,
  `questionid` int(10) NOT NULL,
  `correctoption` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentexamsessionquestions`
--

INSERT INTO `studentexamsessionquestions` (`id`, `sessionid`, `questionid`, `correctoption`) VALUES
(1, 1, 27, '59'),
(2, 1, 26, '55');

-- --------------------------------------------------------

--
-- Table structure for table `studentexamsessions`
--

CREATE TABLE `studentexamsessions` (
  `id` int(10) NOT NULL,
  `examid` int(10) NOT NULL,
  `studentid` int(10) NOT NULL,
  `date` date NOT NULL DEFAULT curdate()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentexamsessions`
--

INSERT INTO `studentexamsessions` (`id`, `examid`, `studentid`, `date`) VALUES
(1, 2, 666, '2020-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `specialization`, `level`, `class`, `year`) VALUES
(666, 'إبراهيم محمد', 'تقانة معلومات', 'الرابع', 'الثامن', 2020);

-- --------------------------------------------------------

--
-- Table structure for table `teacherexams`
--

CREATE TABLE `teacherexams` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `teacherid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacherexams`
--

INSERT INTO `teacherexams` (`id`, `name`, `teacherid`) VALUES
(1, 'حاسب الي', 1),
(2, 'رياضيات', 1),
(3, 'لغة عربيه', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(5) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`) VALUES
(1, 'احمد');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `examquestions`
--
ALTER TABLE `examquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionanswers`
--
ALTER TABLE `questionanswers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentexamsessionanswers`
--
ALTER TABLE `studentexamsessionanswers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentexamsessionquestions`
--
ALTER TABLE `studentexamsessionquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentexamsessions`
--
ALTER TABLE `studentexamsessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacherexams`
--
ALTER TABLE `teacherexams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `examquestions`
--
ALTER TABLE `examquestions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questionanswers`
--
ALTER TABLE `questionanswers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `studentexamsessionanswers`
--
ALTER TABLE `studentexamsessionanswers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studentexamsessionquestions`
--
ALTER TABLE `studentexamsessionquestions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studentexamsessions`
--
ALTER TABLE `studentexamsessions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=667;

--
-- AUTO_INCREMENT for table `teacherexams`
--
ALTER TABLE `teacherexams`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
