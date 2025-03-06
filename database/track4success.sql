-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 03:55 PM
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
-- Database: `track4success`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `date`, `content`, `image_path`, `created_at`) VALUES
(3, 'August HR Meeting', '2024-08-09', 'Sample post only', '../uploads/Home.png', '2024-08-05 13:56:47'),
(6, 'December Meeting', '2024-12-19', 'November Meeting November Meeting', '../uploads/Home (1).png', '2024-08-05 14:14:44'),
(12, 'Student Portal first update', '2025-03-04', 'Student Portal first update', '../uploads/LOG IN.png', '2024-08-24 02:47:26'),
(13, 'Portal Turn-Over', '2024-12-11', 'Developer\'s Turn-over of the Portal to the JCCA', '../uploads/Home.png', '2024-12-07 20:24:38'),
(14, 'Launching of Student Portal', '2025-01-16', 'Launching of Student Portal', '../uploads/Home.png', '2025-01-05 15:39:30'),
(15, 'Heads-Up Thursday', '2025-01-16', 'Heads-Up Thursday', '../uploads/teachers-day.png', '2025-01-14 14:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status_am` varchar(10) DEFAULT 'Present',
  `status_pm` varchar(10) DEFAULT 'Present',
  `teacher_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `attendance_date`, `status_am`, `status_pm`, `teacher_id`) VALUES
(295, 255, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(296, 256, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(297, 257, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(298, 258, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(299, 259, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(300, 260, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(301, 261, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(302, 262, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(303, 263, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(304, 264, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(305, 265, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(306, 266, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(307, 267, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(308, 268, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(309, 269, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(310, 270, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(311, 271, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(312, 272, '2025-03-02', 'Absent', 'Absent', 'teacher-0000001'),
(313, 255, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(314, 256, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(315, 257, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(316, 258, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(317, 259, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(318, 260, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(319, 261, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(320, 262, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(321, 263, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(322, 264, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(323, 265, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(324, 266, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(325, 267, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(326, 268, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(327, 269, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(328, 270, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(329, 271, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(330, 272, '2025-03-04', 'Present', 'Present', 'teacher-0000001'),
(331, 255, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(332, 256, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(333, 257, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(334, 258, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(335, 259, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(336, 260, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(337, 261, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(338, 262, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(339, 263, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(340, 264, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(341, 265, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(342, 266, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(343, 267, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(344, 268, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(345, 269, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(346, 270, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(347, 271, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(348, 272, '2025-03-05', 'Present', 'Present', 'teacher-0000001'),
(349, 255, '2025-03-06', 'Present', 'Absent', 'teacher-0000001'),
(350, 256, '2025-03-06', 'Present', 'Absent', 'teacher-0000001');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `admin_id`, `title`, `start_date`, `content`, `created_at`) VALUES
(18, 'admin-0000001', 'Tuition Updates', '2025-01-14', 'Tuition Updates', '2025-01-05 15:52:52'),
(19, 'admin-0000001', 'Examination Day', '2025-01-15', 'Examination Day', '2025-01-05 15:53:14'),
(20, 'admin-0000001', 'Valentine\'s Day', '2025-02-14', 'Valentine\'s Day', '2025-01-11 14:24:02'),
(21, 'admin-0000001', 'School Holiday', '2025-01-29', 'School Holiday', '2025-01-11 14:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` bigint(20) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `profile_image` varchar(255) DEFAULT '../uploads/profile2.png',
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `profile_image`, `verification_token`, `is_verified`, `date_added`) VALUES
(7, 'Jan', 'Chui', 'Lim', 'jonnasy@gmail.com', '$2y$10$tFWGNFyAhRD8vKxApG/ymO3LWBPIu2SrIl97OvEK2tBMHKG9no1XK', '../uploads/66c6afe55dc9c.png', NULL, 0, '2024-08-22');

-- --------------------------------------------------------

--
-- Table structure for table `parent_details`
--

CREATE TABLE `parent_details` (
  `id` int(11) NOT NULL,
  `parentdet_id` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_details`
--

INSERT INTO `parent_details` (`id`, `parentdet_id`, `address`, `image`, `date_of_birth`, `place_of_birth`, `nationality`, `sex`, `mobile_number`, `personal_email`, `created_at`) VALUES
(15, 'parent-0000006', 'Ciudad Grande Subdivision', NULL, '1998-05-10', 'Pilar, Sorsogon', 'Filipino', 'other', '09947959743', 'ajoyceloterte@gmail.com', '2024-12-08 15:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stud_id` bigint(20) NOT NULL,
  `student_no` varchar(100) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `profile_image` varchar(255) DEFAULT '../uploads/profile2.png',
  `date_added` date NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `student_no`, `firstname`, `middlename`, `lastname`, `email`, `password`, `profile_image`, `date_added`, `verification_token`, `is_verified`) VALUES
