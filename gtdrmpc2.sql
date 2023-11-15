-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 07:35 AM
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
-- Database: `gtdrmpc2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `unique_id` varchar(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `access` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`access`)),
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `img`, `unique_id`, `email`, `password`, `access`, `is_verified`, `verification_token`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, 'DR00001', 'admin@example.com', '$2y$10$YZQ8WFH9b7zvvmTuMkTAQ./J2PTEXRIB8RTdEb5/lU8oTZHu6B0Ti', '[\"inventory\",\"orders\",\"staff_management\",\"payment_methods\",\"activity_logs\",\"buffalo_management\"]', 1, NULL, 1, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'Employee 1', NULL, 'DR00002', 'employee1@example.com', '$2y$10$o6XoJoy4GVqVv.zuLGaXVecjQgQboUWqP8vqncx/bXY5rrPT0RqmS', '[\"orders\",\"buffalo_management\"]', 1, NULL, 0, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(3, 'Employee 2', NULL, 'DR00003', 'employee2@example.com', '$2y$10$cj.JlzF9cztU5KPK3.cpbu1f.Vr8VQgX08by9j9th66XjSOSGgOkq', '[\"inventory\",\"activity_logs\"]', 1, NULL, 0, '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `buffalo`
--

CREATE TABLE `buffalo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `age` enum('baby','adult') NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buffalo`
--

INSERT INTO `buffalo` (`id`, `gender`, `age`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'male', 'baby', 100, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'male', 'adult', 100, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(3, 'female', 'baby', 100, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(4, 'female', 'adult', 100, '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `buffalo_sales`
--

CREATE TABLE `buffalo_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `buyer_address` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `total_quantity` int(11) NOT NULL,
  `grand_total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_fee`
--

CREATE TABLE `delivery_fee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_fee`
--

