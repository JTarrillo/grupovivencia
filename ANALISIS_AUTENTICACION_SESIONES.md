# Análisis de Autenticación y Manejo de Sesiones - GrupoVivencia

## 1. UBICACIÓN DE ARCHIVOS DE AUTENTICACIÓN/LOGIN

### Archivos Principales:

- **Login Controller (Clientes/Public)**: [`app/Controllers/Login.php`](app/Controllers/Login.php)
- **Admin Login (Dashboard)**: [`app/Controllers/B_admin.php`](app/Controllers/B_admin.php) - método `login_admin()`
- **Backoffice Home/Logout**: [`app/Controllers/B_home.php`](app/Controllers/B_home.php) - método `logout()`
- **Filtro de Autenticación**: [`app/Filters/AuthGuard.php`](app/Filters/AuthGuard.php)
- **Vistas de Login**:
  - [`app/Views/login.php`](app/Views/login.php)
  - [`app/Views/login_register.php`](app/Views/login_register.php)
- **Rutas**: [`app/Config/Routes.php`](app/Config/Routes.php)
- **Filtros Config**: [`app/Config/Filters.php`](app/Config/Filters.php)

---

## 2. CÓMO SE GUARDA EL USUARIO EN SESIÓN

### A) Login de Cliente Regular (`Login.php::login_user()`)

```php
// Variables guardadas en sesión:
$ses_data = [
    'id'        => $obj_customer->id,
    'name'      => $obj_customer->name,
    'lastname'  => $obj_customer->lastname,
    'code'      => $obj_customer->code,
    'active'    => $obj_customer->active,
    'email'     => $obj_customer->email,
    'dni'       => $obj_customer->dni,
    'isLoggedIn' => TRUE
];

// Se guarda con:
$session->set($ses_data);
```

**Tabla fuente**: `customers` (dni, password encriptado con password_verify)
**Método de validación**: `password_verify($password, $pass)`

---

### B) Login de administrador (`B_admin.php::login_admin()`)

```php
// Variables guardadas en sesión:
$ses_data = [
    'id'           => $res->id,
    'name'         => $res->name,
    'lastname'     => $res->lastname,
    'email'        => $res->email,
    'dni'          => $res->dni,
    'privilegio'   => $res->privilegio ?? ($res->privilage ?? 'admin'),
    'active'       => $res->active,
    'isLoggedIn'   => TRUE,
    // ⚠️ CRÍTICO: Tokens de API guardados en sesión
    'api_access_token' => $accessToken,
    'api_token_type'   => $tokenType
];

// Se guarda con:
$session->set($ses_data);
```

**Tabla fuente**: `users` (tabla de administradores)
**Método de validación**: `password_verify($password, $pass)`
**Consumo externo**: Hace login a API externa en: `https://apifacturacion.groupdispensersac.com/api/auth/login`

---

## 3. MÚLTIPLES MÓDULOS: ADMIN Y BACKOFFICE

### Estructura de módulos identificados:

#### 🔴 **MÓDULO ADMIN (Dashboard administrativo)**

- Prefijo de controladores: `D_` (Dashboard)
- Ruta de acceso: `/admin` y `/dashboard`
- Rutas protegidas con filtro: `['filter' => 'authGuard']`
- Ejemplos de controladores:
  - `D_panel.php` - Panel principal
  - `D_usuarios.php` - Gestión de usuarios
  - `D_clientes.php` - Gestión de clientes
  - `D_ventas.php` - Módulo de ventas
  - `D_facturas.php` - Gestión de facturas
  - `D_comisiones.php` - Comisiones
  - Más de 30 controladores especializados

#### 🔵 **MÓDULO BACKOFFICE (Para clientes/miembros)**

- Prefijo de controladores: `B_` y `BackofficeNew/`
- Ruta de acceso: `/backoffice_new`, `/backoffice`
- Rutas protegidas con filtro: `['filter' => 'authGuard']`
- Ejemplos de controladores:
  - `B_home.php` - Dashboard de backoffice
  - `B_perfil.php` - Perfil del usuario
  - `B_plan.php` - Gestión de planes
  - `B_finanzas.php` - Historial y finanzas
  - `B_contratos.php` - Gestión de contratos
  - `B_cobros.php` - Cobros/Pagos
  - `B_network.php` - Red/Estructura

#### 📋 **MÓDULO PUBLIC (Clientes nuevos)**

- Ruta: `/login`, `/registro`, `/contacto`
- Controladores: `Login.php`, `Registro.php`, `Home.php`
- **SIN protección** (acceso público)

---

## 4. VARIABLES DE SESIÓN RELATIVAS A USUARIO

### Sesión estándar de cliente/admin:

