-- Actualizar tabla payment_plans para agregar campos faltantes
ALTER TABLE `payment_plans` 
ADD COLUMN `department_id` INT DEFAULT NULL AFTER `location`,
ADD COLUMN `province_id` VARCHAR(100) DEFAULT NULL AFTER `department_id`,
ADD COLUMN `district_id` VARCHAR(100) DEFAULT NULL AFTER `province_id`,
ADD COLUMN `down_payment_type` VARCHAR(50) DEFAULT 'percentage' AFTER `min_down_payment_percentage`,
ADD COLUMN `min_down_payment_amount` DECIMAL(10,2) DEFAULT NULL AFTER `down_payment_type`;

-- Agregar índices
ALTER TABLE `payment_plans` ADD INDEX `idx_department_id` (`department_id`);
ALTER TABLE `payment_plans` ADD INDEX `idx_location_hierarchy` (`department_id`, `province_id`, `district_id`);
