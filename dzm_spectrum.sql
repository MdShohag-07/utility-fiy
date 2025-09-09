-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2025 at 04:10 AM
-- Server version: 8.0.42
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dzm_spectrum`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE `menu_links` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `order` int NOT NULL DEFAULT '0',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'header',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_links`
--

INSERT INTO `menu_links` (`id`, `title`, `url`, `target`, `order`, `location`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'http://127.0.0.1:8000/', '_self', 0, 'header', 'fas fa-home', '2025-05-12 03:50:43', '2025-05-12 03:50:43'),
(2, 'Test', 'http://127.0.0.1:8000/', '_self', 0, 'header', NULL, '2025-05-12 04:43:52', '2025-05-12 04:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_20_202853_add_role_to_users_table', 1),
(5, '2025_04_21_121812_add_username_to_users_table', 1),
(6, '2025_04_22_093604_create_menu_links_table', 1),
(7, '2025_04_22_093801_create_settings_table', 1),
(8, '2025_04_26_163555_create_personal_access_tokens_table', 1),
(9, '2025_05_06_184924_add_icon_to_menu_links_table', 1),
(10, '2025_05_12_050000_create_statements_table', 1),
(11, '2025_05_12_055017_add_statement_date_to_statements_table', 1),
(12, '2025_05_12_064252_create_statement_items_table', 1),
(13, '2025_05_12_064343_update_statements_table_for_dynamic_generation', 1),
(14, '2025_05_12_064400_add_billing_details_to_users_table', 1),
(15, '2025_05_12_064532_add_billing_and_profile_details_to_users_table', 1),
(16, '2025_05_12_074159_make_file_path_nullable_on_statements_table', 1),
(17, '2025_05_12_074439_remove_file_path_and_original_name_from_statements_table', 1),
(18, '2025_05_12_083728_add_paid_at_to_statements_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hp_hero_headline', 'test', '2025-05-12 03:52:12', '2025-05-12 03:52:36'),
(2, 'hp_hero_subheadline', 'test', '2025-05-12 03:52:12', '2025-05-12 03:52:36'),
(3, 'hp_hero_button_text', 'Learn Moree', '2025-05-12 03:52:12', '2025-05-12 03:52:36'),
(4, 'hp_hero_button_url', 'https://dribbble.com/codezisoft1612', '2025-05-12 03:52:12', '2025-05-12 03:52:36'),
(5, 'hp_hero_image', 'homepage/hero/hero/29z5OiKYWfeLbrQeshDNuIYFmnZHiLBvr4EKKMHe.png', '2025-05-12 03:52:12', '2025-05-12 03:52:36'),
(6, 'hp_account_headline', 'Your Account at Your Fingertips', '2025-05-12 03:52:57', '2025-05-12 04:26:39'),
(7, 'hp_account_subtext', 'Sign in for the easiest way to pay your bill, manage your account, watch TV anywhere and more.', '2025-05-12 03:52:57', '2025-05-12 04:40:11'),
(8, 'hp_account_create_text', 'Create a Username', '2025-05-12 03:52:57', '2025-05-12 04:40:11'),
(9, 'hp_account_create_url', NULL, '2025-05-12 03:52:57', '2025-05-12 03:52:57'),
(10, 'hp_account_signin_text', 'Sign In', '2025-05-12 03:52:57', '2025-05-12 04:40:11'),
(11, 'hp_account_notcustomer_text', 'Not a Spectrum Customer?', '2025-05-12 03:52:57', '2025-05-12 04:40:11'),
(12, 'hp_account_getstarted_text', 'Get Started', '2025-05-12 03:52:57', '2025-05-12 04:40:11'),
(13, 'hp_account_getstarted_url', NULL, '2025-05-12 03:52:57', '2025-05-12 03:52:57'),
(14, 'hp_account_image', 'homepage/account/screenshot-2025-05-09-103235-1747045537.png', '2025-05-12 03:52:57', '2025-05-12 04:55:37'),
(15, 'site_logo', 'settings/logos/site_logo.png', '2025-05-12 03:53:56', '2025-05-12 04:25:19'),
(16, 'header_bg_color', '#FFFFFF', '2025-05-12 03:53:56', '2025-05-12 03:53:56'),
(17, 'hp_internet_headline', 'Reliably Fast Internet. Incredible Savings.', '2025-05-12 04:27:01', '2025-05-12 04:32:08'),
(18, 'hp_internet_subtext', 'Switch to Spectrum for the fastest, most reliable Internet. Add Spectrum Mobile® to enjoy seamless connectivity wherever you go.', '2025-05-12 04:27:01', '2025-05-12 04:33:19'),
(19, 'hp_internet_button_text', 'See My Dealss', '2025-05-12 04:27:01', '2025-05-12 04:33:26'),
(20, 'hp_internet_button_url', 'http://127.0.0.1:8000/', '2025-05-12 04:27:01', '2025-05-12 04:33:19'),
(21, 'hp_internet_disclaimer', NULL, '2025-05-12 04:27:01', '2025-05-12 04:27:01'),
(22, 'hp_internet_bg_image', 'homepage/internet/screenshot-2025-05-10-125733-1747044043.png', '2025-05-12 04:27:01', '2025-05-12 04:30:43'),
(23, 'pdf_important_news_title1', 'IMPORTANT NEWSs', '2025-05-13 03:46:03', '2025-05-13 03:46:10'),
(24, 'pdf_important_news_text1', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(25, 'pdf_important_news_title2', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(26, 'pdf_important_news_text2', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(27, 'pdf_unlimited_calling_title', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(28, 'pdf_unlimited_calling_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(29, 'pdf_return_address_warning_brand', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(30, 'pdf_return_address_warning_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(31, 'pdf_payment_recipient_name', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(32, 'pdf_autopay_url_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(33, 'pdf_autopay_url_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(34, 'pdf_online_billing_url_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(35, 'pdf_online_billing_url_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(36, 'pdf_paperless_url_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(37, 'pdf_paperless_url_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(38, 'pdf_phone_payment_number_tel', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(39, 'pdf_phone_payment_number_display', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(40, 'pdf_store_address_line1', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(41, 'pdf_store_address_line2', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(42, 'pdf_store_hours_display', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(43, 'pdf_store_locator_url_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(44, 'pdf_store_locator_url_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(45, 'pdf_support_url_billing_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(46, 'pdf_support_url_billing_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(47, 'pdf_support_phone_main', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(48, 'pdf_support_url_moving_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(49, 'pdf_support_url_moving_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(50, 'pdf_support_phone_moving', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(51, 'pdf_faq_billing_cycle', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(52, 'pdf_faq_insufficient_funds', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(53, 'pdf_faq_disagree_charge', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(54, 'pdf_faq_service_interruption', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(55, 'pdf_terms_url_link', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(56, 'pdf_terms_url_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(57, 'pdf_desc_taxes_fees', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(58, 'pdf_desc_terms_conditions', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(59, 'pdf_desc_insufficient_funds', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(60, 'pdf_legal_programming_changes', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(61, 'pdf_legal_recording_video', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(62, 'pdf_legal_spectrum_terms', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(63, 'pdf_legal_security_center', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(64, 'pdf_legal_billing_practices', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(65, 'pdf_legal_late_fee', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(66, 'pdf_legal_complaint_procedures', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(67, 'pdf_legal_closed_captioning', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(68, 'pdf_closed_caption_phone', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(69, 'pdf_closed_caption_email_addr', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(70, 'pdf_closed_caption_email_text', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(71, 'pdf_closed_caption_complaint_instructions_para1', '', '2025-05-13 03:46:03', '2025-05-13 03:46:03'),
(72, 'security_code_placeholder', 'XXXX', '2025-05-13 03:46:03', '2025-05-13 03:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `statements`
--

CREATE TABLE `statements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `statement_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statement_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'issued',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statements`
--

INSERT INTO `statements` (`id`, `user_id`, `statement_number`, `statement_date`, `due_date`, `total_amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(2, 3, 'STMT-20250507-FKJU', '2025-05-07', '2025-05-27', 50.00, 'issued', NULL, '2025-05-13 01:16:03', '2025-05-13 01:16:03'),
(3, 12, 'STMT-20250602-W2GI', '2025-06-02', '2025-07-01', 80.00, 'issued', NULL, '2025-06-17 21:49:24', '2025-06-17 21:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `statement_items`
--

CREATE TABLE `statement_items` (
  `id` bigint UNSIGNED NOT NULL,
  `statement_id` bigint UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statement_items`
--

INSERT INTO `statement_items` (`id`, `statement_id`, `description`, `quantity`, `unit_price`, `amount`, `created_at`, `updated_at`) VALUES
(2, 2, 'test', 1, 50.00, 50.00, '2025-05-13 01:16:03', '2025-05-13 01:16:03'),
(3, 3, 'Internet', 1, 65.00, 65.00, '2025-06-17 21:49:24', '2025-06-17 21:49:24'),
(4, 3, 'Streaming Plus Package', 1, 15.00, 15.00, '2025-06-17 21:49:24', '2025-06-17 21:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `secondary_first_name`, `secondary_last_name`, `username`, `email`, `role`, `email_verified_at`, `password`, `address`, `city`, `state`, `zip_code`, `phone_number`, `account_number`, `service_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'User', NULL, NULL, 'testuser', 'test@example.com', 'user', '2025-05-12 02:31:18', '$2y$12$VyG3FlNCipztxzqmak1NcuoRLZvBYz2HwyECbumJ68JcgckZry3uW', '5982 Lonnie Inlet Suite 553', 'Norrisberg', 'LA', '70950', '(731) 906-5467', 'ACC9874218', 'Internet Only', 'CYX8CNsS6A', '2025-05-12 02:31:18', '2025-05-12 02:31:18'),
(2, 'Admin', 'User', 'Ted', 'Spinka', 'adminuser', 'admin@example.com', 'admin', '2025-05-12 02:31:19', '$2y$12$ua4vMRyWQDQTEigaHES7JeHqIqmA.KGXsIJ9YS1mmjFCx3mn4bT1G', '1349 Clement Stream Apt. 061', 'Sashahaven', 'NJ', '98520', '+1-341-768-0514', 'ACC9223340', 'Full Package', 'vBUkna9xbCX4v5PHoyhGmPQmVEs7wMH6upTgk9odrQ8yyvrCfiIex1OYc3Un', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(3, 'Ova', 'Stanton', 'Phyllis', 'Waters', 'ovastanton192', 'tillman.houston@example.com', 'user', '2025-05-12 02:31:19', '$2y$12$/IEJiYmNgWM0DG2X3HnQ6.AvV9wnrNJQHcJt8q7ZWM5mdxlJPqKh2', '2279 Toy Grove Apt. 107', 'Jamarcusview', 'WA', '92390-8411', '+1 (352) 517-4574', 'ACC6071581', 'Full Package', 'LAFvQBjigNsRtQClCbVhfhz5bmuggz4KlY3UkH1TJJ7jBsUgpDo0QLeBPsTq', '2025-05-12 02:31:19', '2025-05-12 02:36:06'),
(4, 'Herminia', 'Welch', 'Tina', 'Ebert', 'herminiawelch466', 'shanahan.dulce@example.net', 'user', '2025-05-12 02:31:19', '$2y$12$oJqoELYc481fXk.IjoFY8OGB.AkMtaV7c7011sbx7pMy7gFPRDKbS', '265 Hermann Skyway Apt. 965', 'Lowestad', 'GA', '37723', '+1-408-884-9245', 'ACC5882826', 'Full Package', 'gJUwmY5oPc', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(5, 'Thomas', 'Greenholt', 'Sonya', 'Sawayn', 'thomasgreenholt839', 'wbrakus@example.net', 'user', '2025-05-12 02:31:19', '$2y$12$oJqoELYc481fXk.IjoFY8OGB.AkMtaV7c7011sbx7pMy7gFPRDKbS', '513 Schaden Port', 'West Layne', 'WI', '53238-7905', '(779) 823-0719', 'ACC4459740', 'Internet + TV', '2YP7X2Xd5o', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(6, 'Brain', 'Kessler', NULL, NULL, 'brainkessler939', 'lisette.nolan@example.com', 'user', '2025-05-12 02:31:19', '$2y$12$oJqoELYc481fXk.IjoFY8OGB.AkMtaV7c7011sbx7pMy7gFPRDKbS', '2926 McClure Parks', 'Daynafort', 'MO', '45278-3335', '1-585-463-9909', 'ACC3654948', 'Full Package', 'lImqaAhgBa', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(7, 'Lola', 'Koelpin', 'Gust', 'Zulauf', 'lolakoelpin916', 'pgreenfelder@example.net', 'user', '2025-05-12 02:31:19', '$2y$12$oJqoELYc481fXk.IjoFY8OGB.AkMtaV7c7011sbx7pMy7gFPRDKbS', '88799 Alfredo Route', 'Gorczanyfort', 'TX', '66741', '(478) 377-7519', 'ACC0843756', 'Internet Only', '3AWnX2f49xEasZIzNEFQLP5ED3uxUPoHMUk0IhgHXAMXKnAZRTE1EUkNfxP5', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(10, 'Admin1', 'User1', 'Ted1', 'Spinka1', 'adminuser1', 'gehlotravindra@gmail.com', 'admin', '2025-05-12 02:31:19', '$2y$10$yUqgbzoUQ4a9kMZG7m8hWuT.YiSKIm7jXtUasvWEnE8OfFgS1Y9qG', '1349 Clement Stream Apt. 061', 'Sashahaven', 'NJ', '98520', '+1-341-768-0514', 'ACC9223341', 'Full Package', 'vBUkna9xbCX4v5PHoyhGmPQmVEs7wMH6upTgk9odrQ8yyvrCfiIex1OYc3Un', '2025-05-12 02:31:19', '2025-05-12 02:31:19'),
(11, 'The', 'User', NULL, NULL, 'theuser', 'the@user.com', 'admin', '2025-06-17 06:29:13', '$2y$12$iMP0UUtQCNjisHIkOEIj0ewJkpeLXvtnym9ZsbgHapfewnXIgSDpO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 06:29:13', '2025-06-17 06:29:13'),
(12, 'Dale', 'Earnhardt', NULL, NULL, 'dale@earn.com', 'dale@earn.com', 'user', '2025-06-17 21:48:09', '$2y$12$SsPq4gfhoVMjkiRNDxBKlebX/dK6NETB6dTvPuSKGLKXIbC3T/NVe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 21:48:09', '2025-06-17 21:48:09'),
(13, 'TempAdmin', 'Temp', NULL, NULL, 'TempAdmin', 'tempadmin@admin.com', 'admin', '2025-06-18 04:04:53', '$2y$12$6e0pj8lrzdZ4C7dc6HtKA.uOjnJ.pc6CS9Ip6BBPovJx0lgD6AzxW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-18 04:04:53', '2025-06-18 04:04:53');

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
-- Indexes for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `statements`
--
ALTER TABLE `statements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statements_statement_number_unique` (`statement_number`),
  ADD KEY `statements_user_id_foreign` (`user_id`);

--
-- Indexes for table `statement_items`
--
ALTER TABLE `statement_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statement_items_statement_id_foreign` (`statement_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_account_number_unique` (`account_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `statements`
--
ALTER TABLE `statements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statement_items`
--
ALTER TABLE `statement_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `statements`
--
ALTER TABLE `statements`
  ADD CONSTRAINT `statements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statement_items`
--
ALTER TABLE `statement_items`
  ADD CONSTRAINT `statement_items_statement_id_foreign` FOREIGN KEY (`statement_id`) REFERENCES `statements` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
