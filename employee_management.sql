-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2025 at 01:27 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `national_id` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` int NOT NULL,
  `position` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `employee_no` int NOT NULL,
  `wage_rate` int DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `kin` varchar(50) NOT NULL,
  `kin_contact` varchar(50) NOT NULL,
  `date_joined` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Active','Suspended','Terminated') DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `national_id`, `dob`, `address`, `email`, `mobile`, `position`, `department`, `employee_no`, `wage_rate`, `gender`, `kin`, `kin_contact`, `date_joined`, `status`) VALUES
(9, 'Sherman', 'Mehlo', '63-2358661 V 58', '2004-02-04', 'Rome, Italy', 'shermanmehlo2.0@gmail.com', 784862247, 'Senior developer', 'IT', 1, 22, 'male', 'Mai Sherman', '0774412880', '2025-07-07 10:50:23', 'Active'),
(10, 'Frank', 'Pswarai', '33-7845287 F98', '2000-08-06', 'Rome, Italy', 'frankie@gmail.com', 773476109, 'Associate Director', 'Finance', 2, 25, 'male', 'Mother Pswarai', '0787649649', '2025-07-07 10:53:19', 'Active'),
(18, 'Jane', 'Doe', '', '1998-07-02', '54 Lane Grove Rd.', 'janedoe@gmail.com', 774351298, 'Accountant', 'Finance', 3, 20, 'female', 'John Doe', '0773521479', '2025-07-07 00:00:00', 'Active'),
(20, 'Jesse', 'Pinkman', '', '0000-00-00', '', 'jessepinkman@gmail.c', 773476109, 'Project Manager', 'Marketing', 4, NULL, NULL, '', '', '2025-07-08 00:00:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `former_employees`
--

DROP TABLE IF EXISTS `former_employees`;
CREATE TABLE IF NOT EXISTS `former_employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `employee_no` int DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `mobile` int NOT NULL,
  `date_joined` date DEFAULT NULL,
  `date_suspended` date DEFAULT NULL,
  `status` enum('suspended') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_apps`
--

DROP TABLE IF EXISTS `leave_apps`;
CREATE TABLE IF NOT EXISTS `leave_apps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `employee_no` int NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `leave_type` enum('vacation','annual','maternity','paternity','bereavement','sick','unpaid') DEFAULT NULL,
  `reason` varchar(30) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_apps`
--

INSERT INTO `leave_apps` (`id`, `first_name`, `last_name`, `employee_no`, `date_from`, `date_to`, `leave_type`, `reason`, `status`) VALUES
(1, 'Sherman', 'Mehlo', 1, '2025-07-01', '2025-07-03', 'sick', 'Sick', 'approved'),
(2, 'Sherman', 'Mehlo', 1, '2025-07-07', '2025-07-11', 'annual', 'Annual Leave', 'approved'),
(3, 'Frank', 'Pswarai', 2, '2025-07-01', '2025-07-04', 'vacation', 'Vacation Leave', 'rejected'),
(4, 'Jane', 'Doe', 3, '2025-07-10', '2025-07-14', 'vacation', 'Vacation Leave', 'approved'),
(5, 'Sherman', 'Mehlo', 1, '2025-07-09', '2025-07-11', 'sick', 'Sherman has caught COVID-19', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

DROP TABLE IF EXISTS `timesheets`;
CREATE TABLE IF NOT EXISTS `timesheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `employee_no` int DEFAULT NULL,
  `department` varchar(100) NOT NULL,
  `calendar` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `main_activity` varchar(30) DEFAULT NULL,
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `first_name`, `last_name`, `employee_no`, `department`, `calendar`, `time_in`, `time_out`, `main_activity`, `submitted_at`) VALUES
(15, 'Frank', 'Pswarai', 2, '', '2025-07-02', '08:10:00', '16:14:00', 'Book reviews', '2025-07-05 13:09:05'),
(14, 'Frank', 'Pswarai', 2, '', '2025-07-01', '08:07:00', '16:10:00', 'Meetings', '2025-07-05 13:07:58'),
(13, 'Sherman', 'Mehlo', 1, '', '2025-07-04', '09:02:00', '16:20:00', 'Recording books', '2025-07-05 11:43:36'),
(16, 'Maria', 'Smith', 3, '', '2025-06-30', '08:00:00', '16:12:00', 'Recording Cash Flows', '2025-07-07 11:43:21'),
(17, 'Maria', 'Smith', 3, '', '2025-07-01', '08:10:00', '16:20:00', 'Recording Income Statements', '2025-07-07 11:45:20'),
(18, 'Jane', 'Doe', 3, '', '2025-07-01', '09:00:00', '17:10:00', 'Recording Income Statements', '2025-07-08 12:41:34'),
(19, 'Jane', 'Doe', 3, '', '2025-07-02', '08:14:00', '16:30:00', 'Balancing books', '2025-07-08 12:42:32'),
(20, 'Sherman', 'Mehlo', 1, '', '2025-07-08', '08:00:00', '16:10:00', 'Coding', '2025-07-08 13:59:07'),
(21, 'Sherman', 'Mehlo', 1, '', '2025-07-09', '08:00:00', '17:30:00', 'Backend Development', '2025-07-08 15:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('employee','manager') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `role`) VALUES
(2, 'Sherman', 'Mehlo', 'Sherman', 'shermanmehlo2.0@gmail.com', '$2y$10$2y7I/BX09a0No5pmTivP2OSeaHabspffc46nMTP068Uh2QzTe22eO', 'employee'),
(3, 'Walter', 'White', 'Walt', 'walterwhite@gmail.com', '$2y$10$X4pRgL.ESau2B2T6C6AqmOFG.KiCQdKcUBUs7ViPIAUHz2BkqF4qy', 'manager'),
(4, 'Frank', 'Pswarai', 'frakiemiboi', 'frankie@gmail.com', '$2y$10$zymKTV1acnty/g2LER5b5OQFGetIS//dL2YnbDoAeFScYVcgH9AOK', 'employee'),
(5, 'Maria', 'Smith', 'maria', 'mariasmith@gmail.com', '$2y$10$CA5Q4xyGBxojl7sYg4zOeOXcUg8Q08Coc0PWeGeulEbTMYr7c/KzG', 'employee'),
(6, 'Jane', 'Doe', 'jane', 'janedoe@gmail.com', '$2y$10$kFBKx9rMp/bQVlxgJKBFTeuqxS.EC2SWo/aUjcNddvdBs6pNvFUt.', 'employee');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
