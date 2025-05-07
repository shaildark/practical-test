-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 01:55 AM
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
-- Database: `zestbrain_practical`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) NOT NULL,
  `iUserId` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `additional_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `iUserId`, `name`, `email`, `phone`, `gender`, `profile_image`, `additional_file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'shailendra', 'shail@gmail.com', 9854124512, 'male', 'upload/1746537224_Shailendra Passport Size Image.jpg', 'upload/1746537224_PHP Task -4 (2) (1) (1).pdf', '2025-05-06 07:43:44', '2025-05-06 07:43:44', NULL),
(2, 1, 'Shailendra', 'shail1@gmail.com', 4578452145, 'male', 'upload/1746543492_Drake-Hotline-Bling.jpg', NULL, '2025-05-06 09:28:12', '2025-05-06 15:14:16', NULL),
(4, 1, 'amit', 'amit@gmail.com', 7845124578, 'male', 'upload/1746564928_Drake-Hotline-Bling.jpg', NULL, '2025-05-06 15:25:28', '2025-05-06 17:47:44', '2025-05-06 17:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `contact_additional_field`
--

CREATE TABLE `contact_additional_field` (
  `id` bigint(20) NOT NULL,
  `iContactId` bigint(20) NOT NULL,
  `type` varchar(100) NOT NULL,
  `value` varchar(150) NOT NULL,
  `iChildContactId` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_additional_field`
--

INSERT INTO `contact_additional_field` (`id`, `iContactId`, `type`, `value`, `iChildContactId`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'phone', '7845124578', 4, '2025-05-06 17:14:44', '2025-05-06 17:16:12', NULL),
(2, 2, 'email', 'amit@gmail.com', 4, '2025-05-06 17:17:32', '2025-05-06 17:17:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_custom_field`
--

CREATE TABLE `contact_custom_field` (
  `id` bigint(20) NOT NULL,
  `iContactId` bigint(20) NOT NULL,
  `iCustomFieldId` bigint(20) NOT NULL,
  `data` text DEFAULT NULL,
  `isMerged` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_custom_field`
--

INSERT INTO `contact_custom_field` (`id`, `iContactId`, `iCustomFieldId`, `data`, `isMerged`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'junagadh', 'no', '2025-05-06 09:28:12', '2025-05-06 15:13:40', NULL),
(2, 2, 2, '2025-05-05', 'no', '2025-05-06 09:28:12', '2025-05-06 15:13:40', NULL),
(3, 2, 3, 'rajkot', 'yes', '2025-05-06 09:28:12', '2025-05-06 17:47:44', NULL),
(4, 2, 4, '365201', 'no', '2025-05-06 09:28:12', '2025-05-06 15:13:40', NULL),
(5, 3, 1, 'Junagadh', 'no', '2025-05-06 10:15:59', '2025-05-06 10:15:59', NULL),
(6, 3, 3, 'Junagadh', 'no', '2025-05-06 10:15:59', '2025-05-06 10:15:59', NULL),
(7, 3, 4, '362001', 'no', '2025-05-06 10:15:59', '2025-05-06 10:15:59', NULL),
(8, 4, 1, NULL, 'no', '2025-05-06 17:25:42', '2025-05-06 17:25:42', NULL),
(9, 4, 2, NULL, 'no', '2025-05-06 17:25:42', '2025-05-06 17:25:42', NULL),
(10, 4, 3, 'rajkot', 'no', '2025-05-06 17:25:42', '2025-05-06 17:25:42', NULL),
(11, 4, 4, NULL, 'no', '2025-05-06 17:25:42', '2025-05-06 17:25:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_merge`
--

CREATE TABLE `contact_merge` (
  `id` bigint(20) NOT NULL,
  `iMasterContactId` bigint(20) NOT NULL,
  `iChildContactId` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_merge`
--

INSERT INTO `contact_merge` (`id`, `iMasterContactId`, `iChildContactId`, `created_at`, `updated_at`) VALUES
(2, 2, 4, '2025-05-06 17:47:44', '2025-05-06 17:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `custom_field`
--

CREATE TABLE `custom_field` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('text','date','number','email') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_field`
--

INSERT INTO `custom_field` (`id`, `name`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Address', 'text', '2025-05-06 08:42:29', '2025-05-06 12:56:09', NULL),
(2, 'Birth Day', 'date', '2025-05-06 08:44:02', '2025-05-06 08:44:02', NULL),
(3, 'City', 'text', '2025-05-06 08:44:18', '2025-05-06 08:44:18', NULL),
(4, 'Pincode', 'number', '2025-05-06 08:44:28', '2025-05-06 08:44:28', NULL),
(6, 'Test 1', 'text', '2025-05-06 13:31:04', '2025-05-06 13:33:13', '2025-05-06 13:33:13'),
(7, 'Test 2', 'date', '2025-05-06 13:31:10', '2025-05-06 13:32:20', '2025-05-06 13:32:20'),
(8, 'Test 1', 'text', '2025-05-06 13:36:11', '2025-05-06 13:37:57', '2025-05-06 13:37:57'),
(9, 'Test 2', 'date', '2025-05-06 13:36:19', '2025-05-06 13:37:54', '2025-05-06 13:37:54'),
(10, 'Test 3', 'date', '2025-05-06 13:36:28', '2025-05-06 13:37:45', '2025-05-06 13:37:45'),
(11, 'Test 5', 'text', '2025-05-06 13:36:36', '2025-05-06 13:36:46', '2025-05-06 13:36:46');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0dSigt8xEIHoPmtiDmlLXiAEyh7vDY6S5UrM48ua', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidE41dFoxWk1vQ3YxcXRMQXhXamc1TDZxaEtEeW1vQVNxMm5yQjFCSSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29udGFjdC8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746575374);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shailendra', 'shail@gmail.com', NULL, '$2y$12$wMR/FRLa5O1LQMkXkJl1FuNkjw7H5Ke/3NPyh1LSJkAcJAxiAd6jC', NULL, '2025-05-06 05:03:37', '2025-05-06 05:03:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_additional_field`
--
ALTER TABLE `contact_additional_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_custom_field`
--
ALTER TABLE `contact_custom_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_merge`
--
ALTER TABLE `contact_merge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field`
--
ALTER TABLE `custom_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_additional_field`
--
ALTER TABLE `contact_additional_field`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_custom_field`
--
ALTER TABLE `contact_custom_field`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact_merge`
--
ALTER TABLE `contact_merge`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_field`
--
ALTER TABLE `custom_field`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
