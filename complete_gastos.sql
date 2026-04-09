-- Completar instalación: solo los pasos finales
SET FOREIGN_KEY_CHECKS=0;

-- Verificar e insertar datos por defecto si faltan
INSERT IGNORE INTO `gasto_tipos` (`id`, `nombre`, `icono`, `descripcion`, `color`) VALUES
(1, 'Gastos Administrativos', 'fa-building', 'Gastos relacionados con administración', '#6c757d'),
(2, 'Gastos de Ventas', 'fa-cart-shopping', 'Gastos relacionados con ventas', '#fd7e14'),
(3, 'Gastos Financieros', 'fa-money-bill-wave', 'Intereses, comisiones bancarias', '#ffc107'),
(4, 'Costo de Proyectos', 'fa-hammer', 'Gastos de construcción y proyectos', '#28a745');

INSERT IGNORE INTO `gasto_subcategorias` (`gasto_tipo_id`, `nombre`, `descripcion`) VALUES
(4, 'Mano de Obra', 'Jornales, salarios de construcción'),
(4, 'Maquinaria y Equipo', 'Alquiler y compra de equipos'),
(4, 'Materia Prima', 'Materiales principales de construcción'),
(4, 'Materiales Auxiliares', 'Arena, cemento, acero, otros'),
(4, 'Suministros', 'Cables, tuberías, accesorios'),
(1, 'Servicios', 'Luz, agua, internet, teléfono'),
(1, 'Arriendo y Mantenimiento', 'Alquiler de oficina y mantenimiento'),
(1, 'Útiles y Papelería', 'Útiles de oficina'),
(2, 'Publicidad y Marketing', 'Anuncios, volantes, redes sociales'),
(2, 'Comisiones de Ventas', 'Comisiones a agentes'),
(3, 'Intereses Bancarios', 'Intereses de préstamos'),
(3, 'Comisiones Bancarias', 'Comisiones de transferencias y mantenimiento');

-- Actualizar tabla compras con campos faltantes
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `proyecto_id` BIGINT UNSIGNED NULL COMMENT 'Proyecto asociado';
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `contrato_id` BIGINT UNSIGNED NULL COMMENT 'Contrato asociado';

-- Habilitar verificación de FK
SET FOREIGN_KEY_CHECKS=1;

-- ✅ Instalación completada
