-- ============================================
-- SISTEMA DE CLASIFICACIÓN DE GASTOS - FINAL
-- ============================================
-- Fecha: Abril 8, 2026
-- Descripción: Script con todos los cambios de base de datos
-- para el módulo de Clasificación de Gastos

SET FOREIGN_KEY_CHECKS=0;

-- 1. TABLA: TIPOS DE GASTO
CREATE TABLE IF NOT EXISTS `gasto_tipos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `icono` VARCHAR(50) NULL,
  `descripcion` TEXT NULL,
  `color` VARCHAR(20) DEFAULT '#007bff',
  `activo` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos por defecto
INSERT IGNORE INTO `gasto_tipos` (`id`, `nombre`, `icono`, `descripcion`, `color`) VALUES
(4, 'Costo de Proyectos', 'fa-hammer', 'Gastos de construcción y proyectos', '#28a745');

-- 2. TABLA: SUBCATEGORÍAS DE GASTO
CREATE TABLE IF NOT EXISTS `gasto_subcategorias` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gasto_tipo_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL,
  `activo` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tipo` (`gasto_tipo_id`),
  CONSTRAINT `fk_gs_tipo` FOREIGN KEY (`gasto_tipo_id`) REFERENCES `gasto_tipos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar subcategorías
INSERT IGNORE INTO `gasto_subcategorias` (`gasto_tipo_id`, `nombre`, `descripcion`) VALUES
(4, 'Mano de Obra', 'Jornales, salarios de construcción'),
(4, 'Maquinaria y Equipo', 'Alquiler y compra de equipos'),
(4, 'Materia Prima', 'Materiales principales de construcción'),
(4, 'Materiales Auxiliares', 'Arena, cemento, acero, otros'),
(4, 'Suministros', 'Cables, tuberías, accesorios');

-- 3. TABLA: CLASIFICACIÓN DE COMPRAS-GASTOS
CREATE TABLE IF NOT EXISTS `compra_gastos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `compra_id` BIGINT UNSIGNED NOT NULL,
  `gasto_tipo_id` BIGINT UNSIGNED NOT NULL,
  `gasto_subcategoria_id` BIGINT UNSIGNED NOT NULL,
  `proyecto_id` BIGINT UNSIGNED NULL,
  `contrato_id` BIGINT UNSIGNED NULL,
  `observaciones` TEXT NULL,
  `clasificado_por` BIGINT UNSIGNED NULL,
  `fecha_clasificacion` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_compra` (`compra_id`),
  KEY `idx_tipo` (`gasto_tipo_id`),
  KEY `idx_subcategoria` (`gasto_subcategoria_id`),
  KEY `idx_proyecto` (`proyecto_id`),
  KEY `idx_contrato` (`contrato_id`),
  CONSTRAINT `fk_cg_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cg_tipo` FOREIGN KEY (`gasto_tipo_id`) REFERENCES `gasto_tipos`(`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_cg_subcategoria` FOREIGN KEY (`gasto_subcategoria_id`) REFERENCES `gasto_subcategorias`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. TABLA: DOCUMENTOS ADJUNTOS A COMPRAS
CREATE TABLE IF NOT EXISTS `compra_documentos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `compra_id` BIGINT UNSIGNED NOT NULL,
  `tipo_documento` VARCHAR(50) NOT NULL,
  `nombre_original` VARCHAR(255) NOT NULL,
  `ruta_archivo` VARCHAR(512) NOT NULL,
  `tipo_mime` VARCHAR(100) NULL,
  `tamanio` BIGINT NULL,
  `hash_archivo` VARCHAR(64) NULL,
  `cargado_por` BIGINT UNSIGNED NULL,
  `fecha_carga` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `descripcion` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tipo_doc` (`tipo_documento`),
  KEY `idx_compra_doc` (`compra_id`),
  CONSTRAINT `fk_cd_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. TABLA: REPORTES DE GASTOS
CREATE TABLE IF NOT EXISTS `gasto_reportes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `proyecto_id` BIGINT UNSIGNED NULL,
  `contrato_id` BIGINT UNSIGNED NULL,
  `tipo_gasto_id` BIGINT UNSIGNED NULL,
  `contenido_html` LONGTEXT NULL,
  `contenido_pdf` VARCHAR(512) NULL,
  `total_gasto` DECIMAL(15,2) DEFAULT 0,
  `cantidad_compras` INT DEFAULT 0,
  `estado` VARCHAR(20) DEFAULT 'borrador',
  `usuario_creador` BIGINT UNSIGNED NOT NULL,
  `usuario_contable` BIGINT UNSIGNED NULL,
  `fecha_envio` TIMESTAMP NULL,
  `observaciones` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha` (`fecha_inicio`, `fecha_fin`),
  KEY `idx_tipo_gasto` (`tipo_gasto_id`),
  CONSTRAINT `fk_gr_tipo` FOREIGN KEY (`tipo_gasto_id`) REFERENCES `gasto_tipos`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. ACTUALIZAR TABLA COMPRAS (agregar campos si faltan)
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `proyecto_id` BIGINT UNSIGNED NULL COMMENT 'Proyecto asociado' AFTER `xml_url`;
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `contrato_id` BIGINT UNSIGNED NULL COMMENT 'Contrato asociado' AFTER `proyecto_id`;

-- Agregar índices a compras
ALTER TABLE `compras` ADD INDEX IF NOT EXISTS `idx_proyecto` (`proyecto_id`);
ALTER TABLE `compras` ADD INDEX IF NOT EXISTS `idx_contrato` (`contrato_id`);

SET FOREIGN_KEY_CHECKS=1;

-- ============================================
-- RESUMEN DE CAMBIOS
-- ============================================
-- Tablas creadas: 5
--   1. gasto_tipos (1 registro: Costo de Proyectos)
--   2. gasto_subcategorias (5 registros: Mano de Obra, Maquinaria, Materia Prima, Materiales Auxiliares, Suministros)
--   3. compra_gastos (clasificación de compras)
--   4. compra_documentos (documentos adjuntos)
--   5. gasto_reportes (reportes de gastos)
--
-- Campos agregados a compras: 2
--   - proyecto_id
--   - contrato_id
--
-- Total relaciones: 5 Foreign Keys configuradas
-- ============================================
