# 📋 BÚSQUEDA EXHAUSTIVA DE VARIABLES DE SESIÓN

**Fecha:** 2026-04-08  
**Objetivo:** Identificar todas las referencias a `session()->get()` y `$_SESSION[]` para migrar a prefijos `admin_` y `client_`

---

## 🔍 RESUMEN EJECUTIVO

- **Total de Referencias Encontradas:** 150+
- **Archivos Afectados:** 70+
- **Patrón Dominante:** `$_SESSION['id']`, `$_SESSION['first_name']`, `$_SESSION['last_name']`
- **Controllers:** ~100 referencias
- **Views:** ~50 referencias

---

## ▶️ CONTROLADORES (app/Controllers/)

### 1️⃣ session()->get('id') - 4 REFERENCIAS DIRECTAS

| Línea | Archivo                               | Contexto             | Módulo         | Código Exacto                                |
| ----- | ------------------------------------- | -------------------- | -------------- | -------------------------------------------- |
| 155   | D_clasificacion.php                   | Crear clasificación  | **ADMIN**      | `'clasificado_por' => session()->get('id'),` |
| 239   | D_clasificacion.php                   | Cargar clasificación | **ADMIN**      | `'cargado_por' => session()->get('id'),`     |
| 334   | D_clasificacion.php                   | Usuario creador      | **ADMIN**      | `'usuario_creador' => session()->get('id'),` |
| 21    | BackofficeNew/ContractsController.php | Obtener ID cliente   | **BACKOFFICE** | `$customer_id = session()->get('id');`       |

---

### 2️⃣ session()->get('user_name') - 3 REFERENCIAS

| Línea | Archivo             | Contexto         | Módulo    | Código Exacto                                                             |
| ----- | ------------------- | ---------------- | --------- | ------------------------------------------------------------------------- |
| 237   | PagosController.php | Usuario creación | NO_CAT    | `"usuario_creacion" => session()->get('user_name') ?? "vendedor_sistema"` |
| 478   | D_facturas.php      | Usuario creación | **ADMIN** | `"usuario_creacion" => session()->get('user_name') ?? "vendedor_sistema"` |
| 574   | D_facturas.php      | Usuario creación | **ADMIN** | `"usuario_creacion" => session()->get('user_name') ?? "vendedor_sistema"` |

---

### 3️⃣ $\_SESSION['id'] DIRECTO - 21+ REFERENCIAS

#### 🔐 ADMIN Controllers (D\_\*)

| Línea   | Archivo               | Contexto        | Código                                                                                   |
| ------- | --------------------- | --------------- | ---------------------------------------------------------------------------------------- |
| 21      | **D_usuarios.php**    | Obtener ID      | `$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;`                                 |
| 69      | **D_transfer.php**    | Transfer        | `$id = $_SESSION['id'];`                                                                 |
| 48      | **D_supplier.php**    | Proveedor       | `$id = $_SESSION['id'];`                                                                 |
| 21      | **D_panel.php**       | Panel           | `$id = $_SESSION['id'];`                                                                 |
| 274-275 | **D_panel.php**       | Obtener cliente | `isset($_SESSION['id'])` + `$obj_customer = $Customer->get_data_by_id($_SESSION['id']);` |
| 414     | **D_panel.php**       | Panel           | `$id = $_SESSION['id'];`                                                                 |
| 59      | **D_periodos.php**    | Periodos        | `$id = $_SESSION['id'];`                                                                 |
| 92      | **D_pago_tienda.php** | Pago tienda     | `$id = $_SESSION['id'];`                                                                 |
| 100     | **D_outgoing.php**    | Egreso          | `$id = $_SESSION['id'];`                                                                 |
| 105     | **D_incoming.php**    | Ingreso         | `$id = $_SESSION['id'];`                                                                 |
| 226     | **D_incoming.php**    | Ingreso         | `'user_id' => $_SESSION['id'],`                                                          |
| 2336    | **Inmueble.php**      | Inmueble        | `$patrocinadorId = $this->request->getPost('sponsor_id') ?? ($_SESSION['id'] ?? null);`  |

