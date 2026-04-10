-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.44 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para db_plastiqueria
CREATE DATABASE IF NOT EXISTS `db_plastiqueria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_plastiqueria`;

-- Volcando estructura para tabla db_plastiqueria.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.cache: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.categories: ~6 rows (aproximadamente)
INSERT INTO `categories` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
	(1, 'Bolsas de Polietileno', NULL, NULL),
	(2, 'Envases Descartables', NULL, NULL),
	(3, 'Baldes y Tachos', '2026-03-03 08:41:16', '2026-03-03 08:41:16'),
	(4, 'Limpieza', '2026-03-03 08:41:20', '2026-03-03 08:41:20'),
	(5, 'Cajas Organizadoras', '2026-03-03 08:41:30', '2026-03-03 08:41:30'),
	(7, 'Jardinería', '2026-03-03 08:41:57', '2026-03-03 08:41:57');

-- Volcando estructura para tabla db_plastiqueria.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.customers: ~1 rows (aproximadamente)
INSERT INTO `customers` (`id`, `nombre`, `dni`, `created_at`, `updated_at`) VALUES
	(1, 'Público General', '00000000', NULL, NULL);

-- Volcando estructura para tabla db_plastiqueria.detalle_ventas
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `venta_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  KEY `detalle_ventas_product_id_foreign` (`product_id`),
  CONSTRAINT `detalle_ventas_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.detalle_ventas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.job_batches: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.migrations: ~13 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_06_24_150237_add_two_factor_columns_to_users_table', 1),
	(5, '2024_06_24_150308_create_personal_access_tokens_table', 1),
	(6, '2024_06_24_151540_create_personals_table', 1),
	(7, '2024_06_24_183920_create_categories_table', 1),
	(8, '2024_06_24_184430_create_customers_table', 1),
	(9, '2024_06_29_063940_create_products_table', 1),
	(10, '2026_03_02_183941_create_sales_table', 1),
	(11, '2026_03_02_183957_create_sale_datails_table', 1),
	(12, '2026_03_03_033417_create_ventas_table', 1),
	(13, '2026_03_03_033435_create_detalle_ventas_table', 1);

-- Volcando estructura para tabla db_plastiqueria.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.personals
CREATE TABLE IF NOT EXISTS `personals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.personals: ~2 rows (aproximadamente)
INSERT INTO `personals` (`id`, `name`, `dni`, `created_at`, `updated_at`) VALUES
	(1, 'Luis Admin', '77777777', NULL, NULL),
	(2, 'Angelo Poma', '87654321', '2026-03-03 20:29:42', '2026-03-03 20:29:42');

-- Volcando estructura para tabla db_plastiqueria.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla db_plastiqueria.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `stock` int NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.products: ~19 rows (aproximadamente)
INSERT INTO `products` (`id`, `nombre`, `precio`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
	(1, 'Bolsa Negra 14x20 (Millar)', 15.00, 89, 1, NULL, '2026-03-04 05:14:58'),
	(2, 'Film Stretch 20"', 25.00, 12, 1, NULL, '2026-03-04 05:14:58'),
	(3, 'Balde plástico 10L', 10.00, 0, 3, '2026-03-03 08:43:38', '2026-03-03 22:41:20'),
	(4, 'Balde reforzado 20L', 20.00, 7, 3, '2026-03-03 08:44:02', '2026-03-04 05:14:58'),
	(5, 'Tacho de basura con tapa 30L', 50.00, 0, 3, '2026-03-03 08:44:18', '2026-03-03 08:44:18'),
	(6, 'Tacho pedal 50L', 45.00, 6, 3, '2026-03-03 08:44:41', '2026-03-04 04:16:37'),
	(7, 'Balde multiuso industrial', 60.00, 12, 3, '2026-03-03 08:45:02', '2026-03-03 08:45:02'),
	(8, 'Escoba plástica', 10.00, 49, 4, '2026-03-03 08:45:31', '2026-03-04 05:14:58'),
	(9, 'Recogedor con mango', 5.00, 19, 4, '2026-03-03 08:45:58', '2026-03-04 05:14:58'),
	(10, 'Balde exprimidor', 15.00, 14, 4, '2026-03-03 08:46:10', '2026-03-04 05:14:58'),
	(11, 'Cepillo multiuso', 15.00, 15, 4, '2026-03-03 08:46:22', '2026-03-03 08:46:22'),
	(12, 'Maceta 20cm', 15.00, 20, 7, '2026-03-03 08:46:57', '2026-03-03 08:46:57'),
	(13, 'Maceta colgante', 25.00, 7, 7, '2026-03-03 08:47:21', '2026-03-03 08:47:21'),
	(14, 'Regadera 5L', 32.00, 8, 7, '2026-03-03 08:47:37', '2026-03-03 08:47:37'),
	(15, 'Bandeja para plantas', 33.00, 0, 7, '2026-03-03 08:47:57', '2026-03-03 08:47:57'),
	(16, 'Caja organizadora transparente 15L', 31.00, 9, 5, '2026-03-03 08:48:41', '2026-03-03 08:48:41'),
	(17, 'Caja organizadora 40L con ruedas', 33.00, 6, 5, '2026-03-03 08:48:54', '2026-03-03 08:48:54'),
	(18, 'Caja con tapa hermética', 35.00, 10, 5, '2026-03-03 08:49:13', '2026-03-03 08:49:13'),
	(19, 'Organizador tipo gaveta 3 niveles', 45.00, 12, 5, '2026-03-03 08:49:34', '2026-03-03 08:49:34');

-- Volcando estructura para tabla db_plastiqueria.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned DEFAULT NULL,
  `personal_id` bigint unsigned NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  KEY `sales_personal_id_foreign` (`personal_id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.sales: ~11 rows (aproximadamente)
