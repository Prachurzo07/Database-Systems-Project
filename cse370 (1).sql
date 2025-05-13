-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 04:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse370`
--

-- --------------------------------------------------------

--
-- Table structure for table `advance_booking`
--

CREATE TABLE `advance_booking` (
  `booking_token` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_items` varchar(255) NOT NULL,
  `booking_date` varchar(100) NOT NULL,
  `booking_time` varchar(100) NOT NULL,
  `special_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advance_booking`
--

INSERT INTO `advance_booking` (`booking_token`, `user_id`, `food_items`, `booking_date`, `booking_time`, `special_request`) VALUES
('2564', 6, '[{\"id\":1, \"name\":\"chicken curry\", \"price\":100, \"quantity\":1}]', '2025-05-13', '10:00', 'ssss');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_item_id` int(11) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `name` varchar(200) NOT NULL,
  `amount` bigint(50) NOT NULL,
  `price` bigint(30) NOT NULL,
  `healthtag` varchar(200) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`name`, `amount`, `price`, `healthtag`, `category`) VALUES
('Fuchka', 2, 60, 'Spicy', 'Snacks'),
('Fried Rice', 203, 60, 'High-Calorie', 'Lunch'),
('Chicken Curry', 503, 80, 'Spicy', 'Lunch'),
('Fried Chicken', 311, 75, 'High-Calorie', 'Lunch'),
('Chinese Vegetable', 189, 45, 'Vegetarian', 'Lunch'),
('Polao', 188, 35, 'High-Calorie', 'Lunch'),
('Egg Bhuna', 144, 30, 'High-Protein', 'Lunch'),
('Chicken Tehari', 193, 130, 'High-Calorie', 'Lunch'),
('Beef Bhuna', 150, 170, 'Allergic', 'Lunch'),
('Chicken Bun', 143, 50, 'High-Calorie', 'Snacks'),
('Shingara', 395, 10, 'Vegetarian', 'Snacks'),
('Dim Chop', 348, 30, 'Spicy', 'Snacks'),
('Popcorn', 197, 30, '', 'Snacks'),
('Chicken Sandwich', 194, 65, '', 'Snacks'),
('Plain Rice', 300, 20, '', 'Lunch'),
('Porota', 193, 10, '', 'Breakfast'),
('Coffee', 197, 25, '', 'Snacks'),
('Tea', 299, 15, '', 'Beverages'),
('Shobji', 293, 20, 'Vegetarian', 'Breakfast'),
('Daal', 297, 20, '', 'Breakfast'),
('Dim Bhaji', 299, 20, '', 'Breakfast'),
('Water', 495, 15, '', 'Beverages'),
('Mojo', 182, 25, 'Sugary', 'Beverages'),
('Lemu', 196, 20, '', 'Beverages'),
('Chicken Soup', 197, 100, '', 'Breakfast'),
('Samosa', 348, 10, 'Vegetarian', 'Snacks');

-- --------------------------------------------------------

--
-- Table structure for table `food_ratings`
--

CREATE TABLE `food_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `feedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_ratings`
--

INSERT INTO `food_ratings` (`id`, `user_id`, `food`, `rating`, `created_at`, `feedback`) VALUES
(3, 6, 'Beef Bhuna', 3, '2025-05-10 16:18:53', 'Random'),
(4, 6, 'Chicken Bun', 2, '2025-05-10 16:20:30', 'baje'),
(0, 6, 'Chicken Roast', 4, '2025-05-11 21:37:14', 'good'),
(0, 4, 'Chicken Soup', 5, '2025-05-11 21:37:56', ''),
(0, 4, 'Dim Bhaji', 4, '2025-05-11 21:38:22', 'could be less oily'),
(0, 4, 'Fuchka', 4, '2025-05-11 21:45:02', 'Too Costly '),
(0, 6, 'Porota', 3, '2025-05-11 21:46:08', 'okay'),
(0, 6, 'Chicken Soup', 4, '2025-05-12 00:49:32', 'It was good'),
(0, 4, 'Chicken Sandwich', 2, '2025-05-12 02:47:14', 'below average'),
(0, 3, 'Daal', 3, '2025-05-12 08:20:54', 'nice'),
(0, 4, 'Shingara', 5, '2025-05-12 09:16:32', 'good enough'),
(0, 4, 'Dim Chop', 5, '2025-05-12 09:16:42', ''),
(0, 4, 'Coffee', 4, '2025-05-12 09:17:03', ''),
(0, 4, 'Popcorn', 5, '2025-05-12 09:17:32', 'quantity could be more'),
(0, 4, 'Chinese Vegetable', 5, '2025-05-12 09:18:16', 'really amazing'),
(0, 4, 'Chicken Bun', 2, '2025-05-12 09:19:19', 'quality not satisfactory compared to price'),
(0, 4, 'Plain Rice', 3, '2025-05-12 09:19:32', 'Not bad');

-- --------------------------------------------------------

--
-- Table structure for table `order_tokens`
--

