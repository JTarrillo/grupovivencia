# Recomendaciones y Observaciones - Estructura Admin

## 1. OBSERVACIONES IMPORTANTES

### 1.1 Tabla de Usuarios

**Estado actual:**

- Campo `privilage` es ENUM (1,2,3,4)
- Hay inconsistencia: en la BD es `privilage`, pero en sesión se guarda como `privilage` y también como `privilegio`

```php
// En B_admin.php - línea ~120
'privilage' => $res->privilage ?? 'admin',
'privilegio' => $res->privilegio ?? ($res->privilage ?? 'admin'),
```

**✅ Recomendación:**

- Normalizar el nombre del campo: usar solo `privilage` (o mejor aún: `privilege`)
- Actualizar todas las referencias donde dice `privilegio` a `privilage`

### 1.2 Soft Deletes

```php
// En UsersModel.php
protected $useSoftDeletes = true;
protected $deletedField = 'deleted_at';
```

**✅ Recomendación:**

- Los soft deletes están habilitados, lo cual es bueno para auditoría
- Verificar que las consultas usen correctamente `withDeleted()` cuando sea necesario

### 1.3 Falta de Encriptación de Datos Sensibles

**⚠️ Problema:**

- Se están guardando tokens de API en la sesión en texto plano
- El DNI se guarda sin encriptación

**✅ Recomendación:**

- Encriptar tokens con CodeIgniter Encrypter
- Encriptar DNI en la BD con una función de encriptación reversible

---

## 2. SEGURIDAD

### 2.1 Contraseñas

✅ **Bien hecho:**

- Uso de `password_hash()` con algoritmo BCRYPT
- Verificación con `password_verify()`

### 2.2 Control de Acceso

⚠️ **Problema:**

- No hay validación de privilegios en los controladores
- Solo hay validación de "logueado" con filtro `authGuard`
- Cualquier usuario logueado puede acceder a `/dashboard/usuarios`

**✅ Recomendación:**

```php
// Crear un filtro más restrictivo o validar en cada controlador
if ($session->get('privilage') < 3 && $session->get('privilage') != 'admin') {
    throw new \CodeIgniter\Exceptions\PageNotFoundException();
}
```

### 2.3 CSRF Protection

- Verificar que CodeIgniter 4 tenga CSRF habilitado en `app/Config/Security.php`

```php
public $csrf = [
    'protection' => 'session',
    'regenerate' => true,
    'redirect' => true,
    'expires' => 7200,
];
```

**✅ Recomendación:**

- Añadir token CSRF en todos los formularios
- Validar en servidor: `$this->validate(['csrf_token' => 'valid_csrf_token'])`

### 2.4 SQL Injection

✅ **Bien hecho:**

- Se usan prepared statements automáticamente en QueryBuilder
- Ejemplo: `$this->where('email', $email)` no es vulnerable

### 2.5 Rate Limiting

⚠️ **Problema:**

- No hay protección contra fuerza bruta en login

**✅ Recomendación:**

```php
// Implementar rate limiting
$throttler = service('throttler');

if ($throttler->check(md5($email), 5, MINUTE)) {
    // Máximo 5 intentos por minuto
    return json_encode([
        'status' => false,
        'message' => 'Demasiados intentos. Intente más tarde.'
    ]);
}
```

---

## 3. ESTRUCTURA DE PRIVILEGIOS

### 3.1 Problema Actual

El sistema actual usa un simple ENUM numérico (1,2,3,4) que no es escalable.

```php
switch ($value->privilage) {
    case 1: echo "Control Básico"; break;
    case 2: echo "Control Medio"; break;
    case 3: echo "Control Total"; break;
    case 4: echo "Superadministrador"; break;
}
```

### 3.2 Recomendación: Migrar a Sistema de Roles

Crear tablas de roles y permisos:

```sql
-- Tabla de roles
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description VARCHAR(255),
    level INT (1-4),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de permisos
CREATE TABLE permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    slug VARCHAR(100),
    resource VARCHAR(50),  -- 'usuarios', 'clientes', 'facturas', etc
    action VARCHAR(50),    -- 'create', 'read', 'update', 'delete'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla pivote: role-permission
CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
);

-- Modificar tabla users
ALTER TABLE users ADD COLUMN role_id INT AFTER privilage;
ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES roles(id);
```

