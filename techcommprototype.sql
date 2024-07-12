-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 11:04 PM
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
('IND001', 1, 1, 'IND001.png', 'Qiqi na malungkot', 2, 5, 25.00);

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
(22, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-05 14:56:33'),
(23, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-06 15:33:58'),
(24, 'inventory', 1, 'User 1 - Nate Florendo updated item: IND001 - Stock from 50 to 5. ', '2024-07-06 15:38:44'),
(25, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-06 19:06:59'),
(26, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-06 19:08:39'),
(27, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-06 19:40:30'),
(28, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-06 21:26:34'),
(29, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-07 10:45:49'),
(30, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-07 10:58:39'),
(31, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 10:59:38'),
(32, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 11:00:58'),
(33, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-07 14:34:07'),
(34, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 15:29:52'),
(35, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 17:01:02'),
(36, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-07 17:15:32'),
(37, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 18:59:48'),
(38, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-07 19:57:28'),
(39, 'sales', 3, 'User 3 - Oliver Chiuco issued CGC-000-016 receipt to 1 - Nate Florendo.', '2024-07-07 21:38:05'),
(40, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-07 21:43:25'),
(41, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-11 22:52:30'),
(42, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-12 14:33:50');

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
(5, 'COS', 'Cosplay Arcade', 1),
(6, 'SZN', 'Safezone', 1),
(7, 'ATL', 'Atelier', 1),
(8, 'AXS', '3D Axis', 1),
(9, 'LBX', 'Lightbox', 1),
(10, 'TNS', 'Tunes', 1),
(11, 'SPD', 'Spades', 1),
(12, '24F', '24 Frames', 1),
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
('CGC000015', '1', '3', 4, '4x x CGC001 - QIQI STICKER = P 25.00 . 4x x CGC002 - CIIT PIN = P 50.00 . ', 'P 300', 'Gcash', '2024-07-05 22:35:56'),
('CGC000016', '1', '3', 4, '2x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 125', 'Cash', '2024-07-07 21:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` enum('individual','organization','event') DEFAULT 'individual',
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `val` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `organization_id`, `val`) VALUES
(-1, 'individual', 1, '--navbar-hor-padding: 15px;|--navbar-vert-padding: 10px;|--navbar-height: 53px;|--product-card-height: 300px;|--panel-spacing: 15px;|--navbar-color-1: #00364d;|--navbar-color-2: #43c8f4;|--navbar-text-color: #ffffff;|--background-color-1: #b2f4ff;|--background-color-2: #b2f4ff;|--primary-color: #00364d;|--button-accent-color: #43c8f4;|--card-color: #ffffff;|--card-text-color: #000000;|--cancel-color: #969696;|--confirm-color: #26b926;'),
(0, 'organization', 12, '--navbar-color-1: #CA5A00; | --navbar-color-2: #D99800; | --navbar-text-color: #FFFFFF; | --background-color-1: #FFBA00; | --background-color-2: #FFBA00; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #FF590F; | --card-color: #FFDE86; | --card-text-color: #000000; | --cancel-color: #B4A32F; | --confirm-color: #FF8400;'),
(1, 'individual', 1, '--navbar-color-1: #000000; | --navbar-color-2: #000000; | --navbar-text-color: #FFFFFF; | --background-color-1: #151515; | --background-color-2: #151515; | --primary-color: #858585; | --button-accent-color: #000000; | --card-color: #FFFFFF; | --card-text-color: #000000; | --cancel-color: #727272; | --confirm-color: #000000;'),
(4, 'individual', 1, '--navbar-color-1: rgb(0, 54, 77); | --navbar-color-2: rgb(67, 200, 244); | --navbar-text-color: #ffffff; | --background-color-1: rgba(178, 224, 228, 0.9); | --background-color-2: rgba(178, 224, 228, 0.9); | --primary-color: rgb(0, 54, 77); | --button-accent-color: rgb(67, 200, 244); | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: rgb(38, 185, 38);'),
(0, 'organization', 8, '--navbar-color-1: #6C6C6C; | --navbar-color-2: #6C6C6C; | --navbar-text-color: #ffffff; | --background-color-1: #4E4E4E; | --background-color-2: #242424; | --primary-color: #4E4E4E; | --button-accent-color: #CA7B2D; | --card-color: #444444; | --card-text-color: #FFFFFF; | --cancel-color: rgb(110, 110, 110); | --confirm-color: rgb(38, 185, 38);'),
(0, 'organization', 7, '--navbar-color-1: #000000; | --navbar-color-2: #000000; | --navbar-text-color: #FFFFFF; | --background-color-1: #7A2B2B; | --background-color-2: #0A0A0A; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #FF0000; | --card-color: #FFFFFF; | --card-text-color: #711D1D; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #B93B26;'),
(0, 'organization', 4, '--navbar-color-1: #000000; | --navbar-color-2: #6A1515; | --navbar-text-color: #ffffff; | --background-color-1: #000000; | --background-color-2: #181818; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #825656; | --card-color: #282828; | --card-text-color: #D5434E; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #842A2A;'),
(0, 'organization', 9, '--navbar-color-1: #3B0A75; | --navbar-color-2: #3B0A75; | --navbar-text-color: #55BC8F; | --background-color-1: #6649D5; | --background-color-2: #6649D5; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #55BC8F; | --card-color: #EEFFB8; | --card-text-color: #3B0A75; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #6649D5;'),
(0, 'organization', 3, '--navbar-color-1: #A636A4; | --navbar-color-2: #A636A4; | --navbar-text-color: #FFFFFF; | --background-color-1: #A636A4; | --background-color-2: #502C8E; | --primary-color: #517F93; | --button-accent-color: #A636A4; | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #A636A4;'),
(0, 'organization', 15, '--navbar-color-1: #F58138; | --navbar-color-2: #F58138; | --navbar-text-color: #ffffff; | --background-color-1: #F58138; | --background-color-2: #FFC070; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #FF7C24; | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #FFA417;'),
(0, 'organization', 6, '--navbar-color-1: #FF76A4; | --navbar-color-2: #FF76A4; | --navbar-text-color: #ffffff; | --background-color-1: #FFF1B4; | --background-color-2: #FFC0E2; | --primary-color: rgb(0, 54, 77); | --button-accent-color: #FF76A4; | --card-color: #FFE5EE; | --card-text-color: #353535; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #FF76A4;'),
(0, 'organization', 2, '--navbar-color-1: #00364D; | --navbar-color-2: #00364D; | --navbar-text-color: #FFFFFF; | --background-color-1: #D0D0D0; | --background-color-2: #F4F4F4; | --primary-color: #00364D; | --button-accent-color: #8E8E8E; | --card-color: #FFFFFF; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #005B81;'),
(3, 'individual', 1, '--navbar-color-1: #00364d; | --navbar-color-2: #43c8f4; | --navbar-text-color: #ffffff; | --background-color-1: #b2f4ff; | --background-color-2: #b2f4ff; | --primary-color: #00364d; | --button-accent-color: #43c8f4; | --card-color: #ffffff; | --card-text-color: #000000; | --cancel-color: #969696; | --confirm-color: #26b926;');

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
  `student_number` varchar(50) DEFAULT NULL,
  `status` enum('student','pending','approved','disabled') NOT NULL,
  `use_template` enum('true','false') NOT NULL,
  `use_username` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `role`, `organization`, `password`, `email`, `student_number`, `status`, `use_template`, `use_username`) VALUES
(1, 'neytism', 'Nate Florendo', 'master', 1, 'admin000', 'nate.florendo@ciit.edu.ph', '17213541', 'approved', 'true', 'true'),
(3, 'oli', 'Oliver Chiuco', 'admin', 4, 'admin000', 'oliver.chiuco@ciit.edu.ph', '17223818', 'approved', 'false', 'true'),
(4, 'ziyun', 'Ziyun Reyes', 'seller', 12, 'admin000', 'pepito.reyes@ciit.edu.ph', '17223712', 'approved', 'true', 'true');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