CREATE TABLE `order_tokens` (
  `token_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tokens`
--

INSERT INTO `order_tokens` (`token_id`, `order_date`) VALUES
(1, '2025-05-07 05:25:07'),
(2, '2025-05-07 05:25:17'),
(3, '2025-05-07 05:25:34'),
(4, '2025-05-07 05:26:05'),
(5, '2025-05-07 05:27:46'),
(6, '2025-05-07 05:29:27'),
(7, '2025-05-07 05:32:08'),
(8, '2025-05-07 05:41:48'),
(9, '2025-05-07 05:42:27'),
(10, '2025-05-07 05:45:15'),
(11, '2025-05-07 05:46:35'),
(12, '2025-05-07 06:20:04'),
(13, '2025-05-07 06:35:16'),
(14, '2025-05-07 06:47:48'),
(15, '2025-05-07 07:09:14'),
(16, '2025-05-07 07:09:49'),
(17, '2025-05-07 07:27:45'),
(18, '2025-05-07 07:31:40'),
(19, '2025-05-07 07:32:28'),
(20, '2025-05-07 07:37:18'),
(21, '2025-05-07 07:48:19'),
(22, '2025-05-07 08:02:01'),
(23, '2025-05-08 05:50:17'),
(24, '2025-05-08 05:51:11'),
(25, '2025-05-08 08:28:29'),
(26, '2025-05-08 10:43:08'),
(27, '2025-05-08 10:43:35'),
(28, '2025-05-11 19:17:56'),
(29, '2025-05-11 20:49:00'),
(30, '2025-05-11 21:08:11'),
(31, '2025-05-11 21:08:53'),
(32, '2025-05-11 21:20:24'),
(33, '2025-05-12 01:04:08'),
(34, '2025-05-12 01:09:43'),
(35, '2025-05-12 01:20:12'),
(36, '2025-05-12 01:29:27'),
(37, '2025-05-12 01:41:06'),
(38, '2025-05-12 01:42:07'),
(39, '2025-05-12 01:42:46'),
(40, '2025-05-12 02:06:43'),
(41, '2025-05-12 02:07:28'),
(42, '2025-05-12 02:32:06'),
(43, '2025-05-12 02:32:21'),
(44, '2025-05-12 02:38:23'),
(45, '2025-05-12 02:43:24'),
(46, '2025-05-12 02:59:54'),
(47, '2025-05-12 03:54:34'),
(48, '2025-05-12 04:56:38'),
(49, '2025-05-12 04:56:57'),
(50, '2025-05-12 06:21:12'),
(51, '2025-05-12 06:33:58'),
(52, '2025-05-12 06:52:30'),
(53, '2025-05-12 09:03:04'),
(54, '2025-05-12 09:11:13'),
(55, '2025-05-12 09:11:36'),
(56, '2025-05-12 09:14:03'),
(57, '2025-05-12 09:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `order_id` int(11) NOT NULL,
  `token_number` int(11) NOT NULL,
  `order_details` text NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','delivered') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_orders`
--

INSERT INTO `pending_orders` (`order_id`, `token_number`, `order_details`, `order_total`, `order_date`, `status`) VALUES
(2, 36, '[{\"name\":\"Tea\",\"price\":15,\"quantity\":1,\"subtotal\":15,\"category\":\"\"},{\"name\":\"Porota\",\"price\":10,\"quantity\":1,\"subtotal\":10,\"category\":\"\"},{\"name\":\"Daal\",\"price\":20,\"quantity\":1,\"subtotal\":20,\"category\":\"\"}]', 45.00, '2025-05-12 01:29:27', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `sold_item`
--

CREATE TABLE `sold_item` (
  `name` varchar(100) NOT NULL,
  `price` bigint(50) NOT NULL,
  `amount` bigint(70) NOT NULL,
  `rating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold_item`
--

INSERT INTO `sold_item` (`name`, `price`, `amount`, `rating`) VALUES
('Chicken Curry', 90, 2, 0),
('Fuchka', 60, 14, 0),
('cha', 15, 4, 0),
('coffee', 30, 5, 0),
('Chicken Bun', 50, 7, 0),
('Egg Bhuna', 30, 6, 0),
('Chicken Tehari', 130, 7, 0),
('Chinese Vegetable', 45, 12, 0),
('Chicken Sandwich', 65, 6, 0),
('Fried Chicken', 75, 2, 0),
('Popcorn', 30, 3, 0),
('Shingara', 10, 5, 0),
('Chicken Soup', 100, 3, 0),
('Beef Bhuna', 170, 2, 0),
('Mojo', 25, 20, 0),
('Dim Chop', 30, 2, 0),
('Tea', 15, 1, 0),
('Porota', 10, 8, 0),
('Daal', 20, 3, 0),
('Samosa', 10, 2, 0),
('Fried Rice', 60, 1, 0),
('Shobji', 20, 7, 0),
('Polao', 35, 12, 0),
('Lemu', 20, 4, 0),
('Water', 15, 5, 0),
('Chicken Roast', 130, 1, 0),
('Dim Bhaji', 20, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `mobile` int(11) NOT NULL,
  `role` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `mobile`, `role`, `user_id`) VALUES
('Prachurzo Ray', '$2y$10$0gU', 1767944699, 'host', 1),
('Prachurzo Ray', '$2y$10$XIz', 1767944699, 'host', 2),
('Prachurzo Ray', '010224', 1767944699, 'host', 3),
('Hafsa Khan', '1234', 1308906400, 'user', 4),
('Hafsa Khan', '1234', 1308906400, 'user', 5),
('Yeashfi Ahmed', '1234', 1712192260, 'user', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_item_id` (`food_item_id`);

--
-- Indexes for table `order_tokens`
--
ALTER TABLE `order_tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_tokens`
--
ALTER TABLE `order_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
