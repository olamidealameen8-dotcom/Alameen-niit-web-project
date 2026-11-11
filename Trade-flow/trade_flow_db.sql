-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2026 at 04:22 PM
-- Server version: 11.4.12-MariaDB-cll-lve
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `niitwebd_tradeflow_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_tab`
--

DROP TABLE IF EXISTS `cart_tab`;
CREATE TABLE `cart_tab` (
  `sn` int(11) NOT NULL,
  `cart_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `customer_id` varchar(50) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_tab`
--

INSERT INTO `cart_tab` (`sn`, `cart_id`, `product_id`, `quantity`, `customer_id`, `session_id`, `price`, `status_id`, `created_at`) VALUES
(1, 'CART20261109141949', 'PROD20261109083122', 12, 'CUST20261109124556', '123458', 185000.00, 1, '2026-11-09 14:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories_tab`
--

DROP TABLE IF EXISTS `categories_tab`;
CREATE TABLE `categories_tab` (
  `sn` int(11) NOT NULL,
  `categories_id` varchar(255) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_tab`
--

INSERT INTO `categories_tab` (`sn`, `categories_id`, `categories_name`, `status_id`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'CAT20261109082340', 'Electronics', 1, 'Devices and gadgets including phones, laptops, accessories and other electronic equipment for personal and business use.', NULL, '2026-11-09 08:23:40', '2026-11-09 06:23:40'),
(2, 'CAT20261109082439', 'Groceries', 1, 'Everyday food items and household consumables including grains, beverages, canned goods and cooking essentials.', NULL, '2026-11-09 08:24:39', '2026-11-09 06:24:39'),
(4, 'CAT20261109082603', 'Office Supplies', 1, 'Stationery, printing materials, office furniture and equipment needed for smooth business operations.', NULL, '2026-11-09 08:26:03', '2026-11-09 06:26:03'),
(5, 'CAT20261109082647', 'Health & Beauty', 1, 'Personal care products including skincare, haircare, supplements and hygiene essentials for everyday wellness.', NULL, '2026-11-09 08:26:47', '2026-11-09 06:26:47'),
(7, 'CAT20261111143555', 'Mobile Devices & phones', 1, 'Updated via API', 'https://static.vecteezy.com/system/resources/thumbnails/069/148/697/small_2x/one-hand-holding-smartphone-with-blank-white-screen-on-dark-background-perfect-for-mockups-app-presentations-and-digital-marketing-concepts-photo.jpg', '2026-11-11 14:35:55', '2026-11-11 14:02:46'),
(9, 'CAT20261111154446', 'Audio & Sound Devices', 1, 'Updated headphones', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e', '2026-11-11 15:44:46', '2026-11-11 13:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tab`
--

DROP TABLE IF EXISTS `customer_tab`;
CREATE TABLE `customer_tab` (
  `sn` int(11) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `title_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `role_id` int(111) NOT NULL,
  `reset_otp` int(11) NOT NULL DEFAULT 0,
  `last_login_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tab`
--

INSERT INTO `customer_tab` (`sn`, `customer_id`, `title_id`, `first_name`, `last_name`, `email_address`, `phone_number`, `address`, `password`, `status_id`, `role_id`, `reset_otp`, `last_login_date`, `created_at`, `updated_at`) VALUES
(1, 'CUST20261109122801', 0, 'kola', 'wole', 'kolawol@gmail.com', '09012345678', 'kufile, abk 07', 'e10adc3949ba59abbe56e057f20f883e', 1, 19, 0, '2026-11-11 13:19:19', '2026-11-09 12:28:01', '2026-11-11 11:19:19'),
(2, 'CUST20261109124556', 0, 'Layi', 'Olawale', 'cust_1794221154568@example.com', '08012345678', 'Abeokuta, Ogun State', '482c811da5d5b4bc6d497ffa98491e38', 1, 19, 0, NULL, '2026-11-09 12:45:56', '2026-11-09 10:45:56'),
(3, 'CUST20261109124636', 0, 'Layi', 'Olawale', 'layi_1794221195442@example.com', '08012345678', 'Abeokuta, Ogun State', 'd00f5d5217896fb7fd601412cb890830', 1, 19, 0, NULL, '2026-11-09 12:46:36', '2026-11-09 10:46:36'),
(4, 'CUST20261109130351', 0, 'Oladejo', 'Muhaz', 'muhazoladejo48@gmail.com', 'layi@outlook.com', 'Abeokuta, Ogun State, Nigeria', 'e10adc3949ba59abbe56e057f20f883e', 1, 19, 0, NULL, '2026-11-09 13:03:51', '2026-11-09 11:03:51'),
(5, 'CUST20261109131634', 0, 'Test', 'User', 'test@example.com', '08012345678', 'Abeokuta, Ogun State, Nigeria', '8359b10e30dfabd587a5661e52249101', 1, 19, 0, '2026-11-09 13:17:17', '2026-11-09 13:16:34', '2026-11-09 11:26:39'),
(6, 'CUST20261109131956', 0, 'Oladejo', 'Muhaz', 'lol@outlook.com', '09012347877', 'Abeokuta, Ogun State, Nigeria', '42f749ade7f9e195bf475f37a44cafcb', 1, 19, 0, '2026-11-09 13:47:14', '2026-11-09 13:19:56', '2026-11-09 11:47:14'),
(7, 'CUST20261109134741', 0, 'Test', 'User', 'authtest_1794224859500@example.com', '08099887766', 'Abeokuta, Nigeria', '5c90b96a75d4f9d5a1cfaa6f532afdc8', 1, 19, 0, '2026-11-09 13:47:42', '2026-11-09 13:47:41', '2026-11-09 11:47:42'),
(8, 'CUST20261109135131', 0, 'Oladejo', 'Muhaz', 'testt@test.com', '+2348108725967', 'Abeokuta, Ogun State, Nigeria', 'fcea920f7412b5da7be0cf42b8c93759', 1, 19, 0, NULL, '2026-11-09 13:51:31', '2026-11-09 11:51:31'),
(9, 'CUST20261109141253', 0, 'Oladejo', 'Muhaz', 'layiii@outlook.com', '+2348108725967', 'Abeokuta, Ogun State, Nigeria', 'e10adc3949ba59abbe56e057f20f883e', 1, 19, 0, NULL, '2026-11-09 14:12:53', '2026-11-09 12:12:53'),
(10, 'CUST20261109161142', 0, 'Quadri', 'Lasis', 'lastin@outlook.com', '08108725967', 'Abeokuta, Ogun State, Nigeria', 'fcea920f7412b5da7be0cf42b8c93759', 1, 19, 0, '2026-11-10 12:11:31', '2026-11-09 16:11:42', '2026-11-10 10:11:31'),
(11, 'CUST20261111121214', 1, 'Quadri', 'Lasis', 'test@outlook.com', '08108725967', 'Abeokuta, Ogun State, Nigeria', 'b7dfe9134c7a717a3b6eaf37bdc1ef7b', 1, 1, 0, NULL, '2026-11-11 12:12:14', '2026-11-11 13:53:37'),
(12, 'CUST20261111131212', 1, 'Quadri', 'Lasisi', 'lay@outlook.com', '08108725967', 'Abeokuta, Ogun State', 'b7dfe9134c7a717a3b6eaf37bdc1ef7b', 1, 1, 0, '2026-11-11 13:46:23', '2026-11-11 13:12:12', '2026-11-11 13:39:55'),
(13, 'CUST20261111143445', 1, 'omo', 'Layi', 'teso@epon.com', '+2348108725967', 'Suite 404, Ikeja, Lagos', 'b7dfe9134c7a717a3b6eaf37bdc1ef7b', 1, 1, 0, NULL, '2026-11-11 14:34:45', '2026-11-11 14:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_tab`
--

DROP TABLE IF EXISTS `order_tab`;
CREATE TABLE `order_tab` (
  `sn` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tab`
--

INSERT INTO `order_tab` (`sn`, `order_id`, `customer_id`, `product_id`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'ORD20261110121153', 'CUST20261109161142', 'PROD20261109083122', 5, '2026-11-10 12:11:53', '2026-11-11 11:07:03'),
(2, 'ORD20261111131035', 'CUST20261111121214', 'PROD20261109160252', 1, '2026-11-11 13:10:35', '2026-11-11 11:10:35'),
(3, 'ORD20261111131259', 'CUST20261111131212', 'PROD20261109144239', 1, '2026-11-11 13:12:59', '2026-11-11 11:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_tab`
--

DROP TABLE IF EXISTS `payment_method_tab`;
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

DROP TABLE IF EXISTS `product_tab`;
CREATE TABLE `product_tab` (
  `sn` int(11) NOT NULL,
  `categories_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tab`
--

INSERT INTO `product_tab` (`sn`, `categories_id`, `product_id`, `product_name`, `product_price`, `quantity`, `description`, `image_url`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'CAT20261109082827', 'PROD20261109083122', 'Samsung Galaxy A15', 185000.00, '49', 'A powerful Android smartphone with a 6.5-inch display, 4GB RAM, 128GB storage and long-lasting 5000mAh battery, perfect for everyday use.', 'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-a15-lte-1.jpg', 1, '2026-11-09 08:31:22', '2026-11-09 12:46:46'),
(3, 'CAT20261109082340', 'PROD20261109144239', 'Airpods', 8900.00, '65', 'New Airpos', 'https://fdn.gsmarena.com/imgroot/news/26/10/airpods-5-review/inline/-1200w5/gsmarena_024.jpg', 1, '2026-11-09 14:42:39', '2026-11-09 12:48:10'),
(4, 'CAT20261109082340', 'PROD20261109160252', 'Solar Panels', 9000.00, '25', 'Solar 2400kw', 'https://th.bing.com/th/id/OIP.U6zd3EIJachd8owXxVcf8wHaE7?w=245&h=180&c=7&r=0&o=7&dpr=1.3&pid=1.7&rm=3', 1, '2026-11-09 16:02:52', '2026-11-11 12:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `role_tab`
--

DROP TABLE IF EXISTS `role_tab`;
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
(17, 17, 'Product Designer', NULL, '2026-09-22 16:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tab`
--

DROP TABLE IF EXISTS `staff_tab`;
CREATE TABLE `staff_tab` (
  `sn` int(11) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `title_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `role_id` int(111) NOT NULL,
  `reset_otp` int(11) NOT NULL DEFAULT 0,
  `last_login_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_tab`
--

INSERT INTO `staff_tab` (`sn`, `staff_id`, `title_id`, `first_name`, `last_name`, `phone_number`, `email_address`, `address`, `password`, `status_id`, `role_id`, `reset_otp`, `last_login_date`, `created_at`, `updated_at`) VALUES
(5, 'STAFF20261014040357', 1, 'lay', 'mnm', '+2348108725967', 'layi@outlook.com', 'Abeokuta, Ogun State', 'e10adc3949ba59abbe56e057f20f883e', 2, 3, 0, '2026-10-28 15:38:43', '2026-10-14 16:03:57', '2026-10-28 14:24:46'),
(9, 'STAFF20261028030639', 5, 'test', 'Muhaz Oladejo', '+2348108725967', 'test@test.com', 'Abeokuta, Ogun State', 'e10adc3949ba59abbe56e057f20f883e', 1, 3, 0, '2026-11-11 15:44:12', '2026-10-28 15:06:39', '2026-11-11 13:44:12'),
(10, 'STAFF20261102035216', 1, 'Afooo', 'Afoo', '09122345678', 'afo@mail.com', 'Abeokuta, Ogun State', NULL, 1, 1, 0, NULL, '2026-11-02 15:52:16', '2026-11-04 11:55:28'),
(11, 'STAFF20261103124112', 1, 'John', 'Doe', '08012345678', 'test_probe@example.com', '123 Test St', NULL, 1, 1, 0, NULL, '2026-11-03 12:41:12', '2026-11-03 10:41:12'),
(12, 'STAFF20261109012901', 1, 'Olamide', 'Alameen', '07049870372', 'olamidealameen8@gmail.com', 'Kufile Isale Abetu 07', NULL, 1, 9, 757766, NULL, '2026-11-09 13:29:01', '2026-11-09 14:37:07'),
(13, 'STAFF20261109012926', 1, 'IYABODE', 'OLADEHINDE', '07049870372', 'olamidealameen80@gmail.com', 'Kufile Isale Abetu 13', NULL, 1, 15, 0, NULL, '2026-11-09 13:29:26', '2026-11-09 11:29:26'),
(14, 'STAFF20261109012958', 3, 'Olamide', 'Alameen', '07049870372', 'olamidealameen@gmail.com', 'Kufile Isale Abetu 07', NULL, 1, 15, 0, NULL, '2026-11-09 13:29:58', '2026-11-09 11:29:58'),
(15, 'STAFF20261109013034', 5, 'Lasisi', 'as', '07049870372', 'olamidealen8@gmail.com', 'Kufile Isale Abetu 07', NULL, 1, 4, 0, NULL, '2026-11-09 13:30:34', '2026-11-09 13:57:35'),
(16, 'STAFF20261109013130', 2, 'fikewami', 'lookman', '1234567890', 'shea@gmail.com', 'Kufile Isale Abetu 13', NULL, 1, 15, 0, NULL, '2026-11-09 13:31:30', '2026-11-09 11:33:59'),
(17, 'STAFF20261109035933', 1, 'Lasisi', 'Quadri', '0901234567', 'qalas@outloom.com', '24,Talokan, musin laos', NULL, 1, 5, 0, NULL, '2026-11-09 15:59:33', '2026-11-09 13:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `status_tab`
--

DROP TABLE IF EXISTS `status_tab`;
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
(10, 10, 'Done', '2026-09-22 17:19:18', '2026-09-22 16:19:18'),
(11, 11, 'In Stock', '2026-10-12 10:56:55', '2026-10-12 09:56:55'),
(12, 12, 'Canceled', '2026-10-28 14:27:21', '2026-10-28 12:27:21'),
(13, 13, 'Reverse', '2026-10-28 14:27:43', '2026-10-28 12:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `title_tab`
--

DROP TABLE IF EXISTS `title_tab`;
CREATE TABLE `title_tab` (
  `sn` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `title_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `title_tab`
--

INSERT INTO `title_tab` (`sn`, `title_id`, `title_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mr', NULL, '2026-10-13 11:31:11'),
(2, 2, 'Mrs', NULL, '2026-10-13 11:31:11'),
(3, 3, 'Dr', NULL, '2026-10-13 11:31:11'),
(4, 4, 'Prof', NULL, '2026-10-13 11:31:11'),
(5, 5, 'Engr', NULL, '2026-10-13 11:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tab`
--

DROP TABLE IF EXISTS `transaction_tab`;
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
-- Indexes for table `cart_tab`
--
ALTER TABLE `cart_tab`
  ADD PRIMARY KEY (`sn`);

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
-- Indexes for table `title_tab`
--
ALTER TABLE `title_tab`
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
-- AUTO_INCREMENT for table `cart_tab`
--
ALTER TABLE `cart_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories_tab`
--
ALTER TABLE `categories_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_tab`
--
ALTER TABLE `customer_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_tab`
--
ALTER TABLE `order_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_method_tab`
--
ALTER TABLE `payment_method_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_tab`
--
ALTER TABLE `product_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_tab`
--
ALTER TABLE `role_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff_tab`
--
ALTER TABLE `staff_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `status_tab`
--
ALTER TABLE `status_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `title_tab`
--
ALTER TABLE `title_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_tab`
--
ALTER TABLE `transaction_tab`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
