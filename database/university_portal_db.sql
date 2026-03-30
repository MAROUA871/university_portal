-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 09:41 PM
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
-- Database: `university_portal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL COMMENT 'id of the announcement',
  `user_id` int(11) NOT NULL COMMENT 'id of the teacher',
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'the time the announcement was posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'present/ absent',
  `scaned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `session_id`, `status`, `scaned_at`) VALUES
(0, 1, 1, 'present', '2026-03-25 09:44:07'),
(0, 2, 27, 'present', '2026-03-30 19:25:15'),
(0, 2, 27, 'present', '2026-03-30 19:25:15'),
(0, 2, 27, 'present', '2026-03-30 19:25:15'),
(0, 2, 27, 'present', '2026-03-30 19:25:15'),
(0, 2, 27, 'present', '2026-03-30 19:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_session`
--

CREATE TABLE `attendance_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qr_token` varchar(100) NOT NULL COMMENT 'UNIQUE QR CODE FOR THIS SESSION',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'WHEN THE QR WAS GENERATED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_session`
--

INSERT INTO `attendance_session` (`id`, `user_id`, `qr_token`, `created_at`) VALUES
(1, 2, 'ABC123', '2026-03-25 09:41:44'),
(2, 1, '977129fcfea61f8db98c3f121e5d77a3671f5fd15948df5b1ddf19c6bd61caa7', '2026-03-28 19:53:01'),
(10, 1, '6ebca2dd8e4835cafa223add76994eeddf3aa10a2940661ddc597c1761b87585', '2026-03-28 20:32:19'),
(11, 1, '30f97e6f23964ed94f68c39c1489a78dde3fbd83fe17e3be8d269bd98e8ee1fd', '2026-03-28 20:49:20'),
(12, 1, 'dbcf9a225ced2341498e0c773c6735a2a6f1e690beb3f39c0c3fd3d4804213cb', '2026-03-28 20:49:20'),
(13, 1, '3e0dac9c00c71648d145b2e2b8a538fee7f120460841ba29473ccfeaf7543f1f', '2026-03-28 20:49:21'),
(14, 1, '838ccc48838740c44acca17f11c44676f6bd65ef411e33a2225c0c339dae5540', '2026-03-30 17:04:33'),
(15, 1, '4f004055acf690e70deeaaf613b0c0113eefc107085595f27701409655a73e6c', '2026-03-30 17:15:27'),
(16, 1, 'b0c461e49bcf32010dcdbe0d362fff33d58687784e4012a22acbc821844a3492', '2026-03-30 17:25:01'),
(17, 1, '8d0d359c9fd101ccbfe67d0c640df438772686f919b719fb8452ca962804e9e1', '2026-03-30 17:36:57'),
(18, 1, '579085449bfd0897b267909968f974c6a7605c7af556af0a667a182632864b4c', '2026-03-30 17:36:58'),
(19, 1, 'a8693626b7c3f9b9cf173ac3767d796a77ffe16ab93d318aa6aa4548917dec51', '2026-03-30 17:37:01'),
(20, 1, '9df385db51802d8c99f749552e7776ff2f7f77d623450e7943dcaed894658053', '2026-03-30 17:37:02'),
(21, 1, '40c933d5ca61f88818076eeb8da424c71783073cf1c60708bcc22935361a418c', '2026-03-30 17:37:03'),
(22, 1, '8370a2bf7300357153841c5a24631483f0eaeb3ed959840bf131c85f58a0809e', '2026-03-30 17:37:04'),
(23, 1, 'd980aa0c814c6ebcf0ff87c0ba4c4e608f8921c5af227cf2851623e15a74c63f', '2026-03-30 17:48:17'),
(24, 1, '7d586f3ab808e0822ce4ff2ca9c2c9935f6f94bb36fff397476f514600721595', '2026-03-30 17:52:47'),
(25, 1, '5830ac77a67277f8cab799c6c6e595016e52bc43d5d5d38ef843f4a2febaa471', '2026-03-30 17:53:35'),
(26, 1, 'b5e46252367d49f6b7fcea3f14e310ea6e77d43b0f1c5d947f9f7b1f67e9b163', '2026-03-30 18:00:38'),
(27, 1, '1681539f40e8e26e6f444ae10f5e4829517d118af7095f9e73e96814a4bf9c1b', '2026-03-30 18:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `coefficient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'technical id for the db',
  `identifier` varchar(20) NOT NULL COMMENT 'employee id/ matricule',
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'timestamp for creation of the account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `identifier`, `password`, `role`, `first_name`, `last_name`, `email`, `created`) VALUES
(1, 'S001', '1234', 'student', 'ali', 'ben', 'ali@test.com', '2026-03-25 09:37:54'),
(2, 'T001', '1234', 'teacher', 'sara', 'prof', 'sara@test.com', '2026-03-25 09:39:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `attendance_session`
--
ALTER TABLE `attendance_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_session_ibfk_1` (`user_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_session`
--
ALTER TABLE `attendance_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'technical id for the db', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `attendance_session` (`id`);

--
-- Constraints for table `attendance_session`
--
ALTER TABLE `attendance_session`
  ADD CONSTRAINT `attendance_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
