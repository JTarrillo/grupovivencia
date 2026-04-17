# Mapeo de Rutas, Controladores y Vistas del Admin

## 1. AUTENTICACIÓN

### Rutas

```
GET  /                           Home::index
POST /dashboard/validate         B_admin::login_admin()
GET  /dashboard/panel            D_panel::index()
GET  /logout                     B_admin::logout() [si existe]
```

### Controladores

| Controlador   | Método          | Acción                         |
| ------------- | --------------- | ------------------------------ |
| `Home.php`    | `index()`       | Renderiza página de inicio     |
| `B_admin.php` | `login_admin()` | Autentica usuario, crea sesión |
| `B_admin.php` | `admin()`       | Panel administrativo           |

### Vistas

| Vista                        | Propósito                   |
| ---------------------------- | --------------------------- |
| `app/Views/login_view.php`   | Formulario de login         |
| `app/Views/admin/panel.php`  | Panel principal (si existe) |
| `app/Views/admin/head.php`   | HTML head compartido        |
| `app/Views/admin/header.php` | Navbar + sidebar compartido |
| `app/Views/admin/footer.php` | Footer compartido           |

---

## 2. MÓDULO DE USUARIOS

### Rutas

```
GET  /dashboard/usuarios                 D_usuarios::index()
GET  /dashboard/usuarios/load            D_usuarios::load()
GET  /dashboard/usuarios/load/{id}       D_usuarios::load($id)
POST /dashboard/usuarios/validate        D_usuarios::validacion()
POST /dashboard/usuarios/delete/{id}     D_usuarios::delete($id)  [si existe]
```

### Controlador: D_usuarios.php

```php
class D_usuarios extends BaseController {

    // GET /dashboard/usuarios
    public function index() {
        // 1. Obtiene sesión del usuario
        // 2. Busca todos los usuarios con UsersModel::get_all()
        // 3. Pasa a vista: admin/usuarios/list.php
        // 4. Variables: $obj_users, $session_name
    }

    // GET /dashboard/usuarios/load o /dashboard/usuarios/load/{id}
    public function load($id = false) {
        // 1. Si $id: busca usuario con UsersModel::get_all_by_id($id)
        // 2. Si no: deja $obj_users = null (nuevo usuario)
        // 3. Pasa a vista: admin/usuarios/load.php
        // 4. Variables: $obj_users, $session_name
    }

    // POST /dashboard/usuarios/validate
    public function validacion() {
        // 1. Valida que sea AJAX
        // 2. Obtiene datos POST
        // 3. Extrae: user_id, email, name, lastname, password, privilage
        // 4. Si user_id: UPDATE, si no: INSERT
        // 5. Hashea contraseña si se proporciona
        // 6. Retorna JSON {status: true/false, message: "..."}
    }

    // POST /dashboard/usuarios/delete/{id} [si existe]
    // public function delete($id) { ... }
}
```

### Modelo: UsersModel.php

```php
class UsersModel extends Model {
    protected $table = 'users';

    // public function get_all()
    // public function get_all_by_id($id)
    // public function get_data_by_email($email)
    // public function get_search_row($data)
    // Hereda: insert(), update(), delete(), find(), findAll() [de Model]
}
```

### Vistas

```
app/Views/admin/usuarios/
├─ list.php
│  ├─ Renderiza tabla con $obj_users
│  ├─ Columnas: ID, Nombre, Email, Privilegio, Fecha, Estado, Acciones
│  ├─ Botones: Editar (edit_users), Eliminar (eliminar), Nuevo (new_user)
│  └─ Script: <script src="users.js">
│
└─ load.php
   ├─ Si $obj_users: muestra datos precargados (EDIT)
   ├─ Si no: muestra vacío (CREATE)
   ├─ Campos: ID, Email, Nombres, Apellidos, Contraseña, Privilegios, Estado
   ├─ Botones: Guardar (validate), Cancelar (cancelar_users)
   └─ Form: name="form-user" onsubmit="validate();"
```

### JavaScript: users.js

```javascript
// public/assets/admin/js/script/users.js

function new_user()                // Crea nuevo usuario
function edit_users(user_id)       // Edita usuario existente
function cancelar_users()          // Cancela edición
function validate()                // Valida y guarda (AJAX)
function eliminar(user_id)         // Elimina usuario
function show_pass()               // Muestra/oculta contraseña
```

---

## 3. MÓDULO DE CLIENTES

### Rutas

```
GET  /dashboard/clientes                 D_clientes::index()
GET  /dashboard/clientes/load            D_clientes::load()
GET  /dashboard/clientes/load/{id}       D_clientes::load($id)
POST /dashboard/clientes/validate        D_clientes::validacion()
POST /dashboard/clientes/delete/{id}     D_clientes::delete($id)
```

