<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompraModel;
use App\Models\VentaModel;
use App\Models\DeclaracionModel;
use App\Models\CostoproyectoModel;
use App\Models\ClasificacionCompraModel;

class Tributario extends BaseController
{
    protected $compraModel;
    protected $ventaModel;
    protected $declaracionModel;
    protected $costoproyectoModel;
    protected $clasificacionCompraModel;

    public function __construct()
    {
        $this->compraModel = new CompraModel();
        $this->ventaModel = new VentaModel();
        $this->declaracionModel = new DeclaracionModel();
        $this->costoproyectoModel = new CostoproyectoModel();
        $this->clasificacionCompraModel = new ClasificacionCompraModel();
    }

    /**
     * Registro de compras
     */
    public function compras()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $compras = $this->compraModel
            ->orderBy('fecha_compra', 'DESC')
            ->findAll();

        return view('admin/tributario/compras', [
            'compras' => $compras
        ]);
    }

    /**
     * Registrar nueva compra
     */
    public function registrar_compra()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'proveedor_id' => $request->getPost('proveedor_id'),
                'numero_comprobante' => $request->getPost('numero_comprobante'),
                'tipo_comprobante' => $request->getPost('tipo_comprobante'),
                'fecha_compra' => $request->getPost('fecha_compra'),
                'subtotal' => $request->getPost('subtotal'),
                'igv' => $request->getPost('igv'),
                'total' => (float)$request->getPost('subtotal') + (float)$request->getPost('igv'),
                'descripcion' => $request->getPost('descripcion'),
                'clasificacion' => $request->getPost('clasificacion'),
                'estado' => 'registrado'
            ];

            $this->compraModel->insert($data);
            return redirect()->to('/admin/tributario/compras')->with('success', 'Compra registrada correctamente');
        }

        return view('admin/tributario/registrar_compra');
    }

    /**
     * Registro de ventas
     */
    public function ventas()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $ventas = $this->ventaModel
            ->orderBy('fecha_venta', 'DESC')
            ->findAll();

        return view('admin/tributario/ventas', [
            'ventas' => $ventas
        ]);
    }

    /**
     * Registrar nueva venta
     */
    public function registrar_venta()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'cliente_id' => $request->getPost('cliente_id'),
                'numero_comprobante' => $request->getPost('numero_comprobante'),
                'tipo_comprobante' => $request->getPost('tipo_comprobante'),
                'fecha_venta' => $request->getPost('fecha_venta'),
                'subtotal' => $request->getPost('subtotal'),
                'igv' => $request->getPost('igv'),
                'total' => (float)$request->getPost('subtotal') + (float)$request->getPost('igv'),
                'descripcion' => $request->getPost('descripcion'),
                'estado' => 'registrado'
            ];

            $this->ventaModel->insert($data);
            return redirect()->to('/admin/tributario/ventas')->with('success', 'Venta registrada correctamente');
        }

        return view('admin/tributario/registrar_venta');
    }

    /**
     * Declaraciones tributarias
     */
    public function declaraciones()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $declaraciones = $this->declaracionModel
            ->orderBy('periodo', 'DESC')
            ->findAll();

        return view('admin/tributario/declaraciones', [
            'declaraciones' => $declaraciones
        ]);
    }

    /**
     * Crear nueva declaración
     */
    public function crear_declaracion()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $periodo = $request->getPost('periodo');
            $ventas = $this->ventaModel->where('MONTH(fecha_venta)', substr($periodo, 5, 2))->findAll();
            $compras = $this->compraModel->where('MONTH(fecha_compra)', substr($periodo, 5, 2))->findAll();

            $total_ventas = array_reduce($ventas, function($sum, $v) { return $sum + (float)$v['total']; }, 0);
            $total_compras = array_reduce($compras, function($sum, $c) { return $sum + (float)$c['total']; }, 0);

            $data = [
                'periodo' => $periodo,
                'total_ventas' => $total_ventas,
                'total_compras' => $total_compras,
                'igv_a_pagar' => ($total_ventas * 0.18) - ($total_compras * 0.18),
                'estado' => 'borrador',
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];

            $this->declaracionModel->insert($data);
            return redirect()->to('/admin/tributario/declaraciones')->with('success', 'Declaración creada correctamente');
        }

        return view('admin/tributario/crear_declaracion');
    }

    /**
     * Costo de proyecto
     */
    public function costo_proyecto()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $costos = $this->costoproyectoModel
            ->orderBy('proyecto_id', 'ASC')
            ->findAll();

        return view('admin/tributario/costo_proyecto', [
            'costos' => $costos
        ]);
    }

    /**
     * Registrar costo de proyecto
     */
    public function registrar_costo()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'proyecto_id' => $request->getPost('proyecto_id'),
                'descripcion' => $request->getPost('descripcion'),
                'monto' => $request->getPost('monto'),
                'tipo_costo' => $request->getPost('tipo_costo'),
                'fecha_registro' => date('Y-m-d H:i:s')
            ];

            $this->costoproyectoModel->insert($data);
            return redirect()->to('/admin/tributario/costo_proyecto')->with('success', 'Costo registrado correctamente');
        }

        return view('admin/tributario/registrar_costo');
    }

    /**
     * Clasificación de compras
     */
    public function clasificacion_compras()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $clasificaciones = $this->clasificacionCompraModel->findAll();

        return view('admin/tributario/clasificacion_compras', [
            'clasificaciones' => $clasificaciones
        ]);
    }
}