INSERT INTO `sales` (`id`, `customer_id`, `personal_id`, `total`, `metodo_pago`, `created_at`, `updated_at`) VALUES
	(3, NULL, 2, 105.00, 'efectivo', '2026-03-03 22:38:26', '2026-03-03 22:38:26'),
	(4, NULL, 2, 85.00, 'efectivo', '2026-03-03 22:41:20', '2026-03-03 22:41:20'),
	(5, NULL, 2, 50.00, 'efectivo', '2026-03-03 22:50:02', '2026-03-03 22:50:02'),
	(6, NULL, 2, 55.00, 'efectivo', '2026-03-03 22:51:45', '2026-03-03 22:51:45'),
	(7, NULL, 2, 30.00, 'efectivo', '2026-03-03 22:52:28', '2026-03-03 22:52:28'),
	(8, NULL, 2, 55.00, 'efectivo', '2026-03-03 22:55:40', '2026-03-03 22:55:40'),
	(9, NULL, 2, 45.00, 'efectivo', '2026-03-04 04:03:53', '2026-03-04 04:03:53'),
	(10, NULL, 2, 45.00, 'efectivo', '2026-03-04 04:03:54', '2026-03-04 04:03:54'),
	(11, NULL, 2, 85.00, 'efectivo', '2026-03-04 04:16:37', '2026-03-04 04:16:37'),
	(12, NULL, 2, 40.00, 'efectivo', '2026-03-04 05:11:15', '2026-03-04 05:11:15'),
	(13, NULL, 2, 90.00, 'efectivo', '2026-03-04 05:14:58', '2026-03-04 05:14:58');

