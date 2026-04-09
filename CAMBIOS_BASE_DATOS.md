# CAMBIOS DE BASE DE DATOS - CLASIFICACIÓN DE GASTOS

Fecha: Abril 8, 2026

## RESUMEN EJECUTIVO

Se han implementado 5 nuevas tablas para el módulo de **Clasificación de Gastos** con relaciones de FK, índices y datos por defecto.

---

## TABLAS CREADAS

### 1. `gasto_tipos` - Tipos de Gasto

| Campo       | Tipo            | Descripción            |
| ----------- | --------------- | ---------------------- |
| id          | BIGINT UNSIGNED | ID Primario            |
| nombre      | VARCHAR(100)    | Nombre del tipo        |
| icono       | VARCHAR(50)     | Ícono Font Awesome     |
| descripcion | TEXT            | Descripción            |
| color       | VARCHAR(20)     | Color hexadecimal      |
| activo      | TINYINT         | Estado activo/inactivo |
| created_at  | TIMESTAMP       | Fecha creación         |
| updated_at  | TIMESTAMP       | Fecha actualización    |

**Datos iniciales:**

- ID 4: "Costo de Proyectos" (fa-hammer, color #28a745)

---

### 2. `gasto_subcategorias` - Subcategorías de Gasto

| Campo         | Tipo            | Descripción         |
| ------------- | --------------- | ------------------- |
| id            | BIGINT UNSIGNED | ID Primario         |
| gasto_tipo_id | BIGINT UNSIGNED | FK a gasto_tipos    |
| nombre        | VARCHAR(100)    | Nombre subcategoría |
| descripcion   | TEXT            | Descripción         |
| activo        | TINYINT         | Estado              |
| created_at    | TIMESTAMP       | Fecha creación      |
| updated_at    | TIMESTAMP       | Fecha actualización |

**Datos iniciales (5 subcategorías para Tipo ID 4):**

1. Mano de Obra
2. Maquinaria y Equipo
3. Materia Prima
4. Materiales Auxiliares
5. Suministros

---

### 3. `compra_gastos` - Clasificación de Compras

| Campo                 | Tipo            | Descripción              |
| --------------------- | --------------- | ------------------------ |
| id                    | BIGINT UNSIGNED | ID Primario              |
| compra_id             | BIGINT UNSIGNED | FK a compras             |
| gasto_tipo_id         | BIGINT UNSIGNED | FK a gasto_tipos         |
| gasto_subcategoria_id | BIGINT UNSIGNED | FK a gasto_subcategorias |
| proyecto_id           | BIGINT UNSIGNED | Proyecto asociado (NULL) |
| contrato_id           | BIGINT UNSIGNED | Contrato asociado (NULL) |
| observaciones         | TEXT            | Notas adicionales        |
| clasificado_por       | BIGINT UNSIGNED | Usuario que clasificó    |
| fecha_clasificacion   | TIMESTAMP       | Fecha clasificación      |
| created_at            | TIMESTAMP       | Fecha creación           |
| updated_at            | TIMESTAMP       | Fecha actualización      |

**Relaciones:**

- FK compra_id → compras(id) ON DELETE CASCADE
- FK gasto_tipo_id → gasto_tipos(id) ON DELETE RESTRICT
- FK gasto_subcategoria_id → gasto_subcategorias(id) ON DELETE RESTRICT

---

### 4. `compra_documentos` - Documentos Adjuntos

| Campo           | Tipo            | Descripción                       |
| --------------- | --------------- | --------------------------------- |
| id              | BIGINT UNSIGNED | ID Primario                       |
| compra_id       | BIGINT UNSIGNED | FK a compras                      |
| tipo_documento  | VARCHAR(50)     | Tipo (factura, recibo, foto, etc) |
| nombre_original | VARCHAR(255)    | Nombre archivo original           |
| ruta_archivo    | VARCHAR(512)    | Ruta del archivo                  |
| tipo_mime       | VARCHAR(100)    | MIME type                         |
| tamanio         | BIGINT          | Tamaño en bytes                   |
| hash_archivo    | VARCHAR(64)     | SHA256 hash                       |
| cargado_por     | BIGINT UNSIGNED | Usuario que cargó                 |
| fecha_carga     | TIMESTAMP       | Fecha carga                       |
| descripcion     | TEXT            | Descripción                       |
| created_at      | TIMESTAMP       | Fecha creación                    |

**Relaciones:**

- FK compra_id → compras(id) ON DELETE CASCADE

---

### 5. `gasto_reportes` - Reportes de Gastos

| Campo            | Tipo            | Descripción                |
| ---------------- | --------------- | -------------------------- |
| id               | BIGINT UNSIGNED | ID Primario                |
| nombre           | VARCHAR(255)    | Nombre reporte             |
| fecha_inicio     | DATE            | Período inicio             |
| fecha_fin        | DATE            | Período fin                |
| proyecto_id      | BIGINT UNSIGNED | Proyecto (NULL)            |
| contrato_id      | BIGINT UNSIGNED | Contrato (NULL)            |
| tipo_gasto_id    | BIGINT UNSIGNED | Filtro tipo                |
| contenido_html   | LONGTEXT        | HTML generado              |
| contenido_pdf    | VARCHAR(512)    | Ruta PDF                   |
| total_gasto      | DECIMAL(15,2)   | Total calculado            |
| cantidad_compras | INT             | Cantidad items             |
| estado           | VARCHAR(20)     | borrador/procesado/enviado |
| usuario_creador  | BIGINT UNSIGNED | Usuario                    |
| usuario_contable | BIGINT UNSIGNED | Usuario contable           |
| fecha_envio      | TIMESTAMP       | Fecha envío                |
| observaciones    | TEXT            | Notas                      |
| created_at       | TIMESTAMP       | Fecha creación             |
| updated_at       | TIMESTAMP       | Fecha actualización        |

**Relaciones:**

- FK tipo_gasto_id → gasto_tipos(id) ON DELETE SET NULL

---

## CAMBIOS EN TABLA EXISTENTE

### Tabla `compras` - Campos Agregados

Se agregaron 2 campos opcionales:

```sql
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `proyecto_id` BIGINT UNSIGNED NULL;
ALTER TABLE `compras` ADD COLUMN IF NOT EXISTS `contrato_id` BIGINT UNSIGNED NULL;
ALTER TABLE `compras` ADD INDEX IF NOT EXISTS `idx_proyecto` (`proyecto_id`);
ALTER TABLE `compras` ADD INDEX IF NOT EXISTS `idx_contrato` (`contrato_id`);
```

**Campos añadidos:**

- `proyecto_id`: Asociar compra a un proyecto
- `contrato_id`: Asociar compra a un contrato

---

## ÍNDICES CREADOS

| Tabla               | Índice           | Campo                   |
| ------------------- | ---------------- | ----------------------- |
| gasto_tipos         | idx_nombre       | nombre                  |
| gasto_subcategorias | idx_tipo         | gasto_tipo_id           |
| compra_gastos       | idx_compra       | compra_id               |
| compra_gastos       | idx_tipo         | gasto_tipo_id           |
| compra_gastos       | idx_subcategoria | gasto_subcategoria_id   |
| compra_gastos       | idx_proyecto     | proyecto_id             |
| compra_gastos       | idx_contrato     | contrato_id             |
| compra_documentos   | idx_tipo_doc     | tipo_documento          |
| compra_documentos   | idx_compra_doc   | compra_id               |
| gasto_reportes      | idx_estado       | estado                  |
| gasto_reportes      | idx_fecha        | fecha_inicio, fecha_fin |
| gasto_reportes      | idx_tipo_gasto   | tipo_gasto_id           |
| compras             | idx_proyecto     | proyecto_id             |
| compras             | idx_contrato     | contrato_id             |

---

## FOREIGN KEYS

| Tabla               | Constraint         | Referencia              | ON DELETE |
| ------------------- | ------------------ | ----------------------- | --------- |
| gasto_subcategorias | fk_gs_tipo         | gasto_tipos(id)         | CASCADE   |
| compra_gastos       | fk_cg_compra       | compras(id)             | CASCADE   |
| compra_gastos       | fk_cg_tipo         | gasto_tipos(id)         | RESTRICT  |
| compra_gastos       | fk_cg_subcategoria | gasto_subcategorias(id) | RESTRICT  |
| compra_documentos   | fk_cd_compra       | compras(id)             | CASCADE   |
| gasto_reportes      | fk_gr_tipo         | gasto_tipos(id)         | SET NULL  |

---

## CÓMO EJECUTAR

### Opción 1: MySQL CLI

```bash
mysql -u root -h 127.0.0.1 grupovivencia < LATEST_DATABASE_CHANGES.sql
```

### Opción 2: phpMyAdmin

1. SQL → Nueva consulta
2. Copiar y pegar contenido de `LATEST_DATABASE_CHANGES.sql`
3. Ejecutar

### Opción 3: MySQL Workbench

1. Abrir archivo
2. Ejecutar SQL

---

## VERIFICACIÓN

Ejecutar consulta de verificación:

```sql
SELECT 'TIPOS' as INFO, COUNT(*) as total FROM gasto_tipos
UNION ALL
SELECT 'SUBCATEGORÍAS', COUNT(*) FROM gasto_subcategorias
UNION ALL
SELECT 'COMPRA_GASTOS', COUNT(*) FROM compra_gastos
UNION ALL
SELECT 'COMPRA_DOCUMENTOS', COUNT(*) FROM compra_documentos
UNION ALL
SELECT 'GASTO_REPORTES', COUNT(*) FROM gasto_reportes;
```

**Resultado esperado:**

```
INFO              | total
TIPOS             | 1
SUBCATEGORÍAS     | 5
COMPRA_GASTOS     | 0
COMPRA_DOCUMENTOS | 0
GASTO_REPORTES    | 0
```

---

## ARCHIVOS RELACIONADOS EN GIT

- `app/Controllers/D_clasificacion.php` - Controller principal (11 métodos)
- `app/Models/GastoTipoModel.php` - Model para tipos
- `app/Models/GastoSubcategoriaModel.php` - Model para subcategorías
- `app/Models/CompraGastoModel.php` - Model para clasificación
- `app/Models/CompraDocumentoModel.php` - Model para documentos
- `app/Models/GastoReporteModel.php` - Model para reportes
- `app/Views/admin/clasificacion/index.php` - Vista dashboard
- `app/Views/admin/clasificacion/clasificar.php` - Vista formulario
- `app/Config/Routes.php` - Rutas API (8 endpoints)
- `app/Views/admin/header.php` - Menú integrado

---

## NOTAS IMPORTANTES

1. **Integridad referencial**: Todas las FKs están configuradas
2. **Cascada**: Eliminar una compra elimina automáticamente su clasificación y documentos
3. **Restricción**: No se puede eliminar tipos/subcategorías si están en uso (RESTRICT)
4. **Charset**: UTF-8 MB4 en todas las tablas para caracteres especiales
5. **Timestamps**: Todas las tablas tienen created_at y updated_at automáticos

---

**Compartir con tu compañero:**

- Este archivo resumen
- El archivo SQL: `LATEST_DATABASE_CHANGES.sql`
- El commit Git: `modulo-compras-gastos 7c80dce2`
