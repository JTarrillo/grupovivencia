<?php

namespace App\Controllers;

use App\Models\ComprasModel;
use App\Models\SuppliersModel;
use App\Models\ProjectModel;
use App\Models\ContractModel;

class D_compras extends BaseController
{
    protected $comprasModel;
    protected $suppliersModel;
    protected $projectModel;
    protected $contractModel;

    public function __construct()
    {
        $this->comprasModel = new ComprasModel();
        $this->suppliersModel = new SuppliersModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
    }

    /**
     * Listar todas las compras
     */
    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Obtener parámetro de fecha
        $periodo_fecha = service('request')->getGet('periodo_fecha');

        // Obtener datos para formulario inline
        $db = \Config\Database::connect();
        
        try {
            $gastoTipos = $db->table('gasto_tipos')->orderBy('nombre', 'ASC')->get()->getResultArray();
        } catch (\Exception $e) {
            $gastoTipos = [];
            log_message('error', 'Error al cargar gasto_tipos: ' . $e->getMessage());
        }

        try {
            $gastoSubcategorias = $db->table('gasto_subcategorias')->get()->getResultArray();
        } catch (\Exception $e) {
            $gastoSubcategorias = [];
            log_message('error', 'Error al cargar gasto_subcategorias: ' . $e->getMessage());
        }

        try {
            // IGUAL AL INFORME: SELECT con JOIN a gasto_tipos
            $queryStr = '
                SELECT 
                    c.id,
                    c.numero_comprobante,
                    c.fecha_compra,
                    c.total,
                    c.estado,
                    c.comprobante_archivo,
                    c.proveedor_id,
                    s.name as proveedor_nombre,
                    cg.id as gasto_id,
                    cg.gasto_tipo_id,
                    cg.gasto_subcategoria_id,
                    cg.observaciones,
                    gt.nombre as tipo_nombre,
                    gt.color,
                    gs.nombre as subcategoria_nombre
                FROM compras c
                LEFT JOIN suppliers s ON s.id = c.proveedor_id
                LEFT JOIN compra_gastos cg ON cg.compra_id = c.id
                LEFT JOIN gasto_tipos gt ON gt.id = cg.gasto_tipo_id
                LEFT JOIN gasto_subcategorias gs ON gs.id = cg.gasto_subcategoria_id
            ';
            
            if ($periodo_fecha) {
                $queryStr .= ' WHERE DATE(c.fecha_compra) = ? ';
                $comprasRaw = $db->query($queryStr, [$periodo_fecha])->getResultArray();
            } else {
                $comprasRaw = $db->query($queryStr . ' ORDER BY c.fecha_compra DESC LIMIT 100')->getResultArray();
            }

            // Agrupar resultados: una fila por compra con array de gastos
            $compras = [];
            foreach ($comprasRaw as $row) {
                $compraId = $row['id'];
                
                if (!isset($compras[$compraId])) {
                    $compras[$compraId] = [
                        'id' => $row['id'],
                        'numero_comprobante' => $row['numero_comprobante'],
                        'fecha_compra' => $row['fecha_compra'],
                        'total' => $row['total'],
                        'estado' => $row['estado'],
                        'comprobante_archivo' => $row['comprobante_archivo'],
                        'proveedor_id' => $row['proveedor_id'],
                        'proveedor_nombre' => $row['proveedor_nombre'],
                        'gasto_tipo_id' => null,
                        'gasto_subcategoria_id' => null,
                        'observaciones' => '',
                        'gastos' => []
                    ];
                }
                
                // Agregar gasto si existe
                if (!empty($row['gasto_id'])) {
                    if ($compras[$compraId]['gasto_tipo_id'] === null) {
                        $compras[$compraId]['gasto_tipo_id'] = $row['gasto_tipo_id'];
                        $compras[$compraId]['gasto_subcategoria_id'] = $row['gasto_subcategoria_id'];
                        $compras[$compraId]['observaciones'] = $row['observaciones'] ?? '';
                    }

                    $compras[$compraId]['gastos'][] = [
                        'id' => $row['gasto_id'],
                        'tipo_nombre' => $row['tipo_nombre'],
                        'color' => $row['color'],
                        'subcategoria_nombre' => $row['subcategoria_nombre'] ?? ''
                    ];
                }
            }
            
            // Reindexar array
            $compras = array_values($compras);
            
        } catch (\Exception $e) {
            $compras = [];
            log_message('error', 'Error al cargar compras: ' . $e->getMessage());
        }

