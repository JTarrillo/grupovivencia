# Análisis de Estructura del Admin - Grupo Vivencia

## 1. ESTRUCTURA DE BASE DE DATOS

### 1.1 Tabla `users` (Usuarios/Administradores)

```sql
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `type` varchar(4) NOT NULL DEFAULT 'user',
  `privilage` enum('1','2','3','4') DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### Campos clave:

- **id**: Identificador único (bigint)
- **name, lastname**: Nombre y apellido
- **dni**: Documento de identidad
- **avatar**: Archivo de foto de perfil
- **type**: Tipo de usuario (por defecto 'user')
- **privilage**: Nivel de privilegio (ENUM: '1', '2', '3', '4')
  - **1**: Control Básico
  - **2**: Control Medio
  - **3**: Control Total (Administrador)
  - **4**: Superadministrador
- **active**: Usuarios activos/inactivos (0=inactivo, 1=activo)
- **email**: Correo electrónico (único)
- **password**: Contraseña hasheada con bcrypt ($2y$10$...)
- **timestamps**: Auditoría de creación/actualización

### 1.2 Tabla `customers` (Clientes/Usuarios Regulares)

La tabla `customers` es separada de `users` y contiene:

- Datos de clientes del sistema
- Un usuario puede ser tanto admin (en tabla `users`) como cliente (en tabla `customers`)
- Se diferencia por el campo `email` que permite identificar el tipo de usuario

---

## 2. SISTEMA DE AUTENTICACIÓN Y CONTROL DE ACCESO

### 2.1 Flujo de Autenticación

**Archivo**: [B_admin.php](c:\xampp\htdocs\grupovivencia\app\Controllers\B_admin.php)

#### Método: `login_admin()`

```php
public function login_admin()
{
    // 1. Obtiene credenciales del request
    $email = $request->getPostGet('email');
    $password = $request->getPostGet('password');

    // 2. Busca usuario en tabla `users` por email
    $user = new UsersModel();
    $res = $user->get_data_by_email($email);

    // 3. Verifica contraseña con password_verify() (bcrypt)
    $authenticatePassword = password_verify($password, $res->password);

    // 4. Si es válido, crea sesión con datos del usuario
    $ses_data = [
        'id'           => $res->id,
        'name'         => $res->name,
        'lastname'     => $res->lastname,
        'email'        => $res->email,
        'dni'          => $res->dni,
        'privilegio'   => $res->privilegio ?? ($res->privilage ?? 'admin'),
        'active'       => $res->active,
        'isLoggedIn'   => TRUE,
        'api_access_token' => $accessToken,
        'api_token_type'   => $tokenType
    ];
    $session->set($ses_data);
}
```

### 2.2 Rutas Protegidas

**Archivo**: [Routes.php](c:\xampp\htdocs\grupovivencia\app\Config\Routes.php)

Todas las rutas del dashboard usan el filtro `authGuard`:

```php
$routes->get('/dashboard/panel', 'D_panel::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/usuarios', 'D_usuarios::index', ['filter' => 'authGuard']);
$routes->post('/dashboard/usuarios/validate', 'D_usuarios::validacion', ['filter' => 'authGuard']);
```

El filtro `authGuard` verifica:

- Si el usuario está logueado (`$session->get('isLoggedIn')`)
- Si tiene una sesión activa con datos válidos
- Redirige a login si no cumple condiciones

---

## 3. ESTRUCTURA MVC

### 3.1 Controllers (Controladores)

#### Controladores principales del Admin:

| Controlador        | Ruta                              | Función                                       |
| ------------------ | --------------------------------- | --------------------------------------------- |
| **B_admin.php**    | `/app/Controllers/B_admin.php`    | Autenticación y funciones generales del admin |
| **D_usuarios.php** | `/app/Controllers/D_usuarios.php` | Gestión de usuarios administrativos           |
| **D_panel.php**    | `/app/Controllers/D_panel.php`    | Panel principal del dashboard                 |
| **D_clientes.php** | `/app/Controllers/D_clientes.php` | Gestión de clientes                           |
| **D_rangos.php**   | `/app/Controllers/D_rangos.php`   | Gestión de rangos                             |
| **D_periodos.php** | `/app/Controllers/D_periodos.php` | Gestión de períodos                           |
| **D_pagos.php**    | `/app/Controllers/D_pagos.php`    | Gestión de pagos                              |
| **D_puntos.php**   | `/app/Controllers/D_puntos.php`   | Gestión de puntos                             |
| **D_facturas.php** | `/app/Controllers/D_facturas.php` | Gestión de facturas                           |
| **D_compras.php**  | `/app/Controllers/D_compras.php`  | Gestión de compras                            |
| **D_gastos.php**   | `/app/Controllers/D_gastos.php`   | Gestión de gastos                             |
| **D_ventas.php**   | `/app/Controllers/D_ventas.php`   | Gestión de ventas                             |
| **D_ticket.php**   | `/app/Controllers/D_ticket.php`   | Sistema de tickets/soporte                    |

#### Métodos típicos en controladores:

```php
class D_usuarios extends BaseController {
    // Listar todos los usuarios
    public function index() {}

