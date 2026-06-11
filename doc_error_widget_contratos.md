# Documentación de Resolución de Errores: Widget de Contratos en el Dashboard

**Fecha:** 11 de Junio de 2026
**Módulo:** Backoffice del Cliente (Panel Principal)
**Archivo Principal Afectado:** `app/Controllers/Home.php` y `app/Views/backoffice_new/home.php`

## 1. Descripción del Problema
El usuario reportó que en el panel principal (`/backoffice_new`), el widget de "Mis Contratos Recientes" mostraba el mensaje de advertencia **"No tiene contratos asignados."**, a pesar de que el usuario sí tenía un contrato activo (ej. GV-2026-257) en la base de datos. Además, los estilos CSS del botón no se estaban aplicando correctamente.

## 2. Diagnóstico y Causas Raíz (Root Causes)

Durante la investigación en el código y la base de datos, se descubrieron tres problemas superpuestos que causaban este comportamiento:

### A. Referencia a columnas inexistentes
En la consulta original, se intentaba extraer el nombre del lote usando la columna `lots.name`. Sin embargo, en la base de datos, la estructura de la tabla `lots` utiliza la columna `lot_number` para identificar el lote. Esto causaba que la consulta SQL fallara silenciosamente y devolviera un array vacío.

### B. Restricciones del Modelo de CodeIgniter 4 (`ContractModel`)
Se estaba utilizando el modelo `$ContractModel->select(...)` para hacer *JOINs* con otras tablas (`lots` y `projects`). CodeIgniter 4, por defecto, protege los campos de retorno basados en la propiedad `$allowedFields` del modelo. Al traer campos de otras tablas (como `project_name` o `lot_name`), el modelo los descartaba, resultando en datos incompletos o errores internos.

### C. Confusión de Controladores (`B_home.php` vs `Home.php`)
Las primeras correcciones se aplicaron en el archivo `app/Controllers/B_home.php`. Sin embargo, al revisar `app/Config/Routes.php`, se descubrió que la ruta `/backoffice_new` estaba apuntando al controlador `Home::index` y no a `B_home::index`. Por lo tanto, el usuario no veía los cambios reflejados en pantalla porque el sistema estaba ejecutando un archivo distinto.

## 3. Solución Implementada

Para resolver el problema de manera definitiva, se aplicaron las siguientes soluciones en el archivo correcto (`app/Controllers/Home.php`):

1. **Uso del Query Builder Nativo (`$db->table`)**: 
   Se reemplazó el uso del `$ContractModel` por el Query Builder nativo de la conexión a la base de datos. Esto permite realizar *JOINs* complejos y traer columnas calculadas (alias) sin que el ORM estricto de CodeIgniter bloquee los campos.

2. **Corrección de nombres de columnas**:
   Se corrigió la consulta para utilizar `lots.lot_number as lot_name` en lugar de `lots.name`.

   *Código corregido en `Home.php`:*
   ```php
   $db = \Config\Database::connect();
   $obj_contracts = $db->table('contracts')
       ->select('contracts.*, lots.lot_number as lot_name, projects.name as project_name')
       ->join('lots', 'lots.id = contracts.lot_id', 'left')
       ->join('projects', 'projects.id = lots.project_id', 'left')
       ->where('contracts.customer_id', $id)
       ->orderBy('contracts.id', 'DESC')
       ->limit(5)
       ->get()
       ->getResultArray();
   ```

3. **Corrección de Estilos UI (`home.php`)**:
   Se forzó el color del botón utilizando reglas estrictas (`!important`) para evitar que la hoja de estilos global del template (Metronic) sobrescribiera el color celeste personalizado solicitado por el cliente.

   *Código corregido en la vista:*
   ```html
   <a href="<?= site_url() . BACKOFFICE . '/contratos' ?>" 
      class="btn" 
      style="background-color: #00a8ff !important; color: white !important; border-radius: 4px; font-weight: 500; padding: 10px 20px; font-size: 14px;">
       Ver Mis Contratos
   </a>
   ```

## 4. Resultado
El widget ahora lee correctamente los datos cruzados desde la base de datos, muestra la lista de los últimos 5 contratos del cliente con su respectivo Lote, Fecha y Estado (con colores dinámicos), y el botón redirige correctamente manteniendo el diseño UI aprobado.