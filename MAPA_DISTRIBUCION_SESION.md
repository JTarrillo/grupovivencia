# 🗺️ MAPA DE DISTRIBUCIÓN DE VARIABLES DE SESIÓN

## ESTADÍSTICAS GENERALES

```
Total de referencias encontradas: 127+
Total de archivos afectados: 72
Total de líneas de código a actualizar: 157+

Distribución por tipo:
- Controllers: 100+ referencias
- Views: 40+ referencias

Distribución por módulo:
- ADMIN (D_*): 85+ referencias
- BACKOFFICE (B_*, backoffice_new/): 30+ referencias
- PUBLIC/NO_CAT: 12+ referencias
```

---

## 📁 ÁRBOL DE ARCHIVOS AFECTADOS

### Controllers ADMIN (prefix: D_*)

```
app/Controllers/
├── D_clasificacion.php         [3 refs - session()->get('id')]
├── D_usuarios.php              [4 refs - $_SESSION['id','first_name','last_name','name']]
├── D_transfer.php              [3 refs - $_SESSION['id','first_name','last_name']]
├── D_ticket.php                [3 refs - $_SESSION['first_name','last_name']]
├── D_supplier.php              [3 refs - $_SESSION['id','first_name','last_name']]
├── D_sugerencias.php           [1 ref  - $_SESSION['first_name','last_name']]
├── D_report.php                [8 refs - $_SESSION['first_name','last_name']]
├── D_recarga.php               [8 refs - $_SESSION['first_name','last_name']]
├── D_rangos.php                [6 refs - $_SESSION['first_name','last_name']]
├── D_points.php                [4 refs - $_SESSION['first_name','last_name']]
├── D_periodos.php              [3 refs - $_SESSION['id','first_name','last_name']]
├── D_panel.php                 [14 refs - $_SESSION['id','first_name','last_name','name']]
├── D_pago_tienda.php           [8 refs - $_SESSION['id','first_name','last_name']]
├── D_pagos.php                 [4 refs - $_SESSION['first_name','last_name']]
├── D_outgoing.php              [4 refs - $_SESSION['id','first_name','last_name']]
├── D_nueva_venta.php           [7 refs - $_SESSION['first_name','last_name']]
├── D_kyc.php                   [4 refs - $_SESSION['first_name','last_name']]
├── D_kit_afiliacion.php        [4 refs - $_SESSION['first_name','last_name']]
├── D_kardex.php                [4 refs - $_SESSION['first_name','last_name']]
├── D_integracion_pagos.php     [12 refs - $_SESSION['first_name','last_name']]
├── D_incoming.php              [4 refs - $_SESSION['id','first_name','last_name','user_id']]
├── D_facturas.php              [8 refs - session()->get('user_name'), $_SESSION['first_name','last_name','name']]
└── Inmueble.php                [11 refs - $_SESSION['id','name']]
                                TOTAL: 131+
```

### Controllers BACKOFFICE (prefix: B_*, backoffice_new/)

```
app/Controllers/
├── BackofficeNew/
│   └── ContractsController.php  [1 ref  - session()->get('id')]
│
└── ... (ver vistas para más referencias)
                                TOTAL: 1+ (en controllers)
```

### Controllers NO_CATEGORIZADOS / MIXTOS

```
app/Controllers/
├── ProjectController.php         [1 ref  - $_SESSION['name']]
├── PaymentPlanController.php     [2 refs - $_SESSION['name']]
├── LotController.php             [1 ref  - $_SESSION['name']]
├── ContractController.php        [1 ref  - $_SESSION['name']]
├── PagosController.php           [1 ref  - session()->get('user_name')]
└── ComisionesController.php      [0 refs en código - solo setFlashdata]
                                TOTAL: 6+
```

---

## 🎯 VISTAS AFECTADAS

### Public Views

```
app/Views/
├── cart.php                      [8 refs - $_SESSION['name','lastname','mother_last','email','dni']]
└── ...
                                TOTAL: 8+
```

### Backoffice Views

```
app/Views/backoffice_new/
├── cart.php                      [8 refs - $_SESSION['name','lastname','mother_last','email','dni']]
├── header.php                    [6 refs - $_SESSION['name','dni','active']]
├── toolbar.php                   [4 refs - $_SESSION['name','dni','email']]
└── ...
                                TOTAL: 18+
```

