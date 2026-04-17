# Sistema de Restricción de Menú por Privilage

## Descripción General

Este documento explica cómo funciona el sistema de restricción de menú que permite mostrar SOLO "Registros VIVELAND" a usuarios con `privilage = 5`, mientras que los demás usuarios ven el menú completo.

---

## Arquitectura del Sistema

### 1. Base de Datos (Schema Level)

#### Tabla: `users`

```sql
-- Columna clave: privilage (ENUM)
ALTER TABLE users MODIFY COLUMN privilage ENUM('1','2','3','4','5') NULL DEFAULT NULL;
```

**Niveles de Privilage:**

- `1`, `2`, `3`, `4`: Admins con acceso completo (menú normal)
- `5`: Coordinador VIVELAND (menú restringido - solo "Registros VIVELAND")

**Ejemplo de usuario VIVELAND:**

```sql
INSERT INTO users (name, lastname, email, password, privilage, active)
VALUES (
  'Coordinador',
  'VIVELAND',
  'coordinador.viveland@grupovivencia.club',
  '$2y$10$...',  -- hash bcrypt de la contraseña
  '5',           -- El nivel restrictivo
  1
);
```

---

### 2. Login Controller - Sesión

#### Archivo: `app/Controllers/B_admin.php`

**Líneas 129-147:**

```php
// --- PREPARAR DATOS DE SESIÓN ---
$ses_data = [
    'id'           => $res->id,
    'name'         => $res->name,
    'lastname'     => $res->lastname,
    'email'        => $res->email,
    'dni'          => $res->dni,
    'privilage'    => $res->privilage ?? 'admin',  // ← CLAVE: se obtiene directamente de BD
    'active'       => $res->active,
    'isLoggedIn'   => TRUE,
    'api_access_token' => $accessToken,
    'api_token_type'   => $tokenType
];

$session->set($ses_data);  // Almacena en $_SESSION['privilage']
```

**Lo importante:**

- Se obtiene `$res->privilage` desde la base de datos (el usuario tiene privilage = 5)
- Se guarda en la sesión con la clave `'privilage'` (no `'privilegio'`)
- Este valor es accesible luego en las vistas como `$session->get('privilage')`

---

### 3. Header View - Lógica Condicional

#### Archivo: `app/Views/admin/header.php`

**Línea 348 - Obtener el privilage de sesión:**

```php
<?php
$session = session();
$session_privilege = $session->get('privilage') ?? $session->get('privilegio');
// Obtiene privilage de la sesión actual del usuario autenticado
```

**Línea 357 - Identificar admin normal:**

```php
if (in_array($session_privilege, [1, 2, 3, 4]) || $session_privilege === 'admin' || $session_privilege === 'Administrador' || $session_privilege === 'superadmin') {
    // Este es un admin con acceso completo
    // Mostrar nombre y avatar en el header
} else {
    // No es admin o tiene otro tipo de acceso
}
```

**Líneas 410-425 - Mostrar menú dinámico:**

```php
<ul class="nav pcoded-inner-navbar">
    <?php
    // Obtener privilage de sesión
    $session_privilege = $session->get('privilage') ?? $session->get('privilege') ?? null;

    // Si es coordinador VIVELAND (privilage = 5), mostrar solo ese menú
    if ($session_privilege == 5):
    ?>
    <!-- MENÚ RESTRINGIDO: SOLO VIVELAND -->
    <li class="nav-item <?php echo $viveland_registros_style; ?>">
        <a href="<?php echo base_url('admin/viveland_registros'); ?>" class="nav-link <?php echo $viveland_registros_color; ?>">
            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
            <span class="pcoded-mtext">Registros VIVELAND</span>
        </a>
    </li>
    <?php else: ?>

    <!-- MENÚ NORMAL: TODOS LOS ITEMS DE ADMIN -->
    <li class="nav-item <?php echo $inmueble_style; ?>">
        <a href="/dashboard/inmueble" class="nav-link <?php echo $inmueble_color; ?>">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Panel</span>
        </a>
    </li>
    <li class="nav-item <?php echo $estructura_style; ?>">
        <a href="/dashboard/estructura" class="nav-link <?php echo $estructura_color; ?>">
            <span class="pcoded-micon"><i class="feather icon-share-2"></i></span>
            <span class="pcoded-mtext">Estructura</span>
        </a>
    </li>
    <!-- ... muchos más items de menú -->

    <?php endif; ?>
</ul>
```

---

## Flujo Completo de Ejecución

### Paso 1: Usuario accede a login

```
Usuario ingresa:
  Email: coordinador.viveland@grupovivencia.club
  Password: ViveMe2024!
```

### Paso 2: Verificación en BD

```
B_admin.php consulta:
  SELECT * FROM users WHERE email = 'coordinador.viveland@grupovivencia.club'

Resultado:
  id: 11
  name: Coordinador
  privilage: 5  ← ESTE ES EL VALOR CLAVE
```

### Paso 3: Creación de sesión

```
B_admin.php ejecuta:
  $_SESSION['privilage'] = 5
  $_SESSION['id'] = 11
  $_SESSION['name'] = 'Coordinador'
  $_SESSION['isLoggedIn'] = TRUE
```

### Paso 4: Redirección a admin

```
Usuario es redirigido a: /dashboard/inmueble
Se carga: app/Views/admin/header.php
```

### Paso 5: Header.php renderiza menú

