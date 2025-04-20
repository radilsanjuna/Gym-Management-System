-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 13, 2024 at 03:37 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_type` enum('admin','trainer') NOT NULL,
  `sender_id` int NOT NULL,
  `recipient_type` enum('member','trainer','both') NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `member_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `sender_type`, `sender_id`, `recipient_type`, `title`, `content`, `created_at`, `updated_at`, `member_id`) VALUES
(8, 'admin', 1, 'member', 'cardio', 'radil', '2024-10-13 08:26:01', '2024-10-13 08:33:40', NULL),
(3, 'trainer', 2, 'member', 'dsd', 'sdsd', '2024-10-11 18:04:02', NULL, NULL),
(14, 'trainer', 2, 'member', 'aaa', 'aaaa', '2024-10-13 12:21:46', NULL, NULL),
(15, 'trainer', 2, 'member', 'aaa', 'aaaa', '2024-10-13 12:25:05', NULL, NULL),
(16, 'trainer', 2, 'member', 'aaa', 'aaaa', '2024-10-13 12:25:19', NULL, NULL),
(17, 'trainer', 2, 'member', 'aaa', 'aaaa', '2024-10-13 12:26:02', NULL, NULL),
(18, 'trainer', 2, 'member', 'aaa', 'aaaa', '2024-10-13 12:33:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `scanned_content` text NOT NULL,
  `scan_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `member_id` int DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `exercise_plan` varchar(30) DEFAULT NULL,
  `payment_plan` varchar(30) DEFAULT NULL,
  `payment_status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `scanned_content`, `scan_time`, `member_id`, `username`, `email`, `exercise_plan`, `payment_plan`, `payment_status`) VALUES
