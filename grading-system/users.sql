-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 02:55 AM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `surname`, `first_name`, `middle_name`, `password`, `role`, `section`, `profile_pic`, `subject`) VALUES
(1, '230115925', 'Villalon', 'Khyle Emerson', 'Mamaril', '$2y$10$Gl0ndGrcbSzsLv3bqEiBCeVZlWqT38g7./Xb2fbD8yFaUE1DJRNG2', 'student', 'BSIT-22015', NULL, NULL),
(2, '595959', 'marky', 'bean', 'wick', '$2y$10$ffaLjtIBhEUI7aNq.ClB2e/5r7RuDnPddyOuusoSXwK6dISHN2Edy', 'student', 'BSIT-22015', NULL, NULL),
(3, '59595959', 'Peter', 'Parker', 'pan', '$2y$10$UFCfonWI/5YNFMzwaWirpOAcIH.hggMjhxS3SN1gVjC/h4WRo8gJ6', 'student', 'BSIT-22015', NULL, NULL),
(4, '42069', 'Kobe', 'wicky', 'silva', '$2y$10$wzMRqg94Toi.hKMFGzkOlO1nUvJfwKlot9jMsYB3Jle7plM.ED4NG', 'teacher', NULL, NULL, ''),
(5, '102345', 'Reyes', 'Jonathan Emmanuel', 'C.', '$2y$10$BlKJri6/VqunEV71ydnrq.VRklNi/6RC4.NlPF2bkSKdm2.sneucq', 'teacher', NULL, NULL, 'PE 2'),
(6, '12345678', 'Delacruz', 'Tristan', 'B.', '$2y$10$o2K9W6hKcmzuWjS20ZGa9eSFU9HVI0DdQbBS8Dp3ZIYWV/EfRLaiC', 'teacher', NULL, NULL, ''),
(13, '54321', 'Bautista', 'Tristan', 'D.', '$2y$10$NQidx/gxD7dlnaS46SXV6ugcybivQAvepRtd2KpVf1HXzJmXLrXry', 'teacher', NULL, NULL, ''),
(16, '98765', 'Dayandante', 'Phoenix', 'B.', '$2y$10$7mBhaYnEwwGbgj0dFmGwAepAwBgWr5cHTaSQjnLzNfUJpW2VhRQL2', 'teacher', NULL, NULL, 'Agent'),
(17, '55555', 'Cody', 'sharp', 'C.', '$2y$10$De2DaIs2nxoTsSAJ9.3bmet2SQhCX6rNwSQ2jjYvTUb5FOlvq1C5q', 'student', 'BSIT-22017', NULL, NULL),
(18, '42391', 'Arcane', 'Viktor', 'H.', '$2y$10$3GD8GMvHvTFssT3JWYnm2uS3sCOG3Vj.TMcD/uhFyFiSa60enTAT2', 'teacher', NULL, NULL, 'Hextech'),
(19, '55323', 'Morales', 'Miles', 'G.', '$2y$10$QuPt2py5pE5alppwFm.lTeP555xWS3DuOlUflA4UXxLlN4rUht3Zu', 'teacher', NULL, NULL, 'Parkour'),
(20, '43214', 'Talisman', 'Jayce', 'H.', '$2y$10$axjZtQ6hYwpCCkooLALa3en06l5YzKSYJgbF78sJn58mkNtJUS0Wa', 'teacher', NULL, NULL, 'Hextech'),
(21, '00112233', 'Blitz', 'Crack', 'B.', '$2y$10$ZEEyWO3BUhF96RuyYgx3XuoR11ZjJl.ttAdggmrHxylEsJzabnqVe', 'teacher', NULL, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
