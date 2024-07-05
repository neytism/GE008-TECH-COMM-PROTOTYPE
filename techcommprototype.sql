-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 12:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techcommprototype`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` varchar(53) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `organization_id`, `image_name`, `name`, `category_id`, `stock`, `price`) VALUES
('CGC001', 3, 4, 'CGC001.png', 'Qiqi Sticker', 2, 30, 25.00),
('CGC002', 3, 4, 'CGC002.png', 'CIIT Pin', 3, 12, 50.00),
('IND001', 1, 1, 'IND001.png', 'Qiqi na malungkot', 2, 50, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `name`) VALUES
(1, 'Others'),
(2, 'Stickers'),
(3, 'Pins'),
(4, 'Shirts'),
(5, 'Foods'),
(6, 'Drinks'),
(7, 'Lanyards'),
(8, 'Keycaps'),
(9, 'Keychains');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `type` enum('sales','inventory','user','system','payment') NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `details` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `type`, `userID`, `details`, `timestamp`) VALUES
(1, 'user', 1, 'User Nate Florendo logged in.', '2024-07-02 21:01:12'),
(2, 'user', 1, 'User Nate Florendo logged in.', '2024-07-02 21:19:35'),
(3, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-02 21:28:12'),
(4, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-02 21:41:37'),
(5, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-04 17:12:57'),
(7, 'inventory', 3, 'User 3 - Oliver Chiuco from CIIT Gaming Community added an item CGC001 - Navia Sticker.', '2024-07-04 17:26:18'),
(8, 'inventory', 3, 'User 3 - Oliver Chiuco from CIIT Gaming Community added an item: CGC002 - CIIT Pin. Stock: 12 - Price: P 50', '2024-07-04 17:28:56'),
(9, 'inventory', 3, 'User 3 - Oliver Chiuco updated item:  - Item name from  to Navia Sticker .Stock from  to 12 .Price from  to 25.00 .Category from  to Stickers .', '2024-07-04 20:20:37'),
(10, 'inventory', 3, 'User 3 - Oliver Chiuco updated item:  - Item name from  to Navia Sticker .Stock from  to 12 .Price from  to 25.00 .Category from  to Stickers .', '2024-07-04 20:28:14'),
(11, 'inventory', 3, 'User 3 - Oliver Chiuco updated item:  - Item name from  to Navia Sticker .Stock from  to 12 .Price from  to 25.00 .Category from  to Stickers .', '2024-07-04 20:30:50'),
(12, 'inventory', 3, 'User 3 - Oliver Chiuco updated item:  - Item name from  to Navia Sticker .Stock from  to 12 .Price from  to 25.00 .Category from  to Stickers .', '2024-07-04 20:32:52'),
(13, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Category from Stickers to Foods .', '2024-07-04 20:37:36'),
(14, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Changed image. ', '2024-07-04 20:43:26'),
(15, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Changed image. ', '2024-07-04 20:44:23'),
(16, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Changed image. ', '2024-07-04 20:44:47'),
(17, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Item name from Navia Sticker to Qiqi Sticker. Changed image. Stock from 12 to 30. Price from 25.00 to 30. Category from Foods to Stickers. ', '2024-07-04 20:45:28'),
(18, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Price from P30.00 to P25.00. ', '2024-07-04 20:48:40'),
(19, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-04 21:01:30'),
(20, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-04 21:29:46'),
(21, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-04 21:30:10'),
(22, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-05 14:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `code`, `name`, `active`) VALUES
(1, 'IND', 'Individual', 1),
(2, 'SCO', 'Student Council', 1),
(3, 'OBE', 'Obelisk', 1),
(4, 'CGC', 'CIIT Gaming Community', 1),
(5, 'COS', 'Cosplay Arcase', 1),
(6, 'SZN', 'Safezone', 1),
(7, 'ATL', 'Atelier', 1),
(8, 'AXS', '3D Axis', 1),
(9, 'LBX', 'Lightbox', 1),
(10, 'TNS', 'Tunes', 1),
(11, 'SPD', 'Spades', 1),
(12, '24F', '23 Frammes', 1),
(13, 'TLN', 'Telon', 1),
(14, 'GES', 'Gesalt', 1),
(15, 'PXH', 'PixelHive', 1),
(16, 'SYN', 'Syntax', 0);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` varchar(11) NOT NULL,
  `buyer_id` varchar(11) DEFAULT NULL,
  `seller_id` varchar(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `total_amount` varchar(50) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `buyer_id`, `seller_id`, `organization_id`, `details`, `total_amount`, `payment_method`, `timestamp`) VALUES
('CGC000001', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-05 22:00:19'),
('CGC000002', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-05 22:01:05'),
('CGC000003', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-05 22:05:11'),
('CGC000004', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 75', 'Cash', '2024-07-05 22:05:57'),
('CGC000005', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 75', 'Cash', '2024-07-05 22:10:48'),
('CGC000006', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 75', 'Cash', '2024-07-05 22:12:15'),
('CGC000007', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 75', 'Cash', '2024-07-05 22:12:46'),
('CGC000008', '1', '3', 4, '1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 25', 'Cash', '2024-07-05 22:17:08'),
('CGC000009', '1', '3', 4, '1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 25', 'Cash', '2024-07-05 22:18:45'),
('CGC000010', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-05 22:19:14'),
('CGC000011', '1', '3', 4, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-05 22:21:22'),
('CGC000012', '1', '3', 4, '1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 25', 'Cash', '2024-07-05 22:21:38'),
('CGC000013', '1', '3', 4, '1x x CGC001 - QIQI STICKER = P 25.00 . 2x x CGC002 - CIIT PIN = P 50.00 . ', 'P 125', 'Cash', '2024-07-05 22:29:02'),
('CGC000014', '1', '3', 4, '2x x CGC001 - QIQI STICKER = P 25.00 . 1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 100', 'Cash', '2024-07-05 22:34:47'),
('CGC000015', '1', '3', 4, '4x x CGC001 - QIQI STICKER = P 25.00 . 4x x CGC002 - CIIT PIN = P 50.00 . ', 'P 300', 'Gcash', '2024-07-05 22:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('master','admin','seller','student') NOT NULL,
  `organization` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `role`, `organization`, `password`, `email`, `student_number`) VALUES
(1, 'neytism', 'Nate Florendo', 'master', 1, 'admin000', 'nate.florendo@ciit.edu.ph', '17213541'),
(3, 'oli', 'Oliver Chiuco', 'admin', 4, 'admin000', 'oliver.chiuco@ciit.edu.ph', '17223818');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization` (`organization`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `item_category` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organization`) REFERENCES `organizations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
