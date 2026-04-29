<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\GastoTipoModel;
use App\Models\GastoSubcategoriaModel;
use App\Models\CompraGastoModel;
use App\Models\CompraDocumentoModel;
use App\Models\GastoReporteModel;

class D_clasificacion extends BaseController
{
    protected $comprasModel;
    protected $gastoTipoModel;
    protected $gastoSubcategoriaModel;
    protected $compraGastoModel;
    protected $compraDocumentoModel;
    protected $gastoReporteModel;

    public function __construct()
    {
        $this->comprasModel = new ComprasModel();
        $this->gastoTipoModel = new GastoTipoModel();
        $this->gastoSubcategoriaModel = new GastoSubcategoriaModel();
        $this->compraGastoModel = new CompraGastoModel();
        $this->compraDocumentoModel = new CompraDocumentoModel();
        $this->gastoReporteModel = new GastoReporteModel();
    }

    public function index()
    {
        // Obtener parámetro de fecha (formato: YYYY-MM-DD)
        $periodo_fecha = service('request')->getGet('periodo_fecha');
        
        // Obtener compras sin clasificar
        $db = db_connect();
        
        // Construir condición WHERE dinámicamente
        $where_conditions = "WHERE c.estado IN ('registrado', 'clasificado')";
        $parameters = [];

        // Filtrar por fecha específica
        if ($periodo_fecha) {
            $where_conditions .= " AND DATE(c.fecha_compra) = ?";
            $parameters[] = $periodo_fecha;
        }

        $query = $db->query("
            SELECT 
                c.id, c.numero_comprobante, c.tipo_comprobante, c.fecha_compra,
                c.total, c.estado, c.descripcion,
                s.name as proveedor_nombre,
                COUNT(cg.id) as tiene_clasificacion
            FROM compras c
            LEFT JOIN suppliers s ON s.id = c.proveedor_id
            LEFT JOIN compra_gastos cg ON cg.compra_id = c.id
            $where_conditions
            GROUP BY c.id
            ORDER BY c.fecha_compra DESC
        ", $parameters);

        // Validar si la query fue exitosa
        if (!$query) {
            $error = $db->error();
            log_message('error', 'SQL Error en D_clasificacion::index - ' . $error['message']);
            $compras = [];
        } else {
            $compras = $query->getResultArray();
        }

        // Calcular totales
        $total_sin_clasificar = count(array_filter($compras, fn($c) => $c['tiene_clasificacion'] == 0));
        $total_clasificadas = count(array_filter($compras, fn($c) => $c['tiene_clasificacion'] > 0));
        $total_mes = array_sum(array_column($compras, 'total'));

        $data = [
            'compras' => $compras,
            'total_sin_clasificar' => $total_sin_clasificar,
            'total_clasificadas' => $total_clasificadas,
            'total_mes' => $total_mes,
            'periodo_fecha' => $periodo_fecha ?? date('Y-m-d'),
            'gastoTipos' => $this->gastoTipoModel->getTiposActivos(),
            'gastoSubcategorias' => $this->gastoSubcategoriaModel->findAll(),
        ];

        return view('admin/clasificacion/index', $data);
    }

    /**
     * Catalogo de tipos y subcategorias de gastos
     */
    public function catalogo()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'tipos' => $this->gastoTipoModel->orderBy('nombre', 'ASC')->findAll(),
            'subcategorias' => $this->gastoSubcategoriaModel
                ->select('gasto_subcategorias.*, gasto_tipos.nombre AS tipo_nombre')
                ->join('gasto_tipos', 'gasto_tipos.id = gasto_subcategorias.gasto_tipo_id', 'left')
                ->orderBy('gasto_tipos.nombre', 'ASC')
                ->orderBy('gasto_subcategorias.nombre', 'ASC')
                ->findAll(),
        ];

