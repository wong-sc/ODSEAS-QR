-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 12:05 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odseas-qr`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `ischecked` tinyint(1) NOT NULL,
  `checkin_time` timestamp NULL DEFAULT NULL,
  `checkout_time` timestamp NULL DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `course_id`, `student_id`, `ischecked`, `checkin_time`, `checkout_time`, `created_date`, `updated_date`) VALUES
(1, 'TMN2053', 44648, 0, '2017-03-12 09:00:21', '2017-03-12 09:28:05', '2017-03-12 09:00:21', '2017-03-12 09:00:21'),
(2, 'TMN2053', 44571, 0, '2017-03-12 09:00:28', '2017-03-12 09:27:11', '2017-03-12 09:00:28', '2017-03-12 09:00:28'),
(3, 'TMN2053', 41123, 0, '2017-03-12 09:00:34', '2017-03-12 09:28:15', '2017-03-12 09:00:34', '2017-03-12 09:00:34'),
(4, 'TMN2053', 40840, 0, '2017-03-12 09:38:03', NULL, '2017-03-12 09:38:03', '2017-03-12 09:38:03'),
(5, 'TMN2053', 41853, 0, '2017-03-12 14:46:53', NULL, '2017-03-12 14:46:53', '2017-03-12 14:46:53');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_credit_hour` int(5) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `attendance_id` int(10) NOT NULL,
  `student_number` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_credit_hour`, `exam_date`, `start_time`, `end_time`, `attendance_id`, `student_number`, `created_date`, `updated_date`) VALUES
('TMC1214', 'SAMPLE COURSE', 3, '2017-02-28', '09:00:00', '12:00:00', 1, 50, '2017-02-22 10:49:06', '2017-02-22 10:49:06'),
('TMN2053', 'COURSE NAME 2', 3, '2017-03-21', '14:00:00', '17:00:00', 0, 20, '2017-03-11 11:29:49', '2017-03-11 11:29:49'),
('TMN4053', 'COURSE NAME', 3, '2017-03-13', '14:30:00', '17:30:00', 0, 300, '2017-03-11 11:29:45', '2017-03-11 11:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `course_handler`
--

CREATE TABLE `course_handler` (
  `course_handler_id` int(10) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `invigilator_position` varchar(15) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_handler`
--