---

### 4️⃣ $\_SESSION['first_name'] + $\_SESSION['last_name'] - 70+ REFERENCIAS

**⚠️ PATRÓN MÁS COMÚN EN ADMIN CONTROLLERS:**

```php
$session_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
```

#### Controllers con este patrón:

| Archivo                 | Líneas                           | Módulo |
| ----------------------- | -------------------------------- | ------ |
| D_usuarios.php          | 23-24                            | ADMIN  |
| D_transfer.php          | 17, 36                           | ADMIN  |
| D_ticket.php            | 21, 49                           | ADMIN  |
| D_supplier.php          | 12, 27                           | ADMIN  |
| D_sugerencias.php       | 42                               | ADMIN  |
| D_report.php            | 55, 186, 332, 478                | ADMIN  |
| D_recarga.php           | 12, 27, 42, 91                   | ADMIN  |
| D_rangos.php            | 25, 55, 89                       | ADMIN  |
| D_points.php            | 23, 71                           | ADMIN  |
| D_periodos.php          | 12, 32                           | ADMIN  |
| D_panel.php             | 22, 169, 264, 357, 380, 449, 489 | ADMIN  |
| D_pago_tienda.php       | 21, 36, 145, 161                 | ADMIN  |
| D_pagos.php             | 24, 54                           | ADMIN  |
| D_outgoing.php          | 20, 71                           | ADMIN  |
| D_nueva_venta.php       | 21, 39, 135                      | ADMIN  |
| D_kyc.php               | 12, 27                           | ADMIN  |
| D_kit_afiliacion.php    | 11, 30                           | ADMIN  |
| D_kardex.php            | 19, 75                           | ADMIN  |
| D_integracion_pagos.php | 15, 31, 129, 145, 258, 274       | ADMIN  |
| D_incoming.php          | 20, 72                           | ADMIN  |
| D_facturas.php          | 30-31, 49, 63                    | ADMIN  |

---

### 5️⃣ $\_SESSION['name'] DIRECTO - 15+ REFERENCIAS

| Línea                                    | Archivo                   | Contexto      | Módulo | Código                                             |
| ---------------------------------------- | ------------------------- | ------------- | ------ | -------------------------------------------------- |
| 26                                       | D_usuarios.php            | Fallback name | ADMIN  | `$session_name = $_SESSION['name'];`               |
| 171                                      | D_panel.php               | Fallback name | ADMIN  | `$session_name = $_SESSION['name'];`               |
| 266                                      | D_panel.php               | Fallback name | ADMIN  | `$session_name = $_SESSION['name'];`               |
| 33                                       | D_facturas.php            | Fallback name | ADMIN  | `$session_name = $_SESSION['name'];`               |
| 106                                      | ProjectController.php     | Session name  | NO_CAT | `'session_name' => $_SESSION['name'] ?? 'Usuario'` |
| 24                                       | PaymentPlanController.php | Session name  | NO_CAT | `'session_name' => $_SESSION['name'] ?? 'Usuario'` |
| 111                                      | PaymentPlanController.php | Session name  | NO_CAT | `'session_name' => $_SESSION['name'] ?? 'Usuario'` |
| 156                                      | LotController.php         | Session name  | NO_CAT | `'session_name' => $_SESSION['name'] ?? 'Usuario'` |
| 30                                       | ContractController.php    | Session name  | NO_CAT | `'session_name' => $_SESSION['name'] ?? 'Usuario'` |
| 1340, 1401, 1515, 1621, 1787, 1908, 1922 | Inmueble.php              | Multiple uses | NO_CAT | `$_SESSION['name']`                                |

---

### 6️⃣ Otras variables $\_SESSION en Controllers

| Variable                   | Línea | Archivo                   | Contador |
| -------------------------- | ----- | ------------------------- | -------- |
| `$_SESSION['active']`      | 249   | backoffice_new/header.php | 1        |
| `$_SESSION['tipo_agente']` | 669   | admin/contracts           | 1        |

---

## ▶️ VISTAS (app/Views/)

### 1️⃣ session('success') - 2 REFERENCIAS

