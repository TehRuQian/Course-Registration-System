-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 02:31 PM
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
-- Database: `db_crs`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admins`
--

CREATE TABLE `tb_admins` (
  `admin_id` varchar(11) NOT NULL,
  `a_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admins`
--

INSERT INTO `tb_admins` (`admin_id`, `a_password`) VALUES
('A001', '$2y$10$O0X9prGKcVLnWCCsZOlh2ecsJUJAmNv0OM1EqSYOLyl45m2Ey9a.S'),
('A002', '$2y$10$ULgzmeF4KzmCLZYdHtmy4OWxAnFoZ7VPEc4cNC3vYaYSkrrr/fC7K');

-- --------------------------------------------------------

--
-- Table structure for table `tb_courses`
--

CREATE TABLE `tb_courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_description` text DEFAULT NULL,
  `lecturer_id` varchar(11) NOT NULL,
  `max_students` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_courses`
--

INSERT INTO `tb_courses` (`course_id`, `course_name`, `course_code`, `course_description`, `lecturer_id`, `max_students`) VALUES
(1, 'Database (WBL)', 'SECP2523', 'Comprehensive study of database systems.', 'L001', 37),
(2, 'Software Engineering (WBL)', 'SECP3204', 'Principles and practices of software development.', 'L001', 30),
(3, 'Data Structure and Algorithm', 'SECJ2013', 'Core concepts in data structures and algorithms.', 'L001', 40),
(4, 'Network Communication', 'SECR2213', 'Communication protocols and network architecture.', 'L002', 25),
(5, 'System Development Technology (WBL)', 'SECP3723', 'Basic technologies and components for web application developments.', 'L002', 35);

-- --------------------------------------------------------

--
-- Table structure for table `tb_enrollments`
--

