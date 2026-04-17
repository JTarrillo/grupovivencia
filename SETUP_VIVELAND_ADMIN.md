# SETUP: Administrador VIVELAND con Acceso Limitado

## Resumen de lo creado

Se ha implementado un sistema MVC completo para gestionar registros de VIVELAND en el panel admin:

### 1. **Model** - `VivelandRegistroModel.php`

- Consultas a la tabla `viveland_registros`
- Filtros por estado, búsqueda
- Estadísticas (total, pendiente, confirmado, cancelado)
- Métodos de confirmación y cambio de estado

### 2. **Controller** - `D_viveland_registros.php`

- `index()` - Lista registros con filtros
- `view($id)` - Ver detalle de un registro
- `confirmar($id)` - Confirmar un registro
- `cambiar_estado()` - Cambiar estado de registro
- `exportar()` - Exportar a CSV

### 3. **Views** - Vistas responsivas

- `list.php` - Tabla con filtros, búsqueda y estadísticas
- `view.php` - Detalles completos de cada registro

### 4. **Menú Dinámico**

- Agrégado en `header.php`
- Solo aparece si el usuario tiene `privilage = 5`

---

## PASO 1: Crear el Usuario en la Base de Datos

### Opción A: Ejecutar SQL directo

```sql
INSERT INTO `users` (
    `name`,
    `lastname`,
    `email`,
    `password`,
    `dni`,
    `phone`,
    `type`,
    `privilage`,
    `active`,
    `created_at`,
    `updated_at`
) VALUES (
    'Coordinador',
    'VIVELAND',
    'coordinador.viveland@grupovivencia.club',
    '$2y$10$nR9VzLmjP8qL4tK7bX2wOuM5sD3vF6gH1aJ9cL2mN4oP7qR5sT6u',
    '12345678',
    '+51900000000',
    'admin',
    5,
    1,
    NOW(),
    NOW()
);
```

**Credenciales iniciales:**

- Email: `coordinador.viveland@grupovivencia.club`
- Contraseña: `ViveMe2024!`
- Privilage: `5` (nuevo nivel - solo VIVELANDacceso)

### Opción B: Usando PhpMyAdmin

1. Abre `http://localhost/phpmyadmin`
2. Ve a la base de datos `grupovivencia`
3. Selecciona la tabla `users`
4. Haz clic en "Insertar"
5. Rellena los campos:
   - Nombre: `Coordinador`
   - Apellido: `VIVELAND`
   - Email: `coordinador.viveland@grupovivencia.club`
   - Contraseña: `ViveMe2024!` (dejar que se hashee automáticamente si está configurado)
   - DNI: `12345678`
   - Teléfono: `+51900000000`
   - Tipo: `admin`
   - Privilage: `5` ✅ (Esto es importante!)
   - Activo: `1`

---

## PASO 2: Acceder al Admin

1. Ve a `http://localhost:8081/admin` (o tu dominio de producción)
2. Inicia sesión con:
   - **Email**: `coordinador.viveland@grupovivencia.club`
   - **Contraseña**: `ViveMe2024!`

---

## PASO 3: ¿Qué verá el usuario?

El usuario con `privilage = 5` verá:

- ✅ **Solo** el menú "Registros VIVELAND"
- ✅ Lista de todos los registros de viveland_registros
- ✅ Búsqueda y filtros por estado (Pendiente, Confirmado, Cancelado)
- ✅ Estadísticas de registros
- ✅ Ver detalles de cada registro
- ✅ Confirmar o cancelar registros
- ✅ Exportar a CSV

No verá:

- ❌ Otros menús (Usuarios, Clientes, Ventas, etc.)
- ❌ Otras funcionalidades del admin

---

## PASO 4: Cambiar Contraseña (Recomendado)

El usuario puede cambiar su contraseña después de login. Si lo haces programáticamente:

```php
// Hash de contraseña con bcrypt
$new_password = "Tu_Nueva_Contraseña_2024";
$hash = password_hash($new_password, PASSWORD_BCRYPT);

// Ejecutar en la BD
$this->db->query("UPDATE users SET password = ? WHERE email = 'coordinador.viveland@grupovivencia.club'", [$hash]);
```

---

## PASO 5: Rutas accesibles

Las rutas que solo este usuario puede acceder:

```
GET  /admin/viveland_registros              -> Lista de registros
GET  /admin/viveland_registros/view/{id}    -> Ver detalles
POST /admin/viveland_registros/confirmar/{id}     -> Confirmar
POST /admin/viveland_registros/cambiar_estado/{id}/{estado}  -> Cambiar estado
GET  /admin/viveland_registros/exportar     -> Descargar CSV
```

---

## PASO 6: Estructura de MVC (referencia para desarrollador)

```
app/
├── Controllers/
│   └── D_viveland_registros.php          ← Lógica de negocio
├── Models/
│   └── VivelandRegistroModel.php         ← Consultas a BD
├── Views/
│   └── admin/
│       └── viveland_registros/
│           ├── list.php                  ← Tabla principal
│           └── view.php                  ← Detalles
```

---

## Personalización

### Cambiar el nombre del usuario

En lugar de "Coordinador VIVELAND", puedes usar otro nombre:

```sql
UPDATE users SET name = 'Tu Nombre', lastname = 'Tu Apellido'
WHERE email = 'coordinador.viveland@grupovivencia.club';
```

### Cambiar el email

```sql
UPDATE users SET email = 'nuevo.email@grupovivencia.club'
WHERE email = 'coordinador.viveland@grupovivencia.club';
```

### Dar más acceso (cambiar privilage)

- `privilage = 1` → Control Básico
- `privilage = 2` → Control Medio
- `privilage = 3` → Control Total
- `privilage = 4` → Superadmin
- `privilage = 5` → Solo VIVELAND (como está ahora)

---

## Troubleshooting

### ¿El menú no aparece?

- Verifica que `privilage` sea exactamente `5` en la BD
- Revisa que el usuario esté activo (`active = 1`)
- Limpia caché del navegador (Ctrl+F5)

### ¿No puede acceder a cierta ruta?

- Verifica que esté en el Controller (`D_viveland_registros.php`)
- Confirma que el filtro de autenticación (`authGuard`) no bloquea

### ¿No ve filtros o búsqueda?

- Asegúrate de que `viveland_registros` tabla tiene datos
- Revisa la consola del navegador para errores de JS

---

## Notas de Seguridad

✅ **Lo que está bien:**

- Contraseña hasheada con bcrypt
- Sesiones del lado del servidor
- Validación de privilage en header.php
- CRUD operaciones básicas

⚠️ **Consideraciones futuras:**

- Agregar CSRF tokens a formularios
- Implementar rate limiting en login
- Auditar cambios de estado
- Encriptar contraseña en URLs (mover a POST)

---

## Contacto / Preguntas

Si necesitas más usuarios, cambiar permisos, o ajustar el sistema, contacta al equipo de desarrollo.
