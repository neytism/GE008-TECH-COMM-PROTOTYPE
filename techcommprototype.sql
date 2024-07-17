-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2024 at 06:51 PM
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
('ALL001', 1, 0, 'ALL001.png', 'CIIT Banner Sticker', 2, 15, 25.00),
('ALL002', 1, 0, 'ALL002.png', 'A Ghibli Sticker', NULL, 15, 25.00),
('ALL003', 1, 0, 'ALL003.png', 'Kazuha', 2, 1, 25.00),
('ALL004', 1, 0, 'ALL004.png', 'Ei', 2, 1, 25.00),
('ALL005', 1, 0, 'ALL005.png', 'ganyu', 2, 1, 25.00),
('ALL006', 1, 0, 'ALL006.png', 'It\'s ok', 2, 1, 25.00),
('ALL007', 1, 0, 'ALL007.png', 'WOAH', 2, 1, 25.00),
('ALL008', 1, 0, 'ALL008.png', 'Brother what?', 2, 1, 25.00),
('ALL009', 1, 0, 'ALL009.png', 'T-pose', 2, 1, 25.00),
('ALL010', 1, 0, 'ALL010.png', 'Neuron Activation', 2, 1, 25.00),
('ALL011', 1, 0, 'ALL011.png', 'Childe', 3, 1, 30.00),
('ALL012', 1, 0, 'ALL012.png', 'Minus tech tips', 3, 1, 30.00),
('ALL013', 1, 0, 'ALL013.png', 'Hmmmm???', 3, 1, 30.00),
('ALL014', 1, 0, 'ALL014.png', 'Hmmm...', 3, 1, 30.00),
('ALL015', 1, 0, 'ALL015.png', 'Cat', 3, 1, 30.00),
('ALL016', 1, 0, 'ALL016.png', 'Just the white shirt', 4, 1, 176.00),
('ALL017', 1, 0, 'ALL017.png', 'Strawberry Shake', 6, 1, 50.00),
('ALL018', 1, 0, 'ALL018.png', 'Chocolate Shake', 6, 1, 50.00),
('ALL019', 1, 0, 'ALL019.png', 'Borgir', 5, 1, 55.00),
('ALL020', 1, 0, 'ALL020.png', 'Paw Keycap', 8, 1, 100.00),
('CGC001', 3, 4, 'CGC001.png', 'Qiqi Sticker Edit', 2, 5, 25.00),
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
(42, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-12 14:33:50'),
(43, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 12:25:29'),
(44, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 14:45:23'),
(45, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 17:34:31'),
(46, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 17:34:43'),
(47, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 17:34:54'),
(48, 'user', 1, 'User 1 -  logged in.', '2024-07-14 18:02:46'),
(49, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:03:02'),
(50, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:11:44'),
(51, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:12:47'),
(52, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:13:13'),
(53, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:14:55'),
(54, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:16:35'),
(59, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:40:16'),
(60, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:41:12'),
(61, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:41:13'),
(62, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:41:13'),
(63, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:41:25'),
(64, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:30'),
(65, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:30'),
(66, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:31'),
(67, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:31'),
(68, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:31'),
(69, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:43:31'),
(70, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:47:59'),
(71, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:00'),
(72, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:00'),
(73, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:00'),
(74, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:00'),
(75, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:00'),
(76, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:01'),
(77, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:01'),
(78, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:01'),
(79, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:02'),
(80, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:02'),
(81, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:48:02'),
(82, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:54:06'),
(83, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:54:34'),
(84, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:57:49'),
(85, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 18:59:17'),
(86, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 19:01:08'),
(87, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 19:03:02'),
(88, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 19:05:14'),
(89, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 19:33:04'),
(90, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-14 19:48:01'),
(91, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-14 19:52:09'),
(92, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 19:53:04'),
(93, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 20:22:21'),
(94, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 22:44:21'),
(95, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 22:44:43'),
(96, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 22:45:12'),
(97, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 22:46:20'),
(98, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-14 22:48:26'),
(99, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 22:59:37'),
(100, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-14 23:01:02'),
(101, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-14 23:10:54'),
(102, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-15 07:35:27'),
(103, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-15 08:58:41'),
(104, 'sales', 1, 'User 1 - Nate Florendo issued CGC-000-017 receipt to Non-student - NATEODNEROLF@GMAIL.COM.', '2024-07-15 10:14:24'),
(105, 'sales', 1, 'User 1 - Nate Florendo issued CGC-000-018 receipt to Non-student - NATEODNEROLF@GMAIL.COM.', '2024-07-15 11:03:25'),
(106, 'sales', 1, 'User 1 - Nate Florendo issued CGC-000-019 receipt to Non-student - NATEODNEROLF@GMAIL.COM.', '2024-07-15 11:08:16'),
(107, 'sales', 1, 'User 1 - Nate Florendo issued CGC-000-020 receipt to Non-student - NATEODNEROLF@GMAIL.COM.', '2024-07-15 11:10:50'),
(108, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 08:28:45'),
(109, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 09:02:50'),
(110, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-16 09:12:24'),
(111, 'sales', 3, 'User 3 - Oliver Chiuco issued CGC-000-021 receipt to 1 - Nate Florendo.', '2024-07-16 09:15:33'),
(112, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC002 - Item name from CIIT Pin to CIIT Pin Edit. ', '2024-07-16 09:17:05'),
(113, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC002 - Item name from CIIT Pin Edit to CIIT Pin. ', '2024-07-16 09:21:57'),
(114, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Stock from 30 to 0. ', '2024-07-16 09:26:19'),
(115, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Stock from 0 to . ', '2024-07-16 09:26:27'),
(116, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Stock from 0 to 5. ', '2024-07-16 09:26:47'),
(117, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-16 09:28:03'),
(118, 'sales', 3, 'User 3 - Oliver Chiuco issued CGC-000-022 receipt to 1 - Nate Florendo.', '2024-07-16 09:32:13'),
(119, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC001 - Item name from Qiqi Sticker to Qiqi Sticker Edit. ', '2024-07-16 09:33:29'),
(120, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC002 - Stock from 12 to 0. ', '2024-07-16 09:33:40'),
(121, 'inventory', 3, 'User 3 - Oliver Chiuco updated item: CGC002 - Stock from 0 to 12. ', '2024-07-16 09:33:52'),
(122, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-16 09:36:34'),
(123, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 09:37:40'),
(124, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 15:29:51'),
(125, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 15:51:59'),
(126, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-16 17:26:57'),
(127, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 19:20:34'),
(128, 'user', 1, 'User 1 - Changed name from Nate Florendo into Nate Florendo New Name', '2024-07-16 20:06:52'),
(129, 'user', 1, 'User 1 - Changed name from Nate Florendo New Name into Nate Florendo', '2024-07-16 20:07:46'),
(130, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-16 20:09:28'),
(131, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-16 22:59:32'),
(132, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-16 23:19:24'),
(133, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 08:21:49'),
(134, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-17 10:34:18'),
(135, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 11:40:27'),
(136, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 12:23:17'),
(137, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 12:32:06'),
(138, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 12:32:27'),
(139, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-17 12:41:28'),
(140, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 12:41:48'),
(141, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 12:51:34'),
(142, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-17 12:51:48'),
(143, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 12:52:05'),
(144, 'user', 4, 'User 4 - Ziyun Reyes logged in.', '2024-07-17 12:52:23'),
(145, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 13:25:28'),
(146, 'user', 10, 'User 10 - Peter Santiago logged in.', '2024-07-17 14:06:18'),
(147, 'user', 10, 'User 10 - Peter Santiago logged in.', '2024-07-17 14:07:11'),
(148, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 14:16:08'),
(149, 'user', 10, 'User 10 - Peter Santiago logged in.', '2024-07-17 14:20:41'),
(150, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 14:24:32'),
(151, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 14:52:48'),
(152, 'user', 1, 'User 1 - Nate Florendo logged in.', '2024-07-17 14:52:59'),
(153, 'user', 3, 'User 3 - Oliver Chiuco logged in.', '2024-07-17 14:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `code`, `organization_name`, `active`) VALUES
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
('CGC000016', '1', '3', 4, '2x x CGC002 - CIIT PIN = P 50.00 . 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 125', 'Cash', '2024-07-07 21:38:05'),
('CGC000017', 'Non-student', '1', 0, '1x x CGC002 - CIIT PIN = P 50.00 . ', 'P 50', 'Cash', '2024-07-15 10:14:24'),
('CGC000018', 'Non-student', '1', 0, 'TO: NATEODNEROLF@GMAIL.COM 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 25', 'Cash', '2024-07-15 11:03:25'),
('CGC000019', 'Non-student', '1', 4, 'TO: NATEODNEROLF@GMAIL.COM 1x x CGC002 - CIIT PIN = P 50.00 . 2x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 100', 'Cash', '2024-07-15 11:08:16'),
('CGC000020', 'Non-student', '1', 4, 'TO: NATEODNEROLF@GMAIL.COM 1x x CGC001 - QIQI STICKER = P 25.00 . ', 'P 25', 'Cash', '2024-07-15 11:10:50'),
('CGC000021', '1', '3', 4, 'TO: Nate Florendo 3x CGC001 - QIQI STICKER = P 25.00 . 4x CGC002 - CIIT PIN = P 50.00 . ', 'P 275', 'Cash', '2024-07-16 09:15:33'),
('CGC000022', '1', '3', 4, 'TO: Nate Florendo 4x CGC002 - CIIT PIN = P 50.00 . 4x CGC001 - QIQI STICKER = P 25.00 . ', 'P 300', 'Cash', '2024-07-16 09:32:13');

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
(0, 'organization', 12, '--navbar-color-1: #CA5A00; | --navbar-color-2: #D99800; | --navbar-text-color: #FFFFFF; | --background-color-2: #FFBA00; | --background-color-1: #FFBA00; | --button-accent-color: #FF590F; | --card-color: #FFDE86; | --card-text-color: #000000; | --cancel-color: #B4A32F; | --confirm-color: #FF8400;'),
(1, 'individual', 1, '--navbar-color-1: #000000; | --navbar-color-2: #000000; | --navbar-text-color: #ffffff; | --background-color-2: #353535; | --background-color-1: #353535; | --button-accent-color: #000000; | --card-color: #CCCCCC; | --card-text-color: #353535; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #2A9457;'),
(4, 'individual', 1, '--navbar-color-1: rgb(0, 54, 77); | --navbar-color-2: rgb(67, 200, 244); | --navbar-text-color: #ffffff; | --background-color-2: rgba(178, 224, 228, 0.9); | --background-color-1: rgba(178, 224, 228, 0.9); | --button-accent-color: rgb(67, 200, 244); | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: rgb(38, 185, 38);'),
(0, 'organization', 8, '--navbar-color-1: #6C6C6C; | --navbar-color-2: #6C6C6C; | --navbar-text-color: #ffffff; | --background-color-2: #242424; | --background-color-1: #4E4E4E; | --button-accent-color: #CA7B2D; | --card-color: #444444; | --card-text-color: #FFFFFF; | --cancel-color: rgb(110, 110, 110); | --confirm-color: rgb(38, 185, 38);'),
(0, 'organization', 7, '--navbar-color-1: #000000; | --navbar-color-2: #000000; | --navbar-text-color: #FFFFFF; | --background-color-2: #0A0A0A; | --background-color-1: #7A2B2B; | --button-accent-color: #FF0000; | --card-color: #FFFFFF; | --card-text-color: #711D1D; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #B93B26;'),
(0, 'organization', 4, '--navbar-color-1: #000000; | --navbar-color-2: #6A1515; | --navbar-text-color: #ffffff; | --background-color-2: #181818; | --background-color-1: #000000; | --button-accent-color: #825656; | --card-color: #282828; | --card-text-color: #D5434E; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #842A2A;'),
(0, 'organization', 9, '--navbar-color-1: #3B0A75; | --navbar-color-2: #3B0A75; | --navbar-text-color: #55BC8F; | --background-color-2: #6649D5; | --background-color-1: #6649D5; | --button-accent-color: #55BC8F; | --card-color: #EEFFB8; | --card-text-color: #3B0A75; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #6649D5;'),
(0, 'organization', 3, '--navbar-color-1: #A636A4; | --navbar-color-2: #A636A4; | --navbar-text-color: #FFFFFF; | --background-color-2: #502C8E; | --background-color-1: #A636A4; | --button-accent-color: #A636A4; | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #A636A4;'),
(0, 'organization', 15, '--navbar-color-1: #F58138; | --navbar-color-2: #F58138; | --navbar-text-color: #ffffff; | --background-color-2: #FFC070; | --background-color-1: #F58138; | --button-accent-color: #FF7C24; | --card-color: white; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #FFA417;'),
(0, 'organization', 6, '--navbar-color-1: #FF76A4; | --navbar-color-2: #FF76A4; | --navbar-text-color: #ffffff; | --background-color-2: #FFC0E2; | --background-color-1: #FFF1B4; | --button-accent-color: #FF76A4; | --card-color: #FFE5EE; | --card-text-color: #353535; | --cancel-color: rgb(110, 110, 110); | --confirm-color: #FF76A4;'),
(0, 'organization', 2, '--navbar-color-1: #00364D; | --navbar-color-2: #00364D; | --navbar-text-color: #FFFFFF; | --background-color-2: #F4F4F4; | --background-color-1: #D0D0D0; | --button-accent-color: #8E8E8E; | --card-color: #FFFFFF; | --card-text-color: rgb(0, 0, 0); | --cancel-color: rgb(110, 110, 110); | --confirm-color: #005B81;'),
(3, 'individual', 1, '--navbar-color-1: #00364d; | --navbar-color-2: #43c8f4; | --navbar-text-color: #ffffff; | --background-color-1: #b2f4ff; | --background-color-2: #b2f4ff; | --primary-color: #00364d; | --button-accent-color: #43c8f4; | --card-color: #ffffff; | --card-text-color: #000000; | --cancel-color: #969696; | --confirm-color: #26b926;'),
(0, 'organization', 10, '--navbar-color-1: #AB06E8; | --navbar-color-2: #009AA2; | --navbar-text-color: #FFFFFF; | --background-color-2: #FF8E21; | --background-color-1: #FF8E21; | --button-accent-color: #AB06E8; | --card-color: #FFA51D; | --card-text-color: #000000; | --cancel-color: #727272; | --confirm-color: #009AA2;'),
(0, 'organization', 5, '--navbar-color-1: #3B316E; | --navbar-color-2: #3B316E; | --navbar-text-color: #FFFFFF; | --background-color-2: #8A79BE; | --background-color-1: #8A79BE; | --button-accent-color: #3B316E; | --card-color: #FFFFFF; | --card-text-color: #000000; | --cancel-color: #727272; | --confirm-color: #3B316E;'),
(0, 'organization', 11, '--navbar-color-1: #EE7EB0; | --navbar-color-2: #76993B; | --navbar-text-color: #FFFFFF; | --background-color-2: #EAD6CF; | --background-color-1: #EAD6CF; | --button-accent-color: #76993D; | --card-color: #F5EBE1; | --card-text-color: #000000; | --cancel-color: #727272; | --confirm-color: #76993D;'),
(0, 'organization', 13, '--navbar-color-1: #760B03; | --navbar-color-2: #540D08; | --navbar-text-color: #FFFFFF; | --background-color-2: #9B0D04; | --background-color-1: #9B0D04; | --button-accent-color: #640202; | --card-color: #D5372F; | --card-text-color: #FFFFFF; | --cancel-color: #727272; | --confirm-color: #760B03;'),
(0, 'organization', 14, '--navbar-color-1: #7550ED; | --navbar-color-2: #4890FE; | --navbar-text-color: #FFFFFF; | --background-color-2: #2C3232; | --background-color-1: #2C3232; | --button-accent-color: #FC9E04; | --card-color: #F9F5F2; | --card-text-color: #000000; | --cancel-color: #727272; | --confirm-color: #FF4B7A;'),
(0, 'organization', 16, '--navbar-color-1: #00202F; | --navbar-color-2: #01354D; | --navbar-text-color: #43C8F5; | --background-color-2: #012130; | --background-color-1: #012E43; | --button-accent-color: #FFFFFF; | --card-color: #04415E; | --card-text-color: #FFFFFF; | --cancel-color: #727272; | --confirm-color: #43C8F5;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('master','seller','student') NOT NULL DEFAULT 'student',
  `active_organization` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `use_template` enum('true','false') NOT NULL,
  `use_username` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `role`, `active_organization`, `password`, `email`, `student_number`, `use_template`, `use_username`) VALUES
(1, 'neytism', 'Nate Florendo', 'master', 4, '$2y$10$PsD1MDxYYyZ5XU8sudYHIe1SLLkWbvnd8P5wpHuzsCsPGazAowuLe::76c01dbee3401488cf7ffe7ec48285e6', 'nate.florendo@ciit.edu.ph', '17213541', 'true', 'true'),
(3, 'oli', 'Oliver Chiuco', 'seller', 4, '$2y$10$O8w0jrvzu9Zp5CqIx57hBOL.JMM5TAoY2I8RjsrtA0gqHbrK4ij5W::12facea7f4b4058dc661aeaf21cd8e7d', 'oliver.chiuco@ciit.edu.ph', '17223818', 'true', 'true'),
(4, 'ziyun', 'Ziyun Reyes', 'student', 4, '$2y$10$pQCE2BIweC/VcEaDFtWaKer8rI9KS6PfRcqAOM4nO87PWz0ID4MmC::9fa33c45209b5d94cf62be3e8794f9cc', 'pepito.reyes@ciit.edu.ph', '17223712', 'true', 'true'),
(9, '12223917', 'Mike Reyes', 'student', 1, '$2y$10$QMtz9W1dbvK/hiYU8PR.KeERzhdXZ2xyrQcnnFxNMu6/zR4948Rq2::604c5dab7a058a8dea820c74c0bec1b5', 'michelle.reyes@ciit.edu.ph', '12223917', 'false', 'false'),
(10, '17223998', 'Peter Santiago', 'student', 1, '$2y$10$oD2s85S5egS9FUf.61xY8OkqvTza0tOcoTWAOB2XgMM1lu5dGNsCO::02ae5f62031f5c861377e7e7f7d02bfc', 'peter.santiago@ciit.edu.ph', '17223998', 'false', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `user_organizations`
--

CREATE TABLE `user_organizations` (
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `role` enum('admin','seller','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_organizations`
--

INSERT INTO `user_organizations` (`user_id`, `organization_id`, `status`, `role`) VALUES
(1, 1, 'pending', 'seller'),
(3, 1, 'pending', 'student'),
(3, 4, 'pending', 'student'),
(4, 1, 'pending', 'student'),
(9, 1, 'pending', 'student'),
(10, 1, 'pending', 'student');

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD KEY `fk_settings_organization` (`organization_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization` (`active_organization`);

--
-- Indexes for table `user_organizations`
--
ALTER TABLE `user_organizations`
  ADD PRIMARY KEY (`user_id`,`organization_id`),
  ADD KEY `organization_id` (`organization_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `fk_settings_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`active_organization`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `user_organizations`
--
ALTER TABLE `user_organizations`
  ADD CONSTRAINT `user_organizations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_organizations_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