    // Cargar formulario para crear/editar usuario
    public function load($id = false) {}

    // Validar datos y guardar usuario
    public function validacion() {}
}
```

### 3.2 Models (Modelos)

**Archivo base**: [UsersModel.php](c:\xampp\htdocs\grupovivencia\app\Models\UsersModel.php)

```php
class UsersModel extends Model {
    public $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'lastname', 'phone', 'dni', 'avatar',
        'type', 'active', 'email', 'privilage', 'password',
        'created_at', 'updated_at'
    ];

    // Métodos personalizados
    public function get_data_by_email($email) {}
    public function get_all() {}
    public function get_all_by_id($id) {}
    public function get_search_row($data) {}
}
```

**Otros modelos importantes**:

- `CustomerModel`: Datos de clientes
- `RangesModel`: Rangos del sistema
- `PeriodModel`: Períodos del negocio
- `PaymentPlanModel`: Planes de pago
- `InvoicesModel`: Facturas

### 3.3 Views (Vistas)

**Ubicación**: `/app/Views/admin/`

#### Estructura de views:

```
admin/
├─ head.php                 # Header HTML y CSS
├─ header.php              # Barra de navegación y sidebar
├─ footer.php              # Footer
├─ usuarios/
│  ├─ list.php             # Listado de usuarios
│  └─ load.php             # Formulario crear/editar usuario
├─ clientes/
│  ├─ list.php
│  └─ load.php
├─ rangos/
│  ├─ list.php
│  └─ load.php
├─ periodos/
│  ├─ list.php
│  └─ load.php
├─ pagos/
│  ├─ list.php
│  └─ load.php
├─ facturas/
│  ├─ list.php
│  └─ load.php
└─ [otros módulos]/
```

---

## 4. SISTEMA DE MENÚ Y PRIVILEGIOS

### 4.1 Control de Menú por Privilegios

**Archivo**: [header.php](c:\xampp\htdocs\grupovivencia\app\Views\admin\header.php)

#### Verificación de privilegios:

```php
$session_privilege = $session->get('privilegio');

// Diferencia entre admin y otros usuarios
if ($session_privilege === 'admin' ||
    $session_privilege === 'Administrador' ||
    $session_privilege === 'superadmin') {
    // Cargar datos del admin desde tabla `users`
    $full_name = trim($session_name . ' ' . $session_lastname);
    $dni = $session_dni;

    echo "<script>console.log('SIDEBAR/HEADER ADMIN:', {...});</script>";
} else {
    // Cargar datos del cliente desde tabla `customers`
    $CustomerModel = new \App\Models\CustomerModel();
    $customer = $CustomerModel->where('email', $session_email)->first();
}
```

### 4.2 Estructura de Menú Dinámico

El menú se genera basándose en la ruta actual (`uri_string()`):

```php
$url = explode("/", uri_string());
$nav = $url[1]; // Extrae el módulo actual (ej: "usuarios", "clientes")

