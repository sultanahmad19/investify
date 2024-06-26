-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 07:32 AM
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
-- Database: `digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `password`, `login_token`) VALUES
(7, 'Ibtash', 'officialinvestify@gmail.com', 123456532, '$2y$10$O1uUD/MoKPORV7bAEXjFAuqrQzfCQX75z3mKe.qez5CjXqA6JnkP6', NULL),
(8, 'admin', 'admin@gmail.com', 112222333, '$2y$10$wTn8o87.Jh2BkRojuRg8O.VfyRvvSWe64bl/nwMR0og4yKdX1jXbq', 'KOZnXJUSgtYLP6lJ6aZifAbVwCg5Bvt7'),
(9, 'Sultan', 'arssul917@gmail.com', 2147483647, '$2y$10$vz7f/XmyreZ3DvO4h/aaLurEbvz53YTtLKoC0CMvP7H1vGMiGQDRe', 'q8dLs8jU5ypjQOMPQe3EJjXzuzRlkp7m');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `email`, `gateway`, `amount`, `time`) VALUES
(253, 'aaa@gmail.com', 'Perfect-money', 121, '2024-06-22 05:32:47.631450'),
(254, 'ali@gmail.com', 'Perfect-money', 222, '2024-06-22 06:02:34.971349');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `trx_id` int(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `profit` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `tamount` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) DEFAULT 'active',
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `trx_id`, `email`, `plan`, `profit`, `amount`, `tamount`, `created_at`, `status`, `duration`) VALUES
(170, 0, 'aaa@gmail.com', '7 Days', '3', 20, 20, '2024-06-22 06:00:54', 'active', 7),
(171, 0, 'ali@gmail.com', '7 Days', '7.5', 50, 50, '2024-06-22 06:04:01', 'active', 7);

-- --------------------------------------------------------

--
-- Table structure for table `refer_plan`
--

CREATE TABLE `refer_plan` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refer_plan`
--

INSERT INTO `refer_plan` (`id`, `user_email`, `plan`, `amount`, `created_at`) VALUES
(64, 'arssul917@gmail.com', 'Platinum', 20.00, '2024-06-22 05:55:04'),
(65, 'arssul917@gmail.com', 'Gold', 50.00, '2024-06-22 05:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `tdeposit`
--

CREATE TABLE `tdeposit` (
  `id` int(11) NOT NULL,
  `trx_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tdeposit` int(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tdeposit`
--

INSERT INTO `tdeposit` (`id`, `trx_id`, `name`, `email`, `tdeposit`, `created_at`) VALUES
(209, 11111111, 'aaa', 'aaa@gmail.com', 121, '2024-06-22 05:33:14.151172'),
(210, 22222, 'eee', 'ali@gmail.com', 222, '2024-06-22 06:02:48.012816');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `trx_id` int(11) NOT NULL,
  `method_code` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `tdeposit` decimal(50,2) DEFAULT 0.00,
  `available_earnings` varchar(255) NOT NULL,
  `twithdraw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `trx_id`, `method_code`, `created_at`, `name`, `email`, `amount`, `tdeposit`, `available_earnings`, `twithdraw`) VALUES
(228, 21312, '2', '2024-06-21 04:56:57', 'Sultan Ahmad', 'arssul917@gmail.com', 23, 11.50, '0', ''),
(244, 11111111, '0', '2024-06-22 05:33:14', 'aaa', 'aaa@gmail.com', 121, 101.00, '0', ''),
(245, 22222, '2', '2024-06-22 06:02:48', 'eee', 'ali@gmail.com', 222, 172.00, '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `referred_by` varchar(255) NOT NULL DEFAULT '0',
  `referral_earnings` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `token`, `referral_code`, `referred_by`, `referral_earnings`) VALUES
(154, 'Sultan Ahmad', 'arssul917@gmail.com', 234234234, '$2y$10$DLfuvk0DAKbYXbrRFEUqie9DgUcKP1bfbxyJk1wDo4zY60SPhDphu', '', 'B0876F834A', '', 1.50),
(171, 'aaa', 'aaa@gmail.com', 937892763, '$2y$10$faN2bO/fiEEI6Pq/KN2fBOUz5advUqMnbAnPvGXG6GW3bLDQWjZpe', '', '4BE1C174C1', 'B0876F834A', 0.00),
(172, 'eee', 'ali@gmail.com', 234232323, '$2y$10$z4AUVvmFr9HCxlKAEn7dg.rdmIn8X/Gu7E8SfiJAoz.Gi0oT5Sih2', '', '04E131626D', 'B0876F834A', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `account` varchar(255) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refer_plan`
--
ALTER TABLE `refer_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `tdeposit`
--
ALTER TABLE `tdeposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `refer_plan`
--
ALTER TABLE `refer_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tdeposit`
--
ALTER TABLE `tdeposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `refer_plan`
--
ALTER TABLE `refer_plan`
  ADD CONSTRAINT `refer_plan_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
