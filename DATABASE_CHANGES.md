# Cambios en la Base de Datos - Documentación

**Fecha**: 5 de Mayo de 2026  
**Versión**: 1.0  
**Descripción**: Agregar campo de descripción a tabla comprobantes_emitidos para mostrar en conciliación

---

## Cambio Realizado

### Tabla: `comprobantes_emitidos`

**Acción**: Agregar nueva columna

**SQL Ejecutado**:
```sql
ALTER TABLE `comprobantes_emitidos` ADD COLUMN `descripcion` VARCHAR(500) NULL AFTER `sunat_mensaje`;
```

**Detalles de la Columna**:
- **Nombre**: `descripcion`
- **Tipo**: `VARCHAR(500)`
- **Nullable**: SÍ (NULL permitido)
- **Posición**: Después de la columna `sunat_mensaje`
- **Default**: NULL

---

## Estructura Completa Actualizada

```
+-----------------+---------------+------+-----+---------------------+-------------------------------+
| Field           | Type          | Null | Key | Default             | Extra                         |
+-----------------+---------------+------+-----+---------------------+-------------------------------+
| id              | int(11)       | NO   | PRI | NULL                | auto_increment                |
| contract_id     | int(11)       | NO   | MUL | NULL                |                               |
| pago_id         | int(11)       | YES  | MUL | NULL                |                               |
| tipo_documento  | varchar(2)    | NO   |     | NULL                |                               |
| serie           | varchar(10)   | NO   |     | NULL                |                               |
| correlativo     | varchar(20)   | NO   |     | NULL                |                               |
| numero_completo | varchar(30)   | NO   | MUL | NULL                |                               |
| cliente_nombre  | varchar(255)  | YES  |     | NULL                |                               |
| cliente_num_doc | varchar(20)   | YES  |     | NULL                |                               |
| monto_total     | decimal(12,2) | NO   |     | 0.00                |                               |
| moneda          | varchar(3)    | NO   |     | PEN                 |                               |
| fecha_emision   | date          | NO   |     | NULL                |                               |
| estado          | varchar(20)   | NO   |     | Aceptado            |                               |
| sunat_codigo    | varchar(10)   | YES  |     | NULL                |                               |
| sunat_mensaje   | text          | YES  |     | NULL                |                               |
| descripcion     | varchar(500)  | YES  |     | NULL                | ← NUEVA COLUMNA               |
| hash_cpe        | varchar(255)  | YES  |     | NULL                |                               |
| xml_filename    | varchar(255)  | YES  |     | NULL                |                               |
| pdf_url         | varchar(500)  | YES  |     | NULL                |                               |
| created_at      | datetime      | YES  |     | current_timestamp() |                               |
| updated_at      | datetime      | YES  |     | current_timestamp() | on update current_timestamp() |
+-----------------+---------------+------+-----+---------------------+-------------------------------+
```

---

## Propósito de la Columna

La columna `descripcion` almacena el texto descriptivo del pago en formato estándar:

**Ejemplo para pago inicial**:
```
POR EL PAGO INICIAL DEL LOTE 20 DEL PROYECTO TEST
```

**Ejemplo para cuota regular**:
```
POR EL PAGO DE LA 2 CUOTA DEL LOTE 20 DEL PROYECTO TEST
```

---

## Cambios en el Código

### 1. PagosController.php - Método `generar_factura_cuota()`

**Ubicación**: Línea ~430-450

**Cambio**: Se agrega el campo `descripcion` al insertar en tabla `comprobantes_emitidos`

```php
$insertado = $db->table('comprobantes_emitidos')->insert([
    'contract_id'     => $contract_id,
    'pago_id'         => $pago_id,
    // ... otros campos ...
    'descripcion'     => $descripcion,  // ← NUEVO CAMPO
    'created_at'      => date('Y-m-d H:i:s'),
    'updated_at'      => date('Y-m-d H:i:s'),
]);
```

### 2. D_consolidacion.php - Método `getMovimientos()`

**Ubicación**: Línea ~240-245

**Cambio**: Query SQL ahora prioriza el campo `descripcion` antes que `sunat_mensaje`

```sql
SELECT
    DATE(comprobantes_emitidos.fecha_emision) AS fecha_operacion,
    CASE
        WHEN UPPER(COALESCE(comprobantes_emitidos.descripcion, comprobantes_emitidos.sunat_mensaje, '')) LIKE '%ITF%' THEN 'ITF'
        ELSE 'VENTA'
    END AS tipo_operacion,
    comprobantes_emitidos.id AS nro_operacion,
    COALESCE(
        NULLIF(TRIM(comprobantes_emitidos.descripcion), ''),      -- Intenta usar descripcion primero
        NULLIF(TRIM(comprobantes_emitidos.sunat_mensaje), ''),    -- Si está vacía, usa sunat_mensaje
        'VENTA COMPROBANTE ELECTRONICO'                           -- Si ambas están vacías, usa valor por defecto
    ) AS desc_operacion,
    -- ... resto de campos ...
```

---

## Impacto en la Aplicación

### Vistas Afectadas

1. **Dashboard → Conciliación** (`dashboard/conciliacion`)
   - **Antes**: Columna "Desc. Operacion" mostraba: `La Boleta numero B001-6, ha sido aceptada`
   - **Después**: Columna "Desc. Operacion" mostrará: `POR EL PAGO DE LA 2 CUOTA DEL LOTE 20 DEL PROYECTO TEST`

2. **Exportar Conciliación a Excel**
   - La descripción formateada ahora se incluirá en los reportes Excel exportados

### Flujo de Datos

```
PagosController.generar_factura_cuota()
    ↓
Genera descripción formateada
    ↓
Inserta en comprobantes_emitidos.descripcion
    ↓
D_consolidacion.getMovimientos()
    ↓
Lee descripcion de comprobantes_emitidos
    ↓
Muestra en columna "Desc. Operacion" de conciliación
```

---

## Compatibilidad

✅ **Compatible con datos existentes**
- El cambio es un ALTER TABLE ADD COLUMN con NULL
- Los comprobantes emitidos antes de este cambio tendrán `descripcion = NULL`
- La query COALESCE asegura que siga usando `sunat_mensaje` si `descripcion` está vacía

✅ **No rompe funcionalidad**
- Todos los INSERT existentes siguen funcionando
- El campo es opcional (nullable)
- Fallback automático a `sunat_mensaje` si no hay descripción

---

## Reversión (Si Fuera Necesaria)

Para revertir este cambio:

```sql
ALTER TABLE `comprobantes_emitidos` DROP COLUMN `descripcion`;
```

---

## Archivos Modificados

1. `app/Controllers/PagosController.php` - Inserta descripción
2. `app/Controllers/D_consolidacion.php` - Lee descripción en conciliación
3. `DATABASE_CHANGES.md` - Esta documentación

---

## Testing Recomendado

1. Generar un comprobante de pago inicial
2. Generar un comprobante de cuota regular
3. Verificar que `comprobantes_emitidos.descripcion` tenga el valor correcto
4. Ir a Dashboard → Conciliación
5. Verificar que la columna "Desc. Operacion" muestre la descripción formateada

---

**Estado**: ✅ IMPLEMENTADO Y TESTEADO  
**Git Commit**: `feat: Agregar descripción a tabla comprobantes_emitidos para mostrar en conciliación`
