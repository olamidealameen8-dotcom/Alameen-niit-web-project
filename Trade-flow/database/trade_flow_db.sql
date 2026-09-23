-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 03:35 PM
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
-- Database: `trade_flow_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_tab`
--

CREATE TABLE `categories_tab` (
  `sn` int(11) NOT NULL,
  `categories_id` varchar(255) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_tab`
--

INSERT INTO `categories_tab` (`sn`, `categories_id`, `categories_name`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'CAT20260923094728', 'Handbag & Accessories', 1, '2026-09-23 08:47:28', '2026-09-23 07:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tab`
--

CREATE TABLE `customer_tab` (
  `sn` int(11) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `role_id` int(111) NOT NULL,
  `reset_otp` int(11) NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tab`
--

INSERT INTO `customer_tab` (`sn`, `customer_id`, `first_name`, `last_name`, `email_address`, `password`, `status_id`, `role_id`, `reset_otp`, `last_login_date`, `created_at`, `updated_at`) VALUES
(1, 'CUST20260923113655', 'Olajide', 'olaa', 'ola12@gmail.com', '4230f911529de78e8e012e7b6745a40c', 1, 19, 0, NULL, '2026-09-23 10:36:55', '2026-09-23 09:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_tab`
--

CREATE TABLE `order_tab` (
  `sn` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_tab`
--

CREATE TABLE `payment_method_tab` (
  `sn` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method_tab`
--

INSERT INTO `payment_method_tab` (`sn`, `payment_method_id`, `payment_method_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wallet', '2026-09-23 08:23:42', '2026-09-23 07:23:42'),
(2, 2, 'Bank Transfer', '2026-09-23 08:23:42', '2026-09-23 07:23:42'),
(3, 3, 'Cash', '2026-09-23 08:23:42', '2026-09-23 07:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `product_tab`
--

CREATE TABLE `product_tab` (
  `sn` int(11) NOT NULL,
  `categories_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tab`
--

INSERT INTO `product_tab` (`sn`, `categories_id`, `product_id`, `product_name`, `product_price`, `quantity`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'CAT20260923094728', 'PROD20260923094820', 'Apple iphone 13 pro pro', 0.00, '11', 1, '2026-09-23 08:48:20', '2026-09-23 07:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `role_tab`
--

CREATE TABLE `role_tab` (
  `sn` int(11) NOT NULL,
  `role_id` int(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_tab`
--

INSERT INTO `role_tab` (`sn`, `role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'STAFF', NULL, '2026-09-22 16:09:34'),
(2, 2, 'ADMIN', NULL, '2026-09-22 16:09:34'),
(3, 3, 'SUPER ADMIN', NULL, '2026-09-22 16:09:34'),
(4, 4, 'System Administrator', NULL, '2026-09-22 16:09:34'),
(5, 5, 'Store Manager', NULL, '2026-09-22 16:09:34'),
(6, 6, 'Support Agent', NULL, '2026-09-22 16:09:34'),
(7, 7, 'Inventory Officer', NULL, '2026-09-22 16:09:34'),
(8, 8, 'Finance Analyst', NULL, '2026-09-22 16:09:34'),
(9, 9, 'Operation Lead', NULL, '2026-09-22 16:09:34'),
(10, 10, 'Quality Assurance', NULL, '2026-09-22 16:09:34'),
(11, 11, 'HR Coordinator', NULL, '2026-09-22 16:09:34'),
(12, 12, 'Logistics supervisor', NULL, '2026-09-22 16:09:34'),
(13, 13, 'Marketing Specialist', NULL, '2026-09-22 16:09:34'),
(14, 14, 'Security Officer', NULL, '2026-09-22 16:09:34'),
(15, 15, 'Customer Relation', NULL, '2026-09-22 16:09:34'),
(16, 16, 'Senior Developer', NULL, '2026-09-22 16:09:34'),
(17, 17, 'Product Designer', NULL, '2026-09-22 16:09:34'),
(18, 17, 'Product Designer', NULL, '2026-09-22 16:09:34'),
(19, 19, 'Customer', NULL, '2026-09-23 09:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tab`
--

CREATE TABLE `staff_tab` (
  `sn` int(11) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `role_id` int(111) NOT NULL,
  `reset_otp` int(11) NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_tab`
--

CREATE TABLE `status_tab` (
  `sn` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_tab`
--

INSERT INTO `status_tab` (`sn`, `status_id`, `status_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'ACTIVE', '2026-09-23 08:34:29', '2026-09-23 07:34:29'),
(2, 2, 'INACTIVE', '2026-09-23 08:34:29', '2026-09-23 07:34:29'),
(3, 3, 'PENDING', '2026-09-23 08:34:29', '2026-09-23 07:34:29'),
(4, 4, 'PROCESSING', '2026-09-23 08:34:29', '2026-09-23 07:34:29'),
(5, 5, 'SUCCESSFUL', '2026-09-23 08:34:29', '2026-09-23 07:34:29'),
(6, 6, 'Out of stock', '2026-09-22 17:15:56', '2026-09-22 16:15:56'),
(7, 7, 'Suspended', '2026-09-22 17:17:29', '2026-09-22 16:17:29'),
(8, 8, 'Paid', '2026-09-22 17:18:10', '2026-09-22 16:18:10'),
(9, 9, 'Failed', '2026-09-22 17:19:03', '2026-09-22 16:19:03'),
(10, 10, 'Done', '2026-09-22 17:19:18', '2026-09-22 16:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tab`
--

CREATE TABLE `transaction_tab` (
  `sn` int(11) NOT NULL,
  `transactions_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories_tab`
--
ALTER TABLE `categories_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `customer_tab`
--
ALTER TABLE `customer_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `order_tab`
--
ALTER TABLE `order_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `payment_method_tab`
--
ALTER TABLE `payment_method_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `product_tab`
--
ALTER TABLE `product_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `role_tab`
--
ALTER TABLE `role_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `staff_tab`
--
ALTER TABLE `staff_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `status_tab`
--
ALTER TABLE `status_tab`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `transaction_tab`
--
ALTER TABLE `transaction_tab`
  ADD PRIMARY KEY (`sn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_tab`
--
ALTER TABLE `categories_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_tab`
--
ALTER TABLE `customer_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_tab`
--
ALTER TABLE `order_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_method_tab`
--
ALTER TABLE `payment_method_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_tab`
--
ALTER TABLE `product_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_tab`
--
ALTER TABLE `role_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff_tab`
--
ALTER TABLE `staff_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_tab`
--
ALTER TABLE `status_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction_tab`
--
ALTER TABLE `transaction_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