### Admin Views

```
app/Views/admin/
├── comisiones/list.php           [2 refs - session('success')]
├── header.php                    [0 refs - sesión solo para lectura]
├── inmueble/
│   └── contracts/contracts.php   [4 refs - $_SESSION['id','name','lastname','tipo_agente']]
└── structure.php                 [0 refs]
                                TOTAL: 6+
```

---

## 📊 MATRIX DE VARIABLES vs ARCHIVOS

```
VARIABLE             ADMIN    BACKOFFICE   PUBLIC   NO_CAT   TOTAL
================================|=================================
'id'                  21          1          0        0       22
'first_name'          68          0          0        0       68
'last_name'           68          0          0        0       68
'name'                 4          4          2        5       15
'user_name'            3          0          0        1        4
'email'                0          3          2        0        5
'dni'                  0          4          2        0        6
'lastname'             1          1          2        0        4
'mother_last'          0          2          2        0        4
'active'               0          1          0        0        1
'tipo_agente'          1          0          0        0        1
'success'              2          0          0        0        2
================================|=========== TOTAL: 200+
```

---

## 🔍 ANÁLISIS DE PATRONES

### Patrón 1: CONCATENACIÓN DE NOMBRES (70+ referencias)
Aparece principalmente en Controllers ADMIN (D_*)
```php
$session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
```
**Archivos:** D_panel, D_facturas, D_report, D_integracion_pagos, D_periodos, ... (21 archivos)

### Patrón 2: VERIFICACIÓN TERNARIA (14 referencias)
```php
$session_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
```
**Archivos:** Views (cart.php, header.php, toolbar.php)

### Patrón 3: ASIGNACIÓN DIRECTA (21 referencias)
```php
$id = $_SESSION['id'];
```
**Archivos:** D_panel, D_usuarios, D_transfer, ... (12 archivos)

### Patrón 4: ARRAY DE DATOS (15+ referencias)
```php
'session_name' => $_SESSION['name'] ?? 'Usuario'
```
**Archivos:** Controllers: ProjectController, PaymentPlanController, LotController

### Patrón 5: FALLBACK TERNARIO (7 referencias)
```php
session()->get('user_name') ?? "vendedor_sistema"
```
**Archivos:** PagosController, D_facturas

---

## 🎨 MAPA VISUAL POR MÓDULO

```
┌─────────────────────────────────────────────────────────────┐
│                    GrupoVivencia                            │
├──────────────────┬──────────────────┬──────────────────────┤
│   ADMIN          │   BACKOFFICE     │   PUBLIC/MISC        │
│   (D_*)          │   (B_* + new/)   │                      │
│                  │                  │                      │
│  131+ refs       │  30 refs         │  12 refs             │
│  22 archivos     │  8 archivos      │  5 archivos          │
│                  │                  │                      │
│ PRIMARY DATA:    │ PRIMARY DATA:    │ PRIMARY DATA:        │
│ • first_name     │ • name           │ • name               │
│ • last_name      │ • dni            │ • email              │
│ • id             │ • email          │ • dni                │
│ • user_name      │ • active         │                      │
│ • name           │ • id             │ VIEWS:               │
│                  │                  │ • cart.php           │
│ LOCATIONS:       │ VIEWS:           │ • header.php         │
│ • Controllers    │ • header.php     │ • toolbar.php        │
│ • Admin contracts│ • toolbar.php    │                      │
│                  │ • cart.php       │ CONTROLLERS:         │
│                  │                  │ • ProjectController  │
│                  │                  │ • PagosController    │
│                  |                  │ • LotController      │
└──────────────────┴──────────────────┴──────────────────────┘
```

---

## ✅ CHECKLIST DE ACTUALIZACIÓN