switch ($nav) {
    case "usuarios":
        $mantenimientos_style = "active pcoded-trigger";
        $usuarios_color = "active_nav";  // Marca como activo
        break;
    case "clientes":
        $mantenimientos_style = "active pcoded-trigger";
        $clientes_color = "active_nav";
        break;
    case "rangos":
        $mantenimientos_style = "active pcoded-trigger";
        $rangos_color = "active_nav";
        break;
    // ... más casos
}
```

### 4.3 Elementos del Menú (Sidebar)

Los elementos visibles incluyen:

```php
// Panel principal
<li class="nav-item">
    <a href="/dashboard/inmueble" class="nav-link">
        <i class="feather icon-home"></i> Panel
    </a>
</li>

// Estructura de red
<li class="nav-item">
    <a href="/dashboard/estructura" class="nav-link">
        <i class="feather icon-share-2"></i> Estructura
    </a>
</li>

// Nuevo socio
<li class="nav-item">
    <a href="/dashboard/nuevo_socio" class="nav-link">
        <i class="feather icon-user-plus"></i> Nuevo Socio
    </a>
</li>

// Ventas
<li class="nav-item">
    <a href="/dashboard/ventas" class="nav-link">
        <i class="feather icon-shopping-cart"></i> Ventas
    </a>
</li>

// Clientes
<li class="nav-item">
    <a href="/dashboard/clientes" class="nav-link">
        <i class="fa fa-users"></i> Clientes
    </a>
</li>

// Múltiples submúes para Mantenimientos, Kardex, Reportes, etc.
```

---

## 5. FLUJO DE ADMISIÓN DE USUARIO EN EL ADMIN

### 5.1 Proceso de Login

```
1. Usuario accede a /login (Login::index)
   ↓
2. Ingresa email y contraseña
   ↓
3. POST a /dashboard/validate (B_admin::login_admin)
   ↓
4. Sistema verifica credenciales
   ├─ Busca en tabla `users` por email
   ├─ Valida contraseña con password_verify()
   ├─ Verifica si está activo (active = '1')
   └─ Si es válido:
      ↓
5. Crea sesión con datos del usuario
   ├─ id, name, lastname, email, dni
   ├─ privilage (privilegio: 1,2,3,4)
   ├─ isLoggedIn = TRUE
   └─ Tokens de API (si aplica)
   ↓
6. Redirige a /dashboard/panel (D_panel::index)
   ↓
7. Sistema valida filtro authGuard en cada ruta
```

### 5.2 Niveles de Privilegio

| Nivel | Nombre             | Descripción       | Acceso                 |
| ----- | ------------------ | ----------------- | ---------------------- |
| 1     | Control Básico     | Acceso limitado   | Módulos básicos        |
| 2     | Control Medio      | Acceso intermedio | Módulos intermedios    |
| 3     | Control Total      | Administrador     | Casi todos los módulos |
| 4     | Superadministrador | Acceso total      | Todos los módulos      |

### 5.3 Visualización de Datos de Usuario

El perfil del usuario se muestra en el sidebar:

```php
// En header.php
<div class="user-profile-info">
    <img src="<?php echo $avatar; ?>" alt="Avatar">
    <span><?php echo corta_texto($full_name, 22); ?></span>
    <?php if (!empty($dni)) { ?>
        <span><?php echo $dni; ?></span>
    <?php } ?>