INSERT INTO `delivery_fee` (`id`, `municipality`, `fee`, `zip_code`, `created_at`, `updated_at`) VALUES
(1, 'ALFONSO', 50, '4123', NULL, NULL),
(2, 'AMADEO', 50, '4119', NULL, NULL),
(3, 'BACOOR CITY', 50, '4102', NULL, NULL),
(4, 'CARMONA', 50, '4116', NULL, NULL),
(5, 'CAVITE CITY', 50, '4100', NULL, NULL),
(6, 'DASMARIÑAS CITY', 50, '4114', NULL, NULL),
(7, 'GEN. MARIANO ALVAREZ', 50, '4117', NULL, NULL),
(8, 'GENERAL EMILIO AGUINALDO', 50, '4124', NULL, NULL),
(9, 'GENERAL TRIAS CITY', 50, '4107', NULL, NULL),
(10, 'IMUS', 50, '4103', NULL, NULL),
(11, 'INDANG', 50, '4122', NULL, NULL),
(12, 'KAWIT', 50, '4104', NULL, NULL),
(13, 'MAGALLANES', 50, '4113', NULL, NULL),
(14, 'MARAGONDON', 50, '4112', NULL, NULL),
(15, 'MENDEZ (MENDEZ-NUÑEZ)', 50, '4121', NULL, NULL),
(16, 'NAIC', 50, '4110', NULL, NULL),
(17, 'NOVELETA', 50, '4105', NULL, NULL),
(18, 'ROSARIO', 50, '4106', NULL, NULL),
(19, 'SILANG', 50, '4118', NULL, NULL),
(20, 'TAGAYTAY CITY', 50, '4120', NULL, NULL),
(21, 'TANZA', 50, '4108', NULL, NULL),
(22, 'TERNATE', 50, '4111', NULL, NULL),
(23, 'TRECE MARTIRES CITY', 50, '4109', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_cart`
--

CREATE TABLE `guest_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_order`
--

CREATE TABLE `guest_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `guest_address` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `payment_reciept` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_identifier` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(425, '2014_10_12_000000_create_users_table', 1),
(426, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(427, '2014_10_12_100000_create_password_resets_table', 1),
(428, '2019_08_19_000000_create_failed_jobs_table', 1),
(429, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(430, '2023_04_24_055722_create_product_table', 1),
(431, '2023_04_26_045511_create_cart_table', 1),
(432, '2023_06_04_052435_create_orders_table', 1),
(433, '2023_06_04_053541_create_user_address_table', 1),
(434, '2023_06_19_171221_create_guest_users_table', 1),
(435, '2023_06_19_191907_create_guest_cart_table', 1),
(436, '2023_06_19_192059_create_guest_order_table', 1),
(437, '2023_07_14_102552_create_product_stocks_table', 1),
(438, '2023_07_15_143224_create_variants_table', 1),
(439, '2023_07_15_213256_create_admin_table', 1),
(440, '2023_07_16_100135_create_payment_method_table', 1),
(441, '2023_07_20_162412_create_payment_reciept_table', 1),
(442, '2023_07_21_145859_create_buffalos_table', 1),
(443, '2023_07_25_014120_create_milk_stock_table', 1),
(444, '2023_07_25_174912_create_activity_log_table', 1),
(445, '2023_07_28_221421_create_retailers_table', 1),
(446, '2023_07_29_101534_create_online_shoppers_table', 1),
(447, '2023_08_02_200726_create_sales_table', 1),
(448, '2023_08_04_105929_create_buffalo_sales_table', 1),
(449, '2023_08_04_145642_create_milk_sales_table', 1),
(450, '2023_08_15_150321_create_password_resets_admin_table', 1),
(451, '2023_09_16_121103_create_delivery_fee_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `milk_sales`
--

CREATE TABLE `milk_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_stock`
--

CREATE TABLE `milk_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_shoppers`
--

CREATE TABLE `online_shoppers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `online_shoppers`
--

INSERT INTO `online_shoppers` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 2, '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `grand_total` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `shipping_option` varchar(255) NOT NULL,
  `delivery_fee` int(11) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_type` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `name`, `email`, `mobile_number`, `store_name`, `grand_total`, `address`, `remarks`, `comments`, `shipping_option`, `delivery_fee`, `payment_method`, `reference_number`, `payment_receipt`, `status`, `items`, `customer_id`, `customer_type`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'DR08231', 'Christian Jay Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 350, 'Sta. Cecilia 2 Brgt. Julugan viii, Tanza, Cavite 4108, Philippines', NULL, NULL, 'Delivery', NULL, 'Gcash', '123456789B', NULL, 'Pending', '[{\"product_id\":1,\"name\":\"Choco Milk\",\"variant\":\"Milk\",\"price\":100,\"discount\":0,\"quantity\":2,\"total\":200,\"img\":\"images\\/baka.png\"},{\"product_id\":4,\"name\":\"Plain Yoghurt\",\"variant\":\"Yoghurt\",\"price\":50,\"discount\":0,\"quantity\":3,\"total\":150,\"img\":\"images\\/baka.png\"}]', 1, 'online_shopper', NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'DR08232', 'Christian Jay Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 300, 'street 22221 Brgy. Alima, Baccor City, Cavite  4109, Philippines', NULL, NULL, 'Delivery', NULL, 'Gcash', '987654321A', NULL, 'Pending', '[{\"product_id\":2,\"price\":100,\"discount\":0,\"quantity\":3,\"total\":300}]', 2, 'online_shopper', NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(3, 'DR08233', 'Christian Jay Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 450, 'street 1111 Brgy. Cabulalan, Bacarra, Ilocos Norte  4001, Philippines', NULL, NULL, 'Delivery', NULL, 'Gcash', '987654321F', NULL, 'Pending', '[{\"product_id\":3,\"price\":100,\"discount\":10,\"quantity\":5,\"total\":450}]', 1, 'retailer', NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(4, 'DR08234', 'Christian Jay Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 480, 'street 2222 Brgy. San Antonio, Basco, Batanes 4002, Philippines', NULL, NULL, 'Delivery', NULL, 'Gcash', '123456789G', NULL, 'Pending', '[{\"product_id\":4,\"price\":50,\"discount\":2,\"quantity\":10,\"total\":480}]', 2, 'retailer', NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(5, 'DR08234', 'Christian Jay Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 480, 'street 2222 Brgy. San Antonio, Basco, Batanes 4002, Philippines', NULL, NULL, 'Delivery', NULL, 'Gcash', '123456789G', NULL, 'Pending', '[{\"product_id\":4,\"price\":50,\"discount\":2,\"quantity\":10,\"total\":480}]', NULL, 'guest', NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(6, '1DR1123', 'Christian Jacalne', 'krischang29@gmail.com', '9262189072', NULL, 320, 'Sta. Cecilia 2 Barangay 58-a (patola A), Cavite City, Cavite, 4100 Philippines', 'nothing', NULL, 'Delivery', 50, 'Cash On Delivery', NULL, NULL, 'Pending', '[{\"product_id\":1,\"img\":\"images\\/products\\/choco_milk_large.png\",\"name\":\"Choco Milk (1L)\",\"variant\":\"Milk\",\"price\":135,\"quantity\":2,\"total\":270}]', NULL, 'guest', '127.0.0.1', '2023-11-15 06:29:52', '2023-11-15 06:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets_admin`
--

CREATE TABLE `password_resets_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `type`, `img`, `account_name`, `account_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gcash', 'images/payment_method/gcash_barcode.jpg', 'Christian Jay Jacalne', '09262189072', 'ACTIVATED', '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `payment_reciept`
--

CREATE TABLE `payment_reciept` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `reciept` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `variants_id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stocks` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'NOT AVAILABLE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `img`, `variants_id`, `description`, `price`, `stocks`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Choco Milk (1L)', 'images/products/choco_milk_large.png', '3', NULL, 135, 98, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:29:52'),
(2, 'Choco Milk (200ml)', 'images/products/choco_milk_small.png', '3', NULL, 40, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(3, 'Fresh Milk (1L)', 'images/products/fresh_milk_large.png', '3', NULL, 145, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(4, 'Fresh Milk (200ml)', 'images/products/fresh_milk_small.png', '3', NULL, 40, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(5, 'Strawberry Milk (1L)', 'images/products/strawberry_milk_large.png', '3', NULL, 170, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(6, 'Strawberry Milk (200ml)', 'images/products/strawberry_milk_small.png', '3', NULL, 50, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(7, 'Plain Yogurt', 'images/products/plain_yogurt.png', '1', NULL, 50, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(8, 'Strawberry Yogurt', 'images/products/strawberry_yogurt.png', '1', NULL, 55, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(9, 'Mango Yogurt', 'images/products/mango_yogurt.png', '1', NULL, 55, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(10, 'Blueberry Yogurt', 'images/products/blueberry_yogurt.png', '1', NULL, 55, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(11, 'Patchberry Yogurt', 'images/products/patchberry_yogurt.png', '1', NULL, 55, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(12, 'Pineapple Yogurt', 'images/products/pineapple_yogurt.png', '1', NULL, 55, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(13, 'Milk-o-Jel', 'images/products/milk_o_jel.png', '4', NULL, 22, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(14, 'Plain Pastillas (20pcs)', 'images/products/plain_pastillas.png', '2', NULL, 75, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(15, 'Cheese Pastillas (20pcs)', 'images/products/cheese_pastillas.png', '2', NULL, 75, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(16, 'Ube Pastillas (20pcs)', 'images/products/ube_pastillas.png', '2', NULL, 75, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(17, 'Buko Pandan Pastillas (20pcs)', 'images/products/plain_pastillas.png', '2', NULL, 75, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(18, 'Langka Pastillas (20pcs)', 'images/products/cheese_pastillas.png', '2', NULL, 75, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(19, 'Corn Cheese Ice Cream', 'images/products/cheese_icecream.png', '5', NULL, 30, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(20, 'Ube Cheese Ice Cream', 'images/products/ube_icecream.png', '5', NULL, 30, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(21, 'Cookies & Cream Ice Cream', 'images/products/cookies_icecream.png', '5', NULL, 30, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(22, 'Ube Ice Candy', 'images/products/ube_ice_candy.jpg', '5', NULL, 7, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(23, 'Choco Ice Candy', 'images/products/ice_candy.jpg', '5', NULL, 7, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(24, 'Mais Ice Candy', 'images/products/ice_candy.jpg', '5', NULL, 7, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(25, 'Buko Pandan Ice Candy', 'images/products/pandan_ice_candy.jpg', '5', NULL, 7, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(26, 'Plain Kesong Puti', 'images/products/plain_cheese.png', '6', NULL, 80, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(27, 'Kasilyo', 'images/products/kasilyo_cheese.png', '6', NULL, 30, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(28, 'Mozzarella Cheese', 'images/products/cheese.png', '6', NULL, 200, 100, 'AVAILABLE', '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `stock` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `expiration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retailers`
--

CREATE TABLE `retailers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `complete_address` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `retailers`
--

INSERT INTO `retailers` (`id`, `first_name`, `last_name`, `store_name`, `mobile_number`, `region`, `province`, `municipality`, `barangay`, `street`, `zip_code`, `complete_address`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Retailer 1 First Name', 'Retailer 1 Last Name', 'Retailer 1 Store', '1111111111', 'REGION I', 'ILOCOS NORTE', 'BACARRA', 'CABULALAAN', 'street 1111', '4001', 'street 1111 BRGY. CABULALAAN, BACARRA, ILOCOS NORTE, REGION I 4001, PHILIPPINES', 'remarks 11111', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'Retailer 2 First Name', 'Retailer 2 Last Name', 'Retailer 2 Store', '2222222222', 'REGION II', 'BATANES', 'BASCO', 'SAN ANTONIO', 'street 2222', '4002', 'street 2222 BRGY. SAN ANTONIO, BASCO, BATANES, REGION II 4002, PHILIPPINES', 'remarks 22222', '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `category`, `name`, `price`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Products', 'Choco Milk', 100.00, 99, 1980.00, '2021-12-31 16:00:00', '2023-11-15 06:21:56'),
(2, 'Products', 'Fresh Milk', 100.00, 81, 1949.00, '2021-12-31 16:00:00', '2023-11-15 06:21:56'),
(3, 'Products', 'Plain Yoghurt', 50.00, 68, 1065.00, '2021-12-31 16:00:00', '2023-11-15 06:21:56'),
(4, 'Buffalo', 'Buffalo', 2699.00, 35, 1153.00, '2021-12-31 16:00:00', '2023-11-15 06:21:56'),
(5, 'Products', 'Choco Milk', 100.00, 33, 1674.00, '2022-01-31 16:00:00', '2023-11-15 06:21:56'),
(6, 'Products', 'Fresh Milk', 100.00, 99, 1360.00, '2022-01-31 16:00:00', '2023-11-15 06:21:56'),
(7, 'Products', 'Plain Yoghurt', 50.00, 49, 1039.00, '2022-01-31 16:00:00', '2023-11-15 06:21:56'),
(8, 'Buffalo', 'Buffalo', 4115.00, 93, 1593.00, '2022-01-31 16:00:00', '2023-11-15 06:21:56'),
(9, 'Products', 'Choco Milk', 100.00, 44, 1429.00, '2022-02-28 16:00:00', '2023-11-15 06:21:56'),
(10, 'Products', 'Fresh Milk', 100.00, 66, 1411.00, '2022-02-28 16:00:00', '2023-11-15 06:21:56'),
(11, 'Products', 'Plain Yoghurt', 50.00, 59, 1455.00, '2022-02-28 16:00:00', '2023-11-15 06:21:56'),
(12, 'Buffalo', 'Buffalo', 1594.00, 20, 1017.00, '2022-02-28 16:00:00', '2023-11-15 06:21:56'),
(13, 'Products', 'Choco Milk', 100.00, 56, 1305.00, '2022-03-31 16:00:00', '2023-11-15 06:21:56'),
(14, 'Products', 'Fresh Milk', 100.00, 23, 1510.00, '2022-03-31 16:00:00', '2023-11-15 06:21:56'),
(15, 'Products', 'Plain Yoghurt', 50.00, 45, 1747.00, '2022-03-31 16:00:00', '2023-11-15 06:21:56'),
(16, 'Buffalo', 'Buffalo', 1950.00, 10, 1078.00, '2022-03-31 16:00:00', '2023-11-15 06:21:56'),
(17, 'Products', 'Choco Milk', 100.00, 74, 1901.00, '2022-04-30 16:00:00', '2023-11-15 06:21:56'),
(18, 'Products', 'Fresh Milk', 100.00, 72, 1498.00, '2022-04-30 16:00:00', '2023-11-15 06:21:56'),
(19, 'Products', 'Plain Yoghurt', 50.00, 30, 1266.00, '2022-04-30 16:00:00', '2023-11-15 06:21:56'),
(20, 'Buffalo', 'Buffalo', 3541.00, 66, 1946.00, '2022-04-30 16:00:00', '2023-11-15 06:21:56'),
(21, 'Products', 'Choco Milk', 100.00, 10, 1721.00, '2022-05-31 16:00:00', '2023-11-15 06:21:56'),
(22, 'Products', 'Fresh Milk', 100.00, 69, 1882.00, '2022-05-31 16:00:00', '2023-11-15 06:21:56'),
(23, 'Products', 'Plain Yoghurt', 50.00, 30, 1651.00, '2022-05-31 16:00:00', '2023-11-15 06:21:56'),
(24, 'Buffalo', 'Buffalo', 2180.00, 22, 1594.00, '2022-05-31 16:00:00', '2023-11-15 06:21:56'),
(25, 'Products', 'Choco Milk', 100.00, 69, 1729.00, '2022-06-30 16:00:00', '2023-11-15 06:21:56'),
(26, 'Products', 'Fresh Milk', 100.00, 43, 1863.00, '2022-06-30 16:00:00', '2023-11-15 06:21:56'),
(27, 'Products', 'Plain Yoghurt', 50.00, 87, 1181.00, '2022-06-30 16:00:00', '2023-11-15 06:21:56'),
(28, 'Buffalo', 'Buffalo', 4367.00, 57, 1941.00, '2022-06-30 16:00:00', '2023-11-15 06:21:56'),
(29, 'Products', 'Choco Milk', 100.00, 77, 1503.00, '2022-07-31 16:00:00', '2023-11-15 06:21:56'),
(30, 'Products', 'Fresh Milk', 100.00, 81, 1934.00, '2022-07-31 16:00:00', '2023-11-15 06:21:56'),
(31, 'Products', 'Plain Yoghurt', 50.00, 92, 1812.00, '2022-07-31 16:00:00', '2023-11-15 06:21:56'),
(32, 'Buffalo', 'Buffalo', 4559.00, 80, 1725.00, '2022-07-31 16:00:00', '2023-11-15 06:21:56'),
(33, 'Products', 'Choco Milk', 100.00, 41, 1754.00, '2022-08-31 16:00:00', '2023-11-15 06:21:56'),
(34, 'Products', 'Fresh Milk', 100.00, 29, 1395.00, '2022-08-31 16:00:00', '2023-11-15 06:21:56'),
(35, 'Products', 'Plain Yoghurt', 50.00, 79, 1576.00, '2022-08-31 16:00:00', '2023-11-15 06:21:56'),
(36, 'Buffalo', 'Buffalo', 4396.00, 30, 1758.00, '2022-08-31 16:00:00', '2023-11-15 06:21:56'),
(37, 'Products', 'Choco Milk', 100.00, 89, 1851.00, '2022-09-30 16:00:00', '2023-11-15 06:21:56'),
(38, 'Products', 'Fresh Milk', 100.00, 46, 1835.00, '2022-09-30 16:00:00', '2023-11-15 06:21:56'),
(39, 'Products', 'Plain Yoghurt', 50.00, 46, 1333.00, '2022-09-30 16:00:00', '2023-11-15 06:21:56'),
(40, 'Buffalo', 'Buffalo', 3319.00, 92, 1290.00, '2022-09-30 16:00:00', '2023-11-15 06:21:56'),
(41, 'Products', 'Choco Milk', 100.00, 50, 1315.00, '2022-10-31 16:00:00', '2023-11-15 06:21:56'),
(42, 'Products', 'Fresh Milk', 100.00, 61, 1524.00, '2022-10-31 16:00:00', '2023-11-15 06:21:56'),
(43, 'Products', 'Plain Yoghurt', 50.00, 79, 1714.00, '2022-10-31 16:00:00', '2023-11-15 06:21:56'),
(44, 'Buffalo', 'Buffalo', 3951.00, 65, 1397.00, '2022-10-31 16:00:00', '2023-11-15 06:21:56'),
(45, 'Products', 'Choco Milk', 100.00, 41, 1503.00, '2022-11-30 16:00:00', '2023-11-15 06:21:56'),
(46, 'Products', 'Fresh Milk', 100.00, 13, 1458.00, '2022-11-30 16:00:00', '2023-11-15 06:21:56'),
(47, 'Products', 'Plain Yoghurt', 50.00, 99, 1020.00, '2022-11-30 16:00:00', '2023-11-15 06:21:56'),
(48, 'Buffalo', 'Buffalo', 1729.00, 81, 1330.00, '2022-11-30 16:00:00', '2023-11-15 06:21:56'),
(49, 'Products', 'Choco Milk', 100.00, 70, 1758.00, '2022-12-31 16:00:00', '2023-11-15 06:21:56'),
(50, 'Products', 'Fresh Milk', 100.00, 69, 1912.00, '2022-12-31 16:00:00', '2023-11-15 06:21:56'),
(51, 'Products', 'Plain Yoghurt', 50.00, 92, 1983.00, '2022-12-31 16:00:00', '2023-11-15 06:21:56'),
(52, 'Buffalo', 'Buffalo', 3941.00, 35, 1043.00, '2022-12-31 16:00:00', '2023-11-15 06:21:56'),
(53, 'Products', 'Choco Milk', 100.00, 42, 1730.00, '2023-01-31 16:00:00', '2023-11-15 06:21:56'),
(54, 'Products', 'Fresh Milk', 100.00, 54, 1563.00, '2023-01-31 16:00:00', '2023-11-15 06:21:56'),
(55, 'Products', 'Plain Yoghurt', 50.00, 64, 1947.00, '2023-01-31 16:00:00', '2023-11-15 06:21:56'),
(56, 'Buffalo', 'Buffalo', 4342.00, 30, 1359.00, '2023-01-31 16:00:00', '2023-11-15 06:21:56'),
(57, 'Products', 'Choco Milk', 100.00, 70, 1184.00, '2023-02-28 16:00:00', '2023-11-15 06:21:56'),
(58, 'Products', 'Fresh Milk', 100.00, 42, 1526.00, '2023-02-28 16:00:00', '2023-11-15 06:21:56'),
(59, 'Products', 'Plain Yoghurt', 50.00, 66, 1306.00, '2023-02-28 16:00:00', '2023-11-15 06:21:56'),
(60, 'Buffalo', 'Buffalo', 3635.00, 18, 1284.00, '2023-02-28 16:00:00', '2023-11-15 06:21:56'),
(61, 'Products', 'Choco Milk', 100.00, 27, 1032.00, '2023-03-31 16:00:00', '2023-11-15 06:21:56'),
(62, 'Products', 'Fresh Milk', 100.00, 68, 1391.00, '2023-03-31 16:00:00', '2023-11-15 06:21:56'),
(63, 'Products', 'Plain Yoghurt', 50.00, 18, 1849.00, '2023-03-31 16:00:00', '2023-11-15 06:21:56'),
(64, 'Buffalo', 'Buffalo', 4343.00, 41, 1908.00, '2023-03-31 16:00:00', '2023-11-15 06:21:56'),
(65, 'Products', 'Choco Milk', 100.00, 30, 1850.00, '2023-04-30 16:00:00', '2023-11-15 06:21:56'),
(66, 'Products', 'Fresh Milk', 100.00, 98, 1474.00, '2023-04-30 16:00:00', '2023-11-15 06:21:56'),
(67, 'Products', 'Plain Yoghurt', 50.00, 100, 1897.00, '2023-04-30 16:00:00', '2023-11-15 06:21:56'),
(68, 'Buffalo', 'Buffalo', 3714.00, 57, 1837.00, '2023-04-30 16:00:00', '2023-11-15 06:21:56'),
(69, 'Products', 'Choco Milk', 100.00, 35, 1962.00, '2023-05-31 16:00:00', '2023-11-15 06:21:56'),
(70, 'Products', 'Fresh Milk', 100.00, 19, 1875.00, '2023-05-31 16:00:00', '2023-11-15 06:21:56'),
(71, 'Products', 'Plain Yoghurt', 50.00, 72, 1392.00, '2023-05-31 16:00:00', '2023-11-15 06:21:56'),
(72, 'Buffalo', 'Buffalo', 1987.00, 85, 1843.00, '2023-05-31 16:00:00', '2023-11-15 06:21:56'),
(73, 'Products', 'Choco Milk', 100.00, 58, 1931.00, '2023-06-30 16:00:00', '2023-11-15 06:21:56'),
(74, 'Products', 'Fresh Milk', 100.00, 78, 1338.00, '2023-06-30 16:00:00', '2023-11-15 06:21:56'),
(75, 'Products', 'Plain Yoghurt', 50.00, 15, 1182.00, '2023-06-30 16:00:00', '2023-11-15 06:21:56'),
(76, 'Buffalo', 'Buffalo', 1406.00, 49, 1544.00, '2023-06-30 16:00:00', '2023-11-15 06:21:56'),
(77, 'Products', 'Choco Milk', 100.00, 42, 1694.00, '2023-07-31 16:00:00', '2023-11-15 06:21:56'),
(78, 'Products', 'Fresh Milk', 100.00, 55, 1934.00, '2023-07-31 16:00:00', '2023-11-15 06:21:56'),
(79, 'Products', 'Plain Yoghurt', 50.00, 95, 1567.00, '2023-07-31 16:00:00', '2023-11-15 06:21:56'),
(80, 'Buffalo', 'Buffalo', 3127.00, 67, 1286.00, '2023-07-31 16:00:00', '2023-11-15 06:21:56'),
(81, 'Products', 'Choco Milk', 100.00, 71, 1514.00, '2023-08-31 16:00:00', '2023-11-15 06:21:56'),
(82, 'Products', 'Fresh Milk', 100.00, 25, 1389.00, '2023-08-31 16:00:00', '2023-11-15 06:21:56'),
(83, 'Products', 'Plain Yoghurt', 50.00, 50, 1366.00, '2023-08-31 16:00:00', '2023-11-15 06:21:56'),
(84, 'Buffalo', 'Buffalo', 2159.00, 35, 1358.00, '2023-08-31 16:00:00', '2023-11-15 06:21:56'),
(85, 'Products', 'Choco Milk', 100.00, 12, 1919.00, '2023-09-30 16:00:00', '2023-11-15 06:21:56'),
(86, 'Products', 'Fresh Milk', 100.00, 36, 1914.00, '2023-09-30 16:00:00', '2023-11-15 06:21:56'),
(87, 'Products', 'Plain Yoghurt', 50.00, 58, 1719.00, '2023-09-30 16:00:00', '2023-11-15 06:21:56'),
(88, 'Buffalo', 'Buffalo', 2530.00, 79, 1250.00, '2023-09-30 16:00:00', '2023-11-15 06:21:56'),
(89, 'Products', 'Choco Milk', 100.00, 51, 1955.00, '2023-10-31 16:00:00', '2023-11-15 06:21:56'),
(90, 'Products', 'Fresh Milk', 100.00, 71, 1600.00, '2023-10-31 16:00:00', '2023-11-15 06:21:56'),
(91, 'Products', 'Plain Yoghurt', 50.00, 33, 1516.00, '2023-10-31 16:00:00', '2023-11-15 06:21:56'),
(92, 'Buffalo', 'Buffalo', 1448.00, 82, 1558.00, '2023-10-31 16:00:00', '2023-11-15 06:21:56'),
(93, 'Products', 'Choco Milk', 100.00, 60, 1158.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(94, 'Products', 'Fresh Milk', 100.00, 83, 1665.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(95, 'Products', 'Plain Yoghurt', 50.00, 73, 1763.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(96, 'Buffalo', 'Buffalo', 3381.00, 100, 1935.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(97, 'Products', 'Choco Milk', 100.00, 50, 1500.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(98, 'Buffalo', 'Buffalo', 2300.50, 2, 4601.00, '2023-11-30 16:00:00', '2023-11-15 06:21:56'),
(99, 'Products', 'Choco Milk', 100.00, 25, 2500.00, '2023-10-31 16:00:00', '2023-11-15 06:21:56'),
(100, 'Buffalo', 'Buffalo', 1800.25, 1, 1800.25, '2023-10-31 16:00:00', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_code_count` int(11) DEFAULT 0,
  `email_code_cooldown` timestamp NULL DEFAULT NULL,
  `email_verify_token` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `reset_password` tinyint(1) DEFAULT 0,
  `reset_password_count` int(11) DEFAULT 0,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_cooldown` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `password`, `email_code_count`, `email_code_cooldown`, `email_verify_token`, `email_verified_at`, `reset_password`, `reset_password_count`, `reset_password_token`, `reset_password_cooldown`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Christian Jay', 'Jacalne', 'sample@gmail.com', '9262189071', '$2y$10$bxgKkeBmCA6.CUJwH2As8ebvkyzYpPlcQR0Y83idTi3LIX8uaB1xy', 0, NULL, NULL, '2023-11-15 06:21:56', 0, 0, NULL, NULL, NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'Laarni', 'Lalic', 'myasd@gmail.com', '9972654851', '$2y$10$VooHOIB0awKgvs1yKZcxvOJWFh/ZtT2XU8qrVscv0.piVkhRHvj2i', 0, NULL, NULL, '2023-11-15 06:21:56', 0, 0, NULL, NULL, NULL, '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `region` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL DEFAULT 'home',
  `zip_code` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `region`, `province`, `municipality`, `barangay`, `street`, `label`, `zip_code`, `default`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'REGION IV-A', 'CAVITE', 'TANZA', 'JULUGAN VIII', 'Sta. Cecilia 2', 'home', 4108, 1, 'This is my remark', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 2, 'REGION IV-A', 'CAVITE', 'BACOOR CITY', 'ALIMA', 'street 22221', 'home', 4109, 1, 'This is my remark', '2023-11-15 06:21:56', '2023-11-15 06:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yogurt', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(2, 'Pastillas', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(3, 'Milk', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(4, 'Jelly', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(5, 'Frozen Dessert', '2023-11-15 06:21:56', '2023-11-15 06:21:56'),
(6, 'Cheese', '2023-11-15 06:21:56', '2023-11-15 06:21:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`),
  ADD UNIQUE KEY `admin_unique_id_unique` (`unique_id`);

--
-- Indexes for table `buffalo`
--
ALTER TABLE `buffalo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buffalo_sales`
--
ALTER TABLE `buffalo_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_fee`
--
ALTER TABLE `delivery_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guest_cart`
--
ALTER TABLE `guest_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_order`
--
ALTER TABLE `guest_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_order_mobile_number_unique` (`mobile_number`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_sales`
--
ALTER TABLE `milk_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_stock`
--
ALTER TABLE `milk_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_shoppers`
--
ALTER TABLE `online_shoppers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `online_shoppers_user_id_unique` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_resets_admin`
--
ALTER TABLE `password_resets_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_admin_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_reciept`
--
ALTER TABLE `payment_reciept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `retailers`
--
ALTER TABLE `retailers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_email_verify_token_unique` (`email_verify_token`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buffalo`
--
ALTER TABLE `buffalo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buffalo_sales`
--
ALTER TABLE `buffalo_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_fee`
--
ALTER TABLE `delivery_fee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_cart`
--
ALTER TABLE `guest_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_order`
--
ALTER TABLE `guest_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_users`
--
ALTER TABLE `guest_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=452;

--
-- AUTO_INCREMENT for table `milk_sales`
--
ALTER TABLE `milk_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_stock`
--
ALTER TABLE `milk_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_shoppers`
--
ALTER TABLE `online_shoppers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `password_resets_admin`
--
ALTER TABLE `password_resets_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_reciept`
--
ALTER TABLE `payment_reciept`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retailers`
--
ALTER TABLE `retailers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
