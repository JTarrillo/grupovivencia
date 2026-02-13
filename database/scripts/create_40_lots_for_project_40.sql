-- Script: create_40_lots_for_project_40.sql
-- Inserta 40 lotes asociados a project_id = 40
-- Ajusta base_price_per_sqm (precio por m2) si tu proyecto usa otro valor

USE rere;

DELIMITER //
DROP PROCEDURE IF EXISTS insert_lots_for_project_40 //
CREATE PROCEDURE insert_lots_for_project_40()
BEGIN
  DECLARE i INT DEFAULT 1;
  WHILE i <= 40 DO
    INSERT INTO lots (
      project_id,
      lot_number,
      block,
      area_sqm,
      base_price,
      current_price,
      status,
      created_at,
      price_last_updated
    ) VALUES (
      40,
      CONCAT('L-', LPAD(i,3,'0')),
      CHAR(65 + FLOOR((i-1)/10)), -- A,B,C,D (cada 10 lotes)
      ROUND(60 + (i-1) * 2.5, 2), -- áreas secuenciales 60.00, 62.50, ...
      ROUND((60 + (i-1) * 2.5) * 100, 2), -- base_price = area * 100 S/
      ROUND((60 + (i-1) * 2.5) * 100, 2), -- current_price igual
      'available',
      NOW(),
      NOW()
    );
    SET i = i + 1;
  END WHILE;
END //
DELIMITER ;

-- Ejecutar procedimeinto
CALL insert_lots_for_project_40();

-- Limpiar
DROP PROCEDURE IF EXISTS insert_lots_for_project_40;

-- Verificar (opcional):
-- SELECT id, lot_number, block, area_sqm, base_price, current_price, status, created_at FROM lots WHERE project_id = 40 ORDER BY id DESC LIMIT 50;
