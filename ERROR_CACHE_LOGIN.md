# Error: Cache y Login Colgado - Solución

**Fecha**: 1 de Mayo de 2026  
**Versión CodeIgniter**: 4.1.5  
**Ambiente**: Desarrollo Local (XAMPP)

---

## Problema

### Error Principal
```
[CodeIgniter\Cache\Exceptions\CacheException]

Cache unable to write to C:\xampp\htdocs\grupovivencia\writable\cache/.

at SYSTEMPATH\Cache\Handlers\FileHandler.php:121
```

### Síntomas
1. **Servidor no iniciaba**: `php spark serve --port 8081` fallaba con código de salida 1
2. **Login colgado**: Página de login se quedaba cargando indefinidamente
3. **Sin respuesta**: No había respuesta del servidor

---

## Causas Identificadas

### 1. Directorio de Caché Faltante
- **Ruta esperada**: `writable/cache/`
- **Estado**: No existía
- **Impacto**: CodeIgniter no podía almacenar archivos temporales de caché

### 2. Directorio de Logs Faltante
- **Ruta esperada**: `writable/logs/`
- **Estado**: No existía
- **Impacto**: CodeIgniter no podía guardar archivos de log

### 3. MySQL no Activo
- **Síntoma**: Login se quedaba cargando
- **Causa**: El controlador `Login.php` intenta conectarse a la BD en el método `index()`
  ```php
  // Login.php - línea ~20
  $obj_products = $Memberships->search($params);
  ```
- **Impacto**: Sin MySQL corriendo, la consulta cuelga indefinidamente

---

## Solución

### Paso 1: Crear Directorio de Caché
```bash
mkdir writable/cache
```

### Paso 2: Crear Directorio de Logs
```bash
mkdir writable/logs
```

### Paso 3: Iniciar MySQL
1. Abre **XAMPP Control Panel**
2. Haz clic en **Start** junto a **MySQL**
3. Espera a que esté en estado **Running** (verde)

### Paso 4: Iniciar Servidor CodeIgniter
```bash
php spark serve --port 8081
```

---

## Verificación

Después de aplicar la solución, verifica que:

✅ El servidor inicie sin errores  
✅ Puedas acceder a `http://localhost:8081`  
✅ El formulario de login cargue correctamente  
✅ MySQL esté activo en XAMPP Control Panel  

---

## Archivos Afectados

- `writable/cache/` - Almacenamiento de caché
- `writable/logs/` - Almacenamiento de logs
- `app/Controllers/Login.php` - Controlador que consulta BD

---

## Notas

- El archivo `public/php_errorlog` alcanzó +50MB debido a muchos intentos de conexión fallidos
- Se recomienda revisar regularmente este archivo o usar el sistema de logs de CodeIgniter
- Asegurate de que MySQL esté corriendo antes de iniciar el servidor

---

**Estado**: ✅ Resuelto