INSERT INTO `course_handler` (`course_handler_id`, `staff_id`, `course_id`, `invigilator_position`, `created_date`, `update_date`) VALUES
(1, 1, 'TMN2053', 'INVIGILATOR', '2017-02-21 07:48:28', '2017-02-21 07:48:28'),
(2, 2, 'TMN2053', 'CHIEF ', '2017-02-21 08:28:42', '2017-02-21 08:28:42'),
(3, 3, 'TMC1214', 'INVIGILATOR', '2017-02-21 08:29:04', '2017-02-21 08:29:04'),
(4, 4, 'TMN2053', 'INVIGILATOR', '2017-02-21 08:29:24', '2017-02-21 08:29:24'),
(5, 2, 'TMC1214', 'CHIEF', '2017-02-21 08:41:14', '2017-02-21 08:41:14'),
(6, 2, 'TMN4053', 'CHIEF', '2017-03-11 11:24:55', '2017-03-11 11:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `enroll_handler`
--

CREATE TABLE `enroll_handler` (
  `enroll_handler_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `ischecked` tinyint(1) NOT NULL,
  `checkin_time` timestamp NULL DEFAULT NULL,
  `checkout_time` timestamp NULL DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enroll_handler`
--

INSERT INTO `enroll_handler` (`enroll_handler_id`, `student_id`, `course_id`, `ischecked`, `checkin_time`, `checkout_time`, `created_date`, `updated_date`) VALUES
(1, 44648, 'TMN2053', 1, '2017-03-13 07:44:21', '2017-03-13 07:44:32', '2017-03-13 07:44:32', '2017-03-13 07:44:32'),
(2, 44648, 'TMC1214', 0, NULL, NULL, '2017-03-11 06:58:56', '2017-03-11 06:58:56'),
(3, 44571, 'TMN2053', 1, '2017-03-13 07:45:04', '2017-03-13 07:45:34', '2017-03-13 07:45:34', '2017-03-13 07:45:34'),
(4, 44571, 'TMC1214', 0, NULL, NULL, '2017-03-12 08:58:54', '2017-03-12 08:58:54'),
(5, 41123, 'TMN2053', 0, NULL, NULL, '2017-03-13 07:20:47', '2017-03-13 07:20:47'),
(6, 41853, 'TMN2053', 0, '2017-03-13 07:49:35', NULL, '2017-03-13 07:49:35', '2017-03-13 07:49:35'),
(7, 40840, 'TMN2053', 1, '2017-03-13 07:48:01', '2017-03-13 07:49:01', '2017-03-13 07:49:01', '2017-03-13 07:49:01'),
(8, 44375, 'TMN2053', 0, NULL, NULL, '2017-03-12 08:58:14', '2017-03-12 08:58:14'),
(9, 42682, 'TMN2053', 1, '2017-03-13 07:49:08', '2017-03-13 07:49:15', '2017-03-13 07:49:15', '2017-03-13 07:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `qr_code_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `qr_image` blob NOT NULL,
  `isscanned` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(10) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_password` varchar(30) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staff_email` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `staff_phoneno` int(15) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_password`, `created_date`, `staff_email`, `role`, `staff_phoneno`, `updated_date`) VALUES
(1, 'Staff Admin', '12345', '2017-02-21 08:31:38', 'staffadmin@yahoo.com', 'STAFF', 198784212, '2017-02-21 08:31:38'),
(2, 'STAFF2', '12345678', '2017-02-21 08:30:36', 'staff2@gmail.com', 'LECTURER', 174568952, '2017-02-21 08:30:36'),
(3, 'STAFF3', '123456789', '2017-02-21 08:33:41', 'staff3@hotmail.com', 'LECTURER', 132485499, '2017-02-21 08:33:41'),
(4, 'STAFF4', '789456', '2017-02-21 08:39:39', 'staff4@yahoo.com', 'STAFF', 123878787, '2017-02-21 08:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(10) NOT NULL,
  `qr_code_id` int(10) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_faculty` varchar(100) NOT NULL,
  `student_major` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `qr_code_id`, `student_name`, `student_faculty`, `student_major`, `created_date`, `updated_date`) VALUES
(40827, 0, 'CHEE', 'FCSIT', 'INFORMATION SYSTEMS', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(40840, 0, 'CHEONG', 'FCSIT', 'SOFTWARE ENGINEERING', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(41123, 0, 'ERIC', 'FCSIT', 'NETWORK COMPUTING', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(41853, 0, 'LIM', 'FCSIT', 'NETWORK COMPUTING', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(42682, 0, 'NG', 'FCSIT', 'COMPUTATIONAL SCIENCE', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(43678, 0, 'ONG', 'FCSIT', 'INFORMATION SYSTEMS', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(44371, 0, 'TAN 2', 'FCSIT', 'COMPUTATIONAL SCIENCE', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(44375, 0, 'TAN', 'FCSIT', 'COMPUTATIONAL SCIENCE', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(44571, 2, 'VOON', 'FCSIT', 'INFORMATION SYSTEMS', '2017-03-12 08:52:59', '2017-03-12 08:52:59'),
(44648, 1, 'WONG', 'FCSIT', 'NETWORK COMPUTING', '2017-03-12 08:53:24', '2017-03-12 08:53:24'),
(44670, 0, 'YAP', 'FCSIT', 'MULTIMEDIA COMPUTING', '2017-03-12 08:51:25', '2017-03-12 08:51:25'),
(45188, 0, 'TAN 3', 'FCSIT', 'INFORMATION SYSTEM', '2017-03-12 08:51:25', '2017-03-12 08:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `venue_id` varchar(20) NOT NULL,
  `venue_name` varchar(255) NOT NULL,
  `venue_capacity` int(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venue_id`, `venue_name`, `venue_capacity`, `created_date`, `updated_date`) VALUES
('CTF1_DK', 'CTF 1, DEWAN KULIAH', 350, '2017-03-11 11:28:17', '2017-03-11 11:28:17'),
('FCSIT_TL2', 'TEACHING LAB 2, FCSIT', 40, '2017-02-21 07:40:14', '2017-02-21 07:40:14'),
('FCSIT_TMM', 'TMM,FCSIT', 200, '2017-02-15 14:28:06', '2017-02-15 14:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `venue_handler`
--

CREATE TABLE `venue_handler` (
  `venue_handler_id` int(10) NOT NULL,
  `venue_id` varchar(20) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venue_handler`
--

INSERT INTO `venue_handler` (`venue_handler_id`, `venue_id`, `course_id`, `created_date`, `updated_date`) VALUES
(1, 'FCSIT_TMM', 'TMN2053', '2017-02-21 07:36:54', '2017-02-21 07:36:54'),
(2, 'FCSIT_TL2', 'TMC1214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'CTF1_DK', 'TMN4053', '2017-03-11 11:27:32', '2017-03-11 11:27:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_handler`
--
ALTER TABLE `course_handler`
  ADD PRIMARY KEY (`course_handler_id`);

--
-- Indexes for table `enroll_handler`
--
ALTER TABLE `enroll_handler`
  ADD PRIMARY KEY (`enroll_handler_id`);

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`qr_code_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venue_id`);

--
-- Indexes for table `venue_handler`
--
ALTER TABLE `venue_handler`
  ADD PRIMARY KEY (`venue_handler_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `course_handler`
--
ALTER TABLE `course_handler`
  MODIFY `course_handler_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `enroll_handler`
--
ALTER TABLE `enroll_handler`
  MODIFY `enroll_handler_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `venue_handler`
--
ALTER TABLE `venue_handler`
  MODIFY `venue_handler_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