**Ventajas:**

- Escalable: agregar nuevos permisos sin modificar código
- Flexible: cada rol puede tener diferentes permisos
- Auditoria: se puede registrar qué permisos tiene cada usuario

---

## 4. GESTIÓN DE MENÚ

### 4.1 Problema Actual

El menú en `header.php` es hardcodeado con ~100 líneas de código de inicialización de variables.

```php
$panel_color = null;
$ventas_color = null;
$nuevo_socio_color = null;
// ... 50+ variables más ...
```

### 4.2 Recomendación: Menú Dinámico

Crear una tabla de menú:

```sql
CREATE TABLE menu_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(50),
    route VARCHAR(100),
    parent_id INT,
    min_privilege INT,  -- Privilegio mínimo requerido
    order_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id)
);
```

Modelo para generar el menú:

```php
// app/Models/MenuModel.php

class MenuModel extends Model
{
    public function getMenuByPrivilege($privilege)
    {
        return $this->where('min_privilege <=', $privilege)
                    ->orderBy('order_by', 'ASC')
                    ->findAll();
    }

    public function getActiveMenu($current_route)
    {
        return $this->where('route', $current_route)
                    ->first();
    }
}
```

Usar en vista:

```php
// app/Views/admin/header.php

$MenuModel = new \App\Models\MenuModel();
$menu_items = $MenuModel->getMenuByPrivilege($session->get('privilage'));
$active_route = $MenuModel->getActiveMenu($current_route);

foreach ($menu_items as $item):
    $is_active = ($active_route->id == $item->id) ? 'active_nav' : '';
?>
<li class="nav-item">
    <a href="<?php echo base_url($item->route); ?>" class="nav-link <?php echo $is_active; ?>">
        <i class="<?php echo $item->icon; ?>"></i>
        <span><?php echo $item->name; ?></span>
    </a>
</li>
<?php endforeach; ?>
```

---

## 5. AUDITORÍA Y LOGGING

### 5.1 Actual

```php
// En B_admin.php
$logData = [
    'datetime' => date('Y-m-d H:i:s'),
    'admin_id' => $res->id,
    'customer_array' => [...]
];
// ... pero no se guarda en BD, solo en logs
```

### 5.2 Recomendación

Crear tabla de auditoría:

```sql
CREATE TABLE audit_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    action VARCHAR(50),  -- 'login', 'create', 'update', 'delete'
    resource VARCHAR(50),  -- 'user', 'customer', 'invoice'
    resource_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

Modelo para registrar acciones:

```php
// app/Models/AuditLogModel.php

public function logAction($user_id, $action, $resource, $resource_id, $old = null, $new = null)
{
    return $this->insert([
        'user_id' => $user_id,
        'action' => $action,
        'resource' => $resource,
        'resource_id' => $resource_id,
        'old_values' => $old ? json_encode($old) : null,
        'new_values' => $new ? json_encode($new) : null,
        'ip_address' => \Config\Services::request()->getIPAddress(),
        'user_agent' => \Config\Services::request()->getUserAgent(),
        'created_at' => date('Y-m-d H:i:s')
    ]);
}
```

**Uso:**

```php
// En D_usuarios::validacion()

$AuditLog = new \App\Models\AuditLogModel();

if ($user_id) {
    // Update
    $old_data = $Users->find($user_id);
    $Users->update($user_id, $data_insert);
    $AuditLog->logAction($session->get('id'), 'update', 'user', $user_id, $old_data, $data_insert);
} else {
    // Create
    $id = $Users->insert($data_insert);
    $AuditLog->logAction($session->get('id'), 'create', 'user', $id, null, $data_insert);
}
```

---

## 6. VALIDACIÓN

### 6.1 Problema Actual

Validación solo existe en Models, y no se usa en todos los controladores.

```php
// En UsersModel - pero no se usa
protected $validationRules = [
    'first_name' => 'required|alpha_numeric_space|min_length[3]',
    'last_name' => 'required|alpha_numeric_space|min_length[3]',
    'email' => 'required|valid_email|is_unique[users.email]'
];
```

### 6.2 Recomendación

Usar validación consistentemente:

```php
// En D_usuarios::validacion()