(28, '2024-6734-25041', 'John Elbert', 'Salomon', 'Latuna', 'elbert@gmail.com', '$2y$10$LpPkgnF7Npz014FDrpVzY.G4fTPZcdWuEzCcbhfm0LCjTG5Ed2Ekm', '../uploads/677aa9ce33d9b.png', '0000-00-00', NULL, 0),
(29, '2020-6734-25041', 'Ann Joyce', 'Llamera', 'Loterte', 'abbylosito@gmail.com', '$2y$10$sxHziJRcWtLEQ9hCPkmUie8plr0gPwn73mzVImr1XXTjWhsY574Qa', '../uploads/profile2.png', '0000-00-00', NULL, 0),
(30, '2020-6734-25048', 'Rizzia', 'Llama', 'Loteree', 'rizzia@gmail.com', '$2y$10$RQPqf4BqIjqtKKDa.0wSk.hYUUUg8eeltBEbWVqG/JMFM0xPYSGby', '../uploads/profile2.png', '0000-00-00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students_enrolled`
--

CREATE TABLE `students_enrolled` (
  `student_id` int(11) NOT NULL,
  `student_no` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `classroom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_enrolled`
--

INSERT INTO `students_enrolled` (`student_id`, `student_no`, `firstname`, `middlename`, `lastname`, `classroom_id`) VALUES
(255, '2024-6734-25001', 'John Elbert', 'Salomon', 'Latuna', 19),
(256, '2024-6734-25042', 'Francis', 'Boroc', 'Santiago', 19),
(257, '2024-6734-25043', 'Julie', 'Franz', 'Imperial', 19),
(258, '2024-6734-25044', 'Takashi', '', 'Miyashita', 19),
(259, '2024-6734-25045', 'Kazumasa', '', 'Tsutsumi', 19),
(260, '2024-6734-25046', 'Kiara', 'Ito', 'San', 19),
(261, '2024-6734-25047', 'Miyakashi Sin Moon', 'Sin', 'Moon', 19),
(262, '2024-6734-25048', 'Cora', 'Alavarez', 'Minisota', 19),
(263, '2024-6734-25049', 'Kian', 'Ito', 'Sama', 19),
(264, '2024-6734-25041', 'John Elbert', 'Salomon', 'Latuna', 30),
(265, '2024-6734-25042', 'Francis', 'Boroc', 'Santiago', 30),
(266, '2024-6734-25043', 'Julie', 'Franz', 'Imperial', 30),
(267, '2024-6734-25044', 'Juan', 'Dela', 'Cruz', 30),
(268, '2024-6734-25045', 'Nazareno', 'Di', 'Dimaguiba', 30),
(269, '2024-6734-25046', 'Kiefer', 'Bron', 'Santiago', 30),
(270, '2024-6734-25047', 'Jay', 'Salomon', 'Latuna', 30),
(271, '2024-6734-25048', 'Cora', 'Alavarez', 'Minisota', 30),
(272, '2024-6734-25049', 'Kian', 'Ito', 'Sama', 30),
(273, '2024-6734-25091', 'Juan', 'Salomon', 'Latuna', 32),
(274, '2024-6734-25090', 'Franklin', 'Boroc', 'Santiago', 32),
(275, '2024-6734-25089', 'Julian', 'Antonia', 'Imperial', 32),
(276, '2024-6734-25088', 'Joana', 'Halo', 'Bisarte', 32);

-- --------------------------------------------------------

--
-- Table structure for table `student_behavior_ratings`
--

CREATE TABLE `student_behavior_ratings` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `quarter` enum('1st','2nd','3rd','4th') NOT NULL,
  `R1` varchar(10) DEFAULT NULL,
  `R2` varchar(10) DEFAULT NULL,
  `R3` varchar(10) DEFAULT NULL,
  `R4` varchar(10) DEFAULT NULL,
  `R5` varchar(10) DEFAULT NULL,
  `R6` varchar(10) DEFAULT NULL,
  `R7` varchar(10) DEFAULT NULL,
  `R8` varchar(10) DEFAULT NULL,
  `R9` varchar(10) DEFAULT NULL,
  `R10` varchar(10) DEFAULT NULL,
  `R11` varchar(10) DEFAULT NULL,
  `R12` varchar(10) DEFAULT NULL,
  `R13` varchar(10) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `student_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_behavior_ratings`
--

INSERT INTO `student_behavior_ratings` (`grade_id`, `student_id`, `classroom_id`, `quarter`, `R1`, `R2`, `R3`, `R4`, `R5`, `R6`, `R7`, `R8`, `R9`, `R10`, `R11`, `R12`, `R13`, `date_added`, `student_no`) VALUES
(11, 255, 19, '1st', 'C', 'C', 'C', 'C', 'B', 'B', 'B', 'B', 'A', 'A', 'A', 'B', 'A', '2024-12-04 22:52:20', '2024-6734-25041'),
(12, 256, 19, '1st', 'C', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', '2024-12-04 22:52:20', '2024-6734-25042'),
(13, 257, 19, '1st', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25043'),
(14, 258, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25044'),
(15, 259, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25045'),
(16, 260, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25046'),
(17, 261, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25047'),
(18, 262, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25048'),
(19, 263, 19, '1st', 'B', 'A', 'C', 'B', 'A', 'C', 'C', 'A', 'C', 'A', 'B', 'A', 'A', '2024-12-04 22:52:20', '2024-6734-25049'),
(20, 264, 30, '1st', 'C', 'C', 'C', 'C', 'B', 'B', 'B', 'B', 'A', 'A', 'A', 'B', 'A', '2025-01-05 23:42:35', '2024-6734-25041'),
(21, 265, 30, '1st', 'C', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', '2025-01-05 23:42:35', '2024-6734-25042'),
(22, 266, 30, '1st', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '2025-01-05 23:42:35', '2024-6734-25043'),
(23, 273, 32, '1st', 'C', 'C', 'C', 'C', 'B', 'B', 'B', 'B', 'A', 'A', 'A', 'B', 'A', '2025-01-31 05:47:20', '2024-6734-25091'),
(24, 274, 32, '1st', 'C', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', '2025-01-31 05:47:20', '2024-6734-25090'),
(25, 275, 32, '1st', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '2025-01-31 05:47:20', '2024-6734-25089'),
(26, 276, 32, '1st', 'A', 'B', 'A', 'C', 'B', 'A', 'B', 'A', 'C', 'A', 'B', 'A', 'B', '2025-01-31 05:47:20', '2024-6734-25088');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` int(11) NOT NULL,
  `studentdet_id` bigint(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `studentdet_id`, `address`, `image`, `date_of_birth`, `place_of_birth`, `nationality`, `sex`, `mobile_number`, `personal_email`, `created_at`) VALUES
(17, 28, 'Cumadcad, Castilla, Sorsogon', NULL, '2002-12-17', 'Pilar, Sorsogon', 'Filipino', 'Male', '09947959776', 'johnyyy@gmail.com', '2024-12-08 15:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `first_quarter` decimal(5,2) DEFAULT NULL,
  `first_quarter_remarks` varchar(10) DEFAULT NULL,
  `second_quarter` decimal(5,2) DEFAULT NULL,
  `second_quarter_remarks` varchar(10) DEFAULT NULL,
  `third_quarter` decimal(5,2) DEFAULT NULL,
  `third_quarter_remarks` varchar(10) DEFAULT NULL,
  `fourth_quarter` decimal(5,2) DEFAULT NULL,
  `fourth_quarter_remarks` varchar(10) DEFAULT NULL,
  `overall_grade` decimal(5,2) DEFAULT NULL,
  `overall_remarks` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`grade_id`, `student_id`, `subject_id`, `first_quarter`, `first_quarter_remarks`, `second_quarter`, `second_quarter_remarks`, `third_quarter`, `third_quarter_remarks`, `fourth_quarter`, `fourth_quarter_remarks`, `overall_grade`, `overall_remarks`) VALUES
(24, 255, 20, 91.00, 'PASSED', 91.00, 'PASSED', 91.00, 'PASSED', 91.00, 'PASSED', 91.00, 'PASSED'),
(25, 256, 20, 90.00, 'PASSED', 90.00, 'PASSED', 90.00, 'PASSED', 90.00, 'PASSED', 90.00, 'PASSED'),
(26, 257, 20, 78.00, 'PASSED', 78.00, 'PASSED', 78.00, 'PASSED', 78.00, 'PASSED', 78.00, 'PASSED'),
(27, 258, 20, 99.00, 'PASSED', 99.00, 'PASSED', 99.00, 'PASSED', 99.00, 'PASSED', 99.00, 'PASSED'),
(28, 259, 20, 97.00, 'PASSED', 97.00, 'PASSED', 97.00, 'PASSED', 97.00, 'PASSED', 97.00, 'PASSED'),
(29, 260, 20, 92.00, 'PASSED', 92.00, 'PASSED', 92.00, 'PASSED', 92.00, 'PASSED', 92.00, 'PASSED'),
(30, 261, 20, 73.00, 'FAILED', 73.00, 'FAILED', 79.00, 'PASSED', 73.00, 'FAILED', 74.50, 'FAILED'),
(31, 262, 20, 89.00, 'PASSED', 89.00, 'PASSED', 89.00, 'PASSED', 89.00, 'PASSED', 89.00, 'PASSED'),
(32, 263, 20, 79.00, 'PASSED', 79.00, 'PASSED', 79.00, 'PASSED', 79.00, 'PASSED', 79.00, 'PASSED'),
(42, 255, 22, 90.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 90.50, 'PASSED'),
(43, 256, 22, 90.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 90.00, 'PASSED'),
(44, 257, 22, 78.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 78.00, 'PASSED'),
(45, 258, 22, 99.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 99.00, 'PASSED'),
(46, 259, 22, 97.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 97.00, 'PASSED'),
(47, 260, 22, 92.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 92.00, 'PASSED'),
(48, 261, 22, 79.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 76.00, 'PASSED'),
(49, 262, 22, 89.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 89.00, 'PASSED'),
(50, 263, 22, 79.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 79.00, 'PASSED'),
(51, 264, 30, 91.00, 'PASSED', 91.00, 'PASSED', 70.00, 'FAILED', 89.00, 'PASSED', 85.25, 'PASSED'),
(52, 256, 30, 90.00, 'PASSED', 90.00, 'PASSED', 90.00, 'PASSED', NULL, NULL, 90.00, 'PASSED'),
(53, 257, 30, 78.00, 'PASSED', 78.00, 'PASSED', 78.00, 'PASSED', NULL, NULL, 78.00, 'PASSED'),
(54, 258, 30, 99.00, 'PASSED', 99.00, 'PASSED', 99.00, 'PASSED', NULL, NULL, 99.00, 'PASSED'),
(55, 259, 30, 97.00, 'PASSED', 97.00, 'PASSED', 97.00, 'PASSED', NULL, NULL, 97.00, 'PASSED'),
(56, 260, 30, 92.00, 'PASSED', 92.00, 'PASSED', 92.00, 'PASSED', NULL, NULL, 92.00, 'PASSED'),
(57, 261, 30, 73.00, 'FAILED', 73.00, 'FAILED', 73.00, 'FAILED', NULL, NULL, 73.00, 'FAILED'),
(58, 262, 30, 89.00, 'PASSED', 89.00, 'PASSED', 89.00, 'PASSED', NULL, NULL, 89.00, 'PASSED'),
(59, 263, 30, 79.00, 'PASSED', 79.00, 'PASSED', 79.00, 'PASSED', NULL, NULL, 79.00, 'PASSED'),
(60, 264, 32, 91.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 91.00, 'PASSED'),
(61, 256, 32, 90.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 90.00, 'PASSED'),
(62, 257, 32, 78.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 78.00, 'PASSED'),
(63, 258, 32, 99.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 99.00, 'PASSED'),
(64, 259, 32, 97.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 97.00, 'PASSED'),
(65, 260, 32, 92.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 92.00, 'PASSED'),
(66, 261, 32, 73.00, 'FAILED', NULL, NULL, NULL, NULL, NULL, NULL, 73.00, 'FAILED'),
(67, 262, 32, 89.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 89.00, 'PASSED'),
(68, 263, 32, 79.00, 'PASSED', NULL, NULL, NULL, NULL, NULL, NULL, 79.00, 'PASSED'),
(69, 273, 34, 91.00, 'PASSED', 96.00, 'PASSED', 96.00, 'PASSED', 97.00, 'PASSED', 95.00, 'PASSED'),
(70, 274, 34, 90.00, 'PASSED', 98.00, 'PASSED', 90.00, 'PASSED', 95.00, 'PASSED', 93.25, 'PASSED'),
(71, 275, 34, 78.00, 'PASSED', 99.00, 'PASSED', 90.00, 'PASSED', 93.00, 'PASSED', 90.00, 'PASSED'),
(72, 276, 34, NULL, 'FAILED', NULL, 'FAILED', NULL, 'FAILED', NULL, 'FAILED', NULL, 'FAILED');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_teacher` varchar(255) NOT NULL,
  `subject_room` varchar(255) NOT NULL,
  `subject_desc` text DEFAULT NULL,
  `subject_image` varchar(255) DEFAULT NULL,
  `subject_start_time` time DEFAULT NULL,
  `subject_end_time` time DEFAULT NULL,
  `subject_days` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `classroom_id`, `subject_name`, `subject_teacher`, `subject_room`, `subject_desc`, `subject_image`, `subject_start_time`, `subject_end_time`, `subject_days`) VALUES
(20, 19, 'English', 'Ma\'am Abby', 'Eng-101', 'This English Subject is for Grade 10-Diamond Only', 'classes-img.png', '08:30:00', '10:30:00', 'Monday,Wednesday,Friday'),
(22, 19, 'Math 10', '', 'Math-101', 'This subject is for Grade 10- Diamond Mathematics', 'classes-img.png', '14:00:00', '16:00:00', 'Monday,Wednesday,Friday'),
(23, 19, 'Science', '', 'Scie-101', 'For Grade 10 Diamond only', 'classes-img.png', '07:30:00', '09:30:00', 'Tuesday,Thursday'),
(24, 19, 'AP', '', 'AP CLASS 101', 'For Grade 10- Diamond Only', 'classes-img.png', '16:00:00', '17:30:00', 'Monday,Friday'),
(25, 24, 'TLE', '', 'TLE-101', 'For TLE Class only', 'classes-img.png', '16:00:00', '17:00:00', 'Wednesday'),
(26, 27, 'TLE', 'Joyce', 'TLE-101', 'This is TLE ', 'class.png', '14:32:00', '15:40:00', 'Tuesday, Wednesday, Friday'),
(28, 25, 'TLE', 'Ma\'am Abby', 'TLE-101', 'hh', 'received_457853897257869.jpeg', '10:30:00', '11:50:00', 'Monday, Saturday'),
(29, 19, 'Filipino', 'Ma\'am Abby', 'Fil-101', 'This is Filipino subject', 'classes-img.png', '11:00:00', '12:00:00', 'Tuesday, Thursday'),
(30, 30, 'English', 'Ma\'am Abby', 'Eng-101', 'This is English Subject', 'english.png', '08:30:00', '09:30:00', 'Monday, Wednesday, Friday'),
(31, 30, 'Math', 'Teacher Abby', 'Math-101', 'This is Math Subject', 'math.png', '10:00:00', '11:30:00', 'Tuesday, Thursday'),
(32, 30, 'Science', 'Teacher Abby', 'Scie-101', 'This is Science Subject', 'Science.png', '13:00:00', '14:00:00', 'Monday, Wednesday, Friday'),
(33, 30, 'Filipino', 'Teacher Abby', 'Fil-201', 'This is Filipino Subject', 'Filipno.png', '15:00:00', '16:00:00', 'Tuesday, Friday'),
(34, 32, 'Filipino', 'Joyce', 'Fil-101', 'This is Filipino Subject', 'download (1).png', '08:30:00', '10:30:00', 'Monday, Thursday, Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teachers_id` bigint(20) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `profile_image` varchar(255) DEFAULT '../uploads/profile2.png',
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teachers_id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `profile_image`, `date_added`) VALUES
(1, 'Abby', 'Lim', 'Losito', 'abbylosito@gmail.com', '$2y$10$1TLlJBGsObkuaynECmLUjeehA3paxNZ55iMScqc50gh075Orknx1G', '../uploads/66c63d006db21.png', '2024-07-04'),
(3, 'Carlo', 'Gonzales', 'Sevillano', 'carlosg@gmail.com', '$2y$10$svn6qQ3G4oPzdRntaVO/2OJBvuVwH.f2f8RrjcUx86du0oKfBfTSK', '../uploads/profile2.png', '2024-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `teachers_classroom`
--

CREATE TABLE `teachers_classroom` (
  `classroom_id` int(11) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `section` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `class_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_year` int(11) NOT NULL,
  `end_year` int(11) NOT NULL,
  `STATUS` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_classroom`
--

INSERT INTO `teachers_classroom` (`classroom_id`, `teacher_id`, `class_name`, `section`, `description`, `class_image`, `created_at`, `start_year`, `end_year`, `STATUS`) VALUES
(19, 'teacher-0000001', 'Grade 10', 'Diamond', 'This class is exclusively for Grade 10-Diamond only', 'classes-img.png', '2024-09-19 17:50:18', 2024, 2025, 'ARCHIVE'),
(21, 'teacher-0000002', 'Grade 9', 'Jupiter', 'This is exclusively for Grade 9-Jupiter class only', 'classes-img.png', '2024-09-19 18:36:32', 2023, 2025, 'ACTIVE'),
(24, 'teacher-0000001', 'Grade 8', 'Love', 'This class is exclusively for Grade 8-Love only', 'classes-img.png', '2024-11-04 15:42:14', 2024, 2025, 'ARCHIVE'),
(25, 'teacher-0000001', 'Grade 9', 'Ruby', 'This class is exclusively for Grade 9-Ruby only', 'classes-img.png', '2024-11-04 16:29:47', 2024, 2025, 'ARCHIVE'),
(27, 'teacher-0000003', 'Grade 10', 'Ruby', 'This is class Grade 10 Ruby', 'classes-img.png', '2024-11-20 17:36:24', 2024, 2025, 'ACTIVE'),
(28, 'teacher-0000001', 'Grade 10', 'Ruby', 'hkjkd', 'classes-img.png', '2024-11-20 18:29:29', 2009, 2010, 'ARCHIVE'),
(29, 'teacher-0000001', 'Grade 7', 'Uranus', 'This class is exclusively for Grade 7- Uranus only', 'classes-img.png', '2024-11-20 20:04:41', 2024, 2025, 'ARCHIVE'),
(30, 'teacher-0000001', 'Grade 7', 'Armstrong', 'This class is for Grade 7- Armstrong only', 'classes-img.png', '2025-01-04 02:04:05', 2024, 2025, 'ACTIVE'),
(31, 'teacher-0000001', 'Grade 8', 'Love', 'This class is exclusively for Grade 8-Love only', 'classes-img.png', '2025-01-04 02:11:14', 0, 0, 'ACTIVE'),
(32, 'teacher-0000005', 'Grade 10', 'Ruby', 'This is Grade 10 Ruby', 'received_457853897257869.jpeg', '2025-01-30 21:26:53', 2024, 2025, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_details`
--

CREATE TABLE `teacher_details` (
  `id` int(11) NOT NULL,
  `teacherdet_id` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_details`
--

INSERT INTO `teacher_details` (`id`, `teacherdet_id`, `address`, `image`, `date_of_birth`, `place_of_birth`, `nationality`, `sex`, `mobile_number`, `personal_email`, `created_at`) VALUES
(19, 'teacher-0000002', 'Legazpi City', NULL, '1998-07-20', 'Legazpi City', 'Filipino', 'Male', '09108230280', 'carlooo@gmail.com', '2024-09-19 18:07:16'),
(20, 'teacher-0000001', 'Cumadcad, Castilla, Sorsogon', NULL, '1998-03-05', 'Pilar, Sorsogon', 'Filipino', 'Female', '09108230280', 'abby@gmail.com', '2024-10-21 14:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype` varchar(100) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_added` date NOT NULL,
  `DATETIME_LOG` datetime DEFAULT current_timestamp(),
  `code` text NOT NULL,
  `verification_code` varchar(10) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `last_activity_time` datetime DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT 'profile2.png',
  `student_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `username`, `password`, `email`, `usertype`, `firstname`, `middlename`, `lastname`, `status`, `date_added`, `DATETIME_LOG`, `code`, `verification_code`, `image_path`, `last_activity_time`, `profile_image`, `student_no`) VALUES
(107, 'admin-0000001', 'JCCA_Admin', '$2y$10$TvY96E00CwfthQQuRutITOXvJPo6s/wXD19JsOd/Tohrip6F5sTiS', 'jcca_admin@gmail.com', 'ADMIN', 'Ann Joyce', 'Llamera', 'Loterte', 'APPROVED', '2024-09-20', '2024-09-20 00:56:17', '0f6f7aedf486a32f53df3e1255cf3f8c', '', 'profile2.png', '2024-10-18 00:56:04', '../uploads/profile2.png', NULL),
(109, 'teacher-0000001', 'abby', '$2y$10$NFx4iAzySWjAjppfyH1EyO40T.NtYHvuUAva/2Pqe1AmEw43RFmJ2', 'abbylosito@gmail.com', 'TEACHER', 'Abby', 'Lora', 'Losito', 'APPROVED', '2024-09-20', '2024-09-20 01:43:16', 'c5d5324bcce68b77e5400f972b754e64', '', 'profile2.png', '2024-09-20 01:43:16', '../uploads/67782345c9496.png', NULL),
(110, 'teacher-0000002', 'Gonza', '$2y$10$NYtK4gAL.hjfcDYUf1sFhOlWS7KmHUFLwMig26bEzW0B.I24CZCYm', 'carlsevi@gmail.com', 'TEACHER', 'Carlo', 'Sevi', 'Gonza', 'APPROVED', '2024-09-20', '2024-09-20 01:52:01', 'e2f639fa1a4d7cf16c25abdd1fe46582', '', 'profile2.png', '2024-09-20 01:52:01', '../uploads/profile2.png', NULL),
(112, 'parent-0000001', 'Rigor', '$2y$10$MS5o3subwPVqJwcN39/qLez0DkBzpuyHmySDjftes4HT5Tw0vlh5i', 'rigor@gmail.com', 'PARENT', 'Rigor', 'Inda', 'Dimaguiba', 'APPROVED', '2024-09-20', '2024-09-20 03:15:08', '37c3441c154dfe81f136d0dafbcef514', '', 'profile2.png', '2024-09-20 03:15:08', '../uploads/profile2.png', NULL),
(114, 'parent-0000002', 'MARITEST', '$2y$10$x94uzQiLroDV0yyXx.6tWujZSdWB5O9br0.vSSVure8rlAYjyHl5C', 'marites@gmail.com', 'PARENT', 'Marites', 'Inda', 'Dimaguiba', 'APPROVED', '2024-09-20', '2024-09-20 03:37:52', '58aaa058478b819c59eb5845b1b09c81', '', 'profile2.png', '2024-09-20 03:37:52', '../uploads/profile2.png', NULL),
(115, 'teacher-0000003', 'joyce', '$2y$10$fphDAvtGG.y9jT58ddw2kuOqHBBkxVios3u0lMZQ0b4BbKwpAvauG', 'joyceloterte@gmail.com', 'TEACHER', 'Joyce', 'Llamera', 'Loterte', 'APPROVED', '2024-11-21', '2024-11-21 01:30:52', 'bbbaf7f0ab588fae4d45acf58cb33386', '', 'profile2.png', '2024-11-21 01:30:52', '../uploads/profile2.png', NULL),
(131, 'teacher-0000004', 'john', '$2y$10$DfRtFeclsNYR87xkHuGUWunihPF.Jg1cdQgy7RpL4QfgPnCHszcYi', 'annjoycellamera.loterte@gmail.com', 'TEACHER', 'John', 'Elbert', 'Latuna', 'APPROVED', '2024-11-22', '2024-11-22 03:53:24', '126ed03210a6b4e259cef386ec9d7b84', '90BD2F', 'profile2.png', '2024-11-22 03:53:24', '../uploads/profile2.png', NULL),
(132, 'parent-0000003', 'mariacolla', '$2y$10$GGAFxi92itX5q3e4KAG3feDCmGSL.cpxNBlvOTDmILvYJUPP6PP3e', 'mariacolla@gmail.com', 'PARENT', 'Maria', 'Kasim', 'Colla', 'PENDING', '2024-11-25', '2024-11-25 11:48:11', 'cf6e860ad31c50c3e4d05addd8ee7012', 'D4C067', 'profile2.png', '2024-11-25 11:48:11', '../uploads/profile2.png', NULL),
(133, 'parent-0000004', 'mariacolla', '$2y$10$2sPOaaeNGljmqMUWnwL8vOgbv7K1kF8OjwopGpWh.bwXOxrAmaYCy', 'track4success2024@gmail.com', 'PARENT', 'Maria', 'Kasim', 'Colla', 'APPROVED', '2024-11-25', '2024-11-25 11:49:57', '72f546766887995a2a7b31a3fa807489', 'E8D202', 'profile2.png', '2024-11-25 11:49:57', '../uploads/profile2.png', NULL),
(134, 'parent-0000005', 'nelly', '$2y$10$um7xdh6Jwhm8.iQU9gYIfe5SB/yzrKrREDrMsG6pK.Dm05VdRSDXS', 'ajoyceloterte@gmail.com', 'PARENT', 'Nelly', 'Llamera', 'Loterte', 'APPROVED', '2024-11-26', '2024-11-26 00:48:12', '', '407CF3', 'profile2.png', '2024-11-26 00:48:12', '../uploads/profile2.png', '2024-6734-25041'),
(135, 'parent-0000006', 'aannjoyceloterte', '$2y$10$RCN8wze6wHVHI9H2jVmWteyMj9iY4n4yLcnB4h3q9bAS1.hQ4hjgK', 'joycesloterte@gmail.com', 'PARENT', 'Ann Joyce', 'Llamera', 'Loterte', 'APPROVED', '2024-12-08', '2024-12-08 22:14:03', '', '009774', 'profile2.png', '2024-12-08 22:14:03', '../uploads/6755bf211406b.jpg', NULL),
(136, 'parent-0000007', 'juan', '$2y$10$SVTPanGEY309Jvvo1kKYqefss3ySuFwOX0sENBdviaysH3tEWVrqi', 'salomon@gmail.com', 'PARENT', 'Juan', 'Salomon', 'Latuna', 'APPROVED', '2025-01-06', '2025-01-06 00:00:05', '', '7419CF', 'profile2.png', '2025-01-06 00:00:05', '../uploads/profile2.png', '2024-6734-25041'),
(137, 'teacher-0000005', 'ann', '$2y$10$Fxx.L2TpKb16srMxwtt.JuXE99PX87NxCTnvwX0dYy1OsBPkfhlCO', 'annjoyce@assemblepoint.co.jp', 'TEACHER', 'Ann Joyce', 'Llamera', 'Loterte', 'APPROVED', '2025-01-31', '2025-01-31 05:24:27', 'b245da2caf9186894ddb91d76b62b004', 'AF217B', 'profile2.png', '2025-01-31 05:24:27', '../uploads/profile2.png', NULL),
(138, 'parent-0000008', 'alex', '$2y$10$TsCf2zcObs16HBKrOpvEYeAdHRO6hSGuuPvxw/IZODTGAAY1X5R3m', 'alexloterte@gmail.com', 'PARENT', 'Alexander', 'Mercader ', 'Loterte', 'APPROVED', '2025-01-31', '2025-01-31 05:52:32', '', '468D10', 'profile2.png', '2025-01-31 05:52:32', '../uploads/profile2.png', '2024-6734-25041');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKadminid` (`admin_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_user` (`teacher_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKadminid` (`admin_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `parent_details`
--
ALTER TABLE `parent_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKparentid` (`parentdet_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_no`,`classroom_id`),
  ADD KEY `classroom_id` (`classroom_id`);

--
-- Indexes for table `student_behavior_ratings`
--
ALTER TABLE `student_behavior_ratings`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `classroom_id` (`classroom_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKstudentid` (`studentdet_id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `classroom_id` (`classroom_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teachers_id`);

--
-- Indexes for table `teachers_classroom`
--
ALTER TABLE `teachers_classroom`
  ADD PRIMARY KEY (`classroom_id`),
  ADD KEY `teachidfk` (`teacher_id`);

--
-- Indexes for table `teacher_details`
--
ALTER TABLE `teacher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKteacherid` (`teacherdet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD UNIQUE KEY `userID_UNIQUE` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `parent_details`
--
ALTER TABLE `parent_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `student_behavior_ratings`
--
ALTER TABLE `student_behavior_ratings`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teachers_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers_classroom`
--
ALTER TABLE `teachers_classroom`
  MODIFY `classroom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `teacher_details`
--
ALTER TABLE `teacher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD CONSTRAINT `FKadminiddets` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students_enrolled` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FKadminid` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_details`
--
ALTER TABLE `parent_details`
  ADD CONSTRAINT `FKparentdetid` FOREIGN KEY (`parentdet_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  ADD CONSTRAINT `enrolledstudents` FOREIGN KEY (`classroom_id`) REFERENCES `teachers_classroom` (`classroom_id`) ON DELETE SET NULL;

--
-- Constraints for table `student_behavior_ratings`
--
ALTER TABLE `student_behavior_ratings`
  ADD CONSTRAINT `student_behavior_ratings_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students_enrolled` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_behavior_ratings_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `teachers_classroom` (`classroom_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_details`
--
ALTER TABLE `student_details`
  ADD CONSTRAINT `FKstudentiddets` FOREIGN KEY (`studentdet_id`) REFERENCES `students` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students_enrolled` (`student_id`),
  ADD CONSTRAINT `student_grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `teachers_classroom` (`classroom_id`);

--
-- Constraints for table `teachers_classroom`
--
ALTER TABLE `teachers_classroom`
  ADD CONSTRAINT `teachidfk` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_details`
--
ALTER TABLE `teacher_details`
  ADD CONSTRAINT `FKteacheriddets` FOREIGN KEY (`teacherdet_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
