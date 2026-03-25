<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProveedorModel;
use App\Models\ComisionModel;
use App\Models\PagoProveedorModel;
use App\Models\ReciboHonorariosModel;

class Pagos extends BaseController
{
    protected $proveedorModel;
    protected $comisionModel;
    protected $pagoProveedorModel;
    protected $reciboHonorariosModel;

    public function __construct()
    {
        $this->proveedorModel = new ProveedorModel();
        $this->comisionModel = new ComisionModel();
        $this->pagoProveedorModel = new PagoProveedorModel();
        $this->reciboHonorariosModel = new ReciboHonorariosModel();
    }

    /**
     * Lista de proveedores
     */
    public function proveedores()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $proveedores = $this->proveedorModel->findAll();

        return view('admin/pagos/proveedores', [
            'proveedores' => $proveedores
        ]);
    }

    /**
     * Crear nuevo proveedor
     */
    public function crear_proveedor()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'razon_social' => $request->getPost('razon_social'),
                'ruc' => $request->getPost('ruc'),
                'contacto' => $request->getPost('contacto'),
                'telefono' => $request->getPost('telefono'),
                'email' => $request->getPost('email'),
                'direccion' => $request->getPost('direccion'),
                'tipo_proveedor' => $request->getPost('tipo_proveedor'),
                'estado' => 'activo',
                'fecha_registro' => date('Y-m-d H:i:s')
            ];

            $this->proveedorModel->insert($data);
            return redirect()->to('/admin/pagos/proveedores')->with('success', 'Proveedor creado correctamente');
        }

        return view('admin/pagos/crear_proveedor');
    }

    /**
     * Editar proveedor
     */
    public function editar_proveedor($id)
    {
        $request = \Config\Services::request();
        $proveedor = $this->proveedorModel->find($id);

        if (!$proveedor) {
            return redirect()->to('/admin/pagos/proveedores')->with('error', 'Proveedor no encontrado');
        }

        if ($request->getMethod() === 'post') {
            $data = [
                'razon_social' => $request->getPost('razon_social'),
                'ruc' => $request->getPost('ruc'),
                'contacto' => $request->getPost('contacto'),
                'telefono' => $request->getPost('telefono'),
                'email' => $request->getPost('email'),
                'direccion' => $request->getPost('direccion'),
                'tipo_proveedor' => $request->getPost('tipo_proveedor')
            ];

            $this->proveedorModel->update($id, $data);
            return redirect()->to('/admin/pagos/proveedores')->with('success', 'Proveedor actualizado correctamente');
        }

        return view('admin/pagos/editar_proveedor', ['proveedor' => $proveedor]);
    }

    /**
     * Gestión de comisiones
     */
    public function comisiones()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $comisiones = $this->comisionModel
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        return view('admin/pagos/comisiones', [
            'comisiones' => $comisiones
        ]);
    }

    /**
     * Crear comisión
     */
    public function crear_comision()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'contrato_id' => $request->getPost('contrato_id'),
                'agente_id' => $request->getPost('agente_id'),
                'porcentaje' => $request->getPost('porcentaje'),
                'monto_total' => $request->getPost('monto_total'),
                'monto_comision' => (float)$request->getPost('monto_total') * ((float)$request->getPost('porcentaje') / 100),
                'estado' => 'pendiente',
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];

            $this->comisionModel->insert($data);
            return redirect()->to('/admin/pagos/comisiones')->with('success', 'Comisión creada correctamente');
        }

        return view('admin/pagos/crear_comision');
    }

    /**
     * Registrar pago a proveedor
     */
    public function registrar_pago()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'proveedor_id' => $request->getPost('proveedor_id'),
                'monto' => $request->getPost('monto'),
                'fecha_pago' => $request->getPost('fecha_pago'),
                'metodo_pago' => $request->getPost('metodo_pago'),
                'referencia' => $request->getPost('referencia'),
                'descripcion' => $request->getPost('descripcion'),
                'estado' => 'registrado'
            ];

            $this->pagoProveedorModel->insert($data);
            return redirect()->to('/admin/pagos/pagos_proveedores')->with('success', 'Pago registrado correctamente');
        }

        $proveedores = $this->proveedorModel->findAll();
        return view('admin/pagos/registrar_pago', ['proveedores' => $proveedores]);
    }

    /**
     * Pagos a proveedores
     */
    public function pagos_proveedores()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $pagos = $this->pagoProveedorModel
            ->orderBy('fecha_pago', 'DESC')
            ->findAll();

        return view('admin/pagos/pagos_proveedores', [
            'pagos' => $pagos
        ]);
    }

    /**
     * Recibos por honorarios
     */
    public function recibos_honorarios()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $recibos = $this->reciboHonorariosModel
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        return view('admin/pagos/recibos_honorarios', [
            'recibos' => $recibos
        ]);
    }

    /**
     * Crear recibo por honorarios
     */
    public function crear_recibo()
    {
        $request = \Config\Services::request();

        if ($request->getMethod() === 'post') {
            $data = [
                'beneficiario' => $request->getPost('beneficiario'),
                'dni_ruc' => $request->getPost('dni_ruc'),
                'monto' => $request->getPost('monto'),
                'concepto' => $request->getPost('concepto'),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'numero_recibo' => 'RH-' . date('Ymd') . '-' . rand(1000, 9999),
                'estado' => 'generado'
            ];

            $this->reciboHonorariosModel->insert($data);
            return redirect()->to('/admin/pagos/recibos_honorarios')->with('success', 'Recibo creado correctamente');
        }

        return view('admin/pagos/crear_recibo');
    }

    /**
     * Comisiones Inmobiliarias
     */
    public function comisiones_inmobiliarias()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        // Use the existing D_comisiones logic
        $db = \Config\Database::connect();
        $builder = $db->table('comisiones_inmobiliarias');
        $builder->select('comisiones_inmobiliarias.*, customers.name as customer_name');
        $builder->join('customers', 'customers.id = comisiones_inmobiliarias.beneficiario_id', 'left');
        $builder->orderBy('comisiones_inmobiliarias.fecha_generada', 'DESC');
        
        $comisiones = $builder->get()->getResultArray();

        return view('admin/comisiones/list', [
            'obj_commissions' => $comisiones,
            'comisiones' => $comisiones
        ]);
    }
}