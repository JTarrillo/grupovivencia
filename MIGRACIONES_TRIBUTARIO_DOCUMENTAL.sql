-- MIGRACIONES PARA MÓDULO TRIBUTARIO
-- Ejecutar estas consultas SQL en phpMyAdmin o MySQL

-- ========================================
-- 1. Tabla: COMPRAS
-- ========================================
CREATE TABLE IF NOT EXISTS `compras` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `proveedor_id` BIGINT UNSIGNED NOT NULL,
  `numero_comprobante` VARCHAR(50) NOT NULL,
  `tipo_comprobante` VARCHAR(20) NOT NULL,
  `fecha_compra` DATE NOT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL,
  `igv` DECIMAL(12,2) NOT NULL,
  `total` DECIMAL(12,2) NOT NULL,
  `descripcion` TEXT NULL,
  `clasificacion` VARCHAR(50) NULL,
  `estado` VARCHAR(20) DEFAULT 'registrado',
  `pdf_url` VARCHAR(255) NULL,
  `xml_url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  KEY `fecha_compra` (`fecha_compra`),
  KEY `proveedor_id` (`proveedor_id`),
  FOREIGN KEY (`proveedor_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 2. Tabla: VENTAS
-- ========================================
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `numero_comprobante` VARCHAR(50) NOT NULL,
  `tipo_comprobante` VARCHAR(20) NOT NULL,
  `fecha_venta` DATE NOT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL,
  `igv` DECIMAL(12,2) NOT NULL,
  `total` DECIMAL(12,2) NOT NULL,
  `descripcion` TEXT NULL,
  `estado` VARCHAR(20) DEFAULT 'registrado',
  `pdf_url` VARCHAR(255) NULL,
  `xml_url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  KEY `fecha_venta` (`fecha_venta`),
  KEY `cliente_id` (`cliente_id`),
  FOREIGN KEY (`cliente_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 3. Tabla: DECLARACIONES_TRIBUTARIAS
-- ========================================
CREATE TABLE IF NOT EXISTS `declaraciones_tributarias` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `periodo` VARCHAR(10) NOT NULL UNIQUE,
  `total_ventas` DECIMAL(14,2) DEFAULT 0,
  `total_compras` DECIMAL(14,2) DEFAULT 0,
  `igv_a_pagar` DECIMAL(14,2) DEFAULT 0,
  `estado` VARCHAR(20) DEFAULT 'borrador',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` BIGINT UNSIGNED NULL,
  `observaciones` TEXT NULL,
  KEY `periodo` (`periodo`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 4. Tabla: COSTOS_PROYECTO
-- ========================================
CREATE TABLE IF NOT EXISTS `costos_proyecto` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `proyecto_id` BIGINT UNSIGNED NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  `monto` DECIMAL(12,2) NOT NULL,
  `tipo_costo` VARCHAR(50) NULL,
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `compra_id` BIGINT UNSIGNED NULL,
  KEY `proyecto_id` (`proyecto_id`),
  FOREIGN KEY (`proyecto_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 5. Tabla: CLASIFICACIONES_COMPRA
