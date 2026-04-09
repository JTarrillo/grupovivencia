-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 09:24 PM
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
-- Database: `grupovivencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `archivos_digitales`
--

CREATE TABLE `archivos_digitales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `nombre_almacenado` varchar(255) NOT NULL,
  `tipo_documento` varchar(50) NOT NULL,
  `tama??o` bigint(20) UNSIGNED NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cliente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activo',
  `hash_archivo` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` enum('0','1') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(9, 'BanBif', '0', '2023-08-11 13:09:35', '2024-03-22 18:09:39'),
(10, 'Banco de Comercio', '0', '2023-08-11 13:09:45', '2023-11-02 17:03:01'),
(11, 'Interbank', '0', '2023-08-11 13:09:54', '2025-07-20 12:18:32'),
(12, 'Citibank', '0', '2023-08-11 13:10:01', '2023-11-02 17:03:22'),
(13, 'BBVA', '1', '2023-08-11 13:10:12', '2025-07-20 12:18:44'),
(14, 'Banco de Crédito (BCP)', '0', '2023-08-11 13:10:19', '2024-06-08 13:41:43'),
(15, 'Scotiabank', '0', '2023-08-12 12:18:53', '2025-07-20 12:19:45'),
(16, 'Banco de la Nación', '0', '2023-08-12 12:19:03', '2025-07-20 12:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `bonuses`
--

CREATE TABLE `bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(5,2) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bonuses`
--

INSERT INTO `bonuses` (`id`, `name`, `percent`, `active`, `created_at`, `updated_at`) VALUES
(0, 'Sin bono', 0.00, '1', '2025-10-28 21:16:43', NULL),
(1, 'Bono de Patrocinio', 35.00, '1', '2023-08-10 21:56:50', NULL),
(2, 'Bono de Liderazgo', 0.00, '1', '2023-08-10 21:57:29', NULL),
(3, 'Sistema', 0.00, '1', '2023-08-10 21:57:54', NULL),
(4, 'Compras', 0.00, '1', '2023-08-11 18:59:13', NULL),
(5, 'Regalía MLM', 30.00, '1', '2023-08-11 18:59:26', NULL),
(6, 'Bono Regalía de compras', 30.00, '1', '2023-08-11 18:59:42', NULL),
(7, 'Bono de Liderazgo.', 0.00, '0', '2023-09-24 13:14:08', NULL),
(8, 'Retiro', 0.00, '1', '2023-12-18 15:00:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `calification`
--

CREATE TABLE `calification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `range_id` bigint(20) UNSIGNED DEFAULT NULL,
  `personal_point` decimal(20,6) DEFAULT NULL,
  `group_point` decimal(20,6) DEFAULT NULL,
  `amount` decimal(20,6) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clasificaciones_compra`
--

CREATE TABLE `clasificaciones_compra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clasificaciones_compra`
--

INSERT INTO `clasificaciones_compra` (`id`, `nombre`, `descripcion`, `codigo`) VALUES
(1, 'Materiales', 'Compra de materiales de construcci??n', 'MAT'),
(2, 'Servicios', 'Servicios profesionales y t??cnicos', 'SRV'),
(3, 'Activos', 'Compra de activos fijos', 'ACT'),
(4, 'Suministros', 'Suministros y consumibles', 'SUM'),
(5, 'Otros', 'Otras compras', 'OTR');

-- --------------------------------------------------------

--
-- Table structure for table `comisiones`
--

CREATE TABLE `comisiones` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `monto_minimo` decimal(15,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comisiones_inmobiliarias`
--

CREATE TABLE `comisiones_inmobiliarias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `venta_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiario_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_comision` enum('bono_reserva','venta_base','nivel_1','nivel_2') NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `estado` enum('pendiente','aprobada','pagada','rechazada') DEFAULT 'pendiente',
  `fecha_generada` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comisiones_inmobiliarias`
--

INSERT INTO `comisiones_inmobiliarias` (`id`, `venta_id`, `beneficiario_id`, `tipo_comision`, `monto`, `porcentaje`, `estado`, `fecha_generada`, `created_at`, `updated_at`) VALUES
(123, 187, 28, 'venta_base', 50.00, 5.00, 'aprobada', '2026-01-03 11:17:20', '2026-01-03 17:17:20', '2026-01-03 17:17:20'),
(124, 190, 28, 'venta_base', 250.00, 5.00, 'aprobada', '2026-03-21 14:55:21', '2026-03-21 19:55:21', '2026-03-21 19:55:21'),
(125, 194, 28, 'venta_base', 1200.00, 5.00, 'aprobada', '2026-03-21 16:40:39', '2026-03-21 21:40:39', '2026-03-21 21:40:39'),
(126, 195, 28, 'venta_base', 1200.00, 5.00, 'aprobada', '2026-03-21 17:16:14', '2026-03-21 22:16:14', '2026-03-21 22:16:14'),
(127, 196, 28, 'venta_base', 1000.00, 5.00, 'aprobada', '2026-03-21 17:31:42', '2026-03-21 22:31:42', '2026-03-21 22:31:42'),
(128, 197, 28, 'venta_base', 1000.00, 5.00, 'aprobada', '2026-03-21 17:53:18', '2026-03-21 22:53:18', '2026-03-21 22:53:18'),
(129, 198, 28, 'venta_base', 1000.00, 5.00, 'aprobada', '2026-03-23 23:18:30', '2026-03-24 04:18:30', '2026-03-24 04:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `phone` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `subject` varchar(250) DEFAULT NULL,
  `comment` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `active` enum('0','1') NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_standby` bigint(20) DEFAULT NULL,
  `customer_waiting` bigint(20) DEFAULT NULL,
  `condition` tinyint(4) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `bonus_id` bigint(20) UNSIGNED NOT NULL,
  `recarge_id` bigint(20) DEFAULT NULL,
  `arrive_id` int(11) NOT NULL,
  `amount` decimal(8,3) NOT NULL,
  `discount` decimal(8,3) NOT NULL,
  `date` datetime NOT NULL,
  `date_shop` datetime DEFAULT NULL,
  `system_discount` int(11) DEFAULT NULL,
  `pass_period` int(11) NOT NULL DEFAULT 0,
  `cd` int(11) NOT NULL DEFAULT 0,
  `payment` int(11) NOT NULL DEFAULT 0,
  `active` enum('0','1','2') NOT NULL DEFAULT '1',
  `total` decimal(8,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commissions`
--

INSERT INTO `commissions` (`id`, `invoice_id`, `customer_id`, `customer_standby`, `customer_waiting`, `condition`, `level`, `bonus_id`, `recarge_id`, `arrive_id`, `amount`, `discount`, `date`, `date_shop`, `system_discount`, `pass_period`, `cd`, `payment`, `active`, `total`, `created_at`, `updated_at`) VALUES
(43, NULL, 3, NULL, NULL, NULL, NULL, 6, NULL, 0, 22.200, 0.000, '2024-12-28 16:43:27', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-28 21:43:27', '2024-12-30 04:53:42'),
(44, NULL, 3, NULL, NULL, NULL, NULL, 5, NULL, 0, 38.976, 0.000, '2024-12-29 22:45:26', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-30 03:45:26', '2024-12-30 04:53:29'),
(45, NULL, 4, NULL, NULL, NULL, NULL, 6, NULL, 0, 22.200, 0.000, '2024-12-29 22:52:18', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-30 03:52:18', '2024-12-30 04:53:01'),
(46, NULL, 4, NULL, NULL, NULL, NULL, 5, NULL, 0, 7.400, 0.000, '2024-12-29 22:52:29', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-30 03:52:29', '2024-12-30 04:52:50'),
(47, NULL, 14, NULL, NULL, NULL, NULL, 6, NULL, 0, 1.800, 0.000, '2024-12-29 23:01:31', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-30 04:01:31', '2024-12-30 05:02:58'),
(48, NULL, 11, NULL, NULL, NULL, NULL, 6, NULL, 0, 14.800, 0.000, '2024-12-29 23:02:13', NULL, 1, 0, 0, 0, '1', 0.000, '2024-12-30 04:02:13', '2024-12-30 05:02:41'),
(87, NULL, 16, NULL, NULL, NULL, NULL, 5, NULL, 0, 100.000, 0.000, '2025-02-01 16:02:11', NULL, 1, 0, 0, 0, '1', 0.000, '2025-02-01 21:02:11', '2025-03-01 05:58:03'),
(93, NULL, 4, NULL, NULL, NULL, NULL, 8, NULL, 0, -151.800, 0.000, '2025-01-31 00:00:00', '2025-02-05 16:26:12', NULL, 0, 0, 0, '2', 0.000, '2025-02-05 21:26:12', NULL),
(97, NULL, 2, NULL, NULL, NULL, NULL, 8, NULL, 0, -723.600, 0.000, '2025-01-15 00:00:00', '2025-02-17 15:39:04', NULL, 0, 0, 0, '2', 0.000, '2025-02-17 20:39:04', NULL),
(119, NULL, 16, NULL, NULL, NULL, NULL, 1, NULL, 0, 600.000, 0.000, '2025-02-27 14:47:44', NULL, 1, 0, 0, 0, '1', 0.000, '2025-02-27 19:47:44', '2025-02-27 20:48:01'),
(134, NULL, 4, NULL, NULL, NULL, NULL, 1, NULL, 0, 600.000, 0.000, '2025-02-28 17:22:01', NULL, 1, 0, 0, 0, '1', 0.000, '2025-02-28 22:22:01', '2025-02-28 23:22:14'),
(173, NULL, 4, NULL, NULL, NULL, NULL, 8, NULL, 0, -644.400, 0.000, '2025-02-28 00:00:00', '2025-03-27 12:05:02', NULL, 0, 0, 0, '2', 0.000, '2025-03-27 17:05:02', NULL),
(202, NULL, 3, NULL, NULL, NULL, NULL, 7, NULL, 0, 500.000, 0.000, '2025-03-31 10:06:20', NULL, 1, 0, 0, 0, '1', 0.000, '2025-04-02 15:06:20', '2025-04-02 15:06:39'),
(205, NULL, 3, NULL, NULL, NULL, NULL, 7, NULL, 0, 500.000, 0.000, '2025-04-05 16:54:28', NULL, 1, 0, 0, 0, '1', 0.000, '2025-04-05 21:54:28', '2025-04-05 22:53:02'),
(246, NULL, 3, NULL, NULL, NULL, NULL, 8, NULL, 0, -1735.000, 0.000, '2025-03-31 00:00:00', '2025-04-11 15:49:00', NULL, 0, 0, 0, '2', 0.000, '2025-04-11 20:49:00', NULL),
(519, NULL, 91, NULL, NULL, NULL, NULL, 7, NULL, 0, 500.000, 0.000, '2025-05-23 14:44:13', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-05-23 19:44:13', NULL),
(877, NULL, 4, NULL, NULL, NULL, NULL, 8, NULL, 0, -990.775, 0.000, '2025-07-31 00:00:00', '2025-08-08 18:38:10', NULL, 0, 0, 0, '2', 0.000, '2025-08-08 23:38:10', NULL),
(878, NULL, 16, NULL, NULL, NULL, NULL, 8, NULL, 0, -1555.650, 0.000, '2025-07-31 00:00:00', '2025-08-08 21:07:56', NULL, 0, 0, 0, '2', 0.000, '2025-08-09 02:07:56', NULL),
(899, NULL, 9, NULL, NULL, NULL, NULL, 8, NULL, 0, -1008.500, 0.000, '2025-07-31 00:00:00', '2025-08-16 12:54:50', NULL, 0, 0, 0, '2', 0.000, '2025-08-16 17:54:50', NULL),
(922, NULL, 43, NULL, NULL, NULL, NULL, 8, NULL, 0, -1614.645, 0.000, '2025-07-31 00:00:00', '2025-08-30 16:53:03', NULL, 0, 0, 0, '2', 0.000, '2025-08-30 21:53:03', NULL),
(973, NULL, 28, NULL, NULL, NULL, NULL, 3, NULL, 0, 150.000, 0.000, '2025-09-13 13:24:16', NULL, 1, 0, 0, 0, '1', 0.000, '2025-09-13 18:24:16', NULL),
(981, NULL, 202, NULL, NULL, NULL, NULL, 0, NULL, 0, 10800.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:24:17', NULL),
(982, NULL, 202, NULL, NULL, NULL, NULL, 0, NULL, 0, 11700.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:39:39', NULL),
(983, NULL, 201, NULL, NULL, NULL, NULL, 0, NULL, 0, 11250.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:41:30', NULL),
(984, NULL, 202, NULL, NULL, NULL, NULL, 0, NULL, 0, 10350.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:45:47', NULL),
(985, NULL, 2, NULL, NULL, NULL, NULL, 0, NULL, 0, 10800.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:47:46', NULL),
(986, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 9900.000, 0.000, '0000-00-00 00:00:00', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 21:57:25', NULL),
(987, NULL, 2, NULL, NULL, NULL, NULL, 0, NULL, 0, 10350.000, 0.000, '2025-10-28 18:25:25', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:25:25', NULL),
(988, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 11700.000, 0.000, '2025-10-28 18:29:31', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:29:31', NULL),
(989, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 11250.000, 0.000, '2025-10-28 18:30:31', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:30:31', NULL),
(990, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 9900.000, 0.000, '2025-10-28 18:38:31', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:38:31', NULL),
(991, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 11700.000, 0.000, '2025-10-28 18:43:10', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:43:10', NULL),
(992, NULL, 91, NULL, NULL, NULL, NULL, 0, NULL, 0, 9000.000, 0.000, '2025-10-28 18:48:07', NULL, NULL, 0, 0, 0, '1', 0.000, '2025-10-28 23:48:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE `compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proveedor_id` bigint(20) UNSIGNED NOT NULL,
  `numero_comprobante` varchar(50) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `fecha_compra` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `igv` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `clasificacion` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'registrado',
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `proyecto_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Proyecto asociado',
  `contrato_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Contrato asociado',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compra_documentos`
--

CREATE TABLE `compra_documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento` varchar(50) NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `ruta_archivo` varchar(512) NOT NULL,
  `tipo_mime` varchar(100) DEFAULT NULL,
  `tamanio` bigint(20) DEFAULT NULL,
  `hash_archivo` varchar(64) DEFAULT NULL,
  `cargado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compra_gastos`
--

CREATE TABLE `compra_gastos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` bigint(20) UNSIGNED NOT NULL,
  `gasto_tipo_id` bigint(20) UNSIGNED NOT NULL,
  `gasto_subcategoria_id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `clasificado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_clasificacion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `concept_tickets`
--

CREATE TABLE `concept_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `concept_tickets`
--

INSERT INTO `concept_tickets` (`id`, `title`, `date`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Productos', '2023-08-18', '1', '2023-08-18 19:34:42', NULL),
(2, 'Datos Personales', '2023-08-18', '1', '2023-08-18 19:34:51', NULL),
(3, 'Comisiones', '2023-08-18', '1', '2023-08-18 19:34:57', NULL),
(4, 'Cobros & Payout', '2023-08-18', '1', '2023-08-18 19:35:06', NULL),
(5, 'Otros Conceptos', '2023-08-18', '1', '2023-08-18 19:35:15', NULL),
(6, 'Backoffice (oficina virtual)', '2024-04-15', '1', '2024-04-15 11:30:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conciliaciones_bancarias`
--

CREATE TABLE `conciliaciones_bancarias` (
  `id` int(11) NOT NULL,
  `cuenta_bancaria_id` int(11) NOT NULL,
  `saldo_sistema` decimal(12,2) NOT NULL,
  `saldo_banco` decimal(12,2) NOT NULL,
  `diferencia` decimal(12,2) NOT NULL,
  `fecha_conciliacion` date NOT NULL,
  `observaciones` text NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lot_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sponsor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_number` varchar(100) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `down_payment` decimal(10,2) NOT NULL,
  `financed_amount` decimal(12,2) NOT NULL,
  `monthly_payment` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `contract_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','completed','cancelled','suspended','rejected') NOT NULL DEFAULT 'active',
  `contract_file` varchar(255) DEFAULT NULL,
  `voucher_url` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `is_rejected` tinyint(1) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `financing_months` int(11) DEFAULT NULL,
  `reservation_amount` decimal(10,2) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `is_reserved` tinyint(1) DEFAULT 0,
  `contract_type` varchar(50) DEFAULT NULL,
  `bonus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_factura_id` int(11) DEFAULT NULL COMMENT 'ID de la boleta/factura en la API',
  `factura_serie_correlativo` varchar(20) DEFAULT NULL COMMENT 'Ej: B001-000002',
  `factura_emitida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `lot_id`, `customer_id`, `sponsor_id`, `payment_plan_id`, `contract_number`, `total_amount`, `down_payment`, `financed_amount`, `monthly_payment`, `interest_rate`, `contract_date`, `start_date`, `end_date`, `status`, `contract_file`, `voucher_url`, `is_approved`, `is_rejected`, `notes`, `created_at`, `updated_at`, `financing_months`, `reservation_amount`, `reservation_date`, `is_reserved`, `contract_type`, `bonus_id`, `api_factura_id`, `factura_serie_correlativo`, `factura_emitida`) VALUES
(188, 176, 208, NULL, 2, 'GV-2026-188', 7080.00, 0.00, 0.00, 0.00, 0.00, '2026-01-08', '0000-00-00', '0000-00-00', '', NULL, NULL, 0, 0, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 24, 1000.00, '2026-01-08', 1, 'arras', NULL, NULL, NULL, 0),
(195, 180, 203, NULL, 2, 'GV-2026-189', 24000.00, 5000.00, 19000.00, 1583.33, 0.00, '2026-03-21', '2026-04-21', '2027-03-21', '', 'uploads/comprobantes/1774131311_405f75ba15fa7b66dbfa.jpg', 'uploads/comprobantes/1774131311_405f75ba15fa7b66dbfa.jpg', 0, 0, NULL, '2026-03-21 22:15:11', '2026-03-21 22:16:14', 12, NULL, NULL, 0, 'inicial', NULL, NULL, NULL, 0),
(196, 172, 203, NULL, 9, 'GV-2026-196', 20000.00, 5000.00, 15000.00, 439.53, 3.50, '2026-03-21', '2026-04-21', '2029-04-21', 'active', NULL, NULL, 0, 0, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 36, 0.00, '0000-00-00', 0, 'arras', NULL, NULL, NULL, 0),
(197, 166, 203, NULL, 9, 'GV-2026-197', 20000.00, 5000.00, 15000.00, 439.53, 3.50, '2026-03-21', '2026-04-21', '2029-04-21', 'active', NULL, NULL, 0, 0, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 36, 0.00, '0000-00-00', 0, 'arras', NULL, NULL, NULL, 0),
(198, 167, 203, NULL, 9, 'GV-2026-198', 20000.00, 5000.00, 15000.00, 439.53, 3.50, '2026-03-23', '2026-04-23', '2029-04-23', 'active', NULL, NULL, 0, 0, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 36, 0.00, '0000-00-00', 0, 'arras', NULL, NULL, NULL, 0),
(199, 177, 203, NULL, 2, 'GV-2026-199', 14400.00, 5000.00, 9400.00, 783.33, 0.00, '2026-03-24', '2026-04-24', '2027-03-24', 'active', 'uploads/comprobantes/1774399036_fa0f9125409db5451916.jpeg', 'uploads/comprobantes/1774399036_fa0f9125409db5451916.jpeg', 0, 0, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 12, NULL, NULL, 0, 'inicial', NULL, NULL, NULL, 0),
(200, 155, 1, NULL, 2, 'GV-2026-200', 20000.00, 5000.00, 15000.00, 1250.00, 0.00, '2026-04-03', '2026-05-03', '2027-04-03', '', 'uploads/comprobantes/1775242680_b5a8f7c5798456e969d1.jpeg', 'uploads/comprobantes/1775242680_b5a8f7c5798456e969d1.jpeg', 0, 0, NULL, '2026-04-03 18:58:00', '2026-04-07 15:44:33', 12, NULL, NULL, 0, 'inicial', NULL, 12, 'B001-000012', 1);

-- --------------------------------------------------------

--
-- Table structure for table `costos_proyecto`
--

CREATE TABLE `costos_proyecto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `tipo_costo` varchar(50) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `compra_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_idioma` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `id_wsp` varchar(10) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL DEFAULT '',
  `x` float(13,10) NOT NULL DEFAULT 0.0000000000,
  `y` float(13,10) NOT NULL DEFAULT 0.0000000000,
  `img` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `id_idioma`, `id_wsp`, `nombre`, `x`, `y`, `img`) VALUES
(1, 2, '61', 'ÐÐ²ÑÑ‚Ñ€Ð°Ð»Ð¸Ñ', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 3, '61', 'Australia', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 5, '61', 'Australien', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 6, '61', 'Australie', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 7, '61', 'Australia', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 8, '61', 'Australia', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 61, '61', 'Austr&aacute;lia', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(1, 79, '61', 'æ¾³å¤§åˆ©äºš', -25.2743988037, 133.7751312256, 'ASTL0001.gif'),
(2, 2, '43', 'ÐÐ²ÑÑ‚Ñ€Ð¸Ñ', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 3, '43', 'Austria', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 5, '43', '&Ouml;sterreich', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 6, '43', 'Autriche', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 7, '43', 'Austria', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 8, '43', 'Austria', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 61, '43', '&Aacute;ustria', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(2, 79, '43', 'å¥¥åœ°åˆ©', 47.5162315369, 14.5500717163, 'AUS0001.gif'),
(3, 2, '994', 'ÐÐ·ÐµÑ€Ð±Ð°Ð¹Ð´Ð¶Ð°Ð½', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 3, '994', 'Azerbaijan', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 5, '994', 'Aserbaidschan', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 6, '994', 'Azerba&iuml;djan', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 7, '994', 'Azerbaiy&aacute;n', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 8, '994', 'Azerbaijan', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 61, '994', 'Azerbaij&atilde;o', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(3, 79, '994', 'é˜¿å¡žæ‹œç–†', 40.1431045532, 47.5769271851, 'ARZE0001.gif'),
(4, 2, '1', 'ÐÐ½Ð³ÑƒÐ¸Ð»ÑŒÑ', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 3, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 5, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 6, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 7, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 8, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 61, '1', 'Anguilla', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(4, 79, '1', 'å®‰åœ­æ‹‰', 18.2205543518, -63.0686149597, 'ANGUI0001.gif'),
(5, 2, '54', 'ÐÑ€Ð³ÐµÐ½Ñ‚Ð¸Ð½Ð°', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 3, '54', 'Argentina', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 5, '54', 'Argentinien', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 6, '54', 'Argentine', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 7, '54', 'Argentina', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 8, '54', 'Argentina', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 61, '54', 'Argentina', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(5, 79, '54', 'é˜¿æ ¹å»·', -38.4160957336, -63.6166725159, 'ARGE0001.gif'),
(6, 2, '374', 'ÐÑ€Ð¼ÐµÐ½Ð¸Ñ', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 3, '374', 'Armenia', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 5, '374', 'Armenien', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 6, '374', 'Arm&eacute;nie', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 7, '374', 'Armenia', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 8, '374', 'Armenia', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 61, '374', 'Arm&ecirc;nia', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(6, 79, '374', 'äºšç¾Žå°¼äºš', 40.0690994263, 45.0381889343, 'ARME0001.gif'),
(7, 2, '375', 'Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 3, '375', 'Belarus', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 5, '375', 'Belarus', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 6, '375', 'Bi&eacute;lorussie', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 7, '375', 'Bielorrusia', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 8, '375', 'Bielorussia', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 61, '375', 'Belarus', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(7, 79, '375', 'ç™½ä¿„ç½—æ–¯', 53.7098083496, 27.9533882141, 'BIELO0001.gif'),
(8, 2, '501', 'Ð‘ÐµÐ»Ð¸Ð·', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 3, '501', 'Belize', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 5, '501', 'Belize', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 6, '501', 'Belize', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 7, '501', 'Belice', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 8, '501', 'Belize', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 61, '501', 'Belize', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(8, 79, '32', 'ä¼¯åˆ©å…¹', 17.1898765564, -88.4976501465, 'BELICE0001.jpg'),
(9, 2, '32', 'Ð‘ÐµÐ»ÑŒÐ³Ð¸Ñ', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 3, '32', 'Belgium', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 5, '32', 'Belgien', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 6, '32', 'Belgique', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 7, '32', 'B&eacute;lgica', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 8, '32', 'Belgio', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 61, '32', 'B&eacute;lgica', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(9, 79, '32', 'æ¯”åˆ©æ—¶', 50.5038871765, 4.4699358940, 'BELG0001.gif'),
(10, 2, '1', 'Ð‘ÐµÑ€Ð¼ÑƒÐ´Ñ‹', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 3, '1', 'Bermuda', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 5, '1', 'Bermuda', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 6, '1', 'Bermudes', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 7, '1', 'Bermudas', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 8, '1', 'Bermuda', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 61, '1', 'Bermudas', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(10, 79, '1', 'ç™¾æ…•å¤§', 32.3213844299, -64.7573699951, 'BERMU0001.gif'),
(11, 2, '359', 'Ð‘Ð¾Ð»Ð³Ð°Ñ€Ð¸Ñ', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 3, '359', 'Bulgaria', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 5, '359', 'Bulgarien', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 6, '359', 'Bulgarie', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 7, '359', 'Bulgaria', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 8, '359', 'Bulgaria', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 61, '359', 'Bulg&aacute;ria', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(11, 79, '359', 'ä¿åŠ åˆ©äºš', 42.7338829041, 25.4858303070, 'BULG0001.gif'),
(12, 2, '55', 'Ð‘Ñ€Ð°Ð·Ð¸Ð»Ð¸Ñ', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 3, '55', 'Brazil', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 5, '55', 'Brasilien', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 6, '55', 'Br&eacute;sil', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 7, '55', 'Brasil', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 8, '55', 'Brasile', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 61, '55', 'Brasil', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(12, 79, '55', 'å·´è¥¿', -14.2350044250, -51.9252815247, 'BRAZ0001.gif'),
(13, 2, '44', 'Ð’ÐµÐ»Ð¸ÐºÐ¾Ð±Ñ€Ð¸Ñ‚Ð°Ð½Ð¸Ñ', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 3, '44', 'United Kingdom', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 5, '44', 'Gro&szlig;britannien', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 6, '44', 'Royaume Uni', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 7, '44', 'Reino Unido', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 8, '44', 'Gran Bretagna', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 61, '44', 'Reino Unido', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(13, 79, '44', 'è‹±å›½', 55.3780517578, -3.4359729290, 'REU0001.gif'),
(14, 2, '36', 'Ð’ÐµÐ½Ð³Ñ€Ð¸Ñ', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 3, '36', 'Hungary', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 5, '36', 'Ungarn', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 6, '36', 'Hongrie', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 7, '36', 'Hungr&iacute;a', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 8, '36', 'Ungaria', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 61, '36', 'Hungria', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(14, 79, '36', 'åŒˆç‰™åˆ©', 47.1624946594, 19.5033035278, 'HUNG0001.gif'),
(15, 2, '84', 'Ð’ÑŒÐµÑ‚Ð½Ð°Ð¼', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 3, '84', 'Vietnam', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 5, '84', 'Vietnam', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 6, '84', 'Vi&ecirc;t-Nam', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 7, '84', 'Vietnam', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 8, '84', 'Vietnam', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 61, '84', 'Vietn&atilde;', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(15, 79, '84', 'è¶Šå—', 14.0583238602, 108.2771987915, 'VIET001.gif'),
(16, 2, '509', 'Ð“Ð°Ð¸Ñ‚Ð¸', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 3, '509', 'Haiti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 5, '509', 'Haiti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 6, '509', 'Ha&iuml;ti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 7, '509', 'Haiti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 8, '509', 'Haiti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 61, '509', 'Haiti', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(16, 79, '509', 'æµ·åœ°', 18.9711875916, -72.2852172852, 'HAITI0001.jpg'),
(17, 2, '590', 'Ð“Ð²Ð°Ð´ÐµÐ»ÑƒÐ¿Ð°', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 3, '590', 'Guadeloupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 5, '590', 'Guadeloupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 6, '590', 'Guadeloupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 7, '590', 'Guadalupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 8, '590', 'Guadalupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 61, '590', 'Guadalupe', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(17, 79, '590', 'ç“œå¾·ç½—æ™®å²›', 16.9959716797, -62.0676422119, 'GUADA001.gif'),
(18, 2, '49', 'Ð“ÐµÑ€Ð¼Ð°Ð½Ð¸Ñ', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 3, '49', 'Germany', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 5, '49', 'Deutschland', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 6, '49', 'Allemagne', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 7, '49', 'Alemania', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 8, '49', 'Germania', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 61, '49', 'Alemanha', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(18, 79, '49', 'å¾·å›½', 51.1656913757, 10.4515256882, 'ALE0001.jpg'),
(19, 2, '31', 'ÐÐ¸Ð´ÐµÑ€Ð»Ð°Ð½Ð´Ñ‹ (Ð“Ð¾Ð»Ð»Ð°Ð½Ð´Ð¸Ñ)', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 3, '31', 'Netherlands', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 5, '31', 'Niederlande', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 6, '31', 'Pays-Bas', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 7, '31', 'Pa&iacute;ses Bajos, Holanda', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 8, '31', 'Paesi Bassi (Olanda)', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 61, '31', 'Pa&iacute;ses Baixos', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(19, 79, '31', 'è·å…°', 52.1326332092, 5.2912659645, 'PBAJOS001.gif'),
(20, 2, '30', 'Ð“Ñ€ÐµÑ†Ð¸Ñ', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 3, '30', 'Greece', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 5, '30', 'Griechenland', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 6, '30', 'Gr&egrave;ce', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 7, '30', 'Grecia', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 8, '30', 'Grecia', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 61, '30', 'Gr&eacute;cia', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(20, 79, '30', 'å¸Œè…Š', 39.0742073059, 21.8243122101, 'GREC0001.gif'),
(21, 2, '995', 'Ð“Ñ€ÑƒÐ·Ð¸Ñ', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 3, '995', 'Georgia', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 5, '995', 'Georgien', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 6, '995', 'G&eacute;orgie', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 7, '995', 'Georgia', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 8, '995', 'Georgia', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 61, '995', 'Ge&oacute;rgia', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(21, 79, '995', 'æ ¼é²å‰äºš', 32.6782073975, -83.1738662720, 'GEORG001.gif'),
(22, 2, '45', 'Ð”Ð°Ð½Ð¸Ñ', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 3, '45', 'Denmark', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 5, '45', 'D&auml;nemark', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 6, '45', 'Danemark', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 7, '45', 'Dinamarca', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 8, '45', 'Danimarca', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 61, '45', 'Dinamarca', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(22, 79, '45', 'ä¸¹éº¦', 56.2639198303, 9.5017852783, 'DINAM001.gif'),
(23, 2, '20', 'Ð•Ð³Ð¸Ð¿ÐµÑ‚', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 3, '20', 'Egypt', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 5, '20', '&Auml;gypten', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 6, '20', 'Egypte', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 7, '20', 'Egipto', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 8, '20', 'Egitto', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 61, '20', 'Egito', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(23, 79, '20', 'åŸƒåŠ', 26.8205528259, 30.8024978638, 'EGYPT001.gif'),
(24, 2, '972', 'Ð˜Ð·Ñ€Ð°Ð¸Ð»ÑŒ', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 3, '972', 'Israel', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 5, '972', 'Israel', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 6, '972', 'Isra&euml;l', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 7, '972', 'Israel', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 8, '972', 'Israele', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 61, '972', 'Israel', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(24, 79, '972', 'ä»¥è‰²åˆ—', 31.0460510254, 34.8516120911, 'ISRA0001.gif'),
(25, 2, '91', 'Ð˜Ð½Ð´Ð¸Ñ', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 3, '91', 'India', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 5, '91', 'Indien', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 6, '91', 'Inde', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 7, '91', 'India', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 8, '91', 'India', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 61, '91', '&Iacute;ndia', 20.5936832428, 78.9628829956, 'IND001.gif'),
(25, 79, '91', 'å°åº¦', 20.5936832428, 78.9628829956, 'IND001.gif'),
(26, 2, '98', 'Ð˜Ñ€Ð°Ð½', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 3, '98', 'Iran', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 5, '98', 'Iran', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 6, '98', 'Iran', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 7, '98', 'Ir&aacute;n', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 8, '98', 'Iran', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 61, '98', 'Ir&atilde;', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(26, 79, '98', 'ä¼Šæœ—', 32.4279098511, 53.6880455017, 'IRAN001.gif'),
(27, 2, '353', 'Ð˜Ñ€Ð»Ð°Ð½Ð´Ð¸Ñ', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 3, '353', 'Ireland', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 5, '353', 'Irland', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 6, '353', 'Irlande', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 7, '353', 'Irlanda', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 8, '353', 'Irlanda', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 61, '353', 'Irlanda', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(27, 79, '353', 'çˆ±å°”å…°', 53.4129104614, -8.2438898087, 'IRLA001.gif'),
(28, 2, '34', 'Ð˜ÑÐ¿Ð°Ð½Ð¸Ñ', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 3, '34', 'Spain', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 5, '34', 'Spanien', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 6, '34', 'Espagne', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 7, '34', 'Espa&ntilde;a', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 8, '34', 'Spagna', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 61, '34', 'Espanha', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(28, 79, '34', 'è¥¿ç­ç‰™', 40.4636688232, -3.7492198944, 'ESPA001.gif'),
(29, 2, '39', 'Ð˜Ñ‚Ð°Ð»Ð¸Ñ', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 3, '39', 'Italy', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 5, '39', 'Italien', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 6, '39', 'Italie', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 7, '39', 'Italia', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 8, '39', 'Italia', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 61, '39', 'It&aacute;lia', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(29, 79, '39', 'æ„å¤§åˆ©', 41.8719406128, 12.5673799515, 'ITAL0001.gif'),
(30, 2, '7', 'ÐšÐ°Ð·Ð°Ñ…ÑÑ‚Ð°Ð½', 48.0195732117, 66.9236831665, NULL),
(30, 3, '7', 'Kazakhstan', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 5, '7', 'Kasachstan', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 6, '7', 'Kazakhstan', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 7, '7', 'Kazajst&aacute;n', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 8, '7', 'Kazakhstan', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 61, '7', 'Casaquist&atilde;o', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(30, 79, '7', 'å“ˆè¨å…‹æ–¯å¦', 48.0195732117, 66.9236831665, 'KAZAK001.gif'),
(31, 2, '237', 'ÐšÐ°Ð¼ÐµÑ€ÑƒÐ½', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 3, '237', 'Cameroon', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 5, '237', 'Kamerun', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 6, '237', 'Cameroun', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 7, '237', 'Camer&uacute;n', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 8, '237', 'Camerun', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 61, '237', 'Rep&uacute;blica dos Camar&otilde;es', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(31, 79, '237', 'å–€éº¦éš†', 7.3697218895, 12.3547220230, 'CAME0001.gif'),
(32, 2, '1', 'ÐšÐ°Ð½Ð°Ð´Ð°', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 3, '1', 'Canada', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 5, '1', 'Kanada', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 6, '1', 'Canada', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 7, '1', 'Canad&aacute;', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 8, '1', 'Canada', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 61, '1', 'Canad&aacute;', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(32, 79, '1', 'åŠ æ‹¿å¤§', 56.1303672791, -106.3467712402, 'CANA0001.gif'),
(33, 2, '357', 'ÐšÐ¸Ð¿Ñ€', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 3, '357', 'Cyprus', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 5, '357', 'Zypern', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 6, '357', 'Chypre', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 7, '357', 'Chipre', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 8, '357', 'Cipro', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 61, '357', 'Chipre', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(33, 79, '357', 'å¡žæµ¦è·¯æ–¯', 35.1264114380, 33.4298591614, 'CHIP001.gif'),
(34, 2, '996', 'ÐšÑ‹Ñ€Ð³Ñ‹Ð·ÑÑ‚Ð°Ð½', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 3, '996', 'Kyrgyzstan', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 5, '996', 'Kirgisistan', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 6, '996', 'Kirghizistan', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 7, '996', 'Kirguist&aacute;n', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 8, '996', 'Kirghizistan', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 61, '996', 'Quirguist&atilde;o', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(34, 79, '996', 'å‰å°”å‰å…‹æ–¯å¦', 41.2043800354, 74.7660980225, 'KIRG001.gif'),
(35, 2, '86', 'ÐšÐ¸Ñ‚Ð°Ð¹', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 3, '86', 'China', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 5, '86', 'China', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 6, '86', 'Chine', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 7, '86', 'China', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 8, '86', 'Cina', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 61, '86', 'China', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(35, 79, '86', 'ä¸­å›½', 35.8616600037, 104.1953964233, 'CHINA001.gif'),
(36, 2, '506', 'ÐšÐ¾ÑÑ‚Ð°-Ð Ð¸ÐºÐ°', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 3, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 5, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 6, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 7, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 8, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 61, '506', 'Costa Rica', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(36, 79, '506', 'å“¥æ–¯è¾¾é»ŽåŠ ', 9.7489166260, -83.7534255981, 'CORC0001.gif'),
(37, 2, '965', 'ÐšÑƒÐ²ÐµÐ¹Ñ‚', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 3, '965', 'Kuwait', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 5, '965', 'Kuwait', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 6, '965', 'Koweit', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 7, '965', 'Kuwait', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 8, '965', 'Kuwait', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 61, '965', 'Kuwait', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(37, 79, '965', 'ç§‘å¨ç‰¹', 29.3116607666, 47.4817657471, 'KUWA001.gif'),
(38, 2, '371', 'Ð›Ð°Ñ‚Ð²Ð¸Ñ', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 3, '371', 'Latvia', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 5, '371', 'Lettland', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 6, '371', 'Lettonie', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 7, '371', 'Letonia', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 8, '371', 'Lettonia', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 61, '371', 'Let&ocirc;nia', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(38, 79, '371', 'æ‹‰è„±ç»´äºš', 56.8796348572, 24.6031894684, 'LETON001.gif'),
(39, 2, '218', 'Ð›Ð¸Ð²Ð¸Ñ', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 3, '218', 'Libya', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 5, '218', 'Libyen', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 6, '218', 'Libye', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 7, '218', 'Libia', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 8, '218', 'Libia', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 61, '218', 'L&iacute;bia', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(39, 79, '218', 'åˆ©æ¯”äºš', 26.3351001740, 17.2283306122, 'LIBIA001.gif'),
(40, 2, '370', 'Ð›Ð¸Ñ‚Ð²Ð°', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 3, '370', 'Lithuania', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 5, '370', 'Litauen', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 6, '370', 'Lituanie', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 7, '370', 'Lituania', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 8, '370', 'Lituania', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 61, '370', 'Litu&acirc;nia', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(40, 79, '370', 'ç«‹é™¶å®›', 55.1694374084, 23.8812751770, 'LITUAN001.gif'),
(41, 2, '352', 'Ð›ÑŽÐºÑÐµÐ¼Ð±ÑƒÑ€Ð³', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 3, '352', 'Luxembourg', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 5, '352', 'Luxemburg', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 6, '352', 'Luxembourg', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 7, '352', 'Luxemburgo', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 8, '352', 'Lussemburgo', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 61, '352', 'Luxemburgo', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(41, 79, '352', 'å¢æ£®å ¡', 49.8152732849, 6.1295828819, 'LUXEMB001.gif'),
(42, 2, '52', 'ÐœÐµÐºÑÐ¸ÐºÐ°', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 3, '52', 'Mexico', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 5, '52', 'Mexiko', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 6, '52', 'Mexique', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 7, '52', 'M&eacute;xico', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 8, '52', 'Messico', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 61, '52', 'M&eacute;xico', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(42, 79, '52', 'å¢¨è¥¿å“¥', 23.6345005035, -102.5527877808, 'MEXC0001.gif'),
(43, 2, '373', 'ÐœÐ¾Ð»Ð´Ð¾Ð²Ð°', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 3, '373', 'Moldova', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 5, '373', 'Moldawien', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 6, '373', 'Moldavie', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 7, '373', 'Moldavia', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 8, '373', 'Moldavia', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 61, '373', 'Moldova, Rep&uacute;blica de', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(43, 79, '373', 'æ‘©å°”å¤šç“¦å…±å’Œå›½', 47.4116325378, 28.3698844910, 'MOLDA001.gif'),
(44, 2, '377', 'ÐœÐ¾Ð½Ð°ÐºÐ¾', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 3, '377', 'Monaco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 5, '377', 'Monaco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 6, '377', 'Monaco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 7, '377', 'M&oacute;naco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 8, '377', 'Monaco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 61, '377', 'M&ocirc;naco', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(44, 79, '377', 'æ‘©çº³å“¥', 43.7502975464, 7.4128408432, 'MONAC001.gif'),
(45, 2, '64', 'ÐÐ¾Ð²Ð°Ñ Ð—ÐµÐ»Ð°Ð½Ð´Ð¸Ñ', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 3, '64', 'New Zealand', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 5, '64', 'Neuseeland', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 6, '64', 'Nouvelle Z&eacute;lande', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 7, '64', 'Nueva Zelanda', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 8, '64', 'Nuova Zelanda', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 61, '64', 'Nova Zel&acirc;ndia', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(45, 79, '64', 'æ–°è¥¿å…°', -40.9005584717, 174.8859710693, 'NUEZEL001.gif'),
(46, 2, '47', 'ÐÐ¾Ñ€Ð²ÐµÐ³Ð¸Ñ', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 3, '47', 'Norway', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 5, '47', 'Norwegen', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 6, '47', 'Norv&egrave;ge', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 7, '47', 'Noruega', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 8, '47', 'Norvegia', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 61, '47', 'Noruega', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(46, 79, '47', 'æŒªå¨', 60.4720230103, 8.4689464569, 'NORUE001.gif'),
(47, 2, '48', 'ÐŸÐ¾Ð»ÑŒÑˆÐ°', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 3, '48', 'Poland', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 5, '48', 'Polen', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 6, '48', 'Pologne', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 7, '48', 'Polonia', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 8, '48', 'Polonia', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 61, '48', 'Pol&ocirc;nia', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(47, 79, '48', 'æ³¢å…°', 51.9194374084, 19.1451358795, 'POLO001.gif'),
(48, 2, '351', 'ÐŸÐ¾Ñ€Ñ‚ÑƒÐ³Ð°Ð»Ð¸Ñ', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 3, '351', 'Portugal', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 5, '351', 'Portugal', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 6, '351', 'Portugal', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 7, '351', 'Portugal', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 8, '351', 'Portogallo', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 61, '351', 'Portugal', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(48, 79, '351', 'è‘¡è„ç‰™', 39.3998718262, -8.2244539261, 'PORT001.gif'),
(49, 2, '262', 'Ð ÐµÑŽÐ½ÑŒÐ¾Ð½', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 3, '262', 'Reunion', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 5, '262', 'R&eacute;union', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 6, '262', 'R&eacute;union', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 7, '262', 'Reuni&oacute;n', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 8, '262', 'Reunion', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 61, '262', 'Reuni&atilde;o', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(49, 79, '262', 'ç•™å°¼æ±ª', -21.1151409149, 55.5363845825, 'REUNI001.gif'),
(50, 2, '7', 'Ð Ð¾ÑÑÐ¸Ñ', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 3, '7', 'Russia', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 5, '7', 'Russland', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 6, '7', 'Russie', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 7, '7', 'Rusia', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 8, '7', 'Russia', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 61, '7', 'R&uacute;ssia', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(50, 79, '7', 'ä¿„ç½—æ–¯è”é‚¦', 61.5240097046, 105.3187561035, 'RUSS0001.gif'),
(51, 2, '503', 'Ð¡Ð°Ð»ÑŒÐ²Ð°Ð´Ð¾Ñ€', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 3, '503', 'El Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 5, '503', 'El Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 6, '503', 'Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 7, '503', 'El Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 8, '503', 'El Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 61, '503', 'El Salvador', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(51, 79, '503', 'è¨å°”ç“¦å¤š', 13.7941846848, -88.8965301514, 'ELSALVADOR0001.jpg'),
(52, 2, '421', 'Ð¡Ð»Ð¾Ð²Ð°ÐºÐ¸Ñ', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 3, '421', 'Slovakia', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 5, '421', 'Slowakei', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 6, '421', 'Slovaquie', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 7, '421', 'Eslovaquia', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 8, '421', 'Slovacchia', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 61, '421', 'Eslov&aacute;quia', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(52, 79, '421', 'æ–¯æ´›ä¼å…‹', 48.6690254211, 19.6990242004, 'ESLOV001.gif'),
(53, 2, '386', 'Ð¡Ð»Ð¾Ð²ÐµÐ½Ð¸Ñ', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 3, '386', 'Slovenia', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 5, '386', 'Slowenien', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 6, '386', 'Slov&eacute;nie', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 7, '386', 'Eslovenia', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 8, '386', 'Slovenia', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 61, '386', 'Eslov&ecirc;nia', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(53, 79, '386', 'æ–¯æ´›æ–‡å°¼äºš', 46.1512413025, 14.9954633713, 'ESLOVEN001.gif'),
(54, 2, '597', 'Ð¡ÑƒÑ€Ð¸Ð½Ð°Ð¼', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 3, '597', 'Suriname', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 5, '597', 'Suriname', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 6, '597', 'Surinam', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 7, '597', 'Surinam', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 8, '597', 'Surinam', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 61, '597', 'Suriname', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(54, 79, '597', 'è‹é‡Œå—', 3.9193050861, -56.0277824402, 'SURIMAN001.jpg'),
(55, 2, '1', 'Ð¡Ð¨Ð', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 3, '1', 'United States', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 5, '1', 'Vereinigte Staaten (USA)', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 6, '1', 'Etats Unis', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 7, '1', 'Estados Unidos', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 8, '1', 'Stati Uniti', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 61, '1', 'Estados Unidos', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(55, 79, '1', 'ç¾Žå›½', 37.0902404785, -95.7128906250, 'USAT0001.gif'),
(56, 2, '992', 'Ð¢Ð°Ð´Ð¶Ð¸ÐºÐ¸ÑÑ‚Ð°Ð½', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 3, '992', 'Tajikistan', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 5, '992', 'Tadschikistan', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 6, '992', 'Tadjikistan', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 7, '992', 'Tadjikistan', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 8, '992', 'Tagikistan', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 61, '992', 'Tadjiquist&atilde;o', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(56, 79, '992', 'å¡”å‰å…‹æ–¯å¦', 38.8610343933, 71.2760925293, 'TAYIKI001.gif'),
(57, 2, '993', 'Ð¢ÑƒÑ€ÐºÐ¼ÐµÐ½Ð¸ÑÑ‚Ð°Ð½', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 3, '993', 'Turkmenistan', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 5, '993', 'Turkmenistan', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 6, '993', 'Turkm&eacute;nistan', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 7, '993', 'Turkmenistan', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 8, '993', 'Turkmenistan', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 61, '993', 'Turcomenist&atilde;o', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(57, 79, '993', 'åœŸåº“æ›¼æ–¯å¦', 38.9697189331, 59.5562782288, 'TURKME001.gif'),
(58, 2, '1', 'Ð¢ÑƒÑ€ÐºÑ Ð¸ ÐšÐµÐ¹ÐºÐ¾Ñ', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 3, '1', 'Turks and Caicos Islands', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 5, '1', 'Turks- und Caicosinseln', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 6, '1', 'Turks-et-Caicos (Iles)', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 7, '1', 'Islas Turcas y Caicos', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 8, '1', 'Turks e Caicos, Isole', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 61, '1', 'Ilhas Turks e Caicos', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(58, 79, '1', 'ç‰¹å…‹æ–¯å’Œå‡¯ç§‘æ–¯ç¾¤å²›', 21.6940250397, -71.7979278564, 'TURKCAICO001.gif'),
(59, 2, '90', 'Ð¢ÑƒÑ€Ñ†Ð¸Ñ', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 3, '90', 'Turkey', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 5, '90', 'T&uuml;rkei', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 6, '90', 'Turquie', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 7, '90', 'Turqu&iacute;a', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 8, '90', 'Turchia', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 61, '90', 'Turquia', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(59, 79, '90', 'åœŸè€³å…¶', 38.9637451172, 35.2433204651, 'TURQ001.gif'),
(60, 2, '256', 'Ð£Ð³Ð°Ð½Ð´Ð°', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 3, '256', 'Uganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 5, '256', 'Uganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 6, '256', 'Ouganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 7, '256', 'Uganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 8, '256', 'Uganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 61, '256', 'Uganda', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(60, 79, '256', 'ä¹Œå¹²è¾¾', 1.3733329773, 32.2902755737, 'UGAND001.gif'),
(61, 2, '998', 'Ð£Ð·Ð±ÐµÐºÐ¸ÑÑ‚Ð°Ð½', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 3, '998', 'Uzbekistan', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 5, '998', 'Usbekistan', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 6, '998', 'Ouzb&eacute;kistan', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 7, '998', 'Uzbekist&aacute;n', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 8, '998', 'Uzbekistan', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 61, '998', 'Uzbequist&atilde;o', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(61, 79, '998', 'ä¹Œå…¹åˆ«å…‹æ–¯å¦', 41.3774909973, 64.5852584839, 'UZBEKINTA001.gif'),
(62, 2, '380', 'Ð£ÐºÑ€Ð°Ð¸Ð½Ð°', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 3, '380', 'Ukraine', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 5, '380', 'Ukraine', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 6, '380', 'Ukraine', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 7, '380', 'Ucrania', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 8, '380', 'Ucraina', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 61, '380', 'Ucr&acirc;nia', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(62, 79, '380', 'ä¹Œå…‹å…°', 48.3794326782, 31.1655807495, 'UCRA001.gif'),
(63, 2, '358', 'Ð¤Ð¸Ð½Ð»ÑÐ½Ð´Ð¸Ñ', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 3, '358', 'Finland', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 5, '358', 'Finnland', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 6, '358', 'Finlande', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 7, '358', 'Finlandia', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 8, '358', 'Finlandia', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 61, '358', 'Finl&acirc;ndia', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(63, 79, '358', 'èŠ¬å…°', 61.9241104126, 25.7481517792, 'FINLAND001.gif'),
(64, 2, '33', 'Ð¤Ñ€Ð°Ð½Ñ†Ð¸Ñ', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 3, '33', 'France', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 5, '33', 'Frankreich', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 6, '33', 'France', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 7, '33', 'Francia', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 8, '33', 'Francia', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 61, '33', 'Fran&ccedil;a', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(64, 79, '33', 'æ³•å›½', 46.2276382446, 2.2137489319, 'FRAN0001.gif'),
(65, 2, '420', 'Ð§ÐµÑ…Ð¸Ñ', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 3, '420', 'Czech Republic', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 5, '420', 'Tschechische Republik', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 6, '420', 'R&eacute;publique Tch&egrave;que', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 7, '420', 'Rep&uacute;blica Checa', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 8, '420', 'Repubblica Ceca', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 61, '420', 'Rep&uacute;blica Tcheca', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(65, 79, '420', 'æ·å…‹å…±å’Œå›½', 49.8174934387, 15.4729623795, 'RCHEKA01.gif'),
(66, 2, '41', 'Ð¨Ð²ÐµÐ¹Ñ†Ð°Ñ€Ð¸Ñ', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 3, '41', 'Switzerland', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 5, '41', 'Schweiz', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 6, '41', 'Suisse', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 7, '41', 'Suiza', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 8, '41', 'Svizzera', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 61, '41', 'Su&iacute;&ccedil;a', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(66, 79, '41', 'ç‘žå£«', 46.8181877136, 8.2275123596, 'SUIZ001.gif'),
(67, 2, '46', 'Ð¨Ð²ÐµÑ†Ð¸Ñ', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 3, '46', 'Sweden', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 5, '46', 'Schweden', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 6, '46', 'Su&egrave;de', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 7, '46', 'Suecia', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 8, '46', 'Svezia', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 61, '46', 'Su&eacute;cia', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(67, 79, '46', 'ç‘žå…¸', 60.1281623840, 18.6435012817, 'SUECIA001.gif'),
(68, 2, '372', 'Ð­ÑÑ‚Ð¾Ð½Ð¸Ñ', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 3, '372', 'Estonia', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 5, '372', 'Estland', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 6, '372', 'Estonie', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 7, '372', 'Estonia', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 8, '372', 'Estonia', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 61, '372', 'Est&ocirc;nia', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(68, 79, '372', 'çˆ±æ²™å°¼äºš', 58.5952720642, 25.0136070251, 'ESTON001.gif'),
(69, 2, '82', 'Ð®Ð¶Ð½Ð°Ñ ÐšÐ¾Ñ€ÐµÑ', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 3, '82', 'South Korea', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 5, '82', 'S&uuml;dkorea', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 6, '82', 'Cor&eacute;e du Sud', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 7, '82', 'Corea del Sur', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 8, '82', 'Corea del Sud', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 61, '82', 'Cor&eacute;ia, Sul', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(69, 79, '82', 'éŸ©å›½', 35.9077568054, 127.7669219971, 'CORESUR001.gif'),
(70, 2, '81', 'Ð¯Ð¿Ð¾Ð½Ð¸Ñ', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 3, '81', 'Japan', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 5, '81', 'Japan', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 6, '81', 'Japon', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 7, '81', 'Jap&oacute;n', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 8, '81', 'Giappone', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 61, '81', 'Jap&atilde;o', 36.2048225403, 138.2529296875, 'JAPA0001'),
(70, 79, '81', 'æ—¥æœ¬', 36.2048225403, 138.2529296875, 'JAPA0001'),
(71, 2, '385', 'Ð¥Ð¾Ñ€Ð²Ð°Ñ‚Ð¸Ñ', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 3, '385', 'Croatia', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 5, '385', 'Kroatien', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 6, '385', 'Croatie', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 7, '385', 'Croacia', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 8, '385', 'Croazia', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 61, '385', 'Cro&aacute;cia', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(71, 79, '385', 'å…‹ç½—åœ°äºš', 44.4662437439, 16.4612483978, 'CROACI001.gif'),
(72, 2, '40', 'Ð ÑƒÐ¼Ñ‹Ð½Ð¸Ñ', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 3, '40', 'Romania', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 5, '40', 'Rum&auml;nien', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 6, '40', 'Roumanie', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 7, '40', 'Ruman&iacute;a', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 8, '40', 'Romania', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 61, '40', 'Rom&ecirc;nia', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(72, 79, '40', 'ç½—é©¬å°¼äºš', 45.9431610107, 24.9667606354, 'RUMAN001.gif'),
(73, 2, '852', 'Ð“Ð¾Ð½ÐºÐ¾Ð½Ð³', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 3, '852', 'Hong Kong', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 5, '852', 'Hongkong', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 6, '852', 'Hong Kong', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 7, '852', 'Hong Kong', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 8, '852', 'Hong Kong', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 61, '852', 'Hong Kong, Regi&atilde;o Admin. Especial da China', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(73, 79, '852', 'ä¸­å›½é¦™æ¸¯ç‰¹åˆ«è¡Œæ”¿åŒº', 22.3964271545, 114.1094970703, 'HONGK001.gif'),
(74, 2, '62', 'Ð˜Ð½Ð´Ð¾Ð½ÐµÐ·Ð¸Ñ', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 3, '62', 'Indonesia', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 5, '62', 'Indonesien', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 6, '62', 'Indon&eacute;sie', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 7, '62', 'Indonesia', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 8, '62', 'Indonesia', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 61, '62', 'Indon&eacute;sia', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(74, 79, '62', 'å°åº¦å°¼è¥¿äºš', -0.7892749906, 113.9213256836, 'INDON001.gif'),
(75, 2, '962', 'Ð˜Ð¾Ñ€Ð´Ð°Ð½Ð¸Ñ', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 3, '962', 'Jordan', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 5, '962', 'Jordanien', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 6, '962', 'Jordanie', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 7, '962', 'Jordania', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 8, '962', 'Giordania', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 61, '962', 'Jord&acirc;nia', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(75, 79, '962', 'çº¦æ—¦', 30.5851631165, 36.2384147644, 'JORDANIA001.gif'),
(76, 2, '60', 'ÐœÐ°Ð»Ð°Ð¹Ð·Ð¸Ñ', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 3, '60', 'Malaysia', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 5, '60', 'Malaysia', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 6, '60', 'Malaisie', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 7, '60', 'Malasia', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 8, '60', 'Malesia', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 61, '60', 'Mal&aacute;sia', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(76, 79, '60', 'é©¬æ¥è¥¿äºš', 4.2104840279, 101.9757690430, 'MALAS001.gif'),
(77, 2, '65', 'Ð¡Ð¸Ð½Ð³Ð°Ð¿ÑƒÑ€', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 3, '65', 'Singapore', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 5, '65', 'Singapur', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 6, '65', 'Singapour', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 7, '65', 'Singapur', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 8, '65', 'Singapore', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 61, '65', 'Cingapura', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(77, 79, '65', 'æ–°åŠ å¡', 1.3520829678, 103.8198394775, 'SINGA001.gif'),
(78, 2, '886', 'Ð¢Ð°Ð¹Ð²Ð°Ð½ÑŒ', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 3, '886', 'Taiwan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 5, '886', 'Taiwan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 6, '886', 'Ta&iuml;wan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 7, '886', 'Taiwan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 8, '886', 'Taiwan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 61, '886', 'Taiwan', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(78, 79, '886', 'å°æ¹¾', 23.6978092194, 120.9605178833, 'TAIW001.gif'),
(79, 2, '387', 'Ð‘Ð¾ÑÐ½Ð¸Ñ/Ð“ÐµÑ€Ñ†ÐµÐ³Ð¾Ð²Ð¸Ð½Ð°', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 3, '387', 'Bosnia and Herzegovina', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 5, '387', 'Bosnien Herzegowina', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 6, '387', 'Bosnie-Herz&eacute;govine', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 7, '387', 'Bosnia y Herzegovina', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 8, '387', 'Bosnia ed Erzegovina', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 61, '387', 'B&oacute;snia-Herzeg&oacute;vina', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(79, 79, '387', 'æ³¢æ–¯å°¼äºšå’Œé»‘å±±å…±å’Œå›½', 43.9158859253, 17.6790752411, 'BOSNIA001.gif'),
(80, 2, '1', 'Ð‘Ð°Ð³Ð°Ð¼ÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 3, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 5, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 6, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 7, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 8, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 61, '1', 'Bahamas', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(80, 79, '1', 'å·´å“ˆé©¬', 25.0342807770, -77.3962783813, 'BHMS0001.gif'),
(81, 2, '56', 'Ð§Ð¸Ð»Ð¸', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 3, '56', 'Chile', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 5, '56', 'Chile', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 6, '56', 'Chili', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 7, '56', 'Chile', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 8, '56', 'Cile', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 61, '56', 'Chile', -35.6751480103, -71.5429687500, 'chile.svg'),
(81, 79, '56', 'æ™ºåˆ©', -35.6751480103, -71.5429687500, 'chile.svg'),
(82, 2, '57', 'ÐšÐ¾Ð»ÑƒÐ¼Ð±Ð¸Ñ', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 3, '57', 'Colombia', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 5, '57', 'Kolumbien', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 6, '57', 'Colombie', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 7, '57', 'Colombia', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 8, '57', 'Colombia', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 61, '57', 'Col&ocirc;mbia', 4.5708680153, -74.2973327637, 'colombia.svg'),
(82, 79, '57', 'å“¥ä¼¦æ¯”äºš', 4.5708680153, -74.2973327637, 'colombia.svg'),
(83, 2, '354', 'Ð˜ÑÐ»Ð°Ð½Ð´Ð¸Ñ', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 3, '354', 'Iceland', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 5, '354', 'Island', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 6, '354', 'Islande', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 7, '354', 'Islandia', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 8, '354', 'Islanda', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 61, '354', 'Isl&acirc;ndia', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(83, 79, '354', 'å†°å²›', 64.9630508423, -19.0208358765, 'ISLAND001.gif'),
(84, 2, '850', 'Ð¡ÐµÐ²ÐµÑ€Ð½Ð°Ñ ÐšÐ¾Ñ€ÐµÑ', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 3, '850', 'North Korea', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 5, '850', 'Nordkorea', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 6, '850', 'Cor&eacute;e du Nord', 40.3398513794, 127.5100936890, 'coreanor001.gif');
INSERT INTO `countries` (`id`, `id_idioma`, `id_wsp`, `nombre`, `x`, `y`, `img`) VALUES
(84, 7, '850', 'Corea del Norte', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 8, '850', 'Corea del Nord', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 61, '850', 'Cor&eacute;ia, Norte', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(84, 79, '850', 'åŒ—æœé²œ', 40.3398513794, 127.5100936890, 'coreanor001.gif'),
(85, 2, '389', 'ÐœÐ°ÐºÐµÐ´Ð¾Ð½Ð¸Ñ', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 3, '389', 'Macedonia', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 5, '389', 'Mazedonien', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 6, '389', 'Mac&eacute;doine', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 7, '389', 'Macedonia', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 8, '389', 'Macedonia', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 61, '389', 'Maced&ocirc;nia, Rep&uacute;blica da', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(85, 79, '389', 'é©¬å…¶é¡¿çŽ‹å›½', 41.6086349487, 21.7452754974, 'MACE001.gif'),
(86, 2, '356', 'ÐœÐ°Ð»ÑŒÑ‚Ð°', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 3, '356', 'Malta', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 5, '356', 'Malta', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 6, '356', 'Malte', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 7, '356', 'Malta', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 8, '356', 'Malta', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 61, '356', 'Malta', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(86, 79, '356', 'é©¬è€³ä»–', 35.9374961853, 14.3754158020, 'MALTA001.gif'),
(87, 2, '92', 'ÐŸÐ°ÐºÐ¸ÑÑ‚Ð°Ð½', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 3, '92', 'Pakistan', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 5, '92', 'Pakistan', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 6, '92', 'Pakistan', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 7, '92', 'Pakist&aacute;n', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 8, '92', 'Pakistan', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 61, '92', 'Paquist&atilde;o', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(87, 79, '92', 'å·´åŸºæ–¯å¦', 30.3753204346, 69.3451156616, 'PAKIST001.gif'),
(88, 2, '675', 'ÐŸÐ°Ð¿ÑƒÐ° ÐÐ¾Ð²Ð°Ñ Ð“Ð²Ð¸Ð½ÐµÑ', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 3, '675', 'Papua New Guinea', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 5, '675', 'Papua-Neuguinea', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 6, '675', 'Papouasie Nouvelle Guinee', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 7, '675', 'Pap&uacute;a-Nueva Guinea', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 8, '675', 'Papua Nuova Guinea', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 61, '675', 'Papua-Nova Guin&eacute;', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(88, 79, '675', 'å·´å¸ƒäºšæ–°å‡ å†…äºš', -6.3149929047, 143.9555511475, 'PAPUA001.gif'),
(89, 2, '51', 'ÐŸÐµÑ€Ñƒ', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 3, '51', 'Peru', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 5, '51', 'Peru', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 6, '51', 'P&eacute;rou', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 7, '51', 'Per&uacute;', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 8, '51', 'Peru', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 61, '51', 'Peru', -9.1899671555, -75.0151519775, 'peru.svg'),
(89, 79, '51', 'ç§˜é²', -9.1899671555, -75.0151519775, 'peru.svg'),
(90, 2, '63', 'Ð¤Ð¸Ð»Ð¸Ð¿Ð¿Ð¸Ð½Ñ‹', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 3, '63', 'Philippines', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 5, '63', 'Philippinen', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 6, '63', 'Philippines', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 7, '63', 'Filipinas', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 8, '63', 'Filippine', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 61, '63', 'Filipinas', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(90, 79, '63', 'è²å¾‹å®¾', 12.8797206879, 121.7740173340, 'FILIPI001.gif'),
(91, 2, '966', 'Ð¡Ð°ÑƒÐ´Ð¾Ð²ÑÐºÐ°Ñ ÐÑ€Ð°Ð²Ð¸Ñ', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 3, '966', 'Saudi Arabia', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 5, '966', 'Saudi-Arabien', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 6, '966', 'Arabie Saoudite', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 7, '966', 'Arabia Saudita', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 8, '966', 'Arabia Saudita', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 61, '966', 'Ar&aacute;bia Saudita', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(91, 79, '966', 'æ²™ç‰¹é˜¿æ‹‰ä¼¯', 23.8859424591, 45.0791625977, 'ARABIA001.gif'),
(92, 2, '66', 'Ð¢Ð°Ð¹Ð»Ð°Ð½Ð´', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 3, '66', 'Thailand', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 5, '66', 'Thailand', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 6, '66', 'Tha&iuml;lande', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 7, '66', 'Tailandia', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 8, '66', 'Thailandia', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 61, '66', 'Tail&acirc;ndia', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(92, 79, '66', 'æ³°å›½', 15.8700323105, 100.9925384521, 'TAILA001.gif'),
(93, 2, '971', 'Ðž.Ð.Ð­.', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 3, '971', 'United Arab Emirates', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 5, '971', 'Vereinigte Arabische Emirate', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 6, '971', 'Emirats Arabes Unis', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 7, '971', 'Emiratos &Aacute;rabes Unidos', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 8, '971', 'Emirati Arabi Uniti', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 61, '971', 'Emirados &Aacute;rabes Unidos', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(93, 79, '971', 'é˜¿æ‹‰ä¼¯è”åˆé…‹é•¿å›½', 23.4240760803, 53.8478164673, 'EMIRATOS001.gif'),
(94, 2, '299', 'Ð“Ñ€ÐµÐ½Ð»Ð°Ð½Ð´Ð¸Ñ', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 3, '299', 'Greenland', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 5, '299', 'Gr&ouml;nland', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 6, '299', 'Gro&euml;nland', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 7, '299', 'Groenlandia', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 8, '299', 'Groenlandia', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 61, '299', 'Gro&ecirc;nlandia', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(94, 79, '299', 'æ ¼é™µå…°', 71.7069396973, -42.6043014526, 'GROELA001.gif'),
(95, 2, '58', 'Ð’ÐµÐ½ÐµÑÑƒÑÐ»Ð°', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 3, '58', 'Venezuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 5, '58', 'Venezuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 6, '58', 'V&eacute;n&eacute;zuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 7, '58', 'Venezuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 8, '58', 'Venezuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 61, '58', 'Venezuela', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(95, 79, '58', 'å§”å†…ç‘žæ‹‰', 6.4237499237, -66.5897293091, 'VENZ0001.gif'),
(96, 2, '263', 'Ð—Ð¸Ð¼Ð±Ð°Ð±Ð²Ðµ', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 3, '263', 'Zimbabwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 5, '263', 'Simbabwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 6, '263', 'Zimbabwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 7, '263', 'Zimbabwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 8, '263', 'Zimbabwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 61, '263', 'Zimb&aacute;bwe', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(96, 79, '263', 'æ´¥å·´å¸ƒéŸ¦', -19.0154380798, 29.1548576355, 'ZIMBAG001.gif'),
(97, 2, '254', 'ÐšÐµÐ½Ð¸Ñ', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 3, '254', 'Kenya', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 5, '254', 'Kenia', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 6, '254', 'Kenya', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 7, '254', 'Kenia', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 8, '254', 'Kenya', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 61, '254', 'Qu&ecirc;nia', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(97, 79, '254', 'è‚¯å°¼äºš', -0.0235590003, 37.9061927795, 'KENI001.gif'),
(98, 2, '213', 'ÐÐ»Ð¶Ð¸Ñ€', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 3, '213', 'Algeria', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 5, '213', 'Algerien', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 6, '213', 'Alg&eacute;rie', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 7, '213', 'Algeria', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 8, '213', 'Algeria', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 61, '213', 'Arg&eacute;lia', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(98, 79, '213', 'é˜¿å°”åŠåˆ©äºš', 28.0338859558, 1.6596260071, 'ALGER001.gif'),
(99, 2, '961', 'Ð›Ð¸Ð²Ð°Ð½', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 3, '961', 'Lebanon', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 5, '961', 'Libanon', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 6, '961', 'Liban', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 7, '961', 'L&iacute;bano', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 8, '961', 'Libano', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 61, '961', 'L&iacute;bano', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(99, 79, '961', 'é»Žå·´å«©', 33.8547210693, 35.8622856140, 'LIBAN001.gif'),
(100, 2, '267', 'Ð‘Ð¾Ñ‚ÑÐ²Ð°Ð½Ð°', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 3, '267', 'Botswana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 5, '267', 'Botsuana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 6, '267', 'Botswana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 7, '267', 'Botsuana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 8, '267', 'Botswana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 61, '267', 'Botsuana', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(100, 79, '267', 'åšèŒ¨ç“¦çº³', -22.3284740448, 24.6848659515, 'BOSWA001.gif'),
(101, 2, '255', 'Ð¢Ð°Ð½Ð·Ð°Ð½Ð¸Ñ', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 3, '255', 'Tanzania', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 5, '255', 'Tansania', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 6, '255', 'Tanzanie', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 7, '255', 'Tanzania', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 8, '255', 'Tanzania', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 61, '255', 'Tanz&acirc;nia', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(101, 79, '255', 'å¦æ¡‘å°¼äºš', -6.3690280914, 34.8888206482, 'TANZA001.gif'),
(102, 2, '264', 'ÐÐ°Ð¼Ð¸Ð±Ð¸Ñ', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 3, '264', 'Namibia', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 5, '264', 'Namibia', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 6, '264', 'Namibie', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 7, '264', 'Namibia', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 8, '264', 'Namibia', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 61, '264', 'Nam&iacute;bia', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(102, 79, '264', 'çº³ç±³æ¯”äºš', -22.9576396942, 18.4904098511, 'NAMIBIA.gif'),
(103, 2, '593', 'Ð­ÐºÐ²Ð°Ð´Ð¾Ñ€', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 3, '593', 'Ecuador', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 5, '593', 'Ecuador', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 6, '593', 'Equateur', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 7, '593', 'Ecuador', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 8, '593', 'Equador', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 61, '593', 'Equador', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(103, 79, '593', 'åŽ„ç“œå¤šå°”', -1.8312389851, -78.1834030151, 'ECUA0001.gif'),
(104, 2, '212', 'ÐœÐ¾Ñ€Ð¾ÐºÐºÐ¾', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 3, '212', 'Morocco', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 5, '212', 'Marokko', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 6, '212', 'Maroc', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 7, '212', 'Marruecos', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 8, '212', 'Marocco', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 61, '212', 'Marrocos', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(104, 79, '212', 'æ‘©æ´›å“¥', 31.7917022705, -7.0926198959, 'MARRUE001.gif'),
(105, 2, '233', 'Ð“Ð°Ð½Ð°', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 3, '233', 'Ghana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 5, '233', 'Ghana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 6, '233', 'Ghana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 7, '233', 'Ghana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 8, '233', 'Ghana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 61, '233', 'Gana', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(105, 79, '233', 'åŠ çº³', 7.9465270042, -1.0231939554, 'GANHA001.gif'),
(106, 2, '963', 'Ð¡Ð¸Ñ€Ð¸Ñ', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 3, '963', 'Syria', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 5, '963', 'Syrien', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 6, '963', 'Syrie', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 7, '963', 'Siria', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 8, '963', 'Siria', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 61, '963', 'S&iacute;ria', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(106, 79, '963', 'å™åˆ©äºš', 34.8020744324, 38.9968147278, 'SIRIA001.gif'),
(107, 2, '977', 'ÐÐµÐ¿Ð°Ð»', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 3, '977', 'Nepal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 5, '977', 'Nepal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 6, '977', 'N&eacute;pal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 7, '977', 'Nepal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 8, '977', 'Nepal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 61, '977', 'Nepal', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(107, 79, '977', 'å°¼æ³Šå°”', 28.3948574066, 84.1240081787, 'NEPAL001.gif'),
(108, 2, '222', 'ÐœÐ°Ð²Ñ€Ð¸Ñ‚Ð°Ð½Ð¸Ñ', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 3, '222', 'Mauritania', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 5, '222', 'Mauretanien', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 6, '222', 'Mauritanie', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 7, '222', 'Mauritania', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 8, '222', 'Mauritania', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 61, '222', 'Maurit&acirc;nia', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(108, 79, '222', 'æ¯›é‡Œå¡”å°¼äºš', 21.0078907013, -10.9408349991, 'MAURITI001.gif'),
(109, 2, '248', 'Ð¡ÐµÐ¹ÑˆÐµÐ»Ð»Ñ‹', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 3, '248', 'Seychelles', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 5, '248', 'Seychellen', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 6, '248', 'Seychelles', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 7, '248', 'Seychelles', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 8, '248', 'Seychelles', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 61, '248', 'Seychelles', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(109, 79, '248', 'å¡žèˆŒå°”', -4.6795740128, 55.4919776917, 'SEYCHEL001.gif'),
(110, 2, '595', 'ÐŸÐ°Ñ€Ð°Ð³Ð²Ð°Ð¹', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 3, '595', 'Paraguay', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 5, '595', 'Paraguay', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 6, '595', 'Paraguay', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 7, '595', 'Paraguay', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 8, '595', 'Paraguay', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 61, '595', 'Paraguai', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(110, 79, '595', 'å·´æ‹‰åœ­', -23.4425029755, -58.4438323975, 'PARA0001.gif'),
(111, 2, '598', 'Ð£Ñ€ÑƒÐ³Ð²Ð°Ð¹', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 3, '598', 'Uruguay', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 5, '598', 'Uruguay', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 6, '598', 'Uruguay', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 7, '598', 'Uruguay', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 8, '598', 'Uruguay', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 61, '598', 'Uruguai', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(111, 79, '598', 'ä¹Œæ‹‰åœ­', -32.5227775574, -55.7658348083, 'URUG001.gif'),
(112, 2, '243', 'ÐšÐ¾Ð½Ð³Ð¾ (Brazzaville)', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 3, '243', 'Congo (Brazzaville)', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 5, '243', 'Kongo (Brazzaville)', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 6, '243', 'Congo (Brazzaville)', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 7, '243', 'Congo (Brazzaville)', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 8, '243', 'Congo Brazzaville', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 61, '243', 'Congo', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(112, 79, '243', 'åˆšæžœ', -4.2767000198, 15.2662000656, 'CONGO001.gif'),
(113, 2, '53', 'ÐšÑƒÐ±Ð°', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 3, '53', 'Cuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 5, '53', 'Kuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 6, '53', 'Cuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 7, '53', 'Cuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 8, '53', 'Cuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 61, '53', 'Cuba', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(113, 79, '53', 'å¤å·´', 21.5217571259, -77.7811660767, 'CUBA0001.gif'),
(114, 2, '355', 'ÐÐ»Ð±Ð°Ð½Ð¸Ñ', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 3, '355', 'Albania', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 5, '355', 'Albanien', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 6, '355', 'Albanie', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 7, '355', 'Albania', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 8, '355', 'Albania', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 61, '355', 'Alb&acirc;nia', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(114, 79, '355', 'é˜¿å°”å·´å°¼äºš', 41.1533317566, 20.1683311462, 'ALB0001.jpg'),
(115, 2, '234', 'ÐÐ¸Ð³ÐµÑ€Ð¸Ñ', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 3, '234', 'Nigeria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 5, '234', 'Nigeria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 6, '234', 'Nig&eacute;ria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 7, '234', 'Nigeria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 8, '234', 'Nigeria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 61, '234', 'Nig&eacute;ria', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(115, 79, '234', 'å°¼æ—¥åˆ©äºš', 9.0819988251, 8.6752767563, 'NIGER001.gif'),
(116, 2, '260', 'Ð—Ð°Ð¼Ð±Ð¸Ñ', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 3, '260', 'Zambia', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 5, '260', 'Sambia', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 6, '260', 'Zambie', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 7, '260', 'Zambia', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 8, '260', 'Zambia', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 61, '260', 'Z&acirc;mbia', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(116, 79, '260', 'èµžæ¯”äºš', -13.1338968277, 27.8493328094, 'ZAMBI001.gif'),
(117, 2, '258', 'ÐœÐ¾Ð·Ð°Ð¼Ð±Ð¸Ðº', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 3, '258', 'Mozambique', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 5, '258', 'Mosambik', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 6, '258', 'Mozambique', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 7, '258', 'Mozambique', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 8, '258', 'Mozambico', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 61, '258', 'Mo&ccedil;ambique', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(117, 79, '258', 'èŽ«æ¡‘æ¯”å…‹', -18.6656951904, 35.5295639038, 'MOZAM001.gif'),
(119, 2, '244', 'ÐÐ½Ð³Ð¾Ð»Ð°', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 3, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 5, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 6, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 7, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 8, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 61, '244', 'Angola', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(119, 79, '244', 'å®‰å“¥æ‹‰', -11.2026920319, 17.8738861084, 'ANGOL001.gif'),
(120, 2, '94', 'Ð¨Ñ€Ð¸-Ð›Ð°Ð½ÐºÐ°', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 3, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 5, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 6, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 7, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 8, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 61, '94', 'Sri Lanka', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(120, 79, '94', 'æ–¯é‡Œå…°å¡', 7.8730540276, 80.7717971802, 'SRILANK001.gif'),
(121, 2, '251', 'Ð­Ñ„Ð¸Ð¾Ð¿Ð¸Ñ', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 3, '251', 'Ethiopia', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 5, '251', '&Auml;thopien', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 6, '251', 'Ethiopie', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 7, '251', 'Etiop&iacute;a', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 8, '251', 'Etiopia', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 61, '251', 'Eti&oacute;pia', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(121, 79, '251', 'åŸƒå¡žä¿„æ¯”äºš', 9.1450004578, 40.4896736145, 'ETIOP001.gif'),
(122, 2, '216', 'Ð¢ÑƒÐ½Ð¸Ñ', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 3, '216', 'Tunisia', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 5, '216', 'Tunesien', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 6, '216', 'Tunisie', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 7, '216', 'T&uacute;nez', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 8, '216', 'Tunisia', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 61, '216', 'Tun&iacute;sia', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(122, 79, '216', 'çªå°¼æ–¯', 33.8869171143, 9.5374994278, 'TUNE001.gif'),
(123, 2, '591', 'Ð‘Ð¾Ð»Ð¸Ð²Ð¸Ñ', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 3, '591', 'Bolivia', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 5, '591', 'Bolivien', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 6, '591', 'Bolivie', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 7, '591', 'Bolivia', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 8, '591', 'Bolivia', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 61, '591', 'Bol&iacute;via', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(123, 79, '591', 'çŽ»åˆ©ç»´äºš', -16.2901535034, -63.5886535645, 'bolivia.svg'),
(124, 2, '507', 'ÐŸÐ°Ð½Ð°Ð¼Ð°', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 3, '507', 'Panama', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 5, '507', 'Panama', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 6, '507', 'Panama', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 7, '507', 'Panam&aacute;', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 8, '507', 'Panama', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 61, '507', 'Panam&aacute;', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(124, 79, '507', 'å·´æ‹¿é©¬', 8.5379810333, -80.7821273804, 'PANAMA0001.jpg'),
(125, 2, '265', 'ÐœÐ°Ð»Ð°Ð²Ð¸', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 3, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 5, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 6, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 7, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 8, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 61, '265', 'Malawi', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(125, 79, '265', 'é©¬æ‹‰ç»´', -13.2543077469, 34.3015251160, 'MALAWI001.gif'),
(126, 2, '423', 'Ð›Ð¸Ñ…Ñ‚ÐµÐ½ÑˆÑ‚ÐµÐ¹Ð½', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 3, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 5, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 6, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 7, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 8, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 61, '423', 'Liechtenstein', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(126, 79, '423', 'åˆ—æ”¯æ•¦å£«ç™»', 47.1660003662, 9.5553731918, 'LIECH001.gif'),
(127, 2, NULL, 'Ð‘Ð°Ñ…Ñ€ÐµÐ¹Ð½', 25.9304141998, 50.6377716064, NULL),
(127, 3, NULL, 'Bahrain', 25.9304141998, 50.6377716064, NULL),
(127, 5, NULL, 'Bahrain', 25.9304141998, 50.6377716064, NULL),
(127, 6, NULL, 'Bahrein', 25.9304141998, 50.6377716064, NULL),
(127, 7, NULL, 'Bahrein', 25.9304141998, 50.6377716064, NULL),
(127, 8, NULL, 'Bahrein', 25.9304141998, 50.6377716064, NULL),
(127, 61, NULL, 'Bareine', 25.9304141998, 50.6377716064, NULL),
(127, 79, NULL, 'å·´æž—', 25.9304141998, 50.6377716064, NULL),
(128, 2, NULL, 'Ð‘Ð°Ñ€Ð±Ð°Ð´Ð¾Ñ', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 3, NULL, 'Barbados', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 5, NULL, 'Barbados', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 6, NULL, 'Barbade', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 7, NULL, 'Barbados', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 8, NULL, 'Barbados', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 61, NULL, 'Barbados', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(128, 79, NULL, 'å·´å·´å¤šæ–¯', 13.1938867569, -59.5431976318, 'BARBA0001.jpg'),
(130, 2, NULL, 'Ð§Ð°Ð´', 15.4541664124, 18.7322063446, NULL),
(130, 3, NULL, 'Chad', 15.4541664124, 18.7322063446, NULL),
(130, 5, NULL, 'Tschad', 15.4541664124, 18.7322063446, NULL),
(130, 6, NULL, 'Tchad', 15.4541664124, 18.7322063446, NULL),
(130, 7, NULL, 'Chad', 15.4541664124, 18.7322063446, NULL),
(130, 8, NULL, 'Ciad', 15.4541664124, 18.7322063446, NULL),
(130, 61, NULL, 'Chade', 15.4541664124, 18.7322063446, NULL),
(130, 79, NULL, 'ä¹å¾—', 15.4541664124, 18.7322063446, NULL),
(131, 2, NULL, 'ÐœÑÐ½ Ð¾-Ð²', 54.2361068726, -4.5480561256, NULL),
(131, 3, NULL, 'Isle of Man', 54.2361068726, -4.5480561256, NULL),
(131, 5, NULL, 'Isle of Man', 54.2361068726, -4.5480561256, NULL),
(131, 6, NULL, 'Man (Ile)', 54.2361068726, -4.5480561256, NULL),
(131, 7, NULL, 'Man, Isla de', 54.2361068726, -4.5480561256, NULL),
(131, 8, NULL, 'Man, Isola', 54.2361068726, -4.5480561256, NULL),
(131, 61, NULL, 'Isle of Man', 54.2361068726, -4.5480561256, NULL),
(131, 79, NULL, 'Isle of Man', 54.2361068726, -4.5480561256, NULL),
(132, 2, NULL, 'Ð¯Ð¼Ð°Ð¹ÐºÐ°', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 3, NULL, 'Jamaica', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 5, NULL, 'Jamaica', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 6, NULL, 'Jamaique', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 7, NULL, 'Jamaica', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 8, NULL, 'Giamaica', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 61, NULL, 'Jamaica', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(132, 79, NULL, 'ç‰™ä¹°åŠ ', 18.1095809937, -77.2975082397, 'JAMA0001.gif'),
(133, 2, NULL, 'ÐœÐ°Ð»Ð¸', 17.5706920624, -3.9961659908, NULL),
(133, 3, NULL, 'Mali', 17.5706920624, -3.9961659908, NULL),
(133, 5, NULL, 'Mali', 17.5706920624, -3.9961659908, NULL),
(133, 6, NULL, 'Mali', 17.5706920624, -3.9961659908, NULL),
(133, 7, NULL, 'Mal&iacute;', 17.5706920624, -3.9961659908, NULL),
(133, 8, NULL, 'Mali', 17.5706920624, -3.9961659908, NULL),
(133, 61, NULL, 'Mali', 17.5706920624, -3.9961659908, NULL),
(133, 79, NULL, 'é©¬é‡Œ', 17.5706920624, -3.9961659908, NULL),
(134, 2, NULL, 'ÐœÐ°Ð´Ð°Ð³Ð°ÑÐºÐ°Ñ€', -18.7669467926, 46.8691062927, NULL),
(134, 3, NULL, 'Madagascar', -18.7669467926, 46.8691062927, NULL),
(134, 5, NULL, 'Madagaskar', -18.7669467926, 46.8691062927, NULL),
(134, 6, NULL, 'Madagascar', -18.7669467926, 46.8691062927, NULL),
(134, 7, NULL, 'Madagascar', -18.7669467926, 46.8691062927, NULL),
(134, 8, NULL, 'Madagascar', -18.7669467926, 46.8691062927, NULL),
(134, 61, NULL, 'Madagascar', -18.7669467926, 46.8691062927, NULL),
(134, 79, NULL, 'é©¬è¾¾åŠ æ–¯åŠ ', -18.7669467926, 46.8691062927, NULL),
(135, 2, NULL, 'Ð¡ÐµÐ½ÐµÐ³Ð°Ð»', 14.4974012375, -14.4523620605, NULL),
(135, 3, NULL, 'Senegal', 14.4974012375, -14.4523620605, NULL),
(135, 5, NULL, 'Senegal', 14.4974012375, -14.4523620605, NULL),
(135, 6, NULL, 'S&eacute;n&eacute;gal', 14.4974012375, -14.4523620605, NULL),
(135, 7, NULL, 'Senegal', 14.4974012375, -14.4523620605, NULL),
(135, 8, NULL, 'Sengal', 14.4974012375, -14.4523620605, NULL),
(135, 61, NULL, 'Senegal', 14.4974012375, -14.4523620605, NULL),
(135, 79, NULL, 'å¡žå†…åŠ å°”', 14.4974012375, -14.4523620605, NULL),
(136, 2, NULL, 'Ð¢Ð¾Ð³Ð¾', 8.6195430756, 0.8247820139, NULL),
(136, 3, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 5, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 6, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 7, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 8, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 61, NULL, 'Togo', 8.6195430756, 0.8247820139, NULL),
(136, 79, NULL, 'å¤šå“¥', 8.6195430756, 0.8247820139, NULL),
(137, 2, NULL, 'Ð“Ð¾Ð½Ð´ÑƒÑ€Ð°Ñ', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 3, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 5, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 6, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 7, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 8, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 61, NULL, 'Honduras', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(137, 79, NULL, 'æ´ªéƒ½æ‹‰æ–¯', 15.1999988556, -86.2419052124, 'HOND0001.gif'),
(138, 2, '1809', 'Ð”Ð¾Ð¼Ð¸Ð½Ð¸ÐºÐ°Ð½ÑÐºÐ°Ñ Ñ€ÐµÑÐ¿ÑƒÐ±Ð»Ð¸ÐºÐ°', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 3, '1809', 'Dominican Republic', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 5, '1809', 'Dominikanische Republik', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 6, '1809', 'R&eacute;publique Dominicaine', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 7, '1809', 'Rep&uacute;blica Dominicana', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 8, '1809', 'Repubblica Dominicana', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 61, '1809', 'Rep&uacute;blica Dominicana', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(138, 79, '1809', 'å¤šç±³å°¼åŠ å…±å’Œå›½', 18.7356929779, -70.1626510620, 'RDOMINICA001.gif'),
(139, 2, NULL, 'ÐœÐ¾Ð½Ð³Ð¾Ð»Ð¸Ñ', 46.8624954224, 103.8466567993, NULL),
(139, 3, NULL, 'Mongolia', 46.8624954224, 103.8466567993, NULL),
(139, 5, NULL, 'Mongolien', 46.8624954224, 103.8466567993, NULL),
(139, 6, NULL, 'Mongolie', 46.8624954224, 103.8466567993, NULL),
(139, 7, NULL, 'Mongolia', 46.8624954224, 103.8466567993, NULL),
(139, 8, NULL, 'Mongolia', 46.8624954224, 103.8466567993, NULL),
(139, 61, NULL, 'Mong&oacute;lia', 46.8624954224, 103.8466567993, NULL),
(139, 79, NULL, 'è’™å¤', 46.8624954224, 103.8466567993, NULL),
(140, 2, NULL, 'Ð˜Ñ€Ð°Ðº', 33.2231903076, 43.6792907715, NULL),
(140, 3, NULL, 'Iraq', 33.2231903076, 43.6792907715, NULL),
(140, 5, NULL, 'Irak', 33.2231903076, 43.6792907715, NULL),
(140, 6, NULL, 'Irak', 33.2231903076, 43.6792907715, NULL),
(140, 7, NULL, 'Irak', 33.2231903076, 43.6792907715, NULL),
(140, 8, NULL, 'Iraq', 33.2231903076, 43.6792907715, NULL),
(140, 61, NULL, 'Iraque', 33.2231903076, 43.6792907715, NULL),
(140, 79, NULL, 'ä¼Šæ‹‰å…‹', 33.2231903076, 43.6792907715, NULL),
(141, 2, NULL, 'Ð®ÐÐ ', -30.5594825745, 22.9375057220, NULL),
(141, 3, NULL, 'South Africa', -30.5594825745, 22.9375057220, NULL),
(141, 5, NULL, 'S&uuml;dafrika', -30.5594825745, 22.9375057220, NULL),
(141, 6, NULL, 'R&eacute;publique d&#039;Afrique du Sud', -30.5594825745, 22.9375057220, NULL),
(141, 7, NULL, 'Sud&aacute;frica', -30.5594825745, 22.9375057220, NULL),
(141, 8, NULL, 'Sud Africa', -30.5594825745, 22.9375057220, NULL),
(141, 61, NULL, '&Aacute;frica do Sul', -30.5594825745, 22.9375057220, NULL),
(141, 79, NULL, 'å—éž', -30.5594825745, 22.9375057220, NULL),
(142, 2, NULL, 'ÐÑ€ÑƒÐ»ÑŒÐºÐ¾', 12.5211095810, -69.9683380127, NULL),
(142, 3, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 5, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 6, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 7, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 8, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 61, NULL, 'Aruba', 12.5211095810, -69.9683380127, NULL),
(142, 79, NULL, 'é˜¿é²å·´', 12.5211095810, -69.9683380127, NULL),
(143, 2, NULL, 'Ð“Ð¸Ð±Ñ€Ð°Ð»Ñ‚Ð°Ñ€', 36.1377410889, -5.3453741074, NULL),
(143, 3, NULL, 'Gibraltar', 36.1377410889, -5.3453741074, NULL),
(143, 5, NULL, 'Gibraltar', 36.1377410889, -5.3453741074, NULL),
(143, 6, NULL, 'Gibraltar', 36.1377410889, -5.3453741074, NULL),
(143, 7, NULL, 'Gibraltar', 36.1377410889, -5.3453741074, NULL),
(143, 8, NULL, 'Gibilterra', 36.1377410889, -5.3453741074, NULL),
(143, 61, NULL, 'Gibraltar', 36.1377410889, -5.3453741074, NULL),
(143, 79, NULL, 'ç›´å¸ƒç½—é™€', 36.1377410889, -5.3453741074, NULL),
(144, 2, NULL, 'ÐÑ„Ð³Ð°Ð½Ð¸ÑÑ‚Ð°Ð½', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 3, NULL, 'Afghanistan', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 5, NULL, 'Afganistan', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 6, NULL, 'Afghanistan', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 7, NULL, 'Afganist&aacute;n', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 8, NULL, 'Afghanistan', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 61, NULL, 'Afeganist&atilde;o', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(144, 79, NULL, 'é˜¿å¯Œæ±—', 33.9391098022, 67.7099533081, 'AFGH0001.gif'),
(145, 2, NULL, 'ÐÐ½Ð´Ð¾Ñ€Ñ€Ð°', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 3, NULL, 'Andorra', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 5, NULL, 'Andorra', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 6, NULL, 'Andorre', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 7, NULL, 'Andorra', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 8, NULL, 'Andorra', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 61, NULL, 'Andorra', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(145, 79, NULL, 'å®‰é“å°”', 42.5462455750, 1.6015540361, 'ANDR0001.gif'),
(147, 2, NULL, 'ÐÐ½Ñ‚Ð¸Ð³ÑƒÐ° Ð¸ Ð‘Ð°Ñ€Ð±ÑƒÐ´Ð°', 17.0608158112, -61.7964286804, NULL),
(147, 3, NULL, 'Antigua and Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 5, NULL, 'Antigua und Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 6, NULL, 'Antigua et Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 7, NULL, 'Antigua y Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 8, NULL, 'Antigua and Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 61, NULL, 'Ant&iacute;gua e Barbuda', 17.0608158112, -61.7964286804, NULL),
(147, 79, NULL, 'å®‰æç“œå’Œå·´å¸ƒè¾¾', 17.0608158112, -61.7964286804, NULL),
(149, 2, NULL, 'Ð‘Ð°Ð½Ð³Ð»Ð°Ð´ÐµÑˆ', 23.6849937439, 90.3563308716, NULL),
(149, 3, NULL, 'Bangladesh', 23.6849937439, 90.3563308716, NULL),
(149, 5, NULL, 'Bangladesch', 23.6849937439, 90.3563308716, NULL),
(149, 6, NULL, 'Bangladesh', 23.6849937439, 90.3563308716, NULL),
(149, 7, NULL, 'Bangladesh', 23.6849937439, 90.3563308716, NULL),
(149, 8, NULL, 'Bangladesh', 23.6849937439, 90.3563308716, NULL),
(149, 61, NULL, 'Bangladesh', 23.6849937439, 90.3563308716, NULL),
(149, 79, NULL, 'å­ŸåŠ æ‹‰å›½', 23.6849937439, 90.3563308716, NULL),
(151, 2, NULL, 'Ð‘ÐµÐ½Ð¸Ð½', 9.3076896667, 2.3158340454, NULL),
(151, 3, NULL, 'Benin', 9.3076896667, 2.3158340454, NULL),
(151, 5, NULL, 'Benin', 9.3076896667, 2.3158340454, NULL),
(151, 6, NULL, 'B&eacute;nin', 9.3076896667, 2.3158340454, NULL),
(151, 7, NULL, 'Ben&iacute;n', 9.3076896667, 2.3158340454, NULL),
(151, 8, NULL, 'Benin', 9.3076896667, 2.3158340454, NULL),
(151, 61, NULL, 'Benin', 9.3076896667, 2.3158340454, NULL),
(151, 79, NULL, 'è´å®', 9.3076896667, 2.3158340454, NULL),
(152, 2, NULL, 'Ð‘ÑƒÑ‚Ð°Ð½', 27.5141620636, 90.4336013794, NULL),
(152, 3, NULL, 'Bhutan', 27.5141620636, 90.4336013794, NULL),
(152, 5, NULL, 'Bhutan', 27.5141620636, 90.4336013794, NULL),
(152, 6, NULL, 'Bhoutan', 27.5141620636, 90.4336013794, NULL),
(152, 7, NULL, 'But&aacute;n', 27.5141620636, 90.4336013794, NULL),
(152, 8, NULL, 'Bhutan', 27.5141620636, 90.4336013794, NULL),
(152, 61, NULL, 'But&atilde;o', 27.5141620636, 90.4336013794, NULL),
(152, 79, NULL, 'ä¸ä¸¹', 27.5141620636, 90.4336013794, NULL),
(154, 2, NULL, 'Ð‘Ñ€Ð¸Ñ‚Ð°Ð½ÑÐºÐ¸Ðµ Ð’Ð¸Ñ€Ð³Ð¸Ð½ÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', 18.4206943512, -64.6399688721, NULL),
(154, 3, NULL, 'British Virgin Islands', 18.4206943512, -64.6399688721, NULL),
(154, 5, NULL, 'Britische Jungferninseln', 18.4206943512, -64.6399688721, NULL),
(154, 6, NULL, 'Vierges Britanniques (Iles)', 18.4206943512, -64.6399688721, NULL),
(154, 7, NULL, 'Islas Virgenes Brit&aacute;nicas', 18.4206943512, -64.6399688721, NULL),
(154, 8, NULL, 'Vergini Britanniche, Isole', 18.4206943512, -64.6399688721, NULL),
(154, 61, NULL, 'Ilhas Virgens Brit&acirc;nicas', 18.4206943512, -64.6399688721, NULL),
(154, 79, NULL, 'è‹±å±žç»´äº¬ç¾¤å²›', 18.4206943512, -64.6399688721, NULL),
(155, 2, NULL, 'Ð‘Ñ€ÑƒÐ½ÐµÐ¹', 4.5352768898, 114.7276687622, NULL),
(155, 3, NULL, 'Brunei', 4.5352768898, 114.7276687622, NULL),
(155, 5, NULL, 'Brunei Darussalam', 4.5352768898, 114.7276687622, NULL),
(155, 6, NULL, 'Brunei', 4.5352768898, 114.7276687622, NULL),
(155, 7, NULL, 'Brun&eacute;i', 4.5352768898, 114.7276687622, NULL),
(155, 8, NULL, 'Brunei', 4.5352768898, 114.7276687622, NULL),
(155, 61, NULL, 'Brunei', 4.5352768898, 114.7276687622, NULL),
(155, 79, NULL, 'æ–‡èŽ±', 4.5352768898, 114.7276687622, NULL),
(156, 2, NULL, 'Ð‘ÑƒÑ€ÐºÐ¸Ð½Ð° Ð¤Ð°ÑÐ¾', 12.2383327484, -1.5615930557, NULL),
(156, 3, NULL, 'Burkina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 5, NULL, 'Burkina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 6, NULL, 'Burkina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 7, NULL, 'Burkina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 8, NULL, 'Burkina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 61, NULL, 'Burquina Faso', 12.2383327484, -1.5615930557, NULL),
(156, 79, NULL, 'å¸ƒåŸºçº³æ³•ç´¢', 12.2383327484, -1.5615930557, NULL),
(157, 2, NULL, 'Ð‘ÑƒÑ€ÑƒÐ½Ð´Ð¸', -3.3730559349, 29.9188861847, NULL),
(157, 3, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 5, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 6, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 7, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 8, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 61, NULL, 'Burundi', -3.3730559349, 29.9188861847, NULL),
(157, 79, NULL, 'å¸ƒéš†è¿ª', -3.3730559349, 29.9188861847, NULL),
(158, 2, NULL, 'ÐšÐ°Ð¼Ð±Ð¾Ð´Ð¶Ð°', 12.5656785965, 104.9909667969, NULL),
(158, 3, NULL, 'Cambodia', 12.5656785965, 104.9909667969, NULL),
(158, 5, NULL, 'Kambodscha', 12.5656785965, 104.9909667969, NULL),
(158, 6, NULL, 'Cambodge', 12.5656785965, 104.9909667969, NULL),
(158, 7, NULL, 'Camboya', 12.5656785965, 104.9909667969, NULL),
(158, 8, NULL, 'Cambogia', 12.5656785965, 104.9909667969, NULL),
(158, 61, NULL, 'Camboja', 12.5656785965, 104.9909667969, NULL),
(158, 79, NULL, 'æŸ¬åŸ”å¯¨', 12.5656785965, 104.9909667969, NULL),
(159, 2, NULL, 'ÐšÐ°Ð±Ð¾-Ð’ÐµÑ€Ð´Ðµ', 16.0020828247, -24.0131969452, NULL),
(159, 3, NULL, 'Cape Verde', 16.0020828247, -24.0131969452, NULL),
(159, 5, NULL, 'Kap Verde', 16.0020828247, -24.0131969452, NULL),
(159, 6, NULL, 'Cap Vert', 16.0020828247, -24.0131969452, NULL),
(159, 7, NULL, 'Cabo Verde', 16.0020828247, -24.0131969452, NULL),
(159, 8, NULL, 'Capo Verde', 16.0020828247, -24.0131969452, NULL),
(159, 61, NULL, 'Cabo Verde', 16.0020828247, -24.0131969452, NULL),
(159, 79, NULL, 'ä½›å¾—è§’', 16.0020828247, -24.0131969452, NULL),
(164, 2, NULL, 'ÐšÐ¾Ð¼Ð¾Ñ€ÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', -11.8750009537, 43.8722190857, NULL),
(164, 3, NULL, 'Comoros', -11.8750009537, 43.8722190857, NULL),
(164, 5, NULL, 'Komoren', -11.8750009537, 43.8722190857, NULL),
(164, 6, NULL, 'Comores', -11.8750009537, 43.8722190857, NULL),
(164, 7, NULL, 'Comores', -11.8750009537, 43.8722190857, NULL),
(164, 8, NULL, 'Comore', -11.8750009537, 43.8722190857, NULL),
(164, 61, NULL, 'Comores', -11.8750009537, 43.8722190857, NULL),
(164, 79, NULL, 'ç§‘æ‘©ç½—', -11.8750009537, 43.8722190857, NULL),
(165, 2, NULL, 'ÐšÐ¾Ð½Ð³Ð¾ (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 3, NULL, 'Congo (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 5, NULL, 'Kongo (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 6, NULL, 'Congo (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 7, NULL, 'Congo (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 8, NULL, 'Congo (Kinshasa)', -4.4916658401, 15.8280019760, NULL),
(165, 61, NULL, 'Congo, Rep&uacute;blica Democr&aacute;tica do', -4.4916658401, 15.8280019760, NULL),
(165, 79, NULL, 'åˆšæžœæ°‘ä¸»å…±å’Œå›½', -4.4916658401, 15.8280019760, NULL),
(166, 2, NULL, 'ÐšÑƒÐºÐ° Ð¾-Ð²Ð°', -21.2367362976, -159.7776641846, NULL),
(166, 3, NULL, 'Cook Islands', -21.2367362976, -159.7776641846, NULL),
(166, 5, NULL, 'Cookinseln', -21.2367362976, -159.7776641846, NULL),
(166, 6, NULL, 'Cook (Iles)', -21.2367362976, -159.7776641846, NULL),
(166, 7, NULL, 'Cook, Islas', -21.2367362976, -159.7776641846, NULL),
(166, 8, NULL, 'Cook, Isole', -21.2367362976, -159.7776641846, NULL),
(166, 61, NULL, 'Ilhas Cook', -21.2367362976, -159.7776641846, NULL),
(166, 79, NULL, 'åº“å…‹ç¾¤å²›', -21.2367362976, -159.7776641846, NULL),
(168, 2, NULL, 'ÐšÐ¾Ñ‚-Ð´&#039;Ð˜Ð²ÑƒÐ°Ñ€', 7.5399889946, -5.5470800400, NULL),
(168, 3, NULL, 'Cote D&#039;Ivoire', 7.5399889946, -5.5470800400, NULL),
(168, 5, NULL, 'C&ocirc;te d&#039;Ivoire', 7.5399889946, -5.5470800400, NULL),
(168, 6, NULL, 'C&ocirc;te d&#039;Ivoire', 7.5399889946, -5.5470800400, NULL),
(168, 7, NULL, 'Costa de Marfil', 7.5399889946, -5.5470800400, NULL),
(168, 8, NULL, 'Costa D&#039;Avorio', 7.5399889946, -5.5470800400, NULL),
(168, 61, NULL, 'Costa do Marfim', 7.5399889946, -5.5470800400, NULL),
(168, 79, NULL, 'è±¡ç‰™æµ·å²¸', 7.5399889946, -5.5470800400, NULL),
(169, 2, NULL, 'Ð”Ð¶Ð¸Ð±ÑƒÑ‚Ð¸', 11.8251380920, 42.5902748108, NULL),
(169, 3, NULL, 'Djibouti', 11.8251380920, 42.5902748108, NULL),
(169, 5, NULL, 'Dschibuti', 11.8251380920, 42.5902748108, NULL),
(169, 6, NULL, 'Djibouti', 11.8251380920, 42.5902748108, NULL),
(169, 7, NULL, 'Djibouti, Yibuti', 11.8251380920, 42.5902748108, NULL),
(169, 8, NULL, 'Gibuti', 11.8251380920, 42.5902748108, NULL),
(169, 61, NULL, 'Djibuti', 11.8251380920, 42.5902748108, NULL),
(169, 79, NULL, 'å‰å¸ƒæ', 11.8251380920, 42.5902748108, NULL),
(171, 2, NULL, 'Ð’Ð¾ÑÑ‚Ð¾Ñ‡Ð½Ñ‹Ð¹ Ð¢Ð¸Ð¼Ð¾Ñ€', -8.8742170334, 125.7275390625, NULL),
(171, 3, NULL, 'East Timor', -8.8742170334, 125.7275390625, NULL),
(171, 5, NULL, 'Osttimor', -8.8742170334, 125.7275390625, NULL),
(171, 6, NULL, 'Timor Oriental', -8.8742170334, 125.7275390625, NULL),
(171, 7, NULL, 'Timor Oriental', -8.8742170334, 125.7275390625, NULL),
(171, 8, NULL, 'Timor Est', -8.8742170334, 125.7275390625, NULL),
(171, 61, NULL, 'Timor Leste', -8.8742170334, 125.7275390625, NULL),
(171, 79, NULL, 'ä¸œå¸æ±¶', -8.8742170334, 125.7275390625, NULL),
(172, 2, NULL, 'Ð­ÐºÐ²Ð°Ñ‚Ð¾Ñ€Ð¸Ð°Ð»ÑŒÐ½Ð°Ñ Ð“Ð²Ð¸Ð½ÐµÑ', 1.6508009434, 10.2678947449, NULL),
(172, 3, NULL, 'Equatorial Guinea', 1.6508009434, 10.2678947449, NULL),
(172, 5, NULL, '&Auml;quatorialguinea', 1.6508009434, 10.2678947449, NULL),
(172, 6, NULL, 'Guin&eacute;e Equatoriale', 1.6508009434, 10.2678947449, NULL),
(172, 7, NULL, 'Guinea Ecuatorial', 1.6508009434, 10.2678947449, NULL),
(172, 8, NULL, 'Guinea Equatoriale', 1.6508009434, 10.2678947449, NULL),
(172, 61, NULL, 'Guin&eacute; Equatorial', 1.6508009434, 10.2678947449, NULL),
(172, 79, NULL, 'èµ¤é“å‡ å†…äºš', 1.6508009434, 10.2678947449, NULL),
(173, 2, NULL, 'Ð­Ñ€Ð¸Ñ‚Ñ€ÐµÑ', 15.1793842316, 39.7823333740, NULL),
(173, 3, NULL, 'Eritrea', 15.1793842316, 39.7823333740, NULL),
(173, 5, NULL, 'Eritrea', 15.1793842316, 39.7823333740, NULL),
(173, 6, NULL, 'Erythr&eacute;e', 15.1793842316, 39.7823333740, NULL),
(173, 7, NULL, 'Eritrea', 15.1793842316, 39.7823333740, NULL),
(173, 8, NULL, 'Eritrea', 15.1793842316, 39.7823333740, NULL),
(173, 61, NULL, 'Eritr&eacute;ia', 15.1793842316, 39.7823333740, NULL),
(173, 79, NULL, 'åŽ„ç«‹ç‰¹é‡Œäºš', 15.1793842316, 39.7823333740, NULL),
(175, 2, NULL, 'Ð¤Ð°Ñ€ÐµÑ€ÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', 61.8926353455, -6.9118061066, NULL),
(175, 3, NULL, 'Faroe Islands', 61.8926353455, -6.9118061066, NULL),
(175, 5, NULL, 'F&auml;r&ouml;er', 61.8926353455, -6.9118061066, NULL),
(175, 6, NULL, 'Faroe (Iles)', 61.8926353455, -6.9118061066, NULL),
(175, 7, NULL, 'Feroe, Islas', 61.8926353455, -6.9118061066, NULL),
(175, 8, NULL, 'Faroe, Isole', 61.8926353455, -6.9118061066, NULL),
(175, 61, NULL, 'Ilhas Faroe', 61.8926353455, -6.9118061066, NULL),
(175, 79, NULL, 'æ³•ç½—ç¾¤å²›', 61.8926353455, -6.9118061066, NULL),
(176, 2, NULL, 'Ð¤Ð¸Ð´Ð¶Ð¸', -16.5781936646, 179.4144134521, NULL),
(176, 3, NULL, 'Fiji', -16.5781936646, 179.4144134521, NULL),
(176, 5, NULL, 'Fidschi', -16.5781936646, 179.4144134521, NULL),
(176, 6, NULL, 'Fidji', -16.5781936646, 179.4144134521, NULL),
(176, 7, NULL, 'Fiyi', -16.5781936646, 179.4144134521, NULL),
(176, 8, NULL, 'Fiji', -16.5781936646, 179.4144134521, NULL),
(176, 61, NULL, 'Fiji', -16.5781936646, 179.4144134521, NULL),
(176, 79, NULL, 'æ–æµŽ', -16.5781936646, 179.4144134521, NULL),
(178, 2, NULL, 'Ð¤Ñ€Ð°Ð½Ñ†ÑƒÐ·ÑÐºÐ°Ñ ÐŸÐ¾Ð»Ð¸Ð½ÐµÐ·Ð¸Ñ', -17.6797428131, -149.4068450928, NULL),
(178, 3, NULL, 'French Polynesia', -17.6797428131, -149.4068450928, NULL),
(178, 5, NULL, 'Franz&ouml;sisch Polynesien', -17.6797428131, -149.4068450928, NULL),
(178, 6, NULL, 'Polyn&eacute;sie Fran&ccedil;aise', -17.6797428131, -149.4068450928, NULL),
(178, 7, NULL, 'Polinesia Francesa', -17.6797428131, -149.4068450928, NULL),
(178, 8, NULL, 'Polinesia Francese', -17.6797428131, -149.4068450928, NULL),
(178, 61, NULL, 'Polin&eacute;sia Francesa', -17.6797428131, -149.4068450928, NULL),
(178, 79, NULL, 'æ³•å±žæ³¢åˆ©å°¼è¥¿äºš', -17.6797428131, -149.4068450928, NULL),
(180, 2, NULL, 'Ð“Ð°Ð±Ð¾Ð½', -0.8036890030, 11.6094436646, NULL),
(180, 3, NULL, 'Gabon', -0.8036890030, 11.6094436646, NULL),
(180, 5, NULL, 'Gabu', -0.8036890030, 11.6094436646, NULL),
(180, 6, NULL, 'Gabon', -0.8036890030, 11.6094436646, NULL),
(180, 7, NULL, 'Gab&oacute;n', -0.8036890030, 11.6094436646, NULL),
(180, 8, NULL, 'Gabon', -0.8036890030, 11.6094436646, NULL),
(180, 61, NULL, 'Gab&atilde;o', -0.8036890030, 11.6094436646, NULL),
(180, 79, NULL, 'åŠ è“¬', -0.8036890030, 11.6094436646, NULL),
(181, 2, NULL, 'Ð“Ð°Ð¼Ð±Ð¸Ñ', 13.4431819916, -15.3101387024, NULL),
(181, 3, NULL, 'Gambia', 13.4431819916, -15.3101387024, NULL),
(181, 5, NULL, 'Gambia', 13.4431819916, -15.3101387024, NULL),
(181, 6, NULL, 'Gambie', 13.4431819916, -15.3101387024, NULL),
(181, 7, NULL, 'Gambia', 13.4431819916, -15.3101387024, NULL),
(181, 8, NULL, 'Gambia', 13.4431819916, -15.3101387024, NULL),
(181, 61, NULL, 'G&acirc;mbia', 13.4431819916, -15.3101387024, NULL),
(181, 79, NULL, 'å†ˆæ¯”äºš', 13.4431819916, -15.3101387024, NULL),
(184, 2, NULL, 'Ð“Ñ€ÐµÐ½Ð°Ð´Ð°', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 3, NULL, 'Grenada', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 5, NULL, 'Grenada', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 6, NULL, 'Grenade', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 7, NULL, 'Granada', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 8, NULL, 'Grenada', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 61, NULL, 'Granada', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(184, 79, NULL, 'æ ¼æž—çº³è¾¾', 12.2627763748, -61.6041717529, 'GRANADA0001.jpg'),
(185, 2, '502', 'Ð“Ð²Ð°Ñ‚ÐµÐ¼Ð°Ð»Ð°', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 3, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 5, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 6, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 7, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 8, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 61, '502', 'Guatemala', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(185, 79, '502', 'å±åœ°é©¬æ‹‰', 15.7834711075, -90.2307586670, 'GUAT0001.gif'),
(186, 2, NULL, 'Ð“ÐµÑ€Ð½ÑÐ¸ Ð¾-Ð²', 49.4656906128, -2.5852780342, NULL),
(186, 3, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(186, 5, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(186, 6, NULL, 'Guernesey (Ile)', 49.4656906128, -2.5852780342, NULL),
(186, 7, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(186, 8, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(186, 61, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(186, 79, NULL, 'Guernsey', 49.4656906128, -2.5852780342, NULL),
(187, 2, NULL, 'Ð“Ð²Ð¸Ð½ÐµÑ', 9.9455871582, -9.6966447830, NULL),
(187, 3, NULL, 'Guinea', 9.9455871582, -9.6966447830, NULL),
(187, 5, NULL, 'Guinea', 9.9455871582, -9.6966447830, NULL),
(187, 6, NULL, 'Guin&eacute;e', 9.9455871582, -9.6966447830, NULL),
(187, 7, NULL, 'Guinea', 9.9455871582, -9.6966447830, NULL),
(187, 8, NULL, 'Guinea', 9.9455871582, -9.6966447830, NULL),
(187, 61, NULL, 'Guin&eacute;', 9.9455871582, -9.6966447830, NULL),
(187, 79, NULL, 'å‡ å†…äºš', 9.9455871582, -9.6966447830, NULL),
(188, 2, NULL, 'Ð“Ð²Ð¸Ð½ÐµÑ-Ð‘Ð¸ÑÐ°Ñƒ', 11.8037490845, -15.1804132462, NULL),
(188, 3, NULL, 'Guinea-Bissau', 11.8037490845, -15.1804132462, NULL);
INSERT INTO `countries` (`id`, `id_idioma`, `id_wsp`, `nombre`, `x`, `y`, `img`) VALUES
(188, 5, NULL, 'Guinea-Bissau', 11.8037490845, -15.1804132462, NULL),
(188, 6, NULL, 'Guin&eacute;e Bissau', 11.8037490845, -15.1804132462, NULL),
(188, 7, NULL, 'Guinea-Bissau', 11.8037490845, -15.1804132462, NULL),
(188, 8, NULL, 'Guinea-Bissau', 11.8037490845, -15.1804132462, NULL),
(188, 61, NULL, 'Guin&eacute; Bissau', 11.8037490845, -15.1804132462, NULL),
(188, 79, NULL, 'å‡ å†…äºšæ¯”ç»', 11.8037490845, -15.1804132462, NULL),
(189, 2, NULL, 'Ð“Ð°Ð¹Ð°Ð½Ð°', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 3, NULL, 'Guyana', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 5, NULL, 'Guyana', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 6, NULL, 'Guyane', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 7, NULL, 'Guyana', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 8, NULL, 'Guyana', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 61, NULL, 'Guiana', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(189, 79, NULL, 'åœ­äºšé‚£', 4.8604159355, -58.9301795959, 'GUYANA0001.jpg'),
(193, 2, NULL, 'Ð”Ð¶ÐµÑ€ÑÐ¸ Ð¾-Ð²', 49.2144393921, -2.1312499046, NULL),
(193, 3, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(193, 5, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(193, 6, NULL, 'Jersey (Ile)', 49.2144393921, -2.1312499046, NULL),
(193, 7, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(193, 8, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(193, 61, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(193, 79, NULL, 'Jersey', 49.2144393921, -2.1312499046, NULL),
(195, 2, NULL, 'ÐšÐ¸Ñ€Ð¸Ð±Ð°Ñ‚Ð¸', -3.3704171181, -168.7340393066, NULL),
(195, 3, NULL, 'Kiribati', -3.3704171181, -168.7340393066, NULL),
(195, 5, NULL, 'Kiribati', -3.3704171181, -168.7340393066, NULL),
(195, 6, NULL, 'Kiribati', -3.3704171181, -168.7340393066, NULL),
(195, 7, NULL, 'Kiribati', -3.3704171181, -168.7340393066, NULL),
(195, 8, NULL, 'Kiribati', -3.3704171181, -168.7340393066, NULL),
(195, 61, NULL, 'Quiribati', -3.3704171181, -168.7340393066, NULL),
(195, 79, NULL, 'åŸºé‡Œå·´æ–¯', -3.3704171181, -168.7340393066, NULL),
(196, 2, NULL, 'Ð›Ð°Ð¾Ñ', 19.8562698364, 102.4954986572, NULL),
(196, 3, NULL, 'Laos', 19.8562698364, 102.4954986572, NULL),
(196, 5, NULL, 'Laos', 19.8562698364, 102.4954986572, NULL),
(196, 6, NULL, 'Laos', 19.8562698364, 102.4954986572, NULL),
(196, 7, NULL, 'Laos', 19.8562698364, 102.4954986572, NULL),
(196, 8, NULL, 'Laos', 19.8562698364, 102.4954986572, NULL),
(196, 61, NULL, 'Rep&uacute;blica Democr&aacute;tica Popular de Lao', 19.8562698364, 102.4954986572, NULL),
(196, 79, NULL, 'è€æŒäººæ°‘æ°‘ä¸»å…±å’Œå›½', 19.8562698364, 102.4954986572, NULL),
(197, 2, NULL, 'Ð›ÐµÑÐ¾Ñ‚Ð¾', -29.6099872589, 28.2336082458, NULL),
(197, 3, NULL, 'Lesotho', -29.6099872589, 28.2336082458, NULL),
(197, 5, NULL, 'Lesotho', -29.6099872589, 28.2336082458, NULL),
(197, 6, NULL, 'Lesotho', -29.6099872589, 28.2336082458, NULL),
(197, 7, NULL, 'Lesotho', -29.6099872589, 28.2336082458, NULL),
(197, 8, NULL, 'Lesotho', -29.6099872589, 28.2336082458, NULL),
(197, 61, NULL, 'Lesoto', -29.6099872589, 28.2336082458, NULL),
(197, 79, NULL, 'èŽ±ç´¢æ‰˜', -29.6099872589, 28.2336082458, NULL),
(198, 2, NULL, 'Ð›Ð¸Ð±ÐµÑ€Ð¸Ñ', 6.4280548096, -9.4294986725, NULL),
(198, 3, NULL, 'Liberia', 6.4280548096, -9.4294986725, NULL),
(198, 5, NULL, 'Liberia', 6.4280548096, -9.4294986725, NULL),
(198, 6, NULL, 'Lib&eacute;ria', 6.4280548096, -9.4294986725, NULL),
(198, 7, NULL, 'Liberia', 6.4280548096, -9.4294986725, NULL),
(198, 8, NULL, 'Liberia', 6.4280548096, -9.4294986725, NULL),
(198, 61, NULL, 'Lib&eacute;ria', 6.4280548096, -9.4294986725, NULL),
(198, 79, NULL, 'åˆ©æ¯”é‡Œäºš', 6.4280548096, -9.4294986725, NULL),
(200, 2, NULL, 'ÐœÐ°Ð»ÑŒÐ´Ð¸Ð²ÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', 3.2027781010, 73.2206802368, NULL),
(200, 3, NULL, 'Maldives', 3.2027781010, 73.2206802368, NULL),
(200, 5, NULL, 'Malediven', 3.2027781010, 73.2206802368, NULL),
(200, 6, NULL, 'Maldives', 3.2027781010, 73.2206802368, NULL),
(200, 7, NULL, 'Maldivas', 3.2027781010, 73.2206802368, NULL),
(200, 8, NULL, 'Maldive', 3.2027781010, 73.2206802368, NULL),
(200, 61, NULL, 'Maldivas', 3.2027781010, 73.2206802368, NULL),
(200, 79, NULL, 'é©¬å°”ä»£å¤«', 3.2027781010, 73.2206802368, NULL),
(201, 2, NULL, 'ÐœÐ°Ñ€Ñ‚Ð¸Ð½Ð¸ÐºÐ° Ð¾-Ð²', 14.6415281296, -61.0241737366, NULL),
(201, 3, NULL, 'Martinique', 14.6415281296, -61.0241737366, NULL),
(201, 5, NULL, 'Martinique', 14.6415281296, -61.0241737366, NULL),
(201, 6, NULL, 'Martinique', 14.6415281296, -61.0241737366, NULL),
(201, 7, NULL, 'Martinica', 14.6415281296, -61.0241737366, NULL),
(201, 8, NULL, 'Martinica', 14.6415281296, -61.0241737366, NULL),
(201, 61, NULL, 'Martinica', 14.6415281296, -61.0241737366, NULL),
(201, 79, NULL, 'é©¬æå°¼å…‹å²›', 14.6415281296, -61.0241737366, NULL),
(202, 2, NULL, 'ÐœÐ°Ð²Ñ€Ð¸ÐºÐ¸Ð¹', -20.3484039307, 57.5521507263, NULL),
(202, 3, NULL, 'Mauritius', -20.3484039307, 57.5521507263, NULL),
(202, 5, NULL, 'Mauritius', -20.3484039307, 57.5521507263, NULL),
(202, 6, NULL, 'Maurice (Ile)', -20.3484039307, 57.5521507263, NULL),
(202, 7, NULL, 'Mauricio', -20.3484039307, 57.5521507263, NULL),
(202, 8, NULL, 'Mauritius', -20.3484039307, 57.5521507263, NULL),
(202, 61, NULL, 'Maur&iacute;cio', -20.3484039307, 57.5521507263, NULL),
(202, 79, NULL, 'æ¯›é‡Œæ±‚æ–¯', -20.3484039307, 57.5521507263, NULL),
(205, 2, NULL, 'ÐœÑŒÑÐ½Ð¼Ð° (Ð‘Ð¸Ñ€Ð¼Ð°)', 21.9139652252, 95.9562225342, NULL),
(205, 3, NULL, 'Myanmar', 21.9139652252, 95.9562225342, NULL),
(205, 5, NULL, 'Myanmar', 21.9139652252, 95.9562225342, NULL),
(205, 6, NULL, 'Myanmar', 21.9139652252, 95.9562225342, NULL),
(205, 7, NULL, 'Myanmar', 21.9139652252, 95.9562225342, NULL),
(205, 8, NULL, 'Myanmar', 21.9139652252, 95.9562225342, NULL),
(205, 61, NULL, 'Mianm&aacute;', 21.9139652252, 95.9562225342, NULL),
(205, 79, NULL, 'ç¼…ç”¸', 21.9139652252, 95.9562225342, NULL),
(206, 2, NULL, 'ÐÐ°ÑƒÑ€Ñƒ', -0.5227779746, 166.9315032959, NULL),
(206, 3, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 5, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 6, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 7, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 8, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 61, NULL, 'Nauru', -0.5227779746, 166.9315032959, NULL),
(206, 79, NULL, 'ç‘™é²', -0.5227779746, 166.9315032959, NULL),
(207, 2, NULL, 'ÐÐ½Ñ‚Ð¸Ð»ÑŒÑÐºÐ¸Ðµ Ð¾-Ð²Ð°', 12.2260789871, -69.0600891113, NULL),
(207, 3, NULL, 'Netherlands Antilles', 12.2260789871, -69.0600891113, NULL),
(207, 5, NULL, 'Niederl&auml;ndische Antillen', 12.2260789871, -69.0600891113, NULL),
(207, 6, NULL, 'Antilles N&eacute;erlandaises', 12.2260789871, -69.0600891113, NULL),
(207, 7, NULL, 'Antillas Holandesas', 12.2260789871, -69.0600891113, NULL),
(207, 8, NULL, 'Antille Olandesi', 12.2260789871, -69.0600891113, NULL),
(207, 61, NULL, 'Antilhas Holandesas', 12.2260789871, -69.0600891113, NULL),
(207, 79, NULL, 'è·å±žå®‰çš„åˆ—æ–¯ç¾¤å²›', 12.2260789871, -69.0600891113, NULL),
(208, 2, NULL, 'ÐÐ¾Ð²Ð°Ñ ÐšÐ°Ð»ÐµÐ´Ð¾Ð½Ð¸Ñ Ð¾-Ð²', -20.9043045044, 165.6180419922, NULL),
(208, 3, NULL, 'New Caledonia', -20.9043045044, 165.6180419922, NULL),
(208, 5, NULL, 'Neukaledonien', -20.9043045044, 165.6180419922, NULL),
(208, 6, NULL, 'Nouvelle Cal&eacute;donie', -20.9043045044, 165.6180419922, NULL),
(208, 7, NULL, 'Nueva Caledonia', -20.9043045044, 165.6180419922, NULL),
(208, 8, NULL, 'Nuova Caledonia', -20.9043045044, 165.6180419922, NULL),
(208, 61, NULL, 'Nova Caled&ocirc;nia', -20.9043045044, 165.6180419922, NULL),
(208, 79, NULL, 'æ–°å–€é‡Œå¤šå°¼äºš', -20.9043045044, 165.6180419922, NULL),
(209, 2, '505', 'ÐÐ¸ÐºÐ°Ñ€Ð°Ð³ÑƒÐ°', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 3, '505', 'Nicaragua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 5, '505', 'Nicaragua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 6, '505', 'Nicaragua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 7, '505', 'Nicaragua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 8, '505', 'Nicaragua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 61, '505', 'Nicar&aacute;gua', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(209, 79, '505', 'å°¼åŠ æ‹‰ç“œ', 12.8654155731, -85.2072296143, 'NICARAGUA001.jpg'),
(210, 2, NULL, 'ÐÐ¸Ð³ÐµÑ€', 17.6077880859, 8.0816659927, NULL),
(210, 3, NULL, 'Niger', 17.6077880859, 8.0816659927, NULL),
(210, 5, NULL, 'Niger', 17.6077880859, 8.0816659927, NULL),
(210, 6, NULL, 'Niger', 17.6077880859, 8.0816659927, NULL),
(210, 7, NULL, 'N&iacute;ger', 17.6077880859, 8.0816659927, NULL),
(210, 8, NULL, 'Niger', 17.6077880859, 8.0816659927, NULL),
(210, 61, NULL, 'N&iacute;ger', 17.6077880859, 8.0816659927, NULL),
(210, 79, NULL, 'å°¼æ—¥å°”', 17.6077880859, 8.0816659927, NULL),
(212, 2, NULL, 'ÐÐ¾Ñ€Ñ„Ð¾Ð»Ðº Ð¾-Ð²', -29.0408344269, 167.9547119141, NULL),
(212, 3, NULL, 'Norfolk Island', -29.0408344269, 167.9547119141, NULL),
(212, 5, NULL, 'Norfolkinsel', -29.0408344269, 167.9547119141, NULL),
(212, 6, NULL, 'Norfolk (Ile)', -29.0408344269, 167.9547119141, NULL),
(212, 7, NULL, 'Norfolk Island', -29.0408344269, 167.9547119141, NULL),
(212, 8, NULL, 'Norfolk, Isola', -29.0408344269, 167.9547119141, NULL),
(212, 61, NULL, 'Ilha Norfolk', -29.0408344269, 167.9547119141, NULL),
(212, 79, NULL, 'è¯ºç¦å…‹å²›', -29.0408344269, 167.9547119141, NULL),
(213, 2, NULL, 'ÐžÐ¼Ð°Ð½', 21.5125827789, 55.9232559204, NULL),
(213, 3, NULL, 'Oman', 21.5125827789, 55.9232559204, NULL),
(213, 5, NULL, 'Oman', 21.5125827789, 55.9232559204, NULL),
(213, 6, NULL, 'Oman', 21.5125827789, 55.9232559204, NULL),
(213, 7, NULL, 'Om&aacute;n', 21.5125827789, 55.9232559204, NULL),
(213, 8, NULL, 'Oman', 21.5125827789, 55.9232559204, NULL),
(213, 61, NULL, 'Om&atilde;', 21.5125827789, 55.9232559204, NULL),
(213, 79, NULL, 'é˜¿æ›¼', 21.5125827789, 55.9232559204, NULL),
(215, 2, NULL, 'ÐŸÐ¸Ñ‚ÐºÑÑ€Ð½ Ð¾-Ð²', -24.7036151886, -127.4393081665, NULL),
(215, 3, NULL, 'Pitcairn Islands', -24.7036151886, -127.4393081665, NULL),
(215, 5, NULL, 'Pitcairninseln', -24.7036151886, -127.4393081665, NULL),
(215, 6, NULL, 'Pitcairn (Iles)', -24.7036151886, -127.4393081665, NULL),
(215, 7, NULL, 'Isla Pitcairn', -24.7036151886, -127.4393081665, NULL),
(215, 8, NULL, 'Pitcairn, Isola', -24.7036151886, -127.4393081665, NULL),
(215, 61, NULL, 'Pitcairn', -24.7036151886, -127.4393081665, NULL),
(215, 79, NULL, 'çš®ç‰¹å‡¯æ©', -24.7036151886, -127.4393081665, NULL),
(216, 2, NULL, 'ÐšÐ°Ñ‚Ð°Ñ€', 25.3548259735, 51.1838836670, NULL),
(216, 3, NULL, 'Qatar', 25.3548259735, 51.1838836670, NULL),
(216, 5, NULL, 'Katar', 25.3548259735, 51.1838836670, NULL),
(216, 6, NULL, 'Qatar', 25.3548259735, 51.1838836670, NULL),
(216, 7, NULL, 'Qatar', 25.3548259735, 51.1838836670, NULL),
(216, 8, NULL, 'Qatar', 25.3548259735, 51.1838836670, NULL),
(216, 61, NULL, 'Catar', 25.3548259735, 51.1838836670, NULL),
(216, 79, NULL, 'å¡å¡”å°”', 25.3548259735, 51.1838836670, NULL),
(217, 2, NULL, 'Ð ÑƒÐ°Ð½Ð´Ð°', -1.9402780533, 29.8738880157, NULL),
(217, 3, NULL, 'Rwanda', -1.9402780533, 29.8738880157, NULL),
(217, 5, NULL, 'Ruanda', -1.9402780533, 29.8738880157, NULL),
(217, 6, NULL, 'Rwanda', -1.9402780533, 29.8738880157, NULL),
(217, 7, NULL, 'Ruanda', -1.9402780533, 29.8738880157, NULL),
(217, 8, NULL, 'Rwanda', -1.9402780533, 29.8738880157, NULL),
(217, 61, NULL, 'Ruanda', -1.9402780533, 29.8738880157, NULL),
(217, 79, NULL, 'å¢æ—ºè¾¾', -1.9402780533, 29.8738880157, NULL),
(218, 2, NULL, 'Ð¡Ð²ÑÑ‚Ð¾Ð¹ Ð•Ð»ÐµÐ½Ñ‹ Ð¾-Ð²', -24.1434745789, -10.0306959152, NULL),
(218, 3, NULL, 'Saint Helena', -24.1434745789, -10.0306959152, NULL),
(218, 5, NULL, 'St. Helena', -24.1434745789, -10.0306959152, NULL),
(218, 6, NULL, 'Sainte H&eacute;l&egrave;ne (Iles)', -24.1434745789, -10.0306959152, NULL),
(218, 7, NULL, 'Santa Elena', -24.1434745789, -10.0306959152, NULL),
(218, 8, NULL, 'Sant&#039;Elena', -24.1434745789, -10.0306959152, NULL),
(218, 61, NULL, 'Santa Helena', -24.1434745789, -10.0306959152, NULL),
(218, 79, NULL, 'åœ£èµ«å‹’æ‹¿', -24.1434745789, -10.0306959152, NULL),
(219, 2, NULL, 'Ð¡ÐµÐ½Ñ‚ ÐšÐ¸Ñ‚Ñ Ð¸ ÐÐµÐ²Ð¸Ñ', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 3, NULL, 'Saint Kitts and Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 5, NULL, 'St. Kitts und Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 6, NULL, 'Saint Kitts et Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 7, NULL, 'San Cristobal y Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 8, NULL, 'Saint Kitts e Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 61, NULL, 'S&atilde;o Cristov&atilde;o e Nevis', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(219, 79, NULL, 'åœ£åŸºèŒ¨å’Œå°¼ç»´æ–¯', 17.3578224182, -62.7829971313, 'SANCRISTOBAL0001.jpg'),
(220, 2, NULL, 'Ð¡Ð²ÑÑ‚Ð°Ñ Ð›ÑŽÑÐ¸Ñ', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 3, NULL, 'Saint Lucia', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 5, NULL, 'St. Lucia', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 6, NULL, 'Sainte Lucie', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 7, NULL, 'Santa Luc&iacute;a', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 8, NULL, 'Santa Lucia', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 61, NULL, 'Santa L&uacute;cia', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(220, 79, NULL, 'åœ£å¢è¥¿äºš', 13.9094438553, -60.9788932800, 'SANTALUCIA001.jpg'),
(221, 2, NULL, 'Ð¡ÐµÐ½-ÐŸÑŒÐµÑ€ Ð¸ ÐœÐ¸ÐºÐµÐ»Ð¾Ð½', 46.9419364929, -56.2711105347, NULL),
(221, 3, NULL, 'Saint Pierre and Miquelon', 46.9419364929, -56.2711105347, NULL),
(221, 5, NULL, 'St. Pierre und Miquelon', 46.9419364929, -56.2711105347, NULL),
(221, 6, NULL, 'Saint Pierre et Miquelon', 46.9419364929, -56.2711105347, NULL),
(221, 7, NULL, 'San Pedro y Miquel&oacute;n', 46.9419364929, -56.2711105347, NULL),
(221, 8, NULL, 'Saint Pierre e Miquelon', 46.9419364929, -56.2711105347, NULL),
(221, 61, NULL, 'Saint Pierre e Miquelon', 46.9419364929, -56.2711105347, NULL),
(221, 79, NULL, 'åœ£çš®åŸƒå°”å’Œå¯†å…‹éš†', 46.9419364929, -56.2711105347, NULL),
(222, 2, NULL, 'Ð¡ÐµÐ½Ñ‚-Ð’Ð¸Ð½ÑÐµÐ½Ñ‚ Ð¸ Ð“Ñ€ÐµÐ½Ð°Ð´Ð¸Ð½Ñ‹', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 3, NULL, 'Saint Vincent and the Grenadines', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 5, NULL, 'St. Vincent und die Grenadinen', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 6, NULL, 'Saint Vincent', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 7, NULL, 'San Vincente y Granadinas', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 8, NULL, 'Saint Vincent e Grenadines', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 61, NULL, 'S&atilde;o Vicente e Granadinas', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(222, 79, NULL, 'åœ£æ–‡æ£®ç‰¹å’Œæ ¼æž—çº³ä¸æ–¯', 12.9843053818, -61.2872276306, 'SANCRISTOBAL0001.jpg'),
(223, 2, NULL, 'Ð¡Ð°Ð¼Ð¾Ð°', -13.7590293884, -172.1046295166, NULL),
(223, 3, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 5, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 6, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 7, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 8, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 61, NULL, 'Samoa', -13.7590293884, -172.1046295166, NULL),
(223, 79, NULL, 'è¨æ‘©äºš', -13.7590293884, -172.1046295166, NULL),
(224, 2, NULL, 'Ð¡Ð°Ð½-ÐœÐ°Ñ€Ð¸Ð½Ð¾', 43.9423599243, 12.4577770233, NULL),
(224, 3, NULL, 'San Marino', 43.9423599243, 12.4577770233, NULL),
(224, 5, NULL, 'San Marino', 43.9423599243, 12.4577770233, NULL),
(224, 6, NULL, 'Saint Marin', 43.9423599243, 12.4577770233, NULL),
(224, 7, NULL, 'San Marino', 43.9423599243, 12.4577770233, NULL),
(224, 8, NULL, 'San Marino', 43.9423599243, 12.4577770233, NULL),
(224, 61, NULL, 'San Marino', 43.9423599243, 12.4577770233, NULL),
(224, 79, NULL, 'åœ£é©¬åŠ›è¯º', 43.9423599243, 12.4577770233, NULL),
(225, 2, NULL, 'Ð¡Ð°Ð½-Ð¢Ð¾Ð¼Ðµ Ð¸ ÐŸÑ€Ð¸Ð½ÑÐ¸Ð¿Ð¸', 0.1863600016, 6.6130809784, NULL),
(225, 3, NULL, 'Sao Tome and Principe', 0.1863600016, 6.6130809784, NULL),
(225, 5, NULL, 'S&atilde;o Tom&eacute; und Pr&iacute;ncipe', 0.1863600016, 6.6130809784, NULL),
(225, 6, NULL, 'Sao Tome e Pr&iacute;ncipe', 0.1863600016, 6.6130809784, NULL),
(225, 7, NULL, 'San Tom&eacute; y Pr&iacute;ncipe', 0.1863600016, 6.6130809784, NULL),
(225, 8, NULL, 'Sao Tome e Prinicipe', 0.1863600016, 6.6130809784, NULL),
(225, 61, NULL, 'S&atilde;o Tom&eacute; e Pr&iacute;ncipe', 0.1863600016, 6.6130809784, NULL),
(225, 79, NULL, 'åœ£å¤šç¾Žå’Œæ™®æž—è¥¿æ¯”', 0.1863600016, 6.6130809784, NULL),
(226, 2, NULL, 'Ð¡ÐµÑ€Ð±Ð¸Ñ Ð¸ Ð§ÐµÑ€Ð½Ð¾Ð³Ð¾Ñ€Ð¸Ñ', 43.6679191589, 21.0566902161, NULL),
(226, 3, NULL, 'Serbia and Montenegro', 43.6679191589, 21.0566902161, NULL),
(226, 5, NULL, 'Serbien und Montenegro', 43.6679191589, 21.0566902161, NULL),
(226, 6, NULL, 'Serbie et Mont&eacute;negro', 43.6679191589, 21.0566902161, NULL),
(226, 7, NULL, 'Serbia y Montenegro', 43.6679191589, 21.0566902161, NULL),
(226, 8, NULL, 'Serbia e Montenegro', 43.6679191589, 21.0566902161, NULL),
(226, 61, NULL, 'Serbia and Montenegro', 43.6679191589, 21.0566902161, NULL),
(226, 79, NULL, 'Serbia and Montenegro', 43.6679191589, 21.0566902161, NULL),
(227, 2, NULL, 'Ð¡ÑŒÐµÑ€Ñ€Ð°-Ð›ÐµÐ¾Ð½Ðµ', 8.4605550766, -11.7798891068, NULL),
(227, 3, NULL, 'Sierra Leone', 8.4605550766, -11.7798891068, NULL),
(227, 5, NULL, 'Sierra Leone', 8.4605550766, -11.7798891068, NULL),
(227, 6, NULL, 'Sierra Leone', 8.4605550766, -11.7798891068, NULL),
(227, 7, NULL, 'Sierra Leona', 8.4605550766, -11.7798891068, NULL),
(227, 8, NULL, 'Sierra Leone', 8.4605550766, -11.7798891068, NULL),
(227, 61, NULL, 'Serra Leoa', 8.4605550766, -11.7798891068, NULL),
(227, 79, NULL, 'å¡žæ‹‰åˆ©æ˜‚', 8.4605550766, -11.7798891068, NULL),
(228, 2, NULL, 'Ð¡Ð¾Ð»Ð¾Ð¼Ð¾Ð½Ð¾Ð²Ñ‹ Ð¾-Ð²Ð°', -9.6457099915, 160.1561889648, NULL),
(228, 3, NULL, 'Solomon Islands', -9.6457099915, 160.1561889648, NULL),
(228, 5, NULL, 'Salomonen', -9.6457099915, 160.1561889648, NULL),
(228, 6, NULL, 'Salomon (Iles)', -9.6457099915, 160.1561889648, NULL),
(228, 7, NULL, 'Islas Salom&oacute;n', -9.6457099915, 160.1561889648, NULL),
(228, 8, NULL, 'Solomone, Isole', -9.6457099915, 160.1561889648, NULL),
(228, 61, NULL, 'Ilhas Salom&atilde;o', -9.6457099915, 160.1561889648, NULL),
(228, 79, NULL, 'æ‰€ç½—é—¨ç¾¤å²›', -9.6457099915, 160.1561889648, NULL),
(229, 2, NULL, 'Ð¡Ð¾Ð¼Ð°Ð»Ð¸', 5.1521492004, 46.1996154785, NULL),
(229, 3, NULL, 'Somalia', 5.1521492004, 46.1996154785, NULL),
(229, 5, NULL, 'Somalia', 5.1521492004, 46.1996154785, NULL),
(229, 6, NULL, 'Somalie', 5.1521492004, 46.1996154785, NULL),
(229, 7, NULL, 'Somalia', 5.1521492004, 46.1996154785, NULL),
(229, 8, NULL, 'Somalia', 5.1521492004, 46.1996154785, NULL),
(229, 61, NULL, 'Som&aacute;lia', 5.1521492004, 46.1996154785, NULL),
(229, 79, NULL, 'ç´¢é©¬é‡Œ', 5.1521492004, 46.1996154785, NULL),
(232, 2, NULL, 'Ð¡ÑƒÐ´Ð°Ð½', 12.8628072739, 30.2176361084, NULL),
(232, 3, NULL, 'Sudan', 12.8628072739, 30.2176361084, NULL),
(232, 5, NULL, 'Sudan', 12.8628072739, 30.2176361084, NULL),
(232, 6, NULL, 'Soudan', 12.8628072739, 30.2176361084, NULL),
(232, 7, NULL, 'Sud&aacute;n', 12.8628072739, 30.2176361084, NULL),
(232, 8, NULL, 'Sudan', 12.8628072739, 30.2176361084, NULL),
(232, 61, NULL, 'Sud&atilde;o', 12.8628072739, 30.2176361084, NULL),
(232, 79, NULL, 'è‹ä¸¹', 12.8628072739, 30.2176361084, NULL),
(234, 2, NULL, 'Ð¡Ð²Ð°Ð·Ð¸Ð»ÐµÐ½Ð´', -26.5225028992, 31.4658660889, NULL),
(234, 3, NULL, 'Swaziland', -26.5225028992, 31.4658660889, NULL),
(234, 5, NULL, 'Swasiland', -26.5225028992, 31.4658660889, NULL),
(234, 6, NULL, 'Swaziland', -26.5225028992, 31.4658660889, NULL),
(234, 7, NULL, 'Swazilandia', -26.5225028992, 31.4658660889, NULL),
(234, 8, NULL, 'Swaziland', -26.5225028992, 31.4658660889, NULL),
(234, 61, NULL, 'Suazil&acirc;ndia', -26.5225028992, 31.4658660889, NULL),
(234, 79, NULL, 'æ–¯å¨å£«å…°', -26.5225028992, 31.4658660889, NULL),
(235, 2, NULL, 'Ð¢Ð¾ÐºÐµÐ»Ð°Ñƒ Ð¾-Ð²Ð°', -8.9673633575, -171.8558807373, NULL),
(235, 3, NULL, 'Tokelau', -8.9673633575, -171.8558807373, NULL),
(235, 5, NULL, 'Tokelau', -8.9673633575, -171.8558807373, NULL),
(235, 6, NULL, 'Tokelau (Iles)', -8.9673633575, -171.8558807373, NULL),
(235, 7, NULL, 'Tokelau', -8.9673633575, -171.8558807373, NULL),
(235, 8, NULL, 'Tokelau', -8.9673633575, -171.8558807373, NULL),
(235, 61, NULL, 'Tokelau', -8.9673633575, -171.8558807373, NULL),
(235, 79, NULL, 'æ‰˜å…‹åŠ³', -8.9673633575, -171.8558807373, NULL),
(236, 2, NULL, 'Ð¢Ð¾Ð½Ð³Ð°', -21.1789855957, -175.1982421875, NULL),
(236, 3, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 5, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 6, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 7, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 8, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 61, NULL, 'Tonga', -21.1789855957, -175.1982421875, NULL),
(236, 79, NULL, 'æ±¤åŠ ', -21.1789855957, -175.1982421875, NULL),
(237, 2, NULL, 'Ð¢Ñ€Ð¸Ð½Ð¸Ð´Ð°Ð´ Ð¸ Ð¢Ð¾Ð±Ð°Ð³Ð¾', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 3, NULL, 'Trinidad and Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 5, NULL, 'Trinidad und Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 6, NULL, 'Trinit&eacute; et Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 7, NULL, 'Trinidad y Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 8, NULL, 'Trinidad e Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 61, NULL, 'Trinidad e Tobago', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(237, 79, NULL, 'ç‰¹ç«‹å°¼è¾¾å’Œå¤šå·´å“¥', 10.6918029785, -61.2225036621, 'TRINIDAD001.jpg'),
(239, 2, NULL, 'Ð¢ÑƒÐ²Ð°Ð»Ñƒ', -7.1095352173, 177.6493225098, NULL),
(239, 3, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 5, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 6, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 7, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 8, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 61, NULL, 'Tuvalu', -7.1095352173, 177.6493225098, NULL),
(239, 79, NULL, 'å›¾ç“¦å¢', -7.1095352173, 177.6493225098, NULL),
(240, 2, NULL, 'Ð’Ð°Ð½ÑƒÐ°Ñ‚Ñƒ', -15.3767061234, 166.9591522217, NULL),
(240, 3, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 5, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 6, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 7, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 8, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 61, NULL, 'Vanuatu', -15.3767061234, 166.9591522217, NULL),
(240, 79, NULL, 'ç“¦åŠªé˜¿å›¾', -15.3767061234, 166.9591522217, NULL),
(241, 2, NULL, 'Ð’Ð°Ð»Ð»Ð¸Ñ Ð¸ Ð¤ÑƒÑ‚ÑƒÐ½Ð° Ð¾-Ð²Ð°', -13.7687520981, -177.1560974121, NULL),
(241, 3, NULL, 'Wallis and Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 5, NULL, 'Wallis und Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 6, NULL, 'Wallis et Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 7, NULL, 'Wallis y Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 8, NULL, 'Wallis e Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 61, NULL, 'Wallis e Futuna', -13.7687520981, -177.1560974121, NULL),
(241, 79, NULL, 'ç“¦åˆ©æ–¯å’Œå¯Œå›¾çº³', -13.7687520981, -177.1560974121, NULL),
(242, 2, NULL, 'Ð—Ð°Ð¿Ð°Ð´Ð½Ð°Ñ Ð¡Ð°Ñ…Ð°Ñ€Ð°', 24.2155265808, -12.8858337402, NULL),
(242, 3, NULL, 'Western Sahara', 24.2155265808, -12.8858337402, NULL),
(242, 5, NULL, 'Westsahara', 24.2155265808, -12.8858337402, NULL),
(242, 6, NULL, 'Sahara Occidental', 24.2155265808, -12.8858337402, NULL),
(242, 7, NULL, 'S&aacute;hara Occidental', 24.2155265808, -12.8858337402, NULL),
(242, 8, NULL, 'Sahara Occidentale', 24.2155265808, -12.8858337402, NULL),
(242, 61, NULL, 'Saara Ocidental', 24.2155265808, -12.8858337402, NULL),
(242, 79, NULL, 'è¥¿æ’’å“ˆæ‹‰', 24.2155265808, -12.8858337402, NULL),
(243, 2, NULL, 'Ð™ÐµÐ¼ÐµÐ½', 15.5527267456, 48.5163879395, NULL),
(243, 3, NULL, 'Yemen', 15.5527267456, 48.5163879395, NULL),
(243, 5, NULL, 'Jemen', 15.5527267456, 48.5163879395, NULL),
(243, 6, NULL, 'Y&eacute;men', 15.5527267456, 48.5163879395, NULL),
(243, 7, NULL, 'Yemen', 15.5527267456, 48.5163879395, NULL),
(243, 8, NULL, 'Yemen', 15.5527267456, 48.5163879395, NULL),
(243, 61, NULL, 'I&ecirc;men', 15.5527267456, 48.5163879395, NULL),
(243, 79, NULL, 'ä¹Ÿé—¨', 15.5527267456, 48.5163879395, NULL),
(246, 2, '1', 'ÐŸÑƒÑÑ€Ñ‚Ð¾ Ð Ð¸ÐºÐ¾', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 3, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 5, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 6, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 7, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 8, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 61, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg'),
(246, 79, '1', 'Puerto Rico', 18.2208328247, -66.5901489258, 'PUERTORICO0001.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_bancarias`
--

CREATE TABLE `cuentas_bancarias` (
  `id` int(11) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `numero_cuenta` varchar(50) NOT NULL,
  `tipo_cuenta` varchar(20) NOT NULL,
  `saldo` decimal(12,2) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `range_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `country_id` smallint(5) UNSIGNED DEFAULT NULL,
  `membership_id` bigint(20) UNSIGNED DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL,
  `co_name` varchar(150) DEFAULT NULL,
  `co_dni` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `mother_last` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `dni` char(8) DEFAULT NULL,
  `passport` varchar(15) DEFAULT NULL,
  `temporal` enum('1','2') DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `wallet` varchar(50) DEFAULT NULL,
  `pin` varchar(6) DEFAULT NULL,
  `kyc` enum('0','1','2','3') DEFAULT NULL,
  `ads` enum('0','1') NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `date_active` datetime DEFAULT NULL,
  `pay` int(11) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `ruc` char(11) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `account_deductions` varchar(100) DEFAULT NULL,
  `address_company` varchar(150) DEFAULT NULL,
  `tipo_comprobante` varchar(50) DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `adm` enum('0','1') NOT NULL DEFAULT '0',
  `tipo_agente` varchar(20) DEFAULT NULL,
  `actived_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `estado_renovacion` varchar(20) DEFAULT 'vigente',
  `fecha_renovacion` date DEFAULT NULL,
  `retencion` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `range_id`, `username`, `code`, `country_id`, `membership_id`, `password`, `name`, `lastname`, `co_name`, `co_dni`, `address`, `mother_last`, `phone`, `dni`, `passport`, `temporal`, `email`, `wallet`, `pin`, `kyc`, `ads`, `date`, `date_active`, `pay`, `avatar`, `ruc`, `company_name`, `account_deductions`, `address_company`, `tipo_comprobante`, `active`, `adm`, `tipo_agente`, `actived_at`, `created_at`, `updated_at`, `deleted_at`, `civil_status`, `estado_renovacion`, `fecha_renovacion`, `retencion`) VALUES
(1, 0, NULL, '', 89, 0, '$2y$10$fvUFTA9CSh6sPH6mAu9EuufiboamcQnI5COeG89FqSlnIOhWXlmqe', 'Jose Luis', 'TARRILLO', NULL, NULL, 'Mz C lote 4 San Remo II', 'Chuquiruna', '949260149', '72920325', NULL, NULL, 'jtarrillochuquiruna@gmail.com', NULL, NULL, NULL, '1', '2026-03-25', NULL, 0, NULL, '', NULL, NULL, NULL, NULL, '1', '0', 'externo', NULL, '2026-03-25 18:20:34', NULL, NULL, 'Soltero', 'vigente', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_bank`
--

CREATE TABLE `customer_bank` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(50) NOT NULL,
  `cci` varchar(50) NOT NULL,
  `active` enum('0','1') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_bank`
--

INSERT INTO `customer_bank` (`id`, `customer_id`, `bank_id`, `number`, `cci`, `active`, `created_at`, `updated_at`) VALUES
(1, 4, 14, '19431470393074', ' 00219413147039307497', '1', '2024-12-10 14:38:40', '0000-00-00 00:00:00'),
(2, 1, 13, '0110034436', '00907920011003443651', '1', '2025-01-05 07:21:42', '2025-10-31 18:49:22'),
(3, 2, 14, '123', '123', '1', '2025-02-17 15:38:42', '0000-00-00 00:00:00'),
(4, 3, 14, '.', '.', '1', '2025-04-11 15:48:03', '0000-00-00 00:00:00'),
(5, 43, 14, '000000', '000000', '1', '2025-06-13 17:41:45', '0000-00-00 00:00:00'),
(6, 9, 14, '000', '000', '1', '2025-06-14 09:57:32', '0000-00-00 00:00:00'),
(7, 202, 13, '20962031006', '0011 0083 0200310937 34', '1', '2025-10-28 15:37:20', '0000-00-00 00:00:00'),
(8, 28, 13, '20962031006', '00907920011003443651', '1', '2025-10-28 17:36:04', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `declaraciones_tributarias`
--

CREATE TABLE `declaraciones_tributarias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periodo` varchar(10) NOT NULL,
  `total_ventas` decimal(14,2) DEFAULT 0.00,
  `total_compras` decimal(14,2) DEFAULT 0.00,
  `igv_a_pagar` decimal(14,2) DEFAULT 0.00,
  `estado` varchar(20) DEFAULT 'borrador',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'AMAZONAS'),
(2, 'ANCASH'),
(3, 'APURIMAC'),
(4, 'AREQUIPA'),
(5, 'AYACUCHO'),
(6, 'CAJAMARCA'),
(7, 'CALLAO'),
(8, 'CUSCO'),
(9, 'HUANCAVELICA'),
(10, 'HUANUCO'),
(11, 'ICA'),
(12, 'JUNIN'),
(13, 'LA LIBERTAD'),
(14, 'LAMBAYEQUE'),
(15, 'LIMA'),
(16, 'LORETO'),
(17, 'MADRE DE DIOS'),
(18, 'MOQUEGUA'),
(19, 'PASCO'),
(20, 'PIURA'),
(21, 'PUNO'),
(22, 'SAN MARTIN'),
(23, 'TACNA'),
(24, 'TUMBES'),
(25, 'UCAYALI');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `province_id`) VALUES
(1, 'CHACHAPOYAS', 1),
(2, 'ASUNCION', 1),
(3, 'BALSAS', 1),
(4, 'CHETO', 1),
(5, 'CHILIQUIN', 1),
(6, 'CHUQUIBAMBA', 1),
(7, 'GRANADA', 1),
(8, 'HUANCAS', 1),
(9, 'LA JALCA', 1),
(10, 'LEIMEBAMBA', 1),
(11, 'LEVANTO', 1),
(12, 'MAGDALENA', 1),
(13, 'MARISCAL CASTILLA', 1),
(14, 'MOLINOPAMPA', 1),
(15, 'MONTEVIDEO', 1),
(16, 'OLLEROS', 1),
(17, 'QUINJALCA', 1),
(18, 'SAN FRANCISCO DE DAGUAS', 1),
(19, 'SAN ISIDRO DE MAINO', 1),
(20, 'SOLOCO', 1),
(21, 'SONCHE', 1),
(22, 'BAGUA', 2),
(23, 'ARAMANGO', 2),
(24, 'COPALLIN', 2),
(25, 'EL PARCO', 2),
(26, 'IMAZA', 2),
(27, 'LA PECA', 2),
(28, 'JUMBILLA', 3),
(29, 'CHISQUILLA', 3),
(30, 'CHURUJA', 3),
(31, 'COROSHA', 3),
(32, 'CUISPES', 3),
(33, 'FLORIDA', 3),
(34, 'JAZAN', 3),
(35, 'RECTA', 3),
(36, 'SAN CARLOS', 3),
(37, 'SHIPASBAMBA', 3),
(38, 'VALERA', 3),
(39, 'YAMBRASBAMBA', 3),
(40, 'NIEVA', 4),
(41, 'EL CENEPA', 4),
(42, 'RIO SANTIAGO', 4),
(43, 'LAMUD', 5),
(44, 'CAMPORREDONDO', 5),
(45, 'COCABAMBA', 5),
(46, 'COLCAMAR', 5),
(47, 'CONILA', 5),
(48, 'INGUILPATA', 5),
(49, 'LONGUITA', 5),
(50, 'LONYA CHICO', 5),
(51, 'LUYA', 5),
(52, 'LUYA VIEJO', 5),
(53, 'MARIA', 5),
(54, 'OCALLI', 5),
(55, 'OCUMAL', 5),
(56, 'PISUQUIA', 5),
(57, 'PROVIDENCIA', 5),
(58, 'SAN CRISTOBAL', 5),
(59, 'SAN FRANCISCO DEL YESO', 5),
(60, 'SAN JERONIMO', 5),
(61, 'SAN JUAN DE LOPECANCHA', 5),
(62, 'SANTA CATALINA', 5),
(63, 'SANTO TOMAS', 5),
(64, 'TINGO', 5),
(65, 'TRITA', 5),
(66, 'SAN NICOLAS', 6),
(67, 'CHIRIMOTO', 6),
(68, 'COCHAMAL', 6),
(69, 'HUAMBO', 6),
(70, 'LIMABAMBA', 6),
(71, 'LONGAR', 6),
(72, 'MARISCAL BENAVIDES', 6),
(73, 'MILPUC', 6),
(74, 'OMIA', 6),
(75, 'SANTA ROSA', 6),
(76, 'TOTORA', 6),
(77, 'VISTA ALEGRE', 6),
(78, 'BAGUA GRANDE', 7),
(79, 'CAJARURO', 7),
(80, 'CUMBA', 7),
(81, 'EL MILAGRO', 7),
(82, 'JAMALCA', 7),
(83, 'LONYA GRANDE', 7),
(84, 'YAMON', 7),
(85, 'HUARAZ', 8),
(86, 'COCHABAMBA', 8),
(87, 'COLCABAMBA', 8),
(88, 'HUANCHAY', 8),
(89, 'INDEPENDENCIA', 8),
(90, 'JANGAS', 8),
(91, 'LA LIBERTAD', 8),
(92, 'OLLEROS', 8),
(93, 'PAMPAS', 8),
(94, 'PARIACOTO', 8),
(95, 'PIRA', 8),
(96, 'TARICA', 8),
(97, 'AIJA', 9),
(98, 'CORIS', 9),
(99, 'HUACLLAN', 9),
(100, 'LA MERCED', 9),
(101, 'SUCCHA', 9),
(102, 'LLAMELLIN', 10),
(103, 'ACZO', 10),
(104, 'CHACCHO', 10),
(105, 'CHINGAS', 10),
(106, 'MIRGAS', 10),
(107, 'SAN JUAN DE RONTOY', 10),
(108, 'CHACAS', 11),
(109, 'ACOCHACA', 11),
(110, 'CHIQUIAN', 12),
(111, 'ABELARDO PARDO LEZAMETA', 12),
(112, 'ANTONIO RAYMONDI', 12),
(113, 'AQUIA', 12),
(114, 'CAJACAY', 12),
(115, 'CANIS', 12),
(116, 'COLQUIOC', 12),
(117, 'HUALLANCA', 12),
(118, 'HUASTA', 12),
(119, 'HUAYLLACAYAN', 12),
(120, 'LA PRIMAVERA', 12),
(121, 'MANGAS', 12),
(122, 'PACLLON', 12),
(123, 'SAN MIGUEL DE CORPANQUI', 12),
(124, 'TICLLOS', 12),
(125, 'CARHUAZ', 13),
(126, 'ACOPAMPA', 13),
(127, 'AMASHCA', 13),
(128, 'ANTA', 13),
(129, 'ATAQUERO', 13),
(130, 'MARCARA', 13),
(131, 'PARIAHUANCA', 13),
(132, 'SAN MIGUEL DE ACO', 13),
(133, 'SHILLA', 13),
(134, 'TINCO', 13),
(135, 'YUNGAR', 13),
(136, 'SAN LUIS', 14),
(137, 'SAN NICOLAS', 14),
(138, 'YAUYA', 14),
(139, 'CASMA', 15),
(140, 'BUENA VISTA ALTA', 15),
(141, 'COMANDANTE NOEL', 15),
(142, 'YAUTAN', 15),
(143, 'CORONGO', 16),
(144, 'ACO', 16),
(145, 'BAMBAS', 16),
(146, 'CUSCA', 16),
(147, 'LA PAMPA', 16),
(148, 'YANAC', 16),
(149, 'YUPAN', 16),
(150, 'HUARI', 17),
(151, 'ANRA', 17),
(152, 'CAJAY', 17),
(153, 'CHAVIN DE HUANTAR', 17),
(154, 'HUACACHI', 17),
(155, 'HUACCHIS', 17),
(156, 'HUACHIS', 17),
(157, 'HUANTAR', 17),
(158, 'MASIN', 17),
(159, 'PAUCAS', 17),
(160, 'PONTO', 17),
(161, 'RAHUAPAMPA', 17),
(162, 'RAPAYAN', 17),
(163, 'SAN MARCOS', 17),
(164, 'SAN PEDRO DE CHANA', 17),
(165, 'UCO', 17),
(166, 'HUARMEY', 18),
(167, 'COCHAPETI', 18),
(168, 'CULEBRAS', 18),
(169, 'HUAYAN', 18),
(170, 'MALVAS', 18),
(171, 'CARAZ', 19),
(172, 'HUALLANCA', 19),
(173, 'HUATA', 19),
(174, 'HUAYLAS', 19),
(175, 'MATO', 19),
(176, 'PAMPAROMAS', 19),
(177, 'PUEBLO LIBRE', 19),
(178, 'SANTA CRUZ', 19),
(179, 'SANTO TORIBIO', 19),
(180, 'YURACMARCA', 19),
(181, 'PISCOBAMBA', 20),
(182, 'CASCA', 20),
(183, 'ELEAZAR GUZMAN BARRON', 20),
(184, 'FIDEL OLIVAS ESCUDERO', 20),
(185, 'LLAMA', 20),
(186, 'LLUMPA', 20),
(187, 'LUCMA', 20),
(188, 'MUSGA', 20),
(189, 'OCROS', 21),
(190, 'ACAS', 21),
(191, 'CAJAMARQUILLA', 21),
(192, 'CARHUAPAMPA', 21),
(193, 'COCHAS', 21),
(194, 'CONGAS', 21),
(195, 'LLIPA', 21),
(196, 'SAN CRISTOBAL DE RAJAN', 21),
(197, 'SAN PEDRO', 21),
(198, 'SANTIAGO DE CHILCAS', 21),
(199, 'CABANA', 22),
(200, 'BOLOGNESI', 22),
(201, 'CONCHUCOS', 22),
(202, 'HUACASCHUQUE', 22),
(203, 'HUANDOVAL', 22),
(204, 'LACABAMBA', 22),
(205, 'LLAPO', 22),
(206, 'PALLASCA', 22),
(207, 'PAMPAS', 22),
(208, 'SANTA ROSA', 22),
(209, 'TAUCA', 22),
(210, 'POMABAMBA', 23),
(211, 'HUAYLLAN', 23),
(212, 'PAROBAMBA', 23),
(213, 'QUINUABAMBA', 23),
(214, 'RECUAY', 24),
(215, 'CATAC', 24),
(216, 'COTAPARACO', 24),
(217, 'HUAYLLAPAMPA', 24),
(218, 'LLACLLIN', 24),
(219, 'MARCA', 24),
(220, 'PAMPAS CHICO', 24),
(221, 'PARARIN', 24),
(222, 'TAPACOCHA', 24),
(223, 'TICAPAMPA', 24),
(224, 'CHIMBOTE', 25),
(225, 'CACERES DEL PERU', 25),
(226, 'COISHCO', 25),
(227, 'MACATE', 25),
(228, 'MORO', 25),
(229, 'NEPE&Ntilde;A', 25),
(230, 'SAMANCO', 25),
(231, 'SANTA', 25),
(232, 'NUEVO CHIMBOTE', 25),
(233, 'SIHUAS', 26),
(234, 'ACOBAMBA', 26),
(235, 'ALFONSO UGARTE', 26),
(236, 'CASHAPAMPA', 26),
(237, 'CHINGALPO', 26),
(238, 'HUAYLLABAMBA', 26),
(239, 'QUICHES', 26),
(240, 'RAGASH', 26),
(241, 'SAN JUAN', 2),
(242, 'SICSIBAMBA', 26),
(243, 'YUNGAY', 27),
(244, 'CASCAPARA', 27),
(245, 'MANCOS', 27),
(246, 'MATACOTO', 27),
(247, 'QUILLO', 27),
(248, 'RANRAHIRCA', 27),
(249, 'SHUPLUY', 27),
(250, 'YANAMA', 27),
(251, 'ABANCAY', 28),
(252, 'CHACOCHE', 28),
(253, 'CIRCA', 28),
(254, 'CURAHUASI', 28),
(255, 'HUANIPACA', 28),
(256, 'LAMBRAMA', 28),
(257, 'PICHIRHUA', 28),
(258, 'SAN PEDRO DE CACHORA', 28),
(259, 'TAMBURCO', 28),
(260, 'ANDAHUAYLAS', 29),
(261, 'ANDARAPA', 29),
(262, 'CHIARA', 29),
(263, 'HUANCARAMA', 29),
(264, 'HUANCARAY', 29),
(265, 'HUAYANA', 29),
(266, 'KISHUARA', 29),
(267, 'PACOBAMBA', 29),
(268, 'PACUCHA', 29),
(269, 'PAMPACHIRI', 29),
(270, 'POMACOCHA', 29),
(271, 'SAN ANTONIO DE CACHI', 29),
(272, 'SAN JERONIMO', 29),
(273, 'SAN MIGUEL DE CHACCRAMPA', 29),
(274, 'SANTA MARIA DE CHICMO', 29),
(275, 'TALAVERA', 29),
(276, 'TUMAY HUARACA', 29),
(277, 'TURPO', 29),
(278, 'KAQUIABAMBA', 29),
(279, 'JOSE MARIA ARGUEDAS', 29),
(280, 'ANTABAMBA', 30),
(281, 'EL ORO', 30),
(282, 'HUAQUIRCA', 30),
(283, 'JUAN ESPINOZA MEDRANO', 30),
(284, 'OROPESA', 30),
(285, 'PACHACONAS', 30),
(286, 'SABAINO', 30),
(287, 'CHALHUANCA', 31),
(288, 'CAPAYA', 31),
(289, 'CARAYBAMBA', 31),
(290, 'CHAPIMARCA', 31),
(291, 'COLCABAMBA', 31),
(292, 'COTARUSE', 31),
(293, 'HUAYLLO', 31),
(294, 'JUSTO APU SAHUARAURA', 31),
(295, 'LUCRE', 31),
(296, 'POCOHUANCA', 31),
(297, 'SAN JUAN DE CHAC&Ntilde;A', 31),
(298, 'SA&Ntilde;AYCA', 31),
(299, 'SORAYA', 31),
(300, 'TAPAIRIHUA', 31),
(301, 'TINTAY', 31),
(302, 'TORAYA', 31),
(303, 'YANACA', 31),
(304, 'TAMBOBAMBA', 32),
(305, 'COTABAMBAS', 32),
(306, 'COYLLURQUI', 32),
(307, 'HAQUIRA', 32),
(308, 'MARA', 32),
(309, 'CHALLHUAHUACHO', 32),
(310, 'CHINCHEROS', 33),
(311, 'ANCO-HUALLO', 33),
(312, 'COCHARCAS', 33),
(313, 'HUACCANA', 33),
(314, 'OCOBAMBA', 33),
(315, 'ONGOY', 33),
(316, 'URANMARCA', 33),
(317, 'ROCCHACC', 33),
(318, 'EL PORVENIR', 33),
(319, 'LOS CHANKAS', 33),
(320, 'CHUQUIBAMBILLA', 34),
(321, 'CURPAHUASI', 34),
(322, 'GAMARRA', 34),
(323, 'HUAYLLATI', 34),
(324, 'MAMARA', 34),
(325, 'MICAELA BASTIDAS', 34),
(326, 'PATAYPAMPA', 34),
(327, 'PROGRESO', 34),
(328, 'SAN ANTONIO', 34),
(329, 'SANTA ROSA', 34),
(330, 'TURPAY', 34),
(331, 'VILCABAMBA', 34),
(332, 'VIRUNDO', 34),
(333, 'CURASCO', 34),
(334, 'AREQUIPA', 35),
(335, 'ALTO SELVA ALEGRE', 35),
(336, 'CAYMA', 35),
(337, 'CERRO COLORADO', 35),
(338, 'CHARACATO', 35),
(339, 'CHIGUATA', 35),
(340, 'JACOBO HUNTER', 35),
(341, 'LA JOYA', 35),
(342, 'MARIANO MELGAR', 35),
(343, 'MIRAFLORES', 35),
(344, 'MOLLEBAYA', 35),
(345, 'PAUCARPATA', 35),
(346, 'POCSI', 35),
(347, 'POLOBAYA', 35),
(348, 'QUEQUE&Ntilde;A', 35),
(349, 'SABANDIA', 35),
(350, 'SACHACA', 35),
(351, 'SAN JUAN DE SIGUAS', 35),
(352, 'SAN JUAN DE TARUCANI', 35),
(353, 'SANTA ISABEL DE SIGUAS', 35),
(354, 'SANTA RITA DE SIGUAS', 35),
(355, 'SOCABAYA', 35),
(356, 'TIABAYA', 35),
(357, 'UCHUMAYO', 35),
(358, 'VITOR', 35),
(359, 'YANAHUARA', 35),
(360, 'YARABAMBA', 35),
(361, 'YURA', 35),
(362, 'JOSE LUIS BUSTAMANTE Y RIVERO', 35),
(363, 'CAMANA', 36),
(364, 'JOSE MARIA QUIMPER', 36),
(365, 'MARIANO NICOLAS VALCARCEL', 36),
(366, 'MARISCAL CACERES', 36),
(367, 'NICOLAS DE PIEROLA', 36),
(368, 'OCO&Ntilde;A', 36),
(369, 'QUILCA', 36),
(370, 'SAMUEL PASTOR', 36),
(371, 'CARAVELI', 37),
(372, 'ACARI', 37),
(373, 'ATICO', 37),
(374, 'ATIQUIPA', 37),
(375, 'BELLA UNION', 37),
(376, 'CAHUACHO', 37),
(377, 'CHALA', 37),
(378, 'CHAPARRA', 37),
(379, 'HUANUHUANU', 37),
(380, 'JAQUI', 37),
(381, 'LOMAS', 37),
(382, 'QUICACHA', 37),
(383, 'YAUCA', 37),
(384, 'APLAO', 38),
(385, 'ANDAGUA', 38),
(386, 'AYO', 38),
(387, 'CHACHAS', 38),
(388, 'CHILCAYMARCA', 38),
(389, 'CHOCO', 38),
(390, 'HUANCARQUI', 38),
(391, 'MACHAGUAY', 38),
(392, 'ORCOPAMPA', 38),
(393, 'PAMPACOLCA', 38),
(394, 'TIPAN', 38),
(395, 'U&Ntilde;ON', 38),
(396, 'URACA', 38),
(397, 'VIRACO', 38),
(398, 'CHIVAY', 39),
(399, 'ACHOMA', 39),
(400, 'CABANACONDE', 39),
(401, 'CALLALLI', 39),
(402, 'CAYLLOMA', 39),
(403, 'COPORAQUE', 39),
(404, 'HUAMBO', 39),
(405, 'HUANCA', 39),
(406, 'ICHUPAMPA', 39),
(407, 'LARI', 39),
(408, 'LLUTA', 39),
(409, 'MACA', 39),
(410, 'MADRIGAL', 39),
(411, 'SAN ANTONIO DE CHUCA', 39),
(412, 'SIBAYO', 39),
(413, 'TAPAY', 39),
(414, 'TISCO', 39),
(415, 'TUTI', 39),
(416, 'YANQUE', 39),
(417, 'MAJES', 39),
(418, 'CHUQUIBAMBA', 40),
(419, 'ANDARAY', 40),
(420, 'CAYARANI', 40),
(421, 'CHICHAS', 40),
(422, 'IRAY', 40),
(423, 'RIO GRANDE', 40),
(424, 'SALAMANCA', 40),
(425, 'YANAQUIHUA', 40),
(426, 'MOLLENDO', 41),
(427, 'COCACHACRA', 41),
(428, 'DEAN VALDIVIA', 41),
(429, 'ISLAY', 41),
(430, 'MEJIA', 41),
(431, 'PUNTA DE BOMBON', 41),
(432, 'COTAHUASI', 42),
(433, 'ALCA', 42),
(434, 'CHARCANA', 42),
(435, 'HUAYNACOTAS', 42),
(436, 'PAMPAMARCA', 42),
(437, 'PUYCA', 42),
(438, 'QUECHUALLA', 42),
(439, 'SAYLA', 42),
(440, 'TAURIA', 42),
(441, 'TOMEPAMPA', 42),
(442, 'TORO', 42),
(443, 'AYACUCHO', 43),
(444, 'ACOCRO', 43),
(445, 'ACOS VINCHOS', 43),
(446, 'ANDRES AVELINO CÁCERES DORREGARAY', 43),
(447, 'CARMEN ALTO', 43),
(448, 'CHIARA', 43),
(449, 'OCROS', 43),
(450, 'PACAYCASA', 43),
(451, 'QUINUA', 43),
(452, 'SAN JOSE DE TICLLAS', 43),
(453, 'SAN JUAN BAUTISTA', 43),
(454, 'SANTIAGO DE PISCHA', 43),
(455, 'SOCOS', 43),
(456, 'TAMBILLO', 43),
(457, 'VINCHOS', 43),
(458, 'JESUS NAZARENO', 43),
(459, 'CANGALLO', 44),
(460, 'CHUSCHI', 44),
(461, 'LOS MOROCHUCOS', 44),
(462, 'MARIA PARADO DE BELLIDO', 44),
(463, 'PARAS', 44),
(464, 'TOTOS', 44),
(465, 'SANCOS', 45),
(466, 'CARAPO', 45),
(467, 'SACSAMARCA', 45),
(468, 'SANTIAGO DE LUCANAMARCA', 45),
(469, 'HUANTA', 46),
(470, 'AYAHUANCO', 46),
(471, 'HUAMANGUILLA', 46),
(472, 'IGUAIN', 46),
(473, 'LURICOCHA', 46),
(474, 'SANTILLANA', 46),
(475, 'SIVIA', 46),
(476, 'LLOCHEGUA', 46),
(477, 'CANAYRE', 46),
(478, 'UCHURACCAY', 46),
(479, 'PUCACOLPA', 46),
(480, 'CHACA', 46),
(481, 'SAN MIGUEL', 47),
(482, 'ANCO', 47),
(483, 'AYNA', 47),
(484, 'CHILCAS', 47),
(485, 'CHUNGUI', 47),
(486, 'LUIS CARRANZA', 47),
(487, 'SANTA ROSA', 47),
(488, 'TAMBO', 47),
(489, 'SAMUGARI', 47),
(490, 'ANCHIHUAY', 47),
(491, 'ORONCCOY', 47),
(492, 'PUQUIO', 48),
(493, 'AUCARA', 48),
(494, 'CABANA', 48),
(495, 'CARMEN SALCEDO', 48),
(496, 'CHAVI&Ntilde;A', 48),
(497, 'CHIPAO', 48),
(498, 'HUAC-HUAS', 48),
(499, 'LARAMATE', 48),
(500, 'LEONCIO PRADO', 48),
(501, 'LLAUTA', 48),
(502, 'LUCANAS', 48),
(503, 'OCA&Ntilde;A', 48),
(504, 'OTOCA', 48),
(505, 'SAISA', 48),
(506, 'SAN CRISTOBAL', 48),
(507, 'SAN JUAN', 48),
(508, 'SAN PEDRO', 48),
(509, 'SAN PEDRO DE PALCO', 48),
(510, 'SANCOS', 48),
(511, 'SANTA ANA DE HUAYCAHUACHO', 48),
(512, 'SANTA LUCIA', 48),
(513, 'CORACORA', 49),
(514, 'CHUMPI', 49),
(515, 'CORONEL CASTA&Ntilde;EDA', 49),
(516, 'PACAPAUSA', 49),
(517, 'PULLO', 49),
(518, 'PUYUSCA', 49),
(519, 'SAN FRANCISCO DE RAVACAYCO', 49),
(520, 'UPAHUACHO', 49),
(521, 'PAUSA', 50),
(522, 'COLTA', 50),
(523, 'CORCULLA', 50),
(524, 'LAMPA', 50),
(525, 'MARCABAMBA', 50),
(526, 'OYOLO', 50),
(527, 'PARARCA', 50),
(528, 'SAN JAVIER DE ALPABAMBA', 50),
(529, 'SAN JOSE DE USHUA', 50),
(530, 'SARA SARA', 50),
(531, 'QUEROBAMBA', 51),
(532, 'BELEN', 51),
(533, 'CHALCOS', 51),
(534, 'CHILCAYOC', 51),
(535, 'HUACA&Ntilde;A', 51),
(536, 'MORCOLLA', 51),
(537, 'PAICO', 51),
(538, 'SAN PEDRO DE LARCAY', 51),
(539, 'SAN SALVADOR DE QUIJE', 51),
(540, 'SANTIAGO DE PAUCARAY', 51),
(541, 'SORAS', 51),
(542, 'HUANCAPI', 52),
(543, 'ALCAMENCA', 52),
(544, 'APONGO', 52),
(545, 'ASQUIPATA', 52),
(546, 'CANARIA', 52),
(547, 'CAYARA', 52),
(548, 'COLCA', 52),
(549, 'HUAMANQUIQUIA', 52),
(550, 'HUANCARAYLLA', 52),
(551, 'HUAYA', 52),
(552, 'SARHUA', 52),
(553, 'VILCANCHOS', 52),
(554, 'VILCAS HUAMAN', 53),
(555, 'ACCOMARCA', 53),
(556, 'CARHUANCA', 53),
(557, 'CONCEPCION', 53),
(558, 'HUAMBALPA', 53),
(559, 'LOS BA&Ntilde;OS DEL INCA', 54),
(560, 'SAURAMA', 53),
(561, 'VISCHONGO', 53),
(562, 'CAJAMARCA', 54),
(563, 'ASUNCION', 54),
(564, 'CHETILLA', 54),
(565, 'COSPAN', 54),
(566, 'ENCA&Ntilde;ADA', 54),
(567, 'JESUS', 54),
(568, 'LLACANORA', 54),
(569, 'INDEPENDENCIA', 53),
(570, 'MAGDALENA', 54),
(571, 'MATARA', 54),
(572, 'NAMORA', 54),
(573, 'SAN JUAN', 54),
(574, 'CAJABAMBA', 55),
(575, 'CACHACHI', 55),
(576, 'CONDEBAMBA', 55),
(577, 'SITACOCHA', 55),
(578, 'CELENDIN', 56),
(579, 'CHUMUCH', 56),
(580, 'CORTEGANA', 56),
(581, 'HUASMIN', 56),
(582, 'JORGE CHAVEZ', 56),
(583, 'JOSE GALVEZ', 56),
(584, 'MIGUEL IGLESIAS', 56),
(585, 'OXAMARCA', 56),
(586, 'SOROCHUCO', 56),
(587, 'SUCRE', 56),
(588, 'UTCO', 56),
(589, 'LA LIBERTAD DE PALLAN', 56),
(590, 'CHOTA', 57),
(591, 'ANGUIA', 57),
(592, 'CHADIN', 57),
(593, 'CHIGUIRIP', 57),
(594, 'CHIMBAN', 57),
(595, 'CHOROPAMPA', 57),
(596, 'COCHABAMBA', 57),
(597, 'CONCHAN', 57),
(598, 'HUAMBOS', 57),
(600, 'LAJAS', 57),
(601, 'LLAMA', 57),
(602, 'MIRACOSTA', 57),
(603, 'PACCHA', 57),
(604, 'PION', 57),
(605, 'QUEROCOTO', 57),
(606, 'SAN JUAN DE LICUPIS', 57),
(607, 'TACABAMBA', 57),
(608, 'TOCMOCHE', 57),
(609, 'CHALAMARCA', 57),
(610, 'CONTUMAZA', 58),
(611, 'CHILETE', 58),
(612, 'CUPISNIQUE', 58),
(613, 'GUZMANGO', 58),
(614, 'SAN BENITO', 58),
(615, 'SANTA CRUZ DE TOLED', 58),
(616, 'TANTARICA', 58),
(617, 'YONAN', 58),
(618, 'CUTERVO', 59),
(619, 'CALLAYUC', 59),
(620, 'CHOROS', 59),
(621, 'CUJILLO', 59),
(622, 'LA RAMADA', 59),
(623, 'PIMPINGOS', 59),
(624, 'QUEROCOTILLO', 59),
(625, 'SAN ANDRES DE CUTERVO', 59),
(626, 'SAN JUAN DE CUTERVO', 59),
(627, 'SAN LUIS DE LUCMA', 59),
(628, 'SANTA CRUZ', 59),
(629, 'SANTO DOMINGO DE LA CAPILLA', 59),
(630, 'SANTO TOMAS', 59),
(631, 'SOCOTA', 59),
(632, 'TORIBIO CASANOVA', 59),
(633, 'BAMBAMARCA', 60),
(634, 'CHUGUR', 60),
(635, 'HUALGAYOC', 60),
(636, 'JAEN', 61),
(637, 'BELLAVISTA', 61),
(638, 'CHONTALI', 61),
(639, 'COLASAY', 61),
(640, 'HUABAL', 61),
(641, 'LAS PIRIAS', 61),
(642, 'POMAHUACA', 61),
(643, 'PUCARA', 61),
(644, 'SALLIQUE', 61),
(645, 'SAN FELIPE', 61),
(646, 'SAN JOSE DEL ALTO', 61),
(647, 'SANTA ROSA', 61),
(648, 'SAN IGNACIO', 62),
(649, 'CHIRINOS', 62),
(650, 'HUARANGO', 62),
(651, 'LA COIPA', 62),
(652, 'NAMBALLE', 62),
(653, 'SAN JOSE DE LOURDES', 62),
(654, 'TABACONAS', 62),
(655, 'PEDRO GALVEZ', 63),
(656, 'CHANCAY', 63),
(657, 'EDUARDO VILLANUEVA', 63),
(658, 'GREGORIO PITA', 63),
(659, 'ICHOCAN', 63),
(660, 'JOSE MANUEL QUIROZ', 63),
(661, 'JOSE SABOGAL', 63),
(662, 'SAN MIGUEL', 64),
(663, 'BOLIVAR', 64),
(664, 'CALQUIS', 64),
(665, 'CATILLUC', 64),
(666, 'EL PRADO', 64),
(667, 'LA FLORIDA', 64),
(668, 'LLAPA', 64),
(669, 'NANCHOC', 64),
(670, 'NIEPOS', 64),
(671, 'SAN GREGORIO', 64),
(672, 'SAN SILVESTRE DE COCHAN', 64),
(673, 'TONGOD', 64),
(674, 'UNION AGUA BLANCA', 64),
(675, 'SAN PABLO', 65),
(676, 'SAN BERNARDINO', 65),
(677, 'SAN LUIS', 65),
(678, 'TUMBADEN', 65),
(679, 'SANTA CRUZ', 66),
(680, 'ANDABAMBA', 66),
(681, 'CATACHE', 66),
(682, 'CHANCAYBA&Ntilde;OS', 66),
(683, 'LA ESPERANZA', 66),
(684, 'NINABAMBA', 66),
(685, 'PULAN', 66),
(686, 'SAUCEPAMPA', 66),
(687, 'SEXI', 66),
(688, 'UTICYACU', 66),
(689, 'YAUYUCAN', 66),
(690, 'CALLAO', 67),
(691, 'BELLAVISTA', 67),
(692, 'CARMEN DE LA LEGUA REYNOSO', 67),
(693, 'LA PERLA', 67),
(694, 'LA PUNTA', 67),
(695, 'VENTANILLA', 67),
(696, 'MI PERU', 67),
(697, 'CUSCO', 68),
(698, 'CCORCA', 68),
(699, 'POROY', 68),
(700, 'SAN JERONIMO', 68),
(701, 'SAN SEBASTIAN', 68),
(702, 'SANTIAGO', 68),
(703, 'SAYLLA', 68),
(704, 'WANCHAQ', 68),
(705, 'ACOMAYO', 69),
(706, 'ACOPIA', 69),
(707, 'ACOS', 69),
(708, 'MOSOC LLACTA', 69),
(709, 'POMACANCHI', 69),
(710, 'RONDOCAN', 69),
(711, 'SANGARARA', 69),
(712, 'ANTA', 70),
(713, 'ANCAHUASI', 70),
(714, 'CACHIMAYO', 70),
(715, 'CHINCHAYPUJIO', 70),
(716, 'HUAROCONDO', 70),
(717, 'LIMATAMBO', 70),
(718, 'MOLLEPATA', 70),
(719, 'PUCYURA', 70),
(720, 'ZURITE', 70),
(721, 'CALCA', 71),
(722, 'COYA', 71),
(723, 'LAMAY', 71),
(724, 'LARES', 71),
(725, 'PISAC', 71),
(726, 'SAN SALVADOR', 71),
(727, 'TARAY', 71),
(728, 'YANATILE', 71),
(729, 'YANAOCA', 72),
(730, 'CHECCA', 72),
(731, 'KUNTURKANKI', 72),
(732, 'LANGUI', 72),
(733, 'LAYO', 72),
(734, 'PAMPAMARCA', 72),
(735, 'QUEHUE', 72),
(736, 'TUPAC AMARU', 72),
(737, 'SICUANI', 73),
(738, 'CHECACUPE', 73),
(739, 'COMBAPATA', 73),
(740, 'MARANGANI', 73),
(741, 'PITUMARCA', 73),
(742, 'SAN PABLO', 73),
(743, 'SAN PEDRO', 73),
(744, 'TINTA', 73),
(745, 'SANTO TOMAS', 74),
(746, 'CAPACMARCA', 74),
(747, 'CHAMACA', 74),
(748, 'COLQUEMARCA', 74),
(749, 'LIVITACA', 74),
(750, 'LLUSCO', 74),
(751, 'QUI&Ntilde;OTA', 74),
(752, 'VELILLE', 74),
(753, 'ESPINAR', 75),
(754, 'CONDOROMA', 75),
(755, 'COPORAQUE', 75),
(756, 'OCORURO', 75),
(757, 'PALLPATA', 75),
(758, 'PICHIGUA', 75),
(759, 'SUYCKUTAMBO', 75),
(760, 'ALTO PICHIGUA', 75),
(761, 'SANTA ANA', 76),
(762, 'ECHARATE', 76),
(763, 'HUAYOPATA', 76),
(764, 'MARANURA', 76),
(765, 'OCOBAMBA', 76),
(766, 'QUELLOUNO', 76),
(767, 'KIMBIRI', 76),
(768, 'SANTA TERESA', 76),
(769, 'VILCABAMBA', 76),
(770, 'INKAWASI', 76),
(771, 'VILLA VIRGEN', 76),
(772, 'VILLA KINTIARINA', 76),
(773, 'MEGANTONI', 76),
(774, 'PARURO', 77),
(775, 'ACCHA', 77),
(776, 'CCAPI', 77),
(777, 'COLCHA', 77),
(778, 'HUANOQUITE', 77),
(779, 'OMACHA', 77),
(780, 'PACCARITAMBO', 77),
(781, 'PILLPINTO', 77),
(782, 'YAURISQUE', 77),
(783, 'PAUCARTAMBO', 78),
(784, 'CAICAY', 78),
(785, 'CHALLABAMBA', 78),
(786, 'COLQUEPATA', 78),
(787, 'HUANCARANI', 78),
(788, 'KOS&Ntilde;IPATA', 78),
(789, 'URCOS', 79),
(790, 'ANDAHUAYLILLAS', 79),
(791, 'CAMANTI', 79),
(792, 'CCARHUAYO', 79),
(793, 'CCATCA', 79),
(794, 'CUSIPATA', 79),
(795, 'HUARO', 79),
(796, 'LUCRE', 79),
(797, 'MARCAPATA', 79),
(798, 'OCONGATE', 79),
(799, 'OROPESA', 79),
(800, 'QUIQUIJANA', 79),
(801, 'URUBAMBA', 80),
(802, 'CHINCHERO', 80),
(803, 'HUAYLLABAMBA', 80),
(804, 'MACHUPICCHU', 80),
(805, 'MARAS', 80),
(806, 'OLLANTAYTAMBO', 80),
(807, 'YUCAY', 80),
(808, 'HUANCAVELICA', 81),
(809, 'ACOBAMBILLA', 81),
(810, 'ACORIA', 81),
(811, 'CONAYCA', 81),
(812, 'CUENCA', 81),
(813, 'HUACHOCOLPA', 81),
(814, 'HUAYLLAHUARA', 81),
(815, 'IZCUCHACA', 81),
(816, 'LARIA', 81),
(817, 'MANTA', 81),
(818, 'MARISCAL CACERES', 81),
(819, 'MOYA', 81),
(820, 'NUEVO OCCORO', 81),
(821, 'PALCA', 81),
(822, 'PILCHACA', 81),
(823, 'VILCA', 81),
(824, 'YAULI', 81),
(825, 'ASCENSION', 81),
(826, 'HUANDO', 81),
(827, 'ACOBAMBA', 82),
(828, 'ANDABAMBA', 82),
(829, 'ANTA', 82),
(830, 'CAJA', 82),
(831, 'MARCAS', 82),
(832, 'PAUCARA', 82),
(833, 'POMACOCHA', 82),
(834, 'ROSARIO', 82),
(835, 'LIRCAY', 83),
(836, 'ANCHONGA', 83),
(837, 'CALLANMARCA', 83),
(838, 'CCOCHACCASA', 83),
(839, 'CHINCHO', 83),
(840, 'CONGALLA', 83),
(841, 'HUANCA-HUANCA', 83),
(842, 'HUAYLLAY GRANDE', 83),
(843, 'JULCAMARCA', 83),
(844, 'SAN ANTONIO DE ANTAPARCO', 83),
(845, 'SANTO TOMAS DE PATA', 83),
(846, 'SECCLLA', 83),
(847, 'CASTROVIRREYNA', 84),
(848, 'ARMA', 84),
(849, 'AURAHUA', 84),
(850, 'CAPILLAS', 84),
(851, 'CHUPAMARCA', 84),
(852, 'COCAS', 84),
(853, 'HUACHOS', 84),
(854, 'HUAMATAMBO', 84),
(855, 'MOLLEPAMPA', 84),
(856, 'SAN JUAN', 84),
(857, 'SANTA ANA', 84),
(858, 'TANTARA', 84),
(859, 'TICRAPO', 84),
(860, 'CHURCAMPA', 85),
(861, 'ANCO', 85),
(862, 'CHINCHIHUASI', 85),
(863, 'EL CARMEN', 85),
(864, 'LA MERCED', 85),
(865, 'LOCROJA', 85),
(866, 'PAUCARBAMBA', 85),
(867, 'SAN MIGUEL DE MAYOCC', 85),
(868, 'SAN PEDRO DE CORIS', 85),
(869, 'PACHAMARCA', 85),
(870, 'COSME', 85),
(871, 'HUAYTARA', 86),
(872, 'AYAVI', 86),
(873, 'CORDOVA', 86),
(874, 'HUAYACUNDO ARMA', 86),
(875, 'LARAMARCA', 86),
(876, 'OCOYO', 86),
(877, 'PILPICHACA', 86),
(878, 'QUERCO', 86),
(879, 'QUITO-ARMA', 86),
(880, 'SAN ANTONIO DE CUSICANCHA', 86),
(881, 'SAN FRANCISCO DE SANGAYAICO', 86),
(882, 'SAN ISIDRO', 86),
(883, 'SANTIAGO DE CHOCORVOS', 86),
(884, 'SANTIAGO DE QUIRAHUARA', 86),
(885, 'SANTO DOMINGO DE CAPILLAS', 86),
(886, 'TAMBO', 86),
(887, 'PAMPAS', 87),
(888, 'ACOSTAMBO', 87),
(889, 'ACRAQUIA', 87),
(890, 'AHUAYCHA', 87),
(891, 'COLCABAMBA', 87),
(892, 'DANIEL HERNANDEZ', 87),
(893, 'HUACHOCOLPA', 87),
(894, 'HUARIBAMBA', 87),
(895, '&Ntilde;AHUIMPUQUIO', 87),
(896, 'PAZOS', 87),
(897, 'QUISHUAR', 87),
(898, 'SALCABAMBA', 87),
(899, 'SALCAHUASI', 87),
(900, 'SAN MARCOS DE ROCCHAC', 87),
(901, 'SURCUBAMBA', 87),
(902, 'TINTAY PUNCU', 87),
(903, 'QUICHUAS', 87),
(904, 'ANDAYMARCA', 87),
(905, 'ROBLE', 87),
(906, 'PICHOS', 87),
(907, 'SANTIAGO DE TUCUMA', 87),
(908, 'HUANUCO', 88),
(909, 'AMARILIS', 88),
(910, 'CHINCHAO', 88),
(911, 'CHURUBAMBA', 88),
(912, 'MARGOS', 88),
(913, 'QUISQUI', 88),
(914, 'SAN FRANCISCO DE CAYRAN', 88),
(915, 'SAN PEDRO DE CHAULAN', 88),
(916, 'SANTA MARIA DEL VALLE', 88),
(917, 'YARUMAYO', 88),
(918, 'PILLCO MARCA', 88),
(919, 'YACUS', 88),
(920, 'SAN PABLO DE PILLAO', 88),
(921, 'AMBO', 89),
(922, 'CAYNA', 89),
(923, 'COLPAS', 89),
(924, 'CONCHAMARCA', 89),
(925, 'HUACAR', 89),
(926, 'SAN FRANCISCO', 89),
(927, 'SAN RAFAEL', 89),
(928, 'TOMAY KICHWA', 89),
(929, 'LA UNION', 90),
(930, 'CHUQUIS', 90),
(931, 'MARIAS', 90),
(932, 'PACHAS', 90),
(933, 'QUIVILLA', 90),
(934, 'RIPAN', 90),
(935, 'SHUNQUI', 90),
(936, 'SILLAPATA', 90),
(937, 'YANAS', 90),
(938, 'HUACAYBAMBA', 91),
(939, 'CANCHABAMBA', 91),
(940, 'COCHABAMBA', 91),
(941, 'PINRA', 91),
(942, 'LLATA', 92),
(943, 'ARANCAY', 92),
(944, 'CHAVIN DE PARIARCA', 92),
(945, 'JACAS GRANDE', 92),
(946, 'JIRCAN', 92),
(947, 'MIRAFLORES', 92),
(948, 'MONZON', 92),
(949, 'PUNCHAO', 92),
(950, 'PU&Ntilde;OS', 92),
(951, 'SINGA', 92),
(952, 'TANTAMAYO', 92),
(953, 'RUPA-RUPA', 93),
(954, 'DANIEL ALOMIA ROBLES', 93),
(955, 'HERMILIO VALDIZAN', 93),
(956, 'JOSE CRESPO Y CASTILLO', 93),
(957, 'LUYANDO', 93),
(958, 'PUCAYACU', 93),
(959, 'CASTILLO GRNADE', 93),
(960, 'PUEBLO NUEVO', 93),
(961, 'SANTA DOMINGO DE ANDA', 93),
(962, 'HUACRACHUCO', 94),
(963, 'CHOLON', 94),
(964, 'SAN BUENAVENTURA', 94),
(965, 'LA MORADA', 94),
(966, 'DANTA ROSA DE ALTO YANAJANCA', 94),
(967, 'PANAO', 95),
(968, 'CHAGLLA', 95),
(969, 'MOLINO', 95),
(970, 'UMARI', 95),
(971, 'PUERTO INCA', 96),
(972, 'CODO DEL POZUZO', 96),
(973, 'HONORIA', 96),
(974, 'TOURNAVISTA', 96),
(975, 'YUYAPICHIS', 96),
(976, 'JESUS', 97),
(977, 'BA&Ntilde;OS', 97),
(978, 'JIVIA', 97),
(979, 'QUEROPALCA', 97),
(980, 'RONDOS', 97),
(981, 'SAN FRANCISCO DE ASIS', 97),
(982, 'SAN MIGUEL DE CAURI', 97),
(983, 'CHAVINILLO', 98),
(984, 'CAHUAC', 98),
(985, 'CHACABAMBA', 98),
(986, 'APARICIO POMARES', 98),
(987, 'JACAS CHICO', 98),
(988, 'OBAS', 98),
(989, 'PAMPAMARCA', 98),
(990, 'CHORAS', 98),
(991, 'ICA', 99),
(992, 'LA TINGUI&Ntilde;A', 99),
(993, 'LOS AQUIJES', 99),
(994, 'OCUCAJE', 99),
(995, 'PACHACUTEC', 99),
(996, 'PARCONA', 99),
(997, 'PUEBLO NUEVO', 99),
(998, 'SALAS', 99),
(999, 'SAN JOSE DE LOS MOLINOS', 99),
(1000, 'SAN JUAN BAUTISTA', 99),
(1001, 'SANTIAGO', 99),
(1002, 'SUBTANJALLA', 99),
(1003, 'TATE', 99),
(1004, 'YAUCA DEL ROSARIO', 99),
(1005, 'CHINCHA ALTA', 100),
(1006, 'ALTO LARAN', 100),
(1007, 'CHAVIN', 100),
(1008, 'CHINCHA BAJA', 100),
(1009, 'EL CARMEN', 100),
(1010, 'GROCIO PRADO', 100),
(1011, 'PUEBLO NUEVO', 100),
(1012, 'SAN JUAN DE YANAC', 100),
(1013, 'SAN PEDRO DE HUACARPANA', 100),
(1014, 'SUNAMPE', 100),
(1015, 'TAMBO DE MORA', 100),
(1016, 'NAZCA', 101),
(1017, 'CHANGUILLO', 101),
(1018, 'EL INGENIO', 101),
(1019, 'MARCONA', 101),
(1020, 'VISTA ALEGRE', 101),
(1021, 'PALPA', 102),
(1022, 'LLIPATA', 102),
(1023, 'RIO GRANDE', 102),
(1024, 'SANTA CRUZ', 102),
(1025, 'TIBILLO', 102),
(1026, 'PISCO', 103),
(1027, 'HUANCANO', 103),
(1028, 'HUMAY', 103),
(1029, 'INDEPENDENCIA', 103),
(1030, 'PARACAS', 103),
(1031, 'SAN ANDRES', 103),
(1032, 'SAN CLEMENTE', 103),
(1033, 'TUPAC AMARU INCA', 103),
(1034, 'HUANCAYO', 104),
(1035, 'CARHUACALLANGA', 104),
(1036, 'CHACAPAMPA', 104),
(1037, 'CHICCHE', 104),
(1038, 'CHILCA', 104),
(1039, 'CHONGOS ALTO', 104),
(1040, 'CHUPURO', 104),
(1041, 'COLCA', 104),
(1042, 'CULLHUAS', 104),
(1043, 'EL TAMBO', 104),
(1044, 'HUACRAPUQUIO', 104),
(1045, 'HUALHUAS', 104),
(1046, 'HUANCAN', 104),
(1047, 'HUASICANCHA', 104),
(1048, 'HUAYUCACHI', 104),
(1049, 'INGENIO', 104),
(1050, 'PARIAHUANCA', 104),
(1051, 'PILCOMAYO', 104),
(1052, 'PUCARA', 104),
(1053, 'QUICHUAY', 104),
(1054, 'QUILCAS', 104),
(1055, 'SAN AGUSTIN', 104),
(1056, 'SAN JERONIMO DE TUNAN', 104),
(1057, 'SA&Ntilde;O', 104),
(1058, 'SAPALLANGA', 104),
(1059, 'SICAYA', 104),
(1060, 'SANTO DOMINGO DE ACOBAMBA', 104),
(1061, 'VIQUES', 104),
(1062, 'CONCEPCION', 105),
(1063, 'ACO', 105),
(1064, 'ANDAMARCA', 105),
(1065, 'CHAMBARA', 105),
(1066, 'COCHAS', 105),
(1067, 'COMAS', 105),
(1068, 'HEROINAS TOLEDO', 105),
(1069, 'MANZANARES', 105),
(1070, 'MARISCAL CASTILLA', 105),
(1071, 'MATAHUASI', 105),
(1072, 'MITO', 105),
(1073, 'NUEVE DE JULIO', 105),
(1074, 'ORCOTUNA', 105),
(1075, 'SAN JOSE DE QUERO', 105),
(1076, 'SANTA ROSA DE OCOPA', 105),
(1077, 'CHANCHAMAYO', 106),
(1078, 'PERENE', 106),
(1079, 'PICHANAQUI', 106),
(1080, 'SAN LUIS DE SHUARO', 106),
(1081, 'SAN RAMON', 106),
(1082, 'VITOC', 106),
(1083, 'JAUJA', 107),
(1084, 'ACOLLA', 107),
(1085, 'APATA', 107),
(1086, 'ATAURA', 107),
(1087, 'CANCHAYLLO', 107),
(1088, 'CURICACA', 107),
(1089, 'EL MANTARO', 107),
(1090, 'HUAMALI', 107),
(1091, 'HUARIPAMPA', 107),
(1092, 'HUERTAS', 107),
(1093, 'JANJAILLO', 107),
(1094, 'JULCAN', 107),
(1095, 'LEONOR ORDO&Ntilde;EZ', 107),
(1096, 'LLOCLLAPAMPA', 107),
(1097, 'MARCO', 107),
(1098, 'MASMA', 107),
(1099, 'MASMA CHICCHE', 107),
(1100, 'MOLINOS', 107),
(1101, 'MONOBAMBA', 107),
(1102, 'MUQUI', 107),
(1103, 'MUQUIYAUYO', 107),
(1104, 'PACA', 107),
(1105, 'PACCHA', 107),
(1106, 'PANCAN', 107),
(1107, 'PARCO', 107),
(1108, 'POMACANCHA', 107),
(1109, 'RICRAN', 107),
(1110, 'SAN LORENZO', 107),
(1111, 'SAN PEDRO DE CHUNAN', 107),
(1112, 'SAUSA', 107),
(1113, 'SINCOS', 107),
(1114, 'TUNAN MARCA', 107),
(1115, 'YAULI', 107),
(1116, 'YAUYOS', 107),
(1117, 'JUNIN', 108),
(1118, 'CARHUAMAYO', 108),
(1119, 'ONDORES', 108),
(1120, 'ULCUMAYO', 108),
(1121, 'SATIPO', 109),
(1122, 'COVIRIALI', 109),
(1123, 'LLAYLLA', 109),
(1124, 'MAZAMARI', 109),
(1125, 'PAMPA HERMOSA', 109),
(1126, 'PANGOA', 109),
(1127, 'RIO NEGRO', 109),
(1128, 'RIO TAMBO', 109),
(1129, 'VIZCATAN DEL ENE', 109),
(1130, 'TARMA', 110),
(1131, 'ACOBAMBA', 110),
(1132, 'HUARICOLCA', 110),
(1133, 'HUASAHUASI', 110),
(1134, 'LA UNION', 110),
(1135, 'PALCA', 110),
(1136, 'PALCAMAYO', 110),
(1137, 'SAN PEDRO DE CAJAS', 110),
(1138, 'TAPO', 110),
(1139, 'LA OROYA', 111),
(1140, 'CHACAPALPA', 111),
(1141, 'HUAY-HUAY', 111),
(1142, 'MARCAPOMACOCHA', 111),
(1143, 'MOROCOCHA', 111),
(1144, 'PACCHA', 111),
(1145, 'SANTA BARBARA DE CARHUACAYAN', 111),
(1146, 'SANTA ROSA DE SACCO', 111),
(1147, 'SUITUCANCHA', 111),
(1148, 'YAULI', 111),
(1149, 'CHUPACA', 112),
(1150, 'AHUAC', 112),
(1151, 'CHONGOS BAJO', 112),
(1152, 'HUACHAC', 112),
(1153, 'HUAMANCACA CHICO', 112),
(1154, 'SAN JUAN DE ISCOS', 112),
(1155, 'SAN JUAN DE JARPA', 112),
(1156, 'TRES DE DICIEMBRE', 112),
(1157, 'YANACANCHA', 112),
(1158, 'TRUJILLO', 113),
(1159, 'EL PORVENIR', 113),
(1160, 'FLORENCIA DE MORA', 113),
(1161, 'HUANCHACO', 113),
(1162, 'LA ESPERANZA', 113),
(1163, 'LAREDO', 113),
(1164, 'MOCHE', 113),
(1165, 'POROTO', 113),
(1166, 'SALAVERRY', 113),
(1167, 'SIMBAL', 113),
(1168, 'VICTOR LARCO HERRERA', 113),
(1169, 'ASCOPE', 114),
(1170, 'CHICAMA', 114),
(1171, 'CHOCOPE', 114),
(1172, 'MAGDALENA DE CAO', 114),
(1173, 'PAIJAN', 114),
(1174, 'RAZURI', 114),
(1175, 'SANTIAGO DE CAO', 114),
(1176, 'CASA GRANDE', 114),
(1177, 'BOLIVAR', 115),
(1178, 'BAMBAMARCA', 115),
(1179, 'CONDORMARCA', 115),
(1180, 'LONGOTEA', 115),
(1181, 'UCHUMARCA', 115),
(1182, 'UCUNCHA', 115),
(1183, 'CHEPEN', 116),
(1184, 'PACANGA', 116),
(1185, 'PUEBLO NUEVO', 116),
(1186, 'JULCAN', 117),
(1187, 'CALAMARCA', 117),
(1188, 'CARABAMBA', 117),
(1189, 'HUASO', 117),
(1190, 'OTUZCO', 118),
(1191, 'AGALLPAMPA', 118),
(1192, 'CHARAT', 118),
(1193, 'HUARANCHAL', 118),
(1194, 'LA CUESTA', 118),
(1195, 'MACHE', 118),
(1196, 'PARANDAY', 118),
(1197, 'SALPO', 118),
(1198, 'SINSICAP', 118),
(1199, 'USQUIL', 118),
(1200, 'SAN PEDRO DE LLOC', 119),
(1201, 'GUADALUPE', 119),
(1202, 'JEQUETEPEQUE', 119),
(1203, 'PACASMAYO', 119),
(1204, 'SAN JOSE', 119),
(1205, 'TAYABAMBA', 120),
(1206, 'BULDIBUYO', 120),
(1207, 'CHILLIA', 120),
(1208, 'HUANCASPATA', 120),
(1209, 'HUAYLILLAS', 120),
(1210, 'HUAYO', 120),
(1211, 'ONGON', 120),
(1212, 'PARCOY', 120),
(1213, 'PATAZ', 120),
(1214, 'PIAS', 120),
(1215, 'SANTIAGO DE CHALLAS', 120),
(1216, 'TAURIJA', 120),
(1217, 'URPAY', 120),
(1218, 'HUAMACHUCO', 121),
(1219, 'CHUGAY', 121),
(1220, 'COCHORCO', 121),
(1221, 'CURGOS', 121),
(1222, 'MARCABAL', 121),
(1223, 'SANAGORAN', 121),
(1224, 'SARIN', 121),
(1225, 'SARTIMBAMBA', 121),
(1226, 'SANTIAGO DE CHUCO', 122),
(1227, 'ANGASMARCA', 122),
(1228, 'CACHICADAN', 122),
(1229, 'MOLLEBAMBA', 122),
(1230, 'MOLLEPATA', 122),
(1231, 'QUIRUVILCA', 122),
(1232, 'SANTA CRUZ DE CHUCA', 122),
(1233, 'SITABAMBA', 122),
(1234, 'CASCAS', 123),
(1235, 'LUCMA', 123),
(1236, 'MARMOT', 123),
(1237, 'SAYAPULLO', 123),
(1238, 'VIRU', 124),
(1239, 'CHAO', 124),
(1240, 'GUADALUPITO', 124),
(1241, 'CHICLAYO', 125),
(1242, 'CHONGOYAPE', 125),
(1243, 'ETEN', 125),
(1244, 'ETEN PUERTO', 125),
(1245, 'JOSE LEONARDO ORTIZ', 125),
(1246, 'LA VICTORIA', 125),
(1247, 'LAGUNAS', 125),
(1248, 'MONSEFU', 125),
(1249, 'NUEVA ARICA', 125),
(1250, 'OYOTUN', 125),
(1251, 'PICSI', 125),
(1252, 'PIMENTEL', 125),
(1253, 'REQUE', 125),
(1254, 'SANTA ROSA', 125),
(1255, 'SA&Ntilde;A', 125),
(1256, 'CAYALTI', 125),
(1257, 'PATAPO', 125),
(1258, 'POMALCA', 125),
(1259, 'PUCALA', 125),
(1260, 'FERRE&Ntilde;AFE', 126),
(1261, 'CA&Ntilde;ARIS', 126),
(1262, 'INCAHUASI', 126),
(1263, 'MANUEL ANTONIO MESONES MURO', 126),
(1264, 'PITIPO', 126),
(1265, 'PUEBLO NUEVO', 126),
(1266, 'LAMBAYEQUE', 127),
(1267, 'CHOCHOPE', 127),
(1268, 'ILLIMO', 127),
(1269, 'JAYANCA', 127),
(1270, 'MOCHUMI', 127),
(1271, 'MORROPE', 127),
(1272, 'MOTUPE', 127),
(1273, 'OLMOS', 127),
(1274, 'PACORA', 127),
(1275, 'SALAS', 127),
(1276, 'SAN JOSE', 127),
(1277, 'TUCUME', 127),
(1278, 'LIMA', 128),
(1279, 'ANCON', 128),
(1280, 'ATE', 128),
(1281, 'BARRANCO', 128),
(1282, 'BRE&Ntilde;A', 128),
(1283, 'CARABAYLLO', 128),
(1284, 'CHACLACAYO', 128),
(1285, 'CHORRILLOS', 128),
(1286, 'CIENEGUILLA', 128),
(1287, 'COMAS', 128),
(1288, 'EL AGUSTINO', 128),
(1289, 'INDEPENDENCIA', 128),
(1290, 'JESUS MARIA', 128),
(1291, 'LA MOLINA', 128),
(1292, 'LA VICTORIA', 128),
(1293, 'LINCE', 128),
(1294, 'LOS OLIVOS', 128),
(1295, 'LURIGANCHO', 128),
(1296, 'LURIN', 128),
(1297, 'MAGDALENA DEL MAR', 128),
(1298, 'PUEBLO LIBRE', 128),
(1299, 'MIRAFLORES', 128),
(1300, 'PACHACAMAC', 128),
(1301, 'PUCUSANA', 128),
(1302, 'PUENTE PIEDRA', 128),
(1303, 'PUNTA HERMOSA', 128),
(1304, 'PUNTA NEGRA', 128),
(1305, 'RIMAC', 128),
(1306, 'SAN BARTOLO', 128),
(1307, 'SAN BORJA', 128),
(1308, 'SAN ISIDRO', 128),
(1309, 'SAN JUAN DE LURIGANCHO', 128),
(1310, 'SAN JUAN DE MIRAFLORES', 128),
(1311, 'SAN LUIS', 128),
(1312, 'SAN MARTIN DE PORRES', 128),
(1313, 'SAN MIGUEL', 128),
(1314, 'SANTA ANITA', 128),
(1315, 'SANTA MARIA DEL MAR', 128),
(1316, 'SANTA ROSA', 128),
(1317, 'SANTIAGO DE SURCO', 128),
(1318, 'SURQUILLO', 128),
(1319, 'VILLA EL SALVADOR', 128),
(1320, 'VILLA MARIA DEL TRIUNFO', 128),
(1321, 'BARRANCA', 129),
(1322, 'PARAMONGA', 129),
(1323, 'PATIVILCA', 129),
(1324, 'SUPE', 129),
(1325, 'SUPE PUERTO', 129),
(1326, 'CAJATAMBO', 130),
(1327, 'COPA', 130),
(1328, 'GORGOR', 130),
(1329, 'HUANCAPON', 130),
(1330, 'MANAS', 130),
(1331, 'CANTA', 131),
(1332, 'ARAHUAY', 131),
(1333, 'HUAMANTANGA', 131),
(1334, 'HUAROS', 131),
(1335, 'LACHAQUI', 131),
(1336, 'SAN BUENAVENTURA', 131),
(1337, 'SANTA ROSA DE QUIVES', 131),
(1338, 'SAN VICENTE DE CA&Ntilde;ETE', 132),
(1339, 'ASIA', 132),
(1340, 'CALANGO', 132),
(1341, 'CERRO AZUL', 132),
(1342, 'CHILCA', 132),
(1343, 'COAYLLO', 132),
(1344, 'IMPERIAL', 132),
(1345, 'LUNAHUANA', 132),
(1346, 'MALA', 132),
(1347, 'NUEVO IMPERIAL', 132),
(1348, 'PACARAN', 132),
(1349, 'QUILMANA', 132),
(1350, 'SAN ANTONIO', 132),
(1351, 'SAN LUIS', 132),
(1352, 'SANTA CRUZ DE FLORES', 132),
(1353, 'ZU&Ntilde;IGA', 132),
(1354, 'HUARAL', 133),
(1355, 'ATAVILLOS ALTO', 133),
(1356, 'ATAVILLOS BAJO', 133),
(1357, 'AUCALLAMA', 133),
(1358, 'CHANCAY', 133),
(1359, 'IHUARI', 133),
(1360, 'LAMPIAN', 133),
(1361, 'PACARAOS', 133),
(1362, 'SAN MIGUEL DE ACOS', 133),
(1363, 'SANTA CRUZ DE ANDAMARCA', 133),
(1364, 'SUMBILCA', 133),
(1365, 'VEINTISIETE DE NOVIEMBRE', 133),
(1366, 'MATUCANA', 134),
(1367, 'ANTIOQUIA', 134),
(1368, 'CALLAHUANCA', 134),
(1369, 'CARAMPOMA', 134),
(1370, 'CHICLA', 134),
(1371, 'CUENCA', 134),
(1372, 'HUACHUPAMPA', 134),
(1373, 'HUANZA', 134),
(1374, 'HUAROCHIRI', 134),
(1375, 'LAHUAYTAMBO', 134),
(1376, 'LANGA', 134),
(1377, 'LARAOS', 134),
(1378, 'MARIATANA', 134),
(1379, 'RICARDO PALMA', 134),
(1380, 'SAN ANDRES DE TUPICOCHA', 134),
(1381, 'SAN ANTONIO', 134),
(1382, 'SAN BARTOLOME', 134),
(1383, 'SAN DAMIAN', 134),
(1384, 'SAN JUAN DE IRIS', 134),
(1385, 'SAN JUAN DE TANTARANCHE', 134),
(1386, 'SAN LORENZO DE QUINTI', 134),
(1387, 'SAN MATEO', 134),
(1388, 'SAN MATEO DE OTAO', 134),
(1389, 'SAN PEDRO DE CASTA', 134),
(1390, 'SAN PEDRO DE HUANCAYRE', 134),
(1391, 'SANGALLAYA', 134),
(1392, 'SANTA CRUZ DE COCACHACRA', 134),
(1393, 'SANTA EULALIA', 134),
(1394, 'SANTIAGO DE ANCHUCAYA', 134),
(1395, 'SANTIAGO DE TUNA', 134),
(1396, 'SANTO DOMINGO DE LOS OLLEROS', 134),
(1397, 'SURCO', 134),
(1398, 'HUACHO', 135),
(1399, 'AMBAR', 135),
(1400, 'CHECRAS', 135),
(1401, 'HUALMAY', 135),
(1402, 'HUAURA', 135),
(1403, 'LEONCIO PRADO', 135),
(1404, 'PACCHO', 135),
(1405, 'SANTA LEONOR', 135),
(1406, 'SANTA MARIA', 135),
(1407, 'SAYAN', 135),
(1408, 'VEGUETA', 135),
(1409, 'OYON', 136),
(1410, 'ANDAJES', 136),
(1411, 'CAUJUL', 136),
(1412, 'COCHAMARCA', 136),
(1413, 'NAVAN', 136),
(1414, 'PACHANGARA', 136),
(1415, 'YAUYOS', 137),
(1416, 'ALIS', 137),
(1417, 'AYAUCA', 137),
(1418, 'AYAVIRI', 137),
(1419, 'AZANGARO', 137),
(1420, 'CACRA', 137),
(1421, 'CARANIA', 137),
(1422, 'CATAHUASI', 137),
(1423, 'CHOCOS', 137),
(1424, 'COCHAS', 137),
(1425, 'COLONIA', 137),
(1426, 'HONGOS', 137),
(1427, 'HUAMPARA', 137),
(1428, 'HUANCAYA', 137),
(1429, 'HUANGASCAR', 137),
(1430, 'HUANTAN', 137),
(1431, 'HUA&Ntilde;EC', 137),
(1432, 'LARAOS', 137),
(1433, 'LINCHA', 137),
(1434, 'MADEAN', 137),
(1435, 'MIRAFLORES', 137),
(1436, 'OMAS', 137),
(1437, 'PUTINZA', 137),
(1438, 'QUINCHES', 137),
(1439, 'QUINOCAY', 137),
(1440, 'SAN JOAQUIN', 137),
(1441, 'SAN PEDRO DE PILAS', 137),
(1442, 'TANTA', 137),
(1443, 'TAURIPAMPA', 137),
(1444, 'TOMAS', 137),
(1445, 'TUPE', 137),
(1446, 'VI&Ntilde;AC', 137),
(1447, 'VITIS', 137),
(1448, 'IQUITOS', 138),
(1449, 'ALTO NANAY', 138),
(1450, 'FERNANDO LORES', 138),
(1451, 'INDIANA', 138),
(1452, 'LAS AMAZONAS', 138),
(1453, 'MAZAN', 138),
(1454, 'NAPO', 138),
(1455, 'PUNCHANA', 138),
(1456, 'TORRES CAUSANA', 138),
(1457, 'BELEN', 138),
(1458, 'SAN JUAN BAUTISTA', 138),
(1459, 'YURIMAGUAS', 139),
(1460, 'BALSAPUERTO', 139),
(1461, 'JEBEROS', 139),
(1462, 'LAGUNAS', 139),
(1463, 'SANTA CRUZ', 139),
(1464, 'TENIENTE CESAR LOPEZ ROJAS', 139),
(1465, 'NAUTA', 140),
(1466, 'PARINARI', 140),
(1467, 'TIGRE', 140),
(1468, 'TROMPETEROS', 140),
(1469, 'URARINAS', 140),
(1470, 'RAMON CASTILLA', 141),
(1471, 'PEBAS', 141),
(1472, 'YAVARI', 141),
(1473, 'SAN PABLO', 141),
(1474, 'REQUENA', 142),
(1475, 'ALTO TAPICHE', 142),
(1476, 'CAPELO', 142),
(1477, 'EMILIO SAN MARTIN', 142),
(1478, 'MAQUIA', 142),
(1479, 'PUINAHUA', 142),
(1480, 'SAQUENA', 142),
(1481, 'SOPLIN', 142),
(1482, 'TAPICHE', 142),
(1483, 'JENARO HERRERA', 142),
(1484, 'YAQUERANA', 142),
(1485, 'CONTAMANA', 143),
(1486, 'INAHUAYA', 143),
(1487, 'PADRE MARQUEZ', 143),
(1488, 'PAMPA HERMOSA', 143),
(1489, 'SARAYACU', 143),
(1490, 'VARGAS GUERRA', 143),
(1491, 'BARRANCA', 144),
(1492, 'CAHUAPANAS', 144),
(1493, 'MANSERICHE', 144),
(1494, 'MORONA', 144),
(1495, 'PASTAZA', 144),
(1496, 'ANDOAS', 144),
(1497, 'PUTUMAYO', 145),
(1498, 'ROSA PANDURO', 145),
(1499, 'TENIENTE MANUEL CLAVERO', 145),
(1500, 'YAGUAS', 145),
(1501, 'TAMBOPATA', 146),
(1502, 'INAMBARI', 146),
(1503, 'LAS PIEDRAS', 146),
(1504, 'LABERINTO', 146),
(1505, 'MANU', 147),
(1506, 'FITZCARRALD', 147),
(1507, 'MADRE DE DIOS', 147),
(1508, 'HUEPETUHE', 147),
(1509, 'I&Ntilde;APARI', 148),
(1510, 'IBERIA', 148),
(1511, 'TAHUAMANU', 148),
(1512, 'MOQUEGUA', 149),
(1513, 'CARUMAS', 149),
(1514, 'CUCHUMBAYA', 149),
(1515, 'SAMEGUA', 149),
(1516, 'SAN CRISTOBAL', 149),
(1517, 'TORATA', 149),
(1518, 'OMATE', 150),
(1519, 'CHOJATA', 150),
(1520, 'COALAQUE', 150),
(1521, 'ICHU&Ntilde;A', 150),
(1522, 'LA CAPILLA', 150),
(1523, 'LLOQUE', 150),
(1524, 'MATALAQUE', 150),
(1525, 'PUQUINA', 150),
(1526, 'QUINISTAQUILLAS', 150),
(1527, 'UBINAS', 150),
(1528, 'YUNGA', 150),
(1529, 'ILO', 151),
(1530, 'EL ALGARROBAL', 151),
(1531, 'PACOCHA', 151),
(1532, 'CHAUPIMARCA', 152),
(1533, 'HUACHON', 152),
(1534, 'HUARIACA', 152),
(1535, 'HUAYLLAY', 152),
(1536, 'NINACACA', 152),
(1537, 'PALLANCHACRA', 152),
(1538, 'PAUCARTAMBO', 152),
(1539, 'SAN FCO.DE ASIS DE YARUSYACAN', 152),
(1540, 'SIMON BOLIVAR', 152),
(1541, 'TICLACAYAN', 152),
(1542, 'TINYAHUARCO', 152),
(1543, 'VICCO', 152),
(1544, 'YANACANCHA', 152),
(1545, 'YANAHUANCA', 153),
(1546, 'CHACAYAN', 153),
(1547, 'GOYLLARISQUIZGA', 153),
(1548, 'PAUCAR', 153),
(1549, 'SAN PEDRO DE PILLAO', 153),
(1550, 'SANTA ANA DE TUSI', 153),
(1551, 'TAPUC', 153),
(1552, 'VILCABAMBA', 153),
(1553, 'OXAPAMPA', 154),
(1554, 'CHONTABAMBA', 154),
(1555, 'HUANCABAMBA', 154),
(1556, 'PALCAZU', 154),
(1557, 'POZUZO', 154),
(1558, 'PUERTO BERMUDEZ', 154),
(1559, 'VILLA RICA', 154),
(1560, 'CONSTITUCION', 154),
(1561, 'PIURA', 155),
(1562, 'CASTILLA', 155),
(1563, 'CATACAOS', 155),
(1564, 'CURA MORI', 155),
(1565, 'EL TALLAN', 155),
(1566, 'LA ARENA', 155),
(1567, 'LA UNION', 155),
(1568, 'LAS LOMAS', 155),
(1569, 'TAMBO GRANDE', 155),
(1570, 'VEINTISEIS DE OCTUBLE', 155),
(1571, 'AYABACA', 156),
(1572, 'FRIAS', 156),
(1573, 'JILILI', 156),
(1574, 'LAGUNAS', 156),
(1575, 'MONTERO', 156),
(1576, 'PACAIPAMPA', 156),
(1577, 'PAIMAS', 156),
(1578, 'SAPILLICA', 156),
(1579, 'SICCHEZ', 156),
(1580, 'SUYO', 156),
(1581, 'HUANCABAMBA', 157),
(1582, 'CANCHAQUE', 157),
(1583, 'EL CARMEN DE LA FRONTERA', 157),
(1584, 'HUARMACA', 157),
(1585, 'LALAQUIZ', 157),
(1586, 'SAN MIGUEL DE EL FAIQUE', 157),
(1587, 'SONDOR', 157),
(1588, 'SONDORILLO', 157),
(1589, 'CHULUCANAS', 158),
(1590, 'BUENOS AIRES', 158),
(1591, 'CHALACO', 158),
(1592, 'LA MATANZA', 158),
(1593, 'MORROPON', 158),
(1594, 'SALITRAL', 158),
(1595, 'SAN JUAN DE BIGOTE', 158),
(1596, 'SANTA CATALINA DE MOSSA', 158),
(1597, 'SANTO DOMINGO', 158),
(1598, 'YAMANGO', 158),
(1599, 'PAITA', 159),
(1600, 'AMOTAPE', 159),
(1601, 'ARENAL', 159),
(1602, 'COLAN', 159),
(1603, 'LA HUACA', 159),
(1604, 'TAMARINDO', 159),
(1605, 'VICHAYAL', 159),
(1606, 'SULLANA', 160),
(1607, 'BELLAVISTA', 160),
(1608, 'IGNACIO ESCUDERO', 160),
(1609, 'LANCONES', 160),
(1610, 'MARCAVELICA', 160),
(1611, 'MIGUEL CHECA', 160),
(1612, 'QUERECOTILLO', 160),
(1613, 'SALITRAL', 160),
(1614, 'PARI&Ntilde;AS', 161),
(1615, 'EL ALTO', 161),
(1616, 'LA BREA', 161),
(1617, 'LOBITOS', 161),
(1618, 'LOS ORGANOS', 161),
(1619, 'MANCORA', 161),
(1620, 'SECHURA', 162),
(1621, 'BELLAVISTA DE LA UNION', 162),
(1622, 'BERNAL', 162),
(1623, 'CRISTO NOS VALGA', 162),
(1624, 'VICE', 162),
(1625, 'RINCONADA LLICUAR', 162),
(1626, 'PUNO', 163),
(1627, 'ACORA', 163),
(1628, 'AMANTANI', 163),
(1629, 'ATUNCOLLA', 163),
(1630, 'CAPACHICA', 163),
(1631, 'CHUCUITO', 163),
(1632, 'COATA', 163),
(1633, 'HUATA', 163),
(1634, 'MA&Ntilde;AZO', 163),
(1635, 'PAUCARCOLLA', 163),
(1636, 'PICHACANI', 163),
(1637, 'PLATERIA', 163),
(1638, 'SAN ANTONIO', 163),
(1639, 'TIQUILLACA', 163),
(1640, 'VILQUE', 163),
(1641, 'AZANGARO', 164),
(1642, 'ACHAYA', 164),
(1643, 'ARAPA', 164),
(1644, 'ASILLO', 164),
(1645, 'CAMINACA', 164),
(1646, 'CHUPA', 164),
(1647, 'JOSE DOMINGO CHOQUEHUANCA', 164),
(1648, 'MU&Ntilde;ANI', 164),
(1649, 'POTONI', 164),
(1650, 'SAMAN', 164),
(1651, 'SAN ANTON', 164),
(1652, 'SAN JOSE', 164),
(1653, 'SAN JUAN DE SALINAS', 164),
(1654, 'SANTIAGO DE PUPUJA', 164),
(1655, 'TIRAPATA', 164),
(1656, 'MACUSANI', 165),
(1657, 'AJOYANI', 165),
(1658, 'AYAPATA', 165),
(1659, 'COASA', 165),
(1660, 'CORANI', 165),
(1661, 'CRUCERO', 165),
(1662, 'ITUATA', 165),
(1663, 'OLLACHEA', 165),
(1664, 'SAN GABAN', 165),
(1665, 'USICAYOS', 165),
(1666, 'JULI', 166),
(1667, 'DESAGUADERO', 166),
(1668, 'HUACULLANI', 166),
(1669, 'KELLUYO', 166),
(1670, 'PISACOMA', 166),
(1671, 'POMATA', 166),
(1672, 'ZEPITA', 166),
(1673, 'ILAVE', 167),
(1674, 'CAPAZO', 167),
(1675, 'PILCUYO', 167),
(1676, 'SANTA ROSA', 167),
(1677, 'CONDURIRI', 167),
(1678, 'HUANCANE', 168),
(1679, 'COJATA', 168),
(1680, 'HUATASANI', 168),
(1681, 'INCHUPALLA', 168),
(1682, 'PUSI', 168),
(1683, 'ROSASPATA', 168),
(1684, 'TARACO', 168),
(1685, 'VILQUE CHICO', 168),
(1686, 'LAMPA', 169),
(1687, 'CABANILLA', 169),
(1688, 'CALAPUJA', 169),
(1689, 'NICASIO', 169),
(1690, 'OCUVIRI', 169),
(1691, 'PALCA', 169),
(1692, 'PARATIA', 169),
(1693, 'PUCARA', 169),
(1694, 'SANTA LUCIA', 169),
(1695, 'VILAVILA', 169),
(1696, 'AYAVIRI', 170),
(1697, 'ANTAUTA', 170),
(1698, 'CUPI', 170),
(1699, 'LLALLI', 170),
(1700, 'MACARI', 170),
(1701, 'NU&Ntilde;OA', 170),
(1702, 'ORURILLO', 170),
(1703, 'SANTA ROSA', 170),
(1704, 'UMACHIRI', 170),
(1705, 'MOHO', 171),
(1706, 'CONIMA', 171),
(1707, 'HUAYRAPATA', 171),
(1708, 'TILALI', 171),
(1709, 'PUTINA', 172),
(1710, 'ANANEA', 172),
(1711, 'PEDRO VILCA APAZA', 172),
(1712, 'QUILCAPUNCU', 172),
(1713, 'SINA', 172),
(1714, 'JULIACA', 173),
(1715, 'CABANA', 173),
(1716, 'CABANILLAS', 173),
(1717, 'CARACOTO', 173),
(1718, 'SAN MIGUEL', 173),
(1719, 'SANDIA', 174),
(1720, 'CUYOCUYO', 174),
(1721, 'LIMBANI', 174),
(1722, 'PATAMBUCO', 174),
(1723, 'PHARA', 174),
(1724, 'QUIACA', 174),
(1725, 'SAN JUAN DEL ORO', 174),
(1726, 'YANAHUAYA', 174),
(1727, 'ALTO INAMBARI', 174),
(1728, 'SAN PEDRO DE PUTINA PUNCO', 174),
(1729, 'YUNGUYO', 175),
(1730, 'ANAPIA', 175),
(1731, 'COPANI', 175),
(1732, 'CUTURAPI', 175),
(1733, 'OLLARAYA', 175),
(1734, 'TINICACHI', 175),
(1735, 'UNICACHI', 175),
(1736, 'MOYOBAMBA', 176),
(1737, 'CALZADA', 176),
(1738, 'HABANA', 176),
(1739, 'JEPELACIO', 176),
(1740, 'SORITOR', 176),
(1741, 'YANTALO', 176),
(1742, 'BELLAVISTA', 177),
(1743, 'ALTO BIAVO', 177),
(1744, 'BAJO BIAVO', 177),
(1745, 'HUALLAGA', 177),
(1746, 'SAN PABLO', 177),
(1747, 'SAN RAFAEL', 177),
(1748, 'SAN JOSE DE SISA', 178),
(1749, 'AGUA BLANCA', 178),
(1750, 'SAN MARTIN', 178),
(1751, 'SANTA ROSA', 178),
(1752, 'SHATOJA', 178),
(1753, 'SAPOSOA', 179),
(1754, 'ALTO SAPOSOA', 179),
(1755, 'EL ESLABON', 179),
(1756, 'PISCOYACU', 179),
(1757, 'SACANCHE', 179),
(1758, 'TINGO DE SAPOSOA', 179),
(1759, 'LAMAS', 180),
(1760, 'ALONSO DE ALVARADO', 180),
(1761, 'BARRANQUITA', 180),
(1762, 'CAYNARACHI', 180),
(1763, 'CU&Ntilde;UMBUQUI', 180),
(1764, 'PINTO RECODO', 180),
(1765, 'RUMISAPA', 180),
(1766, 'SAN ROQUE DE CUMBAZA', 180),
(1767, 'SHANAO', 180),
(1768, 'TABALOSOS', 180),
(1769, 'ZAPATERO', 180),
(1770, 'JUANJUI', 181),
(1771, 'CAMPANILLA', 181),
(1772, 'HUICUNGO', 181),
(1773, 'PACHIZA', 181),
(1774, 'PAJARILLO', 181),
(1775, 'PICOTA', 182),
(1776, 'BUENOS AIRES', 182),
(1777, 'CASPISAPA', 182),
(1778, 'PILLUANA', 182),
(1779, 'PUCACACA', 182),
(1780, 'SAN CRISTOBAL', 182),
(1781, 'SAN HILARION', 182),
(1782, 'SHAMBOYACU', 182),
(1783, 'TINGO DE PONASA', 182),
(1784, 'TRES UNIDOS', 182),
(1785, 'RIOJA', 183),
(1786, 'AWAJUN', 183),
(1787, 'ELIAS SOPLIN VARGAS', 183),
(1788, 'NUEVA CAJAMARCA', 183),
(1789, 'PARDO MIGUEL', 183),
(1790, 'POSIC', 183),
(1791, 'SAN FERNANDO', 183),
(1792, 'YORONGOS', 183),
(1793, 'YURACYACU', 183),
(1794, 'TARAPOTO', 184),
(1795, 'ALBERTO LEVEAU', 184),
(1796, 'CACATACHI', 184),
(1797, 'CHAZUTA', 184),
(1798, 'CHIPURANA', 184),
(1799, 'EL PORVENIR', 184),
(1800, 'HUIMBAYOC', 184),
(1801, 'JUAN GUERRA', 184),
(1802, 'LA BANDA DE SHILCAYO', 184),
(1803, 'MORALES', 184),
(1804, 'PAPAPLAYA', 184),
(1805, 'SAN ANTONIO', 184),
(1806, 'SAUCE', 184),
(1807, 'SHAPAJA', 184),
(1808, 'TOCACHE', 185),
(1809, 'NUEVO PROGRESO', 185),
(1810, 'POLVORA', 185),
(1811, 'SHUNTE', 185),
(1812, 'UCHIZA', 185),
(1813, 'TACNA', 186),
(1814, 'ALTO DE LA ALIANZA', 186),
(1815, 'CALANA', 186),
(1816, 'CIUDAD NUEVA', 186),
(1817, 'INCLAN', 186),
(1818, 'PACHIA', 186),
(1819, 'PALCA', 186),
(1820, 'POCOLLAY', 186),
(1821, 'SAMA', 186),
(1822, 'CORONEL GREGORIO ALBARRACIN LANCHIPA', 186),
(1823, 'LA YARADA LOS PALOS', 186),
(1824, 'CANDARAVE', 187),
(1825, 'CAIRANI', 187),
(1826, 'CAMILACA', 187),
(1827, 'CURIBAYA', 187),
(1828, 'HUANUARA', 187),
(1829, 'QUILAHUANI', 187),
(1830, 'LOCUMBA', 188),
(1831, 'ILABAYA', 188),
(1832, 'ITE', 188),
(1833, 'TARATA', 189),
(1834, 'CHUCATAMANI', 189),
(1835, 'ESTIQUE', 189),
(1836, 'ESTIQUE-PAMPA', 189),
(1837, 'SITAJARA', 189),
(1838, 'SUSAPAYA', 189),
(1839, 'TARUCACHI', 189),
(1840, 'TICACO', 189),
(1841, 'TUMBES', 190),
(1842, 'CORRALES', 190),
(1843, 'LA CRUZ', 190),
(1844, 'PAMPAS DE HOSPITAL', 190),
(1845, 'SAN JACINTO', 190),
(1846, 'SAN JUAN DE LA VIRGEN', 190),
(1847, 'ZORRITOS', 191),
(1848, 'CASITAS', 191),
(1849, 'CANOAS DE PUNTA SAL', 191),
(1850, 'ZARUMILLA', 192),
(1851, 'AGUAS VERDES', 192),
(1852, 'MATAPALO', 192),
(1853, 'PAPAYAL', 192),
(1854, 'CALLERIA', 193),
(1855, 'CAMPOVERDE', 193),
(1856, 'IPARIA', 193),
(1857, 'MASISEA', 193),
(1858, 'YARINACOCHA', 193),
(1859, 'NUEVA REQUENA', 193),
(1860, 'MANANTAY', 193),
(1861, 'RAYMONDI', 194),
(1862, 'SEPAHUA', 194),
(1863, 'TAHUANIA', 194),
(1864, 'YURUA', 194),
(1865, 'PADRE ABAD', 195),
(1866, 'IRAZOLA', 195),
(1867, 'CURIMANA', 195),
(1868, 'NESHUYA', 195),
(1869, 'ALEXANDER VON HUMBOLDT', 195),
(1870, 'PURUS', 196),
(1872, 'CALETA DE CARQUIN', 135),
(1874, 'TUMAN', 125);

-- --------------------------------------------------------

--
-- Table structure for table `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `contenido` longtext NOT NULL,
  `version` int(11) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_creador_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ultima_modificacion` datetime DEFAULT NULL,
  `usuario_modificacion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gasto_reportes`
--

CREATE TABLE `gasto_reportes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_gasto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contenido_html` longtext DEFAULT NULL,
  `contenido_pdf` varchar(512) DEFAULT NULL,
  `total_gasto` decimal(15,2) DEFAULT 0.00,
  `cantidad_compras` int(11) DEFAULT 0,
  `estado` varchar(20) DEFAULT 'borrador',
  `usuario_creador` bigint(20) UNSIGNED NOT NULL,
  `usuario_contable` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_envio` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gasto_subcategorias`
--

CREATE TABLE `gasto_subcategorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gasto_tipo_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gasto_subcategorias`
--

INSERT INTO `gasto_subcategorias` (`id`, `gasto_tipo_id`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(61, 4, 'Mano de Obra', 'Jornales, salarios de construcci¾n', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46'),
(62, 4, 'Maquinaria y Equipo', 'Alquiler y compra de equipos', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46'),
(63, 4, 'Materia Prima', 'Materiales principales de construcci¾n', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46'),
(64, 4, 'Materiales Auxiliares', 'Arena, cemento, acero, otros', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46'),
(65, 4, 'Suministros', 'Cables, tuberÝas, accesorios', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `gasto_tipos`
--

CREATE TABLE `gasto_tipos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `color` varchar(20) DEFAULT '#007bff',
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gasto_tipos`
--

INSERT INTO `gasto_tipos` (`id`, `nombre`, `icono`, `descripcion`, `color`, `activo`, `created_at`, `updated_at`) VALUES
(4, 'Costo de Proyectos', 'fa-hammer', 'Gastos de construcci¾n y proyectos', '#28a745', 1, '2026-04-07 19:22:46', '2026-04-07 19:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `incoming`
--

CREATE TABLE `incoming` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `total_cost` decimal(20,2) UNSIGNED DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL COMMENT '0 = salida, 1 =ingreso',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incoming`
--

INSERT INTO `incoming` (`id`, `membership_id`, `supplier_id`, `store_id`, `user_id`, `qty`, `date`, `unit_cost`, `total_cost`, `active`, `created_at`, `updated_at`) VALUES
(2, 15, 1, 1, 1, 300, '2024-11-06 16:34:17', 30.00, 9000.00, '1', '2024-11-06 16:34:17', '0000-00-00 00:00:00'),
(3, 17, 1, 1, 1, 300, '2024-11-06 16:34:32', 30.00, 9000.00, '1', '2024-11-06 16:34:32', '0000-00-00 00:00:00'),
(4, 18, 1, 1, 1, 300, '2024-11-06 16:37:08', 30.00, 9000.00, '1', '2024-11-06 16:37:08', '0000-00-00 00:00:00'),
(5, 19, 1, 1, 6, 100, '2025-05-08 12:51:29', 29.00, 2900.00, '1', '2025-05-08 12:51:29', '0000-00-00 00:00:00'),
(6, 21, 1, 1, 6, 150, '2025-07-18 23:12:54', 29.00, 4350.00, '1', '2025-07-18 23:12:54', '0000-00-00 00:00:00'),
(7, 20, 1, 1, 6, 150, '2025-07-18 23:14:31', 30.00, 4500.00, '1', '2025-07-18 23:14:31', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) UNSIGNED NOT NULL,
  `contract_id` int(11) UNSIGNED NOT NULL,
  `payment_schedule_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `nubefact_response` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'emitida',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail_membership`
--

CREATE TABLE `invoice_detail_membership` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `membership_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `sub_total` decimal(10,2) UNSIGNED NOT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `anverso` varchar(50) NOT NULL,
  `reverso` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `active` enum('0','1','2','3') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lot_number` varchar(50) NOT NULL,
  `cadastral_unit` varchar(50) DEFAULT NULL,
  `registry_number` varchar(50) DEFAULT NULL,
  `block` varchar(20) DEFAULT NULL,
  `area_sqm` decimal(8,2) NOT NULL,
  `base_price` decimal(12,2) NOT NULL,
  `current_price` decimal(12,2) NOT NULL,
  `status` enum('available','reserved','sold','blocked') NOT NULL DEFAULT 'available',
  `reserved_until` timestamp NULL DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT NULL,
  `price_last_updated` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `project_id`, `customer_id`, `lot_number`, `cadastral_unit`, `registry_number`, `block`, `area_sqm`, `base_price`, `current_price`, `status`, `reserved_until`, `sale_date`, `price_last_updated`, `created_at`, `updated_at`) VALUES
(155, 49, 1, '1', '123456', '123456', 'A', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-04-03 18:58:00', '2025-11-29 15:38:30', '2025-11-29 16:38:30', '2026-04-03 18:58:00'),
(156, 49, NULL, '2', '123456', '123456', 'A', 100.00, 20000.00, 20000.00, 'available', NULL, '2026-01-03 01:14:10', '2025-11-29 15:39:19', '2025-11-29 16:39:19', '2026-01-03 17:13:49'),
(158, 49, 87, '3', '123456', '123456', 'A', 100.00, 20000.00, 20000.00, 'sold', NULL, '2025-12-04 19:51:15', '2025-12-03 20:32:55', '2025-12-03 21:32:55', '2025-12-04 19:51:15'),
(159, 49, 87, '4', '123456', '123456', 'A', 100.00, 20000.00, 20000.00, 'sold', NULL, '2025-12-04 19:53:11', '2025-12-03 20:33:19', '2025-12-03 21:33:19', '2025-12-04 19:53:11'),
(160, 49, 1, '5', '123456', '123456', 'A', 100.00, 20000.00, 20000.00, 'reserved', NULL, '2026-01-03 00:51:42', '2025-12-03 20:33:47', '2025-12-03 21:33:47', '2026-02-10 19:31:19'),
(161, 49, NULL, '6', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'available', NULL, '2025-12-31 11:40:55', '2025-12-03 20:34:17', '2025-12-03 21:34:17', '2026-01-03 01:06:40'),
(163, 49, 203, '8', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-01-03 17:14:48', '2025-12-03 20:35:04', '2025-12-03 21:35:04', '2026-01-03 17:14:48'),
(164, 49, NULL, '9', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'available', NULL, NULL, '2025-12-03 20:35:34', '2025-12-03 21:35:34', '2026-01-03 01:08:43'),
(165, 49, NULL, '10', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'available', NULL, NULL, '2025-12-03 20:36:01', '2025-12-03 21:36:01', '2026-01-03 01:08:49'),
(166, 49, 203, '7', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-03-21 22:53:18', '2025-12-03 20:37:30', '2025-12-03 21:37:30', '2026-03-21 22:53:18'),
(167, 49, 203, '11', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-03-24 04:18:30', '2025-12-03 20:37:52', '2025-12-03 21:37:52', '2026-03-24 04:18:30'),
(168, 49, NULL, '12', '123456', '123456', 'C', 100.00, 20000.00, 20000.00, 'available', NULL, NULL, '2025-12-03 20:38:18', '2025-12-03 21:38:18', '2026-01-03 01:07:54'),
(169, 49, 203, '13', '123456', '123456', 'B', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-01-03 17:16:44', '2025-12-03 20:38:43', '2025-12-03 21:38:43', '2026-01-03 17:16:44'),
(170, 49, NULL, '14', '', '', 'C', 100.00, 20000.00, 20000.00, 'available', NULL, NULL, '2025-12-03 20:39:07', '2025-12-03 21:39:07', '2026-01-03 01:06:47'),
(171, 49, NULL, '15', '123456', '123456', 'C', 100.00, 20000.00, 20000.00, 'available', NULL, '2026-01-03 01:10:18', '2025-12-03 20:39:37', '2025-12-03 21:39:37', '2026-01-03 17:13:42'),
(172, 49, 203, '16', '', '', 'B', 100.00, 20000.00, 20000.00, 'sold', NULL, '2026-03-21 22:31:42', '2025-12-03 20:40:00', '2025-12-03 21:40:00', '2026-03-21 22:31:42'),
(173, 49, NULL, '20', '123456', '123456', 'D', 120.00, 24000.00, 24000.00, 'available', NULL, '2026-01-02 23:39:22', '2025-12-03 23:14:33', '2025-12-04 00:14:33', '2026-01-03 01:07:42'),
(176, 51, 208, '133', '32424242', '3131REG', 'A', 59.00, 7080.00, 7080.00, 'reserved', NULL, NULL, '2025-12-04 18:30:15', '2025-12-04 19:30:15', '2026-01-08 22:04:59'),
(177, 51, 203, '12A', '00520', 'REG-002', 'E', 120.00, 14400.00, 14400.00, 'sold', NULL, '2026-03-25 00:37:16', '2026-03-21 19:48:57', '2026-03-21 19:48:57', '2026-03-25 00:37:16'),
(178, 52, 203, '10', '32424242', 'REG-002', 'A', 120.00, 1200000.00, 1200000.00, 'sold', NULL, '2026-03-21 19:53:59', '2026-03-21 19:52:32', '2026-03-21 19:52:32', '2026-03-21 19:53:59'),
(179, 53, 203, '45', '12314345', '3131REG', 'b', 150.00, 30000.00, 30000.00, 'sold', NULL, '2026-03-21 20:26:39', '2026-03-21 20:10:14', '2026-03-21 20:10:14', '2026-03-21 20:26:39'),
(180, 53, 203, '666', '34325345636', '', 'A', 120.00, 24000.00, 24000.00, 'sold', NULL, '2026-03-21 22:15:11', '2026-03-21 20:31:57', '2026-03-21 20:31:57', '2026-03-21 22:15:11');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `public_price` decimal(8,2) DEFAULT NULL,
  `point` decimal(8,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `contable` enum('0','1') NOT NULL DEFAULT '0',
  `sale` enum('1','2') DEFAULT '1' COMMENT '1 = libre, 2 = stock',
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `supplier_id`, `name`, `slug`, `price`, `unit_cost`, `img`, `public_price`, `point`, `description`, `contable`, `sale`, `active`, `created_at`, `updated_at`) VALUES
(1, 0, 'Consumidor', 'consumidor', 0.00, NULL, '1719869649_e3f6e0440e85ccd4961f.png', 0.00, 0.00, '', '0', NULL, '0', '2023-08-01 21:02:48', NULL),
(2, 0, 'Pack 400', 'pack-400', 400.00, 0.00, '1719687218_fb4b53d10174ca6e44aa.png', 350.00, 300.00, '<ul>\r\n<li>3 Productos a elecci&oacute;n</li>\r\n<li>Plan de acci&oacute;n</li>\r\n<li>C&oacute;digo de &Eacute;tica</li>\r\n<li>Acceso al Backoffice</li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW160784913 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW160784913 BCX0\">Descuento en todos</span></span><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"> nuestros productos</span></span></span></span></li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW155963954 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW155963954 BCX0\">Acceso al plan de ganancia</span></span></span></span></span></span></li>\r\n</ul>', '0', NULL, '1', '2023-08-01 22:44:24', NULL),
(3, 0, 'PACK 800', 'pack-800', 800.00, 0.00, '1719687242_bbad29473f1ad8aa3798.png', 750.00, 500.00, '<ul>\r\n<li>5 Productos a elecci&oacute;n</li>\r\n<li>Plan de acci&oacute;n</li>\r\n<li>C&oacute;digo de &Eacute;tica</li>\r\n<li>Acceso al Backoffice</li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW160784913 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW160784913 BCX0\">Descuento en todos</span></span><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"> nuestros productos</span></span></span></span></li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW155963954 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW155963954 BCX0\">Acceso al plan de ganancia</span></span></span></span></span></span></li>\r\n</ul>', '0', NULL, '0', '2023-08-01 22:46:42', NULL),
(4, 0, 'PACK 1600', 'pack-1600', 1600.00, 0.00, '1753817550_39fbbbd0dc15b1a42445.png', 1250.00, 1000.00, '<ul>\r\n<li>12 Productos a elecci&oacute;n</li>\r\n<li>Plan de acci&oacute;n</li>\r\n<li>C&oacute;digo de &Eacute;tica</li>\r\n<li>Acceso al Backoffice</li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW160784913 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW160784913 BCX0\">Descuento en todos</span></span><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"> nuestros productos</span></span></span></span></li>\r\n<li><span class=\"TextRun SCXW3247740 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW3247740 BCX0\"><span class=\"EOP SCXW127418931 BCX0\" data-ccp-props=\"{\"><span class=\"EOP SCXW160784913 BCX0\" data-ccp-props=\"{\"><span class=\"TextRun SCXW155963954 BCX0\" lang=\"ES-PE\" xml:lang=\"ES-PE\" data-contrast=\"auto\"><span class=\"NormalTextRun SCXW155963954 BCX0\">Acceso al plan de ganancia</span></span></span></span></span></span></li>\r\n</ul>', '0', NULL, '1', '2023-08-01 22:48:33', NULL),
(15, 0, 'COFFEE BLUEBERRY', 'coffee-blueberry', 110.00, 30.00, '1759340092_5211a28374dc7b0a09bb.jpg', 160.00, 100.00, '<div><strong>THERMOGEN</strong>&nbsp; -&nbsp;</div>\r\n<div>\"Activa Tu D&iacute;a\"</div>\r\n<div>&nbsp;</div>\r\n<div><strong>CAF&Eacute; SOLUBLE LIOFILIZADO</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<ul>\r\n<li>Contiene antioxidantes, como polifenoles, que ayudan a combatir el da&ntilde;o causado por los radicales libres.</li>\r\n<li>Estimulante natural, aumenta la alerta mental.</li>\r\n<li>Mejora la concentraci&oacute;n y el rendimiento f&iacute;sico durante los ejercicios.</li>\r\n<li>Reduce el riesgo de enfermedades de p&aacute;rkinson, diabetes tipo 2 y ciertos tipos de c&aacute;ncer.</li>\r\n<li>Efecto positivo en el estado de animo al estimular la liberaci&oacute;n de neurotransmisores como la dopamina y la serotonina.</li>\r\n<li>Estimula la digesti&oacute;n y alivia la sensaci&oacute;n de pesadez despu&eacute;s de una comida.</li>\r\n<li>Contiene vitaminas B2, B3, B5, esenciales &bull;para el metabolismo energ&eacute;tico.</li>\r\n</ul>\r\n<div>Tambi&eacute;n contiene minerales como el potasio, magnesio y fosforo, beneficioso para la salud muscular y &oacute;sea.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>ARANDANOS ROJOS (CRANBERRY)</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<ul>\r\n<li>Previene las infecciones urinarias, contiene proantocianidinas, que impiden que las bacterias se adhieran al tracto urinario.</li>\r\n<li>Rica en antioxidantes, protegen a las c&eacute;lulas del da&ntilde;o causado por los radicales libres.</li>\r\n<li>Ayuda a prevenir las caries dentales.</li>\r\n<li>Mejora la memoria y protege el cerebro del da&ntilde;o causado por los radicales libres.</li>\r\n<li>Mejora la salud ocular, la visi&oacute;n nocturna y protege los ojos del da&ntilde;o causado por la luz de las pantallas electr&oacute;nicas.</li>\r\n<li>Mejora la salud del coraz&oacute;n al reducir los niveles de colesterol malo.</li>\r\n<li>Adecuado para la salud digestiva.</li>\r\n<li>Por su alto contenido en vitamina C puede fortalecer el sistema inmunol&oacute;gico.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>LIMON</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Excelente fuente de vitamina C.</li>\r\n<li>Mejora la funci&oacute;n inmunol&oacute;gica y promueve la producci&oacute;n de col&aacute;geno para una piel saludable.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico por su contenido de vitamina C.</li>\r\n<li>Contiene flavonoides que tienen efectos antioxidantes.</li>\r\n<li>Mejora la digesti&oacute;n, estimula la producci&oacute;n de &aacute;cido g&aacute;strico.</li>\r\n<li>Tiene propiedades diur&eacute;ticas que pueden ayudar desintoxicar el cuerpo.</li>\r\n<li>Mejora la funci&oacute;n renal.</li>\r\n<li>Reducen el riesgo de enfermedades cardiacas.</li>\r\n<li>Esencial para la hidrataci&oacute;n y el funcionamiento optimo del cuerpo.</li>\r\n<li>Promueve la producci&oacute;n de col&aacute;geno y reduce los signos de envejecimiento.</li>\r\n<li>Ayuda a mantener la saciedad y reduce el consumo de calor&iacute;as, lo que puede ser &uacute;til para el control de peso.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>GINSENG SIBERIANO (Eleutherococcus Senticosus)&nbsp;</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Mejora de la energ&iacute;a y reducci&oacute;n de la fatiga, ayudando a mejorar la resistencia f&iacute;sica y mental.</li>\r\n<li>Propiedades adaptogenas, ayuda al cuerpo a adoptarse al stress y mantener el equilibrio.</li>\r\n<li>Estimula el sistema inmunol&oacute;gico, aumentando la producci&oacute;n de c&eacute;lulas inmunitarias.</li>\r\n<li>Beneficioso para el rendimiento acad&eacute;mico y laboral.</li>\r\n<li>Mejora la circulaci&oacute;n, contribuyendo a una mejor salud cardiovascular.</li>\r\n<li>&Uacute;til para las personas que experimentan desequilibrios hormonales debido al stress.</li>\r\n<li>Mejora la salud mental, reduce s&iacute;ntomas de ansiedad.</li>\r\n<li>Mejora la recuperaci&oacute;n despu&eacute;s de los ejercicios.</li>\r\n<li>Beneficioso para personas con diabetes o resistencia a la insulina, porque regula el az&uacute;car en la sangre.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>U&Ntilde;A DE GATO (Uncaria tomentosa)</strong></div>\r\n<div>BENFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>&Uacute;til para el tratamiento de afecciones inflamatorias cr&oacute;nicas como artritis y otras enfermedades inflamatorias.</li>\r\n<li>Aumenta la actividad de gl&oacute;bulos blancos, mejorando la respuesta inmunitaria.</li>\r\n<li>Contiene propiedades antioxidantes, y reduce los riesgos de enfermedades cr&oacute;nicas y el envejecimiento prematuro.</li>\r\n<li>Trata problemas digestivos como la gastritis, las ulceras y el s&iacute;ndrome del intestino irritable.</li>\r\n<li>Contiene propiedades antivirales y antibacteriana.</li>\r\n<li>Tiene propiedades anticancer&iacute;genas ayudando a inhibir el crecimiento de c&eacute;lulas cancerosas.</li>\r\n<li>Ayuda a reducir la presi&oacute;n arterial al dilatar los vasos sangu&iacute;neos y mejora la circulaci&oacute;n cardiovascular.</li>\r\n<li>Alivia el dolor, debido a sus propiedades antiinflamatorias y analg&eacute;sicas.</li>\r\n<li>Mejora la salud articular y reduce el dolor.</li>\r\n<li>Ayuda a desentoxicar el cuerpo, mejorara la funci&oacute;n hep&aacute;tica y renal, facilitando la eliminaci&oacute;n de toxinas.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>ALOE VERA</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Excelente humectante para la piel, mantiene hidratada la piel seca.</li>\r\n<li>Tiene propiedades antiinflamatorias, que pueden ayudar a reducir la hinchaz&oacute;n y el enrojecimiento de la piel contra las afecciones de eccema y psoriasis.</li>\r\n<li>Efecto refrescante que puede ayudar a calmar la piel irritada o quemada por el sol.</li>\r\n<li>Depurativo, elimina toxinas.</li>\r\n<li>Alivia el estre&ntilde;imiento al aumentar la motilidad intestinal.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Antis&eacute;ptico, ayuda a prevenir la infecci&oacute;n.</li>\r\n<li>Antioxidante que ayuda a proteger las c&eacute;lulas del da&ntilde;o causado por los radicales libres.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>INULINA DE AGAVE</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Mejora la salud digestiva, act&uacute;a como prebi&oacute;tico.</li>\r\n<li>Controla el az&uacute;car en la sangre.</li>\r\n<li>&bull;Controla el apetito y reduciendo la ingesta de cal&oacute;rica.</li>\r\n<li>Mejora la absorci&oacute;n de minerales, como el calcio y el magnesio, que puede contribuir la salud &oacute;sea.</li>\r\n<li>Ayuda a reducir los niveles de colesterol malo en la sangre.</li>\r\n<li>Rico en antioxidantes.</li>\r\n<li>Mejora la salud intestinal y mejora el sistema inmunol&oacute;gico.</li>\r\n<li>Mejora la salud de la piel, ayudando a reducir la inflamaci&oacute;n.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>L &ndash; CARNITINA</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Mejora del metabolismo.</li>\r\n<li>Beneficioso para personas activas.</li>\r\n<li>Mejora la recuperaci&oacute;n despu&eacute;s del ejercicio, ayuda a reducir el dolor muscular.</li>\r\n<li>Reduce los niveles de triglic&eacute;ridos y mejora el perfil del colesterol.</li>\r\n<li>Beneficioso para la salud cerebral a largo plazo y para personas mayores con riesgo de enfermedades neurodegenerativas.</li>\r\n<li>Reduce la fatiga cr&oacute;nica y la sensaci&oacute;n de cansancio.</li>\r\n<li>&Uacute;til para personas con diabetes tipo 2 o resistencia ala insulina.</li>\r\n<li>Apoya a la fertilidad masculina.</li>\r\n<li>Reduce el Stress oxidativo.</li>\r\n<li>Mejora la salud hep&aacute;tica y renal.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>CROMO (Picolinato de cromo)</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Ayuda a mejorar la acci&oacute;n de la insulina.</li>\r\n<li>Regulaci&oacute;n de la glucosa en la sangre.</li>\r\n<li>Controla el apetito y los antojos.</li>\r\n<li>Mejora del metabolismo.</li>\r\n<li>Reduce el colesterol malo LDL y aumentando el colesterol bueno HDL.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div><strong>FRUTO DEL MONJE (LUO HAN GUO)</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Ideal para personas diab&eacute;ticas.</li>\r\n<li>Contiene propiedades antiinflamatorias y antimicrobianas.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Alivia problemas respiratorio e infecci&oacute;n de garganta.</li>\r\n<li>Reduce riesgos de enfermedades del coraz&oacute;n.</li>\r\n</ul>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div><strong>STEVIA</strong></div>\r\n<div>BENEFICIOS:</div>\r\n<div>&nbsp;</div>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Bajo en &iacute;ndice gluc&eacute;mico.</li>\r\n<li>Protege a las c&eacute;lulas del da&ntilde;o oxidativo.</li>\r\n<li>Promueve la salud cardiovascular.</li>\r\n<li>Promueve un equilibrio saludable en la flora intestinal.</li>\r\n<li>Seguridad y naturalidad frente a un edulcorante artificial.</li>\r\n<li>Contiene propiedades antimicrobianas &bull;ayudando a combatir ciertos pat&oacute;genos en el cuerpo.&nbsp;</li>\r\n<li>Facilita en el control de p&eacute;rdida de peso.</li>\r\n</ul>', '1', '2', '1', '2024-03-21 23:07:37', NULL),
(17, 0, 'COLLA GEN PLUS Q10', 'colla-gen-plus-q10', 110.00, 30.00, '1759340339_ee02089a3c2fe2e52c7b.jpg', 160.00, 100.00, '<p><strong>Tu Aliado Articular y Cut&aacute;neo +Q10</strong></p>\r\n<p>\"Belleza y Salud Desde el Interior \"</p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Mejora la elasticidad e hidrataci&oacute;n de la piel.</li>\r\n<li>Reduce las arrugas y l&iacute;neas de expresi&oacute;n.</li>\r\n<li>Alivia el dolor articular, y mejora la funci&oacute;n de las articulaciones en personas con artritis y osteoporosis.</li>\r\n<li>El col&aacute;geno hidrolizado puede estimular la producci&oacute;n de col&aacute;geno del cuerpo.</li>\r\n<li>Protege y repara el cart&iacute;lago de las articulaciones.</li>\r\n<li>Previene la perdida &oacute;sea.</li>\r\n<li>Aumenta la masa muscular, especialmente cuando se combina con ejercicios de fuerza.</li>\r\n<li>Mejora la salud intestinal al aumentar la producci&oacute;n la producci&oacute;n de mucina, sustancia que protege el revestimiento intestinal.</li>\r\n<li>Fortalece las u&ntilde;as y el cabello, haciendo menos propenso a romperse y quebrarse.</li>\r\n</ul>\r\n<p><strong>CAMU CAMU</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Alto en ANTOCIANINAS, pigmentos con propiedades antioxidantes.</li>\r\n<li>Contiene POLIFENOLES, con antioxidantes y antiinflamatorias que reducen enfermedades cr&oacute;nicas.</li>\r\n<li>Compuesto de propiedades anticancer&iacute;genas.</li>\r\n<li>Contiene minerales como: calcio, potasio, fosforo.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico, por la vitamina C, que protege al cuerpo de enfermedades.</li>\r\n<li>Reduce la inflamaci&oacute;n en el cuerpo, lo que puede ser beneficioso para la artritis y para la inflamaci&oacute;n intestinal.</li>\r\n<li>Mejora la salud de la piel por la vitamina C.</li>\r\n<li>Protege la salud de los ojos. Cataratas y la degeneraci&oacute;n macular.</li>\r\n<li>Fortalece los huesos y dientes.</li>\r\n</ul>\r\n<p><strong>ARANDANOS ROJOS (CRANBERRY)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Previene las infecciones urinarias, contiene proantocianidinas, que impiden que las bacterias se adhieran al tracto urinario.</li>\r\n<li>Rica en antioxidantes, protegen a las c&eacute;lulas del da&ntilde;o causado por los radicales libres.</li>\r\n<li>Ayuda a prevenir las caries dentales.</li>\r\n<li>Mejora la memoria y protege el cerebro del da&ntilde;o causado por los radicales libres.</li>\r\n<li>Mejora la salud ocular, la visi&oacute;n nocturna y protege los ojos</li>\r\n</ul>\r\n<p>del da&ntilde;o causado por la luz de las pantallas electr&oacute;nicas.</p>\r\n<ul>\r\n<li>Mejora la salud del coraz&oacute;n al reducir los niveles de colesterol bueno.</li>\r\n<li>Adecuado para la salud digestiva.</li>\r\n<li>Por su alto contenido en vitamina C puede fortalecer el sistema inmunologico.</li>\r\n</ul>\r\n<p><strong>BIOTINA (conocida como la vitamina B7 o H)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Fortalece la ca&iacute;da del cabello y u&ntilde;as.</li>\r\n<li>Mejora la salud de la piel, al mantener la hidrataci&oacute;n y la elasticidad.</li>\r\n<li>Ayuda a convertir los alimentos en energ&iacute;a.</li>\r\n<li>Mejora la sensibilidad a la insulina y a regular los niveles de az&uacute;car en la sangre, diabetes tipo2.</li>\r\n<li>Mejora la funci&oacute;n cognitiva, la memoria y la funci&oacute;n cerebral.</li>\r\n<li>Recomendable para embarazadas, suplemento prenatal.</li>\r\n</ul>\r\n<p><strong>CARTILAGO DE TIBURON</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Alivia dolores articulares.</li>\r\n<li>Mejora la elasticidad e hidrataci&oacute;n de la piel.</li>\r\n<li>Fortalecimiento del sistema inmunol&oacute;gico.</li>\r\n<li>El cart&iacute;lago de tibur&oacute;n es rico en col&aacute;geno.</li>\r\n<li>Contiene minerales como: calcio, fosforo, magnesio, potasio, sodio, cloro, hierro, zinc, cobre y manganeso.</li>\r\n<li>El col&aacute;geno de tibur&oacute;n contiene GLUCOSAMINA Y CONDROITINA.</li>\r\n</ul>\r\n<p><strong>COENZIMA Q1O (conocida UBIQUINONA)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Reduce el riesgo de enfermedades cardiacas, como insuficiencia cardiaca congestiva y la angina de pecho.</li>\r\n<li>Mejora del rendimiento f&iacute;sico al aumentar la energ&iacute;a y reducir la fatiga.</li>\r\n<li>Protege contra las enfermedades neurodegenerativas, ALZEIMER Y PARKINSON.</li>\r\n<li>Mejora la funci&oacute;n cognitiva en personas mayores.</li>\r\n<li>Mejora la calidad del esperma en hombres inf&eacute;rtiles.</li>\r\n<li>Beneficios reduce la presi&oacute;n arterial, protege contra el c&aacute;ncer, mejora la salud de la piel y reduce el dolor articular.</li>\r\n</ul>\r\n<p><strong>GLUCOSAMINA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Alivia el dolor articular asociado con la osteoartritis.</li>\r\n<li>Efectiva como los medicamentos antiinflamatorios, no contiene asteroides, para reducir el dolor.</li>\r\n<li>Mejora la flexibilidad y la movilidad de las articulaciones.</li>\r\n<li>Reduce la inflamaci&oacute;n por sus propiedades antiinflamatorias.</li>\r\n<li>Protege el cart&iacute;lago del da&ntilde;o y la degeneraci&oacute;n.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico, mejora la salud de la piel.</li>\r\n<li>Puede acelerar la cicatrizaci&oacute;n de heridas.</li>\r\n</ul>\r\n<p><strong>CALCIO</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Formaci&oacute;n y mantenimiento de huesos y dientes.</li>\r\n<li>Funci&oacute;n muscular y nerviosa, ayuda a los m&uacute;sculos a contraerse y relajarse, y a las neuronas a enviar y recibir mensajes.</li>\r\n<li>Factor esencial en la coagulaci&oacute;n de la sangre.</li>\r\n<li>Importante en la liberaci&oacute;n de hormonas y neurotransmisores, como la insulina, el glucag&oacute;n y la serotonina.</li>\r\n<li>Regula la presi&oacute;n arterial y dilata los vasos sangu&iacute;neos.</li>\r\n<li>Reduce el riesgo de c&aacute;ncer, mejora la salud cardiovascular.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n</ul>\r\n<p><strong>ALOE VERA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Excelente humectante para la piel, mantiene hidratada la piel seca.</li>\r\n<li>Tiene propiedades antiinflamatorias, que pueden ayudar a reducir la hinchaz&oacute;n y el enrojecimiento de la piel contra las afecciones de eccema y psoriasis.</li>\r\n<li>Efecto refrescante que puede ayudar a calmar la piel irritada o quemada por el sol.</li>\r\n<li>Depurativo, elimina toxinas.</li>\r\n<li>Alivia el estre&ntilde;imiento al aumentar la motilidad intestinal.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Antis&eacute;ptico, ayuda a prevenir la infecci&oacute;n.</li>\r\n<li>Antioxidante que ayuda a proteger las c&eacute;lulas del da&ntilde;o causado por los radicales libres.</li>\r\n</ul>\r\n<p><strong>ZINC</strong></p>\r\n<p>BENEFICIOS</p>\r\n<ul>\r\n<li>Esencial para el desarrollo y la funci&oacute;n de las c&eacute;lulas inmunitarias.</li>\r\n<li>Prote&iacute;na importante para la cicatrizaci&oacute;n de heridas.</li>\r\n<li>Importante para el crecimiento y desarrollo normal de ni&ntilde;os y adolescentes.</li>\r\n<li>Importante para el embarazo y la lactancia.</li>\r\n<li>Necesario para la producci&oacute;n de hormonas sexuales y la funci&oacute;n reproductiva tanto en hombres y mujeres.</li>\r\n<li>Necesario para el funcionamiento normal del gusto y el olfato.</li>\r\n<li>Ayuda a mejorar el rendimiento deportivo.</li>\r\n<li>Protege la piel del da&ntilde;o solar.</li>\r\n</ul>\r\n<p><strong>FRUTO DEL MONJE (LUO HAN GUO)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Ideal para personas diab&eacute;ticas.</li>\r\n<li>Contiene propiedades antiinflamatorias y antimicrobianas.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Alivia problemas respiratorio e infecci&oacute;n de garganta.</li>\r\n<li>Reduce riesgos de enfermedades del coraz&oacute;n.</li>\r\n</ul>\r\n<p><strong>YACON</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Excelente para personas con diabetes.</li>\r\n<li>Promueve la salud digestiva.</li>\r\n<li>Ayuda en el control de peso.</li>\r\n<li>Combate los radicales libres, protegiendo a las c&eacute;lulas del da&ntilde;o oxidativo.</li>\r\n<li>Regula la presi&oacute;n y la salud &oacute;sea.</li>\r\n<li>Contiene propiedades antiinflamatorias.</li>\r\n<li>Mejora el metabolismo.</li>\r\n</ul>\r\n<p><strong>STEVIA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Bajo en &iacute;ndice gluc&eacute;mico.</li>\r\n<li>Protege a las c&eacute;lulas del da&ntilde;o oxidativo.</li>\r\n<li>Promueve la salud cardiovascular.</li>\r\n<li>Promueve un equilibrio saludable en la flora intestinal.</li>\r\n<li>Seguridad y naturalidad frente a un edulcorante artificial.</li>\r\n<li>Contiene propiedades antimicrobianas ayudando a combatir ciertos pat&oacute;genos en el cuerpo. Facilita en el control de p&eacute;rdida&nbsp;de&nbsp;peso.</li>\r\n</ul>', '1', '2', '1', '2024-03-21 23:17:49', NULL),
(18, 0, 'ENERGY LIFE', 'energy-life', 110.00, 30.00, '1759340377_35df50b8d2d8cbf1a7b4.jpg', 160.00, 100.00, '<p><strong>Rendimiento F&iacute;sico y Mental</strong></p>\r\n<p>\"La chispa que enciende tu d&iacute;a\"</p>\r\n<p>&nbsp;</p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Rica en nutrientes, excelente fuente de vitaminas A y C.</li>\r\n<li>Contiene antioxidantes como polifenoles y los carotenoides.</li>\r\n<li>Mejora la digesti&oacute;n gracias a la fibra diet&eacute;tica presente en el maracuy&aacute;.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Contribuye a una mejor salud cardiovascular.</li>\r\n<li>Beneficioso para la salud ocular, previene cataratas y degeneraci&oacute;n macular.</li>\r\n<li>Contiene propiedades antiinflamatorias gracias a los flavonoides.</li>\r\n<li>Esencial para mantener huesos y dientes fuertes y saludables.</li>\r\n<li>Contiene propiedades sedantes leves, lo que puede reducir la ansiedad y promover un mejor sue&ntilde;o.</li>\r\n<li>Contiene antioxidantes y vitamina C, promueve la producci&oacute;n de col&aacute;geno.</li>\r\n<li>Protege loa rayos UV y otros factores ambientales.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>AGUYMANTO</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Contine altos niveles de antioxidantes como los polifenoles y carotenoides que ayudan a combatir el da&ntilde;o de los radicales libre.</li>\r\n<li>Fuente de vitaminas y minerales. Fuente de vitaminas A, C y del complejo B, (especialmente B1, B2 y B3) minerales como: hierro, fosforo y potasio.</li>\r\n<li>Propiedades antiinflamatorio.</li>\r\n<li>Refuerza el sistema inmunol&oacute;gico.</li>\r\n<li>Beneficios digestivos por la fibra diet&eacute;tica.</li>\r\n<li>Control del az&uacute;car en la sangre.</li>\r\n<li>Contiene propiedades diur&eacute;ticas, ayuda a eliminar el exceso de l&iacute;quidos y toxinas.</li>\r\n<li>Salud ocular.</li>\r\n<li>Mejora la salud del coraz&oacute;n.</li>\r\n<li>Propiedades anticancer&iacute;genas.</li>\r\n<li>Mejora la salud hep&aacute;tica.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>MANZANA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Rica en nutrientes y antioxidantes.</li>\r\n<li>Promueve la salud digestiva.</li>\r\n<li>Saludable para prevenir el estre&ntilde;imiento y mantener un microbioma equilibrado.</li>\r\n<li>Controla el peso.</li>\r\n<li>Regula el exceso de az&uacute;car en la sangre.</li>\r\n<li>Reduce riesgos de enfermedades cardiovasculares.</li>\r\n<li>Reduce enfermedades neurodegenerativas como el Alzheimer.</li>\r\n<li>Mejora la funci&oacute;n pulmonar y una reducci&oacute;n del riesgo de enfermedades respiratorias como el asma.</li>\r\n<li>Previene la osteoporosis.</li>\r\n<li>Reduce riesgos de caries dentales y enfermedades de las enc&iacute;as.</li>\r\n<li>Mejora el sistema inmunol&oacute;gico.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>GUAYUZA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Estimulante natural, contiene cafe&iacute;na, teobromina y teofilina.</li>\r\n<li>Mejora del enfoque y la concentraci&oacute;n.</li>\r\n<li>Aumenta el metabolismo, lo que puede facilitar la perdida de peso y la quema de grasa.</li>\r\n<li>Protege contra enfermedades cardiovascular.</li>\r\n<li>Regula los niveles de az&uacute;car en la sangre.</li>\r\n<li>Apoya en la digesti&oacute;n.</li>\r\n<li>Desintoxica el cuerpo</li>\r\n<li>Reduce el stress, la ansiedad y mejora el estado de animo.</li>\r\n<li>Promueve un sue&ntilde;o reparador</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>GUARANA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Contiene altas concentraciones de cafe&iacute;na, que act&uacute;a como estimulante del sistema nervioso central.</li>\r\n<li>Mejora la memoria y otras funciones cognitivas</li>\r\n<li>Aumenta el metabolismo, lo que puede facilitar la perdida de peso y la quema de grasas.</li>\r\n<li>Puede suprimir el apetito y aumentar la sensaci&oacute;n de saciedad.</li>\r\n<li>Contiene compuestos antioxidantes como catequinas y taninos que ayudan a combatir el da&ntilde;o de los radicales libres.</li>\r\n<li>Aumenta la resistencia y el rendimiento f&iacute;sico y mental.</li>\r\n<li>Previene la formaci&oacute;n de co&aacute;gulos sangu&iacute;neos.</li>\r\n<li>Contiene efectos gastroprotectores y antiinflamatorios en el tracto gastrointestinal.</li>\r\n<li>Reduce el stress y la ansiedad, algunos estudios sugieren que la cafe&iacute;na del guarana puede tener efectos ansiol&iacute;ticos y antidepresivos.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>MACA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Energizante natural, aumenta los niveles de energ&iacute;a.</li>\r\n<li>Combate la fatiga, el stress y la ansiedad.</li>\r\n<li>Mejora la memoria, tiene efectos positivos en la salud mental.</li>\r\n<li>Reguladora hormonal, ayuda equilibrar las hormonas en el cuerpo beneficiosa para la salud en general.</li>\r\n<li>Mejora la fertilidad, tanto en hombres y mujeres.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>GINSENG SIBERIANO (Eleutherococcus Senticosus)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Mejora de la energ&iacute;a y reducci&oacute;n de la fatiga, ayudando a mejorar la resistencia f&iacute;sica y mental.</li>\r\n<li>Propiedades adaptogenas, ayuda al cuerpo a adoptarse al stress y mantener el equilibrio.</li>\r\n<li>Estimula el sistema inmunol&oacute;gico, aumentando la producci&oacute;n de c&eacute;lulas inmunitarias.</li>\r\n<li>Beneficioso para el rendimiento acad&eacute;mico y laboral.</li>\r\n<li>Mejora la circulaci&oacute;n, contribuyendo a una mejor salud cardiovascular.</li>\r\n<li>&Uacute;til para las personas que experimentan desequilibrios hormonales debido al stress.</li>\r\n<li>Mejora la salud mental, reduce s&iacute;ntomas de ansiedad.</li>\r\n<li>Mejora la recuperaci&oacute;n despu&eacute;s de los ejercicios.</li>\r\n<li>Beneficioso para personas con diabetes o resistencia a la insulina, porque regula el az&uacute;car en la sangre.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>FRUTO DEL MONJE (LUO HAN GUO)</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Ideal para personas diab&eacute;ticas.</li>\r\n<li>Contiene propiedades antiinflamatorias y antimicrobianas.</li>\r\n<li>Fortalece el sistema inmunol&oacute;gico.</li>\r\n<li>Alivia problemas respiratorio e infecci&oacute;n de garganta.</li>\r\n<li>Reduce riesgos de enfermedades del coraz&oacute;n.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>YACON</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Excelente para personas con diabetes.</li>\r\n<li>Promueve la salud digestiva.</li>\r\n<li>Ayuda en el control de peso.</li>\r\n<li>Combate los radicales libres, protegiendo a las c&eacute;lulas del da&ntilde;o oxidativo.</li>\r\n<li>Regula la presi&oacute;n y la salud &oacute;sea.</li>\r\n<li>Contiene propiedades antiinflamatorias.</li>\r\n<li>Mejora el metabolismo.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>STEVIA</strong></p>\r\n<p>BENEFICIOS:</p>\r\n<ul>\r\n<li>Edulcorante sin calor&iacute;as.</li>\r\n<li>Bajo en &iacute;ndice gluc&eacute;mico.</li>\r\n<li>Protege a las c&eacute;lulas del da&ntilde;o oxidativo.</li>\r\n<li>Promueve la salud cardiovascular.</li>\r\n<li>Promueve un equilibrio saludable en la flora intestinal.</li>\r\n<li>Seguridad y naturalidad frente a un edulcorante artificial.</li>\r\n<li>Contiene propiedades antimicrobianas ayudando a combatir ciertos pat&oacute;genos en el cuerpo. Facilita en el control de p&eacute;rdida de</li>\r\n</ul>', '1', '2', '1', '2024-04-22 20:03:03', NULL),
(19, 0, 'POWER LIFE', 'power-life', 120.00, 29.00, '1759340483_5aba00c8eb67d74fa3cb.jpg', 180.00, 110.00, '<p><strong>POWER LIFE</strong></p>\r\n<p><strong>BENEFICIOS</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong>MARACUY&Aacute;:</strong></p>\r\n<p>(fruto de la pasion), rico en vitamina C y carotenoides, mejora la salud cardiovascular y fortalece el sistema inmunol&oacute;gico, favorece el sue&ntilde;o, reduce el estr&eacute;s y apoya el equilibrio hormonal masculino, la fibra mejora la digesti&oacute;n y ayuda a controlar el peso, rico en antioxidantes que protegen c&eacute;lulas y apoyan la salud sexual.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>BROMELINA DE PI&Ntilde;A:</strong></p>\r\n<p>Es una enzima que mejora la digesti&oacute;n y reduce la inflamaci&oacute;n en m&uacute;sculos y articulaciones, favorece la recuperaci&oacute;n f&iacute;sica y alivia dolores despu&eacute;s del ejercicio, apoya la salud prost&aacute;tica al combatir procesos inflamatorios, refuerza el sistema inmunol&oacute;gic.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>SAW PALMETTO:</strong></p>\r\n<p>Es una palmera enana, su fruto es utilizado para aliviar los s&iacute;ntomas de la hiperplasia prost&aacute;tica benigna (HPB), contribuye a mejorar el flujo urinario, apoya el equilibrio hormonal al inhibir la conversi&oacute;n de testosterona en DHT, contribuye a mejoras en el libido y la salud sexual.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>ASHWAGANDHA:</strong></p>\r\n<p>Es una planta que contribuye a reducir el estr&eacute;s y la ansiedad al disminuir los niveles de cortisol, aumenta los niveles de testosterona y mejora la fertilidad (calidad del esperma), favorece el crecimiento muscular y la fuerza f&iacute;sica en hombres que entrenan, mejora la energ&iacute;a, el estado de &aacute;nimo y la funci&oacute;n sexual.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>MACA NEGRA<em>:</em></strong></p>\r\n<p>Es una ra&iacute;z, la cual tiene efectos positivos en la energ&iacute;a, fertilidad y rendimiento sexual masculino, aumenta el libido y el deseo sexual de forma natural, mejora la cantidad y movilidad de espermatozoides favoreciendo la fertilidad, incrementa la energ&iacute;a f&iacute;sica y mental, &uacute;til para el rendimiento deportivo, apoya el equilibrio hormonal sin alterar los niveles de testosterona directamente.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>GINKGO BILOBA:</strong></p>\r\n<p>Es una planta con propiedades que ayudan a la circulaci&oacute;n sangu&iacute;nea, favoreciendo la funci&oacute;n er&eacute;ctil y la salud sexual, aumenta la concentraci&oacute;n y la memoria mejorando el rendimiento mental, reduce el estr&eacute;s y la ansiedad gracias a sus efectos calmantes sobre el sistema nervioso, sus propiedades antioxidantes protegen las c&eacute;lulas del da&ntilde;o y el envejecimiento.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>GINSENG:</strong></p>\r\n<p>Es una ra&iacute;z que contribuye a la mejora de la funci&oacute;n er&eacute;ctil y la libido, aumenta la energ&iacute;a f&iacute;sica y mental combatiendo el cansancio y la fatiga, estimula el sistema inmunol&oacute;gico y la resistencia al estr&eacute;s, favorece el rendimiento cognitivo y la concentraci&oacute;n.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>ACHIOTE:</strong></p>\r\n<p>Es una planta tropical, cuyas semillas contienen propiedades antioxidantes gracias a los carotenoides (como la bixina), que protegen las c&eacute;lulas del da&ntilde;o oxidativo, protecci&oacute;n prost&aacute;tica aliviando inflamaciones de la pr&oacute;stata y del tracto urinario, mejora de la salud digestiva y potencial afrodis&iacute;aco.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>HUANARPO MACHO:</strong></p>\r\n<p>Es una planta que aumenta la libido y mejora el deseo sexual de forma natural, favorece la funci&oacute;n er&eacute;ctil, apoya el equilibrio hormonal masculino estimulando la producci&oacute;n de testosterona y fortalece el sistema reproductivo.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>U&Ntilde;A DE GATO:</strong></p>\r\n<p>Es una planta que fortalece el sistema inmunol&oacute;gico, ayudando a prevenir enfermedades e infecciones, contiene propiedades antiinflamatorias, &uacute;tiles para aliviar dolores articulares y musculares, mejora la salud prost&aacute;tica al reducir la inflamaci&oacute;n y promover la salud del tracto urinario, aumenta la energ&iacute;a y vitalidad contribuyendo al bienestar general y la recuperaci&oacute;n f&iacute;sica.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>MASHUA NEGRA:</strong></p>\r\n<p>Mejora la fertilidad masculina y la funci&oacute;n sexual, propiedades afrodis&iacute;acas. aumenta la energ&iacute;a y la resistencia f&iacute;sica siendo beneficiosa para la salud en general, apoya la salud prost&aacute;tica y el bienestar urinario.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>VITAMINAS C, B1, B3, B9:</strong></p>\r\n<p>Son esenciales para la salud masculina, fortaleciendo el sistema inmunol&oacute;gico, mejorando la circulaci&oacute;n y la salud cardiovascular, la vitamina C favorece la regeneraci&oacute;n celular, la B1 aumenta la energ&iacute;a y la funci&oacute;n nerviosa, la B3 mejora el colesterol y la circulaci&oacute;n, y la B9 apoya la salud reproductiva y reduce riesgos cardiovasculares.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>ZINC</strong>:</p>\r\n<p>Es un mineral esencial para la salud masculina, fundamental en la producci&oacute;n de testosterona y la funci&oacute;n inmune, ayuda en la fertilidad masculina mejorando la calidad del esperma y el conteo de espermatozoides, tiene propiedades antioxidantes.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>FRUTO DEL MONJE</strong>:</p>\r\n<p>Edulcorante natural bajo en calor&iacute;as y no eleva los niveles de az&uacute;car en sangre, ideal para personas con diabetes, contiene antioxidantes que ayudan a combatir el envejecimiento celular y promueven la salud respiratoria.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>STEVIA</strong>:</p>\r\n<p>Planta con sabor dulce sin aportar calor&iacute;as, es un edulcorante natural que no eleva los niveles de glucosa en sangre, excelente opci&oacute;n para personas con diabete, propiedades antioxidantes que protegen las c&eacute;lulas del da&ntilde;o y pu</p>\r\n<p>eden ayudar a reducir la presi&oacute;n arterial.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>---</p>', '1', '2', '1', '2025-05-08 17:36:28', NULL),
(20, 0, 'Casa Unifamiliar', 'casa-unifamiliar', 125.00, 30.00, '1759358372_3b2665ba62b6f8fe4986.jpg', 195.00, 60.00, '<p>Casa Familiar Premium -</p>\r\n<p>Confort y Espacio para tu Estilo de Vida</p>\r\n<p>Vive en una casa dise&ntilde;ada para el bienestar, con ambientes amplios y funcionales, jard&iacute;n privado y acabados modernos.</p>\r\n<p>✅ Beneficios</p>\r\n<p>Ambientes amplios y luminosos</p>\r\n<blockquote>\r\n<p>La distribuci&oacute;n inteligente permite aprovechar la luz natural y disfrutar de espacios abiertos para reuniones familiares y momentos de relax.</p>\r\n</blockquote>\r\n<p>Jard&iacute;n privado y zona de parrilla</p>\r\n<blockquote>\r\n<p>Ideal para actividades al aire libre, celebraciones y juegos infantiles, brindando privacidad y contacto con la naturaleza.</p>\r\n</blockquote>\r\n<p>Cocina equipada y comedor independiente</p>\r\n<blockquote>\r\n<p>Pensada para quienes disfrutan cocinar y compartir, con electrodom&eacute;sticos modernos y espacio para toda la familia.</p>\r\n</blockquote>\r\n<p>Seguridad y tranquilidad</p>\r\n<blockquote>\r\n<p>Ubicada en condominio cerrado con vigilancia permanente, acceso controlado y &aacute;reas verdes comunes para tu tranquilidad.</p>\r\n</blockquote>\r\n<p>Opciones de financiamiento flexibles</p>\r\n<blockquote>\r\n<p>Facilidades de pago y asesor&iacute;a personalizada para que puedas adquirir tu casa sin complicaciones.</p>\r\n</blockquote>', '1', '2', '1', '2025-07-17 20:24:30', NULL),
(21, 0, 'Departamento 2 habitaciones', 'departamento-2-habitaciones', 110.00, 29.00, '1759454906_e02195fa01f1ad0b5214.jpeg', 160.00, 50.00, '<p>Departamento 2 habitaciones</p>\r\n<p>Moderno departamento con dos habitaciones amplias, sala y comedor integrados, cocina equipada y balc&oacute;n privado. Ubicado cerca de centros comerciales, colegios y parques. Acceso a piscina, gimnasio, sal&oacute;n de eventos y zona de parrillas. Seguridad las 24 horas y estacionamiento privado. Ambientes iluminados y ventilados, ideales para familias o parejas. Opciones de financiamiento disponibles.</p>', '1', '2', '0', '2025-07-17 20:34:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(8, '2025-10-15-000000', 'App\\Database\\Migrations\\CreateInvoicesTable', 'default', 'App', 1775588482, 1),
(9, '2026-03-24-000001', 'App\\Database\\Migrations\\CreateCuentasBancarias', 'default', 'App', 1775588482, 1),
(10, '2026-03-24-000002', 'App\\Database\\Migrations\\CreateMovimientosBancarios', 'default', 'App', 1775588482, 1),
(11, '2026-03-24-000003', 'App\\Database\\Migrations\\CreateConciliacionesBancarias', 'default', 'App', 1775588482, 1),
(12, '2026-03-24-000004', 'App\\Database\\Migrations\\CreateCompras', 'default', 'App', 1775588482, 1),
(13, '2026-04-07-120000', 'App\\Database\\Migrations\\CreateGastoTipos', 'default', 'App', 1775588483, 1),
(14, '2026-04-07-120001', 'App\\Database\\Migrations\\CreateGastoSubcategorias', 'default', 'App', 1775588483, 1),
(15, '2026-04-07-120002', 'App\\Database\\Migrations\\CreateCompraGastos', 'default', 'App', 1775588559, 2),
(16, '2026-04-07-120003', 'App\\Database\\Migrations\\CreateCompraDocumentos', 'default', 'App', 1775588559, 2),
(17, '2026-04-07-120004', 'App\\Database\\Migrations\\CreateGastoReportes', 'default', 'App', 1775588559, 2);

-- --------------------------------------------------------

--
-- Table structure for table `movimientos_bancarios`
--

CREATE TABLE `movimientos_bancarios` (
  `id` int(11) NOT NULL,
  `cuenta_bancaria_id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `saldo_anterior` decimal(12,2) NOT NULL,
  `saldo_nuevo` decimal(12,2) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `referencia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outgoing`
--

CREATE TABLE `outgoing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_cost` decimal(8,2) DEFAULT NULL,
  `total_cost` decimal(8,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `active` enum('0','1','2') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outgoing`
--

INSERT INTO `outgoing` (`id`, `invoice_id`, `membership_id`, `store_id`, `user_id`, `unit_cost`, `total_cost`, `qty`, `date`, `active`, `created_at`) VALUES
(90, 13, 17, 1, NULL, 30.00, 30.00, 1, '2024-11-06 19:05:48', '1', '2024-11-06 19:05:48'),
(91, 13, 18, 1, NULL, 30.00, 30.00, 1, '2024-11-06 19:05:48', '1', '2024-11-06 19:05:48'),
(92, 15, 17, 1, NULL, 30.00, 60.00, 2, '2024-11-14 10:37:38', '1', '2024-11-14 10:37:38'),
(93, 15, 18, 1, NULL, 30.00, 30.00, 1, '2024-11-14 10:37:38', '1', '2024-11-14 10:37:38'),
(94, 16, 17, 1, NULL, 30.00, 30.00, 1, '2024-11-25 11:58:24', '1', '2024-11-25 11:58:24'),
(96, 17, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-07 21:18:54', '1', '2024-12-07 21:18:54'),
(97, 17, 17, 1, NULL, 30.00, 30.00, 1, '2024-12-07 21:18:54', '1', '2024-12-07 21:18:54'),
(98, 20, 17, 1, NULL, 30.00, 30.00, 1, '2024-12-07 21:45:35', '1', '2024-12-07 21:45:35'),
(99, 18, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-07 21:55:26', '1', '2024-12-07 21:55:26'),
(100, 21, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-17 14:55:03', '1', '2024-12-17 14:55:03'),
(101, 24, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-17 15:04:32', '1', '2024-12-17 15:04:32'),
(102, 25, 17, 1, NULL, 30.00, 30.00, 1, '2024-12-21 16:43:36', '1', '2024-12-21 16:43:36'),
(103, 26, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-23 22:43:09', '1', '2024-12-23 22:43:09'),
(104, 28, 15, 1, NULL, 30.00, 30.00, 1, '2024-12-26 21:47:59', '1', '2024-12-26 21:47:59'),
(105, 28, 17, 1, NULL, 30.00, 30.00, 1, '2024-12-26 21:47:59', '1', '2024-12-26 21:47:59'),
(107, 29, 15, 1, NULL, 30.00, 90.00, 3, '2024-12-27 13:37:51', '1', '2024-12-27 13:37:51'),
(108, 29, 17, 1, NULL, 30.00, 120.00, 4, '2024-12-27 13:37:51', '1', '2024-12-27 13:37:51'),
(109, 29, 18, 1, NULL, 30.00, 90.00, 3, '2024-12-27 13:37:51', '1', '2024-12-27 13:37:51'),
(114, 34, 15, 1, NULL, 30.00, 90.00, 3, '2025-01-31 18:26:37', '1', '2025-01-31 18:26:37'),
(115, 34, 17, 1, NULL, 30.00, 120.00, 4, '2025-01-31 18:26:37', '1', '2025-01-31 18:26:37'),
(116, 34, 18, 1, NULL, 30.00, 90.00, 3, '2025-01-31 18:26:37', '1', '2025-01-31 18:26:37'),
(117, 46, 15, 1, NULL, 30.00, 30.00, 1, '2025-01-31 23:32:56', '1', '2025-01-31 23:32:56'),
(118, 46, 17, 1, NULL, 30.00, 60.00, 2, '2025-01-31 23:32:56', '1', '2025-01-31 23:32:56'),
(119, 47, 15, 1, NULL, 30.00, 60.00, 2, '2025-01-31 23:52:13', '1', '2025-01-31 23:52:13'),
(120, 47, 17, 1, NULL, 30.00, 30.00, 1, '2025-01-31 23:52:13', '1', '2025-01-31 23:52:13'),
(121, 47, 18, 1, NULL, 30.00, 30.00, 1, '2025-01-31 23:52:13', '1', '2025-01-31 23:52:13'),
(122, 48, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-03 17:32:57', '1', '2025-02-03 17:32:57'),
(123, 49, 15, 1, NULL, 30.00, 120.00, 4, '2025-02-12 11:06:46', '1', '2025-02-12 11:06:46'),
(124, 49, 17, 1, NULL, 30.00, 120.00, 4, '2025-02-12 11:06:46', '1', '2025-02-12 11:06:46'),
(125, 49, 18, 1, NULL, 30.00, 60.00, 2, '2025-02-12 11:06:46', '1', '2025-02-12 11:06:46'),
(126, 50, 15, 1, NULL, 30.00, 60.00, 2, '2025-02-14 07:40:50', '1', '2025-02-14 07:40:50'),
(130, 52, 15, 1, NULL, 30.00, 30.00, 1, '2025-02-17 19:04:36', '1', '2025-02-17 19:04:36'),
(131, 52, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-17 19:04:36', '1', '2025-02-17 19:04:36'),
(132, 52, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-17 19:04:36', '1', '2025-02-17 19:04:36'),
(133, 53, 15, 1, NULL, 30.00, 150.00, 5, '2025-02-20 10:11:16', '1', '2025-02-20 10:11:16'),
(135, 57, 15, 1, NULL, 30.00, 30.00, 1, '2025-02-24 23:58:27', '1', '2025-02-24 23:58:27'),
(136, 57, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-24 23:58:27', '1', '2025-02-24 23:58:27'),
(137, 57, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-24 23:58:27', '1', '2025-02-24 23:58:27'),
(139, 59, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-25 08:27:34', '1', '2025-02-25 08:27:34'),
(140, 60, 15, 1, NULL, 30.00, 30.00, 1, '2025-02-25 08:38:32', '1', '2025-02-25 08:38:32'),
(141, 60, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-25 08:38:32', '1', '2025-02-25 08:38:32'),
(142, 62, 15, 1, NULL, 30.00, 90.00, 3, '2025-02-25 15:10:43', '1', '2025-02-25 15:10:43'),
(143, 62, 17, 1, NULL, 30.00, 120.00, 4, '2025-02-25 15:10:43', '1', '2025-02-25 15:10:43'),
(144, 62, 18, 1, NULL, 30.00, 90.00, 3, '2025-02-25 15:10:43', '1', '2025-02-25 15:10:43'),
(145, 63, 15, 1, NULL, 30.00, 60.00, 2, '2025-02-26 17:56:11', '1', '2025-02-26 17:56:11'),
(146, 63, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-26 17:56:11', '1', '2025-02-26 17:56:11'),
(147, 63, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-26 17:56:11', '1', '2025-02-26 17:56:11'),
(148, 65, 15, 1, NULL, 30.00, 90.00, 3, '2025-02-28 13:57:53', '1', '2025-02-28 13:57:53'),
(149, 65, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-28 13:57:53', '1', '2025-02-28 13:57:53'),
(150, 66, 15, 1, NULL, 30.00, 30.00, 1, '2025-02-28 14:04:43', '1', '2025-02-28 14:04:43'),
(151, 66, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-28 14:04:43', '1', '2025-02-28 14:04:43'),
(152, 61, 15, 1, NULL, 30.00, 30.00, 1, '2025-02-28 15:54:15', '1', '2025-02-28 15:54:15'),
(153, 61, 17, 1, NULL, 30.00, 30.00, 1, '2025-02-28 15:54:15', '1', '2025-02-28 15:54:15'),
(154, 61, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-28 15:54:15', '1', '2025-02-28 15:54:15'),
(155, 64, 17, 1, NULL, 30.00, 60.00, 2, '2025-02-28 16:50:36', '1', '2025-02-28 16:50:36'),
(156, 67, 15, 1, NULL, 30.00, 60.00, 2, '2025-02-28 20:25:14', '1', '2025-02-28 20:25:14'),
(157, 67, 17, 1, NULL, 30.00, 60.00, 2, '2025-02-28 20:25:14', '1', '2025-02-28 20:25:14'),
(158, 67, 18, 1, NULL, 30.00, 30.00, 1, '2025-02-28 20:25:14', '1', '2025-02-28 20:25:14'),
(159, 68, 15, 1, NULL, 30.00, 120.00, 4, '2025-03-10 10:22:40', '1', '2025-03-10 10:22:40'),
(160, 68, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-10 10:22:40', '1', '2025-03-10 10:22:40'),
(161, 68, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-10 10:22:40', '1', '2025-03-10 10:22:40'),
(162, 70, 17, 1, NULL, 30.00, 60.00, 2, '2025-03-16 20:40:47', '1', '2025-03-16 20:40:47'),
(167, 79, 15, 1, NULL, 30.00, 120.00, 4, '2025-03-20 12:11:24', '1', '2025-03-20 12:11:24'),
(168, 79, 17, 1, NULL, 30.00, 120.00, 4, '2025-03-20 12:11:24', '1', '2025-03-20 12:11:24'),
(169, 79, 18, 1, NULL, 30.00, 60.00, 2, '2025-03-20 12:11:24', '1', '2025-03-20 12:11:24'),
(170, 80, 15, 1, NULL, 30.00, 60.00, 2, '2025-03-20 12:14:20', '1', '2025-03-20 12:14:20'),
(171, 80, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-20 12:14:20', '1', '2025-03-20 12:14:20'),
(172, 81, 15, 1, NULL, 30.00, 30.00, 1, '2025-03-20 13:06:09', '1', '2025-03-20 13:06:09'),
(173, 81, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-20 13:06:09', '1', '2025-03-20 13:06:09'),
(174, 81, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-20 13:06:09', '1', '2025-03-20 13:06:09'),
(175, 75, 15, 1, NULL, 30.00, 30.00, 1, '2025-03-20 13:11:03', '1', '2025-03-20 13:11:03'),
(178, 83, 17, 1, NULL, 30.00, 60.00, 2, '2025-03-20 15:18:32', '1', '2025-03-20 15:18:32'),
(179, 83, 18, 1, NULL, 30.00, 60.00, 2, '2025-03-20 15:18:32', '1', '2025-03-20 15:18:32'),
(180, 69, 15, 1, NULL, 30.00, 60.00, 2, '2025-03-20 19:08:37', '1', '2025-03-20 19:08:37'),
(181, 69, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-20 19:08:37', '1', '2025-03-20 19:08:37'),
(182, 69, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-20 19:08:37', '1', '2025-03-20 19:08:37'),
(183, 85, 15, 1, NULL, 30.00, 60.00, 2, '2025-03-29 08:26:01', '1', '2025-03-29 08:26:01'),
(184, 85, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-29 08:26:01', '1', '2025-03-29 08:26:01'),
(185, 86, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-29 14:11:22', '1', '2025-03-29 14:11:22'),
(186, 89, 15, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:16:48', '1', '2025-03-31 18:16:48'),
(187, 89, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:16:48', '1', '2025-03-31 18:16:48'),
(188, 89, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:16:48', '1', '2025-03-31 18:16:48'),
(189, 88, 15, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:23:35', '1', '2025-03-31 18:23:35'),
(190, 87, 15, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:32:02', '1', '2025-03-31 18:32:02'),
(191, 87, 17, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:32:02', '1', '2025-03-31 18:32:02'),
(192, 87, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-31 18:32:02', '1', '2025-03-31 18:32:02'),
(193, 90, 15, 1, NULL, 30.00, 60.00, 2, '2025-03-31 18:37:06', '1', '2025-03-31 18:37:06'),
(194, 91, 18, 1, NULL, 30.00, 90.00, 3, '2025-03-31 20:14:57', '1', '2025-03-31 20:14:57'),
(195, 91, 15, 1, NULL, 30.00, 120.00, 4, '2025-03-31 20:14:57', '1', '2025-03-31 20:14:57'),
(196, 91, 17, 1, NULL, 30.00, 90.00, 3, '2025-03-31 20:14:57', '1', '2025-03-31 20:14:57'),
(197, 92, 15, 1, NULL, 30.00, 120.00, 4, '2025-03-31 21:22:50', '1', '2025-03-31 21:22:50'),
(198, 92, 17, 1, NULL, 30.00, 180.00, 6, '2025-03-31 21:22:50', '1', '2025-03-31 21:22:50'),
(199, 92, 18, 1, NULL, 30.00, 30.00, 1, '2025-03-31 21:22:50', '1', '2025-03-31 21:22:50'),
(200, 93, 15, 1, NULL, 30.00, 90.00, 3, '2025-03-31 21:52:19', '1', '2025-03-31 21:52:19'),
(201, 93, 17, 1, NULL, 30.00, 60.00, 2, '2025-03-31 21:52:19', '1', '2025-03-31 21:52:19'),
(202, 95, 15, 1, NULL, 30.00, 60.00, 2, '2025-04-01 18:36:43', '1', '2025-04-01 18:36:43'),
(203, 95, 17, 1, NULL, 30.00, 60.00, 2, '2025-04-01 18:36:43', '1', '2025-04-01 18:36:43'),
(204, 95, 18, 1, NULL, 30.00, 30.00, 1, '2025-04-01 18:36:43', '1', '2025-04-01 18:36:43'),
(223, 120, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-11 15:12:59', '1', '2025-04-11 15:12:59'),
(224, 121, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-11 15:18:51', '1', '2025-04-11 15:18:51'),
(225, 122, 17, 1, NULL, 30.00, 30.00, 1, '2025-04-11 15:19:22', '1', '2025-04-11 15:19:22'),
(229, 126, 17, 1, NULL, 30.00, 90.00, 3, '2025-04-14 15:42:56', '1', '2025-04-14 15:42:56'),
(230, 127, 15, 1, NULL, 30.00, 60.00, 2, '2025-04-15 17:33:14', '1', '2025-04-15 17:33:14'),
(231, 127, 17, 1, NULL, 30.00, 60.00, 2, '2025-04-15 17:33:14', '1', '2025-04-15 17:33:14'),
(232, 127, 18, 1, NULL, 30.00, 30.00, 1, '2025-04-15 17:33:14', '1', '2025-04-15 17:33:14'),
(233, 128, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-15 17:54:15', '1', '2025-04-15 17:54:15'),
(293, 152, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-26 11:37:18', '1', '2025-04-26 11:37:18'),
(294, 152, 17, 1, NULL, 30.00, 30.00, 1, '2025-04-26 11:37:18', '1', '2025-04-26 11:37:18'),
(295, 152, 18, 1, NULL, 30.00, 30.00, 1, '2025-04-26 11:37:18', '1', '2025-04-26 11:37:18'),
(296, 153, 18, 1, NULL, 30.00, 30.00, 1, '2025-04-26 12:54:13', '1', '2025-04-26 12:54:13'),
(298, 155, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-29 15:14:16', '1', '2025-04-29 15:14:16'),
(299, 156, 17, 1, NULL, 30.00, 30.00, 1, '2025-04-29 19:28:14', '1', '2025-04-29 19:28:14'),
(306, 159, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-30 15:46:36', '1', '2025-04-30 15:46:36'),
(310, 166, 15, 1, NULL, 30.00, 90.00, 3, '2025-04-30 19:28:15', '1', '2025-04-30 19:28:15'),
(311, 151, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-30 20:01:40', '1', '2025-04-30 20:01:40'),
(312, 125, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-30 20:02:08', '1', '2025-04-30 20:02:08'),
(313, 167, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-30 20:06:34', '1', '2025-04-30 20:06:34'),
(314, 167, 18, 1, NULL, 30.00, 30.00, 1, '2025-04-30 20:06:34', '1', '2025-04-30 20:06:34'),
(315, 167, 17, 1, NULL, 30.00, 90.00, 3, '2025-04-30 20:06:34', '1', '2025-04-30 20:06:34'),
(316, 169, 15, 1, NULL, 30.00, 60.00, 2, '2025-04-30 20:46:30', '1', '2025-04-30 20:46:30'),
(317, 170, 15, 1, NULL, 30.00, 60.00, 2, '2025-04-30 23:14:02', '1', '2025-04-30 23:14:02'),
(318, 170, 17, 1, NULL, 30.00, 30.00, 1, '2025-04-30 23:14:02', '1', '2025-04-30 23:14:02'),
(319, 170, 18, 1, NULL, 30.00, 60.00, 2, '2025-04-30 23:14:02', '1', '2025-04-30 23:14:02'),
(320, 171, 15, 1, NULL, 30.00, 30.00, 1, '2025-04-30 23:19:26', '1', '2025-04-30 23:19:26'),
(321, 171, 17, 1, NULL, 30.00, 60.00, 2, '2025-04-30 23:19:26', '1', '2025-04-30 23:19:26'),
(322, 171, 18, 1, NULL, 30.00, 60.00, 2, '2025-04-30 23:19:26', '1', '2025-04-30 23:19:26'),
(323, 84, 15, 1, NULL, 30.00, 90.00, 3, '2025-04-30 23:25:57', '1', '2025-04-30 23:25:57'),
(324, 84, 17, 1, NULL, 30.00, 120.00, 4, '2025-04-30 23:25:57', '1', '2025-04-30 23:25:57'),
(325, 84, 18, 1, NULL, 30.00, 90.00, 3, '2025-04-30 23:25:57', '1', '2025-04-30 23:25:57'),
(341, 172, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-03 16:17:10', '1', '2025-05-03 16:17:10'),
(342, 172, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-03 16:17:10', '1', '2025-05-03 16:17:10'),
(343, 172, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-03 16:17:10', '1', '2025-05-03 16:17:10'),
(362, 187, 17, 1, NULL, 30.00, 90.00, 3, '2025-05-05 19:33:58', '1', '2025-05-05 19:33:58'),
(363, 188, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-05 20:11:20', '1', '2025-05-05 20:11:20'),
(364, 191, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-07 13:30:55', '1', '2025-05-07 13:30:55'),
(365, 191, 17, 1, NULL, 30.00, 60.00, 2, '2025-05-07 13:30:55', '1', '2025-05-07 13:30:55'),
(366, 192, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-07 14:17:55', '1', '2025-05-07 14:17:55'),
(367, 195, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-12 11:14:49', '1', '2025-05-12 11:14:49'),
(368, 197, 15, 1, NULL, 30.00, 60.00, 2, '2025-05-12 16:55:22', '1', '2025-05-12 16:55:22'),
(369, 198, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-14 13:41:49', '1', '2025-05-14 13:41:49'),
(370, 198, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-14 13:41:49', '1', '2025-05-14 13:41:49'),
(371, 199, 15, 1, NULL, 30.00, 210.00, 7, '2025-05-14 16:40:05', '1', '2025-05-14 16:40:05'),
(372, 199, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-14 16:40:05', '1', '2025-05-14 16:40:05'),
(373, 199, 18, 1, NULL, 30.00, 60.00, 2, '2025-05-14 16:40:05', '1', '2025-05-14 16:40:05'),
(374, 201, 17, 1, NULL, 30.00, 60.00, 2, '2025-05-15 13:49:34', '1', '2025-05-15 13:49:34'),
(375, 202, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-15 14:08:59', '1', '2025-05-15 14:08:59'),
(376, 206, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-17 12:50:56', '1', '2025-05-17 12:50:56'),
(377, 203, 17, 1, NULL, 30.00, 90.00, 3, '2025-05-17 12:52:07', '1', '2025-05-17 12:52:07'),
(378, 209, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-17 12:52:35', '1', '2025-05-17 12:52:35'),
(379, 210, 15, 1, NULL, 30.00, 300.00, 10, '2025-05-17 13:59:32', '1', '2025-05-17 13:59:32'),
(380, 210, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-17 13:59:32', '1', '2025-05-17 13:59:32'),
(381, 210, 18, 1, NULL, 30.00, 60.00, 2, '2025-05-17 13:59:32', '1', '2025-05-17 13:59:32'),
(382, 210, 19, 1, NULL, 29.00, 29.00, 1, '2025-05-17 13:59:32', '1', '2025-05-17 13:59:32'),
(383, 212, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-17 14:13:35', '1', '2025-05-17 14:13:35'),
(384, 212, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-17 14:13:35', '1', '2025-05-17 14:13:35'),
(385, 213, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-17 15:41:42', '1', '2025-05-17 15:41:42'),
(386, 213, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-17 15:41:42', '1', '2025-05-17 15:41:42'),
(387, 204, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-17 15:43:21', '1', '2025-05-17 15:43:21'),
(388, 204, 19, 1, NULL, 29.00, 29.00, 1, '2025-05-17 15:43:21', '1', '2025-05-17 15:43:21'),
(389, 216, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-22 18:42:29', '1', '2025-05-22 18:42:29'),
(390, 214, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-22 18:43:38', '1', '2025-05-22 18:43:38'),
(391, 217, 17, 1, NULL, 30.00, 60.00, 2, '2025-05-22 19:08:53', '1', '2025-05-22 19:08:53'),
(392, 217, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-22 19:08:53', '1', '2025-05-22 19:08:53'),
(393, 218, 17, 1, NULL, 30.00, 90.00, 3, '2025-05-23 14:03:11', '1', '2025-05-23 14:03:11'),
(395, 221, 18, 1, NULL, 30.00, 300.00, 10, '2025-05-23 14:15:15', '1', '2025-05-23 14:15:15'),
(396, 223, 18, 1, NULL, 30.00, 360.00, 12, '2025-05-23 14:29:13', '1', '2025-05-23 14:29:13'),
(397, 224, 18, 1, NULL, 30.00, 360.00, 12, '2025-05-23 14:29:53', '1', '2025-05-23 14:29:53'),
(398, 225, 18, 1, NULL, 30.00, 180.00, 6, '2025-05-23 14:38:22', '1', '2025-05-23 14:38:22'),
(399, 226, 18, 1, NULL, 30.00, 180.00, 6, '2025-05-23 14:44:13', '1', '2025-05-23 14:44:13'),
(400, 229, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-23 18:01:23', '1', '2025-05-23 18:01:23'),
(401, 229, 17, 1, NULL, 30.00, 60.00, 2, '2025-05-23 18:01:23', '1', '2025-05-23 18:01:23'),
(402, 230, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-23 18:02:53', '1', '2025-05-23 18:02:53'),
(403, 200, 15, 1, NULL, 30.00, 150.00, 5, '2025-05-23 18:03:31', '1', '2025-05-23 18:03:31'),
(404, 200, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-23 18:03:31', '1', '2025-05-23 18:03:31'),
(405, 200, 19, 1, NULL, 29.00, 58.00, 2, '2025-05-23 18:03:31', '1', '2025-05-23 18:03:31'),
(406, 222, 15, 1, NULL, 30.00, 150.00, 5, '2025-05-23 18:03:59', '1', '2025-05-23 18:03:59'),
(407, 215, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-26 16:31:49', '1', '2025-05-26 16:31:49'),
(408, 231, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-26 16:33:09', '1', '2025-05-26 16:33:09'),
(409, 231, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-26 16:33:09', '1', '2025-05-26 16:33:09'),
(410, 232, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-26 16:39:25', '1', '2025-05-26 16:39:25'),
(411, 233, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-26 17:38:35', '1', '2025-05-26 17:38:35'),
(412, 233, 19, 1, NULL, 29.00, 29.00, 1, '2025-05-26 17:38:35', '1', '2025-05-26 17:38:35'),
(413, 234, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-26 17:46:32', '1', '2025-05-26 17:46:32'),
(414, 235, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-27 18:24:05', '1', '2025-05-27 18:24:05'),
(415, 235, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-27 18:24:05', '1', '2025-05-27 18:24:05'),
(427, 254, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-29 15:39:42', '1', '2025-05-29 15:39:42'),
(428, 255, 19, 1, NULL, 29.00, 580.00, 20, '2025-05-29 16:42:36', '1', '2025-05-29 16:42:36'),
(429, 256, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-30 16:25:23', '1', '2025-05-30 16:25:23'),
(430, 256, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-30 16:25:23', '1', '2025-05-30 16:25:23'),
(431, 256, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-30 16:25:23', '1', '2025-05-30 16:25:23'),
(432, 257, 15, 1, NULL, 30.00, 60.00, 2, '2025-05-30 16:29:45', '1', '2025-05-30 16:29:45'),
(433, 257, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-30 16:29:45', '1', '2025-05-30 16:29:45'),
(434, 257, 17, 1, NULL, 30.00, 60.00, 2, '2025-05-30 16:29:45', '1', '2025-05-30 16:29:45'),
(435, 258, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-31 16:21:11', '1', '2025-05-31 16:21:11'),
(436, 260, 15, 1, NULL, 30.00, 120.00, 4, '2025-05-31 18:28:51', '1', '2025-05-31 18:28:51'),
(437, 260, 19, 1, NULL, 29.00, 87.00, 3, '2025-05-31 18:28:51', '1', '2025-05-31 18:28:51'),
(438, 261, 19, 1, NULL, 29.00, 29.00, 1, '2025-05-31 18:42:14', '1', '2025-05-31 18:42:14'),
(439, 261, 18, 1, NULL, 30.00, 30.00, 1, '2025-05-31 18:42:14', '1', '2025-05-31 18:42:14'),
(440, 261, 15, 1, NULL, 30.00, 30.00, 1, '2025-05-31 18:42:14', '1', '2025-05-31 18:42:14'),
(441, 262, 15, 1, NULL, 30.00, 60.00, 2, '2025-05-31 23:49:56', '1', '2025-05-31 23:49:56'),
(442, 262, 17, 1, NULL, 30.00, 30.00, 1, '2025-05-31 23:49:56', '1', '2025-05-31 23:49:56'),
(443, 262, 19, 1, NULL, 29.00, 58.00, 2, '2025-05-31 23:49:56', '1', '2025-05-31 23:49:56'),
(444, 263, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-02 16:36:10', '1', '2025-06-02 16:36:10'),
(445, 263, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-02 16:36:10', '1', '2025-06-02 16:36:10'),
(446, 265, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-03 19:13:51', '1', '2025-06-03 19:13:51'),
(447, 265, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-03 19:13:51', '1', '2025-06-03 19:13:51'),
(448, 265, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-03 19:13:51', '1', '2025-06-03 19:13:51'),
(449, 266, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-09 18:40:19', '1', '2025-06-09 18:40:19'),
(450, 267, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-09 18:46:53', '1', '2025-06-09 18:46:53'),
(451, 267, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-09 18:46:53', '1', '2025-06-09 18:46:53'),
(452, 267, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-09 18:46:53', '1', '2025-06-09 18:46:53'),
(453, 268, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-09 18:53:57', '1', '2025-06-09 18:53:57'),
(454, 268, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-09 18:53:57', '1', '2025-06-09 18:53:57'),
(455, 269, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-09 19:08:34', '1', '2025-06-09 19:08:34'),
(456, 269, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:08:34', '1', '2025-06-09 19:08:34'),
(457, 270, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-09 19:30:43', '1', '2025-06-09 19:30:43'),
(458, 271, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:32:43', '1', '2025-06-09 19:32:43'),
(459, 196, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:56:23', '1', '2025-06-09 19:56:23'),
(460, 196, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:56:23', '1', '2025-06-09 19:56:23'),
(461, 196, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:56:23', '1', '2025-06-09 19:56:23'),
(462, 264, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-09 19:57:45', '1', '2025-06-09 19:57:45'),
(463, 264, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-09 19:57:45', '1', '2025-06-09 19:57:45'),
(464, 259, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-09 19:58:26', '1', '2025-06-09 19:58:26'),
(465, 272, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-09 20:01:32', '1', '2025-06-09 20:01:32'),
(466, 189, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-09 21:21:00', '1', '2025-06-09 21:21:00'),
(467, 274, 15, 1, NULL, 30.00, 90.00, 3, '2025-06-10 14:19:42', '1', '2025-06-10 14:19:42'),
(468, 274, 17, 1, NULL, 30.00, 60.00, 2, '2025-06-10 14:19:42', '1', '2025-06-10 14:19:42'),
(469, 275, 17, 1, NULL, 30.00, 60.00, 2, '2025-06-10 15:56:41', '1', '2025-06-10 15:56:41'),
(470, 275, 18, 1, NULL, 30.00, 60.00, 2, '2025-06-10 15:56:41', '1', '2025-06-10 15:56:41'),
(471, 275, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-10 15:56:41', '1', '2025-06-10 15:56:41'),
(472, 276, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-10 16:36:27', '1', '2025-06-10 16:36:27'),
(473, 276, 17, 1, NULL, 30.00, 60.00, 2, '2025-06-10 16:36:27', '1', '2025-06-10 16:36:27'),
(474, 273, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-13 16:09:35', '1', '2025-06-13 16:09:35'),
(475, 277, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-13 16:11:27', '1', '2025-06-13 16:11:27'),
(476, 277, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-13 16:11:27', '1', '2025-06-13 16:11:27'),
(477, 277, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-13 16:11:27', '1', '2025-06-13 16:11:27'),
(478, 280, 15, 1, NULL, 30.00, 90.00, 3, '2025-06-19 19:29:28', '1', '2025-06-19 19:29:28'),
(479, 278, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-21 21:31:35', '1', '2025-06-21 21:31:35'),
(480, 283, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-24 13:47:09', '1', '2025-06-24 13:47:09'),
(481, 284, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-24 17:17:25', '1', '2025-06-24 17:17:25'),
(482, 285, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-24 17:39:55', '1', '2025-06-24 17:39:55'),
(483, 288, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-26 18:46:09', '1', '2025-06-26 18:46:09'),
(484, 287, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-26 21:07:43', '1', '2025-06-26 21:07:43'),
(485, 287, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-26 21:07:43', '1', '2025-06-26 21:07:43'),
(486, 287, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-26 21:07:43', '1', '2025-06-26 21:07:43'),
(487, 286, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-26 21:10:09', '1', '2025-06-26 21:10:09'),
(488, 289, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-26 21:27:08', '1', '2025-06-26 21:27:08'),
(489, 289, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-26 21:27:08', '1', '2025-06-26 21:27:08'),
(490, 291, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-28 19:48:43', '1', '2025-06-28 19:48:43'),
(491, 290, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-28 19:53:20', '1', '2025-06-28 19:53:20'),
(492, 295, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-30 14:51:24', '1', '2025-06-30 14:51:24'),
(493, 296, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-30 14:55:47', '1', '2025-06-30 14:55:47'),
(494, 296, 17, 1, NULL, 30.00, 60.00, 2, '2025-06-30 14:55:47', '1', '2025-06-30 14:55:47'),
(495, 293, 17, 1, NULL, 30.00, 90.00, 3, '2025-06-30 14:56:38', '1', '2025-06-30 14:56:38'),
(496, 282, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-30 14:58:46', '1', '2025-06-30 14:58:46'),
(497, 297, 17, 1, NULL, 30.00, 60.00, 2, '2025-06-30 15:02:18', '1', '2025-06-30 15:02:18'),
(498, 294, 15, 1, NULL, 30.00, 120.00, 4, '2025-06-30 15:03:52', '1', '2025-06-30 15:03:52'),
(499, 294, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-30 15:03:52', '1', '2025-06-30 15:03:52'),
(500, 281, 19, 1, NULL, 29.00, 29.00, 1, '2025-06-30 15:31:09', '1', '2025-06-30 15:31:09'),
(501, 298, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-30 15:55:34', '1', '2025-06-30 15:55:34'),
(502, 300, 15, 1, NULL, 30.00, 120.00, 4, '2025-06-30 16:24:54', '1', '2025-06-30 16:24:54'),
(503, 300, 17, 1, NULL, 30.00, 30.00, 1, '2025-06-30 16:24:54', '1', '2025-06-30 16:24:54'),
(506, 301, 17, 1, NULL, 30.00, 120.00, 4, '2025-06-30 17:35:40', '1', '2025-06-30 17:35:40'),
(507, 301, 15, 1, NULL, 30.00, 30.00, 1, '2025-06-30 17:35:40', '1', '2025-06-30 17:35:40'),
(508, 302, 15, 1, NULL, 30.00, 60.00, 2, '2025-06-30 23:18:36', '1', '2025-06-30 23:18:36'),
(509, 302, 18, 1, NULL, 30.00, 30.00, 1, '2025-06-30 23:18:36', '1', '2025-06-30 23:18:36'),
(510, 303, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-03 12:34:51', '1', '2025-07-03 12:34:51'),
(511, 304, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-03 19:02:52', '1', '2025-07-03 19:02:52'),
(512, 305, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-08 17:34:16', '1', '2025-07-08 17:34:16'),
(513, 305, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-08 17:34:16', '1', '2025-07-08 17:34:16'),
(514, 305, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-08 17:34:16', '1', '2025-07-08 17:34:16'),
(515, 306, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-11 13:50:35', '1', '2025-07-11 13:50:35'),
(516, 306, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-11 13:50:35', '1', '2025-07-11 13:50:35'),
(517, 306, 19, 1, NULL, 29.00, 29.00, 1, '2025-07-11 13:50:35', '1', '2025-07-11 13:50:35'),
(518, 307, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-11 14:00:57', '1', '2025-07-11 14:00:57'),
(519, 307, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-11 14:00:57', '1', '2025-07-11 14:00:57'),
(520, 313, 15, 1, NULL, 30.00, 90.00, 3, '2025-07-16 15:30:18', '1', '2025-07-16 15:30:18'),
(521, 311, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-16 18:54:17', '1', '2025-07-16 18:54:17'),
(522, 310, 17, 1, NULL, 30.00, 60.00, 2, '2025-07-16 18:55:01', '1', '2025-07-16 18:55:01'),
(523, 310, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-16 18:55:01', '1', '2025-07-16 18:55:01'),
(524, 314, 19, 1, NULL, 29.00, 58.00, 2, '2025-07-16 18:55:45', '1', '2025-07-16 18:55:45'),
(525, 309, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-16 19:00:24', '1', '2025-07-16 19:00:24'),
(526, 308, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-16 19:01:39', '1', '2025-07-16 19:01:39'),
(527, 308, 19, 1, NULL, 29.00, 29.00, 1, '2025-07-16 19:01:39', '1', '2025-07-16 19:01:39'),
(528, 315, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-19 15:06:25', '1', '2025-07-19 15:06:25'),
(529, 315, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-19 15:06:25', '1', '2025-07-19 15:06:25'),
(530, 316, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-19 15:06:50', '1', '2025-07-19 15:06:50'),
(531, 318, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-20 14:47:40', '1', '2025-07-20 14:47:40'),
(532, 320, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-25 13:37:31', '1', '2025-07-25 13:37:31'),
(533, 322, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-26 14:59:00', '1', '2025-07-26 14:59:00'),
(534, 322, 21, 1, NULL, 29.00, 29.00, 1, '2025-07-26 14:59:00', '1', '2025-07-26 14:59:00'),
(535, 323, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-26 15:08:51', '1', '2025-07-26 15:08:51'),
(536, 323, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-26 15:08:51', '1', '2025-07-26 15:08:51'),
(537, 323, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-26 15:08:51', '1', '2025-07-26 15:08:51'),
(538, 329, 20, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:13:30', '1', '2025-07-31 16:13:30'),
(539, 329, 21, 1, NULL, 29.00, 29.00, 1, '2025-07-31 16:13:30', '1', '2025-07-31 16:13:30'),
(540, 329, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:13:30', '1', '2025-07-31 16:13:30'),
(541, 329, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:13:30', '1', '2025-07-31 16:13:30'),
(542, 326, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-31 16:16:09', '1', '2025-07-31 16:16:09'),
(543, 327, 20, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:17:24', '1', '2025-07-31 16:17:24'),
(544, 328, 21, 1, NULL, 29.00, 29.00, 1, '2025-07-31 16:19:54', '1', '2025-07-31 16:19:54'),
(545, 328, 20, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:19:54', '1', '2025-07-31 16:19:54'),
(546, 328, 19, 1, NULL, 29.00, 29.00, 1, '2025-07-31 16:19:54', '1', '2025-07-31 16:19:54'),
(547, 312, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:23:33', '1', '2025-07-31 16:23:33'),
(548, 312, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:23:33', '1', '2025-07-31 16:23:33'),
(549, 319, 15, 1, NULL, 30.00, 150.00, 5, '2025-07-31 16:25:42', '1', '2025-07-31 16:25:42'),
(550, 319, 21, 1, NULL, 29.00, 29.00, 1, '2025-07-31 16:25:42', '1', '2025-07-31 16:25:42'),
(551, 321, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-31 16:31:37', '1', '2025-07-31 16:31:37'),
(552, 321, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-31 16:31:37', '1', '2025-07-31 16:31:37'),
(553, 321, 21, 1, NULL, 29.00, 58.00, 2, '2025-07-31 16:31:37', '1', '2025-07-31 16:31:37'),
(554, 321, 19, 1, NULL, 29.00, 29.00, 1, '2025-07-31 16:31:37', '1', '2025-07-31 16:31:37'),
(555, 330, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-31 19:37:07', '1', '2025-07-31 19:37:07'),
(556, 330, 17, 1, NULL, 30.00, 60.00, 2, '2025-07-31 19:37:07', '1', '2025-07-31 19:37:07'),
(557, 330, 19, 1, NULL, 29.00, 29.00, 1, '2025-07-31 19:37:07', '1', '2025-07-31 19:37:07'),
(558, 332, 19, 1, NULL, 29.00, 58.00, 2, '2025-07-31 23:42:30', '1', '2025-07-31 23:42:30'),
(559, 332, 20, 1, NULL, 30.00, 30.00, 1, '2025-07-31 23:42:30', '1', '2025-07-31 23:42:30'),
(560, 332, 21, 1, NULL, 29.00, 29.00, 1, '2025-07-31 23:42:30', '1', '2025-07-31 23:42:30'),
(561, 332, 15, 1, NULL, 30.00, 60.00, 2, '2025-07-31 23:42:30', '1', '2025-07-31 23:42:30'),
(562, 331, 15, 1, NULL, 30.00, 30.00, 1, '2025-07-31 23:48:37', '1', '2025-07-31 23:48:37'),
(563, 331, 18, 1, NULL, 30.00, 30.00, 1, '2025-07-31 23:48:37', '1', '2025-07-31 23:48:37'),
(564, 331, 17, 1, NULL, 30.00, 30.00, 1, '2025-07-31 23:48:37', '1', '2025-07-31 23:48:37'),
(565, 333, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-06 11:34:58', '1', '2025-08-06 11:34:58'),
(566, 333, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-06 11:34:58', '1', '2025-08-06 11:34:58'),
(567, 333, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-06 11:34:58', '1', '2025-08-06 11:34:58'),
(568, 335, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-07 14:39:31', '1', '2025-08-07 14:39:31'),
(569, 335, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-07 14:39:31', '1', '2025-08-07 14:39:31'),
(570, 336, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-07 15:48:54', '1', '2025-08-07 15:48:54'),
(571, 336, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-07 15:48:54', '1', '2025-08-07 15:48:54'),
(572, 336, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-07 15:48:54', '1', '2025-08-07 15:48:54'),
(573, 334, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-07 17:11:29', '1', '2025-08-07 17:11:29'),
(574, 334, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-07 17:11:29', '1', '2025-08-07 17:11:29'),
(575, 341, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-09 20:49:57', '1', '2025-08-09 20:49:57'),
(576, 341, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-09 20:49:57', '1', '2025-08-09 20:49:57'),
(577, 341, 21, 1, NULL, 29.00, 29.00, 1, '2025-08-09 20:49:57', '1', '2025-08-09 20:49:57'),
(578, 341, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-09 20:49:57', '1', '2025-08-09 20:49:57'),
(579, 341, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-09 20:49:57', '1', '2025-08-09 20:49:57'),
(580, 340, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-09 20:53:34', '1', '2025-08-09 20:53:34'),
(581, 340, 17, 1, NULL, 30.00, 60.00, 2, '2025-08-09 20:53:34', '1', '2025-08-09 20:53:34'),
(582, 340, 21, 1, NULL, 29.00, 29.00, 1, '2025-08-09 20:53:34', '1', '2025-08-09 20:53:34'),
(583, 339, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-09 20:58:29', '1', '2025-08-09 20:58:29'),
(584, 338, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-09 20:58:52', '1', '2025-08-09 20:58:52'),
(585, 342, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-11 15:29:19', '1', '2025-08-11 15:29:19'),
(586, 346, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-14 18:46:39', '1', '2025-08-14 18:46:39'),
(587, 347, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-18 18:43:11', '1', '2025-08-18 18:43:11'),
(588, 347, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-18 18:43:11', '1', '2025-08-18 18:43:11'),
(589, 347, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-18 18:43:11', '1', '2025-08-18 18:43:11'),
(590, 351, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-21 20:05:36', '1', '2025-08-21 20:05:36'),
(591, 351, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-21 20:05:36', '1', '2025-08-21 20:05:36'),
(592, 351, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-21 20:05:36', '1', '2025-08-21 20:05:36'),
(593, 350, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-23 14:43:10', '1', '2025-08-23 14:43:10'),
(594, 345, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-23 14:44:46', '1', '2025-08-23 14:44:46'),
(595, 353, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-23 14:51:09', '1', '2025-08-23 14:51:09'),
(596, 354, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-27 15:34:40', '1', '2025-08-27 15:34:40'),
(597, 354, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-27 15:34:40', '1', '2025-08-27 15:34:40'),
(598, 355, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-30 16:58:36', '1', '2025-08-30 16:58:36'),
(599, 344, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-30 17:00:12', '1', '2025-08-30 17:00:12'),
(600, 344, 17, 1, NULL, 30.00, 60.00, 2, '2025-08-30 17:00:12', '1', '2025-08-30 17:00:12'),
(601, 344, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-30 17:00:12', '1', '2025-08-30 17:00:12'),
(602, 356, 21, 1, NULL, 29.00, 29.00, 1, '2025-08-30 19:02:37', '1', '2025-08-30 19:02:37'),
(603, 357, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-30 19:03:07', '1', '2025-08-30 19:03:07'),
(604, 324, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-30 19:34:29', '1', '2025-08-30 19:34:29'),
(605, 324, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-30 19:34:29', '1', '2025-08-30 19:34:29'),
(606, 324, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-30 19:34:29', '1', '2025-08-30 19:34:29'),
(607, 358, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-30 19:42:08', '1', '2025-08-30 19:42:08'),
(608, 358, 17, 1, NULL, 30.00, 60.00, 2, '2025-08-30 19:42:08', '1', '2025-08-30 19:42:08'),
(609, 358, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-30 19:42:08', '1', '2025-08-30 19:42:08'),
(610, 359, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-30 20:11:21', '1', '2025-08-30 20:11:21'),
(611, 361, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-31 17:10:41', '1', '2025-08-31 17:10:41'),
(612, 361, 17, 1, NULL, 30.00, 120.00, 4, '2025-08-31 17:10:41', '1', '2025-08-31 17:10:41'),
(613, 361, 21, 1, NULL, 29.00, 116.00, 4, '2025-08-31 17:10:41', '1', '2025-08-31 17:10:41'),
(614, 361, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-31 17:10:41', '1', '2025-08-31 17:10:41'),
(615, 361, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-31 17:10:41', '1', '2025-08-31 17:10:41'),
(616, 360, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-31 17:16:38', '1', '2025-08-31 17:16:38'),
(617, 360, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-31 17:16:38', '1', '2025-08-31 17:16:38'),
(618, 360, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-31 17:16:38', '1', '2025-08-31 17:16:38'),
(619, 348, 15, 1, NULL, 30.00, 150.00, 5, '2025-08-31 17:25:43', '1', '2025-08-31 17:25:43'),
(620, 362, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-31 22:42:16', '1', '2025-08-31 22:42:16'),
(621, 362, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-31 22:42:16', '1', '2025-08-31 22:42:16'),
(622, 343, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-31 23:33:39', '1', '2025-08-31 23:33:39'),
(623, 343, 18, 1, NULL, 30.00, 30.00, 1, '2025-08-31 23:33:39', '1', '2025-08-31 23:33:39'),
(624, 343, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-31 23:33:39', '1', '2025-08-31 23:33:39'),
(625, 363, 15, 1, NULL, 30.00, 60.00, 2, '2025-08-31 23:38:17', '1', '2025-08-31 23:38:17'),
(626, 363, 20, 1, NULL, 30.00, 60.00, 2, '2025-08-31 23:38:17', '1', '2025-08-31 23:38:17'),
(627, 364, 17, 1, NULL, 30.00, 90.00, 3, '2025-08-31 23:51:23', '1', '2025-08-31 23:51:23'),
(628, 364, 21, 1, NULL, 29.00, 87.00, 3, '2025-08-31 23:51:23', '1', '2025-08-31 23:51:23'),
(629, 364, 19, 1, NULL, 29.00, 58.00, 2, '2025-08-31 23:51:23', '1', '2025-08-31 23:51:23'),
(630, 364, 20, 1, NULL, 30.00, 30.00, 1, '2025-08-31 23:51:23', '1', '2025-08-31 23:51:23'),
(631, 364, 15, 1, NULL, 30.00, 90.00, 3, '2025-08-31 23:51:23', '1', '2025-08-31 23:51:23'),
(632, 365, 19, 1, NULL, 29.00, 29.00, 1, '2025-08-31 23:59:27', '1', '2025-08-31 23:59:27'),
(633, 365, 17, 1, NULL, 30.00, 30.00, 1, '2025-08-31 23:59:27', '1', '2025-08-31 23:59:27'),
(634, 365, 15, 1, NULL, 30.00, 30.00, 1, '2025-08-31 23:59:27', '1', '2025-08-31 23:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `pagos_proveedores`
--

CREATE TABLE `pagos_proveedores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proveedor_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `fecha_pago` date NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'registrado',
  `voucher_url` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_options`
--

CREATE TABLE `payment_options` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL COMMENT '0 = no activo, 1= activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_options`
--

INSERT INTO `payment_options` (`id`, `name`, `date`, `active`) VALUES
(1, 'Pago con efectivo', '2023-09-30', '1'),
(2, 'Izipay', '2023-10-01', '1'),
(3, 'Pago en Yape', '2023-10-05', '1'),
(4, 'Transferencias BCP', '2023-10-05', '1'),
(5, 'Transferencias BBVA', '2023-11-02', '1'),
(6, 'Monedero', '2024-02-26', '1');

-- --------------------------------------------------------

--
-- Table structure for table `payment_plans`
--

CREATE TABLE `payment_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL COMMENT 'Cusco o General',
  `duration_months` int(11) NOT NULL,
  `min_down_payment_percentage` decimal(5,2) NOT NULL,
  `base_interest_rate` decimal(5,2) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_plans`
--

INSERT INTO `payment_plans` (`id`, `name`, `code`, `location`, `duration_months`, `min_down_payment_percentage`, `base_interest_rate`, `is_default`, `active`, `created_at`, `updated_at`) VALUES
(2, 'Plan Cusco 24 meses', 'CSC24', 'Cusco', 24, 20.00, 3.00, 0, 1, '2025-10-02 23:20:10', '2025-10-06 18:23:55'),
(9, 'Plan Lima 36 meses', 'LIM36', 'Lima', 36, 15.00, 4.00, 1, 1, '2025-10-28 16:54:01', '2025-10-28 16:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `payment_schedules`
--

CREATE TABLE `payment_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lot_id` bigint(20) UNSIGNED NOT NULL,
  `payment_plan_id` bigint(20) UNSIGNED NOT NULL,
  `installment_number` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `capital` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `interest_accrued` decimal(10,2) DEFAULT NULL,
  `interest_accrued_date` date DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','overdue','cancelled','registered') NOT NULL DEFAULT 'pending',
  `paid_date` timestamp NULL DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `voucher_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `contract_id` int(11) NOT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `comprobante_url` varchar(255) DEFAULT NULL COMMENT 'URL del comprobante de pago (PDF, JPG, PNG)',
  `validado_notas` text DEFAULT NULL COMMENT 'Notas del admin al validar el pago',
  `validated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora cuando el admin validó el pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_schedules`
--

INSERT INTO `payment_schedules` (`id`, `lot_id`, `payment_plan_id`, `installment_number`, `due_date`, `amount`, `capital`, `interest`, `interest_accrued`, `interest_accrued_date`, `balance`, `status`, `paid_date`, `paid_amount`, `voucher_url`, `created_at`, `updated_at`, `contract_id`, `pdf_url`, `xml_url`, `comprobante_url`, `validado_notas`, `validated_at`) VALUES
(4009, 155, 2, 1, '2025-12-03', 1666.67, 1666.67, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4010, 155, 2, 2, '2026-01-03', 1666.67, 1666.67, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4011, 155, 2, 3, '2026-02-03', 1666.67, 1666.67, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4012, 155, 2, 4, '2026-03-03', 1666.67, 1666.67, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4013, 155, 2, 5, '2026-04-03', 1666.67, 1666.67, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4014, 155, 2, 6, '2026-05-03', 1666.67, 1666.67, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4015, 155, 2, 7, '2026-06-03', 1666.67, 1666.67, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4016, 155, 2, 8, '2026-07-03', 1666.67, 1666.67, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4017, 155, 2, 9, '2026-08-03', 1666.67, 1666.67, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4018, 155, 2, 10, '2026-09-03', 1666.67, 1666.67, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4019, 155, 2, 11, '2026-10-03', 1666.67, 1666.67, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4020, 155, 2, 12, '2026-11-03', 1666.67, 1666.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2025-12-04 00:11:53', '2025-12-04 00:11:53', 163, NULL, NULL, NULL, NULL, NULL),
(4021, 155, 2, 1, '2025-12-04', 555.56, 555.56, 0.00, NULL, NULL, 19444.44, 'paid', '2025-12-04 19:44:02', 555.56, NULL, '2025-12-04 19:32:58', '2025-12-04 19:44:02', 164, NULL, NULL, NULL, NULL, NULL),
(4022, 155, 2, 2, '2026-01-04', 555.56, 555.56, 0.00, NULL, NULL, 18888.89, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4023, 155, 2, 3, '2026-02-04', 555.56, 555.56, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4024, 155, 2, 4, '2026-03-04', 555.56, 555.56, 0.00, NULL, NULL, 17777.78, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4025, 155, 2, 5, '2026-04-04', 555.56, 555.56, 0.00, NULL, NULL, 17222.22, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4026, 155, 2, 6, '2026-05-04', 555.56, 555.56, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4027, 155, 2, 7, '2026-06-04', 555.56, 555.56, 0.00, NULL, NULL, 16111.11, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4028, 155, 2, 8, '2026-07-04', 555.56, 555.56, 0.00, NULL, NULL, 15555.56, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4029, 155, 2, 9, '2026-08-04', 555.56, 555.56, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4030, 155, 2, 10, '2026-09-04', 555.56, 555.56, 0.00, NULL, NULL, 14444.44, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4031, 155, 2, 11, '2026-10-04', 555.56, 555.56, 0.00, NULL, NULL, 13888.89, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4032, 155, 2, 12, '2026-11-04', 555.56, 555.56, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4033, 155, 2, 13, '2026-12-04', 555.56, 555.56, 0.00, NULL, NULL, 12777.78, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4034, 155, 2, 14, '2027-01-04', 555.56, 555.56, 0.00, NULL, NULL, 12222.22, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4035, 155, 2, 15, '2027-02-04', 555.56, 555.56, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4036, 155, 2, 16, '2027-03-04', 555.56, 555.56, 0.00, NULL, NULL, 11111.11, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4037, 155, 2, 17, '2027-04-04', 555.56, 555.56, 0.00, NULL, NULL, 10555.56, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4038, 155, 2, 18, '2027-05-04', 555.56, 555.56, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4039, 155, 2, 19, '2027-06-04', 555.56, 555.56, 0.00, NULL, NULL, 9444.44, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4040, 155, 2, 20, '2027-07-04', 555.56, 555.56, 0.00, NULL, NULL, 8888.89, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4041, 155, 2, 21, '2027-08-04', 555.56, 555.56, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4042, 155, 2, 22, '2027-09-04', 555.56, 555.56, 0.00, NULL, NULL, 7777.78, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4043, 155, 2, 23, '2027-10-04', 555.56, 555.56, 0.00, NULL, NULL, 7222.22, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4044, 155, 2, 24, '2027-11-04', 555.56, 555.56, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4045, 155, 2, 25, '2027-12-04', 555.56, 555.56, 0.00, NULL, NULL, 6111.11, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4046, 155, 2, 26, '2028-01-04', 555.56, 555.56, 0.00, NULL, NULL, 5555.56, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4047, 155, 2, 27, '2028-02-04', 555.56, 555.56, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4048, 155, 2, 28, '2028-03-04', 555.56, 555.56, 0.00, NULL, NULL, 4444.44, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4049, 155, 2, 29, '2028-04-04', 555.56, 555.56, 0.00, NULL, NULL, 3888.89, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4050, 155, 2, 30, '2028-05-04', 555.56, 555.56, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4051, 155, 2, 31, '2028-06-04', 555.56, 555.56, 0.00, NULL, NULL, 2777.78, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4052, 155, 2, 32, '2028-07-04', 555.56, 555.56, 0.00, NULL, NULL, 2222.22, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4053, 155, 2, 33, '2028-08-04', 555.56, 555.56, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4054, 155, 2, 34, '2028-09-04', 555.56, 555.56, 0.00, NULL, NULL, 1111.11, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4055, 155, 2, 35, '2028-10-04', 555.56, 555.56, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4056, 155, 2, 36, '2028-11-04', 555.56, 555.56, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:32:58', '2025-12-04 19:32:58', 164, NULL, NULL, NULL, NULL, NULL),
(4057, 156, 2, 1, '2025-12-04', 833.33, 833.33, 0.00, NULL, NULL, 9166.67, 'paid', '2025-12-04 19:48:08', 833.33, NULL, '2025-12-04 19:45:39', '2025-12-04 19:48:08', 165, NULL, NULL, NULL, NULL, NULL),
(4058, 156, 2, 2, '2026-01-04', 833.33, 833.33, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4059, 156, 2, 3, '2026-02-04', 833.33, 833.33, 0.00, NULL, NULL, 7500.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4060, 156, 2, 4, '2026-03-04', 833.33, 833.33, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4061, 156, 2, 5, '2026-04-04', 833.33, 833.33, 0.00, NULL, NULL, 5833.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4062, 156, 2, 6, '2026-05-04', 833.33, 833.33, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4063, 156, 2, 7, '2026-06-04', 833.33, 833.33, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4064, 156, 2, 8, '2026-07-04', 833.33, 833.33, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4065, 156, 2, 9, '2026-08-04', 833.33, 833.33, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4066, 156, 2, 10, '2026-09-04', 833.33, 833.33, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4067, 156, 2, 11, '2026-10-04', 833.33, 833.33, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4068, 156, 2, 12, '2026-11-04', 833.33, 833.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2025-12-04 19:45:39', '2025-12-04 19:45:39', 165, NULL, NULL, NULL, NULL, NULL),
(4069, 161, 2, 1, '2025-12-31', 416.67, 416.67, 0.00, NULL, NULL, 4583.33, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4070, 161, 2, 2, '2026-01-31', 416.67, 416.67, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4071, 161, 2, 3, '2026-03-03', 416.67, 416.67, 0.00, NULL, NULL, 3750.00, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4072, 161, 2, 4, '2026-03-31', 416.67, 416.67, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4073, 161, 2, 5, '2026-05-01', 416.67, 416.67, 0.00, NULL, NULL, 2916.67, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4074, 161, 2, 6, '2026-05-31', 416.67, 416.67, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4075, 161, 2, 7, '2026-07-01', 416.67, 416.67, 0.00, NULL, NULL, 2083.33, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4076, 161, 2, 8, '2026-07-31', 416.67, 416.67, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4077, 161, 2, 9, '2026-08-31', 416.67, 416.67, 0.00, NULL, NULL, 1250.00, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4078, 161, 2, 10, '2026-10-01', 416.67, 416.67, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4079, 161, 2, 11, '2026-10-31', 416.67, 416.67, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4080, 161, 2, 12, '2026-12-01', 416.67, 416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2025-12-31 11:40:55', '2025-12-31 11:40:55', 168, NULL, NULL, NULL, NULL, NULL),
(4081, 170, 2, 1, '2026-01-02', 833.33, 833.33, 0.00, NULL, NULL, 19166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4082, 170, 2, 2, '2026-02-02', 833.33, 833.33, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4083, 170, 2, 3, '2026-03-02', 833.33, 833.33, 0.00, NULL, NULL, 17500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4084, 170, 2, 4, '2026-04-02', 833.33, 833.33, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4085, 170, 2, 5, '2026-05-02', 833.33, 833.33, 0.00, NULL, NULL, 15833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4086, 170, 2, 6, '2026-06-02', 833.33, 833.33, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4087, 170, 2, 7, '2026-07-02', 833.33, 833.33, 0.00, NULL, NULL, 14166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4088, 170, 2, 8, '2026-08-02', 833.33, 833.33, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4089, 170, 2, 9, '2026-09-02', 833.33, 833.33, 0.00, NULL, NULL, 12500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4090, 170, 2, 10, '2026-10-02', 833.33, 833.33, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4091, 170, 2, 11, '2026-11-02', 833.33, 833.33, 0.00, NULL, NULL, 10833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4092, 170, 2, 12, '2026-12-02', 833.33, 833.33, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4093, 170, 2, 13, '2027-01-02', 833.33, 833.33, 0.00, NULL, NULL, 9166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4094, 170, 2, 14, '2027-02-02', 833.33, 833.33, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4095, 170, 2, 15, '2027-03-02', 833.33, 833.33, 0.00, NULL, NULL, 7500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4096, 170, 2, 16, '2027-04-02', 833.33, 833.33, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4097, 170, 2, 17, '2027-05-02', 833.33, 833.33, 0.00, NULL, NULL, 5833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4098, 170, 2, 18, '2027-06-02', 833.33, 833.33, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4099, 170, 2, 19, '2027-07-02', 833.33, 833.33, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4100, 170, 2, 20, '2027-08-02', 833.33, 833.33, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4101, 170, 2, 21, '2027-09-02', 833.33, 833.33, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4102, 170, 2, 22, '2027-10-02', 833.33, 833.33, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4103, 170, 2, 23, '2027-11-02', 833.33, 833.33, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4104, 170, 2, 24, '2027-12-02', 833.33, 833.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:15:38', '2026-01-02 23:15:38', 169, NULL, NULL, NULL, NULL, NULL),
(4105, 166, 2, 1, '2026-01-02', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4106, 166, 2, 2, '2026-02-02', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4107, 166, 2, 3, '2026-03-02', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4108, 166, 2, 4, '2026-04-02', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4109, 166, 2, 5, '2026-05-02', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4110, 166, 2, 6, '2026-06-02', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4111, 166, 2, 7, '2026-07-02', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4112, 166, 2, 8, '2026-08-02', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4113, 166, 2, 9, '2026-09-02', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4114, 166, 2, 10, '2026-10-02', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4115, 166, 2, 11, '2026-11-02', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4116, 166, 2, 12, '2026-12-02', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4117, 166, 2, 13, '2027-01-02', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4118, 166, 2, 14, '2027-02-02', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4119, 166, 2, 15, '2027-03-02', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4120, 166, 2, 16, '2027-04-02', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4121, 166, 2, 17, '2027-05-02', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4122, 166, 2, 18, '2027-06-02', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4123, 166, 2, 19, '2027-07-02', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4124, 166, 2, 20, '2027-08-02', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4125, 166, 2, 21, '2027-09-02', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4126, 166, 2, 22, '2027-10-02', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4127, 166, 2, 23, '2027-11-02', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4128, 166, 2, 24, '2027-12-02', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4129, 166, 2, 25, '2028-01-02', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4130, 166, 2, 26, '2028-02-02', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4131, 166, 2, 27, '2028-03-02', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4132, 166, 2, 28, '2028-04-02', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4133, 166, 2, 29, '2028-05-02', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4134, 166, 2, 30, '2028-06-02', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4135, 166, 2, 31, '2028-07-02', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4136, 166, 2, 32, '2028-08-02', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4137, 166, 2, 33, '2028-09-02', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4138, 166, 2, 34, '2028-10-02', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4139, 166, 2, 35, '2028-11-02', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4140, 166, 2, 36, '2028-12-02', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:28:01', '2026-01-02 23:28:01', 170, NULL, NULL, NULL, NULL, NULL),
(4141, 169, 2, 1, '2026-01-02', 833.33, 833.33, 0.00, NULL, NULL, 19166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4142, 169, 2, 2, '2026-02-02', 833.33, 833.33, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4143, 169, 2, 3, '2026-03-02', 833.33, 833.33, 0.00, NULL, NULL, 17500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4144, 169, 2, 4, '2026-04-02', 833.33, 833.33, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4145, 169, 2, 5, '2026-05-02', 833.33, 833.33, 0.00, NULL, NULL, 15833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4146, 169, 2, 6, '2026-06-02', 833.33, 833.33, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4147, 169, 2, 7, '2026-07-02', 833.33, 833.33, 0.00, NULL, NULL, 14166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4148, 169, 2, 8, '2026-08-02', 833.33, 833.33, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4149, 169, 2, 9, '2026-09-02', 833.33, 833.33, 0.00, NULL, NULL, 12500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4150, 169, 2, 10, '2026-10-02', 833.33, 833.33, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4151, 169, 2, 11, '2026-11-02', 833.33, 833.33, 0.00, NULL, NULL, 10833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4152, 169, 2, 12, '2026-12-02', 833.33, 833.33, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4153, 169, 2, 13, '2027-01-02', 833.33, 833.33, 0.00, NULL, NULL, 9166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4154, 169, 2, 14, '2027-02-02', 833.33, 833.33, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4155, 169, 2, 15, '2027-03-02', 833.33, 833.33, 0.00, NULL, NULL, 7500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4156, 169, 2, 16, '2027-04-02', 833.33, 833.33, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4157, 169, 2, 17, '2027-05-02', 833.33, 833.33, 0.00, NULL, NULL, 5833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4158, 169, 2, 18, '2027-06-02', 833.33, 833.33, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4159, 169, 2, 19, '2027-07-02', 833.33, 833.33, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4160, 169, 2, 20, '2027-08-02', 833.33, 833.33, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4161, 169, 2, 21, '2027-09-02', 833.33, 833.33, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4162, 169, 2, 22, '2027-10-02', 833.33, 833.33, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4163, 169, 2, 23, '2027-11-02', 833.33, 833.33, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4164, 169, 2, 24, '2027-12-02', 833.33, 833.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:35:26', '2026-01-02 23:35:26', 171, NULL, NULL, NULL, NULL, NULL),
(4165, 173, 9, 1, '2026-02-02', 556.74, 501.32, 55.42, NULL, NULL, 18498.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4166, 173, 9, 2, '2026-03-02', 556.74, 502.79, 53.95, NULL, NULL, 17995.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4167, 173, 9, 3, '2026-04-02', 556.74, 504.25, 52.49, NULL, NULL, 17491.64, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4168, 173, 9, 4, '2026-05-02', 556.74, 505.72, 51.02, NULL, NULL, 16985.92, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4169, 173, 9, 5, '2026-06-02', 556.74, 507.20, 49.54, NULL, NULL, 16478.72, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4170, 173, 9, 6, '2026-07-02', 556.74, 508.68, 48.06, NULL, NULL, 15970.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4171, 173, 9, 7, '2026-08-02', 556.74, 510.16, 46.58, NULL, NULL, 15459.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4172, 173, 9, 8, '2026-09-02', 556.74, 511.65, 45.09, NULL, NULL, 14948.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4173, 173, 9, 9, '2026-10-02', 556.74, 513.14, 43.60, NULL, NULL, 14435.10, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4174, 173, 9, 10, '2026-11-02', 556.74, 514.64, 42.10, NULL, NULL, 13920.46, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4175, 173, 9, 11, '2026-12-02', 556.74, 516.14, 40.60, NULL, NULL, 13404.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4176, 173, 9, 12, '2027-01-02', 556.74, 517.64, 39.10, NULL, NULL, 12886.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4177, 173, 9, 13, '2027-02-02', 556.74, 519.15, 37.59, NULL, NULL, 12367.52, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4178, 173, 9, 14, '2027-03-02', 556.74, 520.67, 36.07, NULL, NULL, 11846.86, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4179, 173, 9, 15, '2027-04-02', 556.74, 522.19, 34.55, NULL, NULL, 11324.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4180, 173, 9, 16, '2027-05-02', 556.74, 523.71, 33.03, NULL, NULL, 10800.96, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4181, 173, 9, 17, '2027-06-02', 556.74, 525.24, 31.50, NULL, NULL, 10275.72, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4182, 173, 9, 18, '2027-07-02', 556.74, 526.77, 29.97, NULL, NULL, 9748.96, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4183, 173, 9, 19, '2027-08-02', 556.74, 528.31, 28.43, NULL, NULL, 9220.65, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4184, 173, 9, 20, '2027-09-02', 556.74, 529.85, 26.89, NULL, NULL, 8690.80, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4185, 173, 9, 21, '2027-10-02', 556.74, 531.39, 25.35, NULL, NULL, 8159.41, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4186, 173, 9, 22, '2027-11-02', 556.74, 532.94, 23.80, NULL, NULL, 7626.47, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4187, 173, 9, 23, '2027-12-02', 556.74, 534.50, 22.24, NULL, NULL, 7091.98, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4188, 173, 9, 24, '2028-01-02', 556.74, 536.05, 20.68, NULL, NULL, 6555.92, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4189, 173, 9, 25, '2028-02-02', 556.74, 537.62, 19.12, NULL, NULL, 6018.30, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4190, 173, 9, 26, '2028-03-02', 556.74, 539.19, 17.55, NULL, NULL, 5479.12, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4191, 173, 9, 27, '2028-04-02', 556.74, 540.76, 15.98, NULL, NULL, 4938.36, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4192, 173, 9, 28, '2028-05-02', 556.74, 542.34, 14.40, NULL, NULL, 4396.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4193, 173, 9, 29, '2028-06-02', 556.74, 543.92, 12.82, NULL, NULL, 3852.10, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4194, 173, 9, 30, '2028-07-02', 556.74, 545.50, 11.24, NULL, NULL, 3306.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4195, 173, 9, 31, '2028-08-02', 556.74, 547.10, 9.64, NULL, NULL, 2759.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4196, 173, 9, 32, '2028-09-02', 556.74, 548.69, 8.05, NULL, NULL, 2210.81, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4197, 173, 9, 33, '2028-10-02', 556.74, 550.29, 6.45, NULL, NULL, 1660.52, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4198, 173, 9, 34, '2028-11-02', 556.74, 551.90, 4.84, NULL, NULL, 1108.63, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4199, 173, 9, 35, '2028-12-02', 556.74, 553.51, 3.23, NULL, NULL, 555.12, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4200, 173, 9, 36, '2029-01-02', 556.74, 555.12, 1.62, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:39:22', '2026-01-02 23:39:22', 172, NULL, NULL, NULL, NULL, NULL),
(4201, 168, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4202, 168, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4203, 168, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4204, 168, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4205, 168, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4206, 168, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4207, 168, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4208, 168, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4209, 168, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4210, 168, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4211, 168, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4212, 168, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4213, 168, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4214, 168, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4215, 168, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4216, 168, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4217, 168, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4218, 168, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4219, 168, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4220, 168, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4221, 168, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4222, 168, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4223, 168, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4224, 168, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4225, 168, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4226, 168, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4227, 168, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4228, 168, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4229, 168, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4230, 168, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4231, 168, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4232, 168, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4233, 168, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4234, 168, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4235, 168, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4236, 168, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:40:39', '2026-01-02 23:40:39', 173, NULL, NULL, NULL, NULL, NULL),
(4237, 171, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4238, 171, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4239, 171, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4240, 171, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4241, 171, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4242, 171, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4243, 171, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4244, 171, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4245, 171, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4246, 171, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4247, 171, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4248, 171, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4249, 171, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4250, 171, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4251, 171, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4252, 171, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4253, 171, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4254, 171, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4255, 171, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4256, 171, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4257, 171, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4258, 171, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4259, 171, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4260, 171, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4261, 171, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4262, 171, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4263, 171, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4264, 171, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4265, 171, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4266, 171, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4267, 171, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4268, 171, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4269, 171, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4270, 171, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4271, 171, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4272, 171, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:42:00', '2026-01-02 23:42:00', 174, NULL, NULL, NULL, NULL, NULL),
(4273, 167, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4274, 167, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4275, 167, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4276, 167, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `payment_schedules` (`id`, `lot_id`, `payment_plan_id`, `installment_number`, `due_date`, `amount`, `capital`, `interest`, `interest_accrued`, `interest_accrued_date`, `balance`, `status`, `paid_date`, `paid_amount`, `voucher_url`, `created_at`, `updated_at`, `contract_id`, `pdf_url`, `xml_url`, `comprobante_url`, `validado_notas`, `validated_at`) VALUES
(4277, 167, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4278, 167, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4279, 167, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4280, 167, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4281, 167, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4282, 167, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4283, 167, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4284, 167, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4285, 167, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4286, 167, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4287, 167, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4288, 167, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4289, 167, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4290, 167, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4291, 167, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4292, 167, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4293, 167, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4294, 167, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4295, 167, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4296, 167, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4297, 167, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4298, 167, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4299, 167, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4300, 167, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4301, 167, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4302, 167, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4303, 167, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4304, 167, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4305, 167, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4306, 167, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4307, 167, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4308, 167, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:44:27', '2026-01-02 23:44:27', 175, NULL, NULL, NULL, NULL, NULL),
(4309, 172, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4310, 172, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4311, 172, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4312, 172, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4313, 172, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4314, 172, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4315, 172, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4316, 172, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4317, 172, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4318, 172, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4319, 172, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4320, 172, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4321, 172, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4322, 172, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4323, 172, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4324, 172, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4325, 172, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4326, 172, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4327, 172, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4328, 172, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4329, 172, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4330, 172, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4331, 172, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4332, 172, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4333, 172, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4334, 172, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4335, 172, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4336, 172, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4337, 172, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4338, 172, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4339, 172, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4340, 172, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4341, 172, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4342, 172, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4343, 172, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4344, 172, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:50:00', '2026-01-02 23:50:00', 176, NULL, NULL, NULL, NULL, NULL),
(4345, 164, 2, 1, '2026-01-02', 555.56, 555.56, 0.00, NULL, NULL, 19444.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4346, 164, 2, 2, '2026-02-02', 555.56, 555.56, 0.00, NULL, NULL, 18888.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4347, 164, 2, 3, '2026-03-02', 555.56, 555.56, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4348, 164, 2, 4, '2026-04-02', 555.56, 555.56, 0.00, NULL, NULL, 17777.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4349, 164, 2, 5, '2026-05-02', 555.56, 555.56, 0.00, NULL, NULL, 17222.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4350, 164, 2, 6, '2026-06-02', 555.56, 555.56, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4351, 164, 2, 7, '2026-07-02', 555.56, 555.56, 0.00, NULL, NULL, 16111.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4352, 164, 2, 8, '2026-08-02', 555.56, 555.56, 0.00, NULL, NULL, 15555.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4353, 164, 2, 9, '2026-09-02', 555.56, 555.56, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4354, 164, 2, 10, '2026-10-02', 555.56, 555.56, 0.00, NULL, NULL, 14444.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4355, 164, 2, 11, '2026-11-02', 555.56, 555.56, 0.00, NULL, NULL, 13888.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4356, 164, 2, 12, '2026-12-02', 555.56, 555.56, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4357, 164, 2, 13, '2027-01-02', 555.56, 555.56, 0.00, NULL, NULL, 12777.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4358, 164, 2, 14, '2027-02-02', 555.56, 555.56, 0.00, NULL, NULL, 12222.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4359, 164, 2, 15, '2027-03-02', 555.56, 555.56, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4360, 164, 2, 16, '2027-04-02', 555.56, 555.56, 0.00, NULL, NULL, 11111.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4361, 164, 2, 17, '2027-05-02', 555.56, 555.56, 0.00, NULL, NULL, 10555.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4362, 164, 2, 18, '2027-06-02', 555.56, 555.56, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4363, 164, 2, 19, '2027-07-02', 555.56, 555.56, 0.00, NULL, NULL, 9444.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4364, 164, 2, 20, '2027-08-02', 555.56, 555.56, 0.00, NULL, NULL, 8888.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4365, 164, 2, 21, '2027-09-02', 555.56, 555.56, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4366, 164, 2, 22, '2027-10-02', 555.56, 555.56, 0.00, NULL, NULL, 7777.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4367, 164, 2, 23, '2027-11-02', 555.56, 555.56, 0.00, NULL, NULL, 7222.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4368, 164, 2, 24, '2027-12-02', 555.56, 555.56, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4369, 164, 2, 25, '2028-01-02', 555.56, 555.56, 0.00, NULL, NULL, 6111.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4370, 164, 2, 26, '2028-02-02', 555.56, 555.56, 0.00, NULL, NULL, 5555.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4371, 164, 2, 27, '2028-03-02', 555.56, 555.56, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4372, 164, 2, 28, '2028-04-02', 555.56, 555.56, 0.00, NULL, NULL, 4444.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4373, 164, 2, 29, '2028-05-02', 555.56, 555.56, 0.00, NULL, NULL, 3888.89, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4374, 164, 2, 30, '2028-06-02', 555.56, 555.56, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4375, 164, 2, 31, '2028-07-02', 555.56, 555.56, 0.00, NULL, NULL, 2777.78, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4376, 164, 2, 32, '2028-08-02', 555.56, 555.56, 0.00, NULL, NULL, 2222.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4377, 164, 2, 33, '2028-09-02', 555.56, 555.56, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4378, 164, 2, 34, '2028-10-02', 555.56, 555.56, 0.00, NULL, NULL, 1111.11, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4379, 164, 2, 35, '2028-11-02', 555.56, 555.56, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4380, 164, 2, 36, '2028-12-02', 555.56, 555.56, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:52:31', '2026-01-02 23:52:31', 177, NULL, NULL, NULL, NULL, NULL),
(4381, 165, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4382, 165, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4383, 165, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4384, 165, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4385, 165, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4386, 165, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4387, 165, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4388, 165, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4389, 165, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4390, 165, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4391, 165, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4392, 165, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4393, 165, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4394, 165, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4395, 165, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4396, 165, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4397, 165, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4398, 165, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4399, 165, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4400, 165, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4401, 165, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4402, 165, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4403, 165, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4404, 165, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4405, 165, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4406, 165, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4407, 165, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4408, 165, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4409, 165, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4410, 165, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4411, 165, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4412, 165, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4413, 165, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4414, 165, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4415, 165, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4416, 165, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:55:15', '2026-01-02 23:55:15', 178, NULL, NULL, NULL, NULL, NULL),
(4417, 163, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4418, 163, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4419, 163, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4420, 163, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4421, 163, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4422, 163, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4423, 163, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4424, 163, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4425, 163, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4426, 163, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4427, 163, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4428, 163, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4429, 163, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4430, 163, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4431, 163, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4432, 163, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4433, 163, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4434, 163, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4435, 163, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4436, 163, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4437, 163, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4438, 163, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4439, 163, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4440, 163, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4441, 163, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4442, 163, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4443, 163, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4444, 163, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4445, 163, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4446, 163, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4447, 163, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4448, 163, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4449, 163, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4450, 163, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4451, 163, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4452, 163, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-02 23:59:03', '2026-01-02 23:59:03', 179, NULL, NULL, NULL, NULL, NULL),
(4453, 163, 9, 1, '2026-02-02', 410.23, 369.40, 40.83, NULL, NULL, 13630.60, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4454, 163, 9, 2, '2026-03-02', 410.23, 370.47, 39.76, NULL, NULL, 13260.13, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4455, 163, 9, 3, '2026-04-02', 410.23, 371.55, 38.68, NULL, NULL, 12888.58, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4456, 163, 9, 4, '2026-05-02', 410.23, 372.64, 37.59, NULL, NULL, 12515.94, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4457, 163, 9, 5, '2026-06-02', 410.23, 373.72, 36.50, NULL, NULL, 12142.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4458, 163, 9, 6, '2026-07-02', 410.23, 374.81, 35.41, NULL, NULL, 11767.40, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4459, 163, 9, 7, '2026-08-02', 410.23, 375.91, 34.32, NULL, NULL, 11391.49, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4460, 163, 9, 8, '2026-09-02', 410.23, 377.00, 33.23, NULL, NULL, 11014.49, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4461, 163, 9, 9, '2026-10-02', 410.23, 378.10, 32.13, NULL, NULL, 10636.39, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4462, 163, 9, 10, '2026-11-02', 410.23, 379.21, 31.02, NULL, NULL, 10257.18, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4463, 163, 9, 11, '2026-12-02', 410.23, 380.31, 29.92, NULL, NULL, 9876.87, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4464, 163, 9, 12, '2027-01-02', 410.23, 381.42, 28.81, NULL, NULL, 9495.45, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4465, 163, 9, 13, '2027-02-02', 410.23, 382.53, 27.70, NULL, NULL, 9112.91, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4466, 163, 9, 14, '2027-03-02', 410.23, 383.65, 26.58, NULL, NULL, 8729.26, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4467, 163, 9, 15, '2027-04-02', 410.23, 384.77, 25.46, NULL, NULL, 8344.49, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4468, 163, 9, 16, '2027-05-02', 410.23, 385.89, 24.34, NULL, NULL, 7958.60, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4469, 163, 9, 17, '2027-06-02', 410.23, 387.02, 23.21, NULL, NULL, 7571.59, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4470, 163, 9, 18, '2027-07-02', 410.23, 388.15, 22.08, NULL, NULL, 7183.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4471, 163, 9, 19, '2027-08-02', 410.23, 389.28, 20.95, NULL, NULL, 6794.16, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4472, 163, 9, 20, '2027-09-02', 410.23, 390.41, 19.82, NULL, NULL, 6403.75, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4473, 163, 9, 21, '2027-10-02', 410.23, 391.55, 18.68, NULL, NULL, 6012.20, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4474, 163, 9, 22, '2027-11-02', 410.23, 392.69, 17.54, NULL, NULL, 5619.51, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4475, 163, 9, 23, '2027-12-02', 410.23, 393.84, 16.39, NULL, NULL, 5225.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4476, 163, 9, 24, '2028-01-02', 410.23, 394.99, 15.24, NULL, NULL, 4830.68, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4477, 163, 9, 25, '2028-02-02', 410.23, 396.14, 14.09, NULL, NULL, 4434.54, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4478, 163, 9, 26, '2028-03-02', 410.23, 397.30, 12.93, NULL, NULL, 4037.24, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4479, 163, 9, 27, '2028-04-02', 410.23, 398.45, 11.78, NULL, NULL, 3638.79, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4480, 163, 9, 28, '2028-05-02', 410.23, 399.62, 10.61, NULL, NULL, 3239.17, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4481, 163, 9, 29, '2028-06-02', 410.23, 400.78, 9.45, NULL, NULL, 2838.39, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4482, 163, 9, 30, '2028-07-02', 410.23, 401.95, 8.28, NULL, NULL, 2436.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4483, 163, 9, 31, '2028-08-02', 410.23, 403.12, 7.11, NULL, NULL, 2033.32, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4484, 163, 9, 32, '2028-09-02', 410.23, 404.30, 5.93, NULL, NULL, 1629.02, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4485, 163, 9, 33, '2028-10-02', 410.23, 405.48, 4.75, NULL, NULL, 1223.54, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4486, 163, 9, 34, '2028-11-02', 410.23, 406.66, 3.57, NULL, NULL, 816.88, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4487, 163, 9, 35, '2028-12-02', 410.23, 407.85, 2.38, NULL, NULL, 409.04, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4488, 163, 9, 36, '2029-01-02', 410.23, 409.04, 1.19, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:02:47', '2026-01-03 00:02:47', 180, NULL, NULL, NULL, NULL, NULL),
(4489, 160, 2, 1, '2026-01-02', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4490, 160, 2, 2, '2026-02-02', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4491, 160, 2, 3, '2026-03-02', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4492, 160, 2, 4, '2026-04-02', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4493, 160, 2, 5, '2026-05-02', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4494, 160, 2, 6, '2026-06-02', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4495, 160, 2, 7, '2026-07-02', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4496, 160, 2, 8, '2026-08-02', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4497, 160, 2, 9, '2026-09-02', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4498, 160, 2, 10, '2026-10-02', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4499, 160, 2, 11, '2026-11-02', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4500, 160, 2, 12, '2026-12-02', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4501, 160, 2, 13, '2027-01-02', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4502, 160, 2, 14, '2027-02-02', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4503, 160, 2, 15, '2027-03-02', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4504, 160, 2, 16, '2027-04-02', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4505, 160, 2, 17, '2027-05-02', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4506, 160, 2, 18, '2027-06-02', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4507, 160, 2, 19, '2027-07-02', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4508, 160, 2, 20, '2027-08-02', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4509, 160, 2, 21, '2027-09-02', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4510, 160, 2, 22, '2027-10-02', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4511, 160, 2, 23, '2027-11-02', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4512, 160, 2, 24, '2027-12-02', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4513, 160, 2, 25, '2028-01-02', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4514, 160, 2, 26, '2028-02-02', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4515, 160, 2, 27, '2028-03-02', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4516, 160, 2, 28, '2028-04-02', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4517, 160, 2, 29, '2028-05-02', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4518, 160, 2, 30, '2028-06-02', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4519, 160, 2, 31, '2028-07-02', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4520, 160, 2, 32, '2028-08-02', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4521, 160, 2, 33, '2028-09-02', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4522, 160, 2, 34, '2028-10-02', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4523, 160, 2, 35, '2028-11-02', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4524, 160, 2, 36, '2028-12-02', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:33:07', '2026-01-03 00:33:07', 181, NULL, NULL, NULL, NULL, NULL),
(4525, 160, 9, 1, '2026-02-02', 439.53, 395.78, 43.75, NULL, NULL, 14604.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4526, 160, 9, 2, '2026-03-02', 439.53, 396.94, 42.60, NULL, NULL, 14207.28, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4527, 160, 9, 3, '2026-04-02', 439.53, 398.09, 41.44, NULL, NULL, 13809.19, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4528, 160, 9, 4, '2026-05-02', 439.53, 399.25, 40.28, NULL, NULL, 13409.94, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4529, 160, 9, 5, '2026-06-02', 439.53, 400.42, 39.11, NULL, NULL, 13009.52, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4530, 160, 9, 6, '2026-07-02', 439.53, 401.59, 37.94, NULL, NULL, 12607.93, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4531, 160, 9, 7, '2026-08-02', 439.53, 402.76, 36.77, NULL, NULL, 12205.17, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4532, 160, 9, 8, '2026-09-02', 439.53, 403.93, 35.60, NULL, NULL, 11801.24, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4533, 160, 9, 9, '2026-10-02', 439.53, 405.11, 34.42, NULL, NULL, 11396.13, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4534, 160, 9, 10, '2026-11-02', 439.53, 406.29, 33.24, NULL, NULL, 10989.84, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4535, 160, 9, 11, '2026-12-02', 439.53, 407.48, 32.05, NULL, NULL, 10582.36, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4536, 160, 9, 12, '2027-01-02', 439.53, 408.67, 30.87, NULL, NULL, 10173.69, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4537, 160, 9, 13, '2027-02-02', 439.53, 409.86, 29.67, NULL, NULL, 9763.83, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4538, 160, 9, 14, '2027-03-02', 439.53, 411.05, 28.48, NULL, NULL, 9352.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4539, 160, 9, 15, '2027-04-02', 439.53, 412.25, 27.28, NULL, NULL, 8940.53, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4540, 160, 9, 16, '2027-05-02', 439.53, 413.45, 26.08, NULL, NULL, 8527.07, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4541, 160, 9, 17, '2027-06-02', 439.53, 414.66, 24.87, NULL, NULL, 8112.41, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4542, 160, 9, 18, '2027-07-02', 439.53, 415.87, 23.66, NULL, NULL, 7696.54, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4543, 160, 9, 19, '2027-08-02', 439.53, 417.08, 22.45, NULL, NULL, 7279.46, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4544, 160, 9, 20, '2027-09-02', 439.53, 418.30, 21.23, NULL, NULL, 6861.16, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `payment_schedules` (`id`, `lot_id`, `payment_plan_id`, `installment_number`, `due_date`, `amount`, `capital`, `interest`, `interest_accrued`, `interest_accrued_date`, `balance`, `status`, `paid_date`, `paid_amount`, `voucher_url`, `created_at`, `updated_at`, `contract_id`, `pdf_url`, `xml_url`, `comprobante_url`, `validado_notas`, `validated_at`) VALUES
(4545, 160, 9, 21, '2027-10-02', 439.53, 419.52, 20.01, NULL, NULL, 6441.64, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4546, 160, 9, 22, '2027-11-02', 439.53, 420.74, 18.79, NULL, NULL, 6020.90, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4547, 160, 9, 23, '2027-12-02', 439.53, 421.97, 17.56, NULL, NULL, 5598.93, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4548, 160, 9, 24, '2028-01-02', 439.53, 423.20, 16.33, NULL, NULL, 5175.73, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4549, 160, 9, 25, '2028-02-02', 439.53, 424.44, 15.10, NULL, NULL, 4751.29, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4550, 160, 9, 26, '2028-03-02', 439.53, 425.67, 13.86, NULL, NULL, 4325.62, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4551, 160, 9, 27, '2028-04-02', 439.53, 426.91, 12.62, NULL, NULL, 3898.70, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4552, 160, 9, 28, '2028-05-02', 439.53, 428.16, 11.37, NULL, NULL, 3470.54, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4553, 160, 9, 29, '2028-06-02', 439.53, 429.41, 10.12, NULL, NULL, 3041.14, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4554, 160, 9, 30, '2028-07-02', 439.53, 430.66, 8.87, NULL, NULL, 2610.47, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4555, 160, 9, 31, '2028-08-02', 439.53, 431.92, 7.61, NULL, NULL, 2178.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4556, 160, 9, 32, '2028-09-02', 439.53, 433.18, 6.35, NULL, NULL, 1745.38, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4557, 160, 9, 33, '2028-10-02', 439.53, 434.44, 5.09, NULL, NULL, 1310.94, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4558, 160, 9, 34, '2028-11-02', 439.53, 435.71, 3.82, NULL, NULL, 875.23, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4559, 160, 9, 35, '2028-12-02', 439.53, 436.98, 2.55, NULL, NULL, 438.25, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4560, 160, 9, 36, '2029-01-02', 439.53, 438.25, 1.28, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:43:10', '2026-01-03 00:43:10', 182, NULL, NULL, NULL, NULL, NULL),
(4561, 160, 2, 1, '2026-01-02', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4562, 160, 2, 2, '2026-02-02', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4563, 160, 2, 3, '2026-03-02', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4564, 160, 2, 4, '2026-04-02', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4565, 160, 2, 5, '2026-05-02', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4566, 160, 2, 6, '2026-06-02', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4567, 160, 2, 7, '2026-07-02', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4568, 160, 2, 8, '2026-08-02', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4569, 160, 2, 9, '2026-09-02', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4570, 160, 2, 10, '2026-10-02', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4571, 160, 2, 11, '2026-11-02', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4572, 160, 2, 12, '2026-12-02', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4573, 160, 2, 13, '2027-01-02', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4574, 160, 2, 14, '2027-02-02', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4575, 160, 2, 15, '2027-03-02', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4576, 160, 2, 16, '2027-04-02', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4577, 160, 2, 17, '2027-05-02', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4578, 160, 2, 18, '2027-06-02', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4579, 160, 2, 19, '2027-07-02', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4580, 160, 2, 20, '2027-08-02', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4581, 160, 2, 21, '2027-09-02', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4582, 160, 2, 22, '2027-10-02', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4583, 160, 2, 23, '2027-11-02', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4584, 160, 2, 24, '2027-12-02', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4585, 160, 2, 25, '2028-01-02', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4586, 160, 2, 26, '2028-02-02', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4587, 160, 2, 27, '2028-03-02', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4588, 160, 2, 28, '2028-04-02', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4589, 160, 2, 29, '2028-05-02', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4590, 160, 2, 30, '2028-06-02', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4591, 160, 2, 31, '2028-07-02', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4592, 160, 2, 32, '2028-08-02', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4593, 160, 2, 33, '2028-09-02', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4594, 160, 2, 34, '2028-10-02', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4595, 160, 2, 35, '2028-11-02', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4596, 160, 2, 36, '2028-12-02', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-03 00:51:42', '2026-01-03 00:51:42', 183, NULL, NULL, NULL, NULL, NULL),
(4597, 171, 2, 1, '2026-01-02', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4598, 171, 2, 2, '2026-02-02', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4599, 171, 2, 3, '2026-03-02', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4600, 171, 2, 4, '2026-04-02', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4601, 171, 2, 5, '2026-05-02', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4602, 171, 2, 6, '2026-06-02', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4603, 171, 2, 7, '2026-07-02', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4604, 171, 2, 8, '2026-08-02', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4605, 171, 2, 9, '2026-09-02', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4606, 171, 2, 10, '2026-10-02', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4607, 171, 2, 11, '2026-11-02', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4608, 171, 2, 12, '2026-12-02', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4609, 171, 2, 13, '2027-01-02', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4610, 171, 2, 14, '2027-02-02', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4611, 171, 2, 15, '2027-03-02', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4612, 171, 2, 16, '2027-04-02', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4613, 171, 2, 17, '2027-05-02', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4614, 171, 2, 18, '2027-06-02', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4615, 171, 2, 19, '2027-07-02', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4616, 171, 2, 20, '2027-08-02', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4617, 171, 2, 21, '2027-09-02', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4618, 171, 2, 22, '2027-10-02', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4619, 171, 2, 23, '2027-11-02', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4620, 171, 2, 24, '2027-12-02', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4621, 171, 2, 25, '2028-01-02', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, NULL, NULL, NULL),
(4622, 171, 2, 26, '2028-02-02', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'registered', '2026-01-03 17:13:10', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, 'uploads/comprobantes/1767456790_2930cfad495ce492b159.jpg', NULL, NULL),
(4623, 171, 2, 27, '2028-03-02', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'registered', '2026-01-03 16:58:48', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, 'uploads/comprobantes/1767455928_c6608409ed6d25bcb000.jpg', NULL, NULL),
(4624, 171, 2, 28, '2028-04-02', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'registered', '2026-01-03 16:55:03', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, 'uploads/comprobantes/1767455703_81f3db84a083b69a3f07.jpg', NULL, NULL),
(4625, 171, 2, 29, '2028-05-02', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'registered', '2026-01-03 16:53:52', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, 'uploads/comprobantes/1767455632_1887110fa3d6cc6e2535.jpg', NULL, NULL),
(4626, 171, 2, 30, '2028-06-02', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'registered', '2026-01-03 16:50:46', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 01:10:18', 184, NULL, NULL, 'uploads/comprobantes/1767455446_fd26b599f4d106bf548a.jpg', NULL, NULL),
(4627, 171, 2, 31, '2028-07-02', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'registered', '2026-01-03 16:45:55', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 16:45:55', 184, NULL, NULL, 'uploads/comprobantes/1767455155_ad6f6b4a64996715e922.jpg', NULL, NULL),
(4628, 171, 2, 32, '2028-08-02', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'registered', '2026-01-03 16:39:32', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 16:39:32', 184, NULL, NULL, 'uploads/comprobantes/1767454772_19d2363ce2e9887aa1b0.jpg', NULL, NULL),
(4629, 171, 2, 33, '2028-09-02', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'registered', '2026-01-03 16:36:30', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 16:36:30', 184, NULL, NULL, 'uploads/comprobantes/1767454590_f6790e614fb3c350db9b.jpg', NULL, NULL),
(4630, 171, 2, 34, '2028-10-02', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'registered', '2026-01-03 16:32:46', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 16:32:46', 184, NULL, NULL, 'uploads/comprobantes/1767454366_4e383d65ed79d5624be2.jpg', NULL, NULL),
(4631, 171, 2, 35, '2028-11-02', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'paid', '2026-01-03 15:27:40', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 15:27:40', 184, NULL, NULL, NULL, NULL, NULL),
(4632, 171, 2, 36, '2028-12-02', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'paid', '2026-01-03 14:59:27', 27.78, NULL, '2026-01-03 01:10:18', '2026-01-03 14:59:27', 184, NULL, NULL, NULL, NULL, NULL),
(4633, 156, 2, 1, '2026-01-02', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4634, 156, 2, 2, '2026-02-02', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4635, 156, 2, 3, '2026-03-02', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4636, 156, 2, 4, '2026-04-02', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4637, 156, 2, 5, '2026-05-02', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4638, 156, 2, 6, '2026-06-02', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4639, 156, 2, 7, '2026-07-02', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4640, 156, 2, 8, '2026-08-02', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4641, 156, 2, 9, '2026-09-02', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4642, 156, 2, 10, '2026-10-02', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4643, 156, 2, 11, '2026-11-02', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4644, 156, 2, 12, '2026-12-02', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4645, 156, 2, 13, '2027-01-02', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4646, 156, 2, 14, '2027-02-02', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4647, 156, 2, 15, '2027-03-02', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4648, 156, 2, 16, '2027-04-02', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4649, 156, 2, 17, '2027-05-02', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4650, 156, 2, 18, '2027-06-02', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4651, 156, 2, 19, '2027-07-02', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4652, 156, 2, 20, '2027-08-02', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4653, 156, 2, 21, '2027-09-02', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4654, 156, 2, 22, '2027-10-02', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4655, 156, 2, 23, '2027-11-02', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4656, 156, 2, 24, '2027-12-02', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4657, 156, 2, 25, '2028-01-02', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4658, 156, 2, 26, '2028-02-02', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4659, 156, 2, 27, '2028-03-02', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4660, 156, 2, 28, '2028-04-02', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4661, 156, 2, 29, '2028-05-02', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4662, 156, 2, 30, '2028-06-02', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4663, 156, 2, 31, '2028-07-02', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4664, 156, 2, 32, '2028-08-02', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4665, 156, 2, 33, '2028-09-02', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4666, 156, 2, 34, '2028-10-02', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4667, 156, 2, 35, '2028-11-02', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4668, 156, 2, 36, '2028-12-02', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-03 01:14:10', '2026-01-03 01:14:10', 185, NULL, NULL, NULL, NULL, NULL),
(4669, 163, 2, 1, '2026-01-03', 27.78, 27.78, 0.00, NULL, NULL, 972.22, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4670, 163, 2, 2, '2026-02-03', 27.78, 27.78, 0.00, NULL, NULL, 944.44, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4671, 163, 2, 3, '2026-03-03', 27.78, 27.78, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4672, 163, 2, 4, '2026-04-03', 27.78, 27.78, 0.00, NULL, NULL, 888.89, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4673, 163, 2, 5, '2026-05-03', 27.78, 27.78, 0.00, NULL, NULL, 861.11, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4674, 163, 2, 6, '2026-06-03', 27.78, 27.78, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4675, 163, 2, 7, '2026-07-03', 27.78, 27.78, 0.00, NULL, NULL, 805.56, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4676, 163, 2, 8, '2026-08-03', 27.78, 27.78, 0.00, NULL, NULL, 777.78, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4677, 163, 2, 9, '2026-09-03', 27.78, 27.78, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4678, 163, 2, 10, '2026-10-03', 27.78, 27.78, 0.00, NULL, NULL, 722.22, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4679, 163, 2, 11, '2026-11-03', 27.78, 27.78, 0.00, NULL, NULL, 694.44, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4680, 163, 2, 12, '2026-12-03', 27.78, 27.78, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4681, 163, 2, 13, '2027-01-03', 27.78, 27.78, 0.00, NULL, NULL, 638.89, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4682, 163, 2, 14, '2027-02-03', 27.78, 27.78, 0.00, NULL, NULL, 611.11, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4683, 163, 2, 15, '2027-03-03', 27.78, 27.78, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4684, 163, 2, 16, '2027-04-03', 27.78, 27.78, 0.00, NULL, NULL, 555.56, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4685, 163, 2, 17, '2027-05-03', 27.78, 27.78, 0.00, NULL, NULL, 527.78, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4686, 163, 2, 18, '2027-06-03', 27.78, 27.78, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4687, 163, 2, 19, '2027-07-03', 27.78, 27.78, 0.00, NULL, NULL, 472.22, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4688, 163, 2, 20, '2027-08-03', 27.78, 27.78, 0.00, NULL, NULL, 444.44, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4689, 163, 2, 21, '2027-09-03', 27.78, 27.78, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4690, 163, 2, 22, '2027-10-03', 27.78, 27.78, 0.00, NULL, NULL, 388.89, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4691, 163, 2, 23, '2027-11-03', 27.78, 27.78, 0.00, NULL, NULL, 361.11, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4692, 163, 2, 24, '2027-12-03', 27.78, 27.78, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4693, 163, 2, 25, '2028-01-03', 27.78, 27.78, 0.00, NULL, NULL, 305.56, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4694, 163, 2, 26, '2028-02-03', 27.78, 27.78, 0.00, NULL, NULL, 277.78, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4695, 163, 2, 27, '2028-03-03', 27.78, 27.78, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4696, 163, 2, 28, '2028-04-03', 27.78, 27.78, 0.00, NULL, NULL, 222.22, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4697, 163, 2, 29, '2028-05-03', 27.78, 27.78, 0.00, NULL, NULL, 194.44, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4698, 163, 2, 30, '2028-06-03', 27.78, 27.78, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4699, 163, 2, 31, '2028-07-03', 27.78, 27.78, 0.00, NULL, NULL, 138.89, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4700, 163, 2, 32, '2028-08-03', 27.78, 27.78, 0.00, NULL, NULL, 111.11, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4701, 163, 2, 33, '2028-09-03', 27.78, 27.78, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4702, 163, 2, 34, '2028-10-03', 27.78, 27.78, 0.00, NULL, NULL, 55.56, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4703, 163, 2, 35, '2028-11-03', 27.78, 27.78, 0.00, NULL, NULL, 27.78, 'pending', NULL, NULL, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, NULL, NULL, NULL),
(4704, 163, 2, 36, '2028-12-03', 27.78, 27.78, 0.00, NULL, NULL, 0.00, 'registered', '2026-01-09 22:07:42', 27.78, NULL, '2026-01-03 17:14:48', '2026-01-03 17:14:48', 186, NULL, NULL, 'uploads/comprobantes/1767992862_91fcf66f7cc366862d0e.jpg', NULL, NULL),
(4705, 169, 2, 1, '2026-01-03', 83.33, 83.33, 0.00, NULL, NULL, 916.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4706, 169, 2, 2, '2026-02-03', 83.33, 83.33, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4707, 169, 2, 3, '2026-03-03', 83.33, 83.33, 0.00, NULL, NULL, 750.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4708, 169, 2, 4, '2026-04-03', 83.33, 83.33, 0.00, NULL, NULL, 666.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4709, 169, 2, 5, '2026-05-03', 83.33, 83.33, 0.00, NULL, NULL, 583.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4710, 169, 2, 6, '2026-06-03', 83.33, 83.33, 0.00, NULL, NULL, 500.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4711, 169, 2, 7, '2026-07-03', 83.33, 83.33, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4712, 169, 2, 8, '2026-08-03', 83.33, 83.33, 0.00, NULL, NULL, 333.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4713, 169, 2, 9, '2026-09-03', 83.33, 83.33, 0.00, NULL, NULL, 250.00, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4714, 169, 2, 10, '2026-10-03', 83.33, 83.33, 0.00, NULL, NULL, 166.67, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4715, 169, 2, 11, '2026-11-03', 83.33, 83.33, 0.00, NULL, NULL, 83.33, 'pending', NULL, NULL, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, NULL, NULL, NULL),
(4716, 169, 2, 12, '2026-12-03', 83.33, 83.33, 0.00, NULL, NULL, 0.00, 'registered', '2026-01-03 17:18:46', 83.33, NULL, '2026-01-03 17:16:44', '2026-01-03 17:16:44', 187, NULL, NULL, 'uploads/comprobantes/1767457126_778e5ed3d2b9a94d8ea8.jpg', NULL, NULL),
(4717, 176, 2, 1, '2026-01-08', 295.00, 295.00, 0.00, NULL, NULL, 6785.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4718, 176, 2, 2, '2026-02-08', 295.00, 295.00, 0.00, NULL, NULL, 6490.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4719, 176, 2, 3, '2026-03-08', 295.00, 295.00, 0.00, NULL, NULL, 6195.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4720, 176, 2, 4, '2026-04-08', 295.00, 295.00, 0.00, NULL, NULL, 5900.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4721, 176, 2, 5, '2026-05-08', 295.00, 295.00, 0.00, NULL, NULL, 5605.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4722, 176, 2, 6, '2026-06-08', 295.00, 295.00, 0.00, NULL, NULL, 5310.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4723, 176, 2, 7, '2026-07-08', 295.00, 295.00, 0.00, NULL, NULL, 5015.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4724, 176, 2, 8, '2026-08-08', 295.00, 295.00, 0.00, NULL, NULL, 4720.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4725, 176, 2, 9, '2026-09-08', 295.00, 295.00, 0.00, NULL, NULL, 4425.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4726, 176, 2, 10, '2026-10-08', 295.00, 295.00, 0.00, NULL, NULL, 4130.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4727, 176, 2, 11, '2026-11-08', 295.00, 295.00, 0.00, NULL, NULL, 3835.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4728, 176, 2, 12, '2026-12-08', 295.00, 295.00, 0.00, NULL, NULL, 3540.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4729, 176, 2, 13, '2027-01-08', 295.00, 295.00, 0.00, NULL, NULL, 3245.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4730, 176, 2, 14, '2027-02-08', 295.00, 295.00, 0.00, NULL, NULL, 2950.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4731, 176, 2, 15, '2027-03-08', 295.00, 295.00, 0.00, NULL, NULL, 2655.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4732, 176, 2, 16, '2027-04-08', 295.00, 295.00, 0.00, NULL, NULL, 2360.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4733, 176, 2, 17, '2027-05-08', 295.00, 295.00, 0.00, NULL, NULL, 2065.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4734, 176, 2, 18, '2027-06-08', 295.00, 295.00, 0.00, NULL, NULL, 1770.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4735, 176, 2, 19, '2027-07-08', 295.00, 295.00, 0.00, NULL, NULL, 1475.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4736, 176, 2, 20, '2027-08-08', 295.00, 295.00, 0.00, NULL, NULL, 1180.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4737, 176, 2, 21, '2027-09-08', 295.00, 295.00, 0.00, NULL, NULL, 885.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4738, 176, 2, 22, '2027-10-08', 295.00, 295.00, 0.00, NULL, NULL, 590.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4739, 176, 2, 23, '2027-11-08', 295.00, 295.00, 0.00, NULL, NULL, 295.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4740, 176, 2, 24, '2027-12-08', 295.00, 295.00, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-01-08 22:04:59', '2026-01-08 22:04:59', 188, NULL, NULL, NULL, NULL, NULL),
(4741, 160, 2, 1, '2026-02-10', 1666.67, 1666.67, 0.00, NULL, NULL, 18333.33, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4742, 160, 2, 2, '2026-03-10', 1666.67, 1666.67, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4743, 160, 2, 3, '2026-04-10', 1666.67, 1666.67, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4744, 160, 2, 4, '2026-05-10', 1666.67, 1666.67, 0.00, NULL, NULL, 13333.33, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4745, 160, 2, 5, '2026-06-10', 1666.67, 1666.67, 0.00, NULL, NULL, 11666.67, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4746, 160, 2, 6, '2026-07-10', 1666.67, 1666.67, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4747, 160, 2, 7, '2026-08-10', 1666.67, 1666.67, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4748, 160, 2, 8, '2026-09-10', 1666.67, 1666.67, 0.00, NULL, NULL, 6666.67, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4749, 160, 2, 9, '2026-10-10', 1666.67, 1666.67, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4750, 160, 2, 10, '2026-11-10', 1666.67, 1666.67, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4751, 160, 2, 11, '2026-12-10', 1666.67, 1666.67, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4752, 160, 2, 12, '2027-01-10', 1666.67, 1666.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-02-10 19:31:19', '2026-02-10 19:31:19', 189, NULL, NULL, NULL, NULL, NULL),
(4753, 178, 2, 1, '2026-03-21', 416.67, 416.67, 0.00, NULL, NULL, 4583.33, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4754, 178, 2, 2, '2026-04-21', 416.67, 416.67, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4755, 178, 2, 3, '2026-05-21', 416.67, 416.67, 0.00, NULL, NULL, 3750.00, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4756, 178, 2, 4, '2026-06-21', 416.67, 416.67, 0.00, NULL, NULL, 3333.33, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4757, 178, 2, 5, '2026-07-21', 416.67, 416.67, 0.00, NULL, NULL, 2916.67, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4758, 178, 2, 6, '2026-08-21', 416.67, 416.67, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4759, 178, 2, 7, '2026-09-21', 416.67, 416.67, 0.00, NULL, NULL, 2083.33, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4760, 178, 2, 8, '2026-10-21', 416.67, 416.67, 0.00, NULL, NULL, 1666.67, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4761, 178, 2, 9, '2026-11-21', 416.67, 416.67, 0.00, NULL, NULL, 1250.00, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4762, 178, 2, 10, '2026-12-21', 416.67, 416.67, 0.00, NULL, NULL, 833.33, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4763, 178, 2, 11, '2027-01-21', 416.67, 416.67, 0.00, NULL, NULL, 416.67, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4764, 178, 2, 12, '2027-02-21', 416.67, 416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 19:53:59', '2026-03-21 19:53:59', 190, NULL, NULL, NULL, NULL, NULL),
(4765, 179, 2, 1, '2026-04-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4766, 179, 2, 2, '2026-05-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4767, 179, 2, 3, '2026-06-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4768, 179, 2, 4, '2026-07-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4769, 179, 2, 5, '2026-08-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4770, 179, 2, 6, '2026-09-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4771, 179, 2, 7, '2026-10-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4772, 179, 2, 8, '2026-11-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4773, 179, 2, 9, '2026-12-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4774, 179, 2, 10, '2027-01-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4775, 179, 2, 11, '2027-02-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4776, 179, 2, 12, '2027-03-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:11:46', '2026-03-21 20:11:46', 191, NULL, NULL, NULL, NULL, NULL),
(4777, 179, 2, 1, '2026-04-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4778, 179, 2, 2, '2026-05-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4779, 179, 2, 3, '2026-06-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4780, 179, 2, 4, '2026-07-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4781, 179, 2, 5, '2026-08-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4782, 179, 2, 6, '2026-09-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4783, 179, 2, 7, '2026-10-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4784, 179, 2, 8, '2026-11-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4785, 179, 2, 9, '2026-12-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4786, 179, 2, 10, '2027-01-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4787, 179, 2, 11, '2027-02-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4788, 179, 2, 12, '2027-03-21', -416.67, -416.67, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:24:30', '2026-03-21 20:24:30', 192, NULL, NULL, NULL, NULL, NULL),
(4789, 179, 2, 1, '2026-04-21', 2083.33, 2083.33, 0.00, NULL, NULL, 22916.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4790, 179, 2, 2, '2026-05-21', 2083.33, 2083.33, 0.00, NULL, NULL, 20833.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4791, 179, 2, 3, '2026-06-21', 2083.33, 2083.33, 0.00, NULL, NULL, 18750.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4792, 179, 2, 4, '2026-07-21', 2083.33, 2083.33, 0.00, NULL, NULL, 16666.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4793, 179, 2, 5, '2026-08-21', 2083.33, 2083.33, 0.00, NULL, NULL, 14583.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4794, 179, 2, 6, '2026-09-21', 2083.33, 2083.33, 0.00, NULL, NULL, 12500.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4795, 179, 2, 7, '2026-10-21', 2083.33, 2083.33, 0.00, NULL, NULL, 10416.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4796, 179, 2, 8, '2026-11-21', 2083.33, 2083.33, 0.00, NULL, NULL, 8333.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4797, 179, 2, 9, '2026-12-21', 2083.33, 2083.33, 0.00, NULL, NULL, 6250.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4798, 179, 2, 10, '2027-01-21', 2083.33, 2083.33, 0.00, NULL, NULL, 4166.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4799, 179, 2, 11, '2027-02-21', 2083.33, 2083.33, 0.00, NULL, NULL, 2083.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4800, 179, 2, 12, '2027-03-21', 2083.33, 2083.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:26:39', '2026-03-21 20:26:39', 193, NULL, NULL, NULL, NULL, NULL),
(4801, 180, 2, 1, '2026-04-21', 1583.33, 1583.33, 0.00, NULL, NULL, 17416.67, 'registered', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 21:39:40', 194, NULL, NULL, NULL, NULL, NULL),
(4802, 180, 2, 2, '2026-05-21', 1583.33, 1583.33, 0.00, NULL, NULL, 15833.33, 'registered', '2026-03-21 21:45:02', 1583.33, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, 'uploads/comprobantes/1774129502_4bd57dce0101b60a9c6c.jpeg', NULL, NULL),
(4803, 180, 2, 3, '2026-06-21', 1583.33, 1583.33, 0.00, NULL, NULL, 14250.00, 'registered', '2026-03-21 21:54:40', 1583.33, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, 'uploads/comprobantes/1774130080_5f26498141239e7ec290.jpeg', NULL, NULL),
(4804, 180, 2, 4, '2026-07-21', 1583.33, 1583.33, 0.00, NULL, NULL, 12666.67, 'registered', '2026-03-21 21:59:02', 1583.33, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, 'uploads/comprobantes/1774130342_d8014f76afd8638ab0c7.jpeg', NULL, NULL),
(4805, 180, 2, 5, '2026-08-21', 1583.33, 1583.33, 0.00, NULL, NULL, 11083.33, 'registered', '2026-03-21 22:04:31', 1583.33, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, 'uploads/comprobantes/1774130671_dca2c1eb4a2c121e9e5a.jpeg', NULL, NULL),
(4806, 180, 2, 6, '2026-09-21', 1583.33, 1583.33, 0.00, NULL, NULL, 9500.00, 'paid', '2026-03-21 22:12:55', 1583.33, 'uploads/comprobantes/1774130857_c6b93dfcb877696acaf9.jpg', '2026-03-21 20:32:33', '2026-03-21 22:12:55', 194, NULL, NULL, NULL, '', NULL),
(4807, 180, 2, 7, '2026-10-21', 1583.33, 1583.33, 0.00, NULL, NULL, 7916.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL),
(4808, 180, 2, 8, '2026-11-21', 1583.33, 1583.33, 0.00, NULL, NULL, 6333.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `payment_schedules` (`id`, `lot_id`, `payment_plan_id`, `installment_number`, `due_date`, `amount`, `capital`, `interest`, `interest_accrued`, `interest_accrued_date`, `balance`, `status`, `paid_date`, `paid_amount`, `voucher_url`, `created_at`, `updated_at`, `contract_id`, `pdf_url`, `xml_url`, `comprobante_url`, `validado_notas`, `validated_at`) VALUES
(4809, 180, 2, 9, '2026-12-21', 1583.33, 1583.33, 0.00, NULL, NULL, 4750.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL),
(4810, 180, 2, 10, '2027-01-21', 1583.33, 1583.33, 0.00, NULL, NULL, 3166.67, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL),
(4811, 180, 2, 11, '2027-02-21', 1583.33, 1583.33, 0.00, NULL, NULL, 1583.33, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL),
(4812, 180, 2, 12, '2027-03-21', 1583.33, 1583.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 20:32:33', '2026-03-21 20:32:33', 194, NULL, NULL, NULL, NULL, NULL),
(4813, 180, 2, 0, '2026-03-21', 5000.00, 5000.00, 0.00, NULL, NULL, 19000.00, 'registered', '2026-03-21 05:00:00', 5000.00, 'uploads/comprobantes/1774125153_6f31d52e7d188db0b72d.jpg', '2026-03-21 22:03:22', '2026-03-21 22:03:22', 194, NULL, NULL, NULL, NULL, NULL),
(4814, 180, 2, 0, '2026-03-21', 5000.00, 5000.00, 0.00, NULL, NULL, 19000.00, 'registered', '2026-03-21 22:15:11', 5000.00, 'uploads/comprobantes/1774131311_405f75ba15fa7b66dbfa.jpg', '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4815, 180, 2, 1, '2026-04-21', 1583.33, 1583.33, 0.00, NULL, NULL, 17416.67, 'paid', '2026-03-21 22:17:15', 1583.33, 'uploads/comprobantes/1774131404_40a3572b271893963822.jpeg', '2026-03-21 22:15:11', '2026-03-21 22:17:15', 195, NULL, NULL, NULL, '', NULL),
(4816, 180, 2, 2, '2026-05-21', 1583.33, 1583.33, 0.00, NULL, NULL, 15833.33, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4817, 180, 2, 3, '2026-06-21', 1583.33, 1583.33, 0.00, NULL, NULL, 14250.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4818, 180, 2, 4, '2026-07-21', 1583.33, 1583.33, 0.00, NULL, NULL, 12666.67, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4819, 180, 2, 5, '2026-08-21', 1583.33, 1583.33, 0.00, NULL, NULL, 11083.33, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4820, 180, 2, 6, '2026-09-21', 1583.33, 1583.33, 0.00, NULL, NULL, 9500.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4821, 180, 2, 7, '2026-10-21', 1583.33, 1583.33, 0.00, NULL, NULL, 7916.67, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4822, 180, 2, 8, '2026-11-21', 1583.33, 1583.33, 0.00, NULL, NULL, 6333.33, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4823, 180, 2, 9, '2026-12-21', 1583.33, 1583.33, 0.00, NULL, NULL, 4750.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4824, 180, 2, 10, '2027-01-21', 1583.33, 1583.33, 0.00, NULL, NULL, 3166.67, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4825, 180, 2, 11, '2027-02-21', 1583.33, 1583.33, 0.00, NULL, NULL, 1583.33, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4826, 180, 2, 12, '2027-03-21', 1583.33, 1583.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:15:11', '2026-03-21 22:15:11', 195, NULL, NULL, NULL, NULL, NULL),
(4827, 172, 9, 1, '2026-04-21', 439.53, 395.78, 43.75, NULL, NULL, 14604.22, 'paid', '2026-03-21 22:34:28', 439.53, 'uploads/comprobantes/1774132461_6a8bcb92741a59cd836a.jpeg', '2026-03-21 22:31:42', '2026-03-21 22:34:28', 196, NULL, NULL, NULL, '', NULL),
(4828, 172, 9, 2, '2026-05-21', 439.53, 396.94, 42.60, NULL, NULL, 14207.28, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4829, 172, 9, 3, '2026-06-21', 439.53, 398.09, 41.44, NULL, NULL, 13809.19, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4830, 172, 9, 4, '2026-07-21', 439.53, 399.25, 40.28, NULL, NULL, 13409.94, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4831, 172, 9, 5, '2026-08-21', 439.53, 400.42, 39.11, NULL, NULL, 13009.52, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4832, 172, 9, 6, '2026-09-21', 439.53, 401.59, 37.94, NULL, NULL, 12607.93, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4833, 172, 9, 7, '2026-10-21', 439.53, 402.76, 36.77, NULL, NULL, 12205.17, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4834, 172, 9, 8, '2026-11-21', 439.53, 403.93, 35.60, NULL, NULL, 11801.24, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4835, 172, 9, 9, '2026-12-21', 439.53, 405.11, 34.42, NULL, NULL, 11396.13, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4836, 172, 9, 10, '2027-01-21', 439.53, 406.29, 33.24, NULL, NULL, 10989.84, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4837, 172, 9, 11, '2027-02-21', 439.53, 407.48, 32.05, NULL, NULL, 10582.36, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4838, 172, 9, 12, '2027-03-21', 439.53, 408.67, 30.87, NULL, NULL, 10173.69, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4839, 172, 9, 13, '2027-04-21', 439.53, 409.86, 29.67, NULL, NULL, 9763.83, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4840, 172, 9, 14, '2027-05-21', 439.53, 411.05, 28.48, NULL, NULL, 9352.78, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4841, 172, 9, 15, '2027-06-21', 439.53, 412.25, 27.28, NULL, NULL, 8940.53, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4842, 172, 9, 16, '2027-07-21', 439.53, 413.45, 26.08, NULL, NULL, 8527.07, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4843, 172, 9, 17, '2027-08-21', 439.53, 414.66, 24.87, NULL, NULL, 8112.41, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4844, 172, 9, 18, '2027-09-21', 439.53, 415.87, 23.66, NULL, NULL, 7696.54, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4845, 172, 9, 19, '2027-10-21', 439.53, 417.08, 22.45, NULL, NULL, 7279.46, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4846, 172, 9, 20, '2027-11-21', 439.53, 418.30, 21.23, NULL, NULL, 6861.16, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4847, 172, 9, 21, '2027-12-21', 439.53, 419.52, 20.01, NULL, NULL, 6441.64, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4848, 172, 9, 22, '2028-01-21', 439.53, 420.74, 18.79, NULL, NULL, 6020.90, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4849, 172, 9, 23, '2028-02-21', 439.53, 421.97, 17.56, NULL, NULL, 5598.93, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4850, 172, 9, 24, '2028-03-21', 439.53, 423.20, 16.33, NULL, NULL, 5175.73, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4851, 172, 9, 25, '2028-04-21', 439.53, 424.44, 15.10, NULL, NULL, 4751.29, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4852, 172, 9, 26, '2028-05-21', 439.53, 425.67, 13.86, NULL, NULL, 4325.62, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4853, 172, 9, 27, '2028-06-21', 439.53, 426.91, 12.62, NULL, NULL, 3898.70, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4854, 172, 9, 28, '2028-07-21', 439.53, 428.16, 11.37, NULL, NULL, 3470.54, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4855, 172, 9, 29, '2028-08-21', 439.53, 429.41, 10.12, NULL, NULL, 3041.14, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4856, 172, 9, 30, '2028-09-21', 439.53, 430.66, 8.87, NULL, NULL, 2610.47, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4857, 172, 9, 31, '2028-10-21', 439.53, 431.92, 7.61, NULL, NULL, 2178.56, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4858, 172, 9, 32, '2028-11-21', 439.53, 433.18, 6.35, NULL, NULL, 1745.38, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4859, 172, 9, 33, '2028-12-21', 439.53, 434.44, 5.09, NULL, NULL, 1310.94, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4860, 172, 9, 34, '2029-01-21', 439.53, 435.71, 3.82, NULL, NULL, 875.23, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4861, 172, 9, 35, '2029-02-21', 439.53, 436.98, 2.55, NULL, NULL, 438.25, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4862, 172, 9, 36, '2029-03-21', 439.53, 438.25, 1.28, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:31:42', '2026-03-21 22:31:42', 196, NULL, NULL, NULL, NULL, NULL),
(4863, 172, 9, 0, '2026-03-21', 5000.00, 5000.00, 0.00, NULL, NULL, 15000.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:48:37', '2026-03-21 22:48:37', 196, NULL, NULL, NULL, NULL, NULL),
(4864, 166, 9, 0, '2026-03-21', 5000.00, 5000.00, 0.00, NULL, NULL, 15000.00, 'paid', '2026-03-21 22:56:11', 5000.00, 'uploads/comprobantes/1774133753_b385c8d4c1f5d40cb626.jpg', '2026-03-21 22:53:18', '2026-03-21 22:56:11', 197, NULL, NULL, NULL, '', NULL),
(4865, 166, 9, 1, '2026-04-21', 439.53, 395.78, 43.75, NULL, NULL, 14604.22, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4866, 166, 9, 2, '2026-05-21', 439.53, 396.94, 42.60, NULL, NULL, 14207.28, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4867, 166, 9, 3, '2026-06-21', 439.53, 398.09, 41.44, NULL, NULL, 13809.19, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4868, 166, 9, 4, '2026-07-21', 439.53, 399.25, 40.28, NULL, NULL, 13409.94, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4869, 166, 9, 5, '2026-08-21', 439.53, 400.42, 39.11, NULL, NULL, 13009.52, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4870, 166, 9, 6, '2026-09-21', 439.53, 401.59, 37.94, NULL, NULL, 12607.93, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4871, 166, 9, 7, '2026-10-21', 439.53, 402.76, 36.77, NULL, NULL, 12205.17, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4872, 166, 9, 8, '2026-11-21', 439.53, 403.93, 35.60, NULL, NULL, 11801.24, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4873, 166, 9, 9, '2026-12-21', 439.53, 405.11, 34.42, NULL, NULL, 11396.13, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4874, 166, 9, 10, '2027-01-21', 439.53, 406.29, 33.24, NULL, NULL, 10989.84, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4875, 166, 9, 11, '2027-02-21', 439.53, 407.48, 32.05, NULL, NULL, 10582.36, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4876, 166, 9, 12, '2027-03-21', 439.53, 408.67, 30.87, NULL, NULL, 10173.69, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4877, 166, 9, 13, '2027-04-21', 439.53, 409.86, 29.67, NULL, NULL, 9763.83, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4878, 166, 9, 14, '2027-05-21', 439.53, 411.05, 28.48, NULL, NULL, 9352.78, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4879, 166, 9, 15, '2027-06-21', 439.53, 412.25, 27.28, NULL, NULL, 8940.53, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4880, 166, 9, 16, '2027-07-21', 439.53, 413.45, 26.08, NULL, NULL, 8527.07, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4881, 166, 9, 17, '2027-08-21', 439.53, 414.66, 24.87, NULL, NULL, 8112.41, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4882, 166, 9, 18, '2027-09-21', 439.53, 415.87, 23.66, NULL, NULL, 7696.54, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4883, 166, 9, 19, '2027-10-21', 439.53, 417.08, 22.45, NULL, NULL, 7279.46, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4884, 166, 9, 20, '2027-11-21', 439.53, 418.30, 21.23, NULL, NULL, 6861.16, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4885, 166, 9, 21, '2027-12-21', 439.53, 419.52, 20.01, NULL, NULL, 6441.64, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4886, 166, 9, 22, '2028-01-21', 439.53, 420.74, 18.79, NULL, NULL, 6020.90, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4887, 166, 9, 23, '2028-02-21', 439.53, 421.97, 17.56, NULL, NULL, 5598.93, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4888, 166, 9, 24, '2028-03-21', 439.53, 423.20, 16.33, NULL, NULL, 5175.73, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4889, 166, 9, 25, '2028-04-21', 439.53, 424.44, 15.10, NULL, NULL, 4751.29, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4890, 166, 9, 26, '2028-05-21', 439.53, 425.67, 13.86, NULL, NULL, 4325.62, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4891, 166, 9, 27, '2028-06-21', 439.53, 426.91, 12.62, NULL, NULL, 3898.70, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4892, 166, 9, 28, '2028-07-21', 439.53, 428.16, 11.37, NULL, NULL, 3470.54, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4893, 166, 9, 29, '2028-08-21', 439.53, 429.41, 10.12, NULL, NULL, 3041.14, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4894, 166, 9, 30, '2028-09-21', 439.53, 430.66, 8.87, NULL, NULL, 2610.47, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4895, 166, 9, 31, '2028-10-21', 439.53, 431.92, 7.61, NULL, NULL, 2178.56, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4896, 166, 9, 32, '2028-11-21', 439.53, 433.18, 6.35, NULL, NULL, 1745.38, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4897, 166, 9, 33, '2028-12-21', 439.53, 434.44, 5.09, NULL, NULL, 1310.94, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4898, 166, 9, 34, '2029-01-21', 439.53, 435.71, 3.82, NULL, NULL, 875.23, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4899, 166, 9, 35, '2029-02-21', 439.53, 436.98, 2.55, NULL, NULL, 438.25, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4900, 166, 9, 36, '2029-03-21', 439.53, 438.25, 1.28, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-21 22:53:18', '2026-03-21 22:53:18', 197, NULL, NULL, NULL, NULL, NULL),
(4901, 167, 9, 0, '2026-03-23', 5000.00, 5000.00, 0.00, NULL, NULL, 15000.00, 'paid', '2026-03-24 19:17:15', 5000.00, 'uploads/comprobantes/1774379766_458026f35ebf2fa6ed6e.jpeg', '2026-03-24 04:18:30', '2026-03-24 19:17:15', 198, NULL, NULL, NULL, '', NULL),
(4902, 167, 9, 1, '2026-04-23', 439.53, 395.78, 43.75, NULL, NULL, 14604.22, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4903, 167, 9, 2, '2026-05-23', 439.53, 396.94, 42.60, NULL, NULL, 14207.28, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4904, 167, 9, 3, '2026-06-23', 439.53, 398.09, 41.44, NULL, NULL, 13809.19, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4905, 167, 9, 4, '2026-07-23', 439.53, 399.25, 40.28, NULL, NULL, 13409.94, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4906, 167, 9, 5, '2026-08-23', 439.53, 400.42, 39.11, NULL, NULL, 13009.52, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4907, 167, 9, 6, '2026-09-23', 439.53, 401.59, 37.94, NULL, NULL, 12607.93, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4908, 167, 9, 7, '2026-10-23', 439.53, 402.76, 36.77, NULL, NULL, 12205.17, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4909, 167, 9, 8, '2026-11-23', 439.53, 403.93, 35.60, NULL, NULL, 11801.24, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4910, 167, 9, 9, '2026-12-23', 439.53, 405.11, 34.42, NULL, NULL, 11396.13, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4911, 167, 9, 10, '2027-01-23', 439.53, 406.29, 33.24, NULL, NULL, 10989.84, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4912, 167, 9, 11, '2027-02-23', 439.53, 407.48, 32.05, NULL, NULL, 10582.36, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4913, 167, 9, 12, '2027-03-23', 439.53, 408.67, 30.87, NULL, NULL, 10173.69, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4914, 167, 9, 13, '2027-04-23', 439.53, 409.86, 29.67, NULL, NULL, 9763.83, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4915, 167, 9, 14, '2027-05-23', 439.53, 411.05, 28.48, NULL, NULL, 9352.78, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4916, 167, 9, 15, '2027-06-23', 439.53, 412.25, 27.28, NULL, NULL, 8940.53, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4917, 167, 9, 16, '2027-07-23', 439.53, 413.45, 26.08, NULL, NULL, 8527.07, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4918, 167, 9, 17, '2027-08-23', 439.53, 414.66, 24.87, NULL, NULL, 8112.41, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4919, 167, 9, 18, '2027-09-23', 439.53, 415.87, 23.66, NULL, NULL, 7696.54, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4920, 167, 9, 19, '2027-10-23', 439.53, 417.08, 22.45, NULL, NULL, 7279.46, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4921, 167, 9, 20, '2027-11-23', 439.53, 418.30, 21.23, NULL, NULL, 6861.16, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4922, 167, 9, 21, '2027-12-23', 439.53, 419.52, 20.01, NULL, NULL, 6441.64, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4923, 167, 9, 22, '2028-01-23', 439.53, 420.74, 18.79, NULL, NULL, 6020.90, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4924, 167, 9, 23, '2028-02-23', 439.53, 421.97, 17.56, NULL, NULL, 5598.93, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4925, 167, 9, 24, '2028-03-23', 439.53, 423.20, 16.33, NULL, NULL, 5175.73, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4926, 167, 9, 25, '2028-04-23', 439.53, 424.44, 15.10, NULL, NULL, 4751.29, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4927, 167, 9, 26, '2028-05-23', 439.53, 425.67, 13.86, NULL, NULL, 4325.62, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4928, 167, 9, 27, '2028-06-23', 439.53, 426.91, 12.62, NULL, NULL, 3898.70, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4929, 167, 9, 28, '2028-07-23', 439.53, 428.16, 11.37, NULL, NULL, 3470.54, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4930, 167, 9, 29, '2028-08-23', 439.53, 429.41, 10.12, NULL, NULL, 3041.14, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4931, 167, 9, 30, '2028-09-23', 439.53, 430.66, 8.87, NULL, NULL, 2610.47, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4932, 167, 9, 31, '2028-10-23', 439.53, 431.92, 7.61, NULL, NULL, 2178.56, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4933, 167, 9, 32, '2028-11-23', 439.53, 433.18, 6.35, NULL, NULL, 1745.38, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4934, 167, 9, 33, '2028-12-23', 439.53, 434.44, 5.09, NULL, NULL, 1310.94, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4935, 167, 9, 34, '2029-01-23', 439.53, 435.71, 3.82, NULL, NULL, 875.23, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4936, 167, 9, 35, '2029-02-23', 439.53, 436.98, 2.55, NULL, NULL, 438.25, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4937, 167, 9, 36, '2029-03-23', 439.53, 438.25, 1.28, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-24 04:18:30', '2026-03-24 04:18:30', 198, NULL, NULL, NULL, NULL, NULL),
(4938, 177, 2, 0, '2026-03-24', 5000.00, 5000.00, 0.00, NULL, NULL, 9400.00, 'registered', '2026-03-25 00:37:16', 5000.00, 'uploads/comprobantes/1774399036_fa0f9125409db5451916.jpeg', '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4939, 177, 2, 1, '2026-04-24', 783.33, 783.33, 0.00, NULL, NULL, 8616.67, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4940, 177, 2, 2, '2026-05-24', 783.33, 783.33, 0.00, NULL, NULL, 7833.33, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4941, 177, 2, 3, '2026-06-24', 783.33, 783.33, 0.00, NULL, NULL, 7050.00, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4942, 177, 2, 4, '2026-07-24', 783.33, 783.33, 0.00, NULL, NULL, 6266.67, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4943, 177, 2, 5, '2026-08-24', 783.33, 783.33, 0.00, NULL, NULL, 5483.33, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4944, 177, 2, 6, '2026-09-24', 783.33, 783.33, 0.00, NULL, NULL, 4700.00, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4945, 177, 2, 7, '2026-10-24', 783.33, 783.33, 0.00, NULL, NULL, 3916.67, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4946, 177, 2, 8, '2026-11-24', 783.33, 783.33, 0.00, NULL, NULL, 3133.33, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4947, 177, 2, 9, '2026-12-24', 783.33, 783.33, 0.00, NULL, NULL, 2350.00, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4948, 177, 2, 10, '2027-01-24', 783.33, 783.33, 0.00, NULL, NULL, 1566.67, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4949, 177, 2, 11, '2027-02-24', 783.33, 783.33, 0.00, NULL, NULL, 783.33, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4950, 177, 2, 12, '2027-03-24', 783.33, 783.33, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-03-25 00:37:16', '2026-03-25 00:37:16', 199, NULL, NULL, NULL, NULL, NULL),
(4951, 155, 2, 0, '2026-04-03', 5000.00, 5000.00, 0.00, NULL, NULL, 15000.00, 'paid', '2026-04-03 19:07:24', 5000.00, 'uploads/comprobantes/1775242680_b5a8f7c5798456e969d1.jpeg', '2026-04-03 18:58:00', '2026-04-03 19:07:24', 200, NULL, NULL, NULL, '', NULL),
(4952, 155, 2, 1, '2026-05-03', 1250.00, 1250.00, 0.00, NULL, NULL, 13750.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4953, 155, 2, 2, '2026-06-03', 1250.00, 1250.00, 0.00, NULL, NULL, 12500.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4954, 155, 2, 3, '2026-07-03', 1250.00, 1250.00, 0.00, NULL, NULL, 11250.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4955, 155, 2, 4, '2026-08-03', 1250.00, 1250.00, 0.00, NULL, NULL, 10000.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4956, 155, 2, 5, '2026-09-03', 1250.00, 1250.00, 0.00, NULL, NULL, 8750.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4957, 155, 2, 6, '2026-10-03', 1250.00, 1250.00, 0.00, NULL, NULL, 7500.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4958, 155, 2, 7, '2026-11-03', 1250.00, 1250.00, 0.00, NULL, NULL, 6250.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4959, 155, 2, 8, '2026-12-03', 1250.00, 1250.00, 0.00, NULL, NULL, 5000.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4960, 155, 2, 9, '2027-01-03', 1250.00, 1250.00, 0.00, NULL, NULL, 3750.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4961, 155, 2, 10, '2027-02-03', 1250.00, 1250.00, 0.00, NULL, NULL, 2500.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4962, 155, 2, 11, '2027-03-03', 1250.00, 1250.00, 0.00, NULL, NULL, 1250.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL),
(4963, 155, 2, 12, '2027-04-03', 1250.00, 1250.00, 0.00, NULL, NULL, 0.00, 'pending', NULL, NULL, NULL, '2026-04-03 18:58:00', '2026-04-03 18:58:00', 200, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE `pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `cci` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `date_pay` datetime DEFAULT NULL,
  `hash_id` text NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `amount_deductions` decimal(20,3) DEFAULT NULL,
  `factura` varchar(255) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `active` enum('0','1','2','3') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id`, `customer_id`, `bank`, `number`, `cci`, `date`, `date_pay`, `hash_id`, `amount`, `amount_deductions`, `factura`, `discount`, `total`, `active`, `created_at`, `updated_at`) VALUES
(1, 4, 'Banco de Crédito (BCP)', '19431470393074', ' 00219413147039307497', '2025-02-05 16:26:12', '2025-02-05 16:26:52', '', 151.80, NULL, NULL, 0.00, 151.80, '2', '2025-02-05 21:26:12', NULL),
(2, 2, 'Banco de Crédito (BCP)', '123', '123', '2025-02-17 15:39:04', '2025-02-17 16:08:06', '', 723.60, NULL, NULL, 0.00, 723.60, '2', '2025-02-17 20:39:04', NULL),
(3, 4, 'Banco de Crédito (BCP)', '19431470393074', ' 00219413147039307497', '2025-03-27 12:05:02', '2025-03-27 12:05:20', '', 644.40, NULL, NULL, 0.00, 644.40, '2', '2025-03-27 17:05:02', NULL),
(4, 3, 'Banco de Crédito (BCP)', '.', '.', '2025-04-11 15:49:00', '2025-04-11 15:49:36', '', 1735.00, NULL, NULL, 0.00, 1735.00, '2', '2025-04-11 20:49:00', NULL),
(6, 4, '', '', '', '2025-08-08 18:38:10', NULL, '', 990.78, NULL, NULL, 0.00, 990.78, '2', '2025-08-08 23:38:10', NULL),
(7, 16, '', '', '', '2025-08-08 21:07:56', NULL, '', 1555.65, NULL, NULL, 0.00, 1555.65, '2', '2025-08-09 02:07:56', NULL),
(8, 9, '', '', '', '2025-08-16 12:54:50', NULL, '', 1008.50, NULL, NULL, 0.00, 1008.50, '2', '2025-08-16 17:54:50', NULL),
(9, 43, '', '', '', '2025-08-30 16:53:03', NULL, '', 1614.65, NULL, NULL, 0.00, 1614.65, '2', '2025-08-30 21:53:03', NULL),
(10, 28, 'BBVA', '20962031006', '00907920011003443651', '2025-12-04 13:57:30', NULL, '', 2800.00, NULL, NULL, 280.00, 2520.00, '1', '2025-12-04 18:57:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pay_commissions`
--

CREATE TABLE `pay_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pay_id` bigint(20) UNSIGNED NOT NULL,
  `commissions_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_commissions`
--

INSERT INTO `pay_commissions` (`id`, `pay_id`, `commissions_id`, `date`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 93, '2025-02-05', '1', '2025-02-05 21:26:12', NULL),
(2, 2, 97, '2025-02-17', '1', '2025-02-17 20:39:04', NULL),
(3, 3, 173, '2025-03-27', '1', '2025-03-27 17:05:02', NULL),
(4, 4, 246, '2025-04-11', '1', '2025-04-11 20:49:00', NULL),
(6, 6, 877, '2025-08-08', '1', '2025-08-08 23:38:10', NULL),
(7, 7, 878, '2025-08-08', '1', '2025-08-09 02:07:56', NULL),
(8, 8, 899, '2025-08-16', '1', '2025-08-16 17:54:50', NULL),
(9, 9, 922, '2025-08-30', '1', '2025-08-30 21:53:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `payment_schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('mora','suspension','negociacion') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `code`, `begin`, `end`, `created_at`) VALUES
(3, '2408', '2024-08-01', '2024-08-31', '2024-08-10 14:51:06'),
(4, '2409', '2024-09-01', '2024-09-30', '2024-10-15 05:45:41'),
(5, '2410', '2024-10-01', '2024-10-31', '2024-10-15 05:45:57'),
(6, '2011', '2024-11-01', '2024-11-30', '2024-11-06 19:54:23'),
(7, '2412', '2024-12-01', '2024-12-31', '2024-12-06 13:50:11'),
(8, '2501', '2025-01-01', '2025-01-31', '2025-01-06 12:16:32'),
(9, '2502', '2025-02-01', '2025-02-28', '2025-02-01 16:09:19'),
(10, '2503', '2025-03-01', '2025-03-31', '2025-03-01 01:00:01'),
(11, '2504', '2025-04-01', '2025-04-30', '2025-04-01 01:00:02'),
(12, '2505', '2025-05-01', '2025-05-31', '2025-05-01 00:00:01'),
(13, '2506', '2025-06-01', '2025-06-30', '2025-06-01 00:00:01'),
(14, '2507', '2025-07-01', '2025-07-31', '2025-07-01 00:00:02'),
(15, '2508', '2025-08-01', '2025-08-31', '2025-08-01 00:00:01'),
(16, '2509', '2025-09-01', '2025-09-30', '2025-09-01 00:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `departure_id` bigint(20) DEFAULT NULL,
  `points` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `system` enum('0','1') DEFAULT NULL,
  `range` enum('0','1') DEFAULT NULL,
  `active` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_settings`
--

CREATE TABLE `price_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `monthly_increase_percentage` decimal(5,2) NOT NULL DEFAULT 2.00,
  `market_factor` decimal(5,2) NOT NULL DEFAULT 1.00,
  `last_update_date` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_settings`
--

INSERT INTO `price_settings` (`id`, `project_id`, `location`, `monthly_increase_percentage`, `market_factor`, `last_update_date`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'General', 2.00, 1.00, NULL, 1, '2025-10-02 23:20:10', NULL),
(2, NULL, 'Cusco', 2.00, 1.10, NULL, 1, '2025-10-02 23:20:10', NULL),
(3, NULL, 'Lima', 2.00, 1.15, NULL, 1, '2025-10-02 23:20:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `total_lots` int(11) NOT NULL DEFAULT 0,
  `available_lots` int(11) NOT NULL DEFAULT 0,
  `base_price_per_sqm` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_down_payment_percentage` decimal(5,2) NOT NULL DEFAULT 15.00,
  `max_financing_months` int(11) NOT NULL DEFAULT 36,
  `base_interest_rate` decimal(5,2) NOT NULL DEFAULT 3.50,
  `status` enum('planning','active','sold_out','suspended') NOT NULL DEFAULT 'planning',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `down_payment_type` varchar(20) DEFAULT 'percentage',
  `min_down_payment_fixed` decimal(10,2) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `code`, `location`, `description`, `image`, `total_lots`, `available_lots`, `base_price_per_sqm`, `min_down_payment_percentage`, `max_financing_months`, `base_interest_rate`, `status`, `created_at`, `updated_at`, `down_payment_type`, `min_down_payment_fixed`, `department_id`, `province_id`, `district_id`) VALUES
(49, 'Proyecto Vivencia Cusco', 'PROY-C54A', NULL, 'Proyecto vivencia en cusco', 'assets/project_images/project_692b12e3c97fe.jpg', 17, 16, 200.00, 15.00, 36, 2.00, 'active', '2025-11-29 15:36:03', NULL, 'fixed', 1000.00, 15, 128, 1299),
(51, 'Proyecto Maldonado 2', 'PROY-DC06', NULL, 'Prueba', 'assets/project_images/project_6931d077cbdb5.jpeg', 2, 1, 120.00, 15.00, 24, 0.00, 'active', '2025-12-04 18:18:31', '2026-03-21 19:51:56', 'fixed', 5000.00, 8, 68, 697),
(52, 'Proyecto Maldonado', 'PROY-52CE', NULL, '', 'assets/project_images/project_69bef5760a444.jpg', 1, 1, 10000.00, 15.00, 36, 3.50, 'active', '2026-03-21 19:45:58', '2026-03-21 19:50:34', 'fixed', 50000.00, 1, 2, 22),
(53, 'serpiente', 'SERP-60D6', NULL, '', 'assets/project_images/project_69befada7132d.png', 2, 1, 200.00, 15.00, 36, 2.50, 'active', '2026-03-21 20:08:58', NULL, 'fixed', 50000.00, 7, 67, 690);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `department_id`) VALUES
(1, 'CHACHAPOYAS ', 1),
(2, 'BAGUA', 1),
(3, 'BONGARA', 1),
(4, 'CONDORCANQUI', 1),
(5, 'LUYA', 1),
(6, 'RODRIGUEZ DE MENDOZA', 1),
(7, 'UTCUBAMBA', 1),
(8, 'HUARAZ', 2),
(9, 'AIJA', 2),
(10, 'ANTONIO RAYMONDI', 2),
(11, 'ASUNCION', 2),
(12, 'BOLOGNESI', 2),
(13, 'CARHUAZ', 2),
(14, 'CARLOS FERMIN FITZCARRALD', 2),
(15, 'CASMA', 2),
(16, 'CORONGO', 2),
(17, 'HUARI', 2),
(18, 'HUARMEY', 2),
(19, 'HUAYLAS', 2),
(20, 'MARISCAL LUZURIAGA', 2),
(21, 'OCROS', 2),
(22, 'PALLASCA', 2),
(23, 'POMABAMBA', 2),
(24, 'RECUAY', 2),
(25, 'SANTA', 2),
(26, 'SIHUAS', 2),
(27, 'YUNGAY', 2),
(28, 'ABANCAY', 3),
(29, 'ANDAHUAYLAS', 3),
(30, 'ANTABAMBA', 3),
(31, 'AYMARAES', 3),
(32, 'COTABAMBAS', 3),
(33, 'CHINCHEROS', 3),
(34, 'GRAU', 3),
(35, 'AREQUIPA', 4),
(36, 'CAMANA', 4),
(37, 'CARAVELI', 4),
(38, 'CASTILLA', 4),
(39, 'CAYLLOMA', 4),
(40, 'CONDESUYOS', 4),
(41, 'ISLAY', 4),
(42, 'LA UNION', 4),
(43, 'HUAMANGA', 5),
(44, 'CANGALLO', 5),
(45, 'HUANCA SANCOS', 5),
(46, 'HUANTA', 5),
(47, 'LA MAR', 5),
(48, 'LUCANAS', 5),
(49, 'PARINACOCHAS', 5),
(50, 'PAUCAR DEL SARA SARA', 5),
(51, 'SUCRE', 5),
(52, 'VICTOR FAJARDO', 5),
(53, 'VILCAS HUAMAN', 5),
(54, 'CAJAMARCA', 6),
(55, 'CAJABAMBA', 6),
(56, 'CELENDIN', 6),
(57, 'CHOTA ', 6),
(58, 'CONTUMAZA', 6),
(59, 'CUTERVO', 6),
(60, 'HUALGAYOC', 6),
(61, 'JAEN', 6),
(62, 'SAN IGNACIO', 6),
(63, 'SAN MARCOS', 6),
(64, 'SAN MIGUEL', 6),
(65, 'SAN PABLO', 6),
(66, 'SANTA CRUZ', 6),
(67, 'CALLAO', 7),
(68, 'CUSCO', 8),
(69, 'ACOMAYO', 8),
(70, 'ANTA', 8),
(71, 'CALCA', 8),
(72, 'CANAS', 8),
(73, 'CANCHIS', 8),
(74, 'CHUMBIVILCAS', 8),
(75, 'ESPINAR', 8),
(76, 'LA CONVENCION', 8),
(77, 'PARURO', 8),
(78, 'PAUCARTAMBO', 8),
(79, 'QUISPICANCHI', 8),
(80, 'URUBAMBA', 8),
(81, 'HUANCAVELICA', 9),
(82, 'ACOBAMBA', 9),
(83, 'ANGARAES', 9),
(84, 'CASTROVIRREYNA', 9),
(85, 'CHURCAMPA', 9),
(86, 'HUAYTARA', 9),
(87, 'TAYACAJA', 9),
(88, 'HUANUCO', 10),
(89, 'AMBO', 10),
(90, 'DOS DE MAYO', 10),
(91, 'HUACAYBAMBA', 10),
(92, 'HUAMALIES', 10),
(93, 'LEONCIO PRADO', 10),
(94, 'MARA&Ntilde;ON', 10),
(95, 'PACHITEA', 10),
(96, 'PUERTO INCA', 10),
(97, 'LAURICOCHA', 10),
(98, 'YAROWILCA', 10),
(99, 'ICA', 11),
(100, 'CHINCHA', 11),
(101, 'NAZCA', 11),
(102, 'PALPA', 11),
(103, 'PISCO', 11),
(104, 'HUANCAYO', 12),
(105, 'CONCEPCION', 12),
(106, 'CHANCHAMAYO', 12),
(107, 'JAUJA', 12),
(108, 'JUNIN', 12),
(109, 'SATIPO', 12),
(110, 'TARMA', 12),
(111, 'YAULI', 12),
(112, 'CHUPACA', 12),
(113, 'TRUJILLO', 13),
(114, 'ASCOPE', 13),
(115, 'BOLIVAR', 13),
(116, 'CHEPEN', 13),
(117, 'JULCAN', 13),
(118, 'OTUZCO', 13),
(119, 'PACASMAYO', 13),
(120, 'PATAZ', 13),
(121, 'SANCHEZ CARRION', 13),
(122, 'SANTIAGO DE CHUCO', 13),
(123, 'GRAN CHIMU', 13),
(124, 'VIRU', 13),
(125, 'CHICLAYO', 14),
(126, 'FERRE&Ntilde;AFE', 14),
(127, 'LAMBAYEQUE', 14),
(128, 'LIMA', 15),
(129, 'BARRANCA', 15),
(130, 'CAJATAMBO', 15),
(131, 'CANTA', 15),
(132, 'CA&Ntilde;ETE', 15),
(133, 'HUARAL', 15),
(134, 'HUAROCHIRI', 15),
(135, 'HUAURA', 15),
(136, 'OYON', 15),
(137, 'YAUYOS', 15),
(138, 'MAYNAS', 16),
(139, 'ALTO AMAZONAS', 16),
(140, 'LORETO', 16),
(141, 'MARISCAL RAMON CASTILLA', 16),
(142, 'REQUENA', 16),
(143, 'UCAYALI', 16),
(144, 'DATEM DE MARAÑON', 16),
(145, 'PUTUMAYO', 16),
(146, 'TAMBOPATA', 17),
(147, 'MANU', 17),
(148, 'TAHUAMANU', 17),
(149, 'MARISCAL NIETO', 18),
(150, 'GENERAL SANCHEZ CERRO', 18),
(151, 'ILO', 18),
(152, 'PASCO', 19),
(153, 'DANIEL ALCIDES CARRION', 19),
(154, 'OXAPAMPA', 19),
(155, 'PIURA', 20),
(156, 'AYABACA', 20),
(157, 'HUANCABAMBA', 20),
(158, 'MORROPON', 20),
(159, 'PAITA', 20),
(160, 'SULLANA', 20),
(161, 'TALARA', 20),
(162, 'SECHURA', 20),
(163, 'PUNO', 21),
(164, 'AZANGARO', 21),
(165, 'CARABAYA', 21),
(166, 'CHUCUITO', 21),
(167, 'EL COLLAO', 21),
(168, 'HUANCANE', 21),
(169, 'LAMPA', 21),
(170, 'MELGAR', 21),
(171, 'MOHO', 21),
(172, 'SAN ANTONIO DE PUTINA', 21),
(173, 'SAN ROMAN', 21),
(174, 'SANDIA', 21),
(175, 'YUNGUYO', 21),
(176, 'MOYOBAMBA', 22),
(177, 'BELLAVISTA', 22),
(178, 'EL DORADO', 22),
(179, 'HUALLAGA', 22),
(180, 'LAMAS', 22),
(181, 'MARISCAL CACERES', 22),
(182, 'PICOTA', 22),
(183, 'RIOJA', 22),
(184, 'SAN MARTIN', 22),
(185, 'TOCACHE', 22),
(186, 'TACNA', 23),
(187, 'CANDARAVE', 23),
(188, 'JORGE BASADRE', 23),
(189, 'TARATA', 23),
(190, 'TUMBES', 24),
(191, 'CONTRALMIRANTE VILLAR', 24),
(192, 'ZARUMILLA', 24),
(193, 'CORONEL PORTILLO', 25),
(194, 'ATALAYA', 25),
(195, 'PADRE ABAD', 25),
(196, 'PURUS', 25);

-- --------------------------------------------------------

--
-- Table structure for table `ranges`
--

CREATE TABLE `ranges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `points` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ranges`
--

INSERT INTO `ranges` (`id`, `name`, `points`, `description`, `img`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Distribuidor', 0, '', '', '0', '2023-08-02 01:59:49', '2023-08-02 02:01:15'),
(2, 'Bronce', 3000, '+ 3 líneas activas\r\n+ 600 puntos personales.\r\n+ 3,000 puntos grupales', '1719785870_f797efc088dd61631f1a.png', '1', '2023-08-02 01:59:49', '2023-08-02 02:01:15'),
(3, 'Plata', 7000, '+ 4 líneas activas\r\n+ 800 puntos personales\r\n+ 7,000 puntos grupales', '1719785883_743e5e439022526cff27.png', '1', '2023-08-02 02:00:22', '2023-08-02 02:01:15'),
(4, 'Oro', 12000, '+ 5 líneas activas\r\n+ 1,200 puntos personales\r\n+ 12,000 puntos grupales', '1719786331_dac061d42689832fe0a8.png', '1', '2023-08-02 02:00:22', '2023-08-02 02:01:15'),
(5, 'Esmeralda', 35000, '+ 6 líneas activas\r\n+ 1,500 puntos personales\r\n+ 35,000 puntos grupales\r\n+ 1 Bronce, 2 Platas y 1 Oro en tu equipo\r\n', '1719786485_863de666945c94f9471f.png', '1', '2023-08-02 02:00:22', '2023-08-02 02:01:15'),
(6, 'Zafiro', 50000, '+ 7 líneas activas\r\n+ 2,000 puntos personales\r\n+ 50,000 puntos grupales\r\n+ 1 Plata, 2 Orosy 1 Esmeralda en tu equipo', '1719786601_9c77101f0c162a8114dd.png', '1', '2023-08-02 02:00:22', '2023-08-02 02:01:15'),
(7, 'Rubí', 80000, '+ 8 líneas activas\r\n+ 2,000 puntos personales\r\n+ 80,000 puntos grupales\r\n+ 1 Oro, 2 Esmeraldas y 1 Zafiro en tu equipo', '1719789506_2d7de60e0c59790ee42c.png', '1', '2023-08-02 02:01:22', '2023-08-02 02:01:45'),
(8, 'Diamante', 200000, '+ 9 líneas activas\r\n+ 2,000 puntos personales\r\n+ 200,000 puntos grupales\r\n+ 1 Esmeralda, 2 Zafiros y 1 Rubí en tu equipo', '1719789734_853afaea877e334dc7ee.png', '1', '2023-08-02 02:01:22', '2023-08-02 02:01:45'),
(9, 'Doble Diamante', 500000, '+ 10 líneas activas\r\n+ 2,000 puntos personales\r\n+ 500,000 puntos grupales\r\n+ 1 Zafiro, 2 Rubíes y 1 Diamante en tu equipo', '1719789745_9e5eaf3743512cf6c50c.png', '1', '2023-08-02 02:01:48', '2023-08-02 02:02:07'),
(10, 'Triple Diamante', 1200000, '+ 10 líneas activas\r\n+ 2,000 puntos personales\r\n+ 1,200,000 puntos grupales\r\n+ 1 Rubí, 2 Diamantes y 1 Diamante Doble en tu equipo', '1719789830_e86cd1de33ea6da3385a.png', '1', NULL, '2023-08-02 02:02:07'),
(11, 'Diamante Embajador', 3000000, '+ 10 líneas activas\r\n+ 2,500 puntos personales\r\n+ 3,000,000 puntos grupales\r\n+ 1 Diamante, 2 Doble Diamantes y 1 Triple Diamante en tu equipo', '1719790209_78c1515d3a972128da1a.png', '1', '2023-08-02 02:02:10', '2023-08-02 02:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `range_customer`
--

CREATE TABLE `range_customer` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `range_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `period_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `range_customer`
--

INSERT INTO `range_customer` (`id`, `customer_id`, `range_id`, `points`, `date`, `period_id`) VALUES
(1, 3, 2, 3000, '2025-03-31 20:01:51', 10),
(2, 91, 2, 3300, '2025-05-05 00:00:00', NULL),
(3, 92, 2, 3800, '2025-05-05 00:00:00', NULL),
(4, 91, 2, NULL, '2025-06-01 00:00:01', 12);

-- --------------------------------------------------------

--
-- Table structure for table `recibos_honorarios`
--

CREATE TABLE `recibos_honorarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `beneficiario` varchar(255) NOT NULL,
  `dni_ruc` varchar(20) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `concepto` text NOT NULL,
  `numero_recibo` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(20) DEFAULT 'generado',
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requerimientos`
--

CREATE TABLE `requerimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_requerimiento` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `documento_requerido` varchar(255) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` varchar(20) DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_completado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Almacén general - Punto de entrega Ate Vitarte - Lima ', '1', '2023-08-18 10:34:34', '2025-07-20 12:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `concept_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `ruc` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `ruc`, `phone`, `address`, `date`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Yeray Amal SAC.', '20609188180', '962 792 954', 'C. Central Km 85. Cuadra C Int. 21 Lima - Peru', '2023-09-27', '1', '2023-09-27 14:58:16', '2024-08-03 11:42:39'),
(2, 'Yeray Amal SAC', '20609188180', '962792954', 'jr. Ucayali nro. 100 - Yarinacocha - coronel portillo - Ucayali', '2025-05-08', '1', '2025-05-08 12:09:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `concept_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `response` text NOT NULL,
  `date` datetime NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  `active` enum('0','1','2','3') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_leave_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_arrive_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `unit_cost` decimal(20,2) DEFAULT 0.00,
  `total_costo` decimal(20,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unilevels`
--

CREATE TABLE `unilevels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `node` text NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unilevels`
--

INSERT INTO `unilevels` (`id`, `customer_id`, `sponsor_id`, `node`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '', '1', '2024-03-22 21:23:14', NULL),
(52, 2, 1, ',1', '1', '2024-10-28 19:42:47', NULL),
(53, 3, 2, ',1,2', '1', '2024-10-28 21:35:02', NULL),
(54, 4, 3, ',1,2,3', '1', '2024-10-28 21:40:23', NULL),
(55, 5, 3, ',1,2,3', '1', '2024-10-28 21:41:15', NULL),
(56, 6, 3, ',1,2,3', '1', '2024-10-28 21:42:41', NULL),
(58, 8, 3, ',1,2,3', '1', '2024-10-28 21:44:59', NULL),
(59, 9, 3, ',1,2,3', '1', '2024-10-28 21:45:43', NULL),
(60, 10, 4, ',1,2,3,4', '1', '2024-10-28 21:47:28', NULL),
(61, 11, 6, ',1,2,3,6', '1', '2024-10-28 21:50:15', NULL),
(62, 12, 9, ',1,2,3,9', '1', '2024-10-28 21:51:23', NULL),
(64, 14, 4, ',1,2,3,4', '1', '2024-11-21 02:07:48', NULL),
(65, 15, 2, ',1,2', '1', '2024-12-02 19:12:12', NULL),
(66, 16, 2, ',1,2', '1', '2024-12-04 00:12:09', NULL),
(67, 17, 16, ',1,2,16', '1', '2024-12-08 02:37:52', NULL),
(68, 18, 15, ',1,2,15', '1', '2024-12-10 21:22:29', NULL),
(69, 19, 15, ',1,2,15', '1', '2024-12-13 23:10:32', NULL),
(70, 20, 4, ',1,2,3,4', '1', '2024-12-14 16:56:37', NULL),
(71, 21, 4, ',1,2,3,4', '1', '2024-12-14 16:59:28', NULL),
(74, 24, 16, ',1,2,16', '1', '2025-01-01 16:58:57', NULL),
(75, 25, 16, ',1,2,16', '1', '2025-01-02 01:19:59', NULL),
(78, 28, 2, ',1,2', '1', '2025-01-06 17:23:15', NULL),
(79, 29, 2, ',1,2', '1', '2025-01-08 00:54:38', NULL),
(80, 30, 27, ',1,27', '1', '2025-01-14 18:35:47', NULL),
(81, 31, 16, ',1,2,16', '1', '2025-01-16 00:24:12', NULL),
(82, 32, 16, ',1,2,16', '1', '2025-01-17 20:25:30', NULL),
(83, 33, 2, ',1,2', '1', '2025-01-21 21:46:01', NULL),
(84, 34, 16, ',1,2,16', '1', '2025-01-22 18:15:00', NULL),
(85, 35, 16, ',1,2,16', '1', '2025-01-23 13:29:40', NULL),
(86, 36, 2, ',1,2', '1', '2025-01-26 23:32:17', NULL),
(87, 37, 2, ',1,2', '1', '2025-01-27 16:28:16', NULL),
(88, 38, 16, ',1,2,16', '1', '2025-01-30 14:31:59', NULL),
(89, 39, 5, ',1,2,3,5', '1', '2025-02-06 00:59:06', NULL),
(90, 40, 4, ',1,2,3,4', '1', '2025-02-06 19:24:54', NULL),
(91, 41, 4, ',1,2,3,4', '1', '2025-02-11 16:11:43', NULL),
(92, 42, 41, ',1,2,3,4,41', '1', '2025-02-12 20:10:44', NULL),
(93, 43, 3, ',1,2,3', '1', '2025-02-12 20:41:11', NULL),
(94, 44, 29, ',1,2,29', '1', '2025-02-17 22:32:43', NULL),
(95, 45, 16, ',1,2,16', '1', '2025-02-19 16:54:09', NULL),
(96, 46, 45, ',1,2,16,45', '1', '2025-02-19 17:12:47', NULL),
(97, 47, 3, ',1,2,3', '1', '2025-02-27 14:57:14', NULL),
(98, 48, 5, ',1,2,3,5', '1', '2025-02-27 19:03:45', NULL),
(99, 49, 4, ',1,2,3,4', '1', '2025-03-02 04:09:37', NULL),
(100, 50, 4, ',1,2,3,4', '1', '2025-03-02 04:16:41', NULL),
(101, 51, 16, ',1,2,16', '1', '2025-03-03 20:33:21', NULL),
(102, 52, 51, ',1,2,16,51', '1', '2025-03-05 02:18:50', NULL),
(103, 53, 2, ',1,2', '1', '2025-03-13 19:47:29', NULL),
(104, 54, 29, ',1,2,29', '1', '2025-03-16 20:11:48', NULL),
(105, 55, 5, ',1,2,3,5', '1', '2025-03-16 22:52:42', NULL),
(107, 57, 3, ',1,2,3', '1', '2025-03-25 20:38:10', NULL),
(108, 58, 16, ',1,2,16', '1', '2025-03-28 21:51:38', NULL),
(109, 59, 16, ',1,2,16', '1', '2025-03-29 17:02:25', NULL),
(110, 60, 29, ',1,2,29', '1', '2025-03-30 20:01:58', NULL),
(111, 61, 16, ',1,2,16', '1', '2025-04-01 14:00:52', NULL),
(112, 62, 43, ',1,2,3,43', '1', '2025-04-01 22:45:57', NULL),
(113, 63, 3, ',1,2,3', '1', '2025-04-05 21:56:57', NULL),
(114, 64, 2, ',1,2', '1', '2025-04-06 03:40:19', NULL),
(115, 65, 4, ',1,2,3,4', '1', '2025-04-06 18:20:45', NULL),
(126, 76, 5, ',1,2,3,5', '1', '2025-04-08 17:16:34', NULL),
(127, 77, 43, ',1,2,3,43', '1', '2025-04-15 21:57:52', NULL),
(128, 78, 16, ',1,2,16', '1', '2025-04-16 17:45:45', NULL),
(129, 79, 3, ',1,2,3', '1', '2025-04-16 18:33:48', NULL),
(130, 80, 28, ',1,2,28', '1', '2025-04-17 17:06:18', NULL),
(131, 81, 51, ',1,2,16,51', '1', '2025-04-23 02:57:00', NULL),
(134, 84, 28, ',1,2,28', '1', '2025-04-23 22:49:41', NULL),
(137, 87, 28, ',1,2,28', '1', '2025-04-23 23:11:28', NULL),
(139, 89, 77, ',1,2,3,43,77', '1', '2025-04-26 16:30:05', NULL),
(140, 90, 16, ',1,2,16', '1', '2025-05-05 01:14:34', NULL),
(141, 91, 1, ',1', '1', '2025-05-05 21:29:16', NULL),
(176, 126, 2, ',1,2', '1', '2025-08-06 16:21:16', NULL),
(177, 127, 43, ',1,2,3,43', '1', '2025-08-07 18:12:21', NULL),
(181, 202, 1, ',1', '1', '2025-10-28 17:20:04', NULL),
(182, 203, 28, ',1,2,28', '1', '2025-11-21 12:25:46', NULL),
(183, 204, 87, ',1,2,28,87', '1', '2025-11-22 20:53:11', NULL),
(184, 205, 204, ',1,2,28,87,204', '1', '2025-11-24 16:44:24', NULL),
(185, 206, 28, ',1,2,28', '1', '2025-11-24 17:15:34', NULL),
(186, 207, 28, ',1,2,28', '1', '2025-11-25 15:23:16', NULL),
(187, 208, 28, ',1,2,28', '1', '2025-11-26 17:19:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `privilegio` varchar(50) DEFAULT 'admin',
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `type` varchar(4) NOT NULL DEFAULT 'user',
  `privilage` enum('1','2','3','4') DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `privilegio`, `lastname`, `phone`, `dni`, `avatar`, `type`, `privilage`, `active`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rolando', 'admin', 'Contreras Huidobro', '927318326', '45887343', NULL, 'user', '3', '1', 'software.contreras@gmail.com', '$2y$10$vA8lr5/ivt2OhYoO1pHP5uLxdmVyYzm6QV0fA7ZV1JChoQzQmKjky', '2023-08-01 21:18:50', NULL, NULL),
(6, 'Alejandro', 'admin', 'Huamani', NULL, NULL, NULL, 'user', '3', '1', 'alejandro7billones.ah@gmail.com', '$2y$10$s6ZTgRxxp4mb5d0W/Xtg4u8gincesYOxlg6wAF4yIx.bWzPGW3G6u', '2024-07-10 13:30:44', NULL, NULL),
(10, 'Norma', 'admin', 'Manrique', NULL, NULL, NULL, 'user', '3', '1', 'norma.perumundo@gmail.com', '$2y$10$P/zK9yeiC0AMwOBWiw00QOr/9TTVvwlpNDKfuc4AAIgcDI0w1w4di', '2025-05-23 18:17:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `numero_comprobante` varchar(50) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `fecha_venta` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `igv` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'registrado',
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ventas_inmuebles`
--

CREATE TABLE `ventas_inmuebles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lote_id` bigint(20) UNSIGNED NOT NULL,
  `agente_id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `estado` enum('pendiente','aprobada','pagada','anulada') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivos_digitales`
--
ALTER TABLE `archivos_digitales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrato_id` (`contrato_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `tipo_documento` (`tipo_documento`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bonuses`
--
ALTER TABLE `bonuses`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `bonuses_name_unique` (`name`) USING BTREE;

--
-- Indexes for table `calification`
--
ALTER TABLE `calification`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`) USING BTREE,
  ADD KEY `range_id` (`range_id`) USING BTREE;

--
-- Indexes for table `clasificaciones_compra`
--
ALTER TABLE `clasificaciones_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `comisiones`
--
ALTER TABLE `comisiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indexes for table `comisiones_inmobiliarias`
--
ALTER TABLE `comisiones_inmobiliarias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `commissions_customer_id_foreign` (`customer_id`) USING BTREE,
  ADD KEY `commissions_bonus_id_foreign` (`bonus_id`) USING BTREE,
  ADD KEY `invoice_id` (`invoice_id`) USING BTREE;

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fecha_compra` (`fecha_compra`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `idx_proyecto` (`proyecto_id`),
  ADD KEY `idx_contrato` (`contrato_id`);

--
-- Indexes for table `compra_documentos`
--
ALTER TABLE `compra_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tipo_doc` (`tipo_documento`),
  ADD KEY `idx_compra_doc` (`compra_id`);

--
-- Indexes for table `compra_gastos`
--
ALTER TABLE `compra_gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_compra` (`compra_id`),
  ADD KEY `idx_tipo` (`gasto_tipo_id`),
  ADD KEY `idx_subcategoria` (`gasto_subcategoria_id`),
  ADD KEY `idx_proyecto` (`proyecto_id`),
  ADD KEY `idx_contrato` (`contrato_id`);

--
-- Indexes for table `concept_tickets`
--
ALTER TABLE `concept_tickets`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `conciliaciones_bancarias`
--
ALTER TABLE `conciliaciones_bancarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conciliaciones_bancarias_cuenta_bancaria_id_foreign` (`cuenta_bancaria_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contract_number` (`contract_number`),
  ADD KEY `lot_id` (`lot_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `payment_plan_id` (`payment_plan_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_contract_date` (`contract_date`),
  ADD KEY `idx_is_approved` (`is_approved`),
  ADD KEY `idx_is_rejected` (`is_rejected`);

--
-- Indexes for table `costos_proyecto`
--
ALTER TABLE `costos_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyecto_id` (`proyecto_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`,`id_idioma`);

--
-- Indexes for table `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `customers_username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `customers_email_unique` (`email`) USING BTREE,
  ADD KEY `customers_range_id_foreign` (`range_id`) USING BTREE,
  ADD KEY `customers_countries_id_foreign` (`country_id`) USING BTREE,
  ADD KEY `membership_id` (`membership_id`) USING BTREE;

--
-- Indexes for table `customer_bank`
--
ALTER TABLE `customer_bank`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`) USING BTREE,
  ADD KEY `bank_id` (`bank_id`) USING BTREE;

--
-- Indexes for table `declaraciones_tributarias`
--
ALTER TABLE `declaraciones_tributarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periodo` (`periodo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_documento` (`tipo_documento`),
  ADD KEY `estado` (`estado`);

--
-- Indexes for table `gasto_reportes`
--
ALTER TABLE `gasto_reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_fecha` (`fecha_inicio`,`fecha_fin`),
  ADD KEY `idx_tipo_gasto` (`tipo_gasto_id`);

--
-- Indexes for table `gasto_subcategorias`
--
ALTER TABLE `gasto_subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gasto_tipo_id` (`gasto_tipo_id`);

--
-- Indexes for table `gasto_tipos`
--
ALTER TABLE `gasto_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming`
--
ALTER TABLE `incoming`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `membership_id` (`membership_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_detail_membership`
--
ALTER TABLE `invoice_detail_membership`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `invoice_id` (`invoice_id`) USING BTREE,
  ADD KEY `membership_id` (`membership_id`) USING BTREE;

--
-- Indexes for table `kycs`
--
ALTER TABLE `kycs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kycs_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lot_project` (`project_id`,`lot_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_customer` (`customer_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientos_bancarios`
--
ALTER TABLE `movimientos_bancarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_bancarios_cuenta_bancaria_id_foreign` (`cuenta_bancaria_id`);

--
-- Indexes for table `outgoing`
--
ALTER TABLE `outgoing`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `membership_id` (`membership_id`) USING BTREE,
  ADD KEY `store_id` (`store_id`) USING BTREE,
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `pagos_proveedores`
--
ALTER TABLE `pagos_proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `fecha_pago` (`fecha_pago`);

--
-- Indexes for table `payment_options`
--
ALTER TABLE `payment_options`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_location` (`location`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `payment_schedules`
--
ALTER TABLE `payment_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lot_id` (`lot_id`),
  ADD KEY `payment_plan_id` (`payment_plan_id`),
  ADD KEY `idx_due_date` (`due_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pays_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `pay_commissions`
--
ALTER TABLE `pay_commissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pay_commissions_pay_id_foreign` (`pay_id`) USING BTREE,
  ADD KEY `pay_commissions_customer_id_foreign` (`commissions_id`) USING BTREE;

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_id` (`contract_id`),
  ADD KEY `payment_schedule_id` (`payment_schedule_id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`) USING BTREE,
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `price_settings`
--
ALTER TABLE `price_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `idx_location` (`location`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_location` (`location`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruc` (`ruc`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ranges`
--
ALTER TABLE `ranges`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `ranges_name_unique` (`name`) USING BTREE;

--
-- Indexes for table `range_customer`
--
ALTER TABLE `range_customer`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`) USING BTREE,
  ADD KEY `range_id` (`range_id`) USING BTREE;

--
-- Indexes for table `recibos_honorarios`
--
ALTER TABLE `recibos_honorarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_ruc` (`dni_ruc`);

--
-- Indexes for table `requerimientos`
--
ALTER TABLE `requerimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `contrato_id` (`contrato_id`),
  ADD KEY `estado` (`estado`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `suggestions_concept_ticket_id_foreign` (`concept_ticket_id`) USING BTREE,
  ADD KEY `suggestions_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `tickets_concept_ticket_id_foreign` (`concept_ticket_id`) USING BTREE,
  ADD KEY `tickets_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `entre_id` (`store_leave_id`) USING BTREE,
  ADD KEY `membership_id` (`store_arrive_id`) USING BTREE;

--
-- Indexes for table `unilevels`
--
ALTER TABLE `unilevels`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `unilevels_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`) USING BTREE;

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fecha_venta` (`fecha_venta`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indexes for table `ventas_inmuebles`
--
ALTER TABLE `ventas_inmuebles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archivos_digitales`
--
ALTER TABLE `archivos_digitales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bonuses`
--
ALTER TABLE `bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `calification`
--
ALTER TABLE `calification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clasificaciones_compra`
--
ALTER TABLE `clasificaciones_compra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comisiones`
--
ALTER TABLE `comisiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comisiones_inmobiliarias`
--
ALTER TABLE `comisiones_inmobiliarias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=993;

--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compra_documentos`
--
ALTER TABLE `compra_documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compra_gastos`
--
ALTER TABLE `compra_gastos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `concept_tickets`
--
ALTER TABLE `concept_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conciliaciones_bancarias`
--
ALTER TABLE `conciliaciones_bancarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `costos_proyecto`
--
ALTER TABLE `costos_proyecto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_bank`
--
ALTER TABLE `customer_bank`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `declaraciones_tributarias`
--
ALTER TABLE `declaraciones_tributarias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1875;

--
-- AUTO_INCREMENT for table `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gasto_reportes`
--
ALTER TABLE `gasto_reportes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gasto_subcategorias`
--
ALTER TABLE `gasto_subcategorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `gasto_tipos`
--
ALTER TABLE `gasto_tipos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incoming`
--
ALTER TABLE `incoming`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_detail_membership`
--
ALTER TABLE `invoice_detail_membership`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=676;

--
-- AUTO_INCREMENT for table `kycs`
--
ALTER TABLE `kycs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `movimientos_bancarios`
--
ALTER TABLE `movimientos_bancarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outgoing`
--
ALTER TABLE `outgoing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=635;

--
-- AUTO_INCREMENT for table `pagos_proveedores`
--
ALTER TABLE `pagos_proveedores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_options`
--
ALTER TABLE `payment_options`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_plans`
--
ALTER TABLE `payment_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_schedules`
--
ALTER TABLE `payment_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4964;

--
-- AUTO_INCREMENT for table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pay_commissions`
--
ALTER TABLE `pay_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1040;

--
-- AUTO_INCREMENT for table `price_settings`
--
ALTER TABLE `price_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `ranges`
--
ALTER TABLE `ranges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `range_customer`
--
ALTER TABLE `range_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recibos_honorarios`
--
ALTER TABLE `recibos_honorarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requerimientos`
--
ALTER TABLE `requerimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unilevels`
--
ALTER TABLE `unilevels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ventas_inmuebles`
--
ALTER TABLE `ventas_inmuebles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivos_digitales`
--
ALTER TABLE `archivos_digitales`
  ADD CONSTRAINT `archivos_digitales_ibfk_1` FOREIGN KEY (`contrato_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `archivos_digitales_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comisiones`
--
ALTER TABLE `comisiones`
  ADD CONSTRAINT `comisiones_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

--
-- Constraints for table `compra_documentos`
--
ALTER TABLE `compra_documentos`
  ADD CONSTRAINT `compra_documentos_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compra_gastos`
--
ALTER TABLE `compra_gastos`
  ADD CONSTRAINT `fk_cg_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cg_subcategoria` FOREIGN KEY (`gasto_subcategoria_id`) REFERENCES `gasto_subcategorias` (`id`),
  ADD CONSTRAINT `fk_cg_tipo` FOREIGN KEY (`gasto_tipo_id`) REFERENCES `gasto_tipos` (`id`);

--
-- Constraints for table `conciliaciones_bancarias`
--
ALTER TABLE `conciliaciones_bancarias`
  ADD CONSTRAINT `conciliaciones_bancarias_cuenta_bancaria_id_foreign` FOREIGN KEY (`cuenta_bancaria_id`) REFERENCES `cuentas_bancarias` (`id`);

--
-- Constraints for table `gasto_reportes`
--
ALTER TABLE `gasto_reportes`
  ADD CONSTRAINT `fk_gr_tipo` FOREIGN KEY (`tipo_gasto_id`) REFERENCES `gasto_tipos` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gasto_subcategorias`
--
ALTER TABLE `gasto_subcategorias`
  ADD CONSTRAINT `gasto_subcategorias_ibfk_1` FOREIGN KEY (`gasto_tipo_id`) REFERENCES `gasto_tipos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movimientos_bancarios`
--
ALTER TABLE `movimientos_bancarios`
  ADD CONSTRAINT `movimientos_bancarios_cuenta_bancaria_id_foreign` FOREIGN KEY (`cuenta_bancaria_id`) REFERENCES `cuentas_bancarias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
