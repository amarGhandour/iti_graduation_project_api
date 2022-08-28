-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: ecommerce
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `image`       varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categories_name_unique` (`name`),
    UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK
TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories`
VALUES (1, 'Laptops', 'laptops', 'our laptops category', '1661609496.jpg', '2022-08-27 12:11:36',
        '2022-08-27 12:11:36'),
       (2, 'Watches', 'watches', 'our watches category', '1661609567.jpg', '2022-08-27 12:12:47',
        '2022-08-27 12:12:47'),
       (3, 'Headphones', 'headphones', 'our headphones category', '1661609687.jpg', '2022-08-27 12:14:47',
        '2022-08-27 12:14:47'),
       (4, 'Huge sale', 'huge-sale', NULL, NULL, '2022-08-27 12:23:33', '2022-08-27 12:23:33');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `category_product`
--

DROP TABLE IF EXISTS `category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_product`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `category_id` bigint unsigned NOT NULL,
    `product_id`  bigint unsigned NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_product`
--

LOCK
TABLES `category_product` WRITE;
/*!40000 ALTER TABLE `category_product` DISABLE KEYS */;
INSERT INTO `category_product`
VALUES (1, 1, 1, '2022-08-27 12:28:02', '2022-08-27 12:28:02'),
       (2, 1, 2, '2022-08-27 12:30:13', '2022-08-27 12:30:13'),
       (3, 1, 3, '2022-08-27 12:32:58', '2022-08-27 12:32:58'),
       (4, 1, 4, '2022-08-27 12:36:16', '2022-08-27 12:36:16'),
       (5, 2, 5, '2022-08-27 12:37:27', '2022-08-27 12:37:27'),
       (6, 2, 6, '2022-08-27 12:38:34', '2022-08-27 12:38:34'),
       (7, 2, 7, '2022-08-27 12:40:43', '2022-08-27 12:40:43'),
       (8, 2, 8, '2022-08-27 12:41:27', '2022-08-27 12:41:27'),
       (9, 2, 9, '2022-08-27 12:42:42', '2022-08-27 12:42:42'),
       (10, 3, 10, '2022-08-27 12:44:02', '2022-08-27 12:44:02'),
       (11, 3, 11, '2022-08-27 12:44:48', '2022-08-27 12:44:48'),
       (12, 3, 12, '2022-08-27 12:45:55', '2022-08-27 12:45:55');
/*!40000 ALTER TABLE `category_product` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `color_product`
--

DROP TABLE IF EXISTS `color_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `color_product`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `color_id`   bigint unsigned NOT NULL,
    `product_id` bigint unsigned NOT NULL,
    `image`      varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY          `color_product_color_id_foreign` (`color_id`),
    KEY          `color_product_product_id_foreign` (`product_id`),
    CONSTRAINT `color_product_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `color_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_product`
--

LOCK
TABLES `color_product` WRITE;
/*!40000 ALTER TABLE `color_product` DISABLE KEYS */;
INSERT INTO `color_product`
VALUES (1, 1, 1, '1661610482.jpg', '2022-08-27 12:28:02', '2022-08-27 12:28:02'),
       (2, 2, 1, '1661610482.jpg', '2022-08-27 12:28:02', '2022-08-27 12:28:02'),
       (3, 2, 2, '1661610613.jpg', '2022-08-27 12:30:13', '2022-08-27 12:30:13'),
       (4, 2, 3, '1661610778.jpg', '2022-08-27 12:32:58', '2022-08-27 12:32:58'),
       (5, 2, 4, '1661610976.jpeg', '2022-08-27 12:36:16', '2022-08-27 12:36:16'),
       (6, 2, 5, '1661611047.jpg', '2022-08-27 12:37:27', '2022-08-27 12:37:27'),
       (7, 2, 6, '1661611114.jpg', '2022-08-27 12:38:34', '2022-08-27 12:38:34'),
       (8, 2, 7, '1661611243.jpg', '2022-08-27 12:40:43', '2022-08-27 12:40:43'),
       (9, 2, 8, '1661611287.jpg', '2022-08-27 12:41:27', '2022-08-27 12:41:27'),
       (10, 2, 9, '1661611362.jpg', '2022-08-27 12:42:42', '2022-08-27 12:42:42'),
       (11, 2, 10, '1661611442.jpg', '2022-08-27 12:44:02', '2022-08-27 12:44:02'),
       (12, 2, 11, '1661611488.jpg', '2022-08-27 12:44:48', '2022-08-27 12:44:48'),
       (13, 2, 12, '1661611555.jpg', '2022-08-27 12:45:55', '2022-08-27 12:45:55');
/*!40000 ALTER TABLE `color_product` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colors`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `code`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `colors_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK
TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors`
VALUES (1, '#ff0000', '2022-08-27 12:28:02', '2022-08-27 12:28:02'),
       (2, '#ff3440', '2022-08-27 12:28:02', '2022-08-27 12:28:02');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `code`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `value`       int                                              DEFAULT NULL,
    `percent_off` int                                              DEFAULT NULL,
    `valid_date`  datetime                                NOT NULL DEFAULT '2022-08-28 13:57:22',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK
TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons`
VALUES (1, 'ABC123', 'fixed', 3000, NULL, '2022-08-28 13:57:22', NULL, NULL),
       (2, 'DEF567', 'percent', NULL, 15, '2022-08-28 13:57:22', NULL, NULL);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `uuid`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `connection` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `queue`      text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `payload`    longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `exception`  longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `failed_at`  timestamp                               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK
TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations`
(
    `id`        int unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch`     int                                     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK
TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations`
VALUES (1, '2014_10_12_000000_create_users_table', 1),
       (2, '2014_10_12_100000_create_password_resets_table', 1),
       (3, '2019_08_19_000000_create_failed_jobs_table', 1),
       (4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
       (5, '2022_07_23_164827_create_products_table', 1),
       (6, '2022_07_26_151321_create_categories_table', 1),
       (7, '2022_07_26_152132_create_category_product_table', 1),
       (8, '2022_07_26_204149_create_coupons_table', 1),
       (9, '2022_07_27_222635_create_orders_table', 1),
       (10, '2022_07_27_224754_create_order_product_table', 1),
       (11, '2022_08_01_200325_create_permission_tables', 1),
       (12, '2022_08_02_004220_create_sliders_table', 1),
       (13, '2022_08_02_044023_create_colors_table', 1),
       (14, '2022_08_02_044859_create_color_product_table', 1),
       (15, '2022_08_03_234227_create_reviews_table', 1),
       (16, '2022_08_19_010309_add_avatar_to_users_table', 1),
       (17, '2022_08_22_233042_create_shoppingcart_table', 1),
       (18, '2022_08_27_005117_add_info_columns_to_users_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions`
(
    `permission_id` bigint unsigned NOT NULL,
    `model_type`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`      bigint unsigned NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    KEY             `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
    CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK
TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles`
(
    `role_id`    bigint unsigned NOT NULL,
    `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `model_id`   bigint unsigned NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    KEY          `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
    CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK
TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles`
VALUES (1, 'App\\Models\\User', 1),
       (2, 'App\\Models\\User', 2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_product`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `order_id`   bigint unsigned DEFAULT NULL,
    `product_id` bigint unsigned DEFAULT NULL,
    `quantity`   int NOT NULL,
    `price`      int NOT NULL,
    `subtotal`   int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY          `order_product_order_id_foreign` (`order_id`),
    KEY          `order_product_product_id_foreign` (`product_id`),
    CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK
TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders`
(
    `id`                    bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id`               bigint unsigned DEFAULT NULL,
    `billing_email`         varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_name`          varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_address`       varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_city`          varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_province`      varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_postalcode`    varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_phone`         varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_name_on_card`  varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_discount`      int                                     NOT NULL DEFAULT '0',
    `billing_discount_code` varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `billing_subtotal`      int                                     NOT NULL,
    `billing_tax`           int                                     NOT NULL,
    `billing_total`         int                                     NOT NULL,
    `payment_gateway`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'stripe',
    `shipped`               tinyint(1) NOT NULL DEFAULT '0',
    `error`                 varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `created_at`            timestamp NULL DEFAULT NULL,
    `updated_at`            timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY                     `orders_user_id_foreign` (`user_id`),
    CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK
TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets`
(
    `email`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    KEY          `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK
TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK
TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions`
VALUES (1, 'user_management_access', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (2, 'permission_create', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (3, 'permission_edit', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (4, 'permission_show', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (5, 'permission_delete', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (6, 'permission_access', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (7, 'role_create', 'api', '2022-08-27 11:58:21', '2022-08-27 11:58:21'),
       (8, 'role_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (9, 'role_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (10, 'role_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (11, 'role_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (12, 'user_create', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (13, 'user_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (14, 'user_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (15, 'user_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (16, 'user_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (17, 'product_create', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (18, 'product_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (19, 'product_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (20, 'product_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (21, 'product_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (22, 'category_create', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (23, 'category_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (24, 'category_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (25, 'category_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (26, 'category_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (27, 'coupon_create', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (28, 'coupon_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (29, 'coupon_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (30, 'coupon_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (31, 'coupon_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (32, 'order_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (33, 'order_create', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (34, 'order_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (35, 'order_edit', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (36, 'order_delete', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (37, 'review_access', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (38, 'review_show', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (39, 'sliders_management', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (40, 'coupons_management', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (41, 'orders_management', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (42, 'colors_management', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens`
(
    `id`             bigint unsigned NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `tokenable_id`   bigint unsigned NOT NULL,
    `name`           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`          varchar(64) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `abilities`      text COLLATE utf8mb4_unicode_ci,
    `last_used_at`   timestamp NULL DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
    KEY              `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK
TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens`
VALUES (1, 'App\\Models\\User', 1, 'access_token', 'd80a419b227e9486436a3515c965ffd3ef89bed769f53274ef345b708899b939',
        '[\"*\"]', '2022-08-27 12:45:55', '2022-08-27 12:02:36', '2022-08-27 12:45:55'),
       (2, 'App\\Models\\User', 2, 'access_token', 'c1501d8943df9f2c2b700dbab83fd0c92370d870d291919e0492469aef8b6329',
        '[\"*\"]', '2022-08-27 13:02:47', '2022-08-27 13:01:49', '2022-08-27 13:02:47');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `price`       int                                     NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `image`       varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `featured`    tinyint(1) NOT NULL DEFAULT '0',
    `quantity`    int unsigned NOT NULL DEFAULT '10',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `products_name_unique` (`name`),
    UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK
TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products`
VALUES (1, 'Dell Vostro 3510 Laptop 15.6 FHD', 'dell-vostro-3510-laptop-156-fhd', 16200,
        '11th Generation Intel Core i7-1165G7 Processor (12MB Cache, up to 4.7 GHz)\n512GB M.2 PCIe NVMe Solid State Drive; 8GB, 8GBx1, DDR4, 2666MHz\n15.6-inch FHD (1920 x 1080) Anti-glare LED Backlight Non-Touch Narrow Border WVA Display\nWindows 10 Pro Operating System; Intel UHD Graphics with shared graphics memory\nCarbon Black Dell Vostro Laptop with Zipnology Screen Cleaning Cloth Bundle; Non-Backlit Keyboard, English; 720p at 30 fps HD camera, single-integrated microphone; Stereo speakers, 2 W x 2 = 4 W total; 802.11ac 1x1 WiFi and Bluetooth',
        '1661610482.jpg', 1, 10, '2022-08-27 12:28:02', '2022-08-27 12:28:02'),
       (2, 'HP Zbook WorkStation ', 'hp-zbook-workstation-core-i7-4700mq-24ghz-16gb-ram-1tb-128gb-ssd-w7pro-156in',
        16200, 'Brand - HP\nHP Zbook 15 Workstation\nCore i7 4800m 2.7Ghz 16GB Ram DDR3\n2GB VGA Dedicated DDR5 Nvidia',
        '1661610613.jpg', 1, 10, '2022-08-27 12:30:13', '2022-08-27 12:30:13'),
       (3, 'Dell Vostro 3510 laptop ',
        'dell-vostro-3510-laptop-11th-gen-intel-core-i7-1165g7-16gb-ram-1tb-hdd-256gb-ssd-nvidia-geforce-mx350-gddr5-graphics',
        20500,
        'Dell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7, 16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\" FHD (1920 x 1080) An ti-glare LED Narrow Border, Ubuntu - Carbon Black\nGood Quality with a high end\nDell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7, 16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\' FHD (1920 x 1080) Anti-glare,
        Ubuntu -
        Carbon Black\nEasy to use\nPersonal Computer type','1661610778.jpg',1,10,'2022-08-27 12:32:58','2022-08-27 12:32:58'),(4,'Dell Vostro 5555 laptop','dell-vostro-5555-laptop-11th-gen-intel-core-i7-1165g7-34gb-ram-1tb-hdd-256gb-ssd-nvidia-geforce-mx350-gddr5-graphics',25000,'Dell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7,
        16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\" FHD (1920 x 1080) An ti-glare LED Narrow Border, Ubuntu - Carbon Black\nGood Quality with a high end\nDell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7, 16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\' FHD (1920 x 1080) Anti-glare, Ubuntu - Carbon Black\nEasy to use\nPersonal Computer type','1661610976.jpeg',1,10,'2022-08-27 12:36:16','2022-08-27 12:36:16'),(5,'Stainless steel men formal wristwatch ','stainless-steel-men-formal-wristwatch-blak-color-watchhousesonera-2725613738956',150,'Dell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7, 16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\" FHD (1920 x 1080) An ti-glare LED Narrow Border, Ubuntu - Carbon Black\nGood Quality with a high end\nDell Vostro 3510 laptop - 11th Gen Intel core i7-1165G7, 16GB RAM, 1TB HDD + 256GB SSD, Nvidia GeForce MX350 GDDR5 Graphics, 15.6\' FHD (1920 x 1080) Anti-glare, Ubuntu - Carbon Black\nEasy to use\nPersonal Computer type','1661611047.jpg',1,10,'2022-08-27 12:37:27','2022-08-27 12:37:27'),(6,'Analog Watch Metal Strap For Men ','analog-watch-metal-strap-for-men-silver',150,'very fancy watch\n\nit displays date\n\nvery amazing design\n\nit\'s an eye-attractive watch\n\nSilver color','1661611114.jpg',1,10,'2022-08-27 12:38:34','2022-08-27 12:38:34'),(7,'Formula 1 Chronograph Men\'s Watch ','formula-1-chronograph-mens-watch-caz1014ba0842',200,'Formula 1 Chronograph Men\'s Watch CAZ1014.BA0842','1661611243.jpg',1,10,'2022-08-27 12:40:43','2022-08-27 12:40:43'),(8,'Tag Heuer Watches for Women','tag-heuer-watches-for-women',350,'Tag Heuer Watches for Women','1661611287.jpg',1,10,'2022-08-27 12:41:27','2022-08-27 12:41:27'),(9,'GMT-Master II Batman Jubilee Men\'s','gmt-master-ii-batman-jubilee-mens-watch-126710blnr-0002',30000,'GMT-Master II Batman Jubilee Men\'s Watch 126710BLNR-0002','1661611362.jpg',1,10,'2022-08-27 12:42:42','2022-08-27 12:42:42'),(10,'Sony WH-XB910N Wireless NC XB ','sony-wh-xb910n-wireless-nc-xb-headphone',800,'Sony WH-XB910N Wireless NC XB Headphone','1661611442.jpg',1,10,'2022-08-27 12:44:02','2022-08-27 12:44:02'),(11,'Soundcore by Anker','soundcore-by-anker-life-q30-hybrid-active-noise-cancelling-headphones-with-multiple-modes-hi-res-sound-custom-eq-via-app-40h-playtime-comfortable-fit',800,'Soundcore by Anker Life Q30 Hybrid Active Noise Cancelling Headphones with Multiple Modes, Hi-Res Sound, Custom EQ via App, 40H Playtime, Comfortable Fit','1661611488.jpg',1,10,'2022-08-27 12:44:48','2022-08-27 12:44:48'),(12,'Redragon H301 SIREN2 7.1 Virtual Surround Noise Canceling LED Gaming Headse','redragon-h301-siren2-71-virtual-surround-noise-canceling-led-gaming-headse',1200,'Redragon H301 SIREN2 7.1 Virtual Surround Noise Canceling LED Gaming Headse','1661611555.jpg',1,10,'2022-08-27 12:45:55','2022-08-27 12:45:55');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `rating`      int unsigned NOT NULL DEFAULT '0',
    `description` text COLLATE utf8mb4_unicode_ci,
    `user_id`     bigint unsigned NOT NULL,
    `product_id`  bigint unsigned NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY           `reviews_user_id_foreign` (`user_id`),
    KEY           `reviews_product_id_foreign` (`product_id`),
    CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK
TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions`
(
    `permission_id` bigint unsigned NOT NULL,
    `role_id`       bigint unsigned NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    KEY             `role_has_permissions_role_id_foreign` (`role_id`),
    CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK
TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions`
VALUES (19, 2),
       (21, 2),
       (24, 2),
       (26, 2),
       (33, 2),
       (36, 2),
       (37, 2),
       (38, 2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles`
(
    `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK
TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles`
VALUES (1, 'Super Admin', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22'),
       (2, 'User', 'api', '2022-08-27 11:58:22', '2022-08-27 11:58:22');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppingcart`
(
    `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `instance`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `content`    longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`identifier`, `instance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppingcart`
--

LOCK
TABLES `shoppingcart` WRITE;
/*!40000 ALTER TABLE `shoppingcart` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppingcart` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders`
(
    `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
    `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `category_id` bigint unsigned NOT NULL,
    `link`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
    `image`       varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT '0',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `sliders_title_unique` (`title`),
    UNIQUE KEY `sliders_link_unique` (`link`),
    KEY           `sliders_category_id_foreign` (`category_id`),
    CONSTRAINT `sliders_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK
TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders`
VALUES (1, 'Huge sale', 4, 'products?category=Huge sale', 'popular sale from our shop', '1661610213.png', 1,
        '2022-08-27 12:23:33', '2022-08-27 12:23:33');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users`
(
    `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
    `name`              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email`             varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password`          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `avatar`            varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone`             varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `country`           varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `city`              varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `postal_code`       varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `address`           varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `remember_token`    varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK
TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users`
VALUES (1, 'admin', 'admin@admin.com', '2022-08-18 12:17:02',
        '$2y$10$LbkdUjskAgJueZ27u66Og.n9E.2pHEgyAUKorostPjfxjjmJTHnAC', NULL, NULL, NULL, NULL, NULL, NULL, NULL,
        '2022-08-27 11:58:23', '2022-08-27 11:58:23'),
       (2, 'user', 'user@user.com', '2022-08-18 12:17:02',
        '$2y$10$.0wP.Q9BHX1/rm/JuB0zB.gN8b9uyP7p/XTQuqZWg/rzWmsgG/F4i', NULL, NULL, NULL, NULL, NULL, NULL, NULL,
        '2022-08-27 11:58:23', '2022-08-27 11:58:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK
TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-27 17:13:45
