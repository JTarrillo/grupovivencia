# 🔧 PATRONES REGEX PARA BÚSQUEDA Y REEMPLAZO AUTOMATIZADO

## BÚSQUEDA: Patrones Regex para encontrar todas las referencias

### ADMIN CONTROLLERS (D\_\*) - Búsqueda

```regex
# Patrón 1: session()->get('id')
pattern: session\(\)\\s*->\\s*get\s*\(\s*['\"]id['\"]\s*\)
example matches:
  - session()->get('id')
  - session() -> get('id')
  - session()->get( 'id' )

# Patrón 2: session()->get('user_name')
pattern: session\(\)\\s*->\\s*get\s*\(\s*['\"]user_name['\"]\s*\)
example matches:
  - session()->get('user_name')
  - session()->get( 'user_name' )

# Patrón 3: $_SESSION['id']
pattern: \\$_SESSION\\s*\\[\\s*['\"]id['\"]\s*\\]
example matches:
  - $_SESSION['id']
  - $_SESSION[ 'id' ]
  - $_SESSION['id']

# Patrón 4: $_SESSION['first_name'] + $_SESSION['last_name'] (concatenación)
pattern: \\$_SESSION\\s*\\[\\s*['\"]first_name['\"]\s*\\]\\s*\\.
example matches:
  - $_SESSION['first_name'] .
  - $_SESSION[ 'first_name' ] .

# Patrón 5: $_SESSION['name']
pattern: \\$_SESSION\\s*\\[\\s*['\"]name['\"]\s*\\]
example matches:
  - $_SESSION['name']
  - $_SESSION[ 'name' ]

# Patrón 6: $_SESSION['first_name'] - Variable individual
pattern: \\$_SESSION\\s*\\[\\s*['\"]first_name['\"]\s*\\]
example matches:
  - $_SESSION['first_name']

# Patrón 7: $_SESSION['last_name'] - Variable individual
pattern: \\$_SESSION\\s*\\[\\s*['\"]last_name['\"]\s*\\]
example matches:
  - $_SESSION['last_name']

# Patrón 8: session('success') - en Vistas
pattern: session\\s*\\(\\s*['\"]success['\"]\s*\\)
example matches:
  - session('success')
  - session( 'success' )
```

---

## REEMPLAZO: Transformaciones por contexto

### CONTEXTO: ADMIN (Controllers D\__, admin/_)

```
ANTES                                    DESPUÉS
════════════════════════════════════════════════════════════════

session()->get('id')                 →   session()->get('admin_id')
session()->get('user_name')          →   session()->get('admin_user_name')
session()->get('name')               →   session()->get('admin_name')
session()->get('email')              →   session()->get('admin_email')
session()->get('first_name')         →   session()->get('admin_first_name')
session()->get('last_name')          →   session()->get('admin_last_name')

$_SESSION['id']                      →   $_SESSION['admin_id']
$_SESSION['user_name']               →   $_SESSION['admin_user_name']
$_SESSION['name']                    →   $_SESSION['admin_name']
$_SESSION['email']                   →   $_SESSION['admin_email']
$_SESSION['first_name']              →   $_SESSION['admin_first_name']
$_SESSION['last_name']               →   $_SESSION['admin_last_name']
$_SESSION['dni']                     →   $_SESSION['admin_dni']
$_SESSION['lastname']                →   $_SESSION['admin_lastname']
$_SESSION['mother_last']             →   $_SESSION['admin_mother_last']
$_SESSION['active']                  →   $_SESSION['admin_active']
$_SESSION['tipo_agente']             →   $_SESSION['admin_tipo_agente']

# Concatenación especial
$_SESSION['first_name'] . " " . $_SESSION['last_name']
    →
$_SESSION['admin_first_name'] . " " . $_SESSION['admin_last_name']
```

### CONTEXTO: BACKOFFICE (Controllers backoffice*new/\*, B*_, Views backoffice_new/_)