### FASE 1: Controllers ADMIN (D_*) - 21 archivos
- [ ] D_clasificacion.php (3 refs: session()->get('id'))
- [ ] D_usuarios.php (4 refs)
- [ ] D_transfer.php (3 refs)
- [ ] D_ticket.php (3 refs)
- [ ] D_supplier.php (3 refs)
- [ ] D_sugerencias.php (1 ref)
- [ ] D_report.php (8 refs)
- [ ] D_recarga.php (8 refs)
- [ ] D_rangos.php (6 refs)
- [ ] D_points.php (4 refs)
- [ ] D_periodos.php (3 refs)
- [ ] D_panel.php (14 refs)
- [ ] D_pago_tienda.php (8 refs)
- [ ] D_pagos.php (4 refs)
- [ ] D_outgoing.php (4 refs)
- [ ] D_nueva_venta.php (7 refs)
- [ ] D_kyc.php (4 refs)
- [ ] D_kit_afiliacion.php (4 refs)
- [ ] D_kardex.php (4 refs)
- [ ] D_integracion_pagos.php (12 refs)
- [ ] D_incoming.php (4 refs)
- [ ] D_facturas.php (8 refs)
- [ ] Inmueble.php (11 refs)

### FASE 2: Controllers BACKOFFICE - 3 archivos
- [ ] BackofficeNew/ContractsController.php (1 ref)
- [ ] Otros B_* controllers (0 refs encontradas en código)
- [ ] PagosController.php (1 ref: session()->get('user_name'))

### FASE 3: Controllers NO_CATEGORIZADOS - 4 archivos
- [ ] ProjectController.php
- [ ] PaymentPlanController.php
- [ ] LotController.php
- [ ] ContractController.php

### FASE 4: Vistas ADMIN - 3 archivos
- [ ] admin/comisiones/list.php (session('success') - 2 refs)
- [ ] admin/inmueble/contracts/contracts.php (4 refs)
- [ ] admin/header.php (lectura únicamente)

### FASE 5: Vistas BACKOFFICE - 3 archivos  
- [ ] backoffice_new/cart.php (8 refs)
- [ ] backoffice_new/header.php (6 refs)
- [ ] backoffice_new/toolbar.php (4 refs)

### FASE 6: Vistas PUBLIC - 1 archivo
- [ ] cart.php (8 refs)

---

## 📈 IMPACTO POR CAMBIO

### Cambios requeridos por patrón:

**Patrón 1: Concatenación (70 refs)**
```
De: $session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
A:  $session_name = $_SESSION['admin_first_name'] . " " . $_SESSION['admin_last_name'];
```

**Patrón 2: ID directo (21 refs)**
```
De: $id = $_SESSION['id'];
A:  $id = $_SESSION['admin_id'];
```

**Patrón 3: session()->get() (7 refs)**
```
De: session()->get('id')
A:  session()->get('admin_id')
```

**Patrón 4: session()->get('user_name') (3 refs)**
```
De: session()->get('user_name')
A:  session()->get('admin_user_name')
```

**Patrón 5: Views - $_SESSION['name'] (4 refs - BACKOFFICE)**
```
De: $_SESSION['name']
A:  $_SESSION['client_name']
```

---

## 🔗 DEPENDENCIAS CRUZADAS

**Archivos que necesitan sincronización especial:**

1. **D_panel.php** - Múltiples referencias, 14+ líneas
2. **D_facturas.php** - Mix de session()->get() y $_SESSION[]
3. **D_integracion_pagos.php** - 12 referencias al patrón concatenación
4. **admin/inmueble/contracts/contracts.php** - Verifica tipo_agente y usuarios
5. **backoffice_new/cart.php + backoffice_new/header.php** - Debe ser consistente

---

## 🚀 ORDEN RECOMENDADO DE ACTUALIZACIÓN

1. Controllers ADMIN - empezar por D_panel.php, D_integracion_pagos.php (más referencias)
2. Views ADMIN - admin/contracts (contiene lógica de revisión)
3. Views BACKOFFICE - cart.php, header.php (múltiples referencias)
4. Controllers BACKOFFICE - ContractsController
5. Controllers NO_CAT - revisar contexto de cada uno
6. Views PUBLIC - cart.php

---

## 🔐 VALIDACIÓN

Después de cambios, ejecutar:
```bash
# Verificar que no hay referencias antiguas
grep -r "\$_SESSION\['id'\]" app/Controllers/ app/Views/
grep -r "session()->get('id')" app/Controllers/

# Buscar nuevas referencias
grep -r "\$_SESSION\['admin_id'\]" app/Controllers/
grep -r "session()->get('admin_id')" app/Controllers/
```