```
$_SESSION['id']              // ID del usuario (customer_id o admin_id)
$_SESSION['name']            // Nombre
$_SESSION['lastname']        // Apellido
$_SESSION['email']           // Email
$_SESSION['dni']             // Documento de identidad
$_SESSION['code']            // (Clientes) Código único
$_SESSION['active']          // Estado activo (1/0)
$_SESSION['isLoggedIn']      // Bandera de autenticación
$_SESSION['privilegio']      // (Admins) Nivel de privilegio
```

### ⚠️ Variables adicionales en Backoffice:

```
$_SESSION['api_access_token']     // Token de API (CRÍTICO)
$_SESSION['api_token_type']       // Tipo de token
```

### Funciones helper para validar sesión:

```php
// app/Helpers/global_helper.php

// Para clientes en backoffice:
get_session() {
    if (isset($_SESSION['customer'])){
        if($_SESSION['customer']['logged_customer']=="TRUE"
           && $_SESSION['customer']['status']=='1'){
            return true;
        }
    }
}

// Para usuarios CMS (admin):
get_session_cms() {
    if (isset($_SESSION['usercms'])){
        if($_SESSION['usercms']['logged_usercms']=="TRUE"
           && $_SESSION['usercms']['active']==1){
            return true;
        }
    }
}
```

---

## 5. ⚠️ LOGOUT Y DESTRUCCIÓN DE SESIÓN

### Código de Logout en `B_home.php::logout()`:

```php
public function logout()
{
    $session = session();

    // ❌ PROBLEMA: Esta línea está comentada:
    // //$session->sess_destroy();

    // Solo se reestablecen variables a vacío:
    $ses_data = [
        'id'        => '',
        'name'      => '',
        'email'     => '',
        'isLoggedIn' => FALSE
    ];

    $session->set($ses_data);
    return redirect()->to('/iniciar-sesion');
}
```

### 🔴 **VULNERABLE: NO SE DESTRUYE COMPLETAMENTE LA SESIÓN**

---

## 6. CONFIGURACIÓN DE SESIÓN COMPARTIDA

### Rutas de protección (Filters):

```php
// app/Config/Filters.php
'authGuard' => AuthGuard::class
```

### Filtro de autenticación (`AuthGuard.php`):

```php
class AuthGuard implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }
}
```

### ✅ **SESIÓN COMPARTIDA A NIVEL DE APLICACIÓN**

- **Una sola sesión PHP** se usa para todos los módulos (Admin, Backoffice, Public)
- La variable `isLoggedIn` es el verificador global
- Se aplica el mismo filtro `authGuard` para proteger todas las rutas admin/backoffice

### Rutas protegidas:

- Todas las rutas `/dashboard/*` tienen `['filter' => 'authGuard']`
- Todas las rutas `/backoffice_new/*` tienen `['filter' => 'authGuard']`
- Todas las rutas `/admin/*` tienen `['filter' => 'authGuard']` (excepto `/admin` y `/dashboard/validate`)

---

## 7. 🔴 PROBLEMAS DE SEGURIDAD IDENTIFICADOS

### A) **Logout Incompleto**

- **Ubicación**: [`B_home.php:163-171`](app/Controllers/B_home.php)
- **Problema**: La línea `$session->sess_destroy()` está comentada
- **Impacto**: La sesión PHP no se destruye realmente, solo se vacían variables
- **Riesgo**: Session hijacking, reutilización de cookie de sesión

### B) **Tokens de API en sesión**

- **Ubicación**: [`B_admin.php:135-147`](app/Controllers/B_admin.php)
- **Problema**: `api_access_token` y `api_token_type` se guardan en `$_SESSION`
- **Impacto**: Tokens sensibles quedan en archivos de sesión del servidor/cliente
- **Riesgo**: Exposición de credenciales si se compromete la sesión

### C) **Función helper deprecated/con bug**

- **Ubicación**: [`global_helper.php:533-554`](app/Helpers/global_helper.php)
- **Problema**: `get_session()` y `get_session_cms()` usan `$_SESSION` directamente en lugar de `session()`
- **Impacto**: No compatible con los datos de sesión CI4 guardados con `$session->set()`
- **Consecuencia**: Estas funciones nunca funcionarán correctamente

### D) **Acceso directo a `$_SESSION` en controladores**

- **Ubicación**: Múltiples controllers (B_calification, B_files, B_cobros, etc.)
- **Problema**: Acceden a `$_SESSION['id']` en lugar de usar `session()->get('id')`
- **Impacto**: Inconsistencia entre datos en sesión CI4 y acceso directo a `$_SESSION`

### E) **Sin CSRF en login**

- **Ubicación**: [`Routes.php:108-110`](app/Config/Routes.php)
- **Problema**: Las rutas de login POST no tienen filtro CSRF definido
- **Riesgo**: Potencial CSRF en endpoints de autenticación

### F) **Contraseña hardcodeada de API**

- **Ubicación**: [`B_admin.php:110-118`](app/Controllers/B_admin.php)
- **Problema**: Email y contraseña de API están hardcodeados en el source code