```
ANTES                                    DESPUÉS
════════════════════════════════════════════════════════════════

session()->get('id')                 →   session()->get('client_id')
session()->get('user_name')          →   session()->get('client_user_name')
session()->get('name')               →   session()->get('client_name')
session()->get('email')              →   session()->get('client_email')
session()->get('first_name')         →   session()->get('client_first_name')
session()->get('last_name')          →   session()->get('client_last_name')

$_SESSION['id']                      →   $_SESSION['client_id']
$_SESSION['user_name']               →   $_SESSION['client_user_name']
$_SESSION['name']                    →   $_SESSION['client_name']
$_SESSION['email']                   →   $_SESSION['client_email']
$_SESSION['first_name']              →   $_SESSION['client_first_name']
$_SESSION['last_name']               →   $_SESSION['client_last_name']
$_SESSION['dni']                     →   $_SESSION['client_dni']
$_SESSION['lastname']                →   $_SESSION['client_lastname']
$_SESSION['mother_last']             →   $_SESSION['client_mother_last']
$_SESSION['active']                  →   $_SESSION['client_active']
```

### CONTEXTO: PUBLIC (Views cart.php)

```
ANTES                                    DESPUÉS
════════════════════════════════════════════════════════════════

$_SESSION['id']                      →   $_SESSION['client_id']
$_SESSION['name']                    →   $_SESSION['client_name']
$_SESSION['email']                   →   $_SESSION['client_email']
$_SESSION['dni']                     →   $_SESSION['client_dni']
$_SESSION['lastname']                →   $_SESSION['client_lastname']
$_SESSION['mother_last']             →   $_SESSION['client_mother_last']
```

---

## 📋 LISTA DE REEMPLAZOS ORDENADOS POR ARCHIVO

### (Ranked by number of changes needed)

```
D_panel.php                          14 referencias
  └─ 10x: $_SESSION['first_name'] + $_SESSION['last_name']
  └─ 2x: $_SESSION['id']
  └─ 2x: isset($_SESSION['...']) checks

D_integracion_pagos.php              12 referencias
  └─ 12x: $_SESSION['first_name'] + $_SESSION['last_name']

D_facturas.php                       9 referencias
  └─ 4x: $_SESSION['first_name'] + $_SESSION['last_name']
  └─ 2x: $_SESSION['name'] (fallback)
  └─ 2x: session()->get('user_name')
  └─ 1x: isset() checks

D_report.php                         8 referencias
  └─ 8x: $_SESSION['first_name'] + $_SESSION['last_name']

D_pago_tienda.php                    8 referencias
  └─ 4x: $_SESSION['first_name'] + $_SESSION['last_name']
  └─ 4x: $_SESSION['id']

D_recarga.php                        8 referencias
  └─ 8x: $_SESSION['first_name'] + $_SESSION['last_name']

D_incoming.php                       4 referencias
  └─ 2x: $_SESSION['first_name'] + $_SESSION['last_name']
  └─ 1x: $_SESSION['id']
  └─ 1x: $_SESSION['id'] (otra ubicación)

D_usuarios.php                       4 referencias
  └─ 2x: $_SESSION['first_name'] + $_SESSION['last_name']
  └─ 1x: isset($_SESSION['id']) check
  └─ 1x: isset($_SESSION['name']) check

backoffice_new/cart.php              8 referencias (CLIENT)
  └─ name, lastname, mother_last, email, dni

backoffice_new/header.php            6 referencias (CLIENT)
  └─ $_SESSION['name'], $_SESSION['dni'], $_SESSION['active']

admin/inmueble/contracts.php         4 referencias (ADMIN)
  └─ $_SESSION['id'], $_SESSION['name'], $_SESSION['lastname']
  └─ $_SESSION['tipo_agente']

cart.php (public)                    8 referencias (CLIENT)
  └─ name, lastname, mother_last, email, dni
```

---

## ⚙️ SCRIPT AUXILIAR REGEX (VS Code)

### Búsqueda y Reemplazo Masivo en VS Code

#### 1. Encontrar todas las referencias (búsqueda global)