| Línea | Archivo                   | Contexto   | Código                               |
| ----- | ------------------------- | ---------- | ------------------------------------ |
| 278   | admin/comisiones/list.php | Validación | `<?php if (session('success')): ?>`  |
| 283   | admin/comisiones/list.php | Mostrar    | `text: '<?= session('success') ?>',` |

---

### 2️⃣ $\_SESSION['name'] - 4 REFERENCIAS

| Línea | Archivo                    | Contexto | Código                                                             |
| ----- | -------------------------- | -------- | ------------------------------------------------------------------ |
| 131   | cart.php                   | Carrito  | `$nombre = isset($_SESSION['name']) ? $_SESSION['name'] : '';`     |
| 131   | backoffice_new/cart.php    | Carrito  | `$nombre = isset($_SESSION['name']) ? $_SESSION['name'] : '';`     |
| 247   | backoffice_new/header.php  | Header   | `<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>` |
| 22    | backoffice_new/toolbar.php | Toolbar  | `<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>` |

---

### 3️⃣ $\_SESSION['lastname'] - 4 REFERENCIAS

| Línea | Archivo                                | Contexto  | Código                                                                           |
| ----- | -------------------------------------- | --------- | -------------------------------------------------------------------------------- |
| 132   | cart.php                               | Carrito   | `$apellido_paterno = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';` |
| 132   | backoffice_new/cart.php                | Carrito   | `$apellido_paterno = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';` |
| 678   | admin/inmueble/contracts/contracts.php | Contratos | `value="<?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?>"`                 |
| 22    | backoffice_new/toolbar.php             | Toolbar   | (implícito en nombre)                                                            |

---

### 4️⃣ $\_SESSION['mother_last'] - 2 REFERENCIAS

| Línea | Archivo                 | Contexto | Código                                                                                 |
| ----- | ----------------------- | -------- | -------------------------------------------------------------------------------------- |
| 133   | cart.php                | Carrito  | `$apellido_materno = isset($_SESSION['mother_last']) ? $_SESSION['mother_last'] : '';` |
| 133   | backoffice_new/cart.php | Carrito  | `$apellido_materno = isset($_SESSION['mother_last']) ? $_SESSION['mother_last'] : '';` |

---

### 5️⃣ $\_SESSION['email'] - 3 REFERENCIAS

| Línea | Archivo                    | Contexto | Código                                                          |
| ----- | -------------------------- | -------- | --------------------------------------------------------------- |
| 135   | cart.php                   | Carrito  | `$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';` |
| 135   | backoffice_new/cart.php    | Carrito  | `$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';` |
| 22    | backoffice_new/toolbar.php | Toolbar  | (implícito)                                                     |

---

### 6️⃣ $\_SESSION['dni'] - 4 REFERENCIAS

| Línea | Archivo                    | Contexto | Código                                                           |
| ----- | -------------------------- | -------- | ---------------------------------------------------------------- |
| 134   | cart.php                   | Carrito  | `$dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : '';`        |
| 134   | backoffice_new/cart.php    | Carrito  | `$dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : '';`        |
| 258   | backoffice_new/header.php  | Header   | `<?php echo isset($_SESSION['dni']) ? $_SESSION['dni'] : ''; ?>` |
| 22    | backoffice_new/toolbar.php | Toolbar  | `<?php echo isset($_SESSION['dni']) ? $_SESSION['dni'] : ''; ?>` |

---

### 7️⃣ $\_SESSION['id'] - 2 REFERENCIAS EN VISTAS

| Línea | Archivo                                | Contexto          | Código                                                                                    |
| ----- | -------------------------------------- | ----------------- | ----------------------------------------------------------------------------------------- |
| 670   | admin/inmueble/contracts/contracts.php | Verificar sponsor | `$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;`                              |
| 669   | admin/inmueble/contracts/contracts.php | Verificar tipo    | `$isSponsor = isset($_SESSION['tipo_agente']) && $_SESSION['tipo_agente'] === 'sponsor';` |

---

### 8️⃣ $\_SESSION['tipo_agente'] - 1 REFERENCIA