$rules = [
    'email' => 'required|valid_email|is_unique_except[users.email,id,{user_id}]',
    'name' => 'required|string|min_length[3]|max_length[50]',
    'lastname' => 'required|string|min_length[3]|max_length[50]',
    'password' => $user_id ? 'required_if[password,!null]|min_length[8]' : 'required|min_length[8]',
    'privilage' => 'required|in_list[1,2,3,4]'
];

if (!$this->validate($rules)) {
    return json_encode([
        'status' => false,
        'errors' => $this->validator->getErrors()
    ]);
}
```

---

## 7. API TOKENS

### 7.1 Actual

```php
// Los tokens de API se guardan en sesión
'api_access_token' => $accessToken,
'api_token_type' => $tokenType
```

### 7.2 Problema

- Los tokens no se persistem en la BD
- Si la sesión expira, el token se pierde
- No hay forma de revocar tokens

### 7.3 Recomendación

```sql
CREATE TABLE api_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    token_type VARCHAR(20),
    expires_at DATETIME,
    revoked_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

```php
// En B_admin.php - guardar token en BD
$TokenModel = new \App\Models\ApiTokenModel();
$TokenModel->where('user_id', $res->id)->update(['revoked_at' => date('Y-m-d H:i:s')]);

$TokenModel->insert([
    'user_id' => $res->id,
    'token' => $accessToken,
    'token_type' => $tokenType,
    'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
]);
```

---

## 8. TESTING

### 8.1 Recomendación

Crear tests para:

```php
// tests/Feature/AdminLoginTest.php

class AdminLoginTest extends FeatureTestCase
{
    public function test_login_with_valid_credentials()
    {
        $this->post('/dashboard/validate', [
            'email' => 'correct@example.com',
            'password' => 'password123'
        ])->assertStatus(200)
          ->assertJSON(['status' => true]);
    }

    public function test_login_with_invalid_password()
    {
        $this->post('/dashboard/validate', [
            'email' => 'correct@example.com',
            'password' => 'wrong'
        ])->assertStatus(200)
          ->assertJSON(['status' => false]);
    }

    public function test_dashboard_requires_login()
    {
        $this->get('/dashboard/usuarios')
            ->assertRedirectTo('/');
    }
}
```

---

## 9. CHECKLIST DE MEJORAS

- [ ] Normalizar nombres de campos (privilage ↔ privilege)
- [ ] Implementar CSRF tokens en todos los formularios
- [ ] Agregar rate limiting en login
- [ ] Validar privilegios en cada controlador
- [ ] Migrar a sistema de roles y permisos
- [ ] Crear menú dinámico desde BD
- [ ] Implementar auditoría de acciones
- [ ] Persistir API tokens en BD
- [ ] Agregar validación consistente
- [ ] Crear tests unitarios y funcionales
- [ ] Documenta endpoints de API del admin
- [ ] Implementar 2FA (autenticación de dos factores)
- [ ] Encriptar datos sensibles (DNI, tokens)
- [ ] Crear respaldos de datos regularmente

---

## 10. CONCLUSIONES

El sistema de admin actual es **funcional pero necesita mejoras en**:

1. **Seguridad**: Rate limiting, CSRF tokens, validación de privilegios
2. **Escalabilidad**: Menú dinámico, sistema de roles/permisos flexible
3. **Mantenibilidad**: Código repetitivo, falta de DRY principle
4. **Auditoría**: Registrar todas las acciones en la BD
5. **Testing**: Crear test suite para funcionalidades críticas

**Prioridad Alta:**

- Validar privilegios en controladores
- Implementar CSRF tokens
- Agregar rate limiting

**Prioridad Media:**

- Sistema de roles y permisos
- Menú dinámico
- Auditoría de acciones

**Prioridad Baja:**

- 2FA
- Documentación de API
- Mejoras UI/UX