```php
// Lee de sesión
$session_privilege = $session->get('privilage');  // Resultado: 5

// Verifica condición
if ($session_privilege == 5):  // TRUE ✓
    // Mostrar SOLO "Registros VIVELAND"
    echo '<li>Registros VIVELAND</li>';
else:
    // No se ejecuta
endif;
```

### Resultado Final

```
Usuario ve SOLO en el sidebar:
  ✓ Registros VIVELAND

No ve:
  ✗ Panel
  ✗ Estructura
  ✗ Nuevo Socio
  ✗ Ventas
  ✗ Documentario
  ✗ ... (todos los demás items)
```

---

## Archivos Involucrados

### Críticos (cambios realizados):

1. **`app/Controllers/B_admin.php:137`** - Guarda `'privilage'` en sesión desde BD
2. **`app/Views/admin/header.php:348`** - Obtiene `privilage` de la sesión
3. **`app/Views/admin/header.php:416`** - Lógica condicional IF/ELSE para mostrar menú

### De soporte:

- **`database/migrations/create_viveland_admin_user.sql`** - Crea usuario con privilage = 5
- **`app/Controllers/D_viveland_registros.php`** - Controller para "Registros VIVELAND"
- **`app/Views/admin/viveland_registros/list.php`** - Vista restringida
- **`app/Views/admin/viveland_registros/view.php`** - Detalle de registro

---

## Cómo Añadir Otro Usuario con Acceso Restringido

### Opción 1: Por SQL

```sql
-- Insertar usuario nuevo con privilage = 5
INSERT INTO users (name, lastname, email, password, dni, phone, type, privilage, active, created_at, updated_at)
VALUES (
    'Otro Coordinador',
    'VIVELAND',
    'otro@grupovivencia.club',
    '$2y$10$...hash_bcrypt...',  -- Genera con: password_hash('micontraseña', PASSWORD_BCRYPT)
    '12345678',
    '+51900000001',
    'admin',
    5,  -- ← El nivel restringido
    1,
    NOW(),
    NOW()
);
```

### Opción 2: Por Código PHP

```php
$data = [
    'name' => 'Otro Coordinador',
    'lastname' => 'VIVELAND',
    'email' => 'otro@grupovivencia.club',
    'password' => password_hash('micontraseña', PASSWORD_BCRYPT),
    'dni' => '12345678',
    'phone' => '+51900000001',
    'type' => 'admin',
    'privilage' => 5,  // ← El nivel restringido
    'active' => 1
];

$usuariosModel = new \App\Models\UsuariosModel();
$usuariosModel->insert($data);
```

---

## Troubleshooting

### Problema: Usuario ve menú completo aunque privilage = 5

**Causas posibles:**

1. **Sesión no actualizada** - Usuario no hizo logout/login después del cambio
   - Solución: Cerrar sesión completamente y volver a hacer login
2. **Valor de privilage incorrecto en BD**
   - Verificar: `SELECT privilage FROM users WHERE id = 11;`
   - Debe devolver: `5`

3. **Header.php está en cache**
   - Solución: Limpiar caché del navegador (Ctrl+Shift+Del)
   - Solución: Abrir en modo incógnito

4. **PHP debería servirse nuevamente**
   - Si usas `php spark serve`: Reinicia el servidor

### Cómo verificar el estado actual

```php
// Agregar al inicio de header.php temporalmente:
echo '<pre>';
echo "DEBUG PRIVILAGE:\n";
var_dump($session->get('privilage'));
echo "</pre>";
```

O ver en la consola del navegador (Ctrl+Shift+K):

```javascript
console.log("SIDEBAR/HEADER ADMIN:", {
  name: "Coordinador",
  dni: "12345678",
  email: "...",
  privilegio: "5",
  avatar: "...",
});
// Verifica que privilege sea 5
```

---

## Extensiones Futuras

### Agregar más niveles de restricción

Si quieres crear más niveles (ej: privilage = 6 para otro módulo):

```php
// En header.php
if ($session_privilege == 5):
    // Mostrar solo VIVELAND
elseif ($session_privilege == 6):
    // Mostrar solo OTRO_MODULO
else:
    // Mostrar menú completo
endif;
```

### Crear múltiples menús especializados

```php
$menu_config = [
    5 => ['Registros VIVELAND', 'Reportes VIVELAND'],
    6 => ['Inventario', 'Transferencias'],
    7 => ['Facturas', 'Pagos']
];

if (isset($menu_config[$session_privilege])):
    foreach ($menu_config[$session_privilege] as $item):
        echo "<li>$item</li>";
    endforeach;
else:
    // Menú completo
endif;
```

---

## Resumen de Implementación

| Componente           | Ubicación         | Valor Clave                       |
| -------------------- | ----------------- | --------------------------------- |
| **DB Schema**        | `users.privilage` | ENUM('1','2','3','4','5')         |
| **Usuario VIVELAND** | id = 11           | privilage = 5                     |
| **Login Logic**      | B_admin.php:137   | `'privilage' => $res->privilage`  |
| **Session Storage**  | $\_SESSION        | `$_SESSION['privilage']`          |
| **Header Logic**     | header.php:416    | `if ($session_privilege == 5)`    |
| **Resultado**        | URL admin/\*      | Solo "Registros VIVELAND" visible |

---

**Última actualización:** 16 de Abril 2026  
**Estado:** ✅ Operativo  
**Usuario de prueba:** coordinador.viveland@grupovivencia.club (privilage = 5)
