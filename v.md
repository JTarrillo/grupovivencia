# Consultas MySQL - Proyecto Grupovivencia

## Conexion usada

- Motor: `MariaDB / MySQL`
- Host: `localhost`
- Puerto: `3306`
- Usuario: `root`
- Password: vacia
- Base de datos: `grupovivencia`

## Comando de consola

```powershell
C:\xampp\mysql\bin\mysql.exe -u root -D grupovivencia
```

## Consultas usadas

### 1. Ver tablas de la base

```sql
SHOW TABLES;
```

### 2. Revisar relaciones FK de tablas inmobiliarias/clientes

```sql
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'grupovivencia'
  AND (
        TABLE_NAME IN (
            'contracts',
            'projects',
            'customers',
            'payment_plans',
            'payment_schedules',
            'lots',
            'ventas_inmuebles',
            'costos_proyecto',
            'customer_bank',
            'range_customer',
            'unilevels'
        )
        OR REFERENCED_TABLE_NAME IN (
            'contracts',
            'projects',
            'customers',
            'payment_plans',
            'payment_schedules',
            'lots',
            'ventas_inmuebles',
            'costos_proyecto',
            'customer_bank',
            'range_customer',
            'unilevels'
        )
      )
  AND REFERENCED_TABLE_NAME IS NOT NULL
ORDER BY TABLE_NAME, COLUMN_NAME;
```

### 3. Conteo previo antes de limpiar

```sql
SELECT 'archivos_digitales' AS tabla, COUNT(*) AS total FROM archivos_digitales
UNION ALL
SELECT 'commission_reports', COUNT(*) FROM commission_reports
UNION ALL
SELECT 'contracts', COUNT(*) FROM contracts
UNION ALL
SELECT 'projects', COUNT(*) FROM projects
UNION ALL
SELECT 'customers', COUNT(*) FROM customers
UNION ALL
SELECT 'payment_plans', COUNT(*) FROM payment_plans
UNION ALL
SELECT 'payment_schedules', COUNT(*) FROM payment_schedules
UNION ALL
SELECT 'lots', COUNT(*) FROM lots
UNION ALL
SELECT 'ventas_inmuebles', COUNT(*) FROM ventas_inmuebles
UNION ALL
SELECT 'costos_proyecto', COUNT(*) FROM costos_proyecto
UNION ALL
SELECT 'customer_bank', COUNT(*) FROM customer_bank
UNION ALL
SELECT 'range_customer', COUNT(*) FROM range_customer
UNION ALL
SELECT 'unilevels', COUNT(*) FROM unilevels;
```

### 4. Script ejecutado para truncar

```sql
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE archivos_digitales;
TRUNCATE TABLE commission_reports;
TRUNCATE TABLE payment_schedules;
TRUNCATE TABLE contracts;
TRUNCATE TABLE ventas_inmuebles;
TRUNCATE TABLE lots;
TRUNCATE TABLE costos_proyecto;
TRUNCATE TABLE projects;
TRUNCATE TABLE payment_plans;
TRUNCATE TABLE customer_bank;
TRUNCATE TABLE range_customer;
TRUNCATE TABLE unilevels;
TRUNCATE TABLE customers;

SET FOREIGN_KEY_CHECKS = 1;
```

### 5. Conteo final de verificacion

```sql
SELECT 'archivos_digitales' AS tabla, COUNT(*) AS total FROM archivos_digitales
UNION ALL
SELECT 'commission_reports', COUNT(*) FROM commission_reports
UNION ALL
SELECT 'contracts', COUNT(*) FROM contracts
UNION ALL
SELECT 'projects', COUNT(*) FROM projects
UNION ALL
SELECT 'customers', COUNT(*) FROM customers
UNION ALL
SELECT 'payment_plans', COUNT(*) FROM payment_plans
UNION ALL
SELECT 'payment_schedules', COUNT(*) FROM payment_schedules
UNION ALL
SELECT 'lots', COUNT(*) FROM lots
UNION ALL
SELECT 'ventas_inmuebles', COUNT(*) FROM ventas_inmuebles
UNION ALL
SELECT 'costos_proyecto', COUNT(*) FROM costos_proyecto
UNION ALL
SELECT 'customer_bank', COUNT(*) FROM customer_bank
UNION ALL
SELECT 'range_customer', COUNT(*) FROM range_customer
UNION ALL
SELECT 'unilevels', COUNT(*) FROM unilevels;
```

## Resultado final

- `archivos_digitales`: `0`
- `commission_reports`: `0`
- `contracts`: `0`
- `projects`: `0`
- `customers`: `0`
- `payment_plans`: `0`
- `payment_schedules`: `0`
- `lots`: `0`
- `ventas_inmuebles`: `0`
- `costos_proyecto`: `0`
- `customer_bank`: `0`
- `range_customer`: `0`
- `unilevels`: `0`

## Nota

- Si luego quieres volver a poblar datos de prueba, puedes importar un `.sql` o insertar manualmente desde Navicat.
- Este archivo queda como referencia para futuras limpiezas del entorno antes de subir a pruebas.
