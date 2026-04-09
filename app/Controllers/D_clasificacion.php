<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\GastoTipoModel;
use App\Models\GastoSubcategoriaModel;
use App\Models\CompraGastoModel;
use App\Models\CompraDocumentoModel;
use App\Models\GastoReporteModel;
use App\Models\ProjectModel;
use App\Models\ContractModel;

class D_clasificacion extends BaseController
{
    protected $comprasModel;
    protected $gastoTipoModel;
    protected $gastoSubcategoriaModel;
    protected $compraGastoModel;
    protected $compraDocumentoModel;
    protected $gastoReporteModel;
    protected $projectModel;
    protected $contractModel;

    public function __construct()
    {
        $this->comprasModel = new ComprasModel();
        $this->gastoTipoModel = new GastoTipoModel();
        $this->gastoSubcategoriaModel = new GastoSubcategoriaModel();
        $this->compraGastoModel = new CompraGastoModel();
        $this->compraDocumentoModel = new CompraDocumentoModel();
        $this->gastoReporteModel = new GastoReporteModel();
        $this->projectModel = new ProjectModel();
        $this->contractModel = new ContractModel();
    }

    /**
     * Listar compras sin clasificar
     */
    public function index()
    {
        // Obtener compras sin clasificar
        $db = db_connect();
        $query = $db->query("
            SELECT 
                c.id, c.numero_comprobante, c.tipo_comprobante, c.fecha_compra,
                c.total, c.estado, c.descripcion,
                s.name as proveedor_nombre,
                COUNT(cg.id) as tiene_clasificacion
            FROM compras c
            LEFT JOIN suppliers s ON s.id = c.proveedor_id
            LEFT JOIN compra_gastos cg ON cg.compra_id = c.id
            WHERE c.estado IN ('registrado', 'clasificado')
            GROUP BY c.id
            ORDER BY c.fecha_compra DESC
        ");

        // Validar si la query fue exitosa
        if (!$query) {
            $error = $db->error();
            log_message('error', 'SQL Error en D_clasificacion::index - ' . $error['message']);
            $compras = [];
        } else {
            $compras = $query->getResultArray();
        }

        $data = [
            'compras' => $compras,
            'total_sin_clasificar' => count(array_filter($compras, fn($c) => $c['tiene_clasificacion'] == 0)),
            'total_clasificadas' => count(array_filter($compras, fn($c) => $c['tiene_clasificacion'] > 0)),
        ];

        return view('admin/clasificacion/index', $data);
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

        // Obtener proyectos y contratos para asociar
        $proyectos = $this->projectModel->where('status', 'active')->findAll();
        $contratos = $this->contractModel->where('status', 'active')->findAll();

        $data = [
            'compra' => $compra,
            'clasificacion' => $clasificacionActual,
            'tipos' => $tipos,
            'documentos' => $documentos,
            'proyectos' => $proyectos,
            'contratos' => $contratos,
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
        $proyectoId = $this->request->getPost('proyecto_id');
        $contratoId = $this->request->getPost('contrato_id');
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
            'proyecto_id' => $proyectoId ?: null,
            'contrato_id' => $contratoId ?: null,
            'observaciones' => $observaciones,
            'clasificado_por' => session()->get('admin_id'),
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
            'cargado_por' => session()->get('admin_id'),
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
            'usuario_creador' => session()->get('admin_id'),
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
