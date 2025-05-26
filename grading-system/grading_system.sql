-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 02:54 AM
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
-- Database: `grading_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `student_id` int(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `date` date NOT NULL,
  `week` varchar(20) DEFAULT NULL,
  `term` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`student_id`, `student_name`, `task_name`, `score`, `date`, `week`, `term`, `subject`) VALUES
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(1234, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 50, '2025-02-04', NULL, NULL, NULL),
(230116524, 'Claudio, Khyel Andre V.', 'Quiz', 15, '2025-02-04', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'Rumampa', 69, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'nag laro', 420, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'nag laro', 420, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'nag laro', 420, '2025-04-24', NULL, NULL, NULL),
(42069, 'Carlos yulo', 'nag laro', 420, '2025-04-24', NULL, NULL, NULL),
(0, '567890123', 'Essay Writing', 85, '2025-04-24', NULL, NULL, NULL),
(0, '123456789', 'Quiz', 92, '2025-04-24', NULL, NULL, NULL),
(0, '234567890', 'Group Project', 88, '2025-04-24', NULL, NULL, NULL),
(0, '345678901', 'Research Paper', 90, '2025-04-24', NULL, NULL, NULL),
(0, '456789012', 'Lab Experiment', 95, '2025-04-24', NULL, NULL, NULL),
(0, '567890124', 'Midterm Exam', 80, '2025-04-24', NULL, NULL, NULL),
(0, 'John Doe', 'Math Quiz', 95, '2025-04-24', NULL, NULL, NULL),
(0, 'Carlos yulo', 'Midterm Exam', 80, '2025-04-24', NULL, NULL, NULL),
(23101239, 'Mark ', 'Car', 50, '2025-04-24', 'Week 1', 'Prelim', NULL),
(69420, 'Mark ', 'Car', 70, '2025-04-24', 'Week 2', 'Prelim', NULL),
(69421, 'Mark ', 'Car', 70, '2025-04-24', 'Week 3', 'Prelim', NULL),
(69421, 'Mark ', 'Car', 70, '2025-04-24', 'Week 1', 'Prelim', NULL),
(69424, 'Clark', 'Motor', 80, '2025-04-24', 'Week 4', 'Prelim', NULL),
(69426, 'Clarky', 'Motory', 81, '2025-04-24', 'Week 1', 'Prelim', NULL),
(11115, 'Frank', 'Activity 2', 50, '2025-04-24', 'Week 6', 'Prelim', NULL),
(2147483647, 'Charlie puth', 'Sing', 55, '2025-04-24', 'Week 9', 'Midterm', NULL),
(230115925, 'Villalon, Khyle Emerson M.', 'Quiz #2', 15, '2025-05-08', 'Week 4', 'Prelim', 'Information Management'),
(230115925, 'Villalon, Khyle Emerson M.', 'Quiz #2', 15, '2025-05-08', 'Week 4', 'Prelim', 'Information Management'),
(23101239, 'Claudio, Khyel Andre V.', 'Quiz #2', 18, '2025-05-08', 'Week 4', 'Midterm', 'Information Management'),
(555557, 'Claudio, Khyel Andre V.', 'Quiz #5', 21, '2025-05-22', 'Week 9', 'Midterm', 'Information Management'),
(21347, 'Carlos yulo', 'Drifting', 42, '2025-05-22', 'Week 15', 'Finals', 'Information Management'),
(21347, 'Carlos yulo', 'Drifting', 42, '2025-05-22', 'Week 15', 'Finals', 'Information Management'),
(42069, 'Carlos yulo', 'Quiz', 15, '2025-05-22', 'Week 11', 'Midterm', 'Information Management'),
(420691, 'Carlos yulo', 'Quiz#7', 19, '2025-05-22', 'Week 5', 'Prelim', 'Information Management'),
(420691, 'Carlos yulo', 'Quiz#7', 19, '2025-05-22', 'Week 5', 'Prelim', 'Information Management'),
(420691, 'Carlos yulo', 'Quiz#7', 19, '2025-05-22', 'Week 5', 'Prelim', 'Information Management'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(634523, 'Mark', 'Activity 1', 30, '2025-05-22', 'Week 12', 'Midterm', 'ITE'),
(11111, 'Bart', 'Activity 1', 25, '2025-05-22', 'Week 5', 'Prelim', 'ITE'),
(11111, 'Bart', 'Activity 2', 2, '2025-05-22', 'Week 6', 'Prelim', 'ITE'),
(11111, 'Bart', 'Activity 2', 2, '2025-05-22', 'Week 6', 'Prelim', 'ITE'),
(11111, 'Bart', 'Activity 2', 2, '2025-05-22', 'Week 6', 'Prelim', 'ITE'),
(42069, 'Carlos yulo', 'Activity 4', 12, '2025-05-22', 'Week 13', 'Midterm', 'Information Management'),
(42069, 'Carlos yulo', 'Activity 5', 17, '2025-05-22', 'Week 16', 'Midterm', 'Information Management'),
(42069, 'Carlos yulo', 'Activity 5', 17, '2025-05-22', 'Week 16', 'Midterm', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(420691, 'Carlos yulo', 'Activity 7', 20, '2025-05-22', 'Week 17', 'Finals', 'Information Management'),
(42069, 'Carlos yulo', 'Activity 8', 25, '2025-05-22', 'Week 18', 'Finals', 'Information Management'),
(410910, 'Candry', 'Quiz#1', 10, '2025-05-22', 'Week 1', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#1', 10, '2025-05-22', 'Week 1', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#2', 20, '2025-05-22', 'Week 2', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#3', 20, '2025-05-22', 'Week 3', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#4', 40, '2025-05-22', 'Week 4', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#5', 40, '2025-05-22', 'Week 5', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#6', 40, '2025-05-22', 'Week 6', 'Prelim', 'ITE'),
(410910, 'Candry', 'Quiz#7', 20, '2025-05-22', 'Week 7', 'Prelim', 'ITE'),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 1', 2, '2025-05-25', 'Week 1', 'Prelim', 'PE 2'),
(230115925, 'Villalon, Khyle Emerson M.', 'Activity 2', 10, '2025-05-25', 'Week 4', 'Prelim', 'Hextech'),
(230115925, 'Villalon, Khyle Emerson M.', 'test', 30, '2025-05-25', 'Week 6', 'Prelim', 'Hextech');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `password`, `role`, `surname`, `name`, `middle_name`, `section`) VALUES
(1, '230115925', '$2y$10$yjOfWwegOLowHVWHbNW2ZuBRL8.x8r/mNDRtP0otSg/H3jY69cgtW', 'student', 'Villalon', 'Khyle Emerson', 'Mamaril', 'BSIT-22015'),
(2, '69420', '$2y$10$wRRBURHbQF6sU6mK3Ws0Mu9veh6P4VQ0D0yYFwOiVOXDFfEEBMreC', 'student', 'Peter', 'Pan', 'Parker', 'BSIT-22017');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