| Línea | Archivo                                | Contexto          | Código                                                                      |
| ----- | -------------------------------------- | ----------------- | --------------------------------------------------------------------------- |
| 669   | admin/inmueble/contracts/contracts.php | Verificar sponsor | `isset($_SESSION['tipo_agente']) && $_SESSION['tipo_agente'] === 'sponsor'` |

---

## 📊 TABLA RESUMIDA - CONTEOS POR VARIABLE

| Variable                   | Método de Acceso | Total | Tipos                                                                                                                           |
| -------------------------- | ---------------- | ----- | ------------------------------------------------------------------------------------------------------------------------------- |
| `id`                       | session()->get() | 4     | D_clasificacion(3), BackofficeNew/Contracts                                                                                     |
| `id`                       | $\_SESSION[]     | 13    | D_usuarios, D_transfer, D_supplier, D_panel(4), D_periodos, D_pago_tienda, D_outgoing, D_incoming(2), Inmueble, admin/contracts |
| `user_name`                | session()->get() | 3     | PagosController, D_facturas(2)                                                                                                  |
| `first_name` + `last_name` | $\_SESSION[]     | 70+   | 21 archivos D\_\*                                                                                                               |
| `name`                     | $\_SESSION[]     | 19    | Views + Controllers                                                                                                             |
| `lastname`                 | $\_SESSION[]     | 4     | Views principalmente                                                                                                            |
| `mother_last`              | $\_SESSION[]     | 2     | cart.php, backoffice_new/cart.php                                                                                               |
| `email`                    | $\_SESSION[]     | 3     | Views                                                                                                                           |
| `dni`                      | $\_SESSION[]     | 4+    | Views                                                                                                                           |
| `active`                   | $\_SESSION[]     | 1     | backoffice_new/header.php                                                                                                       |
| `tipo_agente`              | $\_SESSION[]     | 1     | admin/contracts                                                                                                                 |
| `success`                  | session()        | 2     | admin/comisiones                                                                                                                |

---

## 🎯 ESTRATEGIA DE MIGRACIÓN RECOMENDADA

### SUSTITUCIONES NECESARIAS:

```
ADMIN (controllers D_*):
  $_SESSION['id']                  → $_SESSION['admin_id']
  $_SESSION['first_name']          → $_SESSION['admin_first_name']
  $_SESSION['last_name']           → $_SESSION['admin_last_name']
  $_SESSION['name']                → $_SESSION['admin_name']
  session()->get('id')             → session()->get('admin_id')
  session()->get('user_name')      → session()->get('admin_user_name')

CLIENT/BACKOFFICE (controllers B_*, backoffice_new/):
  $_SESSION['id']                  → $_SESSION['client_id']
  $_SESSION['first_name']          → $_SESSION['client_first_name']
  $_SESSION['last_name']           → $_SESSION['client_last_name']
  $_SESSION['name']                → $_SESSION['client_name']
  $_SESSION['email']               → $_SESSION['client_email']
  $_SESSION['dni']                 → $_SESSION['client_dni']
  $_SESSION['lastname']            → $_SESSION['client_lastname']
  $_SESSION['mother_last']         → $_SESSION['client_mother_last']
  $_SESSION['active']              → $_SESSION['client_active']
```

---

## 🔗 REFERENCIAS COMENTADAS EN CÓDIGO

**D_nueva_venta.php:334** (comentada, pero nota por migrar)

```php
//   $this->message($_SESSION['name'], $_SESSION['email'], $price, $qty, $membership_id, $details, $res['store_id']);
```

---

## ✅ CONCLUSIONES

1. **Controladores ADMIN (D\_\*):** Mayoría de usos están aquí (80+ referencias)
2. **Controladores BACKOFFICE (B\_\*):** Menos referencias directas, más en vistas
3. **Vistas:** Enfocadas en mostrar datos (name, email, dni, lastname)
4. **Patrón pendiente:** Algunos controllers no categorizados (ProjectController, PaymentPlanController, etc.)
5. **Total de archivos a actualizar:** ~70 archivos