-- ========================================
CREATE TABLE IF NOT EXISTS `clasificaciones_compra` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL UNIQUE,
  `descripcion` TEXT NULL,
  `codigo` VARCHAR(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar clasificaciones de ejemplo
INSERT IGNORE INTO `clasificaciones_compra` (`nombre`, `descripcion`, `codigo`) VALUES
('Materiales', 'Compra de materiales de construcción', 'MAT'),
('Servicios', 'Servicios profesionales y técnicos', 'SRV'),
('Activos', 'Compra de activos fijos', 'ACT'),
('Suministros', 'Suministros y consumibles', 'SUM'),
('Otros', 'Otras compras', 'OTR');

-- ========================================
-- 6. Tabla: ARCHIVOS_DIGITALES
-- ========================================
CREATE TABLE IF NOT EXISTS `archivos_digitales` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_original` VARCHAR(255) NOT NULL,
  `nombre_almacenado` VARCHAR(255) NOT NULL,
  `tipo_documento` VARCHAR(50) NOT NULL,
  `tamaño` BIGINT UNSIGNED NOT NULL,
  `ruta_archivo` VARCHAR(500) NOT NULL,
  `contrato_id` BIGINT UNSIGNED NULL,
  `cliente_id` BIGINT UNSIGNED NULL,
  `descripcion` TEXT NULL,
  `fecha_subida` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` BIGINT UNSIGNED NULL,
  `estado` VARCHAR(20) DEFAULT 'activo',
  `hash_archivo` VARCHAR(64) NULL,
  KEY `contrato_id` (`contrato_id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `tipo_documento` (`tipo_documento`),
  FOREIGN KEY (`contrato_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cliente_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 7. Tabla: REQUERIMIENTOS
-- ========================================
CREATE TABLE IF NOT EXISTS `requerimientos` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `cliente_id` BIGINT UNSIGNED NOT NULL,
  `contrato_id` BIGINT UNSIGNED NULL,
  `tipo_requerimiento` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `documento_requerido` VARCHAR(255) NOT NULL,
  `fecha_vencimiento` DATE NOT NULL,
  `estado` VARCHAR(20) DEFAULT 'pendiente',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` BIGINT UNSIGNED NULL,
  `observaciones` TEXT NULL,
  `fecha_completado` DATETIME NULL,
  KEY `cliente_id` (`cliente_id`),
  KEY `contrato_id` (`contrato_id`),
  KEY `estado` (`estado`),
  FOREIGN KEY (`cliente_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`contrato_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 8. Tabla: DOCUMENTOS
-- ========================================
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `tipo_documento` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL,
  `contenido` LONGTEXT NOT NULL,
  `version` INT DEFAULT 1,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `usuario_creador_id` BIGINT UNSIGNED NULL,
  `última_modificación` DATETIME NULL,
  `usuario_modificacion_id` BIGINT UNSIGNED NULL,
  `estado` VARCHAR(20) DEFAULT 'activo',
  KEY `tipo_documento` (`tipo_documento`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 9. Tabla: PROVEEDORES (nueva, integrada)
-- ========================================
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `razon_social` VARCHAR(255) NOT NULL,
  `ruc` VARCHAR(20) NOT NULL UNIQUE,
  `contacto` VARCHAR(255) NULL,
  `telefono` VARCHAR(20) NULL,
  `email` VARCHAR(100) NULL,
  `direccion` VARCHAR(500) NULL,
  `tipo_proveedor` VARCHAR(50) NULL,
  `estado` VARCHAR(20) DEFAULT 'activo',
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` BIGINT UNSIGNED NULL,
  UNIQUE KEY `ruc` (`ruc`),
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 10. Tabla: PAGOS_PROVEEDORES
-- ========================================
CREATE TABLE IF NOT EXISTS `pagos_proveedores` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `proveedor_id` BIGINT UNSIGNED NOT NULL,
  `monto` DECIMAL(12,2) NOT NULL,
  `fecha_pago` DATE NOT NULL,
  `metodo_pago` VARCHAR(50) NOT NULL,
  `referencia` VARCHAR(100) NULL,
  `descripcion` TEXT NULL,
  `estado` VARCHAR(20) DEFAULT 'registrado',
  `voucher_url` VARCHAR(255) NULL,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `proveedor_id` (`proveedor_id`),
  KEY `fecha_pago` (`fecha_pago`),
  FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 11. Tabla: RECIBOS_HONORARIOS
-- ========================================
CREATE TABLE IF NOT EXISTS `recibos_honorarios` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `beneficiario` VARCHAR(255) NOT NULL,
  `dni_ruc` VARCHAR(20) NOT NULL,
  `monto` DECIMAL(12,2) NOT NULL,
  `concepto` TEXT NOT NULL,
  `numero_recibo` VARCHAR(50) NOT NULL UNIQUE,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `estado` VARCHAR(20) DEFAULT 'generado',
  `pdf_url` VARCHAR(255) NULL,
  `xml_url` VARCHAR(255) NULL,
  KEY `numero_recibo` (`numero_recibo`),
  KEY `dni_ruc` (`dni_ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- 12. Tabla: COMISIONES (nueva)
-- ========================================
CREATE TABLE IF NOT EXISTS `comisiones` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `contrato_id` BIGINT UNSIGNED NOT NULL,
  `agente_id` BIGINT UNSIGNED NULL,
  `porcentaje` DECIMAL(5,2) NOT NULL,
  `monto_total` DECIMAL(12,2) NOT NULL,
  `monto_comision` DECIMAL(12,2) NOT NULL,
  `estado` VARCHAR(20) DEFAULT 'pendiente',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `fecha_pago` DATETIME NULL,
  KEY `contrato_id` (`contrato_id`),
  FOREIGN KEY (`contrato_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- FIN DE MIGRACIONES
-- ========================================
