# Investigación: Flujo de Retiros vs Informe de Comisiones

## 1. FLUJO ACTUAL DE RETIRO (Cobro/Withdraw)

### Usuario: `pay.php` → `B_cobros::make_pay()`

**Proceso:**

1. Usuario ingresa a `/backoffice_new/cobros` (pay.php)
2. Ve saldo disponible
3. Clickea botón "Solicitar Cobro"
4. Modal pide: **Monto + PIN**
5. El PIN se solicita por email (función `send_pin()`)
6. Valida PIN ingresado
7. Si es válido, inserta datos en 3 tablas:
   - **pays** → Solicitud de retiro (estado: '1' = pending)
   - **commissions** → Descuento del retiro (bonus_id: 8)
   - **pay_commission** → Vinculación entre ambas

**Validaciones Implementadas:**
✅ Solo días 1 y 2 del mes
✅ Mínimo S/100
✅ **DETRACCIÓN 10%** si monto en factura >= S/700 (NO es retención, es detracción)
✅ Obligatorio adjuntar factura

### Admin ve: `/admin/pagos/list.php` (Controlador: D_pagos)

- Lista de solicitudes de retiro
- Estado: En espera / Procesado / Rechazado
- Con información de banco, monto, detracción, factura

---

## 2. FLUJO DEL INFORME DE COMISIONES (Nuevo)

### Usuario: `commission_reports/create.php` → `CommissionReportController::store()`

**Proceso:**

1. Usuario crea informe (Nº001-2026)
2. Llena datos:
   - Asunto, Proyectos, Descripción
   - Número de factura, Monto total
3. Sube 4 archivos (Excel, Vauchers, Boletas, Factura PDF)
4. Envía informe
5. Se guarda en tabla **commission_reports** (estado: 'pending')

**Sin validaciones especiales aún**

### Admin ve: `/admin/commission_reports/dashboard.php`

- Resumen de conteos por estado
- Tabla de informes pendientes
- Detalle completo de cada informe
- Puede cambiar estado y agregar notas

---

## 3. COMPARATIVA: DÓNDE VA LA INFORMACIÓN

| Concepto            | Retiro                              | Informe Comisiones                          |
| ------------------- | ----------------------------------- | ------------------------------------------- |
| **Tabla Principal** | `pays`                              | `commission_reports`                        |
| **Información**     | Monto, banco, factura               | Detalle completo, 4 archivos                |
| **Estado**          | 1=Espera, 2=Procesado, 0=Rechazado  | pending, reviewed, approved, rejected, paid |
| **Auditoría**       | ❌ No tiene reviewed_by/reviewed_at | ✅ Tiene audit trail completo               |
| **Admin Vista**     | `/admin/pagos/list`                 | `/admin/commission_reports/dashboard`       |
| **PIN requerido**   | ✅ Sí                               | ❌ No                                       |
| **Archivos**        | 1 (factura)                         | 4 (Excel, vauchers, boletas, factura)       |
| **Días permitidos** | Solo 1-2 mes                        | Cualquier día                               |

---

## 4. PROBLEMA IDENTIFICADO

**El admin NO ve ambas cosas en UN SOLO LUGAR**

- Si quiere ver retiros: va a `/admin/pagos/list`
- Si quiere ver informes: va a `/admin/commission_reports/dashboard`
- No hay relación visible entre ambos

**Información que llega al admin:**

- Retiros: Solicitud de retiro individual (sin detalle de comisiones derivadas)
- Informes: Informe detallado (pero no vinculado con retiros posteriores)

---

## 5. PROPUESTA DE SOLUCIÓN UNIFICADA

### OPCIÓN A: Dashboard Admin Centralizado

**Crear: `/admin/financial-reports/dashboard.php`**

Una sola pantalla que muestre:

```
┌─ RESUMEN FINANCIERO (últimos 30 días)
│  ├─ Informes pendientes: 5 ($15,000)
│  ├─ Retiros solicitados: 8 ($8,500)
│  ├─ Retiros procesados: 12 ($32,000)
│  └─ Retenciones recaudadas: $3,200

├─ INFORMES PENDIENTES
│  ├─ Informe 001-2026 | $10,000 | Rolando I. | Revisar/Aprobar/Rechazar
│  └─ ...

├─ RETIROS PENDIENTES
│  ├─ Retiro #234 | $5,500 | Juan P. | Procesar/Rechazar
│  └─ ...

└─ FILTROS
   ├─ Por tipo (Informe / Retiro / Ambos)
   ├─ Por estado
   ├─ Por periodo
   └─ Por patrocinador
```

### OPCIÓN B: Vincular Informe con Retiro

**Modificar tabla `commission_reports`:**

- Agregar campo `related_withdrawal_id` (FK a pays)
- Cuando el admin aprueba informe, genera retiro automático
- El retiro queda vinculado al informe
- Admin puede ver: Informe → Aprobado → Retiro generado

### OPCIÓN C: Crear Flujo Único "Solicitud de Transferencia"

**Nueva tabla: `financial_requests`**

- Unifica retiros + informes en un solo sistema
- Estados: draft → pending → approved → processed → paid
- Tipo: retiro_simple | informe_comisiones
- Todo en un solo lugar para el admin

---

## 6. RECOMENDACIÓN

**OPCIÓN A (Dashboard Centralizado) + OPCIÓN B (Vincular)**

Esto porque:

1. ✅ Mantiene ambos sistemas funcionales y separados
2. ✅ Admin ve todo en un solo lugar
3. ✅ Permite auditoría completa (quién solicitó qué, cuándo, estado)
4. ✅ Futuro: Automatizar generación de retiro después de aprobar informe
5. ✅ Trazabilidad: "Este retiro viene de este informe"

**Fases de implementación:**

- Fase 1: Dashboard centralizado (list todos, filtrar, ver detalles)
- Fase 2: Vincular informe aprobado → retiro automático
- Fase 3: Automatizar depósito cuando retiro es procesado
