# RESUMEN RÁPIDO - Estructura Admin Grupo Vivencia

## 📋 ÍNDICE RÁPIDO

| Aspecto           | Ubicación                        | Descripción                                   |
| ----------------- | -------------------------------- | --------------------------------------------- |
| **BD**            | `app/Config/rere.sql`            | Tabla `users` con campo `privilage` (1,2,3,4) |
| **Autenticación** | `app/Controllers/B_admin.php`    | Método `login_admin()` con bcrypt             |
| **Usuarios**      | `app/Controllers/D_usuarios.php` | CRUD de usuarios administrativos              |
| **Rutas**         | `app/Config/Routes.php`          | Todas protegidas con filtro `authGuard`       |
| **Menú**          | `app/Views/admin/header.php`     | Generado dinámicamente según ruta actual      |
| **Sesión**        | `$_SESSION`                      | Guarda id, name, email, privilage             |

---

## 🔐 FLUJO DE LOGIN (Secuencia)

```
1. POST /dashboard/validate
   └─ B_admin::login_admin()
      ├─ Busca usuario por email en tabla `users`
      ├─ Verifica contraseña con password_verify()
      ├─ Crea sesión con $session->set()
      └─ Retorna JSON {status: true}

2. GET /dashboard/panel
   └─ Filtro authGuard valida sesión
      ├─ Si válida → renderiza página
      └─ Si inválida → redirige a login
```

---

## 📊 ESTRUCTURA DE BD

### Tabla `users`

```
┌──────────────────────────────────────────┐
│ users                                    │
├──────────────────┬──────────────────────┤
│ id               │ BIGINT (PK)          │
│ email            │ VARCHAR(255) UNIQUE  │
│ password         │ VARCHAR(255) bcrypt  │
│ name             │ VARCHAR(50)          │
│ lastname         │ VARCHAR(50)          │
│ phone            │ VARCHAR(10)          │
│ dni              │ VARCHAR(8)           │
│ avatar           │ VARCHAR(50)          │
│ type             │ VARCHAR(4) = 'user'  │
│ privilage        │ ENUM(1,2,3,4)        │
│ active           │ ENUM(0,1) = 1        │
│ created_at       │ TIMESTAMP            │
│ updated_at       │ TIMESTAMP            │
│ deleted_at       │ TIMESTAMP (soft del) │
└──────────────────┴──────────────────────┘

Privilage Levels:
1 = Control Básico
2 = Control Medio
3 = Control Total
4 = Superadministrador
```

---

## 🎮 CONTROLADORES CLAVE

### B_admin.php

```php
├─ login_admin()         // POST /dashboard/validate
├─ admin()              // GET /dashboard
└─ contrato_pdf()       // Generar PDF
```

### D_usuarios.php

```php
├─ index()              // GET /dashboard/usuarios (Listado)
├─ load($id)            // GET /dashboard/usuarios/load/{id} (Formulario)
└─ validacion()         // POST /dashboard/usuarios/validate (Guardar)
```

### D_panel.php

```php
└─ index()              // GET /dashboard/panel (Panel principal)
```

---

## 👁️ VISTAS - ESTRUCTURA

```
app/Views/admin/
├─ head.php             // <head>, CSS, favicon
├─ header.php           // Barra nav + sidebar + menú dinámico
├─ footer.php           // Scripts + footer
├─ usuarios/
│  ├─ list.php         // Tabla de usuarios
│  └─ load.php         // Formulario crear/editar
├─ clientes/           // Similar estructura
├─ rangos/             // Similar estructura
└─ ... (otros módulos)
```

---

## 🔑 PUNTO DE ENTRADA

```
1. Usuario accede a raíz /
   └─ Login::index()
      └─ Renderiza formulario de login

2. Usuario envía credenciales
   └─ POST /dashboard/validate
      └─ B_admin::login_admin()

3. Si es válido, crea sesión y redirige
   └─ GET /dashboard/panel
      └─ D_panel::index()
         └─ Renderiza dashboard
```

---

## 🛡️ SEGURIDAD

| Aspecto                | Status | Código                                      |
| ---------------------- | :----: | ------------------------------------------- |
| Contraseñas            |   ✅   | `password_hash($password, PASSWORD_BCRYPT)` |
| Filtro Sesión          |   ✅   | `['filter' => 'authGuard']` en rutas        |
| SQL Injection          |   ✅   | QueryBuilder previene inyección             |
| CSRF                   |   ⚠️   | No configurado en formularios               |
| Rate Limiting          |   ❌   | No implementado                             |
| Validación Privilegios |   ❌   | Solo hay "logueado" o "no logueado"         |

---

## 📝 FLUJO CREAR USUARIO

```
1. Clic "Nuevo Usuario"
   │
   └─→ new_user() [JavaScript]
        └─→ Redirige a /dashboard/usuarios/load
              │
              └─→ D_usuarios::load() [Sin ID]
                   └─→ Renderiza formulario vacío

2. Completa formulario y envía
   │
   └─→ validate() [JavaScript]
        └─→ AJAX POST /dashboard/usuarios/validate
              │
              └─→ D_usuarios::validacion()
                   ├─ Valida datos
                   ├─ Hashea contraseña
                   ├─ INSERT en tabla `users`
                   └─→ Retorna JSON {status: true}

3. JavaScript recibe respuesta
   │
   └─→ Muestra alerta SweetAlert
        └─→ Redirige a /dashboard/usuarios
              │
              └─→ D_usuarios::index()
                   └─→ Nueva lista incluye el usuario creado
```

