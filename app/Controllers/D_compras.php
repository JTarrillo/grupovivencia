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

        $data = [
            'session_id' => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title' => 'Módulo de Compras',
            'compras' => $this->comprasModel->getComprasWithDetails(),
            'estadisticas' => $this->comprasModel->getEstadisticas()
        ];

        return view('admin/compras/list', $data);
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
            // Obtener datos
            $proveedor_id = $this->request->getPost('proveedor_id');
            $numero_comprobante = $this->request->getPost('numero_comprobante');
            $tipo_comprobante = $this->request->getPost('tipo_comprobante');
            $fecha_compra = $this->request->getPost('fecha_compra');
            $subtotal = (float) $this->request->getPost('subtotal');
            $igv = (float) $this->request->getPost('igv');
            $total = (float) $this->request->getPost('total');
            $descripcion = $this->request->getPost('descripcion');
            $clasificacion = $this->request->getPost('clasificacion');
            $proyecto_id = $this->request->getPost('proyecto_id') ?: null;
            $contrato_id = $this->request->getPost('contrato_id') ?: null;

            // Validaciones
            if (empty($proveedor_id) || empty($numero_comprobante) || empty($fecha_compra)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Faltan datos requeridos (Proveedor, Comprobante, Fecha)'
                ]);
            }

            // Procesar PDF/archivo
            $pdf_url = null;
            $file = $this->request->getFile('pdf_comprobante');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/comprobantes', $newName);
                $pdf_url = 'uploads/comprobantes/' . $newName;
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
                'clasificacion' => $clasificacion,
                'estado' => 'registrado',
                'pdf_url' => $pdf_url,
                'proyecto_id' => $proyecto_id,
                'contrato_id' => $contrato_id,
                'created_by' => $session->get('id')
            ];

            $compra_id = $this->comprasModel->insert($compraData);

            if ($compra_id) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Compra registrada exitosamente',
                    'compra_id' => $compra_id
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al registrar la compra'
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
                'estado' => 'aprobado',
                'approved_by' => $session->get('id')
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
}
