-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 08, 2022 at 04:52 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.25

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
-- Table structure for table `Logging`
--

CREATE TABLE `Logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `IP` char(255) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `requested_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Subscription`
--

CREATE TABLE `subscriptions` (
  `creator_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  `status` enum('PENDING','REJECTED','ACCEPTED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `api_keys` (
  `key` VARCHAR(255) NOT NULL,
  `client` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`key`))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert into api_keys values ('1504d8188eff6a9be0ba6c9f4e4dc98ba7a3f60d54968b3c908bef3f1d68978b', 'binotify premium server'),
('d1c4af67dc37c4bcb3b33b6e199f5c5b74ee7d098dd6e24d196b82fd5cda8e0d', 'binotify app');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Logging`
--
ALTER TABLE `Logging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Subscriptions`
--
ALTER TABLE `Subscriptions`
  ADD PRIMARY KEY (`creator_id`, `subscriber_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Logging`
--
ALTER TABLE `Logging`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

