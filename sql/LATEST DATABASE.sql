-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 06:47 PM
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
(5, 25, 'angel locsin', NULL, 'angellocsin@gmail.com'),
(6, 33, 'Jan', NULL, 'janjandietitian@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

CREATE TABLE `diet_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_date` date NOT NULL,
  `meal_time` enum('breakfast','lunch','dinner','snack') NOT NULL,
  `dish_name` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `diet_plan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plans`
--

INSERT INTO `diet_plans` (`id`, `user_id`, `meal_date`, `meal_time`, `dish_name`, `created_by`, `date`, `diet_plan`) VALUES
(1, 27, '2025-05-18', 'lunch', 'salad', 25, '2025-05-18', NULL),
(2, 27, '2025-05-18', 'breakfast', 'salad', 25, '2025-05-18', NULL),
(4, 27, '2025-05-19', 'dinner', 'salad', 25, '2025-05-18', NULL),
(6, 27, '2025-05-25', 'breakfast', 'egg', 25, '2025-05-18', NULL),
(7, 27, '2025-05-31', 'breakfast', 'egg plant', 25, '2025-05-18', NULL),
(8, 27, '2025-05-31', 'dinner', 'eggplant', 25, '2025-05-18', NULL),
(9, 27, '2025-05-28', 'lunch', 'food', 25, '2025-05-18', NULL),
(11, 4, '2025-05-25', 'breakfast', 'coconut', 25, '2025-05-18', NULL),
(12, 4, '2025-05-25', 'lunch', 'Fully Loaded Tornado Potatoes Fully Loaded Tornado PotatoesFully Loaded Tornado PotatoesFully Loaded Tornado PotatoesFully Loaded Tornado PotatoesFully Loaded Tornado PotatoesFully Loaded Tornado PotatoesFully Loaded Tornado Potatoes', 33, '2025-05-18', NULL),
(14, 4, '2025-05-25', 'dinner', 'eggloaf', 33, '2025-05-18', NULL),
(18, 4, '2025-05-26', 'breakfast', 'egg with beefloaf', 33, '2025-05-18', NULL),
(19, 4, '2025-05-20', 'breakfast', 'egg with plant', 33, '2025-05-19', NULL);

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
-- Table structure for table `meal_logs`
--

CREATE TABLE `meal_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `quantity` decimal(5,2) DEFAULT NULL,
  `food_group` varchar(50) DEFAULT NULL,
  `protein` decimal(5,2) DEFAULT NULL,
  `carbs` decimal(5,2) DEFAULT NULL,
  `fat` decimal(5,2) DEFAULT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_logs`
--

INSERT INTO `meal_logs` (`id`, `user_id`, `food_name`, `quantity`, `food_group`, `protein`, `carbs`, `fat`, `logged_at`) VALUES
(1, 33, 'egg', 122.00, 'Protein', 313.00, 13.00, 999.99, '2025-05-18 08:53:41'),
(2, 4, 'beefloaf', 1.00, 'Meat', 1.10, 1.10, 0.50, '2025-05-18 11:14:41'),
(3, 33, 'eggplant', 1.00, 'Vegetable', 0.50, 0.40, 0.70, '2025-05-18 16:25:03'),
(4, 4, 'Adobo ', 1.00, 'Meat', 1.20, 1.40, 1.20, '2025-05-18 16:36:20');

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
(16, 25, 27, 'eat what you want', '0000-00-00 00:00:00', '2025-05-17 11:00:24'),
(21, 25, 25, '1231231', '0000-00-00 00:00:00', '2025-05-17 15:26:41'),
(22, 25, 25, '1231231', '0000-00-00 00:00:00', '2025-05-17 15:26:41'),
(28, 4, 25, 'what i will eat today', '0000-00-00 00:00:00', '2025-05-18 11:17:34'),
(33, 33, 4, 'ok eat anything', '0000-00-00 00:00:00', '2025-05-18 16:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `old_diet_plans`
--

CREATE TABLE `old_diet_plans` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `meal_plan` text DEFAULT NULL,
  `diet_plan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `old_diet_plans`
--

INSERT INTO `old_diet_plans` (`id`, `username`, `date`, `meal_plan`, `diet_plan`) VALUES
(1, 'maam', '2025-05-01', 'Breakfast: Oatmeal\nLunch: Chicken Salad\nDinner: Grilled Fish', NULL),
(2, 'maam', '2025-05-01', NULL, 'Oatmeal with banana and almonds'),
(3, 'maam', '2025-05-06', NULL, 'wewewe'),
(4, 'maam', '2025-05-06', NULL, 'weweweasdas');

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
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `full_name`) VALUES
(4, 'george1', '$2y$10$2tIcbuVrbpq2hfSM8FYn3.iFQO.meeErh6HLWIH4xEkT5.gT79yR6', 'user', '', NULL),
(11, 'admin', '$2y$10$...hashedpassword...', 'admin', '', NULL),
(19, 'roy', '$2y$10$PkmdhS6ZjoZBoC/U2U8ptu5o3H4eOndmisK5JbViQbLDRrrzGfxXe', 'admin', '', NULL),
(25, 'angel', '$2y$10$Rpr67DYBB/kZ037uwKCaROdwEOwvs4uGtb43.mSJ4UwvZ26tqwqYm', 'dietitian', '', NULL),
(27, 'maam', '$2y$10$0uDf1xRIPfkngznI8PgOZuS6QDjwyuYc/uO/YxhE/7SWRU2AY2N6e', 'user', '', NULL),
(33, 'Dietitian', '$2y$10$X9WU96ufBIZvecGOwgU74.9UuExIixA/xYUqylfgob7Gh16HkDDEu', 'dietitian', '', NULL),
(34, 'frank', '$2y$10$mKCyEdxEhseVXrhAPqUYfuNLRg5HqWZmx8k.wrhsOKKmPoxGjtwOS', 'user', '', NULL);

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
(84, 4, 'vegetable', 'Beef & Rice Stuffed Poblano Peppers', '2025-05-18 16:31:53', NULL, 'user');

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
-- Table structure for table `user_logged_meals`
--

CREATE TABLE `user_logged_meals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `quantity` decimal(5,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `protein` decimal(5,2) DEFAULT NULL,
  `carbs` decimal(5,2) DEFAULT NULL,
  `fat` decimal(5,2) DEFAULT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logged_meals`
--

INSERT INTO `user_logged_meals` (`id`, `user_id`, `food_name`, `quantity`, `category`, `protein`, `carbs`, `fat`, `logged_at`) VALUES
(4, 4, 'Adobo ', 1.00, 'Meat', 1.20, 1.40, 1.20, '2025-05-18 16:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_meals`
--

CREATE TABLE `user_meals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_name` varchar(255) NOT NULL,
  `category` enum('Breakfast','Lunch','Dinner') NOT NULL,
  `meal_date` date NOT NULL,
  `meal_time` time NOT NULL
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
(3, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Indexes for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_plan` (`user_id`,`meal_date`,`meal_time`);

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
-- Indexes for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `old_diet_plans`
--
ALTER TABLE `old_diet_plans`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_logged_meals`
--
ALTER TABLE `user_logged_meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_meals`
--
ALTER TABLE `user_meals`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diet_plans`
--
ALTER TABLE `diet_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
-- AUTO_INCREMENT for table `meal_logs`
--
ALTER TABLE `meal_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `old_diet_plans`
--
ALTER TABLE `old_diet_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_dish_selections`
--
ALTER TABLE `user_dish_selections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user_health_info`
--
ALTER TABLE `user_health_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logged_meals`
--
ALTER TABLE `user_logged_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_meals`
--
ALTER TABLE `user_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dietitians`
--
ALTER TABLE `dietitians`
  ADD CONSTRAINT `dietitians_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD CONSTRAINT `diet_plans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `health_calendar`
--
ALTER TABLE `health_calendar`
  ADD CONSTRAINT `health_calendar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD CONSTRAINT `meal_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Constraints for table `user_logged_meals`
--
ALTER TABLE `user_logged_meals`
  ADD CONSTRAINT `user_logged_meals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_meals`
--
ALTER TABLE `user_meals`
  ADD CONSTRAINT `user_meals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