(7, 'Member ID: 2\nEmail: radivvl@gmail.com\nExercise Plan: weight_training\nPayment Plan: one_month\nPayment Status: paid\n', '2024-10-06 18:13:29', 2, '', 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid'),
(9, 'Member ID: 2\nEmail: radivvl@gmail.com\nExercise Plan: weight_training\nPayment Plan: one_month\nPayment Status: paid\n', '2024-10-06 18:22:02', 2, '', 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid'),
(4, 'Member ID: 2\nEmail: radivvl@gmail.com\nExercise Plan: weight_training\nPayment Plan: one_month\nPayment Status: paid\n', '2024-10-06 18:08:33', 2, '', 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid'),
(5, 'Member ID: 2\nEmail: radivvl@gmail.com\nExercise Plan: weight_training\nPayment Plan: one_month\nPayment Status: paid\n', '2024-10-06 18:09:00', 2, '', 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid'),
(6, 'Member ID: 2\nEmail: radivvl@gmail.com\nExercise Plan: weight_training\nPayment Plan: one_month\nPayment Status: paid\n', '2024-10-06 18:09:06', 2, '', 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `bmi_records`
--

DROP TABLE IF EXISTS `bmi_records`;
CREATE TABLE IF NOT EXISTS `bmi_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bmi_records`
--

INSERT INTO `bmi_records` (`id`, `member_id`, `bmi`, `submission_date`) VALUES
(1, 0, 31.25, '2024-09-27 15:16:04'),
(2, 0, 31.25, '2024-09-28 04:30:51'),
(3, 1, 50.00, '2024-10-03 06:55:28'),
(4, 8, 32.03, '2024-10-04 07:47:34'),
(5, 2, 38.19, '2024-10-04 16:59:07'),
(6, 2, 38.19, '2024-10-05 16:08:19'),
(7, 10, 51.90, '2024-10-05 16:24:55'),
(8, 2, 24.44, '2024-10-07 18:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `gym_classes`
--

DROP TABLE IF EXISTS `gym_classes`;
CREATE TABLE IF NOT EXISTS `gym_classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `trainer_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gym_classes`
--

INSERT INTO `gym_classes` (`id`, `class_name`, `start_time`, `end_time`, `date`, `trainer_name`) VALUES
(1, 'cardio', '01:57', '00:59', '2024-10-08', 'add'),
(2, 'cardio', '13:12', '03:10', '2024-10-16', 'add'),
(3, 'cardio', '01:15', '04:12', '2024-10-12', 'ssss'),
(5, 'ad', '20:12', '20:13', '2024-10-17', 'ad'),
(6, 'cario', '09:20', '22:11', '2024-10-15', 'Radil Sanjuna');

-- --------------------------------------------------------

--
-- Table structure for table `gym_equipment`
--

DROP TABLE IF EXISTS `gym_equipment`;
CREATE TABLE IF NOT EXISTS `gym_equipment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gym_equipment`
--

INSERT INTO `gym_equipment` (`id`, `name`, `type`, `quantity`, `description`, `image`) VALUES
(12, 'ffff', 'fff', 3, 'ff', '../uploads/images.jpeg'),
(13, 'Vertical Press Machine', 'dhdh', 4, 'dfh', '../uploads/qr_7 (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `memberregister`
--

DROP TABLE IF EXISTS `memberregister`;
CREATE TABLE IF NOT EXISTS `memberregister` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `exercise_plan` varchar(255) DEFAULT NULL,
  `payment_plan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `memberregister`
--

INSERT INTO `memberregister` (`member_id`, `fullname`, `username`, `password`, `dob`, `gender`, `registration_date`, `contact`, `email`, `address`, `exercise_plan`, `payment_plan`) VALUES
(2, 'radil', 'radil', '$2y$10$8MvOj6BJykqiFJ34ZQe2c.HAYUPxoy2q3CumqPGBB/SvbMw7DjkCq', '2024-09-21', 'female', '2024-09-23', '07523712375', 'radil@gmail.com', 'Mirigama', 'cardio_training', 'one_month'),
(19, 'Kasun Himasha', 'kasun', '$2y$10$ktX9/IXoTlSzBMxYcuEOk.DlSCntZpWKyOrD69SsSVd8DunTk/s3S', '2000-02-08', 'male', '2024-10-13', '0778966488', 'kasun@gmail.com', 'Yakkala', 'weight_training', 'six_months'),
(20, 'Siluni Himasha', 'siluni', '$2y$10$2NA5E6nN9KNnbDxOEddjremyt23N/SJOylMlvhxTijONnGlX/z9.K', '2005-03-18', 'female', '2024-10-13', '07858877401', 'siluni@gmail.com', 'Nittabuwa', 'cardio_training', 'six_months'),
(21, 'Tharindu Madusanka', 'tharindu', '$2y$10$uK0sHjgUOexoiDa087b7k.C23Ec.vwx/TowUEEHvluqcpYEr9oyaK', '1998-05-11', 'male', '2024-10-13', '0765580020', 'tharindu@gmail.com', 'Mirigama', 'cardio_weight_training', 'one_month');

-- --------------------------------------------------------

--
-- Table structure for table `member_data`
--

DROP TABLE IF EXISTS `member_data`;
CREATE TABLE IF NOT EXISTS `member_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `exercise_plan` varchar(255) NOT NULL,
  `payment_plan` varchar(255) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member_data`
--

INSERT INTO `member_data` (`id`, `member_id`, `email`, `exercise_plan`, `payment_plan`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'radivvl@gmail.com', 'weight_training', 'one_month', 'paid', '2024-10-04 17:39:54', '2024-10-04 17:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `message` text NOT NULL,
  `date_sent` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `member_id`, `message`, `date_sent`) VALUES
(1, 2, 'Your payment plan expires on 2024-11-07.', '2024-10-12 14:03:58'),
(2, 2, 'Your payment plan expires on 2024-11-07.', '2024-10-12 14:04:01'),
(3, 10, 'Your payment plan expires on 2024-11-05.', '2024-10-12 14:04:38'),
(4, 12, 'Your payment plan expires on 2024-11-06.', '2024-10-12 15:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `training_type` varchar(50) DEFAULT NULL,
  `period` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `payment_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `member_id`, `training_type`, `period`, `amount`, `payment_date`, `due_date`, `payment_status`) VALUES
(48, 2, 'cardio_training', 'one_month', 2500.00, '2024-10-13', '2024-11-13', 'paid'),
(49, 20, 'cardio_training', 'six_months', 10000.00, '2024-10-13', '2025-04-13', 'paid'),
(50, 19, 'weight_training', 'six_months', 13000.00, '2024-10-13', '2025-04-13', 'paid'),
(51, 2, 'cardio_training', 'one_month', 2550.00, '2024-10-13', '2024-10-17', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `qrcode`
--

DROP TABLE IF EXISTS `qrcode`;
CREATE TABLE IF NOT EXISTS `qrcode` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qrtext` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `qrcode`
--

INSERT INTO `qrcode` (`id`, `qrtext`, `qrimage`, `created_at`) VALUES
(7, 'Text: hutta\nDescription: erterte\nEmail: ertet@dfsdfs\nPhone: 4545363', '1728061385.png', '2024-10-04 17:03:05'),
(8, 'Text: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728062017.png', '2024-10-04 17:13:37'),
(9, 'Text: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728062264.png', '2024-10-04 17:17:44'),
(10, 'Text: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728062600.png', '2024-10-04 17:23:20'),
(11, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728063594.png', '2024-10-04 17:39:55'),
(12, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728063691.png', '2024-10-04 17:41:32'),
(13, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728063740.png', '2024-10-04 17:42:21'),
(14, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728065030.png', '2024-10-04 18:03:51'),
(15, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728065253.png', '2024-10-04 18:07:34'),
(16, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728210393.png', '2024-10-06 10:26:34'),
(17, 'Member ID: 2\nDescription: weight_training\nEmail: radivvl@gmail.com\nPhone: one_month', '1728210892.png', '2024-10-06 10:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `schedule_file` varchar(255) NOT NULL,
  `upload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`schedule_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `member_id`, `schedule_file`, `upload_date`) VALUES
(1, 5, 'uploads/schedules/hd-cse---weekly-schedule-7th-to-11th-october-2024.pdf', '2024-10-12 14:44:13'),
(2, 2, 'uploads/schedules/hd-cse---weekly-schedule-7th-to-11th-october-2024.pdf', '2024-10-12 14:49:46'),
(3, 2, 'uploads/schedules/screencapture-localhost-Gym-member-test-php-2024-10-08-13_13_27.png', '2024-10-12 15:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
CREATE TABLE IF NOT EXISTS `trainers` (
  `trainer_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text,
  `date_of_birth` date DEFAULT NULL,
  `specialization` varchar(800) DEFAULT NULL,
  `years_of_experience` int DEFAULT NULL,
  `certifications` text,
  `availability` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`trainer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainer_id`, `full_name`, `username`, `email`, `phone_number`, `address`, `date_of_birth`, `specialization`, `years_of_experience`, `certifications`, `availability`, `password`) VALUES
(11, 'Radil Sanjuna', 'radil', 'radil@gmail.com', '0765368062', 'Gampaha', '1996-06-19', 'bodybuilding', 4, 'National Federation of Professional Trainers (NFPT)', 'weekdays', '$2y$10$s6ao58kW9QxFERbOJYFw7Ocg7G1ezCBQ35ZJQizRCb5PJrVpdbXKC'),
(12, 'Kavishka Anurada', 'kavishka', 'kavishka@gmail.com', '0778965966', 'Katunayaka', '1995-06-09', 'group fitness', 5, 'Fitness Mentors', 'weekdays', '$2y$10$LB3ZqHNAvSwiM9BkJgWwK.K9WJ.AyyXZIwSRHJftpYkSKOYCzxEOe');

-- --------------------------------------------------------

--
-- Table structure for table `trainers_pro`
--

DROP TABLE IF EXISTS `trainers_pro`;
CREATE TABLE IF NOT EXISTS `trainers_pro` (
  `trainer_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `bio` text,
  `twitter_link` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trainer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trainers_pro`
--

INSERT INTO `trainers_pro` (`trainer_id`, `full_name`, `profile_img`, `position`, `bio`, `twitter_link`, `facebook_link`, `linkedin_link`, `instagram_link`) VALUES
(1, 'Radil Sanjuna', 'IMG-20240718-WA0007.jpg', NULL, 'adsvf', '', '', '', ''),
(2, 'Kavishka Kotikara', 'eng_deployment_infrastructure_simple.png', NULL, 'asfaf', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_classes`
--

DROP TABLE IF EXISTS `user_classes`;
CREATE TABLE IF NOT EXISTS `user_classes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `class_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
