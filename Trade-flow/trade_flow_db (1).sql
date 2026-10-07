-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 09:04 AM
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
-- Table structure for table `cart_tab`
--

CREATE TABLE `cart_tab` (
  `sn` int(11) NOT NULL,
  `cart_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories_tab`
--
-- Error reading structure for table trade_flow_db.categories_tab: #1932 - Table &#039;trade_flow_db.categories_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.categories_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`categories_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `customer_tab`
--
-- Error reading structure for table trade_flow_db.customer_tab: #1932 - Table &#039;trade_flow_db.customer_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.customer_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`customer_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `order_tab`
--
-- Error reading structure for table trade_flow_db.order_tab: #1932 - Table &#039;trade_flow_db.order_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.order_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`order_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_tab`
--
-- Error reading structure for table trade_flow_db.payment_method_tab: #1932 - Table &#039;trade_flow_db.payment_method_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.payment_method_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`payment_method_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `product_tab`
--
-- Error reading structure for table trade_flow_db.product_tab: #1932 - Table &#039;trade_flow_db.product_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.product_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`product_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `role_tab`
--
-- Error reading structure for table trade_flow_db.role_tab: #1932 - Table &#039;trade_flow_db.role_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.role_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`role_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `staff_tab`
--
-- Error reading structure for table trade_flow_db.staff_tab: #1932 - Table &#039;trade_flow_db.staff_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.staff_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`staff_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `status_tab`
--
-- Error reading structure for table trade_flow_db.status_tab: #1932 - Table &#039;trade_flow_db.status_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.status_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`status_tab`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `transactions_tab`
--
-- Error reading structure for table trade_flow_db.transactions_tab: #1932 - Table &#039;trade_flow_db.transactions_tab&#039; doesn&#039;t exist in engine
-- Error reading data for table trade_flow_db.transactions_tab: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `trade_flow_db`.`transactions_tab`&#039; at line 1

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_tab`
--
ALTER TABLE `cart_tab`
  ADD PRIMARY KEY (`sn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_tab`
--
ALTER TABLE `cart_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
