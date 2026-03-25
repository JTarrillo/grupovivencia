<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CuentaBancariaModel;
use App\Models\MovimientoBancariaModel;
use App\Models\ConciliacionModel;

class Bancario extends BaseController
{
    protected $cuentaBancariaModel;
    protected $movimientoBancariaModel;
    protected $conciliacionModel;

    public function __construct()
    {
        $this->cuentaBancariaModel = new CuentaBancariaModel();
        $this->movimientoBancariaModel = new MovimientoBancariaModel();
        $this->conciliacionModel = new ConciliacionModel();
    }

    /**
     * Lista todas las cuentas bancarias
     */
    public function cuentas()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $cuentas = $this->cuentaBancariaModel->findAll();
        
        return view('admin/bancario/cuentas', [
            'cuentas' => $cuentas
        ]);
    }

    /**
     * Crea una nueva cuenta bancaria
     */
    public function crear_cuenta()
    {
        $request = \Config\Services::request();
        
        if ($request->getMethod() === 'post') {
            $data = [
                'banco' => $request->getPost('banco'),
                'numero_cuenta' => $request->getPost('numero_cuenta'),
                'tipo_cuenta' => $request->getPost('tipo_cuenta'),
                'saldo' => $request->getPost('saldo'),
                'moneda' => $request->getPost('moneda'),
                'estado' => 'activo',
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];

            $this->cuentaBancariaModel->insert($data);
            return redirect()->to('/admin/bancario/cuentas')->with('success', 'Cuenta bancaria creada correctamente');
        }

        return view('admin/bancario/crear_cuenta');
    }

    /**
     * Edita una cuenta bancaria
     */
    public function editar_cuenta($id)
    {
        $request = \Config\Services::request();
        $cuenta = $this->cuentaBancariaModel->find($id);

        if (!$cuenta) {
            return redirect()->to('/admin/bancario/cuentas')->with('error', 'Cuenta no encontrada');
        }

        if ($request->getMethod() === 'post') {
            $data = [
                'banco' => $request->getPost('banco'),
                'numero_cuenta' => $request->getPost('numero_cuenta'),
                'tipo_cuenta' => $request->getPost('tipo_cuenta'),
                'saldo' => $request->getPost('saldo'),
                'moneda' => $request->getPost('moneda')
            ];

            $this->cuentaBancariaModel->update($id, $data);
            return redirect()->to('/admin/bancario/cuentas')->with('success', 'Cuenta bancaria actualizada correctamente');
        }

        return view('admin/bancario/editar_cuenta', ['cuenta' => $cuenta]);
    }

    /**
     * Movimientos bancarios de una cuenta
     */
    public function movimientos($id_cuenta)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $cuenta = $this->cuentaBancariaModel->find($id_cuenta);
        if (!$cuenta) {
            return redirect()->to('/admin/bancario/cuentas')->with('error', 'Cuenta no encontrada');
        }

        $movimientos = $this->movimientoBancariaModel
            ->where('cuenta_bancaria_id', $id_cuenta)
            ->orderBy('fecha', 'DESC')
            ->findAll();

        return view('admin/bancario/movimientos', [
            'cuenta' => $cuenta,
            'movimientos' => $movimientos
        ]);
    }

    /**
     * Agregar movimiento bancario
     */
    public function agregar_movimiento($id_cuenta)
    {
        $request = \Config\Services::request();
        $cuenta = $this->cuentaBancariaModel->find($id_cuenta);

        if (!$cuenta) {
            return redirect()->to('/admin/bancario/cuentas')->with('error', 'Cuenta no encontrada');
        }

        if ($request->getMethod() === 'post') {
            $tipo = $request->getPost('tipo'); // entrada o salida
            $monto = (float) $request->getPost('monto');
            $saldo_anterior = (float) $cuenta['saldo'];
            
            if ($tipo === 'salida') {
                $saldo_nuevo = $saldo_anterior - $monto;
            } else {
                $saldo_nuevo = $saldo_anterior + $monto;
            }

            $data = [
                'cuenta_bancaria_id' => $id_cuenta,
                'tipo' => $tipo,
                'monto' => $monto,
                'saldo_anterior' => $saldo_anterior,
                'saldo_nuevo' => $saldo_nuevo,
                'fecha' => $request->getPost('fecha'),
                'descripcion' => $request->getPost('descripcion'),
                'referencia' => $request->getPost('referencia')
            ];

            $this->movimientoBancariaModel->insert($data);
            $this->cuentaBancariaModel->update($id_cuenta, ['saldo' => $saldo_nuevo]);

            return redirect()->to('/admin/bancario/movimientos/' . $id_cuenta)->with('success', 'Movimiento registrado correctamente');
        }

        return view('admin/bancario/agregar_movimiento', ['cuenta' => $cuenta]);
    }

    /**
     * Conciliaciones bancarias
     */
    public function conciliaciones()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->route('dashboard/panel');
        }

        $conciliaciones = $this->conciliacionModel
            ->orderBy('fecha_conciliacion', 'DESC')
            ->findAll();

        return view('admin/bancario/conciliaciones', [
            'conciliaciones' => $conciliaciones
        ]);
    }

    /**
     * Crear nueva conciliación
     */
    public function crear_conciliacion()
    {
        $request = \Config\Services::request();
        
        if ($request->getMethod() === 'post') {
            $data = [
                'cuenta_bancaria_id' => $request->getPost('cuenta_bancaria_id'),
                'saldo_sistema' => $request->getPost('saldo_sistema'),
                'saldo_banco' => $request->getPost('saldo_banco'),
                'diferencia' => (float)$request->getPost('saldo_banco') - (float)$request->getPost('saldo_sistema'),
                'fecha_conciliacion' => $request->getPost('fecha_conciliacion'),
                'observaciones' => $request->getPost('observaciones'),
                'estado' => 'pendiente'
            ];

            $this->conciliacionModel->insert($data);
            return redirect()->to('/admin/bancario/conciliaciones')->with('success', 'Conciliación creada correctamente');
        }

        $cuentas = $this->cuentaBancariaModel->findAll();
        return view('admin/bancario/crear_conciliacion', ['cuentas' => $cuentas]);
    }
}