---

## 📝 FLUJO EDITAR USUARIO

```
1. Clic botón "Editar" en tabla
   │
   └─→ edit_users(id) [JavaScript]
        └─→ Redirige a /dashboard/usuarios/load/{id}
              │
              └─→ D_usuarios::load($id)
                   ├─ Busca usuario por ID
                   ├─ Obtiene datos en $obj_users
                   └─→ Renderiza formulario con datos

2. Modifica datos y envía
   │
   └─→ validate() [JavaScript]
        └─→ AJAX POST /dashboard/usuarios/validate
              │
              └─→ D_usuarios::validacion()
                   ├─ Verifica si es UPDATE (user_id presente)
                   ├─ Hashea contraseña si fue modificada
                   ├─ UPDATE en tabla `users`
                   └─→ Retorna JSON {status: true}

3. JavaScript redirige
   │
   └─→ /dashboard/usuarios (actualizado)
```

---

## 📝 FLUJO ELIMINAR USUARIO

```
1. Clic botón "Eliminar"
   │
   └─→ eliminar(id) [JavaScript]
        ├─ Muestra confirmación SweetAlert
        └─ Si confirma:
              │
              └─→ AJAX POST /dashboard/usuarios/delete/{id}
                   │
                   └─→ D_usuarios::delete($id)
                        ├─ Marca como deleted (soft delete)
                        └─→ Retorna JSON {status: true}

2. JavaScript redirige
   │
   └─→ window.location.reload()
        └─→ Tabla se actualiza sin ese usuario
```

---

## 🔄 MENÚ DINÁMICO

```php
// En header.php

$url = explode("/", uri_string());
$nav = $url[1];  // Extrae "usuarios", "clientes", etc

switch ($nav) {
    case "usuarios":
        $usuarios_color = "active_nav";  // Resalta
        $mantenimientos_style = "active pcoded-trigger";
        break;
    // ... más casos ...
}

// En HTML
<li class="nav-item <?php echo $mantenimientos_style; ?>">
    <a href="/dashboard/usuarios" class="<?php echo $usuarios_color; ?>">
        Usuarios
    </a>
</li>
```

---

## 📱 MODELO DE USUARIO EN SESIÓN

```php
$_SESSION = [
    'id'          => 1,                    // ID del usuario
    'name'        => 'Rolando',            // Nombre
    'lastname'    => 'Contreras',          // Apellido
    'email'       => 'user@example.com',   // Email
    'dni'         => '45887343',           // DNI
    'privilage'   => 3,                    // Nivel (1,2,3,4)
    'privilegio'  => 'admin',              // Etiqueta
    'active'      => '1',                  // Activo
    'isLoggedIn'  => TRUE,                 // Flag de sesión
    'avatar'      => '...',                // Ruta avatar
    'api_access_token'  => '...',          // Token API
    'api_token_type'    => '...'           // Tipo token
];
```

---

## 🛠️ TECNOLOGÍAS USADAS

| Tecnología        | Uso                 |
| ----------------- | ------------------- |
| **CodeIgniter 4** | Framework PHP       |
| **MySQL**         | Base de datos       |
| **PHP Sessions**  | Gestión de sesiones |
| **bcrypt**        | Hash de contraseñas |
| **QueryBuilder**  | Queries seguras     |
| **AJAX/jQuery**   | CRUD frontend       |
| **SweetAlert**    | Notificaciones      |
| **DataTables**    | Tablas interactivas |

---

## 📂 ARCHIVOS PRINCIPALES

| Archivo                                  | Líneas | Función                 |
| ---------------------------------------- | ------ | ----------------------- |
| `app/Controllers/B_admin.php`            | 150+   | Autenticación principal |
| `app/Controllers/D_usuarios.php`         | 100+   | CRUD usuarios           |
| `app/Models/UsersModel.php`              | 60+    | Acceso a datos          |
| `app/Config/Routes.php`                  | 500+   | Definición de rutas     |
| `app/Views/admin/header.php`             | 1000+  | Sidebar + menú          |
| `app/Views/admin/usuarios/list.php`      | 100+   | Listado                 |
| `app/Views/admin/usuarios/load.php`      | 150+   | Formulario              |
| `public/assets/admin/js/script/users.js` | 100+   | Funciones AJAX          |
| `app/Config/rere.sql`                    | 10000+ | Schema BD               |

---

## ⚠️ PROBLEMAS CONOCIDOS

1. **Inconsistencia de nombres**: `privilage` vs `privilegio`
2. **No hay CSRF tokens** en formularios
3. **No hay rate limiting** en login
4. **Validación de privilegios débil** (solo logueado/no logueado)
5. **Menú hardcodeado** (~100 líneas de variables)
6. **Soft deletes activos** pero sin usar correctamente

---

## ✅ LO QUE FUNCIONA BIEN

- ✅ Autenticación robusta con bcrypt
- ✅ Rutas protegidas con filtro
- ✅ Soft deletes para auditoría
- ✅ CRUD completo para usuarios
- ✅ Interfaz amigable
- ✅ Validación básica
- ✅ Sistema de privilegios simple

---

## 🎯 PRÓXIMOS PASOS

1. Documentar API endpoints del admin
2. Crear tests unitarios
3. Implementar validación de privilegios en controladores
4. Migrar menú a BD
5. Agregar CSRF tokens
6. Implementar 2FA