        return view('admin/clasificacion/catalogo', $data);
    }

    /**
     * Detectar si la peticion espera JSON (AJAX/fetch)
     */
    private function isAjaxRequest(): bool
    {
        return $this->request->isAJAX()
            || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest'
            || str_contains($this->request->getHeaderLine('Accept'), 'application/json');
    }

    /**
     * Respuesta JSON consistente para operaciones de catalogo
     */
    private function jsonCatalogResponse(bool $success, string $message, array $extra = [], int $status = 200)
    {
        return $this->response->setStatusCode($status)->setJSON(array_merge([
            'success' => $success,
            'message' => $message,
            'csrfName' => csrf_token(),
            'csrfHash' => csrf_hash(),
        ], $extra));
    }

    /**
     * Crear tipo de gasto
     */
    public function crearTipo()
    {
        $session = session();
        $isAjax = $this->isAjaxRequest();

        if (!$session->get('isLoggedIn')) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No autorizado. Inicia sesion nuevamente.', [], 401);
            }
            return redirect()->to(base_url('login'));
        }

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Metodo no permitido', [], 405);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Metodo no permitido');
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        $icono = trim((string) $this->request->getPost('icono'));
        $descripcion = trim((string) $this->request->getPost('descripcion'));
        $color = trim((string) $this->request->getPost('color'));

        if ($nombre === '') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'El nombre del tipo es obligatorio', [], 422);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'El nombre del tipo es obligatorio');
        }

        $exists = $this->gastoTipoModel
            ->where('LOWER(nombre)', strtolower($nombre))
            ->countAllResults();

        if ($exists > 0) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Ya existe un tipo de gasto con ese nombre', [], 409);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Ya existe un tipo de gasto con ese nombre');
        }

        $data = [
            'nombre' => $nombre,
            'icono' => $icono ?: 'fa fa-tag',
            'descripcion' => $descripcion,
            'color' => $color ?: '#6c757d',
            'activo' => 1,
        ];

        if (!$this->gastoTipoModel->insert($data)) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se pudo crear el tipo de gasto', [], 500);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se pudo crear el tipo de gasto');
        }

        $nuevoId = $this->gastoTipoModel->getInsertID();
        if ($isAjax) {
            return $this->jsonCatalogResponse(true, 'Tipo de gasto creado correctamente', [
                'tipo' => [
                    'id' => $nuevoId,
                    'nombre' => $nombre,
                    'color' => $color ?: '#6c757d',
                ],
            ]);
        }

        return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
            ->with('success', 'Tipo de gasto creado correctamente');
    }

    /**
     * Eliminar tipo de gasto
     */
    public function eliminarTipo($id)
    {
        $session = session();
        $isAjax = $this->isAjaxRequest();

        if (!$session->get('isLoggedIn')) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No autorizado. Inicia sesion nuevamente.', [], 401);
            }
            return redirect()->to(base_url('login'));
        }

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Metodo no permitido', [], 405);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Metodo no permitido');
        }

        $db = db_connect();

        $usoEnCompraGastos = $db->table('compra_gastos')->where('gasto_tipo_id', $id)->countAllResults();
        if ($usoEnCompraGastos > 0) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se puede eliminar: el tipo ya esta usado en compras clasificadas', [], 409);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se puede eliminar: el tipo ya esta usado en compras clasificadas');
        }

        if (!$this->gastoTipoModel->delete($id)) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se pudo eliminar el tipo de gasto', [], 500);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se pudo eliminar el tipo de gasto');
        }

        if ($isAjax) {
            return $this->jsonCatalogResponse(true, 'Tipo de gasto eliminado correctamente', [
                'deletedId' => (int) $id,
            ]);
        }

        return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
            ->with('success', 'Tipo de gasto eliminado correctamente');
    }

    /**
     * Crear subcategoria de gasto
     */
    public function crearSubcategoria()
    {
        $session = session();
        $isAjax = $this->isAjaxRequest();

        if (!$session->get('isLoggedIn')) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No autorizado. Inicia sesion nuevamente.', [], 401);
            }
            return redirect()->to(base_url('login'));
        }

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Metodo no permitido', [], 405);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Metodo no permitido');
        }

        $gastoTipoId = (int) $this->request->getPost('gasto_tipo_id');
        $nombre = trim((string) $this->request->getPost('nombre'));
        $descripcion = trim((string) $this->request->getPost('descripcion'));

        if ($gastoTipoId <= 0 || $nombre === '') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Tipo de gasto y nombre son obligatorios', [], 422);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Tipo de gasto y nombre son obligatorios');
        }

        $tipoExiste = $this->gastoTipoModel->find($gastoTipoId);
        if (!$tipoExiste) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'El tipo de gasto seleccionado no existe', [], 422);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'El tipo de gasto seleccionado no existe');
        }

        $exists = $this->gastoSubcategoriaModel
            ->where('gasto_tipo_id', $gastoTipoId)
            ->where('LOWER(nombre)', strtolower($nombre))
            ->countAllResults();

        if ($exists > 0) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Esa subcategoria ya existe para el tipo seleccionado', [], 409);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Esa subcategoria ya existe para el tipo seleccionado');
        }

        $data = [
            'gasto_tipo_id' => $gastoTipoId,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'activo' => 1,
        ];

        if (!$this->gastoSubcategoriaModel->insert($data)) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se pudo crear la subcategoria', [], 500);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se pudo crear la subcategoria');
        }

        $nuevoId = $this->gastoSubcategoriaModel->getInsertID();
        if ($isAjax) {
            return $this->jsonCatalogResponse(true, 'Subcategoria creada correctamente', [
                'subcategoria' => [
                    'id' => $nuevoId,
                    'nombre' => $nombre,
                    'tipo_nombre' => $tipoExiste['nombre'] ?? '',
                ],
            ]);
        }

        return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
            ->with('success', 'Subcategoria creada correctamente');
    }

    /**
     * Eliminar subcategoria de gasto
     */
    public function eliminarSubcategoria($id)
    {
        $session = session();
        $isAjax = $this->isAjaxRequest();

        if (!$session->get('isLoggedIn')) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No autorizado. Inicia sesion nuevamente.', [], 401);
            }
            return redirect()->to(base_url('login'));
        }

        if (strtoupper($this->request->getMethod()) !== 'POST') {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'Metodo no permitido', [], 405);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'Metodo no permitido');
        }

        $db = db_connect();
        $usoEnCompraGastos = $db->table('compra_gastos')->where('gasto_subcategoria_id', $id)->countAllResults();
        if ($usoEnCompraGastos > 0) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se puede eliminar: la subcategoria ya esta usada en compras clasificadas', [], 409);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se puede eliminar: la subcategoria ya esta usada en compras clasificadas');
        }

        if (!$this->gastoSubcategoriaModel->delete($id)) {
            if ($isAjax) {
                return $this->jsonCatalogResponse(false, 'No se pudo eliminar la subcategoria', [], 500);
            }
            return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
                ->with('error', 'No se pudo eliminar la subcategoria');
        }

        if ($isAjax) {
            return $this->jsonCatalogResponse(true, 'Subcategoria eliminada correctamente', [
                'deletedId' => (int) $id,
            ]);
        }

        return redirect()->to(site_url('dashboard/clasificacion/catalogo'))
            ->with('success', 'Subcategoria eliminada correctamente');
    }

    /**
     * Obtener detalles de compra por AJAX
     */
    public function detalles($compraId)
    {
        $this->response->setContentType('application/json');
        
        $compra = $this->comprasModel->find($compraId);
        
        if (!$compra) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Compra no encontrada'
            ]);
        }

        return $this->response->setJSON($compra);
    }

    /**
     * Mostrar formulario para clasificar compra
     */
    public function clasificar($compraId)
    {
        $compra = $this->comprasModel->find($compraId);
        if (!$compra) {
            return redirect()->back()->with('error', 'Compra no encontrada');
        }

        // Obtener clasificación actual si existe
        $clasificacionActual = $this->compraGastoModel->where('compra_id', $compraId)->first();

        // Obtener tipos de gasto
        $tipos = $this->gastoTipoModel->getTiposActivos();

        // Obtener documentos adjuntos
        $documentos = $this->compraDocumentoModel->porCompra($compraId);

        $data = [
            'compra' => $compra,
            'clasificacion' => $clasificacionActual,
            'tipos' => $tipos,
            'documentos' => $documentos,
        ];

        return view('admin/clasificacion/clasificar', $data);
    }

    /**
     * Guardar clasificación de compra
     */
    public function guardarClasificacion()
    {
        if (!$this->request->isAjax()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solicitud inválida']);
        }

        $compraId = $this->request->getPost('compra_id');
        $tipoId = $this->request->getPost('gasto_tipo_id');
        $subcategoriaId = $this->request->getPost('gasto_subcategoria_id');
        $observaciones = $this->request->getPost('observaciones');

        if (!$compraId || !$tipoId || !$subcategoriaId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Faltan campos requeridos'
            ]);
        }

        // Verificar que compra existe
        $compra = $this->comprasModel->find($compraId);
        if (!$compra) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Compra no encontrada'
            ]);
        }

        // Eliminar clasificación anterior si existe
        $this->compraGastoModel->where('compra_id', $compraId)->delete();

        // Crear nueva clasificación
        $data = [
            'compra_id' => $compraId,
            'gasto_tipo_id' => $tipoId,
            'gasto_subcategoria_id' => $subcategoriaId,
            'observaciones' => $observaciones,
            'clasificado_por' => session()->get('id'),
            'fecha_clasificacion' => date('Y-m-d H:i:s'),
        ];

        if ($this->compraGastoModel->insert($data)) {
            // Cambiar estado de compra a clasificado
            $this->comprasModel->update($compraId, [
                'estado' => 'clasificado'
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Compra clasificada exitosamente'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al guardar clasificación'
        ]);
    }

    /**
     * Cargar subcategorías por tipo (AJAX)
     */
    public function subcategoriasPorTipo($tipoId)
    {
        $subcategorias = $this->gastoSubcategoriaModel->getPorTipo($tipoId);
        return $this->response->setJSON($subcategorias);
    }

    /**
     * Cargar documentos de compra (AJAX)
     */
    public function cargarDocumentos($compraId)
    {
        $documentos = $this->compraDocumentoModel->porCompra($compraId);
        return $this->response->setJSON($documentos);
    }

    /**
     * Subir documento para compra
     */
    public function subirDocumento($compraId)
    {
        if (!$this->request->isAjax()) {
            return $this->response->setJSON(['success' => false]);
        }

        $archivo = $this->request->getFile('archivo');
        $tipoDocumento = $this->request->getPost('tipo_documento');
        $descripcion = $this->request->getPost('descripcion');

        // Validar
        if (!$archivo || !$archivo->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Archivo inválido'
            ]);
        }

        // Crear directorio si no existe
        $directorioBase = 'writable/uploads/compras_documentos';
        if (!is_dir(ROOTPATH . $directorioBase)) {
            mkdir(ROOTPATH . $directorioBase, 0755, true);
        }

        // Mover archivo
        $nuevoNombre = $archivo->getRandomName();
        $ruta = $directorioBase . '/' . $nuevoNombre;
        $archivo->move(ROOTPATH . $directorioBase, $nuevoNombre);

        // Calcular hash
        $hash = hash_file('sha256', ROOTPATH . $ruta);

        // Guardar en BD
        $dataDocumento = [
            'compra_id' => $compraId,
            'tipo_documento' => $tipoDocumento,
            'nombre_original' => $archivo->getClientName(),
            'ruta_archivo' => $ruta,
            'tipo_mime' => $archivo->getMimeType(),
            'tamanio' => $archivo->getSize(),
            'hash_archivo' => $hash,
            'cargado_por' => session()->get('id'),
            'descripcion' => $descripcion,
        ];

        if ($this->compraDocumentoModel->insert($dataDocumento)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Documento cargado exitosamente',
                'id' => $this->compraDocumentoModel->getInsertID()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al guardar documento'
        ]);
    }

    /**
     * Eliminar documento
     */
    public function eliminarDocumento($documentoId)
    {
        if (!$this->request->isAjax()) {
            return $this->response->setJSON(['success' => false]);
        }

        if ($this->compraDocumentoModel->borrarDocumento($documentoId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Documento eliminado'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al eliminar documento'
        ]);
    }

    /**
     * Informe detallado por período (rango de fechas)
     */
    public function informe()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Obtener parámetros
        $fecha_inicio = service('request')->getGet('fecha_inicio') ?? date('Y-m-01');
        $fecha_fin = service('request')->getGet('fecha_fin') ?? date('Y-m-d');
        $numero_informe = trim((string) (service('request')->getGet('numero_informe') ?? 'N°032-2026-DFCL'));
        $asunto = trim((string) (service('request')->getGet('asunto') ?? ''));
        $cuerpo_informe = trim((string) (service('request')->getGet('cuerpo_informe') ?? ''));

        if ($asunto === '') {
            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
            $asunto = 'INFORME MENSUAL CORRESPONDIENTE AL MES DE ' . $meses[(int) date('m', strtotime($fecha_inicio)) - 1];
        }

        if ($cuerpo_informe === '') {
            $cuerpo_informe = 'El presente informe tiene como finalidad detallar los gastos realizados durante el período correspondiente, los cuales fueron necesarios para el adecuado desarrollo de las actividades operativas y administrativas de la empresa.' . "\n\n"
                . 'Dichos gastos no forman parte directa de la obra o servicio principal, sin embargo, resultan importantes para garantizar el adecuado desarrollo de las actividades fuera de la sede habitual. Dentro de los gastos realizados se incluye el servicio de alojamiento para el personal, el cual permite asegurar condiciones adecuadas de descanso y permanencia, contribuyendo al cumplimiento eficiente de las labores asignadas y al buen desempeño del equipo de trabajo.' . "\n\n"
                . 'Todas las adquisiciones se encuentran respaldadas por comprobantes de pago (facturas emitidas por proveedores autorizados), cumpliendo con la normativa tributaria vigente y registradas en la contabilidad de la empresa.';
        }

        $db = \Config\Database::connect();

        // Obtener gastos clasificados en el período
        $gastos = $db->query('
            SELECT 
                c.id as compra_id,
                c.numero_comprobante,
                c.fecha_compra,
                c.total as monto_compra,
                cg.id as clasificacion_id,
                cg.fecha_clasificacion,
                cg.observaciones,
                gt.id as gasto_tipo_id,
                gt.nombre as tipo_nombre,
                gt.color,
                gs.nombre as subcategoria_nombre
            FROM compra_gastos cg
            JOIN compras c ON c.id = cg.compra_id
            LEFT JOIN gasto_tipos gt ON gt.id = cg.gasto_tipo_id
            LEFT JOIN gasto_subcategorias gs ON gs.id = cg.gasto_subcategoria_id
            WHERE DATE(cg.fecha_clasificacion) BETWEEN ? AND ?
            ORDER BY c.fecha_compra ASC
        ', [$fecha_inicio, $fecha_fin])->getResultArray();

        // Calcular totales por tipo de gasto
        $totalesPorTipo = [];
        $totalGeneral = 0;
        foreach ($gastos as $gasto) {
            $tipo = $gasto['tipo_nombre'] ?? 'Sin clasificar';
            if (!isset($totalesPorTipo[$tipo])) {
                $totalesPorTipo[$tipo] = [
                    'total' => 0,
                    'cantidad' => 0,
                    'color' => $gasto['color'],
                    'gastos' => []
                ];
            }
            $totalesPorTipo[$tipo]['total'] += $gasto['monto_compra'];
            $totalesPorTipo[$tipo]['cantidad']++;
            $totalesPorTipo[$tipo]['gastos'][] = $gasto;
            $totalGeneral += $gasto['monto_compra'];
        }

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Informe de Gastos por Período',
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'numero_informe' => $numero_informe,
            'asunto' => $asunto,
            'cuerpo_informe' => $cuerpo_informe,
            'gastos' => $gastos,
            'totalesPorTipo' => $totalesPorTipo,
            'totalGeneral' => $totalGeneral,
            'cantidadRegistros' => count($gastos)
        ];

        return view('admin/clasificacion/informe', $data);
    }

    /**
     * Descargar informe en PDF
     */
    public function descargarInformePDF()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Obtener parámetros
        $fecha_inicio = service('request')->getGet('fecha_inicio') ?? date('Y-m-01');
        $fecha_fin = service('request')->getGet('fecha_fin') ?? date('Y-m-d');
        $numero_informe = trim((string) (service('request')->getGet('numero_informe') ?? 'N°032-2026-DFCL'));
        $asunto = trim((string) (service('request')->getGet('asunto') ?? ''));
        $cuerpo_informe = trim((string) (service('request')->getGet('cuerpo_informe') ?? ''));

        if ($asunto === '') {
            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
            $asunto = 'INFORME MENSUAL CORRESPONDIENTE AL MES DE ' . $meses[(int) date('m', strtotime($fecha_inicio)) - 1];
        }

        if ($cuerpo_informe === '') {
            $cuerpo_informe = 'El presente informe tiene como finalidad detallar los gastos realizados durante el período correspondiente, los cuales fueron necesarios para el adecuado desarrollo de las actividades operativas y administrativas de la empresa.' . "\n\n"
                . 'Dichos gastos no forman parte directa de la obra o servicio principal, sin embargo, resultan importantes para garantizar el adecuado desarrollo de las actividades fuera de la sede habitual. Dentro de los gastos realizados se incluye el servicio de alojamiento para el personal, el cual permite asegurar condiciones adecuadas de descanso y permanencia, contribuyendo al cumplimiento eficiente de las labores asignadas y al buen desempeño del equipo de trabajo.' . "\n\n"
                . 'Todas las adquisiciones se encuentran respaldadas por comprobantes de pago (facturas emitidas por proveedores autorizados), cumpliendo con la normativa tributaria vigente y registradas en la contabilidad de la empresa.';
        }

        $db = \Config\Database::connect();

        // Obtener gastos clasificados en el período
        $gastos = $db->query('
            SELECT 
                c.id as compra_id,
                c.numero_comprobante,
                c.fecha_compra,
                c.total as monto_compra,
                cg.id as clasificacion_id,
                cg.fecha_clasificacion,
                cg.observaciones,
                gt.id as gasto_tipo_id,
                gt.nombre as tipo_nombre,
                gt.color,
                gs.nombre as subcategoria_nombre
            FROM compra_gastos cg
            JOIN compras c ON c.id = cg.compra_id
            LEFT JOIN gasto_tipos gt ON gt.id = cg.gasto_tipo_id
            LEFT JOIN gasto_subcategorias gs ON gs.id = cg.gasto_subcategoria_id
            WHERE DATE(cg.fecha_clasificacion) BETWEEN ? AND ?
            ORDER BY c.fecha_compra ASC
        ', [$fecha_inicio, $fecha_fin])->getResultArray();

        // Calcular totales por tipo de gasto
        $totalesPorTipo = [];
        $totalGeneral = 0;
        foreach ($gastos as $gasto) {
            $tipo = $gasto['tipo_nombre'] ?? 'Sin clasificar';
            if (!isset($totalesPorTipo[$tipo])) {
                $totalesPorTipo[$tipo] = [
                    'total' => 0,
                    'cantidad' => 0,
                    'color' => $gasto['color'],
                    'gastos' => []
                ];
            }
            $totalesPorTipo[$tipo]['total'] += $gasto['monto_compra'];
            $totalesPorTipo[$tipo]['cantidad']++;
            $totalesPorTipo[$tipo]['gastos'][] = $gasto;
            $totalGeneral += $gasto['monto_compra'];
        }

        $data = [
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'numero_informe' => $numero_informe,
            'asunto' => $asunto,
            'cuerpo_informe' => $cuerpo_informe,
            'gastos' => $gastos,
            'totalesPorTipo' => $totalesPorTipo,
            'totalGeneral' => $totalGeneral,
            'cantidadRegistros' => count($gastos)
        ];

        // Generar HTML
        $html = view('admin/clasificacion/informe_pdf', $data);

        // Usar DomPDF con optimizaciones
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false);
        $options->set('enable_php', false);
        $options->set('enable_javascript', false);
        $dompdf = new \Dompdf\Dompdf($options);
        
        // Limpiar memoria antes de cargar
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Descargar como PDF
        $numeroArchivo = preg_replace('/[^A-Za-z0-9\-_]/', '_', $numero_informe);
        $nombreArchivo = 'Informe_Gastos_' . trim((string) $numeroArchivo, '_') . '_' . date('Y-m-d_His') . '.pdf';

        // Guardar registro del reporte generado con contenido dinámico
        $this->gastoReporteModel->insert([
            'nombre' => mb_substr($asunto, 0, 255),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'contenido_html' => $cuerpo_informe,
            'contenido_pdf' => $nombreArchivo,
            'total_gasto' => $totalGeneral,
            'cantidad_compras' => count($gastos),
            'estado' => 'completado',
            'usuario_creador' => (int) $session->get('id'),
            'observaciones' => json_encode([
                'numero_informe' => $numero_informe,
                'asunto' => $asunto,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        return $dompdf->stream($nombreArchivo, array("Attachment" => 1));
    }

    /**
     * Ver reportes de gastos
     */
    public function reportes()
    {
        $reportes = $this->gastoReporteModel->reportesActivos();
        
        $data = [
            'reportes' => $reportes,
            'enviados' => $this->gastoReporteModel->reportesEnviados(),
        ];

        return view('admin/clasificacion/reportes', $data);
    }

    /**
     * Crear nuevo reporte
     */
    public function crearReporte()
    {
        $proyectos = $this->projectModel->where('status', 'active')->findAll();
        $contratos = $this->contractModel->where('status', 'active')->findAll();
        $tipos = $this->gastoTipoModel->getTiposActivos();

        $data = [
            'proyectos' => $proyectos,
            'contratos' => $contratos,
            'tipos' => $tipos,
        ];

        return view('admin/clasificacion/crear_reporte', $data);
    }

    /**
     * Guardar nuevo reporte
     */
    public function guardarReporte()
    {
        if (!$this->request->isAjax()) {
            return $this->response->setJSON(['success' => false]);
        }

        $nombre = $this->request->getPost('nombre');
        $fechaInicio = $this->request->getPost('fecha_inicio');
        $fechaFin = $this->request->getPost('fecha_fin');
        $proyectoId = $this->request->getPost('proyecto_id');
        $tipoGastoId = $this->request->getPost('tipo_gasto_id');

        $data = [
            'nombre' => $nombre,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'proyecto_id' => $proyectoId ?: null,
            'tipo_gasto_id' => $tipoGastoId ?: null,
            'estado' => 'borrador',
            'usuario_creador' => session()->get('id'),
        ];

        if ($reporteId = $this->gastoReporteModel->insert($data, true)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Reporte creado',
                'id' => $reporteId,
                'redirect' => site_url('dashboard/clasificacion/verReporte/' . $reporteId)
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al crear reporte'
        ]);
    }

    /**
     * Ver reporte generado
     */
    public function verReporte($reporteId)
    {
        $reporte = $this->gastoReporteModel->conDetalles($reporteId);
        if (!$reporte) {
            return redirect()->back()->with('error', 'Reporte no encontrado');
        }

        // Calcular totales
        $totalGasto = array_sum(array_column($reporte['gastos'], 'total'));
        $cantidadCompras = count($reporte['gastos']);

        // Agrupar por tipo
        $gastosPorTipo = [];
        foreach ($reporte['gastos'] as $gasto) {
            $tipo = $gasto['tipo_nombre'];
            if (!isset($gastosPorTipo[$tipo])) {
                $gastosPorTipo[$tipo] = ['total' => 0, 'cantidad' => 0, 'color' => $gasto['color']];
            }
            $gastosPorTipo[$tipo]['total'] += $gasto['total'];
            $gastosPorTipo[$tipo]['cantidad']++;
        }

        $data = [
            'reporte' => $reporte,
            'totalGasto' => $totalGasto,
            'cantidadCompras' => $cantidadCompras,
            'gastosPorTipo' => $gastosPorTipo,
        ];

        return view('admin/clasificacion/ver_reporte', $data);
    }
}