CREATE TABLE `tb_enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` varchar(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `registration_date` date NOT NULL DEFAULT current_timestamp(),
  `registration_status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_enrollments`
--

INSERT INTO `tb_enrollments` (`enrollment_id`, `student_id`, `course_id`, `semester`, `registration_date`, `registration_status`) VALUES
(1, 'S001', 3, '2024/2025-1', '2024-07-23', 2),
(2, 'S001', 4, '2024/2025-1', '2024-07-15', 3),
(6, 'S002', 1, '2024/2025-1', '2024-07-29', 2),
(7, 'S002', 2, '2024/2025-1', '2024-07-29', 2),
(8, 'S002', 3, '2024/2025-1', '2024-07-29', 2),
(9, 'S003', 3, '2024/2025-1', '2025-01-21', 1),
(10, 'S003', 4, '2024/2025-1', '2025-01-21', 2),
(11, 'S003', 3, '2024/2025-1', '2025-01-26', 1),
(39, 'S001', 4, '2024/2025-2', '2025-01-27', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gender`
--

CREATE TABLE `tb_gender` (
  `ug_id` int(11) NOT NULL,
  `ug_desc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_gender`
--

INSERT INTO `tb_gender` (`ug_id`, `ug_desc`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lecturers`
--

CREATE TABLE `tb_lecturers` (
  `lecturer_id` varchar(11) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `l_email` varchar(100) NOT NULL,
  `l_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_lecturers`
--

INSERT INTO `tb_lecturers` (`lecturer_id`, `l_name`, `l_email`, `l_password`) VALUES
('L001', 'Dr. Noraini Musa', 'noraini.musa@example.com', '$2y$10$Xpzg9MCzSBfnIushVgwMxe7.GZ.R4fEj/2b3ElnjA7azzDoHrixde'),
('L002', 'Prof. Lim Boon Kiat', 'lim.boonkiat@example.com', '$2y$10$GPcq.r1yTfjaTEh0UnGK..pnkN7f1jpBfalFk25dpZY/xDNvki63y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_race`
--

CREATE TABLE `tb_race` (
  `ur_id` int(11) NOT NULL,
  `ur_desc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_race`
--

INSERT INTO `tb_race` (`ur_id`, `ur_desc`) VALUES
(1, 'Melayu'),
(2, 'Cina'),
(3, 'India'),
(4, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `tb_religion`
--

CREATE TABLE `tb_religion` (
  `ua_id` int(11) NOT NULL,
  `ua_desc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_religion`
--

INSERT INTO `tb_religion` (`ua_id`, `ua_desc`) VALUES
(1, 'Islam'),
(2, 'Buddha'),
(3, 'Hindu'),
(4, 'Christian'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `tb_state`
--

CREATE TABLE `tb_state` (
  `st_id` int(11) NOT NULL,
  `st_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_state`
--

INSERT INTO `tb_state` (`st_id`, `st_desc`) VALUES
(1, 'Johor'),
(2, 'Kedah'),
(3, 'Kelantan'),
(4, 'Melaka'),
(5, 'Negeri Sembilan'),
(6, 'Pahang'),
(7, 'Perak'),
(8, 'Perlis'),
(9, 'Pulau Pinang'),
(10, 'Sabah'),
(11, 'Sarawak'),
(12, 'Selangor'),
(13, 'Terengganu'),
(14, 'Wilayah Persekutuan Kuala Lumpur'),
(15, 'Wilayah Persekutuan Labuan'),
(16, 'Wilayah Persekutuan Putrajaya');

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `s_id` int(5) NOT NULL,
  `s_desc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`s_id`, `s_desc`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `tb_students`
--

CREATE TABLE `tb_students` (
  `student_id` varchar(11) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_ic` varchar(25) NOT NULL,
  `s_gender` int(11) NOT NULL,
  `s_race` int(11) NOT NULL,
  `s_religion` int(11) NOT NULL,
  `s_email` varchar(100) NOT NULL,
  `s_phone_number` varchar(20) NOT NULL,
  `s_address` varchar(255) NOT NULL,
  `s_postcode` int(11) NOT NULL,
  `s_city` varchar(255) NOT NULL,
  `s_state` int(11) NOT NULL,
  `s_password` varchar(255) NOT NULL,
  `s_registration_date` date DEFAULT current_timestamp(),
  `s_lecturer_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_students`
--

INSERT INTO `tb_students` (`student_id`, `s_name`, `s_ic`, `s_gender`, `s_race`, `s_religion`, `s_email`, `s_phone_number`, `s_address`, `s_postcode`, `s_city`, `s_state`, `s_password`, `s_registration_date`, `s_lecturer_id`) VALUES
('S001', 'Ahmad Faizal bin Ali', '040101-02-0111', 1, 1, 1, 'ahmad.faizal@gmail.com', '0145657866', 'No. 48, Jalan Raja Laut, Kampung Baru', 50332, 'Kuala Lumpur', 14, '$2y$10$I8epBuK32uvpWexobgDkbO.sO0xRXfpzu6t7tW1TzcdqoI/U0RaHG', '2024-01-18', 'L001'),
('S002', 'Nur Aisyah binti Abu', '040201-03-0222', 2, 1, 1, 'nur.aisyah@gmail.com', '0196546536', '103, Jalan Laksamana, Taman Indah', 84000, 'Muar', 1, '$2y$10$Qt.vHu7BrAgAZ38.KgOlu.S7DPhrVPdsJIET6dnx8wSCvlMtE.0im', '2024-01-12', 'L001'),
('S003', 'Tan Wei Ling', '050101-04-1234', 2, 2, 2, 'tan.weiling@gmail.com', '0185546789', '15, Jalan Padang, Bandar Sri Permaisuri', 56000, 'Kuching', 11, '$2y$10$ylVpIklRcucX1btZ/cwemuEHYz.LIM3MIx2.DxNPf4WmXaAzlAzCq', '2024-01-24', 'L002');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_id` varchar(4) NOT NULL,
  `u_type` int(11) NOT NULL COMMENT '1-Students\r\n2-Lecturer\r\n3-IT Staff\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_id`, `u_type`) VALUES
('S001', 1),
('S002', 1),
('S003', 1),
('L001', 2),
('L002', 2),
('A001', 3),
('A002', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admins`
--
ALTER TABLE `tb_admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tb_courses`
--
ALTER TABLE `tb_courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `tb_enrollments`
--
ALTER TABLE `tb_enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `registration_status` (`registration_status`);

--
-- Indexes for table `tb_gender`
--
ALTER TABLE `tb_gender`
  ADD PRIMARY KEY (`ug_id`);

--
-- Indexes for table `tb_lecturers`
--
ALTER TABLE `tb_lecturers`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD UNIQUE KEY `l_email` (`l_email`);

--
-- Indexes for table `tb_race`
--
ALTER TABLE `tb_race`
  ADD PRIMARY KEY (`ur_id`);

--
-- Indexes for table `tb_religion`
--
ALTER TABLE `tb_religion`
  ADD PRIMARY KEY (`ua_id`);

--
-- Indexes for table `tb_state`
--
ALTER TABLE `tb_state`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tb_students`
--
ALTER TABLE `tb_students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `s_email` (`s_email`),
  ADD KEY `s_gender` (`s_gender`,`s_race`,`s_religion`),
  ADD KEY `s_race` (`s_race`),
  ADD KEY `s_religion` (`s_religion`),
  ADD KEY `s_state` (`s_state`),
  ADD KEY `s_lecturerID` (`s_lecturer_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `u_type` (`u_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_courses`
--
ALTER TABLE `tb_courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_enrollments`
--
ALTER TABLE `tb_enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_courses`
--
ALTER TABLE `tb_courses`
  ADD CONSTRAINT `tb_courses_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `tb_lecturers` (`lecturer_id`);

--
-- Constraints for table `tb_enrollments`
--
ALTER TABLE `tb_enrollments`
  ADD CONSTRAINT `tb_enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tb_students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `tb_courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_enrollments_ibfk_3` FOREIGN KEY (`registration_status`) REFERENCES `tb_status` (`s_id`);

--
-- Constraints for table `tb_students`
--
ALTER TABLE `tb_students`
  ADD CONSTRAINT `tb_students_ibfk_1` FOREIGN KEY (`s_gender`) REFERENCES `tb_gender` (`ug_id`),
  ADD CONSTRAINT `tb_students_ibfk_2` FOREIGN KEY (`s_race`) REFERENCES `tb_race` (`ur_id`),
  ADD CONSTRAINT `tb_students_ibfk_3` FOREIGN KEY (`s_religion`) REFERENCES `tb_religion` (`ua_id`),
  ADD CONSTRAINT `tb_students_ibfk_4` FOREIGN KEY (`s_state`) REFERENCES `tb_state` (`st_id`),
  ADD CONSTRAINT `tb_students_ibfk_5` FOREIGN KEY (`s_lecturer_id`) REFERENCES `tb_lecturers` (`lecturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
