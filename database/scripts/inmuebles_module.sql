-- Módulo de Inmuebles para Grupo Vivencia
-- Compatible con la base de datos alelifeglobal existente

-- Tabla de proyectos inmobiliarios
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL UNIQUE,
  `location` varchar(255) NOT NULL,
  `description` text,
  `total_lots` int(11) NOT NULL DEFAULT 0,
  `available_lots` int(11) NOT NULL DEFAULT 0,
  `base_price_per_sqm` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_down_payment_percentage` decimal(5,2) NOT NULL DEFAULT 15.00,
  `max_financing_months` int(11) NOT NULL DEFAULT 36,
  `base_interest_rate` decimal(5,2) NOT NULL DEFAULT 3.50,
  `status` enum('planning','active','sold_out','suspended') NOT NULL DEFAULT 'planning',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_location` (`location`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de lotes/terrenos
CREATE TABLE IF NOT EXISTS `lots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NULL,
  `lot_number` varchar(50) NOT NULL,
  `block` varchar(20) DEFAULT NULL,
  `area_sqm` decimal(8,2) NOT NULL,
  `base_price` decimal(12,2) NOT NULL,
  `current_price` decimal(12,2) NOT NULL,
  `status` enum('available','reserved','sold','blocked') NOT NULL DEFAULT 'available',
  `reserved_until` timestamp NULL DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT NULL,
  `price_last_updated` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_lots_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lots_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  UNIQUE KEY `unique_lot_project` (`project_id`, `lot_number`),
  KEY `idx_status` (`status`),
  KEY `idx_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de planes de pago
CREATE TABLE IF NOT EXISTS `payment_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL UNIQUE,
  `location` varchar(100) NOT NULL COMMENT 'Cusco, Lima o General',
  `duration_months` int(11) NOT NULL,
  `min_down_payment_percentage` decimal(5,2) NOT NULL,
  `base_interest_rate` decimal(5,2) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_location` (`location`),
  KEY `idx_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de cronogramas de pago
CREATE TABLE IF NOT EXISTS `payment_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lot_id` bigint(20) unsigned NOT NULL,
  `payment_plan_id` bigint(20) unsigned NOT NULL,
  `installment_number` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `capital` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `balance` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','overdue','cancelled') NOT NULL DEFAULT 'pending',
  `paid_date` timestamp NULL DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_payment_schedules_lot` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payment_schedules_plan` FOREIGN KEY (`payment_plan_id`) REFERENCES `payment_plans` (`id`) ON DELETE CASCADE,
  KEY `idx_due_date` (`due_date`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de contratos
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lot_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `payment_plan_id` bigint(20) unsigned NOT NULL,
  `contract_number` varchar(100) NOT NULL UNIQUE,
  `total_amount` decimal(12,2) NOT NULL,
  `down_payment` decimal(10,2) NOT NULL,
  `financed_amount` decimal(12,2) NOT NULL,
  `monthly_payment` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `contract_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','completed','cancelled','suspended') NOT NULL DEFAULT 'active',
  `contract_file` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_contracts_lot` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_contracts_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_contracts_payment_plan` FOREIGN KEY (`payment_plan_id`) REFERENCES `payment_plans` (`id`) ON DELETE CASCADE,
  KEY `idx_status` (`status`),
  KEY `idx_contract_date` (`contract_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de configuración de precios dinámicos
CREATE TABLE IF NOT EXISTS `price_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NULL,
  `location` varchar(100) NOT NULL,
  `monthly_increase_percentage` decimal(5,2) NOT NULL DEFAULT 2.00,
  `market_factor` decimal(5,2) NOT NULL DEFAULT 1.00,
  `last_update_date` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_price_settings_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  KEY `idx_location` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar campos faltantes a la tabla customers existente
ALTER TABLE `customers` 
ADD COLUMN IF NOT EXISTS `mother_last` varchar(100) AFTER `lastname`,
ADD COLUMN IF NOT EXISTS `company_name` varchar(255) AFTER `ruc`,
ADD COLUMN IF NOT EXISTS `account_deductions` decimal(10,2) DEFAULT 0.00 AFTER `company_name`,
ADD COLUMN IF NOT EXISTS `address_company` text AFTER `account_deductions`;

-- Datos iniciales para planes de pago
INSERT IGNORE INTO `payment_plans` (`name`, `code`, `location`, `duration_months`, `min_down_payment_percentage`, `base_interest_rate`, `is_default`) VALUES
('Plan Estándar 36 meses', 'STD36', 'General', 36, 15.00, 3.50, 1),
('Plan Cusco 24 meses', 'CSC24', 'Cusco', 24, 20.00, 3.00, 1),
('Plan Lima 30 meses', 'LIM30', 'Lima', 30, 15.00, 3.25, 1),
('Plan Personalizado 48 meses', 'PER48', 'General', 48, 10.00, 4.00, 0),
('Plan Rápido 12 meses', 'RAP12', 'General', 12, 30.00, 2.50, 0);

-- Datos iniciales para configuración de precios
INSERT IGNORE INTO `price_settings` (`location`, `monthly_increase_percentage`, `market_factor`) VALUES
('General', 2.00, 1.00),
('Cusco', 2.50, 1.10),
('Lima', 3.00, 1.15),
('Arequipa', 2.00, 1.05);

-- Proyectos de ejemplo
INSERT IGNORE INTO `projects` (`name`, `code`, `location`, `description`, `total_lots`, `available_lots`, `base_price_per_sqm`, `min_down_payment_percentage`, `max_financing_months`, `base_interest_rate`, `status`) VALUES
('Proyecto Villa Sol', 'VS001', 'Lima', 'Proyecto residencial con lotes de 150-300 m² en zona exclusiva de Lima', 50, 48, 800.00, 15.00, 36, 3.50, 'active'),
('Residencial Cusco Imperial', 'RCI002', 'Cusco', 'Lotes urbanos en el corazón histórico del Cusco', 30, 28, 650.00, 20.00, 24, 3.00, 'active'),
('Valle Verde Arequipa', 'VVA003', 'Arequipa', 'Lotes con vista panorámica en Arequipa', 40, 40, 500.00, 15.00, 36, 3.25, 'planning');

-- Lotes de ejemplo para Proyecto Villa Sol
INSERT IGNORE INTO `lots` (`project_id`, `lot_number`, `block`, `area_sqm`, `base_price`, `current_price`, `status`) VALUES
(1, 'L001', 'A', 200.00, 160000.00, 160000.00, 'available'),
(1, 'L002', 'A', 180.00, 144000.00, 144000.00, 'available'),
(1, 'L003', 'A', 250.00, 200000.00, 200000.00, 'available'),
(1, 'L004', 'A', 220.00, 176000.00, 176000.00, 'available'),
(1, 'L005', 'A', 300.00, 240000.00, 240000.00, 'available'),
(1, 'L006', 'B', 190.00, 152000.00, 152000.00, 'available'),
(1, 'L007', 'B', 210.00, 168000.00, 168000.00, 'available'),
(1, 'L008', 'B', 280.00, 224000.00, 224000.00, 'available');

-- Lotes de ejemplo para Residencial Cusco Imperial
INSERT IGNORE INTO `lots` (`project_id`, `lot_number`, `block`, `area_sqm`, `base_price`, `current_price`, `status`) VALUES
(2, 'C001', 'Imperial', 150.00, 97500.00, 97500.00, 'available'),
(2, 'C002', 'Imperial', 160.00, 104000.00, 104000.00, 'available'),
(2, 'C003', 'Imperial', 180.00, 117000.00, 117000.00, 'available'),
(2, 'C004', 'Inca', 200.00, 130000.00, 130000.00, 'available'),
(2, 'C005', 'Inca', 170.00, 110500.00, 110500.00, 'available');

-- Crear índices adicionales para mejor rendimiento
CREATE INDEX IF NOT EXISTS `idx_lots_project_status` ON `lots` (`project_id`, `status`);
CREATE INDEX IF NOT EXISTS `idx_payment_schedules_lot_status` ON `payment_schedules` (`lot_id`, `status`);
CREATE INDEX IF NOT EXISTS `idx_contracts_customer_status` ON `contracts` (`customer_id`, `status`);

-- Crear vistas útiles
CREATE OR REPLACE VIEW `view_available_lots` AS
SELECT 
    l.id,
    l.lot_number,
    l.block,
    l.area_sqm,
    l.current_price,
    l.status,
    p.name as project_name,
    p.location,
    p.code as project_code,
    ROUND(l.current_price / l.area_sqm, 2) as price_per_sqm
FROM lots l
JOIN projects p ON l.project_id = p.id
WHERE l.status = 'available' AND p.status = 'active';

CREATE OR REPLACE VIEW `view_customer_properties` AS
SELECT 
    c.id as customer_id,
    c.name as customer_name,
    c.lastname as customer_lastname,
    c.email,
    c.phone,
    l.id as lot_id,
    l.lot_number,
    l.block,
    l.area_sqm,
    l.current_price,
    l.status as lot_status,
    p.name as project_name,
    p.location,
    ct.contract_number,
    ct.monthly_payment,
    ct.status as contract_status
FROM customers c
JOIN lots l ON c.id = l.customer_id
JOIN projects p ON l.project_id = p.id
LEFT JOIN contracts ct ON l.id = ct.lot_id;

-- Procedimiento para actualizar precios automáticamente
DELIMITER //
CREATE OR REPLACE PROCEDURE UpdateLotPrices()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE lot_id INT;
    DECLARE current_price DECIMAL(12,2);
    DECLARE last_updated TIMESTAMP;
    DECLARE monthly_increase DECIMAL(5,2);
    DECLARE market_factor DECIMAL(5,2);
    DECLARE months_elapsed INT;
    DECLARE new_price DECIMAL(12,2);
    
    DECLARE cur CURSOR FOR 
        SELECT 
            l.id, 
            l.current_price, 
            l.price_last_updated,
            COALESCE(ps.monthly_increase_percentage, 2.00) as monthly_increase,
            COALESCE(ps.market_factor, 1.00) as market_factor
        FROM lots l
        JOIN projects p ON l.project_id = p.id
        LEFT JOIN price_settings ps ON p.location = ps.location
        WHERE l.status = 'available'
        AND TIMESTAMPDIFF(MONTH, l.price_last_updated, NOW()) > 0;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;
    
    read_loop: LOOP
        FETCH cur INTO lot_id, current_price, last_updated, monthly_increase, market_factor;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        SET months_elapsed = TIMESTAMPDIFF(MONTH, last_updated, NOW());
        SET new_price = current_price * POW(1 + (monthly_increase / 100), months_elapsed) * market_factor;
        
        UPDATE lots 
        SET current_price = ROUND(new_price, 2),
            price_last_updated = NOW()
        WHERE id = lot_id;
        
    END LOOP;
    
    CLOSE cur;
END//
DELIMITER ;

-- Evento para ejecutar actualización de precios mensualmente
SET GLOBAL event_scheduler = ON;

CREATE EVENT IF NOT EXISTS update_lot_prices_monthly
ON SCHEDULE EVERY 1 MONTH
STARTS CONCAT(DATE_FORMAT(NOW(), '%Y-%m'), '-01 02:00:00')
DO
  CALL UpdateLotPrices();

-- Insertar datos de prueba adicionales
INSERT IGNORE INTO `customers` (
    `id`, `range_id`, `code`, `country_id`, `membership_id`, 
    `password`, `name`, `lastname`, `mother_last`, `address`, 
    `phone`, `dni`, `email`, `active`, `created_at`
) VALUES 
(200, 1, '5100200TPR', 89, 1, '$2y$10$example', 'María', 'González', 'Pérez', 'Av. Principal 123', '987654321', '12345678', 'maria.gonzalez@email.com', '1', NOW()),
(201, 1, '5100201TPR', 89, 1, '$2y$10$example', 'Carlos', 'Rodríguez', 'Silva', 'Jr. Los Pinos 456', '987654322', '23456789', 'carlos.rodriguez@email.com', '1', NOW());

-- Contrato de ejemplo
INSERT IGNORE INTO `contracts` (
    `lot_id`, `customer_id`, `payment_plan_id`, `contract_number`,
    `total_amount`, `down_payment`, `financed_amount`, `monthly_payment`,
    `interest_rate`, `contract_date`, `start_date`, `end_date`, `status`
) VALUES (
    1, 200, 1, 'GV-2024-001',
    160000.00, 24000.00, 136000.00, 4500.00,
    3.50, '2024-01-15', '2024-02-01', '2027-01-31', 'active'
);

-- Cronograma de pagos de ejemplo (primeras 6 cuotas)
INSERT IGNORE INTO `payment_schedules` (
    `lot_id`, `payment_plan_id`, `installment_number`, `due_date`,
    `amount`, `capital`, `interest`, `balance`, `status`
) VALUES 
(1, 1, 1, '2024-02-01', 4500.00, 4103.33, 396.67, 131896.67, 'paid'),
(1, 1, 2, '2024-03-01', 4500.00, 4115.31, 384.69, 127781.36, 'paid'),
(1, 1, 3, '2024-04-01', 4500.00, 4127.32, 372.68, 123654.04, 'pending'),
(1, 1, 4, '2024-05-01', 4500.00, 4139.36, 360.64, 119514.68, 'pending'),
(1, 1, 5, '2024-06-01', 4500.00, 4151.43, 348.57, 115363.25, 'pending'),
(1, 1, 6, '2024-07-01', 4500.00, 4163.54, 336.46, 111199.71, 'pending');

-- Crear triggers para mantener integridad
DELIMITER //
CREATE OR REPLACE TRIGGER tr_lots_after_insert
AFTER INSERT ON lots
FOR EACH ROW
BEGIN
    UPDATE projects 
    SET total_lots = total_lots + 1,
        available_lots = available_lots + 1
    WHERE id = NEW.project_id;
END//

CREATE OR REPLACE TRIGGER tr_lots_after_update
AFTER UPDATE ON lots
FOR EACH ROW
BEGIN
    IF OLD.status != NEW.status THEN
        IF OLD.status = 'available' AND NEW.status IN ('reserved', 'sold') THEN
            UPDATE projects SET available_lots = available_lots - 1 WHERE id = NEW.project_id;
        ELSEIF OLD.status IN ('reserved', 'sold') AND NEW.status = 'available' THEN
            UPDATE projects SET available_lots = available_lots + 1 WHERE id = NEW.project_id;
        END IF;
    END IF;
END//

CREATE OR REPLACE TRIGGER tr_lots_after_delete
AFTER DELETE ON lots
FOR EACH ROW
BEGIN
    UPDATE projects 
    SET total_lots = total_lots - 1,
        available_lots = CASE 
            WHEN OLD.status = 'available' THEN available_lots - 1 
            ELSE available_lots 
        END
    WHERE id = OLD.project_id;
END//
DELIMITER ;
