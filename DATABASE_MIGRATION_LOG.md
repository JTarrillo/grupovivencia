# DOCUMENTACIÓN: Cambios SQL para Producción
**Fecha**: 5 de Mayo de 2026  
**Aplicación**: VIVELAND - Sistema de Gestión Inmobiliaria  
**Versión**: 1.0  

---

## PROBLEMA IDENTIFICADO

Al crear planes de pago con tipo de cuota inicial "Monto Fijo", el sistema fallaba con:
```
ERROR: Column 'min_down_payment_percentage' cannot be null
```

### Causa Raíz
La tabla `payment_plans` tenía restricciones de esquema que no permitían valores NULL en columnas que debían ser opcionales según la lógica de negocio:

| Columna | Estado Anterior | Problema |
|---------|-----------------|----------|
| `min_down_payment_percentage` | NOT NULL | Conflicto: cuando `down_payment_type='fixed'`, esta columna debe ser NULL |
| `base_interest_rate` | NOT NULL, DEFAULT NULL | Contradicción lógica |
| `duration_months` | NOT NULL, DEFAULT NULL | Contradicción lógica |

---

## CAMBIOS REALIZADOS

### CAMBIO 1: min_down_payment_percentage
**Línea de ejecución**:
```sql
ALTER TABLE payment_plans 
MODIFY COLUMN min_down_payment_percentage decimal(5,2) NULL DEFAULT NULL;
```

**Razón**: 
- Cuando el plan usa "Porcentaje", almacena el porcentaje en esta columna
- Cuando el plan usa "Monto Fijo", debe permitir NULL (el monto va en `min_down_payment_amount`)
- La columna debe ser NULLABLE

**Impacto**: ✅ Sin impacto en datos existentes (NULL es válido)

---

### CAMBIO 2: base_interest_rate
**Línea de ejecución**:
```sql
ALTER TABLE payment_plans 
MODIFY COLUMN base_interest_rate decimal(5,2) NOT NULL DEFAULT 0.00;
```

**Razón**: 
- Esta columna es obligatoria (toda plan debe tener tasa)
- Debe tener valor por defecto 0.00 para evitar errores de inserción
- El DEFAULT NULL con NOT NULL es contradicción lógica que causaba problemas

**Impacto**: ✅ Sin impacto (asigna 0.00 a registros nulos si existen)

---

### CAMBIO 3: duration_months
**Línea de ejecución**:
```sql
ALTER TABLE payment_plans 
MODIFY COLUMN duration_months int(11) NOT NULL DEFAULT 12;
```

**Razón**: 
- La duración es obligatoria
- El valor por defecto debe ser 12 meses (plan estándar)
- Evita errores de inserción cuando el usuario no especifica la duración

**Impacto**: ✅ Sin impacto (asigna 12 a registros nulos si existen)

---

## CÓMO EJECUTAR EN PRODUCCIÓN

### Opción 1: Desde CLI (Recomendado)
```powershell
# Conectar a la BD y ejecutar el script
C:\xampp\mysql\bin\mysql -u root -p grupovivencia < database/migrations/2026_05_05_payment_plans_schema_fix.sql
```

### Opción 2: Desde phpMyAdmin
1. Acceder a phpMyAdmin (localhost/phpmyadmin)
2. Seleccionar BD `grupovivencia`
3. Ir a tab "SQL"
4. Copiar y pegar el contenido de `2026_05_05_payment_plans_schema_fix.sql`
5. Ejecutar

### Opción 3: Línea por línea
```sql
ALTER TABLE payment_plans 
MODIFY COLUMN min_down_payment_percentage decimal(5,2) NULL DEFAULT NULL;

ALTER TABLE payment_plans 
MODIFY COLUMN base_interest_rate decimal(5,2) NOT NULL DEFAULT 0.00;

ALTER TABLE payment_plans 
MODIFY COLUMN duration_months int(11) NOT NULL DEFAULT 12;
```

---

## VERIFICACIÓN POST-EJECUCIÓN

Ejecutar para confirmar los cambios:
```sql
DESCRIBE payment_plans;
```