### Controlador: D_clientes.php

```php
class D_clientes extends BaseController {
    // Estructura SIMILAR a D_usuarios
    // Pero usa CustomerModel en lugar de UsersModel
    // Vistas: app/Views/admin/clientes/
}
```

### Modelo: CustomerModel.php

```php
class CustomerModel extends Model {
    protected $table = 'customers';
    // Similar a UsersModel pero para tabla customers
}
```

---

## 4. MÓDULO DE RANGOS

### Rutas

```
GET  /dashboard/rangos                   D_rangos::index()
GET  /dashboard/rangos/load              D_rangos::load()
GET  /dashboard/rangos/load/{id}         D_rangos::load($id)
POST /dashboard/rangos/validate          D_rangos::validacion()
```

### Controlador: D_rangos.php

### Vistas

```
app/Views/admin/rangos/
├─ list.php       # Listado de rangos
└─ load.php       # Formulario crear/editar rango
```

---

## 5. MÓDULO DE PERÍODOS

### Rutas

```
GET  /dashboard/periodos                 D_periodos::index()
POST /dashboard/periodos/validate        D_periodos::validacion()
```

### Vistas

```
app/Views/admin/periodos/
└─ list.php       # Listado de períodos
```

---

## 6. MÓDULO DE PAGOS

### Rutas

```
GET  /dashboard/pagos                    D_pagos::index()
```

### Vistas

```
app/Views/admin/pagos/
└─ list.php       # Listado de pagos/usuarios
```

---

## 7. MÓDULO DE PUNTOS

### Rutas

```
GET  /dashboard/puntos                   D_puntos::index()
```

### Vistas

```
app/Views/admin/puntos/
└─ list.php       # Listado de puntos
```

---

## 8. MÓDULO DE FACTURAS

### Rutas

```
GET  /dashboard/facturas                 D_facturas::index()
GET  /dashboard/facturas/detalle/{id}    D_facturas::detalle($id)
GET  /dashboard/facturasContratos        D_facturas::facturasContratos()
```

### Vistas

```
app/Views/admin/facturas/
├─ list.php
└─ detail.php
```

---

## 9. MÓDULO DE COMPRAS

### Rutas

```
GET  /dashboard/compras                  D_compras::index()
```

### Vistas

```
app/Views/admin/compras/
└─ list.php
```

---

## 10. MÓDULO DE GASTOS

### Rutas

```
GET  /dashboard/gastos                   D_gastos::index()
```

### Vistas

```
app/Views/admin/gastos/
└─ list.php
```

---

## 11. MÓDULO DE VENTAS

### Rutas

```
GET  /dashboard/ventas                   D_ventas::index()
GET  /dashboard/nueva_venta              D_nueva_venta::index()
```

### Vistas

```
app/Views/admin/ventas/
├─ list.php
└─ sales.php
```

---

## 12. MÓDULO DE ESTRUCTURA

### Rutas

```
GET  /dashboard/estructura               D_panel::estructura()
POST /dashboard/estructura_up            D_panel::estructura_up()
GET  /dashboard/estructura/{id}          D_panel::estructura($id)
```

### Vistas

```
app/Views/admin/structure.php            # Árbol de estructura
```

---

## 13. MÓDULO DE SOPORTE (TICKETS)

### Rutas

```
GET  /dashboard/ticket                   D_ticket::index()
```

### Vistas

```
app/Views/admin/ticket/
└─ list.php
```

---

## MAPEO VISUAL - FLUJO TÍPICO CRUD