</div>
```

---

## 6. GESTIÓN DE USUARIOS (Módulo Administrativo)

### 6.1 Listado de Usuarios

**Archivo**: [usuarios/list.php](c:\xampp\htdocs\grupovivencia\app\Views\admin\usuarios\list.php)

Columnas mostradas:

- ID
- Nombre (name + lastname)
- E-mail
- Privilegio (convertido a etiqueta: "Control Básico", "Control Medio", "Control Total")
- Fecha de creación
- Estado (Activo/Inactivo)
- Acciones (Editar, Eliminar)

### 6.2 Formulario de Usuario

**Archivo**: [usuarios/load.php](c:\xampp\htdocs\grupovivencia\app\Views\admin/usuarios/load.php)

Campos del formulario:

- ID (solo lectura, si es edición)
- E-mail (requerido)
- Nombres (requerido)
- Apellidos (requerido)
- Contraseña (requerido, mínimo 8 caracteres)
- Privilegios (select: 1, 2, 3, 4)
- Estado (activo/inactivo)

### 6.3 Validación de Usuario

**Archivo**: [D_usuarios.php - validacion()](c:\xampp\htdocs\grupovivencia\app\Controllers\D_usuarios.php)

Endpoint AJAX: `POST /dashboard/usuarios/validate`

```javascript
// En usuarios.js
function validate() {
  var oData = new FormData(document.forms.namedItem("form-user"));
  $.ajax({
    url: site + "dashboard/usuarios/validate",
    method: "POST",
    data: oData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      var data = JSON.parse(data);
      if (data.status == true) {
        // Redirecciona al listado
        window.location = site + "dashboard/usuarios";
      }
    },
  });
}
```

---

## 7. INFORMACIÓN TÉCNICA ADICIONAL

### 7.1 Archivos JavaScript

- **[users.js](c:\xampp\htdocs\grupovivencia\public\assets\admin\js\script\users.js)**: Funciones AJAX para usuarios
  - `edit_users(user_id)`: Carga formulario de edición
  - `new_user()`: Muestra formulario nuevo
  - `validate()`: Valida y guarda usuario
  - `eliminar(user_id)`: Elimina usuario

### 7.2 Validación en Models

En UsersModel:

```php
protected $validationRules = [
    'first_name' => 'required|alpha_numeric_space|min_length[3]',
    'last_name' => 'required|alpha_numeric_space|min_length[3]',
    'email' => 'required|valid_email|is_unique[users.email]'
];
```

### 7.3 Soft Deletes

La tabla `users` tiene soporte para soft deletes (eliminación lógica):

```php
protected $useSoftDeletes = true;
protected $deletedField = 'deleted_at';
```

Esto significa que los usuarios eliminados se marcan con una fecha en `deleted_at` en lugar de ser eliminados completamente.

---

## 8. RESUMEN ARQUITECTÓNICO

```
┌─────────────────────────────────────────────┐
│        PANEL DE ADMINISTRACIÓN              │
├─────────────────────────────────────────────┤
│                                             │
│  Routes (Routes.php) → Filtro authGuard    │
│       ↓                                     │
│  Controllers (D_*.php) → Business Logic    │
│       ↓                                     │
│  Models (UsersModel.php) → Base de Datos   │
│       ↓                                     │
│  Views (admin/*.php) → Presentación        │
│                                             │
│  Base de Datos:                            │
│  ├─ tabla: users                           │
│  ├─ tabla: customers                       │
│  └─ N tablas más para cada módulo          │
│                                             │
│  Seguridad:                                │
│  ├─ Password: bcrypt                       │
│  ├─ Sesiones: CodeIgniter 4                │
│  ├─ Privilegios: enum (1,2,3,4)            │
│  └─ Filtros: authGuard                     │
│                                             │
└─────────────────────────────────────────────┘
```

---

## 9. PUNTOS CLAVE PARA MANTENIMIENTO

1. **Tabla `users`**: Almacena admins, con privilegios en campo enum
2. **Tabla `customers`**: Almacena clientes separados
3. **Sistema de Sesión**: Usa `$session->set()` y `$session->get()`
4. **Validación**: Combinación de lado cliente (JS) y servidor (PHP/Models)
5. **Permiso**: Basado en el valor de `privilage` en la sesión
6. **Menú**: Generado dinámicamente según la ruta actual en `header.php`
7. **Rutas**: Todas protegidas con filtro `authGuard`
8. **AJAX**: Comunica con controladores mediante `$.ajax()` desde JS
