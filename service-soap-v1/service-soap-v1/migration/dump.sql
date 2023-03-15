-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 01, 2022 at 09:58 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysql_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `key` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`key`, `client`) VALUES
('1504d8188eff6a9be0ba6c9f4e4dc98ba7a3f60d54968b3c908bef3f1d68978b', 'binotify premium server'),
('d1c4af67dc37c4bcb3b33b6e199f5c5b74ee7d098dd6e24d196b82fd5cda8e0d', 'binotify app');

-- --------------------------------------------------------

--
-- Table structure for table `Logging`
--

CREATE TABLE `Logging` (
  `id` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `IP` char(255) COLLATE utf8mb4_general_ci NOT NULL,
  `endpoint` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `requested_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Logging`
--

INSERT INTO `Logging` (`id`, `description`, `IP`, `endpoint`, `requested_at`) VALUES
(1, 'binotify premium server:[]', '192.168.176.1:32970', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 13:45:05'),
(2, 'binotify premium server:[]', '192.168.176.1:34434', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:44:11'),
(3, 'binotify premium server:[]', '192.168.176.1:34454', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:45:43'),
(4, 'binotify premium server:[]', '192.168.176.1:34466', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:45:44'),
(5, 'binotify premium server:[]', '192.168.176.1:34478', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:46:49'),
(6, 'binotify premium server:[]', '192.168.176.1:34482', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:46:50'),
(7, 'binotify premium server:[]', '192.168.176.1:34494', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:48:43'),
(8, 'binotify premium server:[]', '192.168.176.1:34494', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:48:43'),
(9, 'binotify premium server:[]', '192.168.176.1:34514', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:52:14'),
(10, 'binotify premium server:[]', '192.168.176.1:34534', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:55:10'),
(11, 'binotify premium server:[]', '192.168.176.1:34572', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:55:29'),
(12, 'binotify premium server:[8,3]', '192.168.176.1:34586', 'ws.SubscriptionWSImpl.subscribe', '2022-11-30 15:55:33'),
(13, 'binotify premium server:[]', '192.168.176.1:34596', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 15:55:37'),
(14, 'binotify premium server:[]', '192.168.176.1:34658', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-11-30 16:01:35'),
(15, 'binotify premium server:[1,3]', '192.168.176.1:35004', 'ws.SubscriptionWSImpl.checkStatus', '2022-11-30 16:17:06'),
(16, 'binotify premium server:parameters{}', '172.19.0.1:35572', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:18:08'),
(17, 'binotify premium server:parameters{}', '172.19.0.1:35578', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:18:08'),
(18, 'binotify premium server:parameters{[11],[2]}', '172.19.0.1:35712', 'ws.SubscriptionWSImpl.acceptSubscription', '2022-12-01 21:19:26'),
(19, 'binotify premium server:parameters{}', '172.19.0.1:35750', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:19:32'),
(20, 'binotify premium server:parameters{}', '172.19.0.1:35754', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:19:32'),
(21, 'binotify premium server:parameters{}', '172.19.0.1:35802', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:20:08'),
(22, 'binotify premium server:parameters{}', '172.19.0.1:35806', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:20:08'),
(23, 'binotify premium server:parameters{}', '172.19.0.1:35864', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:50:10'),
(24, 'binotify premium server:parameters{}', '172.19.0.1:35868', 'ws.SubscriptionWSImpl.getSubscriptions', '2022-12-01 21:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `Subscriptions`
--

CREATE TABLE `Subscriptions` (
  `creator_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  `status` enum('PENDING','REJECTED','ACCEPTED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Subscriptions`
--

INSERT INTO `Subscriptions` (`creator_id`, `subscriber_id`, `status`) VALUES
(1, 1, 'PENDING'),
(1, 2, 'PENDING'),
(1, 3, 'ACCEPTED'),
(8, 3, 'PENDING'),
(11, 2, 'ACCEPTED');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `Logging`
--
ALTER TABLE `Logging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Subscriptions`
--
ALTER TABLE `Subscriptions`
  ADD PRIMARY KEY (`creator_id`,`subscriber_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Logging`
--
ALTER TABLE `Logging`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
