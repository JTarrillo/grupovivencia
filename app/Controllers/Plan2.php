<?php
namespace App\Controllers;

class Plan2 extends BaseController
{
        public function index()
    {
        $session = session();
        $userId = $session->get('id');
        $tipoAgente = $session->get('tipo_agente');
        $customerModel = model('CustomerModel');
        $inscripcionVigente = true;
        if ($tipoAgente === 'externo') {
            $inscripcionVigente = $customerModel->isInscripcionVigente($userId);
        }
        return view('backoffice_new/plan2', [
            'inscripcionVigente' => $inscripcionVigente,
            'tipoAgente' => $tipoAgente
        ]);
    }

    public function confirmarCompra()
    {
        $session = session();
        $userId = $session->get('id');
        $tipoAgente = $session->get('tipo_agente');
        $montoCompra = $this->request->getPost('monto');
        $customerModel = model('CustomerModel');
        if ($tipoAgente === 'externo' && !$customerModel->isInscripcionVigente($userId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tu inscripción anual está vencida. Renueva para continuar.'
            ]);
        }
        $commissionsModel = model('CommissionsModel');
        $unilevelModel = model('UnilevelsModel');
        $fecha = date('Y-m-d H:i:s');
        $porcentaje_base = ($tipoAgente === 'externo') ? 0.05 : 0.02;
        $commissionsModel->insert([
            'customer_id' => $userId,
            'amount' => $montoCompra * $porcentaje_base,
            'type' => 'venta_base',
            'status' => 'pendiente',
            'created_at' => $fecha
        ]);
        $nivel1 = $unilevelModel->where('customer_id', $userId)->first();
        $sponsor_id_nivel1 = $nivel1 ? $nivel1['sponsor_id'] : null;
        if ($sponsor_id_nivel1) {
            $commissionsModel->insert([
                'customer_id' => $sponsor_id_nivel1,
                'amount' => $montoCompra * 0.04,
                'type' => 'comision_nivel_1',
                'status' => 'pendiente',
                'created_at' => $fecha
            ]);
        }
        $nivel2 = $sponsor_id_nivel1 ? $unilevelModel->where('customer_id', $sponsor_id_nivel1)->first() : null;
        $sponsor_id_nivel2 = $nivel2 ? $nivel2['sponsor_id'] : null;
        if ($sponsor_id_nivel2) {
            $commissionsModel->insert([
                'customer_id' => $sponsor_id_nivel2,
                'amount' => $montoCompra * 0.01,
                'type' => 'comision_nivel_2',
                'status' => 'pendiente',
                'created_at' => $fecha
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Compra confirmada y comisiones generadas correctamente.'
        ]);
    }

    
}