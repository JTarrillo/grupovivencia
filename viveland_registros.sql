-- Tabla para registros de VIVELAND
CREATE TABLE IF NOT EXISTS `viveland_registros` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `zona` enum('Zona Viveland','Zona VIP','Zona Platinum','Zona General') NOT NULL,
  `interes` varchar(100),
  `estado` enum('pendiente','confirmado','cancelado') DEFAULT 'pendiente',
  `fecha_registro` timestamp DEFAULT CURRENT_TIMESTAMP,
  `fecha_confirmacion` datetime,
  INDEX `idx_email` (`email`),
  INDEX `idx_estado` (`estado`),
  INDEX `idx_zona` (`zona`),
  INDEX `idx_fecha` (`fecha_registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
