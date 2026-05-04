-- ===========================================================================
-- MIGRACIÓN: Refactorizar arquitectura de planes de pago
-- Fecha: 4 de Mayo de 2026
-- Objetivo: Usar payment_plans como tabla maestra
-- ===========================================================================

-- 1. Agregar columna payment_plan_id a projects (FK)
ALTER TABLE projects 
ADD COLUMN payment_plan_id BIGINT UNSIGNED DEFAULT NULL AFTER status,
ADD CONSTRAINT fk_projects_payment_plan 
FOREIGN KEY (payment_plan_id) 
REFERENCES payment_plans(id) 
ON DELETE SET NULL 
ON UPDATE CASCADE;

-- 2. Crear un plan de pago por defecto para proyectos existentes
-- (Este es el "plan heredado" que combinará los valores actuales de proyectos)
INSERT INTO payment_plans 
(name, code, location, duration_months, down_payment_type, min_down_payment_percentage, min_amount, base_interest_rate, is_default, active, created_at, updated_at)
VALUES 
('Plan Heredado - Proyectos Existentes', 'LEGACY_DEFAULT', 'MIXED', 36, 'percentage', 15, 0, 3, 0, 1, NOW(), NOW());

-- Obtener el ID del plan recién creado para usar en UPDATE
SET @legacy_plan_id = LAST_INSERT_ID();

-- 3. Asignar el plan heredado a todos los proyectos existentes
UPDATE projects 
SET payment_plan_id = @legacy_plan_id 
WHERE payment_plan_id IS NULL;

-- 4. Remover columnas duplicadas de la tabla projects
-- (Mantener primero en caso de que sea necesario para referencia)
ALTER TABLE projects 
DROP COLUMN max_financing_months,
DROP COLUMN down_payment_type,
DROP COLUMN min_down_payment_percentage,
DROP COLUMN min_down_payment_fixed;

-- 5. Nota: No remover base_interest_rate aún si está siendo usada
-- por otros sistemas. Se debe revisar contratos y otros módulos primero.

-- ===========================================================================
-- VERIFICACIÓN POST-MIGRACIÓN
-- ===========================================================================

-- Mostrar estructura actualizada de projects
-- DESCRIBE projects;

-- Mostrar asignación de planes
-- SELECT id, code, name, payment_plan_id FROM projects LIMIT 10;

-- Mostrar plan heredado
-- SELECT * FROM payment_plans WHERE code = 'LEGACY_DEFAULT';

-- ===========================================================================
-- ROLLBACK (en caso de problemas):
-- 
-- ALTER TABLE projects 
-- DROP FOREIGN KEY fk_projects_payment_plan;
-- 
-- ALTER TABLE projects 
-- DROP COLUMN payment_plan_id;
-- 
-- DELETE FROM payment_plans WHERE code = 'LEGACY_DEFAULT';
-- ===========================================================================