        try {
            $proveedores = $db->table('suppliers')->orderBy('name', 'ASC')->get()->getResultArray();
        } catch (\Exception $e) {
            $proveedores = [];
            log_message('error', 'Error al cargar proveedores: ' . $e->getMessage());
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Módulo de Compras',
            'compras' => $compras,
            'proveedores' => $proveedores,
            'proyectos' => [],
            'contratos' => [],
            'gastoTipos' => $gastoTipos,
            'gastoSubcategorias' => $gastoSubcategorias,
            'periodo_fecha' => $periodo_fecha ?? date('Y-m-d')
        ];

        return view('admin/compras/list_simple', $data);
    }

    /**
     * Vista para crear nueva compra
     */
    public function create()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Registrar Nueva Compra',
            'proveedores' => $this->suppliersModel->findAll(),
            'proyectos' => $this->projectModel->findAll(),
            'contratos' => $this->contractModel->findAll(),
            'clasificaciones' => [
                ['id' => 1, 'nombre' => 'Materiales'],
                ['id' => 2, 'nombre' => 'Servicios'],
                ['id' => 3, 'nombre' => 'Activos'],
                ['id' => 4, 'nombre' => 'Suministros'],
                ['id' => 5, 'nombre' => 'Otros']
            ]
        ];

        if ($this->request->getMethod() === 'post') {
            return $this->store();
        }

        return view('admin/compras/create', $data);
    }

    /**
     * Guardar nueva compra (POST)
     */
    public function store()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        $session = session();

        try {
            // Obtener datos del formulario
            $proveedor_id = $this->request->getPost('proveedor_id');
            $numero_comprobante = $this->request->getPost('numero_comprobante');
            $tipo_comprobante = $this->request->getPost('tipo_comprobante');
            $fecha_compra = $this->request->getPost('fecha_compra');
            $subtotal = (float) $this->request->getPost('subtotal') ?: 0;
            $igv = (float) $this->request->getPost('igv') ?: 0;
            $total = (float) $this->request->getPost('total') ?: 0;
            $descripcion = $this->request->getPost('descripcion') ?: '';
            $gasto_tipo_id = $this->request->getPost('gasto_tipo_id');
            $gasto_subcategoria_id = $this->request->getPost('gasto_subcategoria_id');
            $igvRate = 0.18;

            if ($total > 0 && $subtotal <= 0) {
                $subtotal = round($total / (1 + $igvRate), 2);
                $igv = round($total - $subtotal, 2);
            } elseif ($subtotal > 0 && $total <= 0) {
                $igv = round($subtotal * $igvRate, 2);
                $total = round($subtotal + $igv, 2);
            } elseif ($subtotal > 0 && $total > 0) {
                $igv = round($total - $subtotal, 2);
            }
            // Validaciones
            if (empty($proveedor_id) || empty($numero_comprobante) || empty($fecha_compra) || empty($total)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Faltan datos requeridos: Proveedor, Comprobante, Fecha y Total son obligatorios'
                ]);
            }

            if (empty($gasto_tipo_id) || empty($gasto_subcategoria_id)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Faltan datos requeridos: Tipo de Gasto y Subcategoría son obligatorios'
                ]);
            }

            // Validar que proveedor existe
            $proveedor = $this->suppliersModel->find($proveedor_id);
            if (!$proveedor) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El proveedor seleccionado no existe'
                ]);
            }

            // PROCESAR ARCHIVO ADJUNTO
            $comprobante_archivo = null;
            $file = $this->request->getFile('comprobante_archivo');
            
            log_message('error', '=== PROCESANDO ARCHIVO ===');
            log_message('error', 'File object existe: ' . ($file ? 'YES' : 'NO'));
            
            if ($file) {
                log_message('error', 'Archivo: ' . $file->getName());
                log_message('error', 'isValid: ' . ($file->isValid() ? 'YES' : 'NO'));
                log_message('error', 'hasMoved: ' . ($file->hasMoved() ? 'YES' : 'NO'));
                log_message('error', 'Size: ' . $file->getSize() . ' bytes');
                log_message('error', 'MIME: ' . $file->getMimeType());
                log_message('error', 'Extension: ' . $file->getClientExtension());
            } else {
                log_message('error', 'NO FILE RECEIVED');
            }
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validaciones del archivo
                $maxSize = 5 * 1024 * 1024; // 5MB
                $allowedMimes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                $allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];
                
                if ($file->getSize() > $maxSize) {
                    log_message('error', 'FILE TOO LARGE');
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'El archivo excede el tamaño máximo de 5MB'
                    ]);
                }
                
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    log_message('error', 'MIME NOT ALLOWED: ' . $file->getMimeType());
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Tipo de archivo no permitido. Use: PDF, JPG, PNG. Recibido: ' . $file->getMimeType()
                    ]);
                }
                
                // Generar nombre único para el archivo
                $extension = $file->getClientExtension();
                $filename = 'comprobante_' . date('YmdHis') . '_' . uniqid() . '.' . $extension;
                
                // Crear directorio si no existe
                $uploadPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'comprobantes';
                log_message('error', 'Upload path: ' . $uploadPath);
                log_message('error', 'Directory exists: ' . (is_dir($uploadPath) ? 'YES' : 'NO'));
                
                if (!is_dir($uploadPath)) {
                    log_message('error', 'Creating directory...');
                    mkdir($uploadPath, 0755, true);
                }
                
                // Mover archivo
                try {
                    log_message('error', 'Moving file: ' . $filename);
                    $file->move($uploadPath, $filename);
                    $comprobante_archivo = 'comprobantes/' . $filename;
                    log_message('error', '✅ FILE UPLOADED: ' . $comprobante_archivo);
                } catch (\Exception $e) {
                    log_message('error', '❌ ERROR MOVING FILE: ' . $e->getMessage());
                    log_message('error', 'Stack: ' . $e->getTraceAsString());
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Error al subir el archivo: ' . $e->getMessage()
                    ]);
                }
            } else {
                log_message('error', 'SKIPPED FILE PROCESSING - Conditions: file=' . ($file ? 'YES' : 'NO') . ', isValid=' . ($file && $file->isValid() ? 'YES' : 'NO') . ', hasMoved=' . ($file && $file->hasMoved() ? 'YES' : 'NO'));
            }

            // Insertar compra
            $compraData = [
                'proveedor_id' => $proveedor_id,
                'numero_comprobante' => $numero_comprobante,
                'tipo_comprobante' => $tipo_comprobante,
                'fecha_compra' => $fecha_compra,
                'subtotal' => $subtotal,
                'igv' => $igv,
                'total' => $total,
                'descripcion' => $descripcion,
                'comprobante_archivo' => $comprobante_archivo,
                'estado' => 'clasificado'  // Cambiar a clasificado porque ya tiene gasto tipo
            ];

            $compra_id = $this->comprasModel->insert($compraData);

            if ($compra_id) {
                // Guardar automáticamente la clasificación de gasto
                $db = \Config\Database::connect();
                $clasificacionData = [
                    'compra_id' => $compra_id,
                    'gasto_tipo_id' => $gasto_tipo_id,
                    'gasto_subcategoria_id' => $gasto_subcategoria_id,
                    'observaciones' => $descripcion,
                    'clasificado_por' => $session->get('id'),
                    'fecha_clasificacion' => date('Y-m-d H:i:s')
                ];
                
                $db->table('compra_gastos')->insert($clasificacionData);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Compra registrada y clasificada exitosamente',
                    'compra_id' => $compra_id
                ]);
            } else {
                $error = $this->comprasModel->errors();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al registrar la compra: ' . json_encode($error)
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Ver detalles de compra
     */
    public function view($id)
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $compra = $this->comprasModel->getCompraById($id);

        if (!$compra) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Detalles de Compra',
            'compra' => $compra
        ];

        return view('admin/compras/view', $data);
    }

    /**
     * Ver detalles de compra para modal (HTML parcial)
     */
    public function viewModal($id)
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setBody('<div class="alert alert-danger mb-0">Sesión expirada. Inicia sesión nuevamente.</div>');
        }

        $compra = $this->comprasModel->getCompraById($id);

        if (!$compra) {
            return $this->response->setStatusCode(404)->setBody('<div class="alert alert-warning mb-0">Compra no encontrada.</div>');
        }

        return view('admin/compras/partials/detalle_modal', [
            'compra' => $compra,
        ]);
    }

    /**
     * Clasificar compra (cambiar estado y clasificación)
     */
    public function clasificar()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        try {
            $compra_id = $this->request->getPost('compra_id');
            $clasificacion = $this->request->getPost('clasificacion');
            $proyecto_id = $this->request->getPost('proyecto_id');
            $contrato_id = $this->request->getPost('contrato_id');

            $updateData = [
                'clasificacion' => $clasificacion,
                'estado' => 'clasificado',
                'proyecto_id' => $proyecto_id ?: null,
                'contrato_id' => $contrato_id ?: null
            ];

            if ($this->comprasModel->update($compra_id, $updateData)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Compra clasificada exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al clasificar compra'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Aprobar compra
     */
    public function aprobar()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
        }

        $session = session();

        try {
            $compra_id = $this->request->getPost('compra_id');

            $updateData = [
                'estado' => 'aprobado'
            ];

            if ($this->comprasModel->update($compra_id, $updateData)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Compra aprobada exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al aprobar compra'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generar reporte de compras
     */
    public function reporte()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-01');
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');
        $clasificacion = $this->request->getGet('clasificacion');

        $compras = $this->comprasModel->getReportePorFechas($fecha_inicio, $fecha_fin);

        if ($clasificacion) {
            $compras = array_filter($compras, function ($c) use ($clasificacion) {
                return $c['clasificacion'] == $clasificacion;
            });
        }

        $estadisticas = $this->comprasModel->getEstadisticas();

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Reporte de Compras',
            'compras' => $compras,
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'clasificacion' => $clasificacion
        ];

        return view('admin/compras/reporte', $data);
    }

    /**
     * Descargar comprobante PDF
     */
    public function descargarComprobante($id)
    {
        $compra = $this->comprasModel->find($id);

        if (!$compra || !$compra['pdf_url']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $filePath = WRITEPATH . $compra['pdf_url'];

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Obtener gastos clasificados por compra (AJAX)
     */
    public function getGastosByCompra($compra_id = null)
    {
        // LOG INMEDIATO - Debug en error_log
        error_log('=== DEBUG getGastosByCompra START ===');
        error_log('Compra ID: ' . $compra_id);
        
        $this->response->setContentType('application/json; charset=UTF-8');
        error_log('Content-Type establecido');

        try {
            // Validación de sesión (como fallback del filtro)
            $session_logged_in = session()->get('isLoggedIn');
            error_log('Session isLoggedIn: ' . ($session_logged_in ? 'TRUE' : 'FALSE'));
            
            if (!$session_logged_in) {
                error_log('No hay sesión, devolviendo 401');
                return $this->response
                    ->setStatusCode(401)
                    ->setJSON([
                        'error' => true,
                        'message' => 'No autorizado. Por favor inicia sesión.'
                    ]);
            }

            if (empty($compra_id)) {
                error_log('Compra ID vacío, devolviendo array vacío');
                return $this->response->setJSON([]);
            }

            $db = \Config\Database::connect();
            
            // Consulta para obtener gastos clasificados
            error_log('Ejecutando query para compra_id: ' . $compra_id);
            $gastos = $db->query('
                SELECT 
                    cg.id,
                    cg.compra_id,
                    cg.gasto_tipo_id,
                    cg.gasto_subcategoria_id,
                    cg.observaciones,
                    gt.nombre as tipo_nombre,
                    gt.color,
                    gs.nombre as subcategoria_nombre
                FROM compra_gastos cg
                LEFT JOIN gasto_tipos gt ON gt.id = cg.gasto_tipo_id
                LEFT JOIN gasto_subcategorias gs ON gs.id = cg.gasto_subcategoria_id
                WHERE cg.compra_id = ?
                ORDER BY cg.id DESC
            ', [$compra_id])->getResultArray();
            
            error_log('Gastos encontrados: ' . count($gastos));
            error_log('=== DEBUG getGastosByCompra END - OK ===');
            
            return $this->response->setJSON($gastos);
            
        } catch (\Exception $e) {
            error_log('EXCEPTION en getGastosByCompra: ' . $e->getMessage());
            error_log('Stack: ' . $e->getTraceAsString());
            log_message('error', 'Error en getGastosByCompra: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'error' => true,
                    'message' => $e->getMessage()
                ]);
        }
    }

    /**
     * Guardar clasificación de gasto (AJAX)
     */
    public function guardarClasificacionGasto()
    {
        $isAjax = $this->request->isAJAX()
            || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest'
            || str_contains($this->request->getHeaderLine('Accept'), 'application/json');

        if ($isAjax) {
            $this->response->setContentType('application/json');
        }

        $redirectTo = $this->request->getPost('redirect_to') ?: base_url('dashboard/compras');

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Sólo se aceptan peticiones POST'
                ]);
            }

            return redirect()->to($redirectTo)
                ->with('error', 'Sólo se aceptan peticiones POST');
        }

        $session = session();

        try {
            $db = \Config\Database::connect();
            $compra_id = $this->request->getPost('compra_id');
            $gasto_tipo_id = $this->request->getPost('gasto_tipo_id');
            $gasto_subcategoria_id = $this->request->getPost('gasto_subcategoria_id');
            $proyecto_id = $this->request->getPost('proyecto_id') ?: null;
            $observaciones = $this->request->getPost('observaciones') ?: '';

            // Validaciones
            if (!$compra_id || !$gasto_tipo_id) {
                if ($isAjax) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Compra ID y Tipo de Gasto son requeridos'
                    ]);
                }

                return redirect()->to($redirectTo)
                    ->with('error', 'Compra ID y Tipo de Gasto son requeridos');
            }

            // Validar compra existe
            $compra = $this->comprasModel->find($compra_id);
            if (!$compra) {
                if ($isAjax) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Compra no encontrada'
                    ]);
                }

                return redirect()->to($redirectTo)
                    ->with('error', 'Compra no encontrada');
            }

            // Clasificación solo si no existe
            $existe = $db->table('compra_gastos')
                ->where('compra_id', $compra_id)
                ->countAllResults();

            if ($existe > 0) {
                // Actualizar
                $db->table('compra_gastos')
                    ->where('compra_id', $compra_id)
                    ->update([
                        'gasto_tipo_id' => $gasto_tipo_id,
                        'gasto_subcategoria_id' => $gasto_subcategoria_id,
                        'proyecto_id' => $proyecto_id,
                        'observaciones' => $observaciones,
                        'clasificado_por' => $session->get('id'),
                        'fecha_clasificacion' => date('Y-m-d H:i:s')
                    ]);
            } else {
                // Insertar
                $db->table('compra_gastos')->insert([
                    'compra_id' => $compra_id,
                    'gasto_tipo_id' => $gasto_tipo_id,
                    'gasto_subcategoria_id' => $gasto_subcategoria_id,
                    'proyecto_id' => $proyecto_id,
                    'observaciones' => $observaciones,
                    'clasificado_por' => $session->get('id'),
                    'fecha_clasificacion' => date('Y-m-d H:i:s')
                ]);
            }

            // Actualizar estado de compra a clasificado
            $this->comprasModel->update($compra_id, ['estado' => 'clasificado']);

            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Clasificación guardada exitosamente'
                ]);
            }

            return redirect()->to($redirectTo)
                ->with('success', 'Clasificación guardada exitosamente');

        } catch (\Exception $e) {
            log_message('error', 'Error en guardarClasificacionGasto: ' . $e->getMessage());

            if ($isAjax) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'success' => false,
                        'message' => 'Error: ' . $e->getMessage()
                    ]);
            }

            return redirect()->to($redirectTo)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar clasificación de gastos de una compra
     */
    public function deleteGastos($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $redirectTo = $this->request->getPost('redirect_to') ?: base_url('dashboard/compras');

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return redirect()->to($redirectTo)->with('error', 'Método no permitido');
        }

        try {
            $db = \Config\Database::connect();

            $compra = $this->comprasModel->find($id);
            if (!$compra) {
                return redirect()->to($redirectTo)->with('error', 'Compra no encontrada');
            }

            $db->table('compra_gastos')->where('compra_id', $id)->delete();
            $this->comprasModel->update($id, ['estado' => 'registrado']);

            return redirect()->to($redirectTo)
                ->with('success', 'Clasificación de gastos eliminada exitosamente');
        } catch (\Exception $e) {
            log_message('error', 'Error en deleteGastos: ' . $e->getMessage());
            return redirect()->to($redirectTo)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar compra
     */
    public function delete($id)
    {
        $session = session();
        $isAjax = $this->request->isAJAX();
        if (!$session->get('isLoggedIn')) {
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'SesiÃ³n expirada'
                ])->setStatusCode(401);
            }
            return redirect()->to(base_url('login'));
        }

        $redirectTo = base_url('dashboard/compras');
        
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'MÃ©todo no permitido'
                ])->setStatusCode(405);
            }
            return redirect()->to($redirectTo)->with('error', 'Método no permitido');
        }

        try {
            $db = \Config\Database::connect();
            
            // Eliminar gastos asociados
            $db->table('compra_gastos')->where('compra_id', $id)->delete();
            
            // Eliminar compra
            $this->comprasModel->delete($id);

            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Compra eliminada exitosamente',
                    'id' => (int) $id
                ]);
            }

            return redirect()->to($redirectTo)
                ->with('success', 'Compra eliminada exitosamente');
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar compra: ' . $e->getMessage());

            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al eliminar la compra: ' . $e->getMessage()
                ])->setStatusCode(500);
            }

            return redirect()->to($redirectTo)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