```
┌─────────────────────────────────────────────────────┐
│          MÓDULO GENÉRICO (ej: Usuarios)             │
└─────────────────────────────────────────────────────┘

                        ← GET /dashboard/usuarios ←
                        │
        ┌───────────────┴───────────────┐
        │                               │
    D_usuarios                     list.php (Vista)
        │                               │
        ├─ index()                      │
        │  ├─ UsersModel::get_all()    │
        │  └─ return view('admin/usuarios/list', ...)
        │                               │
        │   Data: $obj_users        Display: Tabla con usuarios
        │                           Actions: Editar, Eliminar, Nuevo
        │
        ├──────────────────────────────────────────┐
        │                                          │
    [Nuevo Usuario]                 [Editar Usuario]
        │                                          │
    GET /dashboard/usuarios/load        GET /dashboard/usuarios/load/{id}
        │                                          │
    ├─ load()                           ├─ load($id)
    │  ├─ $obj_users = null             │  ├─ UsersModel::get_all_by_id($id)
    │  └─ return view('admin/usuarios/load', ...)
    │                                   │  └─ return view(...)
    │                                   │
    │   load.php (Vista)               load.php (Vista)
    │   ├─ Formulario vacío             ├─ Formulario precargado
    │   └─ Campos vacíos                └─ Campos llenos con datos
    │
    │   onsubmit="validate()"           onsubmit="validate()"
    │        │                               │
    │    users.js                       users.js
    │    validate()                    validate()
    │        │                               │
    │    AJAX POST /dashboard/usuarios/validate
    │        │
    │   D_usuarios::validacion()
    │        │
    │   ├─ Obtiene: email, name, lastname, password, privilage
    │   │
    │   ├─ user_id?
    │   │   ├─ Yes: UPDATE users WHERE id = user_id
    │   │   └─ No:  INSERT INTO users (...)
    │   │
    │   ├─ Hashea contraseña: password_hash(..., PASSWORD_BCRYPT)
    │   │
    │   └─ return json_encode({status: true, message: "..."})
    │
    │   users.js (recibe respuesta)
    │   ├─ SweetAlert (mensaje éxito)
    │   └─ Redirige a /dashboard/usuarios
    │
    │   D_usuarios::index()
    │   ├─ UsersModel::get_all() [nuevo registro incluido]
    │   └─ return view('admin/usuarios/list', ...)
    │
    Tabla actualizada
```

---

## ESTRUCTURA DE CARPETAS - ADMIN

```
app/
├─ Controllers/
│  ├─ B_admin.php              # Autenticación
│  ├─ B_user.php               # Usuarios (legacy?)
│  ├─ B_contratos.php
│  ├─ D_usuarios.php           # Usuarios formales
│  ├─ D_clientes.php           # Clientes
│  ├─ D_rangos.php             # Rangos
│  ├─ D_periodos.php           # Períodos
│  ├─ D_pagos.php              # Pagos
│  ├─ D_puntos.php             # Puntos
│  ├─ D_facturas.php           # Facturas
│  ├─ D_compras.php            # Compras
│  ├─ D_gastos.php             # Gastos
│  ├─ D_ventas.php             # Ventas
│  ├─ D_panel.php              # Panel + Estructura
│  └─ D_*.php                  # [+20 más]
│
├─ Models/
│  ├─ UsersModel.php           # Tabla users
│  ├─ CustomerModel.php        # Tabla customers
│  ├─ RangesModel.php          # Tabla ranges
│  ├─ PeriodModel.php          # Tabla periods
│  ├─ PaymentPlanModel.php     # Tabla payment_plans
│  ├─ InvoicesModel.php        # Tabla invoices
│  ├─ ComprasModel.php         # Tabla compras
│  ├─ GastosModel.php          # Tabla gastos
│  └─ *.php                    # [+40 más]
│
├─ Views/
│  └─ admin/
│     ├─ head.php              # Base para todas las vistas
│     ├─ header.php            # Navbar + Sidebar dinámico
│     ├─ footer.php            # Base para footer
│     ├─ usuarios/
│     │  ├─ list.php          # Listado
│     │  └─ load.php          # Formulario
│     ├─ clientes/
│     │  ├─ list.php
│     │  └─ load.php
│     ├─ rangos/
│     │  ├─ list.php
│     │  └─ load.php
│     ├─ [otros módulos]/
│     └─ structure.php         # Estructura especial
│
└─ Config/
   └─ Routes.php               # Todas las rutas con filtro authGuard
```

---

## RESUMEN DE CONTROLADORES PRINCIPALES

| Controlador        | Responsabilidad     | Vistas Asociadas               |
| ------------------ | ------------------- | ------------------------------ |
| **B_admin.php**    | Autenticación       | login_view                     |
| **D_panel.php**    | Dashboard principal | panel                          |
| **D_usuarios.php** | CRUD usuarios       | usuarios/list, usuarios/load   |
| **D_clientes.php** | CRUD clientes       | clientes/list, clientes/load   |
| **D_rangos.php**   | CRUD rangos         | rangos/list, rangos/load       |
| **D_periodos.php** | CRUD períodos       | periodos/list                  |
| **D_pagos.php**    | Gestión pagos       | pagos/list                     |
| **D_puntos.php**   | Gestión puntos      | puntos/list                    |
| **D_facturas.php** | CRUD facturas       | facturas/list, facturas/detail |
| **D_compras.php**  | CRUD compras        | compras/list                   |
| **D_gastos.php**   | CRUD gastos         | gastos/list                    |
| **D_ventas.php**   | Gestión ventas      | ventas/list, sales             |