-- Volcando estructura para tabla db_plastiqueria.sale_datails
CREATE TABLE IF NOT EXISTS `sale_datails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_datails_sale_id_foreign` (`sale_id`),
  KEY `sale_datails_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_datails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sale_datails_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.sale_datails: ~23 rows (aproximadamente)
INSERT INTO `sale_datails` (`id`, `sale_id`, `product_id`, `cantidad`, `precio_unitario`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 3, 15.00, '2026-03-03 22:38:26', '2026-03-03 22:38:26'),
	(2, 3, 2, 2, 25.00, '2026-03-03 22:38:26', '2026-03-03 22:38:26'),
	(3, 3, 3, 1, 10.00, '2026-03-03 22:38:26', '2026-03-03 22:38:26'),
	(4, 4, 3, 4, 10.00, '2026-03-03 22:41:20', '2026-03-03 22:41:20'),
	(5, 4, 6, 1, 45.00, '2026-03-03 22:41:20', '2026-03-03 22:41:20'),
	(6, 5, 2, 2, 25.00, '2026-03-03 22:50:02', '2026-03-03 22:50:02'),
	(7, 6, 1, 2, 15.00, '2026-03-03 22:51:45', '2026-03-03 22:51:45'),
	(8, 6, 2, 1, 25.00, '2026-03-03 22:51:45', '2026-03-03 22:51:45'),
	(9, 7, 1, 2, 15.00, '2026-03-03 22:52:28', '2026-03-03 22:52:28'),
	(10, 8, 1, 2, 15.00, '2026-03-03 22:55:40', '2026-03-03 22:55:40'),
	(11, 8, 2, 1, 25.00, '2026-03-03 22:55:40', '2026-03-03 22:55:40'),
	(12, 9, 6, 1, 45.00, '2026-03-04 04:03:53', '2026-03-04 04:03:53'),
	(13, 10, 6, 1, 45.00, '2026-03-04 04:03:54', '2026-03-04 04:03:54'),
	(14, 11, 6, 1, 45.00, '2026-03-04 04:16:37', '2026-03-04 04:16:37'),
	(15, 11, 4, 2, 20.00, '2026-03-04 04:16:37', '2026-03-04 04:16:37'),
	(16, 12, 1, 1, 15.00, '2026-03-04 05:11:15', '2026-03-04 05:11:15'),
	(17, 12, 2, 1, 25.00, '2026-03-04 05:11:15', '2026-03-04 05:11:15'),
	(18, 13, 1, 1, 15.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58'),
	(19, 13, 2, 1, 25.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58'),
	(20, 13, 4, 1, 20.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58'),
	(21, 13, 8, 1, 10.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58'),
	(22, 13, 9, 1, 5.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58'),
	(23, 13, 10, 1, 15.00, '2026-03-04 05:14:58', '2026-03-04 05:14:58');

-- Volcando estructura para tabla db_plastiqueria.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.sessions: ~6 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('eGeULyc38GGLAlY3wr3hqFtbZoyxhNKaiQV8NgXc', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUVHalhXbkd2ZVBsQ0h6dXlyVHBXdzB5MmR5c3BhT1hCSnB0UmlYSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3QvcGxhc3RpcXVlcmlhL3B1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772585182),
	('LaGMSYvBZ6HBV0M8vaGleNdSdqURRl5TQ4XP0em6', NULL, '192.168.18.23', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFVNMTBzd2pPNjRZeEwwNWR0cndzd2RRaDc2Smlic3UxWGZpd2NUaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xOTIuMTY4LjE4LjIxL3BsYXN0aXF1ZXJpYS9wdWJsaWMvaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772588115),
	('O0E7LwcEisCclnd1DNqO342RI9kkZ1QSqIEJeCX3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0FnMGg3bUdISlc5RzRnRVBMcWREZGRkUzB4c2VyY1RqaThMaEpXayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3QvcGxhc3RpcXVlcmlhL3B1YmxpYy9saXN0YSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772586020),
	('rPcJ9tkiQ7NmL9ElA7khwB17tpx09VmpxVCvK8nq', NULL, '192.168.18.23', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1NlM3NsbkNIVEoxbzQ0VzRZblZQT1FFb2d4UWtzc05sd05FOTlTZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xOTIuMTY4LjE4LjIxL3BsYXN0aXF1ZXJpYS9wdWJsaWMvdmVudGFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772579800),
	('wUdOjNTqgD0H7X36aHxcBtD4hb3ducCpaEPTvr4v', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakpCYnNZNHZ6UnJuYTJ5aHpTV0hJdHB2SXNHa2N5aElaTU41UnVHUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772636457),
	('YBLivJmVSFGYKClky9NLrcMbSFatbSSNF2Desq0V', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWg4NjlCZXlSQjdCMnNqQzRkam9IWHd4WHlaNUhaNVA3bTBNUjdzYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJzb25hbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772592167);

-- Volcando estructura para tabla db_plastiqueria.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.users: ~1 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'Test User', 'test@example.com', '2026-03-03 08:39:49', '$2y$12$1Qglj0qtCORWajNEkY5SpOYK0ZctaDc6rVeI9seSJtMA5Qkxx2neO', NULL, NULL, NULL, 'XGga8SrvVi', NULL, NULL, '2026-03-03 08:39:49', '2026-03-03 08:39:49');

-- Volcando estructura para tabla db_plastiqueria.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `pago_con` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ventas_numero_ticket_unique` (`numero_ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_plastiqueria.ventas: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