```php
'email'      => 'admin@gmail.com',
'password'   => 'Admin123!@#',
```

- **Riesgo**: Credenciales expuestas en repositorio

### G) **Validación de password vulnerable**

- **Ubicación**: [`Login.php:81-84`](app/Controllers/Login.php)
- **Problema**: La consulta SQL es directa sin prepared statements

```php
$obj_customer = $db->query("select * from customers where dni = '$dni'")->getRow();
```

- **Riesgo**: SQL Injection

---

## 8. CONFIGURACIÓN DE COOKIES COMPARTIDAS

### Sesión por defecto CI4:

- **Nombre de cookie**: Configurado en `.env` (por defecto: `PHPSESSID`)
- **Path**: `/` (disponible en toda la aplicación)
- **HttpOnly**: Típicamente activado (protege contra XSS)
- **Secure**: ❓ No se especifica en el análisis

### Estructura de compartición:

```
┌─────────────────────────────────────────┐
│         Cookie de Sesión PHP            │
│  (PHPSESSID - válida para toda app)     │
├─────────────────────────────────────────┤
│  Módulo Admin (D_*):      isLoggedIn=1  │
│                           privilegio=...│
├─────────────────────────────────────────┤
│  Módulo Backoffice (B_*): isLoggedIn=1  │
│                           id=...        │
├─────────────────────────────────────────┤
│  Módulo Frontend (Public): isLoggedIn=0 │
└─────────────────────────────────────────┘
```

**Conclusión**: Una misma cookie de sesión se usa para todos los módulos. El filtro `authGuard` es el único validador.

---

## 9. RECOMENDACIONES DE SEGURIDAD

### 🔧 Fixes Críticos:

1. **Activar destrucción completa en logout**:

   ```php
   $session->destroy();  // Descomenta y usa
   session_destroy();    // O esto para hacer más limpio
   ```

2. **Mover tokens de API a memoria/servidor** (no sesión):
   - Usar cache en servidor (Redis)
   - O regenerar tokens en cada request

3. **Usar prepared statements**:

   ```php
   $obj_customer = $db->table('customers')
       ->where('dni', $dni)
       ->get()
       ->getRow();
   ```

4. **Añadir CSRF a rutas de login**:

   ```php
   $routes->post('/iniciar-sesion/login_user', 'Login::login_user',
       ['filter' => 'csrf']);
   ```

5. **Usar variables de entorno para credenciales**:

   ```php
   'email'    => env('API_EMAIL'),
   'password' => env('API_PASSWORD'),
   ```

6. **Corregir funciones helper para usar CI4 session**:

   ```php
   function get_session_ci4() {
       return session()->get('isLoggedIn') === TRUE;
   }
   ```

7. **Usar `session()->get()` en lugar de `$_SESSION` directamente**

---

## 10. MATRIZ DE FLUJOS DE AUTENTICACIÓN

| Módulo             | Tabla       | Login Controller | Login Method    | Sesión             | Filtro      | Logout             |
| ------------------ | ----------- | ---------------- | --------------- | ------------------ | ----------- | ------------------ |
| **Public/Cliente** | `customers` | `Login.php`      | `login_user()`  | `isLoggedIn=TRUE`  | Ninguno     | N/A                |
| **Backoffice**     | `customers` | `Login.php`      | `login_user()`  | `isLoggedIn=TRUE`  | `authGuard` | `B_home::logout()` |
| **Admin**          | `users`     | `B_admin.php`    | `login_admin()` | `isLoggedIn=TRUE`  | `authGuard` | ❌ No existe       |
| **APIExternal**    | N/A         | `B_admin.php`    | (interno)       | `api_access_token` | N/A         | N/A                |

---

## 11. ARCHIVOS PROCESADOS

```
✅ app/Controllers/Login.php
✅ app/Controllers/B_admin.php
✅ app/Controllers/B_home.php
✅ app/Filters/AuthGuard.php
✅ app/Helpers/global_helper.php
✅ app/Config/Routes.php
✅ app/Config/Filters.php
✅ app/Config/App.php
✅ Múltiples B_* controllers (B_calification.php, B_files.php, etc.)
✅ Múltiples D_* controllers (Dashboard)
```

---

## Conclusión

El sistema utiliza una **arquitectura de sesión centralizada** donde:

- Una sola sesión PHP protege múltiples módulos (Admin, Backoffice, Public)
- El filtro `AuthGuard` verifica `session()->get('isLoggedIn')`
- ⚠️ **Existen problemas de seguridad significativos**, particularmente:
  - Logout incompleto
  - Tokens de API en sesión
  - SQL injection potencial
  - Credenciales hardcodeadas
  - Inconsistencia en acceso a datos de sesión

**Severidad**: 🔴 **CRÍTICA** - Requiere parches de seguridad inmediatos.
