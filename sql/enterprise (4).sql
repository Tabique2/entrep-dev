-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 01:29 PM
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
(5, 25, 'angel locsin', NULL, 'angellocsin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `dish_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `dish_name`) VALUES
(1, 'SALAD BOWL'),
(2, 'Grilled Cabbage \"Steaks\"'),
(3, 'Beef & Rice Stuffed Poblano Peppers'),
(4, 'Loaded Mediterranean Sweet Potato Fries'),
(5, 'Cheesy Garlic Zucchini Steaks'),
(6, 'Florentine Butter Chicken'),
(7, 'Chicken Katsu'),
(8, 'Miso Salmon & Farro Bowl'),
(9, 'Indian Butter Chickpeas');

-- --------------------------------------------------------

--
-- Table structure for table `health_calendar`
--

CREATE TABLE `health_calendar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dietitian_id` int(11) NOT NULL,
  `meal_plan` text NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `user_id`, `dietitian_id`, `meal_plan`, `assigned_at`) VALUES
(1, 27, 25, 'salad bowl', '2025-05-16 05:43:06'),
(2, 27, 25, 'salad bowl', '2025-05-16 05:47:52'),
(3, 27, 25, 'salad bowl', '2025-05-16 05:48:06'),
(4, 4, 25, 'salad bowl', '2025-05-16 05:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `timestamp`) VALUES
(7, 25, 27, 'eat what you want', '0000-00-00 00:00:00', '2025-05-17 09:14:07'),
(13, 25, 25, 'hey', '0000-00-00 00:00:00', '2025-05-17 09:37:57'),
(14, 25, 25, 'what', '0000-00-00 00:00:00', '2025-05-17 09:38:07'),
(15, 27, 25, 'what should i eat', '0000-00-00 00:00:00', '2025-05-17 10:59:20'),
(16, 25, 27, 'eat what you want', '0000-00-00 00:00:00', '2025-05-17 11:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `weight` float DEFAULT NULL,
  `activity_minutes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','dietitian') DEFAULT 'user',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(4, 'george1', '$2y$10$2tIcbuVrbpq2hfSM8FYn3.iFQO.meeErh6HLWIH4xEkT5.gT79yR6', 'user', ''),
(11, 'admin', '$2y$10$...hashedpassword...', 'admin', ''),
(19, 'roy', '$2y$10$PkmdhS6ZjoZBoC/U2U8ptu5o3H4eOndmisK5JbViQbLDRrrzGfxXe', 'admin', ''),
(25, 'angel', '$2y$10$Rpr67DYBB/kZ037uwKCaROdwEOwvs4uGtb43.mSJ4UwvZ26tqwqYm', 'dietitian', ''),
(27, 'maam', '$2y$10$0uDf1xRIPfkngznI8PgOZuS6QDjwyuYc/uO/YxhE/7SWRU2AY2N6e', 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_dish_selections`
--

CREATE TABLE `user_dish_selections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` enum('vegetable','meat','protein') NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `selected_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_type` enum('user','dietitian') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_dish_selections`
--

INSERT INTO `user_dish_selections` (`id`, `user_id`, `category`, `dish_name`, `selected_at`, `assigned_by`, `assigned_type`) VALUES
(9, 27, 'vegetable', 'Fully Loaded Tornado Potatoes', '2025-05-17 10:58:12', NULL, 'user'),
(10, 27, 'vegetable', 'Grilled Zucchini With Ricotta & Walnuts', '2025-05-17 10:58:12', NULL, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_health_info`
--

CREATE TABLE `user_health_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `height_cm` float NOT NULL,
  `weight_kg` float NOT NULL,
  `bmi` float GENERATED ALWAYS AS (`weight_kg` / pow(`height_cm` / 100,2)) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `weight` decimal(5,2) DEFAULT NULL,
  `height` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `activity_level` varchar(20) DEFAULT NULL,
  `health_goal` varchar(50) DEFAULT NULL,
  `dietary_pref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `full_name`, `profile_picture`, `age`, `gender`, `activity_level`, `health_goal`, `dietary_pref`) VALUES
(1, 25, 'frank', NULL, 12, 'Male', 'Sedentary', 'Weight Loss', 'Vegetarian'),
(2, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_calendar`
--
ALTER TABLE `health_calendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dietitian_id` (`dietitian_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_dish_selections`
--
ALTER TABLE `user_dish_selections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_health_info`
--
ALTER TABLE `user_health_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `health_calendar`
--
ALTER TABLE `health_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_dish_selections`
--
ALTER TABLE `user_dish_selections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_health_info`
--
ALTER TABLE `user_health_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dietitians`
--
ALTER TABLE `dietitians`
  ADD CONSTRAINT `dietitians_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `health_calendar`
--
ALTER TABLE `health_calendar`
  ADD CONSTRAINT `health_calendar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `meals_ibfk_2` FOREIGN KEY (`dietitian_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_dish_selections`
--
ALTER TABLE `user_dish_selections`
  ADD CONSTRAINT `user_dish_selections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_health_info`
--
ALTER TABLE `user_health_info`
  ADD CONSTRAINT `user_health_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
