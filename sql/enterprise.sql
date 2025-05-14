-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 05:21 PM
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
-- Database: `enterprise`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkins`
--

CREATE TABLE `checkins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `checkin_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkins`
--

INSERT INTO `checkins` (`id`, `username`, `checkin_date`) VALUES
(19, 'user123', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `dietitians`
--

CREATE TABLE `dietitians` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dietitians`
--

INSERT INTO `dietitians` (`id`, `user_id`, `full_name`, `specialization`, `contact_email`) VALUES
(1, 17, 'Dr. Laura Green', 'Weight Management', 'laura.green@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','dietitian') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(4, 'george1', '$2y$10$2tIcbuVrbpq2hfSM8FYn3.iFQO.meeErh6HLWIH4xEkT5.gT79yR6', 'user'),
(5, 'frank', '$2y$10$w8ulstBPnVSJEg9muVlknu2gdmeqmZCcg39Kja/vR7i.hHUTpAPae', 'user'),
(11, 'admin', '$2y$10$...hashedpassword...', 'admin'),
(16, 'carlo', '$2y$10$oWUwdOP06o9fhBsnPYvuTOBfv2WZ3sFBEpOZwhGwlGxDj1umHnmE6', 'user'),
(17, 'maam', '$2y$10$KHOztJhFOx4TLPtMiL7gOeIL7G3wyBRsAul7VphyPulbyLyOXDRcy', 'user'),
(18, 'dietuser', '$2y$10$abcabcabcabcabcabcabcabcabcabcabcabcabcabcabcabcabcab', 'dietitian'),
(19, 'roy', '$2y$10$PkmdhS6ZjoZBoC/U2U8ptu5o3H4eOndmisK5JbViQbLDRrrzGfxXe', 'admin'),
(20, 'none', '$2y$10$Lv1IvdnOVORSi3.njsxYRONWu6E6iQLlBs/SnC7dp8DHij6o.UdVO', 'user'),
(21, 'georgia', '$2y$10$RurgoPvEqj4hM84Ue7BI0u5.UrxYYQu2W2XaK9rB/bKkjwtef7p6i', 'dietitian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_checkin` (`username`,`checkin_date`);

--
-- Indexes for table `dietitians`
--
ALTER TABLE `dietitians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkins`
--
ALTER TABLE `checkins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dietitians`
--
ALTER TABLE `dietitians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dietitians`
--
ALTER TABLE `dietitians`
  ADD CONSTRAINT `dietitians_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
