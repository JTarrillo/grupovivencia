# 🔍 VIVELAND Debug Logger - Guía de Uso

## ¿Qué es?

Sistema de logging automático que se ejecuta cuando cargas la landing page en cualquier entorno (desarrollo o producción). Ayuda a diagnosticar problemas de rutas, recursos y configuración.

## ¿Cómo funciona?

Cuando cargas la página, el debug logger:

1. ✅ Verifica automáticamente todas las hojas de estilo (CSS)
2. ✅ Verifica todos los scripts (JS) cargados
3. ✅ Verifica las imágenes
4. ✅ Escucha errores de red en tiempo real
5. ✅ Muestra información sobre la URL actual y rutas

## Cómo usar:

### 1️⃣ **Abre la Consola del Navegador**

- **Chrome/Firefox**: Presiona `F12`
- O click derecho → Inspeccionar → Tab "Console"

### 2️⃣ **Verifica el Output Automático**

Cuando la página carga, verás algo como:

```
🔍 VIVELAND DEBUG INICIADO
📋 Información Base
   URL Actual: http://domain.com/viveland
   Hostname: domain.com
   Pathname: /viveland
   Protocol: http:

📦 Verificando Recursos
🎨 Hojas de Estilo (CSS)
   ✅ http://domain.com/viveland/public/assets/css/main.css
   ✅ http://domain.com/viveland/public/assets/css/bootstrap.min.css

⚙️ Scripts (JS)
   ✅ http://domain.com/viveland/public/assets/js/carousel.js
   ✅ http://domain.com/viveland/public/assets/js/main.js

🖼️ Imágenes
   ✅ 1. http://domain.com/viveland/assets/front/img/logo/...

📊 Resumen General
   ✅ VIVELAND está listo para diagnóstico
```

### 3️⃣ **Busca Problemas**

Mira si hay:

- ❌ **Error cargando**: Significa que la ruta está mal o no existe
- ⚠️ **Advertencias**: Posibles problemas pero no críticos
- ✅ **Checkmarks verdes**: Todo cargó correctamente

### 4️⃣ **Exporta los Logs** (si necesitas compartir)

En la Consola, ejecuta:

```javascript
VivelandDebug.exportLogs();
```

Copiar el output y enviar para análisis.

### 5️⃣ **Verifica un Recurso Específico**

Si quieres verificar que un archivo específico existe:

```javascript
VivelandDebug.checkResource("/viveland/public/assets/css/main.css");
```

## 🚨 Problemas Comunes

### Caso 1: CSS No Carga

**Síntoma**: La página se ve sin estilos (blanca con solo texto)

**En la consola verás**:

```
❌ Error cargando: http://domain.com/viveland/public/assets/css/main.css
```

**Solución**: La ruta `/viveland/public/` es incorrecta. Puede ser:

- `/public/` (si está en raíz)
- `/app/public/` (si está en subdirectorio)

### Caso 2: Imágenes No Cargan

**Síntoma**: La página se ve sin logos o fotos

**En la consola verás**:

```
⚠️ 1. http://domain.com/viveland/assets/front/img/logo/...
    (loading)
```

**Solución**: Las imágenes están en otra ruta

### Caso 3: JavaScript No Funciona

**Síntoma**: Botones no responden, carrusel no gira

**En la consola verás**:

```
❌ Promise Rejection: Cannot find module...
```

**Solución**: Rutas de JS incorrectas o dependencias faltantes

## 📋 Qué Información Reportar

Cuando contactes con soporte, incluye:

1. **La URL exacta** donde está la página
2. **Captura de pantalla** de la consola (F12)
3. **El output de**: `VivelandDebug.exportLogs()`
4. **Tu navegador** (Chrome, Firefox, Safari, etc.)

## 🔧 Para Desarrolladores

El logger está siempre activo. Los logs se guardan en:

```javascript
window.VivelandDebug.logs; // Array con todos los logs
```

Puedes acceder a cualquier momento desde la consola.

---

**¡Listo!** Ahora tienes un sistema de diagnóstico automático. 🚀
