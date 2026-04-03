# Documentación: Sistema de Estados de Pago

## Problema Identificado

El sistema tenía inconsistencia en los estados de pago entre el admin (cronograma_completo.php) y la vista de cliente (backoffice_new/cronograma.php), causando que los pagos validados no se mostraran correctamente.

---

## Estados de Pago Válidos

### Base de Datos (PaymentScheduleModel - tabla payment_schedules)

- `pending` - Pago pendiente (por defecto)
- `registered` - Pago registrado por cliente, espera validación del admin
- `paid` - Pago validado/aprobado por admin

### Conversión de Estados (Legacy)

- `pagado` → Debe convertirse a `paid`
- `Pagado` → Debe convertirse a `paid`

---

## Ubicaciones Críticas

### 1. **Admin - Validar Pago**

📁 `app/Controllers/PagosController.php` (línea 126)

```php
// Cuando el admin valida un pago, se guarda así:
$updateData = [
    'status' => 'paid',  // ← SIEMPRE usar 'paid' (minúsculas)
    'paid_date' => date('Y-m-d H:i:s'),
    'paid_amount' => $pago['amount'],
    'validado_notas' => $notas
];
```

### 2. **Controlador - Cálculo de Estadísticas**

📁 `app/Controllers/BackofficeNew/ContractsController.php` (línea 125-135)

**ANTES (INCORRECTO):**

```php
foreach ($cronograma as $pago) {
    if ($pago['status'] == 'Pagado') {  // ❌ Buscaba 'Pagado' (con mayúscula)
        $pagos_realizados++;
    }
}
```

**DESPUÉS (CORRECTO):**

```php
foreach ($cronograma as $pago) {
    $estado = strtolower($pago['status'] ?? 'pending');
    if ($estado == 'pagado' || $estado == 'paid') {  // ✅ Normaliza a minúsculas
        $pagos_realizados++;
        $monto_realizado += $pago['amount'];
    }
}
```

### 3. **Vista - Cálculo de Estadísticas**

📁 `app/Views/backoffice_new/cronograma.php` (línea 158-167)

```php
$estado = $pago['estado'] ?? $pago['status'] ?? '';
$estado = strtolower($estado);  // Normalizar a minúsculas

if ($estado == 'paid' || $estado == 'pagado') {
    // Mostrar como pagado
}
```

---

## Flujo Correcto de Estados

```
CLIENTE registra pago
        ↓
estado = 'registered'
        ↓
ADMIN valida pago
        ↓
estado = 'paid'
        ↓
Se muestra en estadísticas y cronograma
```

---

## Checklist Para Evitar Este Problema

- ✅ **Almacenar estados en minúsculas** en la base de datos
- ✅ **Normalizar con `strtolower()`** antes de comparar
- ✅ **Usar `'paid'` para estado validado** (no 'Pagado' ni 'PAID')
- ✅ **Documentar valores esperados** en modelos
- ✅ **Crear test** para verificar cálculo de estadísticas

---

## Estados de Pago en Diferentes Vistas

| Vista                       | Ubicación                                          | Estados Esperados                | Normaliza |
| --------------------------- | -------------------------------------------------- | -------------------------------- | --------- |
| Admin - Cronograma Completo | `app/Views/admin/inmueble/cronograma_completo.php` | paid, registered, pending        | ✅ Sí     |
| Cliente - Metronic          | `app/Views/backoffice_new/cronograma.php`          | paid/pagado, registered, pending | ✅ Sí     |
| Tabla de Base de Datos      | `payment_schedules.status`                         | paid, registered, pending        | N/A       |

---

## Commits Relacionados

```
b81e69ab - Fix: Normalizar verificación de estado de pago (pagado/paid)
113c5eec - Feat: Mejorar header con más información del contrato y aumentar vibrancia de colores
```

---

## Testing

Para verificar que el fix funciona correctamente:

1. **Validar un pago en el admin** → Debe aparecer como "Pagado"
2. **Ver el cronograma cliente** → Debe mostrar el count correcto en estadísticas
3. **Verificar el porcentaje de progreso** → Debe ser: (pagados / total) \* 100

---

## Notas Importantes

⚠️ **No cambiar el estado a `'Pagado'` con mayúscula** - siempre usar `'paid'` en minúsculas
⚠️ **Normalizar SIEMPRE** antes de comparar: `strtolower($pago['status'])`
⚠️ **Mantener consistencia** entre controladores que guardan y que leen el estado

---

**Última actualización:** 3 de Abril de 2026
**Autor:** Sistema de Pagos - Grupo Vivencia