**Resultado esperado para las 3 columnas modificadas**:
```
| min_down_payment_percentage | decimal(5,2)  | YES  |     | NULL  |
| base_interest_rate          | decimal(5,2)  | NO   |     | 0.00  |
| duration_months             | int(11)       | NO   |     | 12    |
```

---

## CAMBIOS EN CÓDIGO PHP

**Archivo**: `app/Controllers/Inmueble.php`  
**Método**: `create_payment_plan()`

### Modificaciones:
1. **Convertir valores a tipos correctos**:
   - `base_interest_rate`: Convertir a float
   - `duration_months`: Convertir a int
   - `min_down_payment_percentage`: float o NULL
   - `min_down_payment_amount`: float o NULL

2. **Lógica condicional mejorada**:
   ```php
   if ($down_payment_type === 'percentage') {
       $min_down_payment_percentage = floatval($res['min_down_payment_percentage'] ?? 15);
       $min_down_payment_amount = null;
   } else {
       $min_down_payment_percentage = null;
       $min_down_payment_amount = floatval($res['min_down_payment_amount'] ?? 0);
   }
   ```

3. **Valores por defecto garantizados**:
   - Si no viene `base_interest_rate`, usa 0
   - Si no viene `duration_months`, usa 12
   - Si no viene porcentaje, usa 15%

---

## RUTAS TAMBIÉN CORREGIDAS

**Archivo**: `app/Config/Routes.php`

### Cambios:
1. **Ruta de create_payment_plan**: Cambió de GET a POST
   - Antes: `$routes->get('payment_plans/create_payment_plan', ...)`
   - Después: `$routes->post('create_payment_plan', ...)`

2. **Ruta de create_lots_bulk**: Agregada (faltaba)
   - Nuevo: `$routes->post('create_lots_bulk', ...)`

---

## CRONOGRAMA DE IMPLEMENTACIÓN

### Fase 1: BASE DE DATOS (Inmediato)
- ✅ Ejecutar script `2026_05_05_payment_plans_schema_fix.sql`
- ✅ Verificar con DESCRIBE
- ✅ Hacer backup antes (RECOMENDADO)

### Fase 2: CÓDIGO (Simultáneo)
- ✅ Implementar cambios en Inmueble.php
- ✅ Implementar cambios en Routes.php
- ✅ Verificar sintaxis PHP

### Fase 3: TESTING (Inmediatamente después)
- Probar crear plan con Porcentaje
- Probar crear plan con Monto Fijo
- Probar crear múltiples lotes
- Verificar en BD que los datos guardaron correctamente

---

## ROLLBACK (Si es necesario)

Si algo falla, revertir a la estructura anterior:
```sql
-- Solo si es absolutamente necesario
ALTER TABLE payment_plans 
MODIFY COLUMN min_down_payment_percentage decimal(5,2) NOT NULL DEFAULT NULL;

ALTER TABLE payment_plans 
MODIFY COLUMN base_interest_rate decimal(5,2) NOT NULL DEFAULT NULL;

ALTER TABLE payment_plans 
MODIFY COLUMN duration_months int(11) NOT NULL DEFAULT NULL;
```

**Nota**: El rollback no es recomendado. Los cambios son "forward compatible" con los datos existentes.

---

## NOTAS IMPORTANTES

⚠️ **BEFORE GOING TO PRODUCTION**:
1. Hacer BACKUP completo de la BD
2. Ejecutar script en staging PRIMERO
3. Probar todas las funcionalidades
4. Verificar que no hay planes de pago con valores NULL que causen errores

✅ **BENEFICIOS DE ESTOS CAMBIOS**:
- Los usuarios pueden crear planes con Monto Fijo sin errores
- Los usuarios pueden crear múltiples lotes sin problemas
- La BD es más resiliente ante inserciones sin todos los campos
- Los valores por defecto garantizan consistencia de datos

---

**Documento preparado**: 5 de Mayo de 2026  
**Por**: Sistema VIVELAND  
**Estado**: LISTO PARA PRODUCCIÓN ✅
