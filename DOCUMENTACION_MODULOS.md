# DOCUMENTACIÓN DE MÓDULOS - CLASIFICACIÓN DE GASTOS

**Fecha:** Abril 8, 2026  
**Framework:** CodeIgniter 4  
**Módulo:** Sistema de Clasificación de Gastos  
**Commit:** `modulo-compras-gastos 7c80dce2`

---

## 📋 TABLA DE CONTENIDOS

1. [Estructura de Archivos](#estructura-de-archivos)
2. [Controllers](#controllers)
3. [Models](#models)
4. [Views](#views)
5. [Routes](#routes)
6. [Flujo de Datos](#flujo-de-datos)
7. [API Endpoints](#api-endpoints)
8. [Ejemplos de Uso](#ejemplos-de-uso)

---

## Estructura de Archivos

```
app/
├── Config/
│   └── Routes.php                          (Rutas actualizadas)
├── Controllers/
│   └── D_clasificacion.php                 (NUEVO - 11 métodos)
├── Models/
│   ├── GastoTipoModel.php                  (NUEVO - Tipos de gasto)
│   ├── GastoSubcategoriaModel.php          (NUEVO - Subcategorías)
│   ├── CompraGastoModel.php                (NUEVO - Clasificación)
│   ├── CompraDocumentoModel.php            (NUEVO - Documentos)
│   └── GastoReporteModel.php               (NUEVO - Reportes)
└── Views/
    ├── admin/
    │   ├── header.php                      (Actualizado - Menú)
    │   └── clasificacion/
    │       ├── index.php                   (NUEVO - Dashboard)
    │       └── clasificar.php              (NUEVO - Formulario)
```

---

## Controllers

### `D_clasificacion.php`

**Ubicación:** `app/Controllers/D_clasificacion.php`  
**Clase:** `D_clasificacion extends BaseController`  
**Métodos:** 11

#### Método 1: `index()`

**Propósito:** Mostrar dashboard de clasificación  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion`

```php
public function index()
{
    // Obtiene compras sin clasificación
    $model = new CompraGastoModel();
    $compras = $model->getComprasSinClasificar();

    // Calcula estadísticas
    $total_sin_clasificar = count($compras);
    $total_clasificadas = $model->getCountClasificadas();

    return view('admin/clasificacion/index', [
        'compras' => $compras,
        'total_sin_clasificar' => $total_sin_clasificar,
        'total_clasificadas' => $total_clasificadas
    ]);
}
```

**Datos que retorna:**

- Lista de compras pendientes
- Conteo de pendientes
- Conteo de clasificadas

---

#### Método 2: `clasificar($compraId)`

**Propósito:** Mostrar formulario para clasificar una compra  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion/clasificar/{id}`

```php
public function clasificar($compraId)
{
    $compraModel = new CompraModel();
    $tiposModel = new GastoTipoModel();
    $clasificacionModel = new CompraGastoModel();

    $compra = $compraModel->find($compraId);
    $tipos = $tiposModel->getTiposActivos();
    $clasificacion = $clasificacionModel->where('compra_id', $compraId)->first();
    $documentos = $this->getDocumentos($compraId);

    return view('admin/clasificacion/clasificar', [
        'compra' => $compra,
        'tipos' => $tipos,
        'clasificacion' => $clasificacion,
        'documentos' => $documentos
    ]);
}
```

**Variables disponibles en vista:**

- `$compra`: Detalles de la compra
- `$tipos`: Lista de tipos de gasto activos
- `$clasificacion`: Clasificación existente (si existe)
- `$documentos`: Documentos adjuntos

---

#### Método 3: `guardarClasificacion()`

**Propósito:** Guardar o actualizar clasificación (AJAX)  
**HTTP:** POST  
**Ruta:** `/dashboard/clasificacion/guardarClasificacion`

```php
public function guardarClasificacion()
{
    $compraId = $this->request->getPost('compra_id');
    $tipoId = $this->request->getPost('gasto_tipo_id');
    $subcategoriaId = $this->request->getPost('gasto_subcategoria_id');
    $observaciones = $this->request->getPost('observaciones');

    $model = new CompraGastoModel();

    // Busca clasificación existente
    $existe = $model->where('compra_id', $compraId)->first();

    $data = [
        'compra_id' => $compraId,
        'gasto_tipo_id' => $tipoId,
        'gasto_subcategoria_id' => $subcategoriaId,
        'observaciones' => $observaciones,
        'clasificado_por' => user_id(),
        'fecha_clasificacion' => date('Y-m-d H:i:s')
    ];

    if ($existe) {
        $model->update($existe['id'], $data);
    } else {
        $model->insert($data);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Clasificación guardada correctamente'
    ]);
}
```

**Parámetros POST requeridos:**

- `compra_id`: ID de la compra
- `gasto_tipo_id`: ID del tipo de gasto
- `gasto_subcategoria_id`: ID de la subcategoría
- `observaciones`: (Opcional) Notas

---

#### Método 4: `subcategoriasPorTipo($tipoId)`

**Propósito:** Obtener subcategorías por tipo (AJAX dinámico)  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion/subcategoriasPorTipo/{id}`

```php
public function subcategoriasPorTipo($tipoId)
{
    $model = new GastoSubcategoriaModel();
    $subcategorias = $model->where('gasto_tipo_id', $tipoId)
                            ->where('activo', 1)
                            ->findAll();

    return $this->response->setJSON($subcategorias);
}
```

**Retorna:** Array JSON de subcategorías

```json
[
  {
    "id": 61,
    "gasto_tipo_id": 4,
    "nombre": "Mano de Obra",
    "descripcion": "Jornales, salarios de construcción"
  },
  {
    "id": 62,
    "gasto_tipo_id": 4,
    "nombre": "Maquinaria y Equipo",
    "descripcion": "Alquiler y compra de equipos"
  }
]
```

---

#### Método 5: `subirDocumento($compraId)`

**Propósito:** Subir documento adjunto (AJAX)  
**HTTP:** POST  
**Ruta:** `/dashboard/clasificacion/subirDocumento/{id}`

```php
public function subirDocumento($compraId)
{
    $file = $this->request->getFile('archivo');
    $tipoDocumento = $this->request->getPost('tipo_documento');

    if (!$file->isValid()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Archivo inválido'
        ]);
    }

    // Genera nombre único
    $nombreNuevo = $file->getRandomName();
    $ruta = 'uploads/compra_gastos/' . $compraId . '/';

    // Mueve archivo
    $file->move(WRITEPATH . $ruta, $nombreNuevo);

    // Calcula hash
    $hashArchivo = hash_file('sha256', WRITEPATH . $ruta . $nombreNuevo);

    // Guarda registro
    $model = new CompraDocumentoModel();
    $model->insert([
        'compra_id' => $compraId,
        'tipo_documento' => $tipoDocumento,
        'nombre_original' => $file->getClientName(),
        'ruta_archivo' => $ruta . $nombreNuevo,
        'tipo_mime' => $file->getMimeType(),
        'tamanio' => $file->getSize(),
        'hash_archivo' => $hashArchivo,
        'cargado_por' => user_id()
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Documento subido correctamente'
    ]);
}
```

**Parámetros:**

- `archivo`: Archivo multipart/form-data
- `tipo_documento`: factura, recibo, foto, otro

**Retorna:** JSON success/error

---

#### Método 6: `eliminarDocumento($documentoId)`

**Propósito:** Eliminar documento (AJAX)  
**HTTP:** POST  
**Ruta:** `/dashboard/clasificacion/eliminarDocumento/{id}`

```php
public function eliminarDocumento($documentoId)
{
    $model = new CompraDocumentoModel();
    $doc = $model->find($documentoId);

    if (!$doc) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Documento no encontrado'
        ]);
    }

    // Elimina archivo del servidor
    $rutaCompleta = WRITEPATH . $doc['ruta_archivo'];
    if (file_exists($rutaCompleta)) {
        unlink($rutaCompleta);
    }

    // Elimina registro
    $model->delete($documentoId);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Documento eliminado'
    ]);
}
```

---

#### Método 7: `reportes()`

**Propósito:** Listar reportes de gastos  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion/reportes`

```php
public function reportes()
{
    $model = new GastoReporteModel();
    $reportes = $model->reportesActivos();

    return view('admin/clasificacion/reportes', [
        'reportes' => $reportes
    ]);
}
```

---

#### Método 8: `crearReporte()`

**Propósito:** Crear nuevo reporte de gastos  
**HTTP:** POST  
**Ruta:** `/dashboard/clasificacion/guardarReporte` (POST)

```php
public function crearReporte()
{
    $nombre = $this->request->getPost('nombre');
    $fechaInicio = $this->request->getPost('fecha_inicio');
    $fechaFin = $this->request->getPost('fecha_fin');
    $tipoGastoId = $this->request->getPost('tipo_gasto_id');

    $model = new GastoReporteModel();
    $model->insert([
        'nombre' => $nombre,
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
        'tipo_gasto_id' => $tipoGastoId,
        'estado' => 'borrador',
        'usuario_creador' => user_id()
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Reporte creado'
    ]);
}
```

---

#### Método 9: `verReporte($reporteId)`

**Propósito:** Mostrar detalle del reporte  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion/verReporte/{id}`

```php
public function verReporte($reporteId)
{
    $model = new GastoReporteModel();
    $reporte = $model->conDetalles($reporteId);

    return view('admin/clasificacion/ver_reporte', [
        'reporte' => $reporte
    ]);
}
```

---

#### Método 10: `exportarPDF($reporteId)`

**Propósito:** Exportar reporte a PDF  
**HTTP:** GET  
**Ruta:** `/dashboard/clasificacion/exportarPDF/{id}`

```php
public function exportarPDF($reporteId)
{
    $model = new GastoReporteModel();
    $reporte = $model->conDetalles($reporteId);

    // Genera PDF usando DOMPDF
    $html = view('admin/clasificacion/_reporte_pdf', [
        'reporte' => $reporte
    ]);

    // Retorna PDF
    return $this->response
        ->download('reporte_gastos_' . $reporteId . '.pdf', $html)
        ->setHeader('Content-Type', 'application/pdf');
}
```

---

#### Método 11: `enviarAContabilidad($reporteId)`

**Propósito:** Marcar reporte como enviado a contabilidad  
**HTTP:** POST  
**Ruta:** `/dashboard/clasificacion/enviarContabilidad` (POST)

```php
public function enviarAContabilidad()
{
    $reporteId = $this->request->getPost('reporte_id');
    $usuarioContable = $this->request->getPost('usuario_contable_id');

    $model = new GastoReporteModel();
    $model->update($reporteId, [
        'estado' => 'enviado',
        'usuario_contable' => $usuarioContable,
        'fecha_envio' => date('Y-m-d H:i:s')
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Reporte enviado a contabilidad'
    ]);
}
```

---

## Models

### 1. `GastoTipoModel.php`

**Ubicación:** `app/Models/GastoTipoModel.php`  
**Tabla:** `gasto_tipos`  
**Métodos:** 2

#### Método: `getTiposActivos()`

```php
public function getTiposActivos()
{
    return $this->where('activo', 1)
                ->orderBy('id', 'ASC')
                ->findAll();
}
```

**Retorna:** Array todos los tipos de gasto activos

#### Método: `getTipoConSubcategorias($id)`

```php
public function getTipoConSubcategorias($id)
{
    $tipo = $this->find($id);
    if ($tipo) {
        $subModel = new GastoSubcategoriaModel();
        $tipo['subcategorias'] = $subModel->where('gasto_tipo_id', $id)
                                          ->findAll();
    }
    return $tipo;
}
```

**Retorna:** Tipo con array de subcategorías

---

### 2. `GastoSubcategoriaModel.php`

**Ubicación:** `app/Models/GastoSubcategoriaModel.php`  
**Tabla:** `gasto_subcategorias`  
**Métodos:** 3

#### Método: `getPorTipo($gastotipoid)`

```php
public function getPorTipo($gastoTipoId)
{
    return $this->where('gasto_tipo_id', $gastoTipoId)
                ->where('activo', 1)
                ->orderBy('nombre', 'ASC')
                ->findAll();
}
```

**Retorna:** Array subcategorías de un tipo

#### Método: `conTipo($id)`

```php
public function conTipo($id)
{
    return $this->select('gasto_subcategorias.*, gasto_tipos.nombre as tipo_nombre')
                ->join('gasto_tipos', 'gasto_tipos.id = gasto_subcategorias.gasto_tipo_id')
                ->find($id);
}
```

**Retorna:** Subcategoría con nombre del tipo

---

### 3. `CompraGastoModel.php`

**Ubicación:** `app/Models/CompraGastoModel.php`  
**Tabla:** `compra_gastos`  
**Métodos:** 4

#### Método: `getComprasSinClasificar()`

```php
public function getComprasSinClasificar()
{
    return $this->select('c.*, sup.name as proveedor_nombre,
                          CASE WHEN cg.id IS NOT NULL THEN 1 ELSE 0 END as tiene_clasificacion')
                ->from('compras c')
                ->leftJoin('suplidores sup', 'sup.id = c.proveedor_id')
                ->leftJoin('compra_gastos cg', 'cg.compra_id = c.id')
                ->where('c.estado', 'registrado')
                ->orWhere('cg.id IS NULL')
                ->findAll();
}
```

**Retorna:** Compras sin clasificación

#### Método: `conDetalles($id)`

```php
public function conDetalles($id)
{
    return $this->select('cg.*,
                          c.numero_comprobante, gt.nombre as tipo_nombre,
                          gs.nombre as subcategoria_nombre')
                ->join('compras c', 'c.id = cg.compra_id')
                ->join('gasto_tipos gt', 'gt.id = cg.gasto_tipo_id')
                ->join('gasto_subcategorias gs', 'gs.id = cg.gasto_subcategoria_id')
                ->find($id);
}
```

**Retorna:** Clasificación con nombres completos

#### Método: `getCountClasificadas()`

```php
public function getCountClasificadas()
{
    return $this->countAllResults();
}
```

**Retorna:** Total de compras clasificadas

---

### 4. `CompraDocumentoModel.php`

**Ubicación:** `app/Models/CompraDocumentoModel.php`  
**Tabla:** `compra_documentos`  
**Métodos:** 4

#### Método: `porCompra($compraId)`

```php
public function porCompra($compraId)
{
    return $this->where('compra_id', $compraId)
                ->orderBy('fecha_carga', 'DESC')
                ->findAll();
}
```

**Retorna:** Documentos de una compra

#### Método: `verificarIntegridad($id)`

```php
public function verificarIntegridad($id)
{
    $doc = $this->find($id);
    $hashActual = hash_file('sha256', WRITEPATH . $doc['ruta_archivo']);

    return $doc['hash_archivo'] === $hashActual;
}
```

**Retorna:** Boolean - Archivo no modificado

---

### 5. `GastoReporteModel.php`

**Ubicación:** `app/Models/GastoReporteModel.php`  
**Tabla:** `gasto_reportes`  
**Métodos:** 3

#### Método: `reportesActivos()`

```php
public function reportesActivos()
{
    return $this->whereIn('estado', ['borrador', 'procesado', 'enviado'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
}
```

**Retorna:** Reportes activos

#### Método: `conDetalles($id)`

```php
public function conDetalles($id)
{
    $reporte = $this->find($id);

    $gastoModel = new CompraGastoModel();
    $reporte['gastos'] = $gastoModel->where('fecha_clasificacion >=', $reporte['fecha_inicio'])
                                     ->where('fecha_clasificacion <=', $reporte['fecha_fin'])
                                     ->findAll();

    return $reporte;
}
```

**Retorna:** Reporte con gastos asociados

---

## Views

### 1. `index.php` - Dashboard

**Ubicación:** `app/Views/admin/clasificacion/index.php`

**Características:**

- 4 cards con estadísticas (Pendientes, Clasificadas, Total, Porcentaje)
- Tabla responsive con compras
- Botón para clasificar cada compra
- Diseño consistente con admin

**Variables disponibles:**

```php
$compras          // Array de compras
$total_sin_clasificar  // Entero
$total_clasificadas    // Entero
```

**Estructura HTML:**

```html
<!-- Cards Resumen -->
<div class="row">
  <div class="col-md-6 col-xl-3">
    <!-- Pendientes -->
  </div>
  <div class="col-md-6 col-xl-3">
    <!-- Clasificadas -->
  </div>
  <div class="col-md-6 col-xl-3">
    <!-- Total -->
  </div>
  <div class="col-md-12 col-xl-3">
    <!-- Porcentaje -->
  </div>
</div>

<!-- Tabla de Compras -->
<div class="card">
  <table class="table">
    <tr>
      <th>Comprobante</th>
      <th>Proveedor</th>
      <th>Fecha</th>
      <th>Total</th>
      <th>Estado</th>
      <th>Clasificación</th>
      <th>Acciones</th>
    </tr>
  </table>
</div>
```

---

### 2. `clasificar.php` - Formulario

**Ubicación:** `app/Views/admin/clasificacion/clasificar.php`

**Características:**

- Detalles de la compra en card superior
- Formulario de clasificación con 3 campos
- Panel lateral para documentos
- AJAX para carga dinámica de subcategorías
- Subida de archivos con drag-drop

**Variables disponibles:**

```php
$compra             // Array de compra
$tipos              // Array de tipos de gasto
$clasificacion      // Array clasificación existente o null
$documentos         // Array documentos
$proyectos          // Array proyectos
$contratos          // Array contratos
```

**Formulario Principal:**

```html
<form id="formClasificacion">
  <input type="hidden" name="compra_id" value="<?= $compra['id'] ?>" />

  <select name="gasto_tipo_id" id="gastoTipoId" required>
    <!-- Opciones dinámicas -->
  </select>

  <select name="gasto_subcategoria_id" id="subcategoriaId" required>
    <!-- Cargadas por AJAX -->
  </select>

  <select name="proyecto_id">
    <!-- Opcional -->
  </select>
  <select name="contrato_id">
    <!-- Opcional -->
  </select>

  <textarea name="observaciones"></textarea>

  <button type="submit">Guardar</button>
</form>
```

**Script JavaScript:**

```javascript
// Al cambiar tipo, cargar subcategorías
document.getElementById("gastoTipoId").addEventListener("change", function () {
  fetch("/dashboard/clasificacion/subcategoriasPorTipo/" + this.value)
    .then((r) => r.json())
    .then((data) => {
      // Llenar select de subcategorías
    });
});

// Enviar formulario por AJAX
document
  .getElementById("formClasificacion")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    fetch("/dashboard/clasificacion/guardarClasificacion", {
      method: "POST",
      body: new FormData(this),
    })
      .then((r) => r.json())
      .then((data) => {
        if (data.success) {
          Swal.fire("Éxito", data.message, "success");
          setTimeout(
            () => (window.location.href = "/dashboard/clasificacion"),
            1500,
          );
        }
      });
  });
```

---

## Routes

### Actualización en `Routes.php`

**Ubicación:** `app/Config/Routes.php`

**Grupo de rutas agregado:**

```php
$routes->group('dashboard/clasificacion', static function($routes) {
    // Dashboard - GET
    $routes->get('', 'D_clasificacion::index');

    // Formulario clasificación - GET
    $routes->get('clasificar/(:num)', 'D_clasificacion::clasificar/$1');

    // Guardar clasificación - POST (AJAX)
    $routes->post('guardarClasificacion', 'D_clasificacion::guardarClasificacion');

    // Subcategorías dinámicas - GET (AJAX)
    $routes->get('subcategoriasPorTipo/(:num)', 'D_clasificacion::subcategoriasPorTipo/$1');

    // Subir documento - POST (AJAX)
    $routes->post('subirDocumento/(:num)', 'D_clasificacion::subirDocumento/$1');

    // Eliminar documento - POST (AJAX)
    $routes->post('eliminarDocumento/(:num)', 'D_clasificacion::eliminarDocumento/$1');

    // Reportes - GET
    $routes->get('reportes', 'D_clasificacion::reportes');

    // Guardar reporte - POST
    $routes->post('guardarReporte', 'D_clasificacion::crearReporte');
});
```

---

## Integración en Menú

### Actualización en `header.php`

**Ubicación:** `app/Views/admin/header.php`

**Código agregado:**

```php
<?php
// Detectar si estamos en clasificación
$clasificacion_style = (strpos(uri_string(), 'clasificacion') !== false) ? 'active' : '';
$clasificacion_color = (strpos(uri_string(), 'clasificacion') !== false) ? 'text-danger' : '';
?>

<!-- En el menú lateral -->
<li class="nav-item <?= $clasificacion_style ?>">
    <a href="<?= site_url('dashboard/clasificacion') ?>" class="nav-link <?= $clasificacion_color ?>">
        <i class="fa fa-tags"></i>
        <span>Clasificación</span>
    </a>
</li>
```

---

## Flujo de Datos

### 1. Flujo de Clasificación

```
Dashboard (GET /dashboard/clasificacion)
    ↓
Obtiene compras sin clasificación
    ↓
Muestra tabla con botones "Clasificar"
    ↓
Click en "Clasificar"
    ↓
Formulario (GET /dashboard/clasificacion/clasificar/:id)
    ↓
Usuario selecciona Tipo → AJAX carga Subcategorías
    ↓
Usuario selecciona Subcategoría
    ↓
Click "Guardar"
    ↓
POST /dashboard/clasificacion/guardarClasificacion (AJAX)
    ↓
Guarda en tabla compra_gastos
    ↓
Retorna JSON success
    ↓
Redirect a Dashboard
```

### 2. Flujo de Documentos

```
Vista Clasificar
    ↓
Usuario selecciona archivo
    ↓
Click "Subir Documento"
    ↓
POST /dashboard/clasificacion/subirDocumento/:id (FormData + AJAX)
    ↓
Controller valida archivo
    ↓
Copia archivo a writable/uploads/compra_gastos/:id/
    ↓
Calcula SHA256 hash
    ↓
Guarda registro en compra_documentos
    ↓
Retorna JSON success
    ↓
Actualiza lista de documentos en vista
```

---

## API Endpoints

| Método | Endpoint                                            | Descripción                  | Parámetros                                                     |
| ------ | --------------------------------------------------- | ---------------------------- | -------------------------------------------------------------- |
| GET    | `/dashboard/clasificacion`                          | Dashboard principal          | -                                                              |
| GET    | `/dashboard/clasificacion/clasificar/:id`           | Formulario clasificación     | id: compra_id                                                  |
| POST   | `/dashboard/clasificacion/guardarClasificacion`     | Guardar clasificación (AJAX) | compra_id, gasto_tipo_id, gasto_subcategoria_id, observaciones |
| GET    | `/dashboard/clasificacion/subcategoriasPorTipo/:id` | Obtener subcategorías (AJAX) | id: tipo_id                                                    |
| POST   | `/dashboard/clasificacion/subirDocumento/:id`       | Subir documento (AJAX)       | id: compra_id, archivo, tipo_documento                         |
| POST   | `/dashboard/clasificacion/eliminarDocumento/:id`    | Eliminar documento (AJAX)    | id: documento_id                                               |
| GET    | `/dashboard/clasificacion/reportes`                 | Lista de reportes            | -                                                              |
| POST   | `/dashboard/clasificacion/guardarReporte`           | Crear reporte                | nombre, fecha_inicio, fecha_fin, tipo_gasto_id                 |
| GET    | `/dashboard/clasificacion/verReporte/:id`           | Ver reporte                  | id: reporte_id                                                 |
| POST   | `/dashboard/clasificacion/enviarContabilidad`       | Enviar a contabilidad (AJAX) | reporte_id, usuario_contable_id                                |

---

## Ejemplos de Uso

### Ejemplo 1: Obtener Tipos Activos

```php
$tipoModel = new GastoTipoModel();
$tipos = $tipoModel->getTiposActivos();

// Resultado:
// [
//     [
//         'id' => 4,
//         'nombre' => 'Costo de Proyectos',
//         'icono' => 'fa-hammer',
//         'color' => '#28a745',
//         'activo' => 1
//     ]
// ]
```

### Ejemplo 2: Obtener Subcategorías de un Tipo

```php
$subModel = new GastoSubcategoriaModel();
$subs = $subModel->getPorTipo(4);

// Resultado:
// [
//     ['id' => 61, 'nombre' => 'Mano de Obra', ...],
//     ['id' => 62, 'nombre' => 'Maquinaria y Equipo', ...],
//     ...
// ]
```

### Ejemplo 3: Guardar Clasificación

**Request POST a `/dashboard/clasificacion/guardarClasificacion`:**

```json
{
  "compra_id": 1,
  "gasto_tipo_id": 4,
  "gasto_subcategoria_id": 61,
  "observaciones": "Pago a contratista"
}
```

**Response:**

```json
{
  "success": true,
  "message": "Clasificación guardada correctamente"
}
```

### Ejemplo 4: Subir Documento

**Request POST a `/dashboard/clasificacion/subirDocumento/1`:**

```form-data
archivo: [archivo PDF]
tipo_documento: factura
```

**Response:**

```json
{
  "success": true,
  "message": "Documento subido correctamente",
  "documento_id": 152
}
```

---

## Tecnologías Utilizadas

- **Framework:** CodeIgniter 4
- **BD:** MySQL 8.0
- **Frontend:** Bootstrap 5
- **JavaScript:** Vanilla JS + Fetch API
- **Alertas:** SweetAlert2
- **Iconos:** Font Awesome 6
- **Seguridad:** CSRF tokens, Input validation

---

## Archivos de Configuración

### `.env` (Variables importantes)

```
CI_ENVIRONMENT = production
app.baseURL = 'http://localhost:8081/'
database.default.hostname = 127.0.0.1
database.default.database = grupovivencia
```

### Permisos necesarios

- `writable/uploads/` - Escritura habilitada para subida de archivos
- `app/Controllers/` - Lectura para controller
- `app/Models/` - Lectura para models
- `app/Views/` - Lectura para vistas

---

## Próximos Pasos

1. ✅ Crear vistas faltantes (reportes.php, crear_reporte.php, ver_reporte.php)
2. ✅ Implementar exportación de reportes a PDF
3. ✅ Agregar validaciones de permisos (admin solo)
4. ✅ Mejorar diseño de reportes
5. ✅ Agregar búsqueda y filtros avanzados

---

**Documentación generada:** Abril 8, 2026  
**Versión:** 1.0  
**Autor:** Sistema de Clasificación de Gastos