**En VS Code - Ctrl+H (Find & Replace)**

```
Find: \$_SESSION\['(?:id|user_name|name|email|first_name|last_name|dni|lastname|mother_last)'\]
Replace: $[ERROR - SPECIFY CONTEXT]

Find: session\(\)->get\('(?:id|user_name|name|email|first_name|last_name|dni|lastname|mother_last)'\)
Replace: session()->get('[ERROR - SPECIFY CONTEXT]')
```

#### 2. Búsquedas específicas por archivo

**Controllers ADMIN - D_clasificacion.php (3 refs)**

```
Find: session\(\)->get\('id'\)
Replace: session()->get('admin_id')
```

**Controllers ADMIN - Concatenación pattern**

```
Find: \$_SESSION\['first_name'\]\s*\.\s*"\s"\s*\.\s*\$_SESSION\['last_name'\]
Replace: $_SESSION['admin_first_name'] . " " . $_SESSION['admin_last_name']
```

**Controllers ADMIN - ID directo**

```
Find: \$_SESSION\['id'\]
Replace: $_SESSION['admin_id']
```

**Views BACKOFFICE - name pattern**

```
Find: isset\(\$_SESSION\['name'\]\)\s*\?\s*\$_SESSION\['name'\]\s*:\s*''
Replace: isset($_SESSION['client_name']) ? $_SESSION['client_name'] : ''
```

---

## 🔍 COMANDOS CLI para VALIDACIÓN

```bash
# 1. Contar referencias antes del cambio
grep -r "session()->get('id')" app/Controllers/ | wc -l
grep -r "\$_SESSION\['id'\]" app/Controllers/ | wc -l
grep -r "\$_SESSION\['first_name'\]" app/Controllers/ | wc -l

# 2. Después de actualización - verificar nuevos prefijos
grep -r "session()->get('admin_id')" app/Controllers/ | wc -l
grep -r "\$_SESSION\['admin_id'\]" app/Controllers/ | wc -l
grep -r "\$_SESSION\['client_id'\]" app/Views/ | wc -l

# 3. Buscar referencias faltantes (debería estar vacío)
grep -r "session()->get('id')" app/Controllers/ app/Views/
grep -r "\$_SESSION\['id'\]" app/Controllers/D_*.php

# 4. Listar todos los archivos con referencias
grep -l "\$_SESSION\['id'\]" app/Controllers/*.php | sort
grep -l "\$_SESSION\['first_name'\]" app/Controllers/*.php | sort
```

---

## ✅ VALIDACIÓN POST-CAMBIOS

### Verificar integridad:

```regex
# Estas búsquedas DEBEN tener 0 resultados después de actualizar
pattern: \$_SESSION\['(?!admin_|client_)(?:id|user_name|name|email|first_name|last_name|dni|lastname|mother_last)'\]
pattern: session\(\)->get\('(?!admin_|client_)(?:id|user_name|name|email|first_name|last_name|dni|lastname|mother_last)'\)
```

### Estas búsquedas deben tener resultados:

```regex
# ADMIN prefixes
pattern: \$_SESSION\['admin_(?:id|user_name|name|email|first_name|last_name|dni)'"\]
pattern: session\(\)->get\('admin_(?:id|user_name|name|email|first_name|last_name)'\)

# CLIENT prefixes
pattern: \$_SESSION\['client_(?:id|user_name|name|email|first_name|last_name|dni|lastname)'"\]
pattern: session\(\)->get\('client_(?:id|user_name|name|email|first_name|last_name)'\)
```

---

## 🎯 PRUEBAS FUNCIONALES RECOMENDADAS

1. **Login Admin** - Usar D_clasificacion.php con nuevo prefijo admin_id
2. **Admin Panel** - Verificar D_panel.php con concatenación de admin_first_name/admin_last_name
3. **Backoffice Contracts** - Verificar ContractsController con client_id
4. **Carrito de compras** - Verificar views con client_name, client_dni, etc.
5. **Reportes** - D_report.php debe mostrar nombres correctamente
