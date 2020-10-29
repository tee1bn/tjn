-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2020 at 06:26 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsw`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `username`, `firstname`, `lastname`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'Super', 'admin@admin.com', '08123353738', '$2y$10$OepumDQQsOJw/kZBnXAf7.48lf5sP9IibKoMdubhuxTle8XNQ5HWS', '2018-02-22 23:00:00', '2019-03-26 22:51:35'),
(2, NULL, 'Jigloa', 'James ', 'tee02bn@gmail.com', '08123351819', '$2y$10$Tt8Xj8ZAqk7sMAu1cbqWtOZS6rgL8wG.w.OOiU74hRmpTZdCaSLQ6', '2018-02-28 10:26:56', '2018-03-16 16:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast`
--

CREATE TABLE `broadcast` (
  `id` bigint(20) NOT NULL,
  `broadcast_message` varchar(255) NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=published, 0=paused',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `broadcast`
--

INSERT INTO `broadcast` (`id`, `broadcast_message`, `admin_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'new message', 1, 0, '2019-07-14 09:42:13', '2019-07-14 09:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `note`, `created_at`, `updated_at`) VALUES
(3, 'Partys', '', NULL, '2019-02-16 10:13:21'),
(5, 'Training', '', NULL, '2017-07-05 01:03:10'),
(6, 'Kinos', '', '2019-02-16 07:48:47', '2019-02-16 07:48:47'),
(7, 'men', '', '2019-02-16 07:49:42', '2019-02-16 07:49:42');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) NOT NULL,
  `organisation_id` bigint(20) DEFAULT NULL COMMENT 'ompanies is like branches',
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `office_email` varchar(255) NOT NULL,
  `office_phone` varchar(255) DEFAULT NULL,
  `iban_number` varchar(255) DEFAULT NULL,
  `approval_status` enum('approved','declined','verifying') DEFAULT NULL,
  `documents` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `company_description` text,
  `pefcom_id` varchar(255) DEFAULT NULL COMMENT 'pension administrato number',
  `rc_number` varchar(255) DEFAULT NULL COMMENT 'cac rc number',
  `bn_number` varchar(255) DEFAULT NULL COMMENT 'cac bn number',
  `logo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `organisation_id`, `user_id`, `name`, `address`, `office_email`, `office_phone`, `iban_number`, `approval_status`, `documents`, `created_at`, `updated_at`, `company_description`, `pefcom_id`, `rc_number`, `bn_number`, `logo`) VALUES
(5, NULL, 1, 'Machinery Ltd', '', 'fghft gh', 'rwfyujhvb', 'gh hdfj vhj', 'approved', '[{\"files\":\"uploads\\/companies\\/documents\\/Machinery-Ltd-New-label.pdf\",\"label\":\"New label\"},{\"files\":\"uploads\\/companies\\/documents\\/campus-cash.jpg\",\"label\":\"Land\"},{\"files\":\"uploads\\/companies\\/documents\\/SEVENS-BRIDGE-Income-Statement-1.pdf\",\"label\":\"dfgrdf\"}]', '2019-07-12 23:29:32', '2019-07-28 11:02:25', NULL, '', '', NULL, NULL),
(6, NULL, 36, NULL, NULL, '', NULL, NULL, 'approved', '[{\"files\":\"uploads\\/companies\\/documents\\/ten.png\",\"label\":\"ten\"}]', '2019-09-18 01:38:54', '2019-09-18 01:39:27', NULL, NULL, NULL, NULL, NULL),
(7, NULL, 35, 'GOLDEN ltd', '17, isikalu lane olodi apapa lagos', '', '', '', 'approved', NULL, '2019-09-18 02:08:17', '2019-10-23 05:46:41', NULL, '', '', NULL, NULL),
(8, NULL, NULL, NULL, NULL, '', NULL, NULL, 'approved', NULL, '2019-09-28 12:44:12', '2019-09-28 12:44:12', NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2019-10-23 05:41:59', '2019-10-23 05:41:59', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers_support`
--

CREATE TABLE `customers_support` (
  `id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level_income_report`
--

CREATE TABLE `level_income_report` (
  `id` bigint(20) NOT NULL,
  `owner_user_id` bigint(20) NOT NULL,
  `downline_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `amount_earned` decimal(20,2) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `availability` int(11) DEFAULT NULL COMMENT '1= available, 0=not available',
  `commission_type` varchar(255) DEFAULT NULL,
  `payment_month` date DEFAULT NULL,
  `extra_detail` text,
  `proof` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_income_report`
--

INSERT INTO `level_income_report` (`id`, `owner_user_id`, `downline_id`, `order_id`, `amount_earned`, `status`, `availability`, `commission_type`, `payment_month`, `extra_detail`, `proof`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '200.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-08-13 23:00:00', '2019-09-27 23:00:00'),
(2, 35, NULL, NULL, '300.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-09-27 23:00:00', '2019-09-27 23:00:00'),
(3, 1, NULL, NULL, '200.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-08-13 23:00:00', '2019-09-27 23:00:00'),
(4, 35, NULL, NULL, '300.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-09-27 23:00:00', '2019-09-27 23:00:00'),
(5, 1, NULL, NULL, '200.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-08-13 23:00:00', '2019-09-27 23:00:00'),
(6, 35, NULL, NULL, '300.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-09-27 23:00:00', '2019-09-27 23:00:00'),
(7, 1, NULL, NULL, '200.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-08-13 23:00:00', '2019-09-27 23:00:00'),
(8, 35, NULL, NULL, '300.00', 'Credit', 1, NULL, '2019-09-17', NULL, NULL, '2019-09-27 23:00:00', '2019-09-27 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `url` text,
  `message` text,
  `short_message` text,
  `seen_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `type` enum('system_generated','admin_generated') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `heading`, `url`, `message`, `short_message`, `seen_at`, `created_at`, `updated_at`, `admin_id`, `type`) VALUES
(7, 1, '3 Rupees Scheme Upgrade', 'user/scheme', '1', 'Click here to See Details of current Scheme.', '2019-05-29 20:56:43', '2019-05-29 20:56:05', '2019-05-29 20:56:43', NULL, NULL),
(8, 36, '7 Rupees Scheme Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-06-12 11:26:32', '2019-06-12 11:26:32', NULL, NULL),
(9, 35, '3 Rupees Scheme Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-06-12 11:30:22', '2019-06-12 11:30:22', NULL, NULL),
(10, 35, '7 Rupees Scheme Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-06-12 11:31:27', '2019-06-12 11:31:27', NULL, NULL),
(11, 1, 'Secret Scheme I Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', '2019-06-21 23:59:29', '2019-06-21 23:59:05', '2019-06-21 23:59:29', NULL, NULL),
(12, 1, 'Secret Scheme I Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-06-22 00:00:51', '2019-06-22 00:00:51', NULL, NULL),
(13, 1, 'Secret Scheme I Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-06-22 00:05:24', '2019-06-22 00:05:24', NULL, NULL),
(14, 1, 'Professional Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-07-20 14:13:01', '2019-07-20 14:13:01', NULL, NULL),
(15, 1, 'Premium Upgrade', 'user/scheme', '', 'See Details of Current Scheme.', NULL, '2019-07-20 14:30:33', '2019-07-20 14:30:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `amount_payable` float DEFAULT NULL,
  `percent_off` float DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_response` longtext,
  `billing_firstname` varchar(255) DEFAULT NULL,
  `billing_lastname` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_company` varchar(255) DEFAULT NULL,
  `billing_street_address` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_apartment` varchar(255) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `additional_note` mediumtext,
  `buyer_order` longtext,
  `user_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'whether order is shipped, payed, pending, cancelled etc',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `shipping_firstname` varchar(255) DEFAULT NULL,
  `shipping_lastname` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `shipping_company` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_street_address` varchar(255) DEFAULT NULL,
  `shipping_apartment` varchar(255) DEFAULT NULL,
  `shipping_fee` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `amount_payable`, `percent_off`, `paid_at`, `razorpay_order_id`, `razorpay_response`, `billing_firstname`, `billing_lastname`, `billing_phone`, `billing_email`, `billing_country`, `billing_company`, `billing_street_address`, `billing_city`, `billing_state`, `billing_apartment`, `buyer_name`, `email`, `phone`, `address`, `additional_note`, `buyer_order`, `user_id`, `status`, `created_at`, `updated_at`, `shipping_firstname`, `shipping_lastname`, `shipping_email`, `shipping_phone`, `shipping_company`, `shipping_country`, `shipping_city`, `shipping_state`, `shipping_street_address`, `shipping_apartment`, `shipping_fee`) VALUES
(18, 465, 7, '2019-07-09 00:00:00', 'order_CVbXdlCa8NzS09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:29:35', '2019-05-15 01:29:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 465, 7, NULL, 'order_CVbYvMgrXNF7tW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:30:51', '2019-05-15 01:30:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 465, 7, NULL, 'order_CVbZZZFEIgHueV', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:31:27', '2019-05-15 01:31:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 465, 7, NULL, 'order_CVbhjw59Y0IQhX', '{\"razorpay_payment_id\":\"pay_CVbhrtORycFwaz\",\"razorpay_order_id\":\"order_CVbhjw59Y0IQhX\",\"razorpay_signature\":\"a3f14cf3a306c92bd3d8008180614ee7de727504e4d4d7320a07c759706cb0e7\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:39:12', '2019-05-15 01:39:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 465, 7, NULL, 'order_CVbo7ooOTotCVD', '{\"razorpay_payment_id\":\"pay_CVboRYcz64jill\",\"razorpay_order_id\":\"order_CVbo7ooOTotCVD\",\"razorpay_signature\":\"e8ee054fbcdb6e45ee0c8ee8e8be4eab8dcd584ae86859800a425c4317e32d36\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:45:15', '2019-05-15 01:45:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 465, 7, NULL, 'order_CVbpExILWb9hTt', '{\"razorpay_payment_id\":\"pay_CVbpLFES6h1DEh\",\"razorpay_order_id\":\"order_CVbpExILWb9hTt\",\"razorpay_signature\":\"baaca59e56eac8080e5bb0c36a6f2f40c668c026d94caa5f49470fa181613be7\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:46:19', '2019-05-15 01:46:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 465, 7, NULL, 'order_CVbpsHlLvNCKrg', '{\"razorpay_payment_id\":\"pay_CVbq7OBTG0zRJd\",\"razorpay_order_id\":\"order_CVbpsHlLvNCKrg\",\"razorpay_signature\":\"0c0334c2c143af732074737b59b248f440c910d9d6c7cc6bce1f0cf8f10e6e70\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:46:55', '2019-05-15 01:47:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 465, 7, NULL, 'order_CVbqs3LUNYZo5B', '{\"razorpay_payment_id\":\"pay_CVbqxlspXvtTt6\",\"razorpay_order_id\":\"order_CVbqs3LUNYZo5B\",\"razorpay_signature\":\"83cd347b7ff7a44ac5ac8bea891cd0f1991c6dd6dfd0297e640f5a039e7fc532\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:47:51', '2019-05-15 01:48:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 465, 7, NULL, 'order_CVbtiKFJ6B4r2p', '{\"razorpay_payment_id\":\"pay_CVbtoQjIfG3aIz\",\"razorpay_order_id\":\"order_CVbtiKFJ6B4r2p\",\"razorpay_signature\":\"d1215cb2409991e8e916212816c243120ae28db5a99889d5c05c6095f80815bb\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:50:32', '2019-05-15 01:50:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 465, 7, NULL, 'order_CVbuJsiVRmbX9v', '{\"razorpay_payment_id\":\"pay_CVbuR22Qkbj8fW\",\"razorpay_order_id\":\"order_CVbuJsiVRmbX9v\",\"razorpay_signature\":\"ffb4f232cec3d7a414a5c1bc6616337a03dd561878571d8c4a7e3688d6e2528e\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:51:06', '2019-05-15 01:51:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 465, 7, NULL, 'order_CVbwfAiWmnBsaH', '{\"razorpay_payment_id\":\"pay_CVbwpbvtG9JBC9\",\"razorpay_order_id\":\"order_CVbwfAiWmnBsaH\",\"razorpay_signature\":\"15cee49b5573fd09a42d48c636484764aa7a6ca97f154c7f428abcb9a156fa94\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:53:20', '2019-05-15 01:53:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 465, 7, NULL, 'order_CVc0sgBlqW8tW4', '{\"razorpay_payment_id\":\"pay_CVc10AFvQQCZiY\",\"razorpay_order_id\":\"order_CVc0sgBlqW8tW4\",\"razorpay_signature\":\"d06b8902a6bcd79cd948ca4bbae187f23a969375b99fc5e283acec75d6766012\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:57:19', '2019-05-15 01:57:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 465, 7, NULL, 'order_CVc4cufpSkhcnp', '{\"razorpay_payment_id\":\"pay_CVc4j0e3zIZ7FQ\",\"razorpay_order_id\":\"order_CVc4cufpSkhcnp\",\"razorpay_signature\":\"a2bbc741cc7795cd40db0f1eab7ac08b1a3f7bc3252c535f9961a8ab9eee7393\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:00:52', '2019-05-15 02:01:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 465, 7, NULL, 'order_CVc67qlTKNzkaZ', '{\"razorpay_payment_id\":\"pay_CVc6HQl5akvRkS\",\"razorpay_order_id\":\"order_CVc67qlTKNzkaZ\",\"razorpay_signature\":\"4e3c8c81d45d491daae8b1647c8e292c54939b47ac54575a6d53dbc394be0460\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arc...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:02:17', '2019-05-15 02:02:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 465, 7, '2019-05-15 02:04:11', 'order_CVc7tfrIFpmAnC', '{\"razorpay_payment_id\":\"pay_CVc81wLsIPyTOb\",\"razorpay_order_id\":\"order_CVc7tfrIFpmAnC\",\"razorpay_signature\":\"7b70ff8f7412b645c8cf8502350caa14bb53e6c1c41fb3e43d0ac9a0683048eb\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arc...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:03:58', '2019-05-15 02:04:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 37.83, 3, '2019-05-15 21:40:54', 'order_CVwAyNFRZQnJBm', '{\"razorpay_payment_id\":\"pay_CVwB3QarI1qhaN\",\"razorpay_order_id\":\"order_CVwAyNFRZQnJBm\",\"razorpay_signature\":\"c73dee4cdca2ac4e9e6cd17677aa09545902cd7c7152f291e10b81f22af0919f\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":43,\"name\":\"Machinery\",\"scheme\":1,\"price\":\"39\",\"category_id\":null,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21_1.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-05-05 14:52:00\",\"updated_at\":\"2019-05-05 15:36:22\",\"by\":\" \",\"category\":null,\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/43\\/Machinery\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-21.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-21_1.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fu...\",\"qty\":1}]', 1, 'pending', '2019-05-15 21:40:44', '2019-05-15 21:40:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 697.5, 7, NULL, 'order_CbRgmNik0CQzd1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:15', '2019-05-29 19:45:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `orders` (`id`, `amount_payable`, `percent_off`, `paid_at`, `razorpay_order_id`, `razorpay_response`, `billing_firstname`, `billing_lastname`, `billing_phone`, `billing_email`, `billing_country`, `billing_company`, `billing_street_address`, `billing_city`, `billing_state`, `billing_apartment`, `buyer_name`, `email`, `phone`, `address`, `additional_note`, `buyer_order`, `user_id`, `status`, `created_at`, `updated_at`, `shipping_firstname`, `shipping_lastname`, `shipping_email`, `shipping_phone`, `shipping_company`, `shipping_country`, `shipping_city`, `shipping_state`, `shipping_street_address`, `shipping_apartment`, `shipping_fee`) VALUES
(35, 697.5, 7, NULL, 'order_CbRgx6V96MpsG9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:25', '2019-05-29 19:45:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 697.5, 7, NULL, 'order_CbRh5vkhzNSZPd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:32', '2019-05-29 19:45:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 75.66, 3, '2019-06-12 15:01:16', 'order_CguJzMt3RLhzDW', '{\"razorpay_payment_id\":\"pay_CguKSDRvfXS2oR\",\"razorpay_order_id\":\"order_CguJzMt3RLhzDW\",\"razorpay_signature\":\"77618dc83b4c38b4cd94b69a64e4b19f021cb8b078f0927168fad51d3eb51945\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":43,\"name\":\"Machinery\",\"scheme\":1,\"price\":\"39\",\"category_id\":null,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21_1.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-05-05 14:52:00\",\"updated_at\":\"2019-05-21 19:50:30\",\"by\":\" \",\"category\":null,\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/43\\/Machinery\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-21.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-21_1.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volup...\",\"qty\":1},{\"id\":46,\"name\":\"Machiner\",\"scheme\":1,\"price\":\"39\",\"category_id\":null,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>vs n bse&nbsp;<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_16.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_17.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_14.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_15.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_12.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_13.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_10.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_11.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_8.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_9.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_6.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_7.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_4.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_5.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_3.png\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-15_1.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-05-21 20:02:15\",\"updated_at\":\"2019-05-21 20:03:05\",\"by\":\" \",\"category\":null,\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/46\\/Machiner\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_16.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_17.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_14.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_15.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_12.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_13.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_10.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_11.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_8.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_9.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_6.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_7.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_4.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_5.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_3.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_1.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-15_16.png\",\"secondaryimage\":{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_14.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_15.png\"},\"percentdiscount\":0,\"quickdescription\":\"<p>vs n bse&nbsp;<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-06-12 15:00:38', '2019-06-12 15:01:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 697.5, 7, '2019-06-12 16:16:40', 'order_CgvbzplpnfQwXo', '{\"razorpay_payment_id\":\"pay_Cgvc90qxIdD2cd\",\"razorpay_order_id\":\"order_CgvbzplpnfQwXo\",\"razorpay_signature\":\"88d8de5da93cb5dab3ef9221e429474f0bc3ebc32bbd6e6a432a12aed0c39788\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 month ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hen...\",\"qty\":1},{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 month ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas...\",\"qty\":1}]', 35, 'pending', '2019-06-12 16:16:25', '2019-06-12 16:16:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1627.5, 7, '2019-06-12 16:21:07', 'order_CgvgPnSTJNZqh4', '{\"razorpay_payment_id\":\"pay_CgvgVEO5lcFR1I\",\"razorpay_order_id\":\"order_CgvgPnSTJNZqh4\",\"razorpay_signature\":\"24e2100cc0c032590b6827f773cf9f9601601962f64aefe52db9be409d6c23f3\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 month ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":3},{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 month ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phas...\",\"qty\":1}]', 35, 'pending', '2019-06-12 16:20:38', '2019-06-12 16:21:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'tee02bn@gmail.com ', '5c9d5a2c96e96', '2019-03-28 19:35:08', '2019-03-28 19:35:08'),
(2, 'nationel83@gmail.com', '5c9e8f9b698ad', '2019-03-29 17:35:23', '2019-03-29 17:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `pool_commission_schedule`
--

CREATE TABLE `pool_commission_schedule` (
  `id` bigint(20) NOT NULL,
  `period` date NOT NULL,
  `disagio_dump` longtext NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pool_commission_schedule`
--

INSERT INTO `pool_commission_schedule` (`id`, `period`, `disagio_dump`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, '2019-08-01', '{\"total_disagio\":20,\"company_gain\":19.94,\"settings\":{\"1\":{\"level\":\"pool 1\",\"min_merchant_recruitment\":\"100\",\"percent_disagio\":0.05,\"sharable_total\":0.01},\"2\":{\"level\":\"pool 2\",\"min_merchant_recruitment\":\"300\",\"percent_disagio\":0.1,\"sharable_total\":0.02},\"3\":{\"level\":\"pool 3\",\"min_merchant_recruitment\":\"500<br>\",\"percent_disagio\":0.15,\"sharable_total\":0.03}}}', NULL, '2019-09-07 14:42:58', '2019-09-07 14:44:13'),
(3, '2019-09-01', '{\"total_disagio\":0,\"company_gain\":0,\"settings\":{\"1\":{\"level\":\"pool 1\",\"min_merchant_recruitment\":\"100\",\"percent_disagio\":0.05,\"sharable_total\":0},\"2\":{\"level\":\"pool 2\",\"min_merchant_recruitment\":\"300\",\"percent_disagio\":0.1,\"sharable_total\":0},\"3\":{\"level\":\"pool 3\",\"min_merchant_recruitment\":\"500<br>\",\"percent_disagio\":0.15,\"sharable_total\":0}}}', NULL, '2019-09-11 00:01:25', '2019-09-11 00:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheme` bigint(20) DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(191) DEFAULT NULL,
  `ribbon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `front_image` longtext COLLATE utf8mb4_unicode_ci,
  `back_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `downloadable_files` longtext COLLATE utf8mb4_unicode_ci,
  `on_sale` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `scheme`, `price`, `category_id`, `ribbon`, `old_price`, `description`, `front_image`, `back_image`, `downloadable_files`, `on_sale`, `created_at`, `updated_at`) VALUES
(41, 'tbou', 2, '500', 3, NULL, NULL, '<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]}', NULL, NULL, 1, '2019-02-26 06:21:19', '2019-05-03 22:38:47'),
(43, 'Machinery', 1, '39', NULL, NULL, NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-21.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-21_1.png\"}]}', NULL, 'uploads/images/downloadable_files/', 1, '2019-05-05 13:52:00', '2019-05-21 18:50:30'),
(46, 'Machiner', 1, '39', NULL, NULL, NULL, '<p>vs n bse&nbsp;</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_16.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_17.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_14.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_15.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_12.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_13.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_10.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_11.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_8.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_9.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_6.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_7.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_4.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_5.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_3.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_1.png\"}]}', NULL, 'uploads/images/downloadable_files/Screenshot-21_11.zip', 1, '2019-05-21 19:02:15', '2019-05-21 19:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `settlement_tracker`
--

CREATE TABLE `settlement_tracker` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_no` varchar(255) DEFAULT NULL,
  `period` date DEFAULT NULL,
  `dump` longtext,
  `settled_disagio` decimal(20,2) DEFAULT NULL,
  `settled_license_fee` decimal(20,2) DEFAULT NULL,
  `no_of_merchants` bigint(20) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `criteria` varchar(255) DEFAULT NULL,
  `settings` longtext,
  `default_setting` longtext NOT NULL COMMENT 'backup',
  `description` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `name`, `criteria`, `settings`, `default_setting`, `description`, `created_at`, `updated_at`) VALUES
(25, NULL, 'admin_bank_details', '{\"bank\":\"Access Banll\",\"account_number\":\"987567878\",\"account_name\":\"Alien Fashion\"}', '', NULL, NULL, NULL),
(26, 'PayPal', 'paypal_keys', '{\"live\":{\"public_key\":\"\",\"secret_key\":\"\"},\"test\":{\"public_key\":\"AYR2rnn79qtXxtBQsRLPI74yLREVUgt6I7zIls6dfheWqpfgHPk64gIQM2PwH60-kYUkFDw-4Zm5qdLn\",\"secret_key\":\"EFpewl-vuVPTAje7aO1Tk0n4VvAhd4RmtrMRxWMzXz9a5c96MGNJe0CT7w4yrC0bQjdOlMxcW2FKbkf0\"},\"mode\":{\"mode\":\"test\",\"available\":\"1\"}}', '', NULL, NULL, '2020-01-28 06:40:57'),
(27, NULL, 'sms_api_keys', '{\"username\":\"ncs\",\"password\":\"65f130\",\"link\":\"http://www.estoresms.com/smsapi.php\",\"sender\":\"Attendance\"}', '', NULL, NULL, '2019-03-21 13:58:02'),
(28, NULL, 'site_settings', '{\"contact_email\":\"itsmle101@gmail.com\",\"withdrawable_percent\":\"0\",\"email_verification\":\"1\",\"company_verification\":\"1\",\"commission_payouts_start_date\":\"2\",\"coinway_sales_api_key\":\"X-Api-Key : aabee567-eec7-4bbb-a0da-fb514cbc3285\",\"minimum_withdrawal\":200,\"distribute_commissions\":1,\"google_re_captcha_site_key\":\"6Lc1n60UAAAAAC-AqBtn5EgF7QreRh2sXm4R_GBy\",\"google_re_captcha_secret_key\":\"6Lc1n60UAAAAABtPq2oWYKf89YI69ADCf5OwHpit\"}', '', NULL, NULL, '2019-09-28 12:33:22'),
(29, NULL, 'commission_settings', '[{\"level\":\"direct\",\"license\":\"20\",\"packages\":\"20\",\"disagio\":\"1\"},{\"level\":\"1\",\"license\":\"10\",\"packages\":\"10\",\"disagio\":\"0\"},{\"level\":\"2\",\"license\":\"3\",\"packages\":\"3\",\"disagio\":\"0\"},{\"level\":\"3\",\"license\":\"7\",\"packages\":\"7\",\"disagio\":\"0\"}]', '', NULL, NULL, '2019-07-20 10:39:29'),
(30, NULL, 'pools_settings', '{\"1\":{\"level\":\"pool 1\",\"min_merchant_recruitment\":\"100\",\"percent_disagio\":0.05},\"2\":{\"level\":\"pool 2\",\"min_merchant_recruitment\":\"300\",\"percent_disagio\":0.1},\"3\":{\"level\":\"pool 3\",\"min_merchant_recruitment\":\"500<br>\",\"percent_disagio\":0.15}}', '', NULL, NULL, '2019-09-07 12:03:38'),
(31, NULL, 'documents_settings', '[{\"files\":\"uploads\\/admin\\/documents\\/ten.png\",\"label\":\"ten\"}]', '', NULL, NULL, '2019-09-28 13:18:46'),
(33, 'Coin Pay', 'coinpay_keys', '{\"live\":{\"username\":\"ae7a4f220ea847ada4d19566b76d26b2\",\"password\":\"2927618294cb4df78acfed3dac7d7e218ea7191c4e8945158f31d0c85838b922\",\"wallet_id\":\"41eb86b8-4db6-403b-9292-a24b4afbf5e4\"},\"test\":{\"username\":\"\",\"password\":\"\",\"wallet_id\":\"\"},\"mode\":{\"mode\":\"live\",\"available\":\"1\"}}', '', NULL, NULL, '2019-10-19 11:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_payment_orders`
--

CREATE TABLE `subscription_payment_orders` (
  `id` bigint(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_details` longtext,
  `user_id` bigint(20) NOT NULL,
  `sent_email` tinyint(1) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `price` float NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `details` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_payment_orders`
--

INSERT INTO `subscription_payment_orders` (`id`, `plan_id`, `payment_method`, `payment_details`, `user_id`, `sent_email`, `payment_proof`, `price`, `paid_at`, `details`, `created_at`, `updated_at`) VALUES
(75, 2, 'paypal', '{\"gateway\":\"paypal\",\"ref\":\"NSW75P776\",\"order_unique_id\":75,\"approval_url\":\"https:\\/\\/www.sandbox.paypal.com\\/cgi-bin\\/webscr?cmd=_express-checkout&token=EC-7NX885199W1464121\",\"amount\":240}', 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2019-10-05 23:48:04', '2020-01-29 06:46:22'),
(76, 2, NULL, NULL, 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2019-10-06 00:03:53', '2019-10-06 00:03:53'),
(77, 2, NULL, NULL, 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2019-10-06 00:03:56', '2019-10-06 00:03:56'),
(78, 2, NULL, NULL, 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2019-10-06 00:04:36', '2019-10-06 00:04:36'),
(79, 2, 'paypal', '{\"gateway\":\"paypal\",\"ref\":\"NSW79P646\",\"order_unique_id\":79,\"approval_url\":\"https:\\/\\/www.sandbox.paypal.com\\/cgi-bin\\/webscr?cmd=_express-checkout&token=EC-83B780870X012392U\",\"amount\":240}', 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2020-01-29 06:44:06', '2020-01-29 06:44:12'),
(80, 2, 'paypal', '{\"gateway\":\"paypal\",\"ref\":\"NSW80P701\",\"order_unique_id\":80,\"approval_url\":\"https:\\/\\/www.sandbox.paypal.com\\/cgi-bin\\/webscr?cmd=_express-checkout&token=EC-8TY415584X007062B\",\"amount\":240}', 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2020-01-29 06:44:55', '2020-01-29 06:45:07'),
(83, 2, 'paypal', '{\"gateway\":\"paypal\",\"ref\":\"NSW83P345\",\"order_unique_id\":83,\"approval_url\":\"https:\\/\\/www.sandbox.paypal.com\\/cgi-bin\\/webscr?cmd=_express-checkout&token=EC-76S82809MM438445K\",\"amount\":240}', 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2020-01-30 05:42:18', '2020-01-30 05:42:31'),
(84, 2, 'paypal', '{\"gateway\":\"paypal\",\"ref\":\"NSW84P996\",\"order_unique_id\":84,\"approval_url\":\"https:\\/\\/www.sandbox.paypal.com\\/cgi-bin\\/webscr?cmd=_express-checkout&token=EC-21674564Y60158231\",\"amount\":240}', 35, NULL, NULL, 200, NULL, '{\"id\":2,\"price\":200,\"percent_vat\":\"20.00\",\"hierarchy\":3,\"features\":\"access, read\",\"package_type\":\"Basic\",\"downline_commission_level\":2,\"get_pool\":0,\"commission_price\":\"200.00\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-07-20 22:42:51\"}', '2020-01-30 06:09:50', '2020-01-30 06:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `price` float NOT NULL,
  `percent_vat` decimal(10,2) DEFAULT NULL,
  `hierarchy` int(11) DEFAULT NULL,
  `features` longtext NOT NULL,
  `package_type` varchar(255) NOT NULL,
  `downline_commission_level` int(11) DEFAULT NULL,
  `get_pool` int(11) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `gateways_ids` longtext,
  `confirmation_message` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `price`, `percent_vat`, `hierarchy`, `features`, `package_type`, `downline_commission_level`, `get_pool`, `commission_price`, `availability`, `gateways_ids`, `confirmation_message`, `created_at`, `updated_at`) VALUES
(1, 0, '20.00', 4, 'access, read', 'Light', 0, 0, '0.00', 'on', NULL, '<p>Dear project_name;?&gt; member thank you for paying the signup fee for 3 inr (Indian rupees) only</p>\r\n\r\n<ul>\r\n	<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.</li>\r\n	<li>The new multi level earning scheme developed by our very creative minds</li>\r\n	<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.</li>\r\n	<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme</li>\r\n</ul>\r\n\r\n<p>Here are the details for this particular scheme:</p>\r\n\r\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.</p>\r\n\r\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.</p>\r\n\r\n<p>Here are the product details: link: -https//:LOREMIPSUM.CODQSUCJCB</p>\r\n', NULL, '2019-07-20 22:42:51'),
(2, 200, '20.00', 3, 'access, read', 'Basic', 2, 0, '200.00', 'on', NULL, '<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only</p>\r\n\r\n<ul>\r\n	<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.</li>\r\n	<li>The new multi level earning scheme developed by our very creative minds</li>\r\n	<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.</li>\r\n	<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme</li>\r\n</ul>\r\n\r\n<p>Here are the details for this particular scheme:</p>\r\n\r\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.</p>\r\n\r\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.</p>\r\n\r\n<p>Here are the product details: link: -https//:LOREMIPSUM.CODQSUCJCB</p>\r\n', NULL, '2019-07-20 22:42:51'),
(3, 500, '20.00', 2, 'access, read', 'Professional', 3, 0, '500.00', 'on', NULL, NULL, '2019-06-19 00:00:00', '2019-07-20 22:42:51'),
(4, 850, '20.00', 1, 'access, read', 'Premium', 3, 1, '850.00', 'on', NULL, NULL, '2019-06-19 00:00:00', '2019-07-20 22:42:51'),
(6, 900, '20.00', 3, 'access, read', 'Basic + Training', 2, 0, '200.00', 'on', NULL, '<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only</p>\r\n\r\n<ul>\r\n	<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.</li>\r\n	<li>The new multi level earning scheme developed by our very creative minds</li>\r\n	<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.</li>\r\n	<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme</li>\r\n</ul>\r\n\r\n<p>Here are the details for this particular scheme:</p>\r\n\r\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.</p>\r\n\r\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.</p>\r\n\r\n<p>Here are the product details: link: -https//:LOREMIPSUM.CODQSUCJCB</p>\r\n', NULL, '2019-07-20 22:42:52'),
(7, 1200, '20.00', 2, 'access, read, write, test', 'Professional + Training', 3, 0, '500.00', 'on', NULL, NULL, '2019-06-19 00:00:00', '2019-07-20 22:42:52'),
(8, 1450, '20.00', 1, 'access, read, write, test', 'Premium + Training', 3, 1, '850.00', 'on', NULL, NULL, '2019-06-19 00:00:00', '2019-07-20 22:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) NOT NULL,
  `subject_of_ticket` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` smallint(1) NOT NULL COMMENT '0=open, 1=clsed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `subject_of_ticket`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'huujklj E g4RH 7YWJ', 5, 1, '2018-03-06 14:05:02', '2018-03-15 15:44:34'),
(2, 'hhhh', 5, 1, '2018-03-06 14:05:29', '2018-03-06 15:26:26'),
(3, 'hhhh orag', 5, 1, '2018-03-06 14:17:46', '2018-03-06 15:15:52'),
(4, 'My first complaint', 1, 1, '2018-03-07 09:53:15', '2018-03-15 13:47:31'),
(5, 'jiji it', 20, 1, '2018-03-15 13:42:52', '2018-03-15 13:43:13'),
(6, 'jiji itv  jytyet im 4u4j i 4ol', 20, 0, '2018-03-15 13:43:28', '2018-03-15 13:43:28'),
(7, 'hey', 21, 0, '2018-03-15 16:13:28', '2018-03-15 16:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `attester` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `approval_status` int(11) NOT NULL DEFAULT '0' COMMENT '1= approved, 0=not approved',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `user_id`, `attester`, `content`, `approval_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lindas Jmon', '', 1, '2019-07-11 23:53:22', '2019-07-14 11:00:14'),
(2, 1, 'Lindas Jmon', 'This is great systemfdet f e', 1, '2019-07-11 23:54:21', '2019-07-14 11:10:04'),
(4, 1, 'frsr', 'wrrr', 0, '2019-07-14 11:06:54', '2019-07-14 11:10:11'),
(5, 1, 'Lindas Jmon', '', 0, '2019-07-14 11:08:33', '2019-07-14 11:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `mlm_id` varchar(255) DEFAULT NULL,
  `referred_by` bigint(20) DEFAULT NULL COMMENT 'placment_sponsor',
  `introduced_by` bigint(20) DEFAULT NULL COMMENT 'enrolment sponsor',
  `placement_cut_off` longtext,
  `rejoin_id` varchar(255) DEFAULT NULL,
  `rejoin_email` varchar(255) DEFAULT NULL,
  `placed` int(11) DEFAULT NULL COMMENT '0=not placed, 1= placed (by enroler)',
  `username` varchar(255) DEFAULT NULL,
  `account_plan` varchar(255) DEFAULT NULL COMMENT 'Demo receiver user',
  `rank` int(11) NOT NULL DEFAULT '0',
  `locked_to_receive` datetime DEFAULT NULL,
  `rank_history` longtext,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_verification` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone_verification` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `worthy_cause_for_donation` longtext,
  `age` varchar(255) DEFAULT NULL,
  `profile_pix` varchar(255) DEFAULT NULL,
  `resized_profile_pix` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `blocked_on` datetime DEFAULT NULL,
  `lastseen_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastlogin_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mlm_id`, `referred_by`, `introduced_by`, `placement_cut_off`, `rejoin_id`, `rejoin_email`, `placed`, `username`, `account_plan`, `rank`, `locked_to_receive`, `rank_history`, `firstname`, `lastname`, `email`, `state`, `country`, `email_verification`, `phone`, `phone_verification`, `bank_name`, `bank_account_number`, `bank_account_name`, `worthy_cause_for_donation`, `age`, `profile_pix`, `resized_profile_pix`, `password`, `created_at`, `updated_at`, `blocked_on`, `lastseen_at`, `lastlogin_ip`) VALUES
(1, '1', 16, NULL, NULL, NULL, NULL, NULL, '1', '1', 2, NULL, '{\"2018-11-27 12:20:17\":\"8\",\"2018-11-27 12:31:10\":\"5\"}', 'Jmon', 'Lindas', 'ozih@rocketmail.comm', NULL, ' Antigua & Barbuda', '1', '9678908', '162598', 'capitec', '097567890', 'jacqueline', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover ', '23', 'uploads/images/users/profile_pictures/taiwo_1.png', 'uploads/images/users/profile_pictures/taiwo_2.png', '$2y$10$Tt8Xj8ZAqk7sMAu1cbqWtOZS6rgL8wG.w.OOiU74hRmpTZdCaSLQ6', '2018-11-07 12:05:14', '2019-09-07 18:37:13', NULL, '2019-10-03 05:12:26', ''),
(35, '35', 1, 1, NULL, NULL, NULL, NULL, 'teeboy', NULL, 0, NULL, NULL, 'Taiwo', 'Opeifa', 'tee02bn@gmail.com', NULL, NULL, '1', '08123351819', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Tt8Xj8ZAqk7sMAu1cbqWtOZS6rgL8wG.w.OOiU74hRmpTZdCaSLQ6', '2019-06-12 09:32:48', '2019-07-14 08:57:50', NULL, '2019-09-28 11:43:45', ''),
(36, '36', 35, 35, NULL, NULL, NULL, NULL, 'teeboy1', '3', 0, NULL, NULL, 'Taiwo', 'ope', 'tee01bn@gmail.com', NULL, NULL, '1', '081123351819', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$mLK3ULawFnhu6hW0bGvG9uW6HpLtDeQcvXp6Z5Mt6y.z85ZbyTmz2', '2019-06-12 09:42:20', '2019-06-12 11:26:32', NULL, '2019-07-20 19:50:13', ''),
(37, '37', 36, 36, NULL, NULL, NULL, NULL, 'teeboy2', '3', 0, NULL, NULL, 'Taiwo', 'ope', 'tee1bn@gmail.com', NULL, NULL, 'nb46ek', '08112335181', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$HbW0PW41wrqVPhP5P3LOBudlDsSNwSfdYmXl2t6SCuAgQ6DMOgwRm', '2019-06-12 09:53:12', '2019-06-12 09:53:12', NULL, '2019-07-20 19:50:10', ''),
(39, '39', 37, 37, NULL, NULL, NULL, NULL, 'tgrsth', '3', 0, NULL, NULL, 'tee', 'rer', 'tgrsth@sada.com1', NULL, NULL, 't6dnma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$heUN58K5ojNDsg4U1Um1IO4V.qi2J2GS2tyZs0ccKGF.HG51IdsV2', '2019-07-11 19:56:19', '2019-07-20 20:28:42', NULL, '2019-07-20 19:28:42', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `broadcast`
--
ALTER TABLE `broadcast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_support`
--
ALTER TABLE `customers_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_income_report`
--
ALTER TABLE `level_income_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commission_type` (`commission_type`,`owner_user_id`,`downline_id`) USING BTREE;

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pool_commission_schedule`
--
ALTER TABLE `pool_commission_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product` (`name`);

--
-- Indexes for table `settlement_tracker`
--
ALTER TABLE `settlement_tracker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `period` (`period`,`user_id`,`user_no`) USING BTREE;

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_payment_orders`
--
ALTER TABLE `subscription_payment_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `Unique` (`mlm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `broadcast`
--
ALTER TABLE `broadcast`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers_support`
--
ALTER TABLE `customers_support`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level_income_report`
--
ALTER TABLE `level_income_report`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pool_commission_schedule`
--
ALTER TABLE `pool_commission_schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `settlement_tracker`
--
ALTER TABLE `settlement_tracker`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subscription_payment_orders`
--
ALTER TABLE `subscription_payment_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